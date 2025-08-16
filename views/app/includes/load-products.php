<?php
include("../../../lib/config/config.php");
require_once("../../../lib/database/databaseops.php");
require_once("../../../lib/helpers/urlhelpers.php"); // Needed for $url

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 4;

$database = new DatabaseOps();
$url = new UrlHelpers();
$connStatus = $database->createConnection();

if ($connStatus === true) {
  $query = "SELECT * FROM `products` WHERE `prod_status` = 1 ORDER BY `prod_id` DESC LIMIT $offset, $limit";
  $result_products = $database->getData($query);

  if ($result_products && mysqli_num_rows($result_products) > 0) {
    while ($product = mysqli_fetch_array($result_products)) {
      $title = htmlspecialchars($product['prod_title']);
      $regular = (float) $product['prod_regularprice'];
      $sale = (float) ($product['prod_saleprice'] ?? 0);
      $image = htmlspecialchars($product['prod_featuredimage']);

      $formattedRegular = number_format($regular, 1);
      $formattedSale = $sale > 0 ? number_format($sale, 1) : null;

      $imageUrl = $url->baseUrl("uploads/product-images/" . $image);
      $productLink = $url->baseUrl("product?q=" . $product['prod_id']);
      ?>
      <div class="product-card">
        <a href="<?= $productLink ?>">

          <?php if ($sale > 0 && $regular > $sale): ?>
            <?php 
              $discount = round(100 - ($sale / $regular) * 100);
            ?>
            <div class="badge">-<?= $discount ?>%</div>
          <?php endif; ?>

          <img class="product-image" src="<?= $imageUrl ?>" alt="<?= $title ?>" />
          <div class="product-details">
            <div class="product-name">
              <a href="<?= $productLink ?>"><?= $title ?></a>
            </div>
            <div class="price-rating-row">
              <div class="product-price">
                <?php if ($sale > 0 && $regular > $sale): ?>
                  <strike>₹<?= $formattedRegular ?></strike>
                  <span style="font-size: 17px;font-weight:600;">₹<?= $formattedSale ?></span>
                <?php else: ?>
                  <span style="font-size: 17px;font-weight:600;">₹<?= $formattedRegular ?></span>
                <?php endif; ?>
              </div>
              <?php
              $productId = $product['prod_id'];
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
              <div class="rating">
                <i class="fa fa-star"></i> <?= $formattedRating ?>
              </div>
            </div>
          </div>
        </a>
      </div>
      <?php
    }
  } else {
    echo ''; // No products found
  }
} else {
  echo '<p>Error: Could not connect to database.</p>';
}
?>
