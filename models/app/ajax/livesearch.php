<?php

session_start();
ob_start();

//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if($connStatus == true){

    $result = $database->getData("SELECT * FROM `products` WHERE `prod_title` Like '%".$_GET['q']."%' LIMIT 3");

    if($result != false){

        while($products = mysqli_fetch_array($result)){

            echo "<a href='#' onclick='fillSearch(this)'>".$products['prod_title']."</a><br>";
        }
    }
}

?>