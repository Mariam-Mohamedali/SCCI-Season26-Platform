<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- almendra font -->
    <link href="https://fonts.googleapis.com/css2?family=Almendra:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet" />

    <!-- site icon -->
    <link rel="icon" type="image/png" href="../assets/icons/logoSCCI.png" />

    <!-- css other link -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/root.css">
    <!-- css page link -->
    <link rel="stylesheet" href="../assets/css/nav.css" />

    <title></title>
</head>

<body>

    <!-- navbar ----------------------------------------------------------------- -->
    <header>
        <a href="home.css" class="logo">
            <img src="../assets/icons/logoSCCI.png" alt="SCCI logo" loading="lazy" />
            <h1>SCCI</h1>
            <!-- <a target="_blank" href="https://www.facebook.com/scci.cu"><i class="fa-brands fa-facebook"></i> <span class="socialText"> facebook page</span></a> -->
        </a>

        <nav class="navLinks navRespnsive">
            <a href="../home.php" id="homeNavLine">home</a>
            <a href="../about.php" id="aboutNavLine">about us</a>
            <a href="../gallary.php" id="galleryNavLine">gallery</a>
            <a href="../workshops.php" id="workshopsNavLine">workshops</a>
            <a href="../crew.php" id="crewNavLine">crew</a>

        </nav>

        <nav class="navAccount navRespnsive">
            <a href="../auth/login.php" id="loginNav">Log In</a>
            <!-- profile -->
            <a href="../profile.php" id="profileNav">
                <img loading="lazy" src="../assets/img/profilePhoto.png" alt="profile img">
            </a>
        </nav>


        <!-- side navbar btn -->
        <button class="sideBtn"><i class="fa-solid fa-bars sideBars"></i></button>
    </header>

    <!-- side navbar -->
    <aside class="sideNav">
        <div class="sideNavLinks">

            <p class="closeNav">X</p>
            <hr>
            <a href="../home.php"><i class="fa-solid fa-house"></i> home</a>
            <a href="../about.php"><i class="fa-solid fa-book-open"></i> about us</a>
            <a href="../gallary.php"><i class="fa-solid fa-images"></i> gallery</a>
            <a href="../workshops.php"><i class="fa-solid fa-graduation-cap"></i> workshops</a>
            <a href="../crew.php"><i class="fa-solid fa-users"></i> crew</a>
            <!-- login -->
            <a href="../auth/login.php" src="../"><i class="fa-solid fa-user"></i> LogIn</a>
            <!-- profile -->
            <hr>
            <a href="../profile.php" id="profileNav">
                <img loading="lazy" src="../assets/img/profilePhoto.png" alt="profile img">
            </a>
        </div>
    </aside>

    <!-- navbar js -->
     
    <script src="../assets/js/nav.js" defer></script>

    <script src="../assets/js/all.min.js" defer></script>

</body>

</html>
