<?php
include('./includes/config.php');

$select = "SELECT * FROM `workshops` ";
$result = mysqli_query($connect, $select);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshops</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Irish+Grover&display=swap"
        rel="stylesheet">
    <!-- Icons -->
    <!-- Font Awesome (Standard CDN) -->
    <link rel="stylesheet" href="assets/css/all.min.css" />
    <!-- Styles -->
    <link rel="stylesheet" href="assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/workshops.css?v=<?php echo time(); ?>">
    <!-- Custom Page Styles -->
</head>

<body>

    <!-- Navigation -->
    <?php include 'includes/nav.php'; ?>
    <!-- Hero Section -->
    <header class="workshops-hero">
        <div class="container">
            <h1 class="hero-title">DISCOVER THE <span>MAGIC WORKSHOPS</span></h1>
            <p class="hero-subtitle">EACH WORKSHOP UNLOCKS A NEW SKILL</p>

            <div class="magic-divider">
                <i class="fas fa-gem magic-icon"></i> <!-- Diamond/Star Icon -->
                <span>EXPLORE WORKSHOPS</span>
                <i class="fas fa-hat-wizard magic-icon"></i> <!-- Wizard Hat Icon -->
            </div>
        </div>
    </header>

    <!-- Workshops Grid -->
    <section class="workshops-section">
        <div class="container">
            <div class="workshop-cards-grid">
                <?php foreach ($result as $workshops) { ?>

                    <!-- Workshop Card 1: TechSolve -->
                    <div class="workshop-card" onclick="window.location.href='workshopsDetails.php?id=techsolve'">
                        <img src="assets/img/<?php echo $workshops['workshop_image']; ?>"
                            alt="<?php echo $workshops['workshop_name'] ?>" class="card-bg" loading="lazy">

                        <div class="card-content">
                            <a href="workshopsDeatials.php?category_id=<?php echo $workshops['workshop_id'] ?>"
                                class="btn btn-primary btn-sm">Explore More</a>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </section>
    <hr>

    <!-- Scroll To Top -->
    <div class="scroll-top-btn" id="scrollTopBtn">
        <i class="fa-solid fa-arrow-up"></i>
    </div>

    <!-- Scripts -->
    <script src="assets/js/all.min.js"></script>
    <script src="assets/js/workshops.js"></script>
</body>

</html>