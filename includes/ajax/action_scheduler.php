<?php
require_once("../config.php");
//require_once '../../third_party/PHPMailer/PHPMailerAutoload.php';
include(CLASSES_PATH.DS.'complaint.php');

$objComplaint = new Complaint();
$login_id = $_SESSION['login_id'];
$current_datetime = date('Y-m-d H:i:s');

if(isset($_POST)){

    $mon = $_POST['mon_st'] . "-" . $_POST['mon_et'];
    $tue = $_POST['tue_st'] . "-" . $_POST['tue_et'];
    $wed = $_POST['wed_st'] . "-" . $_POST['wed_et'];
    $thu = $_POST['thu_st'] . "-" . $_POST['thu_et'];
    $fri = $_POST['fri_st'] . "-" . $_POST['fri_et'];
    $sat = $_POST['sat_st'] . "-" . $_POST['sat_et'];
    $sun = $_POST['sun_st'] . "-" . $_POST['sun_et'];

    echo $objComplaint->SaveScheduler($mon,$tue,$wed,$thu,$fri,$sat,$sun);

}

?>