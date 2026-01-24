<?php
include './includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
    <meta property="og:image" content="./assets/images/seo/crewDetails.png" />
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
    <link rel="stylesheet" href="./assets/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/root.css" />
    <link rel="stylesheet" href="./assets/css/crewDetails.css?v=<?php echo time(); ?>" />
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>SCCI - Crew Details</title>
  </head>

<body>
    <?php
    include('./includes/nav.php');

    if (isset($_GET['committee_id'])) {
        $committee_id = $_GET['committee_id'];

        // Fetch committee details
        $select_committee = "SELECT committe_name, head_id, committee_description, committee_member,missoin
                         FROM committees 
                         WHERE committee_id = '$committee_id'";
        $run_committee = mysqli_query($connect, $select_committee);
        $committee = mysqli_fetch_assoc($run_committee);

        // Fetch head details
        $head_id = $committee['head_id'];
        $select_head = "SELECT user_id, user_name, image 
                    FROM users 
                    WHERE user_id = '$head_id'";
        $run_head = mysqli_query($connect, $select_head);
        $head = mysqli_fetch_assoc($run_head);

        // ✅ FIXED MEMBERS QUERY
        $select_members = "
        SELECT u.*, w.workshop_name
        FROM users u
        LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
        WHERE u.committee_id = '$committee_id'
        AND u.status = 1
        AND u.user_id != '$head_id'
    ";
        $members = mysqli_query($connect, $select_members);
    }
    ?>
    <!-- Back Button -->
    <a href="crew.php" class="backBtn">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Committee Details Section -->
    <section class="sectionBlock container">
        <div class="titleWrapper">
            <h1 class="mainTitle" data-aos="zoom-in">
                <span class="textPrimary"><?php echo $committee['committe_name']; ?></span>
                <span class="textDark">Head</span>
            </h1>
            <hr data-aos="fade-up" data-aos-duration="1000">
        </div>

        <div class="headLayout">
            <a href="ViewProfile.php?user_id=<?= $head['user_id'] ?>" class="memberCardLink">
                <div class="flipCard headCard smCard" data-aos="flip">
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="Head" />
                        </div>
                        <div class="flipSide flipBack" data-title="HEAD">
                            <div class="backCard">
                                <div class="memberImageContainer">
                                    <img src="./assets/uploadedImages/SCCI Board/<?php echo $head['image']; ?>"
                                        class="memberImage" alt="<?php echo $head['user_name']; ?>">
                                </div>
                                <div class="memberName">
                                    <h3><?php echo $head['user_name']; ?></h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <div class="paperScroll" data-aos="fade-left">
                <div class="paperScrollHeader">
                    <h3 class="paperScrollTitle">Job Description</h3>
                </div>
                <div class="paperContent">
                    <p class="paperText">
                        <?php
                        // Normalize text and split by periods to handle sentence-based lists
                        $raw_text = $committee['missoin'];
                        $mission_items = explode('.', $raw_text); 
                        
                        foreach ($mission_items as $item) {
                            $item = trim($item);
                            // Filter out empty items
                            if (!empty($item)) {
                                echo '<span>⚜ </span>' . htmlspecialchars($item) . '.<br>';
                            }
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="sectionBlock container">
        <div class="titleWrapper">
            <h1 class="mainTitle" data-aos="fade-up">
                <span class="textPrimary"><?php echo $committee['committe_name']; ?></span>
                <span class="textDark">Members</span>
            </h1>
            <div class="sectionDivider"></div>
        </div>
        <hr data-aos="fade-up" data-aos-duration="1000">

        <div class="membersGrid">
            <?php
            $membersList = [];

            if ($members && mysqli_num_rows($members) > 0) {
                while ($row = mysqli_fetch_assoc($members)) {
                    $membersList[] = $row;
                }
            }

            foreach ($membersList as $member) {
                ?>
                <a href="ViewProfile.php?user_id=<?= $member['user_id'] ?>" class="memberCardLink">
                    <div class="flipCard memberCard smCard" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront">
                                <img src="./assets/img/crew/backCardCrew.png" loading="lazy" />
                            </div>

                            <div class="flipSide flipBack"
                                data-title="<?= strtoupper(htmlspecialchars($member['workshop_name'])) ?>">
                                <div class="backCard">
                                    <div class="memberInfo">
                                        <div class="memberImageContainer">
                                            <img src="assets/uploadedImages/<?= htmlspecialchars($member['Image']) ?>"
                                                alt="<?= htmlspecialchars($member['user_name']) ?>" class="memberImage"
                                                loading="lazy">
                                        </div>

                                        <div class="memberName">
                                            <h5><?= htmlspecialchars($member['user_name']) ?></h5>
                                        </div>

                                        <div class="memberTitle">
                                            <p><?= htmlspecialchars($committee['committee_member']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>


    </section>

    <!-- Scroll Top Button -->
    <div class="scrollTopBtn" id="scrollTopBtn">
        &#8593;
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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
    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/crew.js"></script>
    <script src="./assets/js/all.min.js"></script>
</body>
<?php include './includes/footer.php'; ?>

</html>