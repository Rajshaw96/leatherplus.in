<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Order [#<?= $_GET['q'] ?>]- Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl("views/assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="<?= $url->baseUrl("views/assets/vendor/datatables/dataTables.bootstrap4.min.css") ?>" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
        <?php include('../../views/admin/includes/sidebar.inc.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- topbar -->
                <?php include('../../views/admin/includes/topbar.inc.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Orders > #<?= $order_num ?></h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                        </div>
                        <div class="card-body">

                            <h4 class="pb-5">Order Summary</h4>

                            <p><b>Order Number:</b> <?= $order_num ?></p>

                            <p><b>Order Date:</b> <?= $order_date ?></p>

                            <h5><?= $order_fullname ?></h5>
                            <p><b>Ph.</b> <?= $order_phone ?></p>
                            <p><?= $user_billingaddress ?></p>
                            <h6>Ship To</h6>
                            <p class="pb-4">
                                <?= $order_address ?><br>
                                <?= $order_city ?>, <?= $order_state ?>, <?= $order_country ?> - <?= $order_postcode ?>
                            </p>

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

                                    $enabletaxes = 0;

                                    foreach ($order_details as $item) {

                                        $itemnumber = $itemnumber + 1;

                                        $resultcartitems = $database->getData("SELECT * FROM `products` WHERE `prod_id`=" . $item[0] . "");

                                        if ($resultcartitems != false) {

                                            while ($cartitems = mysqli_fetch_array($resultcartitems)) {

                                    ?>

                                                <tr>
                                                    <td class="product-name-col">
                                                        <a href="#"><img src="<?= $url->baseUrl('uploads/product-images/' . $cartitems['prod_featuredimage']) ?>" alt="" style="max-height:90px">
                                                            &nbsp;</a><?= $cartitems['prod_title'] ?> • <?= $item[4] ?>
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


                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>

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
                                                <td class="text-center">₹ <?= $order_total ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <div class="md-margin"></div><!-- space -->
                                    <div class="text-right">
                                    </div>
                                </div><!-- End .col-md-4 -->
                            </div><!-- End .row -->

                            <label for="">Order Status</label>
                            <div class="form-row">
                                <div class="col">
                                    <select class="form-control" id="orderstatus">
                                        <option value="Pending" <?php if ($order_status == "Pending") {
                                                                    echo "selected";
                                                                } ?>>Pending</option>
                                        <option value="Completed" <?php if ($order_status == "Completed") {
                                                                        echo "selected";
                                                                    } ?>>Completed</option>
                                        <option value="On-Hold" <?php if ($order_status == "On-Hold") {
                                                                    echo "selected";
                                                                } ?>>On-Hold</option>
                                        <option value="Canceled" <?php if ($order_status == "Canceled") {
                                                                        echo "selected";
                                                                    } ?>>Canceled</option>
                                        <option value="Rejected" <?php if ($order_status == "Rejected") {
                                                                        echo "selected";
                                                                    } ?>>Rejected</option>
                                        <option value="Refuded" <?php if ($order_status == "Refuded") {
                                                                    echo "selected";
                                                                } ?>>Refuded</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary" onclick="updateStatus()">Update Status</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <a href="print?q=<?= $_GET['q'] ?>" class="btn btn-primary" target="_blank">Print</a>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include('../../views/admin/includes/footer.inc.php'); ?>

            <!-- Page level plugins -->
            <script src="<?= $url->baseUrl("views/assets/vendor/datatables/jquery.dataTables.min.js") ?>"></script>
            <script src="<?= $url->baseUrl("views/assets/vendor/datatables/dataTables.bootstrap4.min.js") ?>"></script>

            <!-- Page level custom scripts -->
            <script src="<?= $url->baseUrl("views/assets/js/demo/datatables-demo.js") ?>"></script>

            <script>
                function updateStatus() {

                    status = document.getElementById('orderstatus').value;

                    var request = $.ajax({
                        type: "POST",
                        url: "<?= $url->baseUrl('models/admin/ajax/update-order-status.php') ?>",
                        data: {
                            id: <?= $_GET['q'] ?>,
                            status: status
                        },
                        dataType: "html"
                    });

                    request.done(function(msg) {
                        alert(msg);
                    });

                    request.fail(function(jqXHR, textStatus) {
                        alert(textStatus);
                    });
                }
            </script>


</body>

</html>