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

$categories = "";
$galleries = "";
$attributes = "";

if (!isset($_POST['materials'])) {
    $materials = null;
} else {
    $materials = json_encode($_POST['materials']);
}

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['product_title'])) {

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

        $extension = array("jpeg", "jpg", "png", "gif", "jfif", "bmp", "tiff", "tif", "gif");
        foreach ($_FILES["productgallery"]["tmp_name"] as $key => $tmp_name) {
            $file_name = date('ymdhis') . rand(1000, 9999) . $_FILES["productgallery"]["name"][$key];
            $file_tmp = $_FILES["productgallery"]["tmp_name"][$key];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if (in_array($ext, $extension)) {
                if (!file_exists("photo_gallery/" . $file_name)) {

                    $imgInfo = getimagesize($file_tmp);
                    $mime = $imgInfo['mime'];

                    // Create a new image from file 
                    switch ($mime) {
                        case 'image/jpeg':
                            $image = imagecreatefromjpeg($file_tmp);
                            break;
                        case 'image/png':
                            $image = imagecreatefrompng($file_tmp);
                            break;
                        case 'image/gif':
                            $image = imagecreatefromgif($file_tmp);
                            break;
                        default:
                            $image = imagecreatefromjpeg($file_tmp);
                    }

                    // Save image 
                    imagejpeg($image, "../../../uploads/product-gallery/" . $file_name, 40);

                    //move_uploaded_file($file_tmp = $_FILES["productgallery"]["tmp_name"][$key], "../../uploads/product-gallery/" . $file_name);

                    if ($galleries == "") {
                        $galleries = $file_name;
                    } else {
                        $galleries = $galleries . ", " . $file_name;
                    }
                } else {
                    $filename = basename($file_name, $ext);
                    $newFileName = $filename . time() . "." . $ext;

                    imagejpeg($image, "../../../uploads/product-gallery/" . $newFileName, 40);

                    //move_uploaded_file($file_tmp = $_FILES["productgallery"]["tmp_name"][$key], "../../uploads/product-gallery/" . $newFileName);
                }
            } else {
                echo "unable to upload " . $file_name;
            }
        }

        if (isset($_POST['managestock']) && $_POST['managestock'] == "on") {

            $managestock = 1;
        } else {
            $managestock = 0;
        }

        if ($_POST['sale_price'] != "") {

            $saleprice = $_POST['sale_price'];
        } else {
            $saleprice = "";
        }

        if ($connStatus == true) {

            $result = $database->runQuery("
    INSERT INTO `products`
    (
        `prod_secret`, 
        `prod_nick`, 
        `prod_title`, 
        `prod_shortdesc`, 
        `prod_desc`, 
        `prod_type`, 
        `prod_tax`, 
        `prod_regularprice`, 
        `prod_saleprice`, 
        `prod_managestock`, 
        `prod_sku`, 
        `prod_shippingweight`, 
        `prod_shippingl`, 
        `prod_shippingw`, 
        `prod_shippingh`, 
        `prod_featuredimage`, 
        `prod_gallery`, 
        `prod_video`, 
        `prod_cats`, 
        `prod_attributes`, 
        `prod_matstatus`, 
        `prod_matparent`, 
        `prod_matpattribid`, 
        `prod_defmatattrib`, 
        `prod_tags`, 
        `prod_setas`, 
        `prod_status`
    )
    VALUES
    (
        '" . $_POST['prod_secret'] . "',
        '" . mysqli_real_escape_string($database->conn, $_POST['product_nick']) . "',
        '" . mysqli_real_escape_string($database->conn, $_POST['product_title']) . "',
        '" . base64_encode($_POST['product_shortdesc']) . "',
        '" . base64_encode($_POST['product_desc']) . "',
        '" . $_POST['product_type'] . "',
        " . $_POST['tax'] . ",
        '" . $_POST['regular_price'] . "',
        '" . $saleprice . "',
        " . $managestock . ",
        '" . $_POST['sku'] . "',
        '" . $_POST['weight'] . "',
        '" . $_POST['length'] . "',
        '" . $_POST['width'] . "',
        '" . $_POST['height'] . "',
        '" . $_POST['uploadedfeatured'] . "',
        '" . $galleries . "',
        '" . base64_encode($_POST['product_video']) . "',
        '" . $categories . "',
        '" . $attributes . "',
        " . $_POST['matstatus'] . ",
        '" . $_POST['matattrib'] . "',
        '" . $materials . "',
        '" . $_POST['defmatattrib'] . "',
        '" . $_POST['tags'] . "',
        '" . $_POST['setas'] . "',
        " . $_POST['status'] . "
    )
");


            if ($result == true) {

                header('location:' . $url->baseUrl("admin/products/all?m=add1"));
            } else {

                header('location:' . $url->baseUrl("admin/products/all?m=add0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
