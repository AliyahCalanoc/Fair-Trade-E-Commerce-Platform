<?php
session_start();
require_once 'dbConnection.php'; 


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php"); 
    exit();
}


$database = new ECommerce();
$db = $database->Connect();


$overallTotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $itemTotal = $item['price'] * $item['quantity'];
    $overallTotal += $itemTotal;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
       
        $db->beginTransaction();

        
        $query = "INSERT INTO orders (product_name, price, quantity, total, user_id) VALUES (:product_name, :price, :quantity, :total, :user_id)";
        $stmt = $db->prepare($query);

        
        $userId = $_SESSION['user_id']; 

        foreach ($_SESSION['cart'] as $item) {
            
            $itemTotal = $item['price'] * $item['quantity']; 
            $stmt->bindParam(':product_name', $item['name']);
            $stmt->bindParam(':price', $item['price']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->bindParam(':total', $itemTotal);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();

            
            $productName = $item['name'];
            $quantityPurchased = $item['quantity'];

            
            if (strpos($productName, "Men's") !== false) {
                $updateQuery = "UPDATE men SET `Men's_Quantity` = `Men's_Quantity` - :quantity WHERE `Men's_Product` = :product_name";
            } elseif (strpos($productName, "Women's") !== false) {
                $updateQuery = "UPDATE women SET `Women's_Quantity` = `Women's_Quantity` - :quantity WHERE `Women's_Product` = :product_name";
            } elseif (strpos($productName, "Kid's") !== false) {
                $updateQuery = "UPDATE kids SET `Kid's_Quantity` = `Kid's_Quantity` - :quantity WHERE `Kid's_Product` = :product_name";
            } elseif (strpos($productName, "HomeLiving's") !== false) {
                $updateQuery = "UPDATE homeliving SET `HomeLiving's_Quantity` = `HomeLiving's_Quantity` - :quantity WHERE `HomeLiving's_Product` = :product_name";
            } else {
                
                continue;
            }

            
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':quantity', $quantityPurchased);
            $updateStmt->bindParam(':product_name', $productName);
            $updateStmt->execute();
        }

        
        $db->commit();

        
        unset($_SESSION['cart']);
        

        
        header("Location: Homepage.php");
        exit();
    } catch (Exception $e) {
       
        $db->rollBack();
        echo "Error: " . $e->getMessage(); 
    }
}
?>
