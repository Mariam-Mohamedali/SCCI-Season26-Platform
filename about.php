<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI - About</title>
    <link rel="icon" href="./assets/icons/logoSCCI.png" type="image/png">

    <!-- Styles -->
    <link rel="stylesheet" href="./assets/css/root.css">
    <link rel="stylesheet" href="./assets/css/about.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
</head>
<body>

<?php include "./includes/nav.php"; ?>

<section class="heroSection">
    <div class="hero">
  <div class="heroBackground">
    <picture>
      <img src="./assets/img/heroImage.png" alt="Hero Image" loading="lazy">
    </picture>
  </div>

  <div class="heroLogo">
    <img src="./assets/icons/logoSCCI.png" class="logoSCCI" alt="SCCI Logo" loading="lazy">
    <h1>SCCI</h1>
  </div>
</div>
</section>

<section class="aboutSection">
    <div class="aboutComponents">

        <div class="aboutBackground">
            <div class="card-container">

                <div class="cardInner">

                    <!-- TEXT CONTENT -->
                    <div class="aboutContent">

                        <div class="titleWrapper">
                            <hr>
                            <h2 class="aboutTitle text-primary">WHO ARE WE?</h2>
                            <hr>
                        </div>

                        <p class="text-secondary aboutParagraph">
                            SCCI is an abbreviation for Student's Conference for Communication and Information,
                            which helps you in bringing the gap between the technical life and the practical life
                            in the marketplace. You can know more about SCCI in this page.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<div class="title2Cards">
            <div class="titleWrapper2">
                <hr>
                <h2 class="aboutTitle text-primary">WHAT MAKES US DIFFERENT?</h2>
                <hr>
            </div>
</div>

<!-- CARDS ROW: WHAT MAKES US DIFFRENET-->
<section class="cardRowSection">
    <div class="cardRow">
        <div style="--r:-15;" class="glass">
            <i class="fas fa-chart-line" style="font-size: 80px; color: #C52525;"></i>
            <h4>GROWTH TRACKING</h4>
            <p>Participants gain hands-on experience through real activities.</p>
        </div>

        <div style="--r:10;" class="glass">
            <i class="fas fa-calendar-alt" style="font-size: 80px; color: #C52525;"></i>
            <h4>SEASON STRUCTURE</h4>
            <p>Participants collaborate in small groups to solve challenges</p>
        </div>

        <div style="--r:0;" class="glass">
            <i class="fas fa-hands-helping" style="font-size: 80px; color: #C52525;"></i>
            <h4>PRACTICAL LEARNING</h4>
            <p>The program is divided into focused, time-limited sessions.</p>
        </div>

        <div style="--r:-10;" class="glass">
            <i class="fas fa-users" style="font-size: 80px; color: #C52525;"></i>
            <h4>TEAM-BASED SYSTEM</h4>
            <p>Progress is monitored to highlight improvement over time.</p>
        </div>

        <div style="--r:15;" class="glass">
            <i class="fas fa-seedling" style="font-size: 80px; color: #C52525;"></i>
            <h4>ENVIRONMENT</h4>
            <p>Participants take the lead, growing through hands-on involvement.</p>
        </div>
    </div>

    <div class="titleWrapper3">
                <hr>
                <h2 class="aboutTitle text-primary">BEHIND THE SCENES</h2>
                <hr>
    </div>
</section>

<!-- CREW CARDS SLIDER -->
<section>
    <div class="sliderWrapper">
        
        <div class="cardStack">
            <img src="./assets/img/crewImg/workshopCard1.png" class="crewCard" alt="Crew Photo #1" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard2-r.png" class="crewCard" alt="Crew Photo #2" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard3.png" class="crewCard" alt="Crew Photo #3" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard4.png" class="crewCard" alt="Crew Photo #4" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard5-r.png" class="crewCard" alt="Crew Photo #5" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard6.png" class="crewCard" alt="Crew Photo #6" loading="lazy">
            <img src="./assets/img/crewImg/workshopCard7.png" class="crewCard" alt="Crew Photo #7" loading="lazy">
        </div>

        <div class="arrowsContainer">
            <button class="arrow left" id="prevBtn">&#10094;</button>
            <button class="arrow right" id="nextBtn">&#10095;</button>
        </div>
    </div>
</section>

<?php include "./includes/footer.php"; ?>
<script src="./assets/js/all.min.js"></script>
<script src="./assets/js/about.js"></script>
</body>
</html>