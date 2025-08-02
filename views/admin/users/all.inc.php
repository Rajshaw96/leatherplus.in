<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>All Users - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Users > All</h1>
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
                        } else if ($_GET['m'] == "wfa") {
                        ?>

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Failed to Add New User!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "nc") {
                        ?>

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Unable to Establish Server Connection!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "su") {
                        ?>

                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New User Has Been Added!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "fp") {
                        ?>

                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Something Went Wrong While Uploading User Image!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {
                        ?>

                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                User Has Been Deleted!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "nd") {
                        ?>

                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Unable to Delete Selected User!
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
                        }
                    }

                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of All Users</h6>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if ($connStatus == true) {

                                            $resultusers = $database->getData("SELECT * FROM `users`");

                                            if ($resultusers != false) {

                                                while ($users = mysqli_fetch_array($resultusers)) {
                                        ?>

                                                    <tr <?php if ($users['user_status'] == 0) {
                                                            echo 'class="bg-danger text-light"';
                                                        } ?>>
                                                        <td><?= $users['user_id'] ?></td>
                                                        <td><?= $users['user_fullname'] ?></td>
                                                        <td><?= $users['user_email'] ?></td>
                                                        <td><?= $users['user_phone'] ?></td>
                                                        <td>

                                                            <a href="<?= $url->baseUrl('admin/users/edit?q=' . $users['user_id']) ?>" class="btn btn-primary"><span class="fa fa-edit"></span></a>

                                                            <?php
                                                            if ($_SESSION['admin_role'] == "admin") {
                                                            ?>

                                                            <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=users&columnname=user_id&columnvalue=' . $users['user_id'] . '&backto=' . $url->baseUrl("admin/users/all") . '') ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>

                                                            <?php  } ?>
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

</body>

</html>