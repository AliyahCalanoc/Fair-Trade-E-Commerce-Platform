<?php
session_start();

require_once 'dbConnection.php';
require_once 'Crud.php';
include 'styles/Login.html';

class Login {
    public $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $inputUsername = htmlspecialchars(trim($_POST['username']));
            $inputPassword = htmlspecialchars(trim($_POST['password']));

            $user = new User($this->db);
            $result = $user->read(); 

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['username'] === $inputUsername && password_verify($inputPassword, $row['password'])) {
                    $_SESSION['username'] = $inputUsername; 
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                          <script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Login successful! Welcome, $inputUsername.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'homepage.php';
                            });
                          </script>";
                    exit();
                }
            }
            return "Invalid username or password.";
        }
        return null;
    }
}

$ecommerce = new ECommerce();
$db = $ecommerce->Connect();

$login = new Login($db);
$error_message = $login->authenticate();

if ($error_message) {
    echo $error_message; // Display error message if login fails
}
?>