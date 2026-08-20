<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $year       = isset($_GET['getYear'])?$_GET['getYear']:'';
    $year       = (int) $year;
    $year_last  = $year - 1;        //get 1 year back
    $status     = "1,2,6";

    $objComplaintReport = new ComplaintReport();
    $deprtments = $objComplaintReport->getDepartmentById('');

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_annual_departmental_complaint_download.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
        } 
        #tblMyTables tr td{
            border:1px solid #CCC !important;
            text-align: center !important;
            vertical-align: middle !important;
        }
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: center !important;
        }
        .tabHeadLine{
            background: #CFCFCF !important;
            color: #000 !important;
        }
        .logoArea img{
            margin: 0px 0px 0px 100px!important;
        }

        #tblMyTables .line-hight{
            vertical-align: middle !important;
        }

        .bgColor{
            background-color: #006BB1 !important;
            color: #FFF !important;
        }

        .boldText{
            font-size: 18px !important;
            font-weight: 1200 !important;
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="5"></td>
                    <td align="right" valign="top">
                        <h4>Annual Departmental Complaint Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="5"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b class="spanYear">Year:</b> 
                        <span id="spanYear"> <?php print_r($year); ?> </span>
                    </td>
                    <td  colspan="5">
                    </td>
                    <td align="right"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th rowspan="2" class="text-center line-hight">Department</th>
                <th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>
                <th colspan="4" class="text-center"><?php echo $year; ?></th>
                <th rowspan="2" class="text-center line-hight">Pending</th>
            </tr>
            <tr class="tblHead">
                <th class="text-center line-hight">Opening <?php echo $year_last; ?></th>
                <th class="text-center line-hight">New</th>
                <th class="text-center line-hight">Total</th>
                <th class="text-center line-hight">Closed</th>
            </tr>
        </thead>
        
        <tbody class="table table-bordered">
            <?php $cmpTotalLogged = 0; ?>
            <?php $cmpTotalPercentage = 0; ?>

            <?php $opening_sum = 0; ?>
            <?php $q1_new_sum = 0; ?>
            <?php $q1_tot_sum = 0; ?>
            <?php $q1_cls_sum = 0; ?>

            <?php $lastyear_open_sum = 0; ?>

            <?php $pending_sum = 0; ?>

            <?php foreach($deprtments as $deprtment): ?>
                <?php
                    $deprtment_id = $deprtment['id'];
                    $data2 =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                    $rowspan = count($data2);
                    $rowspan = $rowspan + 1;
                ?>
                <tr>
                    <td rowspan="<?php echo $rowspan; ?>" class="text-center line-hight"><?php echo $deprtment['primary_name']; ?></td>

                    <?php for($i=0; $i<count($data2); $i++) { ?>
                        <tr>
                            <?php if($data2 != 0) { ?>
                                <td class="text-center line-hight"><?php echo $data2[$i]['fullname']; ?></td>

                                <td class="text-center line-hight bgColor">
                                    <?php 
                                        $cmp_q1_open = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year_last,$status);

                                        //print_r($cmp_q1_open); die;

                                        $all_q1_open = 
                                            $cmp_q1_open[0]['CMPL_OPEN'] + 
                                            $cmp_q1_open[0]['CMPC_OPEN'] + 
                                            $cmp_q1_open[0]['CMPLG_OPEN'] + 
                                            $cmp_q1_open[0]['CMPI_OPEN'] + 
                                            $cmp_q1_open[0]['CMPB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPBB_OPEN'] + 
                                            $cmp_q1_open[0]['CMPV_OPEN'];

                                        // For Field Col-1
                                        echo $all_q1_open;

                                        // For Total Col-1
                                        $opening_sum = $opening_sum + $all_q1_open;

                                        $lastyear_open_sum = $lastyear_open_sum + $all_q1_open;
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        $cmp_q1_new = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        //print_r($cmp_q1_new); die;

                                        $all_q1_new = 
                                            $cmp_q1_new[0]['CMPL_NEW'] + 
                                            $cmp_q1_new[0]['CMPC_NEW'] + 
                                            $cmp_q1_new[0]['CMPLG_NEW'] + 
                                            $cmp_q1_new[0]['CMPI_NEW'] + 
                                            $cmp_q1_new[0]['CMPB_NEW'] + 
                                            $cmp_q1_new[0]['CMPBB_NEW'] + 
                                            $cmp_q1_new[0]['CMPV_NEW'];

                                        // For Field Col-2
                                        echo $all_q1_new;

                                        // For Total Col-2
                                        $q1_new_sum = $q1_new_sum + $all_q1_new;
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        $cmp_q1_total = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        //print_r($complaintslogged); die;

                                        $all_q1_total = 
                                            $cmp_q1_total[0]['CMPL_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPC_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPLG_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPI_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPBB_TOTAL'] + 
                                            $cmp_q1_total[0]['CMPV_TOTAL'];

                                        // For Field Col-3
                                        $all_q1 = $all_q1_total + $all_q1_open;

                                        echo $all_q1;

                                        // For Total Col-2
                                        $q1_tot_sum = $q1_tot_sum + $all_q1;
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        $cmp_q1_closed = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        //print_r($cmp_q1_closed); die;

                                        $all_q1_closed = 
                                            $cmp_q1_closed[0]['CMPL_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPC_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPLG_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPI_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPBB_CLOSED'] + 
                                            $cmp_q1_closed[0]['CMPV_CLOSED'];

                                        // For Field Col-4
                                        echo $all_q1_closed;

                                        // For Total Col-4
                                        $q1_cls_sum = $q1_cls_sum + $all_q1_closed;
                                    ?>
                                </td>

                                <td class="text-center line-hight bgColor">
                                    <?php
                                        $cmp_pending = $objComplaintReport->countsAnnualDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],$year,'');

                                        //print_r($cmp_pending); die;

                                        $all_pending = 
                                            $cmp_pending[0]['CMPL_PENDING'] + 
                                            $cmp_pending[0]['CMPC_PENDING'] + 
                                            $cmp_pending[0]['CMPLG_PENDING'] + 
                                            $cmp_pending[0]['CMPI_PENDING'] + 
                                            $cmp_pending[0]['CMPB_PENDING'] + 
                                            $cmp_pending[0]['CMPBB_PENDING'] + 
                                            $cmp_pending[0]['CMPV_PENDING'];

                                        echo $all_pending = $all_pending ;

                                        $pending_sum = $pending_sum + $all_pending;
                                    ?>
                                </td>
                            <?php } else { ?>
                                <td class="text-center line-hight"><?php echo "NA"; ?></td>

                                <td class="text-center line-hight bgColor"><?php echo "0"; ?></td>
                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                <td class="text-center line-hight"><?php echo "0"; ?></td>

                                <td class="text-center line-hight bgColor"><?php echo "0"; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="2" class="text-center line-hight boldText">Grand Total</td>

                <td class="text-center line-hight boldText"><?php echo $opening_sum; ?></td>
                <td class="text-center line-hight"><?php echo $q1_new_sum; ?></td>
                <td class="text-center line-hight"><?php echo $q1_tot_sum; ?></td>
                <td class="text-center line-hight"><?php echo $q1_cls_sum; ?></td>

                <td class="text-center line-hight boldText"><?php echo $pending_sum; ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>