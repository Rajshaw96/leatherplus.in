<?php
session_start();
ob_start();

date_default_timezone_set('Asia/Kolkata');

// Required Config + Libraries
require_once './lib/config/config.php';
require_once './lib/helpers/urlhelpers.php';
require_once './lib/database/databaseops.php';
require_once './services/shipway_api.php';

// Create objects
$url = new UrlHelpers();
$database = new DatabaseOps();

// DB connection
$conn = $database->createConnection();

if (!$conn) {
    error_log("Database connection failed at " . date('Y-m-d H:i:s'));
    die("❌ Database connection failed.");
}

// Shipway API credentials
$apiEmail = 'info@leatherplus.in';
$apiKey   = 'y983VSB2Tn34tW3xv0u4687rVk1keKq8';

// Params
$date_from = date('Y-m-d', strtotime('-7 days'));
$date_to   = date('Y-m-d');
$page      = 1;
$maxPages  = 100;
$ordersProcessed = 0;

// Prepare data for API
$data = [
    'date_from' => $date_from,
    'date_to'   => $date_to,
    'page'      => $page
];

do {
    $data['page'] = $page;

    // Fetch orders from Shipway API
    $apiResponse = shipwayApiPost(
        "https://app.shipway.com/api/getorders",
        $data,
        $apiEmail,
        $apiKey
    );

    if (!$apiResponse || !isset($apiResponse['message']) || !is_array($apiResponse['message'])) {
        error_log("Invalid API response on page $page: " . var_export($apiResponse, true));
        break;
    }

    // Prepare insert/update for shipway_data table
    $stmt = $conn->prepare("
        INSERT INTO shipway_data (
            order_id, status, shipment_status, tracking_number, carrier_title,
            last_updated, order_date, order_total, shipping_cost, discount,
            payment_method, customer_name, customer_email, customer_phone,
            billing_address, shipping_address, raw_response
        ) VALUES (
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?
        )
        ON DUPLICATE KEY UPDATE
            status = VALUES(status),
            shipment_status = VALUES(shipment_status),
            tracking_number = VALUES(tracking_number),
            carrier_title = VALUES(carrier_title),
            last_updated = VALUES(last_updated),
            order_date = VALUES(order_date),
            order_total = VALUES(order_total),
            shipping_cost = VALUES(shipping_cost),
            discount = VALUES(discount),
            payment_method = VALUES(payment_method),
            customer_name = VALUES(customer_name),
            customer_email = VALUES(customer_email),
            customer_phone = VALUES(customer_phone),
            billing_address = VALUES(billing_address),
            shipping_address = VALUES(shipping_address),
            raw_response = VALUES(raw_response),
            updated_at = CURRENT_TIMESTAMP
    ");

    foreach ($apiResponse['message'] as $order) {
        $orderId        = $order['order_id'] ?? null;
        if (!$orderId) continue;

        $status         = $order['status'] ?? '';
        $shipmentStatus = $order['shipment_status'] ?? '';
        $tracking       = $order['tracking_number'] ?? '';
        $carrier        = $order['carrier_title'] ?? '';
        $lastUpdated    = date('Y-m-d H:i:s');
        $orderDate      = $order['order_date'] ?? null;
        $orderTotal     = $order['order_total'] ?? 0;
        $shippingCost   = $order['shipping_cost'] ?? 0;
        $discount       = $order['discount'] ?? 0;
        $paymentMethod  = $order['payment_method'] ?? '';
        $custName       = trim(($order['b_firstname'] ?? '') . ' ' . ($order['b_lastname'] ?? ''));
        $custEmail      = $order['email'] ?? '';
        $custPhone      = $order['b_phone'] ?? '';
        $billingAddr    = ($order['b_address'] ?? '') . ' ' . ($order['b_address_2'] ?? '') . ', ' . ($order['b_city'] ?? '') . ', ' . ($order['b_state'] ?? '') . ', ' . ($order['b_country'] ?? '') . ' - ' . ($order['b_zipcode'] ?? '');
        $shippingAddr   = ($order['s_address'] ?? '') . ' ' . ($order['s_address_2'] ?? '') . ', ' . ($order['s_city'] ?? '') . ', ' . ($order['s_state'] ?? '') . ', ' . ($order['s_country'] ?? '') . ' - ' . ($order['s_zipcode'] ?? '');
        $rawResponse    = json_encode($order, JSON_UNESCAPED_UNICODE);

        $stmt->bind_param(
            "ssssssssddsssssss",
            $orderId, $status, $shipmentStatus, $tracking, $carrier,
            $lastUpdated, $orderDate, $orderTotal, $shippingCost, $discount,
            $paymentMethod, $custName, $custEmail, $custPhone,
            $billingAddr, $shippingAddr, $rawResponse
        );

        if ($stmt->execute()) {
            $ordersProcessed++;
        } else {
            error_log("Insert failed for order_id $orderId: " . $stmt->error);
        }
    }

    $stmt->close();
    $page++;
} while ($page <= $maxPages && !empty($apiResponse['message']));

ob_end_flush();

echo "✅ Shipway sync complete: $ordersProcessed records processed at " . date('Y-m-d H:i:s') . "\n";
?>
