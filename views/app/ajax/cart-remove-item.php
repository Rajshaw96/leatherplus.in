<?php
session_start();

// Check if index is passed
if (isset($_GET['index'])) {
    $index = intval($_GET['index']);

    // If that index exists in session cart → remove it
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex array
    }
}

// Redirect back to the main cart page
header("Location: ../cart.inc.php"); 
exit;
