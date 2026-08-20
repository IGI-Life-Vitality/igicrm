<?php
    include('/var/www/html/igicrm/includes/config.php');
    include('/var/www/html/igicrm/classes/taskcat_rpt.php');

    /*include('../includes/config.php');
    include('../classes/taskcat_rpt.php');*/

    $objTaskcatReport = new TaskcatReport();
    $isms             = $objTaskcatReport->getIsmdetails('','','','','');

    foreach($isms as $ism)
    {
        $log_datetime   = Date('Y-m-d h:i');
        $ISM_id         = $ism['id']; 
        $task           = $objTaskcatReport->getTaskCounts($ISM_id);
        $TaskDiff       = $objTaskcatReport->getTaskDiff($ISM_id);

        $ism_sub_cat_id     = $ism['sub_cat_id'];   //SubCat ID
        $ism_id             = $ism['id'];           //ISM ID
        $tat                = $ism['tat'];
        $avg_mint_activity  = $ism['minutes_activity'];
        $incomming          = $task[0]['Incoming'];
        $total              = $task[0]['Total'];
        $today_completed    = $task[0]['TodayCompleted'];
        $pending_cf         = $task[0]['Total'] - $task[0]['TodayCompleted'];
        $bf                 = $task[0]['BF'];
        $last_date          = DATE('Y-m-d', strtotime("-1 day"));

        $getCFDetails       = $objTaskcatReport->getCFDetails($ism_sub_cat_id,$ism_id,$last_date);
        $bf                 = $getCFDetails[0]['cf'];
        
        $main_hours         = ($avg_mint_activity * $today_completed) / 60;
        $main_hours         = number_format($main_hours,2);

        foreach($TaskDiffs as $TaskDiff)
        {
            $day1 = ($TaskDiff['DiffInDays'] == 1 ? $TaskDiff['RowCounts'] : "-");
            $day2 = ($TaskDiff['DiffInDays'] == 2 ? $TaskDiff['RowCounts'] : "-");
            $day3 = ($TaskDiff['DiffInDays'] == 3 ? $TaskDiff['RowCounts'] : "-");
            $day4 = ($TaskDiff['DiffInDays'] == 4 ? $TaskDiff['RowCounts'] : "-");
        }

        $result = $objTaskcatReport->saveIsmWiseResultDetails($ism_sub_cat_id,$ism_id,$tat,$avg_mint_activity,$bf,$incomming,$total,$today_completed,$pending_cf,$main_hours,$day1,$day2,$day3,$day4,$log_datetime);

        unset($day1);
        unset($day2);
        unset($day3);
        unset($day4);
    }

    $date = Date('Y-m-d h:i:s');
    echo $result;
    `echo "$date | $result" >> /tmp/log_cron_rpt_task_ism_wise.log`;
?>
