<?php

try{

    require_once 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer(true);

    //$mail->isSMTP();                                      	// Set mailer to use SMTP
    $mail->Host = '61.5.156.108';  			                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               	    // Enable SMTP authentication
    $mail->Username = 'Alerts.fwbl@m3tech.com.pk';              // SMTP username
    $mail->Password = '@L3R*fwb!';                              // SMTP password
    $mail->SMTPSecure = 'ssl';                            	    // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    	    // TCP port to connect to*/
    $mail->SMTPDebug = 1;

    $to_email = "noman.khan330@gmail.com";
    $cc_emails = "abdullah.qamar@m3tech.com.pk";
    $subject = "test email";
    $content = "test content123";

    $mail->setFrom('Alerts.fwbl@m3tech.com.pk', 'FWBL');
    $mail->addAddress($to_email, $to_email);     	            // Add a recipient
    $mail->addCC($cc_emails);
    $mail->isHTML(true);                                        // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $content;

    echo $mail->Send();
    echo $mail->ErrorInfo;


}catch (phpmailerException $e) {
    echo $e->errorMessage(); //error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage();
}



?>