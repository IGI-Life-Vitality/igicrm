<?php

include('includes/config.php');

if(isset($_POST)) {

    
    $filepath       = isset($_POST['filepath'])?$_POST['filepath']:'';
   

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "scandir"){

             $files = scandir($filepath);
             $data = "";
             $data .='<option disabled="disabled" selected="selected" value="0">Select File(s)</option>';
             for($a=2;$a<count($files);$a++){

                $data .='<option value="'.$files[$a].'">'.$files[$a].'</option>';
             }
            echo   $data;     
          
        }
            
        }
    }
?>