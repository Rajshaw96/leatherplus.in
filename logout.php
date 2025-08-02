<?php

session_start();
ob_start();

//Required Config Files
require_once('lib/config/config.php');

//Required libraries
require_once('lib/helpers/urlhelpers.php');

//Creating instance
$url = new UrlHelpers();

session_unset();
ob_end_clean();

session_destroy();
ob_end_flush();

header('location:'.$url->baseUrl('login?m=lo'));

?>