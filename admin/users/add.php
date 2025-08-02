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

    if ($_SESSION['admin_role'] == "sales" || $_SESSION['admin_role'] == "admin") {

        if ($connStatus == true) {

            $result_settings = $database->getData("SELECT `sett_value` FROM `settings` WHERE `sett_name`='enabletaxes'");

            if ($result_settings != false) {

                while ($settings_row = mysqli_fetch_array($result_settings)) {

                    $enabletaxes = $settings_row['sett_value'];
                }
            }

            include('../../views/admin/users/add.inc.php');
        }
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
