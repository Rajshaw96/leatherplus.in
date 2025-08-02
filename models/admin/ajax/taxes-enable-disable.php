<?php


//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if($connStatus == true){

    $result = $database->runQuery("UPDATE `settings` SET `sett_value`='".$_POST['val']."' WHERE `sett_name`='enabletaxes'");
    
    if($result == true){

        echo "Tax Settings has been applied";
    }
    else{
        echo "Unable to run query";
    }
}
else{
    echo "false"; 
}