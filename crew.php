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
    <title>SCCI - Crew</title>
  </head>

<body>

    <?php
   include './includes/nav.php'; 

// Define names to fetch
$target_names = [
    'Mohamed Ali',
    'Marwan Wael',
    'Mohamed Ahmed',
    'Alaa Aboelazm',
    'Mohamed Hesham',
    'Mahmoud Alaam', 
    'Mohamed El Hossiny',
    'Omar Ahmed',
    'Nour Mohamed',
    'Omar Hesham',
    'Asser El-Sayed',
    'Belal Omar',
    'Yasmine Gawish'
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


    <section class="sectionBlock container">
        <h1 class="mainTitle" data-aos="zoom-in">President</h1>
        <hr>
        <div class="presidentGrid">
        
            <a href="ViewProfile.php?user_id=<?= $crew_ids['Mohamed Ali'] ?? '#' ?>" class="memberCardLink">
            <div class="flipCard " data-aos="flip">
                <div class="flipInner">
                    <div class="flipSide flipFront">
                        <img loading="lazy" src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                    </div>
                    <div class="flipSide flipBack" data-title="PRESIDENT">
                         <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img loading="lazy" src="./assets/uploadedImages/SCCI Board/Mohamed Ali.jpg" loading="lazy" alt="Mohamed Ali" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Ali</h3>
                                    </div>
                            </div>
                    </div>
                </div>
            </div >
            </a>


            <div class="jobDescriptionCard" data-aos="fade-left">
                <div class="jobCardHeader">
                    <h3 class="jobCardTitle">Job Description</h3>
                </div>
                <div class="jobCardContent">
                    <p class="textPrimary">
                        <span>⚜ </span>Developing Members In Negotiation, Persuasive And Communication Skills.
                        <span>⚜ </span>Helping Members To Discover Their Own Skills And What Can They Do.
                        <span>⚜ </span>Responsible For The Budget And The Cash Inflow And Outflow.
                        <span>⚜ </span>Making CR Outing For All Members To Create Connections Between CR Members.
                        <span>⚜ </span>After Each Phase Creating One To One Meeting
                        <span>⚜ </span>For Each Member To Evaluate The Members And Incentivize Them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="sectionBlock container">
        <h2 class="sectionTitle textPrimary" data-aos="fade-up">High Board</h2>
        <hr>

        <div class="cardsGrid">

            <div class="boardItem" data-aos="fade-up" data-aos-delay="200">
                <a href="sub_crew.php?group=technical" class="memberCardLink">
                    <div class="flipCard" data-aos="flip">
                        <div class="flipInner  ">
                            <div class="flipSide  flipFront">
                                <img loading="lazy" src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                            </div>
                            <div class="flipSide flipBack" data-title="TECHNICAL">
                                <div class="backCard">

                                        <div class="memberImageContainer">
                                            <img loading="lazy" src="./assets/uploadedImages/SCCI Board/Marwan Wael.jpg" loading="lazy" alt="Marwan Wael" class="memberImage" />
                                        </div>
                                        <div class="memberName">
                                            <h3>Marwan Wael</h3>
                                        </div>
                                    
                                    </div>
                                </div>
                        </div>
                        
                    </div>
                </a>
                <a href="sub_crew.php?group=technical" class="btn btn-primary ">Discover More</a>
            </div>

            <div class="boardItem" data-aos="fade-up" data-aos-delay="200">
                <a href="crewDetails.php?committee_id=3" class="memberCardLink">
                    <div class="flipCard" data-aos="flip">
                        <div class="flipInner">
                            <div class="flipSide flipFront">
                                <img loading="lazy" src="./assets/img/crew/backCardCrew.png" alt="backCard" />
                            </div>
                            <div class="flipSide flipBack" data-title="ACADEMIC">
                                <div class="backCard">

                                        <div class="memberImageContainer">
                                            <img loading="lazy" src="./assets/uploadedImages/SCCI Board/Mohamed Ahmed.jpg" alt="Mohamed Ahmed" class="memberImage" />
                                        </div>
                                        <div class="memberName">
                                            <h3>Mohamed Ahmed</h3>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="crewDetails.php?committee_id=3" class="btn btn-primary ">Know Us !</a>
            </div>

            <div class="boardItem" data-aos="fade-up" data-aos-delay="300">
                <a href="crewDetails.php?committee_id=12" class="memberCardLink">
                <div class="flipCard" data-aos="flip">
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img loading="lazy" src="./assets/img/crew/backCardCrew.png" alt="backCard" />
                        </div>
                        <div class="flipSide flipBack" data-title="HR">
                            <div class="backCard">

                                    <div class="memberImageContainer">
                                        <img loading="lazy" src="./assets/uploadedImages/SCCI Board/Alaa Aboelazm.jpg" alt="Alaa Aboelazm" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Alaa Aboelazm</h3>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <a href="crewDetails.php?committee_id=12" class="btn btn-primary ">Know Us !</a>
            </div>
             <div class="boardItem" data-aos="fade-up" data-aos-delay="200">
                <a href="sub_crew.php?group=er" class="memberCardLink">
                <div class="flipCard" data-aos="flip">
                    
                    
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img loading="lazy" src="./assets/img/crew/backCardCrew.png" loading="lazy">
                        </div>
                        <div class="flipSide flipBack" data-title="ER">
                            <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img loading="lazy" src="./assets/uploadedImages/SCCI Board/Mohamed Hesham.jpg" alt="Mohamed Hesham" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Hesham</h3>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <a href="sub_crew.php?group=er" class="btn btn-primary ">Discover More</a>
            </div>
        </div>
    </section>

    <!-- Overlay for Blur Effect -->
    <div class="pageOverlay" onclick="closeModal()"></div>



    <!-- Modal Container -->
    <div id="crewModal" class="crewModal">
        <button class="modalCloseBtn" onclick="closeModal()" aria-label="Close Modal">×</button>
        <div class="modalContent">
            <!-- Content will be injected via JS -->
        </div>
    </div>

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
    <script src="./assets/js/crew.js?v=<?php echo time(); ?>_2"></script>
    <script src="./assets/js/all.min.js"></script>
</body>
<?php
include './includes/footer.php';
?>

</html>
