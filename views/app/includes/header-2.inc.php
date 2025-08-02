<!-- Navbar -->

<head>
  <!-- Bootstrap 5 CSS -->
  <!-- <link rel="stylesheet" href="./views/app/assets/css/style.css"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons CDN -->

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
    rel="stylesheet">

</head>
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #fdfcf5; padding: 20px 0;">
  <div class="container-fluid px-lg-5"
    style="padding: 0 10px; display: flex; justify-content: space-between; align-items: center;">

    <!-- Logo -->
    <a class="navbar-brand d-none d-lg-flex justify-content-center align-items-center" href="<?= $url->baseUrl("") ?>">
      <img src="./views/app/assets/images/leatherplus_logo.png" alt="LeatherPlus1" style="height: 35px;">
    </a>
    <?php
    $cqty = 0;

    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $qty) {
        $cqty += intval($qty);
      }

    }
    ?>
    <!-- Toggle + Icons (Mobile View) -->
    <!-- Top Mobile Row -->
    <div class="d-flex d-lg-none align-items-center justify-content-between w-100 px-3 mb-2">
      <!-- Left: Hamburger -->
      <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="bi bi-list fs-3"></i>
      </button>

      <!-- Center: Logo -->
      <a class="navbar-brand" href="<?= $url->baseUrl("") ?>" style="margin-left: 40px;">
        <img src="<?= $url->baseUrl("views/app/assets/images/leatherplus_logo.png") ?>" alt="LeatherPlus"
          style="height: 30px;">
      </a>

      <!-- Right: User + Cart -->
      <div class="d-flex align-items-center">
        <a href="<?= $url->baseUrl("login") ?>" class="text-secondary me-3"><i class="bi bi-person "
            style="font-size:20px;display:block;"></i></a>
        <a href="#" class="text-secondary" onclick="toggleCart()"><i class="bi bi-cart fs-5 position-relative"></i><span
            id="cart-count-mobile" class="position-absolute badge "
            style="font-size: 0.6rem; background-color:  #582F0E; border-radius: 50% !important; padding: 0.2rem 0.3rem !important;color: #fff !important;top: 22px;">
            <?= $cqty ?>
          </span></a>
      </div>
    </div>

    <!-- Mobile Search Bar -->
    <div class="d-lg-none w-100 px-3 mb-2">
      <div class="input-group rounded-pill overflow-hidden border" style="background-color: #e6f0ff;">
        <span class="input-group-text border-0 " style="background-color: #DAD7CD;">
          <i class="bi bi-search"></i>
        </span>
        <input type="text" id="navbarSearch" class="form-control border-0 " style="background-color: #DAD7CD;"
          placeholder='Search for "wallets"'>
      </div>
    </div>


    <!-- Collapsible Menu -->
    <div class="collapse navbar-collapse justify-content-between mt-2" id="navbarContent">

      <!-- ✖ Close Button (only visible on mobile) -->
      <div class="d-lg-none text-end w-100">
        <button type="button" class="btn-close mb-2" aria-label="Close" onclick="closeNavbar()"
          style="font-size: 1.2rem;"></button>

      </div>

      <ul class="navbar-nav mx-auto mb-1 mb-lg-0 gap-lg-3 gap-2 text-start" id="toggleMenu">
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="<?= $url->baseUrl('') ?>">Home</a>
        </li>
        <!-- Mobile Shop Menu -->
        <li class="nav-item d-lg-none">
          <a class="nav-link text-secondary fw-medium d-flex justify-content-between align-items-center" href="#"
            id="shopToggleMobile">
            Shop
            <i class="bi bi-chevron-down small ms-1"></i>
          </a>

          <div class="px-4 pt-4 d-none" id="mobileShopMenu">
            <?php
            $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");
            $parentIndex = 0;

            if ($result_categories) {
              while ($parent = mysqli_fetch_assoc($result_categories)) {
                $parentId = $parent['pcat_id'];
                $parentName = htmlspecialchars($parent['pcat_name']);
                $collapseId = "subcat-$parentId";

                echo '<div class="mb-2 border-bottom pb-2">';
                echo '<div class="d-flex justify-content-between align-items-center parent-category-toggle" data-target="' . $collapseId . '" style="cursor:pointer;">';
                echo '<a href="' . $url->baseUrl("shop?cat=$parentId") . '" class="text-secondary fw-medium text-decoration-none">' . $parentName . '</a>';
                echo '<i class="bi bi-chevron-down small ms-1 text-secondary"></i>';
                echo '</div>';

                $result_subcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = '$parentId' ORDER BY `pcat_menuorder` ASC");

                echo '<div class="ps-3 mt-1 d-none" id="' . $collapseId . '">';
                if ($result_subcategories && mysqli_num_rows($result_subcategories) > 0) {
                  echo '<ul class="list-unstyled mb-1">';
                  while ($child = mysqli_fetch_assoc($result_subcategories)) {
                    $childId = $child['pcat_id'];
                    $childName = htmlspecialchars($child['pcat_name']);
                    echo '<li class="mb-1"><a class="text-secondary text-decoration-none small" href="' . $url->baseUrl("shop?cat=$childId") . '">' . $childName . '</a></li>';
                  }
                  echo '</ul>';
                } else {
                  echo '<small class="text-muted">No subcategories</small>';
                }
                echo '</div>';
                echo '</div>';
              }
            }
            ?>
          </div>
        </li>





        <li class="nav-item dropdown position-static mega-dropdown d-none d-lg-block">
          <a class="nav-link text-secondary fw-medium dropdown-toggle" href="<?= $url->baseUrl('shop') ?>"
            role="button">
            Shop
          </a>

          <div class="dropdown-menu w-100 mt-0 shadow-sm mega-menu"
            style="border: none;margin-top: -25px !important;background-color: #fcfcf5;padding-top: 80px !important;">
            <div class="row">
              <?php
              $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

              if ($result_categories) {
                while ($parent = mysqli_fetch_assoc($result_categories)) {
                  $parentId = $parent['pcat_id'];
                  $parentName = htmlspecialchars($parent['pcat_name']);

                  echo '<div class="col-lg-2">';
                  echo '<h6 class="text-uppercase text-muted small mega-parent-category-title">
        <a href="' . $url->baseUrl("shop?cat=$parentId") . '" class="text-decoration-none text-muted">' . $parentName . '</a>
      </h6>';
                  echo '<ul class="list-unstyled">';

                  $result_subcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = '$parentId' ORDER BY `pcat_menuorder` ASC");

                  if ($result_subcategories && mysqli_num_rows($result_subcategories) > 0) {
                    while ($child = mysqli_fetch_assoc($result_subcategories)) {
                      $childId = $child['pcat_id'];
                      $childName = htmlspecialchars($child['pcat_name']);
                      echo '<li><a href="' . $url->baseUrl("shop?cat=$childId") . '">' . $childName . '</a></li>';
                    }
                  } else {
                    echo '<li><small class="text-muted">No subcategories</small></li>';
                  }

                  echo '</ul>';
                  echo '</div>';
                }
              }
              ?>
            </div>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="<?= $url->baseUrl('about') ?>">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="<?= $url->baseUrl('contact') ?>">Contact</a>
        </li>
      </ul>


      <!-- Desktop Right Icons -->
      <div id="width-dynamic" class="d-flex align-items-center d-none d-lg-flex icons-header"
        style="margin-top:4px;margin-bottom: 5px;">
        <div class="d-flex me-3 gap-4 w-100" id="desktopSearchWrapper">
          <input type="text" id="desktopSearchInput" class="form-control form-control-sm  d-none"
            placeholder='Search products...' style="width: 100%; z-index: 1000;">
          <a href="#" class="text-secondary" id="desktopSearchIcon">
            <i class="bi bi-search"></i>
          </a>
        </div>

        <a href="#" class="text-secondary me-3 position-relative" onclick="toggleCart()"><i class="bi bi-cart ">
            <span id="cart-count" class="position-absolute top-0 bg-logo-col cart-counter "><?= $cqty ?></span>
          </i></a>
        <a href="<?= $url->baseUrl("login") ?>" class="text-secondary"><i class="bi bi-person "></i></a>
      </div>
    </div>
  </div>
