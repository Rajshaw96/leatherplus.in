<section class="py-md-5">
  <div class="container-fluid px-lg-5">
    <h2 class="our-Products">Our Products</h2>
    <div class="carousel-container">
      <div class="product-grid" id="productGrid">
        <!-- Products will load here -->
      </div>
    </div>
    <div class="show-more">
      <!-- <button id="loadMoreBtn" onclick="loadMore()">Show More</button> -->
    </div>
  </div>
</section>

<script>
  let offset = 0;
  const limit = 8;

  function loadMore() {
    fetch(`views/app/includes/load-products.php?offset=${offset}&limit=${limit}`)
      .then(res => res.text())
      .then(html => {
        document.getElementById('productGrid').insertAdjacentHTML('beforeend', html);
        offset += limit;

        // Hide button if no more products
        if (html.trim() === '') {
          document.getElementById('loadMoreBtn').style.display = 'none';
        }
      });
  }

  // Initial load
  loadMore();
</script>
