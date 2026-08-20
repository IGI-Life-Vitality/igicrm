<?php

$end_datetime = $this->GetEndDate($task_categ,$sub_cat_id,$task_ism_id);


function GetEndDate($task_categ,$sub_cat_id,$task_ism_id){
        $query = "SELECT tat FROM tbl_task_isam WHERE id = '$task_ism_id' AND task_category_id = '$task_categ' AND sub_cat_id = '$sub_cat_id' AND isactive = 1;";
        $data = $this->mysqli_lib->fetch_all($query);
        $tat = $data[0]['tat'];
        $end_date = date('Y-m-d' ,strtotime("+$tat hours"));
        return $this->EndDate($end_date);
    }

?>