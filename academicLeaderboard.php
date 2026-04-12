<?php
/* =========================================================================
   academicLeaderboard.php — Hall of Fame & Leaderboard
   Accessible by Participants (Role 1 or 3 in participants) and AC/Head (roles 2, 5).
   ========================================================================= */

include "./includes/config.php";

/* ---------- Auth Check ---------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
    exit;
}

$userId = (int) $_SESSION['user_id'];
$role = (int) ($_SESSION['role'] ?? 0);

// We need to check if user is allowed here: role = 2 (AC) or role = 5 (Head), OR they exist in academic_participants.
$isAllowed = false;
if ($role == 2 || $role == 5 || $role == 1) {
    $isAllowed = true;
} else {
    // Check academic participant
    $stmt = mysqli_prepare($connect, "SELECT participant_id FROM academic_participants WHERE participant_id = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        if (mysqli_stmt_get_result($stmt)->num_rows > 0) {
            $isAllowed = true;
        }
        mysqli_stmt_close($stmt);
    }
}

if (!$isAllowed) {
    http_response_code(403);
    die("Access denied — Participants and Academic Crew only.");
}

/* =============================================
   1) FASTEST SUBMISSIONS (First to upload)
   ============================================= */
$firstSubmissions = []; // Format: [BaseWorkshop][TaskTitle] = submissionData

$queryFastest = "
    SELECT s.submission_id, s.submission_date, p.user_name, a_teams.team_name, t.task_title, w.workshop_name
    FROM academic_submissions s
    JOIN academic_tasks t ON s.task_id = t.task_id
    JOIN academic_workshops w ON t.workshop_id = w.workshop_id
    JOIN academic_participants p ON s.participant_id = p.participant_id
    LEFT JOIN academic_teams a_teams ON p.team_id = a_teams.team_id
    WHERE s.status != 'rejected'
    ORDER BY s.submission_date ASC
";
$resFastest = mysqli_query($connect, $queryFastest);

if ($resFastest) {
    while ($row = mysqli_fetch_assoc($resFastest)) {
        // Normalize workshop name (e.g. "Web Development_1" -> "Web Development")
        $baseName = trim(preg_replace('/[_\-]\d+$/', '', $row['workshop_name']));
        $taskTitle = $row['task_title'];
        
        // Since it's ordered by timestamp ASC, the first one we encounter is the fastest
        if (!isset($firstSubmissions[$baseName][$taskTitle])) {
            $firstSubmissions[$baseName][$taskTitle] = $row;
        }
    }
}

/* =============================================
   2) SCORE LEADERBOARD (Total Evaluation Points)
   ============================================= */
$scoreLeaderboard = []; // Format: [BaseWorkshop][] = teamData

$queryScore = "
    SELECT a_teams.team_id, a_teams.team_name, w.workshop_name, SUM(e.score) as total_score
    FROM academic_evaluations e
    JOIN academic_submissions s ON e.submission_id = s.submission_id
    JOIN academic_tasks t ON s.task_id = t.task_id
    JOIN academic_workshops w ON t.workshop_id = w.workshop_id
    JOIN academic_participants p ON s.participant_id = p.participant_id
    LEFT JOIN academic_teams a_teams ON p.team_id = a_teams.team_id
    GROUP BY a_teams.team_id, a_teams.team_name, w.workshop_name
    ORDER BY total_score DESC
";
$resScore = mysqli_query($connect, $queryScore);

if ($resScore) {
    while ($row = mysqli_fetch_assoc($resScore)) {
        $baseName = trim(preg_replace('/[_\-]\d+$/', '', $row['workshop_name']));
        if (!isset($scoreLeaderboard[$baseName])) {
            $scoreLeaderboard[$baseName] = [];
        }
        $scoreLeaderboard[$baseName][] = $row;
    }
}

// Map workshop base names to icons/colors for UI polish
$wsIcons = ['fa-laptop-code', 'fa-server', 'fa-palette', 'fa-code-branch', 'fa-globe', 'fa-database', 'fa-paint-brush', 'fa-project-diagram', 'fa-code', 'fa-terminal'];
$wsColors = ['#6C63FF', '#FF6584', '#43B97F', '#F5A623', '#3B82F6', '#8B5CF6', '#EC4899', '#14B8A6', '#F97316', '#06B6D4'];

