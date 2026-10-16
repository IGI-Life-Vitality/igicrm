<?php

require_once("/var/www/html/igicrm/includes/config.php");
require_once('/var/www/html/igicrm/classes/complaint.php');
require_once('/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php');

$objComplaint = new Complaint();

$data = $objComplaint->getComplaintSMSInterim();

/*echo "<pre>";
print_r($data);
die;*/

$current_date = date('Y-m-d h:i:s');

if(!empty($data)) {

    $msg = "";

    foreach ($data as $row) {

        $source  = $row['source'];
        $complaint_num  = $row['complaint_num'];
        $customer_name  = $row['customer_name'];
        $customer_email  = $row['customer_email'];
        $response_number  = $row['response_number'];
        $create_date  = $row['create_date'];
        $status_id  = $row['status_id'];
        $days_since_complaint  = $row['days_since_complaint'];

        if (!empty($response_number)){

            // if (sendSMS($customer_name, $complaint_num, $response_number)){
            //     $objComplaint->insertSMSInterim($source, $complaint_num, $customer_name, $customer_email, $response_number, $current_date, $status_id, $days_since_complaint, 'sms');
            //     echo "sms send successfully|$current_date|$response_number\n";
            // } else {
            //     echo "sms send failed|$current_date|$response_number\n";
            // }
        }

        
        if(!empty($customer_email)){
            if(sendMail($customer_name, $customer_email, $complaint_num)){
                $objComplaint->insertSMSInterim($source, $complaint_num, $customer_name, $customer_email, $response_number, $create_date, $status_id, $days_since_complaint,'email');
                echo $customer_email;
            }


        }
    }
}

function sendMail($customer_name, $customer_email, $complaint_num) {

    global $email_host, $email_username, $email_password, $port;

    //echo "$email_host|$email_username";die;

    $subject = "Update on Your Complaint [$complaint_num]";
    $body = emailTemplate($customer_name, $complaint_num);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $email_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $email_username;
        $mail->Password   = $email_password;
        $mail->SMTPSecure = "";
        $mail->Port       = $port;
        $mail->SMTPDebug = 2;

        // Sender
        $mail->setFrom($email_username, 'IGI Services');

        // Recipient
        $mail->addAddress($customer_email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->AltBody = $altBody ?: strip_tags($body);

        echo $mail->send();die;
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function emailTemplate($customer_name, $complaint_num){

    $html = '<!DOCTYPE html>
            <html>
            <head>
              <meta charset="UTF-8">
              <title>Complaint Update</title>
            </head>
            <body style="font-family: Arial, sans-serif; font-size:14px; color:#000;">
              <p>Mr./Ms. '.$customer_name.'<br>
                 Complaint No. '.$complaint_num.'</p>
            
              <p>Dear Sir/Madam,</p>
            
              <p>Your complaint is still under review, and our team is actively working to resolve it. 
              We will provide you with an update shortly.</p>
            
              <p>We kindly request your patience while we complete this process.</p>
            
              <p>In the meantime, should you require any assistance, please feel free to contact us at 
              <strong>021-111-111-711</strong> or write to us at 
              <a href="mailto:services.life@igi.com.pk">services.life@igi.com.pk</a>.</p>
            
              <p>Kind Regards,<br>
              Grievance Function<br>
              IGI Life Insurance Limited</p>
            </body>
            </html>';

    return $html;

}

function sendSMS($customer_name, $complaint_num, $response_number){

    global $objComplaint;

    $msg = "Mr./Ms. $customer_name, Complaint No. $complaint_num: Your complaint is still under review. We'll update you once resolved. For help, call 021-111-111-711 or email services.life@igi.com.pk.";
    $encoded_msg = urlencode($msg);

    $response_number = $objComplaint->check_num_new($response_number);
    $url ="http://10.40.64.15/igicrm/send-sms.php?msg=$encoded_msg&msisdn=$response_number";
    $res = file_get_contents($url);

    return true;
}