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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Irish+Grover&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>


<body>
    <main class="main-container">
    
        <section class="login-card">
            <h1 class="login-title">LOGIN</h1>
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
                    <input type="email" name="email" id="email" placeholder="Enter your email">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your pass">
                </div>

                <footer class="form-footer">
                    <label class="remember-me">
                        Remember me
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </footer>

                <button type="submit" name="login1" class="submit-btn">Submit</button>
            </form>
        </section>
    </main>
</body>

</html>