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
                        <h1 class="h3 mb-0 text-gray-800">Reviews > All</h1>
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
                                    <h6 class="m-0 font-weight-bold text-primary">List of All Reviews</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Reviewer</th>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            $result_reviews = $database->getData("SELECT * FROM `product_reviews` LEFT JOIN `products` ON product_reviews.preview_prodid = products.prod_id ORDER BY `preview_id` DESC");

                                            if ($result_reviews != false) {

                                                while ($reviews = mysqli_fetch_array($result_reviews)) {
                                        ?>

                                                    <tr>
                                                        <td><?= $reviews['preview_id'] ?></td>
                                                        <td>
                                                            <?= $reviews['preview_datetime'] ?>
                                                        </td>
                                                        <td class="<?php if ($reviews['preview_status'] == 0) {
                                                                        echo "text-danger";
                                                                    } else {
                                                                        echo "text-success";
                                                                    } ?>">
                                                            <?= $reviews['preview_nickname'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $reviews['preview_title'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $reviews['prod_title'] ?>
                                                            <hr>
                                                            <?= base64_decode($reviews['preview_content']) ?>
                                                        </td>
                                                        <td>
                                                            <?php

                                                            if ($reviews['preview_status'] == 0) {

                                                            ?>
                                                                <button class="btn btn-success" title="Approve" onclick="approve(<?= $reviews['preview_id'] ?>)"><span class="fa fa-check"></span></button>

                                                            <?php
                                                            } else {
                                                            ?>
                                                                <button class="btn btn-warning" title="Disapprove" onclick="disapprove(<?= $reviews['preview_id'] ?>)"><span class="fa fa-times"></span></button>

                                                            <?php
                                                            }

                                                            ?>


                                                            <?php if ($_SESSION['admin_role'] == "admin") { ?>
                                                                <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=product_reviews&columnname=preview_id&columnvalue=' . $reviews['preview_id'] . '&backto=' . $url->baseUrl("admin/reviews/all") . '') ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                                                            <?php  }  ?>
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
                    function approve(review_id) {

                        var request = $.ajax({
                            type: "POST",
                            url: "<?= $url->baseUrl("models/admin/ajax/reviews/approve.php") ?>",
                            data: {
                                id: review_id
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

                    function disapprove(review_id) {

                        var request = $.ajax({
                            type: "POST",
                            url: "<?= $url->baseUrl("models/admin/ajax/reviews/disapprove.php") ?>",
                            data: {
                                id: review_id
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