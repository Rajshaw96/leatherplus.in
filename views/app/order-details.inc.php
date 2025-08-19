<?php

$order_num = isset($_GET['q']) ? $_GET['q'] : '';
$order_details = [];
$order_date = '';
$order_status = '';
$order_total = 0;
$order_paystatus = 0;

$order_query = "SELECT * FROM orders WHERE order_num = '$order_num' AND order_userid = '" . $_SESSION['user_id'] . "'";
$res = $database->getData($order_query);
if ($res && mysqli_num_rows($res) > 0) {
    $order = mysqli_fetch_assoc($res);
    $order_date = $order['order_date'];
    $order_status = $order['order_status'];
    $order_total = $order['order_total'];
    $order_paystatus = $order['order_paystatus'];
}

if (!empty($order['order_details'])) {
    $decoded = json_decode($order['order_details'], true);

    if (is_array($decoded)) {
        foreach ($decoded as $item) {
            // Format: {"product_id":238,"name":"RB35-3315","size":"34","qty":1}
            $order_details[] = [
                'prod_id' => $item['product_id'],
                'name' => $item['name'],
                'size' => $item['size'],
                'quantity' => $item['qty']
            ];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Details - Leather Plus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .order-status {
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }

        .giving-margin {
            margin-top: 155px !important;
            margin-bottom: 30px;
        }

        .card img {
            width: 15%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include('includes/header-2.inc.php') ?>

    <div class="container giving-margin">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Order Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Order Date:</strong> <?= date('d-m-Y', strtotime($order_date)) ?></p>
                        <p><strong>Order Number:</strong> <?= htmlspecialchars($order_num) ?></p>
                        <p><strong>Status:</strong>
                            <span
                                class="order-status <?= strtolower($order_status) == 'completed' ? 'status-completed' : (strtolower($order_status) == 'failed' ? 'status-failed' : 'status-pending') ?>">
                                <?= ucfirst($order_status) ?>
                            </span>
                        </p>
                        <p><strong>Payment:</strong>
                            <?= $order_paystatus == 1 ? '<span style="color: #59300e; font-weight: bold;">Paid</span>'
                                : ($order_paystatus == 2 ? '<span style="color: #59300e; font-weight: bold;">COD</span>'
                                    : '<span style="color: #59300e; font-weight: bold;">Failed</span>') ?>
                        </p>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Code</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_details as $item):
                                        $prod_id = $item['prod_id'];
                                        $qty = $item['quantity'];
                                        $size = $item['size'];

                                        $res = $database->getData("SELECT * FROM products WHERE prod_id = $prod_id");
                                        if ($res && mysqli_num_rows($res) > 0):
                                            $product = mysqli_fetch_assoc($res);
                                            $price = $product['prod_saleprice'] ? $product['prod_saleprice'] : $product['prod_regularprice'];  // use price from DB
                                            $subtotal = $qty * $price;
                                            ?>
                                            <tr>
                                                <td style="width: 300px;">
                                                    <div class="d-flex">
                                                        <img src="<?= $url->baseUrl('uploads/product-images/' . $product['prod_featuredimage']) ?>"
                                                            alt="product-images" class="me-2">
                                                        <div>
                                                            <?= htmlspecialchars($product['prod_nick']?$product['prod_nick']:$product['prod_title']) ?><br>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($product['prod_sku']) ?></td>
                                                <td><?= htmlspecialchars($size) ?></td>
                                                <td>₹ <?= number_format($price, 2) ?></td>
                                                <td><?= $qty ?></td>
                                                <td>₹ <?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                        <?php endif; endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-4">
                            <h5>Total: ₹ <?= number_format($order_total, 2) ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.inc.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>