</nav>
<!-- Preloader -->
<div id="preloader">
  <div class="loader"></div>
</div>

<!-- Cart Sidebar -->
<?php
$url = $url ?? new UrlHelpers();
if (isset($gallery, $shortdesc, $desc, $featuredimage)) {
  $galleryImages = explode(",", $gallery);
  $shortdesc = base64_decode($shortdesc);
  $desc = base64_decode($desc);
  $featuredImageUrl = $url->baseUrl("uploads/product-images/$featuredimage");
}


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
  <div id="cart-content"></div>
</div>




<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <button type="button" class="close-button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
      <div class="form-side">
        <div class="brand-logo mb-4">Leather<span>Plus</span></div>
        <h3 class="fw-bold">Log In</h3>
        <p class="text-muted">Welcome Back! Please enter your credentials.</p>
        <form>
          <div class="mb-1">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" placeholder="robertfox@example.com" />
          </div>
          <div class="mb-1">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="••••••••••••••••••" />
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>
            <a href="#" class="text-green">Forgot Password?</a>
          </div>
          <button type="submit" class="btn btn-brown-login w-100">Login</button>
          <p class="text-center mt-3">Don’t have an account? <a href="#" class="text-green">Create Now</a></p>
        </form>
      </div>
      <div class="image-side"></div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function updateQty(productId, change) {
    fetch("<?= $url->baseUrl('views/app/ajax/update-cart.php') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}&change=${change}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          // Optionally, update the DOM here for the specific item and subtotal
          refreshCart(); // Call function to re-render cart HTML via AJAX
        }
      });
  }


  function removeFromCart(productId) {
    fetch("<?= $url->baseUrl('views/app/ajax/remove-from-cart.php') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `product_id=${productId}`
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          refreshCart(); // Refresh cart HTML without page reload
        }
      });
  }
  function refreshCart() {
    fetch("<?= $url->baseUrl('views/app/ajax/fetch-cart-html.php') ?>")
      .then(res => res.text())
      .then(html => {
        const cartContent = document.getElementById("cart-content");
        if (cartContent) {
          cartContent.innerHTML = html;

          // ✅ Scoped selection
          const newCountEl = cartContent.querySelector("[data-cart-count]");
          const countDesktop = document.getElementById("cart-count");
          const countMobile = document.getElementById("cart-count-mobile");

          if (newCountEl) {
            const countValue = newCountEl.getAttribute("data-cart-count");
            if (countDesktop) countDesktop.innerText = countValue;
            if (countMobile) countMobile.innerText = countValue;
          }
        }
      });
  }



  document.getElementById('desktopSearchIcon').addEventListener('click', function (e) {
    e.preventDefault();
    const input = document.getElementById('desktopSearchInput');
    const input2 = document.getElementById('toggleMenu');
    const input3 = document.getElementById('width-dynamic');
    input.classList.toggle('d-none');
    input2.classList.toggle('d-none');
    input3.classList.toggle('w-100');
    input.focus();
  });

  document.getElementById('desktopSearchInput').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const query = e.target.value.trim();
      if (query !== '') {
        window.location.href = "<?= $url->baseUrl('shop?search=') ?>" + encodeURIComponent(query);
      }
    }
  });


