<?php
	//include connection file
	require_once("../includes/config.php");
	include('../classes/lead.php');

	ini_set('max_execution_time', 2048); //300 seconds = 10 minutes
	ini_set("memory_limit", "-1");
	set_time_limit(0);

	$objLead = new Lead();

	$login_id   = $_SESSION['login_id'];
    $group_id   = $_SESSION['group_id'];
    $user_type  = $_SESSION['user_type'];
    $product_id = $_SESSION['product_id'];

    //echo json_encode($product_id); die;
    //print_r($product_id);die

	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 => 'lead_num',
		1 => 'lead_status_id',
		2 => 'lead_name',
		3 => 'product_name',
		4 => 'mobile_no',
		5 => 'call_time',
		6 => 'city',
		7 => 'area',
		8 => 'assigneeBy',
		9 => 'assigneeTo',
		10 => 'lead_create_date',
		11 => 'lead_exceded_datetime',
		12 => 'lead_id'
	);

	$where = $sqlTot = $sqlRec = "";

	// check search value exist - Disbaled due to custome search
	/*if( !empty($params['search']['value']) ) 
	{   
		if($user_type == 1)
    	{
			$where .=" WHERE ";
			$where .=" ( t.task_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR t.policy_number LIKE '".$params['search']['value']."%' ";
			$where .=" OR usr.user_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR us.user_name LIKE '".$params['search']['value']."%' )";
    	}
    	else if($user_type == 2)
    	{
			$where .=" AND ( t.task_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR t.policy_number LIKE '".$params['search']['value']."%' ";
			$where .=" OR usr.user_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR us.user_name LIKE '".$params['search']['value']."%' )";
    	}
    	else
    	{
			$where .=" AND ( t.task_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR t.policy_number LIKE '".$params['search']['value']."%' ";
			$where .=" OR usr.user_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR us.user_name LIKE '".$params['search']['value']."%' )";
    	}
	}*/

	// getting total number records without any search
	if($user_type == 1)
    {
    	$sql = "SELECT 
					l.lead_num,
					l.lead_status_id,
					CONCAT(l.fname, ' ', l.lname) lead_name,
					pro.fullname as product_name,
					l.mobile_no,
					l.call_time,
					c.fullname city,
					ca.area 'area',
					CONCAT(us.first_name, ' ', us.last_name) assigneeBy,
					CONCAT(usrr.first_name, ' ', usrr.last_name) assigneeTo,
					l.lead_create_date,
					l.lead_exceded_datetime,
					l.lead_id
				FROM tbl_leads l
					LEFT JOIN tbl_leads_status ls 	ON ls.id = l.lead_status_id 
					LEFT JOIN tbl_users us 			ON us.id = l.agent_id 
					LEFT JOIN tbl_users usr 		ON usr.id = l.lead_assignee 
					LEFT JOIN tbl_users usrr 		ON usrr.id = l.lead_assigned_to
					LEFT JOIN tbl_region_city c 	ON c.id = l.city 
					LEFT JOIN tbl_city_areas ca 	ON ca.id = l.area 
					LEFT JOIN tbl_source sr 		ON sr.id = l.source
					LEFT JOIN tbl_product pro 		ON pro.id = l.product";
    }
    else if($user_type == 2)
    {
    	$sql = "SELECT 
					l.lead_num,
					l.lead_status_id,
					CONCAT(l.fname, ' ', l.lname) lead_name,
					pro.fullname as product_name,
					l.mobile_no,
					l.call_time,
					c.fullname city,
					ca.area 'area',
					CONCAT(us.first_name, ' ', us.last_name) assigneeBy,
					CONCAT(usrr.first_name, ' ', usrr.last_name) assigneeTo,
					l.lead_create_date,
					l.lead_exceded_datetime,
					l.lead_id
				FROM tbl_leads l
					LEFT JOIN tbl_leads_status ls 	ON ls.id = l.lead_status_id 
					LEFT JOIN tbl_users us 			ON us.id = l.agent_id 
					LEFT JOIN tbl_users usr 		ON usr.id = l.lead_assignee 
					LEFT JOIN tbl_users usrr 		ON usrr.id = l.lead_assigned_to
					LEFT JOIN tbl_region_city c 	ON c.id = l.city 
					LEFT JOIN tbl_city_areas ca 	ON ca.id = l.area 
					LEFT JOIN tbl_source sr 		ON sr.id = l.source
					LEFT JOIN tbl_product pro 		ON pro.id = l.product
			WHERE l.product IN ($product_id)";
    }
    else
    {
    	$sql = "SELECT 
					l.lead_num,
					l.lead_status_id,
					CONCAT(l.fname, ' ', l.lname) lead_name,
					pro.fullname as product_name,
					l.mobile_no,
					l.call_time,
					c.fullname city,
					ca.area 'area',
					CONCAT(us.first_name, ' ', us.last_name) assigneeBy,
					CONCAT(usrr.first_name, ' ', usrr.last_name) assigneeTo,
					l.lead_create_date,
					l.lead_exceded_datetime,
					l.lead_id
				FROM tbl_leads l
					LEFT JOIN tbl_leads_status ls 	ON ls.id = l.lead_status_id 
					LEFT JOIN tbl_users us 			ON us.id = l.agent_id 
					LEFT JOIN tbl_users usr 		ON usr.id = l.lead_assignee 
					LEFT JOIN tbl_users usrr 		ON usrr.id = l.lead_assigned_to
					LEFT JOIN tbl_region_city c 	ON c.id = l.city 
					LEFT JOIN tbl_city_areas ca 	ON ca.id = l.area 
					LEFT JOIN tbl_source sr 		ON sr.id = l.source
					LEFT JOIN tbl_product pro 		ON pro.id = l.product
			WHERE l.lead_assignee = '$login_id' OR l.lead_assigned_to = '$login_id'";
    }

	//Check sql query without WHERE clouse
	//echo json_encode($sql); die;

	$sqlTot .= $sql;
	$sqlRec .= $sql;

	//Concatenate search sql if value exist
	if(isset($where) && $where != '') 
	{
		$sqlTot .= $where;
		$sqlRec .= $where;
	}

	//Check sql query with WHERE clouse
	//echo json_encode($sqlRec); die;

 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']." LIMIT ".$params['start']." ,".$params['length']." ";

 	//Check sql query with ORDER BY and LIMIT clouse
 	//echo print_r($sqlRec); die;

	$queryTot 	  = $obj_mysql->fetch_all($sqlTot);
	$totalRecords = count($queryTot);
	$queryRecords = $obj_mysql->fetch_all($sqlRec);

	//iterate on results row and create new index array of data
	foreach($queryRecords as $row)
	{ 
		$nestedData = array();

		$lead_end_datetime 	= $row["lead_exceded_datetime"];
        $current_datetime  	= date('Y-m-d H:i:s');
        $lead_status_id 	= $row['lead_status_id'];

        $deff = $objLead->LeadTime($current_datetime,$lead_end_datetime);

        if($deff < 0 && ($lead_status_id == 1 || $lead_status_id == 2))
        { 
            $lead_status_id = "Not Mutured";
            $btnType = "btn-danger full-width";
        }

        if($lead_status_id == 1)
        {
          $lead_status_id = "Initiated";
          $btnType = "btn-primary full-width";
        }
        elseif($lead_status_id == 2)
        {
          $lead_status_id = "In Progress";
          $btnType = "btn-info full-width";
        }
        elseif($lead_status_id == 3)
        {
          $lead_status_id = "Follow-up";
          $btnType = "btn-warning full-width";
        }
        elseif($lead_status_id == 4)
        {
          $lead_status_id = "Bought";
          $btnType = "btn-success full-width";
        }
        elseif($lead_status_id == 5)
        {
          $lead_status_id = "Not Intersted";
          $btnType = "btn-danger full-width";
        }
        elseif($lead_status_id == 6)
        {
          $lead_status_id = "General Query";
          $btnType = "btn-default full-width";
        }

        $lead_id 		= $row['lead_id'];
		$lead_num 		= "<a href='leads_details.php?id=$lead_id'>".$row['lead_num']."</a>";
		$lead_status 	= "<a href='leads_details.php?id=$lead_id' class='btn btn-xs $btnType full-width'>".$lead_status_id."</a>";
		
		$nestedData[] = $lead_num;							
		$nestedData[] = $lead_status;		
		$nestedData[] = $row['lead_name'];				
		$nestedData[] = $row['product_name'];				
		$nestedData[] = $row['mobile_no'];
		$nestedData[] = $row['call_time'];
		$nestedData[] = $row['city'];
		$nestedData[] = $row['area'];
		$nestedData[] = $row['assigneeBy'];
		$nestedData[] = $row['assigneeTo'];
		$nestedData[] = $row['lead_create_date'];
		$nestedData[] = $row['lead_exceded_datetime'];
		$data[] 	  = $nestedData;
	}

	$json_data = array(
					"draw"            => intval($params['draw']),
					"recordsTotal"    => intval($totalRecords),
					"recordsFiltered" => intval($totalRecords),
					"data"            => $data   					//Total data array
				);

	echo json_encode($json_data);  //Send data as json format
?>
