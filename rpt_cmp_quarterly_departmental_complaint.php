<?php
    $page_title         = "Quarterly Departmental Complaint Report";
    $permission_type    = "view";
    $module_id          = "64";
    $parent_id          = "25";
    $parent_id2         = "61";
    $menu_id            = "rpt_cmp_quarterly_departmental_complaint";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $year_last  = DATE("Y", strtotime("-1 year"));    //Last Year
    $year       = DATE("Y");                          //Current Year
    $status     = "1,2,6";

    $objComplaintReport = new ComplaintReport();
    $deprtments = $objComplaintReport->getDepartmentById('');
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Reports Management</a></li>
        <li><a href="javascript:;">Complaint CS & Ops</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $page_title; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- <div class="col-md-12">
            <? 
                /*echo "<pre>";
                    print_r($data[0]); 
                echo "<pre>";*/
            ?>
        </div> -->

        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">&nbsp;</h4>
                </div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select class="form-control default-select2" id="getYear" name="getYear" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
                                        <option value="">-- Select Year --</option>
                                        <?php foreach($Years as $Year){ ?>
                                        <option value="<? echo $Year["value"]; ?>" ><? echo $Year["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                    
                                    <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a>
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_quarterly_departmental_complaint.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Quarterly Departmental Complaint Analysis Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                        <td align="left"></td>
                                         <td align="right">
                                            <b>Total Pages:</b> 1
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b>Year:</b>
                                            <span id="spanYear"> - </span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <table id="tblTable" class="table table-igi table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center line-hight">Department</th>
                                <th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>
                                <th colspan="4" class="text-center">Quarter-1 of <?php echo $year; ?></th>
                                <th colspan="4" class="text-center">Quarter-2 of <?php echo $year; ?></th>
                                <th colspan="4" class="text-center">Quarter-3 of <?php echo $year; ?></th>
                                <th colspan="4" class="text-center">Quarter-4 of <?php echo $year; ?></th>
                                <th rowspan="2" class="text-center line-hight">Pending</th>
                            </tr>
                            <tr>
                                <th class="text-center line-hight">Opening <?php echo $year_last; ?></th>
                                <th class="text-center line-hight">New</th>
                                <th class="text-center line-hight">Total</th>
                                <th class="text-center line-hight">Closed</th>

                                <th class="text-center line-hight">CF</th>
                                <th class="text-center line-hight">New</th>
                                <th class="text-center line-hight">Total</th>
                                <th class="text-center line-hight">Closed</th>

                                <th class="text-center line-hight">CF</th>
                                <th class="text-center line-hight">New</th>
                                <th class="text-center line-hight">Total</th>
                                <th class="text-center line-hight">Closed</th>

                                <th class="text-center line-hight">CF</th>
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

                            <?php $q2_cf_sum = 0; ?>
                            <?php $q2_new_sum = 0; ?>
                            <?php $q2_tot_sum = 0; ?>
                            <?php $q2_cls_sum = 0; ?>

                            <?php $q3_cf_sum = 0; ?>
                            <?php $q3_new_sum = 0; ?>
                            <?php $q3_tot_sum = 0; ?>
                            <?php $q3_cls_sum = 0; ?>

                            <?php $q4_cf_sum = 0; ?>
                            <?php $q4_new_sum = 0; ?>
                            <?php $q4_tot_sum = 0; ?>
                            <?php $q4_cls_sum = 0; ?>

                            <?php $pending_sum = 0; ?>

                            <?php foreach($deprtments as $deprtment): ?>
                                <?php
                                    $deprtment_id = $deprtment['id'];
                                    $data2 =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);
                                    $rowspan = count($data2);
                                    $rowspan = $rowspan + 1;
                                ?>
                                <tr>
                                    <td rowspan="<?php echo $rowspan; ?>"><?php echo $deprtment['primary_name']; ?></td>

                                    <?php for($i=0; $i<count($data2); $i++) { ?>
                                        <tr>
                                            <?php if($data2 != 0) {  ?>
                                                <td class="text-center line-hight"><?php echo $data2[$i]['fullname']; ?></td>

                                                <td class="text-center line-hight bgColor">
                                                    <?php 
                                                        $cmp_q1_open = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'',$year_last,$status);

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
                                                        $cmp_q1_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

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
                                                        $cmp_q1_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

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
                                                        $cmp_q1_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,'');

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
                                                        $cmp_q2_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'01',$year,$status);

                                                        //print_r($cmp_q2_cf); die;

                                                        $all_q2_cf = 
                                                            $cmp_q2_cf[0]['CMPL_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPC_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPLG_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPI_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPB_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPBB_NEW'] + 
                                                            $cmp_q2_cf[0]['CMPV_NEW'];

                                                        $all_q2_cf_sum = $all_q2_cf + $all_q1_open;

                                                        echo $all_q2_cf_sum;

                                                        $q2_cf_sum = $q2_cf_sum + $all_q1_new;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q2_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                                        //print_r($cmp_q2_new); die;

                                                        $all_q2_new = 
                                                            $cmp_q2_new[0]['CMPL_NEW'] + 
                                                            $cmp_q2_new[0]['CMPC_NEW'] + 
                                                            $cmp_q2_new[0]['CMPLG_NEW'] + 
                                                            $cmp_q2_new[0]['CMPI_NEW'] + 
                                                            $cmp_q2_new[0]['CMPB_NEW'] + 
                                                            $cmp_q2_new[0]['CMPBB_NEW'] + 
                                                            $cmp_q2_new[0]['CMPV_NEW'];

                                                        echo $all_q2_new;

                                                        $q2_new_sum = $q2_new_sum + $all_q2_new;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q2_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                                        //print_r($complaintslogged); die;

                                                        $all_q2_total = 
                                                            $cmp_q2_total[0]['CMPL_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPC_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPLG_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPI_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPB_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPBB_TOTAL'] + 
                                                            $cmp_q2_total[0]['CMPV_TOTAL'];

                                                        $all_q2 = $all_q2_total + $all_q2_cf_sum;

                                                        echo $all_q2;

                                                        //echo $all_q2_total;

                                                        $q2_tot_sum = $q2_tot_sum + $all_q2;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q2_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,'');

                                                        //print_r($cmp_q2_closed); die;

                                                        $all_q2_closed = 
                                                            $cmp_q2_closed[0]['CMPL_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPC_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPLG_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPI_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPB_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPBB_CLOSED'] + 
                                                            $cmp_q2_closed[0]['CMPV_CLOSED'];

                                                        echo $all_q2_closed;

                                                        $q2_cls_sum = $q2_cls_sum + $all_q2_closed;
                                                    ?>
                                                </td>

                                                <td class="text-center line-hight bgColor">
                                                    <?php
                                                        $cmp_q3_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'02',$year,$status);

                                                        //print_r($cmp_q3_cf); die;

                                                        $all_q3_cf = 
                                                            $cmp_q3_cf[0]['CMPL_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPC_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPLG_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPI_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPB_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPBB_NEW'] + 
                                                            $cmp_q3_cf[0]['CMPV_NEW'];

                                                        echo $all_q3_cf + $all_q2_cf_sum;

                                                        $q3_cf_sum = $q3_cf_sum + $all_q3_cf + $all_q2_cf_sum;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q3_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                                        //print_r($cmp_q3_new); die;

                                                        $all_q3_new = 
                                                            $cmp_q3_new[0]['CMPL_NEW'] + 
                                                            $cmp_q3_new[0]['CMPC_NEW'] + 
                                                            $cmp_q3_new[0]['CMPLG_NEW'] + 
                                                            $cmp_q3_new[0]['CMPI_NEW'] + 
                                                            $cmp_q3_new[0]['CMPB_NEW'] + 
                                                            $cmp_q3_new[0]['CMPBB_NEW'] + 
                                                            $cmp_q3_new[0]['CMPV_NEW'];

                                                        echo $all_q3_new;

                                                        $q3_new_sum = $q3_new_sum + $all_q3_new;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q3_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                                        //print_r($complaintslogged); die;

                                                        $all_q3_total = 
                                                            $cmp_q3_total[0]['CMPL_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPC_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPLG_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPI_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPB_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPBB_TOTAL'] + 
                                                            $cmp_q3_total[0]['CMPV_TOTAL'];

                                                        $all_q3 = $all_q3_total + $all_q3_cf + $all_q2_cf_sum;

                                                        echo $all_q3;

                                                        $q3_tot_sum = $q3_tot_sum + $all_q3;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q3_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,'');

                                                        //print_r($cmp_q1_closed); die;

                                                        $all_q3_closed = 
                                                            $cmp_q3_closed[0]['CMPL_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPC_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPLG_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPI_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPB_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPBB_CLOSED'] + 
                                                            $cmp_q3_closed[0]['CMPV_CLOSED'];

                                                        echo $all_q3_closed;

                                                        $q3_cls_sum = $q3_cls_sum + $all_q3_closed;
                                                    ?>
                                                </td>

                                                <td class="text-center line-hight bgColor">
                                                    <?php
                                                        $cmp_q4_cf = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'03',$year,$status);

                                                        //print_r($cmp_q1_cf); die;

                                                        $all_q4_cf = 
                                                            $cmp_q4_cf[0]['CMPL_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPC_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPLG_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPI_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPB_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPBB_NEW'] + 
                                                            $cmp_q4_cf[0]['CMPV_NEW'];

                                                        $all_q4_sum = $all_q4_cf + $all_q3_cf + $all_q2_cf_sum;

                                                        echo $all_q4_sum;

                                                        $q4_cf_sum = $q4_cf_sum + $all_q4_sum;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q4_new = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                                        //print_r($cmp_q1_new); die;

                                                        $all_q4_new = 
                                                            $cmp_q4_new[0]['CMPL_NEW'] + 
                                                            $cmp_q4_new[0]['CMPC_NEW'] + 
                                                            $cmp_q4_new[0]['CMPLG_NEW'] + 
                                                            $cmp_q4_new[0]['CMPI_NEW'] + 
                                                            $cmp_q4_new[0]['CMPB_NEW'] + 
                                                            $cmp_q4_new[0]['CMPBB_NEW'] + 
                                                            $cmp_q4_new[0]['CMPV_NEW'];

                                                        echo $all_q4_new;

                                                        $q4_new_sum = $q4_new_sum + $all_q4_new;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q4_total = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                                        //print_r($complaintslogged); die;

                                                        $all_q4_total = 
                                                            $cmp_q4_total[0]['CMPL_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPC_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPLG_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPI_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPB_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPBB_TOTAL'] + 
                                                            $cmp_q4_total[0]['CMPV_TOTAL'];

                                                        $all_q4 = $all_q4_total + $all_q4_sum;

                                                        echo $all_q4;

                                                        $q4_tot_sum = $q4_tot_sum + $all_q4_total + $all_q4_sum;
                                                    ?>
                                                </td>
                                                <td class="text-center line-hight">
                                                    <?php
                                                        $cmp_q4_closed = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'04',$year,'');

                                                        //print_r($cmp_q1_closed); die;

                                                        $all_q4_closed = 
                                                            $cmp_q4_closed[0]['CMPL_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPC_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPLG_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPI_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPB_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPBB_CLOSED'] + 
                                                            $cmp_q4_closed[0]['CMPV_CLOSED'];

                                                        echo $all_q4_closed;

                                                        $q4_cls_sum = $q4_cls_sum + $all_q4_closed;
                                                    ?>
                                                </td>

                                                <td class="text-center line-hight bgColor">
                                                    <?php
                                                        $cmp_pending = $objComplaintReport->countsQuarterlyDepartmentalComplaint($deprtment['id'],$data2[$i]['id'],'',$year,'');

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
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>

                                                <td class="text-center line-hight bgColor"><?php echo "0"; ?></td>
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>
                                                <td class="text-center line-hight"><?php echo "0"; ?></td>

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
                            <tr>
                                <td colspan="2" class="text-center line-hight boldText">Grand Total</td>

                                <td class="text-center line-hight boldText"><?php echo $opening_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q1_new_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q1_tot_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q1_cls_sum; ?></td>

                                <td class="text-center line-hight boldText"><?php echo $q2_cf_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q2_new_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q2_tot_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q2_cls_sum; ?></td>

                                <td class="text-center line-hight boldText"><?php echo $q3_cf_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q3_new_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q3_tot_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q3_cls_sum; ?></td>

                                <td class="text-center line-hight boldText"><?php echo $q4_cf_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q4_new_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q4_tot_sum; ?></td>
                                <td class="text-center line-hight"><?php echo $q4_cls_sum; ?></td>

                                <td class="text-center line-hight boldText"><?php echo $pending_sum; ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="assets/plugins/clipboard/clipboard.min.js"></script>
