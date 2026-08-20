<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $objComplaintReport = new ComplaintReport();

    $deprtments = $objComplaintReport->getDepartmentById('');
    $data       = $objComplaintReport->countsComplaintTypewiseOnLoad('','','','','','');

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_typewise_downlod_all.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            text-align: left !important;
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
                    <td colspan="3"></td>
                    <td align="right" valign="top">
                        <h4>Type Wise Complaint Analysis Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="3"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="DurationType">Duration Type:</b> 
                        <span id="spanDurationType"> All </span>
                    </td>
                    <td colspan="1"></td>
                    <td align="left">
                        <b class="DurationMQY">Month/Quarter/Year:</b> 
                        <span id="spanDurationMQY"> All </span>
                    </td>
                    <td colspan="1"></td>
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
                <th width="100px;">Department Name</th>
                <th width="50px;">Departmental %</th>
                <th width="150px;">Complaint Type</th>
                <th width="200px;">Complaints logged in (Selected Duration)</th>
                <th width="100px;">Complaint Type %</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php $cmpTotalLogged = 0; ?>
            <?php $cmpTotalPercentage = 0; ?>

            <?php foreach($deprtments as $deprtment): ?>
                <?php $cmpTotalTypewisePercentage = 0; ?>
                <?php
                    $deprtment_id = $deprtment['id'];
                    $data2 =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                    $rowspan1 = count($data2);
                    $rowspan1 = $rowspan1 + 1;
                ?>
                <tr>
                    <td valign="top" rowspan="<?php echo $rowspan1; ?>"><?php echo $deprtment['primary_name']; ?>
                    </td>                                    

                    <td valign="top" rowspan="<?php echo $rowspan1; ?>">
                        <?php 
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
                            $departmentalPercentage = 
                                $complaintsloggedw[0]['CMPL'] + 
                                $complaintsloggedw[0]['CMPC'] + 
                                $complaintsloggedw[0]['CMPLG'] + 
                                $complaintsloggedw[0]['CMPI'] + 
                                $complaintsloggedw[0]['CMPB'] + 
                                $complaintsloggedw[0]['CMPBB'] + 
                                $complaintsloggedw[0]['CMPV'];

                            $departmentalPercentage = ($departmentalPercentage/$allCmp)*100;

                            echo number_format($departmentalPercentage,2)."%";
                        ?>
                    </td>

                    <?php for($i=0; $i<count($data2); $i++) { ?>
                        <tr>
                            <?php if($data2 != 0) { ?>
                                <td><?php echo $data2[$i]['fullname']; ?></td>
                                <td>
                                    <?php
                                        $complaintslogged = $objComplaintReport->countsComplaintTypewiseOnLoad('',$data2[$i]['id'],$durationType,$month,$quarter,$year);

                                        $allcomplaintslogged = 
                                            $complaintslogged[0]['CMPL'] + 
                                            $complaintslogged[0]['CMPC'] + 
                                            $complaintslogged[0]['CMPLG'] + 
                                            $complaintslogged[0]['CMPI'] + 
                                            $complaintslogged[0]['CMPB'] + 
                                            $complaintslogged[0]['CMPBB'] + 
                                            $complaintslogged[0]['CMPV'];

                                        echo $allcomplaintslogged;

                                        // For Total Complaints logged in (Selected Duration)
                                        $cmpTotalLogged = $cmpTotalLogged + $allcomplaintslogged;
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $countsAllComplaint = $objComplaintReport->countsComplaintTypewiseOnLoad('','',$durationType,$month,$quarter,$year);
                                        $countsAllCmp = 
                                            $countsAllComplaint[0]['CMPL'] +
                                            $countsAllComplaint[0]['CMPC'] +
                                            $countsAllComplaint[0]['CMPLG'] +
                                            $countsAllComplaint[0]['CMPI'] +
                                            $countsAllComplaint[0]['CMPB'] +
                                            $countsAllComplaint[0]['CMPBB'] +
                                            $countsAllComplaint[0]['CMPV'];

                                        $CmpTypePercentage = ($allcomplaintslogged/$countsAllCmp)*100;

                                        echo number_format($CmpTypePercentage,2)."%";

                                        // For Total Complaint Type %
                                        $cmpTotalPercentage = $cmpTotalPercentage + $CmpTypePercentage;

                                        $cmpTotalTypewisePercentage = $cmpTotalPercentage;

                                        //$cmpTotalTypewisePercentage + $CmpTypePercentage;
                                    ?>
                                </td>
                            <?php } else { ?>
                                <td><?php echo "NA"; ?></td>
                                <td><?php echo "0"; ?></td>
                                <td><?php echo "0.00%"; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td>Total</td>
                <td colspan="2"><?php echo "100.00%"; ?></td>
                <td align="right"><?php echo $cmpTotalLogged; ?></td>
                <td align="right"><?php echo number_format($cmpTotalPercentage,2)."%"; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>