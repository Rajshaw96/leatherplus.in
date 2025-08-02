<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/file-operations/filesops.php');


//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$file = new FilesOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['key'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `pages` SET `page_content`='".base64_encode($_POST['content'])."' WHERE `page_id`=1");

            if($result == true){

                header('location:'. $url->baseUrl("admin/pages/company-profile?m=edt1"));
            }
            else{

                header('location:'. $url->baseUrl("admin/pages/company-profile?m=edt0"));
            }

        } else {

            //header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
