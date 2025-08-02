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


if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['category_id'])) {

        if (strlen($_FILES['category_cover']['tmp_name']) > 3) {

            echo $covername = $filesop->uploadAndCompressImage("../../../uploads/product-category/", $_FILES['category_cover'], date('ymdhis'));
        } else {
            echo $covername = $_POST['catcover'];
        }


        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `product_categories` SET `pcat_name`='" . mysqli_real_escape_string($database->conn, $_POST['category_name']) . "', `pcat_parent`=" . $_POST['category_parent'] . ", `pcat_desc`='" . mysqli_real_escape_string($database->conn, $_POST['category_desc']) . "', `pcat_content`='" . base64_encode($_POST['category_content']) . "', `pcat_cover`='" . $covername . "', `pcat_menuorder`='" . $_POST['category_menuorder'] . "' WHERE `pcat_id`=" . $_POST['category_id']);

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/products/categories?m=edt1"));
            } else {

                header('location:' . $url->baseUrl("admin/products/categories?m=edt0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/products/change-password?m=ir"));
    }
}
