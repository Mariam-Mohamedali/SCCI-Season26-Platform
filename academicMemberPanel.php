<?php
/* =========================================================================
   academicMemberPanel.php — AC Member Dashboard
   Role = 2 (from users table)
   ========================================================================= */

include "./includes/config.php";

/* ---------- Auth & Role Check ---------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$userId = (int) $_SESSION['user_id'];
$role = (int) ($_SESSION['role'] ?? 0);

if ($role !== 2) {
    http_response_code(403);
    die("Access denied — AC Members only.");
}

/* ---------- Flash Message Helper ---------- */
function setFlash($type, $msg)
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

/* ---------- Fetch All Workshops (with team name) ---------- */
$allWorkshops = [];
$groupedWorkshops = [];
$wq = mysqli_query(
    $connect,
    "SELECT w.workshop_id, w.workshop_name, w.team_id, t.team_name
     FROM academic_workshops w
     LEFT JOIN academic_teams t ON w.team_id = t.team_id
     ORDER BY w.workshop_id ASC"
);
if ($wq) {
    while ($row = mysqli_fetch_assoc($wq)) {
        $allWorkshops[(int)$row['workshop_id']] = $row;
        $baseName = trim(preg_replace('/[_\-]\d+$/', '', $row['workshop_name']));
        if (!isset($groupedWorkshops[$baseName])) {
            $groupedWorkshops[$baseName] = [];
        }
        $groupedWorkshops[$baseName][] = $row;
    }
}

/* ---------- Selected Workshop ---------- */
$selectedWorkshopId = isset($_GET['workshop_id']) ? (int) $_GET['workshop_id'] : 0;
if ($selectedWorkshopId <= 0 && count($allWorkshops) > 0) {
    $selectedWorkshopId = array_key_first($allWorkshops);
}

$selectedWorkshopName = '';
$selectedBaseName = '';
if (isset($allWorkshops[$selectedWorkshopId])) {
    $selectedWorkshopName = $allWorkshops[$selectedWorkshopId]['workshop_name'];
    $selectedBaseName = trim(preg_replace('/[_\-]\d+$/', '', $selectedWorkshopName));
}

/* =============================================
   POST HANDLERS
   ============================================= */

/* ----- Handle: Add Task ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_task') {

    $taskTitle = trim($_POST['task_title'] ?? '');
    $taskDesc = trim($_POST['task_description'] ?? '');
    $wsTarget = $_POST['workshop_id'] ?? '0'; // Can be 'all' or numeric ID
    $deadline = trim($_POST['deadline'] ?? '');

    if ($taskTitle === '' || $taskDesc === '') {
        setFlash('error', 'Please fill in all fields');
    } elseif ($deadline === '') {
        setFlash('error', 'Please select a deadline');
    } else {
        $deadlineFormatted = date('Y-m-d H:i:s', strtotime($deadline));
        
        // Determine workshop IDs to insert
        $targetIds = [];
        if ($wsTarget === 'all' && $selectedBaseName !== '') {
            foreach ($groupedWorkshops[$selectedBaseName] as $wsItem) {
                $targetIds[] = (int)$wsItem['workshop_id'];
            }
        } elseif ((int)$wsTarget > 0) {
            $targetIds[] = (int)$wsTarget;
        }

        if (empty($targetIds)) {
            setFlash('error', 'No valid workshops selected');
        } else {
            $stmt = mysqli_prepare($connect, "INSERT INTO academic_tasks (task_title, task_description, workshop_id, deadline) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $successCount = 0;
                foreach ($targetIds as $tid) {
                    mysqli_stmt_bind_param($stmt, "ssis", $taskTitle, $taskDesc, $tid, $deadlineFormatted);
                    if (mysqli_stmt_execute($stmt)) {
                        $successCount++;
                    }
                }
                
                if ($successCount > 0) {
                    setFlash('success', "Task added successfully to $successCount workshop(s) ✓");
                } else {
                    setFlash('error', 'An error occurred while adding the task');
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    $redirectId = ($wsTarget === 'all') ? $selectedWorkshopId : (int)$wsTarget;
    header("Location: academicMemberPanel.php?workshop_id=" . $redirectId);
    exit;
}

/* ----- Handle: Save Evaluation ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_evaluation') {

    $submissionId = (int) ($_POST['submission_id'] ?? 0);
    $score = $_POST['score'] ?? '';
    $feedback = trim($_POST['feedback'] ?? '');
    $wsId = (int) ($_POST['workshop_id'] ?? 0);

    if ($submissionId <= 0) {
        setFlash('error', 'Invalid submission');
    } elseif ($score === '' || !is_numeric($score)) {
        setFlash('error', 'Please enter a valid score');
    } else {
        $scoreVal = (float) $score;
        $stmt = mysqli_prepare(
            $connect,
            "INSERT INTO academic_evaluations (submission_id, score, feedback)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE score = VALUES(score), feedback = VALUES(feedback)"
        );
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ids", $submissionId, $scoreVal, $feedback);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            setFlash('success', 'Evaluation saved successfully ✓');
        }
    }

    header("Location: academicMemberPanel.php?workshop_id=" . $wsId);
    exit;
}

/* ----- Handle: Accept Submission ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'accept_submission') {

    $submissionId = (int) ($_POST['submission_id'] ?? 0);
    $wsId = (int) ($_POST['workshop_id'] ?? 0);

    if ($submissionId > 0) {
        $stmt = mysqli_prepare($connect, "UPDATE academic_submissions SET status = 'reviewed' WHERE submission_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $submissionId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            setFlash('success', 'Submission accepted ✓');
        }
    }

    header("Location: academicMemberPanel.php?workshop_id=" . $wsId);
    exit;
}

/* ---------- Count tasks per workshop (for the slider cards) ---------- */
$workshopTaskCounts = [];
$cntQ = mysqli_query($connect, "SELECT workshop_id, COUNT(*) as cnt FROM academic_tasks GROUP BY workshop_id");
if ($cntQ) {
    while ($row = mysqli_fetch_assoc($cntQ)) {
        $workshopTaskCounts[(int) $row['workshop_id']] = (int) $row['cnt'];
    }
}

