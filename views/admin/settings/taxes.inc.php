<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Taxes [Settings] - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Settings > Taxes</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New Tax has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected Tax has been removed successfully!
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
                            <h6 class="m-0 font-weight-bold text-primary">Tax Setting</h6>
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Enable Taxes &nbsp;
                                    <input type="checkbox" name="enabletaxes" id="enabletaxes" onchange="enableDisableTaxes()" <?php if($enabletaxes == "1"){ echo "checked"; } ?>>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add New Tax</h6>
                        </div>

                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/settings-tax-add.php") ?>" method="POST">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                <div class="form-group">
                                    <label for="">Tax Name</label>
                                    <input type="text" id="tax_name" class="form-control" name="tax_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Tax Value (in %)</label>
                                    <input type="text" id="tax_value" class="form-control" name="tax_value" onkeypress="return isNumberKey(event);" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Taxes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_taxes = $database->getData("SELECT * FROM `settings_taxes` ORDER BY `stax_name` ASC");

                                            if ($result_taxes != false) {

                                                while ($taxes_row = mysqli_fetch_array($result_taxes)) {

                                        ?>

                                                    <tr>
                                                        <td><?= $taxes_row['stax_name'] ?></td>
                                                        <td><?= $taxes_row['stax_value'] ?></td>
                                                        <td>
                                                            <a href="<?= $url->baseUrl("admin/settings/tax-edit?q=" . $taxes_row['stax_id']) ?>" class="btn btn-primary"><span class="fa fa-edit"></span></a>

                                                            <a href="<?= $url->baseUrl('admin/confirm-deletion?tablename=settings_taxes&columnname=stax_id&columnvalue=' . $taxes_row['stax_id'] . '&backto=' . $url->baseUrl("admin/settings/taxes") . '') ?>" class="btn btn-danger"><span class="fa fa-trash"></span></a>
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

                <script>
                    function enableDisableTaxes() {

                        var val = "0";

                        if (document.getElementById("enabletaxes").checked == true) {

                            var val = "1";
                        } else {

                            var val = "0";
                        }

                        var request = $.ajax({
                            type: "POST",
                            url: "<?= $url->baseUrl('models/admin/ajax/taxes-enable-disable.php') ?>",
                            data: {
                                val: val
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

                <script>
                    function isNumberKey(evt) {
                        var charCode = (evt.which) ? evt.which : evt.keyCode;
                        if (charCode != 46 && charCode > 31 &&
                            (charCode < 48 || charCode > 57))
                            return false;

                        return true;
                    }
                </script>

</body>

</html>