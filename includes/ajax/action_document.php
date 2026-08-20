<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'document.php');

$objDocs = new Docs();
if(isset($_POST)) {

     $subject           = isset($_POST['subject'])?$_POST['subject']:'';
     $detail            = isset($_POST['detail'])?$_POST['detail']:'';
     $url               = isset($_POST['url'])?$_POST['url']:'';
     $cat               = isset($_POST['category'])?$_POST['category']:'';
     $creator           = isset($_POST['creator'])?$_POST['creator']:'';
     $owner             = isset($_POST['owner'])?$_POST['owner']:'';
     $share             = isset($_POST['share'])?$_POST['share']:'';
     $share_user        = isset($_POST['share_user'])?$_POST['share_user']:'';
     $file              = isset($_POST['file'])?$_POST['file']:'';
     $exp_dt            = isset($_POST['exp_dt'])?$_POST['exp_dt']:'';
     $rm_dt             = isset($_POST['rm_dt'])?$_POST['rm_dt']:'';
     $reminder_msg      = isset($_POST['reminder_msg'])?$_POST['reminder_msg']:'';
     $docs_id           = isset($_POST['docs_id'])?$_POST['docs_id']:'';
     $isexternal        = isset($_POST['isexternal'])?$_POST['isexternal']:'';
     $isrenewal         = isset($_POST['isrenewal'])?$_POST['isrenewal']:'';
     $isreminder        = isset($_POST['isreminder'])?$_POST['isreminder']:'';
     $comments          = isset($_POST['comments'])?$_POST['comments']:'';

    //echo $file;
    //exit;
    if($file == '' || empty($file) ){

        $file = "0";
    }

    $share_user = implode(",",$share_user);
    $cat = implode(",",$cat);

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_update"){
            if($docs_id == 0){
                 echo $objDocs->AddDocs($subject,$detail,$url,$cat,$creator,$owner,$share,$share_user,$file,$exp_dt,$rm_dt,$reminder_msg,$isexternal,$isrenewal,$isreminder);
            }else{
                  echo $objDocs->UpdateDocs($docs_id,$subject,$detail,$url,$cat,$creator,$owner,$share,$share_user,$file,$exp_dt,$rm_dt,$reminder_msg,$isexternal,$isrenewal,$isreminder,$comments);
            }
          
        }elseif($action == "category_save"){
             $category_name   = isset($_POST['category_name'])?$_POST['category_name']:'';
             $is_active       = isset($_POST['isactive'])?$_POST['isactive']:'';
             $id              = isset($_POST['id'])?$_POST['id']:'';
            echo $objDocs->AddDocCategory($category_name,$is_active);
        }elseif($action == "category_edit"){
             $category_name   = isset($_POST['category_name'])?$_POST['category_name']:'';
             $is_active       = isset($_POST['isactive'])?$_POST['isactive']:'';
             $id              = isset($_POST['id'])?$_POST['id']:'';
            echo $objDocs->UpdateDocCategory($category_name,$is_active,$id);
        }
    }

}
?>