<?php
require_once("includes/config.php");
require_once('classes/complaint.php');
require_once 'third_party/PHPMailer/PHPMailerAutoload.php';
$objComplaint = new Complaint();
$data = $objComplaint->GetComplaintInProcess();

$date = date('Y-m-d');

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
			            $sb .="Dear $user_name,<br /> <br />";
			            $sb .="The complaint  $cmp_num  is still un-resolved.<br><br>This mail is being generated to take the matter in your knowledge.</br></br>"; 
			            $sb .= "Complaint By          : " . $customer_name . "</br></br>";
			            $sb .= "Department            : " . $depart."</br></br>";
			            $sb .= "Currently Assigned to : " . $user."</br></br>";
			            $sb .= "Complaint Type        : " . $cmp_type."</br></br>";
			            $sb .= "Severity Level        : " . $priority."</br></br>";
			            $sb .= "Total Days Lapsed     :     3 Days </br></br>";
                  $sb .= "Total Remaining Days  :     3 Days </br></br>";
			            $sb .= "Problem Description   : " . $desc."</br></br>";
			            $sb .= "Sincerely,</br></br>";
			            $sb .= "Service Desk </br>";
			            $sb .= "IGI Life";

                 echo $sb;
			            /*try{
			                $mail = new PHPMailer(true);

			                //$mail->isSMTP();                               // Set mailer to use SMTP
			                $mail->Host = '10.9.0.4';                 // Specify main and backup SMTP servers
			                $mail->SMTPAuth = true;                     // Enable SMTP authentication
			                $mail->Username = 'services.life@igi.com.pk';              // SMTP username
			                $mail->Password = '';                                      // SMTP password
			                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			                $mail->Port = 26;                                           // TCP port to connect to*/
			                /*$mail->SMTPDebug = 1;

			                //$to_email = "atif.rehman@m3tech.com.pk";
			                //$to_email = "noman.khan330@gmail.com";
			                $cc_emails = "abdullah.qamar@m3tech.com.pk";
			                $subject = "IGI Complaint For $user_name";

			                $mail->setFrom('services.life@igi.com.pk', 'IGI');
			                $mail->addAddress($to_email, $user_name);                   // Add a recipient
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
					            }*/
                 			echo "HOD email";
                 }elseif ($count == 0) {
                       
                      $sb = "";
					            $sb .="Dear Madeem Malik,<br /> <br />";
					            $sb .="The complaint  $cmp_num  is still un-resolved.<br><br>This mail is being generated to take the matter in your knowledge.</br></br>"; 
					            $sb .= "Complaint By          : " . $customer_name . "</br></br>";
					            $sb .= "Department            : " . $depart."</br></br>";
					            $sb .= "Currently Assigned to : " . $user."</br></br>";
					            $sb .= "Complaint Type        : " . $cmp_type."</br></br>";
					            $sb .= "Severity Level        : " . $priority."</br></br>";
					            $sb .= "Total Days Lapsed     :     6 Days </br></br>";
		                  $sb .= "Total Remaining Days  :     1 Days </br></br>";
					            $sb .= "Problem Description   : " . $desc."</br></br>";
					            $sb .= "Sincerely,</br></br>";
					            $sb .= "Service Desk </br>";
					            $sb .= "IGI Life";

                 echo $sb;
			            /*try{
			                $mail = new PHPMailer(true);

			                //$mail->isSMTP();                                          // Set mailer to use SMTP
			                $mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
			                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
			                $mail->Username = 'services.life@igi.com.pk';              // SMTP username
			                $mail->Password = '';                              // SMTP password
			                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
			                $mail->Port = 26;                                           // TCP port to connect to*/
			                /*$mail->SMTPDebug = 1;

			                //$to_email = "atif.rehman@m3tech.com.pk";
			                $to_email = "nadeem.malik@igi.com.pk";
			                $cc_emails = "saima.zafar@igi.com.pk";
			                $subject = "IGI Complaint For $user_name";

			                $mail->setFrom('services.life@igi.com.pk', 'IGI');
			                $mail->addAddress($to_email,$to_email);                   // Add a recipient
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
					            }*/
                 	echo " CEO email";
                 } 

                        
			 	# code...
			 }




}

/*$tat = "7";
echo date('Y-m-d' ,strtotime("+$tat weekdays")) ."<br>";

$stdate = date('Y-m-d');
$edate = "2018-03-16 00:00:00";
echo $stdate ."--".$edate ."<br>";

//$date1 = strtotime($stdate);
//$date2 = strtotime($edate);
//echo $diff = days_diff($stdate,$edate);

$daysLeft = abs(strtotime($stdate) - strtotime($edate));
echo $days = $daysLeft/(60 * 60 * 24);*/
?>