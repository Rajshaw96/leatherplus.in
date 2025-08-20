<?php
session_start();
require_once('../../lib/config/config.php');
require_once('../../lib/database/databaseops.php');

$database = new DatabaseOps();
$connStatus = $database->createConnection();
$conn = $database->conn;

// Check if user is logged in for reset (via OTP verification)
if (!isset($_SESSION['reset_email'])) {
    die("Unauthorized access.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        echo "Both fields are required.";
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    $email = $_SESSION['reset_email'];

    // Update password in DB
    $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        echo "Password reset successfully. You can now <a href='" . $url->baseUrl("login") . "'>login</a>.";
        unset($_SESSION['reset_email']); // clear session
    } else {
        echo "Error updating password. Please try again.";
    }
}
?>

<!-- Reset password form -->
<style>
    body {
        background: #fff;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .reset-container {
        max-width: 400px;
        margin: 60px auto;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(92, 59, 29, 0.08);
        padding: 32px 24px;
        text-align: center;
    }

    .reset-container h2 {
        color: #5c3b1d;
        margin-bottom: 24px;
        font-size: 2rem;
        font-weight: 700;
    }

    .reset-container label {
        display: block;
        color: #5c3b1d;
        font-weight: 600;
        margin-bottom: 8px;
        text-align: left;
    }

    .reset-container input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #5c3b1d;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 1rem;
        background: #fff;
        color: #5c3b1d;
    }

    .reset-container button {
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

    .reset-container button:hover {
        background: #3e2712;
    }
</style>

<div class="reset-container">
    <h2>Reset Password</h2>
    <form method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Reset Password</button>
    </form>
</div>