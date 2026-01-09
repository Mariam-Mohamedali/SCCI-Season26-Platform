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

    } else {

        // Image validation
        if (empty($_FILES['image']['name'])) {

            $error = "Please upload an image";

        } else {

            $image    = $_FILES['image']['name'];
            $tempname = $_FILES['image']['tmp_name'];
            $folder   = "../assets/uploadedImages/" . $image;

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

// Fetch workshops
$select_w = "SELECT * FROM `workshops`";
$run_w = mysqli_query($connect, $select_w);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/registerParticipant.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="main-content">
    <form class="form-content" id="form" action="" method="POST" enctype="multipart/form-data">

        <h1 class="register-title">Register</h1>
        <div class="divider">
            <span class="line"></span>
            <span class="diamond"></span>
            <span class="line"></span>
        </div>

        <div class="input-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" placeholder="Enter phone number" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>

        <div class="input-group">
            <label>Workshop</label>
            <select name="workshop" required>
                <option value="">Select Workshop</option>
                <?php while ($row_w = mysqli_fetch_assoc($run_w)) { ?>
                    <option value="<?php echo $row_w['workshop_id']; ?>">
                        <?php echo $row_w['workshop_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="input-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" required>
        </div>

        <button type="submit" name="submit" class="submit-btn">Register</button>

    </form>
</div>

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

</body>
</html>
