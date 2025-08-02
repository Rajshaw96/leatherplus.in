<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>Home - Leather Plus</title>
    <meta name="description" content="Shop Premium Leather Products">

    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./views/app/assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./views/app/assets/custom-style/style.css" />
    <link rel="stylesheet" href="./views/app/assets/custom-style/about-us.css" />
    <link rel="stylesheet" href="./views/app/assets/custom-style/about-us.css" />
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

    <!--- jQuery -->
    <!-- <script src="/ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->

    <!-- <script>
        window.jQuery || document.write('<script src="<?= $url->baseUrl("views/app/assets/js/jquery-2.1.1.min.js") ?>"><\/script>')
    </script> -->

</head>

<body>
    <div id="wrapper">

        <?php include("includes/header-2.inc.php") ?>

        <section id="content" role="main">


            <?php include("includes/frontpage-slider.inc.php") ?>
            <?php include("categorysection.inc.php") ?>
            <?php include("includes/best-in-industry.in.php") ?>



        </section>
        <div class="d-md-block d-none">

            <?php include("includes/our-product.inc.php") ?>
        </div>
        <div class="d-md-none d-block">
            <?php include("best-sellers-mobile.php") ?>

        </div>


        <?php include('includes/footer.inc.php'); ?>

    </div><!-- End #wrapper -->
    <!-- END -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        $(function() {
            "use strict";
            // Slider Revolution
            jQuery('#revslider').revolution({
                delay: 8000,
                startwidth: 1170,
                startheight: 600,
                fullScreen: "on",
                hideTimerBar: "on",
                spinner: "spinner3",
                navigationVOffset: 50
            });
        });

        // Arrivals section Slider 
        var arrivalsApi = jQuery('#arrivals-slider.revbanner-slider').revolution({
            delay: 7000,
            fullWidth: "on",
            startwidth: 1170,
            startHeight: 800,
            fullScreen: "on",
            fullScreenAlignForce: "on",
            hideTimerBar: "on",
            spinner: "spinner4"
        });

        $('#arrivals-prev').on('click', function(e) {
            arrivalsApi.revprev();
            e.preventDefault();
        });

        $('#arrivals-next').on('click', function(e) {
            arrivalsApi.revnext();
            e.preventDefault();
        });
    </script> -->
</body>

</html>