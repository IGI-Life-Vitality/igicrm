<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $objComplaintReport = new ComplaintReport();
    $deprtments         = $objComplaintReport->getDepartmentById(''); 

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_departmentwise_downlod_all.xls"');
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
                        <span id="spanDurationType"> All </span>
                    </td>
                    <td align="left">
                        <b class="DurationMQY">Month/Quarter/Year:</b> 
                        <span id="spanDurationMQY"> All </span>
                    </td>
                    <td align="right">
                        <b class="DepartmentName">Department Name:</b> 
                        <span id="spanDepartmentName"> All </span>
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
                    $cmp_deprt = $objComplaintReport->getComplaintByDepartmentId($deprtment_id,'','','',''); 
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
                <td align="right"><?php echo number_format($CmpTypePercentage,2)."%"; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>