<?php
session_start();
ob_start();


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['term_id'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `product_attributes_terms` SET `pattribterm_name`='" . $_POST['term_name'] . "', `pattribterm_preview`='" . $_POST['term_preview'] . "' WHERE `pattribterm_id`=" . $_POST['term_id'] . "");

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/products/attribute-terms?q=" . $_POST['attribute_id'] . "&m=add1"));
            } else {

                header('location:' . $url->baseUrl("admin/products/attributes?m=add0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
