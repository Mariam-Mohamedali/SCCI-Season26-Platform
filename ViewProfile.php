<?php
include './includes/config.php';

// Check if user is logged in

if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
}

// Fetch user data using prepared statement
$select_user = "SELECT u.user_name, u.email, u.image, u.githup, u.phone, u.password, u.linkedin, u.role, c.committe_name, w.workshop_name
                FROM users u
                LEFT JOIN committees c ON u.committee_id = c.committee_id
                LEFT JOIN workshops w ON u.workshop_id = w.workshop_id
                WHERE u.user_id = ? AND u.status=1";
$stmt = mysqli_prepare($connect, $select_user);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$run_user = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($run_user);

// Determine image path based on role
$imagePath = $user['image'] ?? 'default.png';
if (isset($user['role']) && $user['role'] == 4 or $user['role'] == 5) {
  $imagePath = 'SCCI Board/' . $imagePath;
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
  <meta property="og:image" content="./assets/images/seo/profile.png" />
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
  <link rel="stylesheet" href="./assets/css/root.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/profile.css?v=<?php echo time(); ?>">
  <!-- aos -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <script src="./assets/js/profile.js"></script>
  <title>SCCI - <?php echo htmlspecialchars($user['user_name']); ?> Profile</title>
</head>

<body>

<?php
include('./includes/nav.php');
    
// Check if user is logged in

if (isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];  
}

// Fetch user data using prepared statement
$select_user = "SELECT u.user_name, u.email, u.image, u.githup, u.phone, u.password, u.linkedin, u.role, c.committe_name, w.workshop_name 
                FROM users u 
                LEFT JOIN committees c ON u.committee_id = c.committee_id 
                LEFT JOIN workshops w ON u.workshop_id = w.workshop_id 
                WHERE u.user_id = ? AND u.status=1";
$stmt = mysqli_prepare($connect, $select_user);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$run_user = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($run_user);

// Determine image path based on role
$imagePath = $user['image'] ?? 'default.png';
if (isset($user['role']) && $user['role'] == 4 or $user['role'] == 5) {
  $imagePath = 'SCCI Board/' . $imagePath;
}
?>


  <section class="profileSection">
    <article class="profileCard">

      <!-- Cover -->
      <div class="profileCover">
        <div class="profileImageWrapper">
          <img src="assets/uploadedImages/<?php echo htmlspecialchars($imagePath); ?>" alt="Profile Photo"
            class="profileImage" loading="lazy">
        </div>
      </div>

      <!-- Content -->
      <div class="profileContent">

        <!-- Name + Settings -->
        <div class="profileHeaderName">
          <h2 class="profileName"><?php echo $user['user_name']; ?></h2>


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
                <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="email-text">
                  <?php echo htmlspecialchars($user['email']); ?>
                </a>
              </div>
              <!-- Phone -->
               <div class="socialItem">
                  <i class="fa-solid fa-phone"></i>
                  <a href="tel:0<?php echo htmlspecialchars($user['phone']); ?>">
                    0<?php echo htmlspecialchars($user['phone']); ?>
                  </a>
              </div>
              <!-- LinkedIn -->
              <div class="socialItem">
                <?php if (!empty($user['linkedin'])): ?>

                  <i class="fa-brands fa-linkedin"></i>
                  <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" target="_blank">
                    LinkedIn
                  </a>
                <?php endif; ?>
              </div>
              <!-- GitHub -->
              <div class="socialItem">
                <?php if (!empty($user['githup'])): ?>
                  <i class="fa-brands fa-github"></i>
                  <a href="<?php echo htmlspecialchars($user['githup']); ?>" target="_blank">
                    GitHub
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Department -->
        <div class="infoPaperWrapper">
          <img src="assets/img/infoPaper.png" class="infoPaperImg" loading="lazy" alt="">

          <div class="infoPaperContent">
            <div class="infoLabel">Department</div>
            <div class="infoValue">
                <?php 
                if ($user['role'] == 4 || $user['role'] == 5) {
                  $dept = !empty($user['committe_name']) ? $user['committe_name'] . " Head" : "Head";
                  echo htmlspecialchars($dept);
                } else {
                
                  if (!empty($user['committe_name'])) {
                    echo "<div>" . htmlspecialchars($user['committe_name']) . "</div>";
                  }
                  
                  if (!empty($user['committe_name']) && !empty($user['workshop_name'])) {
                      echo "<br>";
                  }

                  if (!empty($user['workshop_name'])) {
                    echo "<div>" . htmlspecialchars($user['workshop_name']) . "</div>";
                  }
                }
                    ?>
            </div>
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
            <input type="text" name="user_name" id="user_name"
              value="<?php echo htmlspecialchars($user['user_name']); ?>" placeholder="Enter your name" required>
          </div>

          <div class="input-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
              placeholder="Enter your email" required>
          </div>

          <div class="input-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
              placeholder="Enter your phone" required>
          </div>

          <div class="input-group">
            <label for="password">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" placeholder="Enter new password (optional)">
          </div>

          <div class="input-group">
            <label for="githup">GitHub</label>
            <input type="text" name="githup" id="githup" value="<?php echo htmlspecialchars($user['githup'] ?? ''); ?>"
              placeholder="Enter your GitHub" required>
          </div>

          <div class="input-group">
            <label for="linkedin">LinkedIn</label>
            <input type="text" name="linkedin" id="linkedin" value="<?php echo htmlspecialchars($user['linkedin'] ?? ''); ?>"
              placeholder="Enter your LinkedIn" required>
          </div>

          <button class="saveProfile">Save Changes</button>
          <button type="button" class="closePopup">Close</button>
        </div>
      </div>
    </form>
  </section>
  
  </main>
  <?php include './includes/footer.php'; ?>

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
  <script src="assets/js/profile.js" defer></script>
  <script src="assets/js/all.min.js" defer></script>
</body>

</html>