<?php

include('../config.php');
include(CLASSES_PATH.DS.'email.php');
$objEmail = new Email();
$login_id = $_SESSION['login_id'];

if(isset($_POST)) {

    $email          = isset($_POST['email'])?$_POST['email']:'';
    $home_address   = isset($_POST['home_address'])?$_POST['home_address']:'';
    $filepath       = isset($_POST['filepath'])?$_POST['filepath']:'';
    $dir            = isset($_POST['dir'])?$_POST['dir']:'';
    $file           = isset($_POST['file'])?$_POST['file']:'';
    $folder         = isset($_POST['folder'])?$_POST['folder']:'';

    $logfile="../../logs/send_attachment.txt";

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "sendmail"){
            echo $objEmail->AddEmailTemplate($login_id, $email, '', 'uploads_document_dispatcher', $dir, $file, '1');
        }
        elseif($action = "scandir"){
            $files = scandir("../../".$filepath);
            $data = "";
            $data .='<option disabled="disabled" selected="selected" value="0">Select File(s)</option>';
            for($a=2;$a<count($files);$a++){
                $data .='<option value="'.$files[$a].'">'.$files[$a].'</option>';
            }
            echo $data;
        }
            
    }
}
?>