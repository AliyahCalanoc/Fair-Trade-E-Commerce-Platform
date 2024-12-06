<?php
session_start();

require_once 'dbConnection.php';
require_once 'User.php';
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
                    $this->loginAndInsertMenProducts(); 
                    $this->loginAndInsertWomenProducts(); 
                    $this->loginAndInsertKidsProducts(); 
                    $this->loginAndInsertHomeAndLivingProducts();
                    exit();
                }
            }
            return "Invalid username or password.";
        }
        return null;
    }

    public function loginAndInsertMenProducts() {
        if (isset($_SESSION['username'])) {
            $database = new ECommerce();
            $db = $database->Connect();
    
            $imageDirectory = 'Images/';
            $images = glob($imageDirectory . "Men's*.*"); 
    
            $query = "INSERT INTO men (`Men's_Product`, `Men's_Price`) VALUES (:product_name, :price)";
            $stmt = $db->prepare($query);
    
            foreach ($images as $image) {
                $productName = basename($image); 
                $productName = pathinfo($productName, PATHINFO_FILENAME);
    
                // Default Price
                $price = 15.99;
    
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':price', $price);
    
                if ($stmt->execute()) {
                    echo "";
                } else {
                    echo "";
                }
            }
    
            $db = null;
        } else {
            echo "User is not logged in.";
        }
    }
    
    public function loginAndInsertWomenProducts() {
        if (isset($_SESSION['username'])) {
            $database = new ECommerce();
            $db = $database->Connect();
    
            $imageDirectory = 'Images/';
            $images = glob($imageDirectory . "Women's*.*"); 
    
            $query = "INSERT INTO women (`Women's_Product`, `Women's_Price`) VALUES (:product_name, :price)";
            $stmt = $db->prepare($query);
    
            foreach ($images as $image) {
                $productName = basename($image); 
                $productName = pathinfo($productName, PATHINFO_FILENAME);
    
                // Default Price
                $price = 19.99; 
    
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':price', $price);
    
                if ($stmt->execute()) {
                    echo "";
                } else {
                    echo "";
                }
            }
    
            $db = null;
        } else {
            echo "User  is not logged in.";
        }
    }
    
    public function loginAndInsertKidsProducts() {
        if (isset($_SESSION['username'])) {
            $database = new ECommerce();
            $db = $database->Connect();
    
            $imageDirectory = 'Images/';
            $images = glob($imageDirectory . "Kid's*.*"); 
    
            $query = "INSERT INTO kids (`Kid's_Product`, `Kid's_Price`) VALUES (:product_name, :price)";
            $stmt = $db->prepare($query);
    
            foreach ($images as $image) {
                $productName = basename($image); 
                $productName = pathinfo($productName, PATHINFO_FILENAME);
    
                // Default Price
                $price = 12.99; 
    
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':price', $price);
    
                if ($stmt->execute()) {
                    echo "";
                } else {
                    echo "";
                }
            }
    
            $db = null;
        } else {
            echo "User  is not logged in.";
        }
    }
    
    public function loginAndInsertHomeAndLivingProducts() {
        if (isset($_SESSION['username'])) {
            $database = new ECommerce();
            $db = $database->Connect();
    
            $imageDirectory = 'Images/';
            $images = glob($imageDirectory . "HomeLiving's*.*"); 
    
            $query = "INSERT INTO homeliving (`HomeLiving's_Product`, `HomeLiving's_Price`) VALUES (:product_name, :price)";
            $stmt = $db->prepare($query);
    
            foreach ($images as $image) {
                $productName = basename($image); 
                $productName = pathinfo($productName, PATHINFO_FILENAME);
    
                // Default Price
                $price = 25.99; 
    
                $stmt->bindParam(':product_name', $productName);
                $stmt->bindParam(':price', $price);
    
                if ($stmt->execute()) {
                    echo "";
                } else {
                    echo "";
                }
            }
    
            $db = null;
        } else {
            echo "User  is not logged in.";
        }
    }
}

$database = new ECommerce();
$db = $database->Connect();

$login = new Login($db);
$errorMessage = $login->authenticate();

if ($errorMessage) {
    echo "<p>$errorMessage</p>";
}
?>