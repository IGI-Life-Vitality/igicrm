<?php
    $page_title         = "SMS Interim";
    $permission_type    = "view";
    $module_id          = "72";
    $parent_id          = "25";
    // $parent_id2         = "66";
    $menu_id            = "rpt_sms_interim";

    include('includes/header.php');
    // include('classes/complaint_rpt.php');
    // include('classes/taskcat_rpt.php');

    $login_id           = $_SESSION['login_id'];

    // $objTaskcatReport   = new TaskcatReport();
    // $objComplaintReport = new ComplaintReport();
    // $deprtments         = $objTaskcatReport->getDepartmentById('');
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
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="loadTable(1);">Search</button>
                                    
                                    <a href="" onclick="exportReport(); return false;" class="btn btn-sm btn-success">Export Excel</a>

                                    <a href="javascript: window.location.href = 'sms_interim.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <table id="tblTable" class="table table-igi table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th >Source</th>
                                <th >Complaint Num</th>
                                <th >Customer Name</th>
                                <th >Customer Email</th>
                                <th >Response Number</th>
                                <th >Current Date</th>
                                <th >Days Since Complaint</th>
                                <th >Type</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
                            
                        
                        </tbody>
                    </table>
                    <nav style="    float: right;">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                </div>
            </div>
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

    .na{
        border-top: none !important; 
        border-left: none !important; 
        text-align: center !important; 
        margin: 0px !important;
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
    // $(document).ready(function() {
        loadTable(1); // Load first page

        // Function to load table data
        function loadTable(page) {
            var FromDate    = $('#datetimepicker1').val();
            var ToDate      = $('#datetimepicker2').val();
            $.ajax({
                type: 'POST',
                url: 'includes/ajax/action_complaint.php',
                data: {
                    action: 'search_sms_interim',
                    page: page,
                    FromDate: FromDate,
                    ToDate: ToDate
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#tblTable tbody').html(response.html);
                        $('#pagination').html(response.pagination);
                    } else {
                        $('#tblTable tbody').html('<tr><td colspan="8">No data found</td></tr>');
                        $('#pagination').empty();
                    }
                }
            });
        }

        // Handle pagination link click
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            loadTable(page);
        });

    function exportReport()
    {
        var FromDate    = $('#datetimepicker1').val();
        var ToDate      = $('#datetimepicker2').val();

        window.open(SITE_IP + "/reports/rpt_sms_interim_download.php?fDate="+FromDate+"&tDate="+ToDate, "_blank");
               
    }

</script>

</body>
</html>