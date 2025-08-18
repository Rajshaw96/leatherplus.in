<?php
// footer.php
// require_once('lib/helpers/urlhelpers.php');
 // Ensure $url is available
?>

<div class="container-fluid px-lg-5 px-4 feature-row d-flex padding-bottoms">
  <div class="row text-start justify-content-between w-100">
    <div class="col-md-4 d-flex justify-content-start justify-content-md-start">
      <div class="feature-box text-start">
        <img src="<?= $url->baseUrl('views/app/assets/images/icon-3.png') ?>" alt="Leather Icon" class="feature-icon">
        <span>100% Genuine Leather</span>
      </div>
    </div>
    <div class="col-md-4 d-flex justify-content-start justify-content-md-center">
      <div class="feature-box text-start">
        <img src="<?= $url->baseUrl('views/app/assets/images/icon-2.png') ?>" alt="Shipping Icon" class="feature-icon">
        <span>Free Shipping over ₹1500</span>
      </div>
    </div>
    <div class="col-md-4 d-flex justify-content-start justify-content-md-end">
      <div class="feature-box text-start">
        <img src="<?= $url->baseUrl('views/app/assets/images/icon-1.png') ?>" alt="Support Icon" class="feature-icon">
        <span>24/7 Support</span>
      </div>
    </div>
  </div>
</div>

<div class="horizonntal-line"></div>

<div class="footer-wrapper container-fluid px-lg-5 d-none d-lg-flex">
  <footer>
    <div class="row gy-2">
      <div class="col-md-3 footer-column text-start">
        <div class="footer-logo pb-3">
          <img src="<?= $url->baseUrl('views/app/assets/images/leatherplus_logowhite.png') ?>" alt="LeatherPlus Logo"
            class="img-fluid">
        </div>
        <p>Leather Plus is a premier manufacturer of high-quality leather belts and suspenders, renowned for its
          craftsmanship and dedication to excellence.</p>
        <div class="footer-social mt-2">
          <a href="https://www.instagram.com/leatherplus.fashion" target="_blank"><i class="bi bi-instagram"></i></a>
          <a href="https://www.facebook.com/leatherplus.in/" target="_blank"><i class="bi bi-facebook"></i></a>
          <a href="mailto:info@leatherplus.in"><i class="bi bi-envelope" target="_blank"></i></a>
          <!-- <a href="#"><i class="bi bi-youtube" target="_blank"></i></a> -->
          <a href="https://x.com/leatherplusind" target="_blank"><img src="<?= $url->baseUrl('views/app/assets/images/icons/x-twitter.png') ?>" alt="Twitter Icon" class="feature-icon"></a>
        </div>
      </div>

      <div class="col-md-3 footer-column text-start">
        <h5>Information</h5>
        <ul>
          <li><a href="<?= $url->baseUrl('about') ?>">About Us</a></li>
          <li><a href="<?= $url->baseUrl('career') ?>">Career</a></li>
          <li><a href="<?= $url->baseUrl('best-sellers') ?>">Bestsellers</a></li>
          <li><a href="<?= $url->baseUrl('specials') ?>">Specials</a></li>
          <li><a href="#">Sizes</a></li>
          <li><a href="<?= $url->baseUrl('shop') ?>">Shop Online</a></li>
        </ul>
      </div>

      <div class="col-md-3 footer-column text-start">
        <h5>Account</h5>
        <ul>
          <li><a href="<?= $url->baseUrl('my-account') ?>">My Account</a></li>
          <li><a href="<?= $url->baseUrl('cart') ?>">My Cart</a></li>
          <li><a href="<?= $url->baseUrl('blogs') ?>">Blogs</a></li>
          <li><a href="<?= $url->baseUrl('my-orders') ?>">Orders History</a></li>
          <li><a href="<?= $url->baseUrl('contact') ?>">Help & Support</a></li>
        </ul>
      </div>

      <div class="col-md-3 footer-column text-start">
        <h5>Customer Service</h5>
        <ul>
          <li><a href="<?= $url->baseUrl('contact') ?>">Help & Contact</a></li>
          <li><a href="<?= $url->baseUrl('terms-and-conditions') ?>">Terms & Conditions</a></li>
          <li><a href="<?= $url->baseUrl('cancellation-and-refund-policy') ?>">Cancellation & Refund Policy</a></li>
          <li><a href="<?= $url->baseUrl('privacy-policy') ?>">Privacy Policy</a></li>
          <li><a href="<?= $url->baseUrl('shipping-and-delivery-policy') ?>">Shipping & Delivery Policy</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom text-start">
      <p>&copy; <?= date("Y") ?> Leather Plus®. All Rights Reserved.</p>
    </div>
  </footer>
</div>

