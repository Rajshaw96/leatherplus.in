<?php

ob_start();

//Required PHPMailer FIles

require '../plugins/phpmailer/src/Exception.php';
require '../plugins/phpmailer/src/PHPMailer.php';
require '../plugins/phpmailer/src/SMTP.php';

require('config.php');

session_start();

require('Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

//Required Config Files
require_once('../lib/config/config.php');

//Required Libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/database/databaseops.php');
require_once('../lib/notifications/emailnotifications.php');
require_once('../lib/notifications/smsnotifications.php');

require_once('../plugins/shiprocket/Shiprocket.php');

require_once('../services/aisensy_api.php'); // 👈 Add this line to include the Aisensy API helper

//Create Objects
$url = new UrlHelpers();
$database = new DatabaseOps();
$emailnotif = new EmailNotifications();
$smsnotif = new SMSNotifications();
$ship_rocket = new Shiprocket();

//Declare Variables
$connStatus = $database->createConnection();

if ($connStatus == true) {

    $result_settnotifs = $database->getData("SELECT * FROM `settings_notifs`");

    if ($result_settnotifs != false) {

        while ($settnotifs = mysqli_fetch_array($result_settnotifs)) {

            if ($settnotifs['settnotif_var'] == "sms_orderplaced") {

                $sms_orderplaced = $settnotifs['settnotif_value'];
            }

            if ($settnotifs['settnotif_var'] == "email_orderplaced") {

                $email_orderplaced = $settnotifs['settnotif_value'];
            }

            if ($settnotifs['settnotif_var'] == "admin_email") {

                $admin_email = $settnotifs['settnotif_value'];
            }

            if ($settnotifs['settnotif_var'] == "admin_phone") {

                $admin_phone = $settnotifs['settnotif_value'];
            }
        }
    }
}

$email_orderplaced = str_replace("{{cust_name}}", $_SESSION['user_name'], $email_orderplaced);
$email_orderplaced = str_replace("{{order_number}}", $_SESSION['ordernum'], $email_orderplaced);

$sms_orderplaced = str_replace("{{cust_name}}", $_SESSION['user_name'], $sms_orderplaced);
$sms_orderplaced = str_replace("{{order_number}}", $_SESSION['ordernum'], $sms_orderplaced);


$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {

    // IMPORTANT: The HTML output below will cause a redirect to fail.
    // It's best to move all logic before any output.
    // For this example, we're just adding the Aisensy code block.
    // The previous answer provided a full refactoring to fix this.
    // Please ensure you use that refactored structure in production.
    
    // Fetch order details again to get full name and phone from DB
    $result_orderdetails = $database->getData("SELECT * FROM `orders` WHERE `order_num` = '" . $_SESSION['ordernum'] . "'");
    $ordr = mysqli_fetch_array($result_orderdetails);
    
    if ($ordr) {
        $fullname = $ordr['order_fullname'];
        $phone = $ordr['order_phone'];
        $firstName = strtok($fullname, ' ');

        // 🟢 Call Aisensy API
        $aisensy_data = [
            "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY4YjZhYzcyZGZkZGU0MGMzMWNlZGM3ZSIsIm5hbWUiOiJTdGFyIE9ubGluZSBJbmMiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjhiNmFjNzJkZmRkZTQwYzMxY2VkYzc5IiwiYWN0aXZlUGxhbiI6IkZSRUVfRk9SRVZFUiIsImlhdCI6MTc1NjgwMjE2Mn0.u9B4-RskS_j2QezAZt09rmI7O7-x76t-fB_lX7HCpws", // 👈 Replace with your actual API key
            "campaignName" => "Leatherplus",
            "destination" => "+91" . $phone, // Add country code if not present
            "userName" => $firstName,
            "templateParams" => [
                $firstName,
                "Leather Plus"
            ],
            "media" => [
                "url" => "https://leatherplus.in/views/app/assets/images/Desktop_Banner.jpg",
                "filename" => "file"
            ]
        ];

        $aisensy_response = aisensyApiPost($aisensy_data);
        if (isset($aisensy_response['error'])) {
            error_log("Aisensy API Error on Prepaid Success: " . ($aisensy_response['message'] ?? 'Unknown error'));
        }
    }


    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";

    $emailnotif->sendEmail($_SESSION['user_email'], $_SESSION['user_name'], 'Your Order has been received!', $email_orderplaced);

    $emailnotif->sendEmail($admin_email, "Leather Plus Admin", '1 New Order has been received!', $email_orderplaced);

    $smsnotif->sendSMS($_SESSION['user_phone'], $sms_orderplaced);


    if ($connStatus == true) {

        $order_product_array = array();

        $result_orderdetails = $database->getData("SELECT * FROM `orders` WHERE `order_num` = '" . $_SESSION['ordernum'] . "'");

        if ($result_orderdetails != false) {

            while ($ordr = mysqli_fetch_array($result_orderdetails)) {

                $products = json_decode($ordr['order_details']);

                foreach ($products as $prod_arry) {

                    $result_prod_details = $database->getData("SELECT * FROM `products` WHERE `prod_id` = " . $prod_arry[0]);

                    if ($result_prod_details != false) {

                        while ($prod_details = mysqli_fetch_array($result_prod_details)) {

                            array_push($order_product_array , array(
                                "name" => $prod_details['prod_title'],
                                "sku" => $prod_details['prod_sku'],
                                "units" => $prod_arry[1],
                                "selling_price" => $prod_arry[2],
                                "discount" => "",
                                "tax" => "",
                                "hsn" => 42033000
                            ));
                        }
                    }
                }

                $order_details_for_ship = array(
                    "order_id" => $_SESSION['ordernum'],
                    "order_date" => $ordr['order_date'],
                    "pickup_location" => "Star Online Inc.",
                    "channel_id" => "1556708",
                    "comment" => "From leatherplus.in",
                    "billing_customer_name" => $ordr['order_fullname'],
                    "billing_last_name" => "",
                    "billing_address" => $ordr['order_address'],
                    "billing_address_2" => "",
                    "billing_city" => $ordr['order_city'],
                    "billing_pincode" => $ordr['order_postcode'],
                    "billing_state" => $ordr['order_state'],
                    "billing_country" => $ordr['order_country'],
                    "billing_email" =>  $ordr['order_email'],
                    "billing_phone" => $ordr['order_phone'],
                    "shipping_is_billing" => true,
                    "shipping_customer_name" => "",
                    "shipping_last_name" => "",
                    "shipping_address" => "",
                    "shipping_address_2" => "",
                    "shipping_city" => "",
                    "shipping_pincode" => "",
                    "shipping_country" => "",
                    "shipping_state" => "",
                    "shipping_email" => "",
                    "shipping_phone" => "",
                    "order_items" => $order_product_array,
                    "payment_method" => "Prepaid",
                    "shipping_charges" => 0,
                    "giftwrap_charges" => 0,
                    "transaction_charges" => 0,
                    "total_discount" => 0,
                    "sub_total" => $ordr['order_total'],
                    "length" => 10,
                    "breadth" => 15,
                    "height" => 20,
                    "weight" => 2.5
                );
            }
        }

        $result_updatedetails = $database->runQuery("UPDATE `orders` SET `order_paystatus` = 1 WHERE `order_num` = '" . $_SESSION['ordernum'] . "'");

        if ($result_updatedetails != false) {

            echo "Payment status is updated!";

            $synced_ship = $ship_rocket->generateOrder($order_details_for_ship);

            var_dump($synced_ship);

            if ($synced_ship == true) {
                echo "Order synced to shiprocket";
            } else {
                echo "Order not synced to shiprocket.";
            }

            //header('location:../my-orders?q=order-confirmed');
        } else {

            echo "Something went wrong";
        }
    } else {

        echo "Database server not established";
    }
} else {
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;

?>