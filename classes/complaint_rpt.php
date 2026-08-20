<?php
class ComplaintReport
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

    function getComplaintType() 
    {
        $query = "SELECT * FROM tbl_complaint_type ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getSource() 
    {
        $query = "SELECT * FROM tbl_source ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getStatus() 
    {
        $query = "SELECT * FROM tbl_status ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getMonthFromDB()
    {
        $query = "SELECT * FROM tbl_filter_month ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getMonthFromDBById($id)
    {
        $query = "SELECT * FROM tbl_filter_month WHERE month_value = '$id' LIMIT 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getQuarterFromDB()
    {
        $query = "SELECT * FROM tbl_filter_quarter ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getQuarterFromDBById($id)
    {
        $query = "SELECT * FROM tbl_filter_quarter WHERE quarter_value = '$id' LIMIT 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getYearFromDB()
    {
        $query = "SELECT * FROM tbl_filter_year ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getForumFromDB()
    {
        $query = "SELECT * FROM tbl_forum_list ORDER BY id ASC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getForumFromDBById($id)
    {
        $query = '';

        if($id != '')
        {
          $query .= "SELECT * FROM tbl_forum_list WHERE id = '$id' ORDER BY id ASC";
        }
        else
        {
          $query .= "SELECT * FROM tbl_forum_list ORDER BY id ASC";
        }
        
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

    function getComplaintTypeById($id) 
    {
        $query = "SELECT * FROM tbl_complaint_type WHERE id = '$id' ORDER BY id DESC";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getComplaintTypeByGroupId($group_id)
    {
        $query = '';

        if($group_id != '')
        {
          $query .= "SELECT * FROM tbl_complaint_type WHERE group_id = '$group_id'";
        }
        else
        {
          $query .= "SELECT * FROM tbl_complaint_type";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function getComplaintTypeByForumId($forum_id)
    {
        $query = '';

        if($forum_id != '')
        {
            $query .= "SELECT 
                          cmpleg.*,
                          cmplegdet.*,
                          cmptype.fullname AS dept_type
                        FROM
                          tbl_complaints_legal cmpleg 
                          LEFT JOIN tbl_complaint_details_legal cmplegdet ON cmpleg.complaint_id = cmplegdet.complaint_id
                          LEFT JOIN tbl_complaint_type cmptype ON cmptype.id = cmpleg.complaint_type_id  
                        WHERE cmplegdet.forum_id = '$forum_id'";
        }
        else
        {
            $query .= "SELECT 
                          cmpleg.*,
                          cmplegdet.*,
                          cmptype.fullname AS dept_type
                        FROM
                          tbl_complaints_legal cmpleg 
                          LEFT JOIN tbl_complaint_details_legal cmplegdet ON cmpleg.complaint_id = cmplegdet.complaint_id
                          LEFT JOIN tbl_complaint_type cmptype ON cmptype.id = cmpleg.complaint_type_id";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function getComplaintByChannelId($department_id)
    {
        $query = '';

        if($department_id != '')
        {
            $query .= "SELECT * FROM vw_get_complaint WHERE complaint_depart = '$department_id'";
        }
        else
        {
            $query .= "SELECT * FROM vw_get_complaint";
        }
        
        return $this->mysqli_lib->fetch_all($query);
    }

    function getSourceById($id) 
    {
        $query = "SELECT * FROM tbl_source WHERE id = '$id' ORDER BY id DESC LIMIT 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function getStatusById($id) 
    {
        $query = "SELECT * FROM tbl_status WHERE id = '$id' ORDER BY id DESC LIMIT 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function cmpOverdue($created_date, $closed_date)
    {
        $start  = date_create($created_date);
        $end    = date_create($closed_date);
        $diff   = date_diff($end,$start);
        return $diff->format('%R%a Days');
    }

    function countsComplaintAgeing($start_date,$end_date,$department,$complaint_type,$channel,$status)
    {
        if($start_date != '' && $end_date != '')
        {
            $data_cl    .= "AND DATE(cl.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_cc    .= "AND DATE(cc.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_clg   .= "AND DATE(clg.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_ci    .= "AND DATE(ci.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_cb    .= "AND DATE(cb.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_cbb   .= "AND DATE(cbb.create_date) BETWEEN '$start_date' AND '$end_date'";
            $data_cvt   .= "AND DATE(cvt.create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($department != '')
        {
            $data_cl     .= " AND cl.complaint_depart = '$department'";
            $data_cc     .= " AND cc.complaint_depart = '$department'";
            $data_clg    .= " AND clg.complaint_depart = '$department'";
            $data_ci     .= " AND ci.complaint_depart = '$department'";
            $data_cb     .= " AND cb.complaint_depart = '$department'";
            $data_cbb    .= " AND cbb.complaint_depart = '$department'";
            $data_cvt    .= " AND cvt.complaint_depart = '$department'";
        }

        if($channel != '')
        {
            $data_cl     .= " AND cl.channel = '$channel'";
            $data_cc     .= " AND cc.channel = '$channel'";
            $data_clg    .= " AND clg.channel = '$channel'";
            $data_ci     .= " AND ci.channel = '$channel'";
            $data_cb     .= " AND cb.channel = '$channel'";
            $data_cbb    .= " AND cbb.channel = '$channel'";
            $data_cvt    .= " AND cvt.channel = '$channel'";
        }

        if($complaint_type != '')
        {
            $data_cl     .= " AND cl.complaint_type_id = '$complaint_type'";
            $data_cc     .= " AND cc.complaint_type_id = '$complaint_type'";
            $data_clg    .= " AND clg.complaint_type_id = '$complaint_type'";
            $data_ci     .= " AND ci.complaint_type_id = '$complaint_type'";
            $data_cb     .= " AND cb.complaint_type_id = '$complaint_type'";
            $data_cbb    .= " AND cbb.complaint_type_id = '$complaint_type'";
            $data_cvt    .= " AND cvt.complaint_type_id = '$complaint_type'";
        }

        if($status != '')
        {
            $data_cl     .= " AND cl.status_id = '$status'";
            $data_cc     .= " AND cc.status_id = '$status'";
            $data_clg    .= " AND clg.status_id = '$status'";
            $data_ci     .= " AND ci.status_id = '$status'";
            $data_cb     .= " AND cb.status_id = '$status'";
            $data_cbb    .= " AND cbb.status_id = '$status'";
            $data_cvt    .= " AND cvt.status_id = '$status'";
        }

        $query  = "";
        $query .= "SELECT 
                    cl.complaint_id,
                    cdl.policy_num,
                    cdl.response_number,
                    cl.daily_counter,
                    cl.complaint_num,
                    cl.customer_name,
                    cl.cnic,
                    cl.agent_id,
                    cl.group_id,
                    cl.user_id,
                    cl.product_id,
                    cl.complaint_depart,
                    cl.complaint_type_id,
                    cl.priority_id,
                    cl.status_id,
                    cl.channel,
                    cl.tat,
                    cl.mode AS MODE,
                    cl.type AS TYPE,
                    cl.progress,
                    cl.file_counter,
                    cl.comments,
                    cl.comments_progress,
                    cl.comments_verified,
                    cl.policy_issuance_date,
                    cl.status_policy,
                    cl.plan_nature,
                    cl.create_date,
                    cdl.received_date,
                    cl.end_date,
                    cl.forward_date,
                    cl.close_date,
                    cl.over_all_satisfaction,
                    cl.resolution_time_satisfaction,
                    cl.staff_behavior,
                    cl.feedback_comments,
                    cl.feedback_date,
                    CONCAT(ur.first_name, ' ', ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdl.customer_email,
                    cdl.email,
                    cdl.description,
                    cdl.premium_amount,
                    cdl.refund_amount,
                    cdl.claim_amount,
                    cdl.bank,
                    cdl.region,
                    rc.fullname AS city
                FROM tbl_complaints_life cl
                LEFT JOIN tbl_users ur ON ur.id = cl.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = cl.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = cl.channel
                LEFT JOIN tbl_users urs ON urs.id = cl.user_id
                LEFT JOIN tbl_groups grp ON grp.id = cl.complaint_depart
                LEFT JOIN tbl_complaint_details_life cdl ON cdl.complaint_id = cl.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdl.city
                LEFT JOIN tbl_status sts ON sts.id = cl.status_id
                LEFT JOIN tbl_product p ON p.id = cl.product_id
                WHERE 1=1 $data_cl

                UNION ALL

                SELECT 
                    cc.complaint_id,
                    CONCAT(cdc.group_no, cdc.certificate_no) AS policy_num,
                    cdc.response_number,
                    cc.daily_counter,
                    cc.complaint_num,
                    cc.customer_name,
                    cc.cnic,
                    cc.agent_id,
                    cc.group_id,
                    cc.user_id,
                    cc.product_id,
                    cc.complaint_depart,
                    cc.complaint_type_id,
                    cc.priority_id,
                    cc.status_id,
                    cc.channel,
                    cc.tat,
                    cc.mode AS MODE,
                    cc.type AS TYPE,
                    cc.progress,
                    cc.file_counter,
                    cc.comments,
                    cc.comments_progress,
                    cc.comments_verified,
                    cc.policy_issuance_date,
                    cc.status_policy,
                    cc.plan_nature,
                    cc.create_date,
                    cdc.received_date,
                    cc.end_date,
                    cc.forward_date,
                    cc.close_date,
                    cc.over_all_satisfaction,
                    cc.resolution_time_satisfaction,
                    cc.staff_behavior,
                    cc.feedback_comments,
                    cc.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdc.customer_email,
                    cdc.email,
                    cdc.description,
                    cdc.premium_amount,
                    cdc.refund_amount,
                    cdc.claim_amount,
                    cdc.bank,
                    cdc.region,
                    rc.fullname AS city
                FROM tbl_complaints_cooperate cc
                LEFT JOIN tbl_users ur ON ur.id = cc.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = cc.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = cc.channel
                LEFT JOIN tbl_users urs ON urs.id = cc.user_id
                LEFT JOIN tbl_groups grp ON grp.id = cc.complaint_depart
                LEFT JOIN tbl_complaint_details_cooperate cdc ON cdc.complaint_id = cc.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdc.city
                LEFT JOIN tbl_status sts ON sts.id = cc.status_id
                LEFT JOIN tbl_product p ON p.id = cc.product_id
                WHERE 1=1 $data_cc
                UNION ALL

                SELECT 
                    clg.complaint_id,
                    cdlg.policy_num,
                    cdlg.response_number,
                    clg.daily_counter,
                    clg.complaint_num,
                    clg.customer_name,
                    clg.cnic,
                    clg.agent_id,
                    clg.group_id,
                    clg.user_id,
                    clg.product_id,
                    clg.complaint_depart,
                    clg.complaint_type_id,
                    clg.priority_id,
                    clg.status_id,
                    clg.channel,
                    clg.tat,
                    clg.mode AS MODE,
                    clg.type AS TYPE,
                    clg.progress,
                    clg.file_counter,
                    clg.comments,
                    clg.comments_progress,
                    clg.comments_verified,
                    clg.policy_issuance_date,
                    clg.status_policy,
                    clg.plan_nature,
                    clg.create_date,
                    cdlg.received_date,
                    clg.end_date,
                    clg.forward_date,
                    clg.close_date,
                    clg.over_all_satisfaction,
                    clg.resolution_time_satisfaction,
                    clg.staff_behavior,
                    clg.feedback_comments,
                    clg.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdlg.customer_email,
                    cdlg.email,
                    cdlg.description,
                    cdlg.premium_amount,
                    cdlg.refund_amount,
                    cdlg.claim_amount,
                    cdlg.bank,
                    cdlg.region,
                    rc.fullname AS city
                FROM tbl_complaints_legal clg
                LEFT JOIN tbl_users ur ON ur.id = clg.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = clg.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = clg.channel
                LEFT JOIN tbl_users urs ON urs.id = clg.user_id
                LEFT JOIN tbl_groups grp ON grp.id = clg.complaint_depart
                LEFT JOIN tbl_complaint_details_legal cdlg ON cdlg.complaint_id = clg.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdlg.city
                LEFT JOIN tbl_status sts ON sts.id = clg.status_id
                LEFT JOIN tbl_product p ON p.id = clg.product_id
                WHERE 1=1 $data_clg
                UNION ALL

                SELECT 
                    ci.complaint_id,
                    'NA' AS policy_num,
                    'NA' AS response_number,
                    ci.daily_counter,
                    ci.complaint_num,
                    ci.customer_name,
                    ci.cnic,
                    ci.agent_id,
                    ci.group_id,
                    ci.user_id,
                    '' AS product_id,
                    ci.complaint_depart,
                    ci.complaint_type_id,
                    ci.priority_id,
                    ci.status_id,
                    ci.channel,
                    ci.tat,
                    ci.mode AS MODE,
                    ci.type AS TYPE,
                    ci.progress,
                    ci.file_counter,
                    ci.comments,
                    ci.comments_progress,
                    ci.comments_verified,
                    ci.policy_issuance_date,
                    ci.status_policy,
                    ci.plan_nature,
                    ci.create_date,
                    ci.received_date,
                    ci.end_date,
                    ci.forward_date,
                    ci.close_date,
                    ci.over_all_satisfaction,
                    ci.resolution_time_satisfaction,
                    ci.staff_behavior,
                    ci.feedback_comments,
                    ci.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    '' AS product_name,
                    '' AS customer_email,
                    '' AS email,
                    '' AS description,
                    cdi.premium_amount,
                    cdi.refund_amount,
                    cdi.claim_amount,
                    cdi.bank,
                    cdi.region,
                    rc.fullname AS city
                FROM tbl_complaints_internal ci
                LEFT JOIN tbl_users ur ON ur.id = ci.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = ci.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = ci.channel
                LEFT JOIN tbl_users urs ON urs.id = ci.user_id
                LEFT JOIN tbl_groups grp ON grp.id = ci.complaint_depart
                LEFT JOIN tbl_complaints_internal cdi ON cdi.complaint_id = ci.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdi.city
                LEFT JOIN tbl_status sts ON sts.id = ci.status_id
                WHERE 1=1 $data_ci
                UNION ALL

                SELECT 
                    cb.complaint_id,
                    cdbi.policy_num,
                    cdbi.response_number,
                    cb.daily_counter,
                    cb.complaint_num,
                    cb.customer_name,
                    cb.cnic,
                    cb.agent_id,
                    cb.group_id,
                    cb.user_id,
                    cb.product_id,
                    cb.complaint_depart,
                    cb.complaint_type_id,
                    cb.priority_id,
                    cb.status_id,
                    cb.channel,
                    cb.tat,
                    cb.mode AS MODE,
                    cb.type AS TYPE,
                    cb.progress,
                    cb.file_counter,
                    cb.comments,
                    cb.comments_progress,
                    cb.comments_verified,
                    cb.policy_issuance_date,
                    cb.status_policy,
                    cb.plan_nature,
                    cb.create_date,
                    cdbi.received_date,
                    cb.end_date,
                    cb.forward_date,
                    cb.close_date,
                    cb.over_all_satisfaction,
                    cb.resolution_time_satisfaction,
                    cb.staff_behavior,
                    cb.feedback_comments,
                    cb.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdbi.customer_email,
                    cdbi.email,
                    cdbi.description,
                    cdbi.premium_amount,
                    cdbi.refund_amount,
                    cdbi.claim_amount,
                    cdbi.bank,
                    cdbi.region,
                    rc.fullname AS city
                FROM tbl_complaints_banca cb 
                LEFT JOIN tbl_users ur ON ur.id = cb.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = cb.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = cb.channel
                LEFT JOIN tbl_users urs ON urs.id = cb.user_id
                LEFT JOIN tbl_groups grp ON grp.id = cb.complaint_depart
                LEFT JOIN tbl_complaint_details_banca cdbi ON cdbi.complaint_id = cb.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdbi.city
                LEFT JOIN tbl_status sts ON sts.id = cb.status_id
                LEFT JOIN tbl_product p ON p.id = cb.product_id
                WHERE 1=1 $data_cb
                union All
                SELECT 
                    cbb.complaint_id AS complaint_id,
                    CONCAT(cdbb.group_no, cdbb.certificate_no) AS policy_num,
                    cdbb.response_number AS response_number,
                    cbb.daily_counter AS daily_counter,
                    cbb.complaint_num AS complaint_num,
                    cbb.customer_name AS customer_name,
                    cbb.cnic AS cnic,
                    cbb.agent_id AS agent_id,
                    cbb.group_id AS group_id,
                    cbb.user_id AS user_id,
                    cbb.product_id AS product_id,
                    cbb.complaint_depart AS complaint_depart,
                    cbb.complaint_type_id AS complaint_type_id,
                    cbb.priority_id AS priority_id,
                    cbb.status_id AS status_id,
                    cbb.channel AS channel,
                    cbb.tat AS tat,
                    cbb.mode AS MODE,
                    cbb.type AS TYPE,
                    cbb.progress AS progress,
                    cbb.file_counter AS file_counter,
                    cbb.comments AS comments,
                    cbb.comments_progress AS comments_progress,
                    cbb.comments_verified AS comments_verified,
                    cbb.policy_issuance_date AS policy_issuance_date,
                    cbb.status_policy AS status_policy,
                    cbb.plan_nature AS plan_nature,
                    cbb.create_date AS create_date,
                    cdbb.received_date AS received_date,
                    cbb.end_date AS end_date,
                    cbb.forward_date AS forward_date,
                    cbb.close_date AS close_date,
                    cbb.over_all_satisfaction,
                    cbb.resolution_time_satisfaction,
                    cbb.staff_behavior,
                    cbb.feedback_comments,
                    cbb.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdbb.customer_email AS customer_email,
                    cdbb.email,
                    cdbb.description,
                    cdbb.premium_amount AS premium_amount,
                    cdbb.refund_amount AS refund_amount,
                    cdbb.claim_amount AS claim_amount,
                    cdbb.bank AS bank,
                    cdbb.region AS region,
                    rc.fullname AS city
                FROM tbl_complaints_banca_bank cbb 
                LEFT JOIN tbl_users ur ON ur.id = cbb.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = cbb.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = cbb.channel
                LEFT JOIN tbl_users urs ON urs.id = cbb.user_id
                LEFT JOIN tbl_groups grp ON grp.id = cbb.complaint_depart
                LEFT JOIN tbl_complaint_details_banca_bank cdbb ON cdbb.complaint_id = cbb.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdbb.city
                LEFT JOIN tbl_status sts ON sts.id = cbb.status_id
                LEFT JOIN tbl_product p ON p.id = cbb.product_id
                WHERE 1=1 $data_cbb
                UNION ALL

                SELECT 
                    cvt.complaint_id AS complaint_id,
                    cdv.policy_num AS policy_num,
                    cdv.response_number AS response_number,
                    cvt.daily_counter AS daily_counter,
                    cvt.complaint_num AS complaint_num,
                    cvt.customer_name AS customer_name,
                    cvt.cnic AS cnic,
                    cvt.agent_id AS agent_id,
                    cvt.group_id AS group_id,
                    cvt.user_id AS user_id,
                    cvt.product_id AS product_id,
                    cvt.complaint_depart AS complaint_depart,
                    cvt.complaint_type_id AS complaint_type_id,
                    cvt.priority_id AS priority_id,
                    cvt.status_id AS status_id,
                    cvt.channel AS channel,
                    cvt.tat AS tat,
                    cvt.mode AS MODE,
                    cvt.type AS TYPE,
                    cvt.progress AS progress,
                    cvt.file_counter AS file_counter,
                    cvt.comments AS comments,
                    cvt.comments_progress AS comments_progress,
                    cvt.comments_verified AS comments_verified,
                    cvt.policy_issuance_date AS policy_issuance_date,
                    cvt.status_policy AS status_policy,
                    cvt.plan_nature AS plan_nature,
                    cvt.create_date AS create_date,
                    cdv.received_date AS received_date,
                    cvt.end_date AS end_date,
                    cvt.forward_date AS forward_date,
                    cvt.close_date AS close_date,
                    cvt.over_all_satisfaction,
                    cvt.resolution_time_satisfaction,
                    cvt.staff_behavior,
                    cvt.feedback_comments,
                    cvt.feedback_date,
                    CONCAT(ur.first_name,' ',ur.last_name) AS ReleasedBy,
                    ct.fullname AS ComplaintType,
                    sr.fullname AS Source,
                    CONCAT(urs.first_name,' ',urs.last_name) AS AssignedTo,
                    grp.primary_name AS depart,
                    sts.fullname AS cmpStatus,
                    p.fullname AS product_name,
                    cdv.customer_email AS customer_email,
                    cdv.email,
                    cdv.description,
                    cdv.premium_amount AS premium_amount,
                    cdv.refund_amount AS refund_amount,
                    cdv.claim_amount AS claim_amount,
                    cdv.bank AS bank,
                    cdv.region AS region,
                    rc.fullname AS city
                FROM tbl_complaints_vatality cvt 
                LEFT JOIN tbl_users ur ON ur.id = cvt.agent_id
                LEFT JOIN tbl_complaint_type ct ON ct.id = cvt.complaint_type_id
                LEFT JOIN tbl_source sr ON sr.id = cvt.channel
                LEFT JOIN tbl_users urs ON urs.id = cvt.user_id
                LEFT JOIN tbl_groups grp ON grp.id = cvt.complaint_depart
                LEFT JOIN tbl_complaint_details_vatality cdv ON cdv.complaint_id = cvt.complaint_id
                LEFT JOIN tbl_region_city rc ON rc.id = cdv.city
                LEFT JOIN tbl_status sts ON sts.id = cvt.status_id
                LEFT JOIN tbl_product p ON p.id = cvt.product_id
                WHERE 1=1 $data_cvt";
                
		//echo $query;die;
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetComplaintTypeByGroup($id)
    {
        $query = "SELECT * FROM tbl_complaint_type WHERE group_id = '$id' AND isactive = 1";
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsAnnualComplaintComparison($year)
    {
        if($year != '')
        {
            $data .= "AND YEAR(create_date) = '$year'";
        }

        $query  = "";
        $query .= " SELECT
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '01') AS LJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '02') AS LFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '03') AS LMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '04') AS LAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '05') AS LMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '06') AS LJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '07') AS LJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '08') AS LAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '09') AS LSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '10') AS LOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '11') AS LNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND MONTH(create_date) = '12') AS LDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '01') AS CJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '02') AS CFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '03') AS CMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '04') AS CAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '05') AS CMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '06') AS CJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '07') AS CJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '08') AS CAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '09') AS CSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '10') AS COTB,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '11') AS CNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND MONTH(create_date) = '12') AS CDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '01') AS LGJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '02') AS LGFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '03') AS LGMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '04') AS LGAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '05') AS LGMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '06') AS LGJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '07') AS LGJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '08') AS LGAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '09') AS LGSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '10') AS LGOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '11') AS LGNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND MONTH(create_date) = '12') AS LGDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '01') AS IJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '02') AS IFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '03') AS IMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '04') AS IAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '05') AS IMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '06') AS IJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '07') AS IJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '08') AS IAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '09') AS ISEP,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '10') AS IOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '11') AS INOV,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data AND MONTH(create_date) = '12') AS IDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '01') AS BJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '02') AS BFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '03') AS BMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '04') AS BAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '05') AS BMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '06') AS BJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '07') AS BJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '08') AS BAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '09') AS BSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '10') AS BOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '11') AS BNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND MONTH(create_date) = '12') AS BDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '01') AS BBJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '02') AS BBFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '03') AS BBMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '04') AS BBAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '05') AS BBMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '06') AS BBJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '07') AS BBJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '08') AS BBAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '09') AS BBSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '10') AS BBOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '11') AS BBNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND MONTH(create_date) = '12') AS BBDEM,

                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '01') AS VJAN,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '02') AS VFAB,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '03') AS VMAR,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '04') AS VAPR,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '05') AS VMAY,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '06') AS VJUN,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '07') AS VJUL,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '08') AS VAUG,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '09') AS VSEP,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '10') AS VOTB,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '11') AS VNOV,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND MONTH(create_date) = '12') AS VDEM";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsAllComplaint()
    {
        $query  = "";
        $query .= "SELECT
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_life) AS L,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_cooperate) AS C,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_legal) AS LG,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_internal) AS I,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_banca) AS B,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_banca_bank) AS BB,
                  (SELECT COUNT(complaint_id) FROM tbl_complaints_vatality) AS V";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsAllComplaintGraph($login_id)
    {
        $today      = date("Y-m-d");
        $last_date  = date("Y-m-d", strtotime("-1 week"));

        if($login_id != '' AND $login_id != '1')
        {
            $data .= "AND user_id = '$login_id'";
        }

        $query  = "";
        $query .= "SELECT
                (SELECT COUNT(complaint_id) FROM tbl_complaints_life WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS L,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_cooperate WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS C,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_legal WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS LG,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_internal WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS I,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_banca WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS B,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_banca_bank WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS BB,
                (SELECT COUNT(complaint_id) FROM tbl_complaints_vatality WHERE DATE(create_date) BETWEEN '$last_date' AND '$today' $data) AS V";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsComplaintTypewiseOnLoad($deprtment_id,$complaint_type_id,$duration,$month,$quarter,$year)
    {
        if($deprtment_id != '')
        {
            $data .= "AND complaint_depart = '$deprtment_id'";
        }

        // Not using to filter
        if($complaint_type_id != '')
        {
            $data .= " AND complaint_type_id = '$complaint_type_id'";
        }

        if($duration != '')
        {
          if($month != '')
          {
              $start_month  = $month.'-01';
              $end_month    = $month.'-31';

              $data .= "AND DATE(create_date) BETWEEN '$start_month' AND '$end_month'";
          }

          $quarter_num  = substr($quarter,5,2);
          $quarter_year = substr($quarter,0,4);

          if($quarter != '' AND $quarter_num == '01')
          {
              $start_date = $quarter_year.'-01-'.'01';
              $end_date   = $quarter_year.'-03-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '02')
          {
              $start_date = $quarter_year.'-04-'.'01';
              $end_date   = $quarter_year.'-06-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '03')
          {
              $start_date = $quarter_year.'-07-'.'01';
              $end_date   = $quarter_year.'-09-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '04')
          {
              $start_date = $quarter_year.'-10-'.'01';
              $end_date   = $quarter_year.'-12-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($year != '')
          {
              $data .= "AND YEAR(create_date) = '$year'";
          }
        }

        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data) AS CMPC,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG,
                    (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data) AS CMPI,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getComplaintByDepartmentId($deprtment_id,$duration,$month,$quarter,$year)
    {
        if($duration != '')
        {
          if($month != '')
          {
              $start_month  = $month.'-01';
              $end_month    = $month.'-31';

              $data .= "AND DATE(create_date) BETWEEN '$start_month' AND '$end_month'";
          }

          $quarter_num  = substr($quarter,5,2);
          $quarter_year = substr($quarter,0,4);

          if($quarter != '' AND $quarter_num == '01')
          {
              $start_date = $quarter_year.'-01-'.'01';
              $end_date   = $quarter_year.'-03-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '02')
          {
              $start_date = $quarter_year.'-04-'.'01';
              $end_date   = $quarter_year.'-06-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '03')
          {
              $start_date = $quarter_year.'-07-'.'01';
              $end_date   = $quarter_year.'-09-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '04')
          {
              $start_date = $quarter_year.'-10-'.'01';
              $end_date   = $quarter_year.'-12-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($year != '')
          {
              $data .= "AND YEAR(create_date) = '$year'";
          }
        }

        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPL,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPL_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPL_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPC,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPC_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPC_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPLG,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPLG_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPLG_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 AND complaint_depart ='$deprtment_id' $data) AS CMPI,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPI_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPI_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPB_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPB_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPBB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPBB_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPBB_OPENED,

                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 AND complaint_depart = '$deprtment_id' $data) AS CMPV,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id = '3') AS CMPV_CLOSED,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 AND complaint_depart = '$deprtment_id' $data AND status_id != '3') AS CMPV_OPENED";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function getComplaintOpenCaseAgingByDepartId($deprtment_id,$duration,$month,$quarter,$year)
    {
        $data    = "";
        $query   = "";
 
        if($duration != '')
        {
          if($month != '')
          {
              $start_month  = $month.'-01';
              $end_month    = $month.'-31';

              $data .= "AND DATE(create_date) BETWEEN '$start_month' AND '$end_month'";
          }

          $quarter_num  = substr($quarter,5,2);
          $quarter_year = substr($quarter,0,4);

          if($quarter != '' AND $quarter_num == '01')
          {
              $start_date = $quarter_year.'-01-'.'01';
              $end_date   = $quarter_year.'-03-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '02')
          {
              $start_date = $quarter_year.'-04-'.'01';
              $end_date   = $quarter_year.'-06-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '03')
          {
              $start_date = $quarter_year.'-07-'.'01';
              $end_date   = $quarter_year.'-09-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '04')
          {
              $start_date = $quarter_year.'-10-'.'01';
              $end_date   = $quarter_year.'-12-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($year != '')
          {
              $data .= "AND YEAR(create_date) = '$year'";
          }
        }

        $query .=   "SELECT 
                        SUM(DAYS_0) DAYS_0, 
                        SUM(DAYS_1_3) DAYS_1_3, 
                        SUM(DAYS_4_6) DAYS_4_6, 
                        SUM(DAYS_7_15) DAYS_7_15, 
                        SUM(DAYS_16_30) DAYS_16_30, 
                        SUM(DAYS_31) DAYS_31
                    FROM
                    (
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_life
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL
                        
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_cooperate
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL
                        
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_legal
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL
                        
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_internal
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL
                        
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_banca
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL
                        
                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS DAYS_0,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_banca_bank
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                             
                        UNION ALL

                        SELECT
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) < 1) THEN 1 ELSE 0 END) AS 'DAYS_0',
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 1 AND DATEDIFF(CURDATE(), create_date) <= 3) THEN 1 ELSE 0 END) AS DAYS_1_3,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 4 AND DATEDIFF(CURDATE(), create_date) <= 6) THEN 1 ELSE 0 END) AS DAYS_4_6,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 7 AND DATEDIFF(CURDATE(), create_date) <= 15) THEN 1 ELSE 0 END) AS DAYS_7_15,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) >= 16 AND DATEDIFF(CURDATE(), create_date) <= 30) THEN 1 ELSE 0 END) AS DAYS_16_30,
                            SUM(CASE WHEN (DATEDIFF(CURDATE(), create_date) > 31) THEN 1 ELSE 0 END) AS DAYS_31
                        FROM tbl_complaints_vatality
                        WHERE 1=1 $data AND complaint_depart = '$deprtment_id' AND status_id IN ('1','2','4')
                    ) AS t";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsAllComplaintComparison($duration,$month,$quarter,$year)
    {
        if($duration != '')
        {
          if($month != '')
          {
              $start_month  = $month.'-01';
              $end_month    = $month.'-31';

              $data .= "AND DATE(create_date) BETWEEN '$start_month' AND '$end_month'";
          }

          $quarter_num  = substr($quarter,5,2);
          $quarter_year = substr($quarter,0,4);

          if($quarter != '' AND $quarter_num == '01')
          {
              $start_date = $quarter_year.'-01-'.'01';
              $end_date   = $quarter_year.'-03-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '02')
          {
              $start_date = $quarter_year.'-04-'.'01';
              $end_date   = $quarter_year.'-06-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '03')
          {
              $start_date = $quarter_year.'-07-'.'01';
              $end_date   = $quarter_year.'-09-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '04')
          {
              $start_date = $quarter_year.'-10-'.'01';
              $end_date   = $quarter_year.'-12-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($year != '')
          {
              $data .= "AND YEAR(create_date) = '$year'";
          }
        }

        $query  = "";
        $query .= " SELECT
                    (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL,
                    (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data) AS CMPC,
                    (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG,
                    (SELECT COUNT(*) FROM tbl_complaints_internal WHERE 1=1 $data) AS CMPI,
                    (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB,
                    (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB,
                    (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV,
                    (SELECT SUM(CMPL)+SUM(CMPC)+SUM(CMPLG)+SUM(CMPI)+SUM(CMPB)+SUM(CMPBB)+SUM(CMPV)) AS ALLCMPSUM";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsComplaintChannel($department_id,$duration,$month,$quarter,$year)
    {
        if($duration != '')
        {
          if($month != '')
          {
              $start_month  = $month.'-01';
              $end_month    = $month.'-31';

              $data .= "AND DATE(create_date) BETWEEN '$start_month' AND '$end_month'";
          }

          $quarter_num  = substr($quarter,5,2);
          $quarter_year = substr($quarter,0,4);

          if($quarter != '' AND $quarter_num == '01')
          {
              $start_date = $quarter_year.'-01-'.'01';
              $end_date   = $quarter_year.'-03-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '02')
          {
              $start_date = $quarter_year.'-04-'.'01';
              $end_date   = $quarter_year.'-06-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '03')
          {
              $start_date = $quarter_year.'-07-'.'01';
              $end_date   = $quarter_year.'-09-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($quarter != '' AND $quarter_num == '04')
          {
              $start_date = $quarter_year.'-10-'.'01';
              $end_date   = $quarter_year.'-12-'.'31';

              $data .= "AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
          }

          if($year != '')
          {
              $data .= "AND YEAR(create_date) = '$year'";
          }
        }

        $query  = "";
        $query .= "SELECT
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'individual' $data) AS CMPL,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'corporate' $data) AS CMPC,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'legal' $data) AS CMPLG,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'internal' $data) AS CMPI,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'bancaIndividual' $data) AS CMPB,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'bancaBank' $data) AS CMPBB,
                  (SELECT COUNT(*) FROM vw_get_complaint WHERE complaint_depart = '$department_id' AND TYPE = 'vatality' $data) AS CMPV,
                  (SELECT SUM(CMPL)+SUM(CMPC)+SUM(CMPLG)+SUM(CMPI)+SUM(CMPB)+SUM(CMPBB)+SUM(CMPV)) AS CMPSUM,
                  (SELECT COUNT(1) FROM vw_get_complaint) AS CMPCOUNTS,
                  (SELECT (CMPSUM/CMPCOUNTS)*100) AS CMPPERCENTAGE";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLegalComplaintClosureAnalysis($year)
    {
      if($year != '')
      {
        $data .= "AND YEAR(clg.create_date) = '$year'";
      }

      $query  = "";
      $query .= "SELECT mon.month_name AS 'MonthName', IFNULL (SUM(cdlg.premium_amount),0) AS PremiumCollected, IFNULL (SUM(cdlg.claim_amount),0) AS ClaimedByPolicyholder, IFNULL (SUM(cdlg.refun_amount),0) AS PaymentToPolicyholder FROM tbl_month_name mon LEFT JOIN tbl_complaints_legal clg ON MONTH(clg.create_date) = mon.month_value LEFT JOIN tbl_complaint_details_legal cdlg ON clg.complaint_id = cdlg.complaint_id $data GROUP BY mon.month_value";

      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function countsQuarterlyDepartmentalComplaint($deprtment_id,$complaint_type_id,$quarter,$year,$status)
    {
        if($deprtment_id != '')
        {
            $data .= "AND complaint_depart = '$deprtment_id'";
        }

        if($complaint_type_id != '')
        {
            $data .= " AND complaint_type_id = '$complaint_type_id'";
        }

        if($quarter != '')
        {
            if($quarter == '01')
            {
              $start_date = $year.'-01-'.'01';
              $end_date   = $year.'-03-'.'31';
              $data .= " AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '02')
            {
              $start_date = $year.'-04-'.'01';
              $end_date   = $year.'-06-'.'31';
              $data .= " AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '03')
            {
              $start_date = $year.'-07-'.'01';
              $end_date   = $year.'-09-'.'31';
              $data .= " AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '04')
            {
              $start_date = $year.'-10-'.'01';
              $end_date   = $year.'-12-'.'31';
              $data .= " AND DATE(create_date) BETWEEN '$start_date' AND '$end_date'";
            }
        }

        if($year != '')
        {
            $data .= " AND YEAR(create_date) = '$year'";
        }

        if($status != '')
        {
            $data .= " AND status_id IN ($status)";
        }

        $query  = "";
        $query .= "SELECT
                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data ) AS CMPC_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data) AS CMPI_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV_OPEN,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id = '1') AS CMPL_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id = '1') AS CMPC_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id = '1') AS CMPLG_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id = '1') AS CMPI_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id = '1') AS CMPB_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id = '1') AS CMPBB_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id = '1') AS CMPV_NEW,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data) AS CMPC_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data) AS CMPI_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV_TOTAL,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id = '3') AS CMPL_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id = '3') AS CMPC_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id = '3') AS CMPLG_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id = '3') AS CMPI_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id = '3') AS CMPB_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id = '3') AS CMPBB_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id = '3') AS CMPV_CLOSED,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id IN (1,2)) AS CMPL_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id IN (1,2)) AS CMPC_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id IN (1,2)) AS CMPLG_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id IN (1,2)) AS CMPI_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id IN (1,2)) AS CMPB_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id IN (1,2)) AS CMPBB_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id IN (1,2)) AS CMPV_PENDING";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsAnnualDepartmentalComplaint($deprtment_id,$complaint_type_id,$year,$status)
    {
      if($deprtment_id != '')
      {
        $data .= "AND complaint_depart = '$deprtment_id'";
      }

      if($complaint_type_id != '')
      {
        $data .= " AND complaint_type_id = '$complaint_type_id'";
      }

      if($year != '')
      {
        $data .= " AND YEAR(create_date) = '$year'";
      }

      if($status != '')
      {
        $data .= " AND status_id IN ($status)";
      }

      $query  = "";
      $query .= "SELECT
                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data ) AS CMPC_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data) AS CMPI_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB_OPEN,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV_OPEN,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id = '1') AS CMPL_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id = '1') AS CMPC_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id = '1') AS CMPLG_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id = '1') AS CMPI_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id = '1') AS CMPB_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id = '1') AS CMPBB_NEW,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id = '1') AS CMPV_NEW,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data) AS CMPL_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data) AS CMPC_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data) AS CMPLG_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data) AS CMPI_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data) AS CMPB_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data) AS CMPBB_TOTAL,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data) AS CMPV_TOTAL,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id = '3') AS CMPL_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id = '3') AS CMPC_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id = '3') AS CMPLG_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id = '3') AS CMPI_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id = '3') AS CMPB_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id = '3') AS CMPBB_CLOSED,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id = '3') AS CMPV_CLOSED,

                (SELECT COUNT(*) FROM tbl_complaints_life WHERE 1=1 $data AND status_id IN (1,2)) AS CMPL_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_cooperate WHERE 1=1 $data AND status_id IN (1,2)) AS CMPC_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_legal WHERE 1=1 $data AND status_id IN (1,2)) AS CMPLG_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_internal  WHERE 1=1 $data AND status_id IN (1,2)) AS CMPI_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_banca WHERE 1=1 $data AND status_id IN (1,2)) AS CMPB_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_banca_bank WHERE 1=1 $data AND status_id IN (1,2)) AS CMPBB_PENDING,
                (SELECT COUNT(*) FROM tbl_complaints_vatality WHERE 1=1 $data AND status_id IN (1,2)) AS CMPV_PENDING";

      //return $query;
      return $this->mysqli_lib->fetch_all($query);
    }

    function countsQuarterlyComplaintsByForum($forum_id,$complaint_type_id,$quarter,$year,$status)
    {
        $query  =   "";
        $query .=   "SELECT 
                      COUNT(cmpleg.complaint_id) AS 'CMP_COUNTS'
                    FROM
                      tbl_complaints_legal cmpleg 
                      LEFT JOIN tbl_complaint_details_legal cmplegdet ON cmpleg.complaint_id = cmplegdet.complaint_id
                      LEFT JOIN tbl_complaint_type cmptype ON cmptype.id = cmpleg.complaint_type_id WHERE 1=1 $query";

        if($forum_id != '')
        {
            $query .= " AND cmplegdet.forum_id = '$forum_id'";
        }

        if($complaint_type_id != '')
        {
            $query .= " AND cmpleg.complaint_type_id = '$complaint_type_id'";
        }

        if($quarter != '')
        {
            if($quarter == '01')
            {
              $start_date = $year.'-01-'.'01';
              $end_date   = $year.'-03-'.'31';
              $query .= " AND DATE(cmpleg.create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '02')
            {
              $start_date = $year.'-04-'.'01';
              $end_date   = $year.'-06-'.'31';
              $query .= " AND DATE(cmpleg.create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '03')
            {
              $start_date = $year.'-07-'.'01';
              $end_date   = $year.'-09-'.'31';
              $query .= " AND DATE(cmpleg.create_date) BETWEEN '$start_date' AND '$end_date'";
            }

            if($quarter == '04')
            {
              $start_date = $year.'-10-'.'01';
              $end_date   = $year.'-12-'.'31';
              $query .= " AND DATE(cmpleg.create_date) BETWEEN '$start_date' AND '$end_date'";
            }
        }

        if($year != '')
        {
            $query .= " AND YEAR(cmpleg.create_date) = '$year'";
        }

        if($status != '')
        {
            $query .= " AND cmpleg.status_id IN ($status)";
        }

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }
}