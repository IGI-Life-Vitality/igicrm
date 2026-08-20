<?php
      include('/var/www/html/igicrm/includes/config.php');
     include('/var/www/html/igicrm/classes/taskcat_rpt.php');
    
    //error_reporting(E_ERROR);
    //ini_set('display_errors', -1);

    //include('../includes/config.php');
    //include('../classes/taskcat_rpt.php');

    $objTaskcatReport = new TaskcatReport();
    //$isms             = $objTaskcatReport->getIsmdetails('','','','','');

    $enddate            = $objTaskcatReport->getnintyseventytenddate();

    //echo $isms;die;

    foreach($enddate as $endtm)
    {

        $task_end_time      = $endtm['task_end_datetime'];              // ISM ID
        $task_start_time    = $endtm['task_start_datetime'];            // SubCat ID
        $task_id            = $endtm['task_id']; 


        $task_cat           = $endtm['task_cat'];              // ISM ID
        $task_subcat        = $endtm['task_subcat'];            // SubCat ID
        $task_ism           = $endtm['task_ism'];
        $st = explode(' ',$task_start_time);
        $create_date = $st[0];

        $result = $objTaskcatReport->GetIsmDetail($task_ism);
        $tat  = $result['tat']; 
        //$last_date        = DATE('Y-m-d', strtotime("$tat day"));
        $last_date        = date('Y-m-d', strtotime( $create_date . " $tat Weekday"));
        //echo $task_start_time."|".$result['tat']."|".$last_date;
        

        $st = explode(' ',$task_start_time);
        $et = explode(' ',$task_end_time);

        $final_time = $last_date." ".$et[1];

        echo "start time ".$task_start_time ."old end time->".$task_end_time."new end time->".$final_time."<br>";

        
        $result = $objTaskcatReport->SetEndTime($final_time,$task_id);
        
    }
    //echo "Success";
    //$date = Date('Y-m-d h:i:s');
    //echo $result;
    //`echo "$date | $getBFDetails" >> /tmp/log_cron_set_daily_tasks.log`;
?>

