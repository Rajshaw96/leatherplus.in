<?php


//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if($connStatus == true){

    $result = $database->runQuery("UPDATE `orders` SET `order_status`='".$_POST['status']."' WHERE `order_id`=".$_POST['id']."");
    
    if($result == true){

        echo "Order status has been updated!";
    }
    else{
        echo "Unable to run query";
    }
}
else{
    echo "false"; 
}