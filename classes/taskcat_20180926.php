<?php
class Taskcat
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function AddSubCategory($fullname,$product_category,$is_active)
    {
        $query = "INSERT INTO tbl_task_subcategory (fullname,task_category,isactive) VALUES ('$fullname','$product_category','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateSubCategory($id,$fullname,$product_category,$isactive)
    {
        $query = "UPDATE tbl_task_subcategory SET fullname = '$fullname' , task_category = '$product_category', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        //return $response > 0 ? "success" : "fail";
        return "success";
    }

    function AddTaskCategory($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_task_category (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateTaskCategory($fullname,$is_active,$id)
    {
        $query = "UPDATE `tbl_task_category` SET fullname = '$fullname' , isactive = '$is_active' WHERE id = '$id'";
        $this->mysqli_lib->update($query);
        return "success";
    }

    /*function AddOwnership($department_id,$ownership,$is_active)
    {
        $query = "INSERT INTO tbl_task_ownership (fullname,department_id,isactive) VALUES ('$ownership','$department_id','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }*/

    /*function UpdateOwnership($id,$department_id,$ownership,$is_active)
    {
        $query = "UPDATE tbl_task_ownership SET department_id = '$department_id', fullname = '$ownership', isactive = '$is_active' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return $response > 0 ? "success" : "fail";
    }*/

    function GetTaskCategory($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_task_category` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_task_category`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_task_category` WHERE id = '$id'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSubcategoriesAll()
    {
        $query = "SELECT p.*, pc.fullname `category_name` FROM tbl_task_subcategory p
                INNER JOIN tbl_task_category pc ON pc.id = p.task_category";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSubcategoriesActive($id)
    {
        if($id == 0)
            $query = "SELECT * FROM tbl_task_subcategory WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_task_subcategory WHERE id = '$id'";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSubCatBySubCatID($id)
    {
        $query = "SELECT * FROM `tbl_task_subcategory` WHERE task_category = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetIsamList($id)
    {
        if($id == 0)
            $query = "SELECT t.*,m.task_ism_id,m.subtask_ism_id FROM tbl_task_isam t LEFT JOIN tbl_task_ism_mapping m ON m.task_ism_id = t.id";
        else
            //$query = "SELECT t.id `isam_id`, t.user_id, t.department_id,t.fullname,t.operation_mode,t.tat,t.isactive,t.task_category_id,t.sub_cat_id,t.desc,m.task_ism_id,m.subtask_ism_id FROM tbl_task_isam t INNER JOIN tbl_task_ism_mapping m ON m.task_ism_id = t.id WHERE t.id = '$id'";

            $query = "SELECT t.id `isam_id`, t.user_id, t.department_id, t.fullname,t.operation_mode,t.tat, t.minutes_activity, t.isactive,t.task_category_id, t.sub_cat_id, t.desc,m.task_ism_id AS onclose_task_ism_id, m.subtask_ism_id AS onclose_subtask_ism_id ,s.task_ism_id AS sub_task_ism_id,s.subtask_ism_id AS sub_subtask_ism_id FROM tbl_task_isam t LEFT JOIN tbl_task_ism_mapping m ON m.task_ism_id = t.id LEFT JOIN tbl_subtask_ism_mapping s ON s.task_ism_id = t.id  WHERE t.id = '$id'";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function SaveIsm($user_id,$department_id,$task_category_id,$sub_cat_id,$name,$tat,$mode,$desc,$ownership,$minutes_activity,$is_active,$depn_task_ism,$sub_task_ism,$onclose_task_ism,$pri)
    {
        $query = "INSERT INTO tbl_task_isam (user_id, department_id, task_category_id, sub_cat_id, fullname, tat, operation_mode, `desc`, priority, ownership, minutes_activity, isactive, created_on, updated_on) VALUES ('$user_id', '$department_id', '$task_category_id', '$sub_cat_id', '$name', '$tat', '$mode', '$desc', '$pri', '$ownership', '$minutes_activity', '$is_active', NOW(), '0000-00-00 00:00:00')";
        $response = $this->mysqli_lib->insert($query);

        if($response)
        {
            $query = "INSERT INTO tbl_task_ism_mapping (task_ism_id,subtask_ism_id, isactive)VALUES ('$response','$onclose_task_ism','1')";
            $this->mysqli_lib->insert($query);

            $query_sub = "INSERT INTO tbl_subtask_ism_mapping (task_ism_id,subtask_ism_id, isactive)VALUES ('$response','$sub_task_ism','1')";
            $this->mysqli_lib->insert($query_sub);

            $query_is_major = "UPDATE tbl_task_isam SET is_major = '0' WHERE id IN($sub_task_ism,$onclose_task_ism)";
            $this->mysqli_lib->update($query_is_major);
            return "success";
        }
        else 
        {
            return 0;
        }
    }

    function UpdateIsm($id, $user_id, $department_id, $task_category_id, $sub_cat_id, $name, $tat, $mode, $desc, $ownership, $minutes_activity, $is_active, $depn_task_ism, $sub_task_ism, $onclose_task_ism, $pri)
    {
        $query = "UPDATE tbl_task_isam SET user_id = '$user_id', department_id = '$department_id', task_category_id = '$task_category_id', sub_cat_id = '$sub_cat_id', fullname = '$name', tat = '$tat', operation_mode = '$mode' , `desc` = '$desc', priority = '$pri', ownership = '$ownership', minutes_activity = '$minutes_activity', isactive = '$is_active', updated_on = NOW() WHERE id = '$id'";

        $this->mysqli_lib->update($query);

         $query = "UPDATE tbl_task_ism_mapping SET subtask_ism_id = '$onclose_task_ism'  WHERE task_ism_id = '$id'";

        $this->mysqli_lib->update($query);

        $query_sub = "UPDATE tbl_subtask_ism_mapping SET subtask_ism_id = '$sub_task_ism'  WHERE task_ism_id = '$id'";
        $this->mysqli_lib->update($query_sub);

        $query_is_major = "UPDATE tbl_task_isam SET is_major = '0' WHERE id IN ($sub_task_ism,$onclose_task_ism)";
        $this->mysqli_lib->update($query_is_major);

        return "success";
    }

    function GetCategoryNameById($id)
    {
        $ids= explode(',',$id);
        $response ="";

        for($a=0;$a<count($ids);$a++)
        {
            $query_getcat = "SELECT fullname from tbl_task_category where id ='$ids[$a]'";
            $result = $this->mysqli_lib->fetch_all($query_getcat);
            $response .= $result[0]['fullname'].",";
        }

        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetSubCategoryNameById($id)
    {
        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++){

            $query_getsubcat = "SELECT fullname from tbl_task_subcategory where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getsubcat);

            $response .= $result[0]['fullname'].",";
        }
        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetIsmNameById($id)
    {
        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++){

            $query_getism = "SELECT fullname from tbl_task_isam where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getism);

            $response .= $result[0]['fullname'].",";
        }
        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetAllIsms()
    {
        $query = "SELECT * FROM `tbl_task_isam`";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetIsmDesc($id)
    {
        $query = "SELECT * FROM `tbl_task_isam` where id ='$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetIsmss($subcat,$task_category)
    {
        $query = "SELECT * FROM `tbl_task_isam` where task_category_id ='$task_category' and sub_cat_id = '$subcat'";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTskIsmss($subcat,$task_category,$is_main)
    {
        $query = "SELECT * FROM `tbl_task_isam` where task_category_id ='$task_category' and sub_cat_id = '$subcat' AND is_major = '$is_main'";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function Reasign_user($id,$user)
    {
        $query = "UPDATE tbl_task_new SET task_assigned_to = '$user' WHERE task_id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return $response > 0 ? "success" : "fail";
        //return "success";
    }

    function GetOwnership($depart_id)
    {
        $query = "SELECT * FROM tbl_task_ownership WHERE department_id = '$depart_id' AND isactive = 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetOwnershipList($id)
    {
        if($id != '')
        {
            $data .= "WHERE ow.id = '$id'";
        }

        $query = "SELECT ow.*, g.primary_name FROM tbl_task_ownership ow LEFT JOIN tbl_groups g ON g.id = ow.department_id $data ORDER BY ow.id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    /*function SearchTask($search_detail)
    {
        $query = "SELECT t.*, us.user_name AS assignedBy, usr.user_name 
                     AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to  $search_detail ORDER BY t.task_id DESC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }*/

    function SearchTask($login_id,$user_type,$group_id,$cat,$subcat,$ism,$status,$start_date,$end_date,$policy_num)
    {
        $query = '';

        if($cat != '')
        {
            $data .= " AND t.task_cat = '$cat'";
        }

        if($subcat != '')
        {
            $data .= " AND t.task_subcat = '$subcat'";
        }

        if($ism != '')
        {
            $data .= " AND t.task_ism = '$ism'";
        }

        if($status != '')
        {
            $data .= " AND t.task_status_id = '$status'";
        }

        if($start_date != '' && $end_date != '')
        {
            $data .= " AND DATE(t.task_start_datetime) BETWEEN '$start_date' AND '$end_date'";
        }

        if($policy_num != '')
        {
            $data .= " AND t.policy_number = '$policy_num'";
        }

        if($user_type == 1)
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name 
                     AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE 1=1 $data ORDER BY t.task_id DESC";
        }
        else if($user_type == 2)
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name 
                     AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE us.group_id IN ($group_id) $data ORDER BY t.task_id DESC";
        }
        else
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE (t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' OR t.task_verified_by = '$login_id') AND t.parent_task_id = '0' $data ORDER BY t.task_id DESC";
        }
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

}