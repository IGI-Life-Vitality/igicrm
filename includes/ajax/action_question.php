<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'question.php');

$objQuestion = new Question();

if(isset($_POST)) {

    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $question           = isset($_POST['question'])?$_POST['question']:'';
    $set_id             = isset($_POST['set_id'])?$_POST['set_id']:'';
    $is_active          = isset($_POST['isactive'])?$_POST['isactive']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){
            echo $objQuestion->AddQuestion($id, $question, $set_id, $is_active);
        }elseif($action == "edit"){
            echo $objQuestion->UpdateQuestion($id, $question, $set_id, $is_active);
        }
    }

}

?>