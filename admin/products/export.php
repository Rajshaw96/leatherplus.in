<?php

session_start();
ob_start();

//Required Config Files
require_once('../../lib/config/config.php');

//Required libraries
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/security/requests.php');
require_once('../../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

//Views
if (isset($_SESSION['admin_id'])) {

    if(isset($_GET['q'])){

        $q = $_GET['q'];
    }
    else{
        $q = 0;
    }

    if ($_SESSION['admin_role'] == "shopmanager" || $_SESSION['admin_role'] == "admin") {

        include('../../views/admin/products/export.inc.php');
    } else {

        header('location:' . $url->baseUrl('admin/login?m=ir'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
