<?php
include('./includes/nav.php');

$result = mysqli_query(
    $connect,
    "SELECT * FROM contact_us ORDER BY contactUs_id DESC"
);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stencil&display=swap" rel="stylesheet">


    <!-- css -->
    <link rel="stylesheet" href="./assets/css/contactPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main>
        <h1>Contact Panel</h1>
        <div class="contactTableScroll">
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
                            <td class="tableData"><?= $row['email'] ?></td>
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
    </main>
</body>

</html>
