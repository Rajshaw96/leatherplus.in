<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/security/password.php');


//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$password = new Password();

//Declare Variables
$connStatus = $database->createConnection();

$passtosave = $password->encryptPassword($_POST['password']);


if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {


    if (isset($_POST['id'])) {


        if ($connStatus == true) {

            

            if (strlen($_POST['password']) >= 1) {

                $result = $database->runQuery("UPDATE `users` SET `user_fullname`='" . $_POST['fullname'] . "', `user_email`='" . $_POST['email'] . "', `user_phone`= '" . $_POST['phone'] . "', `user_password`='".$passtosave."', `user_billingaddress`='" . $_POST['billingaddress'] . "', `user_shippingaddress`='" . $_POST['shippingaddress'] . "', `user_tax`='".$_POST['tax']."', `user_status`=" . $_POST['status'] . " WHERE `user_id`='".$_POST['id']."'");
            }
            else{

                $result = $database->runQuery("UPDATE `users` SET `user_fullname`='" . $_POST['fullname'] . "', `user_email`='" . $_POST['email'] . "', `user_phone`= '" . $_POST['phone'] . "', `user_billingaddress`='" . $_POST['billingaddress'] . "', `user_shippingaddress`='" . $_POST['shippingaddress'] . "', `user_tax`='".$_POST['tax']."', `user_status`=" . $_POST['status'] . " WHERE `user_id`='".$_POST['id']."'");
            }

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/users/all?m=edt1"));
            } else {

                header('location:' . $url->baseUrl("admin/users/all?m=edt0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
