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
                                    <button class="btn btn-primary" id="export"><span class="fa fa-download"></span> Download CSV</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="exportme" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Order Number</th>
                                            <th>Order Date</th>
                                            <th>Customer Details</th>
                                            <th>Order Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            $resultorders = $database->getData("SELECT * FROM `abandoned_orders` JOIN `users` ON abandoned_orders.order_userid = users.user_id WHERE `user_fullname` LIKE '%" . $cname . "%' AND `order_status` LIKE '%" . $odrstatus . "%' AND `order_date` LIKE '%" . $odrdate . "%'");

                                            if ($resultorders != false) {

                                                while ($orders = mysqli_fetch_array($resultorders)) {
                                        ?>

                                                    <tr>
                                                        <td><?= $orders['id'] ?></td>
                                                        <td><?= $orders['order_num'] ?></td>
                                                        <td><?= $orders['order_date'] ?></td>
                                                        <td><?= $orders['user_fullname'] ?></td>
                                                        <td><?= $orders['order_total'] ?></td>
                                                        <td><?= $orders['order_status'] ?></td>
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

                <script type="text/javascript">
                    const toCsv = function(table) {
                        // Query all rows
                        const rows = table.querySelectorAll('tr');

                        return [].slice
                            .call(rows)
                            .map(function(row) {
                                // Query all cells
                                const cells = row.querySelectorAll('th,td');
                                return [].slice
                                    .call(cells)
                                    .map(function(cell) {
                                        return cell.textContent;
                                    })
                                    .join(',');
                            })
                            .join('\n');
                    };

                    const download = function(text, fileName) {
                        const link = document.createElement('a');
                        link.setAttribute('href', `data:text/csv;charset=utf-8,${encodeURIComponent(text)}`);
                        link.setAttribute('download', fileName);

                        link.style.display = 'none';
                        document.body.appendChild(link);

                        link.click();

                        document.body.removeChild(link);
                    };

                    const table = document.getElementById('exportme');
                    const exportBtn = document.getElementById('export');

                    exportBtn.addEventListener('click', function() {
                        // Export to csv
                        const csv = toCsv(table);

                        // Download it
                        download(csv, 'abandoned_orders.csv');
                    });
                </script>

</body>

</html>