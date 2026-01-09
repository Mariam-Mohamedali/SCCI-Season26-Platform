<?php
include(__DIR__ . '/config.php');

?>
<header>
    <a href="/SCCI-Season26-Platform/home.php" class="logo">
        <img src="/SCCI-Season26-Platform/assets/icons/logoSCCI.png" alt="SCCI logo" loading="lazy" />
        <h1>SCCI</h1>
    </a>
    <nav class="navLinks navRespnsive">
        <a href="/SCCI-Season26-Platform/home.php" id="homeNavLine">home</a>
        <a href="/SCCI-Season26-Platform/about.php" id="aboutNavLine">about us</a>
        <a href="/SCCI-Season26-Platform/gallary.php" id="galleryNavLine">gallery</a>
        <a href="/SCCI-Season26-Platform/workshops.php" id="workshopsNavLine">workshops</a>
        <a href="/SCCI-Season26-Platform/crew.php" id="crewNavLine">crew</a>
    </nav>
    <nav class="navAccount navRespnsive">
        <?php
        if(isset($_SESSION['user_id'])){
            echo '<a href="/SCCI-Season26-Platform/profile.php" id="profileNav">
            <img loading="lazy" src="/SCCI-Season26-Platform/assets/img/profilePhoto.png" alt="profile img">
        </a>';
        }else{
            echo '<a href="/SCCI-Season26-Platform/auth/login.php" id="loginNav">Log In</a>';
        }
        ?>
    </nav>
    <button class="sideBtn"><i class="fa-solid fa-bars sideBars"></i></button>
</header>

<!-- side navbar -->
<aside class="sideNav">
    <div class="sideNavLinks">
        <p class="closeNav">X</p>
        <hr>
        <a href="/SCCI-Season26-Platform/home.php"><i class="fa-solid fa-house"></i> home</a>
        <a href="/SCCI-Season26-Platform/about.php"><i class="fa-solid fa-book-open"></i> about us</a>
        <a href="/SCCI-Season26-Platform/gallary.php"><i class="fa-solid fa-images"></i> gallery</a>
        <a href="/SCCI-Season26-Platform/workshops.php"><i class="fa-solid fa-graduation-cap"></i> workshops</a>
        <a href="/SCCI-Season26-Platform/crew.php"><i class="fa-solid fa-users"></i> crew</a>
        <a href="/SCCI-Season26-Platform/auth/login.php"><i class="fa-solid fa-user"></i> LogIn</a>
        <hr>
        <a href="/SCCI-Season26-Platform/profile.php" id="profileNav">
            <img loading="lazy" src="/SCCI-Season26-Platform/assets/img/profilePhoto.png" alt="profile img">
        </a>
    </div>
</aside>

<script src="/SCCI-Season26-Platform/assets/js/nav.js" defer></script>
