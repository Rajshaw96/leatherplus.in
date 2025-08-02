<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Change Password - Admin</title>

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
        <?php include('../views/admin/includes/sidebar.inc.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- topbar -->
                <?php include('../views/admin/includes/topbar.inc.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php

                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "su") {
                    ?>


                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Your <strong>Password</strong> change Successfully!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        <?php
                        } else if ($_GET['m'] == "fa") {
                        ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                You Entered Wrong <strong>Old Passsword</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                    <?php
                        }
                    }

                    ?>

                    <!-- Basic Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/change-password"); ?>" method="POST">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key" id="key">

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Old Password" name="old_password" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="New Password" name="new_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user">
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include('../views/admin/includes/footer.inc.php'); ?>


</body>

</html>