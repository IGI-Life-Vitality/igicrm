<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$output = "";
$date = date('Y-m-d H:i:s');

if(isset($_REQUEST)){

    $action     = isset($_REQUEST['action'])?$_REQUEST['action']:'';
    $user_id    = isset($_REQUEST['email'])?$_REQUEST['email']:'';
    $email      = isset($_REQUEST['email'])?$_REQUEST['email']:'';
    $password   = isset($_REQUEST['password'])?$_REQUEST['password']:'';
    $oldpassword   = isset($_REQUEST['oldpassword'])?$_REQUEST['oldpassword']:'';

    $password = MD5($password);
    $oldpassword = MD5($oldpassword);
    $is_attampt ="";

    if($action == 'login'){

        $exists = $objUser->GetDbUser($email);

        if(!empty($exists)){

            if($exists['isactive'] == 0){
                $output = "user deactive";
                $encode = array( "Status" => $output , "Date" => $date);
                echo $return = json_encode($encode);
                `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/CRM.log`;
                exit;
            }
            if($exists['isactive'] > 3){
                $output = "user block";
                $encode = array( "Status" => $output , "Date" => $date);
                echo $return = json_encode($encode);
                `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/CRM.log`;
                exit;
            }

            $checkuser = $objUser->GetCheckUser($email,$password);

            if(!empty($checkuser)){

                $is_expire = $objUser->GetCheckUserExpiry($email,$password);

                if(!empty($is_expire))
                {
                    if($checkuser['isactive'] > 3){
                        $output = "user block";
                        $encode = array( "Status" => $output , "Date" => $date);
                        echo $return = json_encode($encode);
                        `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/CRM.log`;
                        exit;
                    }
                    $_SESSION['user_name']   = $checkuser['first_name']." ".$checkuser['last_name'];
                    $_SESSION['login_id']    = $checkuser['id'];
                    $_SESSION['user_id']     = $checkuser['user_name'];
                    $_SESSION['user_type']   = $checkuser['user_type'];
                    $_SESSION['group_id']    = $checkuser['group_id'];
                    $_SESSION['product_id']  = $checkuser['product_id'];
                    $_SESSION['email']       =  $checkuser['email'];
                    $_SESSION['is_login']  = 1;
                    $updateUser = $objUser->UpdateUserlogin($email,1);
                    $output = "success";
                    `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/CRM.log`;
                }
                else
                {
                    $output = "expired";
                }
            }else{
                 $isactive = $exists['isactive'] + 1;
                 $updateUser = $objUser->UpdateUserlogin($email,$isactive);
                 $output = "fail password";
            }
        }
        else{
            $output = "fail_exists";
        }
        `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/Api.log`;
        $encode = array( "Status" => $output , "Date" => $date);
        echo $return = json_encode($encode);
         //echo $output;
     }else if($action == 'CreateUser'){

            $first_name     = isset($_REQUEST['FirstName'])?$_REQUEST['FirstName']:'';
            $last_name      = isset($_REQUEST['LastName'])?$_REQUEST['LastName']:'';
            $user_type      = 3;
            $user_id        = $first_name. " " .$last_name;
            $employee_id    = "";
            $mobile         = "";
            $location       = "";
            $group_id       = 11;
            $is_active      = 1;
            $expaiy         = '2020-05-30';
            $medium         = 0;
            
            $response = $objUser->AddUsers($first_name,$last_name,$user_type,$user_id,$email,$password,$employee_id,$mobile,$location,$group_id,$expaiy,$is_active,$medium);

            $result = explode('|',$response);
            if($result[0] > 0 && $group_id != 0){
                 $data = $objUser->AddAgentsToGroup($result[0],$group_id);
            }
            `echo "$result[1]|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/Api.log`;
            $encode = array( "Status" => $result[1] , "Date" => $date);
            echo $return = json_encode($encode);
     }
     else if($action == 'NewPassword'){
        
        $data = $objUser->UpdateAgentsPassword($email,$password);
        `echo "$data|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/Api.log`;
        $encode = array( "Status" => $data , "Date" => $date);
        echo $return = json_encode($encode);
     }

     else if($action == 'Logout'){
        `echo "Logout|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/Api.log`;
        session_start();
        $_SESSION['is_login'] = 0;
         session_unset();
        // This will destroy the session variables
         session_destroy();
        $encode = array( "Status" => 'success' , "Date" => $date);
        echo $return = json_encode($encode);
     }else if($action == 'ChangePassword'){
         $email = $_SESSION['email'];
         $checkuser = $objUser->GetCheckUser($email,$oldpassword);
             if(!empty($checkuser)){
              $data = $objUser->UpdateAgentsPassword($email,$password);
             }else{
               $data = "wrong_old_password";
             }
         
        `echo "$output|$email|$password|$date|\r\n" >> /var/www/html/igicrm/logs/CRM.log`;
        echo $data;
     }

}
?>