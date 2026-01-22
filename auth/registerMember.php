<?php
include('../includes/config.php');

$select_w = "SELECT * FROM `workshops`";
$run_w = mysqli_query($connect, $select_w);

$select_c = "SELECT * FROM `committees`";
$run_c = mysqli_query($connect, $select_c);

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $name  = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $password = $_POST['password'];
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $workshop = mysqli_real_escape_string($connect, $_POST['workshop']);

    // FIX: use correct committeeId from form
    $committeeId = !empty($_POST['committeeId']) ? "'" . mysqli_real_escape_string($connect, $_POST['committeeId']) . "'" : "NULL";

    $roleID   = mysqli_real_escape_string($connect, $_POST['roleID']);
    $getHup   = mysqli_real_escape_string($connect, $_POST['github']);
    $linkedin = mysqli_real_escape_string($connect, $_POST['linkedin']);

    // Image Upload Logic
    $image = "default.png"; // Default image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            $new_image_name = uniqid("IMG-", true) . '.' . $file_ext;
            $upload_path = '../assets/uploadedImages/' . $new_image_name;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image = $new_image_name;
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        }
    }

    if (empty($error)) {
        // Check duplicate email or phone
        $select = "SELECT * FROM `users` WHERE `email`='$email' OR `phone`='$phone'";
        $run_select = mysqli_query($connect, $select);
    
        if (mysqli_num_rows($run_select) > 0) {
            $error = "Email or Phone already exists";
        } else {
    
            $insert_p = "INSERT INTO `users`
            (`user_id`,`workshop_id`,`committee_id`,`user_name`,`email`,`phone`,
             `password`,`role`,`Image`,`githup`,`linkedin`,`status`)
            VALUES
            (NULL, NULL,$committeeId,'$name','$email','$phone',
             '$passwordhashing','$roleID','$image','$getHup','$linkedin',1)";
    
            if (mysqli_query($connect, $insert_p)) {
                $success = "Registered Successfully";
            } else {
                $error = "Database Error: " . mysqli_error($connect);
            }
        }
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
    <link rel="icon" type="image/x-icon" href="../assets/icons/logoSCCI.png" />
    <meta property="og:image" content="../assets/images/seo/registerMember.png" />
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
    <link rel="stylesheet" href="../assets/css/registerMember.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SCCI - Register Member</title>
  </head>

<body>

<div class="main-content">
    <form class="form-content" id="form" action="" method="POST" enctype="multipart/form-data" novalidate>

        <h1 class="register-title">Register</h1>
        <div class="divider">
            <span class="line"></span>
            <span class="diamond"></span>
            <span class="line"></span>
        </div>

        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="name" id="name" required placeholder="e.g. John Doe">
            <div class="error-text" id="error-name"></div>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" id="email" required placeholder="example@mail.com">
            <div class="error-text" id="error-email"></div>
        </div>

        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" id="phone" required placeholder="01xxxxxxxxx">
            <div class="error-text" id="error-phone"></div>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" id="password" required placeholder="••••••••">
            <div class="error-text" id="error-password"></div>
        </div>

        <!-- <div class="input-group">
            <label>Workshop</label>
            <select name="workshop" id="workshop" required>
                <option value="">Select Workshop</option>
                <?php while ($row_w = mysqli_fetch_assoc($run_w)) { ?>
                    <option value="<?php echo $row_w['workshop_id']; ?>">
                        <?php echo $row_w['workshop_name']; ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-text" id="error-workshop"></div>
        </div> -->

        <div class="input-group">
            <label>Committee</label>
            <select name="committeeId" id="committeeId" required>
                <option value="">Select Committee</option>
                <?php while ($row_c = mysqli_fetch_assoc($run_c)) { ?>
                    <option value="<?php echo $row_c['committee_id']; ?>">
                        <?php echo $row_c['committe_name']; ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-text" id="error-committee"></div>
        </div>

        <div class="input-group">
            <label>Member in</label>
            <select name="roleID" id="roleID" required>
                <option value="2">hr</option>
                <option value="2">acs</option>
                <option value="2">it</option>
                <option value="3">dd</option>
                <option value="3">mb</option>
                <option value="3">smm</option>
                <option value="3">bd</option>
                <option value="3">cr</option>
                <option value="3">br</option>
                <option value="3">logistes</option>
            </select>
        </div>

        <div class="input-group">
            <label>Profile Photo</label>
            <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/jpg">
        </div>

        <div class="input-group">
            <label>GitHub (Optional)</label>
            <input type="text" name="github" id="github" placeholder="github.com/username">
        </div>

        <div class="input-group">
            <label>LinkedIn (Optional)</label>
            <input type="text" name="linkedin" id="linkedin" placeholder="linkedin.com/in/username">
        </div>

        <button class="submit-btn" type="submit" name="submit">Register</button>

    </form>
</div>

<!-- Validation Script -->
<script src="../assets/js/registerMember.js"></script>

<?php if (!empty($error)) { ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '<?php echo $error; ?>'
});
</script>
<?php } ?>

<?php if (!empty($success)) { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: '<?php echo $success; ?>',
    timer: 2000,
    showConfirmButton: false
}).then(() => {
    window.location.href = 'login.php';
});
</script>
<?php } ?>

    <script src="../assets/js/index.js?v=<?php echo time(); ?>"></script>
</body>
</html>