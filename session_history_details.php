<?php

$page_title = "Session History Details";
$permission_type = "view";
$module_id = "0";
$menu_id = "session_history";
$sub_module_id = "0";

include('includes/header.php');

$heading = "Session History Details";

?>



<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<!--<link href="assets/css/MyTheme/my_style.css" rel="stylesheet" />-->
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
<!-- ================== END PAGE LEVEL STYLE ================== -->





<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li><a href="javascript:;">Session History</a></li>
    <li class="active">Session History Details</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><?php echo $heading ?></h1>
<hr>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">

    <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <!--<div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>-->
                <h4 class="panel-title">Session Details</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                </div>
                <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                    <strong>Error!</strong>
                    Error while saving record, Please try again!
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>
                <form class="form-horizontal" action="" method="post" id="e_form">
                    <div class="form-group" style="display: none;">
                    <label class="col-md-2 control-label">ID</label>
                    <div class="col-md-2">
                        <input class="form-control" id="txtId" value="" disabled="disabled">
                    </div>
                </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Session Id</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtSessionId" id="txtSessionId" value="13500820" disabled="disabled">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Customer Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtCustomerName" id="txtCustomerName" value="" placeholder="Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Interaction Start Date/Time</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="dtStartTime" id="dtStartTime" value="" placeholder="Start Date Time">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Interaction End Date/Time</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="dtEndTime" id="dtEndTime" value="" placeholder="End Date Time">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Interaction Officer</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtOfficer" id="txtOfficer" value="" placeholder="Interaction Officer Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Interaction Outcome</label>
                        <div class="col-md-6">
                                <div class="radio radio-css radio-inline radio-inverse">
                                    <input type="radio" name="radInlineCss2" id="radio_inline_css_6" value="" checked="">
                                    <label for="radio_inline_css_6">
                                        Satisfied
                                    </label>
                                </div>
                                <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="radInlineCss2" id="radio_inline_css_7" value="">
                                <label for="radio_inline_css_7">
                                    Not Satisfied
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="radInlineCss3" id="radio_inline_css_8" value="">
                                <label for="radio_inline_css_8">
                                    Fully Satisfied
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="radInlineCss4" id="radio_inline_css_9" value="">
                                <label for="radio_inline_css_9">
                                    Other
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">CLI</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtCLI" id="txtCLI" value="" placeholder="Phone Number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Message Id</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtMessageId" id="txtMessageId" value="" placeholder="Message Id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label-my">Remarks</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="txtRemarks" id="txtRemarks" value="" placeholder="Agent's Remarks">
                        </div>
                    </div>

                    <hr>

                    <div class="col-md-12">
                        <div class=" form-group">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-info">Save & Submit</button>
                            </div>
                        </div>
                </div>

                </form>
            </div>
        </div>

        <div class="panel panel-inverse" data-sortable-id="table-basic-5">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Session Activity Detail List</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Activity Sequence No</th>
                            <th>Activity Date/Time</th>
                            <th>Activity Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>2017-07-13 16:55:12</td>
                            <td>Initiated</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>2017-07-15 16:55:12</td>
                            <td>Failed</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->

</div>
<!-- end #content -->



<!-- begin #footer -->
<?php include('includes/footer.php') ?>
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

<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
    });
</script>

<script type="text/javascript">
</script>

</body>
</html>