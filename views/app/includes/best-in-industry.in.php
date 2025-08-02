<section id="hide-on-mobile" class="py-5" style="background-color: #FCF8F3;">
  <div class="container-fluid px-lg-5">
    <div class="hero">
      <div class="hero-text">
        <h4>Best in Industry</h4>
        <h1>Best Leather Products</h1>
        <p>Discover the perfect fusion of elegance and functionality with our best material.</p>
        <button class="explore-btn">Explore More</button>
      </div>
      <div class="carousel-controls">
        <button id="controller" class="control-btn  prev">&#8592;</button>
        <button id="controller" class="control-btn control-btn  next">&#8594;</button>
      </div>
    </div>

    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <?php
        if ($connStatus == true) {
          // Fetch all parent categories
          $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

          if ($result_categories != false) {
            while ($parent = mysqli_fetch_array($result_categories)) {

              // Fetch all subcategories for this parent
              $result_subcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = '" . $parent['pcat_id'] . "' ORDER BY `pcat_menuorder` ASC");

              if ($result_subcategories != false) {
                while ($sub = mysqli_fetch_array($result_subcategories)) {
                  ?>
                  <a href="<?= $url->baseUrl("shop?cat=" . $sub['pcat_id']) ?>"
                    class="swiper-slide text-decoration-none text-dark">
                    <img src="<?= $url->baseUrl("uploads/category-images/" . ($sub['pcat_name'] ?? "default") . ".jpg") ?>"
                      alt="<?= $sub['pcat_name'] ?>">
                    <div class="slide-content">
                      <span><?= $parent['pcat_name'] ?></span>
                      <strong><?= $sub['pcat_name'] ?></strong>
                    </div>
                  </a>

                  <?php
                }
              }
            }
          }
        }
        ?>
      </div>
      <div class="swiper-pagination-bullets"></div>
    </div>



  </div>
</section>

<div class="leather-section" id="show-on-mobile-only">
  <div class="leather-content">
    <h4 class="tagline">Best in Industry</h4>
    <h1 class="title">
      Best Leather <br />
      Products
    </h1>
    <p class="description">
      Discover the perfect fusion of elegance and functionality with our best material.
    </p>
    <button class="explore-btn">Explore More</button>
  </div>


  <!-- Carousel Wrapper -->
  <div class="carousel-wrapper">
    <div class="carousel-nav left" onclick="moveSlide(-1)">&#8592;</div>
    <div class="carousel-nav right" onclick="moveSlide(1)">&#8594;</div>
    <div class="carousel-track">
      <?php
      if ($connStatus == true) {
        // Fetch all parent categories
        $result_categories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = 0 ORDER BY `pcat_menuorder` ASC");

        if ($result_categories != false) {
          $count = 1;
          while ($parent = mysqli_fetch_array($result_categories)) {

            // Fetch all subcategories for this parent
            $result_subcategories = $database->getData("SELECT * FROM `product_categories` WHERE `pcat_parent` = '" . $parent['pcat_id'] . "' ORDER BY `pcat_menuorder` ASC");

            if ($result_subcategories != false) {
              while ($sub = mysqli_fetch_array($result_subcategories)) {
                // Sanitize image name (optional)
                $imgName = $sub['pcat_name'];
                $imgPath = "uploads/category-images/" . $imgName . ".jpg";
                ?>
                <a href="<?= $url->baseUrl("shop?cat=" . $sub['pcat_id']) ?>"
                  class="carousel-slide text-decoration-none text-dark">
                  <img src="<?= $url->baseUrl($imgPath) ?>" alt="<?= $sub['pcat_name'] ?>" />
                  <div class="carousel-caption">
                    <p class="carousel-label"><?= str_pad($count, 2, "0", STR_PAD_LEFT) ?>           <?= $parent['pcat_name'] ?></p>
                    <p class="carousel-title"><?= $sub['pcat_name'] ?></p>
                  </div>
                </a>

                <?php
                $count++;
              }
            }
          }
        }
      }
      ?>
      <div class="dots">
        <span class="dot active" onclick="goToSlide(0)"></span>
        <span class="dot" onclick="goToSlide(1)"></span>
      </div>
    </div>


  </div>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    const swiper = new Swiper(".mySwiper", {
      slidesPerView: 3.3,
      spaceBetween: 20,
      pagination: {
        el: ".swiper-pagination-bullets",
        clickable: true,
      },
    });

    document.querySelector(".next").addEventListener("click", () => swiper.slideNext());
    document.querySelector(".prev").addEventListener("click", () => swiper.slidePrev());
  </script>

  <script>
    let currentSlide = 0;

    function moveSlide(step) {
      const slides = document.querySelectorAll(".carousel-slide");
      currentSlide = (currentSlide + step + slides.length) % slides.length;
      updateCarousel();
    }

    function goToSlide(index) {
      currentSlide = index;
      updateCarousel();
    }

    function updateCarousel() {
      const track = document.querySelector(".carousel-track");
      track.style.transform = `translateX(-${currentSlide * 100}%)`;

      document.querySelectorAll(".dot").forEach((dot, i) => {
        dot.classList.toggle("active", i === currentSlide);
      });
    }
  </script>

  <script>
    // JavaScript: Hide section for screens less than 768px
    if (window.innerWidth < 768) {
      document.getElementById('hide-on-mobile').style.display = 'none';
    }
  </script>