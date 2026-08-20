<?php

$page_title = "Session Log History Report";
$permission_type = "view";
$module_id = "17";
$menu_id = "session_log_history_report";

include('includes/header.php');
include('classes/eform.php');

$objeform = new eform();
$data = $objeform->eform_complains($login_id,0);

?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->


<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
<link href="assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->


<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Reports</a></li>
        <li class="active"Session Log History Report</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Session Log History Report</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Session Activity Report</h4>
                </div>
                <div class="panel-body">
                    <legend>Search</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Organization Type <span style="color: red;">*</span></label>
                                    <select class="form-control" id="ddlPriority" name="ddlPriority">
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">Branch/Department</label>
                                    <select class="form-control" id="ddlPriority" name="ddlPriority">
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Users</label>
                                    <select class="multiple-select2 form-control" multiple="multiple" id="ddlUsers" name="ddlUsers" >
                                        <option>User 1</option>
                                        <option>User 2</option>
                                        <option>User 3</option>
                                        <option>User 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">Channel</label>
                                    <select class="form-control" id="ddlPriority" name="ddlPriority">
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>From Date <span style="color: red;">*</span></label>
                                    <div class="input-group" id="default-daterange">
                                        <input type="text" name="default-daterange" class="form-control" value="" placeholder="Click To Select Date Range">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Date</label>
                                    <div class="input-group" id="default-daterange">
                                        <input type="text" name="default-daterange" class="form-control" value="" placeholder="Click To Select Date Range">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RIM #</label>
                                    <input type="text" name="default-daterange" class="form-control" value="" placeholder="RIM Number">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">Medium</label>
                                    <select class="form-control" id="ddlPriority" name="ddlPriority">
                                        <option>All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Duration ></label>
                                        <input type="text" name="default-daterange" class="form-control" value="" placeholder="Duration">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Duration <</label>
                                        <input type="text" name="default-daterange" class="form-control" value="" placeholder="Duration">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-info">Submit</button>
                                    <button type="reset" class="btn btn-sm btn-info">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <legend class="text-center">User Session Log History Report</legend>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Channel Name :</label> All
                                </div>
                                <div class="form-group">
                                    <label>Period :</label> 01:06:2010 to 27:06:2010
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Branch.Dept :</label> All
                                </div>
                                <div class="form-group">
                                    <label></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label></label>
                                </div>
                                <div class="form-group">
                                    <label></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Printed By :</label> Admin
                                </div>
                                <div class="form-group">
                                    <label>Printed On :</label> 27:06:2010 9:07PM
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-8">
                                <label>Summary:</label>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Total Sessions</th>
                                            <th>Average Call Duration</th>
                                            <th>Total Duration</th>
                                            <th>Total Activites</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="1" valign="middle">
                                            <td>5</td>
                                            <td>25m:43s</td>
                                            <td>2h:7m</td>
                                            <td>5</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Customer Name</th>
                                    <th>RIM #</th>
                                    <th>Activites</th>
                                    <th>Outcome</th>
                                    <th>Session Time</th>
                                    <th>Duration (min)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2">admin- Admin</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                <tr>
                                    <td>1</td>
                                    <td>Asif Baloch</td>
                                    <td>1146</td>
                                    <td>1</td>
                                    <td>none</td>
                                    <td>06/03/10 07:35PM</td>
                                    <td>0m:36s</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">Activites Time 06/03/10 07:35PM</td>
                                    <td colspan="2">Activites Description <br>1-Inquiry/Accounts/Account Collection/abvc</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Asif Baloch</td>
                                    <td>619</td>
                                    <td>1</td>
                                    <td>none</td>
                                    <td>06/03/10 07:37PM</td>
                                    <td>2m:35s</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3">Activites Time 06/03/10 07:37PM</td>
                                    <td colspan="2">Activites Description <br>1-Inquiry/Accounts/Account Collection/abvc</td>
                                    <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
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
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->


<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script><script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
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
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>
<script src="assets/plugins/parsley/dist/parsley.js"></script><!-- ================== END PAGE LEVEL JS ================== -->




<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();
    });
</script>


</body>
</html>