<?php
session_start();

// Include dependencies
include("../../../lib/config/config.php"); 
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');

$url = new UrlHelpers();
$database = new DatabaseOps();

// DB Connection
$conn = $database->createConnection();
if (!$conn) {
  echo "<p class='text-danger'>Database connection failed.</p>";
  exit;
}

$cqty = 0;
$camt = 0;
$cartHtml = "";

if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $prodId = $item['product_id'];
    $qty    = $item['qty'];
    $size   = $item['size'] ?? '';
    $name   = $item['name'] ?? '';

    $res = $database->getData("SELECT * FROM products WHERE prod_id = '$prodId' AND prod_status = 1");
    if ($res && mysqli_num_rows($res) > 0) {
      $p = mysqli_fetch_assoc($res);
      $price = $p['prod_saleprice'] > 0 ? $p['prod_saleprice'] : $p['prod_regularprice'];
      $img   = $url->baseUrl("uploads/product-images/" . $p['prod_featuredimage']);

      $cartHtml .= "
        <div class='cart-item'>
          <img src='$img' alt='Product'>
          <div class='flex-grow-1'>
            <div><strong>" . htmlspecialchars($name ?: $p['prod_title']) . "</strong></div>
            " . (!empty($size) ? "<div class='text-muted-small'>Size: " . htmlspecialchars($size) . "</div>" : "") . "
            <div class='text-muted-small'>₹$price</div>
            <div class='quantity-control'>
              <button onclick=\"updateQty($prodId,-1,'$size')\">-</button>
              <span>$qty</span>
              <button onclick=\"updateQty($prodId,1,'$size')\">+</button>
            </div>
          </div>
          <button class='remove-btn' onclick=\"removeFromCart($prodId,'$size')\">&times;</button>
        </div>
      ";

      $cqty += $qty;
      $camt += $price * $qty;
    }
  }
}
?>

<!-- This output is injected inside #cart-content -->

<div class="cart-header d-flex justify-content-between align-items-center">
  <span><i class="bi bi-cart me-2"></i>My Cart</span>
  <button class="btn-close" onclick="toggleCart()"></button>
</div>

<?= $cartHtml ?: "<p class='text-center text-muted my-4'>Your cart is empty</p>" ?>

<hr>

<div class="summary-box">
  <div class="discount-code">
    <input type="text" placeholder="Apply Discount Code" class="form-control" />
    <a href="#"><img src="<?= $url->baseUrl('views/app/assets/images/cart-arrow-icon.png') ?>" alt=""></a>
  </div>
  <div class="subtotal-line d-flex justify-content-between"><span class="text-muted-small">Shipping</span><span>Free</span></div>
  <div class="subtotal-line d-flex justify-content-between"><span class="text-muted-small">Discount</span><span>₹0</span></div>
  <hr>
  <div class="subtotal-line d-flex justify-content-between">
    <strong>Subtotal (<?= $cqty ?> items)</strong>
    <strong>₹<?= $camt ?></strong>
  </div>
  <a href="<?= $url->baseUrl("checkout")?>"><button class="btn-checkout">Checkout & Pay</button></a>
</div>
<span data-cart-count="<?= $cqty ?>" style="display:none;"></span>

<!-- Update cart count badge in header -->
<script>
  const cartCountEl = document.getElementById("cart-count");
  if (cartCountEl) {
    cartCountEl.innerText = <?= $cqty ?>;
  }
</script>
