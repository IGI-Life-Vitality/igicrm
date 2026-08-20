<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $Year1   = isset($_GET['Year1'])?$_GET['Year1']:'';
    $Year2   = isset($_GET['Year2'])?$_GET['Year2']:'';

    if($Year1 == '' AND $Year2 == '')
    {
        $Year1 = DATE("Y", strtotime("-1 year"));    //Last Year
        $Year2 = DATE('Y');                          //Current Year
    }

    $objComplaintReport = new ComplaintReport();
    $data1              = $objComplaintReport->countsAnnualComplaintComparison($Year1);
    $data2              = $objComplaintReport->countsAnnualComplaintComparison($Year2);

    /*echo "<pre>";
        print_r($data1[0]);
    echo "</pre>";die;*/

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_annual_downlod.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            height: 44px !important;
        }
        #tblMyTables tr td{
            border:1px solid #CCC !important;
        }
        .tblHead{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: left !important;
        }
        .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
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
        <table id="tblMyTable" class="table table-igi table-bordered table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="2"></td>
                    <td align="right" valign="top">
                        <h4>Annual Comparison Analysis</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="2"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="Year1">Year 1:</b> 
                        <span id="spanYear1"> <?php echo $Year1; ?> </span>
                    </td>
                    <td colspan="2"></td>
                    <td align="right">
                        <b class="Year2">Year 2:</b> 
                        <span id="spanYear2"> <?php echo $Year2; ?> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="100px;" align="left">Month</th>
                <th width="150px;" align="center"><?php echo $Year1; ?></th>
                <th width="150px;" align="center"><?php echo $Year2; ?></th>
                <th width="100px;" align="right">Improvement</th>
            </tr>
        </thead>
        
        <tbody class="table table-bordered">
            <tr>
                <td>January</td>
                <td>
                    <?php 
                        $MNAME = 'JAN';

                        $JAN1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $JAN1;
                    ?>
                </td>
                <td>
                    <?php
                        $JAN2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $JAN2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($JAN1-$JAN2);
                        $B = ($JAN1+$JAN2);
                        $IMP1 = ($A / $B) * 100;
                        echo number_format($IMP1,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>February</td>
                <td>
                    <?php 
                        $MNAME = 'FAB';

                        $FAB1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $FAB1;
                    ?>
                </td>
                <td>
                    <?php
                        $FAB2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $FAB2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($FAB1-$FAB2);
                        $B = ($FAB1+$FAB2);
                        $IMP2 = ($A / $B) * 100;
                        echo number_format($IMP2,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>March</td>
                <td>
                    <?php 
                        $MNAME = 'MAR';

                        $MAR1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $MAR1;
                    ?>
                </td>
                <td>
                    <?php
                        $MAR2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $MAR2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($MAR1-$MAR2);
                        $B = ($MAR1+$MAR2);
                        $IMP3 = ($A / $B) * 100;
                        echo number_format($IMP3,2)."%";
                    ?>  
                </td>
            </tr>
            <tr>
                <td>April</td>
                <td>
                    <?php 
                        $MNAME = 'APR';

                        $APR1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $APR1;
                    ?>
                </td>
                <td>
                    <?php
                        $APR2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $APR2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($APR1-$APR2);
                        $B = ($APR1+$APR2);
                        $IMP4 = ($A / $B) * 100;
                        echo number_format($IMP4,2)."%";
                    ?>  
                </td>
            </tr>
            <tr>
                <td>May</td>
                <td>
                    <?php 
                        $MNAME = 'MAY';

                        $MAY1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $MAY1;
                    ?>
                </td>
                <td>
                    <?php
                        $MAY2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $MAY2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($MAY1-$MAY2);
                        $B = ($MAY1+$MAY2);
                        $IMP5 = ($A / $B) * 100;
                        echo number_format($IMP5,2)."%";
                    ?>  
                </td>
            </tr>
            <tr>
                <td>June</td>
                <td>
                    <?php 
                        $MNAME = 'JUN';

                        $JUN1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $JUN1;
                    ?>
                </td>
                <td>
                    <?php
                        $JUN2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $JUN2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($JUN1-$JUN2);
                        $B = ($JUN1+$JUN2);
                        $IMP6 = ($A / $B) * 100;
                        echo number_format($IMP6,2)."%";
                    ?>  
                </td>
            </tr>
            <tr>
                <td>July</td>
                <td>
                    <?php 
                        $MNAME = 'JUL';

                        $JUL1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $JUL1;
                    ?>
                </td>
                <td>
                    <?php
                        $JUL2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $JUL2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($JUL1-$JUL2);
                        $B = ($JUL1+$JUL2);
                        $IMP7 = ($A / $B) * 100;
                        echo number_format($IMP7,2)."%";
                    ?>  
                </td>
            </tr>
            <tr>
                <td>August</td>
                <td>
                    <?php 
                        $MNAME = 'AUG';

                        $AUG1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $AUG1;
                    ?>
                </td>
                <td>
                    <?php
                        $AUG2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $AUG2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($AUG1-$AUG2);
                        $B = ($AUG1+$AUG2);
                        $IMP8 = ($A / $B) * 100;
                        echo number_format($IMP8,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>September</td>
                <td>
                    <?php 
                        $MNAME = 'SEP';

                        $SEP1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $SEP1;
                    ?>
                </td>
                <td>
                    <?php
                        $SEP2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $SEP2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($SEP1-$SEP2);
                        $B = ($SEP1+$SEP2);
                        $IMP9 = ($A / $B) * 100;
                        echo number_format($IMP9,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>October</td>
                <td>
                    <?php 
                        $MNAME = 'OTB';

                        $OTB1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $OTB1;
                    ?>
                </td>
                <td>
                    <?php
                        $OTB2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $OTB2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($OTB1-$OTB2);
                        $B = ($OTB1+$OTB2);
                        $IMP10 = ($A / $B) * 100;
                        echo number_format($IMP10,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>November</td>
                <td>
                    <?php 
                        $MNAME = 'NOV';

                        $NOV1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $NOV1;
                    ?>
                </td>
                <td>
                    <?php
                        $NOV2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $NOV2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($NOV1-$NOV2);
                        $B = ($NOV1+$NOV2);
                        $IMP11 = ($A / $B) * 100;
                        echo number_format($IMP11,2)."%"; 
                    ?>  
                </td>
            </tr>
            <tr>
                <td>December</td>
                <td>
                    <?php 
                        $MNAME = 'DEM';

                        $DEM1 = $data1[0]['L'.$MNAME] + $data1[0]['C'.$MNAME] + $data1[0]['LG'.$MNAME] + $data1[0]['I'.$MNAME] + $data1[0]['B'.$MNAME] + $data1[0]['BB'.$MNAME] + $data1[0]['V'.$MNAME];

                        echo $DEM1;
                    ?>
                </td>
                <td>
                    <?php
                        $DEM2 = $data2[0]['L'.$MNAME] + $data2[0]['C'.$MNAME] + $data2[0]['LG'.$MNAME] + $data2[0]['I'.$MNAME] + $data2[0]['B'.$MNAME] + $data2[0]['BB'.$MNAME] + $data2[0]['V'.$MNAME];

                        echo $DEM2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($DEM1-$DEM2);
                        $B = ($DEM1+$DEM2);
                        $IMP12 = ($A / $B) * 100;
                        echo number_format($IMP12,2)."%"; 
                    ?>  
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td>Total</td>
                <td>
                    <?php
                        $TOTAL_Y1 = $JAN1 + $FAB1 + $MAR1 + $APR1 + $MAY1 + $JUN1 + $JUL1 + $AUG1 + $SEP1 + $OTB1 + $NOV1 + $DEM1;
                        echo $TOTAL_Y1;
                    ?>
                </td>
                <td>
                    <?php
                        $TOTAL_Y2 = $JAN2 + $FAB2 + $MAR2 + $APR2 + $MAY2 + $JUN2 + $JUL2 + $AUG2 + $SEP2 + $OTB2 + $NOV2 + $DEM2;
                        echo $TOTAL_Y2;
                    ?>
                </td>
                <td>
                    <?php
                        $A = ($TOTAL_Y1 - $TOTAL_Y2);
                        $B = ($TOTAL_Y1 + $TOTAL_Y2);
                        $TOTAL_IMP_PERCENTAGE = ($A / $B) * 100;
                        echo number_format($TOTAL_IMP_PERCENTAGE,2)."%"; 
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>