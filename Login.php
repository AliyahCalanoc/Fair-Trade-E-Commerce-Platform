<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded para macheck if nagfufunction ng ayos ang login
    $stored_username = 'SampleName';
    $stored_password = 'password123';

    if ($username === $stored_username && $password === $stored_password) {
        echo "Login successful! Welcome, $username.";
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="background">
        <form action="login.php" method="POST">
            <h2>Login</h2>

            <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required><br>

            <div class="button-container">
                <input type="reset" value="Reset">
                <input type="submit" value="Login">
            </div>

            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>

</body>
</html>
