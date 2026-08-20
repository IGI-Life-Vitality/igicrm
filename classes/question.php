<?php

class Question {

    private $mysqli_lib;

    function __construct(){

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }

    function AddCreateSet($fullname,$hierarchy, $isactive){
        $query = "INSERT INTO tbl_questions_set (fullname, hierarchy , isactive) VALUES ('$fullname', '$hierarchy', '$isactive')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function GetCreateSet($id){

        if($id == 0)
            $query = "SELECT * FROM tbl_questions_set WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_questions_set WHERE id = '$id'";

        return $this->mysqli_lib->fetch_all($query);
    }

    function UpdateCreateSet($id, $fullname, $hierarchy, $isactive)
    {
        $query = "UPDATE tbl_questions_set SET fullname = '$fullname', hierarchy = '$hierarchy' , isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        //return $response > 0 ? "success" : "fail";
        return "success";
    }

    function SetName_Type($id)
    {
        if ($id == 0) {
            $query = "SELECT * FROM tbl_questions_set WHERE isactive = 1";
            return $this->mysqli_lib->fetch_all($query);
        } else {
            $query = "SELECT * FROM tbl_questions_set WHERE id = $id";
            $dataSetName = $this->mysqli_lib->fetch_all($query);
            return $dataSetName[0]["fullname"];
        }

    }

    function GetQuestion($id){

        if($id == 0)
            $query = "SELECT * FROM tbl_questions WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_questions WHERE id = '$id'";

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddQuestion($id, $question, $set_id, $is_active)
    {
        $query = "INSERT INTO tbl_questions (id, question, set_id, created_datetime, update_datetime, isactive)
                  VALUES ('$id', '$question', '$set_id', NOW(), '0000-00-00 00:00:00', '$is_active');";

        $response = $this->mysqli_lib->insert($query);

        //print_r($query);
        return $response > 0 ? "success" : "fail";

    }

    function UpdateQuestion($id, $question, $set_id, $is_active)
    {
        $query = "UPDATE tbl_questions SET question = '$question', set_id = '$set_id', update_datetime = Now(), isactive = '$is_active' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        //return $response > 0 ? "success" : "fail";
        //return $query;
        return "success";
    }

    function GetCreateSetAll()
    {
        $query = "SELECT * FROM tbl_questions_set";
        return $this->mysqli_lib->fetch_all($query);
    }
}

?>