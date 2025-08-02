<?php

session_start();
ob_start();

//Required Config Files
require_once('../lib/config/config.php');

//Required libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/security/requests.php');
require_once('../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

//Views
if (isset($_SESSION['admin_id'])) {

    if($connStatus == true){

        $resultusers = $database->getData("SELECT COUNT(`user_id`) AS `totalusers` FROM `users`");

        if($resultusers !=false){

            while($usersrow = mysqli_fetch_array($resultusers)){
                $users = $usersrow['totalusers'];
            }
        }
        else{
            $users = 0;
        }

        $resultproducts = $database->getData("SELECT COUNT(`prod_id`) AS `totalproducts` FROM `products`");

        if($resultproducts !=false){

            while($productssrow = mysqli_fetch_array($resultproducts)){
                $products = $productssrow['totalproducts'];
            }
        }
        else{
            $products = 0;
        }

        $resultpendingorders = $database->getData("SELECT COUNT(`order_id`) AS `totalpendingorders` FROM `orders` WHERE `order_status`='Pending'");

        if($resultpendingorders !=false){

            while($pendingordersrow = mysqli_fetch_array($resultpendingorders)){
                $pendingorders = $pendingordersrow['totalpendingorders'];
            }
        }
        else{
            $pendingorders = 0;
        }
    }

    include('../views/admin/dashboard.inc.php');
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}

