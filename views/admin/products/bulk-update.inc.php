<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bulk Update [Products] - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Products > Bulk Update</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="m-0 font-weight-bold text-primary">List of All Products</h6>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="export?q=<?= $q ?>" class="btn btn-primary"><span class="fa fa-download"></span> Export to CSV</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <form action="" method="GET">
                                <div class="form-group">
                                    <label for="">Show Data For</label>
                                    <select class="form-control" name="q" onchange="form.submit()">
                                        <option value="0">All Categories</option>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_parentcats = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=0 ORDER BY `pcat_name` ASC");

                                            if ($result_parentcats != false) {

                                                while ($parentcats_row = mysqli_fetch_array($result_parentcats)) {

                                        ?>

                                                    <option value="<?= $parentcats_row['pcat_id'] ?>" <?php if ($q == $parentcats_row['pcat_id']) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?= $parentcats_row['pcat_name'] ?></option>
                                                    <?php

                                                    $result_sub = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=" . $parentcats_row['pcat_id']);

                                                    if ($result_sub != false) {

                                                        while ($subcategory_row = mysqli_fetch_array($result_sub)) {

                                                    ?>

                                                            <option value="<?= $subcategory_row['pcat_id'] ?>" <?php if ($q == $subcategory_row['pcat_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>>&nbsp; &nbsp; <?= $subcategory_row['pcat_name'] ?></option>

                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Article</th>
                                            <th>Regular Price</th>
                                            <th>Sale Price</th>
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
                                                        <td>
                                                            <?php

                                                            $array =  explode(',', $products['prod_cats']);

                                                            foreach ($array as $item) {
                                                                if ($connStatus == true) {

                                                                    $resultcategory = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_id` = " . $item . "");

                                                                    if ($resultcategory != false) {

                                                                        while ($cats = mysqli_fetch_array($resultcategory)) {
                                                                            echo "<kbd>" . $cats['pcat_name'] . "</kbd> ";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <!--
                                                            <img src="<?= $url->baseUrl("uploads/product-images/" . $products['prod_featuredimage']) ?>" alt="" style="max-height:65px"> -->

                                                            <a data-toggle="tooltip" title="<img src='<?= $url->baseUrl("uploads/product-images/" . $products['prod_featuredimage']) ?>' width='150px' />">
                                                                <?= $products['prod_title'] ?>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="reg<?= $products['prod_id'] ?>" value="<?= $products['prod_regularprice'] ?>">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control" id="sale<?= $products['prod_id'] ?>" value="<?= $products['prod_saleprice'] ?>">
                                                            <span style="font-size:1px; color:#fff;"><?= $products['prod_saleprice'] ?></span>
                                                        </td>
                                                        <td style="min-width:70px;">
                                                            <select class="form-control" id="tax<?= $products['prod_id'] ?>">
                                                                <?php

                                                                if ($connStatus == true) {

                                                                    $result_taxes = $database->getData("SELECT * FROM `settings_taxes`");

                                                                    if ($result_taxes != false) {

                                                                        while ($tax = mysqli_fetch_array($result_taxes)) {

                                                                ?>

                                                                            <option value="<?= $tax['stax_id'] ?>" <?php if ($tax['stax_id'] == $products['prod_tax']) {
                                                                                                                        echo "selected";
                                                                                                                    } ?>><?= $tax['stax_name'] ?></option>
                                                                <?php
                                                                        }
                                                                    }
                                                                }

                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td style="min-width:90px;">
                                                            <select class="form-control" id="setas<?= $products['prod_id'] ?>">
                                                                <option value="N" <?php if ($products['prod_setas'] == "N") {
                                                                                        echo "selected";
                                                                                    } ?>>New Arrival</option>
                                                                <option value="B" <?php if ($products['prod_setas'] == "B") {
                                                                                        echo "selected";
                                                                                    } ?>>Best Seller</option>

                                                                <option value="R" <?php if ($products['prod_setas'] == "R") {
                                                                                        echo "selected";
                                                                                    } ?>>Latest Product</option>

                                                                <option value="L" <?php if ($products['prod_setas'] == "L") {
                                                                                        echo "selected";
                                                                                    } ?>>Look Book</option>

                                                                <option value="F" <?php if ($products['prod_setas'] == "F") {
                                                                                        echo "selected";
                                                                                    } ?>>Top Rated</option>
                                                            </select>

                                                            <span style="font-size:1px; color:#fff;"><?= $products['prod_setas'] ?></span>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" id="status<?= $products['prod_id'] ?>">
                                                                <option value="1" <?php if ($products['prod_status'] == "1") {
                                                                                        echo "selected";
                                                                                    } ?>>Active</option>
                                                                <option value="0" <?php if ($products['prod_status'] == "0") {
                                                                                        echo "selected";
                                                                                    } ?>>Inactive</option>
                                                            </select>
                                                            <span style="font-size:1px; color:#fff;"><?= $products['prod_status'] ?></span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary" id="upd<?= $products['prod_id'] ?>" onclick="update('mrp<?= $products['prod_id'] ?>', 'reg<?= $products['prod_id'] ?>', 'sale<?= $products['prod_id'] ?>', 'tax<?= $products['prod_id'] ?>', 'setas<?= $products['prod_id'] ?>', 'status<?= $products['prod_id'] ?>', '<?= $products['prod_id'] ?>')"><span class="fa fa-save"></span></button>
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
                    function update(mrp, reg, sale, tax, setas, status, id) {
                        let regprice = document.getElementById(reg).value;
                        let saleprice = document.getElementById(sale).value;
                        let psetas = document.getElementById(setas).value;
                        let pstatus = document.getElementById(status).value;
                        let ptax = document.getElementById(tax).value;

                        var request = $.ajax({
                            type: "POST",
                            url: "<?= $url->baseUrl('models/admin/ajax/product-bulk-update.php') ?>",
                            data: {
                                reg: regprice,
                                sale: saleprice,
                                tax: ptax,
                                setas: psetas,
                                status: pstatus,
                                pid: id
                            },
                            dataType: "html"
                        });

                        request.done(function(msg) {
                            alert(msg);

                            //document.getElementById("defmatattrib").innerHTML = msg;
                        });

                        request.fail(function(jqXHR, textStatus) {
                            alert(textStatus);
                        });
                    }


                    $('a[data-toggle="tooltip"]').tooltip({
                        animated: 'fade',
                        placement: 'bottom',
                        html: true
                    });
                </script>

</body>

</html>