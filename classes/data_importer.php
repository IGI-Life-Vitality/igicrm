<?php
class DataImporter
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function clearBaseTable($target_table)
    {        
        $query = "TRUNCATE TABLE $target_table";
        $response = $this->mysqli_lib->insert($query);
        return $response;
    }

    // Not using
    public function saveData($table_name,$FLD0,$FLD1,$FLD2,$FLD3,$FLD4,$FLD5,$FLD6,$FLD7,$FLD8,$FLD9,$FLD10,$FLD11,$FLD12,$FLD13,$FLD14,$FLD15,$FLD16,$FLD17,$FLD18,$FLD19,$FLD20,$FLD21,$FLD22,$FLD23,$FLD24,$FLD25,$FLD26,$FLD27,$FLD28,$FLD29,$FLD30,$FLD31,$FLD32,$FLD33,$FLD34)
    {
        $query = "INSERT INTO $table_name (Company_Code,Policy_Number,Certificate_Number,Status_Policy_Description,Policy_Premium_Mode,Issue_Date,DOB,Modal_Premium,Insure_Name,Owner_Name,Payor_Name,Address1,Address2,City,Phone_Number,Mobile_Number,Fax_Number,Face_Amount,Agent_Name,Agent_Status,CNIC,Basic_Rider_Premium,Line_Of_Business,Next_Premium_Due_Date,Total_Premium_Paid,Plan_Code,Plan_Name,Email_Address,System_Name,FLD30,FLD31,FLD32,FLD33,FLD34,FLD35) VALUES ('$FLD0','$FLD1','$FLD2','$FLD3','$FLD4','$FLD5','$FLD6','$FLD7','$FLD8','$FLD9','$FLD10','$FLD11','$FLD12','$FLD13','$FLD14','$FLD15','$FLD16','$FLD17','$FLD18','$FLD19','$FLD20','$FLD21','$FLD22','$FLD23','$FLD24','$FLD25','$FLD26','$FLD27','$FLD28','$FLD29','$FLD30','$FLD31','$FLD32','$FLD33','$FLD34')";
        //print_r($query);die;
        
        $this->mysqli_lib->insert($query);
    }

    public function checkDataInM3T($m3t_table)
    {
        $query = "SELECT COUNT(*) AS M3T FROM $m3t_table";
        //print_r($query);die;
        
        return $this->mysqli_lib->fetch_all($query);
    }

    public function checkDataInIGI($igi_table)
    {
        $query = "SELECT COUNT(*) AS IGI FROM $igi_table";
        //print_r($query);die;
        
        return $this->mysqli_lib->fetch_all($query);
    }

    public function copyData($igi_table, $m3t_table)
    {
        $query = "INSERT INTO $m3t_table SELECT * FROM $igi_table";
        //print_r($query);die;
        
        $this->mysqli_lib->insert($query);
    }
}