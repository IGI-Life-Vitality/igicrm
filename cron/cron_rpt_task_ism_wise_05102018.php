<?php
    include('/var/www/html/igicrm/includes/config.php');
    include('/var/www/html/igicrm/classes/taskcat_rpt.php');

    $objTaskcatReport = new TaskcatReport();
    $isms             = $objTaskcatReport->getIsmdetails('','','','','');

    foreach($isms as $ism)
    {
        $log_datetime   = Date('Y-m-d h:i');
        $ISM_id         = $ism['id']; 
        $task           = $objTaskcatReport->getTaskCounts($ISM_id);
        $TaskDiff       = $objTaskcatReport->getTaskDiff($ISM_id);

        $ism_type           = $ism['subcat_name'];
        $ism_code           = $ism['fullname'];
        $tat                = $ism['tat'];
        $avg_mint_activity  = $ism['minutes_activity'];
        $bf                 = $task[0]['BF'] + $task[0]['BF_Closed'];
        $incomming          = $task[0]['Incoming'];
        $total              = $task[0]['Total'] + $task[0]['BF_Closed'];
        $today_completed    = $task[0]['Done'] + $task[0]['BF_Closed'];
        $pending_cf         = $task[0]['Total'] - $task[0]['Done'];

        $main_hours         = $task[0]['Done'] + $task[0]['BF_Closed'];
        $main_hours         = ($avg_mint_activity * $main_hours) / 60;
        $main_hours         = number_format($main_hours,2);

        $day1 = ($TaskDiff[0]['DiffInDays'] == 1 ? $TaskDiff[0]['COUNTS'] : "-");
        $day2 = ($TaskDiff[0]['DiffInDays'] == 2 ? $TaskDiff[0]['COUNTS'] : "-");
        $day3 = ($TaskDiff[0]['DiffInDays'] == 3 ? $TaskDiff[0]['COUNTS'] : "-");
        $day4 = ($TaskDiff[0]['DiffInDays'] == 4 ? $TaskDiff[0]['COUNTS'] : "-");

        $result = $objTaskcatReport->saveIsmWiseResultDetails($ism_type,$ism_code,$tat,$avg_mint_activity,$bf,$incomming,$total,$today_completed,$pending_cf,$main_hours,$day1,$day2,$day3,$day4,$log_datetime);
    }

    $date = Date('Y-m-d h:i:s');
    echo $result;
    `echo "$date | $result" >> /tmp/log_cron_rpt_task_ism_wise.log`;
?>
