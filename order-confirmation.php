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

if (isset($_GET['q'])) {

    $result_orderdetails = $database->getData("SELECT * FROM `orders` WHERE `order_num` = '".$_GET['q']."'");

    if($result_orderdetails != false){

        while($orderdetails = mysqli_fetch_array($result_orderdetails)){

            $fullname = $orderdetails['order_fullname'];
            $phone = $orderdetails['order_phone'];
            $order_date = $orderdetails['order_date'];
            $details = $orderdetails['order_details'];
            $total = $orderdetails['order_total'];
            $order_status = $orderdetails['order_status'];
        }
    }

    include('views/app/order-confirmation.inc.php');
} else {

    header('location:' . $url->baseUrl('index'));
}
