<?php
 function GetTask($login_id)
    {
        $query = '';

        if($login_id == 1)
        {
            $query .= "SELECT t.*, tism.fullname AS ism, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_task_isam tism ON tism.id = t.ism INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_verified_by ORDER BY t.task_id ASC";
        }
        else
        {
            $query .= "SELECT t.*, tism.fullname AS ism , us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_task_isam tism ON tism.id = t.ism INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_verified_by WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' OR t.task_verified_by = '$login_id' ORDER BY t.task_id ASC";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }