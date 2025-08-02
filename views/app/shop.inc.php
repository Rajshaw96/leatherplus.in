<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <title>Shop - Leather Plus</title>
  <meta name="description" content="Login to your Leather Plus Account">

  <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>">
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>">
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/product.css") ?>">

  <!-- Favicon and Apple Icons -->
  <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

  <!--- jQuery -->




</head>

<body>
  <div style="margin-top: 60px;">

    <?php include('includes/header-2.inc.php') ?>
    <?php
    $initialCategory = isset($_GET['cat']) ? intval($_GET['cat']) : null;
    ?>

    <div class="banner">
      <div class="row">
        <h4>Shop</h4><br>
        <h2>Collection</h2>
      </div>
    </div>
    <section class="container-fluid px-lg-5 pb-0 pb-lg-5">
      <div class="breadcrumb">
        <a href="<?= $url->baseUrl("shop") ?>" style="text-decoration: none;" title="Shop">Shop</a> <span
          class="separator">›</span> <span class="breadcrumb-item active">Products</span>
      </div>
      <div class="product-container">
        <form id="filterForm" class="filters">

          <h3>Filters <span class="clear-filter" onclick="clearFilters()">Clear all</span></h3>

          <?php
          $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

          if ($result_categories != false) {
            while ($categories = mysqli_fetch_array($result_categories)) {
              $catId = $categories['pcat_id'];
              $catName = htmlspecialchars($categories['pcat_name']);

              // Count products under parent category too
              $parentCountQuery = $database->getData("
        SELECT COUNT(*) as count 
        FROM products 
        WHERE prod_status = 1 AND FIND_IN_SET('$catId', REPLACE(prod_cats, ' ', ''))
    ");
              $parentCountRow = mysqli_fetch_array($parentCountQuery);
              $parentCount = $parentCountRow['count'] ?? 0;

              echo "<details open>";
              echo "<summary>$catName</summary>";
              echo "<div class='checkbox-group'>";

              // Parent category checkbox
              echo "<label>
        <input type='checkbox' name='category[]' value='$catId'>
        $catName ($parentCount)
    </label>";

              // Subcategories
              $result_childcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = '$catId' ORDER BY `pcat_menuorder` ASC");

              if ($result_childcategories && mysqli_num_rows($result_childcategories) > 0) {
                while ($child = mysqli_fetch_array($result_childcategories)) {
                  $childId = $child['pcat_id'];
                  $childName = htmlspecialchars($child['pcat_name']);

                  $countQuery = $database->getData("
                SELECT COUNT(*) as count 
                FROM products 
                WHERE prod_status = 1 AND FIND_IN_SET('$childId', REPLACE(prod_cats, ' ', ''))
            ");
                  $countRow = mysqli_fetch_array($countQuery);
                  $count = $countRow['count'] ?? 0;

                  echo "<label>
                <input type='checkbox' name='subcategory[]' value='$childId'>
                $childName ($count)
            </label>";
                }
              } else {
                echo "<small>No subcategories</small>";
              }

              echo "</div></details>";
            }

          }
          ?>

          <details open class="d-flex flex-column gap-2">
            <summary>Price</summary>
            <input type="number" name="min_price" id="min_price" placeholder="Min">
            <input type="number" name="max_price" id="max_price" placeholder="Max" class="mt-2">
            <button type="button" id="applyPriceFilter" class="d-block mt-2 apply-button">Apply</button>
          </details>


          <div class="sort-bar mt-3">
            <select name="sort" class="form-select">
              <option value="featured">Sort by: Featured</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
            </select>
          </div>
        </form>
        <!-- Product Grid -->
        <div class="main">
          <div id="product-listing" class="products">
            <!-- Fetched via AJAX -->

          </div>
          <!-- <div class="show-more text-center mt-4">
            <button id="loadMoreBtn" onclick="loadMore()">Show More</button>
          </div> -->
        </div>
      </div>



    </section>





    <?php include('includes/footer.inc.php') ?>

  </div><!-- End #wrapper -->

  <!-- scroltop -->
  <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

  <!-- END -->
  <!-- <script>
    document.querySelectorAll('#filterForm input, #filterForm select').forEach(el => {
      el.addEventListener('change', () => {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);

        // ✅ Include search query from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        const search = urlParams.get('search');
        if (search) {
          formData.append('search', search);
        }

        fetch('views/app/ajax/filter-products.php', {
          method: 'POST',
          body: formData
        })
          .then(res => res.text())
          .then(data => {
            const grid = document.getElementById('productGrid');
            if (grid) grid.innerHTML = data;
          });
      });
    });


    function clearFilters() {
      document.getElementById('filterForm').reset();
      const event = new Event('change');
      document.querySelector('#filterForm select').dispatchEvent(event);
    }

    // Initial load
    document.querySelector('#filterForm select').dispatchEvent(new Event('change'));
  </script> -->
  <!-- <script>
    const filterForm = document.getElementById('filterForm');
    const productGrid = document.getElementById('productGrid');

    // function fetchFilteredProducts() {
    //   const formData = new FormData(filterForm);

    //   // Include search from URL if any
    //   const urlParams = new URLSearchParams(window.location.search);
    //   const search = urlParams.get('search');
    //   if (search) formData.append('search', search);

    //   fetch('views/app/ajax/filter-products.php', {
    //     method: 'POST',
    //     body: formData
    //   })
    //     .then(res => res.text())
    //     .then(data => {
    //       productGrid.innerHTML = data;
    //     });
    // }

    // Trigger on change for checkboxes and sort select (excluding price inputs)
    // document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm select').forEach(el => {
    //   el.addEventListener('change', fetchFilteredProducts);
    // });

    // Price filter triggered only by Apply button
    document.getElementById('applyPriceFilter').addEventListener('click', fetchFilteredProducts);

    // Clear Filters
    function clearFilters() {
      filterForm.reset();
      fetchFilteredProducts();
    }

    // Bind clear button
    document.querySelector('.clear-filter').addEventListener('click', clearFilters);

    // Initial load
    // fetchFilteredProducts();
  </script> -->
  <script>
    let offset = 0;
    const limit = 8;
    const productListing = document.getElementById("product-listing");
    const loadMoreBtn = document.getElementById("loadMoreBtn");

    function loadMore() {
      loadMoreBtn.disabled = true; // Disable button during fetch

      const formData = new FormData(document.getElementById("filterForm"));
      formData.append("offset", offset);
      formData.append("limit", limit);

      fetch("views/app/ajax/filter-products.php", {
        method: "POST",
        body: formData
      })
        .then(res => res.text())
        .then(html => {
          if (html.trim() !== "") {
            productListing.insertAdjacentHTML("beforeend", html);
            offset += limit;
            loadMoreBtn.disabled = false; // Re-enable if more to load
          } else {
            loadMoreBtn.style.display = "none"; // Hide if no more products
          }
        })
        .catch(err => {
          console.error("Error fetching products:", err);
          loadMoreBtn.disabled = false;
        });
    }

    // Initial load
    document.addEventListener("DOMContentLoaded", function () {
      loadMore();
    });

    // Reload filtered products and reset pagination
    function reloadProductsOnFilterChange() {
      offset = 0;
      productListing.innerHTML = "";
      loadMoreBtn.style.display = "block";
      loadMoreBtn.disabled = false;
      loadMore();
    }

    // Bind all filter elements
    document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm select').forEach(el => {
      el.addEventListener('change', reloadProductsOnFilterChange);
    });

    document.getElementById('applyPriceFilter').addEventListener('click', reloadProductsOnFilterChange);
  </script>


  <script>
    const filterForm = document.getElementById('filterForm');
    const productGrid = document.getElementById('product-listing');

    function fetchFilteredProducts() {
      const formData = new FormData(filterForm);

      // Include search from URL if any
      const urlParams = new URLSearchParams(window.location.search);
      const search = urlParams.get('search');
      if (search) formData.append('search', search);

      fetch('views/app/ajax/filter-products.php', {
        method: 'POST',
        body: formData
      })
        .then(res => res.text())
        .then(data => {
          productGrid.innerHTML = data;
        });
    }

    // Trigger on change for checkboxes and sort select (excluding price inputs)
    document.querySelectorAll('#filterForm input[type="checkbox"], #filterForm select').forEach(el => {
      el.addEventListener('change', fetchFilteredProducts);
    });

    // Price filter triggered only by Apply button
    document.getElementById('applyPriceFilter').addEventListener('click', fetchFilteredProducts);

    // Clear Filters
    function clearFilters() {
      filterForm.reset();
      fetchFilteredProducts();
    }

    // Bind clear button
    document.querySelector('.clear-filter').addEventListener('click', clearFilters);

    // Initial load
    fetchFilteredProducts();
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const selectedCat = <?= json_encode($initialCategory) ?>;

      if (selectedCat) {
        // Find and check the matching subcategory checkbox
        const checkbox = document.querySelector(`#filterForm input[type="checkbox"][value="${selectedCat}"]`);
        if (checkbox) {
          checkbox.checked = true;
          checkbox.dispatchEvent(new Event('change'));
        }
      }
    });
  </script>





</body>

</html>