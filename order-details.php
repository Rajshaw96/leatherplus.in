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

    if (isset($_GET['q'])) {

        if($connStatus == true){

            $result_orderdetails = $database->getData("SELECT * FROM `orders` WHERE `order_num` = '".$_GET['q']."' AND `order_userid` = '".$_SESSION['user_id']."'");

            if($result_orderdetails != false){

                while($orderdetails = mysqli_fetch_array($result_orderdetails)){

                    $order_date = $orderdetails['order_date'];
                    $order_details = json_decode($orderdetails['order_details']);
                    $order_status = $orderdetails['order_status'];
                    $order_paystatus = $orderdetails['order_paystatus'];
                    $order_total = $orderdetails['order_total'];

                }
            }
        }

        include('views/app/order-details.inc.php');
    }
    else{
        header('location:' . $url->baseUrl('my-orders'));
    }
} else {

    header('location:' . $url->baseUrl('login'));
}
