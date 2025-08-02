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

    if ($connStatus == true) {

        $result_cat = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_id` = '" . $_GET['q'] . "'");

        if ($result_cat != false) {

            while ($pcat_row = mysqli_fetch_array($result_cat)) {

                $title = $pcat_row['pcat_name'];
                $description = $pcat_row['pcat_desc'];
                $cover = $pcat_row['pcat_cover'];
            }
        }
    }

    if (isset($_GET['show-filter'])) {

        $_SESSION['prod_show_count'] = $_GET['show-filter'];
    } else {
        if (isset($_SESSION['prod_show_count'])) {


        } else {
            $_SESSION['prod_show_count'] = 9;
        }
    }

    if (isset($_GET['sort-filter'])) {

        $_SESSION['prod_sort_by'] = $_GET['sort-filter'];
    } else {
        if (isset($_SESSION['prod_sort_by'])) {


        } else {
            $_SESSION['prod_sort_by'] = "prod_id";
        }
    }

    if (isset($_GET['lower_range'])) {

        $_SESSION['lower_range'] = $_GET['lower_range'];
    } else {
        if (isset($_SESSION['lower_range'])) {


        } else {
            $_SESSION['lower_range'] = 0;
        }
    }

    if (isset($_GET['upper_range'])) {

        $_SESSION['upper_range'] = $_GET['upper_range'];
    } else {
        if (isset($_SESSION['upper_range'])) {


        } else {
            $_SESSION['upper_range'] = 15000;
        }
    }

    if(isset($_GET['page'])){

        $nav_page = $_GET['page'];
    }
    else{

        $nav_page = 1;
    }
}

include('views/app/category.inc.php');
