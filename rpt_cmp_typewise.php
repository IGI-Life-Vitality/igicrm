<?php
    $page_title         = "Type Wise Report";
    $permission_type    = "view";
    $module_id          = "58";
    $parent_id          = "25";
    $parent_id2         = "54";
    $menu_id            = "rpt_cmp_typewise";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $objComplaintReport = new ComplaintReport();
    $deprtments = $objComplaintReport->getDepartmentById(''); 

    //print_r($deprtments); die;
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Duration Type</label>
                                    <select class="form-control default-select2" id="getDurationType" name="getDurationType" data-size="10" data-live-search="true" data-style="btn-white" onchange="showDurationTypeOption();">
                                        <option value=""> All </option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Quarterly</option>
                                        <option value="3">Yearly</option>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Month is required</div>
                                </div>
                            </div>

                            <div class="col-md-6" id="month_div">
                                <div class="form-group">
                                    <label>Month<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getMonth" name="getMonth" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Month --</option>
                                        <?php $getMonthsDB = $objComplaintReport->getMonthFromDB(); ?>
                                        <?php foreach($getMonthsDB as $getMonthDB){ ?>
                                            <option value="<? echo $getMonthDB["month_value"]; ?>" ><? echo $getMonthDB["month_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Month is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department Name</label>
                                    <select class="form-control default-select2" id="getDepartment" name="getDepartment" data-size="10" data-live-search="true" data-style="btn-white" onchange="getcmp_type_ind();">
                                        <option value=""> All </option>
                                        <?php $Depts = $objComplaintReport->getDepartment(); ?>
                                        <?php foreach($Depts as $Dept){ ?>
                                        <option value="<? echo $Dept["id"]; ?>" ><? echo $Dept["primary_name"]; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6" id="quarter_div">
                                <div class="form-group">
                                    <label>Quarter<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getQuarter" name="getQuarter" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Quarter --</option>
                                        <?php $getQuartersDB = $objComplaintReport->getQuarterFromDB(); ?>
                                        <?php foreach($getQuartersDB as $getQuarterDB){ ?>
                                            <option value="<? echo $getQuarterDB["quarter_value"]; ?>" ><? echo $getQuarterDB["quarter_name"]?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Quarter is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Complaint Type</label>
                                    <select class="form-control default-select2" id="getComplaintType" name="getComplaintType" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">All</option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6" id="year_div">
                                <div class="form-group">
                                    <label>Year<span style="color: red;">*</span></label>
                                    <select class="form-control default-select2" id="getYear" name="getYear" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                        <option value="">-- Select Year --</option>
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
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

                                    <a href="javascript: window.location.href = 'rpt_cmp_typewise.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Complaint Type Wise Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b class="DurationType">Duration Type:</b>
                                            <span id="spanDurationType"> - </span>
                                        </td>
                                        <td align="left">
                                            <b class="Department">Department:</b> 
                                            <span id="spanDepartment"> - </span>
                                        </td>
                                        <td align="right">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left">
                                            <b class="Duration">Duration: -</b> 
                                            <span id="spanMonth"></span>
                                            <span id="spanQuarter"></span>
                                            <span id="spanYear"></span>
                                        </td>
                                        <td align="left">
                                            <b class="ComplaintType">Complaint Type:</b> 
                                            <span id="spanComplaintType"> - </span>
                                        </td>
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
                                <th width="100px;">Department Name</th>
                                <th width="100px;">Departmental %</th>
                                <th width="100px;">Complaint Type</th>
                                <th width="200px;">Complaints logged in (Selected Duration)</th>
                                <th width="100px;">Complaint Type %</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
                            <?php $cmpTotalLogged = 0; ?>
                            <?php $cmpTotalPercentage = 0; ?>

                            <?php foreach($deprtments as $deprtment): ?>
                                <?php $cmpTotalTypewisePercentage = 0; ?>
                                <?php
                                    $deprtment_id = $deprtment['id'];

                                    //$data1 = $objComplaintReport->countsComplaintTypewiseOnLoad($deprtment_id,'');

                                    $data2 =  $objComplaintReport->getComplaintTypeByGroupId($deprtment['id']);

                                    $colspan1 = count($data2);
                                    $colspan1 = $colspan1 + 1;
                                ?>
                                <tr>
                                    <td rowspan="<?php echo $colspan1; ?>"><?php echo $deprtment['primary_name']; ?>
                                    </td>                                    

                                    <td rowspan="<?php echo $colspan1; ?>">
                                        <?php 
                                            // Departmental %
                                            $departPer = $objComplaintReport->countsAllComplaint();
                                            $allCmp = 
                                                $departPer[0]['L'] +
                                                $departPer[0]['C'] +
                                                $departPer[0]['LG'] +
                                                $departPer[0]['I'] +
                                                $departPer[0]['B'] +
                                                $departPer[0]['BB'] +
                                                $departPer[0]['V'];

                                            $complaintsloggedw = $objComplaintReport->countsComplaintTypewiseOnLoad($deprtment_id,'','','','','');
                                            //print_r($complaintsloggedw);die;
                                            $departmentalPercentage = 
                                                $complaintsloggedw[0]['CMPL'] + 
                                                $complaintsloggedw[0]['CMPC'] + 
                                                $complaintsloggedw[0]['CMPLG'] + 
                                                $complaintsloggedw[0]['CMPI'] + 
                                                $complaintsloggedw[0]['CMPB'] + 
                                                $complaintsloggedw[0]['CMPBB'] + 
                                                $complaintsloggedw[0]['CMPV'];

                                            $departmentalPercentage = ($departmentalPercentage/$allCmp)*100;

                                            echo number_format($departmentalPercentage,2)."%";

                                            //print_r($complaintsloggedw); die;
                                        ?>
                                    </td>

                                    <?php for($i=0; $i<count($data2); $i++) { ?>
                                        <tr>
                                            <?php if($data2 != 0) {  ?>
                                                <td><?php echo $data2[$i]['fullname']; ?></td>
                                                <td>
                                                    <?php
                                                        $complaintslogged = $objComplaintReport->countsComplaintTypewiseOnLoad('',$data2[$i]['id'],'','','','');

                                                        $allcomplaintslogged = 
                                                            $complaintslogged[0]['CMPL'] + 
                                                            $complaintslogged[0]['CMPC'] + 
                                                            $complaintslogged[0]['CMPLG'] + 
                                                            $complaintslogged[0]['CMPI'] + 
                                                            $complaintslogged[0]['CMPB'] + 
                                                            $complaintslogged[0]['CMPBB'] + 
                                                            $complaintslogged[0]['CMPV'];

                                                        //print_r($complaintslogged); die;

                                                        echo $allcomplaintslogged;

                                                        // For Total Complaints logged in (Selected Duration)
                                                        $cmpTotalLogged = $cmpTotalLogged + $allcomplaintslogged;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $countsAllComplaint = $objComplaintReport->countsComplaintTypewiseOnLoad('','','','','','');
                                                        //print_r($countsAllComplaint); die;

                                                        $countsAllCmp = 
                                                            $countsAllComplaint[0]['CMPL'] +
                                                            $countsAllComplaint[0]['CMPC'] +
                                                            $countsAllComplaint[0]['CMPLG'] +
                                                            $countsAllComplaint[0]['CMPI'] +
                                                            $countsAllComplaint[0]['CMPB'] +
                                                            $countsAllComplaint[0]['CMPBB'] +
                                                            $countsAllComplaint[0]['CMPV'];

                                                        $CmpTypePercentage = ($allcomplaintslogged/$countsAllCmp)*100;

                                                        echo number_format($CmpTypePercentage,2)."%";

                                                        // For Total Complaint Type %
                                                        $cmpTotalPercentage = $cmpTotalPercentage + $CmpTypePercentage;

                                                        $cmpTotalTypewisePercentage = $cmpTotalPercentage;

                                                        //$cmpTotalTypewisePercentage + $CmpTypePercentage;
                                                    ?>
                                                </td>
                                            <?php } else { ?>
                                                <td><?php echo "NA"; ?></td>
                                                <td><?php echo "0"; ?></td>
                                                <td><?php echo "0.00%"; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3">Total</td>
                                <!-- <td colspan="2"><?php //echo "100.00%"; ?></td> -->
                                <td><?php echo $cmpTotalLogged; ?></td>
                                <td><?php echo number_format($cmpTotalPercentage,2)."%"; ?></td>
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

    /*.select2-container--default{
        width: 256px !important;
    }

    #txtCNIC{
        width: 256px !important;
    }*/
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
        var getDurationType    = $('#getDurationType').val();
        var getDepartment      = $('#getDepartment').val();
        var getComplaintType   = $('#getComplaintType').val();
        var getMonth           = $('#getMonth').val();
        var getQuarter         = $('#getQuarter').val();
        var getYear            = $('#getYear').val();

        //alert(getDurationType); return false;

        var getDurationTypeText   = $('#getDurationType option:selected').text();
        var getDepartmentText     = $('#getDepartment option:selected').text();
        var getComplaintTypeText  = $('#getComplaintType option:selected').text();
        var getMonthText          = $('#getMonth option:selected').text();
        var getQuarterText        = $('#getQuarter option:selected').text();
        var getYearText           = $('#getYear option:selected').text();

        $('#spanDurationType').html(getDurationTypeText);
        $('#spanDepartment').html(getDepartmentText);
        $('#spanPrintDate').html(PrintDate);
        $('#spanComplaintType').html(getComplaintTypeText);

        if(getDurationType == 1)
        {
            $('#spanMonth').html(getMonthText);
            $('#spanQuarter').html('');
            $('#spanYear').html('');
        }
        else if(getDurationType == 2)
        {
            $('#spanQuarter').html(getQuarterText);
            $('#spanMonth').html('');
            $('#spanYear').html('');
        }
        else if(getDurationType == 3)
        {
            $('#spanYear').html(getYearText);
            $('#spanQuarter').html('');
            $('#spanMonth').html('');
        }

        if(validation())
        {
            //alert(getMonth); return false;

            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'            :'search_cmp_typewise_rpt',
                    'getDurationType'   :getDurationType,
                    'getDepartment'     :getDepartment,
                    'getComplaintType'  :getComplaintType,
                    'getMonth'          :getMonth,
                    'getQuarter'        :getQuarter,
                    'getYear'           :getYear
                },
                success: function(data) 
                {
                    /*alert(data); 
                    return false;*/

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

    function getcmp_type_ind()
    {
        var depart = $('#getDepartment').val();
        //alert(depart);return false;
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                action : "get_cmp_type",
                depart_id: depart
            }
            }).done(function (data) {
                //alert(data);
                $('#getComplaintType').html(data);
        });
    }

    function exportAllReport()
    {
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_all_cmp_typewise_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_typewise_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function exportFilterReport()
    {
        var getDurationType    = $('#getDurationType').val();
        var getDepartment      = $('#getDepartment').val();
        var getComplaintType   = $('#getComplaintType').val();
        var getMonth           = $('#getMonth').val();
        var getQuarter         = $('#getQuarter').val();
        var getYear            = $('#getYear').val();

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint_rpt.php",
                data:
                {
                    'action'            :'export_cmp_typewise_rpt',
                    'getDurationType'   :getDurationType,
                    'getDepartment'     :getDepartment,
                    'getComplaintType'  :getComplaintType,
                    'getMonth'          :getMonth,
                    'getQuarter'        :getQuarter,
                    'getYear'           :getYear
                },
                success: function(data)
                {
                    data = data.trim();
                    var result = data.split("|");

                    //alert(result);

                    durationType     = result[1];
                    departmentName   = result[2];
                    complaintType    = result[3];
                    month            = result[4];
                    quarter          = result[5];
                    year             = result[6];

                    window.open(SITE_IP + "/reports/rpt_cmp_typewise_download.php?getDurationType="+durationType+"&getDepartment="+departmentName+"&getComplaintType="+complaintType+"&getMonth="+month+"&getQuarter="+quarter+"&getYear="+year);
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
                $('#getQuarter').attr('disabled', true);
                $('#getYear').attr('disabled', true);
                $('#getMonth').removeAttr("disabled");

                $('#getYear').val("");
                $('#getQuarter').val("");
            }
            else if(getDurationType == 2)
            {
                $('#getMonth').attr('disabled', true);
                $('#getYear').attr('disabled', true);
                $('#getQuarter').removeAttr("disabled");

                $('#getMonth').val("");
                $('#getYear').val("");
            }
            else if(getDurationType == 3)
            {
                $('#getMonth').attr('disabled', true);
                $('#getQuarter').attr('disabled', true);
                $('#getYear').removeAttr("disabled");

                $('#getQuarter').val("");
                $('#getMonth').val("");
            }
        }
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        /*if($('#getDurationType').val() == '') 
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
        }*/

        if($('#getMonth').val() == '' && $('#getDurationType').val() == 1) 
        {
            $('#getMonth').addClass('error-val');
            $('#getMonth').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getMonth').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getMonth').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getMonth').removeClass('error-val');
            $('#getMonth').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getMonth').parent().find('.input-error').hide();
        }

        if($('#getQuarter').val() == '' && $('#getDurationType').val() == 2) 
        {
            $('#getQuarter').addClass('error-val');
            $('#getQuarter').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getQuarter').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getQuarter').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getQuarter').removeClass('error-val');
            $('#getQuarter').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#getQuarter').parent().find('.input-error').hide();
        }

        if($('#getYear').val() == '' && $('#getDurationType').val() == 3) 
        {
            $('#getYear').addClass('error-val');
            $('#getYear').parent().find('.input-error').show().css('display', 'inline-block');
            $('#getYear').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#getYear').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear').removeClass('error-val');
            $('#getYear').parent().find('.select2-container--default').show().removeClass('error-val');
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