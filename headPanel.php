<?php
include './includes/config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location:./auth/login.php");
  exit;
}

$crewId = (int) $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT workshop_id, role FROM users WHERE user_id = ? AND status = 1");
$stmt->bind_param("i", $crewId);
$stmt->execute();
$crew = $stmt->get_result()->fetch_assoc();


if (!isset($_SESSION['user_id'])) {
  header("Location:./auth/login.php");
  exit;
}

if (!$crew) {
  http_response_code(403);
  die("Access denied");
}

if ((int) $crew['role'] !== 5) { // admin = 5
  http_response_code(403);
  die("Access denied");
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
    <meta property="og:image" content="./assets/images/seo/headPanel.png" />
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
    <link rel="stylesheet" href="./assets/css/headPanel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SCCI - Head Panel</title>
</head>

<body>
    <?php

    include('./includes/nav.php');

    // Handle blocking user via POST
    $blocked_message = '';

    // Handle blocking user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['block_user_id'])) {
        $id = intval($_POST['block_user_id']);
        $section = isset($_POST['section']) ? $_POST['section'] : 'participants';

        // Fetch image before deletion
        $result = mysqli_query($connect, "SELECT image FROM users WHERE user_id = $id");
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $image_path = './assets/uploadedImages/' . $row['image'];
            if (file_exists($image_path) && $row['image'] != 'default.png') {
                unlink($image_path);
            }
        }

        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=0");
        mysqli_query($connect, "DELETE FROM users WHERE user_id = $id");
        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=1");
        header("Location: headPanel.php?section=$section");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $id = intval($_POST['delete']);
        $section = isset($_POST['section']) ? $_POST['section'] : 'participants';

        // Fetch image before deletion
        $result = mysqli_query($connect, "SELECT image FROM users WHERE user_id = $id");
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $image_path = './assets/uploadedImages/' . $row['image'];
            if (file_exists($image_path) && $row['image'] != 'default.png') {
                unlink($image_path);
            }
        }

        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=0");
        mysqli_query($connect, "DELETE FROM users WHERE user_id = $id");
        mysqli_query($connect, "SET FOREIGN_KEY_CHECKS=1");
        header("Location: headPanel.php?section=$section");
        exit();
    }

    // Fetch distinct committees for filter
    $committees = mysqli_query($connect, "SELECT * FROM committees");

    // Fetch distinct workshops for filter
    $workshops = mysqli_query($connect, "SELECT * FROM workshops");

    // Fetch participants with committee name and workshop name
    $participants = mysqli_query($connect, "
        SELECT u.*, c.committe_name, w.workshop_name
        FROM users u
        LEFT JOIN committees c ON u.committee_id = c.committee_id
        LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
        WHERE u.role='1' AND u.status = 1
        ORDER BY u.user_id DESC
    ");

    // Fetch members with committee name
    $members = mysqli_query($connect, "
        SELECT u.*, c.committe_name 
        FROM users u 
        LEFT JOIN committees c ON u.committee_id = c.committee_id 
        WHERE u.role IN ('2', '3') AND u.status = 1 
        ORDER BY u.user_id DESC
    ");

    ?>

    <?php if ($blocked_message): ?>
        <div class="success-message"><?= htmlspecialchars($blocked_message) ?></div>
    <?php endif; ?>

    <main class="panelWrapper">
        <div class="miniNav">
            <div class="panelSvg">
                <!-- left edge -->
                <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none"
                    viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M50 0 C40 0 30 20 10 50 C30 80 40 100 50 100 Z" fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)" stroke-width="2" stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>

                <!-- center -->
                <svg shape-rendering="geometricPrecision" class="panelBody" viewBox="0 0 300 100"
                    preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <defs>
                        <linearGradient id="fillCenter" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="var(--color-primary-darker)" />
                            <stop offset="50%" stop-color="var(--color-primary)" />
                            <stop offset="100%" stop-color="var(--color-primary-darker)" />
                        </linearGradient>
                    </defs>
                    <rect x="0" y="0" width="300" height="100" fill="url(#fillCenter)"
                        stroke="var(--color-primary-darker)" stroke-width="2" />
                </svg>

                <!-- right edge -->
                <svg shape-rendering="geometricPrecision" class="panelEdge" preserveAspectRatio="none"
                    viewBox="0 0 50 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M0 0 C10 0 20 20 40 50 C20 80 10 100 0 100 Z" fill="var(--color-primary-darker)"
                        stroke="var(--color-primary-darker)" stroke-width="2" stroke-linejoin="round"
                        stroke-linecap="round" />
                </svg>
            </div>

            <a data-page="participants" class="participant">participants</a>
            <a data-page="members" class="member">members</a>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by name, email, or phone...">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
        </div>

        <!-- Filters -->
        <div class="filter-container" id="filterContainer">
            <!-- Workshop Filter for Participants -->
            <select id="workshopFilter" style="display: none;">
                <option value="">All Workshops</option>
                <?php while ($work = mysqli_fetch_assoc($workshops)) { ?>
                    <option value="<?= htmlspecialchars(trim($work['workshop_name'])) ?>">
                        <?= htmlspecialchars(trim($work['workshop_name'])) ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Committee Filter for Members -->
            <select id="committeeFilter" style="display: none;">
                <option value="">All Committees</option>
                <?php while ($comm = mysqli_fetch_assoc($committees)) { ?>
                    <option value="<?= htmlspecialchars($comm['committe_name']) ?>">
                        <?= htmlspecialchars($comm['committe_name']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Participants Table -->
        <div class="headTableScroll" id="participantsSchedule">
            <table class="headTable">
                <thead class="tableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Workshop</th>
                        <th class="tableHeader">Committee</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Phone</th>
                        <th class="tableHeader">Status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($participants)) { ?>
                        <tr class="tableRow">
                            <td class="tableData">
                                <?= htmlspecialchars($row['user_name']) ?>
                            </td>
                            <td class="tableData" data-workshop="<?= htmlspecialchars(trim($row['workshop_name'] ?? '')) ?>">
                                <?= htmlspecialchars($row['workshop_name'] ?? 'N/A') ?>
                            </td>
                            <td class="tableData" data-committee="<?= htmlspecialchars($row['committe_name'] ?? '') ?>">
                                <?= htmlspecialchars($row['committe_name'] ?? 'N/A') ?>
                            </td>
                            <td class="tableData email-text">
                                <?= htmlspecialchars($row['email']) ?>
                            </td>
                            <td class="tableData">0
                                <?= htmlspecialchars($row['phone']) ?>
                            </td>
                            <td class="tableData">
                                <?= ($row['status'] == 0) ? 'User Blocked' : 'Active'; ?>
                            </td>
                            <td class="tableData">
                                <?php if ($row['status'] == 1): ?>
                                    <form method="post" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to block this user?');">
                                        <input type="hidden" name="block_user_id" value="<?= $row['user_id'] ?>">
                                        <input type="hidden" name="section" value="participants">
                                        <button type="submit" class="btn btn-primary block">Block</button>
                                    </form>
                                <?php else: ?>
                                    <span class="blocked-text">Blocked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-controls" id="participantsPagination">
            <button class="nav-arrow prev-btn" disabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>

        <!-- Members Table -->
        <div class="headTableScroll" id="membersSchedule" style="display: none;">
            <table class="headTable">
                <thead class="tableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Committee</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Phone</th>
                        <th class="tableHeader">Status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($members)) { ?>
                        <tr class="tableRow">
                            <td class="tableData"><?= htmlspecialchars($row['user_name']) ?></td>
                            <td class="tableData" data-committee="<?= htmlspecialchars($row['committe_name'] ?? '') ?>">
                                <?= htmlspecialchars($row['committe_name'] ?? 'N/A') ?>
                            </td>
                            <td class="tableData email-text"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="tableData">0<?= htmlspecialchars($row['phone']) ?></td>
                            <td class="tableData"><?= ($row['status'] == 0) ? 'User Blocked' : 'Active'; ?></td>
                            <td class="tableData">
                                <?php if ($row['status'] == 1): ?>
                                    <form method="post" style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to block this user?');">
                                        <input type="hidden" name="delete" value="<?= $row['user_id'] ?>">
                                        <input type="hidden" name="section" value="members">
                                        <button type="submit" class="btn btn-primary block">Block</button>
                                    </form>
                                <?php else: ?>
                                    <span class="blocked-text">Blocked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-controls" id="membersPagination" style="display: none;">
            <button class="nav-arrow prev-btn" disabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>
    </main>
    <script src="./assets/js/all.min.js"></script>
    <script src="./assets/js/headPanel.js?v=<?= time() ?>"></script>
</body>

</html>