function getWsIcon($baseName, $index) {
    global $wsIcons;
    $lowerName = strtolower($baseName);
    if (strpos($lowerName, 'marketing') !== false || strpos($lowerName, 'business') !== false) {
        return 'fa-bullhorn';
    } elseif (strpos($lowerName, 'devolagy') !== false || strpos($lowerName, 'web') !== false) {
        return 'fa-laptop-code';
    } elseif (strpos($lowerName, 'tech') !== false || strpos($lowerName, 'robot') !== false) {
        return 'fa-robot';
    } elseif (strpos($lowerName, 'data') !== false || strpos($lowerName, 'analysis') !== false) {
        return 'fa-chart-bar';
    }
    return $wsIcons[$index % count($wsIcons)];
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png">
    <title>SCCI — Academic Leaderboard</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/all.min.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/root.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/navbar.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/footer.css?v=<?= ASSET_VERSION ?>">
    <link rel="stylesheet" href="./assets/css/academicLeaderboard.css?v=<?= ASSET_VERSION ?>">
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <div class="leaderboard-header-wrapper">
        <div class="container text-center">
            <h1 class="leaderboard-title">
                <i class="fas fa-trophy highlight-icon"></i> Academic Leaderboard
            </h1>
            <p class="leaderboard-subtitle">See who's leading the race and the first to conquer the tasks!</p>
        </div>
    </div>

    <main class="leaderboard-page">
        <div class="container">
            
            <?php 
            $allBaseNames = array_unique(array_merge(array_keys($firstSubmissions), array_keys($scoreLeaderboard)));
            if (empty($allBaseNames)):
            ?>
                <div class="glass-box empty-state">
                    <i class="fas fa-medal gold"></i>
                    <h2>The Competition is Just Beginning</h2>
                    <p>No task submissions or scores are available yet. Complete your first task to make it to the Hall of Fame!</p>
                </div>
            <?php else: ?>

                <!-- Filter Tabs for Workshops -->
                <div class="lb-tabs" id="lbTabs">
                    <button class="lb-tab active" data-target="all">All Workshops</button>
                    <?php 
                    $wi = 0;
                    foreach ($allBaseNames as $bn): 
                        // simple slug
                        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $bn));
                    ?>
                        <button class="lb-tab" data-target="ws-<?= $slug ?>">
                            <i class="fas <?= getWsIcon($bn, $wi) ?>"></i> <?= htmlspecialchars($bn) ?>
                        </button>
                    <?php 
                    $wi++;
                    endforeach; 
                    ?>
                </div>

                <?php 
                $wi = 0;
                foreach ($allBaseNames as $bn): 
                    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $bn));
                    $icon = getWsIcon($bn, $wi);
                    $color = $wsColors[$wi % count($wsColors)];
                ?>
                
                <section class="ws-section" id="ws-<?= $slug ?>" style="--ws-accent: <?= $color ?>;">
                    <div class="ws-section-header">
                        <h2><i class="fas <?= $icon ?>"></i> <?= htmlspecialchars($bn) ?></h2>
                    </div>

                    <div class="lb-grid">
                        
                        <!-- FIRST TO SUBMIT (FASTEST) -->
                        <div class="glass-box">
                            <div class="box-title">
                                <i class="fas fa-bolt" style="color:#F5A623;"></i> Hall of Fame: First Submissions
                            </div>
                            
                            <?php if (empty($firstSubmissions[$bn])): ?>
                                <p class="small-empty">No submissions yet for this category.</p>
                            <?php else: ?>
                                <div class="fastest-list">
                                    <?php foreach ($firstSubmissions[$bn] as $taskName => $data): ?>
                                    <div class="fastest-item">
                                        <div class="f-info">
                                            <span class="f-task"><?= htmlspecialchars($taskName) ?></span>
                                            <span class="f-team">
                                                <i class="fas fa-users-cog"></i> 
                                                <?= htmlspecialchars($data['team_name'] ?: ($data['user_name'] . ' (Individual)')) ?>
                                            </span>
                                        </div>
                                        <div class="f-time">
                                            <i class="far fa-clock"></i> 
                                            <?= htmlspecialchars(date('M j, g:i A', strtotime($data['submission_date']))) ?>
                                            <span class="f-badge">1st</span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TOP SCORES -->
                        <div class="glass-box">
                            <div class="box-title">
                                <i class="fas fa-star" style="color:#F97316;"></i> Top Ranked Teams
                            </div>
                            
                            <?php if (empty($scoreLeaderboard[$bn])): ?>
                                <p class="small-empty">No evaluated scores yet for this category.</p>
                            <?php else: ?>
                                <div class="podium-list">
                                    <?php 
                                    $rank = 1;
                                    foreach ($scoreLeaderboard[$bn] as $idx => $sdata): 
                                        $medalClass = '';
                                        if ($rank === 1) $medalClass = 'gold';
                                        elseif ($rank === 2) $medalClass = 'silver';
                                        elseif ($rank === 3) $medalClass = 'bronze';
                                    ?>
                                        <div class="podium-item <?= $medalClass ?>">
                                            <div class="p-rank">
                                                <?php if($medalClass): ?>
                                                    <i class="fas fa-medal"></i>
                                                <?php else: ?>
                                                    <?= $rank ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="p-team">
                                                <?= htmlspecialchars($sdata['team_name'] ?: 'Team ' . $sdata['team_id']) ?>
                                            </div>
                                            <div class="p-score">
                                                <?= number_format($sdata['total_score'], 1) ?> pts
                                            </div>
                                        </div>
                                    <?php 
                                        $rank++;
                                    endforeach; 
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </section>

                <?php 
                $wi++;
                endforeach; 
                ?>
                
            <?php endif; ?>
        </div>
    </main>

    <?php include './includes/footer.php'; ?>

    <script src="./assets/js/all.min.js?v=<?= ASSET_VERSION ?>"></script>
    <script>
        // Tab Filtering Logic
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.lb-tab');
            const sections = document.querySelectorAll('.ws-section');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active to clicked
                    tab.classList.add('active');

                    const target = tab.getAttribute('data-target');

                    if (target === 'all') {
                        sections.forEach(s => {
                            s.style.display = 'block';
                            s.style.animation = 'fadeIn 0.5s ease frontwards';
                        });
                    } else {
                        sections.forEach(s => {
                            if (s.id === target) {
                                s.style.display = 'block';
                                s.style.animation = 'fadeIn 0.5s ease forwards';
                            } else {
                                s.style.display = 'none';
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
