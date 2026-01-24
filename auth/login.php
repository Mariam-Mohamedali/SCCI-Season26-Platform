<?php
ob_start();
include('../includes/config.php');
$error_msgp="";
$error_msge="";
$error_notv="";
if(isset($_POST['login1'])){
    $email=$_POST["email"];
    $password=$_POST["password"];

    $select="SELECT * FROM `users` WHERE `email`='$email'";
    $run_select=mysqli_query($connect,$select);
    $rows=mysqli_num_rows($run_select);

    if($rows>0){
        $fetch=mysqli_fetch_assoc($run_select);
        $hashed_password=$fetch['password'];
        $status=$fetch['status'];

        if(password_verify($password,$hashed_password)){
       if($status== 1){
     $user_id=$fetch['user_id'];
            $_SESSION['user_id']=$user_id;
            $_SESSION['role']=$fetch['role'];

     if (isset($_POST['remember']) && $_POST['remember'] == '1') {
                setcookie("remember_email", $email, time() + 3600 * 24 * 30, "/"); // 30 days
                setcookie("remember", "1", time() + 3600 * 24 * 30, "/");
            } else {
                // If 'Remember Me' is not checked, delete cookies
                setcookie("remember_email", "", time() - 3600, "/"); 
                setcookie("remember", "", time() - 3600, "/");
            }
            
            // Redirect to profile page
            header("Location: ../profile.php");
            exit();
}else{

    $error_notv= "your account is not activated";
}


        }else{
            $error_msgp="password incorrect";
        }
    }else{
        $error_msge="incorrect email";
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
    <meta property="og:image" content="../assets/images/seo/login.png" />
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
    <link rel="stylesheet" href="../assets/css/root.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/login.css?v=<?php echo time(); ?>">
    <title>SCCI - Login</title>
</head>


<body>
    <main class="main-container">
        <a href="../home.php" class="backBtn">
                        <i class="fas fa-arrow-left"></i>
                    </a>
    
        <section class="login-card">
            <div class="logo-container">
                <img src="../assets/icons/logoSCCI.png" alt="SCCI Logo" class="login-logo">
            </div>
            <h1 class="login-title">LOGIN</h1>
            <hr>
            <?php
            $popup_error = "";
            if(!empty($error_msgp)) $popup_error = $error_msgp;
            if(!empty($error_msge)) $popup_error = $error_msge;
            if(!empty($error_notv)) $popup_error = $error_notv;
            
            if(!empty($popup_error)):
            ?>
            <div class="popup-overlay" id="errorPopup">
                <div class="popup-content">
                    <p class="popup-message"><?php echo $popup_error; ?></p>
                    <button class="popup-close-btn" onclick="document.getElementById('errorPopup').style.display='none'">Close</button>
                </div>
            </div>
            <?php endif; ?>
            <form class="login-form" method="POST">
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : ''; ?>" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="password-container input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your pass" required oncopy="return false" oncut="return false" onpaste="return false">
                        <span class="toggle-password-btn" id="togglePasswordBtn">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="form-footer">
                    <label class="remember-me">
                        Remember me
                        <input type="checkbox" name="remember" value="1" <?php echo (isset($_COOKIE['remember']) && $_COOKIE['remember'] == '1') ? 'checked' : ''; ?>>
                        <span class="toggle-switch"></span>
                    </label>
                </div>

                <button type="submit" name="login1" class="btn btn-primary" style="width: 100%;">Login</button>
            </form>
        </section>
    </main>
    <script src="../assets/js/all.min.js"></script>
    <script src="../assets/js/index.js?v=<?php echo time(); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('#togglePasswordBtn');
            const password = document.querySelector('#password');

                toggleBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    
                    // Toggle the type attribute
                    const currentType = password.getAttribute('type');
                    const newType = currentType === 'password' ? 'text' : 'password';
                    password.setAttribute('type', newType);
                    
                    // Update the icon using innerHTML to handle potential SVG replacements by FontAwesome
                    if (newType === 'text') {
                        // Password visible -> Show Open Eye
                        this.innerHTML = '<i class="fas fa-eye"></i>';
                    } else {
                        // Password hidden -> Show Closed Eye (Slash)
                        this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    }
                });
        });
    </script>
</body>

</html>
