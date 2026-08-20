<?php
    include('../includes/config.php');
    include('../classes/taskcat_rpt.php');

    $objTaskcatReport = new TaskcatReport();
    $isms             = $objTaskcatReport->getIsmdetails('','','','','');

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_task_ism_wise_downlod_all.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            height: 40px !important;
            font-size: 13px !important;
        }
        #tblMyTables tr td{
            /* text-align: center !important; */
            border:1px solid #CCC !important;
        }
        .tblHead, .tblFoot{
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
        .bgColor{
            background: #006BB1 !important;
            color: #FFF !important;
        }
        .TxtCenter{
            text-align: center !important;
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="12"></td>
                    <td align="right" valign="top">
                        <h4>ISM Wise Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="12"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <?php 
        $SUM_AvgMinutesPerActivity = 0;
        $SUM_BF = 0;
        $SUM_Incoming = 0;
        $SUM_Total = 0;
        $SUM_Today_Completed = 0;
        $SUM_CF = 0;
        $SUM_Man_Hours = 0;
        $SUM_Day1 = 0;
        $SUM_Day2 = 0;
        $SUM_Day3 = 0;
        $SUM_Day4 = 0;
    ?>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th class="text-center line-hight">INTERNAL <br>SERVICE MEASURE</th>
                <th class="text-center line-hight">ISM's</th>
                <th class="text-center line-hight">TAT <br> SLA Days</th>
                <th class="text-center line-hight">Avg. Minutes<br> Per Activity</th>
                <th class="text-center line-hight">B/F</th>
                <th class="text-center line-hight">Incoming</th>
                <th class="text-center line-hight">Total</th>
                <th class="text-center line-hight">Today<br>Completed</th>
                <th class="text-center line-hight">C/F</th>
                <th class="text-center line-hight">Man-Hours</th>
                <th class="text-center line-hight">1<br> Day</th>
                <th class="text-center line-hight">2<br> Days</th>
                <th class="text-center line-hight">3<br> Days</th>
                <th class="text-center line-hight">4<br> Days or Above</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php foreach($isms as $ism): ?>
                <?php 
                    $ISM_id = $ism['id']; 
                    $task = $objTaskcatReport->getTaskCounts($ISM_id);
                    $TaskDiff = $objTaskcatReport->getTaskDiff($ISM_id);
                ?>
                <tr>
                    <td><?php echo $ism['subcat_name']; ?></td>
                    <td class="TxtCenter"><?php echo $ism['fullname']; ?></td>
                    <td class="TxtCenter"><?php echo $ism['tat'] . " Days"; ?></td>
                    <td class="TxtCenter">
                        <?php 
                            echo $ism['minutes_activity'];

                            $SUM_AvgMinutesPerActivity = $SUM_AvgMinutesPerActivity + $ism['minutes_activity'];
                        ?>
                    </td>
                    <td class="TxtCenter bgColor">
                        <?php
                            echo $task[0]['BF'];

                            $SUM_BF = $SUM_BF + $task[0]['BF'];
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php 
                            echo $task[0]['Incoming'];

                            $SUM_Incoming = $SUM_Incoming + $task[0]['Incoming'];
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php 
                            echo $task[0]['Total'];

                            $SUM_Total = $SUM_Total + $task[0]['Total'];
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php 
                            echo $task[0]['Done'];

                            $SUM_Today_Completed = $SUM_Today_Completed + $task[0]['Done'];
                        ?>
                    </td>
                    <td class="TxtCenter bgColor">
                        <?php 
                            $Pending_CF = $task[0]['Total'] - $task[0]['Done'];
                            echo $Pending_CF;

                            $SUM_CF = $SUM_CF + $Pending_CF;
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php
                            $minutes_activity = $ism['minutes_activity'];
                            $man_hours =($minutes_activity*$task[0]['Done'])/60;
                            $man_hours = number_format($man_hours);
                            echo $man_hours;

                            $SUM_Man_Hours = $SUM_Man_Hours + $man_hours;
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php
                            $day1 = ($TaskDiff[0]['DiffInDays'] == 1 ? $TaskDiff[0]['COUNTS'] : "-");
                            echo $day1;

                            $SUM_Day1 = $SUM_Day1 + $day1;
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php
                            $day2 = ($TaskDiff[0]['DiffInDays'] == 2 ? $TaskDiff[0]['COUNTS'] : "-");
                            echo $day2;

                            $SUM_Day2 = $SUM_Day2 + $day2;
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php
                            $day3 = ($TaskDiff[0]['DiffInDays'] == 3 ? $TaskDiff[0]['COUNTS'] : "-");
                            echo $day3;

                            $SUM_Day3 = $SUM_Day3 + $day3;
                        ?>
                    </td>
                    <td class="TxtCenter">
                        <?php
                            $day4 = ($TaskDiff[0]['DiffInDays'] == 4 ? $TaskDiff[0]['COUNTS'] : "-");
                            echo $day4;

                            $SUM_Day4 = $SUM_Day4 + $day4;
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="3"><b>Grand Total</b></td>
                <td class="TxtCenter"><?php echo $SUM_AvgMinutesPerActivity; ?></td>
                <td class="TxtCenter"><?php echo $SUM_BF; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Incoming; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Total; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Today_Completed; ?></td>
                <td class="TxtCenter"><?php echo $SUM_CF; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Man_Hours; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Day1; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Day2; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Day3; ?></td>
                <td class="TxtCenter"><?php echo $SUM_Day4; ?></td>
            </tr>

            <tr class="tblFoot">
                <td colspan="3"><b>Manpower in working hours includes, given extra time</b></td>
                <td colspan="11" class="TxtCenter">
                    <b><?php echo ($SUM_Man_Hours/6); ?></b>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
