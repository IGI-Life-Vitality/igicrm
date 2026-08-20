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
	$TaskCategory = isset($_POST['TaskCategory'])?$_POST['TaskCategory']: '';
	$SubCategory  = isset($_POST['SubCategory'])?$_POST['SubCategory']: '';
	$txtISM       = isset($_POST['txtISM'])?$_POST['txtISM']: '';
	$tsk_status   = isset($_POST['tsk_status'])?$_POST['tsk_status']: '';
	$FromDate     = isset($_POST['FromDate'])?$_POST['FromDate']: '';
	$ToDate       = isset($_POST['ToDate'])?$_POST['ToDate']: '';
	$policy       = isset($_POST['policy'])?$_POST['policy']: '';
	// echo json_encode($_REQUEST);die;
	//define index of column
	$columns = array( 
		0 => 'task_num',
		1 => 'task_status_id',
		2 => 'policy_number',
		3 => 'cat',
		4 => 'subcat',
		5 => 'ism',
		6 => 'task_start_datetime',
		7 => 'task_end_datetime',
		8 => 'assignedTo',
		9 => 'assignedBy',
		10 => 'parent_task_id',
		11 => 'task_id'
	);

	$where = $sqlTot = $sqlRec = "";
	$whereAnd = '';
	if($TaskCategory != '')
        {
            $whereAnd .= " AND t.task_cat = '$TaskCategory'";
        }

        if($SubCategory != '')
        {
            $whereAnd .= " AND t.task_subcat = '$SubCategory'";
        }

        if($txtISM != '')
        {
            $whereAnd .= " AND t.task_ism = '$txtISM'";
        }

        if($tsk_status != '')
        {
            $whereAnd .= " AND t.task_status_id = '$tsk_status'";
        }

        if($FromDate != '' && $ToDate != '')
        {
            $whereAnd .= " AND DATE(t.task_start_datetime) BETWEEN '$FromDate' AND '$ToDate'";
        }

        if($policy != '')
        {
            $whereAnd .= " AND t.policy_number = '$policy'";
        }
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
				t.task_num,
				t.task_status_id,
				t.policy_number,
				cat.fullname AS cat,
				subcat.fullname AS subcat,
				ism.fullname AS ism,
				t.task_start_datetime,
				t.task_end_datetime,
				usr.user_name AS assignedTo,
				us.user_name AS assignedBy,
				t.parent_task_id,
				t.task_id
			FROM tbl_task_new t 
				LEFT JOIN tbl_users us ON us.id = t.task_assignee 
				LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to
				LEFT JOIN tbl_task_category cat ON cat.id = t.task_cat
				LEFT JOIN tbl_task_subcategory subcat ON subcat.id = t.task_subcat
				LEFT JOIN tbl_task_isam ism ON ism.id = t.task_ism
				where 1=1 $whereAnd";
    }
    else if($user_type == 2)
    {
    	$sql = "SELECT
				t.task_num,
				t.task_status_id,
				t.policy_number,
				cat.fullname AS cat,
				subcat.fullname AS subcat,
				ism.fullname AS ism,
				t.task_start_datetime,
				t.task_end_datetime,
				usr.user_name AS assignedTo,
				us.user_name AS assignedBy,
				t.parent_task_id,
				t.task_id
			FROM tbl_task_new t 
				LEFT JOIN tbl_users us ON us.id = t.task_assignee 
				LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to
				LEFT JOIN tbl_task_category cat ON cat.id = t.task_cat
				LEFT JOIN tbl_task_subcategory subcat ON subcat.id = t.task_subcat
				LEFT JOIN tbl_task_isam ism ON ism.id = t.task_ism 
			WHERE us.group_id IN ($group_id) $whereAnd";
    }
    else if($user_type == 4)
    {
    	$sql = "SELECT
				t.task_num,
				t.task_status_id,
				t.policy_number,
				cat.fullname AS cat,
				subcat.fullname AS subcat,
				ism.fullname AS ism,
				t.task_start_datetime,
				t.task_end_datetime,
				usr.user_name AS assignedTo,
				us.user_name AS assignedBy,
				t.parent_task_id,
				t.task_id
			FROM tbl_task_new t 
				LEFT JOIN tbl_users us ON us.id = t.task_assignee 
				LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to
				LEFT JOIN tbl_task_category cat ON cat.id = t.task_cat
				LEFT JOIN tbl_task_subcategory subcat ON subcat.id = t.task_subcat
				LEFT JOIN tbl_task_isam ism ON ism.id = t.task_ism 
			WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' $whereAnd";
    }
    else
    {
    	$sql = "SELECT
				t.task_num,
				t.task_status_id,
				t.policy_number,
				cat.fullname AS cat,
				subcat.fullname AS subcat,
				ism.fullname AS ism,
				t.task_start_datetime,
				t.task_end_datetime,
				usr.user_name AS assignedTo,
				us.user_name AS assignedBy,
				t.parent_task_id,
				t.task_id
			FROM tbl_task_new t 
				LEFT JOIN tbl_users us ON us.id = t.task_assignee 
				LEFT JOIN tbl_users usr ON usr.id = t.task_assigned_to
				LEFT JOIN tbl_task_category cat ON cat.id = t.task_cat
				LEFT JOIN tbl_task_subcategory subcat ON subcat.id = t.task_subcat
				LEFT JOIN tbl_task_isam ism ON ism.id = t.task_ism 
			WHERE t.task_assignee = '$login_id' OR t.task_assigned_to = '$login_id' AND t.parent_task_id = '0' $whereAnd";
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
		$nestedData   = array();

		$task_end_datetime = $row['task_end_datetime'];
        $current_datetime  = Date('Y-m-d');
        $task_status_id    = $row['task_status_id'];

        if($task_status_id == 1)
        {
            $task_status_id = "Initiated";
            $btnType = "btn-primary";
        }
        elseif($task_status_id == 2)
        {
            $task_status_id = "In Progress";
            $btnType = "btn-info";
        }
        elseif($task_status_id == 3)
        {
            $task_status_id = "Closed";
            $btnType = "btn-warning";
        }
        elseif($task_status_id == 4)
        {
            $task_status_id = "Verified";
            $btnType = "btn-success";
        }
        elseif($task_status_id == 5)
        {
            $task_status_id = "Invalid";
            $btnType = "btn-danger";
        }
        elseif($task_status_id == 6)
        {
            $task_status_id = "Onhold";
            $btnType = "btn-default";
        }

        $task_id 		= $row['task_id'];
		$task_num 		= "<a href='task_details.php?id=$task_id'>".$row['task_num']."</a>";
		$task_status 	= "<a href='task_details.php?id=$task_id' class='btn btn-xs $btnType full-width'>".$task_status_id."</a>";

		if($row['parent_task_id'] != "0" || $row['parent_task_id'] != 0)
		{
			$subtask = "<a href='task_details.php?id=$task_id' class='btn btn-danger btn-xs full-width'>SubTask</a>";
		}
		else
		{
			$subtask = "";
		}
		
		$nestedData[] = $task_num;							
		$nestedData[] = $task_status;						
		$nestedData[] = $row['policy_number'];				
		$nestedData[] = $row['cat'];				
		$nestedData[] = $row['subcat'];
		$nestedData[] = $row['ism'];
		$nestedData[] = $row['task_start_datetime'];
		$nestedData[] = $row['task_end_datetime'];
		$nestedData[] = $row['assignedTo'];
		$nestedData[] = $row['assignedBy'];
		$nestedData[] = $subtask;
		$data[] 	  = $nestedData;
	}

	$json_data = array(
					"draw"            => intval($params['draw']),
					"recordsTotal"    => intval($totalRecords),
					"recordsFiltered" => intval($totalRecords),
					"data"            => $data   					//Total data array
				);

	echo json_encode($json_data);  	//Send data as json format
?>
	