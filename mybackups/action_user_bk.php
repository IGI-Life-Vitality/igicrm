<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();

if(isset($_POST)) {

    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $user_id            = isset($_POST['user_id'])?$_POST['user_id']:'';
    $department_id      = isset($_POST['department_id'])?$_POST['department_id']:'';
    $email              = isset($_POST['email'])?$_POST['email']:'';
    $password           = isset($_POST['password'])?$_POST['password']:'';
    $is_active          = isset($_POST['isactive'])?$_POST['isactive']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){
            echo $objUser->AddUsers($user_id,$department_id,$email,$password,$is_active);
        }elseif($action == "edit"){
            echo $objUser->UpdateUsers($id,$department_id,$email,$is_active);
        }elseif($action == "select_user"){

            $dataSelect = $objUser->GetUsersByDepartment($id);
            $SelectSubCategory .= " <select id='ddlUsers' name='ddlUsers' style='width: 280px;' multiple>";
            foreach ($dataSelect as $values) {
                $SelectSubCategory .= "<option value=".$values['id']."> ".$values['user_id']."</option>";
            }
            $SelectSubCategory .= "</select>";

            echo $SelectSubCategory;
        }
    }

}

?>