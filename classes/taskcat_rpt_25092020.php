<?php
class TaskcatReport
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function getDepartment() 
    {
        $query = "SELECT * FROM tbl_groups ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getDepartmentById($id) 
    {
        $query = '';

        if($id != '')
        {
          $query .= "SELECT * FROM tbl_groups WHERE id = '$id' ORDER BY id ASC";
        }
        else
        {
          $query .= "SELECT * FROM tbl_groups ORDER BY id ASC";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    /*function getIsmByDepartmentId($id)
    {
        $query = '';

        if($id != '')
        {
          $query .= "SELECT * FROM tbl_task_isam WHERE department_id = '$id' ORDER BY id ASC";
        }
        else
        {
          $query .= "SELECT * FROM tbl_task_isam ORDER BY id ASC";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }*/

    function getIsmByDepartmentId($id,$duration,$month,$quarter,$year)
    {
        $query = "";
        $data  = "";

        if($id != '')
        {
            $data .= "AND ism.department_id = '$id'";
        }

        if($duration != '')
        {
            if($month != '')
            {
                $start_month  = $month.'-01';
                $end_month    = $month.'-31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_month' AND '$end_month'";
            }

            $quarter_num  = substr($quarter,5,2);
            $quarter_year = substr($quarter,0,4);

            if($quarter != '' AND $quarter_num == '01')
            {
                $start_date = $quarter_year.'-01-'.'01';
                $end_date   = $quarter_year.'-03-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '02')
            {
                $start_date = $quarter_year.'-04-'.'01';
                $end_date   = $quarter_year.'-06-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '03')
            {
                $start_date = $quarter_year.'-07-'.'01';
                $end_date   = $quarter_year.'-09-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '04')
            {
                $start_date = $quarter_year.'-10-'.'01';
                $end_date   = $quarter_year.'-12-'.'31';

                $data    .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($year != '')
            {
                $data .= " AND YEAR(tnew.task_update_date) = '$year'";
            }
        }

        $query .= "SELECT ism.*, 
                          subcat.fullname AS subcat_name, 
                          wat.priority AS weightage 
                    FROM tbl_task_isam ism 
                        LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id 
                        LEFT JOIN tbl_priority wat ON wat.id = ism.priority 
                        LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id 
                    WHERE ism.is_major = '1' AND tnew.parent_task_id = '0' $data 
                        GROUP BY ism.id 
                        ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskRating($ism_id,$duration,$month,$quarter,$year,$department_id)
    {
        $query  = "";
        $data   = "";

        if($duration != '')
        {
            if($month != '')
            {
                $start_month  = $month.'-01';
                $end_month    = $month.'-31';

                $data .= " AND DATE(task_update_date) BETWEEN '$start_month' AND '$end_month'";
            }

            $quarter_num  = substr($quarter,5,2);
            $quarter_year = substr($quarter,0,4);

            if($quarter != '' AND $quarter_num == '01')
            {
                $start_date = $quarter_year.'-01-'.'01';
                $end_date   = $quarter_year.'-03-'.'31';

                $data .= " AND DATE(task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '02')
            {
                $start_date = $quarter_year.'-04-'.'01';
                $end_date   = $quarter_year.'-06-'.'31';

                $data .= " AND DATE(task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '03')
            {
                $start_date = $quarter_year.'-07-'.'01';
                $end_date   = $quarter_year.'-09-'.'31';

                $data .= " AND DATE(task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '04')
            {
                $start_date = $quarter_year.'-10-'.'01';
                $end_date   = $quarter_year.'-12-'.'31';

                $data    .= " AND DATE(task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($year != '')
            {
                $data .= " AND YEAR(task_update_date) = '$year'";
            }
        }

        $query = "SELECT
                    (SELECT COUNT(1) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND group_id = '$department_id' AND task_update_date <= task_end_datetime AND parent_task_id = '0' $data) AS task_within_tat,
                    (SELECT COUNT(1) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND group_id = '$department_id' AND parent_task_id = '0' $data) AS total_service_request,
                    (SELECT COUNT(1) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND group_id = '$department_id' AND parent_task_id = '0' $data) AS total_closed_service";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getScoreCurrentMonth($group_id, $month)
    {
        if($month != '')
        {
            $start_month  = $month.'-01';
            $end_month    = $month.'-31';

            $data .= "AND DATE(tnew.task_update_date) BETWEEN '$start_month' AND '$end_month'";
        }

        $query =    "SELECT 
                        COUNT(1) AS total_ism_where_task_closed 
                    FROM tbl_task_new tnew 
                        LEFT JOIN tbl_task_isam ism ON tnew.task_ism = ism.id 
                    WHERE 
                        tnew.group_id = '$group_id' AND 
                        tnew.task_status_id = '3' AND 
                        ism.is_major = '1' $data
                    GROUP BY tnew.task_ism";
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getIsmdetails($id,$duration,$month,$quarter,$year)
    {
        $query  = "";
        $data   = "";

        if($id != '')
        {
            $data .= "AND ism.department_id = '$id'";
        }

        if($duration != '')
        {
            if($month != '')
            {
                $start_month  = $month.'-01';
                $end_month    = $month.'-31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_month' AND '$end_month'";
            }

            $quarter_num  = substr($quarter,5,2);
            $quarter_year = substr($quarter,0,4);

            if($quarter != '' AND $quarter_num == '01')
            {
                $start_date = $quarter_year.'-01-'.'01';
                $end_date   = $quarter_year.'-03-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '02')
            {
                $start_date = $quarter_year.'-04-'.'01';
                $end_date   = $quarter_year.'-06-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '03')
            {
                $start_date = $quarter_year.'-07-'.'01';
                $end_date   = $quarter_year.'-09-'.'31';

                $data .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter != '' AND $quarter_num == '04')
            {
                $start_date = $quarter_year.'-10-'.'01';
                $end_date   = $quarter_year.'-12-'.'31';

                $data    .= " AND DATE(tnew.task_update_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($year != '')
            {
                $data .= " AND YEAR(tnew.task_update_date) = '$year'";
            }
        }

        //$query .= "SELECT ism.*,subcat.fullname AS subcat_name, ow.fullname AS ownership_name, wat.priority AS weightage, tnew.task_end_datetime AS task_end_datetime FROM tbl_task_isam ism LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id LEFT JOIN tbl_task_ownership ow ON ow.id = ism.ownership LEFT JOIN tbl_priority wat ON wat.id = ism.priority LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE ism.is_major = '1' $data GROUP BY ism.id ORDER BY ism.id ASC";

        $query .= "SELECT ism.*, subcat.fullname AS subcat_name, wat.priority AS weightage, tnew.task_end_datetime AS task_end_datetime FROM tbl_task_isam ism LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id LEFT JOIN tbl_priority wat ON wat.id = ism.priority LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE 1=1 $data GROUP BY ism.id ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskCounts($ism_id)
    {
        /*$query = "SELECT
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id IN ('1','2','5','6','7') AND DATE(task_start_datetime) < DATE(NOW()) AND task_ism = '$ism_id') AS BF,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id = '1' AND DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS Incoming,
                    (SELECT SUM(BF) + SUM(Incoming)) AS Total,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id = '3' AND DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS Done";*/

        $query = "SELECT
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id IN ('1','2','5','6','7') AND DATE(task_start_datetime) < DATE(NOW()) AND task_ism = '$ism_id') AS BF,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS Incoming,
                    (SELECT SUM(BF) + SUM(Incoming)) AS Total,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id = '3' AND DATE(task_update_date) = DATE(NOW()) AND task_ism = '$ism_id') AS TodayCompleted,
                    (SELECT COUNT(Total - TodayCompleted) FROM tbl_task_new WHERE DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS CF";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskAging($ism_id)
    {
        $query = "SELECT ism.*, DATE(tnew.task_end_datetime) AS task_end_datetime, DATE(tnew.task_update_date) AS task_update_date FROM tbl_task_isam ism LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE ism.id = '$ism_id' AND tnew.parent_task_id = '0' AND tnew.task_status_id IN ('1','2','5','6','7') GROUP BY ism.id ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskDiff($ism_id)
    {
        $query = "SELECT 
                    (CASE
                        WHEN DATEDIFF(DATE(NOW()), DATE(task_start_datetime)) = 1 THEN 1
                        WHEN DATEDIFF(DATE(NOW()), DATE(task_start_datetime)) = 2 THEN 2
                        WHEN DATEDIFF(DATE(NOW()), DATE(task_start_datetime)) = 3 THEN 3
                        WHEN DATEDIFF(DATE(NOW()), DATE(task_start_datetime)) >= 4 THEN 4
                        WHEN SUBSTR(DATEDIFF(DATE(NOW()), DATE(task_start_datetime)),1,1) = '-' THEN '-'
                        WHEN SUBSTR(DATEDIFF(DATE(NOW()), DATE(task_start_datetime)),1,1) = '0' THEN '0'
                    END) AS DiffInDays, COUNT(*) AS RowCounts
                    FROM tbl_task_new WHERE parent_task_id = '0' AND task_status_id IN (1,2,5,6,7) AND task_ism = '$ism_id' GROUP BY DiffInDays";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function saveIsmWiseResultDetails($ism_sub_cat_id,$ism_id,$tat,$avg_mint_activity,$bf,$incomming,$total,$today_completed,$pending_cf,$main_hours,$day1,$day2,$day3,$day4,$log_datetime)
    {
        $query = "INSERT INTO rpt_task_ism_wise (ism_sub_cat_id,ism_id,tat,avg_mint_activity,bf,incomming,total,today_completed,cf,main_hours,day_1,day_2,day_3,day_4_above,log_datetime) VALUES ('$ism_sub_cat_id','$ism_id','$tat','$avg_mint_activity','$bf','$incomming','$total','$today_completed','$pending_cf','$main_hours','$day1','$day2','$day3','$day4','$log_datetime')";

        //return $query;
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function getIsmWiseResultDetails($log_datetime)
    {
        $data   = "";

        if($log_datetime != '')
        {
            $data .= "AND DATE(log_datetime) = '$log_datetime'";
        }

        $query = "SELECT * FROM rpt_task_ism_wise WHERE 1=1 $data ORDER By id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getCFDetails($ism_sub_cat_id,$ism_id,$last_date)
    {
        $query = "SELECT * FROM rpt_task_ism_wise WHERE ism_sub_cat_id = '$ism_sub_cat_id' AND ism_id = '$ism_id' AND DATE(log_datetime) = '$last_date' ORDER BY id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getBFDetails($ism_sub_cat_id,$ism_id,$incomming_status,$present_date)
    {
        $query = "SELECT 
                      COUNT(1) AS bf
                    FROM
                      tbl_task_new 
                    WHERE task_subcat = '$ism_sub_cat_id' 
                      AND task_ism = '$ism_id' 
                      AND DATE(task_create_date) <= '$present_date'
                      AND task_status_id IN ($incomming_status)";

        //return $query;
        return $this->mysqli_lib->query_execute($query);
    }

    function getTodayTask($ism_sub_cat_id,$ism_id,$present_date,$task_status)
    {
        //$query = "SELECT COUNT(*) AS task_counts FROM tbl_task_new WHERE task_ism_desc = '$ism_type' AND task_ism = '$ism_id' AND DATE(task_create_date) = '$present_date' AND task_status_id IN ($task_status) AND parent_task_id = '0' ORDER BY task_id ASC";
        $query = "SELECT COUNT(1) AS task_counts FROM tbl_task_new WHERE task_subcat = '$ism_sub_cat_id' AND task_ism = '$ism_id' AND DATE(task_create_date) = '$present_date'";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTodayCompletedTask($ism_sub_cat_id,$ism_id,$present_date,$task_status)
    {
        $query = "SELECT COUNT(1) AS task_counts FROM tbl_task_new WHERE task_subcat = '$ism_sub_cat_id' AND task_ism = '$ism_id' AND DATE(task_update_date) = '$present_date' AND task_status_id IN ($task_status)";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getIsmId($ism_code)
    {
        $query = "SELECT * FROM tbl_task_isam WHERE fullname = '$ism_code' LIMIT 1";
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getSubCatName($ism_sub_cat_id,$ism_id)
    {
        $query = "SELECT ism.*, subcat.fullname AS subcat_name FROM tbl_task_isam ism LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id WHERE ism.id = '$ism_id' AND ism.sub_cat_id = '$ism_sub_cat_id' GROUP BY ism.id ORDER BY ism.id ASC";
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }
}
