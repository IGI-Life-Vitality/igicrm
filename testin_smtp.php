<?php
require_once("includes/config.php");

//require_once 'third_party/PHPMailer/PHPMailerAutoload.php';
require_once(MAILER_PATH.DS.'PHPMailer/PHPMailerAutoload.php');
//require_once('/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php');

//print_r($data);

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
			                $mail->Port = 26;                                           // TCP port to connect to*/
			                $mail->SMTPDebug = 1;

			                $to_email = "haroon.ssuet@gmail.com";
			                //$to_email = "bilal.hussain@igi.com.pk";
			                //$cc_emails = "haroon.ssuet@gmail.com";
			                $subject = "IGI Complaint";

			                $mail->setFrom($email_username, 'IGI');
			                $mail->addAddress($to_email);                   // Add a recipient
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
                 			echo "HOD email";
    
?>
