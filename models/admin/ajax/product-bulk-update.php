<?php


//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if($connStatus == true){

    $result = $database->runQuery("UPDATE `products` SET `prod_regularprice`='".$_POST['reg']."', `prod_saleprice`='".$_POST['sale']."', `prod_tax`=".$_POST['tax'].", `prod_setas`='".$_POST['setas']."', `prod_status`=".$_POST['status']." WHERE `prod_id`=".$_POST['pid']."");
    
    if($result == true){

        echo "Product Details Updated";
    }
    else{
        echo "Unable to Update";
    }
}
else{
    echo "false"; 
}