<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['Age'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['Gender'];

    // Alisin comment para makita yung ininput sa registration//checking purpose ng data lang
    
    // echo "Username: $username<br>";
    // echo "Password: $password<br>";
    // echo "Email: $email<br>";
    // echo "Phone: $phone<br>";
    // echo "Age: $age<br>";
    // echo "Birthday: $birthday<br>";
    // echo "Gender: $gender<br>";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="background">
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="SampleName" minlength="6" maxlength="15" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="******" required><br>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" placeholder="sample@example.com" required><br>

            <label for="phone">Cellphone/Telephone #:</label>
            <input type="tel" id="phone" name="phone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br>

            <label for="Age">Age:</label>
            <input type="number" id="Age" name="Age" min="18" required><br>

            <label for="birthday">Birthdate:</label>
            <input type="date" id="birthday" name="birthday" required><br>

            <label for="Gender">Gender: </label>
            
            <label for="Male">Male</label>
            <input type="radio" id="Male" value="Male" name="Gender">
            
            <label for="Female">Female</label>
            <input type="radio" id="Female" value="Female" name="Gender"><br>

            <div class="button-container">
                <input type="reset" value="Reset">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>
</html>
