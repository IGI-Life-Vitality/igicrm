<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'news.php');

$objNews = new News();

if(isset($_POST)) {

    $sender          = isset($_POST['sender'])?$_POST['sender']:'';
    $group           = isset($_POST['group'])?$_POST['group']:'';
    $subject         = isset($_POST['subject'])?$_POST['subject']:'';
    $news            = isset($_POST['news'])?$_POST['news']:'';
    $news_id         = isset($_POST['news_id'])?$_POST['news_id']:'';
    $file            = isset($_POST['file'])?$_POST['file']:'';
    //echo $file;
    //exit;

    if($file == '' || empty($file) ){

        $file = "0";
    }

    $group = implode(",",$group);

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_update"){
            if($news_id == 0){
                 echo $objNews->AddNews($sender,$group,$subject,$news,$file);
            }else{
                  echo $objNews->UpdateNews($news_id,$sender,$group,$subject,$news,$file);
            }
           // echo $objTemplate->AddTemplates($template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail);
        }/*elseif($action == "edit"){
            echo $objTemplate->UpdateAgents($id,$email,$is_active);
        }*/
    }

}
?>