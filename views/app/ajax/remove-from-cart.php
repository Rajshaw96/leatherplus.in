<?php
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'cart_count' => 0];

$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$size      = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '';

if ($productId > 0 && $size !== '') {
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['product_id'] == $productId && $item['size'] === $size) {
                unset($_SESSION['cart'][$index]);
                $response['success'] = true;
                break;
            }
        }
    }

    // Recalculate total quantity
    $totalQty = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $totalQty += $cartItem['qty'];
    }
    $response['cart_count'] = $totalQty;
} else {
    $response['error'] = "Invalid product or size.";
}

echo json_encode($response);
