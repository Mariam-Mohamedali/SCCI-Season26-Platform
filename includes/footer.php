<?php  ?>
<footer>
  <div class="footerCont">
    <div class="footerLeft footerWide">
      <img loading="lazy" src="./assets/icons/logoSCCI.png" alt="SCCI img" />
    </div>
    <div class="contactForm footerForm">
      <h3>Quick Links</h3>
      <section>

        <a href="./home.php">home</a>
        <a href="./about.php">about us</a>
        <a href="./gallary.php">gallery</a>
        <a href="./workshops.php">workshops</a>
        <a href="./crew.php">crew</a>

        <?php if (isset($_SESSION['user_id']) && in_array($_SESSION['role'], [1,2,3,4])): ?>
        <a href="./profile.php">profile</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="./auth/login.php">login</a>
        <?php endif; ?>
      </section>
    </div>
    <div class="contactForm footerForm">
      <h3>Our Committees</h3>
      <section class="footerCrew">
        <a href="./crewDetails.php?committee_id=3">AC</a>
        <a href="./crewDetails.php?committee_id=6">IT</a>
        <a href="./crewDetails.php?committee_id=10">MP</a>
        <a href="./crewDetails.php?committee_id=7">DD</a>
        <a href="./crewDetails.php?committee_id=12">HR</a>
        <a href="./crew.php">more..</a>
      </section>
    </div>
    <div class="contactForm socialForm">
      <h3>social media</h3>
      <div class="footerSocial">
        <a target="_blank" href="https://www.facebook.com/scci.cu"><i class="fa-brands fa-facebook"></i> <span
            class="socialText"> facebook</span></a>
        <a target="_blank" href="https://www.instagram.com/scci.cu/"><i class="fa-brands fa-instagram"></i> <span
            class="socialText"> instagram</span></a>
        <a target="_blank" href="https://www.linkedin.com/in/scci-cu-478a09390/"><i class="fa-brands fa-linkedin"></i>
          <span class="socialText"> linkedin</span></a>
        <a target="_blank" href=""><i class="fa-solid fa-envelope"></i> <span class="socialText">
            scci2026@gmail.com</span></a>
      </div>
    </div>
  </div>
  <div class="copy">
    <p>
      SCCI - Shaping the Arc of Learning
    </p>
  </div>
</footer>