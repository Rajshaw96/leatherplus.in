<?php
session_start();
require_once('../../lib/config/config.php');
require_once('../../lib/database/databaseops.php');

$database = new DatabaseOps();
$connStatus = $database->createConnection();

if (!isset($_SESSION['reset_email'])) {
    die("Unauthorized access.");
}

$email = $_SESSION['reset_email'];
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    // fetch OTP from DB
    $stmt = $database->conn->prepare("SELECT reset_token, reset_expiry FROM users WHERE user_email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($dbOtp, $dbExpiry);
    $stmt->fetch();
    $stmt->close();

    if ($otp == $dbOtp && strtotime($dbExpiry) > time()) {
        // OTP valid → allow password reset
        $_SESSION['otp_verified'] = true;
        header("Location: ../../views/app/reset-password.php");
        exit;
    } else {
        $errorMsg = "Invalid or expired OTP.";
    }
}
?>

<style>
    body {
        background: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .otp-container {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(92,59,29,0.08);
        padding: 32px 24px;
        text-align: center;
    }
    .otp-container h2 {
        color: #5c3b1d;
        margin-bottom: 24px;
        font-size: 2rem;
        font-weight: 700;
    }
    .otp-container label {
        display: block;
        color: #5c3b1d;
        font-weight: 600;
        margin-bottom: 8px;
        text-align: left;
    }
    .otp-container input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #5c3b1d;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 1rem;
        background: #fff;
        color: #5c3b1d;
        letter-spacing: 4px;
        text-align: center;
    }
    .otp-container button {
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
    .otp-container button:hover {
        background: #3e2712;
    }
    .error-box {
        background: #ffe0e0;
        color: #a10000;
        border: 1px solid #f5c2c2;
        padding: 12px;
        margin-bottom: 16px;
        border-radius: 4px;
        font-weight: 600;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="otp-container">
    <h2>Verify OTP</h2>
    
    <?php if (!empty($errorMsg)) : ?>
        <div class="error-box"><?= $errorMsg ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" id="otp" required>
        <button type="submit">Verify OTP</button>
    </form>
</div>
