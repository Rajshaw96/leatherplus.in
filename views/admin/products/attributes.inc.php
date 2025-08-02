<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Attributes - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl("views/assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">Product Attributes</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New Attribute has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected Attribute has been removed successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "edt1") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Changes has been saved successfully!
                            </div>

                    <?php
                        }
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New Product Attribute</h6>
                        </div>

                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/product-attribute-add.php") ?>" method="POST">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" id="attribute_name" class="form-control" name="attribute_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select class="form-control" name="attribute_type">
                                        <option value="S" selected>Simple</option>
                                        <option value="B">Badge</option>
                                        <option value="C">Color</option>
                                        <option value="M">Material</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Attributes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_attributes = $database->getData("SELECT * FROM `product_attributes` ORDER BY `pattrib_name` ASC");

                                            if ($result_attributes != false) {

                                                while ($attributes_row = mysqli_fetch_array($result_attributes)) {

                                        ?>

                                                    <tr>
                                                        <td><?= $attributes_row['pattrib_name'] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($attributes_row['pattrib_type'] == "S") {
                                                                echo "Simple";
                                                            } else if ($attributes_row['pattrib_type'] == "B") {
                                                                echo "Badge";
                                                            } else if ($attributes_row['pattrib_type'] == "C") {
                                                                echo "Color";
                                                            } else if ($attributes_row['pattrib_type'] == "M") {
                                                                echo "Material";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><a href="<?= $url->baseUrl("admin/products/attribute-terms?q=" . $attributes_row['pattrib_id']) ?>" class="btn btn-success"><span class="fa fa-th" title="Configure Terms"></span></a>
                                                        
                                                        <a href="<?= $url->baseUrl("admin/products/attribute-edit?q=" . $attributes_row['pattrib_id']) ?>" class="btn btn-primary"><span class="fa fa-edit"></span></a>
                                                        
                                                        <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=product_attributes&columnname=pattrib_id&columnvalue=' . $attributes_row['pattrib_id'] . '&backto=' . $url->baseUrl("admin/products/attributes") . '') ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a></td>
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

</body>

</html>