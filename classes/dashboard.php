<?php
class Dashboard
{
    private $mysqli_lib;

    function __construct()
    {
      global $obj_mysql;
      $this->mysqli_lib = $obj_mysql;
    }

    function GetNews($id,$user_type)
    {
      if($user_type==1){
           $query ="SELECT * from tbl_news order by create_date  DESC ";
           $result = $this->mysqli_lib->fetch_all($query);
           return $result;
      }else{
      $ids= explode(',',$id);
      $response ="";
      $query_getnews ="";

      for($a=0;$a<count($ids);$a++)
      {
        $query_getnews .= "SELECT * from tbl_news where recipient like '%$ids[$a]%' UNION ";
      }

      $len = strlen($query_getnews);
      $query  = substr($query_getnews,0,$len-6);
      $query .=" order by create_date  DESC ";
      $result = $this->mysqli_lib->fetch_all($query);
      return $result;
     }
    }

    function GetMessage($id)
    {
        $ids= explode(',',$id);
        $response ="";
        $query_getmessage ="";

        for($a=0;$a<count($ids);$a++)
        {
          $query_getmessage .= "SELECT * from tbl_messages where recipient like '%$ids[$a]%' UNION ";
        }

        $len = strlen($query_getmessage);
        $query  = substr($query_getmessage,0,$len-6);
        $query .=" order by create_date  DESC ";
        $result = $this->mysqli_lib->fetch_all($query);
        return $result;
    }

    function dashbord_complains($login_id,$user_type,$group_id)
    {
        if($user_type == 1)
        {
          $query = "SELECT
                        (SELECT COUNT(1) FROM `vw_get_complaint`) AS total_complaints,
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE status_id = 3) AS closed_complaints,
                        (SELECT COUNT(1) FROM `tbl_task_new`) AS total_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id != 3) AS assigned_task";
        }
        elseif($user_type == 3)
        {
          $query = "SELECT
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE agent_id = '$login_id'  OR FIND_IN_SET('$login_id', user_id)) AS total_complaints,
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE status_id = 3 AND agent_id = '$login_id') AS closed_complaints,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_assignee = '$login_id') AS total_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id = 3 AND task_assignee = '$login_id') AS closed_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id IN (1,2) AND task_assigned_to = '$login_id') AS assigned_task";
        }
        elseif($user_type == 4)
        {
          $query = "SELECT
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE FIND_IN_SET('$login_id', user_id) OR FIND_IN_SET('$login_id', agent_id)) AS total_complaints,
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE status_id = 3 AND FIND_IN_SET('$login_id', user_id)) AS closed_complaints,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_assignee = '$login_id' OR task_assigned_to = '$login_id') AS total_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id = 3 AND task_assignee = '$login_id') AS closed_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id IN (1,2) AND task_assigned_to = '$login_id') AS assigned_task";
        }
        else
        {
            $query = "SELECT
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE group_id IN ($group_id)) AS total_complaints,
                        (SELECT COUNT(1) FROM `vw_get_complaint` WHERE status_id = 3 and  group_id IN ($group_id)) AS closed_complaints,
                        (SELECT
                              COUNT(1)
                            FROM tbl_task_new t
                              INNER JOIN tbl_users us
                                ON us.id = t.task_assignee
                              INNER JOIN tbl_users usr
                                ON usr.id = t.task_assigned_to
                              INNER JOIN tbl_users usrs
                                ON usrs.id = t.task_assigned_to
                            WHERE us.group_id IN ($group_id)
                            ORDER BY t.task_id DESC) AS total_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id = 3 AND group_id IN ($group_id)) AS closed_task,
                        (SELECT COUNT(1) FROM `tbl_task_new` WHERE task_status_id != '3' AND task_assigned_to = '$login_id') AS assigned_task";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetDateFormate($date )
    {
           $dayOfWeek = date("l, M d, Y h:i a", strtotime($date));
           $dt = $dayOfWeek;
           return $dt;
    }
    
    function dashbord_leads($login_id,$user_type,$group_id,$product_id)
    {
        /* $query = "SELECT
                        (SELECT COUNT(1) FROM `tbl_leads`) AS total_leads,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 4) AS leads_matured,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 3) AS leads_pending,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 6 OR lead_status_id = 5) AS leads_inquery";*/
   
        if($user_type == 1)
        {
          $query = "SELECT
                        (SELECT COUNT(1) FROM `tbl_leads`) AS total_leads,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 4) AS leads_matured,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 3) AS leads_pending,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 6 OR lead_status_id = 5) AS leads_inquery";
        }
        elseif($user_type == 3)
        {
          $query = "SELECT
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE agent_id = '$login_id'  OR lead_assigned_to = '$login_id') AS total_leads,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 4 AND agent_id = '$login_id' OR lead_assigned_to = '$login_id') AS leads_matured,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 3 AND agent_id = '$login_id'  OR lead_assigned_to = '$login_id') AS leads_pending,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 6 OR lead_status_id = 5 AND  agent_id = '$login_id'  OR lead_assigned_to = '$login_id') AS leads_inquery";
        }
        elseif($user_type == 4)
        {
            $query = "SELECT
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_assigned_to = '$login_id'  OR lead_assignee = '$login_id') AS total_leads,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 4 AND lead_assigned_to = '$login_id') AS leads_matured,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 3 AND lead_assigned_to = '$login_id') AS leads_pending,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 6 OR lead_status_id = 5 AND lead_assigned_to = '$login_id') AS leads_inquery";
        }
        else
        {
            $query = "SELECT
                        (SELECT COUNT(1) FROM `tbl_leads` where product IN ($product_id)) AS total_leads,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 4) AS leads_matured,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 3) AS leads_pending,
                        (SELECT COUNT(1) FROM `tbl_leads` WHERE lead_status_id = 6 OR lead_status_id = 5) AS leads_inquery";
        }
        
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

}
?>