<body>
    <div id="wrapper">

        <section role="main" class="pt-3 pb-sm-5 pb-0">
            <div class="container">
                <div class="row">
                    <h2 class="our-Products">Our Products</h2>
                    <div class="col-sm-12">
                        <div class="row d-flex flex-col gap-4">

                            <?php
                            if ($connStatus === true) {
                                $result_products = $database->getData("SELECT * FROM products WHERE prod_status = 1 AND prod_setas = 'B' LIMIT 0, 8");

                                if ($result_products && mysqli_num_rows($result_products) > 0) {
                                    while ($product = mysqli_fetch_array($result_products)) {
                                        $productId = $product['prod_id'];
                                        $title = htmlspecialchars($product['prod_title']);
                                        $regular = (float) $product['prod_regularprice'];
                                        $sale = (float) ($product['prod_saleprice'] ?? 0);
                                        $image = htmlspecialchars($product['prod_featuredimage']);

                                        $finalSale = ($sale && $sale > 0) ? $sale : max($regular - 350, 1);
                                        $discount = round(100 - ($finalSale / $regular) * 100);

                                        $formattedRegular = number_format($regular, 1);
                                        $formattedSale = number_format($finalSale, 1);

                                        $imageUrl = $url->baseUrl("uploads/product-images/" . $image);
                                        $productLink = $url->baseUrl("product?q=" . $productId);

                                        // Fetch ratings
                                        $reviewQuery = "SELECT preview_rating FROM product_reviews WHERE preview_prodid = ? AND preview_status = 1";
                                        $reviewStmt = $database->conn->prepare($reviewQuery);
                                        $reviewStmt->bind_param("i", $productId);
                                        $reviewStmt->execute();
                                        $reviewResult = $reviewStmt->get_result();

                                        $totalReviews = 0;
                                        $sumRatings = 0;
                                        while ($reviewRow = $reviewResult->fetch_assoc()) {
                                            $sumRatings += $reviewRow['preview_rating'];
                                            $totalReviews++;
                                        }
                                        $averageRating = $totalReviews > 0 ? round($sumRatings / $totalReviews, 1) : 5.0;
                                        $formattedRating = number_format($averageRating, 1);
                                        ?>
                                        <div class="product-card">
                                            <div class="position-relative">
                                                <a href="<?= $productLink ?>">
                                                    <?php if ($discount > 0): ?>
                                                        <div class="badge"
                                                            style="font-size: 0.8rem;">
                                                            -<?= $discount ?>%
                                                        </div>
                                                    <?php endif; ?>
                                                    <img src="<?= $imageUrl ?>" class="card-img-top img-fluid"
                                                        alt="<?= $title ?>">
                                                </a>
                                                <div class="product-details">
                                                    <h6 class="fw-bold mb-2 mt-2" style="color: #333; font-size: 1rem;">
                                                        <a href="<?= $productLink ?>"
                                                            style="text-decoration: none; color: inherit;"><?= $title ?></a>
                                                    </h6>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="product-price">
                                                            <?php if ($finalSale < $regular): ?>
                                                                <strike>₹<?= $formattedRegular ?></strike>
                                                                <span style="font-size: 17px;font-weight:600;">₹<?= $formattedSale ?></span>
                                                            <?php else: ?>
                                                                <span style="font-size: 17px;font-weight:600;">₹<?= $formattedRegular ?></span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="rating">
                                                            <i class="fa fa-star"></i> <?= $formattedRating ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo '<p class="text-muted">No best sellers available.</p>';
                                }
                            } else {
                                echo '<p class="text-danger">Error: Could not connect to database.</p>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>