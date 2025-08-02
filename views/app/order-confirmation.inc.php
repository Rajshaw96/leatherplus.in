<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>Order Confirmation - Leather Plus</title>
    <meta name="description" content="Leather Plus Cart">

    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/css/style.css") ?>">
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/css/responsive.css") ?>">

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/icon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/apple-icon-57x57.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/apple-icon-72x72.png") ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

    <!--- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="<?= $url->baseUrl("views/app/assets/js/jquery-2.1.1.min.js") ?>"><\/script>')
    </script>

</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section id="content" role="main">
            <div class="breadcrumb-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb">
                                <li><a href="index" title="Home">Home</a></li>
                                <li class="active">Order Confirmed</li>
                            </ul>
                        </div><!-- End .col-md-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .breadcrumb-container -->


            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Your order has been received!</h3>

                        <b>Order Number: </b><?= $_GET['q'] ?> <br>
                        <b>Full Name : </b><?= $fullname ?> <br>
                        <b>Phone: </b><?= $phone ?> <br>
                        <b>Order Date: </b><?= $order_date ?> <br>
                        <b>Status: </b><?= $order_status ?> <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th class="table-title">Product Name</th>
                                    <th class="table-title">Product Code</th>
                                    <th class="table-title">Unit Price</th>
                                    <th class="table-title">Quantity</th>
                                    <th class="table-title">SubTotal</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $itemnumber = -1;

                                $_SESSION['cart_totalamt'] = 0;

                                $totalqty = 0;

                                $enabletaxes = 0; // remove later

                                foreach (json_decode($details) as $item) {

                                    $itemnumber = $itemnumber + 1;

                                    $resultcartitems = $database->getData("SELECT * FROM `products` WHERE `prod_id`=" . $item[0] . "");

                                    if ($resultcartitems != false) {

                                        while ($cartitems = mysqli_fetch_array($resultcartitems)) {

                                ?>

                                            <tr>
                                                <td class="product-name-col">
                                                    <figure>
                                                        <a href="#"><img src="<?= $url->baseUrl('uploads/product-images/' . $cartitems['prod_featuredimage']) ?>" alt="" style="max-height:90px"></a>
                                                    </figure>
                                                    <h2 class="product-name"><a href="#"><?= $cartitems['prod_title'] ?></a></h2>
                                                    <ul>
                                                        <li><?= $item[4] ?></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <?= $cartitems['prod_sku'] ?>
                                                </td>
                                                <td>₹ <?= $item[2] ?></td>
                                                <td><?= $item[1] ?></td>

                                                <?php
                                                if ($enabletaxes == 1) {
                                                ?>

                                                    <td><?= $item[3] ?>%</td>

                                                    <td>₹ <?= $item[2] * ($item[3] / 100) ?></td>

                                                    <td>₹ <?= ($item[2] * ($item[3] / 100)) + $item[2] ?></td>

                                                    <td>
                                                        <?php
                                                        $totalamtoi = $item[1] * $item[2];
                                                        $per1 = ($totalamtoi * $item[3]) / 100;
                                                        echo "$ " . $amt = $totalamtoi + $per1;
                                                        ?>
                                                    </td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td>₹ <?= $amt = $item[1] * $item[2] ?></td>

                                                <?php
                                                }
                                                ?>
                                            </tr>



                                <?php

                                            $_SESSION['cart_totalamt'] = $_SESSION['cart_totalamt'] + $amt;

                                            $totalqty = $totalqty + $item[1];
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <div class="md-margin"></div><!-- space -->

                        <div class="row">
                            <div class="col-md-8">

                            </div><!-- End .col-md-8 -->

                            <div class="md-margin visible-sm visible-xs clearfix"></div><!-- clear sm-xs -->


                            <div class="col-md-4">

                                <table class="table total-table">
                                    <tbody>
                                        <!--
                                        <tr>
                                            <td class="total-table-title">Subtotal:</td>
                                            <td>$434.50</td>
                                        </tr>
                                        <tr>
                                            <td class="total-table-title">Shipping:</td>
                                            <td>$6.00</td>
                                        </tr>
                                        <tr>
                                            <td class="total-table-title">TAX (0%):</td>
                                            <td>$0.00</td>
                                        </tr>
                            -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total:</td>
                                            <td>₹ <?= $total ?></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="md-margin"></div><!-- space -->

                            </div><!-- End .col-md-4 -->
                        </div><!-- End .row -->
                    </div><!-- End .col-md-12 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="lg-margin2x"></div><!-- space -->

        </section><!-- End #content -->

        <?php include('includes/footer.inc.php') ?>

    </div><!-- End #wrapper -->

    <!-- scroltop -->
    <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

    <!-- END -->

    <script src="<?= $url->baseUrl("views/app/assets/js/bootstrap.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/smoothscroll.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/waypoints.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/waypoints-sticky.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.debouncedresize.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/retina.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.placeholder.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.hoverIntent.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/owl.carousel.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.selectbox.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.nouislider.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jflickrfeed.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/twitter/jquery.tweet.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/jquery.bxslider.min.js") ?>"></script>
    <script src="<?= $url->baseUrl("views/app/assets/js/main.js") ?>"></script>

</body>

</html>