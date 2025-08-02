<?php
session_start();
ob_start();

// Required Config Files
require_once('../../lib/config/config.php');

// Required Libraries
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');

// Create Objects
$url = new UrlHelpers();
$database = new DatabaseOps();

// Create DB Connection
$connStatus = $database->createConnection();

// Generate Order Number
$_SESSION['ordernum'] = date('ymdhis') . rand(1000, 9999);

// If Cart Exists
if (isset($_SESSION['cart'])) {
    if ($connStatus === true) {

        // Safely get values with fallbacks
        $fullname = $_POST['fullname'] ?? '';
        $email1 = $_POST['email'] ?? '';
        $email2 = $_POST['email2'] ?? $email1;
        $phone = $_POST['phone'] ?? '';
        $company = $_POST['company'] ?? '';
        $address = $_POST['address1'] ?? '';
        $city = $_POST['city'] ?? '';
        $postcode = $_POST['postcode'] ?? '';
        $country = $_POST['country'] ?? '';
        $region = $_POST['region'] ?? '';
        $user_id = $_SESSION['user_id'] ?? 0;
        $cart_total = $_SESSION['cart_totalamt'] ?? 0;
        $tax = $_SESSION['enabletaxes'] ?? 0;
        $order_num = $_SESSION['ordernum'];
        $order_date = date('Y-m-d');
        $cart_details = json_encode($_SESSION['cart']);

        // Insert Query
        $resultcartdata = $database->runQuery("
            INSERT INTO `orders` (
                `order_num`, `order_date`, `order_details`, `order_total`, `order_tax`,
                `order_status`, `order_userid`, `order_fullname`, `order_email`, `order_phone`,
                `order_company`, `order_address`, `order_city`, `order_postcode`, `order_country`,
                `order_state`, `order_paystatus`
            ) VALUES (
                '$order_num', '$order_date', '$cart_details', $cart_total, '$tax',
                'Pending', $user_id, '$fullname', '$email2', '$phone',
                '$company', '$address', '$city', '$postcode', '$country',
                '$region', 0
            )
        ");

        if ($resultcartdata === true) {
            $ttlamtofcart = $_SESSION['cart_totalamt'] ?? 0;

            // Clear cart data
            if ($payment_successful) {
                $_SESSION['cart'] = [];
                $_SESSION['cart_totalamt'] = 0;
                unset($_SESSION['enabletaxes']);
            }

            // Redirect to payment gateway
            if (strtolower($country) === "india") {
                header('location:' . $url->baseUrl("rzp/pay.php?rcpt=$order_num&amt=$ttlamtofcart&name=$fullname&phone=$phone&email=$email1"));
            } else {
                header('location:' . $url->baseUrl("paypal/index.php?rcpt=$order_num&amt=$ttlamtofcart&name=$fullname&phone=$phone&email=$email2"));
            }
        } else {
            header('location:' . $url->baseUrl('app/cart?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl('app/cart'));
    }
}



?>