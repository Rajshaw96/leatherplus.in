<?php
session_start();
header('Content-Type: application/json');

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

$response = ['success' => false];

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
    $response['success'] = true;
    $response['cart_count'] = array_sum($_SESSION['cart']);
} else {
    $response['error'] = "Invalid product ID or not found in cart.";
}

echo json_encode($response);
