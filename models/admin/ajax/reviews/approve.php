<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../../lib/config/config.php');

//Required Libraries
require_once('../../../../lib/security/requests.php');
require_once('../../../../lib/helpers/urlhelpers.php');
require_once('../../../../lib/database/databaseops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($connStatus == true) {

    if (isset($_POST['id'])) {

        $result = $database->runQuery("UPDATE `product_reviews` SET `preview_status` = 1 WHERE `preview_id` = '" . $_POST['id'] . "'");

        if ($result == true) {

            echo "Selected review has been approved!";
        } else {

            echo "Error! This action can not be done.";
        }
    } else {
        echo "Invalid Request";
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=nc'));
}
