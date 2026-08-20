<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'templates.php');

$objTemplate = new Templates();

if(isset($_POST)) {

    $action                = isset($_POST['action']) ? $_POST['action'] : '';
    $template_id           = isset($_POST['template_id'])?$_POST['template_id']:'';
    $template_type         = isset($_POST['template_type'])?$_POST['template_type']:0;
    $template_name         = isset($_POST['template_name'])?$_POST['template_name']:'';
    $template_desc         = isset($_POST['template_desc'])?$_POST['template_desc']:'';
    $template_subject      = isset($_POST['template_subject'])?$_POST['template_subject']:'';
    $is_active             = isset($_POST['isActive'])?$_POST['isActive']:'';
    $template_detail       = isset($_POST['template_detail'])?$_POST['template_detail']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_update"){
            if($template_id == 0){
                 echo $objTemplate->AddTemplates($template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail);
            }else{
                  echo $objTemplate->UpdateTemplates($template_id,$template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail);
            }
        }
    }

}
?>