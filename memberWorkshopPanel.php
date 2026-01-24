<?php

include "./includes/config.php";
/* =====================
   Auth & Role Check
===================== */
if (!isset($_SESSION['user_id'])) {
  header("Location:./auth/login.php");
  exit;
}

$crewId = (int) $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT workshop_id, role FROM users WHERE user_id = ? AND status = 1");
$stmt->bind_param("i", $crewId);
$stmt->execute();
$crew = $stmt->get_result()->fetch_assoc();

if (!$crew) {
  http_response_code(403);
  die("Access denied");
}

if ((int) $crew['role'] !== 2) { // crew = 2
  http_response_code(403);
  die("Access denied");
}

if (empty($crew['workshop_id'])) {
  die("You are not assigned to a workshop");
}

$workshopId = (int) $crew['workshop_id'];

/* =====================
   Sessions Pagination
===================== */
$sessions = [];
$sq = $connect->prepare("
    SELECT s.session_id, s.session_name
    FROM workshop_session ws
    JOIN sessions s ON s.session_id = ws.session_id
    WHERE ws.workshop_id = ?
    ORDER BY s.session_id ASC
");
$sq->bind_param("i", $workshopId);
$sq->execute();
$sessions = $sq->get_result()->fetch_all(MYSQLI_ASSOC);


// tab - Priority: POST parameter -> GET parameter -> default 'evaluate'
$currentTab = $_POST['tab'] ?? ($_GET['tab'] ?? 'evaluate');

// selected session (لازم قبل workshopSessionId)
$selectedSessionId = isset($_POST['session_id']) ? (int) $_POST['session_id'] : (isset($_GET['session_id']) ? (int) $_GET['session_id'] : 0);

$sessionIds = array_map('intval', array_column($sessions, 'session_id'));
if ($selectedSessionId <= 0 || !in_array($selectedSessionId, $sessionIds, true)) {
  $selectedSessionId = count($sessions) ? (int) $sessions[0]['session_id'] : 0;
}

/* =====================
   Get workshop_session_id for selected session (بعد selectedSessionId)
===================== */
$workshopSessionId = 0;

if ($selectedSessionId > 0) {
  $ws = $connect->prepare("
    SELECT workshop_session_id
    FROM workshop_session
    WHERE workshop_id = ? AND session_id = ?
  ");
  $ws->bind_param("ii", $workshopId, $selectedSessionId);
  $ws->execute();
  $wsRow = $ws->get_result()->fetch_assoc();
  if ($wsRow) {
    $workshopSessionId = (int) $wsRow['workshop_session_id'];
  }
}


if ($selectedSessionId <= 0 || !in_array($selectedSessionId, $sessionIds, true)) {
  $selectedSessionId = count($sessions) ? (int) $sessions[0]['session_id'] : 0;
}

function redirectPanel($sessionId, $tab, $type = 'msg', $text = '')
{
  $sessionId = (int) $sessionId;

  // tabs الموجودة عندك بالـ IDs
  $allowedTabs = ['evaluate', 'review', 'addTask', 'addMaterial'];
  if (!in_array($tab, $allowedTabs, true)) {
    $tab = 'evaluate';
  }

  $qs = "session_id={$sessionId}&tab={$tab}";
  if ($text !== '') {
    $qs .= "&{$type}=" . urlencode($text);
  }

  header("Location: memberWorkshopPanel.php?{$qs}");
  exit;
}

function generateSessionsHTML()
{
  global $sessions, $selectedSessionId, $currentTab;

  $html = '';
  foreach ($sessions as $session) {
    $sid = (int) $session['session_id'];

    $isActive = ($sid === (int) $selectedSessionId) ? ' sessionActive' : '';
    $fill = $isActive ? '#1f184e' : 'var(--color-white-gradient)';
    $bodyClass = $isActive ? 'sessionBlue' : 'sessionWhite';

    $href = '?session_id=' . $sid . '&tab=' . urlencode($currentTab);



    $html .= '
        <a class="sessionBtn' . $isActive . '" href="' . $href . '">
            <div class="panelSvg panelSession">
                <svg shape-rendering="geometricPrecision" class="panelEdge sessionEdge" preserveAspectRatio="none" viewBox="0 0 50 100"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M50 0 C40 0 30 20 10 50 C30 80 40 100 50 100 Z"
                        fill="' . $fill . '" stroke="' . $fill . '" stroke-width="2"
                        stroke-linejoin="round" stroke-linecap="round" />
                </svg>

                <div class="panelBody ' . $bodyClass . '"></div>

                <svg shape-rendering="geometricPrecision" class="panelEdge sessionEdge" preserveAspectRatio="none" viewBox="0 0 50 100"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M0 0 C10 0 20 20 40 50 C20 80 10 100 0 100 Z"
                        fill="' . $fill . '" stroke="' . $fill . '" stroke-width="2"
                        stroke-linejoin="round" stroke-linecap="round" />
                </svg>
            </div>

            <p>' . htmlspecialchars($session['session_name']) . '</p>
        </a>';
  }
  return $html;
}

/* =====================
   Participants (same workshop)
===================== */
$participants = [];
$sql = "
  SELECT user_id, user_name
  FROM users
  WHERE workshop_id = ?
    AND role = 1 and status = 1
  ORDER BY user_name ASC
";
$stmt2 = $connect->prepare($sql);
$stmt2->bind_param("i", $workshopId);
$stmt2->execute();
$participants = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

/* =====================
   Attendance Map for Review
   - only for TODAY
===================== */
$attMap = []; // user_id => status
$qMap = $connect->prepare("
  SELECT user_id, status
  FROM attendance
  WHERE workshop_id = ?
    AND session_id = ?
    AND attendance_date = CURDATE()
");
$qMap->bind_param("ii", $workshopId, $selectedSessionId);
$qMap->execute();
$attRows = $qMap->get_result()->fetch_all(MYSQLI_ASSOC);
foreach ($attRows as $r) {
  $attMap[(int) $r['user_id']] = $r['status'];
}

/* =====================
   Handle Attendance POST
===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'mark_attendance') {

  $participantId = (int) ($_POST['participant_id'] ?? 0);
  $status = $_POST['status'] ?? '';

  if ($participantId <= 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Invalid participant");
    exit;
  }
  if (!in_array($status, ['present', 'absent'], true)) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Invalid status");
    exit;
  }

  // ensure participant belongs to same workshop and is participant
  $chk = $connect->prepare("SELECT user_id FROM users WHERE user_id = ? AND workshop_id = ? AND role = 1");
  $chk->bind_param("ii", $participantId, $workshopId);
  $chk->execute();
  if ($chk->get_result()->num_rows === 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Not authorized");
    exit;
  }

  // upsert attendance for TODAY
  $sqlAtt = "
    INSERT INTO attendance (workshop_id, session_id, user_id, attendance_date, status, marked_by)
    VALUES (?, ?, ?, CURDATE(), ?, ?)
    ON DUPLICATE KEY UPDATE
      status = VALUES(status),
      marked_by = VALUES(marked_by)
  ";
  $stmtAtt = $connect->prepare($sqlAtt);
  $stmtAtt->bind_param("iiisi", $workshopId, $selectedSessionId, $participantId, $status, $crewId);
  $stmtAtt->execute();

  redirectPanel($selectedSessionId, $currentTab, 'msg', 'Attendance saved');
  exit;
}

/* =====================
   Submissions Map (Task column)
   - latest submitted file for selected workshop_session
===================== */
$submitMap = []; // user_id => file_link

if ($workshopSessionId > 0) {
  $sqlSub = "
  SELECT ts.user_id, ts.submit_link
  FROM task_submissions ts
  JOIN tasks t ON t.task_id = ts.task_id
  WHERE t.workshop_session_id = ?
    AND ts.status = 'submitted'
    AND ts.submission_id = (
      SELECT MAX(ts2.submission_id)
      FROM task_submissions ts2
      JOIN tasks t2 ON t2.task_id = ts2.task_id
      WHERE ts2.user_id = ts.user_id
        AND t2.workshop_session_id = ?
        AND ts2.status = 'submitted'
    )
";


  $stSub = $connect->prepare($sqlSub);
  $stSub->bind_param("ii", $workshopSessionId, $workshopSessionId);
  $stSub->execute();
  $subRows = $stSub->get_result()->fetch_all(MYSQLI_ASSOC);

  foreach ($subRows as $r) {
    $submitMap[(int) $r['user_id']] = $r['submit_link'];
  }
}

/* =====================
   Handle Feedback POST (modal submit)
===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_feedback') {

  $submissionId = (int) ($_POST['submission_id'] ?? 0);
  $rating = (int) ($_POST['rating'] ?? 0);
  $feedbackText = trim($_POST['feedback_text'] ?? '');

  if ($submissionId <= 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=evaluate&err=Invalid submission");
    exit;
  }
  if ($rating < 1 || $rating > 5) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=evaluate&err=Rating must be 1 to 5");
    exit;
  }
  if ($feedbackText === '') {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=evaluate&err=Feedback is required");
    exit;
  }

  // Security: submission must belong to participant in same workshop and in selected workshop_session
  $chk = $connect->prepare("
    SELECT ts.submission_id
    FROM task_submissions ts
    JOIN users u ON u.user_id = ts.user_id
    JOIN tasks t ON t.task_id = ts.task_id
    WHERE ts.submission_id = ?
      AND u.workshop_id = ?
      AND u.role = 1
      AND t.workshop_session_id = ?
  ");
  $chk->bind_param("iii", $submissionId, $workshopId, $workshopSessionId);
  $chk->execute();
  if ($chk->get_result()->num_rows === 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=evaluate&err=Not authorized");
    exit;
  }

  // Upsert feedback (1 feedback per submission)
  $sql = "
    INSERT INTO task_feedback (submission_id, feedback_text, rating, given_by)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
      feedback_text = VALUES(feedback_text),
      rating = VALUES(rating),
      given_by = VALUES(given_by)
  ";
  $st = $connect->prepare($sql);
  $st->bind_param("isii", $submissionId, $feedbackText, $rating, $crewId);
  $st->execute();

  redirectPanel($selectedSessionId, 'review', 'msg', 'Feedback saved');

  exit;
}

/* =====================
   Latest submission + feedback per participant for selected workshop_session
   Map: user_id => [submission_id, rating, feedback_text, given_by]
===================== */
$latestByUser = []; // user_id => info

if ($workshopSessionId > 0) {
  $sql = "
    SELECT 
      u.user_id,
      u.user_name,
      ts.submission_id,
      tf.rating,
      tf.feedback_text,
      tf.given_by
    FROM users u
    LEFT JOIN task_submissions ts ON ts.user_id = u.user_id
    LEFT JOIN tasks t ON t.task_id = ts.task_id
    LEFT JOIN task_feedback tf ON tf.submission_id = ts.submission_id
    WHERE u.workshop_id = ?
      AND u.role = 1
      AND t.workshop_session_id = ?
      AND ts.status = 'submitted'
      AND ts.submission_id = (
        SELECT MAX(ts2.submission_id)
        FROM task_submissions ts2
        JOIN tasks t2 ON t2.task_id = ts2.task_id
        WHERE ts2.user_id = u.user_id
          AND t2.workshop_session_id = ?
          AND ts2.status = 'submitted'
      )
    ORDER BY u.user_name ASC
  ";
  $stmt = $connect->prepare($sql);
  $stmt->bind_param("iii", $workshopId, $workshopSessionId, $workshopSessionId);
  $stmt->execute();
  $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  foreach ($rows as $r) {
    $uid = (int) $r['user_id'];
    $latestByUser[$uid] = [
      'user_name' => $r['user_name'],
      'submission_id' => (int) $r['submission_id'],
      'rating' => isset($r['rating']) ? (int) $r['rating'] : null,
      'feedback_text' => $r['feedback_text'] ?? null,
      'given_by' => isset($r['given_by']) ? (int) $r['given_by'] : null,
    ];
  }
} else {
  $rows = []; // عشان الـ review loop
}

/* =====================
   Handle Add Task POST
===================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_task') {

  $taskName = trim($_POST['taskName'] ?? '');
  $taskDeadline = $_POST['taskDeadline'] ?? '';
  $taskBio = trim($_POST['taskBio'] ?? '');

  if ($taskName === '' || $taskDeadline === '' || $taskBio === '') {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Please fill all fields");
    exit;
  }

  if ($workshopSessionId <= 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addTask&err=Workshop session not found");
    exit;
  }

  // Check if a task already exists for this session
  $chk = $connect->prepare("SELECT task_id FROM tasks WHERE workshop_session_id = ?");
  $chk->bind_param("i", $workshopSessionId);
  $chk->execute();
  if ($chk->get_result()->num_rows > 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addTask&err=A task has already been added for this session.");
    exit;
  }
  $chk->close();

  // upload file (optional)
  $taskFilePath = null;

  if (!empty($_FILES['task_file']['name'])) {

    if ($_FILES['task_file']['error'] !== UPLOAD_ERR_OK) {
      header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addTask&err=File upload error");
      exit;
    }

    if ($_FILES['task_file']['size'] > 20 * 1024 * 1024) {
      header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addTask&err=File too large (max 20MB)");
      exit;
    }

    $allowed = ['pdf', 'doc', 'docx', 'png', 'jpg', 'jpeg', 'zip'];
    $ext = strtolower(pathinfo($_FILES['task_file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed, true)) {
      header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addTask&err=Invalid file type");
      exit;
    }

    $uploadDir = __DIR__ . "/uploads/tasks";
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $newName = "task_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
    $dest = $uploadDir . "/" . $newName;

    if (!move_uploaded_file($_FILES['task_file']['tmp_name'], $dest)) {
      redirectPanel($selectedSessionId, 'addTask', 'err', 'Failed to upload file');
      exit;
    }

    $taskFilePath = "uploads/tasks/" . $newName;
  }

  // Insert task (USING workshop_session_id and session_id)
  $sql = "
  INSERT INTO tasks (session_id, workshop_session_id, taskName, taskDeadline, taskBio, task_file)
  VALUES (?, ?, ?, ?, ?, ?)
";

  $st = $connect->prepare($sql);

  // i i s s s s  = 6 values
  $st->bind_param("iissss", $selectedSessionId, $workshopSessionId, $taskName, $taskDeadline, $taskBio, $taskFilePath);
  $st->execute();

  redirectPanel($selectedSessionId, $currentTab, 'msg', 'Task added successfully');

  exit;
}

/* =====================
   Handle Add Material POST
===================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_material') {

  if ($workshopSessionId <= 0) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=addMaterial&err=Workshop session not found");
    exit;
  }

  $materialTitle = trim($_POST['material_title'] ?? '');
  $materialType = $_POST['material_type'] ?? '';

  if ($materialTitle === '' || !in_array($materialType, ['technical', 'soft'], true)) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Please enter title and choose a valid type");
    exit;
  }

  if (!isset($_FILES['material_file']) || $_FILES['material_file']['error'] !== UPLOAD_ERR_OK) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=File upload error");
    exit;
  }

  if ($_FILES['material_file']['size'] > 20 * 1024 * 1024) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=File too large (max 20MB)");
    exit;
  }

  $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'rar', 'png', 'jpg', 'jpeg'];
  $ext = strtolower(pathinfo($_FILES['material_file']['name'], PATHINFO_EXTENSION));

  if (!in_array($ext, $allowed, true)) {
    header("Location: memberWorkshopPanel.php?session_id=$selectedSessionId&tab=$currentTab&err=Invalid file type");
    exit;
  }

  $uploadDir = __DIR__ . "/uploads/materials";
  if (!is_dir($uploadDir))
    mkdir($uploadDir, 0777, true);

  $newName = "mat_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
  $dest = $uploadDir . "/" . $newName;

  if (!move_uploaded_file($_FILES['material_file']['tmp_name'], $dest)) {
    redirectPanel($selectedSessionId, 'addMaterial', 'err', 'File upload error');
    exit;
  }

  $dbPath = "uploads/materials/" . $newName;

  $st = $connect->prepare("
    INSERT INTO session_materials (workshop_session_id, material_type, material_title, file_path, uploaded_by)
    VALUES (?, ?, ?, ?, ?)
  ");
  $st->bind_param("isssi", $workshopSessionId, $materialType, $materialTitle, $dbPath, $crewId);
  $st->execute();

  redirectPanel($selectedSessionId, $currentTab, 'msg', 'Material added');

  exit;
}

// Map crew names by id (for showing who gave the feedback)
$crewNameById = [];
$qCrew = $connect->prepare("SELECT user_id, user_name FROM users WHERE workshop_id = ? AND role = 2");
$qCrew->bind_param("i", $workshopId);
$qCrew->execute();
$crewRows = $qCrew->get_result()->fetch_all(MYSQLI_ASSOC);
foreach ($crewRows as $c) {
  $crewNameById[(int) $c['user_id']] = $c['user_name'];
}

/* =====================
   Handle Delete Material (optional)
===================== */
if (isset($_GET['delete_material_id'])) {

  $materialId = (int) $_GET['delete_material_id'];

  $del = $connect->prepare("
    DELETE FROM session_materials
    WHERE material_id = ?
      AND workshop_session_id = ?
  ");
  $del->bind_param("ii", $materialId, $workshopSessionId);
  $del->execute();

  redirectPanel($selectedSessionId, 'addMaterial', 'msg', 'Material deleted');
  exit;
}

/* =====================
   Handle Delete Task (optional)
===================== */
if (isset($_GET['delete_task_id'])) {

  $taskId = (int) $_GET['delete_task_id'];

  $del = $connect->prepare("
    DELETE FROM tasks
    WHERE task_id = ?
      AND workshop_session_id = ?
  ");
  $del->bind_param("ii", $taskId, $workshopSessionId);
  $del->execute();

  redirectPanel($selectedSessionId, 'addTask', 'msg', 'Task deleted');
  exit;
}

/* =====================
   Materials list for selected workshop_session
===================== */
$materialsTech = [];
$materialsSoft = [];

if ($workshopSessionId > 0) {

  $stM = $connect->prepare("
    SELECT material_id, material_type, material_title, file_path, uploaded_by
    FROM session_materials
    WHERE workshop_session_id = ?
    ORDER BY material_id DESC
  ");
  $stM->bind_param("i", $workshopSessionId);
  $stM->execute();

  $mrows = $stM->get_result()->fetch_all(MYSQLI_ASSOC);

  foreach ($mrows as $m) {
    if ($m['material_type'] === 'technical')
      $materialsTech[] = $m;
    else
      $materialsSoft[] = $m;
  }
}

/* =====================
   Tasks list for selected workshop_session
===================== */
$tasks = [];

if ($workshopSessionId > 0) {
  $stT = $connect->prepare("
    SELECT task_id, taskName, taskDeadline, taskBio, task_file
    FROM tasks
    WHERE workshop_session_id = ?
    ORDER BY task_id DESC
  ");
  $stT->bind_param("i", $workshopSessionId);
  $stT->execute();

  $tasks = $stT->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- favicon -->
  <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
  <meta property="og:image" content="./assets/images/seo/memberWorkshopPanel.png" />
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
  <link rel="stylesheet" href="./assets/css/all.min.css" />
  <link rel="stylesheet" href="./assets/css/root.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/navbar.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/footer.css">
  <link rel="stylesheet" href="./assets/css/message-toast.css">
  <link rel="stylesheet" href="./assets/css/memberWorkshopPanel.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/task-management.css?v=<?php echo time(); ?>">
  <!-- Quill CSS -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>SCCI - Member Panel</title>
</head>

<body>
  <?php include('./includes/nav.php'); ?>

  <!-- REVIEW Popup ----------------------------------------------------------------------------- -->
  <!-- REVIEW Popups (one per participant, unique id) -->
  <?php if (!empty($participants)): ?>
    <?php foreach ($participants as $p): ?>
      <?php
      $pid = (int) $p['user_id'];

      $text = $latestByUser[$pid]['feedback_text'] ?? null;
      $giverId = $latestByUser[$pid]['given_by'] ?? null;

      $giverName = ($giverId && isset($crewNameById[(int) $giverId]))
        ? $crewNameById[(int) $giverId]
        : '—';

      $popupId = "feedbackPopup_" . $pid; // ✅ unique
      ?>

      <div id="<?= $popupId ?>" class="reviewFeedbackPopup">
        <div class="reviewFeedbackContainer">
          <div class="FeedbackContainerTop">
            <h6>Feedback Review</h6>
            <div class="closeFeedback">X</div>
          </div>

          <div class="FeedbackBox">
            <h6><?= htmlspecialchars($giverName) ?></h6>
            <!-- put the rating here -->
            <p><?= !empty($text) ? htmlspecialchars($text) : 'No feedback' ?></p>
          </div>
        </div>
      </div>

    <?php endforeach; ?>
  <?php endif; ?>

  <main class="materialPage">
    <!-- FORM Success Popup ----------------------------------------------------------------------------- -->

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
      <a data-page="evaluate" class="activePanelLine">evaluate</a>
      <a data-page="review" class="">review</a>
      <a data-page="addTask" class="">add task</a>
      <a data-page="addMaterial" class="">add materials</a>
      <a data-page="quiz" class="">quiz</a>
    </div>

    <!-- EVALUATE --------------------------------------------------------------------------- -->
    <section id="evaluate" class="panelSection panelSectionActive evaluateContainer">

      <!-- Sessions -->
      <div class="sessionsSelectorFrame">
        <!-- scroll button -->
        <button class="sessionScrollBtn scrollLeft">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-left"></i>
          </div>
        </button>

        <div class="sessionsSelector">
          <?php echo generateSessionsHTML(); ?>
        </div>

        <!-- scroll button -->
        <button class="sessionScrollBtn scrollRight">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-right"></i>
          </div>
        </button>
      </div>

      <div class="panelWhiteBox">
        <!-- Table -->
        <div class="tableScrollFrame">
          <div class="tableScroll" id="workshopTableScroll">
            <table cellpadding="0" cellspacing="0" summary="participants dashboard">
              <colgroup>
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
              </colgroup>

              <!-- Table head -->
              <thead>
                <tr>
                  <th scope="col"><i class="fa-solid fa-user"></i> Name</th>
                  <th scope="col"><i class="fa-solid fa-user"></i> attendance</th>
                  <th scope="col">
                    <i class="fa-regular fa-circle-check"></i> task
                  </th>
                  <th scope="col">
                    <i class="fa-solid fa-splotch"></i> feedback
                  </th>
                </tr>
              </thead>

              <!-- Table body -->

              <tbody>
                <?php if (count($participants) === 0): ?>
                  <tr>
                    <td class="tableParticipantName" colspan="5">No participants in this workshop.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($participants as $participant): ?>

                    <tr>
                      <td class="tableParticipantName"><?php echo htmlspecialchars($participant['user_name']); ?></td>
                      <td>
                        <form method="POST" class="attendanceForm">
                          <input type="hidden" name="action" value="mark_attendance">
                          <input type="hidden" name="participant_id" value="<?php echo $participant['user_id']; ?>">
                          <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
                          <input type="hidden" name="session_id" value="<?php echo $selectedSessionId; ?>"></label>
                          <div class="evaluateTaskRow">
                            <label class="radioOption">
                              <input type="radio" name="status" value="present" <?php echo (isset($attMap[$participant['user_id']]) && $attMap[$participant['user_id']] === 'present') ? 'checked' : ''; ?> />
                              <div class="evaluateAttendanceCircle evaluateCheckTask">
                                <i class="fa-solid fa-check"></i>
                              </div>
                            </label>

                            <label class="radioOption">
                              <input type="radio" name="status" value="absent" <?php echo (!isset($attMap[$participant['user_id']]) || $attMap[$participant['user_id']] !== 'present') ? 'checked' : ''; ?> />
                              <div class="evaluateAttendanceCircle evaluateXtask">
                                <i class="fa-solid fa-x"></i>
                              </div>
                            </label>
                          </div>
                          <button type="submit" class="btn btn-primary btn-sm attendanceSubmit"
                            style="display: none;">Save</button>
                        </form>
                      </td>
                      <td>
                        <?php if (!empty($submitMap[$participant['user_id']])): ?>
                          <a href="<?= htmlspecialchars($submitMap[$participant['user_id']]) ?>" target="_blank"
                            class="tdDwonloadTask"> Download Task</a>
                        <?php else: ?>
                          —
                        <?php endif; ?>
                      </td>

                      <td>

                        <?php
                        $pid = (int) $participant['user_id'];
                        $submissionId = $latestByUser[$pid]['submission_id'] ?? 0;
                        $hasFeedback = isset($latestByUser[$pid]['rating']);
                        ?>

                        <?php if ($submissionId > 0): ?>
                          <button data-popup="feedbackModal" data-submission-id="<?= (int) $submissionId ?>"
                            class="evaluateFeedback btn-primary" type="button" <?php echo $hasFeedback ? 'disabled' : ''; ?>>
                            <?php echo $hasFeedback ? 'Feedback Added' : 'Add Feedback'; ?>
                          </button>
                        <?php else: ?>
                          <span class="text-muted">No submission</span>
                        <?php endif; ?>


                    </tr>

                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="pagination-controls" id="workshopPagination">
          <button class="nav-arrow prev-btn"><i class="fa-solid fa-caret-left"></i></button>
          <span class="page-info">Page 1</span>
          <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>
      </div>
    </section>



    <!-- REVIEW ----------------------------------------------------------------------------- -->
    <section id="review" class="panelSection evaluateContainer">


      <!-- Sessions -->
      <div class="sessionsSelectorFrame">
        <!-- scroll button -->
        <button class="sessionScrollBtn scrollLeft">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-left"></i>
          </div>
        </button>

        <div class="sessionsSelector">
          <?php echo generateSessionsHTML(); ?>
        </div>

        <!-- scroll button -->
        <button class="sessionScrollBtn scrollRight">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-right"></i>
          </div>
        </button>
      </div>

      <div class="panelWhiteBox">
        <!-- Filters -->
        <div class="reviewFilters"
          style="display: flex; gap: 30px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; padding-left: 10px;">

          <!-- Attendance Filter -->
          <div class="filterGroup" style="display: flex; align-items: center; gap: 10px;">
            <span
              style="color: var(--color-secondary); font-weight: bold; font-family: sans-serif; font-size: 0.9rem;">Attendance:</span>
            <div class="filterOptions" style="display: flex; gap: 5px;">
              <button type="button" class="filterBtn active" data-group="attendance" data-value="all">All</button>
              <button type="button" class="filterBtn" data-group="attendance" data-value="present">Present</button>
              <button type="button" class="filterBtn" data-group="attendance" data-value="absent">Absent</button>
            </div>
          </div>

          <!-- Task Status Filter -->
          <div class="filterGroup" style="display: flex; align-items: center; gap: 10px;">
            <span
              style="color: var(--color-secondary); font-weight: bold; font-family: sans-serif; font-size: 0.9rem;">Task
              Status:</span>
            <div class="filterOptions" style="display: flex; gap: 5px;">
              <button type="button" class="filterBtn active" data-group="task" data-value="all">All</button>
              <button type="button" class="filterBtn" data-group="task" data-value="accepted">Accepted</button>
              <button type="button" class="filterBtn" data-group="task" data-value="pending">Pending</button>
            </div>
          </div>

        </div>
        <!-- Table -->
        <div class="tableScrollFrame">
          <div class="tableScroll" id="reviewTableScroll">
            <table cellpadding="0" cellspacing="0" summary="participants dashboard">
              <colgroup>
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
                <col span="1" style="width: 25%" />
              </colgroup>

              <!-- Table head -->
              <thead>
                <tr>
                  <th scope="col"><i class="fa-solid fa-user"></i> Name</th>
                  <th scope="col"><i class="fa-solid fa-user"></i> attendance</th>
                  <th scope="col"><i class="fa-solid fa-bars-progress"></i> task status</th>
                  <th scope="col"><i class="fa-solid fa-splotch"></i> feedback</th>
                </tr>
              </thead>

              <!-- Table body -->
              <tbody>


                <?php if (count($participants) === 0): ?>
                  <tr>
                    <td class="tableParticipantName" colspan="5">No participants in this workshop.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($participants as $p): ?>
                    <?php
                    $pid = (int) $p['user_id'];
                    $st = $attMap[$pid] ?? 'absent';

                    $rating = $latestByUser[$pid]['rating'] ?? null;
                    $text = $latestByUser[$pid]['feedback_text'] ?? null;
                    $given = $latestByUser[$pid]['user_name'] ?? null;
                    ?>
                    <tr class="reviewRow" data-attendance="<?= $st ?>"
                      data-task-status="<?= isset($latestByUser[$pid]) ? 'accepted' : 'pending' ?>">
                      <td class="tableParticipantName"><?php echo htmlspecialchars($p['user_name']); ?></td>

                      <!-- attendance -->
                      <td>
                        <?php if ($st === 'present'): ?>
                          <div class="reviewAttended">
                            <div class="reviewAttendBox">
                              <div class="reviewAttendedSymbol">✓</div>
                            </div>
                            Attended
                          </div>
                        <?php else: ?>
                          <div class="reviewAbsent">
                            <div class="reviewAttendBox">
                              <div class="reviewAttendedSymbol">✗</div>
                            </div>
                            Absent
                          </div>
                        <?php endif; ?>
                      </td>

                      <!-- task status -->
                      <td>
                        <?php if ($rating): ?>
                          <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fa<?= $i <= $rating ? '-solid' : '-regular' ?> fa-star"></i>
                          <?php endfor; ?>
                        <?php elseif (isset($latestByUser[$pid])): ?>
                          <!-- task accepted -->
                          <div class="reviewAttended">
                            <div class="reviewAttendBox">
                              <div class="reviewAttendedLeft"></div>
                              <i class="fa-solid fa-check reviewAttendedSymbol"></i>
                            </div>
                            <div>Accepted</div>
                          </div>
                        <?php else: ?>
                          <!-- task pending -->
                          <div class="reviewBending">
                            <div class="reviewAttendBox">
                              <div class="reviewAttendedLeft"></div>
                              <div class="reviewAttendedSymbol">-</div>
                            </div>
                            <div>Pending</div>
                          </div>
                        <?php endif; ?>
                      </td>

                      <td>
                        <button data-popup="feedbackPopup_<?= (int) $p['user_id'] ?>"
                          class="evaluateFeedback btn-primary" type="button">
                          view feedback
                        </button>

                      </td>

                    </tr>

                    <!-- table row -->
                  <?php endforeach; ?>
                <?php endif; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="pagination-controls" id="reviewPagination">
        <button class="nav-arrow prev-btn"><i class="fa-solid fa-caret-left"></i></button>
        <span class="page-info">Page 1</span>
        <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
      </div>
      </div>
    </section>


    <!-- Add Task Section ------------------------------------- -->
    <section id="addTask" class="taskContainer panelSection evaluateContainer">

      <!-- Sessions -->
      <div class="sessionsSelectorFrame">
        <!-- scroll button -->
        <button class="sessionScrollBtn scrollLeft">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-left"></i>
          </div>
        </button>

        <div class="sessionsSelector">
          <?php echo generateSessionsHTML(); ?>
        </div>

        <!-- scroll button -->
        <button class="sessionScrollBtn scrollRight">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-right"></i>
          </div>
        </button>
      </div>

      <!-- add task form -->
      <div class="panelWhiteBox">
        <form class="validForm" action="memberWorkshopPanel.php?session_id=<?= (int) $selectedSessionId ?>&tab=addTask"
          method="post" enctype="multipart/form-data">
          <input type="hidden" name="action" value="add_task">
          <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
          <input type="hidden" name="session_id" value="<?php echo $selectedSessionId; ?>">
          <div class="materialForm">
            <div class="sideInputs">
              <!-- add task name -->
              <div class="inputsBox">
                <div class="groupInputs">
                  <label class="formLabel" for="taskName">Task Name:</label>
                  <input class="textInput" type="text" name="taskName" id="taskName">
                </div>
                <p id="taskNameMessage"></p>
              </div>

              <!-- add task deadline -->
              <div class="inputsBox">
                <div class="groupInputs">
                  <label class="formLabel" for="taskDeadline">Deadline:</label>
                  <input class="textInput" type="datetime-local" name="taskDeadline" id="taskDeadline">
                </div>
                <p id="taskDeadlineMessage"></p>
              </div>

            </div>
            <!-- add task Description -->
            <div class="inputsBox">
              <div class="groupInputs columnGroup">
                <label class="formLabel" for="taskBio" id="taskBioLabel">Task Description:</label>
                <div class="quill-wrapper">
                  <div id="editor-container"></div>
                </div>
                <textarea name="taskBio" id="taskBioInput" style="display:none"></textarea>
              </div>
              <p id="taskBioMessage"></p>
            </div>

          </div>

          <!-- upload task file -->
          <div class="fileUpload">
            <div class="formLabel">Upload File:</div>
            <div class="uploadContainer">
              <label class="formLabel uploadLabel">
                <div class="uploadIcon"></div>
              </label>
              <p class="uploadText">Drag and drop or click to browse</p>

              <input id="taskUpload" type="file" name="task_file" class="taskFileInput" style="display:none;">

              <!-- Shows uploaded file name -->
              <div class="fileUploadInfo">
                <p class="fileUploadedName" style="display:none;"></p>
                <button type="button" class="removeUpload" style="display:none;">X</button>
              </div>

              <p class="fileMessage"></p>
              <p class="dragMessage" style="display: none;"><i class="fa-solid fa-file"></i>Drag the task file here!</p>

              <label for="taskUpload" class="btn btn-secondary btn-sm uploadBtn">Upload File</label>

            </div>
          </div>

          <button class="btn btn-primary btn-sm submitBtn" type="submit">Add Task</button>
        </form>
      </div>

      <!--task list section ----------------------------- -->
      <div class="panelWhiteBox">
        <h4>Tasks</h4>

        <div class="articleFiles">
          <?php if (count($tasks) === 0): ?>

            <div class="notFIleAdded">
              <i class="fa-solid fa-folder-open"></i>
              <p>No tasks added yet.</p>
            </div>

          <?php else: ?>
            <?php foreach ($tasks as $task): ?>
              <article class="materialItem">
                <div class="materialInfo">
                  <span class="materialFileName">
                    <?= htmlspecialchars($task['taskName']) ?> - Deadline: <?= htmlspecialchars($task['taskDeadline']) ?>
                  </span>
                  <div class="taskDescription ql-editor">
                    <?= $task['taskBio'] // raw html from quill ?>
                  </div>
                </div>
                <div class="materialActions">
                  <?php if (!empty($task['task_file'])): ?>
                    <a href="<?= htmlspecialchars($task['task_file']) ?>" target="_blank" class="downloadFileBtn"><i
                        class="fa-solid fa-download"></i> Download</a>
                  <?php endif; ?>
                  <button class="deleteMaterialButton" onclick="deleteTask(<?= (int) $task['task_id'] ?>)">Delete</button>
                </div>
              </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </div>
    </section>

    <!-- Adding Materials Section ---------------------------------- -->
    <section class="evaluateContainer panelSection" id="addMaterial">

      <!-- Sessions -->
      <div class="sessionsSelectorFrame">
        <!-- scroll button -->
        <button class="sessionScrollBtn scrollLeft">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-left"></i>
          </div>
        </button>

        <div class="sessionsSelector">
          <?php echo generateSessionsHTML(); ?>
        </div>

        <!-- scroll button -->
        <button class="sessionScrollBtn scrollRight">
          <div class="sessionBtnLeft">
            <i class="fa-solid fa-angle-right"></i>
          </div>
        </button>
      </div>

      <!-- Add Material Form -->
      <div class="panelWhiteBox">
        <form class="validForm"
          action="memberWorkshopPanel.php?session_id=<?= (int) $selectedSessionId ?>&tab=addMaterial" method="post"
          enctype="multipart/form-data">
          <input type="hidden" name="action" value="add_material">
          <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
          <input type="hidden" name="session_id" value="<?php echo $selectedSessionId; ?>">

          <div class="sideInputs">
            <div class="inputsBox">
              <div class="formGroup">
                <label class="formLabel" for="material_title">Material Name:</label>
                <input class="textInput" type="text" name="material_title" id="material_title" />
              </div>
            </div>

            <div class="inputsBox">
              <div class="formGroup">
                <label class="formLabel" for="material_type">Session Type:</label>
                <select class="selectInput" name="material_type" id="material_type">
                  <option value="technical">Technical</option>
                  <option value="soft">Soft Skills</option>
                </select>
              </div>
            </div>
          </div>

          <!-- upload material file -->
          <div class="fileUpload">
            <div class="formLabel">Upload File:</div>

            <div class="uploadContainer">
              <label class="formLabel uploadLabel">
                <div class="uploadIcon"></div>
                <p class="uploadText">Drag and drop or click to browse</p>
              </label>

              <input type="file" name="material_file" id="material_file" class="taskFileInput" style="display:none;">

              <!-- Shows uploaded file name -->
              <div class="fileUploadInfo">
                <p class="fileUploadedName" id="materialFileName" style="display:none;"></p>
                <button type="button" class="removeUpload" style="display:none;">X</button>
              </div>
              <p class="fileMessage" id="materialFileMsg"></p>
              <p class="dragMessage" style="display: none;"><i class="fa-solid fa-file"></i>Drag the material here!</p>

              <label class="btn btn-secondary btn-sm" for="material_file">Upload File</label>
            </div>
          </div>

          <button class="btn btn-primary submitBtn btn-sm" type="submit">Add Material</button>

        </form>
      </div>

      <!-- Materials list -->
      <section class="panelWhiteBox">
        <h4>Materials</h4>

        <div class="materialCategory">
          <aside class="materialType">
            <button type="button" class="materialTypeButton active" data-filter="technical">Technical Material</button>
            <button type="button" class="materialTypeButton" data-filter="soft">SoftSkills Material</button>
          </aside>

          <div class="materialItemsList" id="materialsList">
            <?php if (count($materialsTech) === 0 && count($materialsSoft) === 0): ?>
              <div class="notFIleAdded">
                <i class="fa-solid fa-folder-open"></i>
                <p>No materials added yet.</p>
              </div>
            <?php else: ?>
              <?php if (count($materialsTech) > 0): ?>
                <div class="materialCategorySection" id="techMaterials">
                  <h5>Technical Materials</h5>
                  <?php foreach ($materialsTech as $material): ?>
                    <article class="materialItem">

                      <div class="materialInfo">
                        <span class="materialFileName">
                          <?= htmlspecialchars($material['material_title']) ?>
                        </span>
                      </div>

                      <div class="materialActions">
                        <a href="<?= htmlspecialchars($material['file_path']) ?>" target="_blank" class="downloadFileBtn"><i
                            class="fa-solid fa-download"></i> Download</a>
                        <button class="deleteMaterialButton"
                          onclick="deleteMaterial(<?= (int) $material['material_id'] ?>)">Delete</button>
                      </div>

                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <?php if (count($materialsSoft) > 0): ?>
                <div class="materialCategorySection" id="softMaterials">
                  <h5>Soft Skills Materials</h5>
                  <?php foreach ($materialsSoft as $material): ?>
                    <article class="materialItem">
                      <div class="materialInfo">
                        <span class="materialFileName">
                          <?= htmlspecialchars($material['material_title']) ?>
                        </span>
                      </div>
                      <div class="materialActions">
                        <a href="<?= htmlspecialchars($material['file_path']) ?>" target="_blank" class="downloadFileBtn"><i
                            class="fa-solid fa-download"></i> Download</a>
                        <button class="deleteMaterialButton"
                          onclick="deleteMaterial(<?= (int) $material['material_id'] ?>)">Delete</button>
                      </div>
                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>

    </section>

    <!-- Activity Time Section ---------------------------------- -->
    <section id="quiz" class="panelSection evaluateContainer">
      <article class="workshopCard activityCard">
        <div class="cardHeader activityHeader">
          <h4><i class="fas fa-gamepad"></i> ACTIVITY TIME</h4>
        </div>

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
            <p class="gameSubtitle">Cast your quiz, spark curiosity!</p>
          </div>

          <!-- Game Info Cards -->
          <!-- <div class="gameInfoGrid">
                  <div class="gameInfoCard rewardCard">
                      <div class="infoIcon">
                          <i class="fas fa-gem"></i>
                      </div>
                      <div class="infoContent">
                          <span class="infoLabel">Reward Points</span>
                          <span class="infoValue">100 Points</span>
                      </div>
                  </div>
              </div> -->

          <!-- Motivational Message -->
          <div class="motivationalBox">
            <i class="fas fa-bullseye"></i>
            <p>Create quizzes that challenge, inspire, and leave a lasting impact. 🚀</p>
          </div>

          <!-- Play Button -->
          <div class="playButtonContainer">
            <a href="https://awadcoding.github.io/SCCI-Quiz/admin.html" class="playGameBtn">
              <span class="btnGlow"></span>
              <i class="fas fa-play"></i>
              <span class="btnText">START GAME NOW</span>
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>

          <!-- Stats Preview -->
          <!-- <div class="statsPreview">
                  <div class="statItem">
                      <i class="fas fa-users"></i>
                      <span>300 Players</span>
                  </div>
                  <div class="statItem">
                      <i class="fas fa-crown"></i>
                      <span>Top Score: 98/100</span>
                  </div>
              </div> -->
        </div>
      </article>
    </section>

  </main>
  <!-- end add materials section-->

  <!-- Feedback Modal Popup -->
  <div id="feedbackModal" class="reviewFeedbackPopup">
    <div class="reviewFeedbackContainer">

      <div class="FeedbackContainerTop">
        <h6><i class="fas fa-comment-dots"></i> Add Feedback</h6>
        <button type="button" class="closeFeedback">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="modalBody FeedbackBox">
        <form id="feedbackForm" method="POST" action="">
          <input type="hidden" name="action" value="save_feedback">
          <input type="hidden" name="tab" value="<?php echo htmlspecialchars($currentTab); ?>">
          <input type="hidden" name="session_id" value="<?php echo $selectedSessionId; ?>">
          <input type="hidden" name="submission_id" id="submissionIdInput" value="0">
          <input type="hidden" id="ratingValue" name="rating" value="0">

          <div class="materialForm">
            <label class="formLabel" for="feedback_text">Add feedback:</label>
            <textarea class="textInput popupInput" name="feedback_text" id="feedback_text" rows="4"></textarea>
            <p id="feedbackTextMsg" class="errorMsg"></p>
          </div>

          <div class="feedbackFormGroup">
            <label class="feedbackLabel">Rating:</label>
            <div class="feedbackStarsInput">
              <i class="fa-regular fa-star feedbackStars" data-rating="1"></i>
              <i class="fa-regular fa-star feedbackStars" data-rating="2"></i>
              <i class="fa-regular fa-star feedbackStars" data-rating="3"></i>
              <i class="fa-regular fa-star feedbackStars" data-rating="4"></i>
              <i class="fa-regular fa-star feedbackStars" data-rating="5"></i>
            </div>
            <p id="ratingMsg" class="errorMsg"></p>
          </div>

          <div class="modalFooter">
            <button type="submit" class="btn btn-primary btn-sm">Save Feedback</button>
            <p id="feedbackOkMsg" class="okMsg"></p>
          </div>
        </form>
      </div>

    </div>
  </div>


  <!-- successful submit popup -->
  <div class="submitPopup" style="display:none;">
    form submitted
    <button type="button" class="popupSubmitClose">X</button>
  </div>

  <!-- JAVASCRIPT -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const urlParams = new URLSearchParams(window.location.search);
      const urlMsg = urlParams.get('msg');
      const urlErr = urlParams.get('err');

      const sessionMsg = <?php echo isset($_SESSION['msg']) ? json_encode($_SESSION['msg']) : 'null'; ?>;
      const sessionErr = <?php echo isset($_SESSION['err']) ? json_encode($_SESSION['err']) : 'null'; ?>;

      const finalMsg = sessionMsg || urlMsg;
      const finalErr = sessionErr || urlErr;

      const popup = document.querySelector(".submitPopup");
      if (popup && (finalMsg || finalErr)) {
        if (typeof window.displayCustomPopup === 'function') {
          window.displayCustomPopup(finalMsg || finalErr, !!finalErr);
        }

        // Clear URL parameters
        if (urlMsg || urlErr) {
          const newUrl = new URL(window.location.href);
          newUrl.searchParams.delete('msg');
          newUrl.searchParams.delete('err');
          window.history.replaceState({}, '', newUrl.toString());
        }
      }
    });
    <?php unset($_SESSION['msg']);
    unset($_SESSION['err']); ?>
  </script>
  <script src="assets/js/all.min.js" defer></script>
  <!-- <script src="assets/js/messages.js" defer></script> -->
  <!-- Quill JS -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Check if editor container exists
      if (document.getElementById('editor-container')) {
        var quill = new Quill('#editor-container', {
          theme: 'snow',
          placeholder: 'Write the task description here...',
          modules: {
            toolbar: [
              [{
                'header': [1, 2, 3, false]
              }],
              ['bold', 'italic', 'underline'],
              [{
                'list': 'ordered'
              }, {
                'list': 'bullet'
              }],
              ['clean']
            ]
          }
        });

        // Sync with hidden textarea
        var taskBioInput = document.getElementById('taskBioInput');
        quill.on('text-change', function() {
          taskBioInput.value = quill.root.innerHTML;
        });
      }
    });
  </script>
  <script src="assets/js/memberWorkshopPanel.js" defer></script>
  <script src="assets/js/pagination.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      setupPagination('workshopTableScroll', 'workshopPagination');
      setupPagination('reviewTableScroll', 'reviewPagination');
    });
  </script>

  <!-- delete confirmation popup -->
  <div class="deleteConfirmPopup" id="deleteConfirmPopup">
    <div class="confirmCard">
      <div class="confirmHeader">
        <i class="fas fa-trash-alt"></i>
        <h3 id="deleteConfirmTitle">Delete?</h3>
      </div>
      <p id="deleteConfirmMsg">This action cannot be undone.</p>
      <div class="confirmBtnGroup">
        <button type="button" class="btn btn-confirm-cancel" onclick="closeDeleteConfirm()">Cancel</button>
        <button type="button" class="btn btn-confirm-delete" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>

</body>

</html>
