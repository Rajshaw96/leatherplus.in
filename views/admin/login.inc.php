<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - Admin Panel</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl('views/assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl('views/assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Administrator Panel!</h1>
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
                                        } else if ($_GET['m'] == "wc") {
                                        ?>

                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                Wrong Credentials!
                                            </div>

                                        <?php
                                        } else if ($_GET['m'] == "nc") {
                                        ?>

                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                Unable to Establish Server Connection!
                                            </div>

                                    <?php
                                        } else if ($_GET['m'] == "lo") {
                                            ?>
    
                                                <div class="alert alert-success alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    You've Been Logged Out Successfully!
                                                </div>
    
                                        <?php
                                            }
                                    }

                                    ?>

                                    <form action="<?= $url->baseUrl("models/admin/login"); ?>" class="user" method="POST">

                                        <?php

                                        $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                        ?>

                                        <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= $url->baseUrl('views/assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= $url->baseUrl('views/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= $url->baseUrl('views/assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= $url->baseUrl('views/assets/js/sb-admin-2.min.js') ?>"></script>

</body>

</html>