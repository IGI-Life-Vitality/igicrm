<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'taskcat.php');
include(CLASSES_PATH.DS.'task.php');

$objTaskcat = new Taskcat();

if(isset($_POST)) 
{
    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $name               = isset($_POST['fullname'])?$_POST['fullname']:'';
    //$product_code     = isset($_POST['product_code'])?$_POST['product_code']:'';
    $product_category   = isset($_POST['product_category'])?$_POST['product_category']: 0;
    $is_active          = isset($_POST['isactive'])?$_POST['isactive']:'';
    $tat                = isset($_POST['tat'])?$_POST['tat']:'';
    $subcat             = isset($_POST['subcat'])?$_POST['subcat']:'';
    $task_category      = isset($_POST['task_category'])?$_POST['task_category']:'';
    $user_id            = isset($_POST['user_id'])?$_POST['user_id']:'';
    $desc               = isset($_POST['desc'])?$_POST['desc']:'';
    $onclose_task_ism   = isset($_POST['onclosed_task_ism'])?$_POST['onclosed_task_ism']: 0; 
    $depn_task_ism      = isset($_POST['depn_task_ism'])?$_POST['depn_task_ism']: 0;
    $sub_task_ism       = isset($_POST['sub_task_ism'])?$_POST['sub_task_ism']: 0; 
    $sub_task_ism       = implode(',', $sub_task_ism); 
    $mode               = isset($_POST['mode'])?$_POST['mode']:'';
    $is_main            = isset($_POST['is_main'])?$_POST['is_main']:'';
    $pri                = isset($_POST['pri'])?$_POST['pri']:'';
    $tism               = isset($_POST['tism'])?$_POST['tism']:'';
    $department_id      = isset($_POST['ddlDepartmentName'])?$_POST['ddlDepartmentName']:'';
    $ownership          = isset($_POST['ddlOwnership'])?$_POST['ddlOwnership']:''; // 4 ISM
    $ownership_name     = isset($_POST['txtOwnership'])?$_POST['txtOwnership']:''; // 4 Owner
    $minutes_activity   = isset($_POST['txtMinutesPerActivity']) ? $_POST['txtMinutesPerActivity']:'';

    if (isset($_POST['action'])) 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save")
        {
            echo $objTaskcat->AddSubCategory($name,$product_category,$is_active);
        }
        elseif($action == "edit")
        {
            echo $objTaskcat->UpdateSubCategory($id,$name,$product_category,$is_active);
        }
        elseif($action == 'category_save')
        {
            echo $objTaskcat->AddTaskCategory($name,$is_active);
        }
        elseif($action == "category_edit")
        {
            echo $objTaskcat->UpdateTaskCategory($name,$is_active,$id);
        }
        elseif($action == 'ownership_save')
        {
            echo $objTaskcat->AddOwnership($department_id,$ownership_name,$is_active);
        }
        elseif($action == "ownership_edit")
        {
            echo $objTaskcat->UpdateOwnership($id,$department_id,$ownership_name,$is_active);
        }
        elseif($action == 'select_subcat')
        {
            $data = $objTaskcat->GetSubCatBySubCatID($id);
            $Option = "<option disabled selected='selected'>Select SubCategories</option>";
            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
            }
            echo $Option;
        }
        elseif($action == 'save_ism')
        {
            if($sub_task_ism == '')
            {
                $sub_task_ism = 0;
            }

            if($onclose_task_ism == '')
            {
                $onclose_task_ism = 0;
            }
            
            echo $objTaskcat->SaveIsm($user_id,$department_id,$task_category,$subcat,$name,$tat,$mode,$desc,$ownership,$minutes_activity,$is_active,$depn_task_ism,$sub_task_ism,$onclose_task_ism,$pri);
        }
        elseif($action == "edit_ism")
        {
            if($sub_task_ism == '')
            {
                $sub_task_ism = 0;
            }
            if($onclose_task_ism == '')
            {
                $onclose_task_ism = 0;
            }
             echo $objTaskcat->UpdateIsm($id,$user_id,$department_id,$task_category,$subcat,$name,$tat,$mode,$desc,$ownership,$minutes_activity,$is_active,$depn_task_ism,$sub_task_ism,$onclose_task_ism,$pri);
        }
        elseif($action == "select_subtask_ism_desc")
        {
             $data =  $objTaskcat->GetIsmDesc($id);
              echo $data[0]['desc'];
        }
        elseif($action == "get_isms")
        {
            $data =  $objTaskcat->GetIsmss($subcat,$task_category);
            $option = "<option disabled selected>Select ISM</option>";
            foreach ($data as $row)
            {
                $option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
            }
            echo $option;
        }
        elseif($action == "get_tsk_ism")
        {
            $data =  $objTaskcat->GetTskIsmss($subcat,$task_category,$is_main);
            $option = "<option disabled selected value='0'>Select Task ISM</option>";
            foreach ($data as $row)
            {
                $option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
            }
            echo $option;
        }
        elseif($action == "reasign_user")
        {
            $data   =   $objTaskcat->GetIsamList($tism);
            $user   =   $data[0]['user_id'];
            $update =   $objTaskcat->Reasign_user($id,$user);
            echo $update;
        }
        elseif($action == "reasign_manual_user")
        {
            // $data   =   $objTaskcat->GetIsamList($tism);
            $assignedTo = isset($_POST['assignedTo'])?$_POST['assignedTo']:'';
            $user   =   $assignedTo;
            $update =   $objTaskcat->Reasign_user($id,$user);
            $task = new Task();
            $login_id = $_SESSION['login_id'];
            $task->SaveTaskStatus($login_id,$id,'6','In Progress',"Task reassigned to a new user");
            echo $update;
        }
        elseif($action == "get_ownership_list")
        {
            $depart_id = $id;
            $data =  $objTaskcat->GetOwnership($depart_id);
            $option = "<option disabled selected>Select Ownership</option>";
            foreach ($data as $row)
            {
                $option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
            }
            echo $option;
        }
    }
}
?>
