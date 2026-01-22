<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stencil&display=swap" rel="stylesheet">


    <!-- css -->
    <link rel="stylesheet" href="./assets/css/itPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    include('./includes/nav.php');

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

    $result = mysqli_query(
        $connect,
        "SELECT * FROM users where status ='0' ORDER BY user_id DESC"
    );
    ?>
    <main>
        <h1>Contact Panel</h1>
        <div class="userTableScroll" id="userTableScroll">
            <table class="userTable">
                <thead class="tableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">phone</th>
                        <th class="tableHeader">status</th>
                        <th class="tableHeader">Action</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="tableRow">

                            <td class="tableData"><?= $row['user_name'] ?></td>
                            <td class="tableData"><?= $row['email'] ?></td>
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
    <script src="assets/js/pagination.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setupPagination('userTableScroll', 'itPagination'); 
        });
    </script>
</body>

</html>