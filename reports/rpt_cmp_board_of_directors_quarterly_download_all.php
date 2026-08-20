<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $year_last  = DATE("Y", strtotime("-1 year"));    //Last Year
    $year       = DATE("Y");                          //Current Year
    $status     = "1,2,5,6";

    $objComplaintReport = new ComplaintReport();
    $forum_names        = $objComplaintReport->getForumFromDBById('');

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_board_of_directors_quarterly_download_all.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            /* text-align: right !important; */
            height: 44px !important;
        }
        #tblMyTables tr td{
            border:1px solid #CCC !important;
        }
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            /* text-align: right !important; */
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
                    <td colspan="8"></td>
                    <td align="right" valign="top" colspan="6">
                        <h4>Board Of Directors Quarterly Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="8"></td>
                    <td align="right" colspan="6">
                        <b>Pages:</b> 1
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b class="spanYear">Year: </b>
                        <span id="spanYear"> All </span>
                    </td>
                    <td colspan="8"></td>
                    <td align="right" colspan="6">
                        <b class="spanForum">Forum: </b> 
                        <span id="spanForum"> All </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-bordered table-responsive">
        <?php 
            $sum_open_last_year = 0;

            $sum_open_q1 = 0;
            $sum_open_q2 = 0;
            $sum_open_q3 = 0;
            $sum_open_q4 = 0;

            $sum_closed_q1 = 0;
            $sum_closed_q2 = 0;
            $sum_closed_q3 = 0;
            $sum_closed_q4 = 0;

            $sum_cf_for_q2 = 0;
            $sum_cf_for_q3 = 0;
            $sum_cf_for_q4 = 0;

            $sum_pendding_q4 = 0;
        ?>
        
        <thead>
            <tr class="tblHead">
                <th rowspan="2" class="text-center line-hight">Forum</th>
                <th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>
                <th colspan="3" class="text-center">Quarter-1 of <?php echo $year; ?></th>
                <th colspan="3" class="text-center">Quarter-2 of <?php echo $year; ?></th>
                <th colspan="3" class="text-center">Quarter-3 of <?php echo $year; ?></th>
                <th colspan="4" class="text-center">Quarter-4 of <?php echo $year; ?></th>
            </tr>
            <tr class="tblHead">
                <th class="text-center line-hight">Opening <?php echo $year_last; ?></th>
                <th class="text-center line-hight">Received</th>
                <th class="text-center line-hight">Closed</th>

                <th class="text-center line-hight">CF</th>
                <th class="text-center line-hight">Received</th>
                <th class="text-center line-hight">Closed</th>

                <th class="text-center line-hight">CF</th>
                <th class="text-center line-hight">Received</th>
                <th class="text-center line-hight">Closed</th>

                <th class="text-center line-hight">CF</th>
                <th class="text-center line-hight">Received</th>
                <th class="text-center line-hight">Closed</th>
                <th class="text-center line-hight">Pending</th>
            </tr>
        </thead>
        
        <tbody class="table table-bordered">
            <?php foreach($forum_names as $forum_name): ?>
            <?php
                $forum_name_id = $forum_name['id'];
                $data2 =  $objComplaintReport->getComplaintTypeByForumId($forum_name_id);
                $rowspan = count($data2);
                $rowspan = $rowspan + 1;
            ?>
            <tr>
                <td rowspan="<?php echo $rowspan; ?>"><?php echo $forum_name['fullname']; ?></td>
                <?php for($i=0; $i<count($data2); $i++) { ?>
                    <tr>
                        <?php if($data2 != 0) {  ?>
                            <td><?php echo $data2[$i]['dept_type']; ?></td>

                            <?php $complaint_type_id = $data2[$i]['complaint_type_id']; ?>
                            
                            <!-- Quarter-1 Start -->
                            <?php
                                $cmp_open_last_year = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year_last,$status);
                                $cmp_open_last_year = $cmp_open_last_year[0]['CMP_COUNTS'];
                                $sum_open_last_year = $sum_open_last_year + $cmp_open_last_year;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_open_last_year; ?></td>

                            <?php
                                $cmp_open_q1 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'01',$year,$status);
                                $cmp_open_q1 = $cmp_open_q1[0]['CMP_COUNTS'];
                                $sum_open_q1 = $sum_open_q1 + $cmp_open_q1;
                            ?>
                            <td class="text-center"><?php echo $cmp_open_q1; ?>
                            </td>

                            <?php
                                $cmp_closed_q1 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'01',$year,'3');
                                $cmp_closed_q1 = $cmp_closed_q1[0]['CMP_COUNTS'];
                                $sum_closed_q1 = $sum_closed_q1 + $cmp_closed_q1;
                            ?>
                            <td class="text-center"><?php echo $cmp_closed_q1; ?></td>
                            <!-- Quarter-1 End -->
                            

                            <!-- Quarter-2 -->
                            <?php
                                $cmp_cf_for_q2 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2;

                                $sum_cf_for_q2 = $sum_cf_for_q2 + $cmp_cf_for_q2;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_cf_for_q2; ?></td>

                            <?php
                                $cmp_open_q2 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'02',$year,$status);
                                $cmp_open_q2 = $cmp_open_q2[0]['CMP_COUNTS'];
                                $sum_open_q2 = $sum_open_q2 + $cmp_open_q2;
                            ?>
                            <td class="text-center"><?php echo $cmp_open_q2; ?></td>

                            <?php
                                $cmp_closed_q2 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'02',$year,'03');
                                $cmp_closed_q2 = $cmp_closed_q2[0]['CMP_COUNTS'];
                                $sum_closed_q2 = $sum_closed_q2 + $cmp_closed_q2;
                            ?>
                            <td class="text-center"><?php echo $cmp_closed_q2; ?></td>
                            <!-- Quarter-2 End -->
                            

                            <!-- Quarter-3 Start -->
                            <?php
                                $cmp_cf_for_q3 = $cmp_cf_for_q2 + $cmp_open_q2;
                                $sum_cf_for_q3 = $sum_cf_for_q3 + $cmp_cf_for_q3;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_cf_for_q3; ?></td>

                            <?php
                                $cmp_open_q3 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'03',$year,$status);
                                $cmp_open_q3 = $cmp_open_q3[0]['CMP_COUNTS'];
                                $sum_open_q3 = $sum_open_q3 + $cmp_open_q3;
                            ?>
                            <td class="text-center"><?php echo $cmp_open_q3; ?>
                            </td>

                            <?php
                                $cmp_closed_q3 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'03',$year,'03');
                                $cmp_closed_q3 = $cmp_closed_q3[0]['CMP_COUNTS'];
                                $sum_closed_q3 = $sum_closed_q3 + $cmp_closed_q3;
                            ?>
                            <td class="text-center"><?php echo $cmp_closed_q3; ?></td>
                            <!-- Quarter-3 End -->
                            

                            <!-- Quarter-4 Start -->
                            <?php
                                $cmp_cf_for_q4 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2 + $cmp_open_q3;
                                $sum_cf_for_q4 = $sum_cf_for_q4 + $cmp_cf_for_q4;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_cf_for_q4; ?></td>

                            <?php
                                $cmp_open_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,$status);
                                $cmp_open_q4 = $cmp_open_q4[0]['CMP_COUNTS'];
                                $sum_open_q4 = $sum_open_q4 + $cmp_open_q4;
                            ?>
                            <td class="text-center"><?php echo $cmp_open_q4; ?></td>

                            <?php
                                $cmp_closed_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,'03');
                                $cmp_closed_q4 = $cmp_closed_q4[0]['CMP_COUNTS'];
                                $sum_closed_q4 = $sum_closed_q4 + $cmp_closed_q4;
                            ?>
                            <td class="text-center"><?php echo $cmp_closed_q4; ?></td>

                            <?php
                                $cmp_open_q4 = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'04',$year,$status);
                                $cmp_open_q4 = $cmp_open_q4[0]['CMP_COUNTS'];

                                $cmp_pendding_q4 = $cmp_open_last_year + $cmp_open_q1 + $cmp_open_q2 + $cmp_open_q3 + $cmp_open_q4;
                                $sum_pendding_q4 = $sum_pendding_q4 + $cmp_pendding_q4;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_pendding_q4; ?></td>
                            <!-- Quarter-4 End -->
                        <?php } else { ?>
                            <td class="text-center line-hight"><?php echo "NA"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td class="text-center line-hight" colspan="2"><b>Total</b></td>

                <td class="text-center line-hight"><b><?php echo $sum_open_last_year; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_open_q1; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_closed_q1; ?></b></td>

                <td class="text-center line-hight"><b><?php echo $sum_cf_for_q2; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_open_q2; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_closed_q2; ?></b></td>

                <td class="text-center line-hight"><b><?php echo $sum_cf_for_q3; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_open_q3; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_closed_q3; ?></b></td>

                <td class="text-center line-hight"><b><?php echo $sum_cf_for_q4; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_open_q4; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_closed_q4; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_pendding_q4; ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>