<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <title>Job Openings - Leather Plus</title>
    <meta name="description" content="Granada is a premium, responsive and bootstrap based ecommerce template">

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

</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <section id="content" role="main" class="single-page-blog pb-0 pb-lg-5">
            <!-- End .breadcrumb-container -->
            <div class="container py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $url->baseUrl("") ?>">Home</a></li><span
                            class="separator">›</span>
                        <li class="breadcrumb-item active" aria-current="page"><a
                                href="<?= $url->baseUrl("career") ?>">Career</a></li>
                    </ol>
                </nav>
            </div>


            <div class="container">
                <div class="row">

                    <div class="col-md-12 padding-right-larger">

                        <?php

                        if ($connStatus == true) {

                            $result = $database->getData("SELECT * FROM `jobopenings` WHERE `job_status` = 1");

                            if ($result != false) {

                                while ($rows = mysqli_fetch_array($result)) {
                                    ?>

                                    <div class="career-description">
                                        <h4><?= $rows['job_title'] ?></h4>
                                        <p>
                                            <b>Experience: </b><?= $rows['job_experience'] ?><br>
                                            <b>Qualification: </b><?= base64_decode($rows['job_qualification']) ?><br>
                                            <b>Preferred Candidates: </b><?= base64_decode($rows['job_preferredcandidates']) ?> <br>
                                            <b>Job Responsibilities:</b><br>
                                            <?= base64_decode($rows['job_responsibilities']) ?>
                                            Mail us your resume at <a href="mailto:<?= $rows['job_mail'] ?>"
                                                style="text-decoration:underline" class="career-email"><?= $rows['job_mail'] ?></a>
                                        </p>
                                        <hr>
                                    </div>

                                    <?php
                                }
                            }
                        }

                        ?>

                        <div class="sm-margin"></div><!-- space -->
                    </div>

                    <div class="lg-margin visible-sm visible-xs clearfix"></div><!-- space -->

                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="md-margin2x"></div><!-- space -->

        </section><!-- End #content -->

        <?php include('includes/footer.inc.php') ?>
    </div><!-- End #wrapper -->

    <!-- scroltop -->
    <!-- <a href="#header" id="scroll-top" title="Go to top">Top</a> -->

    <!-- END -->



</body>

</html>