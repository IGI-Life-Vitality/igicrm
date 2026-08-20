<?php
    include('/var/www/html/igicrm/includes/config.php');
    include('/var/www/html/igicrm/classes/taskcat_rpt.php');

    // include('../includes/config.php');
    // include('../classes/taskcat_rpt.php');

    $objTaskcatReport = new TaskcatReport();
    $isms             = $objTaskcatReport->getIsmdetails('','','','','');

    foreach($isms as $ism)
    {
        //print_r($ism['id'] . "<br>");

        $log_datetime       = Date('Y-m-d H:i');
	//$log_datetime       = '2020-09-04 11:51';
		
        $ism_id             = $ism['id'];               //ISM ID
        $ism_sub_cat_id     = $ism['sub_cat_id'];       //SubCat ID
        $tat                = $ism['tat'];
        $avg_mint_activity  = $ism['minutes_activity'];

        $last_date        = DATE('Y-m-d', strtotime("-1 day"));
        $present_date     = DATE('Y-m-d');
        $incomming_status = "1,2,4,5,6";
        $completed_status = "3";
		
	//$present_date     = '2020-09-04';

        /* For B/F as Yesterday's C/F truns Today's B/F */
        $getBFDetails = $objTaskcatReport->getCFDetails($ism_sub_cat_id,$ism_id,$last_date);
        //$getBFDetails = $objTaskcatReport->getBFDetails($ism_sub_cat_id,$ism_id,$incomming_status,$present_date);
        $bf           = $getBFDetails[0]['cf'];

        if($bf == "" || $bf == NULL || $bf == null)
        {
            $bf = "0";
        }
        else
        {
            $bf = $bf;
        }
        //print_r($getCFDetails . "<br>");

        /* For Today Incomming */
        $getTodayIncommingTask = $objTaskcatReport->getTodayTask($ism_sub_cat_id,$ism_id,$present_date,$incomming_status);
        $incomming             = $getTodayIncommingTask[0]['task_counts'];

        if($incomming == "" || $incomming == NULL || $incomming == null)
        {
            $incomming = "0";
        }
        else
        {
            $incomming = $incomming;
        }
        //print_r($getTodayIncommingTask . "<br>");

        /* For Today Total */
        $total = $bf + $incomming;

        /* For Today Completed */
        $getTodayCompletedTask = $objTaskcatReport->getTodayCompletedTask($ism_sub_cat_id,$ism_id,$present_date,$completed_status);
        $today_completed       = $getTodayCompletedTask[0]['task_counts'];
        //print_r($getTodayCompletedTask . "<br>");

        /* For Today C/F */
        $pending_cf = $total - $today_completed;

        /* For Main Hours */
        $main_hours = ($avg_mint_activity * $today_completed) / 60;
        $main_hours = number_format($main_hours,2);

        $TaskDiffs = $objTaskcatReport->getTaskDiff($ism_id);
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
