<?php
session_start();
require_once('../../lib/config/config.php');
require_once('../../lib/database/databaseops.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../plugins/phpmailer/src/Exception.php';
require '../../plugins/phpmailer/src/PHPMailer.php';
require '../../plugins/phpmailer/src/SMTP.php';

$database = new DatabaseOps();
$connStatus = $database->createConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // check if user exists
    $stmt = $database->conn->prepare("SELECT user_id FROM users WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // generate OTP
        $otp = rand(100000, 999999);

        // save OTP in DB with expiry
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));
        $stmt2 = $database->conn->prepare("UPDATE users SET reset_token=?, reset_expiry=? WHERE user_email=?");
        $stmt2->bind_param("sss", $otp, $expiry, $email);
        $stmt2->execute();

        // send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'imsgr10@gmail.com'; // 🔹 your Gmail
            $mail->Password = 'mlteqrvptobxeoyo';   // 🔹 app password from Google
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('imsgr10@gmail.com', 'Leather Plus');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Leather Plus - Password Reset OTP';
            $mail->Body = "Your OTP is: <b>$otp</b><br>This will expire in 10 minutes.";

            $mail->send();

            // 🔹 Store email in session for next step
            $_SESSION['reset_email'] = $email;

            // 🔹 Redirect to OTP verify page
            header("Location: verify-otp.php");
            exit;

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with this email.";
    }
}
?>

<!-- Forgot password form -->
<style>
    body {
        background: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .forgot-container {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(92, 59, 29, 0.08);
        padding: 32px 24px;
        text-align: center;
    }

    .forgot-container h2 {
        color: #5c3b1d;
        margin-bottom: 24px;
        font-size: 2rem;
        font-weight: 700;
    }

    .forgot-container label {
        display: block;
        color: #5c3b1d;
        font-weight: 600;
        margin-bottom: 8px;
        text-align: left;
    }

    .forgot-container input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #5c3b1d;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 1rem;
        background: #fff;
        color: #5c3b1d;
    }

    .forgot-container button {
        background: #5c3b1d;
        color: #fff;
        border: none;
        padding: 12px 0;
        width: 100%;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .forgot-container button:hover {
        background: #3e2712;
    }
</style>

<div class="forgot-container">
    <h2>Forgot Password</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send Reset OTP</button>
    </form>
</div>