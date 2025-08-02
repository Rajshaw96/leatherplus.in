<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Notifications [Settings] - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Settings > Notifications</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New record has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected record has been removed successfully!
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
                            <h6 class="m-0 font-weight-bold text-primary">Instructions</h6>
                        </div>

                        <div class="card-body">
                            <h6>{{cust_name}} : Name of Customer</h6>
                            <h6>{{order_number}} : Order Number</h6>
                        </div>
                    </div>

                    <form action="<?= $url->baseUrl("models/admin/settings/update-notifications.php") ?>" method="POST">

                        <?php

                        $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                        ?>

                        <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">


                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">SMS Notification Setting</h6>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Admin Phone Number</label>
                                    <input type="text" name="admin_phone" class="form-control" value="<?= $admin_phone ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Order Placed</label>
                                    <textarea name="sms_orderplaced" class="form-control"><?= $sms_orderplaced ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Email Notification Setting</h6>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Admin Email</label>
                                    <input type="email" name="admin_email" class="form-control" value="<?= $admin_email ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Order Placed</label>
                                    <textarea name="email_orderplaced" class="form-control"><?= $email_orderplaced ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </div>

                    </form>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include('../../views/admin/includes/footer.inc.php'); ?>

</body>

</html>