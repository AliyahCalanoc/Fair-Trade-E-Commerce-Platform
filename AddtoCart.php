<?php
session_start();


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$product_name = htmlspecialchars($_POST['product_name']);
$product_price = htmlspecialchars($_POST['product_price']);
$product_quantity = htmlspecialchars($_POST['product_quantity']);


$product = [
    'name' => $product_name,
    'price' => $product_price,
    'quantity' => $product_quantity
];


$_SESSION['cart'][] = $product;


header("Location: homepage.php");
exit();
?>