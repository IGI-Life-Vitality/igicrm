<?php

class Email
{

    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
        include('templates.php');
    }

    function AddEmail($user_id, $toemail , $ccemail, $subject, $content, $folder, $files, $type){

        $datetime = date('Y-m-d H:i:s');

        $query = "INSERT INTO tbl_emails (user_id, toemail , ccemail, subject, content, folder, files, type, datetime)
                  VALUES ('$user_id', '$toemail', '$ccemail', '$subject', '$content', '$folder', '$files', '$type', '$datetime')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function AddEmailTemplate($user_id, $toemail , $ccemail, $main_folder, $sub_folder, $files, $template_id){

        $datetime = date('Y-m-d H:i:s');
        $objTemp = new Templates();
        $data = $objTemp->GetTemplateById($template_id);

        $response = 0;

        if(!empty($data)){

            $subject = $data[0]["template_subject"];
            $content = $data[0]["template_detail"];
            $content = addslashes($content);

           $query = "INSERT INTO tbl_emails (user_id, toemail , ccemail, subject, content, main_folder, sub_folder, files, is_template, datetime)
                     VALUES ('$user_id', '$toemail', '$ccemail', '$subject', '$content', '$main_folder', '$sub_folder', '$files', '1', '$datetime')";
            $response = $this->mysqli_lib->insert($query);
        }

        return $response > 0 ? "success" : "fail";
    }

    function GetEmails($type = ''){

        $query = "SELECT * FROM tbl_emails WHERE 1=1";

        if($type != ''){
            $query .= " AND type = '$type'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function DeleteEmails($type = ''){

    }
}

?>