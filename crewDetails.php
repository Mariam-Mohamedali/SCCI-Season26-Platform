<?php
include('./includes/nav.php');

if(isset($_GET['committee_id'])) {
    $committee_id = $_GET['committee_id'];

    // Fetch committee details
    $select_committee = "SELECT committe_name, head_id, committee_description FROM committees WHERE committee_id = '$committee_id'";
    $run_committee = mysqli_query($connect, $select_committee);
    $committee = mysqli_fetch_assoc($run_committee);

    // Fetch head details
    $head_id = $committee['head_id'];
    $select_head = "SELECT user_name, image FROM users WHERE user_id = '$head_id'";
    $run_head = mysqli_query($connect, $select_head);
    $head = mysqli_fetch_assoc($run_head);

    // Fetch members
    $select_members = "SELECT * FROM users u JOIN workshops w ON u.workshop_id = w.workshop_id WHERE u.committee_id = '$committee_id' AND u.user_id != '$head_id' And status=1 " ;
    $members = mysqli_query($connect, $select_members);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SCCI - CrewDetails</title>
    <link rel="stylesheet" href="./assets/css/all.min.css" />
    <link rel="stylesheet" href="./assets/css/root.css" />
    <link rel="stylesheet" href="./assets/css/crewDetails.css" />
     <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
</head>

<body>

      <!-- Back Button -->
    <a href="crew.php" class="backBtn">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Committee Details Section -->
    <section class="sectionBlock container">
        <div class="titleWrapper" >
            <h1 class="mainTitle">
                <span class="textPrimary"><?php echo $committee['committe_name']; ?></span>
                <span class="textDark">Head</span>
            </h1>
            <div class="sectionDivider"></div>
        </div>

        <div class="headLayout">
            <a href="profile.php?user_id=<?php echo $head_id; ?>" class="memberCardLink">
                <div class="flipCard headCard smCard" >
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="Head" />
                        </div>
                        <div class="flipSide flipBack">
                            <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/<?php echo $head['image']; ?>" class="memberImage" alt="<?php echo $head['user_name']; ?>">
                                    </div>
                                    <div class="memberName">
                                        <h3><?php echo $head['user_name']; ?></h3>
                                    </div>
                                   
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <div class="paperScroll" >
                <div class="paperContent">
                    <h2 class="paperTitle">Job Description</h2>
                    <p class="paperText">
               <?php echo $committee['committee_description']; ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="sectionBlock container">
        <div class="titleWrapper" >
            <h1 class="mainTitle">
                <span class="textPrimary"><?php echo $committee['committe_name']; ?></span>
                <span class="textDark">Members</span>
            </h1>
            <div class="sectionDivider"></div>
        </div>

        <div class="membersGrid">
           <?php foreach ($members as $member) { ?>
    <a href="profile.php?user_id=<?= $member['user_id'] ?>" class="memberCardLink">
        <div class="flipCard memberCard smCard" data-aos="flip">
            <div class="flipInner">
                <div class="flipSide flipFront">
                    <img src="./assets/img/crew/backCardCrew.png" loading="lazy" />
                </div>
                <div class="flipSide flipBack">
                    <div class="backCard">
                        <div class="memberInfo">
                            <div class="memberImageContainer">
                               <img src="assets/uploadedImages/<?php echo $member['Image']; ?>"
                                                    alt="<?php echo $member['user_name']; ?>" loading="lazy"
                                                    class="memberImage">
                            </div>
                            <div class="memberName">
                                <h5><?= htmlspecialchars($member['user_name']) ?></h5>
                            </div>
                            <div class="memberTitle">
                                <p><?= htmlspecialchars($member['workshop_name']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
<?php } ?>

    </section>

    <!-- Scroll Top Button -->
    <div class="scrollTopBtn" id="scrollTopBtn">
        &#8593;
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/crew.js"></script>
    <script src="./assets/js/all.min.js"></script>
</body>
<?php include './includes/footer.php'; ?>
</html>
