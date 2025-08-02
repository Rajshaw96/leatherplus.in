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

if($connStatus == true){

    $result_check = $database->runQuery("UPDATE `users` SET `user_status` = 1 WHERE `user_otp` = '".$_GET['otp']."' AND `user_email` = '".$_GET['email']."'");

    if($result_check != false){

        header('location:login?m=ver1');
    }
    else{

        header('location:login?ver0');
    }
}