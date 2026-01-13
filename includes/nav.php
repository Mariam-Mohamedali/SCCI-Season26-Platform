<?php
include(__DIR__ . '/config.php');

// Fetch user's profile image if logged in
$user_image = 'default.png'; // Default fallback
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $select_user_image = "SELECT image FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($connect, $select_user_image);
    if($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
            $user_image = $row['image'] ?? 'default.png';
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<head>
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/png">
    <!-- Irish Grover font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
</head>
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
            <img loading="lazy" src="/SCCI-Season26-Platform/assets/uploadedImages/' . htmlspecialchars($user_image) . '" alt="profile img">
        </a>';
        }else{
            echo '<a href="/SCCI-Season26-Platform/auth/login.php" id="loginNav">Log In</a>';
        }
        ?>
    </nav>
    <button class="sideBtn">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </button>
</header>

<!-- side navbar -->
<aside class="sideNav">
    <div class="sideNavLinks">
        <a href="/SCCI-Season26-Platform/home.php"><i class="fa-solid fa-house"></i> home</a>
        <a href="/SCCI-Season26-Platform/about.php"><i class="fa-solid fa-book-open"></i> about us</a>
        <a href="/SCCI-Season26-Platform/gallary.php"><i class="fa-solid fa-images"></i> gallery</a>
        <a href="/SCCI-Season26-Platform/workshops.php"><i class="fa-solid fa-graduation-cap"></i> workshops</a>
        <a href="/SCCI-Season26-Platform/crew.php"><i class="fa-solid fa-users"></i> crew</a>
        <?php
        if(isset($_SESSION['user_id'])){
            echo '<a href="/SCCI-Season26-Platform/profile.php"><i class="fa-solid fa-user"></i> Profile</a>';
        }else{
            echo '<a href="/SCCI-Season26-Platform/auth/login.php"><i class="fa-solid fa-user"></i> LogIn</a>';
        }
        ?>
        <hr>
        <?php if(isset($_SESSION['user_id'])): ?>
        <a href="/SCCI-Season26-Platform/profile.php" id="profileNav">
            <img loading="lazy" src="/SCCI-Season26-Platform/assets/uploadedImages/<?php echo htmlspecialchars($user_image); ?>" alt="profile img">
        </a>
        <?php endif; ?>
    </div>
</aside>
<script src="/SCCI-Season26-Platform/assets/js/index.js?v=<?php echo time(); ?>"></script>