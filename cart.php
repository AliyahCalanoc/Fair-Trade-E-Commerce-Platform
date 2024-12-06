<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $key => $quantity) {
        
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] = intval($quantity); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles/Account.css">
    <link rel="stylesheet" href="styles/cart.css">
</head>
<body>
    <div class="container">
        <h1>Your Cart</h1>
        <form method="POST" action="">
            <table>
                <tr>
                    
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
                <?php
                $overallTotal = 0; 
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $itemTotal = $item['price'] * $item['quantity']; 
                        $overallTotal += $itemTotal;
                        
                        echo "<tr>";
                        
                        
                        
                        
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>₱" . htmlspecialchars($item['price']) . "</td>";
                        echo "<td><input type='number' name='quantities[{$key}]' value='" . htmlspecialchars($item['quantity']) . "' min='1' class='quantity-input'></td>"; // Editable quantity
                        echo "<td>₱" . htmlspecialchars($itemTotal) . "</td>"; 
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Your cart is empty.</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="3" style="text-align: left;"><strong>Overall Total:</strong></td>
                    <td>₱<?php echo htmlspecialchars($overallTotal); ?></td>  </tr>
            </table>
            <button type="submit" name="update_cart" class="update-cart-button">Update Cart</button> 
        </form>
        
        
        <form action="checkout.php" method="POST">
            <button type="submit" class="checkout-button">Checkout</button> 
            
        </form>

        
        <a href="homepage.php" class="return-home-button">Return to Homepage</a> 
    </div>
</body>
</html>