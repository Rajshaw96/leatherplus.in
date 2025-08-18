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
$quantity  = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$size      = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '';

if ($productId > 0 && $quantity > 0) {
    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ✅ Fetch product name from DB
    $productName = '';
    $query = "SELECT prod_title FROM products WHERE prod_id = ? AND prod_status = 1 LIMIT 1";
    $stmt = $database->conn->prepare($query);
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $productName = $row['prod_title'];
        }
    }
    $stmt->close();

    // If product already in cart with same size → update qty
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $productId && $item['size'] == $size) {
            $item['qty'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    // Otherwise add new entry
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $productId,
            'name'       => $productName, // ✅ comes from DB now
            'size'       => $size,
            'qty'        => $quantity
        ];
    }

    // Count total items
    $totalQty = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalQty += $item['qty'];
    }

    $response['success'] = true;
    $response['cart_count'] = $totalQty;
} else {
    $response['error'] = 'Invalid product or quantity';
}

echo json_encode($response);
