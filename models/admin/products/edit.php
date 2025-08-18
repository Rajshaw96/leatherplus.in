<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

$categories = "";
$galleries = "";
$attributes = "";

if (!isset($_POST['materials'])) {
    $materials = null;
} else {
    $materials = json_encode($_POST['materials']);
}

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['id'])) {

        if (!empty($_POST['category'])) {
            foreach ($_POST['category'] as $check) {
                if ($categories == "") {
                    $categories = $check;
                } else {
                    $categories = $categories . ", " . $check;
                }
            }
        }

        if (!empty($_POST['attributes'])) {
            foreach ($_POST['attributes'] as $acheck) {
                if ($attributes == "") {
                    $attributes = $acheck;
                } else {
                    $attributes = $attributes . ", " . $acheck;
                }
            }
        }

        if ($_FILES["productgallery"]["tmp_name"][0] != "") {

            $extension = array("jpeg", "jpg", "png", "gif", "jfif", "bmp", "tiff", "tif", "gif");
            foreach ($_FILES["productgallery"]["tmp_name"] as $key => $tmp_name) {


                $file_name = date('ymdhis') . rand(1000, 9999) . $_FILES["productgallery"]["name"][$key];
                $file_tmp = $_FILES["productgallery"]["tmp_name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                if (in_array(strtolower($ext), $extension)) {


                    if (!file_exists("product-gallery/" . $file_name)) {
                        $resupld = move_uploaded_file($file_tmp = $_FILES["productgallery"]["tmp_name"][$key], "../../../uploads/product-gallery/" . $file_name);


                        if ($galleries == "") {
                            $galleries = $file_name;
                        } else {
                            $galleries = $galleries . ", " . $file_name;
                        }
                    } else {
                        $filename = basename($file_name, $ext);
                        $newFileName = $filename . time() . "." . $ext;
                        move_uploaded_file($file_tmp = $_FILES["productgallery"]["tmp_name"][$key], "../../../uploads/product-gallery/" . $newFileName);
                        echo "yes";
                    }
                } else {
                    echo "not uploaded" . $filename;
                }
            }
        } else {

            $galleries = $_POST['oldgallery'];
        }

        if (strlen($_POST['uploadedfeatured']) > 1) {

            $featuredimage = $_POST['uploadedfeatured'];
        } else {

            $featuredimage = $_POST['oldfeaturedimage'];
        }

        if (isset($_POST['managestock']) && $_POST['managestock'] == "on") {

            $managestock = 1;
        } else {
            $managestock = 0;
        }

        if ($_POST['sale_price'] != "") {

            $saleprice = $_POST['sale_price'];
        } else {
            $saleprice = 0;
        }

        if ($connStatus == true) {

            if( isset($_POST['defmatattrib'])){

                $datamatattrib =  $_POST['defmatattrib'];
            }
            else{
                $datamatattrib = 0;
            }
            $productNick = isset($_POST['product_nick']) ? trim($_POST['product_nick']) : '';
            $result = $database->runQuery("UPDATE `products` SET `prod_title`='" . $_POST['product_title'] . "',`prod_nick`='" . $productNick . "', `prod_shortdesc`='" . base64_encode($_POST['product_shortdesc']) . "', `prod_desc`='" . base64_encode($_POST['product_desc']) . "', `prod_type`='" . $_POST['product_type'] . "', `prod_tax`=" . $_POST['tax'] . ",  `prod_regularprice`=" . $_POST['regular_price'] . ", `prod_saleprice`=" . $saleprice . ", `prod_managestock`=" . $managestock . ", `prod_sku`='" . $_POST['sku'] . "', `prod_shippingweight`='" . $_POST['weight'] . "', `prod_shippingl`= '" . $_POST['length'] . "', `prod_shippingw`='" . $_POST['width'] . "', `prod_shippingh`='" . $_POST['height'] . "', `prod_featuredimage`='" . $featuredimage . "', `prod_gallery`='" . $galleries . "', `prod_video`='" . base64_encode($_POST['product_video']) . "', `prod_cats`='" . $categories . "', `prod_attributes`='" . $attributes . "', `prod_matstatus`='" . $_POST['matstatus'] . "', `prod_matparent`='" . $_POST['matattrib'] . "', `prod_matpattribid`='" . $materials . "', `prod_defmatattrib`='" . $datamatattrib . "', `prod_tags`='" . $_POST['tags'] . "', `prod_setas`='" . $_POST['setas'] . "', `prod_status`='" . $_POST['status'] . "' WHERE `prod_id`=" . $_POST['id']);

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/products/edit?q=" . $_POST['id'] . "&m=edt1"));
            } else {

                header('location:' . $url->baseUrl("admin/products/all?q=" . $_POST['id'] . "&m=edt0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
