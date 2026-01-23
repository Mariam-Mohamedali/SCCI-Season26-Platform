<?php
include(__DIR__ . '/config.php');


// Fetch user's profile image if logged in
$user_image = 'default.png'; // Default fallback
$role = 0;
$committeeId = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'] ?? 0;
    $committeeId = $_SESSION['committee_id'] ?? 0;
    $select_user_image = "SELECT image, role, committee_id FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($connect, $select_user_image);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $user_image = $row['image'] ?? 'default.png';
            $role = $row['role']; // Fetch role from DB to ensure it's available
            $committeeId = $row['committee_id'] ?? 0; // Fetch committee_id from DB

            // Add SCCI Board prefix for role 4 users
            if ($role == 4 or $role == 5) {
                $user_image = 'SCCI Board/' . $user_image;
            }
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
<header data-aos="fade-down" data-aos-duration="800" data-aos-once="true">
    <a href="/SCCI-Season26-Platform/home.php" class="logo">
        <img src="/SCCI-Season26-Platform/assets/icons/logoSCCI.png" alt="SCCI logo" loading="lazy" />
        <h1 id="logo">SCCI</h1>
    </a>
    <nav class="navLinks navRespnsive">
        <a href="/SCCI-Season26-Platform/home.php" id="homeNavLine">home</a>
        <a href="/SCCI-Season26-Platform/about.php" id="aboutNavLine">about us</a>
        <a href="/SCCI-Season26-Platform/gallary.php" id="galleryNavLine">gallery</a>
        <a href="/SCCI-Season26-Platform/workshops.php" id="workshopsNavLine">workshops</a>
        <a href="/SCCI-Season26-Platform/crew.php" id="crewNavLine">crew</a>
        
        <?php
        if ($role == 2 || $role == 1 || $role == 4 || $committeeId == 6) {
           echo '<div class="nav-separator"></div>';
        }
        ?>

        <?php
        if ($role == 2) {
            echo '<a href="/SCCI-Season26-Platform/memberWorkshopPanel.php" id="homeNavLine">member panel</a>';
        }
        ?>
        <?php
        if ($role == 1) {
            echo '<a href="/SCCI-Season26-Platform/participantWorkshopPanel.php" id="homeNavLine">participant panel</a>';
        }
        ?>
        <?php
        if ($role == 5) {
            echo '<a href="/SCCI-Season26-Platform/headPanel.php" id="homeNavLine">head panel</a>';
        }
        ?>
        <?php
         if ($role == 5 or $role == 4) {
            echo '<a href="/SCCI-Season26-Platform/contactPanel.php" id="homeNavLine">contact panel</a>';
        
        }
        ?>
        <?php
        if ($committeeId == 6) {
            echo '<a href="/SCCI-Season26-Platform/itPanel.php" id="homeNavLine">IT panel</a>';
        }
        ?>
    </nav>
    <nav class="navAccount navRespnsive">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="/SCCI-Season26-Platform/profile.php" id="profileNav">
            <img loading="lazy" src="/SCCI-Season26-Platform/assets/img/profilePhoto.png" alt="profile img">
        </a>';
        } else {
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
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="/SCCI-Season26-Platform/auth/login.php"><i class="fa-solid fa-user"></i> LogIn</a>';
        }
        ?>
        <hr>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php
            if ($role == 2) {
                echo '<a href="/SCCI-Season26-Platform/memberWorkshopPanel.php"><i class="fa-solid fa-user-group"></i> member panel</a>';
            }
            ?>
            <?php
            if ($role == 1) {
                echo '<a href="/SCCI-Season26-Platform/participantWorkshopPanel.php"><i class="fa-solid fa-user-graduate"></i> participant panel</a>';
            }
            ?>
            <?php
            if ($role == 4) {
                echo '<a href="/SCCI-Season26-Platform/contactPanel.php"><i class="fa-solid fa-address-book"></i> contact panel</a>';
                echo '<a href="/SCCI-Season26-Platform/headPanel.php"><i class="fa-solid fa-user-tie"></i> head panel</a>';
            }
            ?>
            <?php
            if ($committeeId == 6) {
                echo '<a href="/SCCI-Season26-Platform/itPanel.php"><i class="fa-solid fa-screwdriver-wrench"></i> IT panel</a>';
            }
            ?>

            <a href="/SCCI-Season26-Platform/profile.php" id="profileNav">
                <img loading="lazy"
                    src="/SCCI-Season26-Platform/assets/img/profilePhoto.png"
                    alt="profile img">
            </a>
        <?php endif; ?>
    </div>
</aside>
<script src="/SCCI-Season26-Platform/assets/js/index.js?v=<?php echo time(); ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get current path
        const currentPath = window.location.pathname;

        // Select all links in the main navigation and side navigation
        const navLinks = document.querySelectorAll('.navLinks a, .sideNavLinks a');

        navLinks.forEach(link => {
            // Get the href attribute of the link
            const linkHref = link.getAttribute('href');

            // Check if the current path matches the link's href
            // We use includes() to handle potential relative paths or query parameters if needed
            // But strict equality or endsWith is safer for navigation highlighting.
            // Adjust logic: if href ends with current path or matches exactly.
            
            if (currentPath.endsWith(linkHref) || (linkHref !== '/' && currentPath.includes(linkHref))) {
                 link.classList.add('active');
            }
        });
    });
</script>