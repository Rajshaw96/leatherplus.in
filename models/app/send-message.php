<?php
session_start();
ob_start();


//Required PHPMailer FIles

require '../../plugins/phpmailer/src/Exception.php';
require '../../plugins/phpmailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';


//Required Config Files
require_once('../../lib/config/config.php');

//Required Libraries
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/security/password.php');
require_once('../../lib/notifications/emailnotifications.php');

//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$password = new Password();
$email_notifs = new EmailNotifications();

//Declare Variables
$connStatus = $database->createConnection();

if (isset($_POST['contactemail'])) {

    if ($connStatus == true) {

        $result_settnotifs = $database->getData("SELECT * FROM `settings_notifs`");

        if ($result_settnotifs != false) {

            while ($settnotifs = mysqli_fetch_array($result_settnotifs)) {

                if ($settnotifs['settnotif_var'] == "admin_email") {

                    $admin_email = $settnotifs['settnotif_value'];
                }
            }
        }

        if ($email_notifs->sendEmail($admin_email, "Leather Plus", $_POST['contactsubject'], "Name: ".$_POST['contactname']."<br>"."Email: ".$_POST['contactemail']."<br>"."Message: ".$_POST['contactmessage']) == true) {

            header('location:' . $url->baseUrl('contact?m=send1'));
        } else {

            header('location:' . $url->baseUrl('contact?m=send0'));
        }
    } else {
        header('location:' . $url->baseUrl('contact?m=send0'));
    }
} else {
    header('location:' . $url->baseUrl('contact?m=send0'));
}
