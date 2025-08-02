<?php

session_start();
ob_start();

//Required Config Files
require_once('lib/config/config.php');

//Required libraries
require_once('lib/helpers/urlhelpers.php');
require_once('lib/security/requests.php');
require_once('lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

//Views

if (isset($_SESSION['user_id'])) {

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        if($connStatus == true){

            $result_userdetails = $database->getData(("SELECT * FROM `users` WHERE `user_id` = '".$_SESSION['user_id']."'"));

            if($result_userdetails != false){

                while($userdetails = mysqli_fetch_array($result_userdetails)){

                    $user_phone = $userdetails['user_phone'];
                    $user_address = $userdetails['user_billingaddress'];
                    $user_pincode = $userdetails['user_pincode'];
                }
            }
        }

        include('views/app/checkout.inc.php');
    } else {

        header('location:cart');
    }
} else {

    header('location:' . $url->baseUrl('login'));
}
