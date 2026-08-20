<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();

if(isset($_POST)) {

    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $module_id          = isset($_POST['moduleid']) ? $_POST['moduleid'] : '';
    $permission_type    = isset($_POST['permission']) ? $_POST['permission'] : '';

    if($action == 'get_permission'){
        echo $checkPermission = $objUser->GetPermissions($module_id,$permission_type);
    }

}

?>