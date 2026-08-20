<?php
	//include connection file
	require_once("../includes/config.php");

	ini_set('max_execution_time', 2048); //300 seconds = 10 minutes
	ini_set("memory_limit", "-1");
	set_time_limit(0);

	$login_id   = $_SESSION['login_id'];
    	$user_type  = $_SESSION['user_type'];
    	$group_id   = $_SESSION['group_id'];

	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 => 'complaint_num',
		1 => 'cmpStatus',
		2 => 'customer_name',
		3 => 'policy_num',
		4 => 'ReleasedBy',
		5 => 'AssignedTo',
		6 => 'depart',
		7 => 'ComplaintType',
		8 => 'tat',
		9 => 'type',
		10 => 'create_date',
		11 => 'end_date',
		12 => 'close_date',
		13 => 'Source',
		14 => 'priority_id',
		15 => 'file_counter'
	);

	$where = $sqlTot = $sqlRec = "";

	// check search value exist - Disbaled due to custome search
	/*if( !empty($params['search']['value']) ) 
	{   
		if($user_type == 1)
    	{
			$where .=" WHERE ";
			$where .=" ( vw.complaint_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR vw.policy_num LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.customer_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.ReleasedBy LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.AssignedTo LIKE '".$params['search']['value']."%' )";
    	}
    	else if($user_type == 2)
    	{
			$where .=" AND ( vw.complaint_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR vw.policy_num LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.customer_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.ReleasedBy LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.AssignedTo LIKE '".$params['search']['value']."%' )";
    	}
    	else
    	{
			$where .=" AND ( vw.complaint_num LIKE '".$params['search']['value']."%' ";    
			$where .=" OR vw.policy_num LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.customer_name LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.ReleasedBy LIKE '".$params['search']['value']."%' ";
			$where .=" OR vw.AssignedTo LIKE '".$params['search']['value']."%' )";
    	}
	}*/

	// getting total number records without any search
	if($user_type == 1)
    {
        $sql = "SELECT 	
				vw.complaint_num,
				vw.cmpStatus,
				vw.customer_name,
				vw.policy_num,
				vw.ReleasedBy,
				vw.AssignedTo,
				vw.depart,
				vw.ComplaintType,
				vw.tat,
				vw.type,
				vw.create_date,
				vw.end_date,
				vw.close_date,
				vw.Source,
				vw.priority_id,
				vw.file_counter,
				vw.complaint_id,
				vw.mode,
				vw.status_id
			FROM 
				vw_complaint_view vw";
    }
    else if($user_type == 2)
    {
    	$sql = "SELECT 	
				vw.complaint_num,
				vw.cmpStatus,
				vw.customer_name,
				vw.policy_num,
				vw.ReleasedBy,
				vw.AssignedTo,
				vw.depart,
				vw.ComplaintType,
				vw.tat,
				vw.type,
				vw.create_date,
				vw.end_date,
				vw.close_date,
				vw.Source,
				vw.priority_id,
				vw.file_counter,
				vw.complaint_id,
				vw.mode,
				vw.status_id
			FROM 
				vw_complaint_view vw 
			WHERE vw.group_id IN ($group_id)";
    }
    else
    {
    	$sql = "SELECT 	
				vw.complaint_num,
				vw.cmpStatus,
				vw.customer_name,
				vw.policy_num,
				vw.ReleasedBy,
				vw.AssignedTo,
				vw.depart,
				vw.ComplaintType,
				vw.tat,
				vw.type,
				vw.create_date,
				vw.end_date,
				vw.close_date,
				vw.Source,
				vw.priority_id,
				vw.file_counter,
				vw.complaint_id,
				vw.mode,
				vw.status_id
			FROM 
				vw_complaint_view vw
			WHERE vw.agent_id = '$login_id' OR vw.user_id = '$login_id'";
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
 	//echo json_encode($sqlRec); die;

	$queryTot 	  = $obj_mysql->fetch_all($sqlTot);
	$totalRecords = count($queryTot);
	$queryRecords = $obj_mysql->fetch_all($sqlRec);

	//iterate on results row and create new index array of data
	foreach($queryRecords as $row)
	{ 
		$nestedData = array();
        $cmp_status = $row['cmpStatus'];
        $status_id  = $row['status_id'];

        if($status_id == 1)
        {
            $cmp_status = "Initiated";
            $btnType = "btn-primary";
        }
        elseif($status_id == 2)
        {
            $cmp_status = "In Progress";
            $btnType = "btn-info";
        }
        elseif($status_id == 3)
        {
            $cmp_status = "Closed";
            $btnType = "btn-warning";
        }
        elseif($status_id == 4)
        {
            $cmp_status = "UnResolved";
            $btnType = "btn-success";
        }
        elseif($status_id == 5)
        {
            $cmp_status = "Invalid";
            $btnType = "btn-danger";
        }
        elseif($status_id == 6)
        {
            $cmp_status = "UnResolved";  //Onhold
            $btnType = "btn-default";
        }

        $complaint_id   = $row['complaint_id'];
        $cmode   		= $row['type'];
		$complaint_edit='';
		$complaint_num  = "<a href='complaint_details.php?id=$complaint_id&cmode=$cmode'>".$row['complaint_num']."</a>";
		if($status_id != '3' && $user_type == '2'){
		$complaint_edit  = "<a class='btn btn-primary btn-xs checkUpdate' href='complaint_edit.php?id=$complaint_id&cmode=$cmode'>
                                        Edit <i class='glyphicon glyphicon-edit icon-white'></i>
                                    </a>";
		}
		$cmp_status 	= "<a href='complaint_details.php?id=$complaint_id&cmode=$cmode' class='btn btn-xs $btnType full-width'>".ucfirst($cmp_status)."</a>";
		
		$nestedData[] = $complaint_num;							
		$nestedData[] = $cmp_status;						
		$nestedData[] = $row['customer_name'];				
		$nestedData[] = $row['policy_num'];
		$nestedData[] = $row['ReleasedBy'];
		$nestedData[] = $row['AssignedTo'];
		$nestedData[] = $row['depart'];
		$nestedData[] = $row['ComplaintType'];
		$nestedData[] = $row['tat'];
		$nestedData[] = $row['type'] == 'vatality' ? 'Vitality' : ucfirst($row['type']);
		$nestedData[] = $row['create_date'];
		$nestedData[] = $row['end_date'];
		$nestedData[] = $row['close_date'];
		$nestedData[] = $row['Source'];
		$nestedData[] = $row['priority_id'];
		$nestedData[] = $row['file_counter'];
		$nestedData[] = $complaint_edit;
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
	
