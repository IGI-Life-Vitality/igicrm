<?php

$page_title = "Complaint Details";
$group_id = "complaint";
$menu_id = "complaint_views";

include('includes/header.php');
include('classes/complaint.php');

$objComplaint = new Complaint();
$is_disabled = "";
$btn_text = "Forward";

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $objComplaint->ReadNotification($id,'complaint',$user_type);
        $data = $objComplaint->GetComplaint($login_id,$id);
        $data_status = $objComplaint->GetComplaintStatus($id);
        //$isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $heading = "Complaint Details";
        $status_id = $data[0]['status_id'];

        if($status_id == 2 || $status_id == 3 || $status_id == 4){
            $is_disabled = "disabled";
            $is_disabled_users = "pointer-events:none;";
        }

        if($status_id == 5){
            $btn_text = "Re-Forward";
        }
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
        <li><a href="javascript:;">Complaint</a></li>
        <li class="active">Complaint Details</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Complaint Details</h1>
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
                    <h4 class="panel-title">Complaint Details</h4>
                </div>
                <div class="panel-body">

                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                        <strong>Success!</strong>
                        Record Saved Successfully!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                        <strong>Error!</strong>
                        Error while saving record, Please try again!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <form class="form-horizontal" autocomplete="off">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Complaint Id</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txtCounter" value="<?php echo($data[0]['complaint_counter']); ?>" placeholder="Id" disabled />
                                <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Complaint Product</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" id="ddlProduct" name="ddlProduct" disabled data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0">Select Product</option>
                                    <?php $products = $objComplaint->GetProducts(0); ?>
                                    <?php foreach($products as $product){ ?>
                                        <option value="<? echo $product["id"]; ?>"<?php echo ($data[0]["complaint_product_id"] == $product["id"] ? "selected='selected'" : ""); ?>><? echo $product["fullname"] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Complaint Type</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" id="ddlType" name="ddlType" disabled data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0">Select Type</option>
                                    <?php $types = $objComplaint->GetComplaintType(0); ?>
                                    <?php foreach($types as $type){ ?>
                                        <option value="<? echo $type["id"]; ?>"<?php echo ($data[0]["complaint_type_id"] == $type["id"] ? "selected='selected'" : ""); ?>><? echo $type["fullname"] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Complaint Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="txtTitle" id="txtTitle" disabled value="<?php echo($data[0]['complaint_title']); ?>" placeholder="Complaint Title"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="txtDescription" id="txtDescription" disabled placeholder="Description" rows="5"><?php echo ($data[0]['complaint_desc'] != '' ? $data[0]['complaint_desc'] : ""); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Department</label>
                            <div class="col-md-6">
                                <select class="form-control selectpicker" id="ddlDepartment" name="ddlDepartment" <? echo ($is_disabled); ?> data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0">Select Department</option>
                                    <?php $departments = $objUser->GetResponserDeparment(0); ?>
                                    <?php foreach($departments as $department){ ?>
                                        <option value="<? echo $department["id"]; ?>"<?php echo ($data[0]["department_id"] == $department["id"] ? "selected='selected'" : ""); ?>><? echo $department["fullname"] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Users</label>
                            <div class="col-md-6" id="divUsers" style="<? echo $is_disabled_users; ?>">

                                <? if($data[0]["user_id"] != ""){ ?>

                                    <select class="multiple-select2 form-control" id="ddlUsers" name="ddlUsers" multiple="multiple">
                                        <option value="0">Select Users</option>
                                        <?php
                                            $users = $objUser->GetUsersByDepartment($data[0]["department_id"]);
                                            $counter = 0;
                                            $users_ids =  explode(",",$data[0]["user_id"]);
                                        ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>" data-email="<? echo $user["email"]; ?>" <?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_id"] ?></option>
                                            <? $counter++; } ?>
                                    </select>

                                <? }else{ ?>
                                    <input type="text" class="form-control" name="ddlUsers" id="ddlUsers" value="">
                                <? }?>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Admin Comments</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="txtComment" id="txtComment" <? echo ($is_disabled); ?> rows="5"><?php echo ($data[0]['comments'] != '' ? $data[0]['comments'] : ""); ?></textarea>
                            </div>
                        </div>


                        <? if($status_id == 3 || $status_id == 4){ ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label-my">Verified Comments</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="txtVerifiedComment" id="txtVerifiedComment" <? echo $status_id == 4 ? "disabled" : ""; ?> rows="5"><?php echo ($data[0]['comments_verified'] != '' ? $data[0]['comments_verified'] : ""); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-info" <? echo $status_id == 4 ? "disabled" : ""; ?> onclick="verified();">Verified</button>
                                </div>
                            </div>

                        <? }else{ ?>

                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-success" <? echo ($is_disabled); ?> onclick="save();"><? echo ($btn_text); ?></button>
                                </div>
                            </div>

                        <? } ?>

                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="index-5">
                <div class="panel-heading">
                    <h4 class="panel-title">Comments</h4>
                </div>
                <div class="panel-body">
                    <div class="height-sm" data-scrollbar="true">
                        <ul class="media-list media-list-with-divider media-messaging">

                            <? foreach($data_status as $row){ ?>
                                <li class="media media-sm">
                                    <a href="javascript:;" class="pull-left">
                                        <img src="assets/img/user-5.jpg" alt="" class="media-object rounded-corner" />
                                    </a>
                                    <div class="media-body">
                                        <h5 class="media-heading"><? echo $row['user_name']; ?></h5>
                                        <p> <b>Updated on: </b><? echo $new_date_format = date('M-d-Y H:i:s', strtotime($row['update_datetime'])); ?></p>
                                        <p> <b>Progress: </b><? echo $row['progress']; ?>%</p>
                                        <p><? echo $row['comments']; ?></p>
                                    </div>
                                </li>
                            <? } ?>

                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

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

    $(document).on('change', '#ddlDepartment', function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_user.php",
            data: { 'action': 'select_user', id: id }
        }).done(function (data) {
            console.log(data);
            $('#txtUsers').hide();
            $('#divUsers').html(data);
            $("#ddlUsers").select2();
        });
    });

    function save() {

        var action = "forward";
        var complaint_id = $('#txtId').val();
        var department = $('#ddlDepartment').val();
        var users = $('#ddlUsers').val();
        //var email = $('#ddlUsers option:selected').attr('data-email');
        var comments = $('#txtComment').val();
        //console.log(complaint_id);
        //return false;

        if(validation()){

            $.ajax({
                data: {
                    'complaint_id':complaint_id,
                    'department':department,
                    'users':users,
                    'comments':comments,
                    'action':action
                },
                type: 'POST',
                url: "includes/ajax/action_complaint.php",
                success: function(data) {
                    data = data.trim();
                    //alert(data);
                    console.log(data);
                    if(data == 'success'){
                        $('html, body').animate({scrollTop : 0}, 600);
                        $('#divSuccess').show();
                        clear_values();
                    }else if(data == 'fail'){
                        $('#divError').show();
                    }
                    setTimeout(function () { window.location.reload(); }, 8000);
                }
            });

        }

    }

    function verified() {

        var action = "verified";
        var complaint_id = $('#txtId').val();
        var comments = $('#txtVerifiedComment').val();

        if(comments != ''){
            $.ajax({
                data: {
                    'complaint_id':complaint_id,
                    'comments':comments,
                    'action':action
                },
                type: 'POST',
                url: "includes/ajax/action_complaint.php",
                success: function(data) {

                    data = data.trim();
                    console.log(data);

                    if(data == 'success'){
                        $('#notify_success_insert').show();
                    }else if(data == 'fail'){
                        $('#notify_error_insert').show();
                    }

                    setTimeout(function () {
                        $('.NotificationDiv').fadeOut('fast');
                        window.location.reload();
                    }, 3000);
                }
            });
        }

    }

    function clear_values(){
        $('#ddlType option[value=0]').attr('selected','selected');
        $('#txtTitle').val('');
        $('#txtDescription').val('');
    }

    function validation(){

        var hasFocus = false;
        var errCount = 0;

        var options = $('#ddlUsers > option:selected');
        /*if(options.length == 0){
         alert('no value selected');
         return false;
         }*/


        if($('#ddlDepartment').val() == '0') {

            $('#ddlDepartment').parents('.control-group').addClass('error');
            $('#ddlDepartment').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlDepartment').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlDepartment').parents('.control-group').removeClass('error');
            //$('#ddlDepartment').parents('.control-group').addClass('success');
            $('#ddlDepartment').parent().find('.input-error').hide();
        }

        if(options.length == 0) {

            $('#ddlUsers').parents('.control-group').addClass('error');
            $('#ddlUsers').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlUsers').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlUsers').parents('.control-group').removeClass('error');
            //$('#ddlUsers').parents('.control-group').addClass('success');
            $('#ddlUsers').parent().find('.input-error').hide();
        }


        if (errCount > 0)
            return false;
        else
            return true;
    }
</script>

</body>
</html>

