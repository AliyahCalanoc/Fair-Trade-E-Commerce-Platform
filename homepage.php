<?php
session_start();
require_once 'dbConnection.php'; 


$database = new ECommerce();
$db = $database->Connect();


function RetrieveProducts($db, $table) {
    $query = "SELECT * FROM " . $table;
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';


$products = [];
if ($selectedCategory) {
    $products = RetrieveProducts($db, $selectedCategory);
}


ob_start();
include 'styles/Homepage.html'; 
$htmlContent = ob_get_clean();

//
$productDisplay = '';
if (!empty($products)) {
    $productDisplay .= '<section class="featured-products"><div class="product-grid">';
    foreach ($products as $row) {
      
        if ($selectedCategory === 'men') {
            $productKey = "Men's_Product";
            $priceKey = "Men's_Price";
        
        } elseif ($selectedCategory === 'women') {
            $productKey = "Women's_Product";
            $priceKey = "Women's_Price";
           
        } elseif ($selectedCategory === 'kids') {
            $productKey = "Kid's_Product";
            $priceKey = "Kid's_Price";
           
        } elseif ($selectedCategory === 'homeliving') {
            $productKey = "HomeLiving's_Product";
            $priceKey = "HomeLiving's_Price";
           
        }

        
        if (isset($row[$productKey]) && isset($row[$priceKey]) ) {
            $productDisplay .= '<div class="product">';
            $imagePath = "Images/" . htmlspecialchars($row[$productKey]) .".jpg"; 
            $productDisplay .= '<img src="' . $imagePath . '" alt="' . htmlspecialchars($row[$productKey]) . '" class="product-image">';
            $productDisplay .= '<h3 class="product-title">' . htmlspecialchars($row[$productKey]) . '</h3>';
            
            
            $productDisplay .= '<p>Price: ₱' . htmlspecialchars($row[$priceKey]) . '</p>'; 
            
            
            $productDisplay .= '<form action="AddtoCart.php" method="POST">'; 
            $productDisplay .= '<input type="hidden" name="product_name" value="' . htmlspecialchars($row[$productKey]) . '">';
            $productDisplay .= '<input type="hidden" name="product_price" value="' . htmlspecialchars($row[$priceKey]) . '">'; // Keep price hidden
            $productDisplay .= '<label for="product_quantity">Quantity:</label><br>';
            $productDisplay .= '<input type="number" name="product_quantity" value="1" min="1" required><br>'; 
            $productDisplay .= '<button type="submit" class="product-button">Add to Cart</button>'; 
            $productDisplay .= '</form>';
            
            $productDisplay .= '</div>'; 
        } else {
            
            $productDisplay .= '<p>Product information is missing for one of the items.</p>';
        }
    }
    $productDisplay .= '</div></section>';
} else {
    $productDisplay .= '<p></p>';
}


$htmlContent = str_replace('<!-- Placeholder for product display -->', $productDisplay, $htmlContent);


echo $htmlContent;
?>