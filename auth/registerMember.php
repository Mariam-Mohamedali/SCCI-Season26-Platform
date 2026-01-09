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
                (`user_id`,`workshop_id`,`committee_id`,`user_name`,`email`,`phone`,
                 `password`,`role`,`Image`,`githup`,`linkedin`,`status`)
                VALUES
                (NULL,'$workshop',$committeeId,'$name','$email','$phone',
                 '$passwordhashing','$roleID','$image','$getHup','$linkedin',0)";

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
    <link rel="stylesheet" href="../assets/css/registerMember.css">
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
            <input type="text" name="name" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-group">
            <label>Phone</label>
            <input type="text" name="phone" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
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
            <label>Committee</label>
            <select name="committeeId" required>
                <option value="">Select Committee</option>
                <?php while ($row_c = mysqli_fetch_assoc($run_c)) { ?>
                    <option value="<?php echo $row_c['committee_id']; ?>">
                        <?php echo $row_c['committe_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="input-group">
            <label>Member in</label>
            <select name="roleID" required>
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
            <label>GitHub</label>
            <input type="text" name="github">
        </div>

        <div class="input-group">
            <label>LinkedIn</label>
            <input type="text" name="linkedin">
        </div>

        <div class="input-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" required>
        </div>

        <button class="submit-btn" type="submit" name="submit">Register</button>

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
