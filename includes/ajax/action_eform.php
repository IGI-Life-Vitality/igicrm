<?php

require_once("../config.php");
require_once '../../third_party/PHPMailer/PHPMailerAutoload.php';
include(CLASSES_PATH.DS.'eform.php');
include(CLASSES_PATH.DS.'user.php');


$objUser = new User();
$objeform = new eform();
$login_id = $_SESSION['login_id'];

if(isset($_POST)) {

    $action           = isset($_POST['action'])?$_POST['action']:'';
    $Id               = isset($_POST['id'])?$_POST['id']: 0;
    $eform            = isset($_POST['txtEForm'])?$_POST['txtEForm']: '';
    $comments = isset($_POST['comments'])?$_POST['comments']:'';


    if($action == 'save_eform') {

                $Id = isset($_POST['txtId']) ? $_POST['txtId'] : 0;
                $counter = isset($_POST['txtCounter']) ? $_POST['txtCounter'] : '';
                $eform = isset($_POST['txtEForm']) ? $_POST['txtEForm'] : '';
                $group_id = isset($_POST['ddlGroup']) ? $_POST['ddlGroup'] : 0;
                $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
                $cnic = isset($_POST['txtCNIC']) ? (mysql_real_escape_string($_POST['txtCNIC'])) : '';
                $cust_name = isset($_POST['txtCustomerName']) ? (mysql_real_escape_string($_POST['txtCustomerName'])) : '';
                $cust_rim = isset($_POST['txtCustomerRim']) ? (mysql_real_escape_string($_POST['txtCustomerRim'])) : '';
                $prod_code = isset($_POST['txtProductCode']) ? (mysql_real_escape_string($_POST['txtProductCode'])) : '';
                $prod_categ = isset($_POST['ddlProductCategory']) ? $_POST['ddlProductCategory'] : 0;
                $product_id = isset($_POST['ddlProduct']) ? $_POST['ddlProduct'] : 0;
                $eform_type = isset($_POST['ddlEFormType']) ? $_POST['ddlEFormType'] : 0;
                $priority = isset($_POST['ddlPriority']) ? $_POST['ddlPriority'] : 0;
                $account_no = isset($_POST['txtAccount']) ? $_POST['txtAccount'] : '';
                $card_no = isset($_POST['txtCard']) ? $_POST['txtCard'] : '';
                $source = isset($_POST['ddlSource']) ? $_POST['ddlSource'] : '';
                $po_box = isset($_POST['txtPOBox']) ? $_POST['txtPOBox'] : '';
                $office_addr = isset($_POST['txtOffice']) ? (mysql_real_escape_string($_POST['txtOffice'])) : '';
                $residence_addr = isset($_POST['txtResidence']) ? (mysql_real_escape_string($_POST['txtResidence'])) : '';
                $delievery_addr = isset($_POST['txtDelivery']) ? (mysql_real_escape_string($_POST['txtDelivery'])) : '';
                $alternate_addr = isset($_POST['txtAlternate']) ? (mysql_real_escape_string($_POST['txtAlternate'])) : '';
                $residence_num = isset($_POST['txtResidenceNum']) ? $_POST['txtResidenceNum'] : '';
                $office_num = isset($_POST['txtOfficeNum']) ? $_POST['txtOfficeNum'] : '';
                $mobile_num = isset($_POST['txtMobile']) ? $_POST['txtMobile'] : '';
                $email = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : '';
                $company = isset($_POST['txtCompany']) ? (mysql_real_escape_string($_POST['txtCompany'])) : '';
                $department = isset($_POST['txtDepartment']) ? (mysql_real_escape_string($_POST['txtDepartment'])) : '';
                $emirate = isset($_POST['txtEmirate']) ? (mysql_real_escape_string($_POST['txtEmirate'])) : '';
                $is_email = isset($_POST['rdEmail']) ? $_POST['rdEmail'] : 0;
                $cust_email = isset($_POST['txtCustomerEmail']) ? $_POST['txtCustomerEmail'] : '';
                $is_sms = isset($_POST['rdSMS']) ? $_POST['rdSMS'] : 0;
                $cust_mobile = isset($_POST['txtCustomerMobile']) ? $_POST['txtCustomerMobile'] : '';
                $language = isset($_POST['txtLanguage']) ? (mysql_real_escape_string($_POST['txtLanguage'])) : '';
                $is_call_back = isset($_POST['rdCallBack']) ? $_POST['rdCallBack'] : 0;


                /*echo ($_POST['txtAction']."|".$Id."|".$counter."|".$eform."|".$group_id."|".$userid."|".$cnic."|".$cust_name."|".$cust_rim."|".$prod_code."|".$prod_categ."|"
                     .$product_id."|".$eform_type."|".$priority."|".$account_no."|".$card_no."|".$source."|".$po_box."|".$office_addr."|".$residence_addr."|"
                     .$delievery_addr."|".$alternate_addr."|".$residence_num."|".$office_num."|".$mobile_num."|".$email."|".$company."|"
                     .$department."|".$emirate."|".$is_email."|".$cust_email."|".$is_sms."|".$cust_mobile."|".$language."|".$is_call_back);*/


                //$userid = implode(",", $user_id);

                $response = $objeform->InsertEForm($counter, $group_id, $user_id, $eform, $cnic, $cust_name, $cust_rim, $prod_categ, $product_id, $eform_type, $priority, $account_no, $card_no, $source,
                    $po_box, $office_addr, $residence_addr, $delievery_addr, $alternate_addr, $residence_num, $office_num, $mobile_num, $email, $company, $department, $emirate, $is_email, $cust_email, $is_sms,
                    $cust_mobile, $language, $is_call_back);

                echo $response > 0 ? ("success" . "|" . $response) : "fail";


            }

    elseif($action == 'edit_eform'){
        $group_id               = isset($_POST['group'])?$_POST['group']: '';
        $user_id             = isset($_POST['user'])?$_POST['user']: '';

        echo $response = $objeform->UpdateEForm($Id,$group_id,$user_id);
    }
    elseif($action == 'update_progress'){
        $user_id             = isset($_POST['user'])?$_POST['user']: '';
        $channel             = isset($_POST['channel'])?$_POST['channel']: '';
        $progress            = isset($_POST['progress'])?$_POST['progress']: '';
        $notes               = isset($_POST['notes'])?$_POST['notes']: '';

        echo $objeform->ProgressEForm($login_id,$Id,$channel,$user_id,$progress,$notes);
    }
    elseif($action == 'verification_comment') {
        echo $objeform->VerifiedComments($Id,$comments);
    }






    elseif ($action == 'save') {
        $response = '';
        $userid = implode(",", $user_id);
        $response = $objeform->InsertEForm($counter ,$group_id, $userid, $eform,$prod_categ, $product, $eform_type, $account,$priority, $address, $mobile, $email, $company,$comments,$date_time);
        if($response > 0) {
            $data = $objeform->eform_complains(1, $response);

            $sb = "";
            foreach ($user_id as $user) {
                //echo $user;
                $dataUser = $objUser->GetUsersById($user);
                $to_email = $dataUser[0]['email'];
                $user_name = $dataUser[0]['user_name'];

                $sb .= "Dear $user_name,<br /> <br />";
                $sb .= "A new EForm Complaint has been assigned to you <br /> <br />";

                $sb .= "  <table id='customers22' style='font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif; border-collapse: collapse; width: 100%;'>

                        <thead>
                            <tr>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>EForm ID</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Product</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>EForm Type</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Account No</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Email Address</th>
                                <th style='border: 1px solid #ddd; padding: 8px; background-color: #178acc; color: white;'>Department</th>
                            </tr>
                        </thead>
                        <tbody id='divPayments'>";

                $sb .= "<tr>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['eform_num'] . "</td>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['product'] . "</td>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['eform_type'] . "</td>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['account_no'] . "</td>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['email_address'] . "</td>";
                $sb .= " <td style='text-align:center; border: 1px solid #ddd; padding: 8px;'>" . $data[0]['fullname'] . "</td>";
                $sb .= "</tr>";

                $sb .= "<br /> Regards, <br />";
                $sb .= "FWBL Admin";

                try {
                    $mail = new PHPMailer(true);

                    //$mail->isSMTP();                                      	// Set mailer to use SMTP
                    $mail->Host = '61.5.156.108';                                // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                                    // Enable SMTP authentication
                    $mail->Username = 'Alerts.fwbl@m3tech.com.pk';              // SMTP username
                    $mail->Password = '@L3R*fwb!';                              // SMTP password
                    $mail->SMTPSecure = 'ssl';                                    // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 25;                                            // TCP port to connect to*/
                    $mail->SMTPDebug = 1;

                    //$to_email = "atif.rehman@m3tech.com.pk";
                    //$to_email = "noman.khan330@gmail.com";
                    $cc_emails = "abdullah.qamar@m3tech.com.pk";
                    $subject = "FWBL EForm";
                    $content = "test content123";

                    $mail->setFrom('Alerts.fwbl@m3tech.com.pk', 'FWBL');
                    $mail->addAddress($to_email, $user_name);                    // Add a recipient
                    //$mail->addCC($cc_emails);
                    $mail->isHTML(true);                                        // Set email format to HTML

                    $mail->Subject = $subject;
                    $mail->Body = $sb;

                    if ($mail->send()) {
                        `echo "email send successfully|$current_datetime|$to_email" >> /tmp/email_eform.log`;
                        $result = "success|".$response;
                    } else {
                        `echo "email send failed|$current_datetime|$to_email" >> /tmp/email_eform.log`;
                        $result = "Email Not Send";
                    }
                } catch (phpmailerException $e) {
                    echo $e->errorMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
                $sb = "";
            }
        }
        echo $result;
    }
    /*elseif($action == "edit") {
        $user_id = implode(",", $user_id);
        echo $objeform->UpdateEForm($id ,$department, $user_id, $product, $eform_type, $account,$priority, $address, $mobile, $email, $company);
    }*/
    elseif($action == 'select_eform_type')
    {
        $data = $objeform->GetEFormTypeByProductId($Id);
        $Option = "<option value= '0' disabled selected='selected'>Select E-Form Type</option>";

        foreach($data as $values) {
            $Option .= "<option value =".$values['id'].">".$values["fullname"]."</option>";
        }
        echo $Option;
    }
    /*elseif($action == 'progress') {
        echo $objeform->ProgressEForm($login_id,$id,$progress,$comments);
    }*/
    /*elseif($action == 're-forward') {
        $user_id = implode(",", $user_id);
        echo $objeform->UpdateEFormAgain($id,$department,$user_id);
    }*/
    elseif($action == 'upload'){



        $errors= array();
        $file_counter = 0;
        $dir = "../../uploads_eform_complaint/eform_attachment/";

        if(isset($_FILES['fileupload1']) && $_FILES['fileupload1']['size'] != 0)
        {
            $file_name = $_FILES['fileupload1']['name'];


            $imagename = stripslashes($_FILES['fileupload1']['name']);

            if(is_dir($dir.$eform) == false){
                mkdir($dir.$eform);
            }

            $uploaddir = $dir.$eform."/".$eform."_".$imagename;

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

            if(is_dir($dir.$eform) == false){
                mkdir($dir.$eform);
            }

            $uploaddir = $dir.$eform."/".$eform."_".$imagename;

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

            if(is_dir($dir.$eform) == false){
                mkdir($dir.$eform);
            }

            $uploaddir = $dir.$eform."/".$eform."_".$imagename;

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

            if(is_dir($dir.$eform) == false){
                mkdir($dir.$eform);
            }

            $uploaddir = $dir.$eform."/".$eform."_".$imagename;

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

            if(is_dir($dir.$eform) == false){
                mkdir($dir.$eform);
            }

            $uploaddir = $dir.$eform."/".$eform."_".$imagename;

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

        if(empty($errors))
        {
            $response = $objeform->UpdateComments($comments,$file_counter,$Id);
            echo ("success|".$eform);

        }
        else
        {
            echo ("fail");
        }
    }

}

?>