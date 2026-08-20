<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $durationType   = isset($_GET['getDurationType'])?$_GET['getDurationType']:'';
    $month1         = isset($_GET['getMonth1'])?$_GET['getMonth1']:'';
    $month2         = isset($_GET['getMonth2'])?$_GET['getMonth2']:'';
    $quarter1       = isset($_GET['getQuarter1'])?$_GET['getQuarter1']:'';
    $quarter2       = isset($_GET['getQuarter2'])?$_GET['getQuarter2']:'';
    $year1          = isset($_GET['getYear1'])?$_GET['getYear1']:'';
    $year2          = isset($_GET['getYear2'])?$_GET['getYear2']:'';

    $objComplaintReport = new ComplaintReport();

    if($durationType != '' AND $durationType == 1)
    {
        $getDurationType = 'Monthly';
        $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,$month1,'','');
        $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,$month2,'','');

        $month_name1 = $objComplaintReport->getMonthFromDBById($month1);
        $month_name2 = $objComplaintReport->getMonthFromDBById($month2);

        $getDurationMQY1 = $month_name1[0]['month_name'];
        $getDurationMQY2 = $month_name2[0]['month_name'];
    }

    if($durationType != '' AND $durationType == 2)
    {
        $getDurationType = 'Quarterly';
        $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,'',$quarter1,'');
        $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,'',$quarter2,'');

        $quarter_name1 = $objComplaintReport->getQuarterFromDBById($quarter1);
        $quarter_name2 = $objComplaintReport->getQuarterFromDBById($quarter2);

        $getDurationMQY1 = $quarter_name1[0]['quarter_name'];
        $getDurationMQY2 = $quarter_name2[0]['quarter_name'];
    }
    
    if($durationType != '' AND $durationType == 3)
    {
        $getDurationType = 'Yearly';
        $data1 = $objComplaintReport->countsAllComplaintComparison($durationType,'','',$year1);
        $data2 = $objComplaintReport->countsAllComplaintComparison($durationType,'','',$year2);

        $getDurationMQY1 = $year1;
        $getDurationMQY2 = $year2;
    }

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_comparison_downlod.xls"');
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
            text-align: center !important;
        }
        .tblBody{
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
                    <td></td>
                    <td align="right" valign="top">
                        <h4>Comparison Analysis Report</h4>
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
                        <b class="DurationMQY1">Month1/Quarter1/Year1:</b> 
                        <span id="spanDurationMQY1"> <?php print_r($getDurationMQY1); ?> </span>
                    </td>
                    <td align="right">
                        <b class="DurationMQY2">Month2/Quarter2/Year2:</b> 
                        <span id="spanDurationMQY2"> <?php print_r($getDurationMQY2); ?> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="100px;" class="text-center"><?php echo $getDurationMQY1; ?></th>
                <th width="100px;" class="text-center"><?php echo $getDurationMQY2; ?></th>
                <th width="100px;" class="text-center">Improvement</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <tr class="tblBody">
                <td width="100px;">Complaints logged in <?php echo $getDurationMQY1; ?></td>
                <td width="100px;">Complaints logged in <?php echo $getDurationMQY2; ?></td>
                <td width="100px;">Improvement in Percentage</td>
            </tr>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td width="100px;"><?php echo $data1[0]['ALLCMPSUM']; ?></td>
                <td width="100px;"><?php echo $data2[0]['ALLCMPSUM']; ?></td>
                <td width="100px;">
                    <?php
                        $A = $data1[0]['ALLCMPSUM'];
                        $B = $data2[0]['ALLCMPSUM'];
                        echo (($A-$B)/($A+$B)*100)."%";
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>