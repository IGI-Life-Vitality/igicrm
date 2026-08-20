<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'messages.php');

$objMessage = new message();

if(isset($_POST)) {

    $sender          = isset($_POST['sender'])?$_POST['sender']:'';
    $recipient       = isset($_POST['recipient'])?$_POST['recipient']:'';
    $subject         = isset($_POST['subject'])?$_POST['subject']:'';
    $msg             = isset($_POST['msg'])?$_POST['msg']:'';
    $msg_id          = isset($_POST['msg_id'])?$_POST['msg_id']:'';
    $recipient = implode(",",$recipient);

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_update"){
            if($msg_id == 0){
                 echo $objMessage->AddMessage($sender,$recipient,$subject,$msg);
            }else{
                  echo $objMessage->UpdateMessage($msg_id,$sender,$recipient,$subject,$msg);
            }
           // echo $objTemplate->AddTemplates($template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail);
        }/*elseif($action == "edit"){
            echo $objTemplate->UpdateAgents($id,$email,$is_active);
        }*/
    }

}
?>