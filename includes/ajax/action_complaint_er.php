<?php
require_once('../config.php');
//require_once '../../third_party/PHPMailer/PHPMailerAutoload.php';
require_once(MAILER_PATH.DS.'PHPMailer/PHPMailerAutoload.php');
include(CLASSES_PATH.DS.'complaint.php');
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$objComplaint = new Complaint();
$login_id = $_SESSION['login_id'];
$current_datetime = date('Y-m-d H:i:s');

if(isset($_POST)) 
{
    $complaint_id       = isset($_POST['complaint_id'])?$_POST['complaint_id']:'';
    $ddlDepartmentName  = isset($_POST['ddlDepartmentName'])?$_POST['ddlDepartmentName']:'';
    $type               = isset($_POST['type'])?$_POST['type']:'';
    $priority           = isset($_POST['priority'])?$_POST['priority']:'';
    $mode               = isset($_POST['mode'])?$_POST['mode']:'';
    $action             = isset($_POST['action']) ? $_POST['action'] : '';

    $comments           = isset($_POST['comments'])?$_POST['comments']:'';
    $commentsC          = isset($_POST['commentsC'])?$_POST['commentsC']:'';
    $commentsL          = isset($_POST['commentsL'])?$_POST['commentsL']:'';
    $commentsB          = isset($_POST['commentsB'])?$_POST['commentsB']:'';
    $commentsBB         = isset($_POST['commentsBB'])?$_POST['commentsBB']:'';
    $commentsV          = isset($_POST['commentsV'])?$_POST['commentsV']:'';
    
    $progress           = isset($_POST['progress'])?$_POST['progress']:'';

    $counter_display    = isset($_POST['counter_display']) ? $_POST['counter_display'] : '';
    $counter_displayC   = isset($_POST['counter_displayC']) ? $_POST['counter_displayC'] : '';
    $counter_displayL   = isset($_POST['counter_displayL']) ? $_POST['counter_displayL'] : '';
    $counter_displayB   = isset($_POST['counter_displayB']) ? $_POST['counter_displayB'] : '';
    $counter_displayBB  = isset($_POST['counter_displayBB']) ? $_POST['counter_displayBB'] : '';
    $counter_displayV   = isset($_POST['counter_displayV']) ? $_POST['counter_displayV'] : '';

    if($action == 'save_complaint')
    {
        $Id                    = isset($_POST['txtId'])?$_POST['txtId']: 0;
        $counter               = isset($_POST['txtCounter'])?$_POST['txtCounter']: '';
        $complaint_no          = isset($_POST['txtComplaintNo'])?$_POST['txtComplaintNo']: '';
        $group_id              = isset($_POST['cmp_user_group'])?$_POST['cmp_user_group']: 0;
        $userid                = isset($_POST['cmp_user'])?$_POST['cmp_user']: 0;
        $policynum             = isset($_POST['txtPolicyNumber'])?$_POST['txtPolicyNumber']: 0;
        $cnic                  = isset($_POST['txtCNIC'])?(mysql_real_escape_string($_POST['txtCNIC'])): '';
        $Tat                   = isset($_POST['txtComplaintTAT'])?$_POST['txtComplaintTAT']:'';
        $cust_name             = isset($_POST['txtCustomerName'])?(mysql_real_escape_string($_POST['txtCustomerName'])): '';
        $product_id            = isset($_POST['ddlProductName'])?$_POST['ddlProductName']: 0;
        $complaint_type        = isset($_POST['ddlComplaintType'])?$_POST['ddlComplaintType']: 0;
        $priority              = isset($_POST['priority'])?$_POST['priority']: 0;
        $source                = isset($_POST['ddlSource'])?$_POST['ddlSource']: '';

        $description           = isset($_POST['txtDescription'])?(mysql_real_escape_string($_POST['txtDescription'])): '';
        $callback_num          = isset($_POST['txtCallBack'])?$_POST['txtCallBack']: '';
        $office_addr           = isset($_POST['txtOfficeAddress'])?(mysql_real_escape_string($_POST['txtOfficeAddress'])): '';
        
        $correspondenceAddress = isset($_POST['txtCorrespondenceAddress'])?(mysql_real_escape_string($_POST['txtCorrespondenceAddress'])): '';
        $residence_num         = isset($_POST['txtHomePhone'])?$_POST['txtHomePhone']: '';
        $office_num            = isset($_POST['txtOfficePhone'])?$_POST['txtOfficePhone']: '';
        $mobile_num            = isset($_POST['txtMobile'])?$_POST['txtMobile']: '';
        $email                 = isset($_POST['txtEmail'])?(mysql_real_escape_string($_POST['txtEmail'])): '';
        $is_email              = isset($_POST['rdEmail'])?$_POST['rdEmail']: 0;
        $cust_email            = isset($_POST['txtCustomerEmail'])?$_POST['txtCustomerEmail']: '';
        $is_sms                = isset($_POST['rdSMS'])?$_POST['rdSMS']: 0;
        $response_no           = isset($_POST['txtResponseNumber'])?$_POST['txtResponseNumber']: '';
        $is_call_back          = isset($_POST['rdCallBack'])?$_POST['rdCallBack']: 0;

        $CompanyName           = isset($_POST['txtCompanyName'])?$_POST['txtCompanyName']: 0;
        $AgentBroker           = isset($_POST['txtAgentBroker'])?$_POST['txtAgentBroker']: 0;
        $HospitalNameC         = isset($_POST['ddlHospitalNameC'])?$_POST['ddlHospitalNameC']: 0;
        $ComplainerName        = isset($_POST['txtComplainerName'])?$_POST['txtComplainerName']: 0;
        $txtGroupNo            = isset($_POST['txtGroupNo'])?$_POST['txtGroupNo']: 0;
        $txtCertificate        = isset($_POST['txtCertificate'])?$_POST['txtCertificate']: 0;
        $txtMemberName         = isset($_POST['txtMemberName'])?$_POST['txtMemberName']: 0;
        $ddlReportedBy         = isset($_POST['ddlReportedBy'])?$_POST['ddlReportedBy']: 0;
        $txtLetterComplNumber  = isset($_POST['txtLetterComplNumber'])?$_POST['txtLetterComplNumber']: 0;
        $txtPremiumAmount      = isset($_POST['txtPremiumAmount'])?$_POST['txtPremiumAmount']: 0;
        $txtRefundAmount       = isset($_POST['txtRefundAmount'])?$_POST['txtRefundAmount']: 0;
        $txtAmountClaimed      = isset($_POST['txtAmountClaimed'])?$_POST['txtAmountClaimed']: 0;
        $txtAgentNameL         = isset($_POST['txtAgentNameL'])?$_POST['txtAgentNameL']: 0;
        $txtAgentCode          = isset($_POST['txtAgentCode'])?$_POST['txtAgentCode']: 0;
        $txtUnitName           = isset($_POST['txtUnitName'])?$_POST['txtUnitName']: 0;
        $txtAMName             = isset($_POST['txtAMName'])?$_POST['txtAMName']: 0;
        $ddlRegion             = isset($_POST['ddlRegion'])?$_POST['ddlRegion']: 0;
        $reported_dt           = isset($_POST['reported_dt'])?$_POST['reported_dt']: 0;
        $poccured              = isset($_POST['poccured'])?$_POST['poccured']: 0;
        $ddlPolicyStatusL      = isset($_POST['ddlPolicyStatusL'])?$_POST['ddlPolicyStatusL']: 0;
        $ddlComplaintNature    = isset($_POST['ddlComplaintNature'])?$_POST['ddlComplaintNature']: 0;
        $cityL                 = isset($_POST['cityL'])?$_POST['cityL']: 0;
        $ddlReportedByL        = isset($_POST['ddlReportedByL'])?$_POST['ddlReportedByL']: 0;
        $bank                  = isset($_POST['bank'])?$_POST['bank']:'';
        $ddlForum              = isset($_POST['ddlForum'])?$_POST['ddlForum']: 0;

        //echo $login_id ."||". $is_call_back."||".$source."||".$complaint_type;
        //exit;
    
         $response = $objComplaint->SaveComplaint($login_id,$group_id,$userid,$product_id,$complaint_type,$priority,$source,$Tat,$mode,$type,$description,$cnic,$cust_name,$callback_num,$office_addr,$correspondenceAddress,$email,$office_num,$mobile_num,$residence_num,$is_email,$cust_email,$is_sms,$response_no,$is_call_back,$policynum,$ComplainerName,$CompanyName,$AgentBroker,$HospitalNameC,$txtGroupNo,$txtCertificate,$txtMemberName,$ddlReportedBy,$txtLetterComplNumber,$txtPremiumAmount,$txtRefundAmount,$txtAmountClaimed,$txtAgentNameL,$txtAgentCode,$txtUnitName,$txtAMName,$ddlRegion,$reported_dt,$poccured,$ddlPolicyStatusL,$cityL,$ddlReportedByL,$ddlComplaintNature,$ddlDepartmentName,$bank,$ddlForum);
          
        $comp_detail = explode('|',$response);
        $comp_num = $comp_detail[1];
        $comp_id  = $comp_detail[0];

        $cmp_type        = $objComplaint->GetComplaintTypeList($complaint_type);
        $agnt            = $objComplaint->GetUsersById($cmp_type[0]['user_id']);
        $agent           = $agnt['first_name']." ".$agnt['last_name'];
        $user_mail       = $agnt['email'];
        $depart_nm       = $objComplaint->GetDepart($group_id);
        $depart          = $depart_nm['primary_name'];

        $login_user      = $objComplaint->GetUsersById($login_id);
        $users_login     = $login_user['first_name']." ".$login_user['last_name'];
        $cc_emails       = '';
        $subject         = "IGI Complaint";

        if(!empty($cmp_type))
        {
            $complaint_type = $cmp_type[0]['fullname'];
            $priority = "" ;

            if($cmp_type[0]['fullname'] == '1')
            {
                $priority = "High" ;
            }
            elseif ($cmp_type[0]['fullname'] == '2') 
            {
                $priority = "Low" ;
            }
            else
            {
                $priority = "Medium" ;
            }
        }

        $eb = "";
        $eb .="Dear $agent,<br /> <br />";
        //$eb .= "$users_login has registered Call bearing ticket no <b>$comp_num </b>assigned to $agent<br/><br/><br/>";
        $eb .= "$users_login has registered Call bearing ticket no <b>$comp_num </b>assigned to $agent<br/><br/><br/>";
        $eb .= "Department            : " . $depart."<br/><br/>";
        $eb .= "Currently Assigned to : " . $agent."<br/><br/>";
        $eb .= "Complaint Type        : " . $complaint_type."<br/><br/>";
        $eb .= "Severity Level        : " . $priority."<br/><br/>";
        $eb .= "Problem Description   : " . $desc."<br/><br/>";
        $eb .= "Sincerely,<br/><br/>";
        $eb .= "Service Desk <br/>";
        $eb .= "IGI Life";

        if($type != 'internal')
        {
            if($response > 0 && $email != '')
            {
                $sb ="Dear Customer,<br/><br/>Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:<b> $comp_num</b>, which should be used for further communication with respect to your complaint.<br /><br/>One of our representative will contact you within 24 hours during business days.  We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN: <b>021-111 111 711</b> <br /><br /><br />";
                $sb .= "Best Regards,<br /><br />";
                $sb .= "Customer Experience and Conservation Department<br/><br />";
                $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                //`echo "$sb|$email|\r\n" >> /tmp/email_complaint.log`;
                $setmail      = $objComplaint->setemail($email,$cc_emails,$subject,$sb);
                $setmailUser  = $objComplaint->setemail($user_mail,$cc_emails,$subject,$eb);
                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    $mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;

                    $mail2->addAddress($user_mail);                             // Add a recipient
                    $mail2->isHTML(true);                                        // Set email format to HTML

                    $mail2->Subject = $subject;
                    $mail2->Body    = $eb;

                    /*haroon*/

                    if($mail2->send()) {
                        `echo "email send successfully|$user_mail|$eb" >> /tmp/email_complaint.log`;
                    }
                    else{
                        `echo "email send failed|$email" >> /tmp/email_complaint.log`;
                    }
                }
                catch (phpmailerException $e) 
                {
                    //$e->errorMessage();
                }catch (Exception $e) 
                {
                   // $e->getMessage();
                }
            }
        }
        echo $response > 0 ? ("success"."|".$comp_id."|".$type."|".$comp_num): "fail";
        //echo "success|1";   
    }
    elseif($action == 'edit_complaint')
    {
        $group_id            = isset($_POST['group'])?$_POST['group']: '';
        $user_id             = isset($_POST['user'])?$_POST['user']: '';
        //echo ($complaint_id."|".$group_id."|".$user_id);

        echo $response = $objComplaint->UpdateComplaint($complaint_id,$group_id,$user_id);
    }
    elseif($action == 'get_customer_data')
    {
        $PolicyNumber        = isset($_POST['PolicyNumber'])?$_POST['PolicyNumber']: '';
        $type                = isset($_POST['type'])?$_POST['type']: '';
        $certificate_no      = isset($_POST['certificate_no'])?$_POST['certificate_no']: '';

        //echo ($PolicyNumber."|".$PolicyNumber."|".$type);
        $response = $objComplaint->GetCustomerData($PolicyNumber,$type,$certificate_no);

        if(!empty($response))
        {
            $txtCNIC = $response['CNIC'];
            $txtCustomerName = $response['Owner_Name'] ;
            $txtResponseNumber = $response['Mobile_Number'];
            $txtOfficePhone = $response['Phone_Number'];
            $txtEmail = strtolower($response['Email_Address']);
            $txtCustomerEmail = strtolower($response['Email_Address']) ;
            $txtMobile = $response['Mobile_Number'] ;
            $txtHomePhone = $response['Phone_Number']; 
            $txtOfficeAddress = $response['Address1'] ;
            $txtCorrespondenceAddress = $response['Address2'];
            $insure_name = $response['Insure_Name'];
            $txtCity = $response['City'];
            $txtAgentName = $response['Agent_Name'];
            $txtAgentCode = $response['Agent_Status'];
            $PolicyStatus = $response['Status_Policy_Description'];

            $txtCNIC = trim($txtCNIC);
            $txtCustomerName = trim($txtCustomerName);
            $txtResponseNumber = trim($txtResponseNumber);
            $txtOfficePhone = trim($txtOfficePhone);
            $txtEmail = trim($txtEmail);
            $txtCustomerEmail = trim($txtCustomerEmail);
            $txtMobile = trim($txtMobile);
            $txtHomePhone = trim($txtHomePhone);
            $txtOfficeAddress = trim($txtOfficeAddress);
            $txtCorrespondenceAddress = trim($txtCorrespondenceAddress);
            $insure_name = trim($insure_name);
            $txtCity = trim($txtCity);
            $txtAgentName = trim($txtAgentName);
            $txtAgentCode = trim($txtAgentCode);
            $PolicyStatus = trim($PolicyStatus);
        }

        $output = $txtCNIC."|".$txtCustomerName."|".$txtResponseNumber."|".$txtOfficePhone."|".$txtEmail."|".$txtCustomerEmail."|".$txtMobile."|".$txtHomePhone."|".$txtOfficeAddress."|".$txtCorrespondenceAddress."|".$insure_name."|".$txtCity."|".$txtAgentName."|".$txtAgentCode."|".$PolicyStatus;

        echo $output;
    }
    elseif($action == 'search_complaint')
    {
        $cnic                 = isset($_POST['cnic'])?$_POST['cnic']: '';
        $cmp_num              = isset($_POST['cmp_num'])?$_POST['cmp_num']: '';
        $comp_type            = isset($_POST['comp_type'])?$_POST['comp_type']: '';
        $cmp_status           = isset($_POST['cmp_status'])?$_POST['cmp_status']: '';
        $FromDate             = isset($_POST['FromDate'])?$_POST['FromDate']: '';
        $ToDate               = isset($_POST['ToDate'])?$_POST['ToDate']: '';
        $agent                = isset($_POST['agent'])?$_POST['agent']: '';

        //echo ($cnic."|".$cmp_num."|".$comp_type."|".$cmp_status."|".$FromDate."|".$ToDate);

        $search_detail = "where 1=1 ";

        if($cnic != "")
        {
           $search_detail.= "AND cl.cnic ='$cnic' ";
        }

        if($cmp_num != "")
        {
           $search_detail.= "AND cl.complaint_num = '$cmp_num' ";
        }

        if($comp_type != "")
        {
           $search_detail.= "AND cl.type = '$comp_type' ";
        }

        if($agent != "")
        {
           $search_detail.= "AND cl.user_id = '$agent' ";
        }

        if($cmp_status != "")
        {
           $search_detail.= "AND cl.status_id = '$cmp_status' ";
        }

        if($FromDate != "" && $ToDate != "")
        {
            $FromDate   =  date('Y-m-d', strtotime($FromDate));
            $ToDate     =  date('Y-m-d', strtotime($ToDate));

            $search_detail.= "AND DATE(cl.create_date)  BETWEEN '$FromDate' AND '$ToDate'";
        }

        $data = $objComplaint->SearchComplaint($search_detail);

        //$data = $objComplaint->SearchComplaint($cnic,$cmp_num,$comp_type,$cmp_status,$FromDate,$ToDate,$agent);
        $output ='';
        $output .='<table id="#data-table1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Status</th>
                            <th>Customer Name</th>
                            <th>Released By</th>
                            <th>Assigned To</th>
                            <th>Complaint Department</th>
                            <th>Complaint Type</th>
                            <th>Complaint TAT</th>
                            <th>Complaint Mode</th>
                            <th>Source</th>
                            <th>Priority</th>
                            <th>Created Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>

                    <tbody>';
                            foreach($data as $row)
                            {
                                if($row["type"] == "vatality")
                                { 
                                    $ty = "Vitality";
                                }
                                else
                                { 
                                    $ty =   ucfirst($row["type"]); 
                                }

                                if($row["user_id"] == '0')
                                {
                                    $status = "Not Assigned/Manual Assigning";
                                    $label = "danger";
                                }

                                $status = "";
                                $check_over = $objComplaint->CheckOverDue($row["end_date"]);
                                $lead_time  = $objComplaint->LeadTime($row["create_date"], $row["close_date"]) . " Day(s)";

                                if($row["status_id"] == '1')
                                {
                                    $status = "Initiated";
                                    if($check_over == 1)
                                    {
                                        $label = "danger";
                                    }
                                    else
                                        $label = "primary";
                                }
                                else if($row["status_id"] == '2')
                                {
                                    //only in progress status check for overdue
                                    if($check_over == 1)
                                    {
                                        $status = "In Progress";
                                        $label = "danger";
                                    }
                                    else
                                    {
                                        if($user_type == 4 && $row["progress"] != 0)
                                            $status = "In Progress";
                                        else
                                            $status = "In Progress";

                                        $label = "primary";
                                    }
                                }
                                else if($row["status_id"] == '4')
                                {
                                    $status = "OnHold";
                                    $label = "default";
                                }
                                else if($row["status_id"] == '3')
                                {
                                    $status = "Closed";
                                    $label = "warning";
                                }
                                else if($row["status_id"] == '5')
                                {
                                    $status = "Invalid";
                                    $label = "inverse";
                                }

                                if($row["user_id"] == 0 && $row["status_id"] == 1)
                                {
                                    $status = "Manual Assigning";
                                    $label = "danger";
                                }
                                elseif($row["user_id"] == 0 && $row["status_id"] == 5)
                                {
                                    $status = "Invalid-Manual Assigning";
                                    $label = "inverse";
                                }

                                $output .='<tr>';
                                    $output .='<td><a href="complaint_details.php?id='.$row['complaint_id'].'&cmode='.$row['type'].'" title="Click here to see Details">'.$row["complaint_num"].'</a></td>';
                                    $output .='<td><span class="btn btn-xs btn-'.$label.'">'.$status.'</span></td>';
                                    $output .='<td>'.$row["customer_name"].'</td>';
                                    $output .='<td>'.$row["ReleasedBy"].'</td>';
                                    $output .='<td>'.$row["AssignedTo"].'</td>';
                                    $output .='<td>'.$row["depart"].'</td>';
                                    $output .='<td>'.$row["ComplaintType"].'</td>';
                                    $output .='<td>'.$row["tat"].'</td>';
                                    //$output .='<td>'.ucfirst($row["type"]).'</td>';
                                    $output .='<td>'.$ty.'</td>';
                                    $output .='<td>'.$row["Source"].'</td>';
                                    $output .='<td>'.$row["priority_id"].'</td>';
                                    $output .='<td>'.$row["create_date"].'</td>';
                                    $output .='<td>'.$row["end_date"].'</td></tr>';
                            }
                    $output .='</tbody>';
                    $output .='</table>';

                    echo "success|".$output;
    }
    elseif($action == 'update_progress')
    {
        $complaint_id   = isset($_POST['id'])?$_POST['id']: '';
        $progress       = isset($_POST['progress'])?$_POST['progress']: '';
        $notes          = isset($_POST['notes'])?$_POST['notes']: '';
        $cmode          = isset($_POST['cmode'])?$_POST['cmode']: '';
        $manual         = isset($_POST['manual'])?$_POST['manual']: '';
        $invalid        = isset($_POST['invalid'])?$_POST['invalid']: '';
        $cmp_user_name  = isset($_POST['cmp_user_name'])?$_POST['cmp_user_name']: '';
        $reassign       = isset($_POST['reassign'])?$_POST['reassign']: '0';
        $user_id        = isset($_POST['user_id'])?$_POST['user_id']: '';
        $priority       = isset($_POST['priority'])?$_POST['priority']: '';
        $tat            = isset($_POST['tat'])?$_POST['tat']: '';
        $user           = isset($_POST['user'])?$_POST['user']: '0';
        $new_user       = isset($_POST['new_user'])?$_POST['new_user']: '0';
        $is_manual         = isset($_POST['is_manual'])?$_POST['is_manual']: '';
        $departmentName = isset($_POST['departmentName'])?$_POST['departmentName']: '0';
        $cmp_type       = isset($_POST['cmp_type'])?$_POST['cmp_type']: '';
        $refund_ammount = isset($_POST['refund_ammount'])?$_POST['refund_ammount']: '';

        $gp_id          = $objUser->GetUsersById($cmp_user_name);
        $cmp_user_group = $gp_id[0]['group_id'];

        if($new_user == 0)
        {
            $cmp_user_group = $departmentName;
        }
        
        if($cmode == "individual")
        {
            $res = $objComplaint->ProgressComplaintlife($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);
             
            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";

            if($cumtomer_email != "")
            {
                $sb = "";
                $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                $sb .= "Best Regards,<br /><br />";
                $sb .= "Customer Experience and Conservation Department</br><br />";
                $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);
                
                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                    /*haroon*/
                }
                catch (phpmailerException $e) 
                {
                     // $e->errorMessage();
                }
                catch (Exception $e) 
                {
                     //$e->getMessage();
                }
            }

            echo $result;
        }
        elseif($cmode == "corporate")
        {
            $res = $objComplaint->ProgressComplaintCorporate($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);

            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";

            if($cumtomer_email != "")
            {
                $sb = "";
                $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                    $sb .= "Best Regards,<br /><br />";
                    $sb .= "Customer Experience and Conservation Department</br><br />";
                    $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                    $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);

                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                    /*haroon*/
                }
                catch (phpmailerException $e) 
                {
                   // $e->errorMessage();
                }
                catch (Exception $e) 
                {
                   // $e->getMessage();
                }
            }
            echo $result;
        }
        elseif($cmode == "legal")
        {
            $res = $objComplaint->ProgressComplaintLegal($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type,$refund_ammount);

            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";

            if($cumtomer_email != "")
            {
                $sb = "";
                $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                $sb .= "Best Regards,<br /><br />";
                $sb .= "Customer Experience and Conservation Department</br><br />";
                $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);
                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                    /*haroon*/
                }
                catch (phpmailerException $e) 
                {
                   //  $e->errorMessage();
                }
                catch (Exception $e) 
                {
                   //  $e->getMessage();
                }
            }
            echo $result;
        }
        elseif($cmode == "internal")
        {
            $result = $objComplaint->ProgressComplaintInternal($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);

                /*$detail = explode('|',$res);
                $cumtomer_email = $detail[1];
                $complaint_num = $detail[2];
                $result = $detail[0];

                if($cumtomer_email != ""){
                    $sb = "";
                    $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                    $sb .= "Best Regards,<br /><br />";
                    $sb .= "Customer Experience and Conservation Department</br><br />";
                    $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                    try{
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    /*$mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                }
                catch (phpmailerException $e) 
                {
                    echo $e->errorMessage();
                }
                catch (Exception $e) 
                {
                    echo $e->getMessage();
                }
            }*/
            echo $result;
        }
        elseif($cmode == "bancaIndividual")
        {
            $res = $objComplaint->ProgressComplaintBanca($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);

            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";

            if($cumtomer_email != "")
            {
                $sb = "";
                $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                $sb .= "Best Regards,<br /><br />";
                $sb .= "Customer Experience and Conservation Department</br><br />";
                $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);

                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                    /*haroon*/
                }
                catch (phpmailerException $e) {
                  //  $e->errorMessage();
                }catch (Exception $e) {
                  //  $e->getMessage();
                }
            }

            echo $result;
        }
        elseif($cmode == "vatality")
        { 
            $res = $objComplaint->ProgressComplaintVatality($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$reassign,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);

            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";
            //echo $cumtomer_email;

            if($cumtomer_email != "")
            {
                $sb = "";
                $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                $sb .= "Best Regards,<br /><br />";
                $sb .= "Customer Experience and Conservation Department</br><br />";
                $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);

                try
                {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                          // Set mailer to use SMTP
                    //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                    $mail->Host = $email_host; 
                    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                    //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                    $mail->Username = $email_username;
                    $mail->Password = $email_password;                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;                                           // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "haroon.ssuet@gmail.com";
                    //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "IGI Complaint";
                    //$mail2 = clone $mail;

                    $mail->setFrom($email_username, $cname);
                    $mail->addAddress($cumtomer_email);                   // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body    = $sb;

                    /*haron*/
                    $mail->send();
                    `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                    /*haroon*/
                }
                catch (phpmailerException $e) 
                {
                   //  $e->errorMessage();
                }
                catch (Exception $e) 
                {
                   //  $e->getMessage();
                }
            }

            echo $result;
        }
        elseif($cmode == "bancaBank")
        {
            $res = $objComplaint->ProgressComplaintBancaBank($login_id,$complaint_id,$progress,$notes,$cmode,$manual,$cmp_user_name,$cmp_user_group,$invalid,$user_id,$priority,$tat,$user,$new_user,$is_manual,$departmentName,$cmp_type);

            $detail = explode('|',$res);
            $cumtomer_email = $detail[1];
            $complaint_num = $detail[2];
            $result = $detail[0];
            $cc_emails = "";
            $subject = "IGI Complaint";

            if($cumtomer_email != "")
            {
                    $sb = "";
                    $sb .="Dear Customer,<br/><br/>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br/><br/>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest<br/><br/> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.<br/><br/><br/>";
                    $sb .= "Best Regards,<br /><br />";
                    $sb .= "Customer Experience and Conservation Department</br><br />";
                    $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

                    $setmail      = $objComplaint->setemail($cumtomer_email,$cc_emails,$subject,$sb);
                    try
                    {
                        $mail = new PHPMailer(true);

                        //$mail->isSMTP();                                          // Set mailer to use SMTP
                        //$mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                        $mail->Host = $email_host; 
                        $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                        //$mail->Username = 'services.life@igi.com.pk';              // SMTP username
                        $mail->Username = $email_username;
                        $mail->Password = $email_password;                              // SMTP password
                        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = $port;                                           // TCP port to connect to*/
                        $mail->SMTPDebug = 1;

                        //$to_email = "atif.rehman@m3tech.com.pk";
                        //$to_email = "haroon.ssuet@gmail.com";
                        //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                        $subject = "IGI Complaint";
                        //$mail2 = clone $mail;

                        $mail->setFrom($email_username, $cname);
                        $mail->addAddress($cumtomer_email);                   // Add a recipient
                        //$mail->addCC($cc_emails);
                        $mail->isHTML(true);                                        // Set email format to HTML

                        $mail->Subject = $subject;
                        $mail->Body    = $sb;

                        /*haron*/
                        $mail->send();
                        `echo "email send successfully|$email|$sb" >> /tmp/email_complaint.log`;
                        /*haroon*/
                    }
                    catch (phpmailerException $e) {
                      //  $e->errorMessage();
                    }catch (Exception $e) {
                       // $e->getMessage();
                    }
            }
            echo $result;
        }
    }
    elseif($action == "verification_comment")
    {
        echo $objComplaint->VerifiedComplaint($complaint_id,$comments);
    }

    if($action == "save")
    {
        $cnic               = isset($_POST['cnic'])?$_POST['cnic']:'';
        $customer_name      = isset($_POST['customer_name'])?$_POST['customer_name']:'';
        $card_number        = isset($_POST['card_number'])?$_POST['card_number']:'';
        $branch             = isset($_POST['branch'])?$_POST['branch']:'';

        $callback           = isset($_POST['callback'])?$_POST['callback']:'';
        $office_phone       = isset($_POST['office_phone'])?$_POST['office_phone']:'';
        $mobile_number      = isset($_POST['mobile_number'])?$_POST['mobile_number']:'';
        $residence_address  = isset($_POST['residence_address'])?$_POST['residence_address']:'';
        $alternate_address  = isset($_POST['alternate_address'])?$_POST['alternate_address']:'';
        $residence_phone    = isset($_POST['residence_phone'])?$_POST['residence_phone']:'';
        $email              = isset($_POST['email'])?$_POST['email']:'';

        $is_email           = isset($_POST['is_email'])?$_POST['is_email']:'';
        $is_sms             = isset($_POST['is_sms'])?$_POST['is_sms']:'';
        $res_number         = isset($_POST['res_number'])?$_POST['res_number']:'';

        $complaint_id = $objComplaint->SaveComplaint($product, $type, $priority, $title, $description, $login_id, $counter, $counter_display);

        if($complaint_id > 0)
        {
            $objComplaint->SaveComplaintDetails($complaint_id,$counter_display,$cnic,$customer_name,$card_number,$branch,$callback,$office_phone,$mobile_number,$residence_address,$alternate_address,$residence_phone,$email,$is_email,$is_sms,$res_number);
            echo "success|".$complaint_id;
        }
    }
    elseif($action == "forward")
    {
        /*$department      = isset($_POST['department'])?$_POST['department']:'';
        $users           = isset($_POST['users'])?$_POST['users']:'';
        $complaint_users = implode(",", $users);

         $response = $objComplaint->ForwardComplaint($complaint_id,$department,$complaint_users, $comments);die;

        $data = $objComplaint->GetComplaint($login_id,$complaint_id);

        $sb = "";

        foreach($users as $user){

            $dataUser = $objUser->GetUsersById($user);
            $to_email = $dataUser[0]['email'];
            $user_name = $dataUser[0]['user_name'];

            $sb .="Dear $user_name,<br /> <br />";
            $sb .= "A new Complaint has been assigned to you <br /> <br />";

            $sb .="  <table id='customers22' style='font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>

                    <thead>
                        <tr>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Complaint ID</th>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Complaint Title</th>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Complaint Type</th>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Description</th>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Department</th>
                            <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Comments</th>
                        </tr>
                    </thead>
                    <tbody id='divPayments'>";


            $sb .="<tr>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['complaint_counter']."</td>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['complaint_title']."</td>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['type']."</td>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['complaint_desc']."</td>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['department']."</td>";
            $sb .=" <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>".$data[0]['comments']."</td>";
            $sb .="</tr>";

            $sb .="<br /> Regards, <br />";
            $sb .="IGI Admin";

            try{
                $mail = new PHPMailer(true);

                //$mail->isSMTP();                                      	// Set mailer to use SMTP
                $mail->Host = '61.5.156.108';  			                    // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               	    // Enable SMTP authentication
                $mail->Username = 'alerts.igi@m3tech.com.pk';              // SMTP username
                $mail->Password = '';                              // SMTP password
                $mail->SMTPSecure = 'ssl';                            	    // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 25;                                    	    // TCP port to connect to*/
                /*$mail->SMTPDebug = 1;

                //$to_email = "atif.rehman@m3tech.com.pk";
                //$to_email = "noman.khan330@gmail.com";
                //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                $subject = "IGI Complaint For $user_name";

                $mail->setFrom('alerts.igi@m3tech.com.pk', 'IGI');
                $mail->addAddress($to_email, $user_name);     	            // Add a recipient
                //$mail->addCC($cc_emails);
                $mail->isHTML(true);                                        // Set email format to HTML

                $mail->Subject = $subject;
                $mail->Body    = $sb;

                if($mail->send()) {
                    `echo "email send successfully|$current_datetime|$to_email" >> /tmp/email_complaint.log`;
                }
                else{
                    `echo "email send failed|$current_datetime|$to_email" >> /tmp/email_complaint.log`;
                }

            }
            catch (phpmailerException $e) {
                echo $e->errorMessage();
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $sb = "";
        }
        echo $response;*/
    }
    elseif($action == "close")
    {
        $complaint_id   = isset($_POST['complaint_id'])?$_POST['complaint_id']:'';
        $comments   = isset($_POST['comments'])?$_POST['comments']:'';

        echo $objComplaint->CloseComplaint($complaint_id,$comments);
    }
    elseif($action == "select_type")
    {
        $type_id   = isset($_POST['id'])?$_POST['id']:'';

        $dataSelect = $objComplaint->GetComplaintTypeByProduct($type_id);

        /*$SelectSubCategory = "<option disabled selected='selected'>Select Complaint Type</option>";*/

        if(!empty($dataSelect)){
            foreach ($dataSelect as $values) {
                $SelectSubCategory .= "<option value=".$values['id']."> ".$values['fullname']."</option>";
            }
        }else{
            $SelectSubCategory .= "<option value='0'>Select Complaint Type</option>";
        }

        echo $SelectSubCategory;
    }
    elseif($action == 'upload')
    {
        $errors         = array();

        $file_counter   = 0;
        $complaint_id   = isset($_POST['complaint_id_main'])?$_POST['complaint_id_main']:'';
        $complaint_idC  = isset($_POST['complaint_id_mainC'])?$_POST['complaint_id_mainC']:'';
        $complaint_idL  = isset($_POST['complaint_id_mainL'])?$_POST['complaint_id_mainL']:'';
        $complaint_idB  = isset($_POST['complaint_id_mainB'])?$_POST['complaint_id_mainB']:'';
        $complaint_idBB = isset($_POST['complaint_id_mainBB'])?$_POST['complaint_id_mainBB']:'';
        $complaint_idV  = isset($_POST['complaint_id_mainV'])?$_POST['complaint_id_mainV']:'';

        $dir = "../../uploads_eform_complaint/complaint_attachment/";

        if(isset($_FILES['fileupload1']) && $_FILES['fileupload1']['size'] != 0)
        {
            $file_name = $_FILES['fileupload1']['name'];
            $file_tmp =  $_FILES['fileupload1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileupload1']['name']);

            if(is_dir($dir.$counter_display) == false)
            {
                mkdir($dir.$counter_display);
            }

            $uploaddir = $dir.$counter_display."/".$counter_display."_".$imagename;

            if(empty($errors)==true)
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

            if(is_dir($dir.$counter_display) == false){
                mkdir($dir.$counter_display);
            }

            $uploaddir = $dir.$counter_display."/".$counter_display."_".$imagename;

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

            if(is_dir($dir.$counter_display) == false){
                mkdir($dir.$counter_display);
            }

            $uploaddir = $dir.$counter_display."/".$counter_display."_".$imagename;

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

            if(is_dir($dir.$counter_display) == false){
                mkdir($dir.$counter_display);
            }

            $uploaddir = $dir.$counter_display."/".$counter_display."_".$imagename;

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

            if(is_dir($dir.$counter_display) == false){
                mkdir($dir.$counter_display);
            }

            $uploaddir = $dir.$counter_display."/".$counter_display."_".$imagename;

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
        
        if(isset($_FILES['fileuploadC1']) && $_FILES['fileuploadC1']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadC1']['name'];
            $file_tmp =  $_FILES['fileuploadC1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadC1']['name']);

            if(is_dir($dir.$counter_displayC) == false){
                mkdir($dir.$counter_displayC);
            }

            $uploaddir = $dir.$counter_displayC."/".$counter_displayC."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadC1']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadC2']) && $_FILES['fileuploadC2']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadC2']['name'];
            $file_tmp =  $_FILES['fileuploadC2']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadC2']['name']);

            if(is_dir($dir.$counter_displayC) == false){
                mkdir($dir.$counter_displayC);
            }

            $uploaddir = $dir.$counter_displayC."/".$counter_displayC."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadC2']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadC3']) && $_FILES['fileuploadC3']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadC3']['name'];
            $file_tmp =  $_FILES['fileuploadC3']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadC3']['name']);

            if(is_dir($dir.$counter_displayC) == false){
                mkdir($dir.$counter_displayC);
            }

            $uploaddir = $dir.$counter_displayC."/".$counter_displayC."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadC3']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadC4']) && $_FILES['fileuploadC4']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadC4']['name'];
            $file_tmp =  $_FILES['fileuploadC4']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadC4']['name']);

            if(is_dir($dir.$counter_displayC) == false){
                mkdir($dir.$counter_displayC);
            }

            $uploaddir = $dir.$counter_displayC."/".$counter_displayC."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadC4']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadC5']) && $_FILES['fileuploadC5']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadC5']['name'];
            $file_tmp =  $_FILES['fileuploadC5']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadC5']['name']);

            if(is_dir($dir.$counter_displayC) == false){
                mkdir($dir.$counter_displayC);
            }

            $uploaddir = $dir.$counter_displayC."/".$counter_displayC."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadC5']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadL1']) && $_FILES['fileuploadL1']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadL1']['name'];
            $file_tmp =  $_FILES['fileuploadL1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadL1']['name']);

            if(is_dir($dir.$counter_displayL) == false){
                mkdir($dir.$counter_displayL);
            }

            $uploaddir = $dir.$counter_displayL."/".$counter_displayL."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadL1']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadL2']) && $_FILES['fileuploadL2']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadL2']['name'];
            $file_tmp =  $_FILES['fileuploadL2']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadL2']['name']);

            if(is_dir($dir.$counter_displayL) == false){
                mkdir($dir.$counter_displayL);
            }

            $uploaddir = $dir.$counter_displayL."/".$counter_displayL."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadL2']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadL3']) && $_FILES['fileuploadL3']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadL3']['name'];
            $file_tmp =  $_FILES['fileuploadL3']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadL3']['name']);

            if(is_dir($dir.$counter_displayL) == false){
                mkdir($dir.$counter_displayL);
            }

            $uploaddir = $dir.$counter_displayL."/".$counter_displayL."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadL3']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadL4']) && $_FILES['fileuploadL4']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadL4']['name'];
            $file_tmp =  $_FILES['fileuploadL4']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadL4']['name']);

            if(is_dir($dir.$counter_displayL) == false){
                mkdir($dir.$counter_displayL);
            }

            $uploaddir = $dir.$counter_displayL."/".$counter_displayL."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadL4']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadL5']) && $_FILES['fileuploadL5']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadL5']['name'];
            $file_tmp =  $_FILES['fileuploadL5']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadL5']['name']);

            if(is_dir($dir.$counter_displayL) == false){
                mkdir($dir.$counter_displayL);
            }

            $uploaddir = $dir.$counter_displayL."/".$counter_displayL."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadL5']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
         if(isset($_FILES['fileuploadB1']) && $_FILES['fileuploadB1']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadB1']['name'];
            $file_tmp =  $_FILES['fileuploadB1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadB1']['name']);

            if(is_dir($dir.$counter_displayB) == false){
                mkdir($dir.$counter_displayB);
            }

            $uploaddir = $dir.$counter_displayB."/".$counter_displayB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadB1']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadB2']) && $_FILES['fileuploadB2']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadB2']['name'];
            $file_tmp =  $_FILES['fileuploadB2']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadB2']['name']);

            if(is_dir($dir.$counter_displayB) == false){
                mkdir($dir.$counter_displayB);
            }

            $uploaddir = $dir.$counter_displayB."/".$counter_displayB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadB2']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadB3']) && $_FILES['fileuploadB3']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadB3']['name'];
            $file_tmp =  $_FILES['fileuploadB3']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadB3']['name']);

            if(is_dir($dir.$counter_displayB) == false){
                mkdir($dir.$counter_displayB);
            }

            $uploaddir = $dir.$counter_displayB."/".$counter_displayB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadB3']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadB4']) && $_FILES['fileuploadB4']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadB4']['name'];
            $file_tmp =  $_FILES['fileuploadB4']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadB4']['name']);

            if(is_dir($dir.$counter_displayB) == false){
                mkdir($dir.$counter_displayB);
            }

            $uploaddir = $dir.$counter_displayB."/".$counter_displayB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadB4']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadB5']) && $_FILES['fileuploadB5']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadB5']['name'];
            $file_tmp =  $_FILES['fileuploadB5']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadB5']['name']);

            if(is_dir($dir.$counter_displayB) == false){
                mkdir($dir.$counter_displayB);
            }

            $uploaddir = $dir.$counter_displayB."/".$counter_displayB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadB5']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadV1']) && $_FILES['fileuploadV1']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadV1']['name'];
            $file_tmp =  $_FILES['fileuploadV1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadV1']['name']);

            if(is_dir($dir.$counter_displayV) == false){
                mkdir($dir.$counter_displayV);
            }

            $uploaddir = $dir.$counter_displayV."/".$counter_displayV."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadV1']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadV2']) && $_FILES['fileuploadV2']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadV2']['name'];
            $file_tmp =  $_FILES['fileuploadV2']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadV2']['name']);

            if(is_dir($dir.$counter_displayV) == false){
                mkdir($dir.$counter_displayV);
            }

            $uploaddir = $dir.$counter_displayV."/".$counter_displayV."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadV2']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadV3']) && $_FILES['fileuploadV3']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadV3']['name'];
            $file_tmp =  $_FILES['fileuploadV3']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadV3']['name']);

            if(is_dir($dir.$counter_displayV) == false){
                mkdir($dir.$counter_displayV);
            }

            $uploaddir = $dir.$counter_displayV."/".$counter_displayV."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadV3']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadV4']) && $_FILES['fileuploadV4']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadV4']['name'];
            $file_tmp =  $_FILES['fileuploadV4']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadV4']['name']);

            if(is_dir($dir.$counter_displayV) == false){
                mkdir($dir.$counter_displayV);
            }

            $uploaddir = $dir.$counter_displayV."/".$counter_displayV."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadV4']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadV5']) && $_FILES['fileuploadV5']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadV5']['name'];
            $file_tmp =  $_FILES['fileuploadV5']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadV5']['name']);

            if(is_dir($dir.$counter_displayV) == false){
                mkdir($dir.$counter_displayV);
            }

            $uploaddir = $dir.$counter_displayV."/".$counter_displayV."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadV5']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadBB1']) && $_FILES['fileuploadBB1']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadBB1']['name'];
            $file_tmp =  $_FILES['fileuploadBB1']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadBB1']['name']);

            if(is_dir($dir.$counter_displayBB) == false){
                mkdir($dir.$counter_displayBB);
            }

            $uploaddir = $dir.$counter_displayBB."/".$counter_displayBB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadBB1']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadBB2']) && $_FILES['fileuploadBB2']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadBB2']['name'];
            $file_tmp =  $_FILES['fileuploadBB2']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadBB2']['name']);

            if(is_dir($dir.$counter_displayBB) == false){
                mkdir($dir.$counter_displayBB);
            }

            $uploaddir = $dir.$counter_displayBB."/".$counter_displayBB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadBB2']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadBB3']) && $_FILES['fileuploadBB3']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadBB3']['name'];
            $file_tmp =  $_FILES['fileuploadBB3']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadBB3']['name']);

            if(is_dir($dir.$counter_displayBB) == false){
                mkdir($dir.$counter_displayBB);
            }

            $uploaddir = $dir.$counter_displayBB."/".$counter_displayBB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadBB3']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadBB4']) && $_FILES['fileuploadBB4']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadBB4']['name'];
            $file_tmp =  $_FILES['fileuploadBB4']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadBB4']['name']);

            if(is_dir($dir.$counter_displayBB) == false){
                mkdir($dir.$counter_displayBB);
            }

            $uploaddir = $dir.$counter_displayBB."/".$counter_displayBB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadBB4']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        if(isset($_FILES['fileuploadBB5']) && $_FILES['fileuploadBB5']['size'] != 0)
        {   
            $file_name = $_FILES['fileuploadBB5']['name'];
            $file_tmp =  $_FILES['fileuploadBB5']['tmp_name'];

            $imagename = stripslashes($_FILES['fileuploadBB5']['name']);

            if(is_dir($dir.$counter_displayBB) == false){
                mkdir($dir.$counter_displayBB);
            }

            $uploaddir = $dir.$counter_displayBB."/".$counter_displayBB."_".$imagename;

            if(empty($errors)==true)
            {
                move_uploaded_file($_FILES['fileuploadBB5']['tmp_name'], $uploaddir);
                $file_counter++;
            }
            else
            {

                $errors[]="true";
            }
        }
        
        if(empty($errors))
        {
            if($type == "individual")
            {
                $response = $objComplaint->UpdateCommentsLife($comments,$file_counter,$complaint_id);
                echo ("success|".$counter_display);
            }
            elseif ($type == "corporate") 
            {
                $response = $objComplaint->UpdateCommentsCo($commentsC,$file_counter,$complaint_idC);
                echo ("success|".$counter_displayC);
            }
            elseif ($type == "internal") 
            {
                $response = $objComplaint->UpdateCommentsInternal($comments,$file_counter,$complaint_id);
                echo ("success|".$counter_display);
            }
            elseif ($type == "legal") 
            {
                $response = $objComplaint->UpdateCommentsLegal($commentsL,$file_counter,$complaint_idL);
                echo ("success|".$counter_displayL);
            }
            elseif ($type == "bancaIndividual") 
            {
                $response = $objComplaint->UpdateCommentsBanca($commentsB,$file_counter,$complaint_idB);
                echo ("success|".$counter_displayB);
            }
            elseif ($type == "bancaBank") 
            {
                $response = $objComplaint->UpdateCommentsBancaBank($commentsBB,$file_counter,$complaint_idBB);
                echo ("success|".$counter_displayBB);
            }
            elseif ($type == "vatality") 
            {
                $response = $objComplaint->UpdateCommentsVatality($commentsV,$file_counter,$complaint_idV);
                echo ("success|".$counter_displayV);
            }
        }
        else
        {
            echo ("fail");
        }
    }
}
?>
