<?php

session_start();
ob_start();

//Required Config Files
require_once('lib/config/config.php');

//Required libraries
require_once('lib/helpers/urlhelpers.php');
require_once('lib/security/requests.php');
require_once('lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

if ($connStatus == true) {

    if (isset($_GET['q'])) {

        $result = $database->getData("SELECT * FROM `products` WHERE `prod_id` = '" . $_GET['q'] . "' AND `prod_status` = 1");

        if ($result != false) {

            while ($product = mysqli_fetch_array($result)) {

                $title = $product['prod_title'];
                $nickname = $product['prod_nick'];
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
                $prod_attributes = $product['prod_attributes'];
                $matstatus = $product['prod_matstatus'];
                $matparent = $product['prod_matparent'];
                $matattrib = $product['prod_matpattribid'];
                $defmatattrib = $product['prod_defmatattrib'];
                $tags = $product['prod_tags'];
                $setas = $product['prod_setas'];
                $status = $product['prod_status'];
            }

            if ($saleprice > 0) {

                $rate = $saleprice;
            } else {
                $rate = $regularprice;
            }

            $result_reviews = $database->getData("SELECT COUNT(`preview_id`) AS `total_reviews` FROM `product_reviews` WHERE `preview_prodid` = '" . $_GET['q'] . "' AND `preview_status` = 1");

            if ($result_reviews != false) {

                while ($cons_reviews = mysqli_fetch_array($result_reviews)) {

                    $total_reviews = $cons_reviews['total_reviews'];
                }
            }

            //Views

            include('views/app/product.inc.php');
        } else {

            header('location:404');
        }
    } else {

        header('location:404');
    }
} else {

    header('location:404?q=nc');
}
