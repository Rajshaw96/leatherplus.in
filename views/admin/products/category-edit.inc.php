<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Product Category Details - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= $url->baseUrl("views/assets/vendor/fontawesome-free/css/all.min.css") ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $url->baseUrl("views/assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

    <script src="<?= $url->baseUrl("views/assets/vendor/tinymce/js/tinymce/tinymce.min.js") ?>"></script>

    <script>
        tinymce.init({
            selector: '#shortdescription, #description',
            plugins: 'lists advlist',
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
                        <h1 class="h3 mb-0 text-gray-800">Product Categories</h1>
                    </div>

                    <?php
                    if (isset($_GET['m'])) {

                        if ($_GET['m'] == "add1") {

                    ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New Category has been added successfully!
                            </div>

                        <?php
                        } else if ($_GET['m'] == "ds") {

                        ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                Selected Category has been removed successfully!
                            </div>

                    <?php
                        }
                    }
                    ?>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Product Category</h6>
                        </div>

                        <div class="card-body">
                            <form action="<?= $url->baseUrl("models/admin/products/category-edit.php") ?>" method="POST" enctype="multipart/form-data">

                                <?php

                                $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                                ?>

                                <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key">

                                <input type="hidden" value="<?= $_GET['q'] ?>" name="category_id">

                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" id="category_name" class="form-control" value="<?= $category_name ?>" name="category_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Change Cover Image</label>
                                    <input type="file" class="form-control" name="category_cover">
                                    <p><img src="<?= $url->baseUrl('uploads/product-category/' . $category_cover) ?>" style="max-width:250px" alt=""></p>
                                    <input type="hidden" value="<?= $category_cover ?>" name="catcover">
                                </div>

                                <div class="form-group">
                                    <label for="">Parent Category</label>
                                    <select class="form-control" name="category_parent">
                                        <option value="0">None</option>
                                        <?php
                                        if ($connStatus == true) {
                                            $result_parentcats = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=0 ORDER BY `pcat_name` ASC");

                                            if ($result_parentcats != false) {

                                                while ($parentcats_row = mysqli_fetch_array($result_parentcats)) {

                                        ?>

                                                    <option value="<?= $parentcats_row['pcat_id'] ?>" <?php if($parentcats_row['pcat_id'] == $category_parent){ echo "selected"; } ?>><?= $parentcats_row['pcat_name'] ?></option>
                                                    <?php

                                                    $result_sub = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=" . $parentcats_row['pcat_id']);

                                                    if ($result_sub != false) {

                                                        while ($subcategory_row = mysqli_fetch_array($result_sub)) {

                                                    ?>

                                                            <option value="<?= $subcategory_row['pcat_id'] ?>" <?php if($subcategory_row['pcat_id'] == $category_parent){ echo "selected"; } ?>>&nbsp; &nbsp; <?= $subcategory_row['pcat_name'] ?></option>

                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" name="category_desc"><?= $category_desc ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Display Content</label>
                                    <textarea class="form-control" id="description" name="category_content"><?= base64_decode($category_content) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Menu Order</label>
                                    <input type="number" class="form-control" value="<?= $category_menuorder ?>" name="category_menuorder">
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- footer -->
                <?php include('../../views/admin/includes/footer.inc.php'); ?>

</body>

</html>