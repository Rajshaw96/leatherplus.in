<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>Contact - Leather Plus</title>
    <meta name="description" content="Login to your Leather Plus Account">

    <!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">

    <!--- jQuery -->


</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section class="margin-contact-us">
            <div class="container-fluid px-lg-5 contact-section pb-0 pb-lg-5">
                <h2>Help & Contact Us</h2>
                <p>You may contact us for any help using the information below:</p>

                <div class="mt-4 contact-us">
                    <p><span class="contact-label">Merchant Legal entity name:</span><br>
                        <span class="contact-value">STAR ONLINE INC</span>
                    </p>

                    <p><span class="contact-label">Registered Address:</span><br>
                        <span class="contact-value">B, 56 A, SECTOR 7, Noida, Gautam Buddha Nagar, Uttar Pradesh
                            201301</span>
                    </p>

                    <p><span class="contact-label">Operational Address:</span><br>
                        <span class="contact-value">B, 56 A, SECTOR 7, Noida, Gautam Buddha Nagar, Uttar Pradesh
                            201301</span>
                    </p>

                    <p><span class="contact-label">Telephone No:</span><br>
                        <a href="tel:7835079428" class="contact-value">7835079428</a>
                    </p>

                    <p><span class="contact-label">E-Mail ID:</span><br>
                        <a href="mailto:info@leatherplus.in" class="contact-value">info@leatherplus.in</a>
                    </p>
                </div>
            </div>
        </section>

        <?php include('includes/footer.inc.php') ?>

    </div><!-- End #wrapper -->

    <!-- scroltop -->
    <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

    <!-- END -->



    <script>
        <?php

        if (isset($_GET['m'])) {

            if ($_GET['m'] == "send1") {
                ?>

                alert("Your message has been sent!");

                <?php
            } else {
                ?>

                alert("Unable to sent your message!");

                <?php
            }
        }

        ?>
    </script>

</body>

</html>