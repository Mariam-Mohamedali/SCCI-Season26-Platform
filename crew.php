

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SCCI - Crew</title>
  <link rel="icon" href="./assets/icons/logoSCCI.png" type="image/png">

    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/css/all.min.css" />
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="./assets/css/root.css" />
    <link rel="stylesheet" href="./assets/css/navbar.css" />
    <link rel="stylesheet" href="./assets/css/footer.css" />
    <link rel="stylesheet" href="./assets/css/crew.css" />
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
</head>

<body >

 <?php include('./includes/nav.php'); ?>


    <section class="sectionBlock container">
        <h1 class="mainTitle" data-aos="zoom-in">President</h1>
        <hr>
        <div class="presidentGrid">
            <div class="flipCard " data-aos="flip">
                <div class="flipInner">
                    <div class="flipSide flipFront">
                        <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                    </div>
                    <div class="flipSide flipBack" data-title="PRESIDENT">
                         <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Mohamed Ali.jpg" alt="Mohamed Ali" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Ali</h3>
                                    </div>
                            </div>
                    </div>
                </div>
            </div >

            <div class="paperScroll js-auto-flip" data-aos="fade-left">
                <div class="paperContent">
                    <h3 class="paperTitle">Job Description</h3>
                    <p class=" textPrimary">
                        Developing Members In Negotiation, Persuasive And Communication Skills.
                        Helping Members To Discover Their Own Skills And What Can They Do.
                        Responsible For The Budget And The Cash Inflow And Outflow.
                        Making CR Outing For All Members To Create Connections Between CR Members.
                        After Each Phase Creating One To One Meeting For Each Member To Evaluate The Members And
                        Incentivize Them.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="sectionBlock container">
        <h2 class="sectionTitle textPrimary" data-aos="fade-up">High Board</h2>
        <hr>

        <div class="cardsGrid">

            <div class="boardItem js-auto-flip" data-aos="fade-up" data-aos-delay="400">
                <h3 class="roleTitle">Technical</h3>
                <div class="flipCard  " data-aos="flip">
                    <span class="sideLabel left">IT DD</span>
                    <span class="sideLabel right purpleText">MP SMM</span>
                    <div class="flipInner  ">
                        <div class="flipSide  flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                        </div>
                        <div class="flipSide flipBack" data-title="TECHNICAL">
                            <div class="backCard">

                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Marwan Wael.jpg" loading="lazy" alt="Marwan Wael" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Marwan Wael</h3>
                                    </div>
                                   
                                </div>
                            </div>
                    </div>
                     
                </div>
                <a href="javascript:void(0)" onclick="openModal(this.closest('.boardItem'))" class="btn btn-primary ">Discover More</a>

                <!-- Sub Cards Container -->
                <div class="subCrewGrid hiddenGrid">
                    <!-- 1. IT -->
                    <div class="subCard">
                       <span class="subRoleTitle">IT</span>
                       <div class="flipCard smCard card1" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront">
                                <img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" />
                            </div>
                               <div class="flipSide flipBack" data-title="IT">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Mahmoud Alaam.jpg" alt="Mahmoud Alaam" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mahmoud Alaam</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>
                       <a href="crewDetails.php?committee_id=6" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 2. DD -->
                    <div class="subCard">
                       <span class="subRoleTitle">DD</span>
                       <div class="flipCard smCard card2" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                               <div class="flipSide flipBack" data-title="DD">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Mohamed El Hossiny.jpg" alt="Mohamed El Hossiny" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed El Hossiny</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>
                       <a href="crewDetails.php?committee_id=7" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 3. MP -->
                    <div class="subCard">
                       <span class="subRoleTitle">MP</span>
                       <div class="flipCard smCard card3" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                               <div class="flipSide flipBack" data-title="MP">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Omar Ahmed.jpg" alt="Omar Ahmed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Omar Ahmed</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=10" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 4. SMM -->
                    <div class="subCard">
                       <span class="subRoleTitle">SMM</span>
                       <div class="flipCard smCard card4" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy" alt="backCard" /></div>
                               <div class="flipSide flipBack" data-title="SMM">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Nour Mohamed.jpg" alt="Nour Mohamed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Nour Mohamed</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=5" class="btn btn-primary ">Know Us !</a>
                    </div>
                </div>
            </div>

            <div class="boardItem" data-aos="fade-up" data-aos-delay="200">
                <h3 class="roleTitle">Academic Committee</h3>
                <div class="flipCard" data-aos="flip">
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" alt="backCard" />
                        </div>
                        <div class="flipSide flipBack" data-title="ACADEMIC">
                            <div class="backCard">

                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Mohamed Ahmed.jpg" alt="Mohamed Ahmed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Ahmed</h3>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a href="crewDetails.php?committee_id=3" class="btn btn-primary ">Know Us !</a>
            </div>

            <div class="boardItem" data-aos="fade-up" data-aos-delay="300">
                <h3 class="roleTitle">Human Resource</h3>
                <div class="flipCard" data-aos="flip">
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" alt="backCard" />
                        </div>
                        <div class="flipSide flipBack" data-title="HR">
                            <div class="backCard">

                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Alaa Aboelazm.jpg" alt="Alaa Aboelazm" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Alaa Aboelazm</h3>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a href="crewDetails.php?committee_id=12" class="btn btn-primary ">Know Us !</a>
            </div>
            <div class="boardItem" data-aos="fade-up" data-aos-delay="400">
                <h3 class="roleTitle">External Relations</h3>
                <div class="flipCard" data-aos="flip">
                    
                    
                    <div class="flipInner">
                        <div class="flipSide flipFront">
                            <img src="./assets/img/crew/backCardCrew.png" loading="lazy">
                        </div>
                        <div class="flipSide flipBack" data-title="ER">
                            <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Mohamed Hesham.jpg" alt="Mohamed Hesham" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Mohamed Hesham</h3>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="openModal(this.closest('.boardItem'))" class="btn btn-primary ">Discover More</a>
                <!-- Sub Cards Container -->
                <div class="subCrewGrid hiddenGrid">
                    <!-- 1. BD -->
                    <div class="subCard">
                       <span class="subRoleTitle">BD</span>
                       <div class="flipCard smCard card1" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                               <div class="flipSide flipBack" data-title="BD">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Omar Hesham.jpg" alt="Omar Hesham" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Omar Hesham</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=4" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 2. L -->
                    <div class="subCard">
                       <span class="subRoleTitle">L</span>
                       <div class="flipCard smCard card2" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                               <div class="flipSide flipBack" data-title="LOGISTICS">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Asser El-Sayed.jpg" alt="Asser El-Sayed" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Asser El-Sayed</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=9" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 3. CR -->
                    <div class="subCard">
                       <span class="subRoleTitle">CR</span>
                       <div class="flipCard smCard card3" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                               <div class="flipSide flipBack" data-title="CR">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Belal Omar.jpg" alt="Belal Omar" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Belal Omar</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=8" class="btn btn-primary ">Know Us !</a>
                    </div>
                    <!-- 4. PR -->
                    <div class="subCard">
                       <span class="subRoleTitle">PR</span>
                       <div class="flipCard smCard card4" data-aos="flip">
                           <div class="flipInner">
                               <div class="flipSide flipFront"><img src="./assets/img/crew/backCardCrew.png" loading="lazy"></div>
                               <div class="flipSide flipBack" data-title="PR">
                                 <div class="backCard">
                                    <div class="memberImageContainer">
                                        <img src="./assets/uploadedImages/Yasmine Gawish.jpg" alt="Yasmine Gawish" class="memberImage" />
                                    </div>
                                    <div class="memberName">
                                        <h3>Yasmine Gawish</h3>
                                    </div>
                            </div>
                               </div>
                           </div>
                       </div>   
                       <a href="crewDetails.php?committee_id=11" class="btn btn-primary ">Know Us !</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Overlay for Blur Effect -->
    <div class="pageOverlay" onclick="closeModal()"></div>

    <!-- Scroll Top Button -->
    <div class="scrollTopBtn" id="scrollTopBtn">
        &#8593;
    </div>

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
            once: false,
            offset: 50,
            duration: 1000,
            easing: 'ease-in-out'
        });
    </script>
    <script src="./assets/js/index.js"></script>
    <script src="./assets/js/crew.js"></script>
    <script src="./assets/js/all.min.js"></script>
</body>
<?php
include './includes/footer.php';
?>

</html>
