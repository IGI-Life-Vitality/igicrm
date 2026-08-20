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
        $main_folder = $email['main_folder'];
        $sub_folder = $email['sub_folder'];
        $files = $email['files'];
        $is_template = $email['is_template'];

        try{

            /*if($is_template == 1){
                $content = file_get_contents($dir_templates.$content);
                $content = str_replace('{ADDRESS}','Noman Khan',$content);
            }*/

            //PHPMailer Object
            /*$mail = new PHPMailer(true);

            //$mail->isSMTP();
            $mail->Host = $email_host;
            $mail->SMTPAuth = true;
            $mail->Username = $email_username;
            $mail->Password = $email_password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($email_username, 'FWBL - ' . $subject);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $dirname = SITE_ROOT . DS . $main_folder . DS . $sub_folder . DS;

            if($main_folder != '' && $sub_folder != '' && $files != ''){
                $filename = $files;
                $files = $dirname.$files;
                $mail->addAttachment($files, $filename);
            }


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
                echo "Email send successfully|$main_folder|$datetime|$to_emails|$cc_emails\n";
            }
            else{
                echo "Email send failed|$main_folder|$datetime|$to_emails|$cc_emails\n";
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
else{
    echo "No email found|$datetime\n";
}
*/
?>