<?php

$cname = "";
$odrstatus = "";

$odrdate = "";

if (isset($_GET['cname'])) {
    $cname = $_GET['cname'];
}

if (isset($_GET['odr'])) {
    $odrstatus = $_GET['odr'];
}

if (isset($_GET['dt'])) {
    $odrdate = $_GET['dt'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>All Orders - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Orders > All</h1>
                    </div>

                    <?php

                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "ir") {

                    ?>

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Invalid Request!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {
                        ?>

                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected product has been deleted successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "nc") {
                        ?>

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Unable to Establish Server Connection!
                            </div>

                    <?php
                        }
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="m-0 font-weight-bold text-primary">List of All Orders</h6>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="export?cname=<?= $cname ?>&odr=<?= $odrstatus ?>&dt=<?= $odrdate ?>" class="btn btn-primary"><span class="fa fa-download"></span> Export to CSV</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <form id="myForm" action="" method="GET">
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label for="">Order Date</label>
                                        <input type="date" class="form-control" value="<?= $odrdate ?>" onchange="submitFrom()" name="dt">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="">Customer Name</label>
                                        <input type="text" class="form-control" value="<?= $cname ?>" onchange="submitFrom()" name="cname">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="">Order Status</label>
                                        <select class="form-control" onchange="submitFrom()" name="odr">
                                            <option value="" <?php if ($odrstatus == "") {
                                                                    echo "selected";
                                                                } ?>>All</option>
                                            <option value="Pending" <?php if ($odrstatus == "Pending") {
                                                                        echo "selected";
                                                                    } ?>>Pending</option>
                                            <option value="Completed" <?php if ($odrstatus == "Completed") {
                                                                            echo "selected";
                                                                        } ?>>Completed</option>
                                            <option value="On-Hold" <?php if ($odrstatus == "On-Hold") {
                                                                        echo "selected";
                                                                    } ?>>On-Hold</option>
                                            <option value="Canceled" <?php if ($odrstatus == "Canceled") {
                                                                            echo "selected";
                                                                        } ?>>Canceled</option>
                                            <option value="Rejected" <?php if ($odrstatus == "Rejected") {
                                                                            echo "selected";
                                                                        } ?>>Rejected</option>
                                            <option value="Refuded" <?php if ($odrstatus == "Refuded") {
                                                                        echo "selected";
                                                                    } ?>>Refuded</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Number</th>
                                            <th>Order Date</th>
                                            <th>Customer Details</th>
                                            <th>Order Total</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            $resultorders = $database->getData("SELECT * FROM `orders` JOIN `users` ON orders.order_userid = users.user_id WHERE `user_fullname` LIKE '%" . $cname . "%' AND `order_status` LIKE '%" . $odrstatus . "%' AND `order_date` LIKE '%" . $odrdate . "%'");

                                            if ($resultorders != false) {

                                                while ($orders = mysqli_fetch_array($resultorders)) {
                                        ?>

                                                    <tr>
                                                        <td><?= $orders['order_id'] ?></td>
                                                        <td>
                                                            <?= $orders['order_num'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $orders['order_date'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $orders['user_fullname'] ?>
                                                        </td>
                                                        <td>₹ <?= $orders['order_total'] ?></td>
                                                        <td>
                                                            <?= $orders['order_status'] ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $url->baseUrl('admin/orders/view?q=' . $orders['order_id']) ?>" class="btn btn-primary"><span class="fa fa-eye"></span></a>
                                                        </td>
                                                    </tr>

                                        <?php
                                                }
                                            }
                                        }

                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
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
                    function submitFrom() {

                        document.getElementById("myForm").submit();
                    }
                </script>

</body>

</html>