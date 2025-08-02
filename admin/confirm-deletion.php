<?php

session_start();
ob_start();

//Required Config Files
require_once('../lib/config/config.php');

//Required libraries
require_once('../lib/helpers/urlhelpers.php');
require_once('../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$database = new DatabaseOps();

//Views
if(isset($_SESSION['admin_id'])){
    
    include('../views/admin/confirm-deletion.inc.php');
}
else{

    header('location:'.$url->baseUrl('admin/login?m=ir'));
}

?>