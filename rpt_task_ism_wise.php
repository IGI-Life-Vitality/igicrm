<?php
    $page_title         = "ISM Wise Results";
    $permission_type    = "view";
    $module_id          = "68";
    $parent_id          = "25";
    $parent_id2         = "66";
    $menu_id            = "rpt_task_ism_wise";

    include('includes/header.php');
    include('classes/complaint_rpt.php');
    include('classes/taskcat_rpt.php');

    $login_id     = $_SESSION['login_id'];
    $log_datetime = DATE('Y-m-d', strtotime("-1 day"));

    $objTaskcatReport   = new TaskcatReport();
    //$ismDetails         = $objTaskcatReport->getIsmWiseResultDetails($log_datetime);
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
        <li><a href="javascript:;">Task Reports</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $page_title; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
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
                        <!-- Filter Start -->
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Desired Date<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="datetimepicker1" name="txtFromDate" value="<? echo trim($_POST['txtFromDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtFromDate']))) : ''; ?>" placeholder="Start Date" data-date-format="YYYY-MM-DD">
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Desired Date is required</div>
                                </div>
                            </div>
                        </div>
                        <!-- Filter End -->

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Task</button>
                                    
                                    <!-- <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a> -->
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_task_ism_wise.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>ISM Wise Results</h4>
                                        </td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b class="FromDate">Desired Date:</b>
                                            <span id="spanFromDate"><?php echo DATE('Y-m-d'); ?></span>
                                        </td>
                                        <td align="right">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left"></td>
                                         <td align="right">
                                            <b>Pages:</b> 1
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php
                        //$SUM_AvgMinutesPerActivity = 0;
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

                    <table id="tblTable" class="table table-igi table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th class="text-center line-hight">INTERNAL <br>SERVICE MEASURE</th>
                                <th class="text-center line-hight">ISM's</th>
                                <th class="text-center line-hight">TAT <br> SLA Days</th>
                                <th class="text-center line-hight">Avg. Minutes<br> Per Activity</th>
                                <th class="text-center line-hight">B/F</th>
                                <th class="text-center line-hight">Incoming</th>
                                <th class="text-center line-hight">Total</th>
                                <th class="text-center line-hight">Today<br>Completed</th>
                                <th class="text-center line-hight">C/F</th>
                                <th class="text-center line-hight">Main-Hours</th>
                                <th class="text-center line-hight">1<br> Day</th>
                                <th class="text-center line-hight">2<br> Days</th>
                                <th class="text-center line-hight">3<br> Days</th>
                                <th class="text-center line-hight">4<br> Days or Above</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
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
                                <td class="line-hight"><?php echo $getSubCatName[0]['subcat_name']; ?></td>
                                <td class="line-hight"><?php echo $getSubCatName[0]['fullname']; ?></td>
                                <td class="text-center line-hight"><?php echo $ismDetail['tat'] . " Days"; ?></td>
                                <td class="text-center line-hight">
                                    <?php 
                                        echo $ismDetail['avg_mint_activity'];
                                        $SUM_AvgMinutesPerActivity += $ismDetail['avg_mint_activity'];
                                    ?>
                                </td>

                                <!-- For B/F as Yesterday's C/F truns Today's B/F -->
                                <?php
                                    $getCFDetails = $objTaskcatReport->getCFDetails($ism_sub_cat_id,$ism_id,$last_date);
                                ?>
                                <td class="text-center line-hight bgColor">
                                    <?php
                                        echo $getCFDetails[0]['cf'];
                                        $SUM_BF += $getCFDetails[0]['cf'];
                                    ?>
                                </td>
                                
                                <!-- For Today Incomming -->
                                <td class="text-center line-hight">
                                    <?php
                                        $getTodayIncommingTask = $objTaskcatReport->getTodayTask($ism_sub_cat_id,$ism_id,$present_date,$incomming_status);
                                        //print($getTodayIncommingTask);die;
                                        echo $getTodayIncommingTask[0]['task_counts'];
                                        $SUM_Incoming += $getTodayIncommingTask[0]['task_counts'];
                                    ?>
                                </td>

                                <!-- For Today Total -->
                                <td class="text-center line-hight">
                                    <?php 
                                        echo $getCFDetails[0]['cf'] + $getTodayIncommingTask[0]['task_counts'];
                                        $SUM_Total += ($getCFDetails[0]['cf'] + $getTodayIncommingTask[0]['task_counts']);
                                    ?>
                                </td>

                                <!-- For Today Completed -->
                                <td class="text-center line-hight">
                                    <?php
                                        $getTodayCompletedTask = $objTaskcatReport->getTodayCompletedTask($ism_sub_cat_id,$ism_id,$present_date,$completed_status);
                                        //print_r($getTodayCompletedTask);die;
                                        echo $getTodayCompletedTask[0]['task_counts'];
                                        $SUM_Today_Completed += $getTodayCompletedTask[0]['task_counts'];
                                    ?>
                                </td>

                                <!-- For Today C/F -->
                                <td class="text-center line-hight bgColor">
                                    <?php 
                                        $Pending_CF = ($getCFDetails[0]['cf'] + $getTodayIncommingTask[0]['task_counts']) - $getTodayCompletedTask[0]['task_counts'];
                                        echo $Pending_CF;
                                        $SUM_CF += $Pending_CF;
                                    ?>
                                </td>
                                
                                <!-- For Main Hours -->
                                <td class="text-center line-hight">
                                    <?php
                                        $main_hours = ($ismDetail['avg_mint_activity'] * $getTodayCompletedTask[0]['task_counts']) / 60;
                                        $main_hours = number_format($main_hours,2);
                                        echo $main_hours;
                                        $SUM_Main_Hours += $main_hours;
                                    ?>
                                </td>
                                
                                <?php 
                                    $TaskDiffs = $objTaskcatReport->getTaskDiff($ism_id);
                                    foreach($TaskDiffs as $TaskDiff)
                                    {
                                        $day1 = ($TaskDiff['DiffInDays'] == 1 ? $TaskDiff['RowCounts'] : "-");
                                        $day2 = ($TaskDiff['DiffInDays'] == 2 ? $TaskDiff['RowCounts'] : "-");
                                        $day3 = ($TaskDiff['DiffInDays'] == 3 ? $TaskDiff['RowCounts'] : "-");
                                        $day4 = ($TaskDiff['DiffInDays'] == 4 ? $TaskDiff['RowCounts'] : "-");
                                    }
                                ?>
                                <!-- For Ageings -->
                                <td class="text-center line-hight">
                                    <?php
                                        echo $day1;
                                        $SUM_Day1 += $day1;
                                        unset($day1);
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        echo $day2;
                                        $SUM_Day2 += $day2;
                                        unset($day2);
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        echo $day3;
                                        $SUM_Day3 += $day3;
                                        unset($day3);
                                    ?>
                                </td>
                                <td class="text-center line-hight">
                                    <?php
                                        echo $day4;
                                        $SUM_Day4 += $day4;
                                        unset($day4);
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4"><b>Grand Total</b></td>
                                <!-- <td class="text-center line-hight"><?php //echo $SUM_AvgMinutesPerActivity; ?></td> -->
                                <td class="text-center line-hight"><?php echo $SUM_BF; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Incoming; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Total; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Today_Completed; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_CF; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Main_Hours; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Day1; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Day2; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Day3; ?></td>
                                <td class="text-center line-hight"><?php echo $SUM_Day4; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4"><b>Manpower in working hours includes, given extra time </b></td>
                                <td colspan="10" class="text-center line-hight">
                                    <b><?php echo number_format($SUM_Main_Hours/6,2); ?></b>
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
    var PresentDate;
    var SITE_IP = '<?php echo SITE_IP; ?>';

    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();

        PrintDate = moment().format('YYYY-MM-DD HH:mm');
        PresentDate = moment().format('YYYY-MM-DD');
        $('#spanPrintDate').html(PrintDate);
    });
