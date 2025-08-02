<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Best Sellers - Leather Plus</title>
    <meta name="description" content="<?= $description ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display">

    <!-- Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section id="content" role="main" class="pt-3 pb-sm-5 pb-0 single-page-blog" >
            <div class="container py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $url->baseUrl("") ?>">Home</a></li>
                        <span class="separator">›</span><li class="breadcrumb-item active" aria-current="page"><a
                                href="<?= $url->baseUrl("best-sellers") ?>">Best Sellers</a></li>
                    </ol>
                </nav>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <?php
                            if ($connStatus == true) {
                                $result_products = $database->getData("SELECT * FROM `products` WHERE `prod_status` = 1 AND `prod_setas` = 'B' LIMIT 0, 8");

                                if ($result_products != false && mysqli_num_rows($result_products) > 0) {
                                    while ($product = mysqli_fetch_array($result_products)) {
                                        // destructuring values from fetched row
                                        $title = $product['prod_title'];
                                        $featuredimage = $product['prod_featuredimage'];
                                        $regularprice = $product['prod_regularprice'];
                                        $saleprice = $product['prod_saleprice'];
                                        $shortdesc = $product['prod_shortdesc'];
                                        // $sku = $product['prod_code'];
                                        // $type = $product['prod_buckle'];
                                        // $gallery = $product['prod_galleryimages'];
                            
                                        ?>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card h-100 border-0">
                                                <a href="product?q=<?= $product['prod_id'] ?>">
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

                                                    <a href="product?q=<?= $product['prod_id'] ?>" class="apply-button mt-2">View
                                                        Product</a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php }
                                } else {
                                    echo '<p class="text-muted">No best sellers available.</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include('includes/footer.inc.php') ?>

    </div>
</body>

</html>