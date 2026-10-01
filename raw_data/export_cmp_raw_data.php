<?php
    include('../includes/config.php');
    include('../classes/complaint.php');
    include('../third_party/PHPExcelLib/PHPExcel.php');

    $login_id   = $_SESSION['login_id'];
    $user_type  = $_SESSION['user_type'];
    $group_id   = $_SESSION['group_id'];

    $filters = [
        'cnic_se'     => isset($_GET['cnic_se']) ? $_GET['cnic_se'] : '',
		'cmp_num'     => isset($_GET['cmp_num']) ? $_GET['cmp_num'] : '',
		'comp_type'   => isset($_GET['comp_type']) ? $_GET['comp_type'] : '',
		'Agent_Name'  => isset($_GET['Agent_Name']) ? $_GET['Agent_Name'] : '',
		'cmp_status'  => isset($_GET['cmp_status']) ? $_GET['cmp_status'] : '',
		'policy_num'  => isset($_GET['policy_num']) ? $_GET['policy_num'] : '',
		'txtFromDate' => isset($_GET['txtFromDate']) ? $_GET['txtFromDate'] : '',
		'txtToDate'   => isset($_GET['txtToDate']) ? $_GET['txtToDate'] : ''
    ];

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="export_complaint_raw_data.xls"');

    $objComplaint = new Complaint();
    $data         = $objComplaint->getComplaintRawData($filters);
?>
<table border="1">
    <thead>
        <tr>
            <th>Complaint ID</th>
            <th>Status</th>
            <th>Customer Name</th>
            <th>Policy Number</th>
            <th>Released By</th>
            <th>Assigned To</th>
            <th>Complaint Department</th>
            <th>Complaint Type</th>
            <th>Complaint TAT</th>
            <th>Complaint Mode</th>
            <th>Created Date</th>
            <th>End Date</th>
            <th>Closed Date</th>
            <th>Source</th>
            <th>Priority</th>
            <th>Policy Issuance Date</th>
            <th>Status Policy</th>
            <th>Plan Nature</th>
            <th>Premium Amount</th>
            <th>Refund Amount</th>
            <th>Claim Amount</th>
            <th>Reported Date</th>
            <th>Received Date</th>
            <th>Over All Satisfaction</th>
            <th>Resolution Time Satisfaction</th>
            <th>Staff Behavior</th>
            <th>Feedback Comments</th>
            <th>Feedback Date</th>
        </tr>
    </thead>

    <tbody>
<?php foreach ($data as $row): ?>

<?php
    $status = $row['cmpStatus'];

    if ($status == 1) {
        $status = "Initiated";
    } elseif ($status == 2) {
        $status = "In Progress";
    } elseif ($status == 3) {
        $status = "Resolved";
    }
?>

<tr>
    <td><?php echo $row['complaint_num']; ?></td>
    <td><?php echo $status; ?></td>
    <td><?php echo $row['customer_name']; ?></td>
    <td><?php echo $row['policy_num']; ?></td>
    <td><?php echo $row['ReleasedBy']; ?></td>
    <td><?php echo $row['AssignedTo']; ?></td>
    <td><?php echo $row['depart']; ?></td>
    <td><?php echo $row['ComplaintType']; ?></td>
    <td><?php echo $row['tat']; ?></td>
    <td><?php echo $row['type']; ?></td>

    <td><?php echo !empty($row['create_date']) ? date('d/m/Y', strtotime($row['create_date'])) : ''; ?></td>

    <td><?php echo !empty($row['end_date']) ? date('d/m/Y', strtotime($row['end_date'])) : ''; ?></td>

    <td><?php echo !empty($row['close_date']) ? date('d/m/Y', strtotime($row['close_date'])) : ''; ?></td>

    <td><?php echo $row['Source']; ?></td>

    <td><?php echo $row['priority_id']; ?></td>

    <td><?php echo !empty($row['policy_issuance_date']) ? date('d/m/Y', strtotime($row['policy_issuance_date'])) : ''; ?></td>

    <td><?php echo $row['status_policy']; ?></td>

    <td><?php echo $row['plan_nature']; ?></td>

    <td><?php echo $row['premium_amount']; ?></td>

    <td><?php echo $row['refund_amount']; ?></td>

    <td><?php echo $row['claim_amount']; ?></td>

    <td><?php echo !empty($row['reported_dt']) ? date('d/m/Y', strtotime($row['reported_dt'])) : ''; ?></td>

    <td><?php echo !empty($row['received_date']) ? date('d/m/Y', strtotime($row['received_date'])) : ''; ?></td>

    <td><?php echo $row['over_all_satisfaction']; ?></td>

    <td><?php echo $row['resolution_time_satisfaction']; ?></td>

    <td><?php echo $row['staff_behavior']; ?></td>

    <td><?php echo $row['feedback_comments']; ?></td>

    <td><?php echo !empty($row['feedback_date']) ? date('d/m/Y', strtotime($row['feedback_date'])) : ''; ?></td>
</tr>

<?php endforeach; ?>
</tbody>
</table>