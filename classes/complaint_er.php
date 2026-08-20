<?php
class Complaint 
{
    private $mysqli_lib;
    private $obj_user;

    function __construct()
    {
      global $obj_mysql;
      $this->mysqli_lib = $obj_mysql;
    }

    function SaveComplaint($login_id,$group_id,$userid,$product_id,$complaint_type,$priority,$source,$Tat,$mode,$type,$description,$cnic,$cust_name,$callback_num,$office_addr,$correspondenceAddress,$email,$office_num, $mobile_num,$residence_num,$is_email, $cust_email, $is_sms,$response_no, $is_call_back,$policynum,$ComplainerName,$CompanyName,$AgentBroker,$HospitalNameC,$txtGroupNo,$txtCertificate,$txtMemberName,$ddlReportedBy,$txtLetterComplNumber,$txtPremiumAmount,$txtRefundAmount,$txtAmountClaimed,$txtAgentNameL,$txtAgentCode,$txtUnitName,$txtAMName,$ddlRegion,$reported_dt,$poccured,$ddlPolicyStatusL,$cityL,$ddlReportedByL,$ddlComplaintNature,$ddlDepartmentName,$bank,$ddlForum)
    {
      $reported_dt = date("Y-m-d H:i:s", strtotime($reported_dt));
      $poccured = date("Y-m-d H:i:s", strtotime($poccured));

      $end_datetime = $this->GetEndDate($complaint_type);

      if($type == "individual" && $policynum != 0 )
      {
        $data_counter = explode('|',$this->GenComplaintCounterLife());
        $counter_display = $data_counter[0];
        $counter = $data_counter[1];

        $getTime = date("H:i:s");

        $query = "INSERT INTO tbl_complaints_life(daily_counter,complaint_num,customer_name,cnic,agent_id,group_id, user_id,product_id,complaint_depart,complaint_type_id,priority_id,status_id,channel,tat,mode,type,create_date,end_date,forward_date,close_date) VALUES ('$counter','$counter_display','$cust_name','$cnic','$login_id','$group_id','$userid','$product_id','$ddlDepartmentName','$complaint_type','$priority','1','$source','$Tat','$mode','$type',NOW(),'$end_datetime $getTime','0000-00-00 00:00:00','0000-00-00 00:00:00')";
        $response = $this->mysqli_lib->insert($query);

        if($response > 0)
        {
          $query = "INSERT INTO tbl_complaint_details_life(complaint_id,
            policy_num,description,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,
            is_email,customer_email,is_sms,response_number,is_call_back)
            VALUES('$response','$policynum','$description','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back')";
          $result = $this->mysqli_lib->insert($query);

          // Comments By Kamran Jabbar
          $msg = "Dear Customer,\\nThank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;
          $msg = str_replace(' ', '%20', $msg);
          $mobile_num = $this->check_num($mobile_num);
          $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
          $res = file_get_contents($url);

          if($response_no != $mobile_num)
          {
            $response_no = $this->check_num($response_no);
            $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
            $res = file_get_contents($url);
          }

          //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
          $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

          $cmp_type  = $this->GetComplaintTypeList($complaint_type);
          $agnt = $this->GetUsersById($login_id);
          $agent = $agnt['first_name']." ".$agnt['last_name'];
          $usr_detail = $this->GetUsersById($userid);
          $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
          $to_email = $usr_detail['email'];
          $depart_nm = $this->GetDepart($group_id);
          $depart = $depart_nm['primary_name'];

          if(!empty($cmp_type)){
              $complaint_type = $cmp_type[0]['fullname'];
                  $priority = "" ;
                  if($cmp_type[0]['fullname'] == '1'){
                         $priority = "High" ;
                  }elseif ($cmp_type[0]['fullname'] == '2') {
                          $priority = "Low" ;
                  }else{
                       $priority = "Medium" ;
                  }
          }

          //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

          return $response."|".$counter_display;
        }
        else
        {
          return "fail";
        }
      }
      elseif($type == "internal" && $group_id != 0 && $ComplainerName != 0)
      {
        $data_counter = explode('|',$this->GenComplaintCounterInternal());
        $counter_display = $data_counter[0];
        $counter = $data_counter[1];

        $getTime = date("H:i:s");

        $query = "INSERT INTO tbl_complaints_internal(daily_counter, complaint_num,customer_name,cnic, agent_id, group_id, user_id,complanier,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,progress,file_counter,comments,comments_progress,comments_verified,create_date,end_date,forward_date,close_date)
          VALUES ('$counter','$counter_display','N/A','N/A','$login_id','$group_id','$userid' ,'$ComplainerName','$ddlDepartmentName','$complaint_type', '$priority','1','$source','$Tat','$mode','$type','0','0','$description','','',NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
        $response = $this->mysqli_lib->insert($query);

        if($response > 0)
        {
            //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
            //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');

            $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

            $cmp_type  = $this->GetComplaintTypeList($complaint_type);
            $agnt = $this->GetUsersById($login_id);
            $agent = $agnt['first_name']." ".$agnt['last_name'];
            $usr_detail = $this->GetUsersById($userid);
            $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
            $to_email = $usr_detail['email'];
            $depart_nm = $this->GetDepart($group_id);
            $depart = $depart_nm['primary_name'];

            if(!empty($cmp_type))
            {
                $complaint_type = $cmp_type[0]['fullname'];
                    $priority = "" ;
                    if($cmp_type[0]['fullname'] == '1'){
                           $priority = "High" ;
                    }elseif ($cmp_type[0]['fullname'] == '2') {
                            $priority = "Low" ;
                    }else{
                         $priority = "Medium" ;
                    }
            }
            //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

            return $response."|".$counter_display;
        }
        else
        {
        	return "fail";
        }
      }
      elseif($type == "corporate" && $group_id != "0" && $txtGroupNo != "0") 
      {
          $data_counter = explode('|',$this->GenComplaintCounterCooperate());
          $counter_display = $data_counter[0];
          $counter = $data_counter[1];

          $getTime = date("H:i:s");

          $query = "INSERT INTO tbl_complaints_cooperate(daily_counter, complaint_num,customer_name,cnic, agent_id, group_id, user_id,product_id,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,create_date, end_date, forward_date, close_date)
                VALUES ('$counter','$counter_display','$txtMemberName','$cnic','$login_id','$group_id','$userid' ,'', '$ddlDepartmentName','$complaint_type','$priority', '1','$source','$Tat','$mode','$type', NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
          $response = $this->mysqli_lib->insert($query);

          if($response > 0)
          {
              $query = "INSERT INTO tbl_complaint_details_cooperate(complaint_id,group_no,company_name,certificate_no,reported_by,agent,hospital,description,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,is_email,customer_email,is_sms,response_number,is_call_back)
              VALUES('$response','$txtGroupNo','$CompanyName','$txtCertificate','$ddlReportedBy','$AgentBroker','$HospitalNameC','$description','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back')";
              $result = $this->mysqli_lib->insert($query);

              // Comments By Kamran Jabbar
              $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;
              $msg = str_replace(' ', '%20', $msg);
              $mobile_num = $this->check_num($mobile_num);
              $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
              $res = file_get_contents($url);

              if($response_no != $mobile_num)
              {
                $response_no = $this->check_num($response_no);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                $res = file_get_contents($url);
              }

              //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
              //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
              $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

              $cmp_type  = $this->GetComplaintTypeList($complaint_type);
              $agnt = $this->GetUsersById($login_id);
              $agent = $agnt['first_name']." ".$agnt['last_name'];
              $usr_detail = $this->GetUsersById($userid);
              $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
              $to_email = $usr_detail['email'];
              $depart_nm = $this->GetDepart($group_id);
              $depart = $depart_nm['primary_name'];

              if(!empty($cmp_type)){
                  $complaint_type = $cmp_type[0]['fullname'];
                      $priority = "" ;
                      if($cmp_type[0]['fullname'] == '1'){
                             $priority = "High" ;
                      }elseif ($cmp_type[0]['fullname'] == '2') {
                              $priority = "Low" ;
                      }else{
                           $priority = "Medium" ;
                      }
              }
              //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

              return $response."|".$counter_display;
          }
          else
          {
            return "fail";
          }  
      }
      elseif($type == "legal" && $policynum != '0' && $txtLetterComplNumber != '0')
      {
        $data_counter = explode('|',$this->GenComplaintCounterLegal());
        $counter_display = $data_counter[0];
        $counter = $data_counter[1];

        $getTime = date("H:i:s");

        $query = "INSERT INTO tbl_complaints_legal(daily_counter, complaint_num,customer_name,cnic, agent_id, group_id, user_id,product_id,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,create_date, end_date, forward_date, close_date) VALUES ('$counter','$counter_display','$ComplainerName','$cnic','$login_id','$group_id','$userid' ,'$product_id','$ddlDepartmentName','$complaint_type', '$priority', '1','$source','$Tat','$mode','$type', NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
        $response = $this->mysqli_lib->insert($query);

        if($response > 0)
        {
            $query = "INSERT INTO tbl_complaint_details_legal(complaint_id,policy_num,letter_no,premium_amount,claim_amount,unit_name,am_name,region,city,complaint_nature,policy_status,received_by,reported_date,problem_occurd,agent_code,agent,hospital,description,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,is_email,customer_email,is_sms,response_number,is_call_back,forum_id) VALUES ('$response','$policynum','$txtLetterComplNumber','$txtPremiumAmount','$txtAmountClaimed','$txtUnitName','$txtAMName','$ddlRegion','$cityL','$ddlComplaintNature','$ddlPolicyStatusL','$ddlReportedByL','$reported_dt','$poccured','$txtAgentCode','$txtAgentNameL','$HospitalNameC','$description','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back','$ddlForum')";
            //print_r($query);die;
            $result = $this->mysqli_lib->insert($query);

            // Comments By Kamran Jabbar
            $msg = "Dear Customer,\\nThank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;
           
            $msg = str_replace(' ', '%20', $msg);
            $mobile_num = $this->check_num($mobile_num);
            $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
            $res = file_get_contents($url);

            if($response_no != $mobile_num)
            {
                $response_no = $this->check_num($response_no);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                $res = file_get_contents($url);
            }

            //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
            //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
            $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

            $cmp_type  = $this->GetComplaintTypeList($complaint_type);
            $agnt = $this->GetUsersById($login_id);
            $agent = $agnt['first_name']." ".$agnt['last_name'];
            $usr_detail = $this->GetUsersById($userid);
            $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
            $to_email = $usr_detail['email'];
            $depart_nm = $this->GetDepart($group_id);
            $depart = $depart_nm['primary_name'];

            if(!empty($cmp_type)){
                $complaint_type = $cmp_type[0]['fullname'];
                    $priority = "" ;
                    if($cmp_type[0]['fullname'] == '1'){
                           $priority = "High" ;
                    }elseif ($cmp_type[0]['fullname'] == '2') {
                            $priority = "Low" ;
                    }else{
                         $priority = "Medium" ;
                    }
            }
            //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

            return $response."|".$counter_display;
        }
        else
        {
          return "fail";
        }
      }
      elseif($type == "bancaIndividual" && $policynum != 0)
      {
          $data_counter = explode('|',$this->GenComplaintCounterBanca());
          $counter_display = $data_counter[0];
          $counter = $data_counter[1];

          $getTime = date("H:i:s");

          $query = "INSERT INTO tbl_complaints_banca (daily_counter, complaint_num,customer_name,cnic, agent_id, group_id, user_id,product_id,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,create_date, end_date, forward_date, close_date)
                VALUES ('$counter','$counter_display','$cust_name','$cnic','$login_id','$group_id','$userid' ,'$product_id','$ddlDepartmentName','$complaint_type','$priority', '1','$source','$Tat','$mode','$type', NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
          $response = $this->mysqli_lib->insert($query);

          if($response > 0)
          {
              $query = "INSERT INTO tbl_complaint_details_banca(complaint_id,policy_num,description,bank,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,is_email,customer_email,is_sms,response_number,is_call_back) VALUES ('$response','$policynum','$description','$bank','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back')";
              $result = $this->mysqli_lib->insert($query);

              // Comments By Kamran Jabbar
              $msg = "Dear Customer,\\nThank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

              $msg = str_replace(' ', '%20', $msg);
              $mobile_num = $this->check_num($mobile_num);
              $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
              $res = file_get_contents($url);

              if($response_no != $mobile_num)
              {
                $response_no = $this->check_num($response_no);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                $res = file_get_contents($url);
              }

              //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
              //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
              $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

              $cmp_type  = $this->GetComplaintTypeList($complaint_type);
              $agnt = $this->GetUsersById($login_id);
              $agent = $agnt['first_name']." ".$agnt['last_name'];
              $usr_detail = $this->GetUsersById($userid);
              $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
              $to_email = $usr_detail['email'];
              $depart_nm = $this->GetDepart($group_id);
              $depart = $depart_nm['primary_name'];

              if(!empty($cmp_type))
              {
								$complaint_type = $cmp_type[0]['fullname'];
								$priority = "" ;

								if($cmp_type[0]['fullname'] == '1')
								{
									$priority = "High" ;
								}elseif ($cmp_type[0]['fullname'] == '2') 
								{
									$priority = "Low" ;
								}
								else
								{
									$priority = "Medium" ;
								}
              }
              //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

              return $response."|".$counter_display;
          }
          else
          {
            return "fail";
          }
      }
      elseif($type == "vatality" && $policynum != 0)
      {
          $data_counter = explode('|',$this->GenComplaintCounterVatality());
          $counter_display = $data_counter[0];
          $counter = $data_counter[1];

          $getTime = date("H:i:s");

          $query = "INSERT INTO tbl_complaints_vatality(daily_counter,complaint_num,customer_name,cnic,agent_id, group_id, user_id,product_id,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,create_date, end_date, forward_date, close_date)
                VALUES ('$counter','$counter_display','$cust_name','$cnic','$login_id','$group_id','$userid' ,'$product_id','$ddlDepartmentName','$complaint_type','$priority', '1','$source','$Tat','$mode','$type', NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
          $response = $this->mysqli_lib->insert($query);

          if($response > 0)
          {
              $query = "INSERT INTO tbl_complaint_details_vatality(complaint_id,
              policy_num,description,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,
              is_email,customer_email,is_sms,response_number,is_call_back,reassign)
              VALUES('$response','$policynum','$description','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back','0')";

              $result = $this->mysqli_lib->insert($query);
              $msg = "Dear Customer,\\nThank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;
              $msg = str_replace(' ', '%20', $msg);
              $mobile_num = $this->check_num($mobile_num);
              $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
              $res = file_get_contents($url);

              if($response_no != $mobile_num)
              {
                $response_no = $this->check_num($response_no);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                $res = file_get_contents($url);
              }

              //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
              //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
              $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

              $cmp_type  = $this->GetComplaintTypeList($complaint_type);
              $agnt = $this->GetUsersById($login_id);
              $agent = $agnt['first_name']." ".$agnt['last_name'];
              $usr_detail = $this->GetUsersById($userid);
              $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
              $to_email = $usr_detail['email'];
              $depart_nm = $this->GetDepart($group_id);
              $depart = $depart_nm['primary_name'];

              if(!empty($cmp_type)){
                  $complaint_type = $cmp_type[0]['fullname'];
                      $priority = "" ;
                      if($cmp_type[0]['fullname'] == '1'){
                             $priority = "High" ;
                      }elseif ($cmp_type[0]['fullname'] == '2') {
                              $priority = "Low" ;
                      }else{
                           $priority = "Medium" ;
                      }
              }
              //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

              return $response."|".$counter_display;
          }
          else
          {
            return "fail";
          }
          //}elseif($type == "bancaBank" && $group_id != 0 && $txtGroupNo != 0 ){
      }
      elseif($type == "bancaBank" && $group_id != 0 )
      {
          $data_counter = explode('|',$this->GenComplaintCounterBancaBank());
          $counter_display = $data_counter[0];
          $counter = $data_counter[1];

          $getTime = date("H:i:s");

          $query = "INSERT INTO tbl_complaints_banca_bank (daily_counter, complaint_num,customer_name, cnic,agent_id, group_id, user_id,product_id,complaint_depart,complaint_type_id, priority_id, status_id,channel,tat,mode,type,create_date, end_date, forward_date, close_date)
                VALUES ('$counter','$counter_display','$txtMemberName','$cnic','$login_id','$group_id','$userid' ,'$product_id','$ddlDepartmentName','$complaint_type','$priority', '1','$source','$Tat','$mode','$type', NOW(), '$end_datetime $getTime', '0000-00-00 00:00:00', '0000-00-00 00:00:00')";
          $response = $this->mysqli_lib->insert($query);

          if($response > 0)
          {
              // $query = "INSERT INTO tbl_complaint_details_banca_bank(complaint_id,policy_num,description,bank,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,is_email,customer_email,is_sms,response_number,is_call_back) VALUES ('$response','$policynum','$description','$bank','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back')";

              $query = "INSERT INTO tbl_complaint_details_banca_bank (complaint_id,group_no,company_name,certificate_no,reported_by,agent,hospital,description,bank,callback_num,delivery_address,office_address,email,office_phone,mobile_number,residence_phone,is_email,customer_email,is_sms,response_number,is_call_back)
              VALUES('$response','$txtGroupNo','$CompanyName','$txtCertificate','$ddlReportedBy','$AgentBroker','$HospitalNameC','$description','$bank','$callback_num','$correspondenceAddress','$office_addr','$email','$office_num','$mobile_num','$residence_num','$is_email','$cust_email','$is_sms','$response_no','$is_call_back')";

               $result = $this->mysqli_lib->insert($query);

               $msg = "Dear Customer,\\nThank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;
              $msg = str_replace(' ', '%20', $msg);
              $mobile_num = $this->check_num($mobile_num);
              $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
              $res = file_get_contents($url);

              if($response_no != $mobile_num)
              {
                $response_no = $this->check_num($response_no);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                $res = file_get_contents($url);
              }

               //$sendmail = send_mail_complaint_customer($email,$counter_display,'0');
               //$sendmail      = send_mail_complaint_customer($email,$counter_display,'0');
               $msg = "Dear Customer,Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:" . $counter_display;

              $cmp_type  = $this->GetComplaintTypeList($complaint_type);
              $agnt = $this->GetUsersById($login_id);
              $agent = $agnt['first_name']." ".$agnt['last_name'];
              $usr_detail = $this->GetUsersById($userid);
              $user_name = $usr_detail['first_name']." ".$usr_detail['last_name'];
              $to_email = $usr_detail['email'];
              $depart_nm = $this->GetDepart($group_id);
              $depart = $depart_nm['primary_name'];

              if(!empty($cmp_type)){
                  $complaint_type = $cmp_type[0]['fullname'];
                      $priority = "" ;
                      if($cmp_type[0]['fullname'] == '1'){
                             $priority = "High" ;
                      }elseif ($cmp_type[0]['fullname'] == '2') {
                              $priority = "Low" ;
                      }else{
                           $priority = "Medium" ;
                      }
              }

              //$sendmail_user = send_mail_level_one($user_name,$agent,$counter_display,$depart,$complaint_type,$priority,$description,$to_email);

               return $response."|".$counter_display;
          }
          else
          {
            return "fail";
          }
      }  
    }

    function SaveComplaintDetails($complaint_id,$complaint_counter,$cnic,$customer_name,$card_number,$branch,$callback,$office_phone,$mobile_number,$residence_address,$alternate_address,$residence_phone,$email,$is_email,$is_sms,$response_number)
    {
        $query = "INSERT INTO tbl_complaint_details (complaint_id,complaint_counter,cnic,customer_name,card_number,branch,callback,office_phone,mobile_number,residence_address,alternate_address,
                  residence_phone,email,is_email,is_sms,response_number)";

        $query .= "VALUES('$complaint_id','$complaint_counter','$cnic','$customer_name','$card_number','$branch','$callback','$office_phone','$mobile_number','$residence_address','$alternate_address','$residence_phone','$email','$is_email','$is_sms','$response_number')";

        $response = $this->mysqli_lib->insert($query);

        if($response > 0){
            //$this->obj_user->SaveNotification($complaint_id,'complaint');
            return "success";
        }
        else{
            return "fail";
        }
    }

    function ForwardComplaint($complaint_id,$department,$users, $comments)
    {
        $query = "UPDATE tbl_complaints SET comments = '$comments', comments_progress = '', department_id = '$department', user_id = '$users', status_id = '2', forward_date = NOW()
                  WHERE complaint_id = '$complaint_id'";
        $this->mysqli_lib->update($query);
        return $response = "success";
    }

    function ProgressComplaint($login_id,$complaint_id,$channel,$user_id,$progress,$notes)
    {
        $user_id = implode(",", $user_id);
        $query_part = "";

        if($progress == '100')
        {
            $status_id = '3';
            $query_part .= ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
            $status_id = '5';
            $progress = '0';
            $query_part .= ", group_id = '0', user_id = '0'";
        }
        else
        {
            $status_id = '2';
        }

        $query = "UPDATE tbl_complaints SET channel = '$channel', comments_progress = '$notes', progress = '$progress', status_id = '$status_id' $query_part WHERE complaint_id = '$complaint_id'";
        $this->mysqli_lib->update($query);

        $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$user_id,$progress,$notes);

        return $response = "success";
    }

