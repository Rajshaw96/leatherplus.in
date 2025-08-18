<?php
// product.inc.php
$url = $url ?? new UrlHelpers();
$galleryImages = explode(",", $gallery);
$isLoggedIn = isset($_SESSION['user_id']);
$featuredImageUrl = $url->baseUrl("uploads/product-images/$featuredimage");
$reviews = [];
$reviewQuery = "SELECT * FROM product_reviews WHERE preview_prodid = ? AND preview_status = 1 ORDER BY preview_datetime DESC";
$stmt = $database->conn->prepare($reviewQuery);
$stmt->bind_param("i", $_GET['q']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
  $reviews[] = [
    'user_name' => $row['preview_nickname'],
    'rating' => $row['preview_rating'],
    'comment' => base64_decode($row['preview_content']),
    'created_at' => $row['preview_datetime']
  ];
}
?>

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars(!empty($nickname) ? $nickname : $title) ?> - Leather Plus</title>
  <meta name="description" content="Buy <?= htmlspecialchars(!empty($nickname) ? $nickname : $title) ?> online">

  <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./views/app/assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="./views/app/assets/custom-style/style.css" />
  <link rel="stylesheet" href="./views/app/assets/custom-style/about-us.css" />
  <link rel="stylesheet" href="./views/app/assets/custom-style/product-detail.css" />

  <!-- Favicon and Apple Icons -->
  <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

  <!--- jQuery -->


