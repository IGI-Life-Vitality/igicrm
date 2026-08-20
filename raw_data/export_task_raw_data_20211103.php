<?php
    include('../includes/config.php');
    include('../classes/task.php');

    ini_set("memory_limit","-1");
    set_time_limit(0);
    ini_set('max_execution_time', 2048);

    $login_id   = $_SESSION['login_id'];
    $user_type  = $_SESSION['user_type'];
    $group_id   = $_SESSION['group_id'];

    //print_r($login_id);die;

    $objTask    = new Task();
    $data1      = $objTask->GetTask($login_id,$user_type,$group_id);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="export_task_raw_data.csv"');

    echo $csv_head = "Task ID,Task Status,Policy Number,Category,SubCategory,ISM,Task Description,Priority,Created Date/Time,Updated Date/Time,Start Date/Time,End Date/Time,Assigned To,Assigned By \r\n";
    
    foreach($data1 as $row)
    {
        $task_end_datetime = $row["task_end_datetime"];
        $current_datetime  = Date('Y-m-d');
        $task_status_id    = $row['task_status_id'];

        $deff = $objTask->GetDateTimeDiff($task_end_datetime, $current_datetime);

        if($task_status_id == 1)
        {
            $task_status_id = "Initiated";
            $btnType = "btn-primary";
        }
        elseif($task_status_id == 2)
        {
            $task_status_id = "In Progress";
            $btnType = "btn-info";
        }
        elseif($task_status_id == 3)
        {
            $task_status_id = "Closed";
            $btnType = "btn-warning";
        }
        elseif($task_status_id == 4)
        {
            $task_status_id = "Verified";
            $btnType = "btn-success";
        }
        elseif($task_status_id == 5)
        {
            $task_status_id = "Invalid";
            $btnType = "btn-danger";
        }
        elseif($task_status_id == 6)
        {
            $task_status_id = "Onhold";
            $btnType = "btn-default";
        }

        if($deff > 0)
        { 
            if($task_status_id != "Onhold" && $task_status_id != "Closed" )
            {
                $btnType = "btn-danger";
            }
        }

        $cat_id = $row['task_cat'];
        $cat    = $objTask->GetTaskCatById($cat_id);

        $subcat_id = $row['task_subcat'];
        $subcat    = $objTask->GetSubCategoryByID($subcat_id);

        $ism_id = $row['task_ism'];
        $ism    = $objTask->getIsmById($ism_id);

        echo $csv_head = $row['task_num'].','.$task_status_id.','.$row['policy_number'].','.$cat[0]['fullname'].','.$subcat[0]['fullname'].','.$ism[0]['fullname'].','.preg_replace('/[\r\n]+/', " ", str_replace(',','',$row['task_desc'])).','.$row['priority'].','.$row['task_create_date'].','.$row['task_update_date'].','.$row['task_start_datetime'].','.$row['task_end_datetime'].','.$row['assignedTo'].','.$row['assignedBy']."\r\n";
    }

    exit();
?>