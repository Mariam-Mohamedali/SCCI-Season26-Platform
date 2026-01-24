<?php

include "./includes/config.php";

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

if ((int) $crew['role'] !== 2) { // crew = 2
  http_response_code(403);
  die("Access denied");
}

if (empty($crew['workshop_id'])) {
  die("You are not assigned to a workshop");
}

$workshopId = (int) $crew['workshop_id'];


// Access control: Only allow IT committee members (role 2, committee_id 6)
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}
 

// Fetch committee_id if not in session
if (!isset($_SESSION['committee_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = mysqli_prepare($connect, "SELECT committee_id FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result_comm = mysqli_stmt_get_result($stmt);
    if ($row_comm = mysqli_fetch_assoc($result_comm)) {
        $_SESSION['committee_id'] = $row_comm['committee_id'];
    }
    mysqli_stmt_close($stmt);
}

if ($_SESSION['role'] != 2 || $_SESSION['committee_id'] != 6) {
    die("Access denied: Only IT committee members can access this panel.");
}

/* ===============================
   ACCEPT USER
================================ */
if (isset($_GET['accept'])) {
    $id = (int) $_GET['accept'];

    $stmt = mysqli_prepare($connect, "UPDATE users SET status = 1 WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: itPanel.php");
    exit();
}

/* ===============================
   DELETE USER
================================ */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    // get image
    $stmt = mysqli_prepare($connect, "SELECT image FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['image']) && $row['image'] !== 'default.png') {
            $imagePath = "./assets/uploadedImages/" . $row['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
    mysqli_stmt_close($stmt);

    // delete user
    $stmt = mysqli_prepare($connect, "DELETE FROM users WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: itPanel.php");
    exit();
}

/* ===============================
   FETCH FILTERS DATA
================================ */
$workshops = mysqli_query($connect, "SELECT workshop_id, workshop_name FROM workshops");
if (!$workshops) {
    die("Workshops Error: " . mysqli_error($connect));
}

$committees = mysqli_query($connect, "SELECT committee_id, committe_name FROM committees");
if (!$committees) {
    die("Committees Error: " . mysqli_error($connect));
}

/* ===============================
   FETCH PENDING PARTICIPANTS
================================ */
$sql = "
SELECT 
    u.user_id,
    u.user_name,
    u.email,
    u.phone,
    u.status,
    u.role,
    w.workshop_name
FROM users u
LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
WHERE u.status = 0 AND u.role = 1
ORDER BY u.user_id DESC
";

$usersResult = mysqli_query($connect, $sql);

if (!$usersResult) {
    die("Users Query Error: " . mysqli_error($connect));
}
$rowCountUsers = mysqli_num_rows($usersResult);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
    <meta property="og:image" content="./assets/images/seo/itPanel.png" />
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
    <link rel="stylesheet" href="./assets/css/itPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SCCI - IT Panel</title>
</head>

<body>
    <?php include('./includes/nav.php'); ?>
    <main>
        <h1>IT Panel</h1>
    <hr>
        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by name, email, or phone...">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
        </div>

        <!-- Filters -->
        <div class="filter-container">
            <select id="workshopFilter">
                <option value="">All Workshops</option>
                <?php while ($ws = mysqli_fetch_assoc($workshops)) { ?>
                    <option value="<?= htmlspecialchars($ws['workshop_name']) ?>">
                        <?= htmlspecialchars($ws['workshop_name']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="userTableScroll" id="userTableScroll">
            <table class="userTable">
                <thead class="tableHead">
                    <tr class="tableHeaderRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Workshop</th>
                        <th class="tableHeader">Phone</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php
                    $hasUsers = false;
                    if ($usersResult) {
                        mysqli_data_seek($usersResult, 0);
                        while ($rowUser = mysqli_fetch_assoc($usersResult)) {
                            $hasUsers = true;
                            ?>
                            <tr class="tableRow" data-workshop="<?= htmlspecialchars($rowUser['workshop_name'] ?? 'N/A') ?>">
                                <td class="tableData">
                                    <?= htmlspecialchars($rowUser['user_name'] ?? '') ?>
                                </td>
                                <td class="tableData">
                                    <?= htmlspecialchars($rowUser['email'] ?? '') ?>
                                </td>
                                <td class="tableData">
                                    <?= htmlspecialchars($rowUser['workshop_name'] ?? 'N/A') ?>
                                </td>
                                <td class="tableData">
                                    <?= htmlspecialchars($rowUser['phone'] ?? '') ?>
                                </td>

                                <td class="tableData">
                                    <a href="itPanel.php?accept=<?= $rowUser['user_id'] ?>" class="btn btn-secondary accept">
                                        Accept
                                    </a>

                                <a href="itPanel.php?delete=<?= (int)$rowUser['user_id'] ?>"
                                 class="btn btn-primary block js-delete">
                                         Delete
                                    </a>

                                </td>
                            </tr>
                        <?php }
                    }
                    if (!$hasUsers) {
                        echo '<tr><td colspan="5" class="tableData" style="text-align: center;">No pending participants found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

                        <div class="deleteConfirmPopup" id="deleteConfirmPopup" style="display:none;">
            <div class="confirmCard">
                <div class="confirmHeader">
                <i class="fas fa-trash-alt" id="confirmIcon"></i>
                <h3 id="deleteConfirmTitle">Delete Participant?</h3>
                </div>

                <p id="deleteConfirmMsg">This action cannot be undone.</p>

                <div class="confirmBtnGroup">
                <button type="button" class="btn btn-confirm-cancel" id="cancelDeleteBtn">Cancel</button>
                <button type="button" class="btn btn-confirm-delete" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
            </div>


            <div class="acceptConfirmPopup" id="acceptConfirmPopup">
            <div class="confirmCard">
                <div class="confirmHeader">
                <i class="fas fa-user-check"></i>
                <h3>Accept Participant?</h3>
                </div>

                <p id="deleteConfirmMsg">
                This participant will be added to the workshop.
                </p>

                <div class="confirmBtnGroup">
                <button class="btn btn-confirm-cancel" onclick="closeAcceptConfirm()">Cancel</button>
                <button class="btn btn-confirm-delete" id="acceptBtnConfirm">Accept</button>
                </div>
            </div>
            </div>

        </div>
        <div class="pagination-controls" id="itPagination">
            <button class="nav-arrow prev-btn" disabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>
    </main>
    <script src="assets/js/all.min.js"></script>
    <script src="assets/js/itPanel.js?v=<?= time() ?>"></script>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this user? This action cannot be undone.');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Pagination setup is now handled inside itPanel.js automatically or via explicit call if needed
        });
    </script>
</body>

</html>