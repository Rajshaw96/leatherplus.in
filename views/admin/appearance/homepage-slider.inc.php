<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Homepage Slider - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Home Page Slider</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New Slider has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected Slider has been removed successfully!
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
                            <h6 class="m-0 font-weight-bold text-primary">Add New Slide</h6>
                        </div>

                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/appearance-slide-add.php") ?>" method="POST" enctype="multipart/form-data">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                <div class="form-group">
                                    <input type="file" class="form-control" name="slide" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Slides</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Slide</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_sliders = $database->getData("SELECT * FROM `appearance_sliders` WHERE `apslide_type`='homepage'");

                                            if ($result_sliders != false) {

                                                while ($slides = mysqli_fetch_array($result_sliders)) {

                                        ?>

                                                    <tr>
                                                        <td><?= $slides['apslide_id'] ?></td>
                                                        <td>
                                                            <img src="<?= $url->baseUrl("uploads/sliders/".$slides['apslide_path']) ?>" style="max-height:90px;">
                                                        </td>
                                                        <td><a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=appearance_sliders&columnname=apslide_id&columnvalue=' . $slides['apslide_id'] . '&backto=' . $url->baseUrl("admin/appearance/homepage-slider") . '') ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
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