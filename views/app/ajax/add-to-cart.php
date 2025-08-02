<?php
session_start();
header('Content-Type: application/json');

// Required files
include('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/helpers/urlhelpers.php');

$database = new DatabaseOps();
$connStatus = $database->createConnection();

$response = ['success' => false, 'cart_count' => 0];

// Validate input
$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if ($productId > 0 && $quantity > 0) {
    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update product in cart
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Count total items
    $totalQty = array_sum($_SESSION['cart']);

    $response['success'] = true;
    $response['cart_count'] = $totalQty;
} else {
    $response['error'] = 'Invalid product or quantity';
}

echo json_encode($response);
