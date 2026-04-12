<?php
/* =========================================================================
   academicParticipantPanel.php — Participant Dashboard
   Role = 1 (from academic_participants table)
   ========================================================================= */

include "./includes/config.php";

/* ---------- Auth Check ---------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$userId = (int) $_SESSION['user_id'];

/* ---------- Role Check: must exist in academic_participants with role=1 ---------- */
$participant = null;
$stmt = mysqli_prepare($connect, "SELECT participant_id, user_name, team_id, role, leader FROM academic_participants WHERE participant_id = ? AND role = 1");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $participant = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$participant) {
    http_response_code(403);
    die("Access denied — Academic Participants only.");
}

$participantId = (int) $participant['participant_id'];
$participantName = $participant['user_name'];
$teamId = (int) $participant['team_id'];
$isLeader = (int) $participant['leader'];

/* ---------- Flash Message Helper ---------- */
function setFlash($type, $msg)
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

/* ---------- Handle: Select Team ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'select_team') {
    $selectedTeamId = (int) ($_POST['team_id'] ?? 0);
    if ($selectedTeamId > 0) {
        $stmt = mysqli_prepare($connect, "UPDATE academic_participants SET team_id = ? WHERE participant_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $selectedTeamId, $participantId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            setFlash('success', 'Team selected successfully ✓');
            header("Location: academicParticipantPanel.php");
            exit;
        }
    } else {
        setFlash('error', 'Please select a valid team.');
    }
}

/* ---------- Fetch Workshops for this participant's team ---------- */
$workshops = [];
$stmt = mysqli_prepare(
    $connect,
    "SELECT w.workshop_id, w.workshop_name
     FROM academic_workshops w
     WHERE w.team_id = ?
     ORDER BY w.workshop_id ASC"
);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $teamId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $workshops[] = $row;
    }
    mysqli_stmt_close($stmt);
}

/* ---------- Selected Workshop ---------- */
$selectedWorkshopId = isset($_GET['workshop_id']) ? (int) $_GET['workshop_id'] : 0;

// Validate the selected workshop is one of the participant's workshops
$validIds = array_map(function ($w) {
    return (int) $w['workshop_id'];
}, $workshops);

if ($selectedWorkshopId <= 0 || !in_array($selectedWorkshopId, $validIds, true)) {
    $selectedWorkshopId = count($workshops) > 0 ? (int) $workshops[0]['workshop_id'] : 0;
}

$selectedWorkshopName = '';
foreach ($workshops as $w) {
    if ((int) $w['workshop_id'] === $selectedWorkshopId) {
        $selectedWorkshopName = $w['workshop_name'];
        break;
    }
}

