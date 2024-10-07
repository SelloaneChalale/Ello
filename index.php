

<!DOCTYPE html>
<html>
<head>
    <title>Ello</title>
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="683849238219-m4d6o8ua9t07709gqgldvmvk3ghiatmp.apps.googleusercontent.com">
</head>
<body>

    <div class="container">
        <div class="form-container">
            <div class="form-toggle">
                <span id="login-toggle" class="active">Login</span>
                <span id="signup-toggle">Sign Up</span>
            </div>
            <div id="login-form" class="form">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
             
                <div class="google-signin">
                    <div class="g-signin2" data-onsuccess="onSignIn"></div>
                </div>
                
            </div>
            <div id="signup-form" class="form">
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
   
    <script src="assets/js/script.js"></script>
</body>
</html>