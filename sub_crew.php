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
    <meta property="og:image" content="./assets/images/seo/crew.png" />
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
    <link rel="stylesheet" href="./assets/css/crew.css" />
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>SCCI - Sub Crew</title>
    <link rel="stylesheet" href="./assets/css/sub_crew.css" />
  </head>

<body>

    <?php
   include './includes/nav.php'; 

// Define names to fetch
$target_names = [
    'Marwan Wael',
    'Mohamed Hesham',
];

$names_string = "'" . implode("','", $target_names) . "'";
// Fetch IDs
$crew_ids = [];
$query = "SELECT user_id, user_name FROM users WHERE user_name IN ($names_string)";
$result = mysqli_query($connect, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $crew_ids[trim($row['user_name'])] = $row['user_id'];
    }
}

$group = $_GET['group'] ?? '';
?>
    <script>
        // Add loaded class to header after page loads to prevent FOUC
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            if (header) {
                header.classList.add('loaded');
            }
        });
    </script>


    <section class="sectionBlock container subCrewPageContainer">
        
        <?php if ($group === 'technical'): ?>
            <!-- Back Button -->
            <a href="crew.php" class="btn btn-primary backToCrewBtn" data-aos="fade-right">
                <i class="fas fa-arrow-left"></i> Back to Crew
            </a>

            <h1 class="mainTitle" data-aos="zoom-in">Technical</h1>
            <hr>

            <!-- Head Section Grid: Card + Job Description -->
            <div class="headSectionGrid">
                <!-- Main Board Member -->
                <div class="mainBoardMember" data-aos="fade-up" data-aos-delay="200">
                    <a href="ViewProfile.php?user_id=<?= $crew_ids['Marwan Wael'] ?? '#' ?>" class="memberCardLink">
                    <div class="flipCard" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront">
                                <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                            </div>
                            <div class="flipSide flipBack" data-title="TECHNICAL">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Marwan Wael.jpg" loading="lazy" alt="Marwan Wael" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Marwan Wael</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <!-- Job Description Card -->
                <div class="jobDescriptionCard" data-aos="fade-left">
                    <div class="jobCardHeader">
                        <h3 class="jobCardTitle">Job Description</h3>
                    </div>
                    <div class="jobCardContent">
                        <p class="textPrimary">
                            <span>⚜ </span>Leading The Technical Committees (IT, DD, MP, SMM).
                            <span>⚜ </span>Overseeing All Technical Operations And Digital Initiatives.
                            <span>⚜ </span>Coordinating Between Technical Teams For Seamless Integration.
                            <span>⚜ </span>Ensuring High-Quality Technical Deliverables And Innovation.
                            <span>⚜ </span>Managing Technical Resources And Infrastructure.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sub Cards Container -->
            <div class="subCrewGrid activeGrid">
                <!-- 1. IT -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="300">
                    <a href="crewDetails.php?committee_id=6" class="memberCardLink">
                    <div class="flipCard smCard card1" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront">
                                <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                            </div>
                            <div class="flipSide flipBack" data-title="IT">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Mahmoud Alaam.jpg" alt="Mahmoud Alaam" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mahmoud Allam</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=6" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 2. DD -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="400">
                    <a href="crewDetails.php?committee_id=7" class="memberCardLink">
                    <div class="flipCard smCard card2" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                            <div class="flipSide flipBack" data-title="DD">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Mohamed El Hossiny.jpg" alt="Mohamed El Hossiny" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed El Hossiny</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=7" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 3. MP -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="500">
                    <a href="crewDetails.php?committee_id=10" class="memberCardLink">
                    <div class="flipCard smCard card3" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                            <div class="flipSide flipBack" data-title="MP">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Omar Ahmed.jpg" alt="Omar Ahmed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Omar Ahmed</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=10" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 4. SMM -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="600">
                    <a href="crewDetails.php?committee_id=5" class="memberCardLink">
                    <div class="flipCard smCard card4" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                            <div class="flipSide flipBack" data-title="SMM">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Nour Mohamed.jpg" alt="Nour Mohamed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Nour Mohamed</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=5" class="btn btn-primary">Know Us !</a>
                </div>
            </div>


        <?php elseif ($group === 'er'): ?>
            <!-- Back Button -->
            <a href="crew.php" class="btn btn-primary backToCrewBtn" data-aos="fade-right">
                <i class="fas fa-arrow-left"></i> Back to Crew
            </a>

            <h1 class="mainTitle" data-aos="zoom-in">External Relations</h1>
            <hr>

            <!-- Head Section Grid: Card + Job Description -->
            <div class="headSectionGrid">
                <!-- Main Board Member -->
                <div class="mainBoardMember" data-aos="fade-up" data-aos-delay="200">
                    <a href="ViewProfile.php?user_id=<?= $crew_ids['Mohamed Hesham'] ?? '#' ?>" class="memberCardLink">
                    <div class="flipCard" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront">
                                <img src="./assets/img/crew/backCardCrew.png" loading="lazy">
                            </div>
                            <div class="flipSide flipBack" data-title="ER">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Mohamed Hesham.jpg" alt="Mohamed Hesham" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Hesham</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                <!-- Job Description Card -->
                <div class="jobDescriptionCard" data-aos="fade-left">
                    <div class="jobCardHeader">
                        <h3 class="jobCardTitle">Job Description</h3>
                    </div>
                    <div class="jobCardContent">
                        <p class="textPrimary">
                            <span>⚜ </span>Leading The External Relations Committees (BD, Logistics, CR, PR).
                            <span>⚜ </span>Managing Partnerships And External Communications.
                            <span>⚜ </span>Coordinating Events And Community Outreach Programs.
                            <span>⚜ </span>Building Strategic Relationships With Organizations.
                            <span>⚜ </span>Overseeing Public Relations And Brand Image.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sub Cards Container -->
            <div class="subCrewGrid activeGrid">
                <!-- 1. BD -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="300">
                    <a href="crewDetails.php?committee_id=4" class="memberCardLink">
                    <div class="flipCard smCard card1" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                            <div class="flipSide flipBack" data-title="BD">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Omar Hesham.jpg" alt="Omar Hesham" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Omar Hesham</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=4" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 2. L -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="400">
                    <a href="crewDetails.php?committee_id=9" class="memberCardLink">
                    <div class="flipCard smCard card2" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                            <div class="flipSide flipBack" data-title="LOGISTICS">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Asser El-Sayed.jpg" alt="Asser El-Sayed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Asser El-Sayed</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=9" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 3. CR -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="500">
                    <a href="crewDetails.php?committee_id=8" class="memberCardLink">
                    <div class="flipCard smCard card3" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                            <div class="flipSide flipBack" data-title="CR">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Belal Omar.jpg" alt="Belal Omar" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Belal Omar</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=8" class="btn btn-primary">Know Us !</a>
                </div>

                <!-- 4. PR -->
                <div class="subCard" data-aos="fade-up" data-aos-delay="600">
                    <a href="crewDetails.php?committee_id=11" class="memberCardLink">
                    <div class="flipCard smCard card4" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                            <div class="flipSide flipBack" data-title="PR">
                                <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/SCCI Board/Yasmine Gawish.jpg" alt="Yasmine Gawish" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Yasmine Gawish</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                    <a href="crewDetails.php?committee_id=11" class="btn btn-primary">Know Us !</a>
                </div>
            </div>
        <?php else: ?>
            <div data-aos="fade-up" style="text-align: center; margin-top: 50px;">
                <h2 class="sectionTitle textPrimary">Please select a valid group.</h2>
                <a href="crew.php" class="btn btn-primary">Back to Crew</a>
            </div>
        <?php endif; ?>
    </section>



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
    <script src="./assets/js/sub_crew.js"></script>
    <script src="./assets/js/all.min.js"></script>
</body>
<?php
include './includes/footer.php';
?>

</html>
