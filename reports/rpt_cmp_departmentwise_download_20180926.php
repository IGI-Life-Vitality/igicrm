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
            /* text-align: left !important; */
            height: 44px !important;
        }
        #tblMyTables tr td{
            border:1px solid #CCC !important;
        }
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: left !important;
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
                    <td></td>
                    <td align="right" valign="top">
                        <h4>Department Wise Complaint Analysis Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="DurationType">Duration Type:</b> 
                        <span id="spanDurationType"> <?php print_r($getDurationType); ?> </span>
                    </td>
                    <td align="left">
                        <b class="DurationMQY">Month/Quarter/Year:</b> 
                        <span id="spanDurationMQY"> <?php print_r($getDurationMQY); ?> </span>
                    </td>
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
                <th width="500px;" align="center">Department Name</th>
                <th width="400px;" align="center">Complaints logged in (Selected Duration)</th>
                <th width="150px;" align="center">Overall Percentage</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php $cmpTotalLogged = 0; ?>

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
                    <td><?php echo number_format(($sum_deprt_cmp/$all_sum_deprt_cmp)*100,2)."%"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td>Total</td>
                <td align="right"><?php echo $cmpTotalLogged; ?></td>
                <td align="right"><?php echo number_format($overallPercentage,2)."%"; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>