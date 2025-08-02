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

    if ($connStatus == true) {

        $result = $database->runQuery("INSERT INTO `blogs`(`blog_title`, `blog_description`, `blog_featuredimage`, `blog_status`) VALUES('" . mysqli_real_escape_string($database->conn,  $_POST['title']) . "', '" . base64_encode($_POST['description']) . "', '" . $_POST['uploadedfeatured'] . "', " . $_POST['status'] . ")");

        if ($result == true) {

            header('location:' . $url->baseUrl("admin/blogs/all?m=add1"));
        } else {

            header('location:' . $url->baseUrl("admin/blogs/all?m=add0"));
        }
    } else {

        header('location:' . $url->baseUrl('admin/login?m=nc'));
    }
} else {
    header('location:' . $url->baseUrl("admin/login?m=ir"));
}
