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

    if ($_SESSION['admin_role'] == "sales" || $_SESSION['admin_role'] == "admin" || $_SESSION['admin_role'] == "shopmanager") {

        if ($connStatus == true) {

            $result = $database->getData("SELECT * FROM `pages` WHERE `page_id`= 1");

            if($result != false){

                while ($result_row = mysqli_fetch_array($result)){

                    $data = $result_row["page_content"];
                }
            }
        }

        include('../../views/admin/pages/company-profile.inc.php');
    }
    else{

        header('location:' . $url->baseUrl('admin/login?m=ir'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
