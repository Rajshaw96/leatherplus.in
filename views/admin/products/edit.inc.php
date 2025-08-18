<?php

$attribsarray =  explode(',', trim($attributes, ' '));

$catsarray =  explode(',', trim($categories, ' '));

$galleryarray =  explode(',', $gallery);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Product Details - Admin</title>

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
                        <h1 class="h3 mb-0 text-gray-800">Edit Product Details</h1>
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
                        }
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
                        } else if ($_GET['m'] == "add1") {
                        ?>

                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                New product has been added!
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

                    <form action="<?= $url->baseUrl('models/admin/products/edit.php') ?>" method="POST" enctype="multipart/form-data">

                        <?php

                        $_SESSION['secretcode'] = rand(10000000000, 99999999999);
                        // $nickname = $product['prod_nick'] ?? '';
                       
                        ?>

                        <input type="hidden" value="<?= $request->encodeRequestHash($_SESSION['secretcode']) ?>" name="key" id="key">

                        <input type="hidden" value="<?= $_GET['q'] ?>" name="id">

                        <input type="hidden" value="<?= $gallery ?>" name="oldgallery">

                        <input type="hidden" value="<?= $featuredimage ?>" name="oldfeaturedimage">
                        <?php 
                       $productId = intval($_GET['q']);
$query = "SELECT * FROM products WHERE prod_id = $productId LIMIT 1";
$result = $database->getData($query);
$product = mysqli_fetch_assoc($result);

$nickname = $product['prod_nick'] ?? '';
                        ?>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Edit Product Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Product Nickname </label>
                                    <input type="text" class="form-control" name="product_nick" 
                                        value="<?= $nickname ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Product Title</label>
                                    <input type="text" class="form-control" value="<?= $title ?>" name="product_title">
                                </div>

                                <div class="form-group">
                                    <label for="">Product Short Description</label>
                                    <textarea type="text" class="form-control" id="shortdescription" name="product_shortdesc"><?= base64_decode($shortdesc) ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Product Description</label>
                                    <textarea type="text" class="form-control" id="description" name="product_desc" style="min-height:350px !important"><?= base64_decode($desc) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Data</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Type of Product</label>
                                    <select name="product_type" id="product_type" class="form-control" onchange="enableAttributes()">
                                        <option value="S" <?php if ($type == "S") {
                                                                echo "selected";
                                                            } ?>>Simple</option>
                                        <option value="V" <?php if ($type == "V") {
                                                                echo "selected";
                                                            } ?>>Variable</option>
                                        <option value="A" <?php if ($type == "A") {
                                                                echo "selected";
                                                            } ?>>Affilfiate</option>
                                    </select>
                                </div>

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="false">Inventory</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active p-3" id="general" role="tabpanel" aria-labelledby="general-tab">

                                        <?php
                                        if ($enabletaxes == '1') {
                                        ?>
                                            <div class="form-group">
                                                <label for="">Select Tax</label>
                                                <select name="tax" class="form-control">
                                                    <option value="0">None</option>
                                                    <?php
                                                    if ($connStatus == true) {

                                                        $result_taxes = $database->getData("SELECT * FROM `settings_taxes`");

                                                        if ($result_taxes != false) {

                                                            while ($taxes_row = mysqli_fetch_array($result_taxes)) {

                                                    ?>
                                                                <option value="<?= $taxes_row['stax_id'] ?>" <?php if ($tax == $taxes_row['stax_id']) {
                                                                                                                    echo "selected";
                                                                                                                } ?>><?= $taxes_row['stax_name'] ?> (<?= $taxes_row['stax_value'] ?>%)</option>

                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="hidden" value="0" name="tax">
                                        <?php
                                        }
                                        ?>

                                        <div class="form-group">
                                            <label for="">Regular price</label>
                                            <input type="text" id="regularprice" class="form-control" value="<?= $regularprice ?>" name="regular_price" onkeypress="return isNumberKey(event)" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Sale price</label>
                                            <input type="text" id='saleprice' class="form-control" value="<?= $saleprice ?>" name="sale_price" onkeypress="return isNumberKey(event)">
                                        </div>

                                    </div>
                                    <div class="tab-pane fade p-3" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">

                                        <div class="form-group">
                                            <label for="">SKU</label>
                                            <input type="text" class="form-control" value="<?= $sku ?>" name="sku" id="sku">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Manage Stock</label>
                                            <input type="checkbox" name="managestock" id="managestock" value="on" onchange="enableStock()" <?php if ($managestock == 1) {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>>
                                        </div>

                                        <div class="form-group" id="stockqty" style="display: none;">
                                            <label for="">Stock Quantity</label>
                                            <input type="number" class="form-control" value="<?= $stockqty ?>" name="stockquantity" id="stockquantity">
                                        </div>

                                    </div>

                                    <div class="tab-pane fade p-3" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">

                                        <div class="form-group">
                                            <label for="">Weight (kg)</label>
                                            <input type="text" class="form-control" name="weight" value="<?= $weight ?>" id="weight">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Dimensions (cm)</label>
                                        </div>

                                        <div class="form-row">

                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Length" name="length" value="<?= $length ?>" id="length">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Width" name="width" value="<?= $width ?>" id="width">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="Height" name="height" value="<?= $height ?>" id="height">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="attributes" class="card shadow mb-4" style="display:none">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Attributes</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col">
                                        <?php

                                        if ($connStatus == true) {

                                            $resultattribs = $database->getData("SELECT * FROM `product_attributes`");

                                            if ($resultattribs != false) {

                                                while ($attributes = mysqli_fetch_array($resultattribs)) {

                                        ?>
                                                    <div class="form-group">

                                                        <label class="form-check-label">
                                                            &nbsp; &nbsp; &nbsp; &nbsp;

                                                            <input type="checkbox" class="form-check-input" name="attributes[]" value="<?= $attributes['pattrib_id'] ?>" id="" <?php if (in_array($attributes['pattrib_id'], $attribsarray)) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                } ?>><?= $attributes['pattrib_name'] ?>
                                                        </label>
                                                    </div>

                                        <?php
                                                }
                                            }
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="attributes" class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Material</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col">

                                        <label for="">Material Selection</label>
                                        <select class="form-control" name="matstatus">
                                            <option value="1" <?php if ($matstatus == 1) {
                                                                    echo "selected";
                                                                }  ?>>Enabled</option>
                                            <option value="0" <?php if ($matstatus == 0) {
                                                                    echo "selected";
                                                                }  ?>>Disabled</option>
                                        </select>


                                        <label for="">Attribute</label>
                                        <select class="form-control" id="material" onchange="fetchmaterials()" name="matattrib">

                                            <option value="0">--Select-</option>

                                            <?php

                                            if ($connStatus == true) {

                                                $resultattribs = $database->getData("SELECT * FROM `product_attributes` WHERE `pattrib_type` = 'M'");

                                                if ($resultattribs != false) {

                                                    while ($attributes = mysqli_fetch_array($resultattribs)) {

                                            ?>

                                                        <option value="<?= $attributes['pattrib_id'] ?>" <?php if ($matparent == $attributes['pattrib_id']) {
                                                                                                                echo "selected";
                                                                                                            }  ?>><?= $attributes['pattrib_name'] ?></option>

                                            <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row mt-2">
                                    <div class="col">

                                        <div class="form-check" id="matsfetched">

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Default Selected Material Attribute</label>
                                    <select id="defmatattrib" class="form-control" name="defmatattrib">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <label for="">Product Featured Image</label>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="featuredimage" id="featuredimage">
                                        </div>
                                        <img id="featuredimageresponse" src="" style="max-width: 75px; margin-bottom:50px;" alt="">
                                        <input type="hidden" id="featuredimageresponsehidden" name="uploadedfeatured">
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-primary" id="uploadFeaturedBtn" onclick="uploadFeaturedImage()" data-target>Upload</a>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="">Product Gallery</label>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="file" class="form-control" name="productgallery[]" id="productgallery" multiple>
                                        </div>
                                        <div class="productgalleryresponse">
                                            <?php

                                            if (strlen($gallery) > 0) {

                                                foreach ($galleryarray as $photos) {
                                            ?>

                                                    <img style="max-height:95px !important" src="<?= $url->baseUrl('uploads/product-gallery/' . trim($photos, " ")) ?>" alt=""> &nbsp;

                                            <?php
                                                }
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label for="">Product Video Embed Code (Optional)</label>
                                    <textarea class="form-control" name="product_video"><?= base64_decode($video) ?></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Product Categories</h6>
                            </div>
                            <div class="card-body" style="max-height:250px; overflow:scroll">
                                <div class="form-check">
                                    <?php
                                    if ($connStatus == true) {
                                        $result_parentcats = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=0 ORDER BY `pcat_name` ASC");

                                        if ($result_parentcats != false) {

                                            while ($parentcats_row = mysqli_fetch_array($result_parentcats)) {

                                    ?>
                                                <div class="form-group">

                                                    <label class="form-check-label">

                                                        <input type="checkbox" class="form-check-input" name="category[]" value="<?= $parentcats_row['pcat_id'] ?>" id="" value="<?= $parentcats_row['pcat_id'] ?>" <?php if (in_array($parentcats_row['pcat_id'], $catsarray)) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>> <?= $parentcats_row['pcat_name'] ?>
                                                    </label>
                                                </div>


                                                <?php

                                                $result_sub = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=" . $parentcats_row['pcat_id']);

                                                if ($result_sub != false) {

                                                    while ($subcategory_row = mysqli_fetch_array($result_sub)) {

                                                ?>
                                                        <div class="form-group">

                                                            <label class="form-check-label">
                                                                &nbsp; &nbsp; &nbsp; &nbsp;

                                                                <input type="checkbox" class="form-check-input" name="category[]" value="<?= $subcategory_row['pcat_id'] ?>" id="" <?php if (in_array($subcategory_row['pcat_id'], $catsarray)) {
                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                    } ?>><?= $subcategory_row['pcat_name'] ?>
                                                            </label>
                                                        </div>

                                                        <?php

                                                        $result_sub2 = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`=" . $subcategory_row['pcat_id']);

                                                        if ($result_sub2 != false) {

                                                            while ($subcategory_row2 = mysqli_fetch_array($result_sub2)) {

                                                        ?>

                                                                <div class="form-group">

                                                                    <label class="form-check-label">
                                                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                                                                        <input type="checkbox" class="form-check-input" name="category[]" value="<?= $subcategory_row2['pcat_id'] ?>" id="" <?php if (in_array($subcategory_row2['pcat_id'], $catsarray)) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>><?= $subcategory_row2['pcat_name'] ?>
                                                                    </label>
                                                                </div>


                                    <?php
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Product Tags or SEO Description</label>
                                    <textarea class="form-control" name="tags"><?= $tags ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="">Set As</label>
                                    <select class="form-control" name="setas">
                                        <option value="N" <?php if ($setas == "N") {
                                                                echo "None";
                                                            } ?>>None</option>
                                        <option value="B" <?php if ($setas == "B") {
                                                                echo "selected";
                                                            } ?>>Best Seller</option>
                                        <option value="R" <?php if ($setas == "R") {
                                                                echo "selected";
                                                            } ?>>Latest Product</option>

                                        <option value="L" <?php if ($setas == "L") {
                                                                echo "selected";
                                                            } ?>>Look Book</option>

                                        <option value="F" <?php if ($setas == "F") {
                                                                echo "selected";
                                                            } ?>>Top Rated</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select class="form-control" name="status">
                                        <option value="0" <?php if ($status == 0) {
                                                                echo "selected";
                                                            } ?>>Draft</option>
                                        <option value="1" <?php if ($status == 1) {
                                                                echo "selected";
                                                            } ?>>Published</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>

                    </form>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- footer -->
            <?php include('../../views/admin/includes/footer.inc.php'); ?>

            <script>
                function isNumberKey(evt) {
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode != 46 && charCode > 31 &&
                        (charCode < 48 || charCode > 57))
                        return false;

                    return true;
                }
            </script>

            <script>
                function enableStock() {
                    if (document.getElementById('managestock').checked == true) {

                        document.getElementById('stockqty').style.display = "block";
                    } else {
                        document.getElementById('stockqty').style.display = "none";
                    }
                }
            </script>

            <script>
                if (document.getElementById('managestock').checked == true) {

                    document.getElementById('stockqty').style.display = "block";
                } else {
                    document.getElementById('stockqty').style.display = "none";
                }
            </script>

            <script>
                $('#uploadFeaturedBtn').on('click', function() {

                    document.getElementById("featuredimageresponse").src = "<?= $url->baseUrl('views/assets/img/loading.gif') ?>";

                    var file_data = $('#featuredimage').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('key', document.getElementById('key').value);

                    $.ajax({
                        url: '<?= $url->baseUrl('models/admin/ajax/product-image-upload.php') ?>', // <-- point to server-side PHP script 
                        dataType: 'html', // <-- what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function(php_script_response) {
                            //alert(php_script_response); // <-- display response from the PHP script, if any
                            document.getElementById("featuredimageresponse").src = "<?= $url->baseUrl('uploads/product-images/') ?>" + php_script_response;

                            document.getElementById("featuredimageresponsehidden").value = php_script_response;
                        }
                    });
                });
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

            <script>
                function enableAttributes() {
                    if (document.getElementById("product_type").value == "V") {

                        document.getElementById("attributes").style.display = "block";
                    } else {
                        document.getElementById("attributes").style.display = "none";
                    }
                }
            </script>

            <?php

            if ($type == "V") {
            ?>

                <script>
                    document.getElementById("attributes").style.display = "block";
                </script>

            <?php

            }

            if (strlen($featuredimage) > 0) {
            ?>
                <script>
                    document.getElementById("featuredimageresponse").src = "<?= $url->baseUrl('uploads/product-images/' . $featuredimage) ?>";
                </script>
            <?php
            }

            ?>

            <script>
                function fetchmaterials() {

                    var material = document.getElementById("material").value;

                    var request = $.ajax({
                        type: "POST",
                        url: "<?= $url->baseUrl('models/admin/ajax/fetchmaterialsws.php') ?>",
                        data: {
                            id: material,
                            mats: '<?= $matattrib ?>'
                        },
                        dataType: "html"
                    });

                    request.done(function(msg) {
                        //alert(msg);

                        document.getElementById("matsfetched").innerHTML = msg;

                        fetchmaterialsindd();
                    });

                    request.fail(function(jqXHR, textStatus) {
                        alert(textStatus);
                    });

                }

                function fetchmaterialsindd() {

                    var material = document.getElementById("material").value;

                    var request = $.ajax({
                        type: "POST",
                        url: "<?= $url->baseUrl('models/admin/ajax/fetchmaterialsinddedt.php') ?>",
                        data: {
                            id: material,
                            q: <?= $defmatattrib ?>
                        },
                        dataType: "html"
                    });

                    request.done(function(msg) {
                        //alert(msg);

                        document.getElementById("defmatattrib").innerHTML = msg;
                    });

                    request.fail(function(jqXHR, textStatus) {
                        alert(textStatus);
                    });

                }

                fetchmaterials();
            </script>

            <script type="text/javascript">
                $('#featuredimage').on('change', function() {

                    const size = (this.files[0].size / 1024 / 1024).toFixed(2);

                    if (size > 4) {
                        alert("File must be between the size of 20 KB -4 MB");
                    } else {
                        $("#output").html('<b>' +
                            'This file size is: ' + size + " MB" + '</b>');
                    }
                });

                $('#productgallery').on('change', function() {

                    const size = (this.files[0].size / 1024 / 1024).toFixed(2);

                    if (size > 4) {
                        alert("File must be between the size of 20 KB - 4 MB");
                    } else {
                        $("#output").html('<b>' +
                            'This file size is: ' + size + " MB" + '</b>');
                    }
                });
            </script>

</body>

</html>