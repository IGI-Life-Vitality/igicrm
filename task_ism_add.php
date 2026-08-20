<?php
    $page_title      = "Add ISM";
    $permission_type = "create";
    $module_id       = "33";
    $parent_id       = "26";
    $menu_id         = "task_ism_add";

    include('includes/header.php');
    include('classes/taskcat.php');
    include('classes/task.php');
    //include('classes/complaint.php');

    $objTask    = new Task();
    $objTaskcat = new Taskcat();
    //$objComplaint = new Complaint();

    $users           = $objUser->GetUsers(0);
    $task_categories = $objTaskcat->GetTaskCategory();
    //$task_isms     = $objTaskcat->GetAllIsms();

    //echo $task_categories;
    //print_r($task_isms);

    if(isset($_GET))
    {
        $id  = isset($_GET['id'])?$_GET['id']:0;

        $heading = "";
        $isactive = "";

        if($id > 0)
        {
            $data = $objTaskcat->GetIsamList($id);
            $isactive = $data[0]['isactive'] == 1 ? "checked" : "";
            $operation_mode = ($data[0]['operation_mode'] == 0) ? "checked='checked'" : "";
            $heading = "Edit ISM";
            $display_none = "display: block";
            $isdisable = ($data[0]['operation_mode'] == 0) ? "disabled='disabled'" : "";
        }
        else
        {
            $heading = "Add ISM";
            $isactive = "checked";
            $display_none = "display: none";
            $isdisable = "";
        }
    }
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
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
        <li><a href="javascript:;">Task Management</a></li>
        <li class="active"><? echo $heading; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

    <?php 
        /*echo "<pre>";
            print_r($data[0]);
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
                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;"></div>

                    <form class="form-horizontal" autocomplete="off">
                        <div class="form-group" style="display: none">
                            <label class="col-md-2 control-label-my">ID</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['isam_id']); ?>" placeholder="ID" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2">Department Name<span style="color: red;">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName" data-placeholder="Select Department Name" onchange="get_ownership_list();">
                                    <option value="" selected="selected" disabled>Select Department</option>
                                   <?php $groups = $objUser->GetGroups(); ?>
                                    <?php foreach($groups as $group) { ?>
                                        <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['department_id'] == $group["id"] ? "selected='selected'" : ""?>><? echo $group["primary_name"];?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Department is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Task Category<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlTaskCategory" name="ddlTaskCategory" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option selected="selected" value="" disabled="disabled">Select Category</option>
                                    <?php //$task_categories = $objTaskcat->GetTaskCategory();  ?>
                                    <?php foreach($task_categories as $task_category) { ?>
                                        <option value="<? echo $task_category["id"]; ?>"<?php echo ($data[0]["task_category_id"] == $task_category["id"] ? "selected='selected'" : ""); ?>><? echo $task_category["fullname"] ?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Category is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Sub Category<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <?php if($data[0]['isam_id'] > 0) { ?>
                                    <select class="form-control default-select2" id="ddlSubCat" name="ddlSubCat" data-placeholder="Select Product" onchange="getisms();">
                                        <option selected="selected" value="" disabled="disabled">Select Subcategory</option>
                                        <?php $subcats = $objTaskcat->GetSubcategoriesActive(0); ?>
                                        <?php foreach($subcats as $subcat){ ?>
                                            <option value="<? echo $subcat["id"]; ?>" <?php echo ($data[0]["sub_cat_id"] == $subcat["id"] ? "selected='selected'" : ""); ?>><? echo $subcat["fullname"] ?></option>
                                        <? } ?>
                                    </select>
                                <?php } else { ?>
                                     <select class="form-control default-select2" id="ddlSubCat" name="ddlSubCat" data-placeholder="Select Subcategory" onchange="getisms();">
                                    </select> 
                                <?php } ?>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Subcategory is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">ISM<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($data[0]['fullname']); ?>" placeholder="Enter ISM"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">ISM is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">ISM Description<span style="color: red;">*</span></label>
                            <div class="col-md-4">
                                <textarea type="text" class="form-control" id="txtIsmDesc" name="txtIsmDesc" rows="4" placeholder="Enter ISM Description"><?php echo($data[0]['desc']); ?></textarea>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Description is required</div>
                             </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Turn Around Time (In Days)<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtTAT" id="txtTAT" onkeypress="return validateNumbers(event)" value="<?php echo($data[0]['tat']); ?>" placeholder="Enter TAT in Days" />
                                <!-- <p style="font-size: 12px">Note:  Enter values in hours.</p> -->
                                <div class="input-error form-control-input" style="color: Red; display: none;">TAT is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my" >Weightage<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlPriority" name="ddlPriority" <?php echo $disabled ?>>
                                    <?php $priorities = $objTask->GetPriority(); ?>
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
                            <label class="col-md-2 control-label-my">Ownership<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <?php if($data[0]['isam_id'] > 0) { ?>
                                    <!-- <select class="form-control default-select2" id="ddlOwnership" data-placeholder="Select Ownership" name="ddlOwnership" <?php //echo $disabled ?>>
                                        <?php //$department_id = $data[0]['department_id']; ?>
                                        <?php //$ownerships = $objTaskcat->GetOwnership($department_id); ?>
                                        <?php //foreach($ownerships as $ownership) { ?>
                                            <option value="<? //echo $ownership["id"]; ?>" <?php //echo ($data[0]["ownership"] == $ownership["id"] ? "selected='selected'" : ""); ?>>
                                                <? //echo $ownership["fullname"]; ?>    
                                            </option>
                                        <? //} ?>
                                    </select> -->
                                    <input type="text" class="form-control" name="ddlOwnership" id="ddlOwnership" value="<?php echo($data[0]['ownership']); ?>" placeholder="Enter Ownership" />
                                <?php } else { ?>
                                    <!-- <select class="form-control default-select2" id="ddlOwnership" name="ddlOwnership"></select> -->
                                    <input type="text" class="form-control" name="ddlOwnership" id="ddlOwnership" value="<?php echo($data[0]['ownership']); ?>" placeholder="Enter Ownership" />
                                <?php } ?>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Ownership is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Avg. Minutes Per Activity<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtMinutesPerActivity" id="txtMinutesPerActivity" value="<?php echo($data[0]['minutes_activity']); ?>" placeholder="Enter Minutes Per Activity" />
                                <div class="input-error form-control-input" style="color: Red; display: none;">Minutes Per Activity is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">SubTask ISM</label>
                            <div class="col-md-4">
                                <?php if($data[0]['isam_id'] > 0){?>
                                <select class="form-control default-select2" id="ddlSubTaskIsm" name="ddlSubTaskIsm" data-size="10" data-live-search="true" data-style="btn-white" onchange="desc(1);" multiple="multiple">
                                    <!-- <option disabled="disabled" selected="selected">Select SubTask ISM</option> -->
                                    <?php 
                                    $counter      = 0;
                                    $subtsk_isms = explode(",", $data[0]["sub_subtask_ism_id"]); 
                                    $task_ismss = $objTaskcat->GetIsmss($data[0]["sub_cat_id"],$data[0]["task_category_id"]); ?>
                                    <?php foreach($task_ismss as $tsk_ism){ ?>
                                        <option value="<? echo $tsk_ism["id"]; ?>"<?php echo ($subtsk_isms[$counter] == $tsk_ism["id"] ? "selected='selected'" : $counter--); ?>><? echo $tsk_ism["fullname"] ?></option>
                                    <? $counter++;} ?>
                                </select>
                                <?php }else{?>
                                       <select class="form-control default-select2" id="ddlSubTaskIsm" name="ddlSubTaskIsm" data-size="10" data-live-search="true" data-style="btn-white" onchange="desc(1);" multiple="multiple">

                                <?php }?>
                            </div>
                        </div>

                        <div class="form-group" id="subism" style="display: none">
                            <label class="col-md-2 control-label-my">Sub Task ISM Description<span style="color: red;">*</span></label>
                            <div class="col-md-4" style="display: none">
                                <textarea style="display: none" type="text" class="form-control" id="subIsmDesc" name="subIsmDesc" rows="4" placeholder="Enter Description" disabled=" disabled"></textarea>
                             </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">OnClosed Task ISM</label>
                            <div class="col-md-4">
                                <?php if($data[0]['isam_id'] > 0){?>
                                    <select class="form-control default-select2" id="ddlClosedTaskIsm" name="ddlClosedTaskIsm" data-size="10" data-live-search="true" data-style="btn-white" onchange="desc(0);">
                                    <option disabled="disabled" selected="selected">Select OnClosed Task ISM</option>

                                    <?php $task_ismss = $objTaskcat->GetIsmss($data[0]["sub_cat_id"],$data[0]["task_category_id"]);  ?>
                                    <?php foreach($task_ismss as $task_ism){ ?>
                                        <option value="<? echo $task_ism["id"]; ?>"<?php echo ($data[0]["onclose_subtask_ism_id"] == $task_ism["id"] ? "selected='selected'" : ""); ?>><? echo $task_ism["fullname"] ?></option> 
                                    <? } ?>
                                </select>

                                <?php }else{?>
                                       <select class="form-control default-select2" id="ddlClosedTaskIsm" name="ddlClosedTaskIsm" data-size="10" data-live-search="true" data-style="btn-white" onchange="desc(0);">
                                    <option disabled="disabled" selected="selected">Select OnClosed Task ISM</option>
                                </select>
                                <?php }?>
                                
                            </div>
                        </div>

                        <div class="form-group" id="closeism" style="display: none;">
                            <label class="col-md-2 control-label-my">OnClosed Task ISM Description<span style="color: red;">*</span></label>
                            <div class="col-md-4">
                                <textarea type="text" class="form-control" id="closedIsmDesc" name="closedIsmDesc" rows="4" placeholder="Enter Description" disabled=" disabled"></textarea>
                             </div>
                        </div>

                        <!--<div class="form-group">
                            <label class="col-md-2 control-label-my">Dependent Task ISM</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlDependentTaskIsm" name="ddlDependentTaskIsm" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option disabled="disabled" selected="selected">Select Dependent Task ISM </option>
                                    <?php //$task_categories = $objTaskcat->GetTaskCategory();  ?>
                                    <?php //foreach($task_isms as $task_ism){ ?>
                                        <option value="<?// echo $task_ism["id"]; ?>"<?php// echo ($data[0]["dependent_task_id"] == $task_ism["id"] ? "selected='selected'" : ""); ?>><?// echo $task_ism["fullname"] ?></option>
                                    <?// } ?>
                                </select>
                            </div>
                        </div> -->

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
                            <label class="col-md-2 control-label-my">Assigned To<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <select class="default-select2 form-control" id="ddlAssignedTo" name="ddlAssignedTo" <?php echo $isdisable; ?>>
                                    <option value="" selected="selected">Select User</option>
                                    <?php $users = $objUser->GetUsers(); ?>
                                    <?php foreach($users as $user){ ?>
                                        <option value="<? echo $user["id"]; ?>" <?php echo $data[0]['user_id'] == $user["id"] ? "selected='selected'" : ""?>><? echo $user["first_name"] ." ".$user["last_name"]?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">User is required</div>
                            </div>
                        </div>

                        <!--<input type="hidden" class="form-control" id="txtComplaintEscalationId" value="<?php //echo $data[0]['id']; ?>" />

                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod1" name="ddlTimePeriod1" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php //for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php//echo ($data[0]["escalation_time1"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
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
                                                //$counter = 0;
                                                //$users_ids =  explode(",",$data[0]["level1"]);
                                            ?>
                                            <?php //foreach($users as $user){ ?>
                                                <option value="<? //echo $user["id"]; ?>"<?php //echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? //echo $user["user_name"] ?></option>
                                                <? //$counter++; } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv" class="col-md-12" style="<?php //echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod2" name="ddlTimePeriod2" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php //for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php //echo ($data[0]["escalation_time2"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
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
                                            //$counter = 0;
                                            //$users_ids =  explode(",",$data[0]["level2"]);
                                        ?>
                                        <?php //foreach($users as $user){ ?>
                                            <option value="<? //echo $user["id"]; ?>"<?php //echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? //echo $user["user_name"] ?></option>
                                            <? //$counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv1" class="col-md-12" style="<?php //echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod3" name="ddlTimePeriod3" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php //for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php //echo ($data[0]["escalation_time3"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Level 3</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel3" name="ddlLevel3" multiple="multiple" data-placeholder="Select">
                                        <?php
                                            //$counter = 0;
                                           ///$users_ids =  explode(",",$data[0]["level3"]);
                                        ?>
                                        <?php //foreach($users as $user){ ?>
                                            <option value="<?// echo $user["id"]; ?>"<?php// echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? //echo $user["user_name"] ?></option>
                                            <?// $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv2" class="col-md-12" style="<?php //echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod4" name="ddlTimePeriod4" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php //for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php// echo ($data[0]["escalation_time4"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Level 4</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel4" name="ddlLevel4" multiple="multiple" data-placeholder="Select">
                                        <?php
                                            //$counter = 0;
                                            //$users_ids =  explode(",",$data[0]["level4"]);
                                        ?>
                                        <?php// foreach($users as $user){ ?>
                                            <option value="<?// echo $user["id"]; ?>"<?php// echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><?// echo $user["user_name"] ?></option>
                                            <?// $counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="DynamicDiv3" class="col-md-12" style="<?php //echo $display_none; ?>">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Escalation Time Period</label>
                                    <div class="">
                                        <select class="form-control" id="ddlTimePeriod5" name="ddlTimePeriod5" data-placeholder="Select Time Period">
                                            <option value="0">Select Time Period</option>
                                            <?php //for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php //echo ($data[0]["escalation_time5"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="">Level 5</label>
                                    <select class="multiple-select2 form-control" id="ddlLevel5" name="ddlLevel5" multiple="multiple" data-placeholder="Select">
                                        <?php
                                        //$counter = 0;
                                       // $users_ids =  explode(",",$data[0]["level5"]);
                                        ?>
                                        <?php //foreach($users as $user){ ?>
                                            <option value="<? //echo $user["id"]; ?>"<?php //echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? //echo $user["user_name"] ?></option>
                                            <? //$counter++; } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label>
                                <a class="btn btn-icon btn-circle btn-success" id="btnAddDiv">
                                    <i class="fa fa fa-plus-square"></i></a>
                            </label>
                        </div> -->
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label-my"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveISM" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>

                                <!-- <button type="reset" class="btn btn-sm btn-primary">Reset</button> -->
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
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();

        $('input[type=radio][name=radInlineCss2]').change(function() {
            if (this.value == '1') 
            {
                $("#ddlAssignedTo").attr('disabled',false);
            }
            else if (this.value == '0') 
            {
                $("#ddlAssignedTo").attr('disabled',true);
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        //getisms();
        var counter = 1;

        $(document).on('click','#btnAddDiv', function (){
            if(counter > 4)
            {
                alert("Can not add more.")
            }
            else if (counter == 1)
            {
                $('#DynamicDiv').css('display','block');
                $('#ddlLevel2').select2();

                counter++;
            }
            else if (counter == 2)
            {
                $('#DynamicDiv1').css('display','block');
                $('#ddlLevel3').select2();
                counter++;
            }
            else if (counter == 3)
            {
                $('#DynamicDiv2').css('display','block');
                $('#ddlLevel4').select2();
                counter++;
            }
            else if (counter == 4)
            {
                $('#DynamicDiv3').css('display','block');
                $('#ddlLevel5').select2();

                counter++;
            }
        });

        $("#ddlTaskCategory").change(function () {
            var task_category = $(this).val();
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_taskcat.php",
                data:
                {
                    action : "select_subcat",
                    id: task_category
                }
            }).done(function (data) {
                //alert(data);
                $('#ddlSubCat').html(data);
            });
        });

        $(document).on('click', '#btnSaveISM', function () {
            var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save_ism" : "edit_ism";
            var fullname = $('#txtName').val();
            var tat = $('#txtTAT').val();
            var subcat = $('#ddlSubCat').val();
            var task_category = $('#ddlTaskCategory').val();
            var sub_task_ism = $('#ddlSubTaskIsm').val();
            var onclose_task_ism = $('#ddlClosedTaskIsm').val();
            var depn_task_ism = $('#ddlDependentTaskIsm').val();
            var desc = $('#txtIsmDesc').val();
            var isactive = $('#chkIsActive').is(":checked") ? 1 : 0;
            var mode = $('input[name=radInlineCss2]:checked').val();
            var user_id = (mode == 1) ? $("#ddlAssignedTo").val() : 0;
            var pri = $('#ddlPriority').val();
            var ddlDepartmentName = $('#ddlDepartmentName').val();
            var ddlOwnership =  $('#ddlOwnership').val();
            var txtMinutesPerActivity = $('#txtMinutesPerActivity').val();

            //alert(ddlOwnership); return false;

            // if(sub_task_ism == null)
            //{
            //     sub_task_ism = '';
            //}
            //alert(isactive);
            //alert(pri);
            ///return false;

            if(validation())
            {
                $("#btnSaveISM").button('loading');

                $.ajax({
                    data: 
                    {
                        'action'            : action,
                        'id'                : id,
                        'fullname'          : fullname,
                        'tat'               : tat,
                        'subcat'            : subcat,
                        'task_category'     : task_category,
                        'user_id'           : user_id,
                        'desc'              : desc,
                        'ddlOwnership'      : ddlOwnership,
                        'isactive'          : isactive,
                        'sub_task_ism'      : sub_task_ism,
                        'onclosed_task_ism' : onclose_task_ism,
                        'depn_task_ism'     : depn_task_ism,
                        'mode'              : mode,
                        'pri'               : pri,
                        'ddlDepartmentName' : ddlDepartmentName,
                        'txtMinutesPerActivity' : txtMinutesPerActivity
                    },
                    type: 'POST',
                    url: "includes/ajax/action_taskcat.php",
                    success: function(data) 
                    {
                        $("#btnSaveISM").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);
                        $('html, body').animate({scrollTop: 0}, 600);

                        if(data == 'success')
                        {
                            clear_values();

                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });

                            setTimeout(function () {
                                window.location.href = "task_ism_types.php"
                            }, 2000);
                        }
                        else
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
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
        $('#txtName').val('');
        $('#txtTAT').val('');
        $('#txtMinutesPerActivity').val('');
        $('#ddlOwnership').val('');

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
        $('#ddlDepartmentName').empty();
        $('#ddlOwnership').empty();
    }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;
        var mode = $('input[name=radInlineCss2]:checked').val();

        // For Department OK
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

        // For Task Category OK
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
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#ddlTaskCategory').parent().find('.input-error').hide();
        }

        // For SubCategory OK
        if($('#ddlSubCat').val() == null ) 
        {
            $('#ddlSubCat').addClass('error-val');
            $('#ddlSubCat').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSubCat').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSubCat').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSubCat').removeClass('error-val');
            $('#ddlSubCat').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlSubCat').parent().find('.input-error').hide();
        }

        // For ISM OK
        if($('#txtName').val() == '') 
        {
            $('#txtName').addClass('error-val');
            $('#txtName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtName').parent().find('.input-error').hide();
        }

        // For ISM Description OK
        if($('#txtIsmDesc').val() == '') 
        {
            $('#txtIsmDesc').addClass('error-val');
            $('#txtIsmDesc').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtIsmDesc').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtIsmDesc').removeClass('error-val');
            $('#txtIsmDesc').parent().find('.input-error').hide();
        }

        // For TAT OK
        if($('#txtTAT').val() == '') 
        {
            $('#txtTAT').addClass('error-val');
            $('#txtTAT').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtTAT').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtTAT').removeClass('error-val');
            $('#txtTAT').parent().find('.input-error').hide();
        }

        // For Ownership For Dropdown
        /*if($('#ddlOwnership').val() == null) 
        {
            $('#ddlOwnership').addClass('error-val');
            $('#ddlOwnership').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlOwnership').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlOwnership').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlOwnership').removeClass('error-val');
            $('#ddlOwnership').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlOwnership').parents('.control-group').addClass('success');
            $('#ddlOwnership').parent().find('.input-error').hide();
        }*/

        // For Ownership OK
        if($('#ddlOwnership').val() == '') 
        {
            $('#ddlOwnership').addClass('error-val');
            $('#ddlOwnership').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#ddlOwnership').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlOwnership').removeClass('error-val');
            $('#ddlOwnership').parent().find('.input-error').hide();
        }

        if($('#txtMinutesPerActivity').val() == '') 
        {
            $('#txtMinutesPerActivity').addClass('error-val');
            $('#txtMinutesPerActivity').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtMinutesPerActivity').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else
        {
            $('#txtMinutesPerActivity').removeClass('error-val');
            $('#txtMinutesPerActivity').parent().find('.input-error').hide();
        }

        // For AssignedTo OK
        /*if($('#ddlAssignedTo').val() == null || $('#ddlAssignedTo').val() == '') 
        {
            $('#ddlAssignedTo').addClass('error-val');
            $('#ddlAssignedTo').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlAssignedTo').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlAssignedTo').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlAssignedTo').removeClass('error-val');
            $('#ddlAssignedTo').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlAssignedTo').parents('.control-group').addClass('success');
            $('#ddlAssignedTo').parent().find('.input-error').hide();
        }*/

        // For AssignedTo User OK
        /*if(mode == 1) 
        {
            $('#ddlAssignedTo').addClass('error-val');
            $('#ddlAssignedTo').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlAssignedTo').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlAssignedTo').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else
        {
            $('#ddlAssignedTo').removeClass('error-val');
            $('#ddlAssignedTo').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlAssignedTo').parent().find('.input-error').hide();
        }*/

        if (errCount > 0)
            return false;
        else
            return true;
    }

    function desc($id)
    {
        if($id == 1){
            var sub_task_ism = $('#ddlSubTaskIsm').val();
        }else{
            var sub_task_ism = $('#ddlClosedTaskIsm').val();
        }
        
        //alert(sub_task_ism);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_taskcat.php",
            data:
            {
                action : "select_subtask_ism_desc",
                id: sub_task_ism
            }
        }).done(function (data) {
            //alert(data);
            if($id == 1){
                 //$('#subIsmDesc').html(data);
                //$('#subism').CSS(data);
                //$("#subism").css("display", "block");

            }else{
                 $('#closedIsmDesc').html(data);
                 $("#closeism").css("display", "block");
            }
           
        });
    }

    function getisms()
    {
        var subcat = $('#ddlSubCat').val();
        var task_category = $('#ddlTaskCategory').val();
        var action = "get_isms";

        $.ajax({
            data: 
            {
                'action':action,
                'subcat':subcat,
                'task_category':task_category
            },
            type: 'POST',
            url: "includes/ajax/action_taskcat.php",
            success: function(data) 
            {
                //alert(data);
                // data = data.trim();
                // console.log(data);
                $('#ddlClosedTaskIsm').html(data);
                $('#ddlSubTaskIsm').html(data);
            }
        });
    }

    function get_ownership_list()
    {
        var id = $('#ddlDepartmentName').val();
        //alert(id); return false;
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_taskcat.php",
            data:
            {
                action  : "get_ownership_list",
                id      : id
            }
            }).done(function (data) {
            //alert(data);
            $('#ddlOwnership').html(data);
        });
    }
</script>

</body>
</html>