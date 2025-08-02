<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?> - Leather Plus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Custom CSS -->
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/bootstrap/css/bootstrap.min.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />
    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/about-us.css") ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $url->baseUrl("views/app/assets/images/icons/icon.png") ?>">
</head>

<body>
    <div id="wrapper">
        <?php include('includes/header-2.inc.php') ?>

        <!-- Breadcrumb -->
        <section id="content" role="main" class="pt-3 pb-sm-5 pb-0 single-page-blog">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $url->baseUrl("") ?>" title="Home">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $url->baseUrl("blogs") ?>">Blogs</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
                    </ol>
                </nav>

                <div class="row">
                    <!-- Blog Main Content -->
                    <div class="col-md-9">
                        <article class="card border-0">
                            <!-- Blog Image -->
                            <div class="mb-3">
                                <img src="<?= $url->baseUrl('uploads/blog-images/' . $featuredimage) ?>"
                                    alt="<?= $title ?>" class="img-fluid rounded w-100" />
                            </div>

                            <!-- Blog Date -->
                            <p class="text-muted small"><?= date_format(date_create($time), "d-m-Y") ?></p>

                            <!-- Blog Title -->
                            <h2 class="fw-bold" style="color: #582F0E;"><?= $title ?></h2>

                            <!-- Blog Description -->
                            <div class="mt-3 description">
                                <?= base64_decode($description) ?>
                            </div>
                        </article>
                    </div>

                    <!-- Sidebar -->
                    <aside class="col-md-3">
                        <!-- Latest Posts -->
                        <div class="border rounded p-3">
                            <h4 class="fw-semibold mb-3">Latest Posts</h4>
                            <?php
                            if ($connStatus == true) {
                                $result_blogs = $database->getData("SELECT * FROM `blogs` WHERE `blog_status` = 1 ORDER BY `blog_id` DESC");
                                if ($result_blogs != false) {
                                    while ($blogs = mysqli_fetch_array($result_blogs)) {
                                        ?>
                                        <div class="mb-4">
                                            <a href="blog?q=<?= $blogs['blog_id'] ?>" class="text-decoration-none">
                                                <img src="<?= $url->baseUrl("uploads/blog-images/" . $blogs['blog_featuredimage']) ?>"
                                                    alt="<?= $blogs['blog_title'] ?>" class="img-fluid mb-2 rounded" />
                                                <h6 class="mb-3 text-dark"><?= $blogs['blog_title'] ?></h6>
                                                <a href="blog?q=<?= $blogs['blog_id'] ?>" class="apply-button mt-3">Read More</a>
                                            </a>


                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </aside>
                </div>
            </div>
        </section>

        <?php include('includes/footer.inc.php') ?>
    </div>
</body>

</html>