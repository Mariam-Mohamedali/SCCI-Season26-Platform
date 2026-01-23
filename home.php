<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include "./includes/config.php";
if (isset($_POST['contact'])) {

    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);

    $sql = "INSERT INTO contact_us (name, email, text)
            VALUES ('$name', '$email', '$message')";

    if (mysqli_query($connect, $sql)) {
        header("Location: home.php?success=1#contact");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/icons/logoSCCI.png" />
    <meta property="og:image" content="./assets/images/seo/home-page.png" />
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
    <link rel="stylesheet" href="./assets/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/css/home.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>SCCI - Home</title>
  </head>

<body>
    <?php include "./includes/nav.php"; ?>
    <!-- Main Hero section -->
    <section class="heroSection">
        <div class="heroContainer">
            <h1 data-aos="fade-up" data-aos-duration="1000">SEEK THE PEAK</h1>
            <hr data-aos="fade-up" data-aos-duration="1000">
            <p class="heroText" data-aos="zoom-in" data-aos-duration="2000">
                SCCI is an abbreviation for Student's Conference for Communication and Information,
                which helps you in bringing the gap between the technical life and the practical
                life in the market place. You can know more about our organization right here.
            </p>
            <a data-aos="fade-up" data-aos-duration="2000" href="./about.php" class="btn btn-primary">EXPLORE MORE</a>
        </div>
    </section>

    <!-- Main About section -->
    <section data-aos="fade-up" data-aos-duration="2000" class="aboutSection">
        <div class="aboutContainer">
            <h1 data-aos="fade-up" data-aos-duration="1000">ABOUT US</h1>
            <hr data-aos="fade-down" data-aos-duration="1000">
            <p data-aos="fade-up" data-aos-duration="2000" style="text-transform: none;">
                SCCI is a typical simulation of the outside real life. A one eventful
                experience that will stay in your heart & you'll watch it in your
                personality developmentand that is what SCCI is all about, unleashing your
            </p>
            <a data-aos="zoom-out" data-aos-duration="2000" href="./about.php" class=" btn btn-primary">EXPLORE MORE</a>
        </div>
        <img data-aos="zoom-in" data-aos-duration="2000" class="aboutBG" loading="lazy" src="./assets/img/paperHome.png" alt="paperHome">
        <img data-aos="zoom-in" data-aos-duration="2000" class="aboutBGresponsive" loading="lazy" src="./assets/img/paperHomeResponsive.png" alt="paperHomeResponsive">
    </section>



    <!-- Main Cards -->
    <section class="card2Container">

        <div data-aos="fade-up" data-aos-duration="2500" class="card2Items" id="workshopCard">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="cardContent">
                    <div class="card2I">
                        <img data-aos="fade-up" data-aos-duration="3000" src="./assets/img/home/workShopsLogo.jpg" alt="Workshops Logo" loading="lazy">
                    </div>
                    <h4 data-aos="zoom-in" data-aos-duration="3000" class="card-title">OUR WORKSHOPS</h4>

                    <a data-aos="zoom-in" data-aos-duration="3000" href="./workshops.php" class="btn btn-primary card2Button">EXPLORE MORE</a>
                </div>
            </div>
        </div>

        <div data-aos="fade-up" data-aos-duration="2500" class="card2Items" id="crewCard">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="cardContent">
                    <div class="card2I">
                        <img data-aos="fade-up" data-aos-duration="3000" src="./assets/img/home/crewLogo.png" id="crewLogoImage" alt="Crew Logo" loading="lazy">
                    </div>
                    <h4 data-aos="zoom-in" data-aos-duration="3000" class="card-title">OUR CREW</h4>

                    <a data-aos="zoom-in" data-aos-duration="3000" href="./crew.php" class="btn btn-primary card2Button">EXPLORE MORE</a>
                </div>
            </div>
        </div>
    </section>


    <!-- Main Stats -->
    <section class="stats">

        <!-- title -->
        <div class="homeTitles">
            <h1 data-aos="fade-up" data-aos-duration="1000">SCCI STATISTICS</h1>
            <hr data-aos="fade-up" data-aos-duration="1000">
        </div>

        <div class="statContainer">
            <!-- stats container -->
            <div class="stat">
                <i class="fas fa-calendar-alt statIcon"></i>
                <h4 data-aos="fade-down" data-aos-duration="3500" class="statNumber" data-target="21">0</h4>
                <h4 data-aos="fade-up" data-aos-duration="3000" class="statUnit">years</h4>
            </div>

            <div class="stat">
                <i class="fas fa-users statIcon"></i>
                <h4 data-aos="fade-down" data-aos-duration="3500" class="statNumber" data-target="300">0</h4>
                <h4 data-aos="fade-up" data-aos-duration="3000" class="statUnit">PARTICIPANTS</h4>
            </div>

            <div class="stat">
                <i class="fas fa-user-shield statIcon"></i>
                <h4 data-aos="fade-down" data-aos-duration="3500" class="statNumber" data-target="200">0</h4>
                <h4 data-aos="fade-up" data-aos-duration="3000" class="statUnit">MEMBERS</h4>
            </div>

            <div class="stat">
                <i class="fas fa-clock statIcon"></i>
                <h4 data-aos="fade-down" data-aos-duration="3500" class="statNumber" data-target="16">0</h4>
                <h4 data-aos="fade-up" data-aos-duration="3000" class="statUnit">SESSIONS</h4>
            </div>
        </div>

    </section>

    <!-- Main Sponsors -->
    <section class="sponsors">

        <!-- title -->
        <div class="homeTitles">
            <h1 data-aos="fade-up" data-aos-duration="2000">OUR SPONSORS</h1>
            <hr data-aos="fade-up" data-aos-duration="2000">
        </div>

        <!-- sponsors slider wrapper -->
        <div class="sponsorSliderWrapper">
            <div class="sponsorSliderTrack">

                <!-- Sponsor: Innovation Area -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/innovation_area.png" class="sponsorLogo" alt="Innovation Area Logo" loading="lazy">
                            <h4 class="sponsorTitle">INNOVATION AREA</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Puzzle Station -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/puzzle_station.png" class="sponsorLogo" alt="Puzzle Station Logo" loading="lazy">
                            <h4 class="sponsorTitle">PUZZLE STATION</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Rooh -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/rooh_coworking_space.png" class="sponsorLogo" alt="Rooh Logo" loading="lazy">
                            <h4 class="sponsorTitle">ROOH CO-WORKING SPACE</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Youth Scope -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/youth_scope.png" class="sponsorLogo" alt="Youth Scope Logo" loading="lazy">
                            <h4 class="sponsorTitle">YOUTH SCOPE</h4>
                        </div>
                    </div>
                </div>

                <!-- Duplicate for seamless loop -->

                <!-- Sponsor: Innovation Area -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/innovation_area.png" class="sponsorLogo" alt="Innovation Area Logo" loading="lazy">
                            <h4 class="sponsorTitle">INNOVATION AREA</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Puzzle Station -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/puzzle_station.png" class="sponsorLogo" alt="Puzzle Station Logo" loading="lazy">
                            <h4 class="sponsorTitle">PUZZLE STATION</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Rooh -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/rooh_coworking_space.png" class="sponsorLogo" alt="Rooh Logo" loading="lazy">
                            <h4 class="sponsorTitle">ROOH CO-WORKING SPACE</h4>
                        </div>
                    </div>
                </div>

                <!-- Sponsor: Youth Scope -->
                <div class="sponsorCardItems">
                    <div class="sponsorsCard card2">
                        <div class="corner-ornament top-left"></div>
                        <div class="corner-ornament top-right"></div>
                        <div class="corner-ornament bottom-left"></div>
                        <div class="corner-ornament bottom-right"></div>

                        <div class="sponsorCardContent">
                            <img src="./assets/img/sponser/youth_scope.png" class="sponsorLogo" alt="Youth Scope Logo" loading="lazy">
                            <h4 class="sponsorTitle">YOUTH SCOPE</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>


    <!-- Main Contact us -->
    <section class="homeContactUs" id="contact">
        <!-- title -->
        <div class="homeTitles">
            <h1 data-aos="fade-up" data-aos-duration="2000">CONTACT US</h1>
            <hr data-aos="fade-up" data-aos-duration="2000">
        </div>
        <div class="contactUsContainer">

            <div class="contactUsSection" data-aos="fade-right">
                <div class="cardContactUs">
                    <div class="corner top left"></div>
                    <div class="corner top right"></div>
                    <div class="corner bottom left"></div>
                    <div class="corner bottom right"></div>

                    <div class="contactInfoContent">
                        <i class="fas fa-envelope contactInfoIcon"></i>
                        <h3 class="contactInfoTitle">Get In Touch</h3>
                        <hr class="contactDivider">
                        <p class="contactInfoText">
                            Have questions or want to collaborate? We'd love to hear from you!
                            Whether it's about our workshops, sponsorship opportunities, membership inquiries,
                            or general questions about SCCI, feel free to reach out using the contact form.
                        </p>
                        <p class="contactInfoText">
                            We're committed to responding to all inquiries within 24-48 hours.
                            Your feedback and questions help us improve and serve you better.
                        </p>
                        <hr class="contactDivider">
                        <div class="contactDetails">
                            <div class="contactDetailItem">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cairo, Egypt</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form class="form-content card" data-aos="fade-left" id="form" method="POST" enctype="multipart/form-data">
                <img class="homeBird" loading="lazy" src="./assets/img/bird.png" alt="Decorative bird">

                <?php if (isset($_GET['success'])): ?>
                    <div class="success-message">
                        Thank you for reaching out.<br>
                        Your message has been sent successfully!

                    </div>

                    <script>
                        // remove success from url after showing message
                        if (window.history.replaceState) {
                            const url = new URL(window.location);
                            url.searchParams.delete('success');
                            window.history.replaceState({}, document.title, url);
                        }
                    </script>
                <?php endif; ?>

                <!-- inputs -->
                <div class="input-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                    <small class="error"></small>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <small class="error"></small>
                </div>

                <div class="input-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
                    <small class="error"></small>
                </div>


                <!-- submit-button -->
                <button type="submit" name="contact" class="btn btn-primary submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
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
