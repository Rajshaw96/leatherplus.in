<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Export All Products to CSV - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Products > Export to CSV</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="m-0 font-weight-bold text-primary">List of All Products</h6>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button class="btn btn-primary" id="export"><span class="fa fa-download"></span> Download</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <table id="exportme" border="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Article</th>
                                            <th>MRP</th>
                                            <th>Dealer Price</th>
                                            <th>Distributor Price</th>
                                            <th>Tax</th>
                                            <th>Set As</th>
                                            <th>Active</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            if ($q == 0) {

                                                $resultproducts = $database->getData("SELECT * FROM `products`");
                                            } else {

                                                $resultproducts = $database->getData("SELECT * FROM `products` WHERE `prod_cats` LIKE '" . $_GET['q'] . "' OR `prod_cats` LIKE '%" . $_GET['q'] . ", %' OR `prod_cats` LIKE '%, " . $_GET['q'] . "'");
                                            }

                                            if ($resultproducts != false) {

                                                while ($products = mysqli_fetch_array($resultproducts)) {
                                        ?>

                                                    <tr>
                                                        <td><?= $products['prod_id'] ?></td>
                                                        <td><?php

                                                            $countc = 0;

                                                            $array =  explode(',', $products['prod_cats']);

                                                            foreach ($array as $item) {
                                                                if ($connStatus == true) {

                                                                    $resultcategory = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_id` = " . $item . "");

                                                                    if ($resultcategory != false) {

                                                                        while ($cats = mysqli_fetch_array($resultcategory)) {

                                                                            $countc = $countc + 1;

                                                                            if ($countc > 1) {
                                                                                echo " | ";
                                                                            }

                                                                            echo $cats['pcat_name'];
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>
                                                        <td><?= $products['prod_title'] ?></td>
                                                        <td><?= $products['prod_mrpprice'] ?></td>
                                                        <td><?= $products['prod_regularprice'] ?></td>
                                                        <td><?= $products['prod_saleprice'] ?></td>
                                                        <td><?php

                                                            if ($connStatus == true) {

                                                                $result_taxes = $database->getData("SELECT * FROM `settings_taxes` WHERE `stax_id`=" . $products['prod_tax']);

                                                                if ($result_taxes != false) {

                                                                    while ($tax = mysqli_fetch_array($result_taxes)) {


                                                                        echo $tax['stax_name'];
                                                                    }
                                                                }
                                                            }

                                                            ?></td>
                                                        <td><?php if ($products['prod_setas'] == "N") {
                                                                echo "New Arrival";
                                                            }
                                                            if ($products['prod_setas'] == "B") {
                                                                echo "Best Seller";
                                                            } ?></td>
                                                        <td><?php if ($products['prod_status'] == "1") {
                                                                echo "Active";
                                                            }
                                                            if ($products['prod_status'] == "0") {
                                                                echo "Inactive";
                                                            } ?></td>
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
                        download(csv, 'products.csv');
                    });
                </script>

</body>

</html>