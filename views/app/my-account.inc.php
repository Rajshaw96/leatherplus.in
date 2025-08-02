<!DOCTYPE html>
<html lang="en">
<?php
// Add your other required files here

$loginSuccess = false;
if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true) {
    $loginSuccess = true;
    unset($_SESSION['login_success']); // Avoid showing it again on refresh
}

// Create URL helper object
$url = new UrlHelpers(); // This was used later in the HTML
?>

<head>
    <meta charset="utf-8">
    <title>My Account - Leather Plus</title>
    <meta name="description" content="Shop Premium Leather Products">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .account-sidebar {
            background-color: #fff;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .account-sidebar a {
            display: block;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .account-sidebar a i {
            margin-right: 8px;
        }

        .welcome-box {
            margin-bottom: 2rem;
        }

        .breadcrumb-container {
            background: #fff;
            padding: 1rem 0;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/header-2.inc.php') ?>

        <section id="contentss" role="main" class="py-4 px-lg-0 px-2">
            <!-- <div class="breadcrumb-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb mb-0">
                                <li><a href="<?= $url->baseUrl("") ?>" title="Home">Home</a></li>
                                <li class="active">My Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="container py-4">
                <div class="row">
                    <div class="col-12 welcome-box">
                        <h3 class="text-dark">Hi, <?= $_SESSION['user_name'] ?>!</h3>
                        <p class="text-muted">Manage your account, orders, and settings below.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="account-sidebar">
                            <a href="my-orders" class="btn btn-outline-dark w-100"><i class="fas fa-box"></i> My
                                Orders</a>
                            <a href="cart" class="btn btn-outline-dark w-100"><i class="fas fa-shopping-cart"></i>
                                Cart</a>
                            <a href="checkout" class="btn btn-outline-dark w-100"><i class="fas fa-credit-card"></i>
                                Checkout</a>
                            <!-- <a href="change-password" class="btn btn-outline-dark w-100"><i class="fas fa-key"></i> Change Password</a> -->
                            <a href="logout" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <!-- You can insert default content or a dashboard overview here -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Welcome to your dashboard</h5>
                                <p class="card-text text-muted">Leather Plus is a premier manufacturer of high-quality
                                    leather belts and suspenders, renowned for its craftsmanship and dedication to
                                    excellence.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="my-5"></div> -->
        </section>

        <?php include('includes/footer.inc.php') ?>
    </div>
</body>

</html>