<div class="mobile-footer d-lg-none d-block">
  <div class="footer-box text-white text-start">
    <h5>Your Inbox Deserves Some Rejuvenation Too</h5>
    <p>Sign up for special offers, Leather Plus news, tips, and more!</p>
    <div class="input-group mb-3 d-flex">
      <input id="formid" type="email" class="form-control" placeholder="Your email address" />
      <button class="btn btn-light enter-button"><i class="bi bi-arrow-right"></i></button>
    </div>
  </div>

  <div class="accordion">
    <div class="accordion-item">
      <div class="accordion-header">Information <span class="icon">▼</span></div>
      <div class="accordion-content">
        <ul class="list-unstyled style-accordion">
          <li><a href="<?= $url->baseUrl('about') ?>">About Us</a></li>
          <li><a href="<?= $url->baseUrl('career') ?>">Career</a></li>
          <li><a href="<?= $url->baseUrl('best-sellers') ?>">Bestsellers</a></li>
          <li><a href="<?= $url->baseUrl('specials') ?>">Specials</a></li>
          <li><a href="#">Sizes</a></li>
          <li><a href="<?= $url->baseUrl('shop') ?>">Shop Online</a></li>
        </ul>
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header">Account <span class="icon">▼</span></div>
      <div class="accordion-content">
        <ul class="list-unstyled style-accordion">
          <li><a href="<?= $url->baseUrl('my-account') ?>">My Account</a></li>
          <li><a href="<?= $url->baseUrl('cart') ?>">My Cart</a></li>
          <li><a href="<?= $url->baseUrl('blogs') ?>">Offers & Updates</a></li>
          <li><a href="<?= $url->baseUrl('my-orders') ?>">Orders History</a></li>
          <li><a href="<?= $url->baseUrl('contact') ?>">Help & Support</a></li>
        </ul>
      </div>
    </div>

    <div class="accordion-item">
      <div class="accordion-header">Customer Service <span class="icon">▼</span></div>
      <div class="accordion-content">
        <ul class="list-unstyled style-accordion">
          <li><a href="<?= $url->baseUrl('contact') ?>">Help & Contact</a></li>
          <li><a href="<?= $url->baseUrl('terms-and-conditions') ?>">Terms & Conditions</a></li>
          <li><a href="<?= $url->baseUrl('cancellation-and-refund-policy') ?>">Cancellation & Refund Policy</a></li>
          <li><a href="<?= $url->baseUrl('privacy-policy') ?>">Privacy Policy</a></li>
          <li><a href="<?= $url->baseUrl('shipping-and-delivery-policy') ?>">Shipping & Delivery Policy</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Company Info -->
  <div class="footer-box">
    <!-- <h4 class="fw-bold">LEATHER PLUS</h4> -->
    <img src="<?= $url->baseUrl('views/app/assets/images/leatherplus_logowhite.png') ?>" alt="LeatherPlus Logo"
      class="img-fluid mb-2">
    <p class="mb-0">D-1, 1st Floor, Local Shopping Centre,<br>Soami Nagar, New Delhi, India - 110017</p>
    <div class="footer-social mt-2">
      <a href="https://www.instagram.com/leatherplus.fashion" target="_blank"><i class="bi bi-instagram"></i></a>
      <a href="https://www.facebook.com/leatherplus.in/" target="_blank"><i class="bi bi-facebook"></i></a>
      <a href="mailto:info@leatherplus.in"><i class="bi bi-envelope" target="_blank"></i></a>
      <!-- <a href="#"><i class="bi bi-youtube" target="_blank"></i></a> -->
      <a href="https://x.com/leatherplusind" target="_blank"><img src="<?= $url->baseUrl('views/app/assets/images/icons/x-twitter.png') ?>" alt="Twitter Icon" class="feature-icon"></a>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; <?= date("Y") ?> Leather Plus®. All Rights Reserved.<br>
    U36999DL2017PTC310502
  </div>
</div>
<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
  <div id="toast-message" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive"
    aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto p-5" data-bs-dismiss="toast"
        aria-label="Close"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  function showToast(message, isSuccess = true, delay = null) {
    const toastElement = document.getElementById("toast-message");
    const toastBody = document.getElementById("toast-body");

    toastBody.textContent = message;

    toastElement.classList.remove("bg-success", "bg-danger");
    toastElement.classList.add(isSuccess ? "bg-success" : "bg-danger");

    const toast = new bootstrap.Toast(toastElement, {
      delay: delay ?? 5000
    });
    toast.show();
  }


</script>


<!-- Scroll Up -->
<a href="#" class="footer-scroll-up"><i class="bi bi-chevron-up"></i></a>

<script src="<?= $url->baseUrl('views/app/assets/custom-js/script.js') ?>"></script>