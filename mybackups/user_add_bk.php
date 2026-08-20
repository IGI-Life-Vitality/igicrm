<?php

$page_title = "Add User";
$group_id = "user_management";
$menu_id = "user_add";

include('includes/header.php');

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data = $objUser->GetUsers($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $heading = "User Management";
    }
    else{
        $heading = "User Management";
        $isactive = "checked='checked'";
    }
}

?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
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
<link href="assets/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" />

<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>

<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">User Management</a></li>
        <li class="active">Add User</li>
    </ol>
    <!-- end breadcrumb -->

    <div class="noty_bar noty_theme_default noty_layout_top noty_success NotificationDiv" id="notify_success_insert" style="cursor: pointer; display: none;">
        <div class="noty_message">
            <span class="noty_text">Record Saved Successfully</span>
        </div>
    </div>

    <div class="noty_bar noty_theme_default noty_layout_top noty_error NotificationDiv" id="notify_error_insert" style="cursor: pointer; display: none;">
        <div class="noty_message">
            <span class="noty_text">Error while saving record, Please try again!</span>
        </div>
    </div>

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $heading; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>



                    <h4 class="panel-title">Add User</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" data-parsley-validate="true">

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Id</label>
                                        <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="Id" disabled />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" id="txtFirst" placeholder="First Name" />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">First Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" id="txtLast" placeholder="Last Name" />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Last Name is required</div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Id<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" name="txtUserId" id="txtUserId" <?php echo ($data[0]['id'] > 0 ? "disabled" : ""); ?> value="<?php echo($data[0]['user_id']); ?>" placeholder="User Id" data-parsley-required="true"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">User Id is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <input type="text" class="form-control" name="txtEmail" id="txtEmail" value="<?php echo($data[0]['email']); ?>" placeholder="example@mail.com" data-parsley-required="true"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">E-mail is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Password<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="password" class="form-control" name="txtPassword" id="txtPassword">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Password is required</div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Confirm Password<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="password" class="form-control" name="txtConfirmPassword" id="txtConfirmPassword" data-parsley-required="true"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;"></div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee Id<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" name="txtEmployeeId" id="txtEmployeeId" placeholder="Employee Id" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control" name="txtMobile" id="txtMobile" placeholder="92xxxxxxxxxx" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Location<span style="color: red; font-size: 16px;">*</span></label>
                                        <select class="form-control selectpicker" id="ddlLocation" name="ddlLocation" data-live-search="true" data-style="btn-white" title="Please select something!">
                                            <option value="0">--Select--</option>
                                            <option value="0">Karachi</option>
                                            <option value="0">Hyderabad</option>
                                            <option value="0">Lahore</option>
                                            <option value="0">Peshawar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" value="" placeholder="Expiry Date">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Is Active</label>
                                        <div>
                                            <div class="radio radio-css radio-inline radio-inverse">
                                                <input type="radio" name="radioInlineCss1" id="radio_inline_css_3" value="1" checked="">
                                                <label for="radio_inline_css_3">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="radio radio-css radio-inline radio-danger">
                                                <input type="radio" name="radioInlineCss1" id="radio_inline_css_4" value="2">
                                                <label for="radio_inline_css_4">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-success button_margin" onclick="save();">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-info button_margin" onclick="save();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-tabs_1">
                                <li class="active">
                                    <a href="#default-tab-group" data-toggle="tab">
                                        <span class="visible-xs">Tab 1</span>
                                        <span class="hidden-xs">Group Assignment</span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#default-tab-role" data-toggle="tab">
                                        <span class="visible-xs">Tab 2</span>
                                        <span class="hidden-xs">Role Assignment</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content tab-content_1">
                                <div class="tab-pane fade active in" id="default-tab-group">
                                    <div class="row">

                                        <div class="col-xs-5">

                                            <select name="from" id="multiselect" class="form-control form-control_1" size="8" multiple="multiple">

                                                <option value="1">IED Voice Team</option>

                                                <option value="2">Mobile Application</option>

                                                <option value="3">Finance</option>

                                                <option value="4">Marketing</option>

                                                <option value="5">Information Technology</option>

                                                <option value="6">System Administration</option>

                                            </select>

                                        </div>

                                        <div class="col-xs-2">

                                            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>

                                            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>

                                            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

                                            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>

                                        </div>

                                        <div class="col-xs-5">

                                            <select name="to" id="multiselect_to" class="form-control form-control_1" size="8" multiple="multiple">

                                            </select>

                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="default-tab-role">
                                    <table id="data-table" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Organizational Role Name</th>
                                            <th>Organizational Unit Name</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td>
                                                    <div id="jstree-default">
                                                        <ul>
                                                            <li data-jstree='{"opened":true}' >
                                                                Organizational Roles
                                                                <ul>
                                                                    <li data-jstree='{"opened":true, "selected":true }'>ATM Service Officer</li>
                                                                    <li>Call Agent</li>
                                                                    <li data-jstree='{"opened":false}' >
                                                                        Complaint Manager
                                                                        <ul>
                                                                            <li data-jstree='{"disabled":true}' >Disabled node</li>
                                                                            <li>Another node</li>
                                                                        </ul>
                                                                    </li>

                                                                    <li data-jstree='{"opened":false}' >
                                                                        E-Form Controller
                                                                        <ul>
                                                                            <li>Node 1</li>
                                                                            <li>Node 2</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>E-Form Handler Role</li>
                                                                    <li>General</li>
                                                                    <li>Manager</li>
                                                                    <!--                                                    <li data-jstree='{ "icon" : "fa fa-warning fa-lg text-danger" }'>custom icon class (fontawesome)</li>
                                                                                                                        <li data-jstree='{ "icon" : "fa fa-link fa-lg text-primary" }'><a href="http://www.jstree.com">Clickable link node</a></li>-->
                                                                </ul>
                                                            </li>
                                                            <!--<li>Root node 2</li>-->
                                                        </ul>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div id="jstree-checkable">
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        </fieldset>

                    </form>
                </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-6 -->
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
<script src="assets/plugins/jstree/dist/jstree.min.js"></script>
<script src="assets/js/ui-tree.demo.min.js"></script>
<script src="assets/js/multiselect.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TreeView.init();
        $('#multiselect').multiselect();
    });
