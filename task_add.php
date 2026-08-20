<?php
    $page_title      = "Add Task";
    $permission_type = "create";
    $module_id       = "27";
    $parent_id       = "26";
    $menu_id         = "task_add";

    include('includes/header.php');
    include('classes/task.php');

    $dis_button  = "";
    $objTask     = new Task();
    $tid         = isset($_GET['tid'])?$_GET['tid']: 0;
    $pno         = isset($_GET['pno'])?$_GET['pno']: "";
    $data        = $objTask->GetTasksdetail($tid);

    if($pno == "")
    {
        $dis_button = "disabled='disabled'";
    }
    else
    {
        $dis_button = "";
    }

    $users              = $objUser->GetUsers(0);
    $counter_display    = "";
    $counter            = "";
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
<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="task_view.php">Task</a></li>
        <li class="javascript:;">Add Task</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-4">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Add Task</h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="#" method="POST" id="task">
                        <input type="hidden" id="txtId" name="txtId" value="">
                        <input type="hidden" id="action" name="action" value="save_task">
                        <input type="hidden" id="is_manual" name="is_manual" value="0">
                        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? echo $counter_display; ?>" />
                        <input type="hidden" id="subcat_id" name="subcat_id" class="form-control" value="<?php echo $data[0]['sub_cat_id']; ?>" />
                        <input type="hidden" name="txtCounter" id="txtCounter" value="<? echo $counter; ?>" />
                        <input type="hidden" id="txtTaskNo" name="txtTaskNo" class="form-control" value="<? echo $counter_display; ?>">
                        <input type="hidden" id="task_ism_id" name="task_ism_id" class="form-control" />
                        <input type="hidden" id="user_id" name="user_id" class="form-control" />
                        <input type="hidden" id="tid" name="tid" class="form-control" value="<?php echo $tid ?>" />
                        <input type="hidden" id="pno" name="pno" class="form-control" value="<?php echo $pno; ?>" />
                        <input type="hidden" id="ddlGroup" name="ddlGroup" class="form-control" />
                        <input type="hidden" id="op_mode" name="op_mode" class="form-control" />

                        <fieldset>
                            <legend>Task</legend>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskCategory" name="ddlTaskCategory" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_cat();">
                                            <option selected="selected" value="" disabled="disabled">Select Category</option>
                                            <?php $getTaskCat = $objTask->GetTaskCat(); ?>
                                            <?php foreach($getTaskCat as $getTaskCats) { ?>
                                                <option value="<? echo $getTaskCats["id"]; ?>" <?php echo $data[0]['task_category_id'] == $getTaskCats["id"] ? "selected='selected'" : ""; ?> >
                                                    <? echo $getTaskCats["fullname"]; ?>
                                                </option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Task category is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Subcategory<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlSubCategory" name="ddlSubCategory" data-size="10" data-live-search="true" data-style="btn-white" onchange="getisms();">
                                            <option value="0" selected="selected" disabled>Select Subcategory</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Subcategory is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >ISM</label>
                                        <!-- <input type="text" class="form-control" name="txtISM" id="txtISM" disabled="true">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">ISM is required</div>-->
                                        <select class="form-control default-select2" id="txtISM" name="txtISM" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_subcat();">
                                            <option value="0" disabled="disabled" selected="selected" >Select Task ISM</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Task ISM is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="txtISMDesc" id="txtISMDesc" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="auto_assignee">
                                    <div class="form-group">
                                        <label>Weightage</label>
                                        <input type="text" class="form-control" name="ddlPriority" id="ddlPriority" disabled="true">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="auto_assignee">
                                    <div class="form-group">
                                        <label>Assigned To</label>
                                        <input type="text" class="form-control" name="txtAssignedTo" id="txtAssignedTo" disabled="true">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Task Title<span style="color: red;">*</span></label>
                                        <input type="text" id="txtTitle" name="txtTitle" class="form-control" placeholder="Task Title" value="<?php echo $title_task;?>">
                                        <div class="input-error form-control-input" style="color: red; display: none;">Task Title is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Policy Number<span style="color: red;">*</span></label>
                                        <input type="text" id="txtPolicy" name="txtPolicy" class="form-control" placeholder="Policy Number" value="<?php echo $pno ;?>" <? //echo $dis_button; ?> >
                                        <div class="input-error form-control-input" style="color: red; display: none;">Policy Number is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="manual_assignee" style="display: none;">
                                    <div class="form-group">
                                        <label>Assigned To<span style="color: red;">*</span></label><br>
                                        <select class="form-control default-select2" name="usr_asignee" id="usr_asignee" data-live-search="true" data-style="btn-white">
                                            <option selected="selected" value="">Select Assigned To User</option>
                                            <?php $user = $objUser->GetUsers(0); ?>
                                            <?php foreach($user as $users) { ?>
                                                <option value="<? echo $users["id"]; ?>">
                                                    <? echo $users["first_name"] ." ".$users["last_name"]; ?>
                                                </option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Assigned to user is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <textarea type="text" class="form-control" id="txtTaskDesc" name="txtTaskDesc" rows="6" placeholder="Enter Description"></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Description is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </fieldset>

                        <hr>

                        <div class="col-md-12">
                            <div class="col-md-4 form-group">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveTask" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
                                <button type="Reset" class="btn btn-sm btn-success">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

<!-- Upload File Before Task Submition - Start -->
<div class="modal fade" id="ModalComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseComments" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Task</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalform" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="task_num" name="task_num" value="<?php echo($data[0]['task_num']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id="counter_display" name="counter_display" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload1" id="fileupload1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload2" id="fileupload2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload3" id="fileupload3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload4" id="fileupload4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload5" id="fileupload5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDiv">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUpload" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Upload File Before Task Submition - End -->

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

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }

    .select2-container--default default-select2 {
        width: 260px !important;
    }

    #usr_asignee{
        width: 260px !important;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        //masking();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var tid = $('#tid').val();

        if(tid != 0)
        {
            task_cat();
            getisms();
        }

        var counter = 1;
        var getid = 0;

        var message     = '';
        var task_num    = '';

        $(document).on('click', '#btnSaveTask', function () {
            var Form_data = new FormData($('#task')[0]);

            var ddlPriority = $('#ddlPriority').val();
            Form_data.append('ddlPriority', ddlPriority);

            if(validation())
            {
                $("#btnSaveTask").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_task_cat.php",
                    async: true,
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: Form_data,
                    success: function(data) 
                    {
                        //console.log(data);
                        var result = data.split("|");

                        message = result[0];
                        task_num = result[1];

                        if(message == 'success')
                        {
                            $('#ModalComment').modal({backdrop: 'static', keyboard: false});
                            $('#ModalComment').modal('show');
                            $('#task_num').val(result[1]);
                            return false;
                        }
                        else if(data == 'fail')
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });

        $(document).on('click', '#btnFileUplaodDiv', function () {
            if(counter > 4){
                alert("Can not add more.");
            }
            else if(counter == 1){
                $('#SelectFile1').css('display','block');
                counter++;
            }
            else if(counter == 2){
                $('#SelectFile2').css('display','block');
                counter++;
            }
            else if(counter == 3){
                $('#SelectFile3').css('display','block');
                counter++;
            }
            else if(counter == 4){
                $('#SelectFile4').css('display','block');
                counter++;
            }
        });

        $(document).on('click', '#btnFileUpload', function () {
            var formdata = new FormData($('#modalform')[0]);

            $("#btnFileUpload").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_task_cat.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,
                success: function(data)
                {
                    $("#btnFileUpload").button('reset');

                    data = data.trim();
                    //console.log(data);

                    var message = "Task created successfully with Task Id <strong>";
                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success')
                    {
                        $('#ModalComment').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  task_num + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "task_view.php";
                        }, 1000);
                    }
                    else
                    {
                        $('#ModalComment').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        });

        $(document).on('click', '#btnCloseComments', function () {
            $('#ModalComment').modal('hide');
        });

        $('#fileupload1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload1').val('');
            }
        });

        $('#fileupload2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload2').val('');
                return false;
            }
        });

        $('#fileupload3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload3').val('');
                return false;
            }
        });

        $('#fileupload4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload4').val('');
                return false;
            }
        });

        $('#fileupload5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload5').val('');
                return false;
            }
        });
    });

    /* Task Category */
    function task_cat(){
        var task_category = $('#ddlTaskCategory').val();
        var task_subcat   = $('#subcat_id').val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_task_cat.php",
            data:{
                action : "select_task_category",
                id: task_category,
                task_subcat : task_subcat
            },
            async:false

        }).done(function (data) {
            $('#ddlSubCategory').html(data);
        });
    }

    /* Task Subcategory */
    function task_subcat()
    {
        var ism = $('#txtISM').val();
        var task_category = $('#ddlTaskCategory').val();
        var task_subcategory = $('#ddlSubCategory').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_task_cat.php",
            data:
            {
                action: "select_task_subcategory",
                id: task_category,
                id_subcat : task_subcategory,
                id_ism : ism
            }
        }).done(function (data) {
            var str = data.split('|');
            //$('#txtISM').val(str[0]);
            $('#txtISMDesc').val(str[1]);
            $('#txtAssignedTo').val(str[2]);
            $('#task_ism_id').val(str[3]);
            $('#user_id').val(str[4]);
            $('#ddlGroup').val(str[5]);
            $('#txtTitle').val(str[6]);
            $('#op_mode').val(str[7]);
            $('#ddlPriority').val(str[8]);
            
            if(str[7] == "0")
            {
                $("#is_manual").val("1");
                $("#manual_assignee").css("display", "block");
            }
            else
            {
                $("#auto_assignee").css("display", "block");
                $("#manual_assignee").css("display", "none");
            }
        });
    }

    /* Assigned To */
    $(document).on('change','#ddlGroup', function (){
        $('#ddlAssignedTo').empty();
        var group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_user.php",
            data:{
                action: "select_assignedTousers",
                id: group_id
            }
        }).done(function (data) {
            //console.log(data);
            $('#ddlAssignedTo').html(data);
        });
    });

    /* Verified By - NOT USING NOW */
    $(document).on('change','#ddlGroup', function (){
        $('#ddlVerifiedBy').empty();
        var group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_user.php",
            data:{
                action: "select_verifiedByusers",
                id: group_id
            }
        }).done(function (data) {
            //console.log(data);
            $('#ddlVerifiedBy').html(data);
        });
    });

    /* CC Users List - NOT USING NOW */
    $(document).on('change','#ddlGroup', function (){
        $('#ddlCCUsers').empty();
        var group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_user.php",
            data:{
                action: "select_CCusers",
                id: group_id
            }
        }).done(function (data) {
            //console.log(data);
            $('#ddlCCUsers').html(data);
        });
    });

    function validation()
    {
        var is_manual = $("#is_manual").val();
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        if($('#ddlTaskCategory').val() == null) 
        {
            $('#ddlTaskCategory').addClass('error-val');
            $('#ddlTaskCategory').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlTaskCategory').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlTaskCategory').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlTaskCategory').removeClass('error-val');
            $('#ddlTaskCategory').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlTaskCategory').parent().find('.input-error').hide();
        }

        if($('#ddlSubCategory').val() == null) 
        {
            $('#ddlSubCategory').addClass('error-val');
            $('#ddlSubCategory').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSubCategory').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSubCategory').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSubCategory').removeClass('error-val');
            $('#ddlSubCategory').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlSubCategory').parent().find('.input-error').hide();
        }

        if($('#txtISM').val() == '' || $('#txtISM').val() == null) 
        {
            $('#txtISM').addClass('error-val');
            $('#txtISM').parent().find('.input-error').show().css('display', 'inline-block');
            $('#txtISM').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#txtISM').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtISM').removeClass('error-val');
            $('#txtISM').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#txtISM').parent().find('.input-error').hide();
        }

        if($('#txtTitle').val() == 0 || $('#txtTitle').val() == null) 
        {
            $('#txtTitle').addClass('error-val');
            $('#txtTitle').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtTitle').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtTitle').removeClass('error-val');
            $('#txtTitle').parent().find('.input-error').hide();
        }

        if($('#txtPolicy').val() == 0 || $('#txtPolicy').val() == null) 
        {
            $('#txtPolicy').addClass('error-val');
            $('#txtPolicy').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPolicy').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtPolicy').removeClass('error-val');
            $('#txtPolicy').parent().find('.input-error').hide();
        }

        if(is_manual == 1)
        {
            if($('#usr_asignee').val() == '' || $('#usr_asignee').val() == null) 
            {
                $('#usr_asignee').addClass('error-val');
                $('#usr_asignee').parent().find('.input-error').show().css('display', 'inline-block');
                $('#usr_asignee').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#usr_asignee').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#usr_asignee').removeClass('error-val');
                $('#usr_asignee').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#usr_asignee').parent().find('.input-error').hide();
            }
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking()
    {
        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});
        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }

    function getisms()
    {
        var subcat = $('#ddlSubCategory').val();
        var task_category = $('#ddlTaskCategory').val();
        var action = "get_tsk_ism";
        var tid = $('#tid').val();
        var is_main = "1";
        //alert(tid);       
        $("#is_manual").val("0");

        if(tid != 0)
        {
            is_main = "0";
        }
        //alert(is_main);
        $.ajax({
            data: 
            {
                'action':action,
                'subcat':subcat,
                'task_category':task_category,
                'is_main' :is_main
            },
            type: 'POST',
            url: "includes/ajax/action_taskcat.php",
            success: function(data) 
            {
                //data = data.trim();
                //console.log(data);
                $('#txtISM').html(data);
            }
        });
    }
</script>

</body>
</html>
