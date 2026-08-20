<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$login_id = $_SESSION['login_id'];
$user_type = $_SESSION['user_type'];

if(isset($_POST)) {

    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if($action == 'get_notification'){

        $data = $objUser->GetNotification($login_id,$user_type);
        $counts = !empty($data) ? count($data) : 0;

        $sb = "";
        $sb .= "        <li class='dropdown-header'>Notifications ($counts)</li>";



        foreach($data as $row){

            $complaint_id = $row['complaint_eform_id'];
            $user_id = $row['user_id'];
            $date_ago = $row['date_ago'];

            if($row['type'] == 'complaint'){

                if($user_type == 1){
                    $url = "complaint_details.php?id=$complaint_id";
                }else if($user_type == 3){
                    $url = "complaint_details_department.php?id=$complaint_id";
                }

                $message = "New Complaint Logged from $user_id";
            }else if($row['type'] == 'eform'){
                $url = "eform_user_details_.php?id=$complaint_id";
                $message = "New Eform assign to $user_id";
            }

            $sb .= "        <li class='media'>
                            <a href='$url'>
                                <div class='media-left'><i class='ion-ios-plus-empty media-object bg-blue'></i></div>
                                <div class='media-body'>
                                    <h6 class='media-heading'> $message </h6>
                                    <div class='text-muted f-s-11'>$date_ago</div>
                                </div>
                            </a>
                        </li>";
        }

        echo $counts."|".$sb;
    }

}
?>