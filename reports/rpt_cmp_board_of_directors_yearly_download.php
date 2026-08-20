<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $year       = isset($_GET['getYear'])?$_GET['getYear']:'';
    $year       = (int) $year;
    $year_last  = $year - 1;

    $forum      = isset($_GET['getForum'])?$_GET['getForum']:'';
    $status     = "1,2,5,6";

    $objComplaintReport = new ComplaintReport();
    $forum_names        = $objComplaintReport->getForumFromDBById($forum);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_board_of_directors_yearly_download.xls"');
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
                    <td></td>
                    <td align="right" valign="top" colspan="4">
                        <h4>Board Of Directors Yearly Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td></td>
                    <td align="right" colspan="4">
                        <b>Pages:</b> 1
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b class="spanYear">Year: </b>
                        <span id="spanYear"> <?php echo $year; ?> </span>
                    </td>
                    <td></td>
                    <td align="right" colspan="4">
                        <b class="spanForum">Forum: </b>
                        <span id="spanForum"> <?php echo $forum_names[0]['fullname']; ?> </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-bordered table-responsive">
        <?php 
            $sum_cf = 0;
            $sum_open = 0;
            $sum_closed = 0;
            $sum_pendding = 0;
        ?>
        
        <thead>
            <tr class="tblHead">
                <th rowspan="2" class="text-center line-hight">Forum</th>
                <th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>
                <th colspan="4" class="text-center line-hight">Grand Total</th>
            </tr>
            <tr class="tblHead">
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
                            
                            <?php
                                $cmp_cf = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year_last,$status);
                                $cmp_cf = $cmp_cf[0]['CMP_COUNTS'];
                                $sum_cf = $sum_cf + $cmp_cf;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_cf; ?></td>

                            <?php
                                $cmp_open = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,$status);
                                $cmp_open = $cmp_open[0]['CMP_COUNTS'];
                                $sum_open = $sum_open + $cmp_open;
                            ?>
                            <td class="text-center"><?php echo $cmp_open; ?></td>

                            <?php
                                $cmp_closed = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,'3');
                                $cmp_closed = $cmp_closed[0]['CMP_COUNTS'];
                                $sum_closed = $sum_closed + $cmp_closed;
                            ?>
                            <td class="text-center"><?php echo $cmp_closed; ?></td>
                            
                            <?php
                                $cmp_pendding = $cmp_cf + $cmp_open;
                                $sum_pendding = $sum_pendding + $cmp_pendding;
                            ?>
                            <td class="bgColor text-center"><?php echo $cmp_pendding; ?></td>
                        <?php } else { ?>
                            <td class="text-center line-hight"><?php echo "NA"; ?></td>
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
                <td class="text-center line-hight"><b><?php echo $sum_cf; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_open; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_closed; ?></b></td>
                <td class="text-center line-hight"><b><?php echo $sum_pendding; ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>