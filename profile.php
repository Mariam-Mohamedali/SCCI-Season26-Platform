<?php
include('./includes/nav.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /SCCI-Season26-Platform/auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: /SCCI-Season26-Platform/auth/login.php");
    exit();
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

// Check if user exists
if (!$user) {
    session_destroy();
    header("Location: /SCCI-Season26-Platform/auth/login.php");
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['logout'])) {
    // Validate inputs
    if (isset($_POST['user_name'], $_POST['email'], $_POST['phone'], $_POST['githup'], $_POST['linkedin'])) {
        $user_name = trim($_POST['user_name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $githup = trim($_POST['githup']);
        $linkedin = trim($_POST['linkedin']);
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
        } else {
            // Prepare update query
            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $password = $_POST['password'];
                $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
                
                $update_query = "UPDATE users SET user_name=?, email=?, phone=?, githup=?, linkedin=?, password=? WHERE user_id=?";
                $stmt_update = mysqli_prepare($connect, $update_query);
                mysqli_stmt_bind_param($stmt_update, "ssssssi", $user_name, $email, $phone, $githup, $linkedin, $passwordhashing, $user_id);
            } else {
                $update_query = "UPDATE users SET user_name=?, email=?, phone=?, githup=?, linkedin=? WHERE user_id=?";
                $stmt_update = mysqli_prepare($connect, $update_query);
                mysqli_stmt_bind_param($stmt_update, "sssssi", $user_name, $email, $phone, $githup, $linkedin, $user_id);
            }
            
            if (mysqli_stmt_execute($stmt_update)) {
                $success_message = "Profile updated successfully!";
                // Refresh user data
                $stmt = mysqli_prepare($connect, $select_user);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $run_user = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($run_user);
            } else {
                $error_message = "Error updating profile: " . mysqli_error($connect);
            }
            mysqli_stmt_close($stmt_update);
        }
    } else {
        $error_message = "All fields are required";
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

  <?php if ($success_message): ?>
    <div style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 25px; border-radius: 5px; z-index: 9999; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
      <?php echo htmlspecialchars($success_message); ?>
    </div>
    <script>
      setTimeout(function() {
        document.querySelector('div[style*="fixed"]').style.display = 'none';
      }, 3000);
    </script>
  <?php endif; ?>
  
  <?php if ($error_message): ?>
    <div style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 15px 25px; border-radius: 5px; z-index: 9999; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
      <?php echo htmlspecialchars($error_message); ?>
    </div>
    <script>
      setTimeout(function() {
        document.querySelector('div[style*="fixed"]').style.display = 'none';
      }, 5000);
    </script>
  <?php endif; ?>

  <section class="profileSection">
    <article class="profileCard">

      <!-- Cover -->
      <div class="profileCover">
        <div class="profileImageWrapper">
          <img src="assets/uploadedImages/<?php echo htmlspecialchars($user['image'] ?? 'default.png'); ?>" alt="Profile Photo" class="profileImage"
            loading="lazy">
        </div>
      </div>

      <!-- Content -->
      <div class="profileContent">

        <!-- Name + Settings -->
        <div class="profileHeaderName">
          <h2 class="profileName"><?php echo htmlspecialchars($user['user_name']); ?></h2>

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
                  <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>">
                    <?php echo htmlspecialchars($user['email']); ?>
                  </a>
                </div>
                <!-- LinkedIn -->
                <div class="socialItem">
                                    <?php if (!empty($user['linkedin'])): ?>

                  <i class="fa-brands fa-linkedin"></i>
                  <a href="<?php echo htmlspecialchars($user['linkedin']); ?>" target="_blank">
                    <?php echo htmlspecialchars($user['linkedin']); ?>
                  </a>
                  <?php endif; ?>
                </div>
                <!-- GitHub -->
                <div class="socialItem">
                  <?php if (!empty($user['githup'])): ?>
                  <i class="fa-brands fa-github"></i>
                  <a href="<?php echo htmlspecialchars($user['githup']); ?>" target="_blank">
                    <?php echo htmlspecialchars($user['githup']); ?>
                  </a>
                  <?php endif; ?>
                </div>
                <div class="socialItem">
                  <i class="fa-solid fa-phone"></i>
                  <a href="tel:<?php echo htmlspecialchars($user['phone']); ?>">
                    <?php echo htmlspecialchars($user['phone']); ?>
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
              <div class="infoValue">
                <?php 
                if ($user['role'] == 4) {
                  $dept = !empty($user['committe_name']) ? $user['committe_name'] . " Head" : "Head";
                  echo htmlspecialchars($dept);
                } else {
                  $parts = [];
                  if (!empty($user['committe_name'])) {
                    $parts[] = $user['committe_name'];
                  }
                  if (!empty($user['workshop_name'])) {
                    $parts[] = $user['workshop_name'];
                  }
                  if (!empty($parts)) {
                    echo htmlspecialchars(implode(' - ', $parts));
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
            <input type="text" name="user_name" id="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>"
              placeholder="Enter your name" required>
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
            <input type="text" name="githup" id="githup" value="<?php echo htmlspecialchars($user['githup']); ?>"
              placeholder="Enter your GitHub" required>
          </div>

          <div class="input-group">
            <label for="linkedin">LinkedIn</label>
            <input type="text" name="linkedin" id="linkedin" value="<?php echo htmlspecialchars($user['linkedin']); ?>"
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
  <?php include './includes/footer.php'; ?>

  <script src="assets/js/profile.js" defer></script>
  <script src="assets/js/all.min.js" defer></script>
</body>

</html>
