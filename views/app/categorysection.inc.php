<section class="discover-Section">
  <div class="container-fluid px-lg-5">
    <div class="mb-5 text-md-start text-start mt-5">
      <h2 class="fw-bold">Browse The Range</h2>
      <p class="text-muted">Discover the perfect fusion of elegance and functionality with our best material.</p>
    </div>

    <div class="row g-4">
      <?php
      $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

      if ($result_categories != false) {
        while ($category = mysqli_fetch_array($result_categories)) {
          $categoryId = $category['pcat_id'];
          $categoryName = htmlspecialchars($category['pcat_name']);
          $imagePath = "./views/app/assets/images/default.jpg"; // fallback

          if (file_exists("./views/app/assets/images/Category ($categoryId).png")) {
            $imagePath = "./views/app/assets/images/Category ($categoryId).png";
          }

          $shopUrl = $url->baseUrl("shop?cat=$categoryId");
          ?>
          <div class="col-12 col-sm-6 col-md-4">
            <a href="<?= $shopUrl ?>" class="text-decoration-none">
              <div class="card border-0 rounded-4">
                <img src="<?= $imagePath ?>" alt="<?= $categoryName ?>" class="card-img-top rounded-4" />
                <div class="mt-4">
                  <h6 class="fw-bold mb-0 text-decoration-none"><?= $categoryName ?></h6>
                </div>
              </div>
            </a>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</section>
