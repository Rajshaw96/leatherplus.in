<?php
session_start();
header('Content-Type: application/json');

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$change = isset($_POST['change']) ? intval($_POST['change']) : 0;

$response = ['success' => false];

if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] += $change;

    // Remove if quantity goes to 0 or below
    if ($_SESSION['cart'][$productId] <= 0) {
        unset($_SESSION['cart'][$productId]);
    }

    $response['success'] = true;
    $response['cart_count'] = array_sum($_SESSION['cart']);
} else {
    $response['error'] = "Invalid product or not in cart.";
}

echo json_encode($response);
