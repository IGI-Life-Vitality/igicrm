<?php
//ini_set('max_execution_time', 1000);
require_once "classes/PHPExcel.php";
require_once "includes/config.php";

		$tmpfname = "M3TECH.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();
		
	
		for ($row = 2; $row <= $lastRow; $row++) {
			 
			  $FLD1 = $worksheet->getCell('A'.$row)->getValue();
			  $FLD2 = $worksheet->getCell('B'.$row)->getValue();
			  $FLD3 = $worksheet->getCell('C'.$row)->getValue();
			  $FLD4 = $worksheet->getCell('D'.$row)->getValue();
			  $FLD5 = $worksheet->getCell('E'.$row)->getValue();
			  $FLD6 = $worksheet->getCell('F'.$row)->getValue();
			  $FLD7 = $worksheet->getCell('G'.$row)->getValue();
			  $FLD8 = $worksheet->getCell('H'.$row)->getValue();
			  $FLD9 = $worksheet->getCell('I'.$row)->getValue();
			  $FLD10 = $worksheet->getCell('J'.$row)->getValue();
			  $FLD11 = $worksheet->getCell('K'.$row)->getValue();
			  $FLD12 = $worksheet->getCell('L'.$row)->getValue();
			  $FLD13 = $worksheet->getCell('M'.$row)->getValue();
			  $FLD14 = $worksheet->getCell('N'.$row)->getValue();
			  $FLD15 = $worksheet->getCell('O'.$row)->getValue();
			  $FLD16 = $worksheet->getCell('P'.$row)->getValue();
			  $FLD17 = $worksheet->getCell('Q'.$row)->getValue();
			  $FLD18 = $worksheet->getCell('R'.$row)->getValue();
			  $FLD19 = $worksheet->getCell('S'.$row)->getValue();
			  $FLD20 = $worksheet->getCell('T'.$row)->getValue();
			  $FLD21 = $worksheet->getCell('U'.$row)->getValue();
			  $FLD22 = $worksheet->getCell('V'.$row)->getValue();
			  $FLD23 = $worksheet->getCell('W'.$row)->getValue();
			  $FLD24 = $worksheet->getCell('X'.$row)->getValue();
			  $FLD25 = $worksheet->getCell('Y'.$row)->getValue();
			  $FLD26 = $worksheet->getCell('Z'.$row)->getValue();
			  $FLD27 = $worksheet->getCell('AA'.$row)->getValue();
			  $FLD28 = $worksheet->getCell('AB'.$row)->getValue();
			  $FLD29 = $worksheet->getCell('AC'.$row)->getValue();
			  $FLD30 = $worksheet->getCell('AD'.$row)->getValue();
			  $FLD31 = $worksheet->getCell('AE'.$row)->getValue();
			  $FLD32 = $worksheet->getCell('AF'.$row)->getValue();
			  $FLD33 = $worksheet->getCell('AG'.$row)->getValue();
			  $FLD34 = $worksheet->getCell('AH'.$row)->getValue();
			  $FLD35 = $worksheet->getCell('AI'.$row)->getValue();

			  $FLD6 = date('Y-m-d',strtotime($FLD6));
			  $FLD7 = date('Y-m-d',strtotime($FLD7));
			  $FLD24 = date('Y-m-d',strtotime($FLD24));


			    $query = "INSERT INTO tbl_test_data (Company_Code,Policy_Number,Certificate_Number,Status_Policy_Description,Policy_Premium_Mode,Issue_Date,DOB,Modal_Premium,Insure_Name,Owner_Name,Payor_Name,Address1,Address2,City,Phone_Number,Mobile_Number,Fax_Number,Face_Amount,Agent_Name,Agent_Status,CNIC,Basic_Rider_Premium,Line_Of_Business,Next_Premium_Due_Date,Total_Premium_Paid,Plan_Code,Plan_Name,Email_Address,System_Name,FLD30,FLD31,FLD32,FLD33,FLD34,FLD35) VALUES ('$FLD1','$FLD2','$FLD3','$FLD4','$FLD5','$FLD6','$FLD7','$FLD8','$FLD9','$FLD10','$FLD11','$FLD12','$FLD13','$FLD14','$FLD15','$FLD16','$FLD17','$FLD18','$FLD19','$FLD20','$FLD21','$FLD22','$FLD23','$FLD24','$FLD25','$FLD26','$FLD27','$FLD28','$FLD29','$FLD30','$FLD31','$FLD32','$FLD33','$FLD34','$FLD35')";

			   $res = $obj_mysql->insert($query);
			 
		}
		echo "data dump successfully";
		
?>