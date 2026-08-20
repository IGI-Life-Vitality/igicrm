<?php
require_once("/var/www/html/igicrm/includes/config.php");
require_once('/var/www/html/igicrm/classes/complaint.php');
//require_once 'third_party/PHPMailer/PHPMailerAutoload.php';
require_once('/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php');

$objComplaint = new Complaint();
$data = $objComplaint->GetComplaintInProcess();
$date = date('Y-m-d');
//print_r($data);
if(!empty($data)){
			 foreach ($data as $value) {
			 	          $depart        = $value['depart'];
                  $user          = $value['AssignedTo'];
                  $cmp_type      = $value['ComplaintType'];
                  $end_date      = $value['end_date'];
                  $coments       = $value['commments'];
                  $cmp_num       = $value['complaint_num'];
                  $customer_name = $value['customer_name'];
                  $group_id      = $value['group_id'];
                  $priority      = $value['priority_id'];
                  $desc          = "";

                 $hod_detail = $objComplaint->GetHODDetails($group_id);
                 $hod_name =   $hod_detail['first_name']. " " . $hod_detail['last_name'];
                 $hod_email =  $hod_detail['email']; 

                 $daysLeft = abs(strtotime($date) - strtotime($end_date));
                 $days = $daysLeft/(60 * 60 * 24);

                 $start = strtotime($date);
                 $end = strtotime($end_date);
                 $count = 0;

		 while(date('Y-m-d', $start) < date('Y-m-d', $end)){
		   $count += date('N', $start) < 6 ? 1 : 0;
		   $start = strtotime("+1 day", $start);
		 }
                 echo $count;
                 if($count == 3){

                 	$sb = "";
			            $sb .="Dear $hod_name,<br /> <br />";
			            $sb .="The complaint  $cmp_num  is still un-resolved.<br /><br />This mail is being generated to take the matter in your knowledge.<br /><br />"; 
			            $sb .= "Complaint By          : " . $customer_name . "<br /><br />";
			            $sb .= "Department            : " . $depart."<br /><br />";
			            $sb .= "Currently Assigned to : " . $user."<br /><br />";
			            $sb .= "Complaint Type        : " . $cmp_type."<br /><br />";
			            $sb .= "Severity Level        : " . $priority."<br /><br />";
			            $sb .= "Total Days Lapsed     :     3 Days <br /><br />";
                                    $sb .= "Total Remaining Days  :     3 Days <br /><br />";
			            $sb .= "Problem Description   : " . $desc."<br /><br />";
			            $sb .= "Sincerely,<br /><br />";
			            $sb .= "Service Desk <br />";
			            $sb .= "IGI Life";

			            try{
			                $mail = new PHPMailer(true);

			                //$mail->isSMTP();                               // Set mailer to use SMTP
			                $mail->Host = $email_host;                 // Specify main and backup SMTP servers
			                $mail->SMTPAuth = true;                     // Enable SMTP authentication
			                $mail->Username = $email_username;              // SMTP username
			                $mail->Password = $email_password;                                      // SMTP password
			                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			                $mail->Port = $port;                                           // TCP port to connect to*/
			                $mail->SMTPDebug = 1;

			                //$to_email = "atif.rehman@m3tech.com.pk";
			                $to_email = $hod_email;
			                $cc_emails = "haroon.saeed@m3tech.com.pk";
			                $subject = "IGI Complaint";

			                $mail->setFrom($email_username, 'IGI Life - services');
			                $mail->addAddress($hod_email);                   // Add a recipient
			                $mail->addCC($cc_emails);
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
                 			echo "HOD email";
                 }elseif ($count == 0) {
                       
                      $sb = "";
					            $sb .="Dear Nadeem Malik,<br /> <br />";
					            $sb .="The complaint  $cmp_num  is still un-resolved.<br /><br />This mail is being generated to take the matter in your knowledge.<br /><br />"; 
					            $sb .= "Complaint By          : " . $customer_name . "<br /><br />";
					            $sb .= "Department            : " . $depart."<br /><br />";
					            $sb .= "Currently Assigned to : " . $user."<br /><br />";
					            $sb .= "Complaint Type        : " . $cmp_type."<br /><br />";
					            $sb .= "Severity Level        : " . $priority."<br /><br />";
					            $sb .= "Total Days Lapsed     :     6 Days <br /><br />";
		                                    $sb .= "Total Remaining Days  :     1 Days <br /><br />";
					            $sb .= "Problem Description   : " . $desc."<br /><br />";
					            $sb .= "Sincerely,<br /><br />";
					            $sb .= "Service Desk <br />";
					            $sb .= "IGI Life";

                 
			            try{
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
			                $to_email = "shafi.muhammad@IGI.COM.PK";
			                $cc_emails = "haroon.saeed@m3tech.com.pk";
			                $subject = "IGI Complaint";

			                $mail->setFrom($email_username, 'IGI Life - services');
			                $mail->addAddress($to_email);                   // Add a recipient
			                $mail->addCC($cc_emails);
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
                 	echo " CEO email";
                 }else{
                 	echo "NO mail sent";
                 } 

                        
			 	# code...
			 }




}
?>
