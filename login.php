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

if (isset($_COOKIE['uinfo'])) {

    $resultuserdetails = $database->getData("SELECT * FROM `users` WHERE `user_email`='" . base64_decode($_COOKIE['uinfo']) . "'");

    if ($resultuserdetails != false) {

        while ($userdetails = mysqli_fetch_array($resultuserdetails)) {


            $_SESSION['user_id'] = $userdetails['user_id'];
            $_SESSION['user_name'] = $userdetails['user_fullname'];
            $_SESSION['user_email'] = $userdetails['user_email'];
            $_SESSION['user_type'] = $userdetails['user_type'];
        }
    }
}

//Views
if (!isset($_SESSION['user_id'])) {

    include('views/app/login.inc.php');
} else {

    header('location:' . $url->baseUrl('my-account'));
}
