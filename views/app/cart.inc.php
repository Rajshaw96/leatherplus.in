<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cart - Leather Plus</title>
    <meta name="description" content="Leather Plus Cart">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php'); ?>

        <section id="contentss" role="main" class="cart-section">
            <div class="breadcrumb-container">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="<?= $url->baseUrl("") ?>" title="Home">Home</a></li><span
                            class="separator">›</span>
                        <li class="active">Shopping Cart</li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-end mb-3">
                        <a href="<?= $url->baseUrl("models/app/empty-cart.php") ?>" class="btn btn-danger">Empty
                            Cart</a>
                    </div>
                </div>

                <?php
                $cqty = 0;
                $camt = 0;
                $hasItems = !empty($_SESSION['cart']) && is_array($_SESSION['cart']);
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if ($hasItems) {
                                    foreach ($_SESSION['cart'] as $index => $item) {
                                        $prodId = intval($item['product_id']);
                                        $qty = intval($item['qty']);
                                        $size = htmlspecialchars($item['size']);

                                        if ($qty < 1)
                                            continue;

                                        $res = $database->getData("SELECT * FROM products WHERE prod_id = '$prodId' AND prod_status = 1");
                                        if ($res && mysqli_num_rows($res) > 0) {
                                            $p = mysqli_fetch_assoc($res);
                                            $price = $p['prod_saleprice'] > 0 ? $p['prod_saleprice'] : $p['prod_regularprice'];
                                            $img = $url->baseUrl("uploads/product-images/" . $p['prod_featuredimage']);
                                            $subtotal = $price * $qty;
                                            $nickname = $p['prod_nick'] ? $p['prod_nick']: $p['prod_title'];

                                            $cqty += $qty;
                                            $camt += $subtotal;
                                            ?>
                                            <tr>
                                                <td>
                                                    <img src="<?= $img ?>" style="max-height: 80px;" alt="Product">
                                                    <div style='color:#5c4511;font-weight:600;padding:10px 0;'><?= htmlspecialchars($nickname) ?></div>
                                                </td>
                                                <td><?= $size ?></td>
                                                <td>₹<?= number_format($price, 2) ?></td>
                                                <td><?= $qty ?></td>
                                                <td>₹<?= number_format($subtotal, 2) ?></td>
                                                <td>
                                                    <a href="<?= $url->baseUrl('cart-remove-item?q=' . $prodId) ?>"
                                                        class="btn btn-danger btn-sm">Remove</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center text-muted">Your cart is empty.</td></tr>';
                                }
                                ?>


                            </tbody>
                        </table>

                        <div class="row mt-4">
                            <div class="col-md-8 mb-3">
                                <a href="<?= $url->baseUrl("shop") ?>" class="btn btn-outline-dark">Continue
                                    Shopping</a>
                            </div>
                            <div class="col-md-4">
                                <table class="table">
                                    <tr>
                                        <td><strong>Total:</strong></td>
                                        <td><strong>₹<?= number_format($camt, 2) ?></strong></td>
                                    </tr>
                                </table>
                                <?php if ($camt > 0): ?>
                                    <a href="<?= $url->baseUrl("checkout") ?>" class="btn btn-success btn-block">Checkout &
                                        Pay</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include('includes/footer.inc.php'); ?>

    </div>
</body>

</html>