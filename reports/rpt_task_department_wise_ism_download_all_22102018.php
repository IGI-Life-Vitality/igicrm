<?php
    include('../includes/config.php');
    include('../classes/taskcat_rpt.php');
    include('../classes/complaint_rpt.php');

    $objTaskcatReport   = new TaskcatReport();
    $objComplaintReport = new ComplaintReport();

    $deprtments         = $objTaskcatReport->getDepartmentById(''); 

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_task_department_wise_ism_downlod_all.xls"');
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
        .border{
            border: 1px solid #CCC !important;
        }

        .na{
            border:1px solid #CCC !important; 
            text-align: center !important; 
            margin: 0px !important;
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
                    <td align="right" valign="top" colspan="2">
                        <h4>Department Wise ISM's Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td></td>
                    <td align="right" colspan="2">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="DepartmentName">Department:</b> 
                        <span id="spanDepartmentName"> All </span>
                    </td>
                    <td></td>
                    <td align="right" colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive table-bordered">
        <thead>
            <tr class="tblHead">
                <th width="400px;" align="center">Department <br>Name</th>
                <th width="100px;" align="center">Score <br>Current Month</th>
                <th width="100px;" align="center">Grade <br>Current Month</th>
                <th width="250px;" align="center">ISM <br>Codes</th>
                <th width="150px;" align="center">ISM's <br>Description</th>
                <th width="100px;" align="center">TAT</th>
                <th width="300px;" align="center">Ownership</th>
                <th width="100px;" align="center">Weightage</th>
                <th width="100px;" align="center">Rating</th>
                <th width="100px;" align="center">Grade</th>
                <th width="100px;" align="center">Count of Closed <br>Service Tickets</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php foreach($deprtments as $deprtment): ?>
                <?php 
                    $deprtment_id = $deprtment['id'];

                    $data2 =  $objTaskcatReport->getIsmByDepartmentId($deprtment_id);
                    $colspan1 = count($data2);
                    $colspan1 = $colspan1 + 1;

                    //print_r($data2); die;
                ?>
                <tr>
                    <td valign="top" rowspan="<?php echo $colspan1; ?>"><?php echo $deprtment['primary_name']; ?></td>
                    <?php
                        for($x=0; $x<count($data2); $x++) 
                        {
                            // For Grade Current Month - Start
                            $ism_id1 = $data2[$x]['id'];
                            $task_rating1 = $objTaskcatReport->getTaskRating($ism_id1,'','','','',$deprtment_id);
                            $task_rating_percetage1 = ($task_rating1[0]['task_within_tat'] / $task_rating1[0]['total_service_request']) * 100;

                            $getScoreCurrentMonth = $objTaskcatReport->getScoreCurrentMonth($deprtment_id);
                            $count_ism_where_task_closed = count($getScoreCurrentMonth);

                            $GradeCurrentMonth += $task_rating_percetage1;
                            // For Grade Current Month - End
                        }
                    ?>
                    <td valign="top" rowspan="<?php echo $colspan1; ?>">
                        <?php
                            $total_ism = count($data2);
                            $GradeCurrentMonth1 = number_format($GradeCurrentMonth/$count_ism_where_task_closed);

                            if($total_ism > 1)
                            {
                                print_r($GradeCurrentMonth1 . "%");
                            }
                            else
                            {
                                print_r("0%");
                            }
                        ?>
                    </td>

                    <td valign="top" rowspan="<?php echo $colspan1; ?>">
                        <?php
                            if($GradeCurrentMonth1 >= "95")
                            {
                                echo "Outstanding";
                            }
                            else if($GradeCurrentMonth1 >= "80" AND $GradeCurrentMonth1 <= "94")
                            {
                                echo "Very Good";
                            }
                            else if($GradeCurrentMonth1 >= "71" AND $GradeCurrentMonth1 <= "79")
                            {
                                echo "Average";
                            }
                            else if($GradeCurrentMonth1 <= "70")
                            {
                                echo "Below Average";
                            }
                        ?>
                    </td>
                </tr>
                
                <?php for($i=0; $i<count($data2); $i++) { ?>
                    <?php if($data2 != 0) { ?>
                        <tr>
                            <td><?php echo $data2[$i]['fullname']; ?></td>
                            <td><?php echo $data2[$i]['subcat_name'];?></td>
                            <td><?php echo $data2[$i]['tat'] . " Days"; ?></td>
                            <td><?php echo $data2[$i]['ownership']; ?></td>
                            <td><?php echo $data2[$i]['weightage']; ?></td>
                            <td>
                                <?php
                                    // Rating
                                    $ism_id = $data2[$i]['id'];
                                    $task_rating = $objTaskcatReport->getTaskRating($ism_id,'','','','',$deprtment_id);
                                    $task_rating_percetage = ($task_rating[0]['task_within_tat'] / $task_rating[0]['total_service_request']) * 100;
                                    $rating = number_format($task_rating_percetage,2);
                                    print_r($rating . "%");
                                ?>
                            </td>
                            <td>
                                <?php 
                                    if($task_rating_percetage >= "95")
                                    {
                                        echo "Outstanding";
                                    }
                                    else if($task_rating_percetage >= "80" AND $task_rating_percetage <= "94")
                                    {
                                        echo "Very Good";
                                    }
                                    else if($task_rating_percetage >= "71" AND $task_rating_percetage <= "79")
                                    {
                                        echo "Average";
                                    }
                                    else if($task_rating_percetage <= "70")
                                    {
                                        echo "Below Average";
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    $total_closed_service = $task_rating[0]['total_closed_service'];
                                    print_r($total_closed_service);
                                ?> 
                            </td>
                            <?php } else { ?>
                                <td class="na" colspan="8">NA</td>
                            <?php } ?>
                        </tr>
                <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>