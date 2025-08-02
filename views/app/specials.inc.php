<?php
// Assuming $url and $database are already initialized
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Specials - Leather Plus</title>
    <meta name="description" content="Explore our featured special products">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section id="content" role="main" class="pt-3 pb-sm-5 pb-0 single-page-blog">
            <div class="container py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $url->baseUrl("") ?>">Home</a></li>
                        <span class="separator">›</span>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="<?= $url->baseUrl("specials") ?>">Specials</a></li>
                    </ol>
                </nav>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="lg-margin"></div>

                        <div class="category-grid">
                            <div class="row">
                                <?php
                                if ($connStatus == true) {
                                    $result_products = $database->getData("SELECT * FROM `products` WHERE `prod_status` = 1 AND `prod_setas` = 'F' LIMIT 0,4");

                                    if ($result_products != false) {
                                        while ($products = mysqli_fetch_array($result_products)) {
                                            // Safely extract all expected product fields
                                            $title = isset($products['prod_title']) ? $products['prod_title'] : '';
                                            $featuredimage = isset($products['prod_featuredimage']) ? $products['prod_featuredimage'] : '';
                                            $regularprice = isset($products['prod_regularprice']) ? $products['prod_regularprice'] : 0;
                                            $saleprice = isset($products['prod_saleprice']) ? $products['prod_saleprice'] : 0;
                                            $shortdesc = isset($products['prod_shortdesc']) ? $products['prod_shortdesc'] : '';
                                            $sku = isset($products['prod_code']) ? $products['prod_code'] : '';
                                            $type = isset($products['prod_buckle']) ? $products['prod_buckle'] : 'A';
                                            // $gallery = isset($products['prod_galleryimages']) ? $products['prod_galleryimages'] : '';
                                            ?>
                                            <div class="col-md-3 col-sm-6 mb-4">
                                                <div class="card h-100 border-0">
                                                    <a href="product?q=<?= $products['prod_id'] ?>">
                                                        <img src="<?= $url->baseUrl('uploads/product-images/' . $featuredimage) ?>"
                                                            class="card-img-top img-fluid rounded" alt="<?= $title ?>">
                                                    </a>
                                                    <div class="card-body p-2">
                                                        <h6 class="fw-bold mb-1 mt-2" style="color: #333; font-size: 1rem;">
                                                            <?= $title ?>
                                                        </h6>
                                                        <span class="text-muted small mb-4 w-100 d-flex">
                                                            <?php if ($saleprice > 0): ?>
                                                                <del>₹<?= $regularprice ?></del> <span
                                                                    class="text-danger">₹<?= $saleprice ?></span>
                                                            <?php else: ?>
                                                                ₹<?= $regularprice ?>
                                                            <?php endif; ?>
                                                        </span>

                                                        <a href="product?q=<?= $products['prod_id'] ?>"
                                                            class="apply-button mt-2">View
                                                            Product</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<p>No featured products found.</p>";
                                    }
                                } else {
                                    echo "<p>Database connection failed.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="md-margin2x visible-sm visible-xs"></div>
                    </div>
                </div>
            </div>

            <div class="lg-margin3x hidden-xs"></div>
            <div class="md-margin2x visible-xs"></div>

        </section>

        <?php include('includes/footer.inc.php') ?>
    </div>

    <?php include('views/app/includes/product-scripts.inc.php') ?>
</body>

</html>