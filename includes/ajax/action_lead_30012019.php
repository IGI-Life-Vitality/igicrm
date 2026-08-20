<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'lead.php');
include(CLASSES_PATH.DS.'user.php');
include(CLASSES_PATH.DS.'product.php');
require_once(MAILER_PATH.DS.'PHPMailer/PHPMailerAutoload.php');
//require_once('/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php');

$objLead = new Lead();
$objUser = new User();
$objProd = new Product();
$login_id = $_SESSION['login_id'];
$current_datetime = DATE('Y-m-d');

if(isset($_POST)) 
{
    $id                  = isset($_POST['id'])?$_POST['id']: 0;
    $city                = isset($_POST['city'])?$_POST['city']: '';
    
    if(isset($_POST['action'])) 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_lead")
        {
            $Salutation      = isset($_POST['ddlSalutation'])?$_POST['ddlSalutation']: 0;
            $DepartmentName  = isset($_POST['ddlDepartmentName'])?$_POST['ddlDepartmentName']: 0;
            $FName           = isset($_POST['txtFName'])?$_POST['txtFName']: '';
            $MName           = isset($_POST['txtMName'])?$_POST['txtMName']: '';
            $LName           = isset($_POST['txtLName'])?$_POST['txtLName']: '';
            $CNIC            = isset($_POST['txtCNIC'])?$_POST['txtCNIC']: '';
            $Gender          = isset($_POST['ddlGender'])?$_POST['ddlGender']: '';
            $Mobile          = isset($_POST['txtMobile'])?$_POST['txtMobile']: '';
            $BackNumber      = isset($_POST['txtBackNumber'])?$_POST['txtBackNumber']: '';
            $Email           = isset($_POST['txtEmail'])?$_POST['txtEmail']: '';
            $ddlCity         = isset($_POST['ddlCity'])?$_POST['ddlCity']: '';
            $Area            = isset($_POST['ddlArea'])?$_POST['ddlArea']: '';
            $Address         = isset($_POST['txtAddress'])?$_POST['txtAddress']: '';
            $ProductName     = isset($_POST['ddlProductName'])?$_POST['ddlProductName']: '';
            $CallTime        = isset($_POST['txtPreferableCallTime'])?$_POST['txtPreferableCallTime']: '';
            $Source          = isset($_POST['ddlSource'])?$_POST['ddlSource']: '';
            $LaedsDesc       = isset($_POST['txtLaedsDesc'])?$_POST['txtLaedsDesc']: '';
            $counter         = isset($_POST['counter'])?$_POST['counter']: '';
            $CallTime        = date('Y-m-d h:i:s',strtotime($CallTime));
           
            $response = $objLead->SaveLeads($Salutation,$DepartmentName,$FName,$MName,$LName,$CNIC,$Gender,$Mobile,$BackNumber,$Email,$ddlCity,$Area,$Address,$ProductName,$CallTime,$Source,$LaedsDesc,$login_id);

            //print_r($response);die;
             
            $result      = explode('|', $response);
            $res         = $result[0];     // success/fail
            $leadid      = $result[1];     // lead id     i.e. 1,2,3,4,5...
            $lead_number = $result[2];     // lead number i.e. LM181105001
            $send_mail   = $result[3];     // Regional Manager Email Address's ID only
            $rm_mail     = $result[4];     // Regional Manager Email Address's Email

            // Send SMS to customer when new lead created
            $msg    = "Thank you for contacting IGI Life Insurance. Your ticket number is $lead_number. Kindly use this for further queries. Our representative will get in touch with you shortly.\\nFor any further assistance, you can call 021 111 111 711";
            $msg    = str_replace(' ', '%20', $msg);
            $mobile = $objLead->check_num($Mobile);
            $url    = "http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile";
            $response = file_get_contents($url);

            for($count=1; $count<=$counter; $count++)
            {
                $test_type      = isset($_POST['ddlTestType'.$count])?$_POST['ddlTestType'.$count]: '';
                $test_status    = isset($_POST['ddlLeadTestStatus'.$count])?$_POST['ddlLeadTestStatus'.$count]: '';
                $leads_results  = isset($_POST['txtLeadsResults'.$count])?$_POST['txtLeadsResults'.$count]: '';
                $leads_rmrk     = isset($_POST['txtLeadsRmrk'.$count])?$_POST['txtLeadsRmrk'.$count]: '';

                $objLead->SaveLeadActivity_Test($leadid,$login_id,$test_type,$test_status,$leads_results,$leads_rmrk);
            }

            // Send email to regional manager when new lead created
            if($res == "success")
            {
                if($Email == '')
                {
                    $Email = "kamran.jabbar@m3tech.com.pk";
                }

                /*
                    ------------------ LIST -> HEAD OF SALES ------------------
                    Product Name            ID (DB)      Email Address
                    Vitality                3            akif.malik@IGI.COM.PK
                    Takaful                 2            bakht.jamal@IGI.COM.PK
                    Conventional/Takaful/PA 1/2/4        mohsin.abbas@IGI.COM.PK
                    Corporate Solution GMD  11           wasif.ali@IGI.COM.PK
                */

                //print_r($ProductName. "|" .$rm_mail);die;

                if($ProductName == 1)
                {
                    $cc_emails = "mohsin.abbas@IGI.COM.PK,".$rm_mail;
                }
                else if($ProductName == 2)
                {
                    $cc_emails = "bakht.jamal@IGI.COM.PK,mohsin.abbas@IGI.COM.PK,".$rm_mail;
                }
                else if($ProductName == 3)
                {
                    $cc_emails = "akif.malik@IGI.COM.PK,".$rm_mail;
                }
                else if($ProductName == 4)
                {
                    $cc_emails = "mohsin.abbas@IGI.COM.PK,".$rm_mail;
                }
                else if($ProductName == 11)
                {
                    $cc_emails = "wasif.ali@IGI.COM.PK,".$rm_mail;
                }

                //print_r($cc_emails);die;

                $subject = "Lead Acknowladgement by IGI Life";

                $sb .= "Thank you for contacting IGI Life Insurance. Your ticket number is $lead_number. Kindly use this for further queries. Our representative will get in touch with you shortly.<br><br> For any further assistance, you can call 021 111 111 711 <br />";

                $sb .="<br /> Regards, <br />";
                $sb .="IGI Life";

                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                 // Set mailer to use SMTP
                    $mail->Host = $email_host;         // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;            // Enable SMTP authentication
                    $mail->Username = $email_username; // SMTP username
                    $mail->Password = $email_password; // SMTP password
                    $mail->SMTPSecure = 'ssl';         // Enable TLS encryption, `ssl` also accepted
                    $mail->Port      = $port;          // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    $to_email    = $Email;
                    $subject     = "Lead Acknowladgement by IGI Life";

                    $mail->setFrom($email_username);

                    // Add Recipient/Recipients (only customer)
                    $mail->addAddress($to_email);

                    // To send email on multiple CC
                    $cc_emails = explode(",", $cc_emails);
                    foreach($cc_emails as $cc_email)
                    {
                        $mail->addCC($cc_email);
                    }

                    $mail->isHTML(true); // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    if($mail->send())
                    {
                        `echo "email send successfully|$current_datetime|$to_email" >> /tmp/email_lead.log`;
                    }
                    else
                    {
                        `echo "email send failed|$current_datetime|$to_email" >> /tmp/email_lead.log`;
                    }
                }
                catch (phpmailerException $e) 
                {
                    $e->errorMessage();
                }
                catch (Exception $e) 
                {
                    $e->getMessage();
                }

                $sb = "";
            }
            
            echo $res;
        }
        else if($action == "update_lead")
        {
            $Salutation           = isset($_POST['ddlSalutation'])?$_POST['ddlSalutation']: 0;
            $DepartmentName       = isset($_POST['ddlDepartmentName'])?$_POST['ddlDepartmentName']: 0;
            $FName                = isset($_POST['txtFName'])?$_POST['txtFName']: '';
            $MName                = isset($_POST['txtMName'])?$_POST['txtMName']: '';
            $LName                = isset($_POST['txtLName'])?$_POST['txtLName']: '';
            $CNIC                 = isset($_POST['txtCNIC'])?$_POST['txtCNIC']: '';
            $Gender               = isset($_POST['ddlGender'])?$_POST['ddlGender']: '';
            $Mobile               = isset($_POST['txtMobile'])?$_POST['txtMobile']: '';
            $BackNumber           = isset($_POST['txtBackNumber'])?$_POST['txtBackNumber']: '';
            $Email                = isset($_POST['txtEmail'])?$_POST['txtEmail']: '';
            $ddlCity              = isset($_POST['ddlCity'])?$_POST['ddlCity']: '';
            $Area                 = isset($_POST['ddlArea'])?$_POST['ddlArea']: '';
            $Address              = isset($_POST['txtAddress'])?$_POST['txtAddress']: '';
            
            $ProductName          = isset($_POST['ddlProductName'])?$_POST['ddlProductName']: '';
            $ProductNameList      = implode(',', $ProductName);

            $CallTime             = isset($_POST['txtPreferableCallTime'])?$_POST['txtPreferableCallTime']: '';
            $Source               = isset($_POST['ddlSource'])?$_POST['ddlSource']: '';
            $LaedsDesc            = isset($_POST['txtLaedsDesc'])?$_POST['txtLaedsDesc']: '';
           
            $response = $objLead->UpdateLeads($id,$Salutation,$DepartmentName,$FName,$MName,$LName,$CNIC,$Gender,$Mobile,$BackNumber,$Email,$ddlCity,$Area,$Address,$ProductNameList,$CallTime,$Source,$LaedsDesc,$login_id);

           echo $response;
        }
        else if($action == "leads_mapping_save")
        {
            $City                       = isset($_POST['city'])?$_POST['city']: '';

            $Region                     = isset($_POST['region'])?$_POST['region']: '';

            $Area                       = isset($_POST['regional_area'])?$_POST['regional_area']: '';
            $AreaList                   = implode(',', $Area);

            $RegionManager              = isset($_POST['regional_manager'])?$_POST['regional_manager']: '';
            $ProductType                = isset($_POST['product_type'])?$_POST['product_type']: '';

            $response = $objLead->SaveLeadsMapping($Region,$City,$AreaList,$RegionManager,$ProductType);
            echo $response;
        }
        else if($action == "leads_mapping_update")
        {
            $City          = isset($_POST['region'])?$_POST['region']: '';
            $Area          = isset($_POST['regional_area'])?$_POST['regional_area']: '';
            $AreaList      = implode(',', $Area);
            $RegionManager = isset($_POST['regional_manager'])?$_POST['regional_manager']: '';
            $ProductType   = isset($_POST['product_type'])?$_POST['product_type']: '';

            $response = $objLead->UpdateLeadsMapping($id,$City,$AreaList,$RegionManager,$ProductType);
            echo $response;
        }
        else if($action == "update_asignee")
        {
            $id          = isset($_POST['id'])?$_POST['id']: '';
            $user        = isset($_POST['user'])?$_POST['user']: '';

            $response = $objLead->UpdateLeadsAssignee($id,$user);
            echo $response;
        }
        else if($action == "select_source")
        {
            $pro    = isset($_POST['pro'])?$_POST['pro']: '';
            $output = "";

            if($pro == 2)
            {      
                $output .= '<option value="" selected="selected" disabled>Select Source</option>';
                $source = $objProd->GetSource(0);
                foreach($source as $sources)
                {
                    if($sources['id']== 9 )continue;
                    else
                        $output.='<option value="'.$sources["id"].'">'.$sources["fullname"].'</option>';
                } 
            }
            else
            {
                $output .= '<option value="" selected="selected" disabled>Select Source</option>';
                $source = $objProd->GetSource(0);
                foreach($source as $sources)
                {    
                    $output.='<option value="'.$sources["id"].'">'.$sources["fullname"].'</option>';
                }
            }

            echo $output;
        }
        else if($action == "select_status")
        {
            $cal_result = isset($_POST['cal_result'])?$_POST['cal_result']: '';
            $res        = isset($_POST['res'])?$_POST['res']: '';
            $output     = "";

            if($cal_result == 1 && $res != 'Not Interested' )
            {      
                $output .= '<option value="" selected="selected" disabled>Select Status</option>';
                $status = $objLead->GetLeadStatus();

                foreach($status as $stat)
                {
                    if($stat['id']== 5 )continue;
                    else
                        //$output.="<option value='".$stat['id']."'".">".$stat['fullname']."</option>";
                        $output.="<option value='".$stat['id']."'".($stat['fullname'] == $res ? 'selected = selected': '').">".$stat['fullname']."</option>";
                } 
            }
            else
            {
                $output .= '<option value="" selected="selected" disabled>Select Source</option>';
                $status = $objLead->GetLeadStatus();
                foreach($status as $stat)
                {    
                    $output.="<option value='".$stat['id']."'".($stat['fullname'] == $res ? 'selected = selected': '').">".$stat['fullname']."</option>";
                }
            }
            
            echo $output;
        }
        elseif($action == 'select_lead_city_area')
        {
            $data   = $objLead->GetCityAreas($city);
            $Option = "<option selected='selected' value='' disabled='disabled'> -- Select -- </option>";

            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'>" . $row["area"] . "</option>";
            }

            echo $Option;
        }
        elseif($action == 'select_lead_city_area_multiselect')
        {
            $data   = $objLead->GetCityAreas($city);
            $Option = '';

            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'>" . $row["area"] . "</option>";
            }

            echo $Option;
        }
        elseif($action == 'save_assignee')
        {
            $lead_id             = isset($_POST['id'])?$_POST['id']: 0;
            $assignedTo          = isset($_POST['assignedTo'])?$_POST['assignedTo']: 0;
            $assignee            = isset($_POST['assignee'])?$_POST['assignee']: 0;
            $notes               = isset($_POST['notes'])?$_POST['notes']: '';

            echo $objLead->SaveLeadAssignee($lead_id,$assignee,$assignedTo,$notes);
        }
        else if($action == "leads_user_save")
        {
            $id                       = isset($_POST['id'])?$_POST['id']: '';
            $prod                     = isset($_POST['prod'])?$_POST['prod']: '';
            $prod                     = implode(',', $prod);
            $user_type                = isset($_POST['user_type'])?$_POST['user_type']: '';
            $users                    = isset($_POST['users'])?$_POST['users']: '';

            $response = $objLead->UpdateLeadsUser($id,$prod,$user_type,$users);
            echo $response;
        }
        else if($action == "leads_user_update")
        {
            $id                       = isset($_POST['id'])?$_POST['id']: '';
            $prod                     = isset($_POST['prod'])?$_POST['prod']: '';
            $prod                     = implode(',', $prod);
            $user_type                = isset($_POST['user_type'])?$_POST['user_type']: '';
            $users                    = isset($_POST['users'])?$_POST['users']: '';

            $response = $objLead->UpdateLeadsUser($id,$prod,$user_type,$users);
            echo $response;
        }
        elseif($action == 'update_lead_activty')
        {
            $lead_id           = isset($_POST['id'])?$_POST['id']: 0;
            $login_id          = isset($_POST['login_id'])?$_POST['login_id']: '';
            $call_result       = isset($_POST['ddlCallResult'])?$_POST['ddlCallResult']: '';
            $meeting_time      = isset($_POST['ddlMeetingTime'])?$_POST['ddlMeetingTime']: '';
            $lead_status       = isset($_POST['ddlLeadStatus'])?$_POST['ddlLeadStatus']: '';
            $previous_state    = isset($_POST['previous_state'])?$_POST['previous_state']: '';
            $lead_remarks      = isset($_POST['txtLeadRemarks'])?$_POST['txtLeadRemarks']: '';
            $counter           = isset($_POST['counter'])?$_POST['counter']: '';

            $res = $objLead->SaveLeadActivity($lead_id,$login_id,$call_result,$meeting_time,$lead_status,$previous_state,$lead_remarks);
            echo $res;
            $hod_detail = $objLead->GetUsersById($login_id);
            $send_mail = $hod_detail['email'];

            if($send_mail == '')            
            {
                $send_mail = "haroon.saeed@m3tech.com.pk";
            }
             
            $leaddetail = $objLead->GetLeadDetail($lead_id);
            $mobile_num = $leaddetail['mobile_no'];
            $lead_num   = $leaddetail['lead_num'];

            if($res == "success" && ($lead_status == 4 || $lead_status == 5 || $lead_status == 6) )
            {
                $msg = "Thank you for meeting the IGI Life Insurance representative. Kindly rate the service quality of your meeting by replying:\\n1. Good\\n2. Average\\n3. Poor\\n For any further queries or feedback, kindly contact us on 021 111 111 711";
                $msg = str_replace(' ', '%20', $msg);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $res = file_get_contents($url);
            }

            if($res == "success" && $call_result == 1 && $lead_status == 3)
            {
                /*$leaddetail = $objLead->GetLeadDetail($lead_id);
                $mobile_num = $leaddetail['mobile_no'];
                $lead_num   = $leaddetail['lead_num'];*/
                $cc_emails = "";
                $subject = "Meeting scheduled with prospective policy holder";

                $msg = "Thank you for your time. As discussed, IGI Life Insurance representative will contact you  at $meeting_time. Your ticket reference number is $lead_num. For any further queries, kindly contact us on 021 111 111 711";
                $msg = str_replace(' ', '%20', $msg);
                $mobile_num = $objLead->check_num($mobile_num);
                $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile_num";
                $response = file_get_contents($url);

                $sb .="Hi,<br /> <br />";
                $sb .= "Please be informed that NEW Meeting has been scheduled as per below details:  <br /> <br />";

                $sb .="  <table id='customers22' style='font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>

                        <thead>
                            <tr>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Title</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Date & Time</th>
                            </tr>
                        </thead>
                        <tbody id='divPayments'>";


                $sb .="<tr>";
                $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>Meeting Invitation IGI CRM</td>";
                $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$meeting_time."</td>";
                
                $sb .="</tr>";

                $sb .="<br /> Regards, <br />";
                $sb .="IGI CRM";
                $setmail = $objLead->setemail($send_mail,$cc_emails,$subject,$sb);
               
                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    $mail->Host = $email_host;                               // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    $mail->Username = $email_username;              // SMTP username
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = $send_mail;
                    $to_email = $send_mail;
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "Meeting Invitation IGI CRM";

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($send_mail);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    if($mail->send()) 
                    {
                        `echo "email send successfully|$current_datetime|$to_email" >> /tmp/email_complaint.log`;
                    }
                    else
                    {
                        `echo "email send failed|$current_datetime|$to_email" >> /tmp/email_complaint.log`;
                    }
                }
                catch (phpmailerException $e) 
                {
                    $e->errorMessage();
                } catch (Exception $e) {
                    $e->getMessage();
                }

                $sb = "";
            }

            for($count=1; $count <= $counter; $count++)
            {
                $test_type      = isset($_POST['ddlTestType'.$count])?$_POST['ddlTestType'.$count]: '';
                $test_status    = isset($_POST['ddlLeadTestStatus'.$count])?$_POST['ddlLeadTestStatus'.$count]: '';
                $leads_results  = isset($_POST['txtLeadsResults'.$count])?$_POST['txtLeadsResults'.$count]: '';
                $leads_rmrk     = isset($_POST['txtLeadsRmrk'.$count])?$_POST['txtLeadsRmrk'.$count]: '';

                echo $objLead->SaveLeadActivity_Test($lead_id,$login_id,$test_type,$test_status,$leads_results,$leads_rmrk);
            }
        }
        elseif($action == 'get_lead_user')
        {
            $user_type  = isset($_POST['type'])?$_POST['type']: 0;
            $user_id    = isset($_POST['user_id'])?$_POST['user_id']: 0;
            $group_id   = '3';

            $output = '';
            $output .= '<option value="" selected="selected" disabled="disabled"> Select User </option>';
            $data = $objLead->get_sales_users($user_type,$group_id);

            foreach($data as $manager)
            {
                $output .= "<option value ='".$manager['id']."'". ($manager['id'] == $user_id ? 'selected = selected': '').">".$manager['first_name']." ".$manager['last_name']."</option>";
            }

            echo $output;
        }
        elseif($action == "reassign_lead")
        {
            $lead_id    = isset($_POST['id'])?$_POST['id']: '0';
            $data       = $objLead->GetLeadDetail($lead_id);
            $product    = $data['product'];
            $city       = $data['city'];            
            $area       = $data['area'];
            $mapping    = $objLead->GetLeadMappingDetail($city,$area,$product);
            $user       = $mapping['lead_regional_manager'];
            $update     = $objLead->Reasign_user($lead_id,$user);

            echo $update;
        }
        elseif($action == 'search_lead')
        {
            $lead_num      = isset($_POST['lead_num'])?$_POST['lead_num']: '';
            $cnic          = isset($_POST['cnic'])?$_POST['cnic']: '';
            $product       = isset($_POST['product'])?$_POST['product']: '';
            $call_back     = isset($_POST['call_back'])?$_POST['call_back']: '';
            $lead_status   = isset($_POST['lead_status'])?$_POST['lead_status']: '';
            $city          = isset($_POST['city'])?$_POST['city']: '';
            $FromDate      = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate        = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            
            $search_detail = "where 1=1 ";

            if($lead_num != ""){
               $search_detail.= "AND  l.lead_num = '$lead_num' ";
            }
            if($cnic != ""){
               $search_detail.= "AND  l.cnic = '$cnic' ";
            }
            if($product != ""){
               $search_detail.= "AND  l.product  = '$product' ";
            }
            if($call_back != ""){
               $search_detail.= "AND  l.mobile_no = '$call_back' ";
            }
            if($lead_status != ""){
               $search_detail.= "AND  l.lead_status_id = '$lead_status' ";
            }
            if($city != ""){
               $search_detail.= "AND  l.city  = '$city' ";
            }
            if($FromDate != "" && $ToDate != ""){
               $search_detail.= "AND  DATE(l.lead_create_date)  BETWEEN '$FromDate' AND '$ToDate'";
            }
            // echo $search_detail;
            // exit();

            $data = $objLead->SearchLead($search_detail);
            
            $output ='';
            $output .='<table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Leads ID</th>
                                    <th>Leads Status</th>
                                    <th>Leads Name</th>
                                    <th>Intersted Products</th>
                                    <th>Call Back</th>
                                    <th>Call Time</th>
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Lead Created By</th>
                                    <th>Lead Created</th>
                                </tr>
                            </thead>
                            <tbody>';

            foreach($data as $row)
            {
                $lead_end_datetime = $row["lead_exceded_datetime"];
                $current_datetime  = date('Y-m-d H:i:s');
                $lead_status_id = $row['lead_status_id'];

                $deff = $objLead->LeadTime($current_datetime,$lead_end_datetime);

                if($deff < 0 && ($lead_status_id == 1 || $lead_status_id == 2))
                { 
                    $lead_status_id = "Not Mutured";
                    $btnType = "btn-danger full-width";
                }

                if($lead_status_id == 1)
                {
                  $lead_status_id = "Initiated";
                  $btnType = "btn-primary full-width";
                }
                elseif($lead_status_id == 2)
                {
                  $lead_status_id = "In Progress";
                  $btnType = "btn-info full-width";
                }
                elseif($lead_status_id == 3)
                {
                  $lead_status_id = "Follow-up";
                  $btnType = "btn-warning full-width";
                }
                elseif($lead_status_id == 4)
                {
                  $lead_status_id = "Bought";
                  $btnType = "btn-success full-width";
                }
                elseif($lead_status_id == 5)
                {
                  $lead_status_id = "Not Intersted";
                  $btnType = "btn-danger full-width";
                }
                elseif($lead_status_id == 6)
                {
                  $lead_status_id = "General Query";
                  $btnType = "btn-default full-width";
                }

                $output .='<tr>
                            <td>
                                <a href="leads_details.php?id='.$row['lead_id'].'" title="Click here to see Details">'.$row["lead_num"].'</a>
                            </td>';
                $output .='<td><span class="btn btn-xs '.$btnType.'">'.$lead_status_id.'</span></td>';
                $output .='<td>'.$row["fname"] . " " . $row["lname"].'</td>';
                
                $products = $row["product"];
                $output .='<td>';
                $products = explode(",", $products);
                foreach($products as $product)
                {
                  $product = $objLead->GetProducts($product);
                  $product = ucfirst($product[0]['fullname']);
                  $output .='<span style="padding:3px 3px; background: #006BB1; color:#FFF; border-radius:3px; text-align:center; width: 100% !important; float:left;">' . $product . '</span>';
                }
                $output .='</td>';

                $output .='<td>'.$row["mobile_no"].'</td>';
                $output .='<td>'.$row["call_time"].'</td>';
                $output .='<td>'.$row["city"].'</td>';
                $output .='<td>'.$row["area"].'</td>';
                $output .='<td>'.$row["assignee"].'</td>';
                $output .='<td>'.$row["assignedTo"].'</td>';
                $output .='<td>'.substr($row["lead_create_date"],0,16).'</td>';
                $output .='<td>'.substr($row["lead_exceded_datetime"],0,16).'</td>
                </tr>';
            }

            $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
        }
    }
}
?>
