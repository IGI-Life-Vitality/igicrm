<?php
/*ob_start();
require_once("includes/config.php");
require_once 'third_party/PHPMailer/PHPMailerAutoload.php';
include('classes/email.php');

$objEmail = new Email();
$emails = $objEmail->GetEmails();

$datetime = date('Y-m-d H:i:s');

/*echo '<pre>';
print_r($emails);
echo '</pre>';
die;*/

/*if (!empty($emails)){


    foreach ($emails as $email){

        $id = $email['id'];
        $user_id = $email['user_id'];
        $to_emails = $email['toemail'];
        $cc_emails = $email['ccemail'];
        $subject = $email['subject'];
        $content = $email['content'];
        $folder = $email['folder'];
        $files = $email['files'];
        $type = $email['type'];

        if($folder != ''){

            try{

                //PHPMailer Object
                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = "61.5.156.108";
                $mail->SMTPAuth = true;
                $mail->Username = "alerts.fwbl@m3tech.com.pk";
                $mail->Password = "@L3R*fwb!";
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->SMTPDebug = 2;

                $mail->setFrom("alerts.fwbl@m3tech.com.pk", 'FWBL - ' . $subject);

                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $content;

                //attachement start
                $dirname = SITE_ROOT . DS . $type . DS . $folder . DS;
                $filesname = explode('.',$files);
                $filename = $filesname[0];
                $files = $dirname.$files;
                $mail->addAttachment($files, $filename);
                //attachement end

                //to email loop start
                if (preg_match('/,/',$to_emails)){

                    $to_emails_lists = explode(",",$to_emails);
                    $set_from_email = $to_emails_lists[0];

                    foreach($to_emails_lists as $to_emails_list){
                        $mail->addAddress($to_emails_list, $to_emails_list);
                    }
                }
                else if (preg_match('/;/',$to_emails)){

                    $to_emails_lists = explode(";",$to_emails);
                    $set_from_email = $to_emails_lists[0];

                    foreach($to_emails_lists as $to_emails_list){
                        $mail->addAddress($to_emails_list, $to_emails_list);
                    }
                }
                else{
                    $mail->addAddress($to_emails, $to_emails);
                }
                //to email loop end


                //cc email loop start
                if (preg_match('/,/',$cc_emails)){
                    $cc_emails_lists = explode(",",$cc_emails);
                }
                else if (preg_match('/;/',$cc_emails)){
                    $cc_emails_lists = explode(";",$cc_emails);
                }
                else{
                    $cc_emails_lists = '';
                }

                if(!empty($cc_emails_lists)){
                    foreach($cc_emails_lists as $cc_emails_list){
                        if($cc_emails_list != ''){
                            $mail->addCC($cc_emails_list);
                        }
                    }
                }
                else{
                    if($cc_emails != ''){
                        $mail->addCC($cc_emails);
                    }
                }
                //cc email loop end


                if($mail->send()) {
                    $objEmail->DeleteEmails($id);
                    echo "Email send successfully|$type|$datetime|$to_emails|$cc_emails\n";
                }
                else{
                    echo "email send failed|$type|$datetime|$to_emails|$cc_emails\n";
                }

            }
            catch (phpmailerException $e) {
                echo $e->errorMessage();
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }

}
else{
    echo "No email found|$datetime\n";
}
*/
?>