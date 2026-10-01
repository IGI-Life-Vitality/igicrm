<?php
    include('../includes/config.php');
    include('../classes/complaint.php');
    include('../classes/complaint_rpt.php');
	header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="export_legal_complaint_raw_data.xls"');
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

    $objComplaint = new Complaint();
    $objComplaintReport = new ComplaintReport();
    $data         = $objComplaint->getLegalComplaintRawData($filters);
?>
    <table border="1">
    <thead>
        <tr>
            <th>Ticket #</th>
            <th>Created Date</th>
            <th>Complaint Received Date</th>
            <th>Letter/Complaint No</th>
            <th>Policy Number</th>
            <th>Complainant Name</th>
            <th>CNIC/NiCop</th>
            <th>Contact No</th>
            <th>Email Address</th>
            <th>Policy Issuance Date</th>
            <th>Status of Policy</th>
            <th>Plan Nature</th>
            <th>Product Nature</th>
            <th>Source</th>
            <th>Logged By</th>
            <th>Department</th>
            <th>Complaint Type</th>
            <th>Assign To</th>
            <th>Amount of Premium</th>
            <th>Amount of Refund/Loss</th>
            <th>Amount Claim/Fraud Prevent</th>
            <th>Forums</th>
            <th>Bank Name</th>
            <th>Nominated Agent Name</th>
            <th>Agent Code</th>
            <th>Unit Name</th>
            <th>AM Name</th>
            <th>Region</th>
            <th>City</th>
            <th>Priority/TAT</th>
            <th>Status</th>
            <th>Resolution Date</th>
            <th>End Date</th>
            <th>Aging (Overdue)</th>
            <th>Description</th>
            <th>Comments</th>
            <th>Over All Satisfaction</th>
            <th>Resolution Time Satisfaction</th>
            <th>Staff Behavior</th>
            <th>Feedback Comments</th>
            <th>Feedback Date</th>
        </tr>
    </thead>

    <tbody>

    <?php foreach($data as $row): ?>

        <tr>
            <td><?php echo $row['complaint_num']; ?></td>

            <td><?php echo !empty($row['create_date']) ? date('d/m/Y', strtotime($row['create_date'])) : ''; ?></td>

            <td><?php echo !empty($row['received_date']) ? date('d/m/Y', strtotime($row['received_date'])) : ''; ?></td>

            <td><?php echo $row['letter_no']; ?></td>

            <td><?php echo $row['policy_num']; ?></td>

            <td><?php echo $row['customer_name']; ?></td>

            <td><?php echo  formatCnicNumber($row['cnic']); ?></td>

            <td><?php echo $row['office_phone']; ?></td>

            <td><?php echo $row['email']; ?></td>

            <td><?php echo !empty($row['policy_issuance_date']) ? date('d/m/Y', strtotime($row['policy_issuance_date'])) : ''; ?></td>

            <td><?php echo $row['status_policy']; ?></td>

            <td><?php echo $row['plan_nature']; ?></td>

            <td><?php echo $row['product_name']; ?></td>

            <td><?php echo $row['Source']; ?></td>

            <td><?php echo $row['ReleasedBy']; ?></td>

            <td><?php echo $row['depart']; ?></td>

            <td><?php echo $row['ComplaintType']; ?></td>

            <td><?php echo $row['AssignedTo']; ?></td>

            <td><?php echo $row['premium_amount']; ?></td>

            <td><?php echo $row['refun_amount']; ?></td>

            <td><?php echo $row['claim_amount']; ?></td>

            <td><?php echo $row['forum_name']; ?></td>

            <td><?php echo $row['bank']; ?></td>

            <td><?php echo $row['agent']; ?></td>

            <td><?php echo $row['agent_code']; ?></td>

            <td><?php echo $row['unit_name']; ?></td>

            <td><?php echo $row['am_name']; ?></td>

            <td><?php echo $row['region']; ?></td>

            <td><?php echo $row['city']; ?></td>

            <td><?php echo $row['tat']; ?></td>

            <td>
                <?php
                    if ($row['cmpStatus'] == 1) {
                        echo 'Initiated';
                    } elseif ($row['cmpStatus'] == 2) {
                        echo 'In Progress';
                    } elseif ($row['cmpStatus'] == 3 || $row['cmpStatus'] == 'closed') {
                        echo 'Resolved';
                    } else {
                        echo $row['cmpStatus'];
                    }
                ?>
            </td>

            <td>
                <?php
                    if ($row['cmpStatus'] == 'closed' || $row['cmpStatus'] == 3) {
                        echo !empty($row['close_date']) ? date('d/m/Y', strtotime($row['close_date'])) : '';
                    } else {
                        echo !empty($row['forward_date']) ? date('d/m/Y', strtotime($row['forward_date'])) : '';
                    }
                ?>
            </td>

            <td><?php echo !empty($row['end_date']) ? date('d/m/Y', strtotime($row['end_date'])) : ''; ?></td>

            <td>
                <?php
                    $resolution_date = substr($row['close_date'], 0, 10);

                    $createdDate = ($row['received_date'] == null || $row['received_date'] == '' || $row['received_date'] == '0000-00-00')
                        ? substr($row['create_date'], 0, 10)
                        : substr($row['received_date'], 0, 10);

                    $date = strtotime($createdDate);
                    $tat = substr($row['tat'], 0, 1);
                    $close_date = date('Y-m-d', strtotime("+$tat day", $date));

                    if ($resolution_date == '0000-00-00') {
                        $today = date('Y-m-d');
                        $start = date_create($close_date);
                        $end = date_create($today);
                        $diff = date_diff($start, $end);
                        echo $diff->format('%R%a Days');
                    } else {
                        echo $objComplaintReport->cmpOverdue($resolution_date, $close_date);
                    }
                ?>
            </td>

            <td><?php echo $row['description']; ?></td>
            
            <td><?php echo $row['comments']; ?></td>

            <td><?php echo $row['over_all_satisfaction']; ?></td>

            <td><?php echo $row['resolution_time_satisfaction']; ?></td>

            <td><?php echo $row['staff_behavior']; ?></td>

            <td><?php echo $row['feedback_comments']; ?></td>

            <td><?php echo !empty($row['feedback_date']) ? date('d/m/Y', strtotime($row['feedback_date'])) : ''; ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>
