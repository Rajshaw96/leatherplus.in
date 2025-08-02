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

$old_password = $password->encryptPassword($_POST['opassword']);
$new_password = $password->encryptPassword($_POST['npassword']);

$getResultsop = $database->getData("SELECT `user_password` FROM `users` WHERE `user_id`=" . $_SESSION['user_id'] . "");
if ($getResultsop != false) {
    while ($getResults_rowop = mysqli_fetch_array($getResultsop)) {

        $fetchop = $getResults_rowop['user_password'];
    }
}

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true){

    if ($fetchop == $old_password) {
            
        $result = $database->runQuery("UPDATE `users` SET `user_password`= '$new_password' WHERE `user_id`=" . $_SESSION['user_id'] . " AND `user_password`='" . $old_password . "'");

        if ($result == true) {

            header('location:' . $url->baseUrl("app/change-password?m=su"));
        } else {
            header('location:' . $url->baseUrl("app/change-password?m=fa"));
        }
    }
    else{

        header('location:'.$url->baseUrl('app/change-password?m=wp'));
    }
}
else{

    header('location:'.$url->baseUrl('app/login?m=ir'));
}
