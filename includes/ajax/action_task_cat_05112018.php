<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'task.php');
include(CLASSES_PATH.DS.'user.php');
include(CLASSES_PATH.DS.'taskcat.php');
$objTask = new Task();
$objUser = new User();
$objTaskcat = new Taskcat();

$login_id = $_SESSION['login_id'];

if(isset($_POST)) 
{
    $id                  = isset($_POST['id'])?$_POST['id']: 0;
    $id_subcat           = isset($_POST['id_subcat'])?$_POST['id_subcat']: 0;
    $id_ism              = isset($_POST['id_ism'])?$_POST['id_ism']: 0;
    $product_id          = isset($_POST['product_id'])?$_POST['product_id']:'';
    $product_category_id = isset($_POST['product_category']) ? $_POST['product_category'] : 0;
    $name                = isset($_POST['name'])?$_POST['name']:'';
    $tat                 = isset($_POST['tat'])?$_POST['tat']:'';
    $is_active           = isset($_POST['is_active'])?$_POST['is_active']:'';
    $mode                = isset($_POST['mode'])?$_POST['mode']: 0;
    $group_id            = isset($_POST['group_id']) != "" ? $_POST['group_id'] : 0;

    $escalation_id       = isset($_POST['escalation_id'])?$_POST['escalation_id']: 0;
    $time_period1        = isset($_POST['time_period1'])?$_POST['time_period1']: 0;
    $time_period2        = isset($_POST['time_period2'])?$_POST['time_period2']: 0;
    $time_period3        = isset($_POST['time_period3'])?$_POST['time_period3']: 0;
    $time_period4        = isset($_POST['time_period4'])?$_POST['time_period4']: 0;
    $time_period5        = isset($_POST['time_period5'])?$_POST['time_period5']: 0;
    $level1              = isset($_POST['level1'])?$_POST['level1']:'';
    $level2              = isset($_POST['level2'])?$_POST['level2']:'';
    $level3              = isset($_POST['level3'])?$_POST['level3']:'';
    $level4              = isset($_POST['level4'])?$_POST['level4']:'';
    $level5              = isset($_POST['level5'])?$_POST['level5']:'';

    $counter_display    = isset($_POST['counter_display']) ? $_POST['counter_display'] : '';

    if (isset($_POST['action'])) 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_task")
        {
            $id               = isset($_POST['txtId'])?$_POST['txtId']: 0;
            $opmode           = isset($_POST['op_mode'])?$_POST['op_mode']: 0;
            $counter          = isset($_POST['txtCounter'])?$_POST['txtCounter']: '';
            $task_num         = isset($_POST['txtTaskNo'])?$_POST['txtTaskNo']: '';
            $task_cat         = isset($_POST['ddlTaskCategory'])?$_POST['ddlTaskCategory']: '';
            $task_subcat      = isset($_POST['ddlSubCategory'])?$_POST['ddlSubCategory']: '';
            $task_ism         = isset($_POST['txtISM'])?$_POST['txtISM']: '';
            $task_ism_desc    = isset($_POST['txtISMDesc'])?$_POST['txtISMDesc']: '';
            $priority         = isset($_POST['ddlPriority'])?$_POST['ddlPriority']: '';
            $group_id         = isset($_POST['ddlGroup'])?$_POST['ddlGroup']: '';
            $assigned_to      = isset($_POST['ddlAssignedTo'])?$_POST['ddlAssignedTo']: '';
            $verified_by      = isset($_POST['ddlVerifiedBy'])?$_POST['ddlVerifiedBy']: '';
            $cc_users         = isset($_POST['ddlCCUsers'])?$_POST['ddlCCUsers']: '';
            $task_title       = isset($_POST['txtTitle'])?$_POST['txtTitle']: '';
            $start_time       = isset($_POST['datetimepicker_start'])?$_POST['datetimepicker_start']: '';
            $end_time         = isset($_POST['datetimepicker_end'])?$_POST['datetimepicker_end']: '';
            $task_desc        = isset($_POST['txtTaskDesc'])?$_POST['txtTaskDesc']: '';

            $task_ism_id      = isset($_POST['task_ism_id'])?$_POST['task_ism_id']: '';
            
            $policy_number    = isset($_POST['txtPolicy'])?$_POST['txtPolicy']: '';
            $tid              = isset($_POST['tid'])?$_POST['tid']: '0';

            if($priority =='High')
            {
                $priority ='1';
            }
            elseif($priority =='Low')
            {
                $priority ='2';
            }
            elseif ($priority =='Medium')
            {
                $priority ='3';
            }
        
            if($opmode == "0")
            {
                $assigned_to      = isset($_POST['usr_asignee'])?$_POST['usr_asignee']: '';
                $userdetails      = $objUser->GetUserDetail($assigned_to);
                $group_id        =  $userdetails["group_id"];
                //$group_id         = isset($_POST['ddlGroup'])?$_POST['ddlGroup']: '';
            }
            else
            {
                $assigned_to      = isset($_POST['user_id'])?$_POST['user_id']: '';
                $group_id         = isset($_POST['ddlGroup'])?$_POST['ddlGroup']: '';
            }

            $response = $objTask->SaveTaskNew($counter, $task_num, $task_cat, $task_subcat, $task_ism, $task_ism_desc, $task_title, $task_desc, $login_id, $group_id, $assigned_to, $verified_by, $cc_users, $start_time, $end_time, $priority, $task_ism_id, $policy_number,$tid);

            echo $response;
        }
        elseif($action == "edit_type")
        {
            if($level1 != '')
            {
                $level1 = implode(",", $level1);
            }
            if($level2 != '')
            {
                $level2 = implode(",", $level2);
            }
            if($level3 != '')
            {
                $level3 = implode(",", $level3);
            }
            if($level4 != '')
            {
                $level4 = implode(",", $level4);
            }
            if($level5 != '')
            {
                $level5 = implode(",", $level5);
            }

            $objComplaint->UpdateComplaintType($id,$group_id,$product_category_id,$product_id,$name,$tat,$mode,$is_active);

            echo $objComplaint->UpdateComplaintTypeEscalation($escalation_id,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5);
        }
        elseif($action == 'select_task_category')
        {
            $sub_task_cak = isset($_POST['task_subcat'])?$_POST['task_subcat']: 0;
            $data = $objTask->GetSubCategoryByCategoryID($id);
            $Option = "<option selected='selected' value='' disabled='disabled'>Select Subcategory</option>";

            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'". ($sub_task_cak == $row['id'] ? 'selected=selected' : '').">" . $row['fullname'] . "</option>";
            }

            echo $Option;
        }
        elseif($action  == 'select_task_subcategory')
        {
            $data        = $objTask->GetISMByCategoryANDSubCategory($id_ism);
            
            $user        = $objUser->GetUserNameById($data[0]["user_id"]);
            $userdetails = $objUser->GetUserDetail($data[0]["user_id"]);
            $usergroup   =  $userdetails["group_id"];
            $title = $objTaskcat->GetCategoryNameById($id)."-".$objTaskcat->GetSubCategoryNameById($id_subcat);
            $mode = $data[0]["operation_mode"];

            $Option      = $data[0]["fullname"] ."|". $data[0]["desc"] ."|". $user ."|". $data[0]["id"] ."|". $data[0]["user_id"]."|". $usergroup."|".$title."|".$mode."|".$data[0]["pri"];

            echo $Option;
        }
        elseif($action == 'update_progress')
        {
            $progress      = isset($_POST['progress'])?$_POST['progress']: '';
            $notes         = isset($_POST['notes'])?$_POST['notes']: '';
            $task_id       = isset($_POST['id'])?$_POST['id']: 0;
            $policy        = isset($_POST['policy'])?$_POST['policy']: 0;
            $priority      = isset($_POST['priority'])?$_POST['priority']: 0;
            $ism           = isset($_POST['ism'])?$_POST['ism']: 0;
            
            echo $objTask->ProgressTask($login_id,$task_id,$progress,$notes,$policy,$priority,$ism);
        }
        elseif($action == 'upload')
        {
            $errors         = array();

            $file_counter   = 0;
            $task_num   = isset($_POST['task_num'])?$_POST['task_num']:'';

            $dir = "../../uploads_eform_complaint/task_attachment/";

            if(isset($_FILES['fileupload1']) && $_FILES['fileupload1']['size'] != 0)
            {
                $file_name = $_FILES['fileupload1']['name'];
                $imagename = stripslashes($file_name);
                $imagename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $imagename);

                if(is_dir($dir.$task_num) == false)
                {
                    mkdir($dir.$task_num);
                }

                $uploaddir = $dir.$task_num."/".$task_num."_".$imagename;

                if(empty($errors) == true)
                {
                    move_uploaded_file($_FILES['fileupload1']['tmp_name'], $uploaddir);
                    $file_counter++;
                }
                else
                {
                    $errors[]="true";
                }
            }

            if(isset($_FILES['fileupload2']) && $_FILES['fileupload2']['size'] != 0)
            {
                $file_name = $_FILES['fileupload2']['name'];
                $imagename = stripslashes($file_name);
                $imagename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $imagename);

                if(is_dir($dir.$task_num) == false){
                    mkdir($dir.$task_num);
                }

                $uploaddir = $dir.$task_num."/".$task_num."_".$imagename;

                if(empty($errors)==true)
                {
                    move_uploaded_file($_FILES['fileupload2']['tmp_name'], $uploaddir);
                    $file_counter++;
                }
                else
                {
                    $errors[]="true";
                }
            }

            if(isset($_FILES['fileupload3']) && $_FILES['fileupload3']['size'] != 0)
            {
                $file_name = $_FILES['fileupload3']['name'];
                $imagename = stripslashes($file_name);
                $imagename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $imagename);

                if(is_dir($dir.$task_num) == false){
                    mkdir($dir.$task_num);
                }

                $uploaddir = $dir.$task_num."/".$task_num."_".$imagename;

                if(empty($errors)==true)
                {
                    move_uploaded_file($_FILES['fileupload3']['tmp_name'], $uploaddir);
                    $file_counter++;
                }
                else
                {
                    $errors[]="true";
                }
            }

            if(isset($_FILES['fileupload4']) && $_FILES['fileupload4']['size'] != 0)
            {
                $file_name = $_FILES['fileupload4']['name'];
                $imagename = stripslashes($file_name);
                $imagename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $imagename);

                if(is_dir($dir.$task_num) == false){
                    mkdir($dir.$task_num);
                }

                $uploaddir = $dir.$task_num."/".$task_num."_".$imagename;

                if(empty($errors)==true)
                {
                    move_uploaded_file($_FILES['fileupload4']['tmp_name'], $uploaddir);
                    $file_counter++;
                }
                else
                {
                    $errors[]="true";
                }
            }

            if(isset($_FILES['fileupload5']) && $_FILES['fileupload5']['size'] != 0)
            {
                $file_name = $_FILES['fileupload5']['name'];
                $imagename = stripslashes($file_name);
                $imagename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $imagename);

                if(is_dir($dir.$task_num) == false){
                    mkdir($dir.$task_num);
                }

                $uploaddir = $dir.$task_num."/".$task_num."_".$imagename;

                if(empty($errors)==true)
                {
                    move_uploaded_file($_FILES['fileupload5']['tmp_name'], $uploaddir);
                    $file_counter++;
                }
                else
                {
                    $errors[]="true";
                }
            }

            if(empty($errors))
            {
                echo ("success|".$task_num);
            }
            else
            {
                echo ("fail");
            }
        }
        elseif($action == 'search_task')
        {
            $TaskCategory         = isset($_POST['TaskCategory'])?$_POST['TaskCategory']: '';
            $SubCategory          = isset($_POST['SubCategory'])?$_POST['SubCategory']: '';
            $txtISM               = isset($_POST['txtISM'])?$_POST['txtISM']: '';
            $tsk_status           = isset($_POST['tsk_status'])?$_POST['tsk_status']: '';
            $FromDate             = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate               = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            $policy               = isset($_POST['policy'])?$_POST['policy']: '';
            $group_id             = $_SESSION['group_id'];
            $user_type            = $_SESSION['user_type'];

            $data = $objTaskcat->SearchTask($login_id,$user_type,$group_id,$TaskCategory,$SubCategory,$txtISM,$tsk_status,$FromDate,$ToDate,$policy);

            //print_r($data); die;

            $output ='';
            $output .='<table id="#data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Task <br>Status</th>
                                <th>Policy Number</th>
                                <th>Category</th>
                                <th>SubCategory</th>
                                <th>ISM</th>
                                <th>Start Date/Time</th>
                                <th>End Date/Time</th>
                                <th>Assigned To</th>
                                <th>Assigned By</th>
                                <th>SubTasks</th>
                            </tr>
                        </thead>';

                        $output .='<tbody>';
                                foreach($data as $row)
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

                                    $output .='<tr>';
                                        $output .='<td><a href="task_details.php?id='.$row['task_id'].'" title="Click here to see Details">'.$row["task_num"].'</a></td>';
                                        $output .='<td><a href="task_details.php?id='.$row['task_id'].'" class="btn btn-xs full-width '.$btnType.'">'.$task_status_id.'</a></td>';
                                        $output .='<td>'.$row["policy_number"].'</td>';
                                        /*$output .='<td width="300px">'.$row["task_title"].'</td>';*/
                                        $output .='<td>'.$objTaskcat->GetCategoryNameById($row["task_cat"]).'</td>';
                                        $output .='<td>'.$objTaskcat->GetSubCategoryNameById($row["task_subcat"]).'</td>';
                                        $output .='<td width="100px">'.$objTaskcat->GetIsmNameById($row["task_ism"]).'</td>';
                                        $output .='<td>'.$row["task_start_datetime"].'</td>';
                                    
                                        $end_date = '';
                                        if($deff > 0 AND ($row['task_status_id'] == 1 OR $row['task_status_id'] == 2))
                                        {
                                            $end_date .= '<span style="color:red">'.$row["task_end_datetime"].'</span>';
                                        }
                                        else
                                        {
                                           $end_date .= $row["task_end_datetime"];
                                        }
                                        $output .='<td>' . $end_date .'</td>';

                                        $assign_to_user = '';
                                        $task_verified_by = $row['task_assigned_to'];

                                        if($task_verified_by == $login_id)
                                        {
                                            $assign_to_user .= '<span class="blink_me" style="color:blue">'.ucfirst($row["assignedTo"]).'</span>';
                                        }
                                        else
                                        {
                                            $assign_to_user .= ucfirst($row["assignedTo"]);
                                        }
                                        $output .='<td>'. $assign_to_user .'</td>';

                                        $assign_by_user = '';
                                        $task_verified_by = $row['task_assignee'];
                                        if($task_verified_by == $login_id)
                                        {
                                            $assign_by_user .= '<span class="blink_me" style="color:blue">'. ucfirst($row["assignedBy"]).'</span>';
                                        }
                                        else
                                        {
                                            $assign_by_user .= ucfirst($row["assignedBy"]);
                                        }
                                        $output .='<td>'. $assign_by_user .'</td>';

                                        $stask = '';
                                        $subtask = $row['sub_task_id'];
                                        if($subtask != "0")
                                        {
                                            $stask .= '<a href="task_details.php?id='.$row['task_id'].'" title="Click here to see Details" class = "btn btn-danger btn-xs">SubTask</a>';
                                        }
                                        else 
                                        {

                                        }
                                        $output .='<td>'. $stask .'</td>';
                                    $output .='</tr>';
                                }
                        $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
       }
    }
}
?>