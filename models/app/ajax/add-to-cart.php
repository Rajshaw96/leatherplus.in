<?php

session_start();
ob_start();

//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/database/databaseops.php');

//Create Objects
$database = new DatabaseOps();

//Declare Variables
$connStatus = $database->createConnection();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_POST['ptype'] != "V") {

    $item = array($_POST['pid'], $_POST['qty'], $_POST['prate'], $_POST['ptax'], $_POST['varient'], $_POST['mat']);

    array_push($_SESSION['cart'], $item);
}

if ($_POST['ptype'] == "V") {

    $item = array($_POST['pid'], $_POST['qty'], $_POST['prate'], $_POST['ptax'], $_POST['varient'], $_POST['mat']);

    array_push($_SESSION['cart'], $item);
}

$cdisplay = 0;

foreach ($_SESSION['cart'] as $it) {

    $cdisplay = $it[1] + $cdisplay;
}

//echo $cdisplay;

$cqty=0;
$camt=0;

if (isset($_SESSION['cart'])) {

    $_SESSION['enabletaxes'] = 0; // change later

    foreach ($_SESSION['cart'] as $citems) {

        if ($_SESSION['enabletaxes'] == 1) {

            $cqty =  $cqty + $citems[1];

            $amt1 = $citems[2] * $citems[1];

            $amt2 = $amt1 + ($amt1 * ($citems[3] / 100));

            $camt = $camt + $amt2;
        } else {

            $cqty =  $cqty + $citems[1];

            $amt1 = $citems[2] * $citems[1];

            $camt = $camt + $amt1;
        }
    }
} else {
    $cqty = 0;
}

echo $camt.",".$cqty;
