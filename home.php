<?php


if (isset($_POST['contact'])) {

    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    $contact = "INSERT INTO contact_us (name, email, text)
                VALUES ('$name', '$email', '$message')";

    $run_contact = mysqli_query($connect, $contact);

    if ($run_contact) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Preload critical CSS files -->
    <link rel="preload" href="./assets/css/root.css" as="style">
    <link rel="preload" href="./assets/css/home.css" as="style">
    
    <!-- Inline critical CSS to prevent FOUC -->
    <style>
        /* Prevent FOUC by hiding content until CSS loads */
        header {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        header.loaded {
            opacity: 1;
        }
    </style>
    
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Irish Grover font -->
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet" />


    <!-- site icon -->
    <link rel="icon" type="image/png" href="./assets/icons/logoSCCI.png" />

    <!-- css other link -->
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/root.css">

    <!-- css page link -->
    <link rel="stylesheet" href="./assets/css/home.css">
    <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Load AOS library before other scripts -->


    <title>SCCI - Home</title>
</head>

<body>
    <?php
    if (isset($_GET['success'])) {
        echo "
    <script>
        alert('Message Sent Successfully');

        // remove success from url after showing alert
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('success');
            window.history.replaceState({}, document.title, url);
        }
    </script>
    ";
    }
    ?>

    <?php include './includes/nav.php'; ?>
    
    <script>
        // Add loaded class to header after page loads to prevent FOUC
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');
            if (header) {
                header.classList.add('loaded');
            }
        });
    </script>
    <!-- Main Hero section -->
    <section  class="heroSection">
        <div class="heroContainer">
            <h1 data-aos="fade-up" data-aos-duration="1000">SEEK THE PEAK</h1>
            <hr data-aos="fade-up" data-aos-duration="1000">
            <p class="heroText" data-aos="zoom-in" data-aos-duration="2000">
                SCCI is an abbreviation for Student's Conference for Communication and Information,
                which helps you in bringing the gap between the technical life and the practical
                life in the market place. You can know more about our organization right here.
            </p>
            <a  href="./about.php" class="btn btn-primary">EXPLORE MORE</a>
        </div>
    </section>

    <!-- Main About section -->
    <section data-aos="fade-up" data-aos-duration="2000" class="aboutSection">
        <div class="aboutContainer">
            <h1 data-aos="fade-up" data-aos-duration="1000">ABOUT US</h1>
            <hr>
            <p data-aos="fade-up" data-aos-duration="2000" style="text-transform: none;">
                SCCI is a typical simulation of the outside real life. A one eventful
                experience that will stay in your heart & you'll watch it in your
                personality developmentand that is what SCCI is all about, unleashing your
            </p>
            <a href="./about.php" class=" btn btn-primary">EXPLORE MORE</a>
        </div>
        <img class="aboutBG" loading="lazy" src="./assets/img/paperHome.png" alt="paperHome">
        <img class="aboutBGresponsive" loading="lazy" src="./assets/img/paperHomeResponsive.png" alt="paperHomeResponsive">
    </section>



    <!-- Main Cards -->
    <section class="card2Container">

        <div class="card2Items" id="workshopCard" data-aos="fade-up">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="cardContent">
                    <div class="card2I">
                        <img src="./assets/img/home/workShopsLogo.jpg" alt="Workshops Logo" loading="lazy">
                    </div>
                    <h4 class="card-title">OUR WORKSHOPS</h4>

                    <button class="btn btn-primary card2Button">EXPLORE MORE</button>
                </div>
            </div>
        </div>

        <div class="card2Items" id="crewCard" data-aos="fade-up" data-aos-delay="150">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="cardContent">
                    <div class="card2I">
                        <img src="./assets/img/home/crewLogo.png" id="crewLogoImage" alt="Crew Logo" loading="lazy">
                    </div>
                    <h4 class="card-title">OUR CREW</h4>

                    <button class="btn btn-primary card2Button">EXPLORE MORE</button>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Stats -->
    <section class="stats" data-aos="zoom-in" data-aos-delay="100">

        <!-- title -->
        <div class="homeTitles">
            <h1>SCCI STATISTICS</h1>
            <hr>
        </div>

        <div class="statContainer">
            <!-- stats container -->
            <div class="stat">
                <i class="fas fa-calendar-alt statIcon"></i>
                <h4 class="statNumber" data-target="21">0</h4>
                <h4 class="statUnit">years</h4>
            </div>

            <div class="stat">
                <i class="fas fa-users statIcon"></i>
                <h4 class="statNumber" data-target="300">0</h4>
                <h4 class="statUnit">PARTICIPANTS</h4>
            </div>

            <div class="stat">
                <i class="fas fa-user-shield statIcon"></i>
                <h4 class="statNumber" data-target="200">0</h4>
                <h4 class="statUnit">MEMBERS</h4>
            </div>

            <div class="stat">
                <i class="fas fa-clock statIcon"></i>
                <h4 class="statNumber" data-target="16">0</h4>
                <h4 class="statUnit">SESSIONS</h4>
            </div>
        </div>

    </section>

    <!-- Main Sponsors -->
    <section class="sponsors">

        <!-- title -->
        <div class="homeTitles">
            <h1>OUR SPONSORS</h1>
            <hr>
        </div>

        <!-- sponsors container -->
        <div class="sponsorContainer">

            <!-- sponsor card -->
            <div class="sponsorCardItems" data-aos="fade-up">
                <div class="sponsorsCard card2">
                    <div class="corner-ornament top-left"></div>
                    <div class="corner-ornament top-right"></div>
                    <div class="corner-ornament bottom-left"></div>
                    <div class="corner-ornament bottom-right"></div>

                    <div class="sponsorCardContent">
                        <img src="./assets/icons/logoSCCI.png" class="sponsorLogo" alt="Sponsor Logo" loading="lazy">
                        <h4 class="sponsorTitle">SPONSOR</h4>
                    </div>
                </div>
            </div>

            <!-- sponsor card -->
            <div class="sponsorCardItems" data-aos="fade-up" data-aos-delay="100">
                <div class="sponsorsCard card2">
                    <div class="corner-ornament top-left"></div>
                    <div class="corner-ornament top-right"></div>
                    <div class="corner-ornament bottom-left"></div>
                    <div class="corner-ornament bottom-right"></div>

                    <div class="sponsorCardContent">
                        <img src="./assets/icons/logoSCCI.png" class="sponsorLogo" alt="Sponsor Logo" loading="lazy">
                        <h4 class="sponsorTitle">SPONSOR</h4>
                    </div>
                </div>
            </div>

            <!-- sponsor card -->
            <div class="sponsorCardItems" data-aos="fade-up" data-aos-delay="200">
                <div class="sponsorsCard card2">
                    <div class="corner-ornament top-left"></div>
                    <div class="corner-ornament top-right"></div>
                    <div class="corner-ornament bottom-left"></div>
                    <div class="corner-ornament bottom-right"></div>

                    <div class="sponsorCardContent">
                        <img src="./assets/icons/logoSCCI.png" class="sponsorLogo" alt="Sponsor Logo" loading="lazy">
                        <h4 class="sponsorTitle">SPONSOR</h4>
                    </div>
                </div>
            </div>

            <!-- sponsor card -->
            <div class="sponsorCardItems" data-aos="fade-up" data-aos-delay="300">
                <div class="sponsorsCard card2">
                    <div class="corner-ornament top-left"></div>
                    <div class="corner-ornament top-right"></div>
                    <div class="corner-ornament bottom-left"></div>
                    <div class="corner-ornament bottom-right"></div>

                    <div class="sponsorCardContent">
                        <img src="./assets/icons/logoSCCI.png" class="sponsorLogo" alt="Sponsor Logo" loading="lazy">
                        <h4 class="sponsorTitle">SPONSOR</h4>
                    </div>
                </div>
            </div>

    </section>


    <!-- Main Contact us -->
    <section class="homeContactUs">
        <!-- title -->
        <div class="homeTitles">
            <h1>CONTACT US</h1>
            <hr>
        </div>
        <div class="contactUsContainer">

            <div class="contactUsSection" data-aos="fade-right">
                <div class="cardContactUs">
                    <div class="corner top left"></div>
                    <div class="corner top right"></div>
                    <div class="corner bottom left"></div>
                    <div class="corner bottom right"></div>
                    <hr>
                    <p>Keep In Touch If you want to contact us for any queries, or for any sponsorship deals, don't hesitate to contact us right here.</p>
                    <hr>
                </div>
            </div>


            <form class="form-content card" data-aos="fade-left" id="form" method="POST" enctype="multipart/form-data">
                <img class="homeBird" loading="lazy" src="./assets/img/bird.png" alt="">
                <!-- inputs -->
                <div class="input-group">
                    <label for="">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name">
                    <small class="error"></small>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email">
                    <small class="error"></small>
                </div>

                <div class="input-group">
                    <label for="message">Message</label>
                    <textarea type="text" id="message" name="message" placeholder="Enter your message"></textarea>
                    <small class="error"></small>
                </div>


                <!-- submit-button -->
                <button type="submit" name="contact" class="btn btn-primary submit-btn">Submit</button>
            </form>

        </div>
    </section>

    <?php include './includes/footer.php'; ?>
    <script src="https://unpkg.com/aos@next/dist/aos.js" defer></script>
    <script src="./assets/js/all.min.js" defer></script>
    <script src="./assets/js/home.validation.js" defer></script>
    <script src="./assets/js/home.js" defer></script>
</body>

</html>
