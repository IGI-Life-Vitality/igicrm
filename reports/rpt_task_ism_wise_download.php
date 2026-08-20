<?php
    include('../includes/config.php');
    include('../classes/taskcat_rpt.php');

    $log_datetime     = isset($_GET['FromDate'])?$_GET['FromDate']:'';

    $objTaskcatReport = new TaskcatReport();
    $ismDetails       = $objTaskcatReport->getIsmWiseResultDetails($log_datetime);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_task_ism_wise_downlod.xls"');
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
            margin: 0px 0px 0px 100px !important;
        }
        .border{
            border: 1px solid #CCC !important;
        }
        .bgColor{
            background: #006BB1 !important; 
            color: #FFF !important; 
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top" colspan="10">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td align="right" valign="top" colspan="4">
                        <h4>ISM Wise Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left" colspan="10">
                        <b class="FromDate">Desired Date:</b>
                        <span id="spanFromDate"> <?php echo $log_datetime; ?> </span>
                    </td>
                    <td align="right" colspan="4">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                </tr>

                <tr>
                    <td align="left" colspan="10"></td>
                    <td align="right" colspan="4">
                        <b>Pages:</b> 1
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <?php 
        /*$SUM_AvgMinutesPerActivity = 0;*/
        $SUM_BF = 0;
        $SUM_Incoming = 0;
        $SUM_Total = 0;
        $SUM_Today_Completed = 0;
        $SUM_CF = 0;
        $SUM_Main_Hours = 0;
        $SUM_Day1 = 0;
        $SUM_Day2 = 0;
        $SUM_Day3 = 0;
        $SUM_Day4 = 0;
    ?>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th align="center">INTERNAL <br>SERVICE MEASURE</th>
                <th align="center">ISM's</th>
                <th align="center">TAT <br> SLA Days</th>
                <th align="center">Avg. Minutes<br> Per Activity</th>
                <th align="center">B/F</th>
                <th align="center">Incoming</th>
                <th align="center">Total</th>
                <th align="center">Today<br>Completed</th>
                <th align="center">C/F</th>
                <th align="center">Main-Hours</th>
                <th align="center">1<br> Day</th>
                <th align="center">2<br> Days</th>
                <th align="center">3<br> Days</th>
                <th align="center">4<br> Days or Above</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach($ismDetails as $ismDetail): ?>
                <?php 
                    $ism_sub_cat_id   = $ismDetail['ism_sub_cat_id'];
                    $ism_id           = $ismDetail['ism_id'];
                    $last_date        = DATE('Y-m-d', strtotime("-1 day"));
                    $present_date     = DATE('Y-m-d');
                    $incomming_status = "1,2,4,5,6";
                    $completed_status = "3";

                    $getSubCatName    = $objTaskcatReport->getSubCatName($ism_sub_cat_id,$ism_id);
                ?>
            <tr>
                <td><?php echo $getSubCatName[0]['subcat_name']; ?></td>
                <td><?php echo $getSubCatName[0]['fullname']; ?></td>
                <td align="center"><?php echo $ismDetail['tat'] . " Days"; ?></td>
                <td align="center">
                    <?php 
                        echo $ismDetail['avg_mint_activity'];
                        $SUM_AvgMinutesPerActivity += $ismDetail['avg_mint_activity'];
                    ?>
                </td>

                <!-- For B/F as Yesterday's C/F truns Today's B/F -->
                <?php
                    $getCFDetails = $objTaskcatReport->getCFDetails($ism_sub_cat_id,$ism_id,$last_date);
                ?>
                <td align="center" class="bgColor">
                    <?php
                        echo $ismDetail['bf'];
                        $SUM_BF += $ismDetail['bf'];
                    ?>
                </td>
                
                <!-- For Today Incomming -->
                <td align="center">
                    <?php
                        echo $ismDetail['incomming'];
                        $SUM_Incoming += $ismDetail['incomming'];
                    ?>
                </td>
                
                <!-- For Today Total -->
                <td align="center">
                    <?php 
                        echo $ismDetail['total'];
                        $SUM_Total += $ismDetail['total'];
                    ?>
                </td>
                
                <!-- For Today Completed -->
                <td align="center">
                    <?php
                        echo $ismDetail['today_completed'];
                        $SUM_Today_Completed += $ismDetail['today_completed'];
                    ?>
                </td>
                
                <!-- For Today C/F -->
                <td align="center" class="bgColor">
                    <?php 
                        echo $ismDetail['cf'];
                        $SUM_CF += $ismDetail['cf'];
                    ?>
                </td>
                
                <!-- For Main Hours -->
                <td align="center">
                    <?php
                        echo $ismDetail['main_hours'];
                        $SUM_Main_Hours += $ismDetail['main_hours'];
                    ?>
                </td>

                <!-- For Ageings -->
                <td align="center">
                    <?php
                        echo $ismDetail['day_1'];
                        $SUM_Day1 += $ismDetail['day_1'];
                    ?>
                </td>
                <td align="center">
                    <?php
                        echo $ismDetail['day_2'];
                        $SUM_Day2 += $ismDetail['day_2'];
                    ?>
                </td>
                <td align="center">
                    <?php
                        echo $ismDetail['day_3'];
                        $SUM_Day3 += $ismDetail['day_3'];
                    ?>
                </td>
                <td align="center">
                    <?php
                        echo $ismDetail['day_4_above'];
                        $SUM_Day4 += $ismDetail['day_4_above'];
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="4"><b>Grand Total</b></td>
                <td  align="center"><?php echo $SUM_BF; ?></td>
                <td  align="center"><?php echo $SUM_Incoming; ?></td>
                <td  align="center"><?php echo $SUM_Total; ?></td>
                <td  align="center"><?php echo $SUM_Today_Completed; ?></td>
                <td  align="center"><?php echo $SUM_CF; ?></td>
                <td  align="center"><?php echo $SUM_Main_Hours; ?></td>
                <td  align="center"><?php echo $SUM_Day1; ?></td>
                <td  align="center"><?php echo $SUM_Day2; ?></td>
                <td  align="center"><?php echo $SUM_Day3; ?></td>
                <td  align="center"><?php echo $SUM_Day4; ?></td>
            </tr>
            <tr class="tblFoot">
                <td colspan="4"><b>Manpower in working hours includes, given extra time </b></td>
                <td colspan="10" align="center">
                    <b><?php echo number_format($SUM_Main_Hours/7,2); ?></b>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>