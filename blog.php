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

//Views

if (isset($_GET['q'])) {

    if($connStatus == true){

        $result_blog = $database->getData("SELECT * FROM `blogs` WHERE `blog_id` = ".$_GET['q'] ." AND `blog_status` = 1");

        if($result_blog != false){

            while($blog = mysqli_fetch_array($result_blog)){

                $title = $blog['blog_title'];
                $description = $blog['blog_description'];
                $featuredimage = $blog['blog_featuredimage'];
                $time = $blog['blog_creationtime'];
            }
        }
    }

    include('views/app/blog.inc.php');
} else {

    header('location:' . $url->baseUrl('index'));
}
