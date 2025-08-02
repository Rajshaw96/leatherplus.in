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

        $result = $database->getData("SELECT * FROM `product_attributes_terms` JOIN `product_attributes` ON product_attributes_terms.pattribterm_attribid = product_attributes.pattrib_id WHERE `pattribterm_id`=".$_GET['q']);

        if($result != false){

            while($result_row = mysqli_fetch_array($result)){

                $term_name = $result_row['pattribterm_name'];
                $attribute_type = $result_row['pattrib_type'];
                $attribute_id = $result_row['pattribterm_attribid'];
                $term_preview = $result_row['pattribterm_preview'];
            }
        }

        include('../../views/admin/products/attribute-term-edit.inc.php');
    }
    else{
        header('location:' . $url->baseUrl('admin/products/attributes'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