/* =============================================
   POST HANDLER: Submit Task
   ============================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submit_task') {

    if ($isLeader !== 1) {
        setFlash('error', 'Only team leaders can submit tasks.');
        header("Location: academicParticipantPanel.php?workshop_id=" . ((int) ($_POST['workshop_id'] ?? 0)));
        exit;
    }

    $taskId = (int) ($_POST['task_id'] ?? 0);
    $wsId = (int) ($_POST['workshop_id'] ?? 0);

    if ($taskId <= 0) {
        setFlash('error', 'Please select a task');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    // Verify the task belongs to the selected workshop AND check deadline
    $taskValid = false;
    $isPastDeadline = false;
    $taskDeadline = '';

    $stmt = mysqli_prepare($connect, "SELECT task_id, deadline FROM academic_tasks WHERE task_id = ? AND workshop_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $taskId, $wsId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            $taskValid = true;
            $taskDeadline = $row['deadline'];
        }
        mysqli_stmt_close($stmt);
    }

    if (!$taskValid) {
        setFlash('error', 'Invalid task selection');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    // Server-side Deadline Check (Bypasses local time changes)
    if (!empty($taskDeadline)) {
        $now = new DateTime();
        $deadlineTime = new DateTime($taskDeadline);
        if ($now > $deadlineTime) {
            setFlash('error', 'Submission failed: The deadline has passed (' . date('M j, Y - g:i A', strtotime($taskDeadline)) . ')');
            header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
            exit;
        }
    }

    // File validation
    if (!isset($_FILES['task_file']) || $_FILES['task_file']['error'] !== UPLOAD_ERR_OK) {
        setFlash('error', 'Please select a file to upload');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    if ($_FILES['task_file']['size'] > 30 * 1024 * 1024) {
        setFlash('error', 'File too large (max 30MB)');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    $allowedExt = ['pdf', 'zip', 'docx', 'doc', 'jpg', 'jpeg', 'png'];
    $originalName = $_FILES['task_file']['name'];
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt, true)) {
        setFlash('error', 'File type not allowed (PDF, ZIP, DOCX, JPG, PNG only)');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    // Create upload directory
    $uploadDir = __DIR__ . "/uploads/academic_tasks";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate filename: {participant_id}_{task_id}_{timestamp}.ext
    $newName = "{$participantId}_{$taskId}_" . time() . ".{$ext}";
    $destPath = $uploadDir . "/" . $newName;

    if (!move_uploaded_file($_FILES['task_file']['tmp_name'], $destPath)) {
        setFlash('error', 'File upload failed — please try again');
        header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
        exit;
    }

    // Extra Fields for Final Project
    $projectUrl = null;
    $projectDesc = null;
    $teamPhotoPath = null;

    if ($selectedWorkshopName === 'Final Project') {
        $projectUrl = trim($_POST['project_url'] ?? '');
        $projectDesc = trim($_POST['project_desc'] ?? '');

        // Handle Team Photo Upload
        if (isset($_FILES['team_photo']) && $_FILES['team_photo']['error'] === UPLOAD_ERR_OK) {
            $photoExt = strtolower(pathinfo($_FILES['team_photo']['name'], PATHINFO_EXTENSION));
            $allowedPhotoExt = ['jpg', 'jpeg', 'png'];

            if (in_array($photoExt, $allowedPhotoExt)) {
                $photoName = $participantId . "_team_photo_" . time() . "." . $photoExt;
                $photoPath = "uploads/academic_tasks/" . $photoName;
                if (move_uploaded_file($_FILES['team_photo']['tmp_name'], $photoPath)) {
                    $teamPhotoPath = $photoPath;
                }
            }
        }
    }

    // Prevent DB crash on Duplicate Submissions
    $checkStmt = mysqli_prepare($connect, "SELECT submission_id FROM academic_submissions WHERE participant_id = ? AND task_id = ?");
    if ($checkStmt) {
        mysqli_stmt_bind_param($checkStmt, "ii", $participantId, $taskId);
        mysqli_stmt_execute($checkStmt);
        $checkRes = mysqli_stmt_get_result($checkStmt);
        if (mysqli_num_rows($checkRes) > 0) {
            setFlash('error', 'You have already submitted this task. Please wait or contact your IT to delete the previous submission.');
            mysqli_stmt_close($checkStmt);
            header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
            exit;
        }
        mysqli_stmt_close($checkStmt);
    }

    $fileUrl = "uploads/academic_tasks/" . $newName;

    // Get explicit PHP configured time (Cairo)
    $now = date('Y-m-d H:i:s');

    // Insert submission with explicitly formatted correct time
    $stmt = mysqli_prepare(
        $connect,
        "INSERT INTO academic_submissions (participant_id, task_id, file_url, project_url, team_photo, project_desc, status, submission_date)
         VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisssss", $participantId, $taskId, $fileUrl, $projectUrl, $teamPhotoPath, $projectDesc, $now);
        if (mysqli_stmt_execute($stmt)) {
            setFlash('success', "Task submitted successfully ✓ — Submission date: {$now}");
        } else {
            setFlash('error', 'An error occurred while saving the submission');
        }
        mysqli_stmt_close($stmt);
    }

    header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
    exit;
}

/* =============================================
   POST HANDLER: Delete Submission (1-min limit)
   ============================================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete_submission') {
    $subId = (int) ($_POST['submission_id'] ?? 0);
    $wsId = (int) ($_POST['workshop_id'] ?? 0);

    // Verify submission belongs to this participant and was made within 60 seconds
    $stmt = mysqli_prepare($connect, "SELECT submission_id, file_url, team_photo FROM academic_submissions WHERE submission_id = ? AND participant_id = ? AND submission_date >= (NOW() - INTERVAL 1 MINUTE)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $subId, $participantId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            // Delete record
            $del = mysqli_query($connect, "DELETE FROM academic_submissions WHERE submission_id = $subId");
            if ($del) {
                // Delete files if they exist
                if (!empty($row['file_url']) && file_exists(__DIR__ . "/" . $row['file_url'])) {
                    unlink(__DIR__ . "/" . $row['file_url']);
                }
                if (!empty($row['team_photo']) && file_exists(__DIR__ . "/" . $row['team_photo'])) {
                    unlink(__DIR__ . "/" . $row['team_photo']);
                }
                setFlash('success', 'Submission deleted. You can now re-submit.');
            } else {
                setFlash('error', 'Could not delete submission.');
            }
        } else {
            setFlash('error', 'Delete failed: Either the 1-minute window has passed or invalid ID.');
        }
        mysqli_stmt_close($stmt);
    }
    header("Location: academicParticipantPanel.php?workshop_id=" . $wsId);
    exit;
}

/* ---------- Fetch Tasks for Selected Workshop ---------- */
$tasks = [];
if ($selectedWorkshopId > 0) {
    $stmt = mysqli_prepare(
        $connect,
        "SELECT task_id, task_title, task_description, deadline
         FROM academic_tasks
         WHERE workshop_id = ?
         ORDER BY task_id DESC"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $selectedWorkshopId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

/* ---------- Fetch Participant's Previous Submissions ---------- */
$prevSubmissions = [];
if ($selectedWorkshopId > 0) {
    $stmt = mysqli_prepare(
        $connect,
        "SELECT s.submission_id, s.file_url, s.submission_date, s.status,
                t.task_title, t.task_description,
                e.score, e.feedback
         FROM academic_submissions s
         JOIN academic_tasks t ON s.task_id = t.task_id
         LEFT JOIN academic_evaluations e ON e.submission_id = s.submission_id
         WHERE s.participant_id = ? AND t.workshop_id = ?
         ORDER BY s.submission_date DESC"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $participantId, $selectedWorkshopId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $prevSubmissions[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

/* ---------- Flash Message Retrieval ---------- */
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png">
    <meta property="og:title" content="SCCI — Academic Participant Panel">
    <meta property="og:description"
        content="Participant Dashboard for viewing tasks, submitting work, and tracking progress.">
    <meta name="description" content="SCCI Academic Participant Panel — view workshop tasks and submit your work.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/all.min.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/root.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/navbar.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/footer.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/academicParticipantPanel.css?v=<?= ASSET_VERSION ?>">

    <title> Academic Participant Panel</title>
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <main class="acad-participant-page">
        <div class="container">

            <!-- ============ FLASH MESSAGE ============ -->
            <?php if ($flash): ?>
                <div class="flash-message <?= $flash['type'] === 'success' ? 'success' : 'error' ?>" id="flashMessage">
                    <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
                    <span><?= htmlspecialchars($flash['msg']) ?></span>
                </div>
            <?php endif; ?>

            <?php if ($teamId === 0 || $teamId === null): ?>
                <!-- ============ SELECT TEAM SCREEN ============ -->
                <section class="acad-glass-box" style="max-width: 500px; margin: 40px auto; text-align: center;">
                    <div style="margin-bottom: 20px;">
                        <i class="fas fa-users" style="font-size: 3rem; color: var(--accent-color);"></i>
                    </div>
                    <h2 style="margin-bottom: 15px; color: var(--color-primary);">Welcome to the Academic Panel!</h2>
                    <p style="margin-bottom: 25px; color: var(--color-gray-dark); font-size: var(--fs-sm);">Please select
                        your team to continue and view your specific tasks.</p>

                    <form method="POST" action="">
                        <input type="hidden" name="action" value="select_team">
                        <div class="form-group" style="text-align: left; margin-bottom: 25px;">
                            <label for="team_id">Choose Your Team</label>
                            <select name="team_id" id="team_id" required
                                style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--color-gray-medium); background: white; font-family: inherit;">
                                <option value="">— Select Team —</option>
                                <?php
                                $tq = mysqli_query($connect, "SELECT team_id, team_name FROM academic_teams ORDER BY team_id ASC");
                                if ($tq) {
                                    while ($tr = mysqli_fetch_assoc($tq)) {
                                        echo '<option value="' . (int) $tr['team_id'] . '">' . htmlspecialchars($tr['team_name']) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn-accent"
                            style="width: 100%; justify-content: center; padding: 12px;">
                            <i class="fas fa-save"></i> Continue
                        </button>
                    </form>
                </section>
            <?php else: ?>

                <!-- ============ SECTION 1: WORKSHOP MINI NAV ============ -->
                <section class="workshop-selector" id="workshopSelector">
                    <div class="workshop-pills" id="workshopPills">
                        <?php if (empty($workshops)): ?>
                            <span class="workshop-pill" style="cursor:default; opacity:0.5;">
                                <i class="fas fa-info-circle"></i>
                                No linked workshops
                            </span>
                        <?php else: ?>
                            <?php foreach ($workshops as $w): ?>
                                <?php $isActive = ((int) $w['workshop_id'] === $selectedWorkshopId); ?>
                                <a href="?workshop_id=<?= (int) $w['workshop_id'] ?>"
                                    class="workshop-pill <?= $isActive ? 'active' : '' ?>"
                                    id="workshopPill_<?= (int) $w['workshop_id'] ?>">
                                    <i class="fas fa-graduation-cap"></i>
                                    <?= htmlspecialchars($w['workshop_name']) ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- ============ SECTION 2: TASKS SLIDER ============ -->
                <section class="acad-glass-box" id="tasksSliderSection">
                    <div class="acad-section-title">
                        <i class="fas fa-tasks"></i>
                        <span>Tasks — <?= htmlspecialchars($selectedWorkshopName) ?></span>
                    </div>

                    <?php if (empty($tasks)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p>No tasks yet for this workshop</p>
                        </div>
                    <?php else: ?>
                        <div class="tasks-slider-wrapper">
                            <button class="slider-scroll-btn scroll-left" onclick="scrollSlider('left')"
                                aria-label="Scroll left">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div class="tasks-slider" id="tasksSlider">
                                <?php foreach ($tasks as $i => $task): ?>
                                    <div class="slider-task-card <?= $i === 0 ? 'active-task' : '' ?>"
                                        onclick="expandTask(<?= (int) $task['task_id'] ?>, this)"
                                        id="sliderCard_<?= (int) $task['task_id'] ?>">
                                        <div class="task-icon">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="task-card-title"><?= htmlspecialchars($task['task_title']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button class="slider-scroll-btn scroll-right" onclick="scrollSlider('right')"
                                aria-label="Scroll right">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <!-- Task Expanded Details (one per task, only active shown) -->
                        <?php foreach ($tasks as $i => $task): ?>
                            <div class="task-detail-expand <?= $i === 0 ? 'active' : '' ?>"
                                id="taskDetail_<?= (int) $task['task_id'] ?>">
                                <h4>
                                    <i class="fas fa-bookmark" style="color:var(--accent-color)"></i>
                                    <?= htmlspecialchars($task['task_title']) ?>
                                </h4>
                                <?php if (!empty($task['deadline'])): ?>
                                    <p
                                        style="font-size: var(--fs-xs); color: #EF4444; margin-top: 5px; margin-bottom: 5px; background: rgba(239, 68, 68, 0.1); padding: 4px 8px; border-radius: 4px; display: inline-block; border: 1px solid rgba(239, 68, 68, 0.2);">
                                        <i class="far fa-clock"></i> <strong>Deadline:</strong>
                                        <?= htmlspecialchars(date('M j, Y - g:i A', strtotime($task['deadline']))) ?>
                                    </p>
                                <?php endif; ?>
                                <p><?= nl2br(htmlspecialchars($task['task_description'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </section>

                <!-- ============ SECTION 3: SUBMIT TASK FORM ============ -->
                <section class="acad-glass-box" id="submitTaskSection">
                    <?php if ($isLeader === 1): ?>
                        <form method="POST" action="" enctype="multipart/form-data" class="submit-task-form"
                            id="submitTaskForm">
                            <input type="hidden" name="action" value="submit_task">
                            <input type="hidden" name="workshop_id" value="<?= $selectedWorkshopId ?>">

                            <div class="form-header">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h3>Submit Task</h3>
                            </div>

                            <div class="form-group">
                                <label for="task_id_select">Select Task</label>
                                <select id="task_id_select" name="task_id" required <?= ($selectedWorkshopName === 'Final Project') ? 'disabled' : '' ?>>
                                    <?php if ($selectedWorkshopName === 'Final Project' && !empty($tasks)): ?>
                                        <option value="<?= (int) $tasks[0]['task_id'] ?>" selected>
                                            Final Project Submission
                                        </option>
                                    <?php else: ?>
                                        <option value="">— Select Task —</option>
                                        <?php foreach ($tasks as $task): ?>
                                            <option value="<?= (int) $task['task_id'] ?>">
                                                <?= htmlspecialchars($task['task_title']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <?php if ($selectedWorkshopName === 'Final Project' && !empty($tasks)): ?>
                                    <input type="hidden" name="task_id" value="<?= (int) $tasks[0]['task_id'] ?>">
                                    <p style="font-size: 0.9rem; color: var(--accent-color); margin-top: 5px;">
                                        <i class="fas fa-info-circle"></i> This is a one-time final project submission.
                                    </p>
                                <?php endif; ?>
                            </div>

                            <?php if ($selectedWorkshopName === 'Final Project'): ?>
                                <div class="form-group">
                                    <label for="project_url">Live Site URL</label>
                                    <input type="url" id="project_url" name="project_url" placeholder="https://example.com"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label for="team_photo">Team Photo</label>
                                    <input type="file" id="team_photo" name="team_photo" accept="image/*" required>
                                    <p style="font-size: 0.8rem; color: var(--color-gray-medium); margin-top: 5px;">
                                        Upload a photo of your entire team (JPG, PNG).
                                    </p>
                                </div>

                                <div class="form-group">
                                    <label for="project_desc">Project Summary</label>
                                    <textarea id="project_desc" name="project_desc" rows="4"
                                        placeholder="Enter a comprehensive description of your final project..."
                                        required></textarea>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label>File</label>
                                <div class="file-drop-zone" id="fileDropZone">
                                    <input type="file" name="task_file" id="taskFileInput"
                                        accept=".pdf,.zip,.docx,.doc,.jpg,.jpeg,.png" required>
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Drag & drop your file here or click to browse</p>
                                    <p style="font-size:1rem; color:var(--color-gray-light);">PDF, ZIP, DOCX, JPG, PNG — Max
                                        30MB</p>
                                    <div class="file-name-display" id="fileNameDisplay"></div>
                                </div>
                            </div>

                            <div class="form-actions" style="justify-content: center;">
                                <button type="submit" class="btn-accent" id="submitTaskBtn">
                                    <i class="fas fa-upload"></i>
                                    Submit Task
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="empty-state" style="padding: 20px; text-align: center;">
                            <i class="fas fa-user-shield"
                                style="font-size: 2.5rem; color: var(--color-gray-medium); margin-bottom: 10px;"></i>
                            <p style="color: var(--color-gray-dark);">Only team leaders can submit tasks.</p>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- ============ PREVIOUS SUBMISSIONS ============ -->
                <section class="acad-glass-box" id="prevSubmissionsSection">
                    <div class="acad-section-title">
                        <i class="fas fa-history"></i>
                        <span>Your Previous Submissions</span>
                    </div>

                    <?php if (empty($prevSubmissions)): ?>
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>You haven't submitted any tasks yet</p>
                        </div>
                    <?php else: ?>
                        <div class="prev-submissions">
                            <?php foreach ($prevSubmissions as $sub): ?>
                                <div class="prev-submission-card" id="prevSub_<?= (int) $sub['submission_id'] ?>">
                                    <div class="prev-sub-info">
                                        <span class="prev-sub-task">
                                            <i class="fas fa-file-alt" style="color:var(--accent-color)"></i>
                                            <?= htmlspecialchars($sub['task_title'] ?? '') ?>
                                        </span>
                                        <span class="prev-sub-date" style="margin-left: 10px;">
                                            <i class="far fa-clock" style="color:var(--color-gray-light)"></i>
                                            <?= htmlspecialchars($sub['submission_date'] ?? '') ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($sub['feedback'])): ?>
                                        <div class="prev-sub-desc"
                                            style="margin-top: 10px; font-size: 0.9rem; color: var(--color-gray-dark); background: rgba(255,255,255,0.05); padding: 10px; border-radius: 6px; border-left: 3px solid var(--accent-color);">
                                            <strong>Feedback:</strong> <?= nl2br(htmlspecialchars($sub['feedback'] ?? '')) ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($sub['project_desc'])): ?>
                                        <div class="project-details-expand"
                                            style="margin: 15px 0; padding: 15px; background: rgba(122, 65, 220, 0.05); border-radius: 12px; border: 1px dashed var(--accent-color); font-size: 0.9rem;">
                                            <div style="margin-bottom: 10px; color: var(--color-secondary); font-weight: 600;">
                                                <i class="fas fa-project-diagram" style="margin-right: 5px;"></i> Final Project Details
                                            </div>
                                            <p style="color: var(--color-gray-dark); margin-bottom: 15px;">
                                                <?= nl2br(htmlspecialchars($sub['project_desc'])) ?>
                                            </p>

                                            <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                                                <?php if (!empty($sub['project_url'])): ?>
                                                    <a href="<?= htmlspecialchars($sub['project_url'] ?? '') ?>" target="_blank"
                                                        style="color: var(--accent-color); text-decoration: none; font-weight: 600;">
                                                        <i class="fas fa-external-link-alt"></i> Live Site
                                                    </a>
                                                <?php endif; ?>

                                                <?php if (!empty($sub['team_photo'])): ?>
                                                    <a href="<?= htmlspecialchars($sub['team_photo'] ?? '') ?>" target="_blank"
                                                        style="color: var(--accent-color); text-decoration: none; font-weight: 600;">
                                                        <i class="fas fa-image"></i> Team Photo
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="prev-sub-meta">
                                        <span
                                            class="status-badge <?= $sub['status'] === 'reviewed' ? 'status-reviewed' : 'status-pending' ?>">
                                            <i
                                                class="fas <?= $sub['status'] === 'reviewed' ? 'fa-check-circle' : 'fa-hourglass-half' ?>"></i>
                                            <?= $sub['status'] === 'reviewed' ? 'Reviewed' : 'Pending' ?>
                                        </span>

                                        <?php if (!empty($sub['file_url'])): ?>
                                            <a href="<?= htmlspecialchars($sub['file_url'] ?? '') ?>" target="_blank" download
                                                class="download-sub-btn"
                                                style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 50px; background: rgba(122, 65, 220, 0.1); color: var(--accent-color); font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;"
                                                onmouseover="this.style.background='rgba(122, 65, 220, 0.2)'; this.style.transform='translateY(-1px)'"
                                                onmouseout="this.style.background='rgba(122, 65, 220, 0.1)'; this.style.transform='translateY(0)'">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($sub['score'] !== null): ?>
                                            <span class="score-display">
                                                <i class="fas fa-star" style="color:#FFD700"></i>
                                                <?= htmlspecialchars($sub['score'] ?? '') ?>
                                            </span>
                                        <?php endif; ?>

                                        <?php
                                        // Check if submission was in the last 60 seconds
                                        $subTime = strtotime($sub['submission_date'] ?? 'now');
                                        $isRecently = (time() - $subTime) < 60;
                                        if ($isRecently && $isLeader === 1):
                                            ?>
                                            <form method="POST" style="display:inline;"
                                                onsubmit="return confirm('Are you sure? This will delete your submission so you can re-upload.');">
                                                <input type="hidden" name="action" value="delete_submission">
                                                <input type="hidden" name="submission_id" value="<?= (int) $sub['submission_id'] ?>">
                                                <input type="hidden" name="workshop_id" value="<?= $selectedWorkshopId ?>">
                                                <button type="submit" class="undo-sub-btn"
                                                    style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease;"
                                                    onmouseover="this.style.background='#fca5a5'"
                                                    onmouseout="this.style.background='#fee2e2'">
                                                    <i class="fas fa-undo"></i> Undo (1m)
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

            <?php endif; ?>

        </div>
    </main>

    <?php include './includes/footer.php'; ?>

    <!-- FontAwesome JS (renders icons as SVGs — required since webfonts folder is absent) -->
    <script src="./assets/js/all.min.js?v=<?= ASSET_VERSION ?>"></script>

    <!-- ============ JAVASCRIPT ============ -->
    <script>
        /* --- Workshop pills scroll --- */
        function scrollWorkshops(dir) {
            const c = document.getElementById('workshopPills');
            if (!c) return;
            const amount = 250;
            c.scrollBy({ left: dir === 'right' ? amount : -amount, behavior: 'smooth' });
        }

        /* --- Tasks slider scroll --- */
        function scrollSlider(dir) {
            const c = document.getElementById('tasksSlider');
            if (!c) return;
            const amount = 280;
            c.scrollBy({ left: dir === 'right' ? amount : -amount, behavior: 'smooth' });
        }

        /* --- Expand task detail on card click --- */
        function expandTask(taskId, cardEl) {
            // Remove active from all cards
            document.querySelectorAll('.slider-task-card').forEach(c => c.classList.remove('active-task'));
            // Remove active from all details
            document.querySelectorAll('.task-detail-expand').forEach(d => d.classList.remove('active'));

            // Activate clicked card
            if (cardEl) cardEl.classList.add('active-task');

            // Show detail
            const detail = document.getElementById('taskDetail_' + taskId);
            if (detail) {
                detail.classList.add('active');
                // Smooth scroll to detail
                detail.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        /* --- File input display --- */
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('taskFileInput');
            const nameDisplay = document.getElementById('fileNameDisplay');
            const dropZone = document.getElementById('fileDropZone');

            if (fileInput && nameDisplay) {
                fileInput.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        nameDisplay.textContent = '📎 ' + this.files[0].name;
                        dropZone.style.borderColor = 'var(--accent-color)';
                        dropZone.style.background = 'rgba(122, 65, 220, 0.04)';
                    } else {
                        nameDisplay.textContent = '';
                        dropZone.style.borderColor = '';
                        dropZone.style.background = '';
                    }
                });
            }

            // Drag and drop visual feedback
            if (dropZone) {
                ['dragenter', 'dragover'].forEach(evt => {
                    dropZone.addEventListener(evt, function (e) {
                        e.preventDefault();
                        this.classList.add('dragover');
                    });
                });

                ['dragleave', 'drop'].forEach(evt => {
                    dropZone.addEventListener(evt, function (e) {
                        e.preventDefault();
                        this.classList.remove('dragover');
                    });
                });
            }

            // Flash message auto-hide
            const flash = document.getElementById('flashMessage');
            if (flash) {
                setTimeout(() => {
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-10px)';
                    flash.style.transition = 'all 0.4s ease';
                    setTimeout(() => flash.remove(), 400);
                }, 4000);
            }

            /* --- Form Validation --- */
            const submitForm = document.getElementById('submitTaskForm');
            if (submitForm) {
                submitForm.addEventListener('submit', function (e) {
                    const fileInput = document.getElementById('taskFileInput');
                    const projectUrl = document.getElementById('project_url');
                    const teamPhoto = document.getElementById('team_photo');
                    const projectDesc = document.getElementById('project_desc');

                    // Basic file check
                    if (!fileInput.files || fileInput.files.length === 0) {
                        e.preventDefault();
                        alert('Please select your project file (ZIP, etc.) first.');
                        return;
                    }

                    const file = fileInput.files[0];
                    const maxSize = 30 * 1024 * 1024; // 30MB
                    if (file.size > maxSize) {
                        e.preventDefault();
                        alert('Project file size exceeds 30MB limit.');
                        return;
                    }

                    // Final Project Specific Validation
                    if (projectUrl) {
                        if (!projectUrl.value.trim().startsWith('http')) {
                            e.preventDefault();
                            alert('Please enter a valid live site URL (starting with http/https).');
                            return;
                        }
                    }

                    if (teamPhoto) {
                        if (teamPhoto.files.length === 0) {
                            e.preventDefault();
                            alert('Please upload a team photo.');
                            return;
                        }
                        const photo = teamPhoto.files[0];
                        if (!photo.type.startsWith('image/')) {
                            e.preventDefault();
                            alert('The team photo must be an image file (JPG, PNG, etc.)');
                            return;
                        }
                    }

                    if (projectDesc) {
                        if (projectDesc.value.trim().length < 20) {
                            e.preventDefault();
                            alert('Please provide a more detailed project summary (min 20 characters).');
                            return;
                        }
                    }
                });
            }

            // Scroll active workshop pill into view
            const activeP = document.querySelector('.workshop-pill.active');
            if (activeP) {
                activeP.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        });
    </script>
</body>

</html>