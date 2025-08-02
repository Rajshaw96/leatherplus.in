<?php

session_start();
ob_start();

//Required Config Files
require_once('../../../lib/config/config.php');
require_once('../../../lib/file-operations/filesops.php');
require_once('../../../lib/security/requests.php');

//Create Objects
$fileop = new FilesOps();
$request = new Requests();

if($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true){

    $prefix = date('ymdhis');
    
    //$result = $fileop->uploadImage("../../../uploads/product-images/", $_FILES['file'], $prefix, 1024000000);
    $result = $fileop->uploadAndCompressImage("../../../uploads/blog-images/", $_FILES['file'], $prefix);

    echo $result;
}

?>