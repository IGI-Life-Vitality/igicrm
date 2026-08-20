<?php
class Task 
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
        //$this->obj_user = new User();
    }

    function SaveTask($counter, $task_num, $task_type, $task_title, $task_desc, $login_id, $group_id, $assigned_to, $verified_by, $cc_users, $start_time, $end_time, $priority)
    {
        $start_time = date("Y-m-d H:i:s", strtotime($start_time));
        $end_time   = date("Y-m-d H:i:s", strtotime($end_time));

        $query = "INSERT INTO tbl_task(task_daily_counter, group_id ,task_num,task_type,task_title,task_desc,task_assignee,task_assigned_to,task_verified_by,task_cc_list,task_start_datetime,task_end_datetime,task_priority,task_create_date,task_update_date) VALUES ('".$counter."','".$group_id."','".$task_num."','".$task_type."','".$task_title."','".$task_desc."','".$login_id."','".$assigned_to."','".$verified_by."','".$cc_users."','".$start_time."','".$end_time."','".$priority."',NOW(), NOW())";
        $response = $this->mysqli_lib->insert($query);

        if($response > 0)
        {
            return "success";
        }
        else
        {
            return "fail";
        }
    }

    function SaveTaskNew($counter, $task_num, $task_cat, $task_subcat, $task_ism, $task_ism_desc, $task_title, $task_desc, $login_id, $group_id, $assigned_to, $verified_by, $cc_users, $start_time, $end_time, $priority, $task_ism_id, $policy_number, $tid,$channel='CRM')
    {
        $start_time = date("Y-m-d H:i:s");
        $end_tm = explode(' ', $start_time);
        $end_datetime = $this->GetEndDate($task_cat, $task_subcat, $task_ism_id, $start_time);

        $data_counter = explode('|', $this->GenTaskCounter());
        $task_num = $data_counter[0];
        $counter = $data_counter[1];

        $getTime = date("H:i:s");
        $end_datetime = substr($end_datetime, 0, 10);
        $end_datetime = $end_datetime . " " . $getTime;

        /*if($end_datetime = substr($end_datetime, 0, 4) == '1970'){
                $end_datetime = $this->GetEndDate($task_cat, $task_subcat, $task_ism_id, $start_time);
                $end_datetime = substr($end_datetime, 0, 10);
                $end_datetime = $end_datetime . " " . $getTime;

        }*/

        $query = "INSERT INTO tbl_task_new(task_daily_counter, group_id ,task_num,task_cat,task_subcat,task_ism,task_ism_desc,task_title,task_desc,task_assignee,task_assigned_to,task_verified_by,task_cc_list,task_start_datetime,task_end_datetime,task_priority,task_create_date,task_update_date,policy_number,sub_task_id,parent_task_id, is_complete,channel) VALUES ('".$counter."', '".$group_id."' ,'".$task_num."','".$task_cat."','".$task_subcat."','".$task_ism_id."','".$task_ism_desc."','".$task_title."','".$task_desc."','".$login_id."','".$assigned_to."','".$verified_by."','".$cc_users."','".$start_time."','".$end_datetime."','".$priority."',NOW(),NOW(), '".$policy_number."','0','$tid','0','".$channel."')";

        $response = $this->mysqli_lib->insert($query);
        $res ="";

        if($response > 0)
        {
            if($tid != 0)
            {
                $query = "SELECT sub_task_id FROM tbl_task_new WHERE task_id = '$tid'";
                $taskdetail =  $this->mysqli_lib->fetch_all($query);
                $sb_tsk_id = $taskdetail[0]['sub_task_id'];

                if($sb_tsk_id != "")
                {
                   $res =  $sb_tsk_id.",".$response;
                }
                else
                {
                    $res =  $response;
                }

                $query = "UPDATE tbl_task_new SET sub_task_id = '$res', task_status_id = '6' WHERE task_id = '$tid'";
                $this->mysqli_lib->update($query);
                $this->SaveTaskStatus($login_id,$tid,'6','In Progress',$task_desc);
            }
            if($channel == 'APP'){
                $taskId = $response;
                $response = array("status" => 1,"task_id" => $taskId, "task_num" => $task_num);
                return $response;
            }
            return "success|".$task_num;
        }
        else
        {
            if($channel == 'APP'){
                $response = array("status" => 0);
                return $response;
            }
            return "fail";
        }
    }

    function GetTask($login_id,$user_type,$group_id,$fromDate,$toDate)
    {
        $dateFilter='';
        if ($fromDate && $toDate) {
            $dateFilter = " AND DATE(t.task_create_date) BETWEEN '$fromDate' AND '$toDate' ";
        } elseif ($fromDate) {
            $dateFilter = " AND DATE(t.task_create_date) >= '$fromDate' ";
        } elseif ($toDate) {
            $dateFilter = " AND DATE(t.task_create_date) <= '$toDate' ";
        }
        // -----------------------------
    // Role based filters
    // -----------------------------
        $baseQuery = "
            SELECT 
                t.*, 
                us.user_name AS assignedBy, 
                usr.user_name AS assignedTo, 
                pr.priority 
            FROM tbl_task_new t 
            LEFT JOIN tbl_users us ON us.id = t.task_assignee 
            LEFT JOIN tbl_priority pr ON pr.id = t.task_priority 
            LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to
            WHERE 1=1
            $dateFilter
        ";
        if ($user_type == 1) {

            $query = $baseQuery . " ORDER BY t.task_id DESC";

        } elseif ($user_type == 2) {

            $query = $baseQuery . " AND us.group_id IN ($group_id)
                    ORDER BY t.task_id DESC";

        } elseif ($user_type == 4) {

            $query = $baseQuery . " AND (t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id')
                    ORDER BY t.task_id DESC";

        } else {

        // FIXED LOGIC (important)
        $query = $baseQuery . " 
            AND (t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id')
            AND t.parent_task_id = '0'
            ORDER BY t.task_id DESC
        ";
    }
    
    //return $query;
        // $query = '';

        // if($user_type == 1)
        // {
        //     $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to LEFT JOIN tbl_users usrs ON usrs.id = t.task_assigned_to ORDER BY t.task_id DESC";
        // }
        // else if($user_type == 2)
        // {
        //     $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to LEFT JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE us.group_id IN ($group_id) ORDER BY t.task_id DESC";
        // }
        // else if($user_type == 4)
        // {
        //     $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to LEFT JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' ORDER BY t.task_id DESC";
        // }
        // else
        // {
        //     $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to LEFT JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' AND t.parent_task_id = '0' ORDER BY t.task_id DESC";
        // }

	//return $query;
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTaskStatus($task_id)
    {
        $task_id = intval($task_id);

        $query = "SELECT * 
                FROM tbl_task_status 
                WHERE task_id = '$task_id' 
                ORDER BY id DESC 
                LIMIT 1";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTaskById($id)
    {
       /* $query = "SELECT t.*, ty.task_type_name, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy, usrc.user_name AS CCUsers, ts.progress, ts.comments FROM tbl_task t INNER JOIN tbl_task_type ty ON ty.id = t.task_type INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_verified_by LEFT JOIN tbl_users usrc ON usrc.id = t.task_cc_list LEFT JOIN tbl_task_status ts ON ts.task_id = t.task_id WHERE t.task_id = '$id' ORDER BY ts.id DESC LIMIT 1";*/

       $query = "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo,pr.priority,ts.progress, ts.comments, s.fullname task_status_name FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to  LEFT JOIN tbl_task_status ts ON ts.task_id = t.task_id LEFT JOIN tbl_status s ON s.id = t.task_status_id  WHERE t.task_id = '$id' ORDER BY ts.id DESC LIMIT 1";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function SaveTaskStatus($login_id,$task_id,$status_id,$progress,$notes)
    {
        
        $query = "INSERT INTO tbl_task_status (login_id,task_id,current_state,progress,comments) VALUES('$login_id','$task_id','$status_id','$progress','$notes')";
        $this->mysqli_lib->insert($query);
    }

    function GetTaskStatusById($task_id)
    {
        $query = "SELECT t.*, usr.user_name FROM tbl_task_status t INNER JOIN tbl_users usr ON usr.id = t.login_id WHERE t.task_id = '$task_id' ORDER BY t.id DESC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function ConfirmManualAssignment($task_cat,$task_subcat,$task_ism)
    {
        $query = "SELECT * FROM tbl_task_isam WHERE id = '$task_ism' AND task_category_id = '$task_cat' AND sub_cat_id = '$task_subcat' ";
        return $this->mysqli_lib->fetch_all($query);
    }

    function ProgressTask($login_id,$task_id,$progress,$comments,$policy,$priority,$ism,$assign_to=0)
    {
        $task_is_complete = '0';
        if($progress == '100') // for complete
        {
            $query = "SELECT * FROM tbl_task_ism_mapping WHERE task_ism_id = '$ism'";
            $subtask = $this->mysqli_lib->fetch_all($query); 
            $subtask_id = $subtask[0]['subtask_ism_id'];
            if($subtask_id != 0)
            {
                $query         = "SELECT * FROM tbl_task_isam WHERE id = '$subtask_id'";
                $subtaskism    = $this->mysqli_lib->fetch_all($query); 
                $us_details    = $this->GetUserDetail($subtaskism[0]['user_id']);
                $gp_id         = $us_details['group_id'];
                $start_time    = date("Y-m-d H:i:s");
                $task_cat      = $subtaskism[0]['task_category_id'];
                $task_subcat   = $subtaskism[0]['sub_cat_id'];
                $task_ism_id   = $subtaskism[0]['id'];
                $task_ism_desc = $subtaskism[0]['desc'];
                $assigned_to   = $subtaskism[0]['user_id'];
                $end_datetime  = $this->GetEndDate($task_cat, $task_subcat, $task_ism_id, $start_time);
                $verified_by   = "0";
                $cc_users      = "0";
                $verified_by   = "0";
                $task_desc     = "0";
                $catname       = $this->GetCategoryNameById($subtaskism[0]['task_category_id']);
                $subcat_name   = $this->GetSubCategoryNameById($subtaskism[0]['sub_cat_id']);
                $task_title    = $catname."-".$subcat_name;
                //$task_title    = $subtaskism[0]['desc'];
                $subtsk = "";
                
                if(!empty($subtaskism))
                {
                    $data_counter = explode('|',$this->GenTaskCounter());
                    $task_num = $data_counter[0];
                    $counter = $data_counter[1];

                    $query = "INSERT INTO tbl_task_new(task_daily_counter, group_id ,task_num,task_cat,task_subcat,task_ism,task_ism_desc,task_title,task_desc,task_assignee,task_assigned_to,task_verified_by,task_cc_list,task_start_datetime,task_end_datetime,task_priority,task_create_date,task_update_date, policy_number,sub_task_id,parent_task_id,is_complete) VALUES ('".$counter."', '".$gp_id."' ,'".$task_num."','".$task_cat."','".$task_subcat."','".$task_ism_id."','".$task_ism_desc."','".$task_title."','".$task_desc."','".$login_id."','".$assigned_to."','".$verified_by."','".$cc_users."','".$start_time."','".$end_datetime."','$priority',NOW(),NOW(), '".$policy."','0','$task_id','0')";
                    $response = $this->mysqli_lib->insert($query);
                    $taskdetails = $this->GetTaskById($task_id);
                    
                    if($taskdetails[0]['sub_task_id'] != 0)
                    {
                       $subtsk = $taskdetails[0]['sub_task_id'] .",".$response;
                    }
                    else
                    {
                        $subtsk = $response;
                    }

                    $query = "UPDATE tbl_task_new SET sub_task_id = '$subtsk' WHERE task_id = '$task_id'";
                      $this->mysqli_lib->update($query);
                } 
                
                $task_status_id = '2';
            }
            else
            {
                $task_status_id = '3';
            }
           
            $task_is_complete = '1';
        }
        elseif($progress == '101') // for onhold
        {
            $task_status_id = '5';
            $progress = '0';
        }
        elseif($progress == 'initiated') // for initiated
        {
            $task_status_id = '1';
            $progress = '0';
        }
        else // for in process
        {
            $task_status_id = '2';
        }
        $query_bf = "SELECT * FROM tbl_task_new WHERE DATE(task_start_datetime) < DATE(NOW()) AND task_status_id != '3' AND task_id = '$task_id'";
        $task_bf = $this->mysqli_lib->fetch_all($query_bf);

        if(count($task_bf) > 0)
        {
            $query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', is_complete = '$task_is_complete', is_bf = '1', task_update_date = NOW() WHERE task_id = '$task_id'";
            //$query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', is_complete = '$task_is_complete', is_bf = '1', task_update_date = NOW(), task_assignee = '$login_id', task_assigned_to = '$assign_to' WHERE task_id = '$task_id'";
        }
        else 
        {
            $query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', is_complete = '$task_is_complete', task_update_date = NOW() WHERE task_id = '$task_id'";
            //$query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', is_complete = '$task_is_complete', task_update_date = NOW(), task_assignee = '$login_id', task_assigned_to = '$assign_to' WHERE task_id = '$task_id'";
        }

        $this->mysqli_lib->update($query);

        //`echo "$query" >> /tmp/query.log`;
        $query = "SELECT task_assignee FROM tbl_task_new WHERE task_id = '$task_id'";
        $taskNew = $this->mysqli_lib->fetch_all($query); 

        if($taskNew[0]['task_assignee'] == 0)
        {
            $query = "UPDATE tbl_task_new SET  task_assignee = '$login_id', task_assigned_to = '$assign_to' WHERE task_id = '$task_id'";
            $this->mysqli_lib->update($query);
        }
        else
        {
            $query = "UPDATE tbl_task_new SET  task_assigned_to = '$assign_to' WHERE task_id = '$task_id'";
            $this->mysqli_lib->update($query);
        }

        $this->SaveTaskStatus($login_id,$task_id,$task_status_id,$progress,$comments);
        $tskdetails = $this->GetTaskById($task_id);
        $ptid = $tskdetails[0]['parent_task_id'];

        if($ptid != 0)
        {
            $parentdetails = $this->GetTaskById($ptid);
            $stid = $parentdetails[0]['sub_task_id'];
            $iscomplete = $parentdetails[0]['is_complete'];
            $subtask_status = $this->GetSubTaskStatus($stid);
        
            if($subtask_status == "")
            {
               $task_status_id = '6';
            }
            else
            {
                if($iscomplete == "1" && $progress == '100')
                {
                    $task_status_id = '3';
                    $query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', task_update_date = NOW() WHERE task_id = '$ptid'";
                    $this->mysqli_lib->update($query);
                }
                else if($iscomplete == "0" && $progress == '100')
                {
                    $task_status_id = '2';

                    $query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id', task_update_date = NOW() WHERE task_id = '$ptid'";
                    $this->mysqli_lib->update($query);
                }
                else
                {
                    //$task_status_id = '2';
                    //$query = "UPDATE tbl_task_new SET task_status_id = '$task_status_id' WHERE task_id = '$ptid'";
                    //$this->mysqli_lib->update($query);
                }
            }  
        }

        return $res1 = "success";
    }

    function GetPriority()
    {
        $query = "SELECT * FROM tbl_priority WHERE is_active = 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTaskType()
    {
        $query = "SELECT * FROM tbl_task_type ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTaskCat()
    {
        $query = "SELECT * FROM tbl_task_category ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTaskCatById($cat_id)
    {
        $query = "SELECT * FROM tbl_task_category WHERE id = '$cat_id' ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getIsmById($ism_id)
    {
        $query  = "";

        $query .= "SELECT * FROM tbl_task_isam WHERE id = '$ism_id' ORDER BY id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSubCategoryByID($id)
    {
        $query = "SELECT * FROM tbl_task_subcategory WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSubCategoryByCategoryID($id)
    {
        $query = "SELECT * FROM tbl_task_subcategory WHERE task_category = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetISMByCategoryANDSubCategory($id)
    {
        // if($tid == 0){
        // $query = "SELECT * FROM tbl_task_isam WHERE task_category_id = '$id' AND sub_cat_id = '$id_subcat' AND is_major ='$is_main'";
           // $query = "SELECT * FROM tbl_task_isam WHERE id = '$id'";

            $query = "SELECT tbl_task_isam.* , tbl_priority.priority AS pri FROM tbl_task_isam INNER JOIN tbl_priority ON tbl_priority.id = tbl_task_isam.priority WHERE tbl_task_isam.id='$id'";
        // }else{
        //     $query = "SELECT * FROM tbl_task_isam WHERE id = (SELECT tbl_subtask_ism_mapping.subtask_ism_id FROM tbl_subtask_ism_mapping INNER JOIN tbl_task_new ON tbl_subtask_ism_mapping.task_ism_id = tbl_task_new.task_ism WHERE tbl_task_new.task_id = '$tid')";

        // }
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetISMGroupId($task_cat,$task_subcat,$task_ism)
    {
        $query = "SELECT * FROM tbl_task_isam WHERE id = '$task_ism' AND task_category_id = '$task_cat' AND sub_cat_id = '$task_subcat' ";
        return $this->mysqli_lib->fetch_all($query);
    }

    /*function GetISMInfo($id_ism)
    {
        $query = "SELECT * FROM tbl_task_isam WHERE id = '$id_ism'";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }*/

    function GetTaskList($id)
    {
        $query = "SELECT * FROM tbl_task WHERE task_id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GenTaskCounter()
    {
	$time = microtime(true);
        $micro_time = sprintf("%06d",($time - floor($time)) * 1000000);

        $first_digit = "TS";
        $today = date("Y-m-d");
        $date_part = date("ymd".$micro_time);

        $sql="SELECT IFNULL(MAX(task_daily_counter)+1,1) AS daily_counter FROM `tbl_task_new` WHERE DATE(`task_create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%04d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GetDateTimeDiff($task_end_datetime, $current_datetime)
    {
      $task_end_datetime = strtotime($task_end_datetime);
      $current_datetime = strtotime($current_datetime);
      $diff = $current_datetime - $task_end_datetime;
      return round($diff / 86400);
    }

    function GetDateTimeDiffHour($task_end_datetime, $current_datetime)
    {
      $task_end_datetime = strtotime($task_end_datetime);
      $current_datetime = strtotime($current_datetime);
      $diff = $current_datetime - $task_end_datetime;
      return round($diff / 3600);
    }

    /*function GetEndDate($task_categ,$sub_cat_id,$task_ism_id)
    {        
        $query = "SELECT tat FROM tbl_task_isam WHERE id = '$task_ism_id' AND task_category_id = '$task_categ' AND sub_cat_id = '$sub_cat_id' AND isactive = 1"; 
        $data = $this->mysqli_lib->fetch_all($query);

        $tat = $data[0]['tat'];
        $end_date = date('Y-m-d' ,strtotime("+$tat hours"));        
        return $end_date;  
    }*/

    function GetEndDate($task_categ,$sub_cat_id,$task_ism_id,$start_date)
    {
        $query = "SELECT tat FROM tbl_task_isam WHERE id = '$task_ism_id' AND task_category_id = '$task_categ' AND sub_cat_id = '$sub_cat_id' AND isactive = 1"; 
        
        $data       = $this->mysqli_lib->fetch_all($query);
        $tat        = $data[0]['tat'];
        $tat        = $tat;
	$start_date = $start_date;
        $end_date   = date('Y-m-d', strtotime("+$tat weekdays"));
        return $this->EndDate($start_date,$end_date);
    }

    function EndDate($start_date,$end_date)
    {
        $query = "SELECT week_day FROM tbl_calendar_weekends";
        $data = $this->mysqli_lib->fetch_all($query);

        //$query = "SELECT * FROM tbl_calendar_holidays WHERE '$end_date' BETWEEN from_date AND to_date";

	$query = "SELECT *, DATEDIFF(to_date,from_date)+1 AS HoliDaysCounts FROM tbl_calendar_holidays WHERE from_date BETWEEN '$start_date' AND '$end_date' OR to_date BETWEEN '$start_date' AND '$end_date'";
        
    //updated query change on muharram 2021 
      //not proper tested
    /*$QUERY = "SELECT *, DATEDIFF(to_date,from_date)+1 AS HoliDaysCounts FROM tbl_calendar_holidays WHERE from_date BETWEEN '$start_date' AND '$end_date' OR to_date BETWEEN '$start_date' AND '$end_date' UNION SELECT *, DATEDIFF(to_date,from_date)+1 AS HoliDaysCounts FROM tbl_calendar_holidays WHERE DATE('$end_date') BETWEEN DATE(tbl_calendar_holidays.from_date) AND DATE(tbl_calendar_holidays.to_date) ORDER BY id DESC LIMIT 1"; *///CHANGE ON muharram 2021 

        //$query = "SELECT *, DATEDIFF(to_date,from_date)+1 AS HoliDaysCounts FROM tbl_calendar_holidays WHERE DATE('$end_date') BETWEEN DATE(tbl_calendar_holidays.from_date) AND DATE(tbl_calendar_holidays.to_date)";  //change on muharram 2021 
    
        $responses = $this->mysqli_lib->fetch_all($query);
	
	//if Holidays exist
        if (!empty($responses)) 
        {
            /*$current_date = date('Y-m-d');
            $currentTime        = strtotime($current_date);
            $from_time          = strtotime($response[0]['from_date']);
            $tat               = round(($currentTime - $from_time)/(60*60));*/

            foreach ($responses as $response) 
            {
		$HoliDaysCounts = $response['HoliDaysCounts'];      // Holidays Counts
                //$end_date = date('Y-m-d', date(strtotime("+1 day", strtotime($response['to_date']))));
		$end_date = date('Y-m-d', strtotime($end_date));
		$end_date = date('Y-m-d', date(strtotime("+$HoliDaysCounts day", strtotime($end_date))));
                $Day = date("D", strtotime($end_date));

                foreach ($data as $row) 
                {
                    //if (strtolower($Day) == $row['week_day']) 
		    if (strtolower($Day) == "sat" || strtolower($Day) == "sun")
                    {
                        if (strtolower($Day) == 'sat') 
			{
				//$end_date = date('Y-m-d', date(strtotime("+$HoliDaysCounts day", strtotime($end_date))));
                            	$end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                            	return $end_date;
                        } 
			elseif (strtolower($Day) == 'sun') 
			{
				//$end_date = date('Y-m-d', date(strtotime("+$HoliDaysCounts day", strtotime($end_date))));
                            	$end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                            	return $end_date;
                        }
                    } 
                    else 
                    { 
			//$end_date = date('Y-m-d', date(strtotime("+$HoliDaysCounts day", strtotime($end_date))));
			$end_date = date('Y-m-d', strtotime($end_date));
                        return $end_date;
                    }
                }
            }
        } 
        else 
        {
            $Day = date("D", strtotime($end_date));

            foreach ($data as $row) 
            {
                if (strtolower($Day) == "sat" || strtolower($Day) == "sun")
                {
                    if (strtolower($Day) == 'sat') 
                    {
                        $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                        return $end_date;
                    } 
                    elseif (strtolower($Day) == 'sun') 
                    {
                        $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                        return $end_date;
                    }
                }
            }
        }
        
        $end_date = date('Y-m-d 00:00:00', strtotime($end_date));
        return $end_date;
    }

    function missing_params()
    {
        $data[0] = array(
            'status'   => 'Some Parameters Missing'
        );
        return json_encode($data);
    }

    function log_tracking($log, $fol, $type)
    {
        $log_file = "../../logs/" . $fol . "/" . $type . "_" . date('Ymd') . ".txt";
        //return $log_file;
        $fh = fopen($log_file, 'a');
        $file_data = "\"" . date('Y-m-d H:i:s') . "\"," . $log . "\r\n";
        fwrite($fh, $file_data);
        fclose($fh);
    }

    function GetSubTaskByTaskId($task_id)
    {
        $query = '';

        /*if($login_id == 1)
        {
            $query .= "SELECT t.*, ty.task_type_name, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task t INNER JOIN tbl_task_type ty ON ty.id = t.task_type INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_verified_by ORDER BY t.task_id ASC";
        }
        else
        {
            $query .= "SELECT t.*, ty.task_type_name, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task t INNER JOIN tbl_task_type ty ON ty.id = t.task_type INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_verified_by WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' OR t.task_verified_by = '$login_id' ORDER BY t.task_id ASC";
        }*/


        if($login_id == 1)
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name 
                     AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to where t.parent_task_id = '$task_id'  ORDER BY t.task_id DESC";
        }
        else
        {
             $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE t.parent_task_id = '$task_id' ORDER BY t.task_id DESC";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUserDetail($userid)
    {
        $query = "SELECT * FROM tbl_users WHERE id = '".$userid."'";
        $getuserdetails = $this->mysqli_lib->query_execute($query);
        return $getuserdetails;
    }

    function GetSubTaskStatus($id)
    {
        $ids = explode(',',$id);
        $response ="";

        for($a=0;$a<count($ids);$a++)
        {
            $query = "SELECT task_status_id from tbl_task_new where task_id ='$ids[$a] and task_status_id = '3'";
            $result = $this->mysqli_lib->fetch_all($query);

            if(!empty($result))
            {
                $response .= $result[0]['task_status_id'].",";
            }
        }

        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetSubCategoryNameById($id)
    {
        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++)
        {
            $query_getsubcat = "SELECT fullname from tbl_task_subcategory where id ='$ids[$a]'";
            $result = $this->mysqli_lib->fetch_all($query_getsubcat);
            $response .= $result[0]['fullname'].",";
        }
        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetCategoryNameById($id)
    {
        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++){

            $query_getcat = "SELECT fullname from tbl_task_category where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getcat);

            $response .= $result[0]['fullname'].",";
        }
        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetTaskTreeView($login_id,$user_type)
    {
        $query = '';
        if($user_type == 1 || $user_type == 2)
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name 
                     AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to  ORDER BY t.task_id DESC";
        }
        else
        {
            $query .= "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority, usrs.user_name AS verifiedBy FROM tbl_task_new t INNER JOIN tbl_users us ON us.id = t.task_assignee INNER JOIN tbl_priority pr ON pr.id = t.task_priority INNER JOIN tbl_users usr ON usr.id = t.task_assigned_to INNER JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' OR t.task_verified_by = '$login_id' and parent_task_id = '0' ORDER BY t.task_id DESC";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetTasksdetail($id)
    {
        $query = "SELECT subtask_ism_id FROM tbl_subtask_ism_mapping WHERE task_ism_id = (SELECT task_ism FROM tbl_task_new WHERE task_id ='$id')";
        $subtask = $this->mysqli_lib->query_execute($query); 
        $subtask_id = $subtask['subtask_ism_id'];
        if($subtask_id != 0)
        {
            $query         = "SELECT * FROM tbl_task_isam WHERE id = '$subtask_id'";
            $subtaskism    = $this->mysqli_lib->fetch_all($query);
        }
        return $subtaskism;
    }

    function GetSubTaskById($id)
    {
        $query = "SELECT subtask_ism_id FROM tbl_subtask_ism_mapping WHERE task_ism_id = (SELECT task_ism FROM tbl_task_new WHERE task_id ='$id')";
        $subtask = $this->mysqli_lib->query_execute($query); 
        return $subtask;
    }

    function GetAppTask($login_id,$user_type,$group_id)
    {
        $query = "SELECT t.*, us.user_name AS assignedBy, usr.user_name AS assignedTo, pr.priority FROM tbl_task_new t LEFT JOIN tbl_users us ON us.id = t.task_assignee LEFT JOIN tbl_priority pr ON pr.id = t.task_priority LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to LEFT JOIN tbl_users usrs ON usrs.id = t.task_assigned_to WHERE channel = 'APP' ORDER BY t.task_id DESC limit 100";
        
        return $this->mysqli_lib->fetch_all($query);
    }
}
?>
