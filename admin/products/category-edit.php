<?php

session_start();
ob_start();

//Required Config Files
require_once('../../lib/config/config.php');

//Required libraries
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/security/requests.php');
require_once('../../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

//Views
if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == "admin") {

    if (isset($_GET['q'])) {

        $result = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_id`=".$_GET['q']);

        if($result != false){

            while($result_row = mysqli_fetch_array($result)){

                $category_name = $result_row['pcat_name'];
                $category_desc = $result_row['pcat_desc'];
                $category_content = $result_row['pcat_content'];
                $category_cover = $result_row['pcat_cover'];
                $category_parent = $result_row['pcat_parent'];
                $category_menuorder = $result_row['pcat_menuorder'];
            }
        }

        include('../../views/admin/products/category-edit.inc.php');
    }
    else{
        header('location:' . $url->baseUrl('admin/products/categories'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
