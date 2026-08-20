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

        $query .= "SELECT ism.*,subcat.fullname AS subcat_name, wat.priority AS weightage FROM tbl_task_isam ism LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id LEFT JOIN tbl_priority wat ON wat.id = ism.priority LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE ism.is_major = '1' $data GROUP BY ism.id ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskRating($ism_id)
    {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND task_update_date <= task_end_datetime) AS task_within_tat,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id') AS total_service_request,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3') AS total_closed_service,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_create_date >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) AND task_create_date <= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY) ) AS created_last_month,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND task_update_date <= task_end_datetime AND task_create_date >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 2 MONTH)), INTERVAL 1 DAY) AND task_create_date <= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 1 MONTH)), INTERVAL 1 DAY) ) AS score_last_month,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND MONTH(task_create_date) = MONTH(CURDATE())) AS created_current_month,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_ism = '$ism_id' AND task_status_id = '3' AND task_update_date <= task_end_datetime AND MONTH(task_create_date) = MONTH(CURDATE())) AS score_current_month";
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

        $query .= "SELECT ism.*,subcat.fullname AS subcat_name, ow.fullname AS ownership_name, wat.priority AS weightage, tnew.task_end_datetime AS task_end_datetime FROM tbl_task_isam ism LEFT JOIN tbl_task_subcategory subcat ON subcat.id = ism.sub_cat_id LEFT JOIN tbl_task_ownership ow ON ow.id = ism.ownership LEFT JOIN tbl_priority wat ON wat.id = ism.priority LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE ism.is_major = '1' $data GROUP BY ism.id ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskCounts($ism_id)
    {
        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id IN ('1','2','5','6','7') AND DATE(task_start_datetime) < DATE(NOW()) AND task_ism = '$ism_id') AS BF,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id = '1' AND DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS Incoming,
                    (SELECT SUM(BF) + SUM(Incoming)) AS Total,
                    (SELECT COUNT(*) FROM tbl_task_new WHERE task_status_id = '3' AND DATE(task_start_datetime) = DATE(NOW()) AND task_ism = '$ism_id') AS Done";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskAging($ism_id)
    {
        $query  = "";
        $query .= "SELECT ism.*, DATE(tnew.task_end_datetime) AS task_end_datetime, DATE(tnew.task_update_date) AS task_update_date FROM tbl_task_isam ism LEFT JOIN tbl_task_new tnew ON tnew.task_ism = ism.id WHERE ism.id = '$ism_id' AND tnew.parent_task_id = '0' AND tnew.task_status_id IN ('1','2','5','6','7') GROUP BY ism.id ORDER BY ism.id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getTaskDiff($ism_id)
    {
        $query  = "";
        $query .= "SELECT 
                        COUNT(*) AS COUNTS,
                        (CASE
                            WHEN DATEDIFF(DATE(NOW()), DATE(task_end_datetime)) = 1 THEN 1
                            WHEN DATEDIFF(DATE(NOW()), DATE(task_end_datetime)) = 2 THEN 2
                            WHEN DATEDIFF(DATE(NOW()), DATE(task_end_datetime)) = 3 THEN 3
                            WHEN DATEDIFF(DATE(NOW()), DATE(task_end_datetime)) >= 4 THEN 4
                            WHEN SUBSTR(DATEDIFF(DATE(NOW()), DATE(task_end_datetime)),1,1) = '-' THEN '-'
                            WHEN SUBSTR(DATEDIFF(DATE(NOW()), DATE(task_end_datetime)),1,1) = '0' THEN '0'
                        END) AS DiffInDays
                        FROM tbl_task_new 
                    WHERE parent_task_id = '0' AND task_status_id IN ('1','2','5','6','7') AND task_ism = '$ism_id'
                        GROUP BY task_ism 
                        ORDER BY task_id ASC";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }
}