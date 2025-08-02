<?php
session_start();
ob_start();


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/file-operations/filesops.php');


//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$file = new FilesOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['key'])) {

        $uploadeslide = $file->uploadImage("../../uploads/sliders/", $_FILES['slide'], date("ymdhisa"), "5000000");

        if ($connStatus == true && $uploadeslide != false) {

            $result = $database->runQuery("INSERT INTO `appearance_sliders`(`apslide_path`, `apslide_type`) VALUES('".$uploadeslide."', 'homepage')");

            if($result == true){

                header('location:'. $url->baseUrl("admin/appearance/homepage-slider?m=add1"));
            }
            else{

                header('location:'. $url->baseUrl("admin/appearance/homepage-slider?m=add0"));
            }

        } else {

            //header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
