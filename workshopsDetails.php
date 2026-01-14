<?php
include('./includes/nav.php');
if (isset($_GET['category_id'])) {
    $workshop_id = $_GET['category_id'];
    $select_workshop = "SELECT * FROM `workshops` WHERE `workshop_id` = '$workshop_id'";
    $run_workshop = mysqli_query($connect, $select_workshop);

    $select_members = "SELECT * FROM `users` WHERE `workshop_id` = '$workshop_id' && `status` = 1";
    $run_members = mysqli_query($connect, $select_members);


    $select_spill = "SELECT * FROM `spells`  WHERE `workshop_id` = '$workshop_id'";
    $run_spill = mysqli_query($connect, $select_spill);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php foreach ($run_workshop as $workshops) { ?>
    <title>SCCI - <?php echo $workshops['workshop_name']; ?></title>
    <?php } ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Irish+Grover&display=swap"
        rel="stylesheet">

     <!-- site icon -->


    <!-- Font Awesome (Standard CDN) -->
    <link rel="stylesheet" href="assets/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/workshops.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/workshopsDetails.css?v=<?php echo time(); ?>">
    <!-- Custom Page Styles -->

    <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->


    <main>

        <!-- Description for workshop -->
        <?php foreach ($run_workshop as $workshops) { ?>
            <section class="workshopsHero">

                <div class="magicDivider" data-aos="fade-down" data-aos-duration="1000">
                    <h2 class="heroTitle"><?php echo $workshops['workshop_name']; ?></h2>
                </div>

                <a href="workshops.php" class="backBtn">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="workshopDescription">
                    <div data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                        <img class="workshopImage"
                            src="assets/img/workshop-icons/<?php echo $workshops['workshop_icon']; ?>"
                            alt="<?php echo $workshops['workshop_name']; ?>" loading="lazy">
                    </div>

                    <p class="workshopDetails" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                        <?php echo $workshops['visson']; ?> </p>

                </div>
            <?php } ?>
        </section>

        <!-- Workshop Journey Section -->
        <section class="workshopJourneySection" data-aos="fade-up" data-aos-duration="1000">
            <div class="container">
                <h2 class="heroTitle"><?php echo $workshops['workshop_name']; ?> <span>Spell Journey</span></h2>
                <hr>
                <div class="journeyContainer">
                    <?php foreach ($run_spill as $workshops) { ?>
                        <!-- Navigation Buttons (Left Side) -->
                        <div class="journeyNav">
                            <button class="journeyBtn active" data-content="opening"><?php echo $workshops['button1']; ?>
                            </button>
                            <button class="journeyBtn" data-content="core1"><?php echo $workshops['button2']; ?></button>
                            <button class="journeyBtn" data-content="core2"><?php echo $workshops['button3']; ?></button>
                            <button class="journeyBtn" data-content="core3"><?php echo $workshops['button4']; ?></button>
                        </div>
                    <?php } ?>

                    <!-- Content Card Display (Right Side) -->
                    <div class="journeyCard">
                        <div class="cardContentWrapper">
                            <!-- Opening Spell Content (Default) -->
                            <div class="contentBlock active" id="opening">
                                <?php foreach ($run_spill as $workshops) { ?>
                                    <h3><?php echo $workshops['button1']; ?> </h3>
                                    <p><?php echo $workshops['opening_spell']; ?></p>
                                </div>
                                <div class="contentBlock" id="core1">
                                    <h3><?php echo $workshops['button2']; ?> </h3>
                                    <p><?php echo $workshops['core_magic']; ?></p>
                                </div>
                                <div class="contentBlock" id="core2">
                                    <h3><?php echo $workshops['button3']; ?> </h3>
                                    <p><?php echo $workshops['advanced_spell']; ?></p>
                                </div>
                                <div class="contentBlock" id="core3">
                                    <h3><?php echo $workshops['button4']; ?> </h3>
                                    <p><?php echo $workshops['final_quest']; ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!--  -->


        <!-- members in this workshop -->

        <section class="workshopsSection" data-aos="fade-up" data-aos-duration="1000">

            <div class="MemberCardTitle" data-aos="zoom-in" data-aos-duration="800">
                <h2 class="heroTitle">Members</h2>
                <hr>
            </div>

            <div class="container">
                <div class="workshopDetailsGrid">
                    <?php foreach ($run_members as $members) { ?>
                        <!--  member card  -->
                        <a href="profile.php?user_id=<?php echo $members['user_id']; ?>" class="memberCardLink">
                            <div class="cardsContainer" data-aos="flip">
                                <div class="flipCard card1">
                                    <div class="frontCard">
                                        <img src="assets/img/crew/backCardCrew.png" alt="<?php echo $members['user_name']; ?>"
                                            loading="lazy">
                                    </div>
                                    <div class="backCard">
                                        <div class="memberInfo">
                                            <div class="memberImageContainer">
                                                <img src="assets/uploadedImages/<?php echo $members['Image']; ?>"
                                                    alt="<?php echo $members['user_name']; ?>" loading="lazy"
                                                    class="memberImage">
                                            </div>
                                            <div class="memberName">
                                                <h3><?php echo $members['user_name']; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>







                </div>
            </div>
        </section>

    </main>

    <!-- Scroll to Top Button -->
    <div class="scrollTopBtn" id="scrollTopBtn">
        <i class="fas fa-arrow-up"></i>
    </div>









    <!-- Scripts -->
    <script src="assets/js/all.min.js" defer></script>
    <script src="assets/js/workshops.js" defer></script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({

            once: true,

            offset: 100,

            easing: 'ease-in-out',
        });
    </script>
</body>
<?php include 'includes/footer.php'; ?>
</html>
