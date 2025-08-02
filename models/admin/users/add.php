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

    if (isset($_POST['fullname'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("INSERT INTO `users`(`user_fullname`, `user_email`, `user_phone`, `user_password`, `user_billingaddress`, `user_shippingaddress`, `user_tax`, `user_status`) VALUES('" . $_POST['fullname'] . "', '" . $_POST['email'] . "', '" . $_POST['phone'] . "', '" . $passtosave . "', '" . $_POST['billingaddress'] . "', '" . $_POST['shippingaddress'] . "', '" . $_POST['tax'] . "', " . $_POST['status'] . ")");

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/users/all?m=add1"));
            } else {

                header('location:' . $url->baseUrl("admin/users/all?m=add0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