</script>
<script>
  // Toggle the main "Shop" dropdown
  document.getElementById('shopToggleMobile').addEventListener('click', function (e) {
    e.preventDefault();
    const shopMenu = document.getElementById('mobileShopMenu');
    shopMenu.classList.toggle('d-none');
  });

  // Toggle each parent category to show/hide subcategories
  document.querySelectorAll('.parent-category-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
      const targetId = this.getAttribute('data-target');
      const subMenu = document.getElementById(targetId);
      if (subMenu) {
        subMenu.classList.toggle('d-none');
        // Optionally toggle icon
        const icon = this.querySelector('i');
        if (icon) {
          icon.classList.toggle('bi-chevron-down');
          icon.classList.toggle('bi-chevron-up');
        }
      }
    });
  });
</script>

<script>
  function toggleCart() {
    const sidebar = document.getElementById("cartSidebar");
    const wasOpen = sidebar.classList.contains("open");

    sidebar.classList.toggle("open");

    // ✅ Always update cart count — even on close
    refreshCart();

    // ❌ (optional) if you don’t want to reload full cart contents when closing
    // you can conditionally do this:
    // if (!wasOpen) refreshCart();
  }


  function closeNavbar() {
    const navbarCollapse = document.getElementById('navbarContent');
    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
    if (bsCollapse) {
      bsCollapse.hide();
    }
  }
  document.getElementById('navbarSearch').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const query = e.target.value.trim();
      if (query !== '') {
        window.location.href = "<?= $url->baseUrl('shop?search=') ?>" + encodeURIComponent(query);
      }
    }
  });
  document.getElementById('desktopSearchInput').addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      const query = e.target.value.trim();
      if (query !== '') {
        window.location.href = "<?= $url->baseUrl('shop?search=') ?>" + encodeURIComponent(query);
      }
    }
  });

  const dropdown = document.querySelector('.mega-dropdown');

  // Optional: disable mega-menu on small screens
  if (window.innerWidth > 992) {
    dropdown.addEventListener('mouseenter', () => {
      dropdown.classList.add('show');
      dropdown.querySelector('.dropdown-menu').classList.add('show');
    });

    dropdown.addEventListener('mouseleave', () => {
      dropdown.classList.remove('show');
      dropdown.querySelector('.dropdown-menu').classList.remove('show');
    });
  }


</script>