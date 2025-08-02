<?php
// Start session and output buffering
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

// Database Configurations
$GLOBALS['dbhost'] = "localhost";
$GLOBALS['dbuser'] = "root";
$GLOBALS['dbpassword'] = ""; // empty password for XAMPP default
$GLOBALS['dbname'] = "leatherplusDB";

// URL Configurations
$GLOBALS['site_url'] = "http://localhost/leatherplus.in/";
// $GLOBALS['site_url'] = "https://www.leatherplus.in/";

// Email Configurations
$GLOBALS['smtp_server'] = "leatherplusbelt.com";
$GLOBALS['smtp_username'] = "donotreply@leatherplusbelt.com";
$GLOBALS['smtp_password'] = "eKadb.lw-8@B";
$GLOBALS['smtp_port'] = 465;
$GLOBALS['smtp_secure'] = "ssl";
$GLOBALS['from_email'] = "donotreply@leatherplusbelt.com";
$GLOBALS['from_name'] = "Leather Plus";

// Include Required Libraries
require_once(__DIR__ . '/../helpers/urlhelpers.php');
require_once(__DIR__ . '/../database/databaseops.php');

// Instantiate Global Helpers
$url = new UrlHelpers();
$database = new DatabaseOps();
$connStatus = $database->createConnection();
?>