    function UpdateComplaint($Id,$group_id,$user_id)
    {
        $user_id = implode(",", $user_id);
        $query = "UPDATE tbl_complaints SET group_id = '$group_id', user_id = '$user_id', status_id = '2', forward_date = NOW() WHERE complaint_id = '$Id'";

        //return $query;
        $this->mysqli_lib->update($query);

        return "success";
    }

    function CloseComplaint($complaint_id,$comments)
    {
        $query = "UPDATE tbl_complaints SET status_id = '3', comments_close = '$comments', close_date = NOW() WHERE complaint_id = '$complaint_id'";
        $this->mysqli_lib->update($query);
        return $response = "success";
    }

    function GetComplaintById($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_life.*, tbl_complaint_details_life.email AS cemail ,tbl_complaint_details_life.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail, tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name, tbl_source.fullname source
      FROM tbl_complaints_life
      LEFT JOIN tbl_complaint_details_life ON tbl_complaints_life.complaint_id = tbl_complaint_details_life.complaint_id
      LEFT JOIN tbl_users ON tbl_complaints_life.agent_id = tbl_users.id
      LEFT JOIN tbl_status ON tbl_complaints_life.status_id = tbl_status.id
      LEFT JOIN tbl_complaint_status ON tbl_complaints_life.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'individual' 
      LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_life.product_id
      LEFT JOIN tbl_complaint_type ON tbl_complaints_life.complaint_type_id = tbl_complaint_type.id
      LEFT JOIN tbl_groups ON tbl_complaints_life.group_id = tbl_groups.id
      LEFT JOIN tbl_source ON tbl_complaints_life.channel = tbl_source.id 
      WHERE tbl_complaints_life.complaint_id = '$id'
      LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdVatality($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_vatality.*, tbl_complaint_details_vatality.email AS cemail , tbl_complaints_vatality.complaint_id As cmv_id ,tbl_complaint_details_vatality.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail , tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name, tbl_source.fullname source
      FROM tbl_complaints_vatality
      LEFT JOIN tbl_complaint_details_vatality ON tbl_complaints_vatality.complaint_id = tbl_complaint_details_vatality.complaint_id
      LEFT JOIN tbl_users ON tbl_complaints_vatality.agent_id = tbl_users.id
      LEFT JOIN tbl_status ON tbl_complaints_vatality.status_id = tbl_status.id
      LEFT JOIN tbl_complaint_status ON tbl_complaints_vatality.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'vatality' 
      LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_vatality.product_id
      LEFT JOIN tbl_complaint_type ON tbl_complaints_vatality.complaint_type_id = tbl_complaint_type.id
      LEFT JOIN tbl_groups ON tbl_complaints_vatality.group_id = tbl_groups.id
      LEFT JOIN tbl_source ON tbl_complaints_vatality.channel = tbl_source.id 
      WHERE tbl_complaints_vatality.complaint_id = '$id'
      LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdCorporate($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_cooperate.*, tbl_complaint_details_cooperate.email AS cemail ,tbl_complaint_details_cooperate.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail , tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name, tbl_source.fullname source, tbl_hospitals.fullname hospital, tbl_agency.fullname agency
      FROM tbl_complaints_cooperate
      LEFT JOIN tbl_complaint_details_cooperate ON tbl_complaints_cooperate.complaint_id = tbl_complaint_details_cooperate.complaint_id
      LEFT JOIN tbl_users ON tbl_complaints_cooperate.agent_id = tbl_users.id
      LEFT JOIN tbl_status ON tbl_complaints_cooperate.status_id = tbl_status.id
      LEFT JOIN tbl_complaint_status ON tbl_complaints_cooperate.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'cooperate' 
      LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_cooperate.product_id
      LEFT JOIN tbl_complaint_type ON tbl_complaints_cooperate.complaint_type_id = tbl_complaint_type.id
      LEFT JOIN tbl_groups ON tbl_complaints_cooperate.group_id = tbl_groups.id
      LEFT JOIN tbl_source ON tbl_complaints_cooperate.channel = tbl_source.id
      LEFT JOIN tbl_hospitals ON tbl_complaint_details_cooperate.hospital = tbl_hospitals.id 
      LEFT JOIN tbl_agency ON tbl_complaint_details_cooperate.agent = tbl_agency.id  
      WHERE tbl_complaints_cooperate.complaint_id = '$id'
      LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdBancaBank($id,$cmode)
    {   
        $query = "SELECT tbl_complaints_banca_bank.*, tbl_complaint_details_banca_bank.email AS cemail ,tbl_complaint_details_banca_bank.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail , tbl_status.fullname `status`,  tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name,  tbl_source.fullname source, tbl_hospitals.fullname hospital, tbl_agency.fullname agency FROM tbl_complaints_banca_bank
        LEFT JOIN tbl_complaint_details_banca_bank ON tbl_complaints_banca_bank.complaint_id = tbl_complaint_details_banca_bank.complaint_id
        LEFT JOIN tbl_users ON tbl_complaints_banca_bank.agent_id = tbl_users.id
        LEFT JOIN tbl_status ON tbl_complaints_banca_bank.status_id = tbl_status.id
        LEFT JOIN tbl_complaint_status ON tbl_complaints_banca_bank.status_id = tbl_complaint_status.id  AND tbl_complaint_status.complaint_mode = 'bancaBank' 
        LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_banca_bank.product_id
        LEFT JOIN tbl_complaint_type ON tbl_complaints_banca_bank.complaint_type_id = tbl_complaint_type.id
        LEFT JOIN tbl_groups ON tbl_complaints_banca_bank.group_id = tbl_groups.id
        LEFT JOIN tbl_source ON tbl_complaints_banca_bank.channel = tbl_source.id
        LEFT JOIN tbl_hospitals ON tbl_complaint_details_banca_bank.hospital = tbl_hospitals.id 
        LEFT JOIN tbl_agency ON tbl_complaint_details_banca_bank.agent = tbl_agency.id  
        WHERE tbl_complaints_banca_bank.complaint_id = '$id'
        LIMIT 1";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdLegal($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_legal.*, tbl_complaint_details_legal.email AS cemail ,tbl_complaint_details_legal.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail , tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name, tbl_source.fullname source, tbl_hospitals.fullname hospital, tbl_agency.fullname agency
        FROM tbl_complaints_legal
        LEFT JOIN tbl_complaint_details_legal ON tbl_complaints_legal.complaint_id = tbl_complaint_details_legal.complaint_id
        LEFT JOIN tbl_users ON tbl_complaints_legal.agent_id = tbl_users.id
        LEFT JOIN tbl_status ON tbl_complaints_legal.status_id = tbl_status.id
        LEFT JOIN tbl_complaint_status ON tbl_complaints_legal.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'legal' 
        LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_legal.product_id
        LEFT JOIN tbl_complaint_type ON tbl_complaints_legal.complaint_type_id = tbl_complaint_type.id
        LEFT JOIN tbl_groups ON tbl_complaints_legal.group_id = tbl_groups.id
        LEFT JOIN tbl_source ON tbl_complaints_legal.channel = tbl_source.id
        LEFT JOIN tbl_hospitals ON tbl_complaint_details_legal.hospital = tbl_hospitals.id 
        LEFT JOIN tbl_agency ON tbl_complaint_details_legal.agent = tbl_agency.id  
        WHERE tbl_complaints_legal.complaint_id = '$id'
        LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdInternal($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_internal.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email , tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`
        FROM tbl_complaints_internal
        LEFT JOIN tbl_users ON tbl_complaints_internal.agent_id = tbl_users.id
        LEFT JOIN tbl_status ON tbl_complaints_internal.status_id = tbl_status.id
        LEFT JOIN tbl_complaint_status ON tbl_complaints_internal.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'internal' 
        LEFT JOIN tbl_complaint_type ON tbl_complaints_internal.complaint_type_id = tbl_complaint_type.id
        LEFT JOIN tbl_groups ON tbl_complaints_internal.group_id = tbl_groups.id
        WHERE tbl_complaints_internal.complaint_id = '$id'
        LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByIdBanca($id,$cmode)
    {   
      $query = "SELECT tbl_complaints_banca.*, tbl_complaint_details_banca.email AS cemail ,tbl_complaint_details_banca.*, tbl_users.user_name, tbl_groups.primary_name department_name, tbl_groups.email AS gemail , tbl_status.fullname `status`, tbl_complaint_type.fullname `complaint_type`, tbl_product.fullname product_name, tbl_source.fullname source
      FROM tbl_complaints_banca
      LEFT JOIN tbl_complaint_details_banca ON tbl_complaints_banca.complaint_id = tbl_complaint_details_banca.complaint_id
      LEFT JOIN tbl_users ON tbl_complaints_banca.agent_id = tbl_users.id
      LEFT JOIN tbl_status ON tbl_complaints_banca.status_id = tbl_status.id
      LEFT JOIN tbl_complaint_status ON tbl_complaints_banca.status_id = tbl_complaint_status.id AND tbl_complaint_status.complaint_mode = 'bancaIndividual' 
      LEFT JOIN tbl_product ON tbl_product.id = tbl_complaints_banca.product_id
      LEFT JOIN tbl_complaint_type ON tbl_complaints_banca.complaint_type_id = tbl_complaint_type.id
      LEFT JOIN tbl_groups ON tbl_complaints_banca.group_id = tbl_groups.id
      LEFT JOIN tbl_source ON tbl_complaints_banca.channel = tbl_source.id 
      WHERE tbl_complaints_banca.complaint_id = '$id'
      LIMIT 1";
      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintStatusById($complaint_id,$cmode)
    {
      $query = "SELECT t.*, usr.user_name FROM tbl_complaint_status t INNER JOIN tbl_users usr ON usr.id = t.login_id WHERE t.complaint_id = '$complaint_id' AND t.complaint_mode = '$cmode' ORDER BY t.id DESC";
      return $this->mysqli_lib->fetch_all($query);
    }

    /* by kamran */
    function ProgressComplaintlife($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {
        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        else
        {
          $status_id = '2';
        }

        $table = "tbl_complaints_life";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }

        if($manual == "1"){
            $status_id = '1';
                if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_life SET status_id = '$status_id', group_id = '$departmentName', user_id = '$new_user' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_life SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$new_user' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }
         }elseif($manual == "2"){

              if($valid == '0'){

                $status_id = '5';
                $query = "UPDATE tbl_complaints_life SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                 $query = "UPDATE tbl_complaints_life SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }        
         }else{
              $query = "UPDATE tbl_complaints_life SET status_id = '$status_id', progress = '$progress' $onhold  WHERE complaint_id = '$complaint_id'  AND type = '$cmode'";
              $this->mysqli_lib->update($query);

              $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }
        if($status_id == '3'){
               $data = $this->GetComplaintById($complaint_id,'individual');
               $counter_display = $data[0]['complaint_num'];
               $email ="";
               $email  = $data[0]['email'];
               $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];
                $response_no  = $data[0]['response_number'];
                $mobile_num = $this->check_num($mobile_num);
                $response_no = $this->check_num($response_no);
               `echo "$mobile_num|$respon_no" >> /tmp/hs.log`;
                //if($response_no != $mobile_num){
                   $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $res = file_get_contents($url);      
                 //}
                $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $ress = file_get_contents($urls);
        }

        return $response = "success|".$email."|".$counter_display;
    }

    function ProgressComplaintCorporate($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {
        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        else
        {
          $status_id = '2';
        }
        $table = "tbl_complaints_cooperate";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }
        if($manual == "1"){
            $status_id = '1';
            if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id', group_id = '$departmentName', user_id = '$new_user' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$new_user' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }

             /*$query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);*/

         }elseif($manual == "2"){
            //echo $valid."|";
             if($valid == "0"){
                
                $status_id = '5';
                $query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                $query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }

         }
         else
         {
            $query = "UPDATE tbl_complaints_cooperate SET status_id = '$status_id', progress = '$progress'  $onhold WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
            $this->mysqli_lib->update($query);

            $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }

       if($status_id == '3')
       {
            $data = $this->GetComplaintByIdCorporate($complaint_id,'corporate');
            $counter_display = $data[0]['complaint_num'];
            $email ="";
            $email  = $data[0]['email'];
               
            $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];

                $mobile_num = $this->check_num($mobile_num);
                
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
                $response_no  = $data[0]['response_number'];
                $response_no = $this->check_num($response_no);
               `echo "$mobile_num|$respon_no" >> /tmp/hs.log`;
                //if($response_no != $mobile_num){
                   $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $ress = file_get_contents($urls);
                //}
       }

       return $response = "success|".$email."|".$counter_display;
    }

    function ProgressComplaintLegal($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type,$refund_ammount) 
    {
        $valid = "1";
        $onhold = "";

        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        elseif($progress == '99')
        {
          $status_id = '1';
          $progress = '0';
        }
        else
        {
          $status_id = '2';
        }

        $table = "tbl_complaints_legal";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];

        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 )
            {
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else
            {
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
            $onhold = ", end_date = '$end_date'";
        }

        if($manual == "1")
        {
            $status_id = '1';

            if($is_manual == 0)
            {
                $query = "UPDATE tbl_complaints_legal SET status_id = '$status_id', group_id = '$departmentName', user_id = '$cmp_user_name' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                $this->mysqli_lib->update($query);
            }
            else
            {
                $query = "UPDATE tbl_complaints_legal SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                $this->mysqli_lib->update($query);
            }

            /*$query = "UPDATE tbl_complaints_legal SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
            $this->mysqli_lib->update($query);*/
        }
        elseif($manual == "2")
        {
            if($valid == "0")
            {
                $status_id = '5';
                $query = "UPDATE tbl_complaints_legal SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                $this->mysqli_lib->update($query);
                $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);
            }
            else
            {
                $status_id = '1';
                $query = "UPDATE tbl_complaints_legal SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                $this->mysqli_lib->update($query);
                $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);
            }
        }
        else
        {
            $query = "UPDATE tbl_complaints_legal SET status_id = '$status_id', progress = '$progress' $onhold WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
            $this->mysqli_lib->update($query);

            $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);

            // New Added By Kamran Jabbar
            $query1 = "UPDATE tbl_complaint_details_legal SET refun_amount = '$refund_ammount' WHERE complaint_id = '$complaint_id'";
            $this->mysqli_lib->update($query1);
        }

        // Sent Email
        if($status_id == '3')
        {
           $data = $this->GetComplaintByIdLegal($complaint_id,'legal');
           $counter_display = $data[0]['complaint_num'];
           $email ="";
           $email  = $data[0]['email'];
               
            $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];
                $mobile_num = $this->check_num($mobile_num);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
                $response_no  = $data[0]['response_number'];
                $response_no = $this->check_num($response_no);
               `echo "$mobile_num|$respon_no" >> /tmp/hs.log`;
                //if($response_no != $mobile_num){
                   $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $res = file_get_contents($urls);
                 //}
        }

        return $response = "success|".$email."|".$counter_display;
    }

    function ProgressComplaintInternal($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {
        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
         elseif($progress == '99')
        {
          $status_id = '1';
          $progress = '0';
          
        }
         elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        else
        {
          $status_id = '2';
        }
        $table = "tbl_complaints_internal";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }

        

        if($manual == "1"){
            $status_id = '1';
            if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_internal SET status_id = '$status_id', group_id = '$departmentName', user_id = '$cmp_user_name' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_internal SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }
             /*$query = "UPDATE tbl_complaints_internal SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);*/

         }elseif($manual == "2"){
            if($valid == "0"){   
                $status_id = '5';
                $query = "UPDATE tbl_complaints_internal SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                $query = "UPDATE tbl_complaints_internal SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }

         }else{
              $query = "UPDATE tbl_complaints_internal SET status_id = '$status_id', progress = '$progress' $onhold WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);

              $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }

        return $response = "success";
    }

    function ProgressComplaintBanca($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {

        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        else
        {
          $status_id = '2';
        }

        $table = "tbl_complaints_banca";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }

        if($manual == "1"){
            $status_id = '1';
            if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_banca SET status_id = '$status_id', group_id = '$departmentName', user_id = '$cmp_user_name' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_banca SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }
             /*$query = "UPDATE tbl_complaints_banca SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);*/

         }elseif($manual == "2"){

              if($valid == '0'){

                $status_id = '5';
                $query = "UPDATE tbl_complaints_banca SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                $query = "UPDATE tbl_complaints_banca SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }        
         }else{
              $query = "UPDATE tbl_complaints_banca SET status_id = '$status_id', progress = '$progress' $onhold  WHERE complaint_id = '$complaint_id'  AND type = '$cmode'";
              $this->mysqli_lib->update($query);

              $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }

        if($status_id == '3'){
               $data = $this->GetComplaintByIdBanca($complaint_id,'bancaIndividual');
               $counter_display = $data[0]['complaint_num'];
               $email ="";
               $email  = $data[0]['email'];
               
            
           $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];
                $mobile_num = $this->check_num($mobile_num);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
                $response_no  = $data[0]['response_number'];
                $response_no = $this->check_num($response_no);
                //if($response_no != $mobile_num){
                   $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $ress = file_get_contents($urls);
                 //}


        }

        return $response = "success|".$email."|".$counter_display;
    }

    function ProgressComplaintBancaBank($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {

        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        else
        {
          $status_id = '2';
        }

        $table = "tbl_complaints_banca_bank";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }

        if($manual == "1"){
            $status_id = '1';
            if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id', group_id = '$departmentName', user_id = '$cmp_user_name' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }
             /*$query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);*/

         }elseif($manual == "2"){

              if($valid == '0'){

                $status_id = '5';
                $query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                $query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }        
         }else{
              $query = "UPDATE tbl_complaints_banca_bank SET status_id = '$status_id', progress = '$progress' $onhold  WHERE complaint_id = '$complaint_id'  AND type = '$cmode'";
              $this->mysqli_lib->update($query);

              $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }

         if($status_id == '3'){
               $data = $this->GetComplaintByIdBancaBank($complaint_id,'bancaBank');
               $counter_display = $data[0]['complaint_num'];
               $email ="";
               $email  = $data[0]['email'];
               
            $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];
                $mobile_num = $this->check_num($mobile_num);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
                $response_no  = $data[0]['response_number'];
                //if($response_no != $mobile_num){
                   $response_no = $this->check_num($response_no);
                   $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $ress = file_get_contents($urls);
                 //}

        }
        return $response = "success|".$email."|".$counter_display;
    }

    function ProgressComplaintVatality($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$reassign,$user_id,$pri,$tatt,$user,$new_user,$is_manual,$departmentName,$cmp_type) 
    {
        $valid = "1";
        $onhold = "";
        if($progress == '100')
        {
          $status_id = '3';
          $onhold = ", close_date = NOW()";
        }
        elseif($progress == '101')
        {
          $status_id = '5';
          $progress = '0';
          $valid = "0";
        }
        elseif($progress == '11')
        {
          $status_id = '4';
          $onhold = ", forward_date = NOW()";
        }
        elseif($progress == '1000')
        {
          $status_id = '1';
              if($reassign == "0"){
                 $onhold = ", user_id = '16' ";
                 $reassign = "1";
              }else{
                 $onhold = ", user_id = '62'";
                 $reassign = "2";
              }
          $query = "UPDATE tbl_complaint_details_vatality SET reassign = '$reassign'  WHERE complaint_id = '$complaint_id'";
           $this->mysqli_lib->update($query);
          
        }
        else
        {
          $status_id = '2';
        }

        $table = "tbl_complaints_vatality";
        $lstatus = $this->GetComplaintpreStatusById($table,$cmode,$complaint_id);
        $last_status = $lstatus['status_id'];
        if($last_status == "4" AND $status_id == "2")
        {
            $forward_date =  $lstatus['forward_date'];
            $create_date  =  $lstatus['create_date'];
            $end_date     =  $lstatus['end_date'];
            $totat_time   =  $this->LeadTime($create_date,  $end_date);
            $ohld_time    =  $this->LeadTime($forward_date, $end_date);

            $time         = $totat_time - $ohld_time;
            $dt           =  date('Y-m-d h:i:s');
            $diff_onhold  =  $this->LeadTime($end_date, $dt);
            $forw         =  $this->LeadTime($forward_date, $dt);
            $days = $forw . 'days';
            if($diff_onhold > 0 ){
              $end_date = date('Y-m-d', strtotime($dt. $days));
            }else{
             $end_date = date('Y-m-d', strtotime($end_date. $days));

            }
          
 
            $onhold = ", end_date = '$end_date'";
        }

        if($manual == "1"){
            $status_id = '1';
            if($is_manual == 0){
                      $query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id', group_id = '$departmentName', user_id = '$cmp_user_name' , priority_id = '$pri' , tat = '$tatt' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                      $this->mysqli_lib->update($query);

                }else{
                    
                    $query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                }
             /*$query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id', group_id = '$cmp_user_group', user_id = '$cmp_user_name' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
              $this->mysqli_lib->update($query);*/

         }elseif($manual == "2"){

              if($valid == '0'){

                $status_id = '5';
                $query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id', group_id = '0', user_id = '0' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }else{
                $status_id = '1';
                $query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id' WHERE complaint_id = '$complaint_id' AND type = '$cmode'";
                  $this->mysqli_lib->update($query);
                  $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,'0',$notes,$cmode);

              }        
         }else{
               $query = "UPDATE tbl_complaints_vatality SET status_id = '$status_id', progress = '$progress' $onhold  WHERE complaint_id = '$complaint_id'  AND type = '$cmode'";
              $this->mysqli_lib->update($query);

              $this->SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode);
        }

         if($status_id == '3'){
               $data = $this->GetComplaintByIdVatality($complaint_id,'vatality');
               $counter_display = $data[0]['complaint_num'];
               $email ="";
               $email  = $data[0]['email'];
               
            $msg ="Dear Customer,\\nKindly note that your complaint no. $counter_display has been resolved at our end.\\nFor any further assistance you can contact on UAN 021-111 111 711.\\nWe look forward to serving you better.\\nBest Regards,\\nCustomer Experience and Conservation Department";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $data[0]['mobile_number'];
                $mobile_num = $this->check_num($mobile_num);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
                $response_no  = $data[0]['response_number'];
                $response_no = $this->check_num($response_no);
                //if($respon_no != $mobile_num){
                   $urls ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$response_no";
                   $ress = file_get_contents($urls);
                 //}

        }

        return $response = "success|".$email."|".$counter_display;
    }

    /* by Kamran */
    function SaveComplaintStatus($login_id,$complaint_id,$status_id,$progress,$notes,$cmode)
    {
        $query = "INSERT INTO tbl_complaint_status (login_id,complaint_id,complaint_mode,current_state,progress,comments) VALUES('$login_id','$complaint_id','$cmode','$status_id','$progress','$notes')";
        $this->mysqli_lib->insert($query);
    }

    /*haroon*/
    function GetComplaint($login_id, $complain_id,$user_type,$group_id)
    {
      $query = "";
      $query .= "SELECT * from vw_get_complaint";

      if($user_type == 1)
      {
          $query .= " WHERE 1=1 ";

          if($complain_id <> 0)
          {
            $query .= " AND complaint_id = '".$complain_id."'";
          }
           $query .= " ORDER BY create_date DESC";
           //$query;
      }
      elseif($user_type == 2)
      {

        $query .= " WHERE group_id IN ($group_id) OR agent_id ='$login_id'";

            if($complain_id <> 0)
            {
              $query .= " AND complaint_id = '".$complain_id."'";
            }
            $query .= " ORDER BY create_date DESC"; 
      }
      else
      {
            $query .= " WHERE  (agent_id = '$login_id' OR user_id = '$login_id') ";

            if($complain_id <> 0)
            {
              $query .= " AND complaint_id = '".$complain_id."'";
            }
            $query .= " ORDER BY create_date DESC";
      }

      //return $query;

      $response = $this->mysqli_lib->fetch_all($query);
      return $response;
    }
    /*haron*/

    /* by kamran*/
    /*function GetComplaint($login_id, $complain_id,$user_type,$group_id)
    {
      if($user_type == 1)
      {
          $query = "";
          $query .= "SELECT cl.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_life cl 
            LEFT JOIN tbl_users ur ON ur.id = cl.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cl.channel LEFT JOIN tbl_users urs ON urs.id = cl.user_id LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart
            UNION
            SELECT cc.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_cooperate cc
            LEFT JOIN tbl_users ur ON ur.id = cc.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cc.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cc.channel LEFT JOIN tbl_users urs ON urs.id = cc.user_id LEFT JOIN tbl_groups grp ON grp.id = cc.complaint_depart
            UNION
            SELECT clg.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_legal clg LEFT JOIN tbl_users ur ON ur.id = clg.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = clg.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = clg.channel LEFT JOIN tbl_users urs ON urs.id = clg.user_id LEFT JOIN tbl_groups grp ON grp.id = clg.complaint_depart
            UNION
            SELECT ci.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM tbl_complaints_internal ci
            LEFT JOIN tbl_users ur ON ur.id = ci.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = ci.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = ci.channel LEFT JOIN tbl_users urs ON urs.id = ci.user_id LEFT JOIN tbl_groups grp ON grp.id = ci.complaint_depart
            UNION
            SELECT cb.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, 
            CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_banca cb LEFT JOIN tbl_users ur ON ur.id = cb.agent_id  LEFT JOIN tbl_complaint_type ct ON ct.id = cb.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cb.channel LEFT JOIN tbl_users urs ON urs.id = cb.user_id LEFT JOIN tbl_groups grp ON grp.id = cb.complaint_depart
          UNION
          SELECT cbb.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, 
            CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_banca_bank cbb 
            LEFT JOIN tbl_users ur ON ur.id = cbb.agent_id  LEFT JOIN tbl_complaint_type ct ON ct.id = cbb.complaint_type_id 
            LEFT JOIN tbl_source sr ON sr.id = cbb.channel 
            LEFT JOIN tbl_users urs ON urs.id = cbb.user_id LEFT JOIN tbl_groups grp ON grp.id = cbb.complaint_depart
            UNION
            SELECT cvt.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, 
            CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_vatality cvt 
            LEFT JOIN tbl_users ur ON ur.id = cvt.agent_id  LEFT JOIN tbl_complaint_type ct ON ct.id = cvt.complaint_type_id 
            LEFT JOIN tbl_source sr ON sr.id = cvt.channel 
            LEFT JOIN tbl_users urs ON urs.id = cvt.user_id LEFT JOIN tbl_groups grp ON grp.id = cvt.complaint_depart WHERE 1=1 ";

          if($complain_id <> 0)
          {
            $query .= " AND complaint_id = '".$complain_id."'";
          }
           $query .= " ORDER BY create_date DESC";
      }
      elseif($user_type == 2)
      {

        $query = "";
        $query .= "SELECT cl.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_life cl 
            LEFT JOIN tbl_users ur ON ur.id = cl.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cl.channel LEFT JOIN tbl_users urs ON urs.id = cl.user_id  LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart WHERE cl.group_id IN ($group_id) OR cl.agent_id ='$login_id'
            UNION
            SELECT cc.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_cooperate cc
            LEFT JOIN tbl_users ur ON ur.id = cc.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cc.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cc.channel LEFT JOIN tbl_users urs ON urs.id = cc.user_id LEFT JOIN tbl_groups grp ON grp.id = cc.complaint_depart  WHERE cc.group_id IN ($group_id) OR cc.agent_id ='$login_id'
            UNION
            SELECT clg.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM tbl_complaints_legal clg LEFT JOIN tbl_users ur ON ur.id = clg.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = clg.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = clg.channel LEFT JOIN tbl_users urs ON urs.id = clg.user_id LEFT JOIN tbl_groups grp ON grp.id = clg.complaint_depart WHERE clg.group_id IN ($group_id) OR clg.agent_id ='$login_id'
            UNION
            SELECT ci.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM tbl_complaints_internal ci
            LEFT JOIN tbl_users ur ON ur.id = ci.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = ci.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = ci.channel LEFT JOIN tbl_users urs ON urs.id = ci.user_id LEFT JOIN tbl_groups grp ON grp.id = ci.complaint_depart WHERE ci.group_id IN ($group_id) OR ci.agent_id ='$login_id'
            UNION
            SELECT cb.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_banca cb LEFT JOIN tbl_users ur ON ur.id = cb.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cb.complaint_type_id  LEFT JOIN tbl_source sr ON sr.id = cb.channel 
            LEFT JOIN tbl_users urs ON urs.id = cb.user_id  LEFT JOIN tbl_groups grp ON grp.id = cb.complaint_depart  WHERE cb.group_id IN ($group_id) OR cb.agent_id ='$login_id'";

            if($complain_id <> 0)
            {
              $query .= " AND complaint_id = '".$complain_id."'";
            }
            $query .= " ORDER BY create_date DESC"; 
      }
      else
      {
        $query = "";
        $query .= "SELECT cl.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_life cl 
            LEFT JOIN tbl_users ur ON ur.id = cl.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cl.channel LEFT JOIN tbl_users urs ON urs.id = cl.user_id LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart WHERE  (cl.agent_id = '$login_id' OR cl.user_id = '$login_id') 
            UNION
            SELECT cc.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_cooperate cc
            LEFT JOIN tbl_users ur ON ur.id = cc.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = cc.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = cc.channel LEFT JOIN tbl_users urs ON urs.id = cc.user_id LEFT JOIN tbl_groups grp ON grp.id = cc.complaint_depart WHERE  (cc.agent_id = '$login_id' OR cc.user_id = '$login_id') 
            UNION
            SELECT clg.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM tbl_complaints_legal clg LEFT JOIN tbl_users ur ON ur.id = clg.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = clg.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = clg.channel LEFT JOIN tbl_users urs ON urs.id = clg.user_id LEFT JOIN tbl_groups grp ON grp.id = clg.complaint_depart  WHERE  (clg.agent_id = '$login_id' OR clg.user_id = '$login_id') 
            UNION
            SELECT ci.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source, CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM tbl_complaints_internal ci
            LEFT JOIN tbl_users ur ON ur.id = ci.agent_id LEFT JOIN tbl_complaint_type ct ON ct.id = ci.complaint_type_id LEFT JOIN tbl_source sr ON sr.id = ci.channel LEFT JOIN tbl_users urs ON urs.id = ci.user_id LEFT JOIN tbl_groups grp ON grp.id = ci.complaint_depart WHERE  (ci.agent_id = '$login_id' OR ci.user_id = '$login_id')
              UNION
              SELECT cb.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname  AS ComplaintType, sr.fullname AS Source,  CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart FROM tbl_complaints_banca cb  LEFT JOIN tbl_users ur ON ur.id = cb.agent_id  LEFT JOIN tbl_complaint_type ct ON ct.id = cb.complaint_type_id  LEFT JOIN tbl_source sr ON sr.id = cb.channel LEFT JOIN tbl_users urs ON urs.id = cb.user_id  LEFT JOIN tbl_groups grp ON grp.id = cb.complaint_depart 
                WHERE (cb.agent_id = '$login_id' OR cb.user_id = '$login_id') ";

        if($complain_id <> 0)
        {
          $query .= " AND complaint_id = '".$complain_id."'";
        }
        $query .= " ORDER BY create_date DESC";
      }

      $response = $this->mysqli_lib->fetch_all($query);
      return $response;
    }*/

    function VerifiedComplaint($complaint_id,$comments)
    {
        $query = "UPDATE tbl_complaints SET status_id = '4', comments_verified = '$comments' WHERE complaint_id = '$complaint_id'";
        $this->mysqli_lib->update($query);
        return $response = "success";
    }

    function GetEFormByID($id)
    {
        $query = "SELECT ed.*, e.locked_by,e.status_id,e.progress,e.file_counter,e.comments,e.comments_progress,e.comments_verified,e.current_datetime
                  FROM tbl_eform_details ed
                  INNER JOIN tbl_eform_add e ON e.id = ed.eform_id
                  WHERE ed.id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintByAgents($login_id)
    {
        $query = "";
        $query .= "SELECT tbl_complaints.*, tbl_users.user_name, tbl_department.fullname department, tbl_department.email,
                 tbl_status.fullname `status`, tbl_complaint_type.fullname `type`, tbl_product.fullname product_name
                 FROM tbl_complaints
                 INNER JOIN tbl_users ON tbl_complaints.agent_id = tbl_users.id
                 INNER JOIN tbl_status ON tbl_complaints.status_id = tbl_status.id
                 INNER JOIN tbl_product ON tbl_product.id = tbl_complaints.complaint_product_id
                 INNER JOIN tbl_complaint_type ON tbl_complaints.complaint_type_id = tbl_complaint_type.id
                 LEFT JOIN tbl_department ON tbl_complaints.department_id = tbl_department.id WHERE 1=1 ";

        if($login_id != 1)
        {
            $query .= " AND tbl_complaints.agent_id = '".$login_id."'";
        }

        $response = $this->mysqli_lib->fetch_all($query);
        return $response;
    }

    function GetComplaintByDepartment($department_id)
    {
        $query = "";
        $query .= "SELECT tbl_complaints.*, tbl_users.user_name, tbl_department.fullname department, tbl_department.email,
                 tbl_status.fullname `status`, tbl_complaint_type.fullname `type`, tbl_product.fullname product_name
                 FROM tbl_complaints
                 INNER JOIN tbl_users ON tbl_complaints.agent_id = tbl_users.id
                 INNER JOIN tbl_status ON tbl_complaints.status_id = tbl_status.id
                 INNER JOIN tbl_product ON tbl_product.id = tbl_complaints.complaint_product_id
                 INNER JOIN tbl_complaint_type ON tbl_complaints.complaint_type_id = tbl_complaint_type.id
                 LEFT JOIN tbl_department ON tbl_complaints.department_id = tbl_department.id WHERE 1=1
                 AND tbl_complaints.status_id IN ('2') AND tbl_complaints.department_id = '$department_id'";

        $response = $this->mysqli_lib->fetch_all($query);
        return $response;
    }

    function GetComplaintType($id)
    {
        if($id == 0)
            $query = "SELECT * FROM tbl_complaint_type WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_complaint_type WHERE id = '$id' AND isactive = 1;";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintTypeList($id)
    {
        if($id == 0)
            $query = "SELECT t.* FROM tbl_complaint_type t";
        else
            $query = "SELECT t.id `complaint_id`, t.group_id,t.fullname,t.operation_mode,t.tat,t.isactive,t.user_id,t.priority,te.* FROM tbl_complaint_type t INNER JOIN tbl_complaint_type_escalation te ON t.id = te.complaint_escalation_id WHERE t.id = '$id';";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetPriority()
    {
        $query = "SELECT * FROM tbl_priority WHERE is_active = 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function CheckOverDue($datetime)
    {
        if($datetime != '0000-00-00 00:00:00'){

            $str = date("Y-m-d", strtotime($datetime));
            $current_date = date("Y-m-d");
            /*$str = strtotime(date("Y-m-d")) - (strtotime($str));
            $difference = floor($str/3600/24);

            $query = "SELECT tat FROM tbl_complaint_type WHERE id = '$type_id'";
            $data = $this->mysqli_lib->fetch_all($query);
            $tat = $data[0]["tat"];*/

            //return $difference."|".$tat;

            if ($current_date > $datetime){
                return 1;
            }
             else{
                return 0;
            }

        }
        else{
            return 0;
        }

        /*if($difference > $tat){
            return "over";
        }else{
            return "normal";
        }*/
    }

    function LeadTime($created_date, $closed_date){

        $start_ts = strtotime($created_date);
        $end_ts = strtotime($closed_date);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    function SaveComplaintType($group_id,$user_id,$name,$tat,$mode,$priority,$is_active)
    {
        $query = "INSERT INTO tbl_complaint_type (group_id,user_id,fullname,tat,operation_mode, priority , isactive,created_on,updated_on)
                  VALUES ('$group_id','$user_id','$name','$tat','$mode','$priority','$is_active',NOW(),'0000-00-00 00:00:00')";

        $response = $this->mysqli_lib->insert($query);
        return $response;
    }

    function UpdateComplaintType($id,$group_id,$user_id,$name,$tat,$mode,$priority,$is_active)
    {
        $query = "UPDATE tbl_complaint_type SET group_id = '$group_id', user_id = '$user_id', fullname = '$name', tat = '$tat', operation_mode = '$mode', priority = '$priority',isactive = '$is_active',updated_on = NOW() WHERE id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function SaveComplaintTypeEscalation($complaint_escalation_id,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5)
    {
        $query = "INSERT INTO tbl_complaint_type_escalation (complaint_escalation_id,escalation_time1,level1,escalation_time2,level2,escalation_time3,level3,escalation_time4,level4,escalation_time5,level5)
				      VALUES ('$complaint_escalation_id','$time_period1','$level1','$time_period2','$level2','$time_period3','$level3','$time_period4','$level4','$time_period5','$level5')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateComplaintTypeEscalation($escalation_id,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5)
    {
        $query = "UPDATE tbl_complaint_type_escalation SET escalation_time1 = '$time_period1', level1 = '$level1', escalation_time2 = '$time_period2', level2 = '$level2',
                  escalation_time3 = '$time_period3', level3 = '$level3',escalation_time4 = '$time_period4', level4 = '$level4',
                  escalation_time5 = '$time_period5', level5 = '$level5' WHERE id ='$escalation_id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsLife($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_life SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsCo($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_cooperate SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsLegal($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_legal SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }
     
    function UpdateCommentsInternal($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_internal SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsBanca($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_banca SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsBancaBank($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_banca_bank SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function UpdateCommentsVatality($comments,$file_counter,$id)
    {
        $query = "UPDATE tbl_complaints_vatality SET comments = '$comments' , file_counter = '$file_counter' WHERE complaint_id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function DeleteComplaintType($id) 
    {
        $query = "DELETE FROM tbl_complaint_type WHERE id = '$id';";
        $res = $this->mysqli_lib->delete($query);
        if($res){
          return "success";
         }else{
           return "error";
         }
    }

    function GenComplaintCounter()
    {
        $first_digit = "CT";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterLife()
    {
        $first_digit = "CTID";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_life` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterVatality()
    {
        $first_digit = "CTVT";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_vatality` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterCooperate()
    {
        $first_digit = "CTCO";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_cooperate` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterLegal()
    {
        $first_digit = "CTLE";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_legal` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterInternal()
    {
        $first_digit = "CTIN";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_internal` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterBanca()
    {
        $first_digit = "CTBI";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_banca` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GenComplaintCounterBancaBank()
    {
        $first_digit = "CTBB";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql="SELECT IFNULL(MAX(daily_counter)+1,1) AS daily_counter FROM `tbl_complaints_banca_bank` WHERE DATE(`create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit.$date_part.$second_digit;
        return $next_counter."|".$row[0]['daily_counter'];
    }

    function GetProducts($id)
    {
        if($id == 0)
            $query = "SELECT * FROM tbl_product WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_product WHERE id = '$id' AND isactive = 1;";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintTypeByProduct($id)
    {
        $query = "SELECT * FROM tbl_complaint_type WHERE product_id = '$id' AND isactive = 1;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetStatus($id)
    {
        if($id == 0)
            $query = "SELECT * FROM tbl_status WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_status WHERE id = '$id' AND isactive = 1;";

        return $this->mysqli_lib->fetch_all($query);
    }

    /*function SaveComplaintStatus($login_id,$complaint_id,$status_id,$user_id,$progress,$notes)
    {
        $query = "INSERT INTO tbl_complaint_status (login_id,complaint_id,current_state,assign_to,progress,comments) VALUES('$login_id','$complaint_id','$status_id','$user_id','$progress','$notes')";
        $this->mysqli_lib->insert($query);
    }*/

    function GetComplaintStatus_Old($complaint_id)
    {
        $query = "SELECT tbl_complaints.complaint_counter,tbl_users.user_name, tbl_complaint_status.*
                  FROM tbl_complaint_status
                  INNER JOIN tbl_complaints ON tbl_complaint_status.complaint_id = tbl_complaints.complaint_id
                  INNER JOIN tbl_users ON tbl_users.id = tbl_complaint_status.login_id
                  WHERE tbl_complaint_status.complaint_id = '$complaint_id' ORDER BY update_datetime DESC LIMIT 10;";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintStatus($complaint_id,$cmode)
    {
        $query = "SELECT *, (SELECT user_name FROM `tbl_users` WHERE id IN (tbl_complaint_status.`login_id`)) AS activity_performer
                  FROM tbl_complaint_status WHERE complaint_id = '$complaint_id' AND complaint_mode = '$cmode' ORDER BY update_datetime DESC LIMIT 0,10;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetScheduler($id)
    {
        $query = "SELECT * FROM vw_scheduler;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function SaveScheduler($mon, $tue, $wed, $thu, $fri, $sat, $sun)
    {
        $query = "REPLACE INTO tbl_scheduler (id,Mon,Tue,Wed,Thu,Fri,Sat,Sun) VALUES (1,'$mon','$tue','$wed','$thu','$fri','$sat','$sun')";
        $query = str_replace('---','-',$query);

        $this->mysqli_lib->insert($query);
        return "success";
    }

    /*function GetEndDate($type_id)
    {
        $query = "SELECT tat FROM tbl_complaint_type WHERE id = '$type_id' AND isactive = 1;";
        $data = $this->mysqli_lib->fetch_all($query);
        $tat = $data[0]['tat'];
        $end_date = date('Y-m-d' ,strtotime("+$tat hours"));
        return $this->EndDate($end_date);
    }*/

    function GetEndDate($type_id)
    {
      $query  = "SELECT tat FROM tbl_complaint_type WHERE id = '$type_id' AND isactive = 1";
      $data   = $this->mysqli_lib->fetch_all($query);
      $tat    = $data[0]['tat'];
      //$tat = $tat - 1;	//For current day
      $tat      = $tat;				//For next day
      return $end_date = date('Y-m-d', strtotime("+$tat weekdays"));
      //return $this->EndDate($end_date);
    }

    function EndDate($end_date)
    {
      $start_date = DATE('Y-m-d');

      $query = "SELECT week_day FROM tbl_calendar_weekends";
      $data  = $this->mysqli_lib->fetch_all($query);

      //$query = "SELECT * FROM `tbl_calendar_holidays` WHERE '$end_date' BETWEEN from_date AND to_date";
      $query = "SELECT * FROM tbl_calendar_holidays WHERE DATE(from_date) BETWEEN '$start_date' AND '$end_date'";
      $responses = $this->mysqli_lib->fetch_all($query);

      $date1 = strtotime($responses[0]['from_date']);
      $date2 = strtotime($responses[0]['to_date']);
      $diff  = $date2 - $date1;

      $diff = round($diff / (60 * 60 * 24));

      if($diff != 0)
      {
      	$my_end_date = date('Y-m-d', date(strtotime("+$diff day", strtotime($end_date))));
      }
      else
      {
      	$my_end_date = date('Y-m-d', date(strtotime("+1 day", strtotime($end_date))));
      }

      if (!empty($responses)) 
      {
        foreach ($responses as $response) 
        {
          $end_date = date('Y-m-d', date(strtotime("+1 day", strtotime($response['to_date']))));
          $Day = date("D", strtotime($end_date));

          foreach ($data as $row) 
          {
          	//print_r($data); die;
            if (strtolower($Day) == $row['week_day'])
            {
              if (strtolower($Day) == 'sat') 
              {
                $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
                return $this->EndDate($end_date);
              } 
              elseif (strtolower($Day) == 'sun') 
              {
                $end_date = date('Y-m-d', date(strtotime("+24 hours", strtotime($end_date))));
                return $this->EndDate($end_date);
              }
            }
            else 
            {
            	return $my_end_date;
            }
          }
        }
      } 
      else 
      {
        $Day = date("D", strtotime($end_date));

        foreach ($data as $row) 
        {
        	//print_r($data);
          if (strtolower($Day) == $row['week_day']) 
          {
            if (strtolower($Day) == 'sat') 
            {
              $end_date = date('Y-m-d', date(strtotime("+48 hours", strtotime($end_date))));
              return $this->EndDate($end_date);
            } 
            elseif (strtolower($Day) == 'sun') 
            {
              $end_date = date('Y-m-d', date(strtotime("+24 hours", strtotime($end_date))));
              return $this->EndDate($end_date);
            }
          }
          else
          {
            return $end_date;
          }
        }
      }
    }

    function EndDateOld($TAT) 
    {
      $query = "SELECT * FROM tbl_scheduler;";
      $Calender = $this->mysqli_lib->fetch_all($query);

      $DateTime = date("Y-m-d G:i:s");
      $Day = date('D',strtotime($DateTime . "+$TAT days"));
      $Time = date('G:i:s',strtotime($DateTime . "+$TAT days"));

      $Calender11 = array("Mon"=>"09:00-18:00",
          "Tue"=>"09:00-18:00",
          "Wed"=>"09:00-18:00",
          "Thu"=>"09:00-18:00",
          "Fri"=>"09:00-18:00",
          "Sat"=>"-",
          "Sun"=>"-");

      $NextDay = 1;
      $Add = 0;

      $CTime = $Calender[0][$Day];
      #return "($CTime)";

      while(1)
      {
        if ($CTime == "-") { $Day = date('D',strtotime($DateTime . "+$NextDay days")); $CTime = $Calender[0][$Day]; if($Add) {$NextDay++ ;} }
        else{ $Add = 1; break; }
      }

      $Add = 0;
      $CTime = $Calender[0][$Day];

      while(1)
      {
          list ($On,$Off)=split('-', $CTime);
          $On = $On.":00";
          $Off = $Off.":00";

          //print "$Off < $Time\n";
          if ($Off > $Time)
          {
              if ($Add) {$NextDay --; }
              $EndTime = date('Y-m-d G:i:s',strtotime($DateTime . "+$NextDay days"));
              //print $EndTime."\n" ;
              return $EndTime;
              //break;
          }
          else 
          { 
              $DHour = $Time - $Off; $Day = date('D',strtotime($DateTime . "+$NextDay days")); $CTime = $Calender[0][$Day]; $NextDay++ ;
          } 
          $Add = 1;
      }
    }

    function ReadNotification($complaint_id, $notification_type, $user_type)
    {
        if($user_type == '1')
        {
            $col = " admin_is_read = '1'";
        }
        elseif($user_type == '3')
        {
            $col = " user_is_read = '1'";
        }

        $query = "UPDATE tbl_notifications SET $col WHERE complaint_eform_id = '$complaint_id' AND type = '$notification_type'";
        $this->mysqli_lib->update($query);
        return "success";
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

    function GetComplaintForAPI($cnic)
    {
        $query = "SELECT * FROM `vw_get_complaints` WHERE cnic = '".$cnic."' ";
        $response = $this->mysqli_lib->fetch_all($query);
        return $response;
    }

    // function test()
    // {
    //     return "hello";
    // }

    function GetComplaintTypeByGroup($id)
    {
        $query = "SELECT * FROM tbl_complaint_type WHERE group_id = '$id' AND isactive = 1;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintTypeDetails($id)
    {
        $query = "SELECT * FROM tbl_complaint_type WHERE id = '$id' AND isactive = 1;";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetPriorityLabel($id)
    {
        $query = "SELECT * FROM tbl_priority WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintpreStatusById($table,$cmode,$complaint_id)
    {
        $query = "SELECT * FROM $table WHERE complaint_id = '$complaint_id' and type = '$cmode'";
        return $this->mysqli_lib->query_execute($query);
    }

    // function SearchComplaint($cnic,$cmp_num,$comp_type,$cmp_status,$FromDate,$ToDate,$agent){
      
    //  $query ="SELECT cl.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname 
    //         AS ComplaintType, sr.fullname AS Source,  CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM vw_get_complaint cl 
    //         LEFT JOIN tbl_users ur ON ur.id = cl.agent_id 
    //         LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id
    //         LEFT JOIN tbl_source sr ON sr.id = cl.channel 
    //         LEFT JOIN tbl_users urs ON urs.id = cl.user_id 
    //         LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart
    //         WHERE 1=1 AND  cl.complaint_num = '$cmp_num' OR cl.status_id = '$cmp_status' OR DATE(cl.create_date)  BETWEEN '$FromDate' AND '$ToDate' OR cl.cnic ='$cnic' OR cl.type = '$comp_type' OR cl.agent_id = '$agent'";
           
    //         //return $query;
    //         return $this->mysqli_lib->fetch_all($query);
    // }

    function SearchComplaint($search_detail)
    {
        $query ="SELECT cl.*, CONCAT(ur.first_name, ' ' ,ur.last_name) AS ReleasedBy, ct.fullname AS ComplaintType, sr.fullname AS Source,  CONCAT(urs.first_name, ' ' ,urs.last_name) AS AssignedTo , grp.primary_name AS depart  FROM vw_get_complaint cl 
        LEFT JOIN tbl_users ur ON ur.id = cl.agent_id 
        LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id
        LEFT JOIN tbl_source sr ON sr.id = cl.channel 
        LEFT JOIN tbl_users urs ON urs.id = cl.user_id 
        LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart $search_detail";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetCustomerData($PolicyNumber,$type,$certificate_no)
    {
        $whereclause = "";

        if($type == 1)
        {
            $whereclause .= " where Policy_Number like  '%$PolicyNumber%' LIMIT 1" ;
        }
        else
        {
            $whereclause .= " where Policy_Number like '%$PolicyNumber%' AND Certificate_Number like  '%$certificate_no%' LIMIT 1" ;
        }

        $query = "SELECT * FROM tbl_policy_master_data $whereclause";

        //return $query;
        return $this->mysqli_lib->query_execute($query);
    }

    function check_num($mobile)
    {
        $msisdn = trim($mobile);    
        $initial = substr($msisdn, 0, 2);    
        if($initial == '03' || $initial == '92'){        
            if($initial == '03') {            
                $msisdn = '92'.substr($msisdn, 1, strlen($msisdn));       
            }    
        }
       return $msisdn; 
    }

    function GetDepart($group_id)
    {
         $query = "SELECT primary_name FROM tbl_groups WHERE id = '$group_id'";
          return $this->mysqli_lib->query_execute($query);
    }

    function GetUsersById($id)
    {
        $query = "SELECT * FROM tbl_users WHERE id = '$id'";
        return $this->mysqli_lib->query_execute($query);
    }

    function  GetComplaintInProcess()
    { 
        $query = " SELECT * FROM vw_get_complaint WHERE status_id IN(2,1)";
        $response = $this->mysqli_lib->fetch_all($query);
        return $response;
    }

    function GetCustomersData($msisdn)
    {
        $query = "SELECT * FROM tbl_policy_master_data WHERE (Phone_Number = '$msisdn' OR Mobile_Number = '$msisdn' OR Fax_Number = '$msisdn') limit 1";
        return $this->mysqli_lib->query_execute($query);
    }

    function GetCityName($id)
    {
        $query = "SELECT fullname FROM `tbl_region_city` WHERE id = '$id'";
        $res = $this->mysqli_lib->query_execute($query);

        return $res['fullname'];
    }

    function GetHODDetails($group_id)
    {
        $query ="SELECT * FROM tbl_users WHERE group_id = '$group_id' AND user_type ='2'";
        $res = $this->mysqli_lib->query_execute($query);
        return $res;
    }
   
    function GetCustomersDataPolicy($policy)
    {
        $query = "SELECT * FROM tbl_policy_master_data where Policy_Number like '%$policy%' limit 1";
        return $this->mysqli_lib->query_execute($query);
    }

    function setemail($toemail,$ccemail,$subject,$content)
    {
        $query ="Insert INTO tbl_daily_email (toemail,ccemail,subject,content,datetime,is_active) VALUES ('$toemail','$ccemail','$subject','$content',NOW(),'1')";

        $res = $this->mysqli_lib->insert($query);
         
        if($res)
        {
            return "success";
        }
        else
        {
            return "fail";
        }
    }

    function GetEmailInProcess()
    {
        $query = "SELECT * FROM tbl_daily_email WHERE is_active = '1'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function UpdateEmail($id)
    {
        $query = "UPDATE tbl_daily_email SET is_active ='0' where id ='$id'";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetForums()
    {
        $query = "SELECT * FROM tbl_forum_list ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }
}
