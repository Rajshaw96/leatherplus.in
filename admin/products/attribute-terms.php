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
if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == "admin") {

    if (isset($_GET['q'])) {

        $result = $database->getData("SELECT * FROM `product_attributes` WHERE `pattrib_id`=".$_GET['q']);

        if($result != false){

            while($result_row = mysqli_fetch_array($result)){

                $attribute_name = $result_row['pattrib_name'];
                $attribute_type = $result_row['pattrib_type'];
            }
        }

        include('../../views/admin/products/attribute-terms.inc.php');
    }
    else{
        header('location:' . $url->baseUrl('admin/products/attributes'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
