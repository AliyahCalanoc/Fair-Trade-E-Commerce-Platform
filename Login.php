<?php
session_start();

include 'styles/Login.html';
class Login {
    public $stored_username ;
    public $stored_password;

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if ($username === $this->stored_username && $password === $this->stored_password) {
                echo "Login successful! Welcome, $username.";
                header("Location: homepage.php");
                exit();
            } else {
                return "Invalid username or password.";
            }
        }
        return null;
    }
}

$login = new Login();
$error_message = $login->handleLogin();
?>


