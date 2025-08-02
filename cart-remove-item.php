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

    unset($_SESSION['cart'][$_GET['q']]);

    $_SESSION['cart_totalamt'] = 0;
}

//var_dump($_SESSION['cart']);

header('location:' . $url->baseUrl('cart'));
