<?php
//require_once 'third_party/PHPMailer/PHPMailerAutoload.php';
require_once(MAILER_PATH.DS.'PHPMailer/PHPMailerAutoload.php');

function generateFeedbackUrl($type,$complaintNumber)
{
    $data = array(
        'c' => $complaintNumber,
        't' => $type
    );

    $json = json_encode($data);

    // IMPORTANT: use OPENSSL_RAW_DATA for proper encoding
    $encrypted = openssl_encrypt(
        $json,
        'AES-128-ECB',
        'your-secret-key',
        OPENSSL_RAW_DATA
    );

    // URL safe base64
    $urlSafe = rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '=');

    $feedbackUrl = FEEDBACK_URL . $urlSafe;

    // Return full URL
    return $feedbackUrl;
}
function formatCnicNumber($number)
{
    // Remove everything except digits
    $number = preg_replace('/\D/', '', $number);

    // Format: 5 digits - 7 digits - remaining digits
    if (strlen($number) >= 13) {
        return substr($number, 0, 5) . '-' .
               substr($number, 5, 7) . '-' .
               substr($number, 12);
    }

    return $number;
}

function excelDate($date, $format = 'd/m/Y')
{
    if (
        empty($date) ||
        $date === '0000-00-00' ||
        $date === '1970-01-01' ||
        $date === '01-01-1970' ||
        $date === '0000-00-00 00:00:00' ||
        strtotime($date) === false
    ) {
        return '';
    }

    return PHPExcel_Shared_Date::PHPToExcel(date($format, strtotime($date)));
}
function formatCNIC($cnic) {
    $cnic = preg_replace('/\D/', '', $cnic);
    return preg_replace('/^(\d{5})(\d{7})(\d{1})$/', '$1-$2-$3', $cnic);
}
   function send_mail_complaint_customer($toemail,$complaint_num,$isclosed){

         $sb = "";

    if($isclosed == "0"){

        $sb .="Dear Customer,</br></br>Thank you for contacting IGI Life Insurance. Your complaint has been registered and is in process. Your complaint reference No is:<b> $complaint_num</b>, which should be used for further communication with respect to your complaint.<br /></br>One of our representative will contact you within 24 hours during business days.  We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN: <b>021-111 111 711</b> <br /><br /><br />";
            $sb .= "Best Regards,<br /><br />";
            $sb .= "Customer Experience and Conservation Department</br><br />";
            $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";


       }else{

           $sb .="Dear Customer,</br></br>This is to inform you that your complaint no. :<b> $complaint_num</b> has been resolved at our end.<br /></br>We assure you of our best services and would request you to provide your feedback which will help us in improving our services and serve your better.In case of any dispute kindly contact us at your earliest</br></br> We look forward to serving you better and for any further assistance, you are welcome to contact our call center on UAN <b>021-111 111 711.</b> <br /><br /><br />";
            $sb .= "Best Regards,<br /><br />";
            $sb .= "Customer Experience and Conservation Department</br><br />";
            $sb .= "Email: services.life@igi.com.pk : Web: www.igilife.com.pk, UAN Number: 021-111-111-711";

       }

            try{
                $mail = new PHPMailer(true);

                //$mail->isSMTP();                                          // Set mailer to use SMTP
                $mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                $mail->Username = 'services.life@igi.com.pk';              // SMTP username
                $mail->Password = '';                              // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 26;                                           // TCP port to connect to*/
                $mail->SMTPDebug = 1;

                //$to_email = "atif.rehman@m3tech.com.pk";
                //$to_email = "noman.khan330@gmail.com";
                //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                $subject = "IGI Complaint";

                $mail->setFrom('services.life@igi.com.pk', 'IGI');
                $mail->addAddress($toemail, $toemail);                   // Add a recipient
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
            }catch (Exception $e) {
                echo $e->getMessage();
            }

            //$sb = "";
            return "mail sent";
        }

function send_mail_level_one($user_name,$agent,$complaint_num,$depart,$complaint_type,$priority,$desc,$to_email){

            $sb = "";
            $sb .="Dear $user_name,<br /> <br />";
            $sb .= "$agent has registered Call bearing ticket no <b>$complaint_num </b>assigned to $user_name <br /> <br /></br>";
            $sb .= "Department            : " . $depart."</br></br>";
            $sb .= "Currently Assigned to : " . $user_name."</br></br>";
            $sb .= "Complaint Type        : " . $complaint_type."</br></br>";
            $sb .= "Severity Level        : " . $priority."</br></br>";
            $sb .= "Problem Description   : " . $desc."</br></br>";
            $sb .= "Sincerely,</br></br>";
            $sb .= "Service Desk </br>";
            $sb .= "IGI Life";


            try{
                $mail = new PHPMailer(true);

                //$mail->isSMTP();                                          // Set mailer to use SMTP
                $mail->Host = '10.9.0.4';                               // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                     // Enable SMTP authentication
                $mail->Username = 'services.life@igi.com.pk';              // SMTP username
                $mail->Password = '';                              // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 26;                                           // TCP port to connect to*/
                $mail->SMTPDebug = 1;

                //$to_email = "atif.rehman@m3tech.com.pk";
                //$to_email = "noman.khan330@gmail.com";
                //$cc_emails = "abdullah.qamar@m3tech.com.pk";
                $subject = "IGI Complaint For $user_name";

                $mail->setFrom('services.life@igi.com.pk', 'IGI');
                $mail->addAddress($to_email, $to_email);                   // Add a recipient
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



    }
        
    

?>