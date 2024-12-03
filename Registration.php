<?php  
session_start();
include 'styles/Registration.html';
require_once 'dbConnection.php';
require_once 'Crud.php';

class Registration {
    public function registerUser  () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $database = new ECommerce();
            $db = $database->Connect();
         
        
            $user = new User($db);
            $user->username = htmlspecialchars(trim($_POST['username']));
            $user->password = password_hash(htmlspecialchars(trim($_POST['password'])), PASSWORD_DEFAULT);            $user->email = htmlspecialchars(trim($_POST['email']));
            $user->phone = htmlspecialchars(trim($_POST['phone']));
            $user->age = htmlspecialchars(trim($_POST['Age']));
            $user->birthday = htmlspecialchars(trim($_POST['birthday']));
            $user->gender = htmlspecialchars(trim($_POST['Gender']));

            
            if ($user->create()) {
                $_SESSION['message'] = "Registration successful!";
                echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'Registration successful!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'Login.php';
                        });
                      </script>";
            } else {
                $_SESSION['message'] = "Registration failed. Please try again.";
                echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Email already used. Registration Failed',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'Registration.php';
                        });
                      </script>";
            }
        }
    }
}


$registration = new Registration();
$registration->registerUser ();
?>