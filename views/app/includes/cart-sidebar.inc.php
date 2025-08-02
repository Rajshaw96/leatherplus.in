<?php
// product.inc.php
$url = $url ?? new UrlHelpers();
$galleryImages = explode(",", $gallery);
$shortdesc = base64_decode($shortdesc);
$desc = base64_decode($desc);
$featuredImageUrl = $url->baseUrl("uploads/product-images/$featuredimage");

// Fetch cart items
$cqty = 0;
$camt = 0;
$cartHtml = "";

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
  foreach ($_SESSION['cart'] as $prodId => $qty) {
    $prodResult = $database->getData("SELECT * FROM products WHERE prod_id = '$prodId' AND prod_status = 1");
    if ($prodResult && mysqli_num_rows($prodResult) > 0) {
      $product = mysqli_fetch_assoc($prodResult);
      $price = $product['prod_saleprice'] > 0 ? $product['prod_saleprice'] : $product['prod_regularprice'];
      $img = $url->baseUrl("uploads/product-images/" . $product['prod_featuredimage']);
      $cartHtml .= "
        <div class='cart-item'>
          <img src='$img' alt='Product'>
          <div class='flex-grow-1'>
            <div><strong>" . htmlspecialchars($product['prod_title']) . "</strong></div>
            <div class='text-muted-small'>₹$price</div>
            <div class='quantity-control'>
              <button onclick=\"updateQty($prodId,-1)\">-</button>
              <span>$qty</span>
              <button onclick=\"updateQty($prodId,1)\">+</button>
            </div>
          </div>
          <button class='remove-btn' onclick=\"removeFromCart($prodId)\">&times;</button>
        </div>
      ";
      $cqty += $qty;
      $camt += $price * $qty;
    }
  }
}
?>

<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header d-flex justify-content-between align-items-center">
    <span><i class="bi bi-cart me-2"></i>My Cart</span>
    <button class="btn-close" onclick="toggleCart()"></button>
  </div>
  <div class="info-banner">
    Add products worth <strong>₹1499</strong> and get <strong>₹350 off</strong>. Use Code: <strong>LP350</strong>
  </div>

  <?= $cartHtml ?: "<p class='text-center text-muted my-4'>Your cart is empty</p>" ?>

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
    <button class="btn-checkout">Checkout & Pay</button>
  </div>
</div>

<script>
  function updateQty(productId, change) {
    fetch("<?= $url->baseUrl('views/app/ajax/update-cart.php') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}&change=${change}`
    }).then(() => location.reload());
  }

  function removeFromCart(productId) {
    fetch("<?= $url->baseUrl('views/app/ajax/remove-from-cart.php') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}`
    }).then(() => location.reload());
  }
</script>
