<?php
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'cart_count' => 0];

// Input validation
$productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$change    = isset($_POST['change']) ? intval($_POST['change']) : 0;
$size      = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : '';

if ($productId > 0 && $size !== '' && $change !== 0) {
    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => &$item) {
            if ($item['product_id'] == $productId && $item['size'] === $size) {
                $item['qty'] += $change;

                // Remove item if qty goes to 0
                if ($item['qty'] <= 0) {
                    unset($_SESSION['cart'][$index]);
                }

                $response['success'] = true;
                break;
            }
        }
        unset($item); // break reference
    }

    // Recalculate total quantity
    $totalQty = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $totalQty += $cartItem['qty'];
    }
    $response['cart_count'] = $totalQty;
} else {
    $response['error'] = "Invalid product, size, or change.";
}

echo json_encode($response);
