<?php 
session_start(); 
include 'styles/Registration.html';

class Registration {
    public function registerUser () {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $age = $_POST['Age'];
            $birthday = $_POST['birthday'];
            $gender = $_POST['Gender'];

            
            $_SESSION['stored_username'] = $username; 
            $_SESSION['stored_password'] = $password; 
            $_SESSION['stored_email'] = $email;
            $_SESSION['stored_phone'] = $phone;
            $_SESSION['stored_age'] = $age; 
            $_SESSION['stored_birthday'] = $birthday; 
            $_SESSION['stored_gender'] = $gender; 
            
            
            header("Location: Login.php");
            exit();
        }
    }
}

$registration = new Registration();
$registration->registerUser ();

?>

