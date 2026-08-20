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
    header('Content-Disposition: attachment; filename="rpt_cmp_channelwise_downlod_all.xls"');
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
            /* text-align: left !important; */
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
                        <h4>Channel Wise Complaint Analysis Report</h4>
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
                <th width="150px;">Complaint Channel</th>
                <th width="200px;">Complaints logged in (Selected Duration)</th>
                <th width="100px;">Complaint Type %</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php $CMPChannelPercentage  = 0; ?>
            <?php $CMPTotalPercentage = 0; ?>

            <?php foreach($deprtments as $deprtment): ?>
                <?php $cmpTotalTypewisePercentage = 0; ?>
                <?php
                    $department_id = $deprtment['id'];
                    $data =  $objComplaintReport->getComplaintByChannelId($department['id']);
                    $channel_counts = $objComplaintReport->countsComplaintChannel($department_id,'','','','');
                ?>
                <?php 
                    $L = number_format(($channel_counts[0]['CMPL']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $C = number_format(($channel_counts[0]['CMPC']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $LG = number_format(($channel_counts[0]['CMPLG']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $I = number_format(($channel_counts[0]['CMPI']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $B = number_format(($channel_counts[0]['CMPB']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $BB = number_format(($channel_counts[0]['CMPBB']/$channel_counts[0]['CMPCOUNTS'])*100,2);
                    $V = number_format(($channel_counts[0]['CMPV']/$channel_counts[0]['CMPCOUNTS'])*100,2);

                    $OVERALLPERCENTAGE = $L+$C+$LG+$I+$B+$BB+$V;
                ?>
                <tr>
                    <td rowspan="7" valign="top"><?php echo $deprtment['primary_name']; ?>
                    </td>
                    <td rowspan="7" valign="top" align="left"><?php echo number_format($OVERALLPERCENTAGE,2)."%"; ?></td>
                    <td>Individual Life</td>
                    <td><?php echo $channel_counts[0]['CMPL']; ?></td>
                    <td><?php echo $L; ?>%</td>
                </tr>
                <tr>
                    <td>Corporate Policy Holder</td>
                    <td><?php echo $channel_counts[0]['CMPC']; ?></td>
                    <td><?php echo $C; ?>%</td>
                </tr>
                <tr>
                    <td>Legal/Fraudalent Complaints</td>
                    <td><?php echo $channel_counts[0]['CMPLG']; ?></td>
                    <td><?php echo $LG; ?>%</td>
                </tr>
                <tr>
                    <td>Internal Complaints</td>
                    <td><?php echo $channel_counts[0]['CMPI']; ?></td>
                    <td><?php echo $I; ?>%</td>
                </tr>
                <tr>
                    <td>Bancassurance - (Banca - Individual)</td>
                    <td><?php echo $channel_counts[0]['CMPB']; ?></td>
                    <td><?php echo $B; ?>%</td>
                </tr>
                <tr>
                    <td>Bancassurance - (Banca - Bank)</td>
                    <td><?php echo $channel_counts[0]['CMPBB']; ?></td>
                    <td><?php echo $BB; ?>%</td>
                </tr>
                <tr>
                    <td>Vitality Complaints</td>
                    <td><?php echo $channel_counts[0]['CMPV']; ?></td>
                    <td><?php echo $V; ?>%</td>
                </tr>
                <?php $CMPChannelPercentage = $CMPChannelPercentage + $channel_counts[0]['CMPPERCENTAGE']; ?>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td>Total</td>
                <td colspan="2" align="left"><?php echo "100.00%"; ?></td>
                <td><?php echo $channel_counts[0]['CMPCOUNTS']; ?></td>
                <td><?php echo number_format($CMPChannelPercentage,2)."%"; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>