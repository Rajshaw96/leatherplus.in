<?php
// Required PHPMailer Files
require '../../plugins/phpmailer/src/Exception.php';
require '../../plugins/phpmailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';

// Config and Libraries
require_once('../../lib/config/config.php');
require_once('../../lib/notifications/emailnotifications.php');
require_once('../../lib/helpers/urlhelpers.php');

// Get params from URL
$email = $_GET['email'] ?? '';
$fullname = $_GET['fullname'] ?? '';
$otp = $_GET['otp'] ?? '';

if ($email && $fullname && $otp) {
    $url = new UrlHelpers();
    $email_notifs = new EmailNotifications();

    $verifyLink = $url->baseUrl("verify-account?email=$email&otp=$otp");

    $message = "Dear $fullname,<br><br>Your account has been successfully created. Please click the link below to verify your account:<br><a href='$verifyLink'>$verifyLink</a>";

    $email_notifs->sendEmail($email, $fullname, "Verify Your Leather Plus Account", $message);
}
