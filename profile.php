<?php
ob_start();
include './includes/config.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location:auth/login.php");
  exit();
}
$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Handle logout
if (isset($_POST['logout'])) {
  session_destroy();
  header("Location: auth/login.php");
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
  header("Location: auth/login.php");
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
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    $errors = [];

    // Build Dynamic Update Query
    $updates = [];
    $params = [];
    $types = "";

    // Name (Required)
    if ($user_name !== $user['user_name']) {
      if (strlen($user_name) >= 3) {
        $updates[] = "user_name = ?";
        $params[] = $user_name;
        $types .= "s";
      } else {
        $errors[] = "Name must be at least 3 characters.";
      }
    }

    // Email (Required)
    if ($email !== $user['email']) {
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $updates[] = "email = ?";
        $params[] = $email;
        $types .= "s";
      } else {
        $errors[] = "Invalid email format.";
      }
    }

    // Phone (Required)
    if ($phone !== $user['phone']) {
      if (preg_match("/^01[0-2,5]{1}[0-9]{8}$/", $phone)) {
        $updates[] = "phone = ?";
        $params[] = $phone;
        $types .= "s";
      } else {

      }
    }

    // Optional Fields: GitHub
    if ($githup !== ($user['githup'] ?? '')) {
      $updates[] = "githup = ?";
      $params[] = $githup;
      $types .= "s";
    }

    // Optional Fields: LinkedIn
    if ($linkedin !== ($user['linkedin'] ?? '')) {
      $updates[] = "linkedin = ?";
      $params[] = $linkedin;
      $types .= "s";
    }

    // Password (Must provide confirm if setting new)
    if (!empty($password)) {
      if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
      } elseif (!preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
        $errors[] = "Password must contain uppercase, lowercase, and special characters.";
      } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
      } else {
        $updates[] = "password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
        $types .= "s";
      }
    }

    if (empty($errors)) {
      if (!empty($updates)) {
        $sql_parts = implode(", ", $updates);
        $update_query = "UPDATE users SET $sql_parts WHERE user_id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt_update = mysqli_prepare($connect, $update_query);
        mysqli_stmt_bind_param($stmt_update, $types, ...$params);

        if (mysqli_stmt_execute($stmt_update)) {
          $_SESSION['msg'] = "Profile updated successfully!";
        } else {
          $_SESSION['err'] = "Error updating profile: " . mysqli_error($connect);
        }
        mysqli_stmt_close($stmt_update);
      } else {
        $_SESSION['err'] = "No changes detected.";
      }
    } else {
      $_SESSION['err'] = implode("<br>", $errors);
    }
    header("Location: profile.php");
    exit();
  } else {
    $_SESSION['err'] = "Required fields are missing.";
    header("Location: profile.php");
    exit();
  }
}

// Get and clear session messages
$success_message = $_SESSION['msg'] ?? '';
$error_message = $_SESSION['err'] ?? '';
unset($_SESSION['msg'], $_SESSION['err']);

