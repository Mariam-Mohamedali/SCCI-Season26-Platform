<?php
include './includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI - Gallery</title>
    <link rel="icon" href="./assets/icons/logoSCCI.png" type="image/png">

    <!-- font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/root.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/gallary.css">
    <!-- AOS library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <main>

        <!-- ================= Papers ================= -->
        <section class="paperContainer" id="paperContainer" aria-label="Paper Animation" data-aos="fade-in"
            data-aos-duration="800">
            <div class="paperRow topRow">
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="200"><a href="#"
                        class="paper" data-event="opening">
                        <p>Opening</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="350"><a href="#"
                        class="paper" data-event="ushering">
                        <p>Ushering</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="500"><a href="#"
                        class="paper" data-event="firstSession">
                        <p>First Session</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="650"><a href="#"
                        class="paper" data-event="57357">
                        <p>57357</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="800"><a href="#"
                        class="paper" data-event="outing">
                        <p>Outing</p>
                    </a></div>
            </div>

            <div class="paperRow bottomRow">
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="950"><a href="#"
                        class="paper" data-event="midYear">
                        <p>Mid-Year</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="1100"><a href="#"
                        class="paper" data-event="comptition">
                        <p>Competition</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="1250"><a href="#"
                        class="paper" data-event="league">
                        <p>League</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="1400"><a href="#"
                        class="paper" data-event="academic">
                        <p>Academic</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="1550"><a href="#"
                        class="paper" data-event="confrence">
                        <p>Conference</p>
                    </a></div>
                <div class="paperWrapper" data-aos="zoom-in" data-aos-duration="600" data-aos-delay="1700"><a href="#"
                        class="paper" data-event="closing">
                        <p>Closing</p>
                    </a></div>
            </div>
        </section>

        <!-- ================= Book ================= -->
        <section class="bookSection" aria-label="Magic Book Interaction" data-aos="fade-up" data-aos-duration="1000">
            <div class="bookContainer">
                <img src="assets/img/book_bg.png" data-aos="flip-up" data-aos-duration="1500" data-aos-delay="300"
                    alt="Magic Book" class="bookBg" loading="lazy">
                <figure class="imageFrame left" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="800">
                    <img id="bookImageLeft" src="assets/img/opening/book1.jpg" alt="Magic Content Left" loading="lazy">
                    <!-- <div class="comingSoonText">Coming</div> -->
                    <div class="flashOverlay"></div>
                </figure>
                <figure class="imageFrame right" data-aos="fade-left" data-aos-duration="1200" data-aos-delay="800">
                    <img id="bookImageRight" src="assets/img/opening/book2.jpg" alt="Magic Content Right"
                        loading="lazy">
                    <!-- <div class="comingSoonText">Soon</div> -->
                    <div class="flashOverlay"></div>
                </figure>
            </div>
        </section>


        <!-- ================= Slider Section ================= -->
        <section class="eventsSection" aria-label="Events" data-aos="fade-up" data-aos-duration="1000">
            <div class="eventsHeader" data-aos="zoom-in" data-aos-duration="800" data-aos-delay="200">
                <div class="dividerLine left"></div>
                <h2 class="eventsTitle">Our Events</h2>
                <div class="dividerLine right"></div>
            </div>
            <div class="sliderContainer" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <button class="sliderBtn prev" aria-label="Previous Slide"></button>
                <div class="cardsWrapper">
                    <article class="sliderCard slot0 level2">
                        <!-- JS هيحط صورة Slider هنا -->
                        <img class="imgPrimary" id="img0" loading="lazy">
                        <img class="imgSecondary" loading="lazy">
                    </article>
                    <article class="sliderCard slot1 level1">
                        <img class="imgPrimary" id="img1" loading="lazy">
                        <img class="imgSecondary" loading="lazy">
                    </article>
                    <article class="sliderCard slot2 active">
                        <img class="imgPrimary" id="img2" loading="lazy">
                        <img class="imgSecondary" loading="lazy">
                    </article>
                    <article class="sliderCard slot3 level1">
                        <img class="imgPrimary" id="img3" loading="lazy">
                        <img class="imgSecondary" loading="lazy">
                    </article>
                    <article class="sliderCard slot4 level2">
                        <img class="imgPrimary" id="img4" loading="lazy">
                        <img class="imgSecondary" loading="lazy">
                    </article>
                </div>
                <button class="sliderBtn next" aria-label="Next Slide"></button>
            </div>
        </section>
        <div class="sectionDivider" id="cardsDivider"></div>
        <!-- ================= Cards Section ================= -->
        <section class="polaroidGallery" aria-label="Photo Gallery" data-aos="fade-up" data-aos-duration="1000">
            <div class="polaroidContainer" id="cardsContainer" data-aos="zoom-in" data-aos-duration="1000"
                data-aos-delay="200">

            </div>
        </section>


        <!-- ================= Coming Soon Popup ================= -->
        <div id="comingSoonModal" class="modalOverlay" aria-hidden="true">
            <div class="modalContent card">
                <h2 class="modalTitle">Coming Soon</h2>
                <div class="sectionDivider"></div>
                <div class="modalBody">
                    <p class="modalText">We are preparing something magical for you.</p>
                </div>
                <button id="closeModalBtn" class="btn btnPrimary" style="width: 100%; margin-top: 20px;">Go
                    Back</button>
            </div>
        </div>
        <!-- ================= Lightbox Modal ================= -->
        <div id="lightboxModal" class="lightboxOverlay" aria-hidden="true">
            <span class="lightboxClose">&times;</span>
            <img id="lightboxImage" class="lightboxImage" src="" alt="Magnified View" loading="lazy">
            <button id="lightboxBackBtn" class="lightboxBack" aria-label="Back to Gallery">&larr;</button>
        </div>



    </main>

    <?php include 'includes/footer.php'; ?>

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
    <script src="assets/js/gallary.js?v=<?php echo time(); ?>" defer></script>
</body>

</html>
