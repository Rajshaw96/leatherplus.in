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
if (isset($_SESSION['admin_id'])) {

    if ($_SESSION['admin_role'] == "shopmanager" || $_SESSION['admin_role'] == "admin") {

        if (isset($_GET['q'])) {

            if ($connStatus == true) {

                $result_settings = $database->getData("SELECT `sett_value` FROM `settings` WHERE `sett_name`='enabletaxes'");

                if ($result_settings != false) {

                    while ($settings_row = mysqli_fetch_array($result_settings)) {

                        $enabletaxes = $settings_row['sett_value'];
                    }
                }

                $resultproducts = $database->getData("SELECT * FROM `products` WHERE `prod_id`=" . $_GET['q'] . "");

                if ($resultproducts != false) {

                    while ($product = mysqli_fetch_array($resultproducts)) {

                        $title = $product['prod_title'];
                        $shortdesc = $product['prod_shortdesc'];
                        $desc = $product['prod_desc'];
                        $type = $product['prod_type'];
                        $tax = $product['prod_tax'];
                        $regularprice = $product['prod_regularprice'];
                        $saleprice = $product['prod_saleprice'];
                        $managestock = $product['prod_managestock'];
                        $stockqty = $product['prod_stockqty'];
                        $sku = $product['prod_sku'];
                        $weight = $product['prod_shippingweight'];
                        $length = $product['prod_shippingl'];
                        $height = $product['prod_shippingh'];
                        $width = $product['prod_shippingw'];
                        $featuredimage = $product['prod_featuredimage'];
                        $gallery = $product['prod_gallery'];
                        $video = $product['prod_video'];
                        $categories = $product['prod_cats'];
                        $attributes = $product['prod_attributes'];
                        $matstatus = $product['prod_matstatus'];
                        $matparent = $product['prod_matparent'];
                        $matattrib = $product['prod_matpattribid'];
                        $defmatattrib = $product['prod_defmatattrib'];
                        $tags = $product['prod_tags'];
                        $setas = $product['prod_setas'];
                        $status = $product['prod_status'];
                    }
                }
            }

            if($defmatattrib == null || $defmatattrib == ""){
                $defmatattrib = 0;
            }

            include('../../views/admin/products/edit.inc.php');
        }
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}