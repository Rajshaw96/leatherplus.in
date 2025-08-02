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
if (isset($_SESSION['admin_id'])  && $_SESSION['admin_role'] == "admin") {

    if ($connStatus == true) {

        $result_settnotifs = $database->getData("SELECT * FROM `settings_notifs`");

        if ($result_settnotifs != false) {

            while ($settnotifs = mysqli_fetch_array($result_settnotifs)) {

                if ($settnotifs['settnotif_var'] == "sms_orderplaced") {

                    $sms_orderplaced = $settnotifs['settnotif_value'];
                }

                if ($settnotifs['settnotif_var'] == "email_orderplaced") {

                    $email_orderplaced = $settnotifs['settnotif_value'];
                }

                if ($settnotifs['settnotif_var'] == "admin_email") {

                    $admin_email = $settnotifs['settnotif_value'];
                }

                if ($settnotifs['settnotif_var'] == "admin_phone") {

                    $admin_phone = $settnotifs['settnotif_value'];
                }
            }
        }

        include('../../views/admin/settings/notifications.inc.php');
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
