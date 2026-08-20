<?php

class User
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;
    }

    function DateTimeToString($datetime)
    {
        $date = date_create($datetime);
        return date_format($date, "m/d/Y");
    }

    function GetLogin($action, $userid, $pass)
    {

        if ($action == 'login') {
            $query = "SELECT * FROM tbl_users WHERE user_name = '" . $userid . "' AND user_pass = '" . $pass . "' AND isactive = 1;";
            $getLogin = $this->mysqli_lib->query_execute($query);
            //return $query;

            if (!empty($getLogin)) {

                $query_update = "UPDATE tbl_users SET last_login = NOW() WHERE user_name = '" . $userid . "' AND user_pass = '" . $pass . "' AND isactive = 1;";
                $this->mysqli_lib->update($query_update);
                return $getLogin;
            } else {
                return "";
            }
        }
    }

    function GetResponserProduct($id)
    {

        if ($id == 0)
            $query = "SELECT * FROM tbl_product WHERE isactive = 1 AND id NOT IN (1,2);";
        else
            $query = "SELECT * FROM tbl_product WHERE id = '$id' AND isactive = 1 AND id NOT IN (1,2);";

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddDepartment($fullname, $email, $isactive)
    {
        $query = "INSERT INTO tbl_department (fullname, email, isactive) VALUES ('$fullname', '$email', '$isactive')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateDepartment($id, $fullname, $email, $isactive)
    {
        $query = "UPDATE tbl_department SET fullname = '$fullname', email = '$email', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        //return $response > 0 ? "success" : "fail";
        return "success";
    }

    function GetDeparments($id)
    {

        if ($id == 0)
            $query = "SELECT * FROM tbl_department WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_department WHERE id = '$id' AND isactive = 1;";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetResponserDeparment($id)
    {

        if ($id == 0)
            $query = "SELECT * FROM tbl_department WHERE isactive = 1 AND id NOT IN (1,2);";
        else
            $query = "SELECT * FROM tbl_department WHERE id = '$id' AND isactive = 1 AND id NOT IN (1,2);";

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddUsers($first_name, $last_name, $user_type, $user_id, $email, $password, $employee_id, $mobile, $location, $group_id, $date_time, $is_active, $medium)
    {
        $query = "SELECT id,email FROM tbl_users WHERE email = '$email'";
        $data = $this->mysqli_lib->fetch_all($query);

        if (!empty($data))
            return 0 . "|" . "email already exists";
        else {
            $first_name = ucwords($first_name);
            if ($medium == 1) {
                if ($group_id != 0)
                    $group_id  = implode(",", $group_id);
            }
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));

            $query = "INSERT INTO tbl_users (first_name,last_name,user_type,user_name,email,user_pass,employee_id,mobile_no,
			                              location_id,group_id,isactive,create_datetime,expiry_datetime,last_login,product_id)
                  VALUES ('$first_name','$last_name','$user_type','$user_id','$email','$password','$employee_id','$mobile','$location','$group_id','$is_active',NOW(),'$date_time', '0000-00-00 00:00:00','0');";

            $response = $this->mysqli_lib->insert($query);

            return $response . "|" . "success";
        }
    }

    function UpdateUsers($id, $first_name, $last_name, $user_id, $user_type, $email, $password, $mobile, $location, $date_time, $group_id, $is_active)
    {
        $firstname = ucwords($first_name);
        $group_id  = implode(",", $group_id);
        $date_time = date("Y-m-d H:i:s", strtotime($date_time));

        if ($password != '') {
            $password = MD5($password);
            $update_pass = ",user_pass = '$password'";
        } else {
            $update_pass = '';
        }

        $query = "UPDATE tbl_users SET first_name = '$firstname', last_name = '$last_name', user_type = '$user_type', mobile_no = '$mobile', location_id = '$location', expiry_datetime = '$date_time', group_id = '$group_id', isactive = '$is_active', user_name = '$user_id' $update_pass WHERE id = '$id'";
        //return $query;
        $this->mysqli_lib->update($query);
        return "success";
    }

    function AddUsersToGroup($response, $group_id)
    {
        $query = "INSERT INTO tbl_users_group (user_id, group_id) VALUES ";

        foreach ($group_id as $groupid) {
            $query .= "('" . $response . "', '" . $groupid . "'),";
        }

        $query = rtrim($query, ",");
        $result = $this->mysqli_lib->insert($query);
        return $result > 0 ? "success" : "fail";
    }

    function DeleteUsersFromGroup($user_id)
    {
        $query = "DELETE FROM `tbl_users_group` WHERE user_id = '$user_id'";
        $this->mysqli_lib->delete($query);
        return "success";
    }

    function GetUsers($id)
    {
        if ($id == 0)
            $query = "SELECT * FROM tbl_users WHERE user_type != '1' ORDER BY Id";
        else
            $query = "SELECT * FROM tbl_users WHERE Id = '$id' AND user_type != '1';";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUsersByGroupID($id)
    {
        $query = "SELECT * FROM tbl_users WHERE FIND_IN_SET('$id', group_id) AND isactive = 1 AND id NOT IN ('1','3') ORDER BY Id";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUsersByGroupsId($id)
    {
        $query = "SELECT * FROM tbl_users WHERE FIND_IN_SET('$id', group_id) AND isactive = 1 AND user_type NOT IN ('1','3')  ORDER BY Id";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUsersByGroups($id)
    {
        $login_id = $_SESSION['login_id'];
        $query = "SELECT * FROM tbl_users WHERE FIND_IN_SET('$id', group_id) AND isactive = 1 AND id != '$login_id' AND user_type NOT IN ('1','3')  ORDER BY Id";
        return $this->mysqli_lib->fetch_all($query);
    }

    function checkUser()
    {
        // if the session id is not set, redirect to login page
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        // the user want to logout
        if (isset($_GET['logOut'])) {

            doLogout();
        }
    }

    function DeleteDepartment($id)
    {
        $query = "DELETE FROM tbl_department WHERE id = '$id';";
        $this->mysqli_lib->delete($query);
    }

    function DeleteUsers($id)
    {
        $query = "DELETE FROM tbl_users WHERE id = '$id';";
        $this->mysqli_lib->delete($query);
    }

    function GetUsersById($id)
    {
        $query = "SELECT * FROM tbl_users WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUserNameById($id)
    {
        $ids = explode(',', $id);
        $response = "";

        for ($a = 0; $a < count($ids); $a++) {
            $query_getuser = "SELECT user_name from tbl_users where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getuser);

            $response .= $result[0]['user_name'] . ",";
        }

        $len = strlen($response);
        $response = substr($response, 0, $len - 1);
        return $response;
    }

    function doLogout()
    {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }
        if (isset($_SESSION['user_name'])) {
            unset($_SESSION['user_name']);
        }
        if (isset($_SESSION['user_type'])) {
            unset($_SESSION['user_type']);
        }

        header('Location: login.php');
        exit;
    }

    function SaveNotification($complaint_eform_id, $type)
    {
        $datetime = date('Y-m-d H:i:s');
        $query = "INSERT INTO `tbl_notifications` (`complaint_eform_id`, `type`, `update_datetime`) VALUES ('$complaint_eform_id', '$type', '$datetime'); ";
        return $response = $this->mysqli_lib->insert($query);
    }

    function GetNotification($user_id, $user_type)
    {
        $query = "SELECT n.*,c.complaint_counter,e.eform_num, u.user_id,

                  CASE
                    WHEN TIMESTAMPDIFF(MINUTE,update_datetime,NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE,update_datetime,NOW()),' minutes ago')
                    WHEN TIMESTAMPDIFF(MINUTE,update_datetime,NOW()) >= 60 AND TIMESTAMPDIFF(HOUR,update_datetime,NOW()) <= 24 THEN CONCAT(TIMESTAMPDIFF(HOUR,update_datetime,NOW()),' hour ago')
                    WHEN TIMESTAMPDIFF(HOUR,update_datetime,NOW()) >= 24 THEN CONCAT(TIMESTAMPDIFF(DAY,update_datetime,NOW()),' day ago')
                  END AS date_ago

                  FROM tbl_notifications n
                  LEFT JOIN tbl_complaints c ON n.complaint_eform_id = c.complaint_id
                  LEFT JOIN tbl_eform_add e ON n.complaint_eform_id = e.id
                  LEFT JOIN tbl_users u ON u.id = c.agent_id
                  WHERE 1=1 ";

        if ($user_type == '3') {
            $query .= " AND n.user_is_read = 0 AND FIND_IN_SET('$user_id', c.user_id)";
        } else if ($user_type == '1') {
            $query .= " AND n.admin_is_read = 0";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUserType($id = 0, $isactive = 1)
    {
        $query = "SELECT * FROM tbl_users_type WHERE isactive = '$isactive' AND id != 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetLocation($id = 0, $isactive = 1)
    {

        $query = "SELECT * FROM `tbl_location` WHERE isactive = '$isactive'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetGroups($id = 0, $isall = 1)
    {
        if ($id == 0) {
            if ($isall == 1)
                $query = "SELECT *FROM tbl_groups ORDER BY primary_name";
            else
                $query = "SELECT *FROM tbl_groups WHERE isactive = '1' ORDER BY primary_name";
        } else {
            $query = "SELECT *FROM tbl_groups WHERE id = '$id'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetPermissions($moduleid, $permission)
    {
        $group_id = $_SESSION['group_id'];

        $query = "SELECT `$permission` FROM `tbl_groups_permissions` WHERE group_id IN ($group_id) AND module_id = '$moduleid'";
        $data = $this->mysqli_lib->fetch_all($query);
        //return $data[0][$permission];
        // return $query;
        return $data;
    }

    function GetSpecificGroups($id, $group_id)
    {
        if ($id == 0)
            $query = "SELECT * FROM tbl_groups WHERE id NOT IN ($group_id) AND isactive = 1";
        else if ($id == 1)
            $query = "SELECT * FROM tbl_groups WHERE id IN ($group_id)";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetSpecificUsers($id, $user_id)
    {
        if ($id == 0)
            $query = "SELECT * FROM tbl_users WHERE id NOT IN ($user_id) AND isactive = 1 AND id != '1'";
        else if ($id == 1)
            $query = "SELECT * FROM tbl_users WHERE id IN ($user_id)";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUserById($id)
    {

        $ids = explode(',', $id);
        $response = "";
        for ($a = 0; $a < count($ids); $a++) {

            $query_getuser = "SELECT user_name from tbl_users where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getuser);

            $response .= $result[0]['primary_name'] . ",";
        }
        $len = strlen($response);
        $response = substr($response, 0, $len - 1);
        return $response;
    }

    function GetDbUser($email)
    {
        $query = "SELECT isactive FROM tbl_users WHERE email = '" . $email . "'";
        $checkusr = $this->mysqli_lib->query_execute($query);
        if (!empty($checkusr)) {

            return $checkusr;
        } else {
            return "";
        }
    }

    function UpdateUserlogin($email, $isactive)
    {
        $query_update = "UPDATE tbl_users SET last_login = NOW(),isactive = '$isactive' WHERE email = '" . $email . "'";
        $this->mysqli_lib->update($query_update);
    }

    function UserBlock($email, $isactive)
    {
        $query_update = "UPDATE tbl_users SET last_login = NOW(),isactive = '$isactive' WHERE email = '" . $email . "'";
        $this->mysqli_lib->update($query_update);
    }

    function GetInactiveUsers()
    {
        $query = "SELECT user_name,isactive,id,last_login FROM tbl_users WHERE isactive != '1'";
        $getinactiveuser = $this->mysqli_lib->fetch_all($query);

        if (!empty($getinactiveuser)) {
            return $getinactiveuser;
        } else {
            return "";
        }
    }

    function GetBlockedUsers()
    {
        $query = "SELECT user_name,isactive,id,last_login FROM tbl_users WHERE isactive = '4'";
        $getblockeduser = $this->mysqli_lib->fetch_all($query);

        if (!empty($getblockeduser)) {
            return $getblockeduser;
        } else {
            return "";
        }
    }

    function UpdateInactiveUser($userid, $isactive)
    {
        $query_update = "UPDATE tbl_users SET isactive = '$isactive' WHERE id = '" . $userid . "'";
        $this->mysqli_lib->update($query_update);
    }


    function GetCheckUser($email, $pass)
    {
        $query = "SELECT * FROM tbl_users WHERE email = '" . $email . "' AND user_pass = '" . $pass . "'";
        $getcheckuser = $this->mysqli_lib->query_execute($query);
        //return $query;

        if (!empty($getcheckuser)) {

            return $getcheckuser;
        } else {
            return "";
        }
    }
    function GetCheckUserExpiry($email, $pass)
    {

        $query = "SELECT * FROM tbl_users WHERE email = '" . $email . "' AND user_pass = '" . $pass . "' AND expiry_datetime > NOW()";
        $getuser = $this->mysqli_lib->query_execute($query);
        //return $query;

        if (!empty($getuser)) {
            return $getuser;
        } else {
            return 0;
        }
    }

    function GetMsgUser($userid)
    {

        $query = "SELECT user_name FROM tbl_users WHERE id = '" . $userid . "'";
        $getmsgkuser = $this->mysqli_lib->query_execute($query);

        return  $getmsgkuser['user_name'];
    }
    function GetUserDetail($userid)
    {

        $query = "SELECT * FROM tbl_users WHERE id = '" . $userid . "'";
        $getuserdetails = $this->mysqli_lib->query_execute($query);
        return $getuserdetails;
    }
    function GetUserByGrpID($id)
    {
        $query = "SELECT * FROM tbl_users WHERE group_id like '%$id%' AND isactive = 1";
        return $this->mysqli_lib->fetch_all($query);
    }
    function GetSalesUsers($group_id)
    {
        if ($id == 1)
            $query = "SELECT * FROM tbl_users";
        else
            //$query = "SELECT * FROM tbl_users WHERE group_id LIKE '%$group_id%'";
            $query = "SELECT * FROM tbl_users WHERE FIND_IN_SET('$group_id',group_id) and user_type ='4'";
        return $this->mysqli_lib->fetch_all($query);
    }


    function AddAgentsToGroup($response, $group_id)
    {
        $query = "INSERT INTO tbl_users_group (user_id, group_id) VALUES ('" . $response . "', '" . $group_id . "')";
        $result = $this->mysqli_lib->insert($query);

        return $result > 0 ? "success" : "fail";
    }

    function UpdateAgentsPassword($email, $password)
    {
        $query = "Update tbl_users SET user_pass = '$password' where email ='$email'";
        $result = $this->mysqli_lib->update($query);
        if ($result) {
            return "success";
        } else {
            return "fail";
        }
    }
}
