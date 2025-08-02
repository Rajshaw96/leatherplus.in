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

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true){

    if(isset($_POST['email'])){

        if($connStatus == true){

            $result = $database->getData("SELECT * FROM `admins` WHERE `admin_email`='".$_POST['email']."' AND `admin_password`='".$password->encryptPassword($_POST['password'])."' AND `admin_status`=1");

            if($result != false){

                while($result_row = mysqli_fetch_array($result)){

                    $_SESSION['admin_id'] = $result_row['admin_id'];
                    $_SESSION['admin_name'] = $result_row['admin_name'];
                    $_SESSION['admin_email'] = $result_row['admin_email'];
                    $_SESSION['admin_role'] = $result_row['admin_role'];
                }

                header('location:'.$url->baseUrl('admin/dashboard'));
            }
            else{

                header('location:'.$url->baseUrl('admin/login?m=wc'));
            }
        }
        else{

            header('location:'.$url->baseUrl('admin/login?m=nc'));
        }
    }
    else{

        header('location:'.$url->baseUrl('admin/login?m=ir'));
    }
}
else{

    header('location:'.$url->baseUrl('admin/login?m=ir'));
}
