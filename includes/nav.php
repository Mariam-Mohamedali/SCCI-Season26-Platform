<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
    <link rel="stylesheet" href="../assets/css/navbar.css" />

    <title></title>
</head>

<body>

    <!-- navbar ----------------------------------------------------------------- -->
    <header>
        <a href="home.css" class="logo">
            <img src="../assets/icons/logoSCCI.png" alt="" loading="lazy" />
            <h1>SCCI</h1>
            <!-- <a target="_blank" href="https://www.facebook.com/scci.cu"><i class="fa-brands fa-facebook"></i> <span class="socialText"> facebook page</span></a> -->
        </a>

        <nav class="navLinks navRespnsive">
            <a href="home.html" id="homeNavLine" href="#">home</a>
            <a href="about.html" id="aboutNavLine">about us</a>
            <a href="gallery.html" id="galleryNavLine">gallery</a>
            <a href="workshops.html" id="workshopsNavLine">workshops</a>
            <a href="crew.html" id="crewNavLine">crew</a>

        </nav>

        <nav class="navAccount navRespnsive">
            <a href="login.html" id="loginNav" href="#">Log In</a>
            <!-- profile -->
            <a href="profile.html" id="profileNav">
                <img src="../assets/img/profilePhoto.png" alt="">
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
            <a href="home.html"><i class="fa-solid fa-house"></i> home</a>
            <a href="about us.html"><i class="fa-solid fa-book-open"></i> about us</a>
            <a href="gallery.html"><i class="fa-solid fa-images"></i> gallery</a>
            <a href="workshops.html"><i class="fa-solid fa-graduation-cap"></i> workshops</a>
            <a href="crew.html"><i class="fa-solid fa-users"></i> crew</a>
            <!-- login -->
            <a href="login.html"><i class="fa-solid fa-user"></i> LogIn</a>
            <!-- profile -->
            <hr>
            <a href="profile.html" id="profileNav">
                <img src="../assets/img/profilePhoto.png" alt="">
            </a>
        </div>
    </aside>

    <!-- navbar js -->
     
    <script src="../assets/js/navbar.js"></script>

    <script src="../assets/js/all.min.js"></script>

</body>

</html>
