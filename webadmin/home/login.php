<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>User Panel</h2>
            <p>Sign in to start your session</p>
            <form action="../action/proses_login.php" method="POST">
                <div class="input-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="remember_me" name="remember_me">
                    <label for="remember_me">Remember Me</label>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