</head>
<?php include('includes/header-2.inc.php') ?>
<section class="product-details" style="margin-top: 90px;">
  <!-- Breadcrumb -->
  <div class="breadcrumb container-fluid px-lg-5 mt-5 mt-lg-0">
    <a href="<?= $url->baseUrl("") ?>" title="Home">Home</a>
    <span class="separator">›</span>
    <a href="<?= $url->baseUrl("shop") ?>">Products</a>
    <span class="separator">›</span>
    <a href="<?= $url->baseUrl("shop") ?>">Category</a>
    <span class="divider">|</span>
    <span class="current"><?= htmlspecialchars(!empty($nickname) ? $nickname : $title) ?></span>
  </div>

  <div class="container-fluid px-lg-5">
    <div class="row product-details-row">
      <div class="col-md-5">
        <img id="main-product-image" src="<?= $featuredImageUrl ?>" class="img-fluid mb-3 product-image" />
        <div class="product-img-thumb d-flex">
          <?php foreach ($galleryImages as $img): ?>
            <img src="<?= $url->baseUrl('uploads/product-gallery/' . trim($img)) ?>" class="thumbnail">
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-md-7">
        <h2 class="product-title mt-4 mt-lg-0">
          <?= htmlspecialchars(!empty($nickname) ? $nickname : $title) ?>
        </h2>

        <p class="price">
          <?php
          $regularFormatted = number_format((float) $regularprice, 1);

          if ($saleprice > 0) {
            // Show regular with strike + sale price
            $saleFormatted = number_format((float) $saleprice, 1);
            echo "<del>₹$regularFormatted</del>
            <span style='color: #5c2e0f;font-size:22px;margin-left:10px;'>
              ₹$saleFormatted
            </span>";
          } else {
            // Show only regular price (no strike, no discount)
            echo "<span style='color: #5c2e0f;font-size:22px;'>₹$regularFormatted</span>";
          }
          ?>
        </p>


        <?php
        $total_reviews = count($reviews);
        if ($total_reviews > 0) {
          $average_rating = round(array_sum(array_column($reviews, 'rating')) / $total_reviews, 1);
          $full_stars = floor($average_rating);
          $half_star = ($average_rating - $full_stars) >= 0.5;
          $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
        } else {
          // Dummy 5-star rating
          $full_stars = 5;
          $half_star = false;
          $empty_stars = 0;
        }
        ?>
        <div class="rating mb-2 text-warning">
          <?php for ($i = 0; $i < $full_stars; $i++): ?>
            <i class="fas fa-star"></i>
          <?php endfor; ?>
          <?php if ($half_star): ?>
            <i class="fas fa-star-half-alt"></i>
          <?php endif; ?>
          <?php for ($i = 0; $i < $empty_stars; $i++): ?>
            <i class="far fa-star"></i>
          <?php endfor; ?>
          <span class="ms-2 text-muted">| <?= $total_reviews ?> Customer
            Review<?= $total_reviews !== 1 ? 's' : '' ?></span>
        </div>
        <hr style="color: #00000059;margin: 30px 0;">

        <p>
          <?= !empty(trim($shortdesc)) ? $shortdesc : "Leather Plus is a premier manufacturer of high-quality leather belts and suspenders, renowned for its craftsmanship and dedication to excellence. Combining traditional techniques with modern innovations, Leather Plus offers a diverse range of products that cater to both classic and contemporary tastes. Each leather belt and pair of suspenders is meticulously crafted from the finest materials, ensuring durability and a sophisticated finish." ?>
        </p>


        <div class="mb-3">
          <span class="size">Size</span>
          <div class="pt-3" id="size-options" style="display: flex; flex-wrap: wrap;">
            <?php
            $sizes = [];

            $attrId = isset($prod_attributes) ? $prod_attributes : null;

            if (!empty($attrId)) {
              $sizeQuery = "SELECT pattribterm_name FROM product_attributes_terms WHERE pattribterm_attribid = ?";
              $stmt = $database->conn->prepare($sizeQuery);
              if ($stmt) {
                $stmt->bind_param("i", $attrId);
                $stmt->execute();
                $res = $stmt->get_result();

                while ($row = $res->fetch_assoc()) {
                  $sizes[] = $row['pattribterm_name'];
                }
              }
            }

            // Output size options
            if (!empty($sizes)) {
              sort($sizes, SORT_NATURAL | SORT_FLAG_CASE); // Sorts sizes naturally like S, M, L, XL, etc.
              $defaultSize = $sizes[0];

              foreach ($sizes as $size) {
                $isActive = $size === $defaultSize ? "active" : "";
                echo "<span class='size-btn $isActive' data-size='" . htmlspecialchars($size) . "'>" . htmlspecialchars($size) . "</span>";
              }
            } else {
              echo "<span class='size-btn active' data-size='One Size'>One Size</span>";
            }

            ?>
          </div>




        </div>
        <!-- <div class="mb-3">
          <span class="color">Color</span>
          <div id="color-options">
            <span class="color-dot" style="background-color:#000"></span>
            <span class="color-dot" style="background-color:#563d7c"></span>
            <span class="color-dot" style="background-color:#8C6239"></span>
          </div>
        </div> -->

        <div class="product-action">
          <div class="quantity-selector">
            <button class="qty-btn" onclick="changeQty(-1)">−</button>
            <span class="qty-value" id="qty">1</span>
            <button class="qty-btn" onclick="changeQty(1)">+</button>
          </div>

          <div class="cart-button-container">
            <!-- <button class="cart-button" onclick="addToCart(<?= $product['prod_id'] ?>)"> -->
            <button class="cart-button" onclick="addToCart(<?= $_GET['q'] ?>)">

              <span class="cart-icon">🛒</span>
              Add to Cart
            </button>
          </div>
        </div>
        <!-- Highlight Section Starts -->
        <div class="product-highlights mt-4 d-flex flex-column flex-md-row justify-content-between gap-3">
          <div class="highlight-item text-center flex-fill d-flex flex-column align-items-center"
            style="background-color: #fcfcf5;padding: 40px 20px;color: #5c2e0f;">
            <i class="fas fa-box fa-2x " style="color: #5c2e0f"></i>
            <span class="mt-2 mb-0 fw-semibold">100% Genuine Leather</span>
          </div>
          <div class="highlight-item text-center flex-fill d-flex flex-column align-items-center"
            style="background-color: #fcfcf5;padding: 40px 20px;color: #5c2e0f;">
            <i class="fas fa-truck fa-2x " style="color: #5c2e0f"></i>
            <span class="mt-2 mb-0 fw-semibold">Free Shipping over ₹1500</span>
          </div>
          <div class="highlight-item text-center flex-fill d-flex flex-column align-items-center"
            style="background-color: #fcfcf5;padding: 40px 20px;color: #5c2e0f;">
            <i class="fas fa-headset fa-2x " style="color: #5c2e0f"></i>
            <span class="mt-2 mb-0 fw-semibold">24/7 Support</span>
          </div>
        </div>
        <!-- Highlight Section Ends -->


      </div>
    </div>

    <br>
    <div class="container-fluid main-product-dec px-lg-5 ">
    </div>

    <!-- About Product -->
    <div class="mt-5">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#about">About Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews</a>
        </li>

      </ul>
      <div class="tab-content p-3 border border-top-0">
        <div class="tab-pane fade show active" id="about">
          <ul class="about-product" style="padding: 0;">
            <li><strong>Product Code:</strong> <?= $sku ?></li>
            <li><strong>Type:</strong> <?= $type === 'A' ? 'Autolock' : 'Standard' ?></li>
            <li><strong>Warranty:</strong> 3 months</li>
            <li><strong>Care Instructions:</strong> Wipe with a clean dry cloth...</li>
          </ul>
        </div>
        <div class="tab-pane fade" id="reviews">
          <!-- Reviews List -->
          <div class="reviews-list mb-4">
            <?php if (!empty($reviews)): ?>
              <?php foreach ($reviews as $review): ?>
                <div class="review mb-3 border-bottom pb-2">
                  <strong><?= htmlspecialchars($review['user_name']) ?></strong>
                  <p class="text-muted mb-1"><?= date("F j, Y", strtotime($review['created_at'])) ?></p>
                  <p class="text-warning mb-1">
                    <?= str_repeat("★", $review['rating']) ?>
                    <?= str_repeat("☆", 5 - $review['rating']) ?>
                  </p>
                  <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                </div>
              <?php endforeach; ?>

            <?php else: ?>
              <p>No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>
          </div>

          <!-- Review Form -->
          <?php if ($isLoggedIn): ?>
            <div class="review-form">
              <h5 class="mb-3">Write a Review</h5>
              <form id="review-form">
                <div class="mb-3">
                  <label class="form-label d-block mb-2">Your Rating</label>
                  <div class="rating-stars">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                  </div>
                  <input type="hidden" id="rating-value" name="rating" value="0" required>
                  <textarea class="form-control" id="review-text" rows="4" placeholder="Your review..."
                    required></textarea>
                  <input type="hidden" name="product_id" value="<?= $_GET['q'] ?>">

                </div>
                <button type="submit" class="apply-button">Submit Review</button>
              </form>
            </div>
          <?php else: ?>
            <p><a href="<?= $url->baseUrl('login') ?>">Log in</a> to write a review.</p>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <br>
    <div class="container-fluid main-product-dec px-lg-5 ">
    </div>
  </div>
  <!-- Toast Container -->
  <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="toast-message" class="toast align-items-center text-white bg-success border-0" role="alert"
      aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toast-body">
          <!-- Message will appear here -->
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
          aria-label="Close"></button>
      </div>
    </div>
  </div>

