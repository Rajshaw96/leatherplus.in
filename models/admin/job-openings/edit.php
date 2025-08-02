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

    if (isset($_POST['title']) || isset($_POST['id'])) {

        if ($connStatus == true) {

            $result = $database->runQuery("UPDATE `jobopenings` SET `job_title`='".$_POST['title']."', `job_experience`='".$_POST['experience']."', `job_qualification`='".base64_encode($_POST['qualifications'])."', `job_preferredcandidates`='".base64_encode($_POST['pref_candidates'])."', `job_responsibilities`='".base64_encode($_POST['responsibilities'])."', `job_mail`= '".$_POST['email']."', `job_status`='".$_POST['status']."' WHERE `job_status` = '".$_POST['id']."'");

            if ($result == true) {

                header('location:' . $url->baseUrl("admin/job-openings/all?m=edt1"));
            } else {

                header('location:' . $url->baseUrl("admin/job-openings/all?m=edt0"));
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
