<?php
    $page_title         = "Lead Status";
    $permission_type    = "view";
    $module_id          = "52";
    $parent_id          = "25";
    $parent_id2         = "25";
    $menu_id            = "rpt_lead_status";

    include('includes/header.php');
    include('classes/lead_rpt.php');

    $login_id = $_SESSION['login_id'];

    $objLeadReport = new LeadReport();
    $data          = $objLeadReport->countsLeadsByStatus('',''); 
    
    /*print_r($data);
    die;*/
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Reports Management</a></li>
        <li><a href="javascript:;">Lead Reports</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $page_title; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
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
                                    <label>From Date<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="datetimepicker1" name="txtFromDate" value="<? echo trim($_POST['txtFromDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtFromDate']))) : ''; ?>" placeholder="Start Date" data-date-format="YYYY-MM-DD">
                                    <div class="input-error form-control-input" style="color: Red; display: none;">From Date is required</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>To Date<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="datetimepicker2" name="txtToDate" value="<? echo trim($_POST['txtToDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtToDate']))) : ''; ?>" placeholder="End Date" data-date-format="YYYY-MM-DD">
                                    <div class="input-error form-control-input" style="color: Red; display: none;">To Date is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Leads</button>
                                    
                                    <!-- <button type="submit" name="export" class="btn btn-sm btn-success">Export Excel</button> -->
                                    
                                    <a href="" onclick="exportReport(); return false;" class="btn btn-sm btn-success">Export Excel</a>

                                    <a href="javascript: window.location.href = 'rpt_lead_status.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Lead Status Report</h4>
                                        </td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>
                                    <tr class="spanFromDate">
                                        <td align="left">
                                            <b class="FromDate">From Date:</b> 
                                            <span id="spanFromDate"> - </span>
                                        </td>
                                        <td align="right">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                    </tr>
                                    <tr class="spanToDate">
                                        <td align="left">
                                            <b class="ToDate">To Date:</b> 
                                            <span id="spanToDate"> - </span>
                                        </td>
                                        <td align="right">
                                            <b>Pages:</b> 1
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <table id="tblTable" class="table table-igi table-responsive">
                        <thead>
                            <tr>
                                <th width="600px;">Lead Status</th>
                                <th width="200px;">Lead Count</th>
                                <th width="200px;">Overall Percentage</th>
                            </tr>
                        </thead>

                        <?php 
                            $initiated_leads_pval       = ($data[0]['initiated_leads']/$data[0]['all_leads'])*100;
                            $inprogress_leads_pval      = ($data[0]['inprogress_leads']/$data[0]['all_leads'])*100;
                            $followup_leads_pval        = ($data[0]['followup_leads']/$data[0]['all_leads'])*100;
                            $bought_leads_pval          = ($data[0]['bought_leads']/$data[0]['all_leads'])*100;
                            $not_interested_leads_pval  = ($data[0]['not_interested_leads']/$data[0]['all_leads'])*100;
                            $general_inquiry_leads_pval = ($data[0]['general_inquiry_leads']/$data[0]['all_leads'])*100;

                            $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;
                        ?>

                        <tbody>
                            <tr>
                                <td>Initiated</td>
                                <td><?php echo $data[0]['initiated_leads']; ?></td>
                                <td><?php echo number_format($initiated_leads_pval); ?>%</td>
                            </tr>
                            <tr>
                                <td>In Progress</td>
                                <td><?php echo $data[0]['inprogress_leads']; ?></td>
                                <td><?php echo number_format($inprogress_leads_pval); ?>%</td>
                            </tr>
                            <tr>
                                <td>Follow Up</td>
                                <td><?php echo $data[0]['followup_leads']; ?></td>
                                <td><?php echo number_format($followup_leads_pval); ?>%</td>
                            </tr>
                            <tr>
                                <td>Bought</td>
                                <td><?php echo $data[0]['bought_leads']; ?></td>
                                <td><?php echo number_format($bought_leads_pval); ?>%</td>
                            </tr>
                            <tr>
                                <td>Not Interested</td>
                                <td><?php echo $data[0]['not_interested_leads']; ?></td>
                                <td><?php echo number_format($not_interested_leads_pval); ?>%</td>
                            </tr>
                            <tr>
                                <td>General Inquiry</td>
                                <td><?php echo $data[0]['general_inquiry_leads']; ?></td>
                                <td><?php echo number_format($general_inquiry_leads_pval); ?>%</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td><b>Total</b></td>
                                <td><b><?php echo number_format($data[0]['all_leads']); ?></b></td>
                                <td><b><?php echo number_format($t_pval); ?>%</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
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

        $('#spanFromDate').html(FromDate);
        $('#spanToDate').html(ToDate);
        $('#spanPrintDate').html(PrintDate);

        //alert(FromDate);
        //alert(ToDate);
  
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_lead_rpt.php",
                data: 
                {
                    'action'     :'search_lead_status_rpt',
                    'FromDate'   :FromDate,
                    'ToDate'     :ToDate
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                    var result = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('#tblTable tr').remove();
                        $('#tblTable').html(result[1]);

                        /*$('#data-table').dataTable({ 
                            destroy: true,            
                            responsive: true,            
                            searching: true,            
                            pageLength: 10,            
                            order: false       
                        }); */  
                    }
                }
            });
        }
    }

    function exportReport()
    {
        var FromDate    = $('#datetimepicker1').val();
        var ToDate      = $('#datetimepicker2').val();

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_lead_rpt.php",
                /*url: "rpt_lead_status_download.php?fDate="+FromDate+"&tDate="+ToDate,*/
                data:
                {
                    'action': 'export_lead_status_report',
                    'FromDate': FromDate,
                    'ToDate': ToDate
                },
                success: function(data)
                {
                    data = data.trim();

                    var result = data.split("|");

                    fDate = result[1];
                    tDate = result[2];

                    window.open(SITE_IP + "/reports/rpt_lead_status_download.php?fDate="+fDate+"&tDate="+tDate, "_blank");
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