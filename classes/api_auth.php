<?php
class ApiAuth
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function authLogin($username, $password)
    {
        $query = "SELECT is_active from tbl_users_app WHERE username = '$username' and is_active = 1";
        $response = $this->mysqli_lib->fetch_all($query);
        
        if ($response[0]['is_active'] == 1) {
            $password = MD5($password);
            $query = "SELECT token from tbl_users_app WHERE username = '$username' and password = '$password'";
            $response = $this->mysqli_lib->fetch_all($query);
            
            if ($response[0]['token']) {
                $response = array("status" => 1, "description" => 'Success', "token" => $response[0]['token']);
                return $response;
            } else {
                $response = array("status" => 0, "description" => 'Username or Password incorrect');
                return $response;
            }
        } else {
            $response = array("status" => 0, "description" => 'Auth user is not activated');
            return $response;
        }
    }
    function validateToken($token)
    {
            $query = "SELECT token from tbl_users_app WHERE token = '$token'";
            $response = $this->mysqli_lib->fetch_all($query);
            
            if ($response[0]['token']) {
                return true;
            } else {
                return false;
            }
    }
}
