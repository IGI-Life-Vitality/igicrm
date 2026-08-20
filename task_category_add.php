<?php
$page_title = "Add Task Category";
$permission_type = "create";
$module_id = "29";
$parent_id = '26';
$menu_id = "task_category_add";
include('includes/header.php');
include('classes/taskcat.php');

$objTaskcat  = new Taskcat();

if(isset($_GET))
{
    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $data = $objTaskcat->GetTaskCategory($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $heading = "Edit Task Category";
        $title = "<li class='active'> Edit Task Category </li>";
    }
    else
    {
        $heading = "Add Task Category";
        $isactive = "checked='checked'";
        $title = "<li class='active'> Add Task Category</li>";
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
        <li><a href="javascript:;">Task Management</a></li>
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

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
                    <form class="form-horizontal" action="" method="POST">
                        <div class="form-group" style="display: none;">
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtcategoryId" value="<?php echo($data[0]['id']); ?>" placeholder="Category Id" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Task Category</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtTaskCategoryName" id="txtTaskCategoryName" value="<?php echo($data[0]['fullname']); ?>" placeholder="Task Category" onkeypress="return validateAlphabets(event)"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Task Category is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <input type="checkbox" id="chkCategoryActive" name="chkCategoryActive" <?php echo ($isactive); ?> />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnCategorySave">Save</button>
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

    $(document).ready(function() {

        $(document).on('click', '#btnCategorySave', function () {

            var id = $('#txtcategoryId').val() !=0 ? $('#txtcategoryId').val() : 0;
            var action = id == 0 ? "category_save" : "category_edit";
            var task_category_name = $('#txtTaskCategoryName').val();
            var is_active = $('#chkCategoryActive').is(":checked") ? 1 : 0;

            if(validation()){

                $("#btnCategorySave").button('loading');

                $.ajax({
                    data: {
                        'action':action,
                        'id':id,
                        'fullname':task_category_name,
                        'isactive':is_active
                    },
                    type: 'POST',
                    url: "includes/ajax/action_taskcat.php",
                    success: function(data) {

                        $("#btnCategorySave").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);

                        if(data == 'success'){
                            clear_values();
                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "task_category_list.php" }, 3000);
                        }else if(data == 'fail'){
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });

            }
        });
    });


    function validation() {

        var hasFocus = false;
        var errCount = 0;

        if ($('#txtTaskCategoryName').val() == '') {

            $('#txtTaskCategoryName').addClass('error-val');
            $('#txtTaskCategoryName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtTaskCategoryName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtTaskCategoryName').removeClass('error-val');
            $('#txtTaskCategoryName').parent().find('.input-error').hide();
        }


        if (errCount > 0)
            return false;
        else
            return true;

    }

    function clear_values(){
        $('#txtcategoryId').val('');
        $('#txtTaskCategoryName').val('');
    }

</script>

</body>
</html>