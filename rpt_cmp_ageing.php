<?php
    $page_title         = "Ageing Report";
    $permission_type    = "view";
    $module_id          = "55";
    $parent_id          = "25";
    $parent_id2         = "54";
    $menu_id            = "rpt_cmp_ageing";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $objComplaintReport = new ComplaintReport();
    $data               = $objComplaintReport->countsComplaintAgeing('','','','','','');
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
                    print_r($data); 
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>From Date</label>
                                    <input type="text" class="form-control" id="datetimepicker1" name="txtFromDate" value="<? echo trim($_POST['txtFromDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtFromDate']))) : ''; ?>" placeholder="Start Date" data-date-format="YYYY-MM-DD">
                                    <div class="input-error form-control-input" style="color: Red; display: none;">From Date is required</div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <input type="text" class="form-control" id="datetimepicker2" name="txtToDate" value="<? echo trim($_POST['txtToDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtToDate']))) : ''; ?>" placeholder="End Date" data-date-format="YYYY-MM-DD">
                                    <div class="input-error form-control-input" style="color: Red; display: none;">To Date is required</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control default-select2" id="getDepartment" name="getDepartment" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $getDepartments = $objComplaintReport->getDepartment(); ?>
                                        <option value=''>All</option>
                                        <?php foreach($getDepartments as $getDepartment){ ?>
                                            <option value="<? echo $getDepartment["id"]; ?>" ><? echo $getDepartment["primary_name"]?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Complaint Type</label>
                                    <select class="form-control default-select2" id="getType" name="getType" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $getTypes = $objComplaintReport->getComplaintType(); ?>
                                        <option value=''>All</option>
                                        <?php foreach($getTypes as $getType){ ?>
                                            <option value="<? echo $getType["id"]; ?>" ><? echo $getType["fullname"]?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Source</label>
                                    <select class="form-control default-select2" id="getSource" name="getSource" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $getSources = $objComplaintReport->getSource(); ?>
                                        <option value=''>All</option>
                                        <?php foreach($getSources as $getSource){ ?>
                                            <option value="<? echo $getSource["id"]; ?>" ><? echo $getSource["fullname"]?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control default-select2" id="getStatus" name="getStatus" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $getStatuss = $objComplaintReport->getStatus(); ?>
                                        <option value=''>All</option>
                                        <?php foreach($getStatuss as $getStatus){ ?>
                                            <option value="<? echo $getStatus["id"]; ?>" ><? echo ucfirst($getStatus["fullname"]); ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                    
                                    <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a>
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_ageing.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Ageing Analysis</h4>
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
                                        <td></td>
                                        <td align="right">
                                            <b>Pages:</b> 1
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <b class="FromDate">From Date:</b> 
                                            <span id="spanFromDate"> - </span>
                                        </td>
                                        <td align="left">
                                            <b class="ToDate">To Date:</b> 
                                            <span id="spanToDate"> - </span>
                                        </td>
                                        <td align="right">
                                            <b class="Department">Department:</b> 
                                            <span id="spangetDepartment"> - </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <b class="Type">Complaint Type:</b> 
                                            <span id="spangetType"> - </span>
                                        </td>
                                        <td align="left">
                                            <b class="Source">Source:</b> 
                                            <span id="spangetSource"> - </span>
                                        </td>
                                        <td align="right">
                                            <b class="Status">Status:</b> 
                                            <span id="spangetStatus"> - </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <table id="data-table" class="table table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th width="100px;">Ticket #</th>
                                <th width="100px;">Registration Date</th>
                                <th width="100px;">Policy#</th>
                                <th width="100px;">Customer Name</th>
                                <th width="100px;">Contact No</th>
                                <th width="100px;">Source</th>
                                <th width="100px;">Logged By</th>
                                <th width="100px;">Complaint Type</th>
                                <th width="100px;">Department</th>
                                <th width="100px;">Assign To</th>
                                <th width="100px;">Priority/TAT</th>
                                <th width="100px;">Status</th>
                                <th width="100px;">Resolution Date</th>
                                <th width="100px;">Aging (Overdue)</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered table-responsive">
                            <?php foreach($data as $row): ?>
                                <tr>
                                    <td><?php echo $row['complaint_num'] ?></td>
                                    <td><?php echo substr($row['create_date'],0,10); ?></td>
                                    <td><?php echo $row['policy_num'] ?></td>
                                    <td><?php echo $row['customer_name'] ?></td>
                                    <td><?php echo $row['response_number'] ?></td>
                                    <td><?php echo $row['Source'] ?></td>
                                    <td><?php echo $row['ReleasedBy'] ?></td>
                                    <td><?php echo $row['ComplaintType'] ?></td>
                                    <td><?php echo $row['depart'] ?></td>
                                    <td><?php echo $row['AssignedTo'] ?></td>
                                    <td><?php echo $row['tat'] ?></td>
                                    <td><?php echo ucfirst($row['cmpStatus']); ?></td>
                                    <td><?php echo substr($row['close_date'],0,10); ?></td>
                                    <td>
                                        <?php
                                            // 1st date
                                            $resolution_date = substr($row['close_date'],0,10);

                                            // 2nd date
                                            $cdate  = substr($row['create_date'],0,10);
                                            $date   = strtotime($cdate);
                                            $tat    = substr($row['tat'],0,1);
                                            $create_date = strtotime("+$tat day", $date);
                                            $close_date = date('Y-m-d', $create_date);

                                            if($resolution_date == '0000-00-00')
                                            {
                                                $today  = DATE('Y-m-d');
                                                $start  = date_create($close_date);
                                                $end    = date_create($today);
                                                $diff   = date_diff($start,$end);
                                                echo $diff->format('%R%a Days');
                                            }
                                            else
                                            {
                                                $re = $objComplaintReport->cmpOverdue($resolution_date, $close_date);
                                                echo $re;
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
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
        var FromDate    = $('#datetimepicker1').val();
        var ToDate      = $('#datetimepicker2').val();
        var Department  = $('#getDepartment').val();
        var Type        = $('#getType').val();
        var Source      = $('#getSource').val();
        var Status      = $('#getStatus').val();

        var DepartmentText  = $('#getDepartment option:selected').text();
        var TypeText        = $('#getType option:selected').text();
        var SourceText      = $('#getSource option:selected').text();
        var StatusText      = $('#getStatus option:selected').text();

        $('#spanFromDate').html(FromDate);
        $('#spanToDate').html(ToDate);
        $('#spanPrintDate').html(PrintDate);
        $('#spangetDepartment').html(DepartmentText);
        $('#spangetType').html(TypeText);
        $('#spangetSource').html(SourceText);
        $('#spangetStatus').html(StatusText);
  
        /*if(validation())
        {*/
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'     :'search_cmp_ageing_rpt',
                    'FromDate'   :FromDate,
                    'ToDate'     :ToDate,
                    'Department' :Department,
                    'Type'       :Type,
                    'Source'     :Source,
                    'Status'     :Status
                },
                success: function(data) 
                {
                    //alert(data);
                    console.log(data);
                    var result = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('#data-table').html(result[1]);
                        $('#data-table').dataTable({ 
                           destroy: true,            
                           responsive: true,            
                           searching: true,            
                           pageLength: 10,            
                           order: [[ 0, "asc" ]]       
                        });
                    }
                }
            });
        /*}*/
    }

    function exportAllReport()
    {        
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_all_cmp_ageing_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_ageing_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function exportFilterReport()
    {
        var FromDate    = $('#datetimepicker1').val();
        var ToDate      = $('#datetimepicker2').val();
        var Department  = $('#getDepartment').val();
        var Type        = $('#getType').val();
        var Source      = $('#getSource').val();
        var Status      = $('#getStatus').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_cmp_ageing_rpt',
                'FromDate'   :FromDate,
                'ToDate'     :ToDate,
                'Department' :Department,
                'Type'       :Type,
                'Source'     :Source,
                'Status'     :Status
            },
            success: function(data)
            {
                data = data.trim();
                var result = data.split("|");

                //alert(result);

                FromDate    = result[1];
                ToDate      = result[2];
                Department  = result[3];
                Type        = result[4];
                Source      = result[5];
                Status      = result[6];

                window.open(SITE_IP + "/reports/rpt_cmp_ageing_download.php?FromDate="+FromDate+"&ToDate="+ToDate+"&Department="+Department+"&Type="+Type+"&Source="+Source+"&Status="+Status);
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    // Not using yet
    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#datetimepicker1').val() == 0 || $('#datetimepicker1').val() == null) 
        {
            $('#datetimepicker1').addClass('error-val');
            $('#datetimepicker1').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#datetimepicker1').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#datetimepicker1').removeClass('error-val');
            //$('#datetimepicker1').parents('.control-group').addClass('success');
            $('#datetimepicker1').parent().find('.input-error').hide();
        }

        if($('#datetimepicker2').val() == 0 || $('#datetimepicker2').val() == null) 
        {
            $('#datetimepicker2').addClass('error-val');
            $('#datetimepicker2').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#datetimepicker2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#datetimepicker2').removeClass('error-val');
            $('#datetimepicker2').parent().find('.input-error').hide();
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