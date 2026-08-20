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

    // $objPHPExcel = new PHPExcel();
    // $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
    // $objPHPExcel->setActiveSheetIndex(0);
    // $objPHPExcel->getActiveSheet()->setTitle('Complaint Raw Data');
    // $objPHPExcel->getActiveSheet()->getStyle("A1:AB1")->applyFromArray(array("font" => array("bold" => true)));

    // //set column width
    // $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
    // $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);

    // //set column Name
    // $objPHPExcel->setActiveSheetIndex(0)
    //     ->setCellValue('A1', 'Complaint ID')
    //     ->setCellValue('B1', 'Status')
    //     ->setCellValue('C1', 'Customer Name')
    //     ->setCellValue('D1', 'Policy Number')
    //     ->setCellValue('E1', 'Released By')
    //     ->setCellValue('F1', 'Assigned To')
    //     ->setCellValue('G1', 'Complaint Department')
    //     ->setCellValue('H1', 'Complaint Type')
    //     ->setCellValue('I1', 'Complaint TAT')
    //     ->setCellValue('J1', 'Complaint Mode')
    //     ->setCellValue('K1', 'Created Date')
    //     ->setCellValue('L1', 'End Date')
    //     ->setCellValue('M1', 'Closed Date')
    //     ->setCellValue('N1', 'Source')
    //     ->setCellValue('O1', 'Priority')
    //     ->setCellValue('P1', 'Policy Issuance Date')
    //     ->setCellValue('Q1', 'Status Policy')
    //     ->setCellValue('Q1', 'Plan Nature')
    //     ->setCellValue('S1', 'Premium Amount')
    //     ->setCellValue('T1', 'Refund Amount')
    //     ->setCellValue('U1', 'Claim Amount')
    //     ->setCellValue('V1', 'Reported dt')
    //     ->setCellValue('W1', 'Received Date')
    //     ->setCellValue('X1', 'Over All Satisfaction')
    //     ->setCellValue('Y1', 'Resolution Time Satisfaction')
    //     ->setCellValue('Z1', 'Staff Behavior')
    //     ->setCellValue('AA1', 'Feedback Comments')
    //     ->setCellValue('AB1', 'Feedback Date');
    
    // //set row values
    // $i = 2;
    // foreach($data as $row)
    // {
    //     $status = $row['cmpStatus'];

    //     if($status == 1)
    //     {
    //         $status = "Initiated";
    //     }
    //     else if($status == 2)
    //     {
    //         $status = "In Progress";
    //     }
    //     else if($status == 3)
    //     {
    //         $status = "Resolved";
    //     }


    //     $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A'.$i, $row['complaint_num'])
    //         ->setCellValue('B'.$i, $status)
    //         ->setCellValue('C'.$i, $row['customer_name'])
    //         ->setCellValue('D'.$i, $row['policy_num'])
    //         ->setCellValue('E'.$i, $row['ReleasedBy'])
    //         ->setCellValue('F'.$i, $row['AssignedTo'])
    //         ->setCellValue('G'.$i, $row['depart'])
    //         ->setCellValue('H'.$i, $row['ComplaintType'])
    //         ->setCellValue('I'.$i, $row['tat'])
    //         ->setCellValue('J'.$i, $row['type'])
    //         ->setCellValue('K'.$i, excelDate($row['create_date'])) 
    //         ->setCellValue('L'.$i, excelDate($row['end_date']))
    //         ->setCellValue('M'.$i, excelDate($row['close_date']))
    //         ->setCellValue('N'.$i, $row['Source'])
    //         ->setCellValue('O'.$i, $row['priority_id'])
    //         ->setCellValue('P'.$i, excelDate($row['policy_issuance_date']))
    //         ->setCellValue('Q'.$i, $row['status_policy'])
    //         ->setCellValue('R'.$i, $row['plan_nature'])
    //         ->setCellValue('S'.$i, $row['premium_amount'])
    //         ->setCellValue('T'.$i, $row['refund_amount'])
    //         ->setCellValue('U'.$i, $row['claim_amount'])
    //         ->setCellValue('V'.$i, $row['reported_dt'])
    //         ->setCellValue('W'.$i, excelDate($row['received_date']))
    //         ->setCellValue('X'.$i, $row['over_all_satisfaction'])
    //         ->setCellValue('Y'.$i, $row['resolution_time_satisfaction'])
    //         ->setCellValue('Z'.$i, $row['staff_behavior'])
    //         ->setCellValue('AA'.$i, $row['feedback_comments'])
    //         ->setCellValue('AB'.$i, excelDate($row['feedback_date']));
    //     $i++;
    // }

    // //create excelsheet
    // $objPHPExcel->setActiveSheetIndex(0);
    // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    // //write excelsheet
    // $filename = "export_complaint_raw_data";
    // //$objWriter->save(str_replace(__FILE__,'template/'.$filename,__FILE__));

    // header('Content-Type: application/vnd.openXMLformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
    // header('Cache-Control: max-age=0');
    // $objWriter->save('php://output');
