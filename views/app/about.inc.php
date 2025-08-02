<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <title>About Us - Leather Plus</title>
  <meta name="description" content="Login to your Leather Plus Account">

  <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
  <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

  <!-- Favicon and Apple Icons -->
  <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

  <!--- jQuery -->


</head>

<body>
  <div id="wrapper">

    <?php include('includes/header-2.inc.php') ?>

    <section class="lp-banner" style="margin-top: 60px;">
      <picture>
        <source srcset="./views/app/assets/images/about-img-phone.png" media="(max-width: 700px)">
        <img src="./views/app/assets/images/about-us-bg.png" alt="Leather Belt Banner" />
      </picture>
    </section>

    <!-- About Us -->
    <section class="lp-section lp-about" id="about">
      <h2 class="fw-bold">About Us</h2>
      <p>Leather Plus is a premier manufacturer of high-quality leather belts and suspenders, renowned for its
        craftsmanship and dedication to excellence. Combining traditional techniques with modern innovations, Leather
        Plus offers a diverse range of products that cater to both classic and contemporary tastes. Each leather belt
        and pair of suspenders is meticulously crafted from the finest materials, ensuring durability and a
        sophisticated finish. The company prides itself on attention to detail, from selecting premium leather to
        employing skilled artisans who bring each piece to life. Leather Plus stands out in the market for its
        commitment to sustainability, using eco-friendly processes and ethically sourced materials. Whether you seek a
        timeless belt for formal occasions or stylish suspenders for everyday wear, Leather Plus provides unparalleled
        quality and design. Experience the perfect blend of tradition and modernity with Leather Plus, where every
        product is a testament to exceptional craftsmanship.</p>
    </section>

    <!-- Why Leather Plus -->
    <section class="lp-section lp-whyplus">
      <h2 class="fw-bold">Why Leather Plus</h2>
      <div class="lp-whycards-container">
        <div class="lp-whycards-card">
          <img src="./views/app/assets/images/about-us-icon (4).png" alt="Plant Icon">
          <span class="lp-whycards-title">Modern italian Plant & Machinery</span>
          <span class="lp-whycards-desc">Our unrivaled quality – backed by Italian precision. Our cutting-edge plant &
            machinery, sourced from Italy, elevate our products to a level of excellence that stands apart in the
            industry, ensuring you own nothing but the finest.</span>
        </div>
        <div class="lp-whycards-card">
          <img src="./views/app/assets/images/about-us-icon (3).png" alt="Globe Icon">
          <span class="lp-whycards-title">Global sourcing from trusted Suppliers</span>
          <span class="lp-whycards-desc">Empower your style with our global sourcing strategy. We partner with trusted
            suppliers worldwide to bring you the finest materials, ensuring our creations radiate exceptional quality
            and authenticity in every stitch.</span>
        </div>
        <div class="lp-whycards-card">
          <img src="./views/app/assets/images/about-us-icon (2).png" alt="Raw Material Icon">
          <span class="lp-whycards-title">In-house raw and finished stock</span>
          <span class="lp-whycards-desc">Crafting perfection, we control the journey from start to finish. With in-house
            sourcing of raw materials and production of finished goods, we guarantee quality at every step, resulting in
            products that embody our commitment to excellence.</span>
        </div>
        <div class="lp-whycards-card">
          <img src="./views/app/assets/images/about-us-icon (1).png" alt="Shield Icon">
          <span class="lp-whycards-title">Using the highest grade of Leather</span>
          <span class="lp-whycards-desc">Our commitment to luxury begins with selecting the finest material. From the
            richness of Spanish leather to the sophistication of Italian and Nappa leather, we meticulously curate the
            highest grade of hides, ensuring our products exude an unmatched blend of quality, style, and
            durability.</span>
        </div>
      </div>
    </section>

    <!-- Our Products -->
    <?php include 'includes/our-product.inc.php'; ?>


    <?php include('includes/footer.inc.php') ?>

  </div><!-- End #wrapper -->

  <!-- scroltop -->
  <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

  <!-- END -->


</body>

</html>