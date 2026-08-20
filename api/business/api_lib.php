<?php
class api_lib
{
    private $mysqli_lib;

    function __construct()
    {
        include('business/mysqli_lib.php');
        global $host, $un, $pass, $db, $api_path;
        $this->mysqli_lib = new Mysqli_Lib($host, $un, $pass, $db);
    }

    // Used 1st
    function save_lead($name, $email, $mobile, $intersted_product, $created_date, $lead_source)
    {
        $exced_time      = date("Y-m-d", strtotime("+30 days"));
        $data_counter    = explode('|', $this->GenLeadCounter());
        $counter_display = $data_counter[0];
        $counter         = $data_counter[1];

        $query = "INSERT into tbl_leads(lead_daily_counter,lead_num,fname,mobile_no,email,product,source,group_id,lead_exceded_datetime,lead_create_date,lead_update_date,lead_status_id,is_completed) VALUES ('$counter','$counter_display','$name','$mobile','$email','$intersted_product','$lead_source','3','$exced_time',NOW(),NOW(),'1','0')";
        $res_query = $this->mysqli_lib->insert($query);

        if (!empty($res_query)) {
            $return = "success";
            $msg = "Thank you for contacting IGI Life Insurance. Your ticket number is $counter_display. Kindly use this for further queries. Our representative will get in touch with you shortly.\\nFor any further assistance, you can call 021 111 111 711";
            $msg = str_replace(' ', '%20', $msg);
            $mobile = $this->check_num($mobile);
            $url = "http://10.40.64.15/igicrm/send-sms.php?msg=$msg&msisdn=$mobile";
            $res = file_get_contents($url);

            $data[0] = array(
                'status' => $return
            );
            return json_encode($data);
        } else {
            $return = "fail";

            $data[0] = array(
                'status' => $return
            );
            return json_encode($data);
        }
    }

    function GenLeadCounter()
    {
        $first_digit = "LM";
        $today = date("Y-m-d");
        $date_part = date("ymd");

        $sql = "SELECT IFNULL(MAX(lead_daily_counter)+1,1) AS daily_counter FROM `tbl_leads` WHERE DATE(`lead_create_date`) = '$today'";
        $row = $this->mysqli_lib->fetch_all($sql);
        $second_digit = sprintf('%03d', (int)$row[0]['daily_counter']);
        $next_counter = $first_digit . $date_part . $second_digit;
        return $next_counter . "|" . $row[0]['daily_counter'];
    }

    function invalidRequest($opt = '', $msg = '')
    {
        $opt = !empty($opt) ? " with [$opt] option." : '';

        $data[0] = array(
            'status' => 'invalid request' . $opt,
            'msg' => $msg
        );

        return json_encode($data);
    }

    // Used
    function missing_params()
    {
        $data[0] = array(
            'status'   => 'Some Parameters Missing'
        );

        return json_encode($data);
    }

    function insert_logs($deviceid, $menu)
    {
        $query = "INSERT INTO tbl_logs (deviceid,menu) VALUES ('" . $deviceid . "', '" . $menu . "')";
        $this->mysqli_lib->insert($query);
    }
    function check_num($mobile)
    {
        $msisdn = trim($mobile);
        $initial = substr($msisdn, 0, 2);
        if ($initial == '03' || $initial == '92') {
            if ($initial == '03') {
                $msisdn = '92' . substr($msisdn, 1, strlen($msisdn));
            }
        }
        return $msisdn;
    }

    function complaintFeedback($complaintType,$dataToUpdate,$where)
    {

        if ($complaintType == 'individual') {
            $table='tbl_complaints_life';
            return $this->updateRecord($table, $dataToUpdate, $where);
        } 
        else if ($complaintType == 'internal') {
            $table='tbl_complaints_internal';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }
        else if ($complaintType == 'corporate') {
            $table='tbl_complaints_cooperate';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }
        else if ($complaintType == 'legal') {
            $table='tbl_complaints_legal';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }
        else if ($complaintType == 'bancaIndividual') {
            $table='tbl_complaints_banca';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }
        else if ($complaintType == 'vatality') {
            $table='tbl_complaints_vatality';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }
        else if ($complaintType == 'bancaBank') {
            $table='tbl_complaints_banca_bank';
            return $this->updateRecord($table, $dataToUpdate, $where);
        }

        return json_encode(
                array(
                    'status'  => 'fail',
                    'message' => 'Complaint not updated. Call the admin',
                )
            );
    }


    private function updateRecord($table, $data, $where)
    {
        $query = "SELECT * 
          FROM {$table} 
          WHERE complaint_num = '{$where['complaint_num']}' 
          AND feedback_date is not null";

        $response = $this->mysqli_lib->fetch_all($query);

        if ($response != 0) {
            return json_encode(
                array(
                    'status'  => 'fail',
                    'message' => 'You have already given feedback',
                )
            );
        }
        // Build SET part of query
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = '{$value}'";
        }
        $setQuery = implode(", ", $setParts);

        // Build WHERE part
        $whereParts = [];
        foreach ($where as $key => $value) {
            $whereParts[] = "$key = '{$value}'";
        }
        $whereQuery = implode(" AND ", $whereParts);

        // Final query
        $query = "UPDATE {$table} SET {$setQuery} WHERE {$whereQuery}";

        // Run update
        $success = $this->mysqli_lib->update($query);
        
        // Return JSON
        if ($success) {
            return json_encode(
                array(
                    'status'  => 'success',
                    'message' => 'Complaint successfully updated',
                )
            );
        } else {
            return json_encode(
                array(
                    'status'  => 'fail',
                    'message' => 'Complaint not updated. Call the admin....',
                )
            );
        }
    }
}
