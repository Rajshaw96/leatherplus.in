<?php

session_start();
ob_start();

//Required Config Files
require_once('../lib/config/config.php');

//Required libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/security/requests.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();

//Views
if(!isset($_SESSION['admin_id'])){
    
    include('../views/admin/login.inc.php');
}
else{

    header('location:'.$url->baseUrl('admin/dashboard'));
}

?>