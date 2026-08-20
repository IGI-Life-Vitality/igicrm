<?php
class Lead
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function SaveLeads($Salutation,$DepartmentName,$FName,$MName,$LName,$CNIC,$Gender,$Mobile,$BackNumber,$Email,$ddlCity,$Area,$Address,$ProductName,$CallTime,$Source,$LaedsDesc,$loginid)
    {
        $exced_time      = date("Y-m-d", strtotime("+30 days"));
        $data_counter    = explode('|', $this->GenLeadCounter());
        $counter_display = $data_counter[0];
        $counter         = $data_counter[1];

        if($ProductName == 3)
        {
            $ProductName = 3;
        }
        else
        {
            $ProductName = $ProductName;
        }

        /*$query1     = "SELECT * FROM tbl_leads_maping WHERE lead_region = '$ddlCity' AND FIND_IN_SET($Area, lead_region_area) AND lead_product = '$ProductName'";*/

        $query1 = "SELECT * FROM tbl_leads_maping WHERE lead_city = '$ddlCity' AND FIND_IN_SET($Area, lead_region_area) AND lead_product = '$ProductName'";
        $response1 = $this->mysqli_lib->fetch_all($query1);

        //return $response1[0]['lead_regional_manager']; 
 
        $query2 = "SELECT * FROM tbl_users WHERE user_type = '2' AND group_id = '3' AND FIND_IN_SET($ProductName, product_id) LIMIT 1";
        $response2  = $this->mysqli_lib->fetch_all($query2);

        if($response1 != '')
        {
            $lead_regional_manager  = $response1[0]['lead_regional_manager'];
        }
        else
        {
            if($ProductName == 3)
            {
                $lead_regional_manager = 91;    //Vitility Manager ID 91
            }
            else
            {
                $lead_regional_manager = $response1[0]['id'];
            }
        }

        $query3 = "SELECT * FROM tbl_users WHERE id = '$lead_regional_manager' LIMIT 1";
        $response3  = $this->mysqli_lib->fetch_all($query3);
        
        $query = "INSERT into tbl_leads(lead_daily_counter,lead_num,salutation,fname,mname,lname,cnic,gender,mobile_no,backup_no,email,city,area,address,product,source,call_time,group_id,lead_desc,agent_id,lead_assignee,lead_assigned_to,lead_exceded_datetime,lead_create_date,lead_update_date,lead_status_id,is_completed) VALUES ('$counter','$counter_display','$Salutation','$FName','$MName','$LName','$CNIC','$Gender','$Mobile','$BackNumber','$Email','$ddlCity','$Area','$Address','$ProductName','$Source','$CallTime','$DepartmentName','$LaedsDesc','$loginid','$loginid','$lead_regional_manager','$exced_time',NOW(),'','1','0')";
        $response = $this->mysqli_lib->insert($query);

        if($response)
        {
            return "success|".$response."|".$counter_display."|".$lead_regional_manager."|".$response3[0]['email'];
        }
        else 
        {
            return 0;
        }
    }

    function UpdateLeads($lead_id,$Salutation,$DepartmentName,$FName,$MName,$LName,$CNIC,$Gender,$Mobile,$BackNumber,$Email,$ddlCity,$Area,$Address,$ProductName,$CallTime,$Source,$LaedsDesc,$loginid)
    {
        if($ProductName == 3)
        {
            $ProductName = 3;
        }
        else
        {
            $ProductName = $ProductName;
        }

        $query1     = "SELECT * FROM tbl_leads_maping WHERE lead_city = '$ddlCity' AND FIND_IN_SET($Area, lead_region_area) AND lead_product = '$ProductName'";
        $response1  = $this->mysqli_lib->fetch_all($query1);

        $query2     = "SELECT * FROM tbl_users WHERE user_type = '2' AND group_id = '3' AND  FIND_IN_SET($ProductName, product_id) LIMIT 1";
        $response2  = $this->mysqli_lib->fetch_all($query2);

        if($response1 != '')
        {
            $lead_regional_manager  = $response1[0]['lead_regional_manager'];
        }
        else
        {
            $lead_regional_manager = $response1[0]['id'];
        }

        $query = "UPDATE tbl_leads SET salutation='$Salutation',fname='$FName', mname='$MName',lname='$LName',cnic='$CNIC', gender='$Gender', mobile_no='$Mobile', backup_no='$BackNumber', email='$Email', city='$ddlCity', area='$Area',address='$Address',product='$ProductName',source='$Source',call_time='$CallTime',lead_desc='$LaedsDesc',agent_id='$loginid',lead_assignee='$loginid',lead_assigned_to='$lead_regional_manager',lead_update_date=NOW() WHERE lead_id = '$lead_id'";
        $response = $this->mysqli_lib->update($query);
        
        if($response)
        {
            return "success";
        }
        else 
        {
            return 0;
        }
    }

    function SaveLeadsMapping($Region,$City,$Area,$RegionManager,$ProductType)
    {
        $query = "INSERT INTO tbl_leads_maping (lead_region, lead_city ,lead_region_area, lead_regional_manager, lead_product, created_datetime, updated_datetime) VALUES ('$Region','$City', '$Area', '$RegionManager', '$ProductType', NOW(), NOW())";
        $response = $this->mysqli_lib->insert($query);

        if($response)
        {
            return "success";
        }
        else 
        {
            return 0;
        }
    }

    function UpdateLeadsMapping($id,$City,$Area,$RegionManager,$ProductType)
    {
        $query = "UPDATE tbl_leads_maping SET lead_region = '$City', lead_region_area='$Area', lead_regional_manager='$RegionManager', lead_product='$ProductType', updated_datetime=NOW() WHERE id='$id'";
        $response = $this->mysqli_lib->update($query);

        if($response)
        {
            return "success";
        }
        else 
        {
            return 0;
        }
    }

    function GetLeads($login_id,$group_id,$user_type,$product_id)
    {
        $query = '';

        if($user_type == 1)
        {
            $query .= "SELECT l.*, c.fullname city, ca.area 'area', sr.fullname source_name, CONCAT(us.first_name, ' ', us.last_name) assignee, CONCAT(usr.first_name, ' ', usr.last_name) assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_source sr ON sr.id = l.source ORDER BY l.lead_id DESC";
        }
        else if($user_type == 2)
        {
            $query .= "SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_groups gr ON gr.id = l.group_id LEFT JOIN tbl_source sr ON sr.id = l.source WHERE l.product IN ($product_id) AND l.group_id IN (".$group_id.") OR l.agent_id = '".$login_id."' OR l.lead_assignee = '".$login_id."' ORDER BY l.lead_id DESC";
        }
        else if($user_type == 3)
        {
            $query .= "SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_groups gr ON gr.id = l.group_id LEFT JOIN tbl_source sr ON sr.id = l.source WHERE l.group_id IN (".$group_id.") AND l.agent_id = '".$login_id."' OR l.lead_assignee = '".$login_id."' OR l.agent_id = 0 OR  l.lead_assignee = 0 ORDER BY l.lead_id DESC";
        }
        else
        {
            $query .= "SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_source sr ON sr.id = l.source WHERE l.lead_assigned_to = '".$login_id."' OR l.agent_id = '".$login_id."' ORDER BY l.lead_id DESC";
        }

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadsMapping()
    {
        $query = '';

        /*$query .= "SELECT lmp.*, cty.fullname as city, CONCAT(usr.first_name, ' ' , usr.last_name) as regional_manager FROM tbl_leads_maping lmp LEFT JOIN tbl_city cty ON cty.id = lmp.lead_region LEFT JOIN tbl_city_areas ara ON ara.id = lmp.lead_region_area LEFT JOIN tbl_users usr ON usr.id = lmp.lead_regional_manager ORDER BY lmp.id ASC";*/

        $query .= "SELECT lmp.*, re.fullname AS region, cty.fullname AS city, CONCAT(usr.first_name, ' ' , usr.last_name) AS regional_manager FROM tbl_leads_maping lmp LEFT JOIN tbl_region re ON re.id = lmp.lead_region LEFT JOIN tbl_region_city cty ON cty.id = lmp.lead_city LEFT JOIN tbl_city_areas ara ON ara.id = lmp.lead_region_area LEFT JOIN tbl_users usr ON usr.id = lmp.lead_regional_manager ORDER BY lmp.id ASC";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadsMappingById($id)
    {
        $query = '';

        /*$query .= "SELECT lmp.*, cty.fullname as city, CONCAT(usr.first_name, ' ' , usr.last_name) as regional_manager FROM tbl_leads_maping lmp LEFT JOIN tbl_region_city cty ON cty.id = lmp.lead_region LEFT JOIN tbl_city_areas ara ON ara.id = lmp.lead_region_area LEFT JOIN tbl_users usr ON usr.id = lmp.lead_regional_manager WHERE lmp.id = '$id' ORDER BY lmp.id ASC";*/
         $query .= "SELECT lmp.*, re.fullname AS region, cty.fullname AS city, CONCAT(usr.first_name, ' ' , usr.last_name)  AS regional_manager FROM tbl_leads_maping lmp  LEFT JOIN tbl_region re ON re.id = lmp.lead_region LEFT JOIN tbl_region_city cty ON cty.id = lmp.lead_city  LEFT JOIN tbl_city_areas ara ON ara.id = lmp.lead_region_area  LEFT JOIN tbl_users usr ON usr.id = lmp.lead_regional_manager WHERE lmp.id = '$id' ORDER BY lmp.id ASC";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetRegionalAreas($id)
    {
        $query = "SELECT * FROM tbl_city_areas WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetCityAreas($id)
    {
        $query = "SELECT * FROM tbl_city_areas WHERE city_id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetRegionalManager()
    {
        $query = "SELECT * FROM tbl_users WHERE user_type = '4' AND group_id = '3' AND SUBSTR(user_name,  1, 14) = 'Regional Head'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetCallResult()
    {
        $query = "SELECT * FROM tbl_leads_call_results ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadStatus()
    {
        $query = "SELECT * FROM tbl_leads_status ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadTestTypeStatus()
    {
        $query = "SELECT * FROM tbl_leads_test_type_status ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function UpdateLead()
    {
        $query = "";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function SaveLeadAssignee($lead_id,$assignee,$assignedTo,$notes)
    {
        $query = "UPDATE tbl_leads SET lead_assignee = '$assignee', lead_assigned_to = '$assignedTo', lead_note = '$notes', lead_status_id = '2', lead_update_date = NOW() WHERE lead_id = '$lead_id'";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function SaveLeadActivity($lead_id,$login_id,$call_result,$meeting_time,$lead_status,$previous_state,$lead_remarks)
    {
        $query = "INSERT INTO tbl_leads_details (login_id,lead_id,lead_call_result,current_state,previous_state,meeting_time,remarks,update_datetime) VALUES ('$login_id','$lead_id','$call_result','$lead_status','$previous_state','$meeting_time','$lead_remarks',NOW())";
        $this->mysqli_lib->insert($query);

        $query1 = "SELECT current_state FROM tbl_leads_details WHERE lead_id = '$lead_id' ORDER BY update_datetime DESC LIMIT 1";
        $lead_current_state = $this->mysqli_lib->fetch_all($query1);

        $lead_current_state = $lead_current_state[0]['current_state'];

        $query2 = "UPDATE tbl_leads SET lead_status_id = '$lead_current_state', lead_update_date = NOW() WHERE lead_id = '$lead_id'";
        $this->mysqli_lib->update($query2);

        return "success";
    }

    function SaveLeadActivity_Test($lead_id,$login_id,$test_type,$test_status,$leads_results,$leads_rmrk)
    {
         $query1 = "INSERT INTO tbl_leads_vitality_details (login_id,lead_id,lead_test_type,lead_status,results,remarks,update_datetime) VALUES ('$login_id','$lead_id','$test_type','$test_status','$leads_results','$leads_rmrk',NOW())";
        $this->mysqli_lib->insert($query1);
        return "success";
    }

    function SaveLeadStatusOnly($lead_id,$status)
    {
        $query = "UPDATE tbl_leads SET lead_status_id = '$status', lead_update_date = NOW() WHERE lead_id = '$lead_id'";
        $this->mysqli_lib->update($query);
    }

    function GenLeadCounter()
    {
        $first_digit = "LM";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(lead_daily_counter)+1,1) AS daily_counter FROM `tbl_leads` WHERE DATE(`lead_create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GetDateTimeDiff($lead_end_datetime, $current_datetime)
    {
      $lead_end_datetime = strtotime($lead_end_datetime);
      $current_datetime = strtotime($current_datetime);
      $diff = $current_datetime - $lead_end_datetime;
      return round($diff / 3600);
    }

    function LeadTime($current_date, $exced_date)
    {
        $current_date = strtotime($current_date);
        $exced_date = strtotime($exced_date);
        $diff = $exced_date - $current_date;
        //return $current_date;
        return round($diff / 86400);
    }

    function GetProducts($id) 
    {
        $query = "SELECT * FROM tbl_product WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadsById($id)
    {
        $query = "SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_details ld ON ld.lead_id = l.lead_id LEFT JOIN tbl_leads_call_results lcr ON lcr.id = ld.lead_call_result LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_source sr ON sr.id = l.source WHERE l.lead_id = '".$id."' ORDER BY l.lead_id DESC";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function SaveLeadsStatus($login_id,$lead_id,$status_id,$progress,$notes)
    {
        $query = "INSERT INTO tbl_task_status (login_id, task_id, current_state, progress, comments) VALUES('$login_id','$task_id','$status_id','$progress','$notes')";
        $this->mysqli_lib->insert($query);
    }

    function GetLeadsStatusById($lead_id)
    {
        $query = "SELECT ld.*, lcr.fullname call_result, ls.fullname previous_state, ls.fullname current_state, CONCAT(us.first_name, ' ', us.last_name) activity_performed_by FROM tbl_leads_details ld LEFT JOIN tbl_leads_call_results lcr ON lcr.id = ld.lead_call_result LEFT JOIN tbl_leads_status les ON les.id = ld.previous_state LEFT JOIN tbl_leads_status ls ON ls.id = ld.current_state LEFT JOIN tbl_users us ON us.id = ld.login_id WHERE ld.lead_id = '$lead_id' ORDER BY ld.update_datetime DESC LIMIT 10";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadsTestById($lead_id)
    {
        $query = "SELECT lvd.*, lts.fullname AS test_type_status, ltt.fullname AS test_type_name FROM tbl_leads_vitality_details lvd LEFT JOIN tbl_leads_test_type_status lts ON lvd.lead_status = lts.id LEFT JOIN tbl_leads_test_type ltt ON lvd.lead_test_type = ltt.id WHERE lvd.lead_id = '$lead_id' ORDER BY lvd.id DESC LIMIT 10";

        return $this->mysqli_lib->fetch_all($query);
    }

    /*function SearchLead($lead_num,$cnic,$product,$call_back,$lead_status,$city,$FromDate,$ToDate)
    {
        $query ="SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_groups gr ON gr.id = l.group_id LEFT JOIN tbl_source sr ON sr.id = l.source WHERE l.lead_num = '$lead_num' OR l.cnic = '$cnic' OR l.product = '$product' OR l.mobile_no = '$call_back' OR l.lead_status_id = '$lead_status' OR l.city = '$city' OR DATE(l.lead_create_date) between '$FromDate' AND '$ToDate' ORDER BY l.lead_id ASC";
           
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }*/

    function SearchLead($search_detail)
    {
        $query ="SELECT l.*, c.fullname city, ca.area 'area', sr.fullname AS source_name, CONCAT(us.first_name, ' ', us.last_name) AS assignee, CONCAT(usr.first_name, ' ', usr.last_name) AS assignedTo FROM tbl_leads l LEFT JOIN tbl_leads_status ls ON ls.id = l.lead_status_id LEFT JOIN tbl_users us ON us.id = l.agent_id LEFT JOIN tbl_users usr ON usr.id = l.lead_assigned_to LEFT JOIN tbl_region_city c ON c.id = l.city LEFT JOIN tbl_city_areas ca ON ca.id = l.area LEFT JOIN tbl_groups gr ON gr.id = l.group_id LEFT JOIN tbl_source sr ON sr.id = l.source $search_detail ORDER BY l.lead_id ASC";
           
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLeadsTestType()
    {
        $query = "SELECT * FROM tbl_leads_test_type ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }
    function GetUsersById($id){

        $query = "SELECT * FROM tbl_users WHERE id = '$id'";
        return $this->mysqli_lib->query_execute($query);
    }
    function GetLeadDetail($lead_id){
            $query_leadnum = "Select * from tbl_leads  WHERE lead_id = '$lead_id'";
            $detail = $this->mysqli_lib->query_execute($query_leadnum);
            return $detail;
    }
    
    function check_num($mobile){
        $msisdn = trim($mobile);    
        $initial = substr($msisdn, 0, 2);    
        if($initial == '03' || $initial == '92'){        
            if($initial == '03') {            
                $msisdn = '92'.substr($msisdn, 1, strlen($msisdn));       
            }    
        }
       return $msisdn; 
    }
    function setemail($toemail,$ccemail,$subject,$content){
        $query ="Insert INTO tbl_daily_email (toemail,ccemail,subject,content,datetime,is_active) VALUES ('$toemail','$ccemail','$subject','$content',NOW(),'1')";

         $res = $this->mysqli_lib->insert($query);
         if($res){
            return "success";
        }else{
            return "fail";
        }

    }

    function get_sales_users($user_type,$group_id){

         $query = "SELECT * FROM tbl_users where user_type = '$user_type' and FIND_IN_SET($group_id, group_id)";
        return $this->mysqli_lib->fetch_all($query);

    }

    function UpdateLeadsUser($id,$prod,$user_type,$users){
        if($id == 0){
            $id = $users;
        }

         $query = "UPDATE tbl_users SET product_id ='$prod'  where user_type = '$user_type' and id = '$id' ";
        $this->mysqli_lib->update($query);
        return "success";

    }

    function GetLeadsUserById($id){

            $query = "SELECT * FROM tbl_users WHERE id = '$id'";
            $detail = $this->mysqli_lib->fetch_all($query);
            return $detail;

    }


    function GetLeadsUser(){

    $query = "SELECT * FROM tbl_users where product_id != '0' and FIND_IN_SET(3, group_id)";
        return $this->mysqli_lib->fetch_all($query);

    }

    function GetProductsName($id)
    {
        $query = "SELECT * FROM tbl_product WHERE id = '$id'";
        return $this->mysqli_lib->query_execute($query);
    }

    function UpdateLeadsAssignee($id,$user)
    {
        $query = "UPDATE tbl_leads SET lead_assigned_to ='$user'  where lead_id = '$id' ";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetLeadMappingDetail($city,$area,$product)
    {
        $query= "SELECT * FROM tbl_leads_maping WHERE lead_city = '$city' AND FIND_IN_SET($area, lead_region_area) AND lead_product = '$product'";
        $detail = $this->mysqli_lib->query_execute($query);
            return $detail;
    }

    function Reasign_user($id,$user)
    {
        $query = "UPDATE tbl_leads SET lead_assigned_to = '$user' WHERE lead_id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return $response > 0 ? "success" : "fail";
        //return "success";
    }

}