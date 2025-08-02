<?php
include('../../lib/config/config.php');
include('../../lib/database/databaseops.php');

$database = new DatabaseOps();
$connStatus = $database->createConnection();

$where = "WHERE prod_status = 1";

// Handle subcategory filters (checkboxes)
if (!empty($_POST['subcategory'])) {
  $subcats = array_map('intval', $_POST['subcategory']);
  $conditions = array_map(function ($cat) {
    return "FIND_IN_SET($cat, REPLACE(prod_cats, ' ', ''))";
  }, $subcats);
  $where .= " AND (" . implode(" OR ", $conditions) . ")";
}

// Handle price filter
if (!empty($_POST['min_price']) && !empty($_POST['max_price'])) {
  $min = intval($_POST['min_price']);
  $max = intval($_POST['max_price']);
  $where .= " AND prod_salerice BETWEEN $min AND $max";
}

// Sorting
$sort = $_POST['sort'] ?? 'featured';
$orderBy = "ORDER BY prod_id DESC";
if ($sort === 'price-asc') $orderBy = "ORDER BY prod_salerice ASC";
elseif ($sort === 'price-desc') $orderBy = "ORDER BY prod_salerice DESC";

// Pagination
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 8;

$query = "SELECT * FROM products $where $orderBy LIMIT $offset, $limit";
$result = $database->getData($query);

if ($result && mysqli_num_rows($result) > 0) {
  while ($product = mysqli_fetch_array($result)) {
    $productId = $product['prod_id'];
    $title = htmlspecialchars($product['prod_title']);
    $price = $product['prod_salerice'];
    $image = htmlspecialchars($product['prod_featuredimage']);
    $productUrl = $url->baseUrl("product?q=$productId");
    $imageUrl = $url->baseUrl($image);

    echo "
    <div class='product-card'>
      <a href='$productUrl'>
        <img src='$imageUrl' alt='$title' />
        <div class='product-name'>$title</div>
      </a>
      <div class='price'>₹$price</div>
      <button class='add-to-cart' data-id='$productId'>Add to Cart</button>
    </div>
    ";
  }
} else {
  // When no more products, send empty response (JS handles hiding the button)
  echo '';
}
?>
