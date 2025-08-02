<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailNotifications
{

    public function sendEmail($to_email, $to_name, $subject, $message)
    {

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = $GLOBALS['smtp_server']; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = $GLOBALS['smtp_port']; // TLS only
        $mail->SMTPSecure = $GLOBALS['smtp_secure'];
        $mail->SMTPAuth = true;
        $mail->Username = $GLOBALS['smtp_username'];
        $mail->Password = $GLOBALS['smtp_password'];
        $mail->setFrom($GLOBALS['from_email'], $GLOBALS['from_name']);
        $mail->addAddress($to_email, $to_name);
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->AltBody = 'Email not sent!';
        // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

        if (!$mail->send()) {
            return false;
        } else {

            return true;
        }
    }
}
