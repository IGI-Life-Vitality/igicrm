<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();

if(isset($_POST)) {

    $action     = isset($_POST['action']) ? $_POST['action'] : '';
    $id         = isset($_POST['id'])?$_POST['id']:0;
    $name       = isset($_POST['fullname'])?$_POST['fullname']:'';
    $email      = isset($_POST['email'])?$_POST['email']:'';
    $is_active  = isset($_POST['isactive'])?$_POST['isactive']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){
            echo $objUser->AddDepartment($name,$email,$is_active);
        }elseif($action == "edit"){
            echo $objUser->UpdateDepartment($id,$name,$email,$is_active);
        }
    }

}

?>