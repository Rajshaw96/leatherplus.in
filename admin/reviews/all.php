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

    if ($_SESSION['admin_role'] == "sales" || $_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "shopmanager") {

        include('../../views/admin/reviews/all.inc.php');
    }
    else{

        header('location:' . $url->baseUrl('admin/login?m=ir'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
