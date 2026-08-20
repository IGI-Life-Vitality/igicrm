<?php
    $page_title = "View Task";
    $permission_type = "view";
    $module_id = "28";
    $parent_id = "26";
    $menu_id = "task_view";

    include('includes/header.php');
    include('classes/task.php');
    include('classes/taskcat.php');
    $login_id = $_SESSION['login_id'];

    $objTask = new Task();
    $objTaskcat = new Taskcat();
    $data = $objTask->GetTask($login_id,$user_type,$group_id);

    //print_r($data);
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
        <li><a href="javascript:;">Task</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

    <?php
      /*echo "<pre>";
        print_r($data[1]);
      echo "</pre>";*/
    ?>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $page_title; ?></h4>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <!-- <legend>Task Search</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">CNIC</label>
                                        <input type="text" class="form-control" placeholder="42201-XXXXXXX-X">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Ticket Number</label>
                                        <input type="text" class="form-control" placeholder="CTyymmdd000">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Complaint Type</label>
                                        <select class="form-control default-select2" id="ddlPriority" name="ddlPriority">
                                            <option selected="selected" disabled>Select Complaint Type</option>
                                            <option>Normal</option>
                                            <option>Low</option>
                                            <option>Hight</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Current Actor</label>
                                        <input type="text" class="form-control" placeholder="Agent Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="" selected="selected" disabled>Current State</label>
                                        <select class="form-control default-select2" id="ddlPriority" name="ddlPriority">
                                            <option selected="selected" disabled>Select Current State</option>
                                            <option>Active</option>
                                            <option>Is Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" id="txtFromDate" value="" placeholder="Date/Time">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <div class="input-group date" id="datetimepicker2">
                                            <input type="text" class="form-control" id="txtToDate" value="" placeholder="Date/Time">
                                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-info">Search</button>
                                        <button type="reset" class="btn btn-sm btn-info">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr> -->

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
                                <th>SubTasks</th>
                            </tr>
                            </thead>

                            <tbody>
                                <?php
                                    foreach($data as $row)
                                    {
                                        $task_end_datetime = $row["task_end_datetime"];
                                        $current_datetime  = Date('Y-m-d');
                                        //$current_datetime  = "2018-04-30 00:00:00";
                                        $task_status_id = $row['task_status_id'];

                                       $deff = $objTask->GetDateTimeDiff($task_end_datetime, $current_datetime);

                                        // if($deff > 0 && ($task_status_id == 1 || $task_status_id == 2 )){ 
                                        //       $task_status_id = "In Progress";
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

                                            <td>
                                              <?
                                                $subtask = $row['sub_task_id'];

                                                if($subtask != "0")
                                                {?>
                                                  <a href="task_details.php?id=<?php echo $row['task_id']; ?>" title="Click here to see Details" class = "btn btn-danger">SubTask</a>
                                                <?}
                                                else
                                                {
                                                  
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

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();
    });
</script>

</body>
</html>