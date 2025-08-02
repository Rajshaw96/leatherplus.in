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

    if (isset($_POST['attribute_id'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("INSERT INTO `product_attributes_terms`(`pattribterm_name`, `pattribterm_preview`, `pattribterm_attribid`) VALUES('".$_POST['term_name']."', '".$_POST['term_preview']."', '".$_POST['attribute_id']."')");

            if($result == true){

                header('location:'. $url->baseUrl("admin/products/attribute-terms?q=".$_POST['attribute_id']."&m=edt1"));
            }
            else{

                header('location:'. $url->baseUrl("admin/products/attribute-terms?q=".$_POST['attribute_id']."&m=edt0"));
            }

        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
