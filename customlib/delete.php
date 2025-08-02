<?php

session_start();
ob_start();

//Required Config Files
require_once('../lib/config/config.php');

//Required libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

//Views
if(isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == "admin"){
    if(isset($_POST['tablename']) && isset($_POST['columnname']) && isset($_POST['columnvalue']) && isset($_POST['backto'])){

        if($connStatus == true){
            $result = $database->runQuery("DELETE FROM `".$_POST['tablename']."` WHERE `".$_POST['columnname']."` = '".$_POST['columnvalue']."'");

            header('location:'.$_POST['backto'].'?m=ds');
        }
        else{
            header('location:'.$_POST['backto'].'?m=nd');
        }
    }
}
else{

    header('location:'.$url->baseUrl('admin/login?m=ir'));
}

?>