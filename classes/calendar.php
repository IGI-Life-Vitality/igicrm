<?php

class Calendar
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }

    function AddDailyHours($effective_from,$effective_to,$start_hours,$start_mins,$start_sec,$end_hours,$end_mins,$end_sec){

        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);
        $start_time = ($start_hours.":".$start_mins.":".$start_sec);
        $start_time = $this->StringToTime($start_time);
        $end_time = ($end_hours.":".$end_mins.":".$end_sec);
        $end_time = $this->StringToTime($end_time);

        $query = "INSERT INTO tbl_calendar_daily_hours(effective_from,effective_to,start_time,end_time,created_on,updated_on)
                  VALUES ('$effective_from','$effective_to','$start_time','$end_time',NOW(),'0000-00-00 00:00:00')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateDailyHours($id,$effective_from,$effective_to,$start_hours,$start_mins,$start_sec,$end_hours,$end_mins,$end_sec)
    {
        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);
        $start_time = ($start_hours.":".$start_mins.":".$start_sec);
        $start_time = $this->StringToTime($start_time);
        $end_time = ($end_hours.":".$end_mins.":".$end_sec);
        $end_time = $this->StringToTime($end_time);

        $query = "UPDATE tbl_calendar_daily_hours SET effective_from = '$effective_from', effective_to = '$effective_to', start_time = '$start_time', end_time = '$end_time', updated_on = NOW() WHERE id = '$id'";

        $this->mysqli_lib->update($query);

        return "success";
    }

    function GetDailyHours($id=0){

        if($id==0){
            $query = "SELECT id, DATE_FORMAT(effective_from, '%M %d, %Y') AS effective_from,
                             DATE_FORMAT(effective_to, '%M %d, %Y') AS effective_to,
                             start_time, end_time FROM tbl_calendar_daily_hours";
        }else{
            $query = "SELECT id, DATE_FORMAT(effective_from, '%m/%d/%Y') AS effective_from,
                             DATE_FORMAT(effective_to, '%m/%d/%Y') AS effective_to,
                             DATE_FORMAT(start_time, '%H,%i,%s') AS start_time,
                             DATE_FORMAT(end_time, '%H,%i,%s') AS end_time
                             FROM tbl_calendar_daily_hours WHERE id = '$id'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddWeekEnds($effective_from,$effective_to,$WeekDay)
    {
        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);

        $query = "INSERT INTO tbl_calendar_weekends (effective_from,effective_to,week_day,created_on,updated_on)
                  VALUES ('$effective_from','$effective_to','$WeekDay',NOW(),'0000-00-00 00:00:00')";

        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateWeekEnds($id,$effective_from,$effective_to,$WeekDay){

        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);

        $query = "UPDATE tbl_calendar_weekends SET effective_from = '$effective_from', effective_to = '$effective_to', week_day = '$WeekDay', updated_on = NOW() WHERE id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetWeekEnds($id=0){

        if($id==0){
            $query = "SELECT id, DATE_FORMAT(effective_from, '%M %d, %Y') AS effective_from,
                             DATE_FORMAT(effective_to, '%M %d, %Y') AS effective_to,
                             week_day FROM tbl_calendar_weekends";
        }else{
            $query = "SELECT id, DATE_FORMAT(effective_from, '%m/%d/%Y') AS effective_from,
                             DATE_FORMAT(effective_to, '%m/%d/%Y') AS effective_to,
                             week_day FROM tbl_calendar_weekends WHERE id = '$id'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddHolidays($event_name,$effective_from,$effective_to,$is_repeat)
    {
        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);

        $query = "INSERT INTO tbl_calendar_holidays (event_name,from_date,to_date,is_repeat) VALUES('$event_name','$effective_from','$effective_to','$is_repeat')";

        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateHolidays($id,$event_name,$effective_from,$effective_to,$is_repeat){

        $effective_from = $this->StringToDate($effective_from);
        $effective_to = $this->StringToDate($effective_to);

        $query = "UPDATE tbl_calendar_holidays SET event_name = '$event_name', from_date = '$effective_from', to_date = '$effective_to', is_repeat = '$is_repeat' WHERE id = '$id'";

        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetHolidays($id=0)
    {
        if($id==0){
            $query = "SELECT id,event_name, DATE_FORMAT(from_date, '%M %d, %Y') AS from_date,
                             DATE_FORMAT(to_date, '%M %d, %Y') AS to_date,
                             is_repeat FROM tbl_calendar_holidays";
        }else{
            $query = "SELECT id, event_name,DATE_FORMAT(from_date, '%m/%d/%Y') AS from_date,
                             DATE_FORMAT(to_date, '%m/%d/%Y') AS to_date,
                             is_repeat FROM tbl_calendar_holidays WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function DateToString($datetime){
        $date = date_create($datetime);
        return date_format($date,"m/d/y");
    }

    function StringToDate($datetime){
        return date("Y-m-d", strtotime($datetime));
    }

    function TimeToString($time){
        $formats = array('H','i','s');
        $result = array();
        $Time = date_create($time);
        foreach($formats as $format){
            $result[] = date_format($Time,$format);
        }
        return $result;
    }

    function StringToTime($time){
        return date("H:i:s", strtotime($time));
    }

}

?>