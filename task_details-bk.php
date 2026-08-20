<?php
    $page_title = "Task Details";
    $permission_type = "view";
    $module_id = "28";
    $parent_id = "26";
    $menu_id = "task_view";

    include('includes/header.php');
    include('classes/task.php');
    include('classes/taskcat.php');

    $objTask = new Task();
    $objTaskcat = new Taskcat();

    $users = $objUser->GetUsers(0);   

    $disable_info            = "";
    $disable_task_progress   = "";
    $dis_button              = "";
    $comments_progress       = "";
    $disabled_comments       = "";

    if(isset($_GET))
    {
        $task_id  = isset($_GET['id']) ? $_GET['id'] : 0;

        $heading = "";
        $isactive = "";

        if($task_id > 0)
        {
            $data                   = $objTask->GetTaskById($task_id);
            $sub_tsk_id             = $objTask->GetSubTaskById($task_id);
            $subtask_ism            = $sub_tsk_id['subtask_ism_id'];
            //$tsid                   = $data[0]['task_id'];
            $activity_data          = $objTask->GetTaskStatusById($task_id);

            //For Reassignment in Manual Assignment's ISM
            $confirm_manual_assign  = $objTask->ConfirmManualAssignment($data[0]['task_cat'],$data[0]['task_subcat'],$data[0]['task_ism']);

            $disable_info           = $data[0]['group_id'] != 0 ? "disabled='disabled'" : "";
            $disable_task_progress  = $data[0]["progress"] == 100 ? "disabled='disabled'" : "";
            $dis_button             = ($data[0]['task_status_id'] == 3 || $data[0]['task_status_id'] == 4 || $data[0]['task_status_id'] == 6 || $data[0]['task_assigned_to'] != $login_id ) ? "disabled='disabled'" : "";
            $comments_progress      = ($data[0]['task_status_id'] == 3 || $data[0]['task_status_id'] == 4 || $data[0]['task_status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments      = ($data[0]['task_status_id'] == 3 || $data[0]['task_status_id'] == 4 || $data[0]['task_status_id']== 6) ? "disabled='true'" : "";
            $display_button         = ($data[0]['task_status_id'] == 3 && $user_type == 2) ? "" : "display: none";
        }
        else
        {
            $heading = "Task Management";
        }
    }
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
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

<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->


<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="task_view.php">Task</a></li>
        <li class="javascript:;"><?php echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <?php 
        //$data = $objTask->GetTaskById($_GET['id']);
        /*echo "<pre>";
            print_r($confirm_manual_assign[0]);
        echo "</pre>";*/
    ?>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <div class="col-md-2">
                            <!-- <blink><a id="btnVerify" style="<? //echo $display_button ?>" class="btn btn-xs btn-warning"><span class="blink_me">Verify</span></a></blink> -->
                        </div>
                    </div>
                    <h4 class="panel-title"><?php echo $page_title; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="#" method="POST" id="task">
                        <input type="hidden" class="form-control" id="txtId" value="<?php echo($data[0]['task_id']); ?>">
                        <input type="hidden" class="form-control" value="<? echo $data[0]['task_num'] ?>">
                        <input type="hidden" name="txtCounter" id="txtCounter" value="<? echo $data[0]['task_daily_counter']; ?>" />
                        <input type="hidden" class="form-control" id="pri" value="<?php echo($data[0]['task_priority']); ?>">
                        <input type="hidden" class="form-control" id="policy_no" value="<?php echo($data[0]['policy_number']); ?>">
                        <input type="hidden" class="form-control" id="tism" value="<?php echo($data[0]['task_ism']); ?>">

                        <fieldset>
                            <legend>Task</legend>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Task Number</label>
                                        <input type="text" class="form-control" placeholder="Task Number" value="<? print_r($data[0]['task_num']); ?>" disabled='true'>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="tc_old">
                                    <div class="form-group">
                                        <label>Task Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskCat" name="ddlTaskCat" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                                <option value="<? echo $data[0]['task_cat']; ?>">
                                                    <? echo $objTaskcat->GetCategoryNameById($data[0]['task_cat']); ?>
                                                </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" id="tc_new" style="display: none;">
                                    <div class="form-group">
                                        <label style="width: 200px;">Task Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskCatR" name="ddlTaskCatR" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_cat();">
                                            <option selected="selected" value="" disabled="disabled">Select Category</option>
                                            <?php $getTaskCat = $objTask->GetTaskCat(); ?>
                                            <?php foreach($getTaskCat as $getTaskCats) { ?>
                                                <option value="<? echo $getTaskCats["id"]; ?>" <?php echo $data[0]['task_category_id'] == $getTaskCats["id"] ? "selected='selected'" : ""?> >
                                                    <? echo $getTaskCats["fullname"]; ?>
                                                </option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Task category is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="tsc_old">
                                    <div class="form-group">
                                        <label>Task Sub Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskSubCat" name="ddlTaskSubCat" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                            <option value="<? echo $data[0]['task_subcat']; ?>">
                                                <? echo $objTaskcat->GetSubCategoryNameById($data[0]['task_subcat']); ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-3" id="tsc_new" style="display: none;">
                                    <div class="form-group">
                                        <label>Task Sub Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskSubCatR" name="ddlTaskSubCatR" data-size="10" data-live-search="true" data-style="btn-white" onchange="getisms();">
                                            <option value="0" selected="selected" disabled>Select Subcategory</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Subcategory is required</div>
                                    </div>
                                </div>
                                 <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3" id="ismold">
                                    <div class="form-group">
                                        <label>Task ISM<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskIsm" name="ddlTaskIsm" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                                <option value="<? echo $data[0]['task_ism']; ?>">
                                                    <? echo $objTaskcat->GetIsmNameById($data[0]['task_ism']); ?>
                                                </option>
                                
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3" id="ismnew" style="display: none;">
                                    <div class="form-group">
                                        <label >ISM</label>
                                        <!-- <input type="text" class="form-control" name="txtISM" id="txtISM" disabled="true">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">ISM is required</div>
                                    </div> -->
                                    <select class="form-control default-select2" id="txtISM" name="txtISM" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_subcat();">
                                        <option value="0" disabled="disabled" selected="selected" >Select Task ISM</option>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Task ISM is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>ISM DESC<span style="color: red;">*</span></label>
                                        <input type="text" id="txtIsmDesc" name="txtIsmDesc" class="form-control" placeholder="Task ISM DESC"  value="<? print_r($data[0]['task_ism_desc']); ?>" disabled='true'>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3" id="re_assign_to_old">
                                    <div class="form-group">
                                        <label>Assigned To<span style="color: red;">*</span></label>
                                        <?php if($data[0]['task_assigned_to'] == 0){ ?>
                                            <select class="form-control default-select2" id="ddlAssignedTo" name="ddlAssignedTo" data-size="10" data-live-search="true" data-style="btn-white">
                                                <option selected="selected" disabled="true">Select User</option>
                                                <?php foreach($users as $user){ ?>
                                                    <option value="<? echo $user["id"]; ?>" <?php echo ($data[0]['task_assigned_to'] == $user["id"] ? "selected='selected'" : ''); ?>>
                                                    <? echo ucfirst($user["user_name"]); ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        <?php } else { ?>
                                            <select class="form-control default-select2" id="ddlAssignedTo" name="ddlAssignedTo" data-size="10" data-live-search="true" data-style="btn-white" disabled="true">
                                                <option selected="selected" disabled="true">Select User</option>
                                                <?php foreach($users as $user){ ?>
                                                    <option value="<? echo $user["id"]; ?>" <?php echo ($data[0]['task_assigned_to'] == $user["id"] ? "selected='selected'" : ''); ?>>
                                                    <? echo ucfirst($user["user_name"]); ?>
                                                    </option>
                                                <? } ?>
                                            </select>
                                        <?php } ?>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Assigned to user is required</div>
                                    </div>
                                </div>

                                <div class="col-md-3" id="re_assign_to" style="display: none;">
                                    <div class="form-group">
                                        <label>Assigned To<span style="color: red;">*</span></label>
                                        <input type="text" id="AssignedTo" name="AssignedTo" class="form-control" placeholder="Policy Number"  value="" disabled='true'>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Task Title<span style="color: red;">*</span></label>
                                        <input type="text" id="txtTitle" name="txtTitle" class="form-control" placeholder="Task Title"  value="<? print_r($data[0]['task_title']); ?>" disabled='true'>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Task Title is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Time Start<span style="color: red;">*</span></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="datetimepicker_start" value="<? echo $data[0]['task_start_datetime']; ?>" disabled='true'>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Start time is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Time End<span style="color: red;">*</span></label>
                                        <div class="input-group date">
                                            <input type="text" class="form-control" name="datetimepicker_end" value="<? print_r($data[0]['task_end_datetime']); ?>" disabled='true'>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">End time is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                                
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Weightage</label>
                                        <select class="form-control default-select2" id="ddlPriority" name="ddlPriority" disabled="true">
                                            <?php $priorities = $objTask->GetPriority(); ?>
                                            <?php foreach($priorities as $priority){ ?>
                                                <option value="<? echo $priority["id"]; ?>" <?php echo ($data[0]['task_priority'] == $priority["id"] ? "selected='selected'" : ''); ?>>
                                                    <? echo $priority["priority"]; ?>    
                                                </option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Policy Number<span style="color: red;">*</span></label>
                                        <input type="text" id="policy" name="policy" class="form-control" placeholder="Policy Number"  value="<? echo $data[0]['policy_number']; ?>" disabled='true'>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Progress</label>
                                        <select class="form-control default-select2" id="ddlProgress" name="ddlProgress" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_task_progress; ?> >
                                            <option value="0" disabled="disabled">Select Progress</option>
                                            <option value="100" selected="selected" >Completed</option>
                                            <option value="50" >In Progress</option>
                                           <!--  <?php// for($i = 0; $i <= 100; $i += 10) { ?>
                                                <option value="<? //echo $i ?>"<?php //echo ($data[0]["progress"] == $i ? "selected='selected'" : ""); ?>><? //echo $i ?>%</option>
                                            <? //} ?>
                                            <option value="101">Invalid</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <textarea type="text" class="form-control" id="txtTaskDesc" name="txtTaskDesc" rows="6" placeholder="Enter Description" disabled="true"><? print_r($data[0]['task_desc']); ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Description is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Activity Note<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtActivity" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['task_status_id'] == 3 || $data[0]['task_status_id'] == 4) ? $comments_progress : ''; ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </fieldset>

                        <!-- <fieldset>
                            <legend>Task - Activity Note</legend>
                                <div class="col-md-12">
                                    
                                </div>
                        </fieldset> -->

                        <fieldset>
                            <legend>Task - File Attachment</legend>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <?php
                                        $filepath  = SITE_ROOT."/uploads_eform_complaint/task_attachment/".$data[0]['task_num']."/";

                                        $filepath7 = SITE_IP."/uploads_eform_complaint/task_attachment/".$data[0]['task_num']."/";

                                        $files = scandir($filepath);
                                        
                                        $datas = "";
                                    ?>
                                    
                                    <?php if($files != '') { ?>
                                        <tr>
                                            <?php
                                                for($a=2; $a<count($files); $a++)
                                                {
                                                    $datas .='<td class="text-center">';
                                                        $datas .='<div><i class="fa fa-arrow-circle-o-right fa-3x text-inverse fa-rotate-90"></i></div>';
                                                        $datas .='<div><a title="'.$files[$a].'" class="btn btn-primary btn-sm" href="'.$filepath7.$files[$a].'" download>'.$data[0]['task_num'].'<a/></div>';
                                                    $datas .='</td>';
                                                }
                                                echo $datas;
                                            ?>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td align="center"><b> No Attachment Found </b></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </fieldset>

                        <hr>

                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnSubmitTask" <? echo $dis_button; ?> <?php echo $disable_task_progress; ?> data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Submit</button>
                                  <?php if($subtask_ism != 0 ){?>
                                    <a <? echo $dis_button; ?> class="btn btn-danger btn-sm checkUpdate" href="task_add.php?tid=<?php echo $task_id ; ?>&pno=<?php echo $data[0]["policy_number"]?>"> Add SubTask <i class="glyphicon glyphicon-edit icon-white"></i></a>
                                <?php } ?>
                                <?php if( ($user_type == 1 || $user_type == 2) && $data[0]['task_status_id'] != 3 ) { ?>
                                    <?php if($confirm_manual_assign[0]['operation_mode']){ ?>
                                        <button type="button" class="btn btn-sm btn-primary" id="btnReasignTask" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." onclick="reasign();">Reassign</button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-sm btn-primary" id="btnupReasignTask" style="display: none;margin-left: 238px;margin-top: -29px;" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." onclick="update_user();">Update</button>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-inverse" data-sortable-id="table-stuff-5">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Task Activities</h4>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date/Time</th>
                                    <th>Previous State</th>
                                    <th>Current State</th>
                                    <th>Activity Performed By</th>
                                    <!-- <th>Progress</th> -->
                                    <th width="300px">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?  
                                    $users = $objUser->GetUsers(0);
                                    $counter = 0;
                                    $users_ids = explode(",", $activity_data[0]['assign_to']);
                                ?>
                                <?php foreach($activity_data as $row) { ?>
                                    <?php
                                        if($row["current_state"] == 2){
                                            $curr_status = "In Progress";
                                            $pre_status  = "Initiated";
                                        }
                                        elseif($row["current_state"] == 3){
                                            $curr_status = "closed";
                                            $pre_status  = "In Progress";
                                        }
                                        elseif($row["current_state"] == 4){
                                            $curr_status = "verified";
                                            $pre_status  = "closed";
                                        }
                                        elseif($row["current_state"] == 5) {
                                            $curr_status = "Invalid";
                                            $pre_status = "Forwarded";
                                        }elseif($row["current_state"] == 6) {
                                            $curr_status = "ONHOLD/Forwarded";
                                            $pre_status = "In Progress";
                                        }
                                    ?>
                                    <tr>
                                        <td><? echo $row["update_datetime"]; ?></td>
                                        <td><? echo $pre_status; ?></td>
                                        <td><? echo $curr_status; ?></td>
                                        <td><? echo ucfirst($row["user_name"]); ?></td>
                                        <!-- <td><? //echo $row["progress"] . "%"; ?></td> -->
                                        <td><? echo $row["comments"]; ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

<div class="modal fade" id="ModalComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseComments" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Add Task</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalform" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="$task_id" name="$task_id" value="<?php //echo($data[0]['task_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" name="counter_display" value="<? echo $counter_display; ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="comments" class="form-control" id="txtComments1" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

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

                                <div class="col-md-12">
                                    <label>
                                        <a class="btn btn-icon btn-circle btn-success" id="btnFileUplaodDiv">
                                            <i class="fa fa fa-plus-square"></i></a>
                                    </label>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUpload" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Upload</button>
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
<!-- //haroon wrok-->  

<?php //echo $tsid; 
    $data = $objTask->GetSubTaskByTaskId($task_id);
    if(!empty($data)){ ?>
    <div id="content" class="content">
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        </div>
                        <h4 class="panel-title">View Sub Task</h4>
                    </div>
                    <div class="panel-body">
                        <fieldset>
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task ID</th>
                                        <th>Status</th>
                                        <th>Tilte</th>
                                        <th>Category</th>
                                        <th>SubCategory</th>
                                        <th>ISM</th>
                                        <th>Priority</th>
                                        <th>Start Date/Time</th>
                                        <th>End Date/Time</th>
                                        <th>Assigned To</th>
                                        <th>Created Date/Time</th>
                                        <th>ISM Desc</th>
                                        <th>Task Desc</th>
                                        <th>Assigned By</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        foreach($data as $row)
                                        {
                                            $task_end_datetime = $row["task_end_datetime"];
                                            $task_status_id = $row['task_status_id'];
                                            $current_datetime  = Date('Y-m-d');
                                            //$current_datetime  = "2018-03-31 00:00:00";
                                            $task_status_id = $row['task_status_id'];

                                            $deff = $objTask->GetDateTimeDiff($task_end_datetime, $current_datetime);

                                            // if($deff > 0 && ($task_status_id == 1 || $task_status_id == 2 || $task_status_id == 6 )){ 
                                            //      $task_status_id = "Due";
                                            //      $btnType = "btn-danger";
                                            //  }
                                            // if($deff > 0 && ($task_status_id == 1 || $task_status_id == 2 )){ 
        
                                            //       $btnType = "btn-danger";
                                            //   }
                            

                                            if($task_status_id == 1)
                                            {
                                              $task_status_id = "Initiated";
                                              $btnType = "btn-primary";
                                            }
                                            elseif($task_status_id == 2)
                                            {
                                              $task_status_id = "In Progress";
                                              $btnType = "btn-info";
                                            }
                                            elseif($task_status_id == 3)
                                            {
                                              $task_status_id = "Closed";
                                              $btnType = "btn-warning";
                                            }
                                            elseif($task_status_id == 4)
                                            {
                                              $task_status_id = "Verified";
                                              $btnType = "btn-success";
                                            }
                                            elseif($task_status_id == 5)
                                            {
                                              $task_status_id = "Invalid";
                                              $btnType = "btn-danger";
                                            }
                                            elseif($task_status_id == 6)
                                            {
                                              $task_status_id = "Onhold";
                                              $btnType = "btn-default";
                                            }

                                              if($deff > 0){ 

                                                 if($task_status_id != "Onhold" && $task_status_id != "Closed" ){
                                                     //echo $task_status_id;
                                                     $btnType = "btn-danger";
                                                  }//elseif( $task_status_id != "Closed"){
                                                 //     echo $task_status_id;
                                                 //     $btnType = "btn-danger";
                                                 // }
                                             }
                                    
                                            ?>
                                            <tr>
                                                <td>
                                                  <a href="task_details.php?id=<?php echo $row['task_id']; ?>" title="Click here to see Details"><? echo $row["task_num"] ?></a>
                                                </td>
                                                <td><a href="task_details.php?id=<?php echo $row['task_id']; ?>" class="btn btn-xs <? echo $btnType; ?>"><? echo $task_status_id; ?></a></td>
                                                <td width="300px"><? echo $row["task_title"]; ?></td>
                                                <td><? echo $objTaskcat->GetCategoryNameById($row["task_cat"]); ?></td>
                                                <td><? echo $objTaskcat->GetSubCategoryNameById($row["task_subcat"]); ?></td>
                                                <td width="100px" ><? echo $objTaskcat->GetIsmNameById($row["task_ism"]); ?></td>
                                                <td><? echo $row["priority"]; ?></td>
                                                <td><? echo $row["task_start_datetime"]; ?></td>
                                                <td>
                                                  <?
                                                    $task_end_datetime = $row["task_end_datetime"];
                                                    $current_datetime  = Date('Y-m-d H:i:s');

                                                    $deff = $objTask->GetDateTimeDiff($task_end_datetime, $current_datetime);
                                                    
                                                    $task_status_id = $row["task_status_id"];

                                                    if($deff > 0 AND ($task_status_id == 1 OR $task_status_id == 2))
                                                    {
                                                      echo "<span style='color:red'>" . $row["task_end_datetime"] . "</span>";
                                                    }
                                                    else
                                                    {
                                                      echo $row["task_end_datetime"];
                                                    }
                                                  ?>  
                                                </td>
                                                <td>
                                                  <?
                                                    $task_verified_by = $row['task_assigned_to'];

                                                    if($task_verified_by == $login_id)
                                                    {
                                                      echo "<span class='blink_me' style='color:blue'>" . ucfirst($row["assignedTo"]) . "</span>";
                                                    }
                                                    else
                                                    {
                                                      echo ucfirst($row["assignedTo"]);
                                                    }
                                                  ?>  
                                                </td>
                                                <td><? echo $row["task_create_date"]; ?></td>
                                                <td><? echo $row["task_ism_desc"]; ?></td>
                                                <td><? echo $row["task_desc"]; ?></td>
                                                <td>
                                                  <?
                                                    $task_verified_by = $row['task_assignee'];

                                                    if($task_verified_by == $login_id)
                                                    {
                                                      echo "<span class='blink_me' style='color:blue'>" . ucfirst($row["assignedBy"]) . "</span>";
                                                    }
                                                    else
                                                    {
                                                      echo ucfirst($row["assignedBy"]);
                                                    }
                                                  ?>  
                                                </td>
                                            </tr>
                                        <?php }
                                    ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
<?php } ?>
<!--haroon work end  */ -->

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

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
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
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();
    });
</script>

<script type="text/javascript">
    $("#btnSubmitTask").click(function () 
    {
        var id        = $('#txtId').val();
        var action    = 'update_progress';
        var user_type = <? echo $user_type ?>;
        var progress  = $('#ddlProgress').val();
        var notes     = $('#txtActivity').val();
        var policy    = $('#policy_no').val();
        var priority  = $('#pri').val();
        var ism       = $('#ddlTaskIsm').val();
        
        //alert(ism);
        //alert(policy);
        //return false;

        if (validation(user_type)) 
        {
            $("#btnSubmitTask").button('loading');
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_task_cat-bk.php",
                data: 
                {
                    'id'        :id,
                    'action'    :action,
                    'progress'  :progress,
                    'notes'     :notes,
                    'policy'    :policy,
                    'priority'  :priority,
                    'ism'       :ism
                },
                success: function (data) 
                {
                    //$("#btnSubmitTask").button('reset');
                    data = data.trim();
                    //alert(data);
                    console.log(data);

                    if(data == 'success')
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        //setTimeout(function () { window.location.href = "task_details.php?id=<? echo $task_id ?>" }, 3000);
                        setTimeout(function () { window.location.href = "task_view.php" }, 3000);
                    }
                    else if(data == 'fail')
                    {
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    });

    function validation(user_type)
    {
        var hasFocus = false;
        var errCount = 0;

        if(user_type == 4)
        {
            if($('#txtActivity').val() == "") 
            {
                $('#txtActivity').addClass('error-val');
                $('#txtActivity').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivity').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivity').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivity').parent().find('.input-error').hide();
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

    function task_cat()
    {
        //$("#ddlComplaintType").empty();
        var task_category = $('#ddlTaskCatR').val();
        var task_subcat   = '';
        //alert(task_subcat);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_task_cat.php",
            data:
            {
                action : "select_task_category",
                id: task_category,
                task_subcat : task_subcat
            },
            async:false
        }).done(function (data) {
            //alert(data);
            $('#ddlTaskSubCatR').html(data);
            
            $("#tsc_new").css("display", "block");
            $("#tsc_old").css("display", "none");
            
            //if(tid != 0){
            // task_subcat(); 
            //}
        });
        //task_subcat();
    }

    function getisms()
    {
        var subcat = $('#ddlTaskSubCatR').val();
        var task_category = $('#ddlTaskCatR').val();
        var action = "get_tsk_ism";
        var tid = "1";
        var is_main = "1";

        if(tid != 0)
        {
            is_main = "0";
        }

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
                //alert(data);
                // data = data.trim();
                console.log(data);
                
                $('#txtISM').html(data);
                $("#ismnew").css("display", "block");
                $("#ismold").css("display", "none");
            }
        });
    }

    function task_subcat()
    {
        var ism = $('#txtISM').val();
        var task_category = $('#ddlTaskCatR').val();
        var task_subcategory = $('#ddlTaskSubCatR').val();

        // var tid = $('#tid').val();
        // var is_main = "1";
        // if(tid != 0){
        //     is_main = "0";
        // }  
        //alert(is_main);
        //alert(task_subcategory);

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
            //alert(data);
            //return false;
            //console.log(data);

            var str = data.split('|');

            //$('#txtISM').val(str[0]);
            $('#txtIsmDesc').val(str[1]);
            $('#AssignedTo').val(str[2]);
            $('#task_ism_id').val(str[3]);
            $('#user_id').val(str[4]);
            $('#ddlGroup').val(str[5]);
            $('#txtTitle').val(str[6]);
            $('#op_mode').val(str[7]);
            $('#ddlPriority').val(str[8]);
            
            if(str[7] == "0")
            {
               //$("#auto_assignee").css("display", "block");
               $("#manual_assignee").css("display", "block");
               //$(".select2-container--default default-select2").css("width" ,"260px !important");
               //$(".select2-container--default default-select2").css('width','260px');
            }
            else
            {
                $("#auto_assignee").css("display", "block");
                $("#manual_assignee").css("display", "none");
            }
            
            $("#re_assign_to").css("display", "block");
            $("#re_assign_to_old").css("display", "none");
        });
    }

    function reasign()
    {
        //alert("hi");
        //return false;
        //$("#tc_old").css("display", "none");
        //$("#tc_new").css("display", "block");
        //$("#btnupReasignTask").css("display", "block");
        //$("#btnReasignTask").attr('disabled',true);

        var task    = $('#txtId').val();
        //var us    = $('#AssignedTo').val();
        var tism    = $('#tism').val();
        var action  = 'reasign_user';

        //alert(tism);
        $.ajax({
            data: 
            {
                'action':action,
                'tism':tism,
                'id' :task
            },
            type: 'POST',
            url: "includes/ajax/action_taskcat.php",
            success: function(data) 
            {
                //alert(data);
                // data = data.trim();
                console.log(data);
                if(data == 'success')
                {
                    //$('html, body').animate({scrollTop: 0}, 600);
                    $.notifyBar({ cssClass: "success", html: "Task Reassignment Successfully", delay: 2000, animationSpeed: "normal" });
                    //$('#divSuccess').html('<strong>Success!</strong> User created successfully with Employee Id  <strong>' + employee_id + '</strong> <span class="close" data-dismiss="alert">&times;</span>');
                    //$('#notify_success_insert').show();
                    //clear_values();
                    setTimeout(function () { window.location.href = "task_view.php" }, 3000);
                }
                else if(data == 'fail')
                {
                    $('#txtEmail').addClass('error-val');
                    $('#txtEmail').focus();
                    $.notifyBar({ cssClass: "warning", html: "Note: This task can't be reasigned, First change 'Assigned To' user from target ISM!", delay: 5000, animationSpeed: "normal" });
                }
            }
        });
    }

    function update_user()
    {
        //alert("hi");
        //return false;
        var ism = $('#txtISM').val();
        var us = $('#AssignedTo').val();
        var tism = $('#tism').val();
        var action = 'reasign_user';

        alert(tism);

        $.ajax({
            data: 
            {
                'action':action,
                'tism':tism
            },
            type: 'POST',
            url: "includes/ajax/action_taskcat.php",
            success: function(data) 
            {
                alert(data);
                // data = data.trim();
                console.log(data);
            }
        });
    }
</script>

</body>
</html>
