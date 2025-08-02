<?php
session_start();
ob_start();


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/security/requests.php');

//Create Objects
$url = new UrlHelpers();
$database = new DatabaseOps();
$request = new Requests();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['id']) && $_POST['nickname'] != "" && isset($_POST['rate'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("INSERT INTO `product_reviews`(`preview_title`, `preview_nickname`, `preview_rating`, `preview_content`, `preview_prodid`, `preview_status`) VALUES('" . $_POST['title'] . "', '" . $_POST['nickname'] . "', '" . $_POST['rate'] . "', '" . base64_encode($_POST['content']) . "', '" . $_POST['id'] . "', 0)");

            if ($result != false) {

                header('location:' . $url->baseUrl('product?q=' . $_POST['id'] . '&r=1'));
            } else {

                header('location:' . $url->baseUrl('product?q=' . $_POST['id'] . '&r=0'));
            }
        } else {
            header('location:' . $url->baseUrl('product?q=' . $_POST['id'] . '&m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl('product?q=' . $_POST['id'] . '&m=req'));
    }
} else {
    header('location:' . $url->baseUrl('product?q=' . $_POST['id'] . '&m=ir'));
}
