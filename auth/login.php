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

            <form class="login-form">
                <div class="input-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" placeholder="Enter your email">
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Enter your pass">
                </div>

                <footer class="form-footer">
                    <a href="#" class="forgot-pass">Forget Password ?</a>
                    <label class="remember-me">
                        Remember me
                        <input type="checkbox">
                        <span class="checkmark"></span>
                    </label>
                </footer>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </section>
    </main>
</body>

</html>