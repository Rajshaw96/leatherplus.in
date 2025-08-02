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

    if (isset($_POST['tax_name'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `settings_taxes` SET `stax_name`='".$_POST['tax_name']."', `stax_value`='".$_POST['tax_value']."' WHERE `stax_id`=".$_POST['tax_id']);

            if($result == true){

                header('location:'. $url->baseUrl("admin/settings/taxes?m=edt1"));
            }
            else{

                header('location:'. $url->baseUrl("admin/settings/taxes?m=edt0"));
            }

        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