</script>


<script type="text/javascript">

    function save() {

        //var action = "";
        var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
        var action = id == 0 ? "save" : "edit";
        var user_id = $('#txtUserId').val();
        var department_id = $('#ddlDepartment').val();
        var email = $('#txtEmail').val();
        var password = $('#txtPassword').val();
        var is_active = $('#chkIsActive').is(":checked") ? 1 : 0;

        if(validation()){

            $.ajax({
                data: {
                    'action':action,
                    'id':id,
                    'user_id':user_id,
                    'department_id':department_id,
                    'email':email,
                    'password':password,
                    'is_active':is_active
                },
                type: 'POST',
                url: "includes/ajax/action_user.php",
                success: function(data) {

                    data = data.trim();
                    //alert(data);
                    console.log(data);

                    if(data == 'success'){
                        $('#notify_success_insert').show();
                        clear_values();
                    }else if(data == 'fail'){
                        $('#notify_error_insert').show();
                    }

                    setTimeout(function () { window.location.href = "user_add.php" }, 3000);
                }
            });

        }

    }

    function clear_values(){
        $('#txtId').val('');
        $('#txtUserId').val('');
        $('#txtPassword').val('');
        $('#txtEmail').val('');
    }

    function validation(){

        var hasFocus = false;
        var errCount = 0;


        if($('#txtUserId').val() == '') {

            $('#txtUserId').parents('.control-group').addClass('error');
            $('#txtUserId').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtUserId').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtUserId').parents('.control-group').removeClass('error');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtUserId').parent().find('.input-error').hide();
        }

        if($('#ddlDepartment').val() == 0) {

            $('#ddlDepartment').parents('.control-group').addClass('error');
            $('#ddlDepartment').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtTitle').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlDepartment').parents('.control-group').removeClass('error');
            //$('#ddlDepartment').parents('.control-group').addClass('success');
            $('#ddlDepartment').parent().find('.input-error').hide();
        }

        if($('#txtEmail').val() == '') {

            $('#txtEmail').parents('.control-group').addClass('error');
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtEmail').parents('.control-group').removeClass('error');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
        }

        if($('#txtPassword').val() == '') {

            $('#txtPassword').parents('.control-group').addClass('error');
            $('#txtPassword').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPassword').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtPassword').parents('.control-group').removeClass('error');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#txtPassword').parent().find('.input-error').hide();
        }


        if (errCount > 0)
            return false;
        else
            return true;
    }

</script>

</body>
</html>

