<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $departmentName= isset($_GET['getDepartment'])?$_GET['getDepartment']:'';
    $durationType  = isset($_GET['getDurationType'])?$_GET['getDurationType']:'';
    $month         = isset($_GET['getMonth'])?$_GET['getMonth']:'';
    $quarter       = isset($_GET['getQuarter'])?$_GET['getQuarter']:'';
    $year          = isset($_GET['getYear'])?$_GET['getYear']:'';

    $objComplaintReport = new ComplaintReport();
    $deprtments         = $objComplaintReport->getDepartmentById($departmentName); 

    if($durationType != '' AND $durationType == 1)
    {
        $getDurationType = 'Monthly';
        $data = $objComplaintReport->countsAllComplaintComparison($durationType,$month,'','');
        $month_name = $objComplaintReport->getMonthFromDBById($month);
        $getDurationMQY = $month_name[0]['month_name'];
    }

    if($durationType != '' AND $durationType == 2)
    {
        $getDurationType = 'Quarterly';
        $data = $objComplaintReport->countsAllComplaintComparison($durationType,'',$quarter,'');
        $quarter_name = $objComplaintReport->getQuarterFromDBById($quarter);
        $getDurationMQY = $quarter_name[0]['quarter_name'];
    }
    
    if($durationType != '' AND $durationType == 3)
    {
        $getDurationType = 'Yearly';
        $data = $objComplaintReport->countsAllComplaintComparison($durationType,'','',$year);
        $getDurationMQY = $year;
    }

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_departmentwise_downlod.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            height: 44px !important;
        }
        #tblMyTables tr td{
            text-align: left;
            border:1px solid #CCC !important;
        }
        .tblHead{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: center !important;
        }
        .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: center !important;
        }
        .tabHeadLine{
            background: #CFCFCF !important;
            color: #000 !important;
        }
        .logoArea img{
            margin: 0px 0px 0px 100px!important;
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="7"></td>
                    <td align="right" valign="top" colspan="2">
                        <h4>Department Wise Complaint Analysis Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="8"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="DurationType">Duration Type:</b> 
                        <span id="spanDurationType"> <?php print_r($getDurationType); ?> </span>
                    </td>
                    <td colspan="3"></td>
                    <td align="left">
                        <b class="DurationMQY">Month/Quarter/Year:</b> 
                        <span id="spanDurationMQY"> <?php print_r($getDurationMQY); ?> </span>
                    </td>
                    <td colspan="4"></td>
                    <td align="right">
                        <b class="DepartmentName">Department Name:</b> 
                        <span id="spanDepartmentName"> <?php print_r($getDepartment); ?> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th colspan="5">Complaint Details (Selected Duration)</th>
                <th colspan="5">Opened Cases Aging in Days (Selected Duration)</th>
            </tr>
            <tr class="tblHead">
                <th>Department <br>Name</th>
                <th>Complaints <br>Logged</th>
                <th>Complaints <br>Closed</th>
                <th>Complaints <br>Opened</th>
                <th>Overall <br>Percentage</th>
                <th>00 to 03 <br>Days</th>
                <th>04 to 06 <br>Days</th>
                <th>07 to 15 <br>Day</th>
                <th>16 to 30 <br>Days</th>
                <th>Above 30 <br>Days</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php $cmpTotalLogged = 0; ?>
            <?php $cmpTotalClosed = 0; ?>
            <?php $cmpTotalOpened = 0; ?>
            <?php $cmpTotal03Days = 0; ?>
            <?php $cmpTotal06Days = 0; ?>
            <?php $cmpTotal15Days = 0; ?>
            <?php $cmpTotal30Days = 0; ?>
            <?php $cmpTotalA30Days = 0; ?>

            <?php foreach($deprtments as $deprtment): ?>
                <?php $cmpTotalTypewisePercentage = 0; ?>
                <?php 
                    $deprtment_id = $deprtment['id']; 
                    $cmp_deprt = $objComplaintReport->getComplaintByDepartmentId($deprtment_id,$durationType,$month,$quarter,$year); 
                ?>
                <tr>
                    <td><?php echo $deprtment['primary_name']; ?></td>

                    <?php
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

                        // For Overall Percentage - Start
                        $all_deprt_cmp = $objComplaintReport->countsAllComplaint();
                        $all_sum_deprt_cmp = 
                                $all_deprt_cmp[0]['L'] +
                                $all_deprt_cmp[0]['C'] +
                                $all_deprt_cmp[0]['LG'] +
                                $all_deprt_cmp[0]['I'] +
                                $all_deprt_cmp[0]['B'] +
                                $all_deprt_cmp[0]['BB'] +
                                $all_deprt_cmp[0]['V'];

                        $CmpTypePercentage = ($all_sum_deprt_cmp/$cmpTotalLogged)*100;
                        // For Overall Percentage - End

                        // For Overall Percentage After Search - Start
                        $overallPercentage = ($cmpTotalLogged/$all_sum_deprt_cmp)*100;
                        // For Overall Percentage After Search - End
                    ?> 
                    <td><?php echo $sum_deprt_cmp; ?></td>

                    <?php 
                        // For Complaints Closed SUM - Start
                        $sum_deprt_cmp_closed = 
                        $cmp_deprt[0]['CMPL_CLOSED'] + 
                        $cmp_deprt[0]['CMPC_CLOSED'] + 
                        $cmp_deprt[0]['CMPLG_CLOSED'] + 
                        $cmp_deprt[0]['CMPI_CLOSED'] + 
                        $cmp_deprt[0]['CMPB_CLOSED'] + 
                        $cmp_deprt[0]['CMPBB_CLOSED'] + 
                        $cmp_deprt[0]['CMPV_CLOSED'];

                        $cmpTotalClosed = $cmpTotalClosed + $sum_deprt_cmp_closed;
                    ?>
                    <td><?php echo $sum_deprt_cmp_closed; ?></td>

                    <?php 
                        // For Complaints Opened SUM - Start
                        $sum_deprt_cmp_opened = 
                        $cmp_deprt[0]['CMPL_OPENED'] + 
                        $cmp_deprt[0]['CMPC_OPENED'] + 
                        $cmp_deprt[0]['CMPLG_OPENED'] + 
                        $cmp_deprt[0]['CMPI_OPENED'] + 
                        $cmp_deprt[0]['CMPB_OPENED'] + 
                        $cmp_deprt[0]['CMPBB_OPENED'] + 
                        $cmp_deprt[0]['CMPV_OPENED'];

                        $cmpTotalOpened = $cmpTotalOpened + $sum_deprt_cmp_opened;
                    ?>
                    <td><?php echo $sum_deprt_cmp_opened; ?></td>

                    <td><?php echo number_format(($sum_deprt_cmp/$all_sum_deprt_cmp)*100,2)."%"; ?></td>

                    <!-- Ageing Starts Here -->
                    <?php
                        $ageing = $objComplaintReport->getComplaintOpenCaseAgingByDepartId($deprtment_id,$durationType,$month,$quarter,$year);

                        /*$ageing_0    = $ageing[0]['DAYS_0'];*/
                        $ageing_03   = $ageing[0]['DAYS_1_3'];
                        $ageing_06   = $ageing[0]['DAYS_4_6'];
                        $ageing_15   = $ageing[0]['DAYS_7_15'];
                        $ageing_30   = $ageing[0]['DAYS_16_30'];
                        $ageing_A30  = $ageing[0]['DAYS_31'];
                    ?>
                    <td>
                        <?php
                            echo $ageing_03;
                            $cmpTotal03Days += $ageing_03;
                        ?>
                    </td>

                    <td>
                        <?php
                            echo $ageing_06;
                            $cmpTotal06Days += $ageing_06;
                        ?>
                    </td>

                    <td>
                        <?php
                            echo $ageing_15;
                            $cmpTotal15Days += $ageing_15;
                        ?>
                    </td>

                    <td>
                        <?php
                            echo $ageing_30;
                            $cmpTotal30Days += $ageing_30;
                        ?>
                    </td>

                    <td>
                        <?php
                            echo $ageing_A30;
                            $cmpTotalA30Days += $ageing_A30;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td>Total</td>
                <td><?php echo $cmpTotalLogged; ?></td>
                <td><?php echo $cmpTotalClosed; ?></td>
                <td><?php echo $cmpTotalOpened; ?></td>
                <td><?php echo number_format($overallPercentage,2)."%"; ?></td>
                <td><?php echo $cmpTotal03Days; ?></td>
                <td><?php echo $cmpTotal06Days; ?></td>
                <td><?php echo $cmpTotal15Days; ?></td>
                <td><?php echo $cmpTotal30Days; ?></td>
                <td><?php echo $cmpTotalA30Days; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>