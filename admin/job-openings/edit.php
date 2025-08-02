<?php

session_start();
ob_start();

//Required Config Files
require_once('../../lib/config/config.php');

//Required libraries
require_once('../../lib/helpers/urlhelpers.php');
require_once('../../lib/security/requests.php');
require_once('../../lib/database/databaseops.php');

//Creating instance
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();

$connStatus = $database->createConnection();

//Views
if (isset($_SESSION['admin_id'])) {

    if ($_SESSION['admin_role'] == "shopmanager" || $_SESSION['admin_role'] == "admin") {

        if ($connStatus == true) {

            $result_settings = $database->getData("SELECT `sett_value` FROM `settings` WHERE `sett_name`='enabletaxes'");

            if ($result_settings != false) {

                while ($settings_row = mysqli_fetch_array($result_settings)) {

                    $enabletaxes = $settings_row['sett_value'];
                }
            }

            if (isset($_GET['q'])) {

                $result = $database->getData("SELECT * FROM `jobopenings` WHERE `job_id` = '" . $_GET['q'] . "'");

                if($result != false){

                    while($row = mysqli_fetch_array($result)){

                        $title = $row['job_title'];
                        $experience = $row['job_experience'];
                        $qualification = base64_decode($row['job_qualification']);
                        $pref_candidates = base64_decode($row['job_preferredcandidates']);
                        $responsibilities = base64_decode($row['job_responsibilities']);
                        $email = $row['job_mail'];
                        $status = $row['job_status'];
                    }
                }

                include('../../views/admin/job-openings/edit.inc.php');
            }
        }
    }
} else {

    header('location:' . $url->baseUrl('admin/login?m=ir'));
}
