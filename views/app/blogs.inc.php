<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Blogs - Leather Plus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />

    <!-- Favicon and Apple Icons -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="57x57"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">
  <link rel="apple-touch-icon" sizes="72x72"
    href="<?= $url->baseUrl("views/app/assets/images/icons/favicon.png") ?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair Display">
</head>

<body>
    <div id="wrapper">

        <?php include('includes/header-2.inc.php') ?>

        <!-- Banner -->
        <div class="container-fluid py-3 px-0">
            <div class="bg-dark text-white text-center py-5 banner-custom"
                style="background: url('<?= $url->baseUrl("views/app/assets/images/product-page1.png") ?>') no-repeat center center / cover;">
                <h1 class="display-4 fw-bold">Blogs</h1>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="container py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= $url->baseUrl("")?>">Home</a></li><span class="separator">›</span>
                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= $url->baseUrl("blogs")?>">Blogs</a></li>
                </ol>
            </nav>
        </div>

        <!-- Blogs Section -->
        <div class="container py-4">
            <div class="row g-4">

                <?php
                if ($connStatus == true) {
                    $result_blogs = $database->getData("SELECT * FROM `blogs` WHERE `blog_status` = 1 ORDER BY `blog_id` DESC");
                    if ($result_blogs != false) {
                        while ($blogs = mysqli_fetch_array($result_blogs)) {
                            ?>
                            <div class="col-12 col-md-6">
                                <div class="card h-100 shadow-sm border-0">
                                    <a href="blog?q=<?= $blogs['blog_id'] ?>">
                                        <img src="<?= $url->baseUrl("uploads/blog-images/" . $blogs['blog_featuredimage']) ?>"
                                            class="card-img-top" alt="<?= $blogs['blog_title'] ?>">
                                    </a>
                                    <div class="card-body p-4">
                                        <p class="text-muted small mb-1">
                                            <?= date_format(date_create($blogs['blog_creationtime']), "d M, Y") ?></p>
                                        <h5 class="card-title">
                                            <a href="blog?q=<?= $blogs['blog_id'] ?>"
                                                class="text-dark text-decoration-none"><?= $blogs['blog_title'] ?></a>
                                        </h5>
                                        <p class="card-text"><?= substr(base64_decode($blogs['blog_description']), 0, 120) ?>...</p>
                                        <a href="blog?q=<?= $blogs['blog_id'] ?>" class="apply-button">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>

            </div>
        </div>

        <div class="py-0 py-lg-5"></div>

        <?php include('includes/footer.inc.php') ?>

    </div>
</body>

</html>