<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account - Leather Plus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .account-sidebar {
            background: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar a {
            margin-bottom: 0.8rem;
            display: block;
        }

        .account-welcome {
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .order-table th {
            background-color: #343a40;
            color: #fff;
        }

        .order-table td,
        .order-table th {
            vertical-align: middle;
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
    </style>
</head>

<body>
    <?php include('includes/header-2.inc.php') ?>

    <div class="container giving-margin">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="account-sidebar">
                    <h5 class="account-welcome">Hi, <?= $_SESSION['user_name'] ?></h5>
                    <a href="my-orders" class="btn btn-outline-dark w-100"><i class="fas fa-box"></i> My Orders</a>
                    <a href="cart" class="btn btn-outline-dark w-100"><i class="fas fa-shopping-cart"></i> Cart</a>
                    <a href="checkout" class="btn btn-outline-dark w-100"><i class="fas fa-credit-card"></i>
                        Checkout</a>
                    <!-- <a href="change-password" class="btn btn-outline-dark w-100"><i class="fas fa-key"></i> Change Password</a> -->
                    <a href="logout" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">My Orders</h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped order-table mb-0">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Order Number</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($connStatus != false) {
                                    $result_myorders = $database->getData("SELECT * FROM `orders` WHERE `order_userid` = '" . $_SESSION['user_id'] . "' ORDER BY `order_id` DESC");
                                    if ($result_myorders != false) {
                                        while ($myorders = mysqli_fetch_array($result_myorders)) {
                                            $statusClass = "status-pending";
                                            if (strtolower($myorders['order_status']) == "completed")
                                                $statusClass = "status-completed";
                                            elseif (strtolower($myorders['order_status']) == "failed")
                                                $statusClass = "status-failed";
                                            ?>
                                            <tr>
                                                <td><?= date_format(date_create($myorders['order_date']), "d-m-Y") ?></td>
                                                <td><a
                                                        href="order-details?q=<?= $myorders['order_num'] ?>"><?= $myorders['order_num'] ?></a>
                                                </td>
                                                <td>₹ <?= $myorders['order_total'] ?></td>
                                                <td><span
                                                        class="order-status <?= $statusClass ?>"><?= ucfirst($myorders['order_status']) ?></span>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $myorders['order_paystatus'] == 1 ? '<span class="text-success fw-bold">Paid</span>' 
                                                        : ($myorders['order_paystatus'] == 2 ? '<span style="color:#59300e" class="fw-bold">COD</span>' 
                                                        : '<span class="text-danger fw-bold">Failed</span>');
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center text-muted'>No orders found.</td></tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.inc.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>