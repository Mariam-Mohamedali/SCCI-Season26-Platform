<?php
require_once './includes/config.php';
/* =====================
   Auth & Role Check
===================== */
if (!isset($_SESSION['user_id'])) {
    header("Location: ./auth/login.php");
    exit;
}

$userId = (int) $_SESSION['user_id'];
$role = (int) ($_SESSION['role'] ?? -1);

if ($role !== 1) {
    http_response_code(403);
    die("Access denied");
}

$userName = $_SESSION['user_name'] ?? 'User';

/* =====================
   Get workshop_id
===================== */
$stW = $connect->prepare("
    SELECT workshop_id 
    FROM users 
    WHERE user_id = ? AND status = 1
");
$stW->bind_param("i", $userId);
$stW->execute();
$uRow = $stW->get_result()->fetch_assoc();
$stW->close();

if (!$uRow || empty($uRow['workshop_id'])) {
    die("You are not assigned to a workshop");
}

$workshopId = (int) $uRow['workshop_id'];

/* =====================
   Sessions
===================== */
$sessions = [];
$res = $connect->query("
    SELECT session_id, session_name 
    FROM sessions 
    ORDER BY session_id ASC
");
if ($res) {
    $sessions = $res->fetch_all(MYSQLI_ASSOC);
}

$selectedSessionId = isset($_GET['session_id'])
    ? (int) $_GET['session_id']
    : ($sessions[0]['session_id'] ?? 0);

$currentTab = $_GET['tab'] ?? 'evaluate';

$currentSessionName = 'Session';
foreach ($sessions as $s) {
    if ($s['session_id'] == $selectedSessionId) {
        $currentSessionName = $s['session_name'];
        break;
    }
}

/* =====================
   workshop_session_id
===================== */
$workshopSessionId = 0;

$ws = $connect->prepare("
    SELECT workshop_session_id
    FROM workshop_session
    WHERE workshop_id = ? AND session_id = ?
    LIMIT 1
");
$ws->bind_param("ii", $workshopId, $selectedSessionId);
$ws->execute();
$wsRow = $ws->get_result()->fetch_assoc();
$workshopSessionId = (int) ($wsRow['workshop_session_id'] ?? 0);
$ws->close();

/* =====================
   Tasks
===================== */
$tasks = [];

if ($workshopSessionId > 0) {
    $st = $connect->prepare("
        SELECT t.task_id, t.taskName, t.taskDeadline, t.taskBio, t.task_file, ts.submission_id, ts.submit_link
        FROM tasks t
        LEFT JOIN task_submissions ts ON ts.task_id = t.task_id AND ts.user_id = ?
        WHERE t.workshop_session_id = ?
        ORDER BY t.task_id DESC
    ");
    $st->bind_param("ii", $userId, $workshopSessionId);
    $st->execute();
    $tasks = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
}

/* =====================
   Get submitted tasks for current user (to check if already submitted)
===================== */
$submittedTaskIds = [];
if ($workshopSessionId > 0) {
    $stSub = $connect->prepare("
        SELECT DISTINCT t.task_id
        FROM task_submissions ts
        JOIN tasks t ON t.task_id = ts.task_id
        WHERE t.workshop_session_id = ?
          AND ts.user_id = ?
          AND ts.status = 'submitted'
    ");
    $stSub->bind_param("ii", $workshopSessionId, $userId);
    $stSub->execute();
    $subRows = $stSub->get_result()->fetch_all(MYSQLI_ASSOC);
    $submittedTaskIds = array_map(function ($row) {
        return (int) $row['task_id'];
    }, $subRows);
    $stSub->close();
}


/* =====================
   Handle Task Deletion
===================== */
if (isset($_GET['delete_submission_id'])) {
    $submissionId = (int) $_GET['delete_submission_id'];

    // Security check: ensure it belongs to this user
    $stSub = $connect->prepare("SELECT submit_link FROM task_submissions WHERE submission_id = ? AND user_id = ?");
    $stSub->bind_param("ii", $submissionId, $userId);
    $stSub->execute();
    $sub = $stSub->get_result()->fetch_assoc();
    $stSub->close();

    if ($sub) {
        $filePath = __DIR__ . "/" . $sub['submit_link'];
        if (file_exists($filePath)) {
            @unlink($filePath);
        }

        $del = $connect->prepare("DELETE FROM task_submissions WHERE submission_id = ?");
        $del->bind_param("i", $submissionId);
        $del->execute();
        $del->close();

        $_SESSION['msg'] = "Task submission deleted successfully.";
    } else {
        $_SESSION['err'] = "Invalid submission or permission denied.";
    }

    header("Location: participantWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab");
    exit;
}

/* =====================
   Handle Task Submission (AJAX)
===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submit_task') {

    header('Content-Type: application/json');
    $response = ['status' => 'error', 'message' => ''];

    $taskId = (int) ($_POST['task_id'] ?? 0);
    if ($taskId <= 0) {
        $response['message'] = 'Invalid task.';
        echo json_encode($response);
        exit;
    }

    // Check for deadline
    $stDl = $connect->prepare("SELECT taskDeadline FROM tasks WHERE task_id = ?");
    $stDl->bind_param("i", $taskId);
    $stDl->execute();
    $taskData = $stDl->get_result()->fetch_assoc();
    $stDl->close();

    if ($taskData) {
        $deadlineTime = strtotime($taskData['taskDeadline']);
        if ($deadlineTime !== false && time() > $deadlineTime) {
            $response['message'] = 'The deadline for this task has passed.';
            echo json_encode($response);
            exit;
        }
    }

    // Check if task already submitted
    $chkSub = $connect->prepare("
        SELECT submission_id FROM task_submissions
        WHERE task_id = ? AND user_id = ? AND status = 'submitted'
    ");
    $chkSub->bind_param("ii", $taskId, $userId);
    $chkSub->execute();
    if ($chkSub->get_result()->num_rows > 0) {
        $response['message'] = 'You have already submitted this task.';
        echo json_encode($response);
        exit;
    }
    $chkSub->close();

    if (!isset($_FILES['submit_link']) || $_FILES['submit_link']['error'] !== 0) {
        $response['message'] = 'Please select a file.';
        echo json_encode($response);
        exit;
    }

    if ($_FILES['submit_link']['size'] > 20 * 1024 * 1024) {
        $response['message'] = 'File too large (max 20MB).';
        echo json_encode($response);
        exit;
    }

    $allowedExt = ['pdf', 'doc', 'docx', 'zip', 'rar', 'png', 'jpg', 'jpeg'];
    $fileName = $_FILES['submit_link']['name'];
    $tmpName = $_FILES['submit_link']['tmp_name'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt, true)) {
        $response['message'] = 'File type not allowed.';
        echo json_encode($response);
        exit;
    }

    $uploadDir = __DIR__ . "/assets/taskSubmissions/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $safeName = preg_replace("/[^a-zA-Z0-9_-]/", "_", pathinfo($fileName, PATHINFO_FILENAME));
    $newName = "u{$userId}_t{$taskId}_" . time() . "_{$safeName}.{$ext}";
    $fullPath = $uploadDir . $newName;

    if (!move_uploaded_file($tmpName, $fullPath)) {
        $response['message'] = 'Upload failed.';
        echo json_encode($response);
        exit;
    }

    $dbPath = "assets/taskSubmissions/" . $newName;

    $sql = "
        INSERT INTO task_submissions (task_id, user_id, submit_link, status)
        VALUES (?, ?, ?, 'submitted')
        ON DUPLICATE KEY UPDATE
            submit_link = VALUES(submit_link),
            status = 'submitted'
    ";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iis", $taskId, $userId, $dbPath);
    $stmt->execute();
    $stmt->close();

    echo json_encode([
        'status' => 'success',
        'message' => 'Task submitted successfully.'
    ]);
    exit;
}

/* =====================
   Review Table
===================== */
$reviewRows = [];

$q = $connect->prepare("
    SELECT
        s.session_name,
        t.taskName,
        ts.status,
        ts.submit_link,
        tf.rating AS feedback_rating,
        tf.feedback_text,
        u.user_name AS reviewer_name
    FROM tasks t
    JOIN workshop_session ws ON ws.workshop_session_id = t.workshop_session_id
    JOIN sessions s ON s.session_id = ws.session_id
    LEFT JOIN task_submissions ts
        ON ts.task_id = t.task_id AND ts.user_id = ?
    LEFT JOIN task_feedback tf
        ON tf.submission_id = ts.submission_id
    LEFT JOIN users u ON u.user_id = tf.given_by
    WHERE ws.workshop_id = ? AND ws.session_id = ?
    ORDER BY s.session_id, t.task_id

");
$q->bind_param("iii", $userId, $workshopId, $selectedSessionId);
$q->execute();
$res = $q->get_result();
if ($res) {
    $reviewRows = $res->fetch_all(MYSQLI_ASSOC);
}
$q->close();

/* =====================
   Materials (for selected session only)
===================== */
$technicalMaterials = [];
$softMaterials = [];

if ($workshopSessionId > 0) {
    $qTech = $connect->prepare("
        SELECT material_title, file_path
        FROM session_materials
        WHERE workshop_session_id = ?
          AND material_type = 'technical'
    ");
    $qTech->bind_param("i", $workshopSessionId);
    $qTech->execute();
    $technicalMaterials = $qTech->get_result()->fetch_all(MYSQLI_ASSOC);
    $qTech->close();

    $qSoft = $connect->prepare("
        SELECT material_title, file_path
        FROM session_materials
        WHERE workshop_session_id = ?
          AND material_type = 'soft'
    ");
    $qSoft->bind_param("i", $workshopSessionId);
    $qSoft->execute();
    $softMaterials = $qSoft->get_result()->fetch_all(MYSQLI_ASSOC);
    $qSoft->close();
}

/* =====================
   Helpers
===================== */
function renderStars($rating)
{
    $rating = (int) $rating;
    if ($rating < 1 || $rating > 5)
        return "—";
    return str_repeat("⭐", $rating) . str_repeat("☆", 5 - $rating);
}

/* =====================
   Include UI
===================== */
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
    <meta property="og:image" content="./assets/images/seo/participantPanel.png" />
    <meta property="og:title" content="SCCI`26" />
    <meta property="og:description"
        content="SCCI is the university's premier student community, uniting creative minds to build the future of tech, media, business, and entrepreneurship." />
    <meta name="keywords"
        content="SCCI, Student Community, Creative Minds, Tech, Media, Business, Entrepreneurship, University, Community, College" />
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!-- css -->
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/message-toast.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/participantWorkshopPanel.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/task-management.css?v=<?php echo time(); ?>">
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <title>SCCI - Workshop Panel</title>
</head>

<body>
    <?php include './includes/nav.php'; ?>
    <!-- panel ----------------------------------------------------------------- -->

    <div class="navbar-spacer"></div>

    <!-- Floating Background Decorations -->
    <div class="floatingDecorations">
        <i class="fas fa-star decoration-icon" style="top: 10%; left: 5%; animation-delay: 0s;"></i>
        <i class="fas fa-sparkles decoration-icon" style="top: 20%; right: 8%; animation-delay: 2s;"></i>
        <i class="fas fa-code decoration-icon" style="top: 35%; left: 10%; animation-delay: 4s;"></i>
        <i class="fas fa-star decoration-icon" style="top: 50%; right: 15%; animation-delay: 1s;"></i>
        <i class="fas fa-gem decoration-icon" style="top: 65%; left: 7%; animation-delay: 3s;"></i>
        <i class="fas fa-rocket decoration-icon" style="top: 75%; right: 5%; animation-delay: 5s;"></i>
        <i class="fas fa-heart decoration-icon" style="top: 85%; left: 12%; animation-delay: 2.5s;"></i>
        <i class="fas fa-laptop-code decoration-icon" style="top: 15%; right: 20%; animation-delay: 1.5s;"></i>
        <i class="fas fa-lightbulb decoration-icon" style="top: 45%; left: 3%; animation-delay: 3.5s;"></i>
        <i class="fas fa-certificate decoration-icon" style="top: 60%; right: 10%; animation-delay: 4.5s;"></i>
    </div>

    <div class="miniNav">
        <div class="panelSvg">
            <!-- left edge -->
            <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none" viewBox="0 0 50 100"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M50 0
                        C40 0 30 20 10 50
                        C30 80 40 100 50 100
                        Z" fill="var(--color-primary-darker)" stroke="var(--color-primary-darker)" stroke-width="2"
                    stroke-linejoin="round" stroke-linecap="round" />
            </svg>

            <!-- center -->
            <svg shape-rendering="geometricPrecision" class="panelBody" viewBox="0 0 300 100" preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <defs>
                    <linearGradient id="fillCenter" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="var(--color-primary-darker)" />
                        <stop offset="50%" stop-color="var(--color-primary)" />
                        <stop offset="100%" stop-color="var(--color-primary-darker)" />
                    </linearGradient>
                </defs>

                <rect x="0" y="0" width="300" height="100" fill="url(#fillCenter)" stroke="var(--color-primary-darker)"
                    stroke-width="2" />
            </svg>

            <!-- right edge -->
            <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none" viewBox="0 0 50 100"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M0 0
                        C10 0 20 20 40 50
                        C20 80 10 100 0 100
                        Z" fill="var(--color-primary-darker)" stroke="var(--color-primary-darker)" stroke-width="2"
                    stroke-linejoin="round" stroke-linecap="round" />
            </svg>
        </div>

        <!-- Name the "data-page" in the mini nav the same as its section -->
        <a data-page="evaluate" class="<?= ($currentTab === 'evaluate') ? 'activePanelLine' : '' ?>">view task</a>
        <a data-page="review" class="<?= ($currentTab === 'review') ? 'activePanelLine' : '' ?>">review Task</a>
        <a data-page="addTask" class="<?= ($currentTab === 'addTask') ? 'activePanelLine' : '' ?>">materials</a>
        <a data-page="addMaterial" class="<?= ($currentTab === 'addMaterial') ? 'activePanelLine' : '' ?>">activity time
        </a>
    </div>

    <!-- Main Workshop Panel Section -->
    <section class="workshopPanelSection">
        <div class="container">

            <!-- Sessions Selector with SVG Buttons -->
            <div class="sessionsSelectorFrame">
                <button class="scrollBtn leftBtn" onclick="scrollSessions('left')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="sessionsSelector" id="sessionsContainer">
                    <?php foreach ($sessions as $s): ?>
                        <?php $sid = (int) $s['session_id']; ?>
                        <?php $isActive = ($selectedSessionId === $sid); ?>

                        <a href="?tab=<?= htmlspecialchars($currentTab) ?>&session_id=<?= $sid ?>"
                            class="sessionBtn <?= $isActive ? 'sessionActive' : '' ?>">
                            <!-- svg shape -->
                            <div class="panelSvg panelSession">
                                <!-- left edge -->
                                <svg shape-rendering="geometricPrecision" class="panelEdge sessionEdge"
                                    preserveAspectRatio="none" viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path d="M50 0 C40 0 30 20 10 50 C30 80 40 100 50 100 Z"
                                        fill="<?= $isActive ? '#1f184e' : 'var(--color-white-gradient)' ?>"
                                        stroke="<?= $isActive ? '#1f184e' : 'var(--color-white-gradient)' ?>"
                                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round" />
                                </svg>

                                <!-- center -->
                                <div class="panelBody <?= $isActive ? 'sessionBlue' : 'sessionWhite' ?>"></div>

                                <!-- right edge -->
                                <svg shape-rendering="geometricPrecision" class="panelEdge sessionEdge"
                                    preserveAspectRatio="none" viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path d="M0 0 C10 0 20 20 40 50 C20 80 10 100 0 100 Z"
                                        fill="<?= $isActive ? '#1f184e' : 'var(--color-white-gradient)' ?>"
                                        stroke="<?= $isActive ? '#1f184e' : 'var(--color-white-gradient)' ?>"
                                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round" />
                                </svg>
                            </div>

                            <p><?= htmlspecialchars($s['session_name']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
                <button class="scrollBtn rightBtn" onclick="scrollSessions('right')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Panel Section: View Task (Evaluate) -->
            <div id="evaluate" class="panelSection panelSectionActive">


                <!-- Workshop Card -->
                <?php if (count($tasks) > 0): ?>
                    <?php foreach ($tasks as $task): ?>
                        <article class="workshopCard">
                            <div class="taskItem"> <!-- Added wrapper for each task if multiple -->
                                <!-- Card Header -->
                                <header class="cardHeader">
                                    <h2>WEEKLY TASK - <?= htmlspecialchars($currentSessionName); ?></h2>
                                </header>
                                <!-- Card Body -->
                                <div class="cardBody">
                                    <!-- Task Name Row -->

                                    <div class="taskRow">
                                        <label class="taskLabel">Task Name:</label>
                                        <div class="taskValue"><?= htmlspecialchars($task['taskName']); ?></div>
                                    </div>

                                    <!-- Deadline Row -->
                                    <div class="taskRow">
                                        <label class="taskLabel">Deadline:</label>
                                        <div class="taskValue"><?= htmlspecialchars($task['taskDeadline']); ?></div>
                                    </div>

                                    <!-- Session Row -->
                                    <div class="taskRow">
                                        <label class="taskLabel">Session:</label>
                                        <div class="taskValue"><?= htmlspecialchars($currentSessionName); ?></div>
                                    </div>

                                    <!-- Task Bio Box -->
                                    <div class="taskBio">
                                        <label class="taskLabel">Task bio:</label>
                                        <div class="taskBioContent ql-editor">
                                            <?= $task['taskBio']; // Raw HTML from Quill ?>
                                        </div>
                                    </div>

                                    <!-- Task Resource Row -->
                                    <div class="taskResource">
                                        <label class="taskLabel">Task Resource:</label>
                                        <div class="resourceInfo">
                                            <i class="fas fa-file-alt"></i>
                                            <?php if (!empty($task['task_file'])): ?>
                                                <?php if (filter_var($task['task_file'], FILTER_VALIDATE_URL)): ?>
                                                    <a href="<?= htmlspecialchars($task['task_file']); ?>" target="_blank"><i class="fas fa-link"></i> Open URL</a>
                                                <?php else: ?>
                                                    <a href="<?= htmlspecialchars($task['task_file']); ?>" target="_blank"><i class="fas fa-download"></i> Download</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                —
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <article class="workshopCard">
                        <div class="cardBody">
                            <p>No tasks assigned for this session yet.</p>
                        </div>

                    </article>
                <?php endif; ?>

                <!-- Submit Task Form Section -->
                <?php
                $isSubmitted = false;
                if (isset($tasks[0])) {
                    $isSubmitted = in_array((int) $tasks[0]['task_id'], $submittedTaskIds);
                }
                ?>
                <form class="fileUpload" id="validForm" action="" method="post" enctype="multipart/form-data"
                    data-submitted="<?= $isSubmitted ? 'true' : 'false' ?>"
                    data-deadline="<?= isset($tasks[0]) ? htmlspecialchars($tasks[0]['taskDeadline']) : '' ?>">
                    <div class="uploadCard">
                        <!-- Upload Header -->
                        <div class="uploadHeader">
                            <h3 class="uploadSectionTitle">Submit Task</h3>
                        </div>

                        <input type="hidden" name="action" value="submit_task">
                        <input type="hidden" name="task_id"
                            value="<?= isset($tasks[0]) ? (int) $tasks[0]['task_id'] : 0 ?>">

                        <!-- Upload Container -->
                        <div class="uploadContainer" id="taskUploadContainer">
                            <label class="formLabel" for="submit_link" id="formLabel">
                                <div class="uploadIcon">
                                    <i class="fas fa-arrow-down"></i>
                                </div>
                                <h4 class="uploadTitle">Upload File</h4>
                                <p class="uploadText" id="fileUploadState">
                                    Drag and drop or click to browse
                                </p>
                            </label>

                            <p id="fileUploadedName"></p>
                            <!-- Hidden File Input -->
                            <input type="file" name="submit_link" id="submit_link">

                            <p id="fileMessage"></p>
                        </div>
                    </div>

                    <!-- Action Buttons (Centered & Responsive) -->
                    <div id="actionButtons"
                        style="display:none; justify-content:center; flex-wrap:wrap; gap:var(--space-4); padding: var(--space-5);">
                        <button type="button" class="btn btn-primary" id="removeFileBtn" style="min-width:200px;">
                            <i class="fas fa-solid fa-xmark"></i>
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-secondary" id="submitTaskBtn" style="min-width:200px;">
                            <i class="fas fa-upload"></i>
                            Submit Task
                        </button>
                    </div>
                </form>

                <div class="panelWhiteBox">
                    <h4>Tasks</h4>
                    <div class="articleFiles">
                        <?php if (count($tasks) === 0): ?>
                            <div class="notFIleAdded">
                                <i class="fa-solid fa-folder-open"></i>
                                <p>No tasks assigned yet.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($tasks as $task): ?>
                                <article class="materialItem">
                                    <div class="materialInfo">
                                        <span class="materialFileName">
                                            <?php if (!empty($task['taskName'])): ?>
                                                <?= htmlspecialchars($task['taskName']) ?>
                                            <?php else: ?>
                                                No Task Name
                                            <?php endif; ?>
                                        </span>
                                        <p class="taskDescription">
                                            <?php if (!empty($task['taskDeadline'])): ?>
                                                <?= htmlspecialchars($task['taskDeadline']) ?>
                                            <?php else: ?>
                                                No Task Deadline
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="materialActions">
                                        <?php if (!empty($task['submit_link'])): ?>
                                            <a href="<?= htmlspecialchars($task['submit_link']) ?>" target="_blank"
                                                class="downloadFileBtn"><i class="fa-solid fa-download"></i> Download Submission</a>
                                            <button class="deleteMaterialButton" style="background-color: #d6414131;"
                                                onclick="deleteSubmission(<?= (int) $task['submission_id'] ?>)">Delete
                                                Submission</button>
                                        <?php elseif (!empty($task['task_file'])): ?>
                                            <?php if (filter_var($task['task_file'], FILTER_VALIDATE_URL)): ?>
                                                <a href="<?= htmlspecialchars($task['task_file']) ?>" target="_blank"
                                                    class="downloadFileBtn"><i class="fa-solid fa-link"></i> Open URL</a>
                                            <?php else: ?>
                                                <a href="<?= htmlspecialchars($task['task_file']) ?>" target="_blank"
                                                    class="downloadFileBtn"><i class="fa-solid fa-file-download"></i> Task Resource</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Panel Section: Review Task -->
            <div id="review" class="panelSection">
                <article class="workshopCard">
                    <header class="cardHeader">
                        <h2>TASK REVIEW</h2>
                    </header>
                    <div class="cardBody">
                        <!-- Review Table -->
                        <div class="reviewTableContainer">
                            <table class="reviewTable">
                                <thead>
                                    <tr>
                                        <th>Sessions</th>
                                        <th>Task Link</th>
                                        <th>Status</th>
                                        <th><i class="fas fa-check-circle"></i> Task rating</th>
                                        <th><i class="fas fa-comment-dots"></i> Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($reviewRows) == 0): ?>
                                        <tr>
                                            <td colspan="6">No data</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($reviewRows as $r): ?>
                                            <tr>
                                                <td class="sessionName"><?= htmlspecialchars($r['session_name']) ?></td>
                                                <td class="taskLink">
                                                    <?php if (!empty($r['submit_link'])): ?>
                                                        <a href="<?= htmlspecialchars($r['submit_link']) ?>" target="_blank"
                                                            class="taskLinkBtn">
                                                            <i class="fas fa-link"></i>
                                                            View file
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="taskLinkBtn">—</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="statusBadge statusSubmitted">
                                                        <i class="fas fa-check"></i>
                                                        <?= htmlspecialchars($r['status'] ?? 'pending') ?>
                                                    </span>
                                                </td>
                                                <td class="rating">
                                                    <?= renderStars($r['feedback_rating'] ?? 0) ?>
                                                </td>
                                                <td>
                                                    <button class="feedbackBtn"
                                                        data-session="<?= htmlspecialchars($r['session_name']) ?>"
                                                        data-rating="<?= htmlspecialchars($r['feedback_rating'] ?? 0) ?>"
                                                        data-feedback="<?= htmlspecialchars($r['feedback_text'] ?? 'No feedback yet.') ?>"
                                                        data-instructor="<?= htmlspecialchars($r['reviewer_name'] ?? '—') ?>">
                                                        view feedback
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Panel Section: Materials -->
            <div id="addTask" class="panelSection">
                <article class="workshopCard">
                    <header class="cardHeader">
                        <h2>WORKSHOP MATERIALS</h2>
                    </header>
                    <div class="cardBody">
                        <div class="materialsContainer">
                            <!-- Category Tabs -->
                            <div class="materialCategories">
                                <button class="materialCategoryBtn active" data-category="technical">
                                    <i class="fas fa-play"></i>
                                    Technical Material
                                </button>
                                <button class="materialCategoryBtn" data-category="softskills">
                                    <i class="fas fa-play"></i>
                                    Soft-skills Material
                                </button>
                            </div>

                            <!-- Materials List -->
                            <div class="materialsListContainer">
                                <!-- Technical Materials -->
                                <div id="technical" class="materialsList activeMaterialsList">
                                    <?php if (empty($technicalMaterials)): ?>
                                        <div class="no-materials-msg"
                                            style="text-align: center; padding: 20px; color: #666;">
                                            <i class="fas fa-folder-open"
                                                style="font-size: 2em; margin-bottom: 10px; color: #ccc;"></i>
                                            <p>No technical materials available for this workshop.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($technicalMaterials as $tm): ?>
                                            <div class="materialItem">
                                                <i class="fas fa-file-alt materialIcon"></i>
                                                <span class="materialName"><?= htmlspecialchars($tm['material_title']) ?></span>
                                                <?php if (filter_var($tm['file_path'], FILTER_VALIDATE_URL)): ?>
                                                    <a href="<?= htmlspecialchars($tm['file_path']) ?>" class="materialDownloadBtn"
                                                        target="_blank">
                                                        <i class="fas fa-link"></i>
                                                        Open URL
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= htmlspecialchars($tm['file_path']) ?>" class="materialDownloadBtn"
                                                        target="_blank" download>
                                                        <i class="fas fa-download"></i>
                                                        Download
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>


                                <!-- Soft-skills Materials -->
                                <div id="softskills" class="materialsList">
                                    <?php if (empty($softMaterials)): ?>
                                        <div class="no-materials-msg"
                                            style="text-align: center; padding: 20px; color: #666;">
                                            <i class="fas fa-folder-open"
                                                style="font-size: 2em; margin-bottom: 10px; color: #ccc;"></i>
                                            <p>No soft-skills materials available for this workshop.</p>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($softMaterials as $sm): ?>
                                            <div class="materialItem">
                                                <i class="fas fa-file-alt materialIcon"></i>
                                                <span class="materialName"><?= htmlspecialchars($sm['material_title']) ?></span>
                                                <?php if (filter_var($sm['file_path'], FILTER_VALIDATE_URL)): ?>
                                                    <a href="<?= htmlspecialchars($sm['file_path']) ?>" class="materialDownloadBtn"
                                                        target="_blank">
                                                        <i class="fas fa-link"></i>
                                                        Open URL
                                                    </a>
                                                <?php else: ?>
                                                    <a href="<?= htmlspecialchars($sm['file_path']) ?>" class="materialDownloadBtn"
                                                        target="_blank" download>
                                                        <i class="fas fa-download"></i>
                                                        Download
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Panel Section: Activity Time (Game Intro) -->
            <div id="addMaterial" class="panelSection">
                <article class="workshopCard activityCard">
                    <header class="cardHeader activityHeader">
                        <h2><i class="fas fa-gamepad"></i> ACTIVITY TIME</h2>
                    </header>
                    <div class="cardBody activityBody">
                        <!-- Game Challenge Banner -->
                        <div class="gameBanner">
                            <!-- Animated Game Avatar -->
                            <div class="gameAvatar">
                                <div class="avatarCircle">
                                    <i class="fas fa-robot avatarIcon"></i>
                                </div>
                                <div class="avatarGlow"></div>
                            </div>

                            <div class="bannerIcons">
                                <i class="fas fa-trophy bannerIcon"></i>
                                <i class="fas fa-star bannerIcon"></i>
                                <i class="fas fa-fire bannerIcon"></i>
                            </div>
                            <h3 class="gameTitle">🎮 Weekly Challenge Game!</h3>
                            <p class="gameSubtitle">Test your knowledge and compete for the highest score!</p>
                        </div>

                        <!-- Motivational Message -->
                        <div class="motivationalBox">
                            <i class="fas fa-bullseye"></i>
                            <p><strong>Ready to prove yourself?</strong> Challenge your skills and climb the
                                leaderboard! 🚀</p>
                        </div>

                        <!-- Play Button -->
                        <div class="playButtonContainer">
                            <a href="https://awadcoding.github.io/SCCI-Quiz/" class="playGameBtn">
                                <span class="btnGlow"></span>
                                <i class="fas fa-play"></i>
                                <span class="btnText">START GAME NOW</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <p class="playHint">Click to enter the game arena!</p>
                        </div>

                        <!-- Stats Preview -->
                        <div class="statsPreview">
                            <div class="statItem">
                                <i class="fas fa-users"></i>
                                <span>300 Players</span>
                            </div>
                            <div class="statItem">
                                <i class="fas fa-crown"></i>
                                <span>Top Score: 98/100</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

        </div>
    </section>

    <!-- Footer Section -->
    <?php include './includes/footer.php'; ?>

    <!-- Feedback Modal Popup -->
    <div id="feedbackModal" class="modalOverlay">
        <div class="modalContainer">
            <div class="modalHeader">
                <h3><i class="fas fa-comments"></i> Instructor Feedback</h3>
                <button class="modalCloseBtn" onclick="closeFeedbackModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modalBody">
                <!-- Session Info -->
                <div class="feedbackSessionInfo">
                    <span class="feedbackSessionLabel">Session:</span>
                    <span id="feedbackSessionName" class="feedbackSessionValue">Session</span>
                </div>

                <!-- Rating -->
                <div class="feedbackRating">
                    <span class="feedbackLabel">Rating:</span>
                    <div id="feedbackRatingStars" class="feedbackStars"></div>
                </div>

                <!-- Feedback Content -->
                <div class="feedbackContent">
                    <p class="feedbackLabel"><i class="fas fa-comment-alt"></i> Feedback Message:</p>
                    <div id="feedbackText" class="feedbackTextArea">
                        <p></p>
                    </div>
                </div>

                <!-- Instructor Info -->
                <div class="feedbackInstructor">
                    <i class="fas fa-user-tie"></i>
                    <span>Reviewed by: <strong id="feedbackInstructorName">instructor</strong></span>
                </div>
            </div>
            <div class="modalFooter">
                <button class="modalOkBtn" onclick="closeFeedbackModal()">Got it!</button>
            </div>
        </div>
    </div>

    <!-- successful submit popup -->
    <div class="submitPopup">
        <span id="popupMessage">Form Submitted</span>
        <button type="button" class="popupSubmitClose">X</button>
    </div>

    <!-- delete confirmation popup -->
    <div class="deleteConfirmPopup" id="deleteConfirmPopup">
        <div class="confirmCard">
            <div class="confirmHeader">
                <i class="fas fa-trash-alt"></i>
                <h3>Delete Submission?</h3>
            </div>
            <p>This action cannot be undone. You will need to re-upload your task.</p>
            <div class="confirmBtnGroup">
                <button type="button" class="btn btn-confirm-cancel" onclick="closeDeleteConfirm()">Cancel</button>
                <button type="button" class="btn btn-confirm-delete" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>

    <!-- Page Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            startEvent: 'load',
            once: true,
            offset: 0,
            duration: 1000,
            easing: 'ease-in-out',
            anchorPlacement: 'top-bottom'
        });
    </script>
    <script src="./assets/js/all.min.js" defer></script>
    <script src="./assets/js/messages.js" defer></script>
    <script>
        (function () {
            const urlParams = new URLSearchParams(window.location.search);
            const urlMsg = urlParams.get('msg');
            const urlErr = urlParams.get('err');

            window.sessionMessages = {
                msg: <?php echo isset($_SESSION['msg']) ? json_encode($_SESSION['msg']) : 'null'; ?> || urlMsg,
                err: <?php echo isset($_SESSION['err']) ? json_encode($_SESSION['err']) : 'null'; ?> || urlErr
            };

            if (urlMsg || urlErr) {
                const newUrl = new URL(window.location.href);
                newUrl.searchParams.delete('msg');
                newUrl.searchParams.delete('err');
                window.history.replaceState({}, '', newUrl.toString());
            }

            // Display message using global popup if available
            // Note: We need to wait for the JS file to load, or ensure JS handles window.sessionMessages
            // The participantWorkshopPanel.js already handles window.sessionMessages on load, 
            // so we don't need to call showPopup explicitly here, just setting the variable is enough.
            // But for safety/consistency with member panel:
            
            window.addEventListener('load', () => {
                 if (window.showPopup && (window.sessionMessages.msg || window.sessionMessages.err)) {
                     // handled inside js file, but we can force it here if logic differs
                     // actually participantWorkshopPanel.js lines 148-152 handle this automatically on DOMContentLoaded/load
                 }
            });

        })();
        <?php unset($_SESSION['msg']);
        unset($_SESSION['err']); ?>
    </script>
    <script src="./assets/js/participantWorkshopPanel.js?v=<?php echo time(); ?>" defer></script>
</body>

</html>