<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'calendar.php');

$objcal = new Calendar();

if(isset($_POST)) {

    $id             = isset($_POST['id']) ? $_POST['id'] : 0;
    $effective_from = isset($_POST['effective_from']) ? $_POST['effective_from'] : '';
    $effective_to   = isset($_POST['effective_to']) ? $_POST['effective_to'] : '';
    $start_hours    = isset($_POST['start_hours']) ? $_POST['start_hours'] : '';
    $start_mins     = isset($_POST['start_mins']) ? $_POST['start_mins'] : '';
    $start_sec      = isset($_POST['start_sec']) ? $_POST['start_sec'] : '';
    $end_hours      = isset($_POST['end_hours']) ? $_POST['end_hours'] : '';
    $end_mins       = isset($_POST['end_mins']) ? $_POST['end_mins'] : '';
    $end_sec        = isset($_POST['end_sec']) ? $_POST['end_sec'] : '';
    $weekDay        = isset($_POST['week_day']) ? $_POST['week_day'] : '';
    $is_repeat      = isset($_POST['is_repeat']) ? $_POST['is_repeat'] : 0;
    $event_name        = isset($_POST['event_name']) ? $_POST['event_name'] : '';

    if (isset($_POST['action'])) {
        $action         = isset($_POST['action']) ? $_POST['action'] : '';


        if($action == 'save'){
            $data = $objcal->AddDailyHours($effective_from,$effective_to,$start_hours,$start_mins,$start_sec,$end_hours,$end_mins,$end_sec);
            echo ($data."|Record Saved Successfully!");
        }
        elseif($action == 'edit'){
            $data = $objcal->UpdateDailyHours($id,$effective_from,$effective_to,$start_hours,$start_mins,$start_sec,$end_hours,$end_mins,$end_sec);
            echo ($data."|Record updated Successfully!");
        }
        elseif($action == 'daily_hours_data') {
            $data = $objcal->GetDailyHours($id);
            $effective_from = $data[0]['effective_from'];
            $effective_to =   $data[0]['effective_to'];
            $StartTimeFormat = explode(",",$data[0]['start_time']);
            $start_hours = $StartTimeFormat[0];
            $start_mins = $StartTimeFormat[1];
            $start_sec = $StartTimeFormat[2];
            $EndTimeFormat = explode(",",$data[0]['end_time']);
            $end_hours = $EndTimeFormat[0];
            $end_mins = $EndTimeFormat[1];
            $end_sec = $EndTimeFormat[2];

            echo ("success|".$effective_from."|".$effective_to."|".$start_hours."|".$start_mins."|".$start_sec."|".$end_hours."|".$end_mins."|".$end_sec);

        }
        elseif($action == 'saveweekend') {
            $data = $objcal->AddWeekEnds($effective_from,$effective_to,$weekDay);
            echo ($data."|Record Saved Successfully!");
        }
        elseif($action == 'editweekend'){
            $data = $objcal->UpdateWeekEnds($id,$effective_from,$effective_to,$weekDay);
            echo ($data."|Record Updated Successfully!");
        }
        elseif($action == 'weekend_data') {
            $data = $objcal->GetWeekEnds($id);
            $effective_from = $data[0]['effective_from'];
            $effective_to = $data[0]['effective_to'];
            $weekDay = $data[0]['week_day'];

            echo ("success|".$effective_from."|".$effective_to."|".$weekDay);
        }
        elseif($action == 'saveholidays') {
            $data = $objcal->AddHolidays($event_name,$effective_from,$effective_to,$is_repeat);
            echo ($data."|Record Saved Successfully!");
        }
        elseif($action == 'editholidays') {
            $data = $objcal->UpdateHolidays($id,$event_name,$effective_from,$effective_to,$is_repeat);
            echo ($data."|Record Updated Successfully!");
        }
        elseif($action == 'holidays_data'){
            $data = $objcal->GetHolidays($id);
            $event_name = $data[0]['event_name'];
            $effective_from = $data[0]['from_date'];
            $effective_to = $data[0]['to_date'];
            $is_repeat = $data[0]['is_repeat'];
            echo ("success|".$effective_from."|".$effective_to."|".$is_repeat."|".$event_name);
        }

    }
}

?>