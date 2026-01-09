<?php
include 'includes/config.php';

$user_id = $_SESSION['user_id'];

$select_user = "SELECT u.user_name, u.email, u.image, u.githup, u.phone, u.password, u.linkedin, c.committe_name, w.workshop_name FROM users u JOIN committees c ON u.committee_id = c.committee_id JOIN workshops w ON u.workshop_id = w.workshop_id WHERE u.user_id = $user_id AND u.status=1";
$run_user = mysqli_query($connect, $select_user);
$user = mysqli_fetch_assoc($run_user);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_name = mysqli_real_escape_string($connect, $_POST['user_name']);
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $phone = mysqli_real_escape_string($connect, $_POST['phone']);
  $githup = mysqli_real_escape_string($connect, $_POST['githup']);
  $linkedin = mysqli_real_escape_string($connect, $_POST['linkedin']);

  $update_fields = "user_name='$user_name', email='$email', phone='$phone', githup='$githup', linkedin='$linkedin'";
  if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $update_fields .= ", password='$passwordhashing'";
  }

  $update_query = "UPDATE users SET $update_fields WHERE user_id=$user_id";
  if (mysqli_query($connect, $update_query)) {
    // Refresh user data
    $run_user = mysqli_query($connect, $select_user);
    $user = mysqli_fetch_assoc($run_user);
  }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile – SCCI 26</title>

  <!-- Root -->
  <link rel="stylesheet" href="assets/css/root.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link rel="stylesheet" href="assets/css/profile.css?v=<?php echo time(); ?>">
  <script src="assets/js/profile.js"></script>

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
</head>

<body>

  <section class="profileSection">
    <article class="profileCard">

      <!-- Cover -->
      <div class="profileCover">
        <div class="profileImageWrapper">
          <img src="assets/img/uploadedImages/<?php echo $user['image']; ?>" alt="Profile Photo" class="profileImage"
            loading="lazy">
        </div>
      </div>

      <!-- Content -->
      <div class="profileContent">

        <!-- Name + Settings -->
        <div class="profileHeaderName">
          <h2 class="profileName"><?php echo $user['user_name']; ?></h2>

          <div class="settingsContainer">
            <span class="settingsIcon">
              <i class="fa-solid fa-gear"></i>
            </span>

            <!-- Popup -->
            <div class="settingsMenu">
              <img src="assets/img/paperWorkshop.png" class="settingsPaperImg" loading="lazy" alt="Settings Paper">

              <div class="settingsLinks">
                <a href="#" class="settingsLink" id="openEditProfile">
                  <i class="fa-solid fa-pen-to-square"></i>
                  Edit
                </a>
<form method="POST">
                <a href="" class="settingsLink">
                  <i class="fa-solid fa-right-from-bracket"></i>
                 <button type="submit" name="logout">logout</button>
                </a>
</form>
              </div>
            </div>
          </div>
        </div>

        <!-- Info Papers -->
        <div class="infoPapersContainer">

          <!-- Contact -->
          <div class="infoPaperWrapper">
            <img src="assets/img/infoPaper.png" class="infoPaperImg" loading="lazy" alt="">

            <div class="infoPaperContent">
              <div class="infoLabel">Contacts</div>
              <div class="profileSocial">
                <!-- Email -->
                <div class="socialItem">
                  <i class="fa-solid fa-envelope"></i>
                  <a href="mailto:<?php echo $user['email']; ?>">
                    <?php echo $user['email']; ?>
                  </a>
                </div>
                <!-- LinkedIn -->
                <div class="socialItem">
                  <i class="fa-brands fa-linkedin"></i>
                  <a href="https://linkedin.com/in/example" target="_blank">
                    <?php echo $user['linkedin']; ?>
                  </a>
                </div>
                <!-- GitHub -->
                <div class="socialItem">
                  <i class="fa-brands fa-github"></i>
                  <a href="https://github.com/example" target="_blank">
                    <?php echo $user['githup']; ?>
                  </a>
                </div>
                <div class="socialItem">
                  <i class="fa-solid fa-phone"></i>
                  <a href="tel:<?php echo $user['phone']; ?>">
                    <?php echo $user['phone']; ?>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Department -->
          <div class="infoPaperWrapper">
            <img src="assets/img/infoPaper.png" class="infoPaperImg" loading="lazy" alt="">

            <div class="infoPaperContent">
              <div class="infoLabel">Department</div>
              <div class="infoValue"><?php echo $user['committe_name'] . ' - ' . $user['workshop_name']; ?></div>
            </div>
          </div>

        </div>
      </div>
    </article>
  </section>


  <!-- Edit Profile Popup -->
  <section>
    <form method="POST" action="">
      <div class="editProfileOverlay" id="editProfileOverlay">
        <div class="editProfilePopup">

          <img src="assets/img/infoPaper.png" class="editPaperImg" alt="">

          <h3 class="editTitle">Edit Profile</h3>

          <div class="input-group">
            <label for="user_name">Name</label>
            <input type="text" name="user_name" id="user_name" value="<?php echo $user['user_name']; ?>"
              placeholder="Enter your name" required>
          </div>

          <div class="input-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>"
              placeholder="Enter your email" required>
          </div>

          <div class="input-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" value="<?php echo $user['phone']; ?>"
              placeholder="Enter your phone" required>
          </div>

          <div class="input-group">
            <label for="password">password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>
          </div>

          <div class="input-group">
            <label for="githup">GitHub</label>
            <input type="text" name="githup" id="githup" value="<?php echo $user['githup']; ?>"
              placeholder="Enter your GitHub" required>
          </div>

          <div class="input-group">
            <label for="linkedin">LinkedIn</label>
            <input type="text" name="linkedin" id="linkedin" value="<?php echo $user['linkedin']; ?>"
              placeholder="Enter your LinkedIn" required>
          </div>

          <button class="saveProfile">Save Changes</button>
          <button type="button" class="closePopup">Close</button>
        </div>
      </div>
    </form>
  </section>







  <!-- History Section -->

  <section class="historySection">
    <div class="card-container">
      <div class="vertical-line"></div>

      <div class="role-item">
        <div class="diamond"></div>
        <div class="role-content">
          <h3 class="role-title">IT Head</h3>
          <p class="role-description">The IT head has a lot of responsibilities to take care of, like making the system
            all the SCU user in their daily bases, he leads the IT members to accomplish this goal.</p>
        </div>
      </div>

      <div class="role-item">
        <div class="diamond"></div>
        <div class="role-content">
          <h3 class="role-title">IT Member</h3>
          <p class="role-description">The IT member makes the system all the SCU user in their daily bases, and support
            the workshops</p>
        </div>
      </div>

      <div class="role-item">
        <div class="diamond"></div>
        <div class="role-content">
          <h3 class="role-title">DEYO Participant</h3>
          <p class="role-description">They take course on how to build websites from scratch using cutting edge
            technologies, and then participate in the conference</p>
        </div>
      </div>
    </div>
  </section>
  </main>

  <script src="assets/js/profile.js" defer></script>
  <script src="assets/js/all.min.js" defer></script>
</body>

</html>
