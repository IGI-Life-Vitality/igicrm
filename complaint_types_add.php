<?php

$page_title = "Complaint Type";
$permission_type = "create";
$module_id = "4";
$parent_id ="19";
$menu_id = "complaint_types_add";

include('includes/header.php');
include('classes/complaint.php');

$objComplaint = new Complaint();
$users = $objUser->GetUsers(0);


if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data = $objComplaint->GetComplaintTypeList($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked" : "";
        $operation_mode = ($data[0]['operation_mode'] == 0) ? "checked='checked'" : "";
        $heading = "Edit Complaint Type";
        $display_none = "display: block";
        $isdisable = ($data[0]['operation_mode'] == 0) ? "disabled='disabled'" : "";
    }
    else{
        $heading = "Add Complaint Type";
        $isactive = "checked";
        $display_none = "display: none";
        $isdisable = "";

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
<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>
<!-- ================== END PAGE LEVEL STYLE ================== -->

<style type="text/css">
    .assigned_to_user{
        font-size: 14px;
        font-weight: bold;
        margin-top: 8px;
    }
</style>

<!-- begin #content -->
<div id="content" class="content">

    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Complaint</a></li>
        <li class="active">Complaint Types</li>
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
                    <h4 class="panel-title">Complaint Types</h4>
                </div>
                <div class="panel-body">
                <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                </div>
                <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                    <strong>Error!</strong>
                    Error while saving record, Please try again!
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>
                    <form class="form-horizontal" autocomplete="off">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['complaint_id']); ?>" placeholder="Id" disabled />
                                <input type="hidden" name="cmp_id" id="cmp_id" value="<?php echo $data[0]['user_id'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Department<span style="color: red;">*</span></label>
                            <div class="col-md-4">
                                <select class="default-select2 form-control" id="group_id" name="group_id" <?php echo $isdisable; ?> onchange="asign_to();">
                                    <option value="" selected="selected" disabled>Select Department</option>
                                    <?php $groups = $objUser->GetGroups(); ?>
                                    <?php foreach($groups as $group){ ?>
                                        <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['group_id'] == $group["id"] ? "selected='selected'" : ""?>><? echo $group["primary_name"] ?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Department is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Complaint Type</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($data[0]['fullname']); ?>" placeholder="Complaint Type"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Turn Around Time</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtTAT" id="txtTAT" onkeypress="return validateNumbers(event)" value="<?php echo($data[0]['tat']); ?>" placeholder="Turn Around Time" />
                                <p style="font-size: 12px">Note:  Enter values in Days.</p>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Turn Around Time is required</div>
                            </div>
                        </div>      
                <div class="form-group">
                    <label class="col-md-2 control-label-my">Weightage</label>
                    <div class="col-md-4">
                    <select class="form-control default-select2" id="ddlPriority" name="ddlPriority" <?php echo $disabled ?>>
                        <?php $priorities = $objComplaint->GetPriority(); ?>
                        <?php foreach($priorities as $priority) { ?>
                            <option value="<? echo $priority["id"]; ?>">
                                <? echo $priority["priority"]; ?>    
                            </option>
                        <? } ?>
                    </select>
                    <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                </div>
                </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">IsActive</label>
                            <div class="col-md-4">
                                <div class="checkbox checkbox-css checkbox-success">
                                    <input type="checkbox" id="chkIsActive" <? echo ($isactive);?> />
                                    <label for="chkIsActive">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Operation Mode</label>
                            <div class="col-md-6">
                                <div class="radio radio-css radio-inline radio-inverse">
                                    <input type="radio" name="radInlineCss2" id="radio_inline_css_6" value="1" checked="">
                                    <label for="radio_inline_css_6">
                                        Auto
                                    </label>
                                </div>
                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="radInlineCss2" id="radio_inline_css_7" value="0" <? echo $operation_mode; ?>>
                                    <label for="radio_inline_css_7">
                                        Manual
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Assign To</label>
                            <div class="col-md-4">
                                <select class="default-select2 form-control" id="ddlAssignee" name="ddlAssignee" <?php echo $isdisable; ?>>
                                </select>

				<div class="input-error form-control-input" style="color: Red; display: none;">User is required</div>			
                            </div>

			    <p class="assigned_to_user">
                                <?php 
                                    if($id > 0) 
                                    {
                                        $assigned_to_user_id = $data[0]['user_id'];
                                        $assigned_to_user = $objComplaint->GetUsersById($assigned_to_user_id);
                                        print_r($assigned_to_user['user_name']);
                                    } 
                                ?>
                            </p>				
                        </div>

                        <input type="hidden" class="form-control" id="txtComplaintEscalationId" value="<?php echo $data[0]['id']; ?>" />

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod1" name="ddlTimePeriod1" data-placeholder="Select Time Period">
                                            <option value="0" disabled="disabled">Select Time Period</option>
                                            <?php for($i = 3; $i <= 7; $i += 3) { ?>
                                                <option value="<? echo $i ?>"<?php echo ($data[0]["escalation_time1"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?> Days</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Level 1</label>
                                    <div>
                                        <select class="multiple-select2 form-control" id="ddlLevel1" name="ddlLevel1" multiple="multiple">
                                            <?php
                                                $counter = 0;
                                                $users_ids =  explode(",",$data[0]["level1"]);
                                            ?>
                                            <?php foreach($users as $user){ ?>
                                                <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                                                <? $counter++; } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv" class="col-md-12" style="<?php echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod2" name="ddlTimePeriod2" data-placeholder="Select Time Period">
                                            <option value="0" disabled="disabled">Select Time Period</option>
                                            <?php for($i = 3; $i <= 7; $i += 3) { ?>
                                                <option value="<? echo $i ?>"<?php echo ($data[0]["escalation_time2"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?> Days</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Level 2</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel2" name="ddlLevel2" multiple="multiple" data-placeholder="Select">
                                        <?php
                                            $counter = 0;
                                            $users_ids =  explode(",",$data[0]["level2"]);
                                        ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                                            <? $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv1" class="col-md-12" style="<?php echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod3" name="ddlTimePeriod3" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php for($i = 3; $i <= 7; $i += 3) { ?>
                                                <option value="<? echo $i ?>"<?php echo ($data[0]["escalation_time3"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?> Days</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label>Level 3</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel3" name="ddlLevel3" multiple="multiple" data-placeholder="Select">
                                        <?php
                                            $counter = 0;
                                            $users_ids =  explode(",",$data[0]["level3"]);
                                        ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                                            <? $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv2" class="col-md-12" style="<?php echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod4" name="ddlTimePeriod4" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php for($i = 3; $i <= 7; $i += 3) { ?>
                                                <option value="<? echo $i ?>"<?php echo ($data[0]["escalation_time4"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?> Days</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label>Level 4</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel4" name="ddlLevel4" multiple="multiple" data-placeholder="Select">
                                        <?php
                                            $counter = 0;
                                            $users_ids =  explode(",",$data[0]["level4"]);
                                        ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                                            <? $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv3" class="col-md-12" style="<?php echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod5" name="ddlTimePeriod5" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php for($i = 3; $i <= 7; $i += 3) { ?>
                                                <option value="<? echo $i ?>"<?php echo ($data[0]["escalation_time5"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?> Days</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group" style="display: none;">
                                    <label class="">Level 5</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel5" name="ddlLevel5" multiple="multiple" data-placeholder="Select">
                                        <?php
                                        $counter = 0;
                                        $users_ids =  explode(",",$data[0]["level5"]);
                                        ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                                            <? $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label>
                                <a class="btn btn-icon btn-circle btn-success" id="btnAddDiv">
                                    <i class="fa fa fa-plus-square"></i></a>
                            </label>
                        </div>

                        <div class="col-md-4">
                            <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintType" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
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

        $('input[type=radio][name=radInlineCss2]').change(function() {
            if (this.value == '1') {
                $("#ddlAssignee").attr('disabled',false);
            }
            else if (this.value == '0') {
                $("#ddlAssignee").attr('disabled',true);
            }
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {
        asign_to();
        var counter = 1;

        $(document).on('click','#btnAddDiv', function (){
            if(counter > 1){
                alert("Can not add more.")
            }
            else if (counter == 1){
                $('#DynamicDiv').css('display','block');
                $('#ddlLevel2').select2();

                counter++;
            }
            else if (counter == 2){
                $('#DynamicDiv1').css('display','block');
                $('#ddlLevel3').select2();
                counter++;
            }
            else if (counter == 3){
                $('#DynamicDiv2').css('display','block');
                $('#ddlLevel4').select2();
                counter++;
            }
            else if (counter == 4){
                $('#DynamicDiv3').css('display','block');
                $('#ddlLevel5').select2();

                counter++;
            }
        });

        $(document).on('click', '#btnSaveComplaintType', function () {

            var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save_type" : "edit_type";
            var EscalationId = $('#txtComplaintEscalationId').val();
            var name = $('#txtName').val();
            var tat = $('#txtTAT').val();
            //var product_id = $('#ddlProduct').val();
            //var product_category = $('#ddlProductCategory').val();
            var time_period1 = $('#ddlTimePeriod1').val();
            var level1 = $('#ddlLevel1').val();
            var time_period2 = $('#ddlTimePeriod2').val();
            var level2 = $('#ddlLevel2').val();
            var time_period3 = $('#ddlTimePeriod3').val();
            var level3 = $('#ddlLevel3').val();
            var time_period4 = $('#ddlTimePeriod4').val();
            var level4 = $('#ddlLevel4').val();
            var time_period5 = $('#ddlTimePeriod5').val();
            var level5 = $('#ddlLevel5').val();
            var is_active = $('#chkIsActive').is(":checked") ? 1 : 0;
            var mode = $('input[name=radInlineCss2]:checked').val();
            var depart = $('#group_id').val();
            var priority = $('#ddlPriority').val();
            var user_id = (mode == 1) ? $("#ddlAssignee").val() : 0;

          

            if(validation()){

                $("#btnSaveComplaintType").button('loading');

                $.ajax({
                    data: {
                        'action'            : action,
                        'id'                : id,
                        'escalation_id'     : EscalationId,
                        'name'              : name,
                        'tat'               : tat,
                        'priority'          : priority,
                        'user_id'           : user_id,
                        'group_id'          : depart,
                        'time_period1'      : time_period1,
                        'level1'            : level1,
                        'time_period2'      : time_period2,
                        'level2'            : level2,
                        'time_period3'      : time_period3,
                        'level3'            : level3,
                        'time_period4'      : time_period4,
                        'level4'            : level4,
                        'time_period5'      : time_period5,
                        'level5'            : level5,
                        'is_active'         : is_active,
                        'mode'              : mode
                    },
                    type: 'POST',
                    url: "includes/ajax/action_complaint_type.php",
                    success: function(data) {

                        $("#btnSaveComplaintType").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);
                        $('html, body').animate({scrollTop: 0}, 600);
                        if(data == 'success'){
                            clear_values();
                           $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () {
                                window.location.href = "complaint_types.php"
                            }, 2000);
                        }else{
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });

            }
        });

    });
function asign_to(){
    var depart = $('#group_id').val();
    var cmp_id = $('#cmp_id').val();
    //alert(depart);
    //alert(cmp_id);
    //return false;
     $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint_type.php",
                data:{
                    'action' : "select_assign_to",
                    'group_id': depart,
                    'cmp_id'  : cmp_id
                }
            }).done(function (data) {
                //alert(data);
                $('#ddlAssignee').html(data);
                //$('#subism').CSS(data);
                $("#ddlAssignee").css("display", "block");
            });

}
    function clear_values(){
        $('#txtId').val('');
        $('#txtName').val('');
        $('#txtTAT').val('');

        $('#ddlLevel1').empty();
        $('#ddlLevel2').empty();
        $('#ddlLevel3').empty();
        $('#ddlLevel4').empty();
        $('#ddlLevel5').empty();
        $("#ddlAssignee").empty();
        $('#ddlTimePeriod1').empty();
        $('#ddlTimePeriod2').empty();
        $('#ddlTimePeriod3').empty();
        $('#ddlTimePeriod4').empty();
        $('#ddlTimePeriod5').empty();

        $('#ddlProduct').empty();
        $('#ddlProductCategory').empty();

    }

    function validation(){

        var hasFocus = false;
        var errCount = 0;
        var dept = $('#group_id').val();
        var user = $('#ddlAssignee').val();
        var mode = $('input[name=radInlineCss2]:checked').val();

        if($('#txtName').val() == '') {

            $('#txtName').addClass('error-val');
            $('#txtName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtName').parent().find('.input-error').hide();
        }

        if($('#txtTAT').val() == '') {

            $('#txtTAT').addClass('error-val');
            $('#txtTAT').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtTAT').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtTAT').removeClass('error-val');
            $('#txtTAT').parent().find('.input-error').hide();
        }

        if( dept == 'null' || dept == null) {

            $('#group_id').addClass('error-val');
            $('#group_id').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#group_id').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#group_id').removeClass('error-val');
            $('#group_id').parent().find('.input-error').hide();
        }

        if(user == 'null' || user == null && mode == '1') {

            $('#ddlAssignee').addClass('error-val');
            $('#ddlAssignee').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlAssignee').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlAssignee').removeClass('error-val');
            $('#ddlAssignee').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }



</script>

</body>
</html>