/* ---------- Fetch Tasks for Selected Workshop ---------- */
$tasks = [];
if ($selectedWorkshopId > 0) {
    $stmt = mysqli_prepare(
        $connect,
        "SELECT t.task_id, t.task_title, t.task_description, t.deadline,
                (SELECT COUNT(*) FROM academic_submissions s WHERE s.task_id = t.task_id) AS sub_count
         FROM academic_tasks t
         WHERE t.workshop_id = ?
         ORDER BY t.task_id DESC"
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

/* ---------- Fetch Submissions for Selected Workshop ---------- */
$submissions = [];
if ($selectedWorkshopId > 0) {
    $stmt = mysqli_prepare(
        $connect,
        "SELECT s.submission_id, s.file_url, s.submission_date, s.status,
                p.user_name, p.participant_id,
                t.task_id, t.task_title,
                e.score, e.feedback
         FROM academic_submissions s
         JOIN academic_participants p ON s.participant_id = p.participant_id
         JOIN academic_tasks t ON s.task_id = t.task_id
         LEFT JOIN academic_evaluations e ON e.submission_id = s.submission_id
         WHERE t.workshop_id = ?
         ORDER BY s.submission_date DESC"
    );
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $selectedWorkshopId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $submissions[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
}

/* ---------- Flash Message Retrieval ---------- */
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

/* ---------- Workshop icon/color maps ---------- */
$wsIcons = ['fa-laptop-code', 'fa-server', 'fa-palette', 'fa-code-branch', 'fa-globe', 'fa-database', 'fa-paint-brush', 'fa-project-diagram', 'fa-code', 'fa-terminal'];
$wsColors = ['#6C63FF', '#FF6584', '#43B97F', '#F5A623', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316', '#06B6D4'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png">
    <meta property="og:title" content="SCCI — Academic Member Panel">
    <meta property="og:description"
        content="AC Member Dashboard for managing academic workshops, tasks, and evaluations.">
    <meta name="description"
        content="SCCI Academic Member Panel — manage workshops, tasks, submissions, and evaluations.">

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
    <link rel="stylesheet" href="./assets/css/academicMemberPanel.css?v=<?= ASSET_VERSION ?>">

    <title>SCCI — Academic Member Panel</title>
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <main class="acad-page">
        <div class="container">

            <!-- ============ FLASH MESSAGE ============ -->
            <?php if ($flash): ?>
                <div class="flash-message <?= $flash['type'] === 'success' ? 'success' : 'error' ?>" id="flashMessage">
                    <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
                    <span><?= htmlspecialchars($flash['msg']) ?></span>
                </div>
            <?php endif; ?>

            <!-- ============ SECTION 1: WORKSHOP SLIDER ============ -->
            <section class="ws-slider-section" id="workshopSliderSection">
                <div class="ws-slider-header">
                    <h2><i class="fas fa-graduation-cap"></i> Select Workshop</h2>
                    <p class="ws-slider-subtitle">Choose a workshop to manage its tasks and submissions</p>
                </div>

                <?php if (empty($groupedWorkshops)): ?>
                    <div class="acad-glass-box">
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <p>No workshops available yet</p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="ws-slider-wrapper">


                        <div class="ws-slider-track" id="wsSliderTrack">
                            <?php 
                            $i = 0;
                            foreach ($groupedWorkshops as $baseName => $wsList): 
                                $isActive = ($baseName === $selectedBaseName);
                                
                                $lowerName = strtolower($baseName);
                                if (strpos($lowerName, 'marketing') !== false || strpos($lowerName, 'business') !== false) {
                                    $icon = 'fa-bullhorn';
                                } elseif (strpos($lowerName, 'devolagy') !== false || strpos($lowerName, 'web') !== false) {
                                    $icon = 'fa-laptop-code';
                                } elseif (strpos($lowerName, 'tech') !== false || strpos($lowerName, 'robot') !== false) {
                                    $icon = 'fa-robot';
                                } elseif (strpos($lowerName, 'data') !== false || strpos($lowerName, 'analysis') !== false) {
                                    $icon = 'fa-chart-bar';
                                } else {
                                    $icon = $wsIcons[$i % count($wsIcons)];
                                }

                                $color = $wsColors[$i % count($wsColors)];
                                
                                // Point to the first team's workshop by default when clicking the category
                                $defaultWsId = (int) $wsList[0]['workshop_id'];
                                
                                // Sum tasks across all teams for this category
                                $totalTasks = 0;
                                foreach ($wsList as $wTemp) {
                                    $totalTasks += $workshopTaskCounts[(int)$wTemp['workshop_id']] ?? 0;
                                }
                            ?>
                                <a href="?workshop_id=<?= $defaultWsId ?>"
                                    class="ws-slide-card <?= $isActive ? 'ws-active' : '' ?>"
                                    id="wsCard_<?= $defaultWsId ?>" style="--ws-accent: <?= $color ?>;">
                                    <div class="ws-card-icon">
                                        <i class="fas <?= $icon ?>"></i>
                                    </div>
                                    <div class="ws-card-name"><?= htmlspecialchars($baseName) ?></div>
                                    <div class="ws-card-meta">
                                        <span class="ws-card-tasks">
                                            <i class="fas fa-tasks"></i>
                                            <?= $totalTasks ?> <?= $totalTasks === 1 ? 'task' : 'tasks' ?>
                                        </span>
                                    </div>
                                    <?php if ($isActive): ?>
                                        <div class="ws-card-active-dot"></div>
                                    <?php endif; ?>
                                </a>
                            <?php 
                            $i++;
                            endforeach; 
                            ?>
                        </div>
                    </div>

                    <?php if ($selectedBaseName && isset($groupedWorkshops[$selectedBaseName])): ?>
                        <div class="team-dropdown-container" style="max-width: 400px; margin: 25px auto 10px; text-align: center;">
                            <label style="display:block; margin-bottom:10px; font-weight: 500; font-size: var(--fs-md); color: var(--color-primary);">
                                <i class="fas fa-users-cog" style="color:var(--accent-color); margin-right:5px;"></i> Select Specific Team
                            </label>
                            <select class="form-control" style="width:100%; padding: 12px; border-radius: 8px; border: 1px solid var(--color-gray-medium); font-family: inherit; font-size: var(--fs-base);"
                                onchange="window.location.href='?workshop_id='+this.value">
                                <option value="" disabled>— Select Specific Team —</option>
                                <?php foreach ($groupedWorkshops[$selectedBaseName] as $wsRow): ?>
                                    <option value="<?= (int)$wsRow['workshop_id'] ?>" <?= ((int)$wsRow['workshop_id'] === $selectedWorkshopId) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($wsRow['team_name'] ?: 'Team ' . $wsRow['team_id']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <!-- ============ SECTION 2: ADD TASK + TASKS GRID ============ -->
            <?php if ($selectedWorkshopId > 0): ?>

                <!-- Add Task Form -->
                <?php if ($selectedWorkshopName !== 'Final Project'): ?>
                    <section class="acad-glass-box" id="addTaskSection">
                        <form method="POST" action="" class="add-task-form" id="addTaskForm">
                            <input type="hidden" name="action" value="add_task">
                            <input type="hidden" name="workshop_id" value="<?= isset($_GET['workshop_id']) && $_GET['workshop_id'] === 'all' ? 'all' : $selectedWorkshopId ?>">

                            <div class="form-header">
                                <i class="fas fa-plus-circle"></i>
                                <h3>Add New Task</h3>
                                <span class="form-workshop-tag">
                                    <i class="fas fa-arrow-right" style="font-size:0.7em; opacity:0.6;"></i>
                                    <?= htmlspecialchars($selectedWorkshopName) ?>
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="task_title">Task Title</label>
                                <input type="text" id="task_title" name="task_title" placeholder="Enter task title..." required>
                            </div>

                            <div class="form-group">
                                <label for="task_description">Task Description</label>
                                <textarea id="task_description" name="task_description" rows="4"
                                    placeholder="Enter detailed task description..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="datetime-local" id="deadline" name="deadline" required>
                            </div>

                            <div class="form-group">
                                <p style="font-size: 0.85rem; color: var(--accent-color); font-weight: 500;">
                                    <i class="fas fa-info-circle"></i> This task will be assigned to <strong><?= htmlspecialchars($allWorkshops[$selectedWorkshopId]['team_name'] ?: 'Team ' . $allWorkshops[$selectedWorkshopId]['team_id']) ?></strong>.
                                </p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-accent" id="addTaskBtn">
                                    <i class="fas fa-paper-plane"></i>
                                    Add Task
                                </button>
                            </div>
                        </form>
                    </section>
                <?php else: ?>
                    <div class="acad-glass-box" style="border-left: 4px solid var(--accent-color);">
                        <div style="display: flex; align-items: center; gap: 15px; color: var(--color-secondary);">
                            <i class="fas fa-lock" style="font-size: 1.5rem; color: var(--accent-color);"></i>
                            <div>
                                <h4 style="margin: 0; font-weight: 700;">Final Project Mode</h4>
                                <p style="margin: 5px 0 0; font-size: 0.9rem; color: var(--color-gray-dark);">
                                    Tasks for the Final Project are fixed and cannot be added manually. You can still manage and evaluate team submissions below.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Tasks Grid -->
                <section id="tasksGrid">
                    <div class="acad-section-title">
                        <i class="fas fa-tasks"></i>
                        <span>Tasks — <?= htmlspecialchars($selectedWorkshopName) ?></span>
                    </div>

                    <?php if (empty($tasks)): ?>
                        <div class="acad-glass-box">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <p>No tasks yet for this workshop</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="tasks-grid">
                            <?php foreach ($tasks as $task): ?>
                                <div class="task-card" onclick="openTaskModal(<?= (int) $task['task_id'] ?>)"
                                    id="taskCard_<?= (int) $task['task_id'] ?>">
                                    <div class="task-card-title"><?= htmlspecialchars($task['task_title']) ?></div>
                                    <div class="task-card-desc">
                                        <?= htmlspecialchars(mb_strimwidth($task['task_description'], 0, 100, '...')) ?>
                                    </div>
                                    <div class="task-card-footer">
                                        <span class="task-card-workshop"><?= htmlspecialchars($selectedWorkshopName) ?></span>
                                        <?php if (!empty($task['deadline'])): ?>
                                            <span class="task-badge"
                                                style="background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2);">
                                                <i class="far fa-clock"></i>
                                                <?= htmlspecialchars(date('M j, g:i A', strtotime($task['deadline']))) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="task-badge">
                                            <i class="fas fa-file-upload"></i>
                                            <?= (int) $task['sub_count'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Task Detail Modals -->
                <?php foreach ($tasks as $task): ?>
                    <div class="task-modal-overlay" id="taskModal_<?= (int) $task['task_id'] ?>">
                        <div class="task-modal">
                            <div class="task-modal-header">
                                <h3><?= htmlspecialchars($task['task_title']) ?></h3>
                                <button class="task-modal-close" onclick="closeTaskModal(<?= (int) $task['task_id'] ?>)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="task-modal-body">
                                <p><?= nl2br(htmlspecialchars($task['task_description'])) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Submissions Section -->
                <?php if (!empty($submissions)): ?>
                    <section class="acad-glass-box" id="submissionsSection">
                        <div class="acad-section-title">
                            <i class="fas fa-file-alt"></i>
                            <span>Submissions — <?= htmlspecialchars($selectedWorkshopName) ?></span>
                        </div>

                        <?php foreach ($submissions as $sub): ?>
                            <div class="submission-row" id="subRow_<?= (int) $sub['submission_id'] ?>">
                                <div class="submission-header">
                                    <div class="submission-info">
                                        <span class="submission-name">
                                            <i class="fas fa-user-graduate" style="color:var(--accent-color)"></i>
                                            <?= htmlspecialchars($sub['user_name'] ?? '') ?>
                                        </span>
                                        <span class="submission-task">
                                            <i class="fas fa-file-alt" style="color:var(--color-gray-medium)"></i>
                                            <?= htmlspecialchars($sub['task_title'] ?? '') ?>
                                        </span>
                                        <span class="submission-date">
                                            <i class="far fa-clock" style="color:var(--color-gray-light)"></i>
                                            <?= htmlspecialchars($sub['submission_date'] ?? '') ?>
                                        </span>
                                    </div>
                                    <span
                                        class="status-badge <?= $sub['status'] === 'reviewed' ? 'status-reviewed' : 'status-pending' ?>">
                                        <i
                                            class="fas <?= $sub['status'] === 'reviewed' ? 'fa-check-circle' : 'fa-hourglass-half' ?>"></i>
                                        <?= $sub['status'] === 'reviewed' ? 'Reviewed' : 'Pending' ?>
                                    </span>
                                </div>

                                <div class="submission-actions">
                                    <a href="<?= htmlspecialchars($sub['file_url']) ?>" target="_blank" class="btn-download"
                                        download>
                                        <i class="fas fa-download"></i> Download
                                    </a>

                                    <?php if ($sub['status'] !== 'reviewed'): ?>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="action" value="accept_submission">
                                            <input type="hidden" name="submission_id" value="<?= (int) $sub['submission_id'] ?>">
                                            <input type="hidden" name="workshop_id" value="<?= $selectedWorkshopId ?>">
                                            <button type="submit" class="btn-accept" id="acceptBtn_<?= (int) $sub['submission_id'] ?>">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if (!empty($sub['score'])): ?>
                                        <div class="eval-display">
                                            <span class="eval-score">
                                                <i class="fas fa-star" style="color:#FFD700"></i>
                                                Score: <?= htmlspecialchars($sub['score']) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST" action="" class="eval-form"
                                        id="evalForm_<?= (int) $sub['submission_id'] ?>">
                                        <input type="hidden" name="action" value="save_evaluation">
                                        <input type="hidden" name="submission_id" value="<?= (int) $sub['submission_id'] ?>">
                                        <input type="hidden" name="workshop_id" value="<?= $selectedWorkshopId ?>">
                                        <div class="eval-field">
                                            <label>Score</label>
                                            <input type="number" name="score" min="0" max="100" step="0.5"
                                                value="<?= htmlspecialchars($sub['score'] ?? '') ?>" placeholder="0-100" required>
                                        </div>
                                        <div class="eval-field">
                                            <label>Feedback</label>
                                            <textarea name="feedback" rows="2"
                                                placeholder="Enter your feedback..."><?= htmlspecialchars($sub['feedback'] ?? '') ?></textarea>
                                        </div>
                                        <button type="submit" class="btn-save-eval">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </section>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </main>

    <?php include './includes/footer.php'; ?>

    <!-- FontAwesome JS -->
    <script src="./assets/js/all.min.js?v=<?= ASSET_VERSION ?>"></script>

    <script>
        /* --- Workshop Slider scroll --- */
        function slideWorkshops(dir) {
            const track = document.getElementById('wsSliderTrack');
            if (!track) return;
            const cardWidth = track.querySelector('.ws-slide-card')?.offsetWidth || 260;
            const gap = 20;
            const amount = cardWidth + gap;
            track.scrollBy({ left: dir === 'right' ? amount : -amount, behavior: 'smooth' });
        }

        /* --- Task Modal --- */
        function openTaskModal(taskId) {
            const modal = document.getElementById('taskModal_' + taskId);
            if (modal) { modal.classList.add('active'); document.body.style.overflow = 'hidden'; }
        }

        function closeTaskModal(taskId) {
            const modal = document.getElementById('taskModal_' + taskId);
            if (modal) { modal.classList.remove('active'); document.body.style.overflow = ''; }
        }

        document.querySelectorAll('.task-modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function (e) {
                if (e.target === this) { this.classList.remove('active'); document.body.style.overflow = ''; }
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.task-modal-overlay.active').forEach(m => m.classList.remove('active'));
                document.body.style.overflow = '';
            }
        });

        /* --- Flash + auto-scroll --- */
        document.addEventListener('DOMContentLoaded', function () {
            const flash = document.getElementById('flashMessage');
            if (flash) {
                setTimeout(() => {
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(-10px)';
                    flash.style.transition = 'all 0.4s ease';
                    setTimeout(() => flash.remove(), 400);
                }, 4000);
            }

            const activeCard = document.querySelector('.ws-slide-card.ws-active');
            if (activeCard) {
                activeCard.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        });
    </script>
</body>

</html>