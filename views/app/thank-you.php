<?php include('../../lib/config/config.php'); ?>

<head>
    <title>Thank You - Leather Plus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= $url->baseUrl("views/app/assets/custom-style/style.css") ?>" />

</head>
<style>
    .thankyou-container {
        margin: 250px 0 180px 0 !important;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        max-width: 100%;
        height: fit-content;
    }
</style>
<section>
    <?php include('includes/header-2.inc.php') ?>
    <div class="thankyou-container">
        <h2>Thank You for Your Order!</h2>
        <p>Your order <?php echo htmlspecialchars($_GET['order']); ?> has been placed successfully with Cash on
            Delivery.</p>
        <div class="d-flex gap-2">
            <a href="<?= $url->baseUrl("shop") ?>" class="apply-button">Continue Shopping</a>
            <a href="<?= $url->baseUrl("my-account") ?>" class="apply-button">Order Detail</a>

        </div>
    </div>
    <?php include('includes/footer.inc.php') ?>
</section>