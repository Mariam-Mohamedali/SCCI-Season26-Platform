<?php
include('../includes/config.php');

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $name  = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $password = $_POST['password'];
    $passwordhashing = password_hash($password, PASSWORD_DEFAULT);
    $workshop = mysqli_real_escape_string($connect, $_POST['workshop']);

    // Check duplicate email or phone
    $select = "SELECT * FROM `users` WHERE `email`='$email' OR `phone`='$phone'";
    $run_select = mysqli_query($connect, $select);

    if (mysqli_num_rows($run_select) > 0) {
        $error = "Email or Phone already exists";
    } elseif ($password != $_POST['cpassword']) {
        $error = "Passwords do not match";
    } else {

        // Image validation
        if (empty($_FILES['image']['name'])) {

            $error = "Please upload an image";

        } else {

            $image = $_FILES['image']['name'];
            $imageExtension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

            if (!in_array($imageExtension, $allowedExtensions)) {
                $error = "Only Image files (JPG, PNG, GIF, WEBP) are allowed";
            } elseif ($_FILES['image']['size'] > 1 * 1024 * 1024) {
                // 1 * 1024 * 1024 = 1,048,576 bytes = 1MB
                $error = "Image size must be less than 1MB";
            } else {
                $tempname = $_FILES['image']['tmp_name'];
                $folder = "../assets/uploadedImages/" . $image;

                if (move_uploaded_file($tempname, $folder)) {

                $insert_p = "INSERT INTO `users`
                (`user_id`,`workshop_id`,`user_name`,`email`,`phone`,
                 `password`,`role`,`Image`,`status`)
                VALUES
                (NULL,'$workshop','$name','$email','$phone',
                 '$passwordhashing','1','$image',0)";   

                if (mysqli_query($connect, $insert_p)) {
                    $success = "Registered Successfully";
                } else {
                    $error = "Database Error: " . mysqli_error($connect);
                }

            } else {
                $error = "Failed to upload image";
            }
        }
    }
}
}

// Fetch workshops
$select_w = "SELECT * FROM `workshops`";
$run_w = mysqli_query($connect, $select_w);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/icons/logoSCCI.png" />
    <meta property="og:image" content="../assets/images/seo/registerParticipant.png" />
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
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- css -->
     <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/registerParticipant.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>SCCI - Register</title>
  </head>

<body>

<div class="main-content">
    <form class="form-content" id="form" action="" method="POST" enctype="multipart/form-data" novalidate>

        <img src="../assets/icons/logoSCCI.png" alt="SCCI Logo" class="register-logo">
        <h1 class="register-title">Register</h1>
        <div class="divider">
            <span class="line"></span>
            <span class="diamond"></span>
            <span class="line"></span>
        </div>

        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="name" id="name" placeholder="e.g. John Doe" required>
            <div class="error-text" id="error-name"></div>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" id="email" placeholder="example@mail.com" required>
            <div class="error-text" id="error-email"></div>
        </div>

        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" id="phone" placeholder="01xxxxxxxxx" required>
            <div class="error-text" id="error-phone"></div>
        </div>

        <div class="input-group password-group">
            <label>Password</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="••••••••" required oncopy="return false" oncut="return false" onpaste="return false">
                <span class="toggle-password-btn" id="togglePasswordBtn">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>
            <div class="error-text" id="error-password"></div>
        </div>

        <div class="input-group password-group">
            <label>Confirm Password</label>
            <div class="password-wrapper">
                <input type="password" name="cpassword" id="cpassword" placeholder="••••••••" required oncopy="return false" oncut="return false" onpaste="return false">
                <span class="toggle-password-btn" id="toggleCPasswordBtn">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </div>
            <div class="error-text" id="error-cpassword"></div>
        </div>

        <div class="input-group">
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
        </div>

        <div class="input-group">
            <label>Image</label>
            <div class="file-upload-wrapper">
                <input type="file" name="image" id="image" accept="image/*" required style="display: none;">
                <label for="image" class="file-upload-label" id="fileLabel">
                    <span class="file-upload-btn">Choose File</span>
                    <span class="file-upload-text" id="fileName">No file chosen</span>
                </label>
            </div>
            <div class="error-text" id="error-image"></div>
        </div>

        <button type="submit" name="submit" class="submit-btn">Register</button>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>

    </form>
</div>

<!-- Validation Script -->


<?php if (!empty($error)) { ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: '<?php echo $error; ?>',
    confirmButtonText: 'Try Again',
    customClass: {
        popup: 'swal-custom-popup',
        title: 'swal-custom-title',
        htmlContainer: 'swal-custom-text',
        confirmButton: 'swal-custom-button'
    },
    background: 'linear-gradient(to bottom, #fffdf5, #ffe4b5)',
    backdrop: 'rgba(0,0,0,0.7)',
    showClass: {
        popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
    },
    didOpen: () => {
        document.body.classList.add('no-scroll');
    },
    willClose: () => {
        document.body.classList.remove('no-scroll');
    }
});
</script>
<?php } ?>

<?php if (!empty($success)) { ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Welcome!',
    text: '<?php echo $success; ?>',
    timer: 2500,
    showConfirmButton: false,
    customClass: {
        popup: 'swal-custom-popup',
        title: 'swal-custom-title',
        htmlContainer: 'swal-custom-text'
    },
    background: 'linear-gradient(to bottom, #fffdf5, #ffe4b5)',
    backdrop: 'rgba(0,0,0,0.7)',
    showClass: {
        popup: 'animate__animated animate__zoomIn'
    },
    hideClass: {
        popup: 'animate__animated animate__zoomOut'
    },
    didOpen: () => {
        document.body.classList.add('no-scroll');
    },
    willClose: () => {
        document.body.classList.remove('no-scroll');
    }
}).then(() => {
    window.location.href = 'login.php';
});
</script>
<?php } ?>
     <script src="../assets/js/all.min.js"></script>
    <script src="../assets/js/registerParticipant.js?v=<?php echo time(); ?>"></script>
    <script>
        // Client-side image size validation
        document.getElementById('image').addEventListener('change', function() {
            const file = this.files[0];
            const maxSize = 1 * 1024 * 1024; // 1MB

            if (file && file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Image size must be less than 1MB',
                    confirmButtonText: 'Try Again',
                    customClass: {
                        popup: 'swal-custom-popup',
                        title: 'swal-custom-title',
                        htmlContainer: 'swal-custom-text',
                        confirmButton: 'swal-custom-button'
                    },
                    background: 'linear-gradient(to bottom, #fffdf5, #ffe4b5)',
                    backdrop: 'rgba(0,0,0,0.7)',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    didOpen: () => {
                        document.body.classList.add('no-scroll');
                    },
                    willClose: () => {
                        document.body.classList.remove('no-scroll');
                    }
                });
                this.value = ""; // Clear input
            }
        });
    </script>
</body>
</html>