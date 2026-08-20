<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'question.php');

$objQuestion = new Question();

if(isset($_POST)) {

    $action     = isset($_POST['action']) ? $_POST['action'] : '';
    $id         = isset($_POST['id'])?$_POST['id']:0;
    $name       = isset($_POST['fullname'])?$_POST['fullname']:'';
    $hierarchy  = isset($_POST['hierarchy'])?$_POST['hierarchy']:'';
    $is_active  = isset($_POST['isactive'])?$_POST['isactive']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){
            echo $objQuestion->AddCreateSet($name,$hierarchy,$is_active);
        }elseif($action == "edit"){
            echo $objQuestion->UpdateCreateSet($id,$name,$hierarchy,$is_active);
        }
    }

}

?>