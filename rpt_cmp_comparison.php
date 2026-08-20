<?php
    $page_title         = "Comparison Report";
    $permission_type    = "view";
    $module_id          = "57";
    $parent_id          = "25";
    $parent_id2         = "54";
    $menu_id            = "rpt_cmp_comparison";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $year1 = DATE("Y", strtotime("-1 year"));    //Last Year
    $year2 = DATE("Y");                          //Current Year

    $objComplaintReport  = new ComplaintReport();
    $data1               = $objComplaintReport->countsAllComplaintComparison(3,'','',$year1);
    $data2               = $objComplaintReport->countsAllComplaintComparison(3,'','',$year2);

    /*echo "<pre>";
        print_r($data2);
    echo "</pre>";die;*/
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
        <li><a href="javascript:;">Complaint Comparison Report</a></li>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Comparison</label>
                                    <select class="form-control default-select2" id="getDurationType" name="getDurationType" data-size="10" data-live-search="true" data-style="btn-white" onchange="showDurationTypeOption();">
                                        <option value=""> -- Select Comparison First -- </option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Quarterly</option>
                                        <option value="3">Yearly</option>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Comparison is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Month 1<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getMonth1" name="getMonth1" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Month 1 --</option>
                                        <?php $getMonthsDB = $objComplaintReport->getMonthFromDB(); ?>
                                        <?php foreach($getMonthsDB as $getMonthDB){ ?>
                                            <option value="<? echo $getMonthDB["month_value"]; ?>" ><? echo $getMonthDB["month_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Month 1 is required</div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Month 2<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getMonth2" name="getMonth2" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Month 2 --</option>
                                        <?php $getMonthsDB = $objComplaintReport->getMonthFromDB(); ?>
                                        <?php foreach($getMonthsDB as $getMonthDB){ ?>
                                            <option value="<? echo $getMonthDB["month_value"]; ?>" ><? echo $getMonthDB["month_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Month 2 is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quarter 1<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getQuarter1" name="getQuarter1" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Quarter 1 --</option>
                                        <?php $getQuartersDB = $objComplaintReport->getQuarterFromDB(); ?>
                                        <?php foreach($getQuartersDB as $getQuarterDB){ ?>
                                            <option value="<? echo $getQuarterDB["quarter_value"]; ?>" ><? echo $getQuarterDB["quarter_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Quarter 1 is required</div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quarter 2<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getQuarter2" name="getQuarter2" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Quarter 2 --</option>
                                        <?php $getQuartersDB = $objComplaintReport->getQuarterFromDB(); ?>
                                        <?php foreach($getQuartersDB as $getQuarterDB){ ?>
                                            <option value="<? echo $getQuarterDB["quarter_value"]; ?>" ><? echo $getQuarterDB["quarter_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Quarter 2 is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year 1<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getYear1" name="getYear1" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Year 1 --</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year 1 is required</div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year 2<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getYear2" name="getYear2" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Year 2 --</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year 2 is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                    
                                    <!-- <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a> -->
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_comparison.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Complaint Comparison Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr class="spanComparison">
                                        <td align="left">
                                            <b>Duration Type: </b>
                                            <span id="spanComparison"> Yearly </span>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                        </td>
                                    </tr>

                                    <tr class="spanDuration1">
                                        <td align="left">
                                            <b class="spanDuration1">Duration 1:</b> 
                                            <span id="spanDuration1"> <?php echo $year1; ?> </span>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                    </tr>

                                    <tr class="spanDuration2">
                                        <td align="left">
                                            <b class="spanDuration2">Duration 2:</b> 
                                            <span id="spanDuration2"> <?php echo $year2; ?> </span>
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
                                <th width="100px;"><?php echo $year1; ?></th>
                                <th width="100px;"><?php echo $year2; ?></th>
                                <th width="100px;">Improvement</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
                            <tr>
                                <td>Complaints logged in <?php echo $year1; ?></td>
                                <td>Complaints logged in <?php echo $year2; ?></td>
                                <td>Improvement in Percentage</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td><?php echo $data1[0]['ALLCMPSUM']; ?></td>
                                <td><?php echo $data2[0]['ALLCMPSUM']; ?></td>
                                <td>
                                    <?php
                                        $A = $data1[0]['ALLCMPSUM'];
                                        $B = $data2[0]['ALLCMPSUM'];
                                        echo (($A-$B)/($A+$B)*100)."%";
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

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
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
        var getDurationType     = $('#getDurationType').val();
        var getMonth1           = $('#getMonth1').val();
        var getMonth2           = $('#getMonth2').val();
        var getQuarter1         = $('#getQuarter1').val();
        var getQuarter2         = $('#getQuarter2').val();
        var getYear1            = $('#getYear1').val();
        var getYear2            = $('#getYear2').val();

        //alert(getDurationType); return false;

        var getDurationTypeText    = $('#getDurationType option:selected').text();
        var getMonthText1          = $('#getMonth1 option:selected').text();
        var getMonthText2          = $('#getMonth2 option:selected').text();
        var getQuarterText1        = $('#getQuarter1 option:selected').text();
        var getQuarterText2        = $('#getQuarter2 option:selected').text();
        var getYearText1           = $('#getYear1 option:selected').text();
        var getYearText2           = $('#getYear2 option:selected').text();

        $('#spanComparison').html(getDurationTypeText);
        $('#spanPrintDate').html(PrintDate);

        if((getMonth1 != '' || getMonth2 != '') && (getMonth1 >= getMonth2))
        {
            alert("Kindly select higher than " + getMonthText1 + " in Month 2 Field!");
        }

        if((getQuarter1 != '' || getQuarter2 != '') && (getQuarter1 >= getQuarter2))
        {
            alert("Kindly select higher than " + getQuarterText1 + " in Quarter 2 Field!");
        }

        if((getYear1 != '' || getYear2 != '') && (getYear1 >= getYear2))
        {
            alert("Kindly select higher than " + getYearText1 + " in Year 2 Field!");
        }

        if(getDurationType == 1)
        {
            $('#spanDuration1').html(getMonthText1);
            $('#spanDuration2').html(getMonthText2);
            $('#spanQuarter1').html('');
            $('#spanQuarter2').html('');
            $('#spanYear1').html('');
            $('#spanYear2').html('');
        }
        else if(getDurationType == 2)
        {
            $('#spanDuration1').html(getQuarterText1);
            $('#spanDuration2').html(getQuarterText2);
            $('#spanMonth1').html('');
            $('#spanMonth2').html('');
            $('#spanYear1').html('');
            $('#spanYear2').html('');
        }
        else if(getDurationType == 3)
        {
            $('#spanDuration1').html(getYearText1);
            $('#spanDuration2').html(getYearText2);
            $('#spanQuarter1').html('');
            $('#spanQuarter2').html('');
            $('#spanMonth1').html('');
            $('#spanMonth2').html('');
        }

        if(validation())
        {
            //alert(getMonth); return false;

            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'             :'search_cmp_comparison_rpt',
                    'getDurationType'    :getDurationType,
                    'getMonth1'          :getMonth1,
                    'getMonth2'          :getMonth2,
                    'getQuarter1'        :getQuarter1,
                    'getQuarter2'        :getQuarter2,
                    'getYear1'           :getYear1,
                    'getYear2'           :getYear2
                },
                success: function(data)
                {
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

    /*function exportAllReport()
    {
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_all_cmp_departmentwise_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_departmentwise_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }*/

    function exportFilterReport()
    {
        var getDurationType     = $('#getDurationType').val();
        var getMonth1           = $('#getMonth1').val();
        var getMonth2           = $('#getMonth2').val();
        var getQuarter1         = $('#getQuarter1').val();
        var getQuarter2         = $('#getQuarter2').val();
        var getYear1            = $('#getYear1').val();
        var getYear2            = $('#getYear2').val();

        var getDurationTypeText    = $('#getDurationType option:selected').text();
        var getMonthText1          = $('#getMonth1 option:selected').text();
        var getMonthText2          = $('#getMonth2 option:selected').text();
        var getQuarterText1        = $('#getQuarter1 option:selected').text();
        var getQuarterText2        = $('#getQuarter2 option:selected').text();
        var getYearText1           = $('#getYear1 option:selected').text();
        var getYearText2           = $('#getYear2 option:selected').text();

        if((getMonth1 != '' || getMonth2 != '') && (getMonth1 >= getMonth2))
        {
            alert("Kindly select higher than " + getMonthText1 + " in Month 2 Field!");
        }

        if((getQuarter1 != '' || getQuarter2 != '') && (getQuarter1 >= getQuarter2))
        {
            alert("Kindly select higher than " + getQuarterText1 + " in Quarter 2 Field!");
        }

        if((getYear1 != '' || getYear2 != '') && (getYear1 >= getYear2))
        {
            alert("Kindly select higher than " + getYearText1 + " in Year 2 Field!");
        }

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint_rpt.php",
                data:
                {
                    'action'             :'export_cmp_comparison_rpt',
                    'getDurationType'    :getDurationType,
                    'getMonth1'          :getMonth1,
                    'getMonth2'          :getMonth2,
                    'getQuarter1'        :getQuarter1,
                    'getQuarter2'        :getQuarter2,
                    'getYear1'           :getYear1,
                    'getYear2'           :getYear2
                },
                success: function(data)
                {
                    data = data.trim();
                    var result = data.split("|");

                    durationType      = result[1];
                    month1            = result[2];
                    month2            = result[3];
                    quarter1          = result[4];
                    quarter2          = result[5];
                    year1             = result[6];
                    year2             = result[7];

                    window.open(SITE_IP + "/reports/rpt_cmp_comparison_download.php?getDurationType="+durationType+"&getMonth1="+month1+"&getMonth2="+month2+"&getQuarter1="+quarter1+"&getQuarter2="+quarter2+"&getYear1="+year1+"&getYear2="+year2);
                }
            }).done(function (data) {
                console.log(data);
            });
        }
    }

    function showDurationTypeOption()
    {
        var getDurationType = $('#getDurationType').val();

        if(getDurationType != 0)
        {
            if(getDurationType == 1)
            {
                $('#getQuarter1').attr('disabled', true);
                $('#getQuarter2').attr('disabled', true);
                $('#getYear1').attr('disabled', true);
                $('#getYear2').attr('disabled', true);
                $('#getMonth1').removeAttr("disabled");
                $('#getMonth2').removeAttr("disabled");

                $('#getYear1').val("");
                $('#getYear2').val("");
                $('#getQuarter1').val("");
                $('#getQuarter2').val("");
            }
            else if(getDurationType == 2)
            {
                $('#getMonth1').attr('disabled', true);
                $('#getMonth2').attr('disabled', true);
                $('#getYear1').attr('disabled', true);
                $('#getYear2').attr('disabled', true);
                $('#getQuarter1').removeAttr("disabled");
                $('#getQuarter2').removeAttr("disabled");

                $('#getMonth1').val("");
                $('#getMonth2').val("");
                $('#getYear1').val("");
                $('#getYear2').val("");
            }
            else if(getDurationType == 3)
            {
                $('#getMonth1').attr('disabled', true);
                $('#getMonth2').attr('disabled', true);
                $('#getQuarter1').attr('disabled', true);
                $('#getQuarter2').attr('disabled', true);
                $('#getYear1').removeAttr("disabled");
                $('#getYear2').removeAttr("disabled");

                $('#getQuarter1').val("");
                $('#getQuarter2').val("");
                $('#getMonth1').val("");
                $('#getMonth2').val("");
            }
        }
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#getDurationType').val() == '') 
        {
            $('#getDurationType').addClass('error-val');
            $('#getDurationType').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getDurationType').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getDurationType').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getDurationType').removeClass('error-val');
            $('#getDurationType').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getDurationType').parent().find('.input-error').hide();
        }

        if($('#getMonth1').val() == '' && $('#getDurationType').val() == 1) 
        {
            $('#getMonth1').addClass('error-val');
            $('#getMonth1').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getMonth1').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getMonth1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getMonth1').removeClass('error-val');
            $('#getMonth1').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getMonth1').parent().find('.input-error').hide();
        }

        if($('#getMonth2').val() == '' && $('#getDurationType').val() == 1) 
        {
            $('#getMonth2').addClass('error-val');
            $('#getMonth2').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getMonth2').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getMonth2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getMonth2').removeClass('error-val');
            $('#getMonth2').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getMonth2').parent().find('.input-error').hide();
        }

        if($('#getQuarter1').val() == '' && $('#getDurationType').val() == 2) 
        {
            $('#getQuarter1').addClass('error-val');
            $('#getQuarter1').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getQuarter1').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getQuarter1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getQuarter1').removeClass('error-val');
            $('#getQuarter1').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getQuarter1').parent().find('.input-error').hide();
        }

        if($('#getQuarter2').val() == '' && $('#getDurationType').val() == 2) 
        {
            $('#getQuarter2').addClass('error-val');
            $('#getQuarter2').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getQuarter2').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getQuarter2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getQuarter2').removeClass('error-val');
            $('#getQuarter2').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getQuarter2').parent().find('.input-error').hide();
        }

        if($('#getYear1').val() == '' && $('#getDurationType').val() == 3) 
        {
            $('#getYear1').addClass('error-val');
            $('#getYear1').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getYear1').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getYear1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear1').removeClass('error-val');
            $('#getYear1').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getYear1').parent().find('.input-error').hide();
        }

        if($('#getYear2').val() == '' && $('#getDurationType').val() == 3) 
        {
            $('#getYear2').addClass('error-val');
            $('#getYear2').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getYear2').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getYear2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear2').removeClass('error-val');
            $('#getYear2').parent().find('.select2-container--default').show().removeClass('error-val');
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