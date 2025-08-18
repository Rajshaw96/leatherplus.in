<?php
include('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/helpers/urlhelpers.php');

$database = new DatabaseOps();
$url = new UrlHelpers();
$connStatus = $database->createConnection();

// Base WHERE clause
$where = "WHERE prod_status = 1";
$searchTerm = $_POST['search'] ?? '';

$searchTerm = trim($searchTerm);

if (!empty($searchTerm)) {
    $escaped = mysqli_real_escape_string($database->conn, $searchTerm);
    $where .= " AND (prod_title LIKE '%$escaped%' OR prod_nick LIKE '%$escaped%')";
}


// Collect all category IDs (parent + child)
$allCatIDs = [];

if (!empty($_POST['category']) && is_array($_POST['category'])) {
    $allCatIDs = array_map('intval', $_POST['category']);
}
if (!empty($_POST['subcategory']) && is_array($_POST['subcategory'])) {
    $subCatIDs = array_map('intval', $_POST['subcategory']);
    $allCatIDs = array_merge($allCatIDs, $subCatIDs);
}

// Apply category filtering using FIND_IN_SET for comma-separated values
if (!empty($allCatIDs)) {
    $findClauses = array_map(fn($id) => "FIND_IN_SET('$id', REPLACE(prod_cats, ' ', ''))", $allCatIDs);
    $where .= " AND (" . implode(" OR ", $findClauses) . ")";
}

// Price filtering based on prod_regularprice
$hasMin = isset($_POST['min_price']) && is_numeric($_POST['min_price']);
$hasMax = isset($_POST['max_price']) && is_numeric($_POST['max_price']);

if ($hasMin && $hasMax) {
    $min = intval($_POST['min_price']);
    $max = intval($_POST['max_price']);
    $where .= " AND prod_regularprice BETWEEN $min AND $max";
} elseif ($hasMin) {
    $min = intval($_POST['min_price']);
    $where .= " AND prod_regularprice >= $min";
} elseif ($hasMax) {
    $max = intval($_POST['max_price']);
    $where .= " AND prod_regularprice <= $max";
}

// Sorting
$sortOrder = "ORDER BY prod_id DESC"; // Default
if (!empty($_POST['sort'])) {
    switch ($_POST['sort']) {
        case 'price-asc':
            $sortOrder = "ORDER BY prod_regularprice ASC";
            break;
        case 'price-desc':
            $sortOrder = "ORDER BY prod_regularprice DESC";
            break;
        default:
            $sortOrder = "ORDER BY prod_id DESC";
            break;
    }
}

// Final query
$query = "SELECT * FROM products $where $sortOrder LIMIT 0, 20";
$result = $database->getData($query);

// Output products
if ($result && mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_array($result)) {
        $productId = htmlspecialchars($product['prod_id']);
        // Prefer nickname if available, otherwise title
        $nickname = $product['prod_nick'] ?? '';
        $displayTitle = !empty($nickname) ? htmlspecialchars($nickname) : htmlspecialchars($product['prod_title']);

        $regularPrice = (float) $product['prod_regularprice'];
        $salePrice = (float) $product['prod_saleprice'] ?? 0;

        $finalSalePrice = $salePrice > 0 ? $salePrice : $regularPrice;
        $finalSalePrice = max($finalSalePrice, 1); // prevent negative prices
        $discountPercent = round(100 - ($finalSalePrice / $regularPrice) * 100);

        $formattedRegular = number_format($regularPrice, 1);
        $formattedSale = number_format($finalSalePrice, 1);

        $image = htmlspecialchars($product['prod_featuredimage']);
        $imageUrl = $url->baseUrl("uploads/product-images/$image");
        $productUrl = $url->baseUrl("product?q=$productId");

        // Fetch reviews for the current product
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

        echo "
<div class='product-card'>
  <a href='$productUrl'>
    <div class='discount'>-$discountPercent%</div>
    <img src='$imageUrl' alt='$displayTitle' />
    <div class='p-3'>
      <div class='product-name'>$displayTitle</div>
      <div class='d-flex justify-content-between align-items-center'>
        <div class='price'>
          ";

        // Only show <del> when there’s a valid sale price
        if ($salePrice > 0 && $salePrice < $regularPrice) {
            echo "<del style='color:#888;'>₹$formattedRegular</del>
                    <span style='font-size:17px; font-weight: 500;'>₹$formattedSale</span>";
        } else {
            echo "<span style='font-size:17px; font-weight: 500;'>₹$formattedRegular</span>";
        }

        echo "
        </div>
        <div class='rating-product'>★ $formattedRating</div>
      </div>
    </div>
  </a>
</div>

";

    }

} else {
    echo "<p>No products found.</p>";
}
?>