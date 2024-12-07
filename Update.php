<?php
session_start();
require_once 'dbConnection.php';
require_once 'User.php';



if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

$database = new ECommerce();
$db = $database->Connect();


$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = htmlspecialchars(trim($_POST['username'])); 
    $newData = [
        'password' => password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT),        'email' => htmlspecialchars(trim($_POST['email'])),
        'phone' => htmlspecialchars(trim($_POST['phone'])),
        'Address' => htmlspecialchars(trim($_POST['Address'])),
        'age' => htmlspecialchars(trim($_POST['age'])),
        'birthday' => htmlspecialchars(trim($_POST['birthday'])),
        'gender' => htmlspecialchars(trim($_POST['gender'])),
    ];

    
    if ($user->updateByUsername($_SESSION['username'], $newUsername, $newData)) {
        $_SESSION['username'] = $newUsername; 
        $_SESSION['message'] = "User  information updated successfully!";
        header("Location: Account.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update user information.";
        header("Location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="styles/Update.css">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<body>
    <form action="Update.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="Address">Address:</label>
        <input type="text" id="email" name="Address" required><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required><br>

        <label for="birthday">Birthday:</label>
        <input type="date" id="birthday" name="birthday" required><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>

        <input type="submit" value="Update">
    </form>
    <script>
        
        <?php if (!empty($message)): ?>
            Swal.fire({
                title: '<?php echo strpos($message, 'successfully') !== false ? 'Success' : 'Error'; ?>',
                text: '<?php echo $message; ?>',
                icon: '<?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    <?php if (strpos($message, 'successfully') !== false): ?>
                        window.location.href = 'Account.php';
                    <?php endif; ?>
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>