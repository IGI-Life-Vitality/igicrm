<?php
    include('../includes/config.php');
    include('../classes/lead_rpt.php');
    include('../third_party/PHPExcelLib/PHPExcel.php');

    $login_id   = $_SESSION['login_id'];
    $user_type  = $_SESSION['user_type'];
    $group_id   = $_SESSION['group_id'];

    $objLeadReport  = new LeadReport();
    $data           = $objLeadReport->getLeadRawData();

    //print_r($data);die;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('Lead Raw Data');
    $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->applyFromArray(array("font" => array("bold" => true)));

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

    //set column Name
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Leads ID')
        ->setCellValue('B1', 'Leads Name')
        ->setCellValue('C1', 'CNIC')
        ->setCellValue('D1', 'Gender')
        ->setCellValue('E1', 'Mobile')
        ->setCellValue('F1', 'Email')
        ->setCellValue('G1', 'City')
        ->setCellValue('H1', 'Area')
        ->setCellValue('I1', 'Address')
        ->setCellValue('J1', 'Call Time')
        ->setCellValue('K1', 'Leads Description')
        ->setCellValue('L1', 'Leads Assinged By')
        ->setCellValue('M1', 'Leads Assinged To')
        ->setCellValue('N1', 'Leads Created Date/Time')
        ->setCellValue('O1', 'Leads Exceed Date/Time')
        ->setCellValue('P1', 'Leads Status')
        ->setCellValue('Q1', 'Last Remark');
    
    //set row values
    $i = 2;
    foreach($data as $row)
    {
        $status = $row['lead_status_id'];

        if($status == 1)
        {
            $status = "Initiated";
        }
        else if($status == 2)
        {
            $status = "In Progress";
        }
        else if($status == 3)
        {
            $status = "Follow-up";
        }
        else if($status == 4)
        {
            $status = "Bought";
        }
        else if($status == 5)
        {
            $status = "Not Interested";
        }
        else if($status == 6)
        {
            $status = "General Inquiry";
        }

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $row['lead_num'])
            ->setCellValue('B'.$i, $row['salutation'] . " " . $row['fname'] . " " . $row['mname'] . " " . $row['lname'])
            ->setCellValue('C'.$i, $row['cnic'])
            ->setCellValue('D'.$i, $row['gender'])
            ->setCellValue('E'.$i, $row['mobile_no'])
            ->setCellValue('F'.$i, $row['email'])
            ->setCellValue('G'.$i, $row['city'])
            ->setCellValue('H'.$i, $row['area'])
            ->setCellValue('I'.$i, $row['address'])
            ->setCellValue('J'.$i, $row['call_time'])
            ->setCellValue('K'.$i, $row['lead_desc'])
            ->setCellValue('L'.$i, $row['lead_assignee'])
            ->setCellValue('M'.$i, $row['lead_assignee_to'])
            ->setCellValue('N'.$i, $row['lead_create_date'])
            ->setCellValue('O'.$i, $row['lead_exceded_datetime'])
            ->setCellValue('P'.$i, $status)
            ->setCellValue('Q'.$i, $row['last_remarks']);
        $i++;
    }

    //create excelsheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

    //write excelsheet
    $filename = "export_lead_raw_data";
    //$objWriter->save(str_replace(__FILE__,'template/'.$filename,__FILE__));

    header('Content-Type: application/vnd.openXMLformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
?>