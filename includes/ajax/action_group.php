<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'group.php');

$objGroup = new Group();

if(isset($_POST)) {

    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $primary_name       = isset($_POST['primary_name'])?$_POST['primary_name']:'';
    $secondary_name     = isset($_POST['secondary_name'])?$_POST['secondary_name']:'';
    $email              = isset($_POST['email'])?$_POST['email']:'';
    $expiry_date        = isset($_POST['expiry_date'])?$_POST['expiry_date']:'';
    $groups             = isset($_POST['groups'])?$_POST['groups']:'';
    $users              = isset($_POST['users'])?$_POST['users']:'';
    $is_active          = isset($_POST['isactive'])?$_POST['isactive']:'';
    $permissions        = isset($_POST['permissions'])?stripcslashes($_POST['permissions']):'';

    $expiry_date = date('Y-m-d', strtotime($expiry_date));

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save"){

            $new_group_id = $objGroup->AddGroup($primary_name, $secondary_name, $email, $expiry_date, $is_active);

            //$new_group_id = 1;

            if($new_group_id > 0){

                if($groups != ''){
                    $new_groups = $objGroup->InheritGroupsPermission($groups, $new_group_id);
                }
                else{
                    $new_groups = $objGroup->SaveGroupsPermission($permissions, $new_group_id);
                }

                if($users != ''){
                    $new_users = $objGroup->AddUsersToGroup($users, $new_group_id);
                }

                echo "success";

            }
            else{
                echo "fail";
            }
        }
        elseif($action == "edit"){

            $update_groups = $objGroup->UpdateGroup($id, $primary_name, $secondary_name, $email, $expiry_date, $is_active);

            if($groups != ''){
                $new_groups = $objGroup->UpdateInheritGroupsPermission($groups, $id);
            }
            else{
                $update_groups = $objGroup->UpdateGroupsPermission($permissions, $id);
            }

            if($users != ''){
                $new_users = $objGroup->UpdateUsersToGroup($users, $id);
            }

            echo "success";

        }
    }

}

?>