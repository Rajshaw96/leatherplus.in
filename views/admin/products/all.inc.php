<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>All Products - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Products > All</h1>
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
                        }
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
                        } else if ($_GET['m'] == "edt1") {
                            ?>

                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        Changes has been saved!
                                    </div>

                            <?php
                        } else if ($_GET['m'] == "edt0") {
                            ?>

                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            Unable to save changes!
                                        </div>

                            <?php
                        } else if ($_GET['m'] == "add1") {
                            ?>

                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                New product has been added!
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

                    <div class="pb-3">
                        <a href="add" class="btn btn-primary"><span class="fa fa-plus"></span> Add New</a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of All Products</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Thumbnail</th>
                                            <th>Title</th>
                                            <th>Categories</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            $resultproducts = $database->getData("SELECT * FROM `products` ORDER BY `prod_title` ASC");

                                            if ($resultproducts != false) {

                                                while ($products = mysqli_fetch_array($resultproducts)) {
                                                    ?>

                                                    <tr>
                                                        <td><?= $products['prod_id'] ?></td>
                                                        <td>
                                                            <img src="<?= $url->baseUrl("uploads/product-images/" . $products['prod_featuredimage']) ?>"
                                                                alt="" style="max-width:95px">
                                                        </td>
                                                        <td>
                                                            <b><?= $products['prod_title'] ?></b><br>SKU:
                                                            <?= $products['prod_sku'] ?>
                                                        </td>
                                                        <td>
                                                            <?php

                                                            $array = explode(',', $products['prod_cats']);

                                                            foreach ($array as $item) {
                                                                $cat_id = trim($item);
                                                                if ($cat_id !== '' && is_numeric($cat_id)) {
                                                                    $result_pcatnameprint = $database->getData("SELECT `pcat_name` FROM `product_categories` WHERE `pcat_id` = $cat_id");

                                                                    if ($result_pcatnameprint != false) {
                                                                        while ($pcatnameprint = mysqli_fetch_array($result_pcatnameprint)) {
                                                                            echo "<kbd>" . htmlspecialchars($pcatnameprint['pcat_name']) . "</kbd> ";
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php

                                                            if ($products['prod_status'] == 1) {

                                                                echo "Published";
                                                            } else {
                                                                echo "Unpublished";
                                                            }
                                                            ?>
                                                            <br>
                                                            <?php

                                                            if ($products['prod_managestock'] == 1) {

                                                                if ($products['prod_stockqty'] > 0) {
                                                                    echo "In Stock";
                                                                } else {
                                                                    echo "<kbd>Out of Stock</kbd>";
                                                                }
                                                            } else {
                                                                echo "N/A";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $url->baseUrl('admin/products/edit?q=' . $products['prod_id']) ?>"
                                                                class="btn btn-primary"><span class="fa fa-edit"></span></a>
                                                            <?php if ($_SESSION['admin_role'] == "admin") { ?>
                                                                <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=products&columnname=prod_id&columnvalue=' . $products['prod_id'] . '&backto=' . $url->baseUrl("admin/products/all") . '') ?>"
                                                                    class="btn btn-danger"><span class="fa fa-trash"></span></a>
                                                            <?php } ?>
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
                <script
                    src="<?= $url->baseUrl("views/assets/vendor/datatables/dataTables.bootstrap4.min.js") ?>"></script>

                <!-- Page level custom scripts -->
                <script src="<?= $url->baseUrl("views/assets/js/demo/datatables-demo.js") ?>"></script>

                <script>
                    function replaceCats() {
                        <?php

                        if ($connStatus == true) {

                            $resultCategories = $database->getData("SELECT * FROM `product_categories`");

                            if ($resultCategories != false) {

                                while ($categories = mysqli_fetch_array($resultCategories)) {

                                    ?>


                                    document.body.innerHTML = document.body.innerHTML
                                        .replace("<kbd><?= $categories['pcat_id'] ?></kbd>", "<kbd><?= $categories['pcat_name'] ?></kbd>");

                                    document.body.innerHTML = document.body.innerHTML
                                        .replace("<kbd> <?= $categories['pcat_id'] ?></kbd>", " <kbd><?= $categories['pcat_name'] ?></kbd>");

                                    <?php
                                }
                            }
                        }

                        ?>
                    }

                    replaceCats();
                </script>

</body>

</html>