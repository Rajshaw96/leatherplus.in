<?php
session_start();
ob_start();

// Required PHPMailer Files
require '../../plugins/phpmailer/src/Exception.php';
require '../../plugins/phpmailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';

// Config and Libraries
require_once('../../lib/config/config.php');
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/security/password.php');
require_once('../../lib/notifications/emailnotifications.php');

// Object Creation
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$password = new Password();
$email_notifs = new EmailNotifications();

// DB connection
$connStatus = $database->createConnection();

// OTP generation
$user_otp = rand(10000, 99999);

// Validate request hash
if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) === true) {
    if (
        isset($_POST['fullname'], $_POST['phone'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])
    ) {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            header('Location: ' . $url->baseUrl('register?m=pwd_mismatch'));
            exit;
        }

        if ($connStatus === true) {
            $fullname = $_POST['fullname'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            // ✅ Fast, secure password hashing
            $encryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $query = "INSERT INTO `users`
                (`user_fullname`, `user_phone`, `user_email`, `user_password`, `user_status`, `user_otp`)
                VALUES ('$fullname', '$phone', '$email', '$encryptedPassword', '1', '$user_otp')";

            $result = $database->runQuery($query);

            if ($result !== false) {
                // ✅ Immediate redirect to user
                header('Location: ' . $url->baseUrl('login'));

                // ✅ Flush output to client
                ignore_user_abort(true);
                ob_end_clean();
                flush();

                // ✅ Trigger email in background
                $emailEncoded = urlencode($email);
                $fullnameEncoded = urlencode($fullname);
                $otpEncoded = urlencode($user_otp);

                $emailUrl = $url->baseUrl("models/app/send_verification_email.php?email=$emailEncoded&fullname=$fullnameEncoded&otp=$otpEncoded");

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $emailUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200); // Don't block
                curl_exec($ch);
                curl_close($ch);
                exit;
            } else {
                header('Location: ' . $url->baseUrl('register?m=wc'));
                exit;
            }
        } else {
            header('Location: ' . $url->baseUrl('register?m=nc'));
            exit;
        }
    } else {
        header('Location: ' . $url->baseUrl('register?m=ir'));
        exit;
    }
} else {
    header('Location: ' . $url->baseUrl('register?m=ir'));
    exit;
}