<script src="assets/js/form-plugins.demo.min.js"></script>

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<style type="text/css">
    #tblTable .line-hight{
        vertical-align: middle;
    }

    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }

    .bgColor{
        background-color: #006BB1 !important;
        color: #FFF;
    }

    .boldText{
        font-size: 18px;
        font-weight: 1200;
    }
</style>

<script>
    var PrintDate;
    var SITE_IP = '<?php echo SITE_IP; ?>';

    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();

        PrintDate = moment().format('YYYY-MM-DD HH:mm');
        $('#spanPrintDate').html(PrintDate);
    });
</script>

<script type="text/javascript">
    function search()
    {
        var getYear = $('#getYear').val();

        $('#spanYear').html(getYear);
        $('#spanPrintDate').html(PrintDate);

        var YearText  = $('#getYear option:selected').text();

        $('#spanYear').html(YearText);
  
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'     :'search_cmp_quarterly_departmental_complaint_rpt',
                    'getYear'    :getYear
                },
                success: function(data) 
                {
                    //alert(data);
                    console.log(data);
                    var result = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('#tblTable tr').remove();
                        $('#tblTable').html(result[1]); 
                    }
                }
            });
        }
    }

    function exportAllReport()
    {
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_cmp_quarterly_departmental_complaint_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_quarterly_departmental_complaint_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function exportFilterReport()
    {
        var getYear = $('#getYear').val();

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint_rpt.php",
                data:
                {
                    'action': 'export_cmp_quarterly_departmental_complaint_rpt',
                    'getYear': getYear
                },
                success: function(data)
                {
                    data = data.trim();
                    var result = data.split("|");

                    getYear   = result[1];

                    window.open(SITE_IP + "/reports/rpt_cmp_quarterly_departmental_complaint_download.php?getYear="+getYear);
                }
            }).done(function (data) {
                console.log(data);
            });
        }
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#getYear').val() == 0 || $('#getYear').val() == '') 
        {
            $('#getYear').addClass('error-val');
            $('#getYear').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#getYear').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear').removeClass('error-val');
            //$('#getYear').parents('.control-group').addClass('success');
            $('#getYear').parent().find('.input-error').hide();
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }
</script>

</body>
</html>