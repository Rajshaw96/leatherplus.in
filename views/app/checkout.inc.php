<?php
// session_start();
include("./lib/config/config.php");
require_once("./lib/helpers/urlhelpers.php");
require_once("./lib/database/databaseops.php");

$url = new UrlHelpers();
$database = new DatabaseOps();
$conn = $database->createConnection();
if (!$conn) {
    die("<p class='text-danger'>Database connection failed.</p>");
}

$name = $_SESSION['user']['fullname'] ?? "";
$email = $_SESSION['user']['email'] ?? "";
$phone = $_SESSION['user']['phone'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Checkout - Leather Plus</title>
    <meta name="description" content="Login to your Leather Plus Account">

    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

    <!--- jQuery -->


</head>

<body>
    <?php include('includes/header-2.inc.php') ?>
    <div class="container py-5 giving-margin">
        <h2 class="mb-4">Checkout</h2>
        <form action="<?= $url->baseUrl("models/app/confirm-order.php") ?>" method="POST">
            <div class="row">
                <!-- Billing Information -->
                <div class="col-md-7">
                    <h4 class="mb-3">Billing Information</h4>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($name) ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Shipping Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter full address"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <select name="country" class="form-control" required>
                            <option value="">Select Country</option>
                            <option value="india" selected>India</option>
                            <option value="usa">United States</option>
                            <option value="uk">United Kingdom</option>
                            <option value="uae">UAE</option>
                            <option value="canada">Canada</option>
                            <!-- Add more countries as needed -->
                        </select>
                    </div>

                </div>

                <!-- Order Summary -->
                <div class="col-md-5">
                    <h4 class="mb-3">Order Summary</h4>
                    <div class="card p-3 mb-3">
                        <?php
                        $total = 0;
                        if (!empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $prodId => $qty) {
                                $res = $database->getData("SELECT * FROM products WHERE prod_id = '$prodId' AND prod_status = 1");
                                if ($res && mysqli_num_rows($res) > 0) {
                                    $p = mysqli_fetch_assoc($res);
                                    $price = $p['prod_saleprice'] > 0 ? $p['prod_saleprice'] : $p['prod_regularprice'];
                                    $subtotal = $price * $qty;
                                    $total += $subtotal;
                                    
                                    echo "<div class='d-flex justify-content-between'>
                          <div>" . htmlspecialchars($p['prod_title']) . " (x$qty)</div>
                          <div>₹$subtotal</div>
                        </div>";
                                }
                            }
                            $_SESSION['cart_totalamt'] = $total;
                        } else {
                            echo "<p>Your cart is empty.</p>";
                        }
                        ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span>₹<?= $total ?></span>
                        </div>

                        <!-- Payment Mode Selection -->
                        <div class="mb-3 mt-3">
                            <label class="form-label">Payment Mode</label>
                            <select name="payment_mode" class="form-control" required>
                                <option value="prepaid">Prepaid (Online Payment)</option>
                                <?php if ($_POST['country'] === 'india' || !isset($_POST['country'])): ?>
                                    <option value="cod">Cash on Delivery (India only)</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Place Order</button>
                </div>
            </div>
        </form>
    </div>
    <?php include('includes/footer.inc.php') ?>
</body>

</html>