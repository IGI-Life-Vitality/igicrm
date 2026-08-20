<?php
    $page_title = "View Task";
    $permission_type = "view";
    $module_id = "28";
    $parent_id = "26";
    $menu_id = "task_view";

    include('includes/header.php');
    include('classes/task.php');
    include('classes/taskcat.php');

    $login_id   = $_SESSION['login_id'];
    $user_type  = $_SESSION['user_type'];
    $group_id   = $_SESSION['group_id'];

    $objTask    = new Task();
    $objTaskcat = new Taskcat();
    $data       = $objTask->GetTask($login_id,$user_type,$group_id);
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

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

    <?php 
        /*echo "<pre>";
            print_r($data);
        echo "</pre>";*/
    ?>

    <!-- begin page-header -->
    <h1 class="page-header">Task Management</h1>
    <!-- end page-header -->

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
                        <legend>Task Search</legend>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >Category<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlTaskCategory" name="ddlTaskCategory" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_cat();">
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

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Subcategory<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlSubCategory" name="ddlSubCategory" data-size="10" data-live-search="true" data-style="btn-white" onchange="getisms();">
                                            <option value="0" selected="selected" disabled>Select Subcategory</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Subcategory is required</div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label >ISM</label>
   
                                        <select class="form-control default-select2" id="txtISM" name="txtISM" data-size="10" data-live-search="true" data-style="btn-white" onchange="task_subcat();">
                                            <option value="0" disabled="disabled" selected="selected" >Select Task ISM</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Task ISM is required</div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Current State</label>
                                        <select class="form-control default-select2" id="tsk_status" name="tsk_status">
                                            <option  value ="" selected="selected" disabled>Select Current State</option>
                                            <option value="1">Initiated</option>
                                            <option value="2">In Progress</option>
                                            <option value="3">Closed</option>
                                            <option value="6">Onhold</option>
                                            <option value="5">Invalid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" id="txtFromDate" value="<? echo trim($_POST['txtFromDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtFromDate']))) : ''; ?>" placeholder="Start Date" data-date-format="YYYY-MM-DD">
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
                                            <input type="text" class="form-control" id="txtToDate" value="<? echo trim($_POST['txtToDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtToDate']))) : ''; ?>" placeholder="End Date" data-date-format="YYYY-MM-DD">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Policy Number</label>
                                        <input type="text" class="form-control" id="policy" value="" placeholder="Policy Number">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="search();">Search</button>
                                        <button type="reset" class="btn btn-sm btn-primary" onclick="reset();">Reset</button>

                                        <?php if($user_type == 1 || $user_type == 2) { ?>
                                            <a href="raw_data/export_task_raw_data.php" class="btn btn-sm btn-success">Export Task Raw Data</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr> 

                        <table id="task_grid" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Task <br>ID</th>
                                    <th>Task <br>Status</th>
                                    <th>Policy <br>Number</th>
                                    <th>Category</th>
                                    <th>SubCategory</th>
                                    <th>ISM</th>
                                    <th>Start <br>Date/Time</th>
                                    <th>End <br>Date/Time</th>
                                    <th>Assigned <br>To</th>
                                    <th>Assigned <br>By</th>
                                    <th>SubTasks</th>
                                </tr>
                            </thead>
                     
                            <tbody></tbody>
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

    function getisms()
    {
        var subcat = $('#ddlSubCategory').val();
        var task_category = $('#ddlTaskCategory').val();
        var action = "get_tsk_ism";
        var tid = $('#tid').val();
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
            }
        });
    }

    function task_cat()
    {
        //$("#ddlComplaintType").empty();
        var task_category = $('#ddlTaskCategory').val();
        var task_subcat   = $('#subcat_id').val();
        //alert(task_subcat);

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
            //alert(data);
            $('#ddlSubCategory').html(data);
            // if(tid != 0){
            //    task_subcat(); 
            //}
        });
        //task_subcat();
    }

    /* Task Subcategory */
    function task_subcat()
    {
        var ism = $('#txtISM').val();
        var task_category = $('#ddlTaskCategory').val();
        var task_subcategory = $('#ddlSubCategory').val();
        // var tid = $('#tid').val();
        // var is_main = "1";
        // if(tid != 0){
        //     is_main = "0";
        //   }  
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

            var str = data.split('|')

            //$('#txtISM').val(str[0]);
            $('#txtISMDesc').val(str[1]);
            $('#txtAssignedTo').val(str[2]);
            $('#task_ism_id').val(str[3]);
            $('#user_id').val(str[4]);
            $('#ddlGroup').val(str[5]);
            $('#txtTitle').val(str[6]);
            $('#op_mode').val(str[7]);
            $('#ddlPriority').val(str[8]);
            
            if(str[7] == "0"){
               //$("#auto_assignee").css("display", "block");
               $("#manual_assignee").css("display", "block");
               //$(".select2-container--default default-select2").css("width" ,"260px !important");
               //$(".select2-container--default default-select2").css('width','260px');
            }else{
                $("#auto_assignee").css("display", "block");
                $("#manual_assignee").css("display", "none");

            }
        });
    }

    function reset()
    {
        $('#policy').val('');
        $('#ddlTaskCategory').prop('selectedIndex',0);
        $('#select2-ddlTaskCategory-container').html('Select Category');
        $('#ddlSubCategory').prop('selectedIndex',0);
        $('#select2-ddlSubCategory-container').html('Select SubCategory');
        $('#txtISM').prop('selectedIndex',0);
        $('#select2-txtISM-container').html('Select Task ISM');
        $('#tsk_status').prop('selectedIndex',0);
        $('#select2-tsk_status-container').html('Select Current Status');
        $('#txtFromDate').val('');
        $('#txtToDate').val('');
    }

    function search()
    {
        var policy         = $('#policy').val();
        var TaskCategory   = $('#ddlTaskCategory').val();
        var SubCategory    = $('#ddlSubCategory').val();
        var txtISM         = $('#txtISM').val();
        var tsk_status     = $('#tsk_status').val();
        var FromDate       = $('#txtFromDate').val();
        var ToDate         = $('#txtToDate').val();
  
        if(policy != '' || TaskCategory != null || SubCategory != null || txtISM != null || FromDate!= '' || ToDate != '' || tsk_status != null)
        {
            $.ajax({
                data: 
                {
                    'action'          :'search_task',
                    'policy'          :policy,
                    'TaskCategory'    :TaskCategory,
                    'SubCategory'     :SubCategory,
                    'txtISM'          :txtISM,
                    'FromDate'        :FromDate,
                    'ToDate'          :ToDate,
                    'tsk_status'      :tsk_status
                },
                type: 'POST',
                url: "includes/ajax/action_task_cat.php",
                success: function(data) 
                {
                    //alert(data);
                    console.log(data);
                    var result = data.split("|");
                    
                    if(result[0] == 'success')
                    {
                        $('#task_grid').DataTable().destroy();
                        $('#task_grid').html(result[1]);                       
                        $('#task_grid').DataTable({
                            'destroy': true,
                            'paging': true,
                            'searching': true,
                            'ordering': true,
                            'info': true,
                            'autoWidth': true,
                            "scrollCollapse": true,
                            "scrollX": true
                        });
                    }
                }
            });
        } 
    }
</script>

<!-- Datatable with ajax request -->
<script type="text/javascript" language="javascript">
    $( document ).ready(function() {
        var dt = $('#task_grid').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "searching": false,
            /*"language": 
            {
                searchPlaceholder: "Enter Task ID / Policy # / AssignedTo / AssignedBy"
            },*/
            "order": [[ 0, "desc" ]],
            "ajax":
            {
                url : "data-table-query/response_task.php", //JSON Data Source
                type: "post",                               //Type of Method, GET/POST/DELETE
                error: function(){
                    $("#employee_grid_processing").css("display","none");
                }/*,
                success: function(data){
                    console.log(data);
                }*/
            }
        });

        /*$('.dataTables_filter input[type="search"]').css(
            {
                'width':'295px',
                'display':'inline-block'
            }
        );*/

        /*$(window).load(function(){
            var iets = $('.dataTables_filter input');

            iets.unbind().bind("keyup", function (e) {
                if(iets.val().length >= 3)
                {
                    dt.search(iets.val()).draw();
                }

                if(iets.val() === "")
                {
                    dt.search(iets.val()).draw();
                }
            });
        });*/
    });
</script>

</body>
</html>