<?php
    $page_title      = "Annual Comparison Report";
    $permission_type = "view";
    $module_id       = "56";
    $parent_id       = "25";
    $parent_id2      = "54";
    $menu_id         = "rpt_cmp_annual";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $year1 = DATE("Y", strtotime("-1 year"));    //Last Year
    $year2 = DATE('Y');                          //Current Year

    $objComplaintReport  = new ComplaintReport();
    $data1               = $objComplaintReport->countsAnnualComplaintComparison($year1);
    $data2               = $objComplaintReport->countsAnnualComplaintComparison($year2);
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
        <li><a href="javascript:;">Complaint QA</a></li>
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
                    print_r($data1[0]['LJUN']);
                echo "</pre>";die;*/
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year 1<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getYear1" name="getYear1" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
                                        <option value="">-- Select Year 1 --</option>
                                        <?php foreach($Years as $Year){ ?>
                                        <option value="<? echo $Year["value"]; ?>" ><? echo $Year["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year 1 is required</div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year 2<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getYear2" name="getYear2" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
                                        <option value="">-- Select Year 2 --</option>
                                        <?php foreach($Years as $Year){ ?>
                                        <option value="<? echo $Year["value"]; ?>" ><? echo $Year["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year 2 is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                                                        
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_annual.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Annual Comparison Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>
                                    <tr class="spangetYear1">
                                        <td align="left">
                                            <b class="Year1">Year 1:</b> 
                                            <span id="spangetYear1"> - </span>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                    </tr>
                                    <tr class="spangetYear2">
                                        <td align="left">
                                            <b class="Year2">Year 2:</b> 
                                            <span id="spangetYear2"> - </span>
                                        </td>
                                        <td></td>
                                         <td align="right">
                                            <b>Pages:</b> 1
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <table id="tblTable" class="table table-igi table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th width="100px;">Month</th>
                                <th width="100px;" id="spangetYear1"><?php echo $year1; ?></th>
                                <th width="100px;" id="spangetYear2"><?php echo $year2; ?></th>
                                <th width="100px;">Improvement</th>
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
                            <tr>
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
        var getYear1    = $('#getYear1').val();
        var getYear2    = $('#getYear2').val();

        //alert(getYear1); return false;

        if(getYear1 >= getYear2 && getYear1 != '')
        {
            alert("Kindly select higher than " + getYear1 + " in Year 2 Field!");
        }

        var Year1Text  = $('#getYear1 option:selected').text();
        var Year2Text  = $('#getYear2 option:selected').text();

        $('#spangetYear1').html(Year1Text);
        $('#spangetYear2').html(Year2Text);
  
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'     :'search_cmp_annual_rpt',
                    'getYear1'   :getYear1,
                    'getYear2'   :getYear2
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

    function exportFilterReport()
    {
        var getYear1    = $('#getYear1').val();
        var getYear2    = $('#getYear2').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_cmp_annual_rpt',
                'Year1': getYear1,
                'Year2': getYear2
            },
            success: function(data)
            {
                data = data.trim();
                var result = data.split("|");

                //alert(result);

                Year1   = result[1];
                Year2   = result[2];

                window.open(SITE_IP + "/reports/rpt_cmp_annual_download.php?Year1="+Year1+"&Year2="+Year2);
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#getYear1').val() == 0 || $('#getYear1').val() == null) 
        {
            $('#getYear1').addClass('error-val');
            $('#getYear1').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#getYear1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear1').removeClass('error-val');
            //$('#getYear1').parents('.control-group').addClass('success');
            $('#getYear1').parent().find('.input-error').hide();
        }

        if($('#getYear2').val() == 0 || $('#getYear2').val() == null) 
        {
            $('#getYear2').addClass('error-val');
            $('#getYear2').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#getYear2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear2').removeClass('error-val');
            $('#getYear2').parent().find('.input-error').hide();
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