<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit User Details - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl("views/assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

    <script src="<?= $url->baseUrl("views/assets/vendor/tinymce/js/tinymce/tinymce.min.js") ?>"></script>

    <script>
        tinymce.init({
            selector: '#shortdescription, #description',
            menubar: false,
            toolbar: 'undo redo | styleselect | forecolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist',
        });
    </script>

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
                        <h1 class="h3 mb-0 text-gray-800">Edit User Details</h1>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Enter User Details</h6>
                        </div>
                        <div class="card-body">

                            <form action="<?= $url->baseUrl('models/admin/users/edit.php') ?>" method="POST" enctype="multipart/form-data">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key" id="key">

                                <input type="hidden" value="<?= $_GET['q'] ?>" name="id">

                                <div class="form-group">
                                    <label for="">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" value="<?= $fullname ?>" name="fullname">
                                </div>

                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" id="email" value="<?= $email ?>" name="email">
                                </div>

                                <div class="form-group">
                                    <label for="">Phone</label>
                                    <input type="text" class="form-control" id="phone" value="<?= $phone ?>" name="phone">
                                </div>

                                <div class="form-group">
                                    <label for="">Password [<span class="fa fa-eye-slash text-primary" id="pwtoggle" onclick="pwtoggle()">Show/Hide</span>] <span class="text-danger">Leave blank to keep unchanged</span></label>
                                    <input type="password" class="form-control" id="password" value="" placeholder="Leave blank to kepp unchanged" name="password" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="">Billing Address</label>
                                    <textarea name="billingaddress" class="form-control" id="billingaddress"><?= $billingaddress ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Shipping Address</label><br>
                                    <input type="checkbox" id="copyaddress" onchange="copyAddresstoS()"> Copy From Billing Address
                                    <textarea name="shippingaddress" class="form-control" id="shippingaddress"><?= $shippingaddress ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Tax Number</label>
                                    <input type="text" class="form-control" value="<?= $tax ?>" name="tax">
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select type="text" class="form-control" id="status" name="status">
                                        <option value="1" <?php if ($status == 1) {
                                                                echo 'selected';
                                                            } ?>>Active</option>
                                        <option value="0" <?php if ($status == 0) {
                                                                echo 'selected';
                                                            } ?>>Blocked</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include('../../views/admin/includes/footer.inc.php'); ?>

            <script>
                function pwtoggle() {
                    if (document.getElementById('password').getAttribute('type') == 'text') {
                        document.getElementById('password').setAttribute('type', 'password');
                    } else {
                        document.getElementById('password').setAttribute('type', 'text');
                    }
                }
            </script>

            <script>
                function copyAddresstoS() {

                    document.getElementById("shippingaddress").value = document.getElementById("billingaddress").value;
                }
            </script>

</body>

</html>