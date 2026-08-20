<?php
class LeadReport
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    // Leads for Status - Start
    function GetRgCity($id) 
    {
        $query = "SELECT * FROM tbl_region_city";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetCityName($id) 
    {
        $query = "SELECT * FROM tbl_region_city WHERE id = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByStatus($start_date,$end_date)
    {
        if($start_date != '' && $end_date != '')
        {
            $data .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 1 $data) AS initiated_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 2 $data) AS inprogress_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 3 $data) AS followup_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 4 $data) AS bought_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 5 $data) AS not_interested_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 6 $data) AS general_inquiry_leads,
                    (SELECT COUNT(*) FROM tbl_leads) AS counts,
                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByStatusGraphs($start_date,$end_date,$login_id)
    {
        if($start_date != '' && $end_date != '')
        {
            $data .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($login_id != '' AND $login_id != '1')
        {
            $data .= "AND lead_assigned_to = '$login_id'";
        }

        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 1 $data) AS initiated_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 2 $data) AS inprogress_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 3 $data) AS followup_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 4 $data) AS bought_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 5 $data) AS not_interested_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 6 $data) AS general_inquiry_leads,
                    (SELECT COUNT(*) FROM tbl_leads) AS counts,
                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads";
        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function exportLeadsByStatus($start_date,$end_date)
    {
        if($start_date != '' && $end_date != '')
        {
            $data .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        $query  = "";
        $query .= "SELECT
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 1 $data) AS initiated_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 2 $data) AS inprogress_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 3 $data) AS followup_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 4 $data) AS bought_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 5 $data) AS not_interested_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE lead_status_id = 6 $data) AS general_inquiry_leads,
                    (SELECT COUNT(*) FROM tbl_leads WHERE gender = 'Male' $data) AS male,
                    (SELECT COUNT(*) FROM tbl_leads WHERE gender = 'Female' $data) AS female,
                    (SELECT COUNT(*) FROM tbl_leads) AS counts,
                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads";

        //return $query;            
        return $this->mysqli_lib->fetch_all($query);
    }
    // Leads for Status - End

    // Leads for Citywise - Start
    function countsLeadsByCityLoop()
    {
        $query  = "";
        $query .= "SELECT tbl_region_city.id, tbl_region_city.fullname city_name FROM tbl_region_city INNER JOIN tbl_leads ON tbl_region_city.id = tbl_leads.city GROUP BY tbl_region_city.id";

        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByCityOne($city)
    {
        $query  = "";
        $query .= "SELECT tbl_region_city.id, tbl_region_city.fullname city_name FROM tbl_region_city INNER JOIN tbl_leads ON tbl_region_city.id = tbl_leads.city WHERE 1=1 AND tbl_region_city.id = '$city' GROUP BY tbl_region_city.id";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByCity($start_date,$end_date,$city)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($city != '')
        {
            if($city != 0)
            {
                $DATA .= "AND city = '$city'";
            }
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 $DATA) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Male' $DATA) AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Female' $DATA) AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 $DATA) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Male' $DATA) AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Female' $DATA) AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 $DATA) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Male' $DATA) AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Female' $DATA) AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 $DATA) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Male' $DATA) AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Female' $DATA) AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 $DATA) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Male' $DATA) AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Female' $DATA) AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 $DATA) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Male' $DATA) AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Female' $DATA) AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByCityOnPageLoad($city_id)
    {
        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND city = $city_id) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND city = $city_id AND gender = 'Male') AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND city = $city_id AND gender = 'Female') AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND city = $city_id) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND city = $city_id AND gender = 'Male') AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND city = $city_id AND gender = 'Female') AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND city = $city_id) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND city = $city_id AND gender = 'Male') AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND city = $city_id AND gender = 'Female') AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND city = $city_id) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND city = $city_id AND gender = 'Male') AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND city = $city_id AND gender = 'Female') AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND city = $city_id) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND city = $city_id AND gender = 'Male') AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND city = $city_id AND gender = 'Female') AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND city = $city_id) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND city = $city_id AND gender = 'Male') AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND city = $city_id AND gender = 'Female') AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }

    function exportLeadsByCity($start_date,$end_date,$city)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($city != '')
        {
            if($city != 0)
            {
                $DATA .= "AND city = '$city'";
            }
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 $DATA) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Male' $DATA) AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Female' $DATA) AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 $DATA) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Male' $DATA) AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Female' $DATA) AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 $DATA) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Male' $DATA) AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Female' $DATA) AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 $DATA) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Male' $DATA) AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Female' $DATA) AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 $DATA) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Male' $DATA) AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Female' $DATA) AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 $DATA) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Male' $DATA) AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Female' $DATA) AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }
    // Leads for Citywise - End

    // Leads for Source Info - Start
    function countsLeadsBySourceInfo($start_date,$end_date,$city)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($city != '')
        {
            $DATA .= "AND city = '$city'";
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 $DATA) AS email,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Male' $DATA) AS email_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Female' $DATA) AS email_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 $DATA) AS calls,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Male' $DATA) AS calls_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Female' $DATA) AS calls_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 $DATA) AS letter,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Male' $DATA) AS letter_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Female' $DATA) AS letter_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 $DATA) AS walkin_customer,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Male' $DATA) AS walkin_customer_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Female' $DATA) AS walkin_customer_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 $DATA) AS website,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 AND gender = 'Male' $DATA) AS website_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 AND gender = 'Female' $DATA) AS website_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 $DATA) AS corporate_partners,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 AND gender = 'Male' $DATA) AS corporate_partners_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 AND gender = 'Female' $DATA) AS corporate_partners_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 $DATA) AS vec,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 AND gender = 'Male' $DATA) AS vec_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 AND gender = 'Female' $DATA) AS vec_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 $DATA) AS billboard,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 AND gender = 'Male' $DATA) AS billboard_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 AND gender = 'Female' $DATA) AS billboard_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(email)+SUM(calls)+SUM(letter)+SUM(walkin_customer)+SUM(website)+SUM(corporate_partners)+SUM(vec)+SUM(billboard))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(email_male_leads)+SUM(calls_male_leads)+SUM(letter_male_leads)+SUM(walkin_customer_male_leads)+SUM(website_male_leads)+SUM(corporate_partners_male_leads)+SUM(vec_male_leads)+SUM(billboard_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(email_female_leads)+SUM(calls_female_leads)+SUM(letter_female_leads)+SUM(walkin_customer_female_leads)+SUM(website_female_leads)+SUM(corporate_partners_female_leads)+SUM(vec_female_leads)+SUM(billboard_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsBySourceInfoOnPageLoad($city_id)
    {
        if($city_id != '')
        {
            $DATA .= "AND city = '$city_id'";
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 $DATA) AS email,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Male' $DATA) AS email_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Female' $DATA) AS email_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 $DATA) AS calls,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Male' $DATA) AS calls_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Female' $DATA) AS calls_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 $DATA) AS letter,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Male' $DATA) AS letter_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Female' $DATA) AS letter_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 $DATA) AS walkin_customer,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Male' $DATA) AS walkin_customer_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Female' $DATA) AS walkin_customer_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 $DATA) AS website,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 AND gender = 'Male' $DATA) AS website_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 5 AND gender = 'Female' $DATA) AS website_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 $DATA) AS corporate_partners,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 AND gender = 'Male' $DATA) AS corporate_partners_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 6 AND gender = 'Female' $DATA) AS corporate_partners_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 $DATA) AS vec,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 AND gender = 'Male' $DATA) AS vec_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 7 AND gender = 'Female' $DATA) AS vec_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 $DATA) AS billboard,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 AND gender = 'Male' $DATA) AS billboard_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 8 AND gender = 'Female' $DATA) AS billboard_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(email)+SUM(calls)+SUM(letter)+SUM(walkin_customer)+SUM(website)+SUM(corporate_partners)+SUM(vec)+SUM(billboard))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(email_male_leads)+SUM(calls_male_leads)+SUM(letter_male_leads)+SUM(walkin_customer_male_leads)+SUM(website_male_leads)+SUM(corporate_partners_male_leads)+SUM(vec_male_leads)+SUM(billboard_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(email_female_leads)+SUM(calls_female_leads)+SUM(letter_female_leads)+SUM(walkin_customer_female_leads)+SUM(website_female_leads)+SUM(corporate_partners_female_leads)+SUM(vec_female_leads)+SUM(billboard_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    /*function exportLeadsBySourceInfo($start_date,$end_date,$city)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date'";
        }

        if($city != '')
        {
            $DATA .= "AND city = '$city'";
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 $DATA) AS email,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Male' $DATA) AS email_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 1 AND gender = 'Female' $DATA) AS email_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 $DATA) AS website,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Male' $DATA) AS website_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 2 AND gender = 'Female' $DATA) AS website_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 $DATA) AS calls,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Male' $DATA) AS calls_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 3 AND gender = 'Female' $DATA) AS calls_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 $DATA) AS billboard,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Male' $DATA) AS billboard_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE source = 4 AND gender = 'Female' $DATA) AS billboard_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(email)+SUM(website)+SUM(calls)+SUM(billboard))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(email_male_leads)+SUM(website_male_leads)+SUM(calls_male_leads)+SUM(billboard_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(email_female_leads)+SUM(website_female_leads)+SUM(calls_female_leads)+SUM(billboard_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }*/
    // Leads for Source Info - End

    // Leads for Regnal Managars - Start
    /*function getRegionalManagers()
    {
        $query  = "";
        $query .= "SELECT tbl_users.id AS regional_manager_id, tbl_users.user_name AS regional_manager_name FROM tbl_users INNER JOIN tbl_leads ON tbl_users.id = tbl_leads.lead_assigned_to GROUP BY tbl_users.id";

        return $this->mysqli_lib->fetch_all($query);
    }*/

    function getRegionalManagers()
    {
        $query  = "";
        $query .= "SELECT tbl_users.id AS regional_manager_id, tbl_users.user_name AS regional_manager_name FROM tbl_users WHERE user_type = '4' AND product_id != '0'";

        return $this->mysqli_lib->fetch_all($query);
    }

    // Not using
    function getRegionalManagersFromMapping()
    {
        $query  = "";
        $query .= "SELECT tbl_users.id AS regional_manager_id, tbl_users.user_name AS regional_manager_name FROM tbl_users INNER JOIN tbl_leads_maping ON tbl_users.id = tbl_leads_maping.lead_regional_manager GROUP BY tbl_users.id";

        return $this->mysqli_lib->fetch_all($query);
    }

    function getRegionalManagersById($rm_id)
    {
        if($rm_id != '')
        {
            $DATA .= " AND id = '$rm_id'";
        }

        $query  = "";
        $query  .= "SELECT tbl_users.id AS regional_manager_id, tbl_users.user_name AS regional_manager_name FROM tbl_users WHERE user_type = '4' AND product_id != '0' $DATA";
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByRegional($start_date,$end_date,$rm_id)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= " AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date' ";
        }

        if($rm_id != '')
        {
            $DATA .= " AND lead_assigned_to = '$rm_id'";
        }

        $query  = "";
        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 $DATA) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Male' $DATA) AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Female' $DATA) AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 $DATA) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Male' $DATA) AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Female' $DATA) AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 $DATA) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Male' $DATA) AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Female' $DATA) AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 $DATA) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Male' $DATA) AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Female' $DATA) AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 $DATA) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Male' $DATA) AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Female' $DATA) AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 $DATA) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Male' $DATA) AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Female' $DATA) AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;
        return $this->mysqli_lib->fetch_all($query);
    }

    function countsLeadsByRegionalOnPageLoad($rm_id)
    {
        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND lead_assigned_to = $rm_id) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND lead_assigned_to = $rm_id AND gender = 'Male') AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND lead_assigned_to = $rm_id AND gender = 'Female') AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND lead_assigned_to = $rm_id) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND lead_assigned_to = $rm_id AND gender = 'Male') AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND lead_assigned_to = $rm_id AND gender = 'Female') AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND lead_assigned_to = $rm_id) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND lead_assigned_to = $rm_id AND gender = 'Male') AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND lead_assigned_to = $rm_id AND gender = 'Female') AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND lead_assigned_to = $rm_id) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND lead_assigned_to = $rm_id AND gender = 'Male') AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND lead_assigned_to = $rm_id AND gender = 'Female') AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND lead_assigned_to = $rm_id) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND lead_assigned_to = $rm_id AND gender = 'Male') AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND lead_assigned_to = $rm_id AND gender = 'Female') AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND lead_assigned_to = $rm_id) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND lead_assigned_to = $rm_id AND gender = 'Male') AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND lead_assigned_to = $rm_id AND gender = 'Female') AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }

    function exportLeadsByRegional($start_date,$end_date,$regional_manager)
    {
        if($start_date != '' && $end_date != '')
        {
            $DATA .= "AND DATE(lead_create_date) BETWEEN '$start_date' AND '$end_date' ";
        }

        if($regional_manager != '')
        {
            $DATA .= "AND lead_assigned_to = '$regional_manager'";
        }

        $query  = "";

        $query .= "SELECT 
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 $DATA) AS initiated_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Male' $DATA) AS initiated_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 1 AND gender = 'Female' $DATA) AS initiated_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 $DATA) AS inprogress_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Male' $DATA) AS inprogress_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 2 AND gender = 'Female' $DATA) AS inprogress_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 $DATA) AS followup_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Male' $DATA) AS followup_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 3 AND gender = 'Female' $DATA) AS followup_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 $DATA) AS bought_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Male' $DATA) AS bought_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 4 AND gender = 'Female' $DATA) AS bought_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 $DATA) AS not_interested_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Male' $DATA) AS not_interested_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 5 AND gender = 'Female' $DATA) AS not_interested_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 $DATA) AS general_inquiry_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Male' $DATA) AS general_inquiry_male_leads,
                    (SELECT COUNT(1) FROM tbl_leads WHERE lead_status_id = 6 AND gender = 'Female' $DATA) AS general_inquiry_female_leads,

                    (SELECT COUNT(1) FROM tbl_leads) AS counts,

                    (SELECT (SUM(initiated_leads)+SUM(inprogress_leads)+SUM(followup_leads)+SUM(bought_leads)+SUM(not_interested_leads)+SUM(general_inquiry_leads))/counts FROM tbl_leads) AS all_leads,

                    (SELECT (SUM(initiated_male_leads)+SUM(inprogress_male_leads)+SUM(followup_male_leads)+SUM(bought_male_leads)+SUM(not_interested_male_leads)+SUM(general_inquiry_male_leads))/counts FROM tbl_leads) AS all_male_leads,

                    (SELECT (SUM(initiated_female_leads)+SUM(inprogress_female_leads)+SUM(followup_female_leads)+SUM(bought_female_leads)+SUM(not_interested_female_leads)+SUM(general_inquiry_female_leads))/counts FROM tbl_leads) AS all_female_leads";

        //return $query;

        return $this->mysqli_lib->fetch_all($query);
    }
    // Leads for Regnal Managars - End

    function getLeadRawData()
    {
        $query  = "";
        $query .= "SELECT 
                l.*, rcity.fullname AS city, carea.area AS 'area', prod.fullname AS product, sour.fullname AS source, usr.user_name AS lead_assignee, usr2.user_name AS lead_assignee_to, (SELECT remarks FROM tbl_leads_details WHERE lead_id = l.lead_id ORDER BY update_datetime DESC LIMIT 1) AS last_remarks 
                FROM tbl_leads l 
                    LEFT JOIN tbl_region_city rcity ON l.city = rcity.id
                    LEFT JOIN tbl_city_areas carea ON l.area = carea.city_id 
                    LEFT JOIN tbl_product prod ON l.product = prod.id 
                    LEFT JOIN tbl_source sour ON l.source = sour.id
                    LEFT JOIN tbl_users usr ON l.lead_assignee = usr.id
                    LEFT JOIN tbl_users usr2 ON l.lead_assigned_to = usr2.id
                GROUP BY l.lead_id";

        return $this->mysqli_lib->fetch_all($query);
    }
}
