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

    <!-- $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Legal Complaint Raw Data');
    $objPHPExcel->getActiveSheet()->getStyle("A1:AZ1")->applyFromArray(array("font" => array("bold" => true)));

    //set column width
    $objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AE")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AF")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AG")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AH")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AI")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AK")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AL")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AM")->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension("AN")->setAutoSize(true);
    //set column Name
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ticket #')
            // ->setCellValue('B1', 'Registration Date')
            ->setCellValue('B1', 'Created Date')
            ->setCellValue('C1', 'Complaint Received Date')
            ->setCellValue('D1', 'Letter/Complaint No')
            ->setCellValue('E1', 'Policy Number')
            ->setCellValue('F1', 'Complainant Name')
            ->setCellValue('G1', 'CNIC/NiCop')
            ->setCellValue('H1', 'Contact No')
            ->setCellValue('I1', 'Email Address')
            ->setCellValue('J1', 'Policy Issuance Date')
            ->setCellValue('K1', 'Status of Policy')
            ->setCellValue('L1', 'Plan Nature')
            ->setCellValue('M1', 'Product Nature')
            ->setCellValue('N1', 'Source')
            ->setCellValue('O1', 'Logged By')
            ->setCellValue('P1', 'Department')
            ->setCellValue('Q1', 'Complaint Type')
            ->setCellValue('R1', 'Assign To')
            ->setCellValue('S1', 'Amount of Premium')
            ->setCellValue('T1', 'Amount of Refund/Loss')
            ->setCellValue('U1', 'Amount Claim/Fraud Prevent')
            ->setCellValue('V1', 'Forums')
            ->setCellValue('W1', 'Bank Name')
            ->setCellValue('X1', 'Nominated Agent Name')
            ->setCellValue('Y1', 'Agent Code')
            ->setCellValue('Z1', 'Unit Name')
            ->setCellValue('AA1', 'AM Name')
            ->setCellValue('AB1', 'Region')
            ->setCellValue('AC1', 'City')
            ->setCellValue('AD1', 'Priority/TAT')
            ->setCellValue('AE1', 'Status')
            ->setCellValue('AF1', 'Resolution Date')
            ->setCellValue('AG1', 'End Date')
            ->setCellValue('AH1', 'Aging (Overdue)')
            ->setCellValue('AI1', 'Comments')
            ->setCellValue('AJ1', 'Description')
            ->setCellValue('AK1', 'Over All Satisfaction')
            ->setCellValue('AL1', 'Resolution Time Satisfaction')
            ->setCellValue('AM1', 'Staff Behavior')
            ->setCellValue('AN1', 'Feedback Comments')
            ->setCellValue('AO1', 'Feedback Date');
    
    //set row values
    $i = 2;
    foreach($data as $row)
    {
            // 1st date
        $resolution_date = substr($row['close_date'],0,10);

        // 2nd date
        $createdDate=($row['received_date'] == null || $row['received_date'] == '' || $row['received_date'] == '0000-00-00') ? substr($row['create_date'],0,10) : substr($row['received_date'],0,10);
        $cdate  = $createdDate ;
        $date   = strtotime($cdate);
        $tat    = substr($row['tat'],0,1);
        $create_date = strtotime("+$tat day", $date);
        $close_date = date('Y-m-d', $create_date);

        if($resolution_date == '0000-00-00')
        {
            $today  = DATE('Y-m-d');
            $start  = date_create($close_date);
            $end    = date_create($today);
            $diff   = date_diff($start,$end);
            $re = $diff->format('%R%a Days');
        }
        else
        {
            $re = $objComplaintReport->cmpOverdue($resolution_date, $close_date);
        }

        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $row['complaint_num'])
             ->setCellValue('B'.$i, excelDate($row['create_date']))
            ->setCellValue('C'.$i, excelDate($row['received_date']))
            ->setCellValue('D'.$i, $row['letter_no'])
            ->setCellValue('E'.$i, $row['policy_num'])
            ->setCellValue('F'.$i, $row['customer_name'])
            ->setCellValue('G'.$i, formatCnicNumber($row['cnic']))
            ->setCellValue('H'.$i, $row['office_phone'])
            ->setCellValue('I'.$i, $row['email'])
            ->setCellValue('J'.$i, excelDate($row['policy_issuance_date']))
            ->setCellValue('K'.$i, $row['status_policy'])
            ->setCellValue('L'.$i, $row['plan_nature'])
            ->setCellValue('M'.$i, $row['product_name'])
            ->setCellValue('N'.$i, $row['Source'])
            ->setCellValue('O'.$i, $row['ReleasedBy'])
            ->setCellValue('P'.$i, $row['depart'])
            ->setCellValue('Q'.$i, $row['ComplaintType'])
            ->setCellValue('R'.$i, $row['AssignedTo'])
            ->setCellValue('S'.$i, $row['premium_amount'])
            ->setCellValue('T'.$i, $row['refun_amount'])
            ->setCellValue('U'.$i, $row['claim_amount'])
            ->setCellValue('V'.$i, $row['forum_name'])
            ->setCellValue('W'.$i, $row['bank'])
            ->setCellValue('X'.$i, $row['agent'])
            ->setCellValue('Y'.$i, $row['agent_code'])
            ->setCellValue('Z'.$i, $row['unit_name'])
            ->setCellValue('AA'.$i, $row['am_name'])
            ->setCellValue('AB'.$i, $row['region'])
            ->setCellValue('AC'.$i, $row['city'])
            ->setCellValue('AD'.$i, $row['tat'])
            ->setCellValue('AE'.$i, ($row['cmpStatus'] == 'closed') ? 'Resolved' : $row['cmpStatus'])
            ->setCellValue('AF'.$i, ($row['cmpStatus'] == 'closed') ? excelDate($row['close_date']) : excelDate($row['forward_date']))
            ->setCellValue('AG'.$i, excelDate($row['end_date']))
            ->setCellValue('AH'.$i, $re)
            ->setCellValue('AI'.$i, $row['comments'])
            ->setCellValue('AJ'.$i, $row['description'])
            ->setCellValue('AK'.$i, $row['over_all_satisfaction'])
            ->setCellValue('AL'.$i, $row['resolution_time_satisfaction'])
            ->setCellValue('AM'.$i, $row['staff_behavior'])
            ->setCellValue('AN'.$i, $row['feedback_comments'])
            ->setCellValue('AO'.$i, excelDate($row['feedback_date']));
        $i++;
    }

    //create excelsheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    //write excelsheet
    $filename = "export_legalcomplaint_raw_data";
    //$objWriter->save(str_replace(__FILE__,'template/'.$filename,__FILE__));

    // header('Content-Type: application/vnd.openXMLformats-officedocument.spreadsheetml.sheet');
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
?> -->
