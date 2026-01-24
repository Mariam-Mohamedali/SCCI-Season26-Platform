<?php
include './includes/config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location:./auth/login.php");
  exit;
}

if (!in_array($_SESSION['role'], [4, 5])) {
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
    <meta property="og:image" content="./assets/images/seo/contactPanel.png" />
    <meta property="og:title" content="SCCI`26" />
    <meta
      property="og:description"
      content="SCCI is the university's premier student community, uniting creative minds to build the future of tech, media, business, and entrepreneurship."  
    />
    <meta
      name="keywords"
      content="SCCI, Student Community, Creative Minds, Tech, Media, Business, Entrepreneurship, University, Community, College"
    />
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <!-- css -->
    <link rel="stylesheet" href="./assets/css/contactPanel.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SCCI - Contact Panel</title>
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
        <h1 data-aos="fade-up" data-aos-duration="1000">Contact Panel</h1>
        <hr data-aos="fade-up" data-aos-duration="2000">
        <div data-aos="fade-up" data-aos-duration="3000" class="contactTableScroll" id="contactTableScroll">
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
            <button class="nav-arrow prev-btn" enabled><i class="fa-solid fa-caret-left"></i></button>
            <span class="page-info">Page 1</span>
            <button class="nav-arrow next-btn"enabled><i class="fa-solid fa-caret-right"></i></button>
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
