<?php
    ini_set('max_execution_time', 10000);

    include('/var/www/html/igicrm/includes/config.php');
    include('/var/www/html/igicrm/classes/taskcat_rpt.php');
    
    //error_reporting(E_ERROR);
    //ini_set('display_errors', -1);

    //include('../includes/config.php');
    //include('../classes/taskcat_rpt.php');

    $objTaskcatReport = new TaskcatReport();
    //$isms             = $objTaskcatReport->getIsmdetails('','','','','');
    $isms               = $objTaskcatReport->getIsmdetailsNew();

    //echo $isms;die;

    foreach($isms as $ism)
    {
        //print_r($ism['id'] . "<br>");

        $log_datetime      = Date('Y-m-d h:i');
        //$log_datetime      = '2020-09-01 15:41';

        $ism_id            = $ism['id'];                    // ISM ID
        $ism_sub_cat_id    = $ism['sub_cat_id'];            // SubCat ID
        $tat               = $ism['tat'];
        $avg_mint_activity = $ism['minutes_activity'];

        $last_date        = DATE('Y-m-d', strtotime("-1 day"));
        $present_date     = DATE('Y-m-d');
        $incomming_status = "1,2,4,5,6,7";
        $completed_status = "3";

        //$present_date     = '2020-09-27';
        //$last_date        = '2020-09-27';

        /* For B/F as Yesterday's C/F truns Today's B/F */
        $getBFDetails = $objTaskcatReport->GetBFDetailDateWise_test($ism_sub_cat_id,$ism_id,$incomming_status,$present_date,$last_date);
      
        `echo "$date|$ism_sub_cat_id|$ism_id|$incomming_status|$present_date|$last_date" >> /tmp/log_cron_set_daily_tasks.log`;
        
    }
    echo "Success";
    //$date = Date('Y-m-d h:i:s');
    //echo $result;
    #`echo "$date | $getBFDetails" >> /tmp/log_cron_set_daily_tasks.log`;
?>
