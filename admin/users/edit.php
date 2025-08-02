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

        if (isset($_GET['q'])) {

            if ($connStatus == true) {

                $resultuser = $database->getData("SELECT * FROM `users` WHERE `user_id`=" . $_GET['q'] . "");

                if ($resultuser != false) {

                    while ($user = mysqli_fetch_array($resultuser)) {

                        $fullname = $user['user_fullname'];
                        $phone = $user['user_phone'];
                        $email = $user['user_email'];
                        $billingaddress = $user['user_billingaddress'];
                        $shippingaddress = $user['user_shippingaddress'];
                        $tax = $user['user_tax'];
                        $status = $user['user_status'];
                    }
                }
            }

            include('../../views/admin/users/edit.inc.php');
        }
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
