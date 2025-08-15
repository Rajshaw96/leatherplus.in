<?php include('../../lib/config/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head><title>Thank You - Leather Plus</title></head>
<body>
    <div class="container">
        <h2>Thank You for Your Order!</h2>
        <p>Your order <?php echo htmlspecialchars($_GET['order']); ?> has been placed successfully with Cash on Delivery.</p>
    </div>
</body>
</html>