</script>

<script type="text/javascript">
    function search()
    {
        var FromDate = $('#datetimepicker1').val();

        $('#spanFromDate').html(FromDate);

        if(FromDate >= PresentDate)
        {
            alert("Kindly pick back days to view or export data!");
            return false;
        }
         //alert(FromDate);
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_taskcat_rpt.php",
                data: 
                {
                    'action'     :'search_task_ism_wise_rpt',
                    'FromDate'   :FromDate
                },
                success: function(data)
                {
                    console.log(data);
                    //alert(data);
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

    /*function exportAllReport()
    {
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_taskcat_rpt.php",
            data:
            {
                'action': 'export_task_ism_wise_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_task_ism_wise_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }*/

    function exportFilterReport()
    {
        var FromDate    = $('#datetimepicker1').val();

        if(FromDate >= PresentDate)
        {
            alert("Kindly pick back days to view or export data!");
            return false;
        }

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_taskcat_rpt.php",
                data:
                {
                    'action'     :'export_task_ism_wise_rpt',
                    'FromDate'   :FromDate
                },
                success: function(data)
                {
                    data = data.trim();
                    var result = data.split("|");
                    FromDate = result[1];

                    window.open(SITE_IP + "/reports/rpt_task_ism_wise_download.php?FromDate="+FromDate);
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

        if($('#datetimepicker1').val() == 0 || $('#datetimepicker1').val() == null) 
        {

            $('#datetimepicker1').addClass('error-val');
            $('#datetimepicker1').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#datetimepicker1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#datetimepicker1').removeClass('error-val');
            $('#datetimepicker1').parent().find('.input-error').hide();
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
