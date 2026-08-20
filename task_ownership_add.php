<?php
$page_title = "Add Ownership";
$permission_type = "create";
$module_id = "69";
$parent_id = '20';
$menu_id = "task_ownership_add";
$title= '';
include('includes/header.php');
include('classes/taskcat.php');

$objTaskcat = new Taskcat();

if(isset($_GET))
{
    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $data = $objTaskcat->GetOwnershipList($id);
        $heading = "Edit Ownership";
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $title = "<li> Edit Ownership </li>";

    }
    else
    {
        $heading = "Add Ownership";
        $isactive = "checked='checked'";
        $title .= "<li class='active'> Add Ownership </li>";
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
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="">Task Management</a></li>
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

    <?php 
        /*echo "<pre>";
            print_r($data);
        echo "</pre>";*/
    ?>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" id="OwnershipForm">
                        <div class="form-group" style="display: none;">
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="Id" disabled />
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-md-2 control-label-my">Product Code</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtProductCode" value="<?php //echo($data[0]['product_code']); ?>" placeholder="Product Code"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product Code is required</div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Department Name</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName" data-placeholder="Select Department Name">
                                    <option value="" selected="selected" disabled>Select Department</option>
                                   <?php $groups = $objUser->GetGroups(); ?>
                                    <?php foreach($groups as $group) { ?>
                                        <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['department_id'] == $group["id"] ? "selected='selected'" : ""?>><? echo $group["primary_name"];?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Department Name is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Ownership</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtOwnership" id="txtOwnership" value="<?php echo($data[0]['fullname']); ?>" placeholder="CEC / ADMIN" />
                                <div class="input-error form-control-input" style="color: Red; display: none;">Ownership is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <input type="checkbox" id="chkIsActive" name="chkIsActive" <?php echo ($isactive); ?> />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <!--<button type="button" class="btn btn-sm btn-info" id="btnProductSave">Save</button>-->
                                <button type="button" class="btn btn-primary btn-sm" id="btnOwnershipSave" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
                            </div>
                        </div>
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
    $(document).ready(function() {
        /*$.notifyBar({ cssClass: "success", html: "Data Saved Successfully..!", close: true, waitingForClose: true, closeOnClick: false });

        $.notifyBar({
            html: "Thank you, your settings were updated!",
            delay: 2000,
            animationSpeed: "normal"
        });*/

        $(document).on('click', '#btnOwnershipSave', function () {
            var id                = $('#txtId').val() != 0 ? $('#txtId').val() : 0;
            var action            = id == 0 ? "ownership_save" : "ownership_edit";
            var txtOwnership      = $('#txtOwnership').val();
            var ddlDepartmentName = $('#ddlDepartmentName').val();
            var isactive          = $('#chkIsActive').is(":checked") ? 1 : 0;

            //alert(txtOwnership);return false;

            if (validation()) 
            {
                $("#btnOwnershipSave").button('loading');

                $.ajax({
                    data: 
                    {
                        'action'            : action,
                        'id'                : id,
                        'txtOwnership'      : txtOwnership,
                        'ddlDepartmentName' : ddlDepartmentName,
                        'isactive'          : isactive
                    },
                    type: 'POST',
                    url: "includes/ajax/action_taskcat.php",
                    success: function (data) 
                    {
                        $("#btnOwnershipSave").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);

                        if (data == 'success') 
                        {
                            clear_values();
                            $.notifyBar({ cssClass: "success", html: "Ownership Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "task_ownership_list.php" }, 3000);
                        } else if (data == 'fail') 
                        {
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });
    });

    function clear_values()
    {
        $('#txtId').val('');
        $('#txtOwnership').val('');
        $('#ddlDepartmentName').empty();
    }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#ddlDepartmentName').val() == null) 
        {
            $('#ddlDepartmentName').addClass('error-val');
            $('#ddlDepartmentName').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentName').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlDepartmentName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlDepartmentName').removeClass('error-val');
            $('#ddlDepartmentName').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlDepartmentName').parents('.control-group').addClass('success');
            $('#ddlDepartmentName').parent().find('.input-error').hide();
        }

        if ($('#txtOwnership').val() == '') 
        {
            $('#txtOwnership').addClass('error-val');
            $('#txtOwnership').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtOwnership').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtOwnership').removeClass('error-val');
            $('#txtOwnership').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }
</script>

</body>
</html>