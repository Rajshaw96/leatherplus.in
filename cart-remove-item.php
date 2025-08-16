<?php
session_start();
ob_start();

require_once('lib/config/config.php');
require_once('lib/helpers/urlhelpers.php');
require_once('lib/security/requests.php');
require_once('lib/database/databaseops.php');

$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$connStatus = $database->createConnection();

if (isset($_GET['q'])) {
    $prodId = intval($_GET['q']);

    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if (intval($item['product_id']) === $prodId) {
                unset($_SESSION['cart'][$index]);
            }
        }
        // Re-index array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    $_SESSION['cart_totalamt'] = 0;
}

// Redirect back
header('Location: ' . $url->baseUrl('cart'));
exit;
