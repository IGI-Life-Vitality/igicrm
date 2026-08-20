<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'complaint_rpt.php');
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$objComplaintReport = new ComplaintReport();
$login_id = $_SESSION['login_id'];
$current_datetime = date('Y-m-d H:i:s');

if(isset($_POST)) 
{    
    if(isset($_POST['action'])) 
    {
        $action    = isset($_POST['action']) ? $_POST['action'] : '';
        $FromDate  = isset($_POST['FromDate'])?$_POST['FromDate']: '';
        $ToDate    = isset($_POST['ToDate'])?$_POST['ToDate']: '';

        if($action == 'search_cmp_ageing_rpt')
        {
            $Department     = isset($_POST['Department'])?$_POST['Department']:'';
            $Type           = isset($_POST['Type'])?$_POST['Type']:'';
            $Source         = isset($_POST['Source'])?$_POST['Source']:'';
            $Status         = isset($_POST['Status'])?$_POST['Status']:'';
            
            $data           = $objComplaintReport->countsComplaintAgeing($FromDate,$ToDate,$Department,$Type,$Source,$Status);

            //echo $data[0]; die;
            
            $output = '';
            $output .='<table id="data-table" class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th width="100px;">Ticket #</th>
                                    <th width="100px;">Registration Date</th>
                                    <th width="100px;">Policy#</th>
                                    <th width="100px;">Customer Name</th>
                                    <th width="100px;">Contact No</th>
                                    <th width="100px;">Source</th>
                                    <th width="100px;">Logged By</th>
                                    <th width="100px;">Complaint Type</th>
                                    <th width="100px;">Department</th>
                                    <th width="100px;">Assign To</th>
                                    <th width="100px;">Priority/TAT</th>
                                    <th width="100px;">Status</th>
                                    <th width="100px;">Resolution Date</th>
                                    <th width="100px;">Aging (Overdue)</th>
                                </tr>
                            </thead>
                            <tbody>';

                            foreach($data as $row)
                            {                                
                                $output .='<tr>';
                                    $output .='<td>'.$row['complaint_num'].'</td>';
                                    $output .='<td>'.substr($row['create_date'],0,10).'</td>';
                                    $output .='<td>'.$row['policy_num'].'</td>';
                                    $output .='<td>'.$row['customer_name'].'</td>';
                                    $output .='<td>'.$row['response_number'].'</td>';
                                    $output .='<td>'.$row['Source'].'</td>';
                                    $output .='<td>'.$row['ReleasedBy'].'</td>';
                                    $output .='<td>'.$row['ComplaintType'].'</td>';
                                    $output .='<td>'.$row['depart'].'</td>';
                                    $output .='<td>'.$row['AssignedTo'].'</td>';
                                    $output .='<td>'.$row['tat'].'</td>';
                                    $output .='<td>'.$row['cmpStatus'].'</td>';
                                    $output .='<td>'.substr($row['close_date'],0,10).'</td>';
                                    // 1st date
                                    $resolution_date = substr($row['close_date'],0,10);

                                    // 2nd date
                                    $cdate  = substr($row['create_date'],0,10);
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
                                        $output .='<td>'.$diff->format('%R%a Days').'</td>';
                                    }
                                    else
                                    {
                                        $re = $objComplaintReport->cmpOverdue($resolution_date, $close_date);
                                        $output .='<td>'.$re.'</td>';
                                    }
                                $output .='</tr>';
                            }

            $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_ageing_rpt')
        {
            $FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
            $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';
            $Department= isset( $_POST['Department'] )   ? $_POST['Department']   : '';
            $Type      = isset( $_POST['Type'] )   ? $_POST['Type']   : '';
            $Source    = isset( $_POST['Source'] )   ? $_POST['Source']   : '';
            $Status    = isset( $_POST['Status'] )   ? $_POST['Status']   : '';

            echo "success|".$FromDate."|".$ToDate."|".$Department."|".$Type."|".$Source."|".$Status;
        }
        elseif($action == 'search_cmp_annual_rpt')
        {
            $Year1     = isset($_POST['getYear1'])?$_POST['getYear1']:'';
            $Year2     = isset($_POST['getYear2'])?$_POST['getYear2']:'';
            
            $data1     = $objComplaintReport->countsAnnualComplaintComparison($Year1);
            $data2     = $objComplaintReport->countsAnnualComplaintComparison($Year2);

            //echo $data[0]; die;
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                            $output .='<thead>';
                                $output .='<tr>';
                                    $output .='<th width="100px;">Month</th>';
                                    $output .='<th width="100px;">'.$Year1.'</th>';
                                    $output .='<th width="100px;">'.$Year2.'</th>';
                                    $output .='<th width="100px;">Improvement</th>';
                                $output .='</tr>';
                            $output .='</thead>';

                            $output .='<tbody>';
                                $output .='<tr>';
                                    $output .='<td>January</td>';
                                    $MNAME = 'JAN';
                                    $JAN1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$JAN1.'</td>';
                                    $JAN2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$JAN2.'</td>';
                                    $A = ($JAN1-$JAN2);
                                        $B = ($JAN1+$JAN2);
                                        $IMP1 = ($A / $B) * 100;
                                        $IMP1 = number_format($IMP1,2)."%"; 
                                    $output .='<td>'.$IMP1.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>February</td>';

                                    $MNAME = 'FAB';
                                    $FAB1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$FAB1.'</td>';
                                    $FAB2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$FAB2.'</td>';
                                    $A = ($FAB1-$FAB2);
                                        $B = ($FAB1+$FAB2);
                                        $IMP2 = ($A / $B) * 100;
                                        $IMP2 = number_format($IMP2,2)."%"; 
                                    $output .='<td>'.$IMP2.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>March</td>';

                                    $MNAME = 'MAR';
                                    $MAR1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$MAR1.'</td>';
                                    $MAR2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$MAR2.'</td>';
                                    $A = ($MAR1-$MAR2);
                                        $B = ($MAR1+$MAR2);
                                        $IMP3 = ($A / $B) * 100;
                                        $IMP3 = number_format($IMP3,2)."%"; 
                                    $output .='<td>'.$IMP3.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>April</td>';

                                    $MNAME = 'APR';
                                    $APR1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$APR1.'</td>';
                                    $APR2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$APR2.'</td>';
                                    $A = ($APR1-$APR2);
                                    $B = ($APR1+$APR2);
                                    $IMP4 = ($A / $B) * 100;
                                    $IMP4 = number_format($IMP4,2)."%";
                                    $output .='<td>'.$IMP4.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>May</td>';

                                    $MNAME = 'MAY';
                                    $MAY1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$MAY1.'</td>';
                                    $MAY2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$MAY2.'</td>';
                                    $A = ($MAY1-$MAY2);
                                    $B = ($MAY1+$MAY2);
                                    $IMP5 = ($A / $B) * 100;
                                    $IMP5 = number_format($IMP5,2)."%"; 
                                    $output .='<td>'.$IMP5.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>June</td>';

                                    $MNAME = 'JUN';
                                    $JUN1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$JUN1.'</td>';
                                    $JUN2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$JUN2.'</td>';
                                    $A = ($JUN1-$JUN2);
                                    $B = ($JUN1+$JUN2);
                                    $IMP6 = ($A / $B) * 100;
                                    $IMP6 = number_format($IMP6,2)."%"; 
                                    $output .='<td>'.$IMP6.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>July</td>';

                                    $MNAME = 'JUL';
                                    $JUL1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$JUL1.'</td>';
                                    $JUL2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$JUL2.'</td>';
                                    $A = ($JUL1-$JUL2);
                                    $B = ($JUL1+$JUL2);
                                    $IMP7 = ($A / $B) * 100;
                                    $IMP7 = number_format($IMP7,2)."%"; 
                                    $output .='<td>'.$IMP7.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>August</td>';

                                    $MNAME = 'AUG';
                                    $AUG1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$AUG1.'</td>';
                                    $AUG2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$AUG2.'</td>';
                                    $A = ($AUG1-$AUG2);
                                    $B = ($AUG1+$AUG2);
                                    $IMP8 = ($A / $B) * 100;
                                    $IMP8 = number_format($IMP8,2)."%"; 
                                    $output .='<td>'.$IMP8.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>September</td>';

                                    $MNAME = 'SEP';
                                    $SEP1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$SEP1.'</td>';
                                    $SEP2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$SEP2.'</td>';
                                    $A = ($SEP1-$SEP2);
                                    $B = ($SEP1+$SEP2);
                                    $IMP9 = ($A / $B) * 100;
                                    $IMP9 = number_format($IMP9,2)."%"; 
                                    $output .='<td>'.$IMP9.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>October</td>';

                                    $MNAME = 'OTB';
                                    $OTB1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$OTB1.'</td>';
                                    $OTB2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$OTB2.'</td>';
                                    $A = ($OTB1-$OTB2);
                                    $B = ($OTB1+$OTB2);
                                    $IMP10 = ($A / $B) * 100;
                                    $IMP10 = number_format($IMP10,2)."%"; 
                                    $output .='<td>'.$IMP10.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>November</td>';

                                    $MNAME = 'NOV';
                                    $NOV1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$NOV1.'</td>';
                                    $NOV2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$NOV2.'</td>';
                                    $A = ($NOV1-$NOV2);
                                    $B = ($NOV1+$NOV2);
                                    $IMP11 = ($A / $B) * 100;
                                    $IMP11 = number_format($IMP11,2)."%"; 
                                    $output .='<td>'.$IMP11.'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>December</td>';

                                    $MNAME = 'DEM';
                                    $DEM1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];
                                    $output .='<td>'.$DEM1.'</td>';
                                    $DEM2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];
                                    $output .='<td>'.$DEM2.'</td>';
                                    $A = ($DEM1-$DEM2);
                                    $B = ($DEM1+$DEM2);
                                    $IMP12 = ($A / $B) * 100;
                                    $IMP12 = number_format($IMP12,2)."%"; 
                                    $output .='<td>'.$IMP12.'</td>';
                                $output .='</tr>';
                                
                            $output .='</tbody>';

                            $output .='<tfoot>';
                                $output .='<tr>';
                                    $output .='<td>Total</td>';
                                    $TOTAL_Y1 = $JAN1 + $FAB1 + $MAR1 + $APR1 + $MAY1 + $JUN1 + $JUL1 + $AUG1 + $SEP1 + $OTB1 + $NOV1 + $DEM1;
                                    $output .='<td>'.$TOTAL_Y1.'</td>';
                                    $TOTAL_Y2 = $JAN2 + $FAB2 + $MAR2 + $APR2 + $MAY2 + $JUN2 + $JUL2 + $AUG2 + $SEP2 + $OTB2 + $NOV2 + $DEM2;
                                    $output .='<td>'.$TOTAL_Y2.'</td>';
                                    $A = ($TOTAL_Y1 - $TOTAL_Y2);
                                    $B = ($TOTAL_Y1 + $TOTAL_Y2);
                                    $TOTAL_IMP_PERCENTAGE = ($A / $B) * 100;
                                    $TOTAL_IMP_PERCENTAGE = number_format($TOTAL_IMP_PERCENTAGE,2)."%"; 
                                    $output .='<td>'.$TOTAL_IMP_PERCENTAGE.'</td>';
                                $output .='</tr>';
                            $output .='</tfoot>';

            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_annual_rpt')
        {
            $Year1  = isset( $_POST['Year1'] ) ? $_POST['Year1'] : '';
            $Year2  = isset( $_POST['Year2'] ) ? $_POST['Year2'] : '';

            echo "success|".$Year1."|".$Year2;
        }
        elseif($action == 'get_cmp_type')
        {
            $DepartId  = isset($_POST['depart_id'])?$_POST['depart_id']: '';

            $data = $objComplaintReport->GetComplaintTypeByGroup($DepartId);
            $Option = "<option selected='selected' value=''> All </option>";

            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'>" . $row["fullname"] . "</option>";
            }

            echo $Option;
        }
        elseif($action == 'search_cmp_typewise_rpt')
        {
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $complaintType = isset($_POST['getComplaintType'])?$_POST['getComplaintType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';
            
            //$data          = $objComplaintReport->countsComplaintTypewiseOnLoad($deprtment_id,'',$durationType,$month,$quarter,$year);
            //print_r($data); die;

            $deprtments    = $objComplaintReport->getDepartmentById($departmentName);

            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                        $output .='<thead>';
                            $output .='<tr>';
                                $output .='<th width="100px;">Department Name</th>';
                                $output .='<th width="100px;">Departmental %</th>';
                                $output .='<th width="150px;">Complaint Type</th>';
                                $output .='<th width="200px;">Complaints logged in (Selected Duration)</th>';
                                $output .='<th width="100px;">Complaint Type %</th>';
                            $output .='</tr>';
                        $output .='</thead>';

                        $cmpTotalLogged = 0;
                        $cmpTotalPercentage = 0;
                        $cmpTotalTypewisePercentage = 0;

                        foreach($deprtments as $deprtment)
                        {
                            $deprtment_id = $deprtment['id'];

                            // Just to get colspan value
                            $data2 =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                            $rowspan1 = count($data2);
                            $rowspan1 = $rowspan1 + 1;

                            //print_r($deprtment); die;
                            $output .='<tbody>';
                                $output .='<tr>';
                                    $output .='<td rowspan="'.$rowspan1.'">'.$deprtment['primary_name'].'</td>';

                                    // Departmental %
                                    $departPer = $objComplaintReport->countsAllComplaint();
                                    $allCmp = 
                                        $departPer[0]['L'] +
                                        $departPer[0]['C'] +
                                        $departPer[0]['LG'] +
                                        $departPer[0]['I'] +
                                        $departPer[0]['B'] +
                                        $departPer[0]['BB'] +
                                        $departPer[0]['V'];

                                    $complaintsloggedw = $objComplaintReport->countsComplaintTypewiseOnLoad($deprtment_id,'',$durationType,$month,$quarter,$year);

                                    //$complaintsloggedw = countsComplaintTypewise($durationType,$month,$quarter,$year,$deprtment_id,$complaintType);
                                    //print_r($complaintsloggedw); die;

                                    $departmentalPercentage = 
                                        $complaintsloggedw[0]['CMPL'] + 
                                        $complaintsloggedw[0]['CMPC'] + 
                                        $complaintsloggedw[0]['CMPLG'] + 
                                        $complaintsloggedw[0]['CMPI'] + 
                                        $complaintsloggedw[0]['CMPB'] + 
                                        $complaintsloggedw[0]['CMPBB'] + 
                                        $complaintsloggedw[0]['CMPV'];

                                    $departmentalPercentage = ($departmentalPercentage/$allCmp)*100;

                                    $departmentalPercentage = number_format($departmentalPercentage,2)."%";
                                    $output .='<td rowspan="'.$rowspan1.'">'.$departmentalPercentage.'</td>';

                                    //$cTypeList = $objComplaintReport->GetComplaintTypeByGroup($deprtment['id']);
                                    //print_r($cTypeList); die;

                                    for($i=0; $i<count($data2); $i++) 
                                    {
                                        $output .='<tr>';
                                            if($data2 != 0) 
                                            {
                                                $output .='<td>'.$data2[$i]['fullname'].'</td>';

                                                $complaintslogged = $objComplaintReport->countsComplaintTypewiseOnLoad('',$data2[$i]['id'],$durationType,$month,$quarter,$year);

                                                //print_r($complaintslogged); die;

                                                $allcomplaintslogged = 
                                                    $complaintslogged[0]['CMPL'] + 
                                                    $complaintslogged[0]['CMPC'] + 
                                                    $complaintslogged[0]['CMPLG'] + 
                                                    $complaintslogged[0]['CMPI'] + 
                                                    $complaintslogged[0]['CMPB'] + 
                                                    $complaintslogged[0]['CMPBB'] + 
                                                    $complaintslogged[0]['CMPV'];

                                                $output .='<td>'.number_format($allcomplaintslogged).'</td>';

                                                // For Total Complaints logged in (Selected Duration)
                                                $cmpTotalLogged = $cmpTotalLogged + $allcomplaintslogged;

                                                $countsAllComplaint = $objComplaintReport->countsComplaintTypewiseOnLoad('','',$durationType,$month,$quarter,$year);

                                                $countsAllCmp = 
                                                    $countsAllComplaint[0]['CMPL'] +
                                                    $countsAllComplaint[0]['CMPC'] +
                                                    $countsAllComplaint[0]['CMPLG'] +
                                                    $countsAllComplaint[0]['CMPI'] +
                                                    $countsAllComplaint[0]['CMPB'] +
                                                    $countsAllComplaint[0]['CMPBB'] +
                                                    $countsAllComplaint[0]['CMPV'];

                                                $CmpTypePercentage = ($allcomplaintslogged/$allCmp)*100;

                                                $CmpTypePercentage = number_format($CmpTypePercentage,2)."%";

                                                // For Total Complaint Type %
                                                $cmpTotalPercentage = $cmpTotalPercentage + $CmpTypePercentage;

                                                $cmpTotalTypewisePercentage = $cmpTotalPercentage;

                                                $output .='<td>'.$CmpTypePercentage.'</td>';
                                            } 
                                            else 
                                            {
                                                $output .='<td>NA</td>';
                                                $output .='<td>0</td>';
                                                $output .='<td>0.00%</td>';
                                            } 
                                        $output .='</tr>';
                                    }
                                $output .='</tr>';                                
                            $output .='</tbody>';
                        }

                        $output .='<tfoot>';
                            $output .='<tr>';
                                $output .='<td colspan="3">Total</td>';
                                $output .='<td>'.$cmpTotalLogged.'</td>';
                                $output .='<td>'.number_format($cmpTotalPercentage,2).'%</td>';
                            $output .='</tr>';
                        $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_typewise_rpt')
        {
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $complaintType = isset($_POST['getComplaintType'])?$_POST['getComplaintType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            echo "success|".$durationType."|".$departmentName."|".$complaintType."|".$month."|".$quarter."|".$year;
        }
        elseif($action == 'search_cmp_departmentwise_rpt')
        {
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';
            
            $deprtments    = $objComplaintReport->getDepartmentById($departmentName);

            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                        $output .='<thead>';
                            $output .='<tr>';
                                $output .='<th width="500px;">Department Name</th>';
                                $output .='<th width="250px;">Complaints logged in (Selected Duration)</th>';
                                $output .='<th width="150px;">Overall Percentage</th>';
                            $output .='</tr>';
                        $output .='</thead>';

                        $cmpTotalLogged = 0;

                        foreach($deprtments as $deprtment)
                        {
                            $deprtment_id = $deprtment['id'];
                            $cmp_deprt = $objComplaintReport->getComplaintByDepartmentId($deprtment_id,$durationType,$month,$quarter,$year);
                            //print_r($cmp_deprt); die;

                            $output .='<tbody>';
                                $output .='<tr>';
                                    $output .='<td>'.$deprtment['primary_name'].'</td>';

                                    // For Complaints logged SUM - Start
                                    $sum_deprt_cmp = 
                                        $cmp_deprt[0]['CMPL'] + 
                                        $cmp_deprt[0]['CMPC'] + 
                                        $cmp_deprt[0]['CMPLG'] + 
                                        $cmp_deprt[0]['CMPI'] + 
                                        $cmp_deprt[0]['CMPB'] + 
                                        $cmp_deprt[0]['CMPBB'] + 
                                        $cmp_deprt[0]['CMPV'];

                                    $cmpTotalLogged = $cmpTotalLogged + $sum_deprt_cmp;
                                    // For Complaints logged SUM - End

                                    // For Overall Percentage Before Search - Start
                                    $all_deprt_cmp = $objComplaintReport->countsAllComplaint();
                                    $all_sum_deprt_cmp = 
                                            $all_deprt_cmp[0]['L'] +
                                            $all_deprt_cmp[0]['C'] +
                                            $all_deprt_cmp[0]['LG'] +
                                            $all_deprt_cmp[0]['I'] +
                                            $all_deprt_cmp[0]['B'] +
                                            $all_deprt_cmp[0]['BB'] +
                                            $all_deprt_cmp[0]['V'];

                                    $CmpTypePercentage = ($sum_deprt_cmp/$all_sum_deprt_cmp)*100;
                                    // For Overall Percentage Before Search - End

                                    // For Overall Percentage After Search - Start
                                    $overallPercentage = ($cmpTotalLogged/$all_sum_deprt_cmp)*100;
                                    // For Overall Percentage After Search - End

                                    $output .='<td>'.$sum_deprt_cmp.'</td>';

                                    $output .='<td>'.number_format(($sum_deprt_cmp/$all_sum_deprt_cmp)*100,2).'%</td>';
                                $output .='</tr>';                                
                            $output .='</tbody>';
                        }

                        $output .='<tfoot>';
                            $output .='<tr>';
                                $output .='<td>Total</td>';
                                $output .='<td>'.$cmpTotalLogged.'</td>';
                                $output .='<td>'.number_format($overallPercentage,2).'%</td>';
                            $output .='</tr>';
                        $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_departmentwise_rpt')
        {
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            echo "success|".$departmentName."|".$durationType."|".$month."|".$quarter."|".$year;
        }
        elseif($action == 'search_cmp_comparison_rpt')
        {
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';

            if($durationType != '' AND $durationType == 1)
            {
                $month1 = isset($_POST['getMonth1'])?$_POST['getMonth1']:'';
                $month2 = isset($_POST['getMonth2'])?$_POST['getMonth2']:'';

                $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,$month1,'','');
                $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,$month2,'','');

                $month_name1 = $objComplaintReport->getMonthFromDBById($month1);
                $month_name2 = $objComplaintReport->getMonthFromDBById($month2);

                //print_r($data1); die;
                
                $output = '';
                $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                                $output .='<thead>';
                                    $output .='<tr>';
                                        $output .='<th width="100px;">'.$month_name1[0]['month_name'].'</th>';
                                        $output .='<th width="100px;">'.$month_name2[0]['month_name'].'</th>';
                                        $output .='<th width="100px;">Improvement</th>';
                                    $output .='</tr>';
                                $output .='</thead>';

                                $output .='<tbody>';
                                    $output .='<tr>';
                                        $output .='<td>Complaints logged in '.$month_name1[0]['month_name'].'</td>';
                                        $output .='<td>Complaints logged in '.$month_name2[0]['month_name'].'</td>';
                                        $output .='<td>Improvement in Percentage</td>';
                                    $output .='</tr>';
                                $output .='</tbody>';

                                $output .='<tfoot>';
                                    $output .='<tr>';
                                        $output .='<td>'.$data1[0]['ALLCMPSUM'].'</td>';
                                        $output .='<td>'.$data2[0]['ALLCMPSUM'].'</td>';

                                        $A = ($data1[0]['ALLCMPSUM']);
                                        $B = ($data2[0]['ALLCMPSUM']);
                                        $imp = ($A-$B)/($A+$B)*100;
                                        $imp = number_format($imp,2)."%"; 
                                        $output .='<td>'.$imp.'</td>';
                                    $output .='</tr>';
                                $output .='</tfoot>';
                $output .='</table>';

                echo "success|".$output;
            }

            if($durationType != '' AND $durationType == 2)
            {
                $quarter1       = isset($_POST['getQuarter1'])?$_POST['getQuarter1']:'';
                $quarter2       = isset($_POST['getQuarter2'])?$_POST['getQuarter2']:'';

                $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,'',$quarter1,'');
                $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,'',$quarter2,'');

                $quarter_name1 = $objComplaintReport->getQuarterFromDBById($quarter1);
                $quarter_name2 = $objComplaintReport->getQuarterFromDBById($quarter2);

                //print_r($quarter1); die;
                
                $output = '';
                $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                                $output .='<thead>';
                                    $output .='<tr>';
                                        $output .='<th width="100px;">'.$quarter_name1[0]['quarter_name'].'</th>';
                                        $output .='<th width="100px;">'.$quarter_name2[0]['quarter_name'].'</th>';
                                        $output .='<th width="100px;">Improvement</th>';
                                    $output .='</tr>';
                                $output .='</thead>';

                                $output .='<tbody>';
                                    $output .='<tr>';
                                        $output .='<td>Complaints logged in '.$quarter_name1[0]['quarter_name'].'</td>';
                                        $output .='<td>Complaints logged in '.$quarter_name2[0]['quarter_name'].'</td>';
                                        $output .='<td>Improvement in Percentage</td>';
                                    $output .='</tr>';
                                $output .='</tbody>';

                                $output .='<tfoot>';
                                    $output .='<tr>';
                                        $output .='<td>'.$data1[0]['ALLCMPSUM'].'</td>';
                                        $output .='<td>'.$data2[0]['ALLCMPSUM'].'</td>';

                                        $A = ($data1[0]['ALLCMPSUM']);
                                        $B = ($data2[0]['ALLCMPSUM']);
                                        $imp = ($A-$B)/($A+$B)*100;
                                        $imp = number_format($imp,2)."%"; 
                                        $output .='<td>'.$imp.'</td>';
                                    $output .='</tr>';
                                $output .='</tfoot>';
                $output .='</table>';

                echo "success|".$output;
            }

            if($durationType != '' AND $durationType == 3)
            {
                $year1          = isset($_POST['getYear1'])?$_POST['getYear1']:'';
                $year2          = isset($_POST['getYear2'])?$_POST['getYear2']:'';

                $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,'','',$year1);
                $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,'','',$year2);

                //print_r($quarter1); die;
                
                $output = '';
                $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                                $output .='<thead>';
                                    $output .='<tr>';
                                        $output .='<th width="100px;">'.$year1.'</th>';
                                        $output .='<th width="100px;">'.$year2.'</th>';
                                        $output .='<th width="100px;">Improvement</th>';
                                    $output .='</tr>';
                                $output .='</thead>';

                                $output .='<tbody>';
                                    $output .='<tr>';
                                        $output .='<td>Complaints logged in '.$year1.'</td>';
                                        $output .='<td>Complaints logged in '.$year2.'</td>';
                                        $output .='<td>Improvement in Percentage</td>';
                                    $output .='</tr>';
                                $output .='</tbody>';

                                $output .='<tfoot>';
                                    $output .='<tr>';
                                        $output .='<td>'.$data1[0]['ALLCMPSUM'].'</td>';
                                        $output .='<td>'.$data2[0]['ALLCMPSUM'].'</td>';

                                        $A = ($data1[0]['ALLCMPSUM']);
                                        $B = ($data2[0]['ALLCMPSUM']);
                                        $imp = ($A-$B)/($A+$B)*100;
                                        $imp = number_format($imp,2)."%"; 
                                        $output .='<td>'.$imp.'</td>';
                                    $output .='</tr>';
                                $output .='</tfoot>';
                $output .='</table>';

                echo "success|".$output;
            }
        }
        elseif($action == 'export_cmp_comparison_rpt')
        {
            $durationType   = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month1         = isset($_POST['getMonth1'])?$_POST['getMonth1']:'';
            $month2         = isset($_POST['getMonth2'])?$_POST['getMonth2']:'';
            $quarter1       = isset($_POST['getQuarter1'])?$_POST['getQuarter1']:'';
            $quarter2       = isset($_POST['getQuarter2'])?$_POST['getQuarter2']:'';
            $year1          = isset($_POST['getYear1'])?$_POST['getYear1']:'';
            $year2          = isset($_POST['getYear2'])?$_POST['getYear2']:'';

            echo "success|".$durationType."|".$month1."|".$month2."|".$quarter1."|".$quarter2."|".$year1."|".$year2;
        }
        elseif($action == 'search_cmp_channelwise_rpt')
        {
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            $deprtments    = $objComplaintReport->getDepartmentById($departmentName);

            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                        $output .='<thead>';
                            $output .='<tr>';
                                $output .='<th width="100px;">Department Name</th>';
                                $output .='<th width="100px;">Departmental %</th>';
                                $output .='<th width="150px;">Complaint Channel</th>';
                                $output .='<th width="200px;">Complaints logged in (Selected Duration)</th>';
                                $output .='<th width="100px;">Complaint Type %</th>';
                            $output .='</tr>';
                        $output .='</thead>';

                        $CMPChannelWiseTotal    = 0;
                        $CMPChannelPercentage   = 0;
                        $CMPTotalPercentage     = 0;

                        foreach($deprtments as $deprtment)
                        {
                            $department_id = $deprtment['id'];
                            $channel_counts = $objComplaintReport->countsComplaintChannel($department_id,$durationType,$month,$quarter,$year);

                            $L = number_format(($channel_counts[0]['CMPL']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $C = number_format(($channel_counts[0]['CMPC']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $LG = number_format(($channel_counts[0]['CMPLG']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $I = number_format(($channel_counts[0]['CMPI']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $B = number_format(($channel_counts[0]['CMPB']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $BB = number_format(($channel_counts[0]['CMPBB']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $V = number_format(($channel_counts[0]['CMPV']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                            $OVERALLPERCENTAGE = $L+$C+$LG+$I+$B+$BB+$V;

                            $output .='<tbody>';
                                $output .='<tr>';
                                    $output .='<td rowspan="7">'.$deprtment['primary_name'].'</td>';
                                    $output .='<td rowspan="7">'.number_format($OVERALLPERCENTAGE,2).'%</td>';
                                    $output .='<td>Individual Life</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPL'].'</td>';
                                    $output .='<td>'.$L.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Corporate Policy Holder</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPC'].'</td>';
                                    $output .='<td>'.$C.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Legal/Fraudalent Complaints</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPLG'].'</td>';
                                    $output .='<td>'.$LG.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Internal Complaints</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPI'].'</td>';
                                    $output .='<td>'.$I.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Bancassurance - (Banca - Individual)</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPB'].'</td>';
                                    $output .='<td>'.$B.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Bancassurance - (Banca - Bank)</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPBB'].'</td>';
                                    $output .='<td>'.$BB.'%</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Vitality Complaints</td>';
                                    $output .='<td>'.$channel_counts[0]['CMPV'].'</td>';
                                    $output .='<td>'.$V.'%</td>';
                                $output .='</tr>';

                                $CMPChannelPercentage = $CMPChannelPercentage + $channel_counts[0]['CMPPERCENTAGE']; 

                                $CMPChannelWiseTotal = $CMPChannelWiseTotal + $channel_counts[0]['CMPSUM'];              
                            $output .='</tbody>';
                        }

                        $output .='<tfoot>';
                            $output .='<tr>';
                                $output .='<td colspan="3">Total</td>';
                                $output .='<td>'.$CMPChannelWiseTotal.'</td>';
                                $output .='<td>'.number_format($CMPChannelPercentage,2).'%</td>';
                            $output .='</tr>';
                        $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_channelwise_rpt')
        {
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            echo "success|".$departmentName."|".$durationType."|".$month."|".$quarter."|".$year;
        }
        elseif($action == 'search_cmp_legal_complaint_closure_rpt')
        {
            $year = isset($_POST['getYear'])?$_POST['getYear']:'';
            
            $data = $objComplaintReport->countsLegalComplaintClosureAnalysis($year);
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                $output .='<thead>';
                    $output .='<tr>';
                        $output .='<th width="350px;">Month</th>';
                        $output .='<th width="150px;">Premium Collected</th>';
                        $output .='<th width="200px;">Claimed by the Policyholders</th>';
                        $output .='<th width="200px;">Payments to Policyholders</th>';
                        $output .='<th width="100px;">Savings</th>';
                    $output .='</tr>';
                $output .='</thead>';

                $output .='<tbody>';
                    $PremiumCollected = 0;
                    $ClaimedPolicyholders = 0;
                    $PaymentsPolicyholders = 0;
                    $SumSavings = 0;

                    foreach($data as $row)
                    {
                        $Savings = ($row['PremiumCollected']-$row['PaymentToPolicyholder']);

                        $output .='<tr>';
                            $output .='<td>'.$row['MonthName'].'</td>';
                            $output .='<td>'.number_format($row['PremiumCollected']).'</td>';
                            $output .='<td>'.number_format($row['ClaimedByPolicyholder']).'</td>';
                            $output .='<td>'.number_format($row['PaymentToPolicyholder']).'</td>';
                            $output .='<td>'.number_format($Savings).'</td>';

                            $PremiumCollected = $PremiumCollected + $row['PremiumCollected'];
                            $ClaimedPolicyholders = $ClaimedPolicyholders + $row['ClaimedByPolicyholder'];
                            $PaymentsPolicyholders = $PaymentsPolicyholders + $row['PaymentToPolicyholder'];
                            $SumSavings = $SumSavings + $Savings;

                        $output .='</tr>';
                    }
                $output .='</tbody>';

                $output .='<tfoot>';
                    $output .='<tr>';
                        $output .='<td>Total</td>';
                        $output .='<td>'.number_format($PremiumCollected).'</td>';
                        $output .='<td>'.number_format($ClaimedPolicyholders).'</td>';
                        $output .='<td>'.number_format($PaymentsPolicyholders).'</td>';
                        $output .='<td>'.number_format($SumSavings).'</td>';
                    $output .='</tr>';
                $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_legal_complaint_closure_rpt')
        {
            $year = isset($_POST['getYear'])?$_POST['getYear']:'';
            echo "success|".$year;
        }
        elseif($action == 'search_cmp_quarterly_departmental_complaint_rpt')
        {
            $year       = isset($_POST['getYear'])?$_POST['getYear']:'';
            $year       = (int) $year;
            $year_last  = $year - 1; //get 1 year back
            $status     = "1,2,6";

            $deprtments = $objComplaintReport->getDepartmentById('');
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                $output .='<thead>';
                    $output .='<tr>';
                        $output .='<th rowspan="2" class="text-center line-hight">Department</th>';
                        $output .='<th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>';
                        $output .='<th colspan="4" class="text-center">Quarter-1 of '. $year .'</th>';
                        $output .='<th colspan="4" class="text-center">Quarter-2 of '. $year .'</th>';
                        $output .='<th colspan="4" class="text-center">Quarter-3 of '. $year .'</th>';
                        $output .='<th colspan="4" class="text-center">Quarter-4 of '. $year .'</th>';
                        $output .='<th rowspan="2" class="text-center line-hight">Pending</th>';
                    $output .='</tr>';

                    $output .='<tr>';
                        $output .='<th class="text-center line-hight">Opening '. $year_last .'</th>';
                        $output .='<th class="text-center line-hight">New</th>';
                        $output .='<th class="text-center line-hight">Total</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">New</th>';
                        $output .='<th class="text-center line-hight">Total</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">New</th>';
                        $output .='<th class="text-center line-hight">Total</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">New</th>';
                        $output .='<th class="text-center line-hight">Total</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';
                    $output .='</tr>';
                $output .='</thead>';

                $output .='<tbody>';
                    $cmpTotalLogged = 0;
                    $cmpTotalPercentage = 0;

                    $opening_sum = 0;
                    $q1_new_sum = 0;
                    $q1_tot_sum = 0;
                    $q1_cls_sum = 0;

                    $lastyear_open_sum = 0;

                    $q2_cf_sum = 0;
                    $q2_new_sum = 0;
                    $q2_tot_sum = 0;
                    $q2_cls_sum = 0;

                    $q3_cf_sum = 0;
                    $q3_new_sum = 0;
                    $q3_tot_sum = 0;
                    $q3_cls_sum = 0;

                    $q4_cf_sum = 0;
                    $q4_new_sum = 0;
                    $q4_tot_sum = 0;
                    $q4_cls_sum = 0;

                    $pending_sum = 0;

                    foreach($deprtments as $deprtment)
                    {
                        $deprtment_id = $deprtment['id'];
                        $data2        =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                        $rowspan      = count($data2);
                        $rowspan      = $rowspan + 1;

                        $output .='<tr>';
                            $output .='<td rowspan="'.$rowspan.'">'.$deprtment['primary_name'].'</td>';

                            for($i=0; $i<count($data2); $i++) 
                            {
                                $output .='<tr>';
                                    if($data2 != 0) 
                                    {
                                        // Q1 Start
                                        $output .='<td class="text-center line-hight">'.$data2[$i]['fullname'].'</td>';
                                        $cmp_q1_open = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'',$year_last,$status);

                                        $all_q1_open = 
                                            $cmp_q1_open[0]['CMPL_OPEN'] + 
                                            $cmp_q1_open[0]['CMPC_OPEN'] + 
                                            $cmp_q1_open[0]['CMPLG_OPEN'] + 
                                            $cmp_q1_open[0]['CMPI_OPEN'] + 
                                            $cmp_q1_open[0]['CMPB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPBB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPV_OPEN'];

                                        // For Total Col-1
                                        $opening_sum = $opening_sum + $all_q1_open;

                                        $lastyear_open_sum = $lastyear_open_sum + $all_q1_open;

                                        $output .='<td class="text-center line-hight bgColor">'.$all_q1_open.'</td>';

                                        $cmp_q1_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

                                        $all_q1_new = 
                                            $cmp_q1_new[0]['CMPL_NEW'] + 
                                            $cmp_q1_new[0]['CMPC_NEW'] + 
                                            $cmp_q1_new[0]['CMPLG_NEW'] + 
                                            $cmp_q1_new[0]['CMPI_NEW'] + 
                                            $cmp_q1_new[0]['CMPB_NEW'] + 
                                            $cmp_q1_new[0]['CMPBB_NEW'] + 
                                            $cmp_q1_new[0]['CMPV_NEW'];

                                        // For Total Col-2
                                        $q1_new_sum = $q1_new_sum + $all_q1_new;

                                        $output .='<td class="text-center line-hight">'.$all_q1_new.'</td>';

                                        $cmp_q1_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

                                        $all_q1_total = 
                                            $cmp_q1_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPV_TOTAL'];

                                        // For Field Col-3
                                        $all_q1 = $all_q1_total + $all_q1_open;

                                        // For Total Col-2
                                        $q1_tot_sum = $q1_tot_sum + $all_q1;

                                        $output .='<td class="text-center line-hight">'.$all_q1.'</td>';

                                        $cmp_q1_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

                                        $all_q1_closed = 
                                            $cmp_q1_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPV_CLOSED'];

                                        // For Total Col-4
                                        $q1_cls_sum = $q1_cls_sum + $all_q1_closed;

                                        $output .='<td class="text-center line-hight">'.$all_q1_closed.'</td>';
                                        // Q1 End

                                        // Q2 Start
                                        $cmp_q2_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,$status);

                                        $all_q2_cf = 
                                            $cmp_q2_cf[0]['CMPL_NEW'] + 
                                            $cmp_q2_cf[0]['CMPC_NEW'] + 
                                            $cmp_q2_cf[0]['CMPLG_NEW'] + 
                                            $cmp_q2_cf[0]['CMPI_NEW'] + 
                                            $cmp_q2_cf[0]['CMPB_NEW'] + 
                                            $cmp_q2_cf[0]['CMPBB_NEW'] + 
                                            $cmp_q2_cf[0]['CMPV_NEW'];

                                        $all_q2_cf_sum = $all_q2_cf + $all_q1_open;

                                        $q2_cf_sum = $q2_cf_sum + $all_q2_cf + $all_q1;

                                        $output .='<td class="text-center line-hight bgColor">'.$all_q2_cf_sum.'</td>';

                                        $cmp_q2_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                        $all_q2_new = 
                                            $cmp_q2_new[0]['CMPL_NEW'] + 
                                            $cmp_q2_new[0]['CMPC_NEW'] + 
                                            $cmp_q2_new[0]['CMPLG_NEW'] + 
                                            $cmp_q2_new[0]['CMPI_NEW'] + 
                                            $cmp_q2_new[0]['CMPB_NEW'] + 
                                            $cmp_q2_new[0]['CMPBB_NEW'] + 
                                            $cmp_q2_new[0]['CMPV_NEW'];

                                        $q2_new_sum = $q2_new_sum + $all_q2_new;

                                        $output .='<td class="text-center line-hight">'.$all_q2_new.'</td>';

                                        $cmp_q2_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                        $all_q2_total = 
                                            $cmp_q2_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q2_total[0]['CMPV_TOTAL'];

                                        $all_q2 = $all_q2_total + $all_q2_cf_sum;

                                        $q2_tot_sum = $q2_tot_sum + $all_q2;

                                        $output .='<td class="text-center line-hight">'.$all_q2.'</td>';

                                        $cmp_q2_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                        $all_q2_closed = 
                                            $cmp_q2_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q2_closed[0]['CMPV_CLOSED'];

                                        $q2_cls_sum = $q2_cls_sum + $all_q2_closed;

                                        $output .='<td class="text-center line-hight">'.$all_q2_closed.'</td>';
                                        // Q2 End

                                        // Q3 Start
                                        $cmp_q3_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,$status);

                                        $all_q3_cf = 
                                            $cmp_q3_cf[0]['CMPL_NEW'] + 
                                            $cmp_q3_cf[0]['CMPC_NEW'] + 
                                            $cmp_q3_cf[0]['CMPLG_NEW'] + 
                                            $cmp_q3_cf[0]['CMPI_NEW'] + 
                                            $cmp_q3_cf[0]['CMPB_NEW'] + 
                                            $cmp_q3_cf[0]['CMPBB_NEW'] + 
                                            $cmp_q3_cf[0]['CMPV_NEW'];

                                        $all_q3 = $all_q3_cf + $all_q2_cf_sum;

                                        $q3_cf_sum = $q3_cf_sum + $all_q3;

                                        $output .='<td class="text-center line-hight bgColor">'.$all_q3.'</td>';

                                        $cmp_q3_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                        $all_q3_new = 
                                            $cmp_q3_new[0]['CMPL_NEW'] + 
                                            $cmp_q3_new[0]['CMPC_NEW'] + 
                                            $cmp_q3_new[0]['CMPLG_NEW'] + 
                                            $cmp_q3_new[0]['CMPI_NEW'] + 
                                            $cmp_q3_new[0]['CMPB_NEW'] + 
                                            $cmp_q3_new[0]['CMPBB_NEW'] + 
                                            $cmp_q3_new[0]['CMPV_NEW'];

                                        $q3_new_sum = $q3_new_sum + $all_q3_new;

                                        $output .='<td class="text-center line-hight">'.$all_q3_new.'</td>';

                                        $cmp_q3_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                        $all_q3_total = 
                                            $cmp_q3_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q3_total[0]['CMPV_TOTAL'];

                                        $all_q3 = $all_q3_total + $all_q3_cf + $all_q2_cf_sum;

                                        $q3_tot_sum = $q3_tot_sum + $all_q3;

                                        $output .='<td class="text-center line-hight">'.$all_q3.'</td>';


                                        $cmp_q3_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                        $all_q3_closed = 
                                            $cmp_q3_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q3_closed[0]['CMPV_CLOSED'];

                                        $q3_cls_sum = $q3_cls_sum + $all_q3_closed;

                                        $output .='<td class="text-center line-hight">'.$all_q3_closed.'</td>';
                                        // Q3 End

                                        // Q4 Start
                                        $cmp_q4_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,$status);

                                        $all_q4_cf = 
                                            $cmp_q4_cf[0]['CMPL_NEW'] + 
                                            $cmp_q4_cf[0]['CMPC_NEW'] + 
                                            $cmp_q4_cf[0]['CMPLG_NEW'] + 
                                            $cmp_q4_cf[0]['CMPI_NEW'] + 
                                            $cmp_q4_cf[0]['CMPB_NEW'] + 
                                            $cmp_q4_cf[0]['CMPBB_NEW'] + 
                                            $cmp_q4_cf[0]['CMPV_NEW'];


                                        // New Addition
                                        $all_q4_sum = $all_q4_cf + $all_q3_cf + $all_q2_cf_sum;

                                        $q4_cf_sum = $q4_cf_sum + $all_q4_sum;

                                        $output .='<td class="text-center line-hight bgColor">'.$all_q4_sum.'</td>';


                                        $cmp_q4_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                        $all_q4_new = 
                                            $cmp_q4_new[0]['CMPL_NEW'] + 
                                            $cmp_q4_new[0]['CMPC_NEW'] + 
                                            $cmp_q4_new[0]['CMPLG_NEW'] + 
                                            $cmp_q4_new[0]['CMPI_NEW'] + 
                                            $cmp_q4_new[0]['CMPB_NEW'] + 
                                            $cmp_q4_new[0]['CMPBB_NEW'] + 
                                            $cmp_q4_new[0]['CMPV_NEW'];

                                        $q4_new_sum = $q4_new_sum + $all_q4_new;

                                        $output .='<td class="text-center line-hight">'.$all_q4_new.'</td>';


                                        $cmp_q4_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                        $all_q4_total = 
                                            $cmp_q4_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q4_total[0]['CMPV_TOTAL'];

                                        $all_q4 = $all_q4_total + $all_q4_sum;

                                        $q4_tot_sum = $q4_tot_sum + $all_q4_total + $all_q4_sum;

                                        $output .='<td class="text-center line-hight">'.$all_q4.'</td>';


                                        $cmp_q4_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                        $all_q4_closed = 
                                            $cmp_q4_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q4_closed[0]['CMPV_CLOSED'];

                                        $q4_cls_sum = $q4_cls_sum + $all_q4_closed;

                                        $output .='<td class="text-center line-hight">'.$all_q4_closed.'</td>';
                                        // Q4 End

                                        // Pending Start
                                        $cmp_pending = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'',$year,'');

                                        $all_pending = 
                                            $cmp_pending[0]['CMPL_PENDING'] + 
                                            $cmp_pending[0]['CMPC_PENDING'] + 
                                            $cmp_pending[0]['CMPLG_PENDING'] + 
                                            $cmp_pending[0]['CMPI_PENDING'] + 
                                            $cmp_pending[0]['CMPB_PENDING'] + 
                                            $cmp_pending[0]['CMPBB_PENDING'] + 
                                            $cmp_pending[0]['CMPV_PENDING'];

                                        $pending_sum = $pending_sum + $all_pending;

                                        $output .='<td class="text-center line-hight bgColor">'.$all_pending.'</td>';
                                        // Pending End
                                    }
                                    else
                                    {
                                        $output .='<td>NA</td>';

                                        $output .='<td class="text-center line-hight bgColor">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';

                                        $output .='<td class="text-center line-hight bgColor">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';

                                        $output .='<td class="text-center line-hight bgColor">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';

                                        $output .='<td class="text-center line-hight bgColor">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';

                                        $output .='<td class="text-center line-hight bgColor">0</td>';
                                    }
                                $output .='</tr>';
                            }
                        $output .='</tr>';
                    }
                $output .='</tbody>';

                $output .='<tfoot>';
                    $output .='<tr>';
                        $output .='<td colspan="2" class="text-center line-hight boldText">Grand Total</td>';

                        $output .='<td class="text-center line-hight boldText">'.$opening_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_new_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_tot_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_cls_sum.'</td>';

                        $output .='<td class="text-center line-hight boldText">'.$q2_cf_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q2_new_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q2_tot_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q2_cls_sum.'</td>';

                        $output .='<td class="text-center line-hight boldText">'.$q3_cf_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q3_new_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q3_tot_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q3_cls_sum.'</td>';

                        $output .='<td class="text-center line-hight boldText">'.$q4_cf_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q4_new_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q4_tot_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q4_cls_sum.'</td>';

                        $output .='<td class="text-center line-hight boldText">'.$pending_sum.'</td>';
                    $output .='</tr>';
                $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_quarterly_departmental_complaint_rpt')
        {
            $year = isset($_POST['getYear'])?$_POST['getYear']:'';
            echo "success|".$year;
        }
        elseif($action == 'search_cmp_annual_departmental_complaint_rpt')
        {
            $year       = isset($_POST['getYear'])?$_POST['getYear']:'';
            $year       = (int) $year;
            $year_last  = $year - 1; //get 1 year back
            $status     = "1,2,6";

            $deprtments = $objComplaintReport->getDepartmentById('');
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                $output .='<thead>';
                    $output .='<tr>';
                        $output .='<th rowspan="2" class="text-center line-hight">Department</th>';
                        $output .='<th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>';
                        $output .='<th colspan="4" class="text-center">'. $year .'</th>';
                        $output .='<th rowspan="2" class="text-center line-hight">Pending</th>';
                    $output .='</tr>';

                    $output .='<tr>';
                        $output .='<th class="text-center line-hight">Opening '. $year_last .'</th>';
                        $output .='<th class="text-center line-hight">New</th>';
                        $output .='<th class="text-center line-hight">Total</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';
                    $output .='</tr>';
                $output .='</thead>';

                $output .='<tbody>';
                    $cmpTotalLogged = 0;
                    $cmpTotalPercentage = 0;

                    $opening_sum = 0;
                    $q1_new_sum = 0;
                    $q1_tot_sum = 0;
                    $q1_cls_sum = 0;

                    $lastyear_open_sum = 0;

                    $pending_sum = 0;

                    foreach($deprtments as $deprtment)
                    {
                        $deprtment_id = $deprtment['id'];
                        $data2        =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                        $rowspan      = count($data2);
                        $rowspan      = $rowspan + 1;

                        $output .='<tr>';
                            $output .='<td rowspan="'.$rowspan.'"  class="text-center line-hight">'.$deprtment['primary_name'].'</td>';

                            for($i=0; $i<count($data2); $i++) 
                            {
                                $output .='<tr>';
                                    if($data2 != 0) 
                                    {
                                        //Start
                                        $output .='<td class="text-center line-hight">'.$data2[$i]['fullname'].'</td>';
                                        $cmp_q1_open = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year_last,$status);

                                        $all_q1_open = 
                                            $cmp_q1_open[0]['CMPL_OPEN'] + 
                                            $cmp_q1_open[0]['CMPC_OPEN'] + 
                                            $cmp_q1_open[0]['CMPLG_OPEN'] + 
                                            $cmp_q1_open[0]['CMPI_OPEN'] + 
                                            $cmp_q1_open[0]['CMPB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPBB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPV_OPEN'];

                                        // For Total Col-1
                                        $opening_sum = $opening_sum + $all_q1_open;

                                        $lastyear_open_sum = $lastyear_open_sum + $all_q1_open;

                                        $output .='<td class="text-center line-hight">'.$all_q1_open.'</td>';

                                        $cmp_q1_new = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        $all_q1_new = 
                                            $cmp_q1_new[0]['CMPL_NEW'] + 
                                            $cmp_q1_new[0]['CMPC_NEW'] + 
                                            $cmp_q1_new[0]['CMPLG_NEW'] + 
                                            $cmp_q1_new[0]['CMPI_NEW'] + 
                                            $cmp_q1_new[0]['CMPB_NEW'] + 
                                            $cmp_q1_new[0]['CMPBB_NEW'] + 
                                            $cmp_q1_new[0]['CMPV_NEW'];

                                        // For Total Col-2
                                        $q1_new_sum = $q1_new_sum + $all_q1_new;

                                        $output .='<td class="text-center line-hight">'.$all_q1_new.'</td>';

                                        $cmp_q1_total = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        $all_q1_total = 
                                            $cmp_q1_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPV_TOTAL'];

                                        // For Field Col-3
                                        $all_q1 = $all_q1_total + $all_q1_open;

                                        // For Total Col-2
                                        $q1_tot_sum = $q1_tot_sum + $all_q1;

                                        $output .='<td class="text-center line-hight">'.$all_q1.'</td>';

                                        $cmp_q1_closed = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        $all_q1_closed = 
                                            $cmp_q1_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPV_CLOSED'];

                                        // For Total Col-4
                                        $q1_cls_sum = $q1_cls_sum + $all_q1_closed;

                                        $output .='<td class="text-center line-hight">'.$all_q1_closed.'</td>';
                                        //End

                                        // Pending Start
                                        $cmp_pending = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        $all_pending = 
                                            $cmp_pending[0]['CMPL_PENDING'] + 
                                            $cmp_pending[0]['CMPC_PENDING'] + 
                                            $cmp_pending[0]['CMPLG_PENDING'] + 
                                            $cmp_pending[0]['CMPI_PENDING'] + 
                                            $cmp_pending[0]['CMPB_PENDING'] + 
                                            $cmp_pending[0]['CMPBB_PENDING'] + 
                                            $cmp_pending[0]['CMPV_PENDING'];

                                        $pending_sum = $pending_sum + $all_pending;

                                        $output .='<td class="text-center line-hight">'.$all_pending.'</td>';
                                        // Pending End
                                    }
                                    else
                                    {
                                        $output .='<td class="text-center line-hight">NA</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                    }
                                $output .='</tr>';
                            }
                        $output .='</tr>';
                    }
                $output .='</tbody>';

                $output .='<tfoot>';
                    $output .='<tr>';
                        $output .='<td colspan="2" class="text-center line-hight boldText">Grand Total</td>';

                        $output .='<td class="text-center line-hight boldText">'.$opening_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_new_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_tot_sum.'</td>';
                        $output .='<td class="text-center line-hight">'.$q1_cls_sum.'</td>';

                        $output .='<td class="text-center line-hight boldText">'.$pending_sum.'</td>';
                    $output .='</tr>';
                $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_annual_departmental_complaint_rpt')
        {
            $year = isset($_POST['getYear'])?$_POST['getYear']:'';
            echo "success|".$year;
        }
        elseif($action == 'search_cmp_board_of_directors_quarterly_rpt')
        {
            $forum      = isset($_POST['getForum'])?$_POST['getForum']:'';
            $year       = isset($_POST['getYear'])?$_POST['getYear']:'';
            $year       = (int) $year;
            $year_last  = $year - 1;        //get 1 year back
            $status     = "1,2,5,6";

            $objComplaintReport = new ComplaintReport();
            $forum_names        = $objComplaintReport->getForumFromDBById($forum);
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                $output .='<thead>';
                    $output .='<tr>';
                        $output .='<th rowspan="2" class="text-center line-hight">Forum</th>';
                        $output .='<th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>';
                        $output .='<th colspan="3" class="text-center">Quarter-1 of '. $year .'</th>';
                        $output .='<th colspan="3" class="text-center">Quarter-2 of '. $year .'</th>';
                        $output .='<th colspan="3" class="text-center">Quarter-3 of '. $year .'</th>';
                        $output .='<th colspan="4" class="text-center">Quarter-4 of '. $year .'</th>';
                    $output .='</tr>';

                    $output .='<tr>';
                        $output .='<th class="text-center line-hight">Opening '. $year_last .'</th>';
                        $output .='<th class="text-center line-hight">Received</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">Received</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">Received</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';

                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">Received</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';
                        $output .='<th class="text-center line-hight">Pending</th>';
                    $output .='</tr>';
                $output .='</thead>';

                $sum_open_last_year = 0;

                $sum_open_q1 = 0;
                $sum_open_q2 = 0;
                $sum_open_q3 = 0;
                $sum_open_q4 = 0;

                $sum_closed_q1 = 0;
                $sum_closed_q2 = 0;
                $sum_closed_q3 = 0;
                $sum_closed_q4 = 0;

                $sum_cf_for_q2 = 0;
                $sum_cf_for_q3 = 0;
                $sum_cf_for_q4 = 0;

                $sum_pendding_q4 = 0;

                $output .='<tbody>';
                    foreach($forum_names as $forum_name)
                    {
                        $forum_name_id = $forum_name['id'];
                        $data2 =  $objComplaintReport->getComplaintTypeByForumId($forum_name_id);
                        $rowspan = count($data2);
                        $rowspan = $rowspan + 1;

                        $output .='<tr>';
                            $output .='<td rowspan="'.$rowspan.'"  class="text-center line-hight">'.$forum_name['fullname'].'</td>';

                            for($i=0; $i<count($data2); $i++)
                            {
                                $output .='<tr>';
                                    if($data2 != 0) 
                                    {
                                        $output .='<td class=" line-hight">'.$data2[$i]['dept_type'].'</td>';

                                        $complaint_type_id = $data2[$i]['complaint_type_id'];

                                        // Quarter-1 Start //
                                        $cmp_open_last_year = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year_last,$status);
                                        $cmp_open_last_year = $cmp_open_last_year[0]['CMP_COUNTS'];
                                        $sum_open_last_year = $sum_open_last_year + $cmp_open_last_year;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_open_last_year.'</td>';

                                        $cmp_open_q1 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'01',$year,$status);
                                        $cmp_open_q1 = $cmp_open_q1[0]['CMP_COUNTS'];
                                        $sum_open_q1 = $sum_open_q1 + $cmp_open_q1;
                                        $output .='<td class="text-center line-hight">'.$cmp_open_q1.'</td>';

                                        $cmp_closed_q1 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'01',$year,'3');
                                        $cmp_closed_q1 = $cmp_closed_q1[0]['CMP_COUNTS'];
                                        $sum_closed_q1 = $sum_closed_q1 + $cmp_closed_q1;
                                        $output .='<td class="text-center line-hight">'.$cmp_closed_q1.'</td>';
                                        // Quarter-1 End //



                                        // Quarter-2 Start //
                                        $cmp_cf_for_q2 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2;

                                        $sum_cf_for_q2 = $sum_cf_for_q2 + $cmp_cf_for_q2;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_cf_for_q2.'</td>';

                                        $cmp_open_q2 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'02',$year,$status);
                                        $cmp_open_q2 = $cmp_open_q2[0]['CMP_COUNTS'];
                                        $sum_open_q2 = $sum_open_q2 + $cmp_open_q2;
                                        $output .='<td class="text-center line-hight">'.$cmp_open_q2.'</td>';

                                        $cmp_closed_q2 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'02',$year,'03');
                                        $cmp_closed_q2 = $cmp_closed_q2[0]['CMP_COUNTS'];
                                        $sum_closed_q2 = $sum_closed_q2 + $cmp_closed_q2;
                                        $output .='<td class="text-center line-hight">'.$cmp_closed_q2.'</td>';
                                        // Quarter-2 End //



                                        // Quarter-3 Start //
                                        $cmp_cf_for_q3 = $cmp_cf_for_q2 + $cmp_open_q2;
                                        $sum_cf_for_q3 = $sum_cf_for_q3 + $cmp_cf_for_q3;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_cf_for_q3.'</td>';

                                        $cmp_open_q3 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'03',$year,$status);
                                        $cmp_open_q3 = $cmp_open_q3[0]['CMP_COUNTS'];
                                        $sum_open_q3 = $sum_open_q3 + $cmp_open_q3;
                                        $output .='<td class="text-center line-hight">'.$cmp_open_q3.'</td>';

                                        $cmp_closed_q3 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'03',$year,'03');
                                        $cmp_closed_q3 = $cmp_closed_q3[0]['CMP_COUNTS'];
                                        $sum_closed_q3 = $sum_closed_q3 + $cmp_closed_q3;
                                        $output .='<td class="text-center line-hight">'.$cmp_closed_q3.'</td>';
                                        // Quarter-3 End //



                                        // Quarter-4 Start //
                                        $cmp_cf_for_q4 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2 + $cmp_open_q3;
                                        $sum_cf_for_q4 = $sum_cf_for_q4 + $cmp_cf_for_q4;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_cf_for_q4.'</td>';

                                        $cmp_open_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,$status);
                                        $cmp_open_q4 = $cmp_open_q4[0]['CMP_COUNTS'];
                                        $sum_open_q4 = $sum_open_q4 + $cmp_open_q4;
                                        $output .='<td class="text-center line-hight">'.$cmp_open_q4.'</td>';

                                        $cmp_closed_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,'03');
                                        $cmp_closed_q4 = $cmp_closed_q4[0]['CMP_COUNTS'];
                                        $sum_closed_q4 = $sum_closed_q4 + $cmp_closed_q4;
                                        $output .='<td class="text-center line-hight">'.$cmp_closed_q4.'</td>';

                                        $cmp_open_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,$status);
                                                $cmp_open_q4 = $cmp_open_q4[0]['CMP_COUNTS'];
                                        $cmp_pendding_q4 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2 + $cmp_open_q3 + $cmp_open_q4;
                                        $sum_pendding_q4 = $sum_pendding_q4 + $cmp_pendding_q4;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_pendding_q4.'</td>';
                                        // Quarter-4 End //
                                    }
                                    else
                                    {
                                        $output .='<td class="text-center line-hight">NA</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                    }
                                $output .='</tr>';
                            }
                        $output .='</tr>';
                    }
                $output .='</tbody>';

                $output .='<tfoot>';
                    $output .='<tr>';
                        $output .='<td colspan="2" class="text-center line-hight">Total</td>';

                        $output .='<td class="text-center line-hight">'.$sum_open_last_year.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_open_q1.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_closed_q1.'</td>';

                        $output .='<td class="text-center line-hight">'.$sum_cf_for_q2.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_open_q2.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_closed_q2.'</td>';

                        $output .='<td class="text-center line-hight">'.$sum_cf_for_q3.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_open_q3.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_closed_q3.'</td>';

                        $output .='<td class="text-center line-hight">'.$sum_cf_for_q4.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_open_q4.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_closed_q4.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_pendding_q4.'</td>';
                    $output .='</tr>';
                $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_board_of_directors_quarterly_rpt')
        {
            $year  = isset($_POST['getYear'])?$_POST['getYear']:'';
            $forum = isset($_POST['getForum'])?$_POST['getForum']:'';
            echo "success|".$year."|".$forum;
        }
        elseif($action == 'search_cmp_board_of_directors_yearly_rpt')
        {
            $forum      = isset($_POST['getForum'])?$_POST['getForum']:'';
            $year       = isset($_POST['getYear'])?$_POST['getYear']:'';
            $year       = (int) $year;
            $year_last  = $year - 1;
            $status     = "1,2,5,6";

            $objComplaintReport = new ComplaintReport();
            $forum_names        = $objComplaintReport->getForumFromDBById($forum);
            
            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                $output .='<thead>';
                    $output .='<tr>';
                        $output .='<th rowspan="2" class="line-hight">Forum</th>';
                        $output .='<th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>';
                        $output .='<th colspan="4" class="text-center">Grand Total</th>';
                    $output .='</tr>';

                    $output .='<tr>';
                        $output .='<th class="text-center line-hight">CF</th>';
                        $output .='<th class="text-center line-hight">Received</th>';
                        $output .='<th class="text-center line-hight">Closed</th>';
                        $output .='<th class="text-center line-hight">Pending</th>';
                    $output .='</tr>';
                $output .='</thead>';

                $sum_cf = 0;
                $sum_open = 0;
                $sum_closed = 0;
                $sum_pendding = 0;

                $output .='<tbody>';
                    foreach($forum_names as $forum_name)
                    {
                        $forum_name_id = $forum_name['id'];
                        $data2 =  $objComplaintReport->getComplaintTypeByForumId($forum_name_id);
                        $rowspan = count($data2);
                        $rowspan = $rowspan + 1;

                        $output .='<tr>';
                            $output .='<td rowspan="'.$rowspan.'"  class="line-hight">'.$forum_name['fullname'].'</td>';

                            for($i=0; $i<count($data2); $i++)
                            {
                                $output .='<tr>';
                                    if($data2 != 0) 
                                    {
                                        $output .='<td>'.$data2[$i]['dept_type'].'</td>';

                                        $complaint_type_id = $data2[$i]['complaint_type_id'];

                                        $cmp_cf = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year_last,$status);
                                        $cmp_cf = $cmp_cf[0]['CMP_COUNTS'];
                                        $sum_cf = $sum_cf + $cmp_cf;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_cf.'</td>';

                                        $cmp_open = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,$status);
                                        $cmp_open = $cmp_open[0]['CMP_COUNTS'];
                                        $sum_open = $sum_open + $cmp_open;
                                        $output .='<td class="text-center line-hight">'.$cmp_open.'</td>';

                                        $cmp_closed = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,'3');
                                        $cmp_closed = $cmp_closed[0]['CMP_COUNTS'];
                                        $sum_closed = $sum_closed + $cmp_closed;
                                        $output .='<td class="text-center line-hight">'.$cmp_closed.'</td>';

                                        $cmp_pendding = $cmp_cf + $cmp_open;
                                        $sum_pendding = $sum_pendding + $cmp_pendding;
                                        $output .='<td class="bgColor text-center line-hight">'.$cmp_pendding.'</td>';
                                    }
                                    else
                                    {
                                        $output .='<td class="text-center line-hight">NA</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                        $output .='<td class="text-center line-hight">0</td>';
                                    }
                                $output .='</tr>';
                            }
                        $output .='</tr>';
                    }
                $output .='</tbody>';

                $output .='<tfoot>';
                    $output .='<tr>';
                        $output .='<td colspan="2" class="text-center line-hight">Total</td>';

                        $output .='<td class="text-center line-hight">'.$sum_cf.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_open.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_closed.'</td>';
                        $output .='<td class="text-center line-hight">'.$sum_pendding.'</td>';
                    $output .='</tr>';
                $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_cmp_board_of_directors_yearly_rpt')
        {
            $year  = isset($_POST['getYear'])?$_POST['getYear']:'';
            $forum = isset($_POST['getForum'])?$_POST['getForum']:'';
            echo "success|".$year."|".$forum;
        }
    }
}

?>