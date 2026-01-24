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
    <meta property="og:image" content="./assets/images/seo/about.png" />
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
    <link rel="stylesheet" href="./assets/css/root.css">
    <link rel="stylesheet" href="./assets/css/about.css">
    <!-- aos -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <title>SCCI - About</title>
  </head>

<body>

    <?php include "./includes/nav.php"; ?>

    <section class="heroSection" data-aos="fade-in" data-aos-duration="800">
        <div class="hero">
            <div class="heroBackground">
                <picture>
                    <img src="./assets/img/heroImage1.png" alt="Hero Image" loading="lazy">
                </picture>
            </div>

            <div class="heroLogo" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                <h5>SEEK THE PEEK</h5>
            </div>
        </div>
    </section>

    <section class="aboutSection" data-aos="fade-up" data-aos-duration="1000">
        <div class="cardAbout">
            <div class="corner top left"></div>
            <div class="corner top right"></div>
            <div class="corner bottom left"></div>
            <div class="corner bottom right"></div>
            <hr>
            <h1 data-aos="fade-down" data-aos-duration="800" data-aos-delay="200">WHO ARE WE?</h1>
            <hr>
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">SCCI is an abbreviation for Student's Conference for Communication and Information,
                which helps you in bringing the gap between the technical life and the practical life
                in the marketplace. You can know more about SCCI in this page.</p>
        </div>
    </section>

    <!-- <section class="aboutSection">
    <div class="aboutComponents">

        <div class="aboutBackground">
            <div class="card-container">

                <div class="cardInner">

                    
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
</section> -->

    <div class="title2Cards" data-aos="fade-up" data-aos-duration="1000">
        <div class="titleWrapper2">
            <hr>
            <h2 class="aboutTitle text-primary">WHAT MAKES US DIFFERENT?</h2>
            <hr>
        </div>
    </div>

    <section class="card2Container">

        <div class="card2Items" data-aos="fade-up" data-aos-duration="1000">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="card-content">
                    <div class="card2I">
                        <i class="fas fa-chart-line" style="font-size: 5rem; text-align: center; color: var(--color-primary-dark);"></i>
                    </div>
                    <h4 class="card-title">GROWTH TRACKING</h4>

                    <div class="divider"></div>

                    <p class="card-text">
                        Participants gain hands-on experience through real activities.
                    </p>

                    <div class="divider"></div>

                    <div class="decorative-element">⚜</div>
                </div>
            </div>
        </div>

        <div class="card2Items" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="card-content">
                    <div class="card2I">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h4 class="card-title">PRACTICAL LEARNING</h4>

                    <div class="divider"></div>

                    <p class="card-text">
                        The program is divided into focused, time-limited sessions.
                    </p>

                    <div class="divider"></div>

                    <div class="decorative-element">⚜</div>
                </div>
            </div>
        </div>

        <div class="card2Items" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="card-content">
                    <div class="card2I">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4 class="card-title">SEASON STRUCTURE</h4>

                    <div class="divider"></div>

                    <p class="card-text">
                        Participants collaborate in small groups to solve challenges.
                    </p>

                    <div class="divider"></div>

                    <div class="decorative-element">⚜</div>
                </div>
            </div>
        </div>

        <div class="card2Items" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="card-content">
                    <div class="card2I">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="card-title">TEAM-BASED SYSTEM</h4>

                    <div class="divider"></div>

                    <p class="card-text">
                        Progress is monitored to highlight improvement over time.
                    </p>

                    <div class="divider"></div>

                    <div class="decorative-element">⚜</div>
                </div>
            </div>
        </div>

        <div class="card2Items" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="card2">
                <div class="corner-ornament top-left"></div>
                <div class="corner-ornament top-right"></div>
                <div class="corner-ornament bottom-left"></div>
                <div class="corner-ornament bottom-right"></div>

                <div class="card-content">
                    <div class="card2I">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h4 class="card-title">ENVIROMENT</h4>

                    <div class="divider"></div>

                    <p class="card-text">
                        Participants take the lead, growing through hands-on involvement.
                    </p>

                    <div class="divider"></div>

                    <div class="decorative-element">⚜</div>
                </div>
            </div>
        </div>


    </section>



    <!-- CREW CARDS SLIDER -->
    <section data-aos="fade-up" data-aos-duration="1000">
        <hr>
        <h1 data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">BEHIND THE SCENES</h1>
        <hr>
        <div class="sliderWrapper" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">

            <div class="cardStack">
                <?php
                // Get all images from crewImg directory
                $imageDir = './assets/img/crewImg/';
                $images = glob($imageDir . '*.{png,jpg,jpeg,PNG,JPG,JPEG}', GLOB_BRACE);
                
                // Sort images naturally
                natsort($images);
                
                // Loop through and display each image
                foreach ($images as $index => $image) {
                    $imageName = basename($image);
                    $altText = "Crew Photo #" . ($index + 1);
                    echo '<img src="' . htmlspecialchars($image) . '" class="crewCard" alt="' . htmlspecialchars($altText) . '" loading="lazy">' . "\n                ";
                }
                ?>
            </div>

            <div class="arrowsContainer">
                <button class="sliderBtn next" id="nextBtn"></button>
                <button class="sliderBtn prev" id="prevBtn"></button>
            </div>
        </div>
    </section>

    <?php include "./includes/footer.php"; ?>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
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
    <script src="./assets/js/all.min.js"></script>
    <script src="./assets/js/about.js"></script>
</body>

</html>
