<?php
session_start();
ob_start();


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/security/password.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$password = new Password();

//Declare Variables
$connStatus = $database->createConnection();

$old_password = $password->encryptPassword($_POST['old_password']);
$new_password = $password->encryptPassword($_POST['new_password']);

$getResultsop = $database->getData("SELECT `admin_password` FROM `admins` WHERE `admin_id`=" . $_SESSION['admin_id'] . "");
if ($getResultsop != false) {
    while ($getResults_rowop = mysqli_fetch_array($getResultsop)) {

        $fetchop = $getResults_rowop['admin_password'];
    }
}
if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true){

    if (isset($_POST)) {

        if ($connStatus == true) {

            if ($fetchop == $old_password) {
            
                $result = $database->runQuery("UPDATE `admins` SET `admin_password`= '$new_password' WHERE `admin_id`=" . $_SESSION['admin_id'] . " AND `admin_password`='" . $old_password . "'");

                if ($result == true) {

                    header('location:' . $url->baseUrl("admin/change-password?m=su"));
                } else {
                    header('location:' . $url->baseUrl("admin/change-password?m=fa"));
                }
            } 
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:'. $url->baseUrl("admin/change-password?m=ir"));
      }
    }
    else{
    
        header('location:'.$url->baseUrl('admin/change-password?m=ir'));
    }
  
  