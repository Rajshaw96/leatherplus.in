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

        if (isset($_GET['q'])) {

            if ($connStatus == true) {

                $result_orderdetails = $database->getData("SELECT * FROM `orders` LEFT JOIN `users` ON `orders`.`order_userid` = `users`.`user_id` WHERE `order_id` = '" . $_GET['q'] . "'");

                if ($result_orderdetails != false) {

                    while ($orderdetails = mysqli_fetch_array($result_orderdetails)) {

                        $order_num = $orderdetails['order_num'];
                        $order_date = $orderdetails['order_date'];
                        $order_details = json_decode($orderdetails['order_details']);
                        $order_status = $orderdetails['order_status'];
                        $order_paystatus = $orderdetails['order_paystatus'];
                        $order_total = $orderdetails['order_total'];
                        $order_tax = $orderdetails['order_tax'];
                        $order_userid = $orderdetails['order_userid'];
                        $order_fullname = $orderdetails['order_fullname'];
                        $order_email = $orderdetails['order_email'];
                        $order_phone = $orderdetails['order_phone'];
                        $order_company = $orderdetails['order_company'];
                        $order_address = $orderdetails['order_address'];
                        $order_city = $orderdetails['order_city'];
                        $order_postcode = $orderdetails['order_postcode'];
                        $order_country = $orderdetails['order_country'];
                        $order_state = $orderdetails['order_state'];
                        $user_billingaddress = $orderdetails['user_billingaddress'];
                    }
                }
            }

            include('../../views/admin/abandoned-cart/print.inc.php');
        }
    } else {
        header('location:' . $url->baseUrl('admin/login?m=ir'));
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
