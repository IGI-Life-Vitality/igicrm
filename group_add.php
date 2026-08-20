<?php
$page_title = "Add Group";
$permission_type = "create";
$module_id = "6";
$parent_id ="20";
$menu_id = "group_add";

include('includes/header.php');
include('classes/group.php');
$objGroup = new Group();

if(isset($_GET))
{
    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $data = $objGroup->GetGroups($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $heading = "Edit Group";
    }
    else
    {
        $heading = "Add Group";
        $isactive = "checked='checked'";
    }
}

$users_group = $objGroup->GetUsersByGroupId($id);
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
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li><a href="javascript:;">Administration</a></li>
    <li class="active">Add Group</li>
</ol>
<!-- end breadcrumb -->

<!-- begin page-header -->
<h1 class="page-header">Administration</h1>
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
                    <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                </div>

                <h4 class="panel-title"><? echo $heading; ?></h4>
            </div>

            <div class="panel-body">
                <form class="form-horizontal" autocomplete="off">
                    <fieldset>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Group Id</label>
                                    <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="Id" disabled="disabled" />
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Primary Name<span style="color: red; font-size: 16px;">*</span></label>
                                    <input type="text" class="form-control" id="txtPrimary" value="<?php echo($data[0]['primary_name']); ?>" placeholder="Primary Name" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Primary Name is required</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Secondary Name</label>
                                    <input type="text" class="form-control" id="txtSecondary" value="<?php echo($data[0]['secondary_name']); ?>" placeholder="Secondary Name" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Secondary Name is required</div>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>E-Mail Address</label>
                                    <input type="text" class="form-control" id="txtEmail" value="<?php echo($data[0]['email']); ?>" placeholder="abc@example.com" />
                                    <div class="input-error form-control-input" style="color: Red; display: none;">E-Mail Address is required</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Expiry Date</label>
                                    <input type="text" class="form-control" id="datepicker-autoClose" placeholder="Expiry Date" value="<?  echo ($id > 0 ? date('m/d/Y',strtotime($data[0]['expiry_date'])) : date('m/d/Y', strtotime("+365 days"))) ?>" />
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>

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
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-primary button_margin" id="btnGroupSave" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <br>

                    <fieldset>
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-tabs_1">
                                <!-- <li class="active tabColor">
                                    <a href="#default-tab-group" data-toggle="tab">
                                        <span class="visible-xs">Tab 1</span>
                                        <span class="hidden-xs">Group Assignment</span>
                                    </a>
                                </li>
                                <li class=" tabColor">
                                    <a href="#default-tab-user" data-toggle="tab">
                                        <span class="visible-xs">Tab 2</span>
                                        <span class="hidden-xs">User Assignment</span>
                                    </a>
                                </li> -->
                                <li class="active tabColor">
                                    <a href="#default-tab-permission" data-toggle="tab">
                                        <span class="visible-xs">Tab 3</span>
                                        <span class="hidden-xs">Permission Assignment</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content tab-content_1">
                                <!-- <div class="tab-pane fade active in" id="default-tab-group">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <select name="from" id="ddlGroup" class="form-control form-control_1" size="8" multiple="multiple">
                                                <?php //$groups = $objGroup->GetGroups(0,0); ?>
                                                <?php //foreach($groups as $group) { ?>
                                                    <option value="<? //echo $group["id"]; ?>"><? //echo $group["primary_name"]; ?></option>
                                                <? //} ?>
                                            </select>
                                        </div>
                                
                                        <div class="col-xs-2">
                                            <button type="button" id="ddlGroup_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                
                                            <button type="button" id="ddlGroup_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                
                                            <button type="button" id="ddlGroup_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                
                                            <button type="button" id="ddlGroup_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                        </div>
                                
                                        <div class="col-xs-5">
                                            <select name="to" id="ddlGroup_to" class="form-control form-control_1" size="8" multiple="multiple">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="default-tab-user">
                                    <div class="row">
                                        <div class="col-xs-5">
                                            <select name="ddlUser" id="ddlUser" class="form-control form-control_1" size="8" multiple="multiple">
                                                <?php //$users = $objUser->GetSpecificUsers(0,$users_group); ?>
                                                <?php //foreach($users as $user){ ?>
                                                    <option value="<? //echo $user["id"]; ?>"><? //echo $user["user_name"] ?></option>
                                                <? //} ?>
                                            </select>
                                        </div>
                                
                                        <div class="col-xs-2">
                                            <button type="button" id="ddlUser_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
                                
                                            <button type="button" id="ddlUser_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                
                                            <button type="button" id="ddlUser_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                
                                            <button type="button" id="ddlUser_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
                                        </div>
                                
                                        <div class="col-xs-5">
                                            <select name="ddlUser_to" id="ddlUser_to" class="form-control form-control_1" size="8" multiple="multiple">
                                                <?php //$users = $objUser->GetSpecificUsers(1,$users_group); ?>
                                                <?php //foreach($users as $user){ ?>
                                                    <option value="<? //echo $user["id"]; ?>"><? //echo $user["user_name"] ?></option>
                                                <? //} ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="tab-pane fade active in" id="default-tab-permission" style="min-height: 175px;">
                                    <div class="row">
                                        <div class="checkbox checkbox-css checkbox-inline checkbox-inverse full_permission">
                                        <input type="checkbox" type="checkbox" id="selectAll" />
                                        <label for="selectAll">Full Permission</label>
                                    </div>

                                    <?php $parentmodules = $objGroup->GetParentModules(); ?>

                                    <?php $countr=1; foreach ($parentmodules as $par_mod) { $par_id = $par_mod['id'];?>

                                    <div class="panel-group group_tab" id="accordion">
                                        <div class="panel panel-inverse overflow-hidden">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $countr?>">
                                                        <i class="fa fa-plus-circle pull-right"></i> 
                                                        <?php echo $par_mod['name'];?>
                                                    </a>
                                                </h3>
                                            </div>
                       
                                            <div id="collapse<?php echo $countr?>" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <?php $modules = $objGroup->GetModules($id,$par_id); ?>
                                                    <div class="table-responsive">
                                                        <table id="tblPermissions0" class="table table-striped tblPermissions">
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none;">Module Id</th>
                                                                    <th width="200px !important"></th>
                                                                    <th>Create</th>
                                                                    <th>Update</th>
                                                                    <th>Delete</th>
                                                                    <th>View</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <?php $counter=0; foreach ($modules as $row) { ?>
                                                                <tr>
                                                                    <td style="display: none;"><?php echo $row['id']; ?></td>
                                                                    <td><?php echo $row['name']; ?></td>
                                                                    <td>
                                                                        <input type="checkbox" value="" name="chkCreate" class="chkCreate" <?  echo $row['create'] == 1 ? "checked" : "" ?>  />
                                                                    </td>
                                                                    <td>
                                                                        <input type="checkbox" value="" name="chkCreate" class="chkUpdate" <?  echo $row['update'] == 1 ? "checked" : "" ?> />
                                                                    </td>
                                                                    <td>
                                                                        <input type="checkbox" value="" name="chkDelete" class="chkDelete" <?  echo $row['delete'] == 1 ? "checked" : "" ?> />
                                                                    </td>
                                                                    <td>
                                                                        <input type="checkbox" value="" name="chkView" class="chkView" <?  echo $row['view'] == 1 ? "checked" : "" ?> />
                                                                    </td>
                                                                </tr>
                                                                <? $counter++; } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <? $countr ++; } ?>
                                    </div>
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
<?php include('includes/footer.php'); ?>
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
<script src="assets/js/multiselect.js"></script>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<script src="assets/plugins/jquery-json/jquery.json.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();

        $('#ddlGroup').multiselect();
        $('#ddlUser').multiselect();

        $('#selectAll').click(function (e) {
            //$(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
            $('.tblPermissions').find('td input:checkbox').prop('checked', this.checked);
        });


        $(document).on('click', '#btnGroupSave', function () {
            var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save" : "edit";
            var primary_name = $('#txtPrimary').val();
            var secondary_name = $('#txtSecondary').val();
            var email = $('#txtEmail').val();
            var expiry_date = $('#datepicker-autoClose').val();
            var groups = $("#ddlGroup_to>option").map(function() { return $(this).val(); }).get();
            var users = $("#ddlUser_to>option").map(function() { return $(this).val(); }).get();
            var is_active = $('#chkIsActive').is(":checked") ? 1 : 0;
            var TableData = $.toJSON(storeTblValues());

            /*alert(TableData);
             return false;*/

            if(validation())
            {
                $("#btnGroupSave").button('loading');

                $.ajax({
                    data: {
                        'action':action,
                        'id':id,
                        'primary_name':primary_name,
                        'secondary_name':secondary_name,
                        'email':email,
                        'expiry_date':expiry_date,
                        'groups':groups,
                        'users':users,
                        'permissions':TableData,
                        'isactive':is_active
                    },
                    type: 'POST',
                    url: "includes/ajax/action_group.php",
                    success: function(data) 
                    {
                        $("#btnGroupSave").button('reset');

                        data = data.trim();
                        console.log(data);

                        if(data == 'success')
                        {
                            clear_values();

                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "group_view.php" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }

            return false;
        });
    });

    function storeTblValues()
    {
        var TableData = new Array();

        $('.tblPermissions tr').each(function(row, tr){

            TableData[row]={
                "moduleid"  : $(tr).find('td:eq(0)').text()
                ,"create"   : $(tr).find('.chkCreate').is(":checked") ? 1 : 0
                ,"update"   : $(tr).find('.chkUpdate').is(":checked") ? 1 : 0
                ,"delete"   : $(tr).find('.chkDelete').is(":checked") ? 1 : 0
                ,"view"     : $(tr).find('.chkView').is(":checked") ? 1 : 0
            }

        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }

    function clear_values()
    {
        $('#txtId').val('');
        $('#txtPrimary').val('');
        $('#txtSecondary').val('');
        $('#txtEmail').val('');
    }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#txtPrimary').val() == '') 
        {

            $('#txtPrimary').addClass('error-val');
            $('#txtPrimary').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPrimary').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtPrimary').removeClass('error-val');
            $('#txtPrimary').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }
</script>

</body>
</html>