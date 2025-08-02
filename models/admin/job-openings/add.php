<?php
session_start();
ob_start();


//Required Config Files
require_once('../../../lib/config/config.php');

//Required Libraries
require_once('../../../lib/security/requests.php');
require_once('../../../lib/helpers/urlhelpers.php');
require_once('../../../lib/database/databaseops.php');
require_once('../../../lib/file-operations/filesops.php');



//Create Objects
$url = new UrlHelpers();
$request = new Requests();
$database = new DatabaseOps();
$filesop = new FilesOps();

//Declare Variables
$connStatus = $database->createConnection();

if ($request->checkRequestHash($_POST['key'], $_SESSION['secretcode']) == true) {

    if (isset($_POST['title'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("INSERT INTO `jobopenings`(`job_title`, `job_experience`, `job_qualification`, `job_preferredcandidates`, `job_responsibilities`, `job_mail`, `job_status`) VALUES('".$_POST['title']."', '".$_POST['experience']."', '".base64_encode($_POST['qualifications'])."', '".base64_encode($_POST['pref_candidates'])."', '".base64_encode($_POST['responsibilities'])."', '".$_POST['email']."', '".$_POST['status']."')");

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/job-openings/all?m=add1"));
            } else {

                header('location:' . $url->baseUrl("admin/job-openings/all?m=add0"));
            }
        } else {

            header('location:' . $url->baseUrl('admin/login?m=nc'));
        }
    } else {
        header('location:' . $url->baseUrl("admin/login?m=fr"));
    }
}
else {
    header('location:' . $url->baseUrl("admin/login?m=ir"));
}
