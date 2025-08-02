<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
</head>

<body>
    <?php

    session_start();
    ob_start();

    //Required Config Files
    require_once('../lib/config/config.php');

    //Required libraries
    require_once('../lib/helpers/urlhelpers.php');
    require_once('../lib/security/requests.php');
    require_once('../lib/database/databaseops.php');

    //Creating instance
    $url = new UrlHelpers();
    $request = new Requests();
    $database = new DatabaseOps();

    $connStatus = $database->createConnection();

    if ($connStatus == true) {

        $result_CC = $database->getData("SELECT * FROM `settings` WHERE `sett_name` = 'INR_USD'");

        if ($result_CC != false) {

            while ($rows_CC = mysqli_fetch_array($result_CC)) {

                $cc_rate = $rows_CC['sett_value'];
            }
        }
    }
    

    include('config.php');
    $productName = $_GET['rcpt'];
    $currency = "USD";
    $productPrice = round($_GET['amt'] * $cc_rate, 2);
    $productId = $_GET['rcpt'];
    $orderNumber = $_GET['rcpt'];
    ?>
    <div class="container-fluid" style="padding-top:10%; padding-bottom:10%">
        <center>
            <div>
                <h5>Click the button below</h5>
                <?php include 'paypalCheckout.php'; ?>
            </div>
        </center>
    </div>
</body>

</html>