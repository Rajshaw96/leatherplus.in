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
if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == "admin") {

    if (isset($_GET['q'])) {

        if ($connStatus == true) {

            $result = $database->getData("SELECT * FROM `settings_taxes` WHERE `stax_id`=" . $_GET['q'] . "");

            if($result != false){

                while ($result_row = mysqli_fetch_array($result)){

                    $tax_name = $result_row['stax_name'];
                    $tax_value = $result_row['stax_value'];
                }
            }
        }

        include('../../views/admin/settings/tax-edit.inc.php');
    }
    else{

        header('location:'.$url->baseUrl('admin/settings/taxes'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
