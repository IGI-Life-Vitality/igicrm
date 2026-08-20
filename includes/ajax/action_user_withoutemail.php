<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();

if(isset($_POST)) 
{
    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $first_name         = isset($_POST['first_name'])?$_POST['first_name']:'';
    $last_name          = isset($_POST['last_name'])?$_POST['last_name']:'';
    $user_type          = isset($_POST['user_type'])?$_POST['user_type']:'';
    $user_id            = isset($_POST['user_id'])?$_POST['user_id']:'';
    $email              = isset($_POST['email'])?$_POST['email']:'';
    $password           = isset($_POST['password'])?$_POST['password']:'';
    $employee_id        = isset($_POST['employee_id'])?$_POST['employee_id']:'';
    $mobile             = isset($_POST['mobile'])?$_POST['mobile']:'';
    $location           = isset($_POST['location'])?$_POST['location']: 0;
    $group_id           = isset($_POST['group_id']) != '' ? $_POST['group_id'] : 0;
    $date_time          = isset($_POST['date_time'])?$_POST['date_time']: '';
    $is_active          = isset($_POST['is_active'])?$_POST['is_active']:0;

    //$department_id      = isset($_POST['department_id'])?$_POST['department_id']:'';

    if (isset($_POST['action'])) 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save")
        {
            $response = $objUser->AddUsers($first_name,$last_name,$user_type,$user_id,$email,$password,$employee_id,$mobile,$location,$group_id,$date_time,$is_active);
            $response = explode("|",$response);
            $data = $response[1];
            if($response[0] > 0 && $group_id != 0)
                $data = $objUser->AddUsersToGroup($response[0],$group_id);
            echo $data;
        }
        elseif($action == "edit")
        {
            $response =  $objUser->UpdateUsers($id,$first_name,$last_name,$user_type,$email,$mobile,$location,$date_time,$group_id,$is_active);

            if($response == "success" && $group_id != 0)
            {
                $objUser->DeleteUsersFromGroup($id);
                echo $objUser->AddUsersToGroup($id,$group_id);
            }else
                echo "success";
        }
        elseif($action == "select_user")
        {
            $dataSelect = $objUser->GetUsersByGroupID($id);
            $SelectSubCategory .= " <select id='ddlUsers' name='ddlUsers' style='width: 280px;' multiple>";
            $SelectSubCategory .= "<option value='0'>".All."</option>";
            foreach ($dataSelect as $values) 
            {
                $SelectSubCategory .= "<option value=".$values['id']."> ".$values['user_name']."</option>";
            }
            $SelectSubCategory .= "</select>";

            echo $SelectSubCategory;
        }
        elseif($action == "select_users")
        {
            $dataSelect = $objUser->GetUsersByGroups($id);
            $SelectSubCategory .= " <select id='ddlUsers' name='ddlUsers' style='width: 280px;' multiple>";
            /*$SelectSubCategory .= "<option value='0'>".All."</option>";*/
            foreach ($dataSelect as $values) 
            {
                $SelectSubCategory .= "<option value=".$values['id']."> ".$values['user_name']."</option>";
            }
            $SelectSubCategory .= "</select>";
            echo $SelectSubCategory;
        }
        elseif($action == "select_assignedTousers")
        {
            $dataSelect = $objUser->GetUsersByGroupsForTask($id);
            $SelectSubCategory .= " <select id='ddlAssignedTo' name='ddlAssignedTo' style='width: 280px;'>";
            /*$SelectSubCategory .= "<option value='0'>".All."</option>";*/
            foreach ($dataSelect as $values) 
            {
                $SelectSubCategory .= "<option value=".$values['id']."> ".ucfirst($values['user_name'])."</option>";
            }
            $SelectSubCategory .= "</select>";
            echo $SelectSubCategory;
        }
        elseif($action == "select_verifiedByusers")
        {
            $dataSelect = $objUser->GetUsersByGroupsForTask($id);
            $SelectSubCategory .= " <select id='ddlVerifiedBy' name='ddlVerifiedBy' style='width: 280px;'>";
            /*$SelectSubCategory .= "<option value='0'>".All."</option>";*/
            foreach ($dataSelect as $values) 
            {
                $SelectSubCategory .= "<option value=".$values['id']."> ".ucfirst($values['user_name'])."</option>";
            }
            $SelectSubCategory .= "</select>";
            echo $SelectSubCategory;
        }
        elseif($action == "select_CCusers")
        {
            $dataSelect = $objUser->GetUsersByGroupsForTask($id);
            $SelectSubCategory .= " <select id='ddlCCUsers' name='ddlCCUsers' style='width: 280px;' multiple>";
            /*$SelectSubCategory .= "<option value='0'>".All."</option>";*/
            foreach ($dataSelect as $values) 
            {
                $SelectSubCategory .= "<option value=".$values['id']."> ".ucfirst($values['user_name'])."</option>";
            }
            $SelectSubCategory .= "</select>";
            echo $SelectSubCategory;
        }
    }
}
?>