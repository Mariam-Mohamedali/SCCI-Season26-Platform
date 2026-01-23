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


if (isset($_GET['accept'])) {
    $id = intval($_GET['accept']);
    mysqli_query($connect, "UPDATE users SET status = 1 WHERE user_id = $id");
    header("Location: itPanel.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Fetch image before deletion
    $result = mysqli_query($connect, "SELECT image FROM users WHERE user_id = $id");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $image_path = './assets/uploadedImages/' . $row['image'];
        if (file_exists($image_path) && $row['image'] != 'default.png') {
            unlink($image_path);
        }
    }

    mysqli_query($connect, "DELETE FROM users WHERE user_id = $id");
    header("Location: itPanel.php");
    exit();
}

// Fetch all workshops for filter
$workshops = mysqli_query($connect, "SELECT * FROM workshops");

$result = mysqli_query(
    $connect,
    "SELECT u.*, w.workshop_name 
     FROM users u 
     LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
     WHERE u.status ='0' 
     ORDER BY u.user_id DESC"
);
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

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by name, email, or phone...">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
        </div>

        <!-- Workshop Filter -->
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
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Workshop</th>
                        <th class="tableHeader">phone</th>
                        <th class="tableHeader">status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="tableRow" data-workshop="<?= htmlspecialchars($row['workshop_name'] ?? '') ?>">

                            <td class="tableData"><?= $row['user_name'] ?></td>
                            <td class="tableData"><?= $row['email'] ?></td>
                            <td class="tableData"><?= htmlspecialchars($row['workshop_name'] ?? 'N/A') ?></td>
                            <td class="tableData"><?= $row['phone'] ?></td>

                            <td class="tableData">
                                <?= ($row['status'] == 0) ? 'User Blocked' : 'Active'; ?>
                            </td>

                            <td class="tableData">

                                <a href="itPanel.php?accept=<?= $row['user_id'] ?>" class="btn accept">
                                    Accept
                                </a>

                                <a href="itPanel.php?delete=<?= $row['user_id'] ?>" class="btn block">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-controls" id="itPagination">
            <button class="nav-arrow prev-btn" disabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>
    </main>
    </main>
    <script src="assets/js/all.min.js"></script>
    <script src="assets/js/itPanel.js?v=<?= time() ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
             // Pagination setup is now handled inside itPanel.js automatically or via explicit call if needed
        });
    </script>
</body>

</html>