</section>

<?php include('includes/our-product.inc.php') ?>
<?php include('includes/footer.inc.php') ?>

<!-- Interactivity Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function showToast(message, isSuccess = true, duration = null, callback = null) {
    const toastElement = document.getElementById("toast-message");
    const toastBody = document.getElementById("toast-body");

    toastBody.textContent = message;

    // Set toast style based on success/failure
    toastElement.classList.remove("bg-success", "bg-danger");
    toastElement.classList.add(isSuccess ? "bg-success" : "bg-danger");

    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    if (duration !== null && !isNaN(duration)) {
      setTimeout(() => {
        toast.hide(); // hide manually if duration specified
        if (typeof callback === 'function') callback();
      }, duration);
    }
  }


  function changeQty(amount) {
    const qtySpan = document.getElementById('qty');
    let qty = parseInt(qtySpan.textContent);
    qty += amount;
    if (qty < 1) qty = 1;
    qtySpan.textContent = qty;
  }

  function addToCart(productId) {
    const qty = parseInt(document.getElementById('qty').textContent);
    const selectedSizeBtn = document.querySelector('.size-btn.active');

    if (!selectedSizeBtn) {
      showToast("Please select a size before adding to cart.", false);
      // alert("Please select a size before adding to cart.");
      return;
    }

    const size = selectedSizeBtn.getAttribute('data-size');

    fetch("<?= $url->baseUrl('views/app/ajax/add-to-cart.php') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}&quantity=${qty}&size=${size}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // alert("Added to cart successfully!");
          showToast("Added to cart successfully!", true);
          const cartCountDesktop = document.getElementById("cart-count");
          const cartCountMobile = document.getElementById("cart-count-mobile");

          if (cartCountDesktop) cartCountDesktop.textContent = data.cart_count;
          if (cartCountMobile) cartCountMobile.textContent = data.cart_count;
        } else {
          // alert("Something went wrong.");
          showToast("Something went wrong.", false);
        }
      });
  }



  document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });

  document.querySelectorAll('.color-dot').forEach(dot => {
    dot.addEventListener('click', function () {
      document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
      this.classList.add('active');
    });
  });

  const mainImage = document.getElementById('main-product-image');
  document.querySelectorAll('.product-img-thumb img').forEach(thumb => {
    thumb.addEventListener('click', function () {
      mainImage.src = this.src;
    });
  });
  document.getElementById("review-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const productId = document.querySelector('[name="product_id"]').value;
    const rating = document.getElementById("rating-value").value;
    const content = document.getElementById("review-text").value;

    fetch("<?= $url->baseUrl('views/app/ajax/save-review.php') ?>", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `product_id=${productId}&rating=${rating}&content=${encodeURIComponent(content)}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showToast("Review submitted!", true, 2000, () => location.reload());

          // alert("Review submitted!");
          // location.reload(); // Reload to show the review
        } else {
          showToast("Failed to submit review.", true);
          // alert("Failed to submit review.");
        }
      });
  });
</script>