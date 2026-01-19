<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI - Workshops</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Irish+Grover&display=swap"
        rel="stylesheet">

    <!-- site icon -->
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/png">


    <!-- Font Awesome (Standard CDN) -->
    <link rel="stylesheet" href="assets/css/all.min.css" />

    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/workshops.css?v=<?php echo time(); ?>">
    <!-- Custom Page Styles -->
    <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body>
    <?php
    include('./includes/nav.php');

    $select = "SELECT * FROM `workshops` ";
    $result = mysqli_query($connect, $select);
    ?>
    <!-- Navigation -->

    <!-- Hero Section -->
    <section class="workshopsHero">
        <div class="container">
            <h1 class="heroTitle" data-aos="fade-down" data-aos-duration="1000">DISCOVER THE <span>MAGIC WORKSHOPS</span></h1>
            <p class="heroSubtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">EACH WORKSHOP UNLOCKS A NEW SKILL</p>

            <div class="magicDivider" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="400">
                <i class="fas fa-gem magic-icon"></i> <!-- Diamond/Star Icon -->
                <span>EXPLORE WORKSHOPS</span>
                <i class="fas fa-hat-wizard magic-icon"></i> <!-- Wizard Hat Icon -->
            </div>
        </div>
    </section>
    <main>
        <!-- Workshops Grid -->
        <section class="workshopsSection">
            <div class="container">
                <div class="workshopCardsGrid">
                    <?php
                    $count = 0;
                    foreach ($result as $workshop) {
                        if ($count >= 4) break; // show only 4 workshops
                    ?>
                        <div class="cardsContainer" data-aos="flip">
                            <div class="flipCard">
                                <!-- Front -->
                                <div class="frontCard">
                                    <img src="assets/img/crew/backCardCrew.png"
                                        alt="<?php echo $workshop['workshop_name']; ?>" loading="lazy">
                                </div>

                                <!-- Back -->
                                <div class="backCard">
                                    <div class="card2">
                                        <div class="corner-ornament top-left"></div>
                                        <div class="corner-ornament top-right"></div>
                                        <div class="corner-ornament bottom-left"></div>
                                        <div class="corner-ornament bottom-right"></div>

                                        <div class="card-content">

                                            <div class="card-image">
                                                <img
                                                    src="./assets/img/workshop-icons/<?php echo $workshop['workshop_icon']; ?>"
                                                    alt="<?php echo htmlspecialchars($workshop['workshop_name']); ?>">
                                            </div>

                                            <h4 class="card-title"><?php echo $workshop['workshop_name']; ?></h4>

                                            <div class="divider"></div>

                                            <p class="card-text">
                                                <?php echo $workshop['workshop_description']; ?>
                                            </p>
                                            <div class="divider"></div>
                                            <a href="workshopsDetails.php?category_id=<?php echo $workshop['workshop_id']; ?>"
                                                class="btn btn-primary btn-sm exploreBtn">
                                                Explore More
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    } ?>
                </div>
            </div>
        </section>

        <!-- Scroll To Top -->
        <div class="scrollTopBtn" id="scrollTopBtn">
            <i class="fa-solid fa-arrow-up"></i>
        </div>



    </main>

    <?php include 'includes/footer.php'; ?>

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

</html>
