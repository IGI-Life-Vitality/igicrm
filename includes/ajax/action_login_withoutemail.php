<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$output = "";

if(isset($_POST)){

    $action    = isset($_POST['action'])?$_POST['action']:'';
    $user_id   = isset($_POST['user_id'])?$_POST['user_id']:'';
    $password  = isset($_POST['password'])?$_POST['password']:'';
    $is_attampt ="";

    if (isset($_POST['action'])) {

        $exists = $objUser->GetDbUser($user_id);

        if(!empty($exists)){

            if($exists['isactive'] == 0){
                echo $output = "user deactive";
                exit;
            }
            if($exists['isactive'] > 3){
                echo $output = "user block";
                exit;
            }

            $checkuser = $objUser->GetCheckUser($user_id,$password);

            if(!empty($checkuser)){

                $is_expire = $objUser->GetCheckUserExpiry($checkuser["user_name"],$checkuser["user_pass"]);

                if(!empty($is_expire))
                {
                    if($checkuser['isactive'] > 3){
                        echo $output = "user block";
                        exit;
                    }
                    $_SESSION['user_name'] = $checkuser['first_name']." ".$checkuser['last_name'];
                    $_SESSION['login_id']  = $checkuser['id'];
                    $_SESSION['user_id']   = $checkuser;
                    $_SESSION['user_type'] = $checkuser['user_type'];
                    $_SESSION['group_id']  = $checkuser['group_id'];
                    $_SESSION['is_login']  = 1;
                    $updateUser = $objUser->UpdateUserlogin($user_id,1);
                    $output = "success";
                }
                else
                {
                    $output = "expired";
                }
            }else{
                 $isactive = $exists['isactive'] + 1;
                 $updateUser = $objUser->UpdateUserlogin($user_id,$isactive);
                 $output = "fail password";
            }
        }
        else{
            $output = "fail_exists";
        }
         echo $output;
    }

}
?>