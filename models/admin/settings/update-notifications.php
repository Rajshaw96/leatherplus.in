<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['admin_email'])) {

        $res = 0;

        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `settings_notifs` SET `settnotif_value` = '" . $_POST['admin_email'] . "' WHERE `settnotif_var` = 'admin_email'");

            if ($result == true) {

                $res = 1;
            } else {

                $res = 0;
            }

            if ($res == 1) {

                $result = $database->runQuery("UPDATE `settings_notifs` SET `settnotif_value` = '" . $_POST['admin_phone'] . "' WHERE `settnotif_var` = 'admin_phone'");

                if ($result == true) {

                    $res = 1;
                } else {

                    $res = 0;
                }
            }

            if ($res == 1) {

                $result = $database->runQuery("UPDATE `settings_notifs` SET `settnotif_value` = '" . $_POST['sms_orderplaced'] . "' WHERE `settnotif_var` = 'sms_orderplaced'");

                if ($result == true) {

                    $res = 1;
                } else {

                    $res = 0;
                }
            }

            if ($res == 1) {

                $result = $database->runQuery("UPDATE `settings_notifs` SET `settnotif_value` = '" . $_POST['email_orderplaced'] . "' WHERE `settnotif_var` = 'email_orderplaced'");

                if ($result == true) {

                    $res = 1;
                } else {

                    $res = 0;
                }
            }

            if($res == 1){

                header('location:'.$url->baseUrl('admin/settings/notifications?m=edt1'));
            }
            else{
                header('location:'.$url->baseUrl('admin/settings/notifications?m=edt0'));
            }


        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=ir"));
    }
}
