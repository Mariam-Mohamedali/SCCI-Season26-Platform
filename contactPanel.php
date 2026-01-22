<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI - Contact Panel</title>
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stencil&display=swap" rel="stylesheet">


    <!-- css -->
    <link rel="stylesheet" href="./assets/css/contactPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    include('./includes/nav.php');

    $result = mysqli_query(
        $connect,
        "SELECT * FROM contact_us ORDER BY contactUs_id DESC"
    );
    ?>
    <main>
        <h1>Contact Panel</h1>
        <div class="contactTableScroll" id="contactTableScroll">
            <table class="contactTable">
                <thead class="TableHead">
                    <tr class="tableRow">
                        <th class="tableHeader">Full Name</th>
                        <th class="tableHeader">Email</th>
                        <th class="tableHeader">Message</th>
                    </tr>
                </thead>
                <tbody class="tableBody">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="tableRow">
                            <td class="tableData"><?= $row['name'] ?></td>
                            <td class="tableData email-text"><?= $row['email'] ?></td>
                            <td class="tableData">
                                <P class="cell-content">
                                    <?= $row['text'] ?>
                                </P>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-controls" id="contactPagination">
            <button class="nav-arrow prev-btn" disabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"><i class="fa-solid fa-caret-right"></i></button>
        </div>
    </main>
    <script src="./assets/js/all.min.js"></script>
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
    <script src="assets/js/pagination.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setupPagination('contactTableScroll', 'contactPagination');
        });
    </script>
</body>

</html>
