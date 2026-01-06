<!--
 Things to remeber:
    -sidenav image
    -add 4 stats images

  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- almendra font -->
    <link href="https://fonts.googleapis.com/css2?family=Almendra:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet" />


    <!-- site icon -->
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/x-icon">

    <!-- css other link -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/root.css">

    <!-- css registration link -->
    <link rel="stylesheet" href="./assets/css/registerParticipant.css">

    <!-- css page link -->
    <link rel="stylesheet" href="./assets/css/home.css">
     <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <title>Home</title>
</head>

<body>
    <!-- Main Hero section -->
    <section class="heroSection">
        <div class="heroContainer">
            <h1>seek the peak</h1>
            <hr>
            <p>
                SCCI is an abbreviation for Student's Conference for Communication and Information,
                which helps you in bringing the gap between the technical life and the practical
                life in the market place. You can know more about our organization right here.
            </p>
            <a href="./about.php" class="submit-btn homeBtn">explore more</a>
        </div>
        <!-- <img loading="lazy" src="./assets/img/homeHeroSection.png" alt=""> -->
    </section>

    <!-- Main First section -->
    <section class="aboutSection">
        <div class="aboutContainer">
            <h1>about us</h1>
            <hr>
            <p>
                SCCI is a typical simulation of the outside real life. A one eventful
                experience that will stay in your heart & you'll watch it in your
                personality developmentand that is what SCCI is all about, unleashing your
            </p>
            <a href="./about.php" class="submit-btn homeBtn">explore more</a>
        </div>
        <img loading="lazy" src="./assets/img/paperHome.png" alt="">
    </section>



    <!-- Main Cards -->
    <section class="workshopsSection">
        <div class="container">
            <div class="workshopCardsGrid">
                    <div class="cardsContainer aos-animate" data-aos="flip">
                        <div class="flipCard">
                            <div class="frontCard">
                                <img src="assets/img/backCardCrew.png" alt="Workshops" loading="lazy">
                            </div>
                            <div class="backCard">
                                <img src="assets/img/workshopCard.png" alt="Workshops" loading="lazy">
                                <div class="cardContent">
                                    <p class="cardText">OUR WORKSHOPS</p>
                                    <img src="assets/img/workShopsLogo.jpg" alt="Workshops">
                                    <a href="workshops.php" class="btn btn-primary btn-sm">
                                        Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cardsContainer aos-animate" data-aos="flip">
                        <div class="flipCard">
                            <div class="frontCard">
                                <img src="assets/img/backCardCrew.png" alt="Crew" loading="lazy">
                            </div>
                            <div class="backCard">
                                <img src="assets/img/workshopCard.png" alt="Crew" loading="lazy">
                                <div class="cardContent">
                                    <p class="cardText">OUR CREW</p>
                                    <img src="assets/img/workShopsLogo.jpg" alt="Crew">
                                    <a href="crew.php" class="btn btn-primary btn-sm">
                                        Explore More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
            </div>
        </div>

    </section>




    <!-- Main Stats -->
    <!-- <section class="stats"> -->

        <!-- title -->
        <!-- <div class="homeTitles">
            <h1>scci statistics</h1>
            <hr>
        </div>

        <div class="statContainer"> -->
            <!-- stats container -->
            <!-- <div class="stat">
                <img loading="lazy" src="./assets/img/stat-calender.png" alt="">
                <p class="statNumber">21</p>
                <p class="statUnit">years</p>
            </div>

            <div class="stat">
                <img loading="lazy" src="./assets/img/stat-members.png" alt="">
                <p class="statNumber">300</p>
                <p class="statUnit">participants</p>
            </div>

            <div class="stat">
                <img loading="lazy" src="./assets/img/stat-participant.png" alt="">
                <p class="statNumber">200</p>
                <p class="statUnit">members</p>
            </div>

            <div class="stat">
                <img loading="lazy" src="./assets/img/stat-session.png" alt="">
                <p class="statNumber">16</p>
                <p class="statUnit">sessions</p>
            </div>
        </div>

    </section> -->

    <!-- Main Sponsors -->
    <section class="sponsors">

        <!-- title -->
        <div class="homeTitles">
            <h1>our sponsors</h1>
            <hr>
        </div>
        
        <!-- sponsors container -->
        <div class="statContainer">
            <div class="stat">
                <img loading="lazy" src="./assets/img/sponsorBackground.png" alt="">
                <div class="sponsorInfo">
                    <!-- sponsor logo -->
                    <img loading="lazy" src="" alt="sponsor logo">
                    <!-- sponsor name -->
                    <p class="sponsorName">sponsor name</p>
                </div>
            </div>
            <div class="stat">
                <img loading="lazy" src="./assets/img/sponsorBackground.png" alt="">
                <div class="sponsorInfo">
                    <!-- sponsor logo -->
                    <img loading="lazy" src="" alt="sponsor logo">
                    <!-- sponsor name -->
                    <p class="sponsorName">sponsor name</p>
                </div>
            </div>
            <div class="stat">
                <img loading="lazy" src="./assets/img/sponsorBackground.png" alt="">
                <div class="sponsorInfo">
                    <!-- sponsor logo -->
                    <img loading="lazy" src="" alt="sponsor logo">
                    <!-- sponsor name -->
                    <p class="sponsorName">sponsor name</p>
                </div>
            </div>
            <div class="stat">
                <img loading="lazy" src="./assets/img/sponsorBackground.png" alt="">
                <div class="sponsorInfo">
                    <!-- sponsor logo -->
                    <img loading="lazy" src="" alt="sponsor logo">
                    <!-- sponsor name -->
                    <p class="sponsorName">sponsor name</p>
                </div>
            </div>
            
        </div>

    </section>


    <!-- Main Contact us -->
    <section class="homeContactUs">
        <!-- title -->
        <div class="homeTitles">
            <h1>contact us</h1>
            <hr>
        </div>
        <div class="contactUsContainer">
            <img loading="lazy" src="./assets/img/paperWorkshop.png" alt="">
            <img loading="lazy" src="./assets/img/bird.png" alt="">

            <form class="form-content" id="form" action="" method="POST" enctype="multipart/form-data">
                <!-- rigester-title with dimonds and lines -->
                <h1 class="register-title">Register</h1>
                <div class="divider">
                    <span class="line"></span>
                    <span class="diamond"></span>
                    <span class="line"></span>
                </div>
                <!-- inputs -->
                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name">
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email">
                </div>

                <div class="input-group">
                    <label>Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter phone number">
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password">
                </div>

                <div class="input-group">
                    <label>Workshop</label>
                    <select id="workshop" name="workshop">
                        <option value="">Select Workshop</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Image</label>
                    <input type="file" id="image" name="image" accept="image/*">
                </div>


                <!-- submit-button -->
                <button type="submit" name="submit" class="submit-btn">Register</button>
            </form>

        </div>
    </section>


        <!-- Scripts -->
    <script src="assets/js/all.min.js" defer></script>
    <script src="assets/js/workshops.js" defer></script>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({

            once: true,

            offset: 100,

            easing: 'ease-in-out',
        });
    </script>
</body>

</html>