// Determine image path based on role
$imagePath = $user['image'] ?? 'default.png';
if (isset($user['role']) && ($user['role'] == 4 or $user['role'] == 5)) {
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
  <meta property="og:description"
    content="SCCI is the university's premier student community, uniting creative minds to build the future of tech, media, business, and entrepreneurship." />
  <meta name="keywords"
    content="SCCI, Student Community, Creative Minds, Tech, Media, Business, Entrepreneurship, University, Community, College" />
  <!-- google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet" />
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
  ?>
  <main>
    <?php
    $final_success = $success_message ?: ($_SESSION['msg'] ?? '');
    if ($final_success): ?>
      <div
        style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 25px; border-radius: 5px; z-index: 9999; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
        <?php echo htmlspecialchars($final_success); ?>
      </div>
      <script>
        setTimeout(function () {
          const msgDiv = document.querySelector('div[style*="fixed"]');
          if (msgDiv) msgDiv.style.display = 'none';
        }, 3000);
      </script>
      <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <?php if ($error_message): ?>
      <div
        style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 15px 25px; border-radius: 5px; z-index: 9999; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
        <?php echo $error_message; // No htmlspecialchars because it contains <br> ?>
      </div>
      <script>
        setTimeout(function () {
          const errDiv = document.querySelectorAll('div[style*="fixed"]');
          errDiv.forEach(d => d.style.display = 'none');
        }, 5000);
      </script>
    <?php endif; ?>

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
            <h2 class="profileName"><?php echo htmlspecialchars($user['user_name']); ?></h2>

            <div class="settingsContainer">
              <span class="settingsIcon">
                <i class="fa-solid fa-gear"></i>
              </span>

              <!-- Popup -->
              <div class="settingsMenu">
                <div class="settingsCard">
                  <a href="#" class="settingsLink" id="openEditProfile">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Edit</span>
                  </a>
                  <form method="POST" style="margin: 0; padding: 0;">
                    <button type="submit" name="logout" class="settingsLink logoutBtn">
                      <i class="fa-solid fa-right-from-bracket"></i>
                      <span>Logout</span>
                    </button>
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
                <div class="infoValue">
                  <!-- Email -->
                  <div class="socialItem">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="email-text">
                      <?php echo htmlspecialchars($user['email']); ?>
                    </a>
                  </div>
                  <!-- phone -->
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
                  if ($user['role'] == 4 OR $user['role'] == 5) {
                    $dept = !empty($user['committe_name']) ? $user['committe_name'] . " Head" : "Head";
                    echo htmlspecialchars($dept);
                  } else {

                    if (!empty($user['committe_name'])) {
                      echo "<div>" . htmlspecialchars($user['committe_name']) . "</div>";
                    }

                    if (!empty($user['committe_name']) && !empty($user['workshop_name'])) {

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
    <section class="editProfileSection">
      <form method="POST" action="">
        <div class="editProfileOverlay" id="editProfileOverlay">
          <div class="editProfilePopup">

            <img src="assets/img/infoPaper.png" class="editPaperImg" alt="">

            <h3 class="editTitle">Edit Profile</h3>

            <div class="input-group">
              <label for="user_name">Name</label>
              <input type="text" name="user_name" id="user_name"
                value="<?php echo htmlspecialchars($user['user_name']); ?>" placeholder="Enter your name">
              <span class="error-msg" id="error-user_name"></span>
            </div>

            <div class="input-group">
              <label for="email">E-mail</label>
              <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                placeholder="Enter your email">
              <span class="error-msg" id="error-email"></span>
            </div>

            <div class="input-group">
              <label for="phone">Phone</label>
              <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>"
                placeholder="Enter your phone">
              <span class="error-msg" id="error-phone"></span>
            </div>

            <div class="input-group passwordGroup">
              <label for="password">Password (leave blank to keep current)</label>
              <div class="passwordWrapper">
                <input class="passwordInput" type="password" name="password" id="password"
                  placeholder="Enter new password (optional)">
                <span class="toggle-password-btn" id="togglePasswordBtnOuter">
                  <i class="fas fa-eye-slash"></i>
                </span>
              </div>
              <span class="error-msg" id="error-password"></span>
            </div>

            <div class="input-group">
              <label for="confirm_password">Confirm Password</label>
              <div class="passwordWrapper">
                <input class="passwordInput" type="password" name="confirm_password" id="confirm_password"
                  placeholder="Confirm new password">
                <span class="toggle-password-btn" id="toggleCPasswordBtnOuter">
                  <i class="fas fa-eye-slash"></i>
                </span>
              </div>
              <span class="error-msg" id="error-confirm_password"></span>
            </div>

            <div class="input-group">
              <label for="githup">GitHub</label>
              <input type="text" name="githup" id="githup"
                value="<?php echo htmlspecialchars($user['githup'] ?? ''); ?>" placeholder="Enter your GitHub">
              <span class="error-msg" id="error-githup"></span>
            </div>

            <div class="input-group">
              <label for="linkedin">LinkedIn</label>
              <input type="text" name="linkedin" id="linkedin"
                value="<?php echo htmlspecialchars($user['linkedin'] ?? ''); ?>" placeholder="Enter your LinkedIn">
              <span class="error-msg" id="error-linkedin"></span>
            </div>

            <div class="button-group">
              <button type="button" class="closePopup">Close</button>
              <button type="submit" class="saveProfile" id="saveChangesBtn">Save Changes</button>
            </div>
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