<?php
session_start();
ob_start();

// Required Config Files
require_once('../../lib/config/config.php');

// Required Libraries
require_once('../../lib/security/requests.php');
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/database/databaseops.php');
require_once('../../lib/security/password.php');

// Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

// DB connection
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) === true) {
    if (isset($_POST['email'], $_POST['password'])) {
        if ($connStatus === true) {
            $email = $_POST['email'];
            $passwordInput = $_POST['password'];

            // Fetch user by email
            $result = $database->getData("SELECT * FROM `users` WHERE `user_email`='$email' AND `user_status`=1");

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                // ✅ Verify the password

                if (password_verify($passwordInput, $user['user_password'])) {

                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_fullname'];
                    $_SESSION['user_email'] = $user['user_email'];
                    $_SESSION['user_type'] = $user['user_type'];
                    $_SESSION['user_phone'] = $user['user_phone'];
                    $_SESSION['login_success'] = true;
                    if (isset($_POST['rememberme']) && $_POST['rememberme'] === "on") {
                        setcookie("uinfo", base64_encode($user['user_email']), time() + (86400 * 30), "/");
                    }

                    header('Location: ' . $url->baseUrl('my-account'));
                    exit;
                } else {
                    $_SESSION['login_error'] = "Incorrect password.";
                    header('Location: ' . $url->baseUrl('login?wp'));
                    exit;
                }
            } else {
                $_SESSION['login_error'] = "User not found or inactive.";
                header('Location: ' . $url->baseUrl('login'));
                exit;
            }
        } else {
            header('Location: ' . $url->baseUrl('login?m=nc'));
            exit;
        }
    } else {
        header('Location: ' . $url->baseUrl('login?m=ir'));
        exit;
    }
} else {
    header('Location: ' . $url->baseUrl('login?m=ir'));
    exit;
}
