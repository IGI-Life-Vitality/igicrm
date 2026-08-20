<?php
require_once("/var/www/html/igicrm/includes/config.php");
require_once('/var/www/html/igicrm/classes/complaint.php');
require_once '/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php';
$objComplaint = new Complaint();
$data = $objComplaint->GetEmailInProcess();
//print_r($data);
$date = date('Y-m-d');

if(!empty($data)){
			 foreach ($data as $value) {
			 	          $id            = $value['id'];
			 	          $to_email      = $value['toemail'];
                  $ccemail       = $value['ccemail'];
                  $content       = $value['content'];
                  $subject       = $value['subject'];
                       
                       //echo  $to_email;
                       //exit;
			            try{
			                $mail = new PHPMailer(true);

			                //$mail->isSMTP();                               // Set mailer to use SMTP
			                $mail->Host = $email_host;                 // Specify main and backup SMTP servers
			                $mail->SMTPAuth = true;                     // Enable SMTP authentication
			                $mail->Username = $email_username;              // SMTP username
			                $mail->Password = $email_password;                                      // SMTP password
			                $mail->SMTPSecure = '';                                  // Enable TLS encryption, `ssl` also accepted
			                $mail->Port = $port;                                           // TCP port to connect to*/
			                $mail->SMTPDebug = 1;

			                //$to_email = "atif.rehman@m3tech.com.pk";
			                //$to_email = "noman.khan330@gmail.com";
			                //$cc_emails = "abdullah.qamar@m3tech.com.pk";
			                //$subject = "IGI Complaint For $user_name";

			                $mail->setFrom($email_username, $cname);
			                $mail->addAddress($to_email);                   // Add a recipient
			                //$mail->addCC($ccemail);
			                $mail->isHTML(true);                                        // Set email format to HTML

			                $mail->Subject = $subject;
			                $mail->Body    = $content;

				                if($mail->send()) {
				                    `echo "email send successfully|$current_datetime|$to_email" >> /tmp/email_complaint.log`;
				                      echo "sent email";
				                      $data = $objComplaint->UpdateEmail($id);


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
                 	//		echo "HOD email";
                 		}
                 	}
                
?>