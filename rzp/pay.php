<?php

require('config.php');
require('Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);
$amount = floatval($_GET['amt']);
// $amount = 500;

if ($amount < 1) {
    die("Amount must be at least ₹1 to proceed with Razorpay.");
}
//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => $_GET['rcpt'],
    'amount'          => $amount * 100,
    'currency'        => 'INR',
    'payment_capture' => 1
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "Leather Plus",
    "description"       => "Online Shopping",
    "image"             => "",
    "prefill"           => [
    "name"              => $_GET['name'],
    "email"             => $_GET['email'],
    "contact"           => $_GET['phone'],
    ],
    "notes"             => [
    "address"           => "",
    "merchant_order_id" => $_GET['rcpt'],
    ],
    "theme"             => [
    "color"             => "#FC5456"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

require("checkout/{$checkout}.php");

?>

<html>
    <script>
        document.querySelector('.razorpay-payment-button').click();
    </script>
</html>