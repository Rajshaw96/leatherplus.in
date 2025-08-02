<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Product Attributes Terms - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Configure Product Attribute Terms For "<?= $attribute_name ?>"</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New Term has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected Term has been removed successfully!
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

                    <div>
                        <a href="<?= $url->baseUrl("admin/products/attributes") ?>" class="btn btn-primary"><span class="fa fa-arrow-left"></span> Back To List of Attributes</a>
                        <br><br>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New Product Attribute Term For "<?= $attribute_name ?>"</h6>
                        </div>

                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/product-attribute-term-add.php") ?>" method="POST">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                <input type="hidden" value="<?= $_GET['q'] ?>" name="attribute_id">

                                <div class="form-group">
                                    <label for="">Term Name</label>
                                    <input type="text" id="term_name" class="form-control" name="term_name" required>
                                </div>
                                <?php

                                if ($attribute_type == "C") {

                                ?>

                                    <div class="form-group">
                                        <label for="">Preview</label>
                                        <input type="color" name="term_preview">
                                    </div>

                                <?php
                                } else {

                                ?>

                                    <input type="hidden" value="" name="term_preview">
                                <?php
                                }
                                ?>


                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Terms For Attribute "<?= $attribute_name ?>"</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Preview</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_terms = $database->getData("SELECT * FROM `product_attributes_terms` WHERE `pattribterm_attribid`=" . $_GET['q']);

                                            if ($result_terms != false) {

                                                while ($terms_row = mysqli_fetch_array($result_terms)) {

                                        ?>

                                                    <tr>
                                                        <td><?= $terms_row['pattribterm_name'] ?></td>
                                                        <td>
                                                            <?php
                                                            if (strlen($terms_row['pattribterm_preview']) > 1) {

                                                            ?>
                                                                <span style="background-color: <?= $terms_row['pattribterm_preview'] ?>;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= $url->baseUrl("admin/products/attribute-term-edit?q=" . $terms_row['pattribterm_id']) ?>" class="btn btn-primary"><span class="fa fa-edit"></span></a>

                                                            <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=product_attributes_terms&columnname=pattribterm_id&columnvalue=' . $terms_row['pattribterm_id'] . '&backto=' . $url->baseUrl("admin/products/attributes")) ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
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

</body>

</html>