<?php

$page_title = "Add User";
$permission_type = "create";
$module_id = "5";
$parent_id ="20";
$menu_id = "user_add";

include('includes/header.php');

$title= '';

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data = $objUser->GetUsers($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $isdisabled = "disabled='disabled'";
        $heading = "User Management";
        $title .= "<li class='active'><a href='user_list.php'> View User </a></li>";
        $title .= "<li class='active'> Edit User </li>";
        $panel_title = "Edit User";
        $group_assign = $data[0]['user_type'] == 3 ? "disabled='disabled'" : "";
    }
    else{
        $title = "<li class='active'> Add User </li>";
        $panel_title = "Add User";;
        $heading = "User Management";
        $isactive = "checked='checked'";
        $isdisabled = "";
        $group_assign = "";
    }
}

?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
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
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->

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
                    </div>



                    <h4 class="panel-title"><?php echo $panel_title; ?></h4>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                    </div>
                    <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                        <strong>Error!</strong>
                        Error while saving record, Please try again!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>
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
                                        <input type="text" class="form-control" value="<?php echo $data[0]['first_name'] != '' ? $data[0]['first_name'] : '' ?>" onkeypress="return validateAlphabets(event)" id="txtFirst" placeholder="First Name" />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">First Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" id="txtLast" value="<?php echo $data[0]['last_name'] != '' ? $data[0]['last_name'] : '' ?>" onkeypress="return validateAlphabets(event)" placeholder="Last Name" />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Last Name is required</div>
                                    </div>
                                </div>

                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Type<span style="color: red; font-size: 16px;">*</span></label>
                                        <select class="form-control default-select2" id="ddlUserType" name="ddlUserType" data-live-search="true" data-style="btn-white" data-placeholder="Select User Type">
                                            <option value="0" selected="selected" disabled>--Select--</option>
                                            <?php $usertypes = $objUser->GetUserType(); ?>
                                            <?php    foreach($usertypes as $usertype){ ?>
                                            <option value="<?php echo $usertype['id'] ?>"<?php echo ($data[0]['user_type'] == $usertype['id'] ? "selected='selected'" : "") ?>><?php echo $usertype['fullname'] ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">User Type is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User Id<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" name="txtUserId" id="txtUserId" <?php echo $isdisabled; ?> value="<?php echo($data[0]['user_name']); ?>" placeholder="User Id" data-parsley-required="true"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">User Id is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>E-Mail<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" name="txtEmail" id="txtEmail" value="<?php echo($data[0]['email']); ?>" placeholder="example@mail.com" data-parsley-required="true"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Email Address is required</div>
                                        <div class="input-error1 form-control-input" style="color: Red; display: none;">Email format is incorrect</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Password<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="password" class="form-control" name="txtPassword" id="txtPassword" value="<?php echo $data[0]['user_pass'] != '' ? $data[0]['user_pass'] : '' ?>" <?php echo $isdisabled; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Password is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Confirm Password<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="password" class="form-control" name="txtConfirmPassword" id="txtConfirmPassword" value="<?php echo $data[0]['user_pass'] != '' ? $data[0]['user_pass'] : '' ?>" <?php echo $isdisabled; ?> />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Confirm Password is required</div>
                                        <div class="input-error1 form-control-input" style="color: Red; display: none;">Password Unmatched</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee Id<span style="color: red; font-size: 16px;">*</span></label>
                                        <input type="text" class="form-control" name="txtEmployeeId" id="txtEmployeeId" placeholder="Employee Id" value="<?php echo $data[0]['employee_id'] != '' ? $data[0]['employee_id'] : '' ?>" <?php echo $isdisabled; ?> />
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Employee ID is required</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <input type="text" class="form-control number" name="txtMobile" value="<?php echo $data[0]['mobile_no'] ?>" onkeypress="return validateNumbers(event)" maxlength="12" id="txtMobile" placeholder="92xxxxxxxxxx" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-control default-select2" id="ddlLocation" name="ddlLocation" data-placeholder="Select Location" />
                                            <option value="0" selected="selected" disabled>Select Location</option>
                                            <?php $locations = $objUser->GetLocation(); ?>
                                            <?php    foreach($locations as $location){ ?>
                                                <option value="<?php echo $location['id'] ?>"<?php echo ($data[0]['location_id'] == $location['id'] ? "selected='selected'" : "") ?>><?php echo $location['fullname'] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Expiry Date</label>
                                        <input type="text" class="form-control" id="datepicker-autoClose1" value="<?php echo $data[0]['expiry_datetime'] != "" ?  ($objUser->DateTimeToString($data[0]['expiry_datetime'])) : date("m/d/Y", strtotime("+30 days")); ?>"/>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Expiry Date is required</div>

                                    </div>
                                </div>
                                </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Is Active</label>
                                        <div class="checkbox checkbox-css checkbox-success">
                                            <input type="checkbox" id="chkIsActive" <? echo ($isactive);?> />
                                            <label for="chkIsActive">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary button_margin" id="btnUserSave" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
                                        <div id="divGroupError" class="input-error" style="color: Red; display: none;">Kindly select atleast one group</div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset id="group_role" <? echo $group_assign; ?>>
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-tabs_1">
                                <li class="active">
                                    <a href="#default-tab-group" data-toggle="tab">
                                        <span class="visible-xs">Tab 1</span>
                                        <span class="hidden-xs">Group Assignment</span>
                                    </a>
                                </li>
                                <!-- <li class="">
                                    <a href="#default-tab-role" data-toggle="tab">
                                        <span class="visible-xs">Tab 2</span>
                                        <span class="hidden-xs">Role Assignment</span>
                                    </a>
                                </li> -->
                            </ul>
                            <div class="tab-content tab-content_1">
                                <div class="tab-pane fade active in" id="default-tab-group">
                                    <div class="row">

                                        <div class="col-xs-5">

                                            <select name="from" id="ddlGroupAssign" class="form-control form-control_1" size="8" multiple="multiple">
                                                <? $groups_id = ($data[0]['group_id'] != '' ? $data[0]['group_id'] : 0); ?>
                                                <?php $groups = $objUser->GetSpecificGroups(0,$groups_id); ?>
                                                <?php foreach($groups as $group){ ?>
                                                    <option value="<? echo $group["id"]; ?>"><? echo $group["primary_name"] ?></option>
                                                <? } ?>

                                            </select>

                                        </div>

                                        <div class="col-xs-2">

                                            <button type="button" id="ddlGroupAssign_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>

                                            <button type="button" id="ddlGroupAssign_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>

                                            <button type="button" id="ddlGroupAssign_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>

                                            <button type="button" id="ddlGroupAssign_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>

                                        </div>

                                        <div class="col-xs-5">

                                            <select name="ddlGroupAssign_to" id="ddlGroupAssign_to" class="form-control form-control_1" size="8" multiple="multiple">
                                                <? $groups_id = ($data[0]['group_id'] != '' ? $data[0]['group_id'] : 0); ?>
                                                <?php $groups = $objUser->GetSpecificGroups(1,$groups_id); ?>
                                                <?php foreach($groups as $group){ ?>
                                                    <option value="<? echo $group["id"]; ?>"><? echo $group["primary_name"] ?></option>
                                                <? } ?>
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
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
        masking();
        $('#ddlGroupAssign').multiselect();
        TreeView.init();

    });
</script>


<script type="text/javascript">

    $(document).ready(function() {

        $(document).on('change', '#ddlUserType', function () {
            var user_type = $(this).val();

            // if(user_type == 3){
            //     $("#group_role").attr('disabled',true);
            // }else{
            //     $("#group_role").attr('disabled',false);
            // }
        });


        $(document).on('click', '#btnUserSave', function () {
            var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save" : "edit";
            var first_name = $('#txtFirst').val();
            var last_name = $('#txtLast').val();
            var user_type = $('#ddlUserType').val();
            var user_id = $('#txtUserId').val();
            var email = $('#txtEmail').val();
            var password = $('#txtPassword').val();
            var confirm_pass = $('#txtConfirmPassword').val();
            var employee_id = $('#txtEmployeeId').val();
            var mobile = $('#txtMobile').val();
            var location = $('#ddlLocation').val();
            // var group_id = user_type != 3 ? ($("#ddlGroupAssign_to>option").map(function() { return $(this).val(); }).get()) : 0;
            var group_id =$("#ddlGroupAssign_to>option").map(function() { return $(this).val(); }).get();
            var date_time = $('#datepicker-autoClose1').val();
            var isactive = $('#chkIsActive').is(":checked") ? 1 : 0;

            if(validation(group_id)){

                $("#btnUserSave").button('loading');

                $.ajax({
                    data: {
                        'action':action,
                        'id':id,
                        'first_name' :first_name,
                        'last_name' :last_name,
                        'user_type' :user_type,
                        'user_id':user_id,
                        'email':email,
                        'password':password,
                        'employee_id' :employee_id,
                        'mobile' :mobile,
                        'location' :location,
                        'group_id' :group_id,
                        'date_time' :date_time,
                        'is_active':isactive
                    },
                    type: 'POST',
                    url: "includes/ajax/action_user.php",
                    success: function(data) {

                        $("#btnUserSave").button('reset');

                        data = data.trim();
                        console.log(data);
                        //alert(data);

                        if(data == 'success'){
                            //$('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            //$('#divSuccess').html('<strong>Success!</strong> User created successfully with Employee Id  <strong>' + employee_id + '</strong> <span class="close" data-dismiss="alert">&times;</span>');
                            //$('#notify_success_insert').show();
                            clear_values();
                            setTimeout(function () { window.location.href = "user_list.php" }, 3000);
                        }else if(data == 'fail'){
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }

        });
    });

    function validation(group_id){

        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;


        if($('#txtFirst').val() == '') {

            $('#txtFirst').addClass('error-val');
            $('#txtFirst').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtFirst').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtFirst').removeClass('error-val');
            $('#txtFirst').parent().find('.input-error').hide();
        }

        if($('#txtLast').val() == '') {

            $('#txtLast').addClass('error-val');
            $('#txtLast').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtLast').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtLast').removeClass('error-val');
            //$('#ddlDepartment').parents('.control-group').addClass('success');
            $('#txtLast').parent().find('.input-error').hide();
        }

        if($('#ddlUserType').val() == null) {

            $('#ddlUserType').addClass('error-val');
            $('#ddlUserType').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlUserType').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlUserType').removeClass('error-val');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#ddlUserType').parent().find('.input-error').hide();
        }

        if($('#txtUserId').val() == '') {

            $('#txtUserId').addClass('error-val');
            $('#txtUserId').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtUserId').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtUserId').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtUserId').parent().find('.input-error').hide();
        }

        if($('#txtEmail').val() == '') {

            $('#txtEmail').addClass('error-val');
            //$('#txtEmail').parents('.control-group').addClass('error');
            $('#txtEmail').parent().find('.input-error1').hide();
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else if($('#txtEmail').val() != '' && email.test($('#txtEmail').val()) == false) {

            $('#txtEmail').addClass('error-val');
            //$('#txtEmail').parents('.control-group').addClass('error');
            $('#txtEmail').parent().find('.input-error').hide();
            $('#txtEmail').parent().find('.input-error1').show().css('display', 'inline-block');


            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtEmail').removeClass('error-val');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
            $('#txtEmail').parent().find('.input-error1').hide();
        }

        if($('#txtPassword').val() == '') {

            $('#txtPassword').addClass('error-val');
            $('#txtPassword').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPassword').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtPassword').removeClass('error-val');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#txtPassword').parent().find('.input-error').hide();
        }

        if($('#txtConfirmPassword').val() == '') {

            $('#txtConfirmPassword').addClass('error-val');
            //$('#txtConfirmPassword').parents('.control-group').addClass('error');
            $('#txtConfirmPassword').parent().find('.input-error1').hide();
            $('#txtConfirmPassword').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtConfirmPassword').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtConfirmPassword').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtConfirmPassword').parent().find('.input-error').hide();
        }

        if($('#txtPassword').val() != '' && $('#txtConfirmPassword').val() != ''){

            var password = $('#txtPassword').val();
            var confirmpass = $('#txtConfirmPassword').val();

            if(password != confirmpass) {

                $('#txtConfirmPassword').addClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtConfirmPassword').parent().find('.input-error').hide();
                $('#txtConfirmPassword').parent().find('.input-error1').show();

                if (!hasFocus) {
                    $('#txtConfirmPassword').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else {
                $('#txtConfirmPassword').removeClass('error-val');
                //$('#txtConfirmPassword').parents('.control-group').addClass('error');
                $('#txtConfirmPassword').parent().find('.input-error1').hide();
                $('#txtConfirmPassword').parent().find('.input-error').hide();
                //$('#txtConfirmPassword').parent().find('.input-error1').show().css('display', 'inline-block');


            }
        }

        if($('#txtEmployeeId').val() == '') {

            $('#txtEmployeeId').addClass('error-val');
            $('#txtEmployeeId').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmployeeId').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtEmployeeId').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtEmployeeId').parent().find('.input-error').hide();
        }

        if($('#ddlLocation').val() == 0) {

            $('#ddlLocation').addClass('error-val');
            $('#ddlLocation').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlLocation').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlLocation').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlLocation').parent().find('.input-error').hide();
        }


        if($('#ddlUserType').val() != '3')
        {
            if(group_id == '') {
                //$('#divGroupError').addClass('error');
                $('#divGroupError').show().css('display', 'block');
                errCount++;
            }
            else {
                //$('#divGroupError').removeClass('error');
                $('#divGroupError').hide();
            }
        }


        /*if($('#dtpDateTime').val() == '') {

            $('#dtpDateTime').parents('.control-group').addClass('error');
            $('#dtpDateTime').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#dtpDateTime').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#dtpDateTime').parents('.control-group').removeClass('error');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#dtpDateTime').parent().find('.input-error').hide();
        }*/


        if (errCount > 0)
            return false;
        else
            return true;
    }

    function masking(){
        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }

    function clear_values(){
        $('#txtId').val('');
        $('#txtFirst').val('');
        $('#txtLast').val('');
        $('#ddlUserType').empty();
        $('#txtUserId').val('');
        $('#txtEmail').val('');
        $('#txtPassword').val('');
        $('#txtConfirmPassword').val('');
        $('#txtEmployeeId').val('');
        $('#txtMobile').val('');
        $('#ddlLocation').empty();
        $('#datepicker-autoClose1').val('');
    }

</script>

</body>
</html>

