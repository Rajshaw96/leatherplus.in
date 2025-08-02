<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Delete Record - Admin</title>

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

                    <!-- Basic Card Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Do you want to delete this record permanently?</h6>
                        </div>
                        <div class="card-body">
                            <h5>This process can not be reversed again...</h5>

                            <form action="<?= $url->baseUrl("customlib/delete.php") ?>" method="POST">
                                <input type="hidden" value="<?= $_GET['tablename'] ?>" name="tablename">
                                <input type="hidden" value="<?= $_GET['columnname'] ?>" name="columnname">
                                <input type="hidden" value="<?= $_GET['columnvalue'] ?>" name="columnvalue">
                                <input type="hidden" value="<?= $_GET['backto'] ?>" name="backto">
                                <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> Yes! Delete</button>
                            </form>

                            <hr>

                            <button class="btn btn-success" onclick="goBack()">NO! I Want to Go Back</button>
                            <script>
                                function goBack() {
                                    window.history.back();
                                }
                            </script>

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