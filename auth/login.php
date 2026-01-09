<?php
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
   echo "m3lm radwan";

     if (isset($_POST['remember'])) {
                setcookie("remember_email", $email, time() + 3600 * 24 * 365); 
                setcookie("remember_password", $password, time() + 3600 * 24 * 365);   
                setcookie("remember", $remember, time() + 3600 * 24 * 365);
            } else {
                // If 'Remember Me' is not checked, delete cookies
                setcookie("remember_email", "", time() - 3600); 
                setcookie("remember_password", "", time() - 3600); 
                setcookie("remember", "", time() - 3600);
            }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCCI Login</title>
     <link rel="icon" href="assets/icons/logoSCCI.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>

<!-- main container -->

<body>
    <main class="mainContainer">
<!-- login card -->
        <section class="loginCard">
            <h1 class="loginTitle">LOGIN</h1>
            <div class="divider">
                <span class="line"></span>
                <span class="diamond"></span>
                <span class="line"></span>
            </div>
            <?php
            $popup_error = "";
            if(!empty($error_msgp)) $popup_error = $error_msgp;
            if(!empty($error_msge)) $popup_error = $error_msge;
            if(!empty($error_notv)) $popup_error = $error_notv;
            
            if(!empty($popup_error)):
            ?>
            <div class="popupOverlay" id="errorPopup">
                <div class="popupContent">
                    <p class="popupMessage"><?php echo $popup_error; ?></p>
                    <button class="popupCloseBtn" onclick="document.getElementById('errorPopup').style.display='none'">Close</button>
                </div>
            </div>
            <?php endif; ?>
            <form class="loginForm" method="POST">
                <div class="inputGroup">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email">
                </div>
<!-- user input -->
                <div class="inputGroup">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your pass">
                </div>
<!-- form footer -->
                <footer class="formFooter">
                    <label class="rememberMe">
                        Remember me
                        <input type="checkbox"  name="remember" value="1">
                             <?php echo (!empty($remember) || isset($_COOKIE['remember'])) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                </footer>
<!-- button -->
                <button type="submit" name="login1" class="submitBtn">Submit</button>
            </form>
        </section>
    </main>
</body>

</html>