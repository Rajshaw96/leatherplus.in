<?php
session_start();
ob_start();


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/helpers/urlhelpers.php');

$url = new UrlHelpers();

$_SESSION['cart'] = [];

header('location:'.$url->baseUrl("cart"));

?>