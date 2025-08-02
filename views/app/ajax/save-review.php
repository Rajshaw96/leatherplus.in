<?php
session_start();
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

$database = new DatabaseOps();
$database->createConnection();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not logged in']);
  exit;
}

$productId = intval($_POST['product_id'] ?? 0);
$rating = intval($_POST['rating'] ?? 0);
$content = trim($_POST['content'] ?? '');
$userName = $_SESSION['user_name'] ?? 'Guest';

if ($productId > 0 && $rating >= 1 && $rating <= 5 && !empty($content)) {
  $contentEncoded = base64_encode($content);
  $now = date('Y-m-d H:i:s');

  $sql = "INSERT INTO product_reviews (preview_title, preview_nickname, preview_rating, preview_content, preview_prodid, preview_datetime, preview_status)
          VALUES ('Review', ?, ?, ?, ?, ?, 1)";

  $stmt = $database->conn->prepare($sql);
  $stmt->bind_param("sissi", $userName, $rating, $contentEncoded, $productId, $now);
  $result = $stmt->execute();

  echo json_encode(['success' => $result]);
} else {
  echo json_encode(['success' => false, 'message' => 'Invalid input']);
}
