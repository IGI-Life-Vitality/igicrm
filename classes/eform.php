<?php

class eform
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }


    function GenDailyCounter()
    {
        $first_digit = "EF";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_eform_add` WHERE DATE(current_datetime) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];

    }


    function InsertEForm($counter ,$group_id, $userid, $eform, $cnic, $cust_name, $cust_rim, $prod_categ, $product_id, $eform_type, $priority, $account, $card_no, $source,
                         $po_box, $office_addr, $residence_addr, $delievery_addr, $alternate_addr, $residence_num, $office_num, $mobile_num, $email, $company, $department, $emirate, $is_email, $cust_email, $is_sms,
                         $cust_mobile, $language, $is_call_back)
    {

        $end_datetime = $this->GetEndDate($prod_categ,$product_id,$eform_type);

        $agent_id = $_SESSION['login_id'];

        $query = "INSERT INTO tbl_eform_add(id,daily_counter,group_id,user_id,agent_id,eform_num,product_category,product_id,eform_type_id,
                                            priority_id,status_id,
                                            current_datetime,closed_datetime,end_datetime)
                  VALUES(NULL,'$counter','$group_id','$userid','$agent_id','$eform','$prod_categ','$product_id','$eform_type',
                         '$priority','1',NOW(),'','$end_datetime')";

        `echo "$query"  >> /tmp/query.log`;

        $response = $this->mysqli_lib->insert($query);
        if($response > 0){
            $query = "INSERT INTO tbl_eform_details(eform_id,cnic,customer_name,customer_rim,account_no,card_no,source,pobox_no,
                                                    office_address,residence_address,delievery_address,alternate_address,residence_num,office_num,mobile_num,
                                                    email,company_name,department,emirate,is_email,customer_email,is_sms,customer_mobile_num,`language`,is_call_back)
				      VALUES('$response','$cnic','$cust_name','$cust_rim','$account','$card_no','$source','$po_box','$office_addr','$residence_addr',
				              '$delievery_addr','$alternate_addr','$residence_num','$office_num','$mobile_num','$email','$company','$department','$emirate',
				              '$is_email','$cust_email','$is_sms','$cust_mobile','$language','$is_call_back')";

            $result = $this->mysqli_lib->insert($query);
            if($result > 0){
                $query = "SELECT group_id FROM  tbl_eform_type WHERE product_category_id = '$prod_categ' AND product_id = '$product_id' AND id = '$eform_type' AND operation_mode = '1'";

                $data = $this->mysqli_lib->fetch_all($query);
                if(!empty($data)){
                    $group_id = $data[0]['group_id'];
                    $query = "SELECT GROUP_CONCAT(user_id) AS user_id FROM tbl_users_group WHERE group_id = '$group_id'";
                    $users_id = $this->mysqli_lib->fetch_all($query);
                    $users_id = $users_id[0]['user_id'];
                    if($users_id != ''){
                        $query = "UPDATE tbl_eform_add SET group_id = '$group_id', user_id = '$users_id', status_id = '2', forward_datetime = NOW() WHERE id = '$response'";
                        $this->mysqli_lib->update($query);
                    }
                }
            }

            //$this->SaveNotification($response,date("Y-m-d h:i:s"));
            return $response;
        }else{
            return "fail";
        }
    }

    function SaveNotification($id,$date_time){
        $query = "INSERT INTO tbl_notifications VALUES (NULL,'$id','eform','$date_time','1','')";
        return $this->mysqli_lib->insert($query);
    }

    function UpdateEForm($Id,$group_id,$user_id)
    {
        $user_id = implode(",", $user_id);
        $query = "UPDATE tbl_eform_add SET group_id = '$group_id', user_id = '$user_id', status_id = '2', forward_datetime = NOW() WHERE id = '$Id'";

        //return $query;
        $this->mysqli_lib->update($query);

        return "success";
    }

    function GetEndDate($prod_categ,$product_id,$eform_type){
        $query = "SELECT tat FROM tbl_eform_type WHERE id = '$eform_type' AND product_category_id = '$prod_categ' AND product_id = '$product_id' AND isactive = 1;";
        $data  = $this->mysqli_lib->fetch_all($query);
        $tat   = $data[0]['tat'];
        $end_date = date('Y-m-d' ,strtotime("+$tat hours"));
        return $this->EndDate($end_date);
    }

    function EndDate($end_date)
    {
        $query = "SELECT week_day FROM `tbl_calendar_weekends`";
        $data = $this->mysqli_lib->fetch_all($query);

        $query = "SELECT to_date FROM `tbl_calendar_holidays` WHERE '$end_date' BETWEEN from_date AND to_date";
        $responses = $this->mysqli_lib->fetch_all($query);

        if (!empty($responses)) {
            /*$current_date = date('Y-m-d');
            $currentTime        = strtotime($current_date);
            $from_time          = strtotime($response[0]['from_date']);
            $tat               = round(($currentTime - $from_time)/(60*60));*/


            foreach ($responses as $response) {
                $end_date = date('Y-m-d', date(strtotime("+1 day", strtotime($response['to_date']))));

                $Day = date("D", strtotime($end_date));

                foreach ($data as $row) {
                    if (strtolower($Day) == $row['week_day']) {
                        if (strtolower($Day) == 'sat') {
                            $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                            return $this->EndDate($end_date);
                        } elseif (strtolower($Day) == 'sun') {
                            $end_date = date('Y-m-d', date(strtotime("+24 hours", strtotime($end_date))));
                            return $this->EndDate($end_date);
                        }
                    } else {
                        return $this->EndDate($end_date);
                    }
                }
            }
            //return $end_date."|";
            //$holiday = $end_date;


            /*$end_date = date('Y-m-d',date(strtotime("+$tat hours", strtotime($end_date))));*/
        } else {
            $Day = date("D", strtotime($end_date));

            foreach ($data as $row) {
                if (strtolower($Day) == $row['week_day']) {
                    if (strtolower($Day) == 'sat') {
                        $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                        return $this->EndDate($end_date);
                    } elseif (strtolower($Day) == 'sun') {
                        $end_date = date('Y-m-d', date(strtotime("+24 hours", strtotime($end_date))));
                        return $this->EndDate($end_date);

                    }
                }
            }
        }
        $end_date = date('Y-m-d 00:00:00', strtotime($end_date));
        return $end_date;
    }

    function EndDateOLD($TAT) {

        $query = "SELECT * FROM tbl_scheduler;";
        $Calender = $this->mysqli_lib->fetch_all($query);
        $Calender = $Calender[0];

        $DateTime = date("Y-m-d G:i:s");
        $Day = date('D',strtotime($DateTime . "+$TAT days"));
        $Time = date('G:i:s',strtotime($DateTime . "+$TAT days"));

        $Calender11 = array("Mon"=>"09:00-18:00",
            "Tue"=>"09:00-10:00",
            "Wed"=>"09:00-18:00",
            "Thu"=>"-",
            "Fri"=>"-",
            "Sat"=>"-",
            "Sun"=>"-");


        $NextDay = 1;
        $Break = 1;
        $Add = 0;

        $CTime = $Calender[$Day];
        while(1){

            if ($CTime == "-") { $Day = date('D',strtotime($DateTime . "+$NextDay days")); $CTime = $Calender[$Day]; $NextDay++ ; }
            else{ break; }
        }
        #print "$Day -- $NextDay\n";
        if ($NextDay > 1) {$NextDay--;}
        #print "$Day -- $NextDay\n";
        $Add = 0; $DHour = 1;
        $CTime = $Calender[$Day];

        while(1)
        {
            list ($On,$Off)=split('-', $CTime);

            $On = $On.":00";
            $Off = $Off.":00";
            if($DHour == 0) { $Time = $On; }

            #print "$NextDay -- $Off < $Time -- $DHour\n";
            if ($Off > $Time)
            {
                if ($Add) {$NextDay --; }
                $EndTime = date('Y-m-d',strtotime($DateTime . "+$NextDay days"));
                $EndTime = $EndTime." ".$Time;
                #print $EndTime."\n" ;
                return $EndTime;
                break;
            }
            else { $DHour = $Time - $Off; $Day = date('D',strtotime($DateTime . "+$NextDay days")); $CTime = $Calender[$Day]; $NextDay++ ;} $Add = 1; }

    }

    function UpdateComments($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_eform_add SET comments = '$comments' , file_counter = '$file_counter' WHERE id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetEFormByID($id)
    {
        $query = "SELECT ed.*, e.`daily_counter`,e.`group_id`,e.`user_id`,e.`agent_id`,e.`eform_num`,e.`product_category`,
                         e.`product_id`,e.`eform_type_id`,e.channel,e.`priority_id`, e.agent_id,e.status_id,e.progress,e.file_counter,e.comments,e.comments_progress,e.comments_verified,e.current_datetime,
                         e.`end_datetime`,e.`closed_datetime`,e.`forward_datetime`
                  FROM tbl_eform_details ed
                  INNER JOIN tbl_eform_add e ON e.id = ed.eform_id
                  WHERE ed.id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetEformStatus($id)
    {
        $query = "SELECT *, (SELECT user_name FROM `tbl_users` WHERE id IN (tbl_eform_status.`login_id`)) AS activity_performer
                  FROM tbl_eform_status WHERE eform_id = '$id' ORDER BY update_datetime DESC LIMIT 0,10;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetEFormTypeList($id)
    {
        if ($id == 0){
            $query = "SELECT e.*,p.fullname product_name
                      FROM tbl_eform_type e
                      INNER JOIN tbl_product p ON p.id = e.product_id;";
        }
        else{
            $query = "SELECT e.id `eform_id`,e.group_id,e.fullname,e.tat,e.operation_mode,e.isactive,ee.*,e.product_category_id,e.product_id,p.fullname product_name
                      FROM tbl_eform_type e
                      INNER JOIN tbl_product p ON p.id = e.product_id
                      INNER JOIN tbl_eform_type_escalation ee ON e.id = ee.eform_escalation_id
                      WHERE e.id = '$id';";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetEFormTypeByProductId($id)
    {
        $query = "SELECT * FROM tbl_eform_type WHERE product_id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function get_eform_max_id()
    {
        $query = "SELECT IFNULL(MAX(id)+1,1) AS eform_no FROM `tbl_eform_add`";
        $eform_no = $this->mysqli_lib->fetch_all($query);
        return date('ymd') . "00" . $eform_no[0]['eform_no'];
    }

   /* function e_form_complains($login_id, $complain_id)
    {
        $query = "SELECT e.id,e.comments_verified,e.progress,e.comments_progress ,e.priority_id,pr.priority,e.`comments`,e.closed_datetime,e.department_id,d.fullname,p.id `product_id`,p.fullname `product`,e.eform_type_id,u.user_id,e.user_id `userid`,e.status_id,s.fullname `status`,e.current_datetime, e.end_datetime, e.eform_num, e.account_no, ef.eform_type,e.email_address, e.company_name
                  FROM tbl_eform_add e
                  INNER JOIN tbl_department d ON d.id = e.department_id
                  INNER JOIN tbl_users u ON u.id = e.user_id
                  INNER JOIN tbl_eform_type ef ON ef.id = e.eform_type_id
                  INNER JOIN tbl_status s ON s.`id` = e.`status_id`
                  INNER JOIN tbl_product p ON p.`id` = e.`product_id`
                  INNER JOIN tbl_priority pr ON pr.id = e.priority_id WHERE 1=1";

        if ($complain_id <> 0) {
            $query .= " AND e.id = '" . $complain_id . "'";
        }

        if ($login_id != 1) {
            $query .= " AND FIND_IN_SET('".$login_id."', e.user_id)";
        }

        return $this->mysqli_lib->fetch_all($query);
    }*/

    function eform_complains($login_id, $eform_id)
    {

        $query = "SELECT e.* ,us.user_name `released_by` ,pr.priority,g.primary_name `fullname`,p.id `product_id`,p.fullname `product`,u.user_name `username`,
                  s.fullname `status`,ef.fullname `eform_type`
                  FROM tbl_eform_add e
                  LEFT JOIN tbl_groups g ON g.id = e.group_id
                  LEFT JOIN tbl_users u ON u.id = e.user_id
                  INNER JOIN tbl_users us ON us.id = e.agent_id
                  INNER JOIN tbl_eform_type ef ON ef.id = e.eform_type_id
                  INNER JOIN tbl_status s ON s.`id` = e.`status_id`
                  INNER JOIN tbl_product p ON p.`id` = e.`product_id`
                  INNER JOIN tbl_priority pr ON pr.id = e.priority_id WHERE 1=1";

        if ($eform_id <> 0) {
            $query .= " AND e.id = '" . $eform_id . "'";
        }

        if ($login_id != 1 && $_SESSION['user_type'] != 2) {
            $user_id = $_SESSION['login_id'];
            if($_SESSION['user_type'] == 3) {
                $query .= " AND agent_id = '$user_id'";
            }
            else {
                $query .= " AND FIND_IN_SET('$user_id', e.user_id)";
            }
        }

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function LeadTime($created_date, $closed_date){

        $start_ts = strtotime($created_date);
        $end_ts = strtotime($closed_date);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }
    /*function Product_Category()
    {
        $query = "SELECT * FROM tbl_product_category WHERE is_active = 1";
        return $this->mysqli_lib->fetch_all($query);
    }*/

    function SaveEFormType($group_id,$product_category_id,$product_id,$name,$tat,$mode,$is_active)
    {
        $query = "INSERT INTO tbl_eform_type (group_id,product_category_id,product_id,fullname,tat,operation_mode,isactive,created_on,updated_on)
                  VALUES ('$group_id','$product_category_id','$product_id','$name','$tat','$mode','$is_active',NOW(),'0000-00-00 00:00:00')";

        $response = $this->mysqli_lib->insert($query);
        return $response;
    }


    function UpdateEFormType($id, $group_id, $product_category_id ,$product_id , $name, $tat, $mode, $is_active)
    {
        $query = "UPDATE tbl_eform_type SET group_id = '$group_id', product_category_id = '$product_category_id', product_id = '$product_id', fullname = '$name', tat = '$tat', operation_mode = '$mode',isactive = '$is_active',updated_on = NOW() WHERE id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function SaveEFormTypeEscalation($eform_escalation_id,$time_period1, $level1, $time_period2, $level2, $time_period3, $level3, $time_period4, $level4, $time_period5, $level5)
    {
        $query = "INSERT INTO tbl_eform_type_escalation (eform_escalation_id,escalation_time1,level1,escalation_time2,level2,escalation_time3,level3,escalation_time4,level4,escalation_time5,level5)
				      VALUES ('$eform_escalation_id','$time_period1','$level1','$time_period2','$level2','$time_period3','$level3','$time_period4','$level4','$time_period5','$level5')";

        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateEFormTypeEscalation($escalation_id,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5)
    {
        $query = "UPDATE tbl_eform_type_escalation SET escalation_time1 = '$time_period1', level1 = '$level1', escalation_time2 = '$time_period2', level2 = '$level2',
                  escalation_time3 = '$time_period3', level3 = '$level3',escalation_time4 = '$time_period4', level4 = '$level4',
                  escalation_time5 = '$time_period5', level5 = '$level5' WHERE id ='$escalation_id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function Product_Type($id)
    {
        if ($id == 0) {
            $query = "SELECT * FROM tbl_product WHERE isactive = 1";
            return $this->mysqli_lib->fetch_all($query);
        } else {
            $query = "SELECT * FROM tbl_product WHERE id = $id";
            $product = $this->mysqli_lib->fetch_all($query);
            return $product[0]["fullname"];
        }


    }

    function Priority()
    {
        $query = "SELECT * FROM tbl_priority WHERE is_active = 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function CheckOverDue($datetime)
    {
        if ($datetime != '0000-00-00 00:00:00') {

            $datetime = date("Y-m-d", strtotime($datetime));
            $current_date = date("Y-m-d");

            /*$str = strtotime(date("Y-m-d")) - (strtotime($str));
            $difference = floor($str / 3600 / 24);*/

            //$query = "SELECT tat FROM tbl_eform_type WHERE id = '$eform_type_id'";
            //$data = $this->mysqli_lib->fetch_all($query);
            //$tat = $data[0]["tat"];

            if ($current_date > $datetime) {
                return 1;
            } else {
                return 0;
            }

        } else {
            return 0;
        }

    }

    function GetEFormByDepartment($department_id)
    {
        $query = "SELECT e.`id`,ef.`eform_type`,e.eform_num,e.`email_address`,e.`current_datetime`,e.status_id,s.fullname `status`,p.fullname `product`
                  FROM tbl_eform_add e
                  INNER JOIN tbl_eform_type ef ON ef.id = e.eform_type_id
                  INNER JOIN tbl_product p ON p.id = e.`product_id`
                  INNER JOIN tbl_status s ON s.`id` = e.`status_id`
                  WHERE 1=1 AND e.`status_id` IN ('2') AND e.`department_id` = '$department_id'";

        return $this->mysqli_lib->fetch_all($query);

    }

    function CloseEformComplaint($id) {
        $query = "UPDATE tbl_eform_add SET status_id = '3', closed_datetime = NOW() WHERE id = '$id'";
        $this->mysqli_lib->update($query);
        return $response = "success";
    }

    function VerifyEformComplaint($id) {
        $query = "UPDATE tbl_eform_add SET status_id = '4' WHERE id = '$id'";
        $this->mysqli_lib->update($query);
        return $response = "success";
    }

    function ProgressEForm($login_id,$id,$channel,$user_id,$progress,$notes) {
        $user_id = implode(",", $user_id);
        $query_part = "";

        if($progress == '100'){
            $status_id = '3';
            $query_part .= ", closed_datetime = NOW()";
        }
        elseif($progress == '101'){
            $status_id = '5';
            $progress = '0';
            $query_part .= ", group_id = '0', user_id = '0'";
        }
        else{
            $status_id = '2';
        }

        $query = "UPDATE tbl_eform_add SET channel = '$channel', progress = '$progress', comments_progress = '$notes', status_id = '$status_id' $query_part WHERE id = '$id'";

        $this->mysqli_lib->update($query);

        $this->SaveEFormStatus($login_id,$id,$status_id,$user_id,$progress,$notes);

        return $response = "success";
    }

    function SaveEFormStatus($login_id,$id,$status_id,$user_id,$progress,$notes){
        $query = "INSERT INTO tbl_eform_status (login_id,eform_id,current_state,assign_to,progress,comments) VALUES('$login_id','$id','$status_id','$user_id','$progress','$notes')";
        $this->mysqli_lib->insert($query);
    }

    function UpdateEFormAgain($id,$department,$user_id) {
        $query = "UPDATE tbl_eform_add SET comments_progress = '', department_id = '$department', user_id = '$user_id', status_id = '2' WHERE id = '$id';";
        $this->mysqli_lib->update($query);

        return "success";
    }

    function VerifiedComments($id,$comments) {
        $query = "UPDATE tbl_eform_add SET comments_verified = '$comments', status_id = '4' WHERE id = '$id';";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetEFormStatus_old($eform_id){
        $query = "SELECT tbl_eform_add.`eform_num`, tbl_users.user_name, tbl_eform_status.*
                  FROM tbl_eform_status
                  INNER JOIN tbl_users ON tbl_users.id = tbl_eform_status.login_id
                  INNER JOIN tbl_eform_add ON tbl_eform_status.`eform_id` = tbl_eform_add.`id`
                  WHERE tbl_eform_status.`eform_id` = '$eform_id' ORDER BY update_datetime DESC LIMIT 10;";

        return $this->mysqli_lib->fetch_all($query);
    }

    function ReadNotification($id,$notification_type)
    {
        $query = "UPDATE tbl_notifications SET user_is_read = '1' WHERE `type` = '$notification_type' AND id = '$id'";
        return $this->mysqli_lib->update($query);
    }

    function GetEFormForAPI($cnic)
    {
        $query = "SELECT * FROM `vw_get_eforms` WHERE cnic = '".$cnic."' ";
        $response = $this->mysqli_lib->fetch_all($query);
        return $response;
    }
}

?>