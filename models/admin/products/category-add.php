<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/file-operations/filesops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$filesop = new FilesOps();

//Declare Variables
$connStatus = $database->createConnection();

$covername = "";

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_FILES['category_cover'])) {

        echo $covername = $filesop->uploadAndCompressImage("../../../uploads/product-category/", $_FILES['category_cover'], date('ymdhis'));
    }


    if (isset($_POST['category_name'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("INSERT INTO `product_categories`(`pcat_name`, `pcat_parent`, `pcat_desc`, `pcat_content`, `pcat_cover`, `pcat_menuorder`) VALUES('" . mysqli_real_escape_string($database->conn, $_POST['category_name']) . "', " . $_POST['category_parent'] . ", '" . mysqli_real_escape_string($database->conn,$_POST['category_desc']) . "', '" . base64_encode($_POST['category_content']) . "', '" . $covername . "', " . $_POST['category_menuorder'] . ")");

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/products/categories?m=add1"));
            } else {

                header('location:' . $url->baseUrl("admin/products/categories?m=add0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
