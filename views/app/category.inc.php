<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title><?= $title ?> - Leather Plus</title>
    <meta name="description" content="<?= $description ?>">

    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css")?>" />
      <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css")?>" />
      <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css")?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/icon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/leatherplus_logo.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/leatherplus_logo.png") ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

    <!--- jQuery -->
    

</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section id="content" role="main">
            <div class="breadcrumb-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="breadcrumb">
                                <li><a href="index" title="Home">Home</a></li>
                                <li class="active"><?= $title ?></li>
                            </ul>
                        </div><!-- End .col-md-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .breadcrumb-container -->

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="category-banner">
                            <img src="<?= $url->baseUrl('uploads/product-category/') . $cover ?>" alt="<?= $title ?>" class="img-responsive" style="height:200px !important; width:100%; object-fit: cover;">
                            <div class="banner-container">
                                <div class="vcenter-container">
                                    <div class="vcenter">
                                        <div class="banner-content">
                                            <h1 style="color:#fff !important;"><span style="color:#fff !important;"><?= $title ?></span>Collection</h1>
                                            <!--
                                            <a href="#" class="btn btn-custom-7 min-width-md">Buy it now</a>
-->
                                        </div>
                                    </div><!-- End .vcenter -->
                                </div><!-- End .vcenter-container -->
                            </div><!-- End .banner-content -->
                        </div><!-- End #category-banner -->

                        <div class="lg-margin"></div><!-- space -->

                        <div class="row">
                            <div class="col-md-9 padding-right-lg">

                                <form action="" method="GET">

                                    <div id="category-filter-bar" class="clearfix">


                                        <input type="hidden" value="<?= $_GET['q'] ?>" name="q"">

                                        <div class=" pull-left clearfix">

                                        <div class="pull-left sort-filter">
                                            <div class="normal-selectbox clearfix">
                                                <select id="sort-filter" name="sort-filter" onchange="this.form.submit()" class="selectbox">
                                                    <option value="prod_id" <?php if ($_SESSION['prod_sort_by'] == "prod_id") {
                                                                                echo "selected";
                                                                            } ?>>Sort By: Latest</option>
                                                    <option value="prod_regularprice" <?php if ($_SESSION['prod_sort_by'] == "prod_regularprice") {
                                                                                            echo "selected";
                                                                                        } ?>>Sort By: Price</option>
                                                </select>
                                            </div><!-- End .normal-selectbox-->
                                        </div><!-- End .sort-filter -->

                                    </div><!-- End .pull-left -->

                                    <div class="sm-margin visible-xs clearfix"></div><!-- space -->



                                    <div class="pull-right clearfix">

                                        <div class="normal-selectbox clearfix">
                                            <select id="show-filter" name="show-filter" onchange="this.form.submit()" class="selectbox">
                                                <option value="9" <?php if ($_SESSION['prod_show_count'] == 9) {
                                                                        echo "selected";
                                                                    } ?>>Show: 9</option>
                                                <option value="12" <?php if ($_SESSION['prod_show_count'] == 12) {
                                                                        echo "selected";
                                                                    } ?>>Show: 12</option>
                                                <option value="15" <?php if ($_SESSION['prod_show_count'] == 15) {
                                                                        echo "selected";
                                                                    } ?>>Show: 15</option>
                                                <option value="18" <?php if ($_SESSION['prod_show_count'] == 18) {
                                                                        echo "selected";
                                                                    } ?>>Show: 18</option>
                                                <option value="21" <?php if ($_SESSION['prod_show_count'] == 21) {
                                                                        echo "selected";
                                                                    } ?>>Show: 21</option>
                                            </select>
                                        </div><!-- End .normal-selectbox-->

                                        <!--
                                    <a href="compare.html" class="btn btn-custom-8 btn-compare pull-right">Compare</a>
                                    <div class="view-btn-group pull-right">
                                        <a href="category.html" class="btn btn-view btn-view-grid active">Grid View</a>
                                        <a href="category-list.html" class="btn btn-view btn-view-list">List View</a>
                                    </div>
                                                                        -->
                                    </div><!-- End .pull-right -->
                                </form>
                            </div><!-- End #category-filter-bar -->

                            <div class="category-grid">

                                <div class="row">

                                    <?php

                                    if ($connStatus == true) {

                                        $result_products = $database->getData("SELECT * FROM `products` WHERE `prod_status` = 1 AND `prod_cats` LIKE '" . $_GET['q'] . "%' OR `prod_cats` LIKE '%, " . $_GET['q'] . "%' AND `prod_regularprice` BETWEEN '".$_SESSION['lower_range']."' AND '".$_SESSION['upper_range']."' ORDER BY `" . $_SESSION['prod_sort_by'] . "` ASC LIMIT " . ($nav_page - 1) * $_SESSION['prod_show_count'] . "," . $_SESSION['prod_show_count']);

                                        if ($result_products != false) {

                                            while ($products = mysqli_fetch_array($result_products)) {

                                    ?>

                                                <div class="col-sm-4 md-margin2x">

                                                    <?php

                                                    include("templates/product-2.inc.php");

                                                    ?>

                                                </div>

                                    <?php
                                            }
                                        }
                                    }

                                    ?>

                                </div><!-- End .row -->

                                <?php

                                $result_products_pagination = $database->getData("SELECT COUNT(`prod_id`) AS `total_products` FROM `products` WHERE `prod_status` = 1 AND `prod_cats` LIKE '" . $_GET['q'] . "%' OR `prod_cats` LIKE '%, " . $_GET['q'] . "%' AND `prod_regularprice` BETWEEN '".$_SESSION['lower_range']."' AND '".$_SESSION['upper_range']."' ORDER BY `" . $_SESSION['prod_sort_by'] . "` ASC LIMIT 0," . $_SESSION['prod_show_count']);

                                if ($result_products_pagination != false) {

                                    while ($pagination = mysqli_fetch_array($result_products_pagination)) {

                                        $pages = ceil($pagination['total_products'] / $_SESSION['prod_show_count']);
                                    }
                                }
                                ?>


                                <div class="pagination-container clear-margin clearfix">
                                    <ul class="pagination pull-right">

                                        <?php

                                        $i = 1;

                                        while ($i <= $pages) {

                                        ?>

                                            <li><a href="<?= ("category?q=" . $_GET['q']) . "&sort-filter=" . $_SESSION['prod_sort_by'] . "&show-filter=" . $_SESSION['prod_show_count'] . "&page=" . $i ?>"><?= $i ?></a></li>

                                        <?php

                                            $i = $i + 1;
                                        }

                                        ?>
                                    </ul>
                                </div><!-- End pagination-container -->

                            </div><!-- End .category-grid -->

                            <div class="md-margin2x visible-sm visible-xs"></div><!-- space -->
                        </div><!-- End .col-md-9 -->

                        <aside class="col-md-3 sidebar margin-top-up" role="complementary">

                            <div class="widget">
                                <h3>Shop By Categories</h3>

                                <ul id="category-widget">

                                    <?php

                                    $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

                                    if ($result_categories != false) {

                                        while ($categories = mysqli_fetch_array($result_categories)) {
                                    ?>

                                            <li class="open"><a href="category?q=<?= $categories['pcat_id'] ?>"><?= $categories['pcat_name'] ?><span class="category-widget-btn"></span></a>
                                                <ul>

                                                    <?php

                                                    $result_childcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent`= '" . $categories['pcat_id'] . "' ORDER BY `pcat_menuorder` ASC");

                                                    if ($result_childcategories != false) {

                                                        while ($childcategories = mysqli_fetch_array($result_childcategories)) {
                                                    ?>

                                                            <li><a href="category?q=<?= $childcategories['pcat_id'] ?>"><?= $childcategories['pcat_name'] ?></a></li>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </ul>

                                        <?php
                                        }
                                    }

                                        ?>
                                </ul>
                            </div><!-- End .widget -->


                            <div class="widget">
                                <div class="accordion" id="sidebar-collapse-filter">

                                    <div class="accordion-group panel">
                                        <div class="accordion-title">
                                            Price Filter
                                            <a class="accordion-btn open" data-toggle="collapse" href="#price-filter"></a>
                                        </div><!-- End .accourdion-title -->

                                        <div class="accordion-body collapse in" id="price-filter">
                                            <div class="accordion-body-wrapper">
                                                <div class="filter-price">
                                                    <form action="" method="GET">

                                                    <input type="hidden" value="<?= $_GET['q'] ?>" name="q">

                                                        <div id="filter-range-details" class="row">
                                                            <div class="col-xs-5">
                                                                <div class="filter-price-label">from</div>
                                                                <input type="text" id="range-low" value="<?= $_SESSION['lower_range'] ?>" name="lower_range" class="form-control">
                                                            </div>
                                                            <div class="col-xs-5">
                                                                <div class="filter-price-label">to</div>
                                                                <input type="text" id="range-high" value="<?= $_SESSION['upper_range'] ?>" name="upper_range" class="form-control">
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="filter-price-label">&nbsp;</div>
                                                                <button type="submit" class="btn btn-custom min-width-xss">Ok</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- End .accordion-body-wrapper -->
                                        </div><!-- End .accordion-body -->
                                    </div><!-- End .accordion-group -->
                                </div><!-- End .accordion -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3>BestSellers</h3>
                                <div class="owl-carousel bestsellers-slider">
                                    <div class="product-group">
                                        <div class="col-sm-3">

                                            <?php

                                            if ($connStatus == true) {

                                                $result_products = $database->getData("SELECT * FROM `products` WHERE `prod_status` = 1 AND `prod_setas` = 'L' LIMIT 0,2");

                                                if ($result_products != false) {

                                                    while ($products = mysqli_fetch_array($result_products)) {

                                            ?>



                                                        <div class="product clearfix">
                                                            <figure class="product-image-container">
                                                                <a href="<?= ("products?q=" . $products['prod_id']) ?>" title="<?= $products['prod_title'] ?>">
                                                                    <img src="<?= $url->baseUrl("uploads/product-images/" . $products['prod_featuredimage']) ?>" alt="<?= $products['prod_title'] ?>" class="product-image">
                                                                    <?php
                                                                    $gallery = explode(",", $products['prod_gallery']);

                                                                    $prod_img2 = "";

                                                                    foreach ($gallery as $prod_img) {

                                                                        if ($prod_img2 == "") {

                                                                            $prod_img2 = trim($prod_img);
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <img src="<?= $url->baseUrl("uploads/product-gallery/" . $prod_img2) ?>" alt="<?= $products['prod_title'] ?>" class="product-image-hover">
                                                                </a>
                                                            </figure>
                                                            <div class="product-content">
                                                                <h3 class="product-name"><a href="product.html" title="Jacket Suiting Blazer"><?= $products['prod_title'] ?></a></h3>
                                                                <div class="ratings-container">
                                                                    <div class="ratings">
                                                                        <div class="ratings-result" data-result="80"></div>
                                                                    </div><!-- End .ratings -->
                                                                </div><!-- End .rating-container -->
                                                                <div class="product-price-container">
                                                                    <span class="product-price">
                                                                        <?php

                                                                        if ($products['prod_saleprice'] > 0) {
                                                                        ?>
                                                                            <s>₹ <?= $products['prod_regularprice'] ?></s> ₹ <?= $products['prod_saleprice'] ?>

                                                                        <?php
                                                                        } else {
                                                                        ?>

                                                                            <?= $products['prod_regularprice'] ?>

                                                                        <?php
                                                                        }

                                                                        ?>
                                                                    </span>
                                                                </div><!-- End .product-price-container -->
                                                            </div><!-- End .product-content -->
                                                        </div><!-- End .product -->

                                            <?php
                                                    }
                                                }
                                            }

                                            ?>

                                        </div>

                                    </div><!-- End .product-group -->
                                </div><!-- End .owl-carousel -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <div class="sidebar-banner">
                                    <img src="images/banners/banner.jpg" alt="banner" class="img-responsive">
                                    <div class="sidebar-banner-content">
                                        <div class="vcenter-container">
                                            <div class="vcenter">
                                                <h5><span>New </span>Collection</h5>
                                                <a href="#" class="btn btn-custom-7 min-width-md">Buy it now</a>
                                            </div><!-- End .vcenter -->
                                        </div><!-- End .vcenter-container -->
                                    </div><!-- End .sidebar-banner-content -->
                                </div><!-- End .sidebar-banner -->
                            </div><!-- End .widget -->
                        </aside><!-- End .sidebar -->
                    </div><!-- End .row -->
                </div><!-- End .col-sm-12 -->
            </div><!-- End .row -->
    </div><!-- End .container -->

    <div class="lg-margin3x hidden-xs"></div><!-- space -->
    <div class="md-margin2x visible-xs"></div><!-- space -->

    </section><!-- End #content -->

    <?php include('includes/footer.inc.php') ?>

    </div><!-- End #wrapper -->

    <!-- scroltop -->
    <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

    <!-- END -->

    

    <?php include('views/app/includes/product-scripts.inc.php') ?>

</body>

</html>