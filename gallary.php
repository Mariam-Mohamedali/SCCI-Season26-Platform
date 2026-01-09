<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI-Gallery</title>
    <link rel="icon" href="assets/icons/logoSCCI.png" type="image/png">

    <!-- font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/root.css">
     <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/gallary.css">
      <link rel="stylesheet" href="assets/css/footer.css" >

</head>

<body>
<?php include 'includes/nav.php'; ?>

    <main>

        <!-- ================= Papers ================= -->
        <section class="paperContainer" id="paperContainer" aria-label="Paper Animation">
            <div class="paperRow topRow">
                <div class="paperWrapper"><a href="#" class="paper" data-event="opening">
                        <p>Opening</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="ushering">
                        <p>Ushering</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="firstSession">
                        <p>First Session</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="57357">
                        <p>57357</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="outing">
                        <p>Outing</p>
                    </a></div>
            </div>

            <div class="paperRow bottomRow">
                <div class="paperWrapper"><a href="#" class="paper" data-event="midYear">
                        <p>Mid-Year</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="comptition">
                        <p>Competition</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="league">
                        <p>League</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="academic">
                        <p>Academic</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="confrence">
                        <p>Conference</p>
                    </a></div>
                <div class="paperWrapper"><a href="#" class="paper" data-event="closing">
                        <p>Closing</p>
                    </a></div>
            </div>
        </section>

        <!-- ================= Book ================= -->
        <section class="bookSection" aria-label="Magic Book Interaction">
            <div class="bookContainer">
                <img src="assets/img/book_bg.png" alt="Magic Book" class="bookBg" loading="lazy">
                <figure class="imageFrame left">
                    <img id="bookImageLeft" src="assets/img/opening/book1.jpg" alt="Magic Content Left" loading="lazy">
                    <!-- <div class="comingSoonText">Coming</div> -->
                    <div class="flashOverlay"></div>
                </figure>
                <div class="pageText textLeft">click on the image</div>
                <figure class="imageFrame right">
                    <img id="bookImageRight" src="assets/img/opening/book2.jpg" alt="Magic Content Right"
                        loading="lazy">
                    <!-- <div class="comingSoonText">Soon</div> -->
                    <div class="flashOverlay"></div>
                </figure>
                <div class="pageText textRight">to see the magic</div>
            </div>
        </section>


        <!-- ================= Slider Section ================= -->
        <section class="eventsSection" aria-label="Events">
            <div class="eventsHeader">
                <div class="dividerLine left"></div>
                <h2 class="eventsTitle">Our Events</h2>
                <div class="dividerLine right"></div>
            </div>
            <div class="sliderContainer">
                <button class="sliderBtn prev" aria-label="Previous Slide"></button>
                <div class="cardsWrapper">
                    <article class="sliderCard slot0 level2">
                        <!-- JS هيحط صورة Slider هنا -->
                        <img class="imgPrimary" id="img0">
                        <img class="imgSecondary">
                    </article>
                    <article class="sliderCard slot1 level1">
                        <img class="imgPrimary" id="img1">
                        <img class="imgSecondary">
                    </article>
                    <article class="sliderCard slot2 active">
                        <img class="imgPrimary" id="img2">
                        <img class="imgSecondary">
                    </article>
                    <article class="sliderCard slot3 level1">
                        <img class="imgPrimary" id="img3">
                        <img class="imgSecondary">
                    </article>
                    <article class="sliderCard slot4 level2">
                        <img class="imgPrimary" id="img4">
                        <img class="imgSecondary">
                    </article>
                </div>
                <button class="sliderBtn next" aria-label="Next Slide"></button>
            </div>
        </section>
        <div class="sectionDivider" id="cardsDivider"></div>
        <!-- ================= Cards Section ================= -->
        <section class="polaroidGallery" aria-label="Photo Gallery">
            <div class="polaroidContainer" id="cardsContainer">

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
            <img id="lightboxImage" class="lightboxImage" src="" alt="Magnified View">
        </div>



    </main>

    <script src="assets/js/gallary.js?v=<?php echo time(); ?>" defer></script>
</body>
<?php include 'includes/footer.php'; ?>

</html>