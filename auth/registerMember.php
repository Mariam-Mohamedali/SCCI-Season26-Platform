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

        $insert_p = "INSERT INTO `users`
        (`user_id`,`workshop_id`,`committee_id`,`user_name`,`email`,`phone`,
         `password`,`role`,`Image`,`githup`,`linkedin`,`status`)
        VALUES
        (NULL,'$workshop',$committeeId,'$name','$email','$phone',
         '$passwordhashing','$roleID','default.png','$getHup','$linkedin',0)";

        if (mysqli_query($connect, $insert_p)) {
            $success = "Registered Successfully";
        } else {
            $error = "Database Error: " . mysqli_error($connect);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI - Register</title>
    <link rel="icon" href="../assets/icons/logoSCCI.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Stencil&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/registerMember.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="main-content">
    <form class="form-content containerCard" id="form" action="" method="POST" novalidate>

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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form');
    
    // Inputs
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const workshopSelect = document.getElementById('workshop');
    const committeeSelect = document.getElementById('committeeId');

    // Error Containers
    const errorName = document.getElementById('error-name');
    const errorEmail = document.getElementById('error-email');
    const errorPhone = document.getElementById('error-phone');
    const errorPassword = document.getElementById('error-password');
    const errorWorkshop = document.getElementById('error-workshop');
    const errorCommittee = document.getElementById('error-committee');

    function showError(input, element, message) {
        element.textContent = message;
        element.style.display = 'block';
        input.parentElement.classList.add('error');
    }

    function clearError(input, element) {
        element.textContent = '';
        element.style.display = 'none';
        input.parentElement.classList.remove('error');
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePhone(phone) {
        // Egyptian phone validation (starts with 01, 11 digits)
        const re = /^01[0-2,5]{1}[0-9]{8}$/; 
        return re.test(phone);
    }

    form.addEventListener('submit', (e) => {
        let valid = true;

        // Name Validation
        if (nameInput.value.trim().length === 0) {
            showError(nameInput, errorName, 'Name is required');
            valid = false;
        } else if (nameInput.value.trim().length < 3) {
            showError(nameInput, errorName, 'Name must be at least 3 characters');
            valid = false;
        } else {
            clearError(nameInput, errorName);
        }

        // Email Validation
        if (emailInput.value.trim().length === 0) {
            showError(emailInput, errorEmail, 'Email is required');
            valid = false;
        } else if (!validateEmail(emailInput.value.trim())) {
            showError(emailInput, errorEmail, 'Please enter a valid email');
            valid = false;
        } else {
            clearError(emailInput, errorEmail);
        }

        // Phone Validation
        if (phoneInput.value.trim().length === 0) {
            showError(phoneInput, errorPhone, 'Phone is required');
            valid = false;
        } else if (!validatePhone(phoneInput.value.trim())) {
            showError(phoneInput, errorPhone, 'Phone must be a valid 11-digit number');
            valid = false;
        } else {
            clearError(phoneInput, errorPhone);
        }

        // Password Validation
        if (passwordInput.value.length === 0) {
            showError(passwordInput, errorPassword, 'Password is required');
            valid = false;
        } else if (passwordInput.value.length < 6) {
            showError(passwordInput, errorPassword, 'Password must be at least 6 characters');
            valid = false;
        } else {
            clearError(passwordInput, errorPassword);
        }

        // Dropdown Validation
        if (workshopSelect.value === "") {
            showError(workshopSelect, errorWorkshop, 'Please select a workshop');
            valid = false;
        } else {
            clearError(workshopSelect, errorWorkshop);
        }

        if (committeeSelect.value === "") {
            showError(committeeSelect, errorCommittee, 'Please select a committee');
            valid = false;
        } else {
            clearError(committeeSelect, errorCommittee);
        }

        if (!valid) {
            e.preventDefault(); // Stop form submission
        }
    });

    // Real-time validation cleanup
    const inputs = [nameInput, emailInput, phoneInput, passwordInput, workshopSelect, committeeSelect];
    inputs.forEach(input => {
        input.addEventListener('input', () => {
             input.parentElement.classList.remove('error');
             const errorDisplay = input.parentElement.querySelector('.error-text');
             if(errorDisplay) errorDisplay.style.display = 'none';
        });
    });
});
</script>

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