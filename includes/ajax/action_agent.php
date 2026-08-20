<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'agent.php');

$objAgent = new Agent();

if(isset($_POST)) {

    $action     = isset($_POST['action']) ? $_POST['action'] : '';
    $id         = isset($_POST['id'])?$_POST['id']:0;
    $user_id    = isset($_POST['user_id'])?$_POST['user_id']:'';
    $email      = isset($_POST['email'])?$_POST['email']:'';
    $password   = isset($_POST['password'])?$_POST['password']:'';
    $is_active          = isset($_POST['is_active'])?$_POST['is_active']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){
            echo $objAgent->AddAgents($user_id,$email,$password,$is_active);
        }elseif($action == "edit"){
            echo $objAgent->UpdateAgents($id,$email,$is_active);
        }
    }

}

?>