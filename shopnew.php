<?php
include('./lib/config/config.php');
include('./lib/database/databaseops.php');
include('./lib/helpers/urlhelpers.php');

$url = new UrlHelpers();
$database = new DatabaseOps();
$connStatus = $database->createConnection();

$category = $_GET['category'] ?? '';
$subcategory = $_GET['subcategory'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$sort = $_GET['sort'] ?? 'featured';

$where = "WHERE prod_status = 1";
if (!empty($category)) {
  $where .= " AND prod_cats LIKE '%$category%'";
}
if (!empty($subcategory)) {
  $where .= " AND prod_tags LIKE '%$subcategory%'";
}
if (!empty($min)) {
  $where .= " AND prod_regularprice >= " . intval($min);
}
if (!empty($max)) {
  $where .= " AND prod_regularprice <= " . intval($max);
}

$order = "ORDER BY prod_id DESC"; // default
if ($sort === 'price-asc') {
  $order = "ORDER BY prod_regularprice ASC";
} elseif ($sort === 'price-desc') {
  $order = "ORDER BY prod_regularprice DESC";
}

$sql = "SELECT * FROM products $where $order LIMIT 0, 24";
$result_products = $database->getData($sql);

if ($result_products != false) {
  while ($product = mysqli_fetch_assoc($result_products)) {
    $title = $product['prod_title'];
    $regularprice = $product['prod_regularprice'];
    $saleprice = $product['prod_saleprice'];
    $featuredimage = $product['prod_featuredimage'];
    $category = $product['prod_cats'];
    $rating = 4.9; // Optional: pull from review table
?>
    <div class="product-card">
      <div class="discount">-<?= round((($regularprice - $saleprice) / $regularprice) * 100) ?>%</div>
      <img src="<?= $url->baseUrl("uploads/product-images/" . $featuredimage) ?>" alt="<?= $title ?>" />
      <div class="p-3">
        <div class="product-name"><?= $title ?></div>
        <div class="d-flex justify-content-between align-items-center">
          <div class="price"><del>₹<?= $regularprice ?></del> ₹<?= $saleprice ?></div>
          <div class="rating-product">★ <?= $rating ?></div>
        </div>
      </div>
    </div>
<?php
  }
} else {
  echo "<p>No products found.</p>";
}
?>
