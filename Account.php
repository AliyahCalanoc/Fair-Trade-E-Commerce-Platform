<?php
session_start();
require_once 'dbConnection.php';
require_once 'User.php';

if (!isset($_SESSION['username'])) {
    header("Location: Account.php");
    exit();
    
}

$database = new ECommerce();
$db = $database->Connect();

$user = new User($db);
$user->username = $_SESSION['username']; 


$query = "SELECT * FROM " . $user->table_name . " WHERE username = :username LIMIT 1";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $user->username);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <link rel="stylesheet" href="styles/Account.css">
</head>
<body>
    <div class="container">
        <?php
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <h1>Account Information</h1>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
            <p><strong>Password:</strong> <?php echo str_repeat('*', 10); ?></p> <!-- Display asterisks -->
            <p><strong>Email:</strong><br> <?php echo htmlspecialchars($row['email']); ?></p>            <p><strong>Phone:</strong> ****<?php echo htmlspecialchars(substr($row['phone'], -4)); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($row['age']); ?></p>
            <p><strong>Birthday:</strong> <?php echo htmlspecialchars($row['birthday']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['gender']); ?></p>
            <a href="Update.php" class="update-button">Update Account</a>
            <?php
        } else {
            echo "<p>No account information found.</p>";
        }
        ?>
        <a href="homepage.php" class="return-button">Return to Homepage</a>
    </div>
</body>
</html>


