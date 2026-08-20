<?php
    $page_title = "Complaint Views";
    $permission_type = "view";
    $module_id = "3";
    $parent_id ="19";
    $menu_id = "complaint_views";

    include('includes/header.php');
    include('classes/complaint.php');

    $login_id   = $_SESSION['login_id'];
    $group_id   = $_SESSION['group_id'];
    $user_type  = $_SESSION['user_type'];

    //$objComplaint = new Complaint();
    /*$data = $objComplaint->getComplaintView($login_id,$user_type,$group_id,'','','','','','','','');*/
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Complaint</a></li>
        <li class="active">View Complaint</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Complaint Management</h1>
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
                    <h4 class="panel-title">View Complaints</h4>
                </div>

                <div class="panel-body">
                    <legend>Complaint Search</legend>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="">CNIC</label>
                                    <input type="text" class="form-control" placeholder="42201XXXXXXXX" id="cnic_se" onkeypress="return validateNumbers(event)" maxlength="13">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Complaint Number</label>
                                    <input type="text" class="form-control" placeholder="CTyymmdd000" id="cmp_num" maxlength="13">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Complaint Type</label>
                                    <select class="form-control default-select2" id="comp_type" name="comp_type">
                                        <option value ="" selected="selected" disabled>Select Complaint Type</option>
                                         <option value="bancaIndividual">Bancassurance Individual</option>
                                        <option value="bancaBank">Bancassurance Bank</option>
                                        <option value="corporate">Corporate</option>
                                        <option value="individual">Individual</option> 
                                        <option value="legal">Legal</option>
                                        <option value="vatality">Vitality</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Assigned To</label>
                                    <select class="default-select2 form-control" id="Agent_Name" name="Agent_Name">
                                        <option value="" selected="selected">Select Assigned To</option>
                                        <?php $users = $objUser->GetUsers(0); ?>
                                        <?php foreach($users as $user){ ?>
                                            <option value="<? echo $user["id"]; ?>" ><? echo $user["first_name"] ." ".$user["last_name"]?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Current State</label>
                                    <select class="form-control default-select2" id="cmp_status" name="cmp_status">
                                        <option  value ="" selected="selected" disabled>Select Current State</option>
                                        <option value="1">Initiated</option>
                                        <option value="2">In Progress</option>
                                        <option value="3">Resolved</option>
                                        <option value="4">UnResolved</option>
                                        <option value="5">Invalid</option>
                                    </select>
                                </div>
                            </div>
            
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
                                    <input type="text" class="form-control" id="policy_num" name="policy_num" placeholder="Enter Policy #">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary" onclick="search();">Search</button>
                                    <button type="reset" class="btn btn-sm btn-primary" onclick="reset();">Reset</button>
                                    <?php if($user_type == 1 || $user_type == 2){ ?>
                                            <a href="#" class="btn btn-sm btn-success" onclick="exportCmpRawData()">Export Complaint Raw Data</a>
                                            <a href="#" class="btn btn-sm btn-success" onclick="exportLegCmpRawData()">Export Legal Complaint Raw Data</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <table id="cmp_grid" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Complaint ID</th>
                                <th>Status</th>
                                <th>Customer<br> Name</th>
                                <th>Policy<br> Number</th>
                                <th>Released<br> By</th>
                                <th>Assigned<br> To</th>
                                <th>Complaint<br> Department</th>
                                <th>Complaint<br> Type</th>
                                <th>Complaint<br> TAT</th>
                                <th>Complaint<br> Mode</th>
                                <th>Created<br> Date</th>
                                <th>End<br> Date</th>
                                <th>Closed<br> Date</th>
                                <th>Source</th>
                                <th>Priority</th>
                                <th>Attachments</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody></tbody>
                    </table>
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
        //masking();
    });

    function reset()
    {
        $('#cnic_se').val('');
        $('#cmp_num').val('');
        $('#comp_type').prop('selectedIndex',0);
        $('#select2-comp_type-container').html('Select Complaint Type');
        $('#cmp_status').prop('selectedIndex',0);
        $('#select2-cmp_status-container').html('Select Current State');
        $('#Agent_Name').prop('selectedIndex',0);
        $('#select2-Agent_Name-container').html('Select Agent');
        $('#txtFromDate').val('');
        $('#txtToDate').val('');
        $('#policy_num').val('');
    }

    function masking()
    {
        //$("#cnic_se").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }

    function search()
    {
        var cnic       = $('#cnic_se').val();
        var cmp_num    = $('#cmp_num').val();
        var comp_type  = $('#comp_type').val();
        var cmp_status = $('#cmp_status').val();
        var agent      = $('#Agent_Name').val();
        var FromDate   = $('#txtFromDate').val();
        var ToDate     = $('#txtToDate').val();
        var policy_num = $('#policy_num').val();

        //alert(agent);
  
        if(cnic != '' || cmp_num != '' || comp_type != null || cmp_status != null || FromDate!= '' || ToDate != '' || agent != '' || policy_num != '')
        {
            $.ajax({
                data: 
                {
                    'action'     :'search_complaint',
                    'cnic'       :cnic,
                    'cmp_num'    :cmp_num,
                    'comp_type'  :comp_type,
                    'cmp_status' :cmp_status,
                    'FromDate'   :FromDate,
                    'ToDate'     :ToDate,
                    'agent'      :agent,
                    'policy_num' :policy_num
                },
                type: 'POST',
                url: "includes/ajax/action_complaint.php",
                success: function(data) 
                {
                    //alert(data);
                    console.log(data);
                    var result = data.split("|");
                    
                    if(result[0] == 'success')
                    {
                        $('#cmp_grid').DataTable().destroy();
                        $('#cmp_grid').html(result[1]);                       
                        $('#cmp_grid').DataTable({
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
        var dt = $('#cmp_grid').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "searching": false,
            /*"language": 
            {
                searchPlaceholder: "Enter Complaint ID / Policy # / Customer Name / AssignedTo / AssignedBy"
            },*/
            "order": [[ 0, "desc" ]],
            /*"responsive": true,*/
            "scrollX": true,
            "ajax":
            {
                url : "data-table-query/response_cmp.php", //JSON Data Source
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
                'width':'420px',
                'display':'inline-block'
            }
        );*/

        /*$(window).load(function(){
            var iets = $('.dataTables_filter input');
            iets.unbind().bind("keyup", function (e) {
                if(iets.val().length >= 3) {
                    dt.search(iets.val()).draw();
                }
                if(iets.val() === ""){
                    dt.search(iets.val()).draw();
                }
            });
        });*/
    });
    function exportCmpRawData(){
        var txtFromDate = document.getElementById("txtFromDate").value;
        var txtToDate   = document.getElementById("txtToDate").value;
                if (
            (txtFromDate !== "" && txtToDate === "") ||
            (txtFromDate === "" && txtToDate !== "")
        ) {
            alert("Please select both From Date and To Date.");
            return false;
        }
        var url = "raw_data/export_cmp_raw_data.php?" +
        "cnic_se=" + encodeURIComponent(document.getElementById("cnic_se").value) +
        "&cmp_num=" + encodeURIComponent(document.getElementById("cmp_num").value) +
        "&comp_type=" + encodeURIComponent(document.getElementById("comp_type").value) +
        "&Agent_Name=" + encodeURIComponent(document.getElementById("Agent_Name").value) +
        "&cmp_status=" + encodeURIComponent(document.getElementById("cmp_status").value) +
        "&txtFromDate=" + encodeURIComponent(document.getElementById("txtFromDate").value) +
        "&txtToDate=" + encodeURIComponent(document.getElementById("txtToDate").value) +
        "&policy_num=" + encodeURIComponent(document.getElementById("policy_num").value);

        window.location.href = url;
    }

    function exportLegCmpRawData(){
        var txtFromDate = document.getElementById("txtFromDate").value;
        var txtToDate   = document.getElementById("txtToDate").value;
                if (
            (txtFromDate !== "" && txtToDate === "") ||
            (txtFromDate === "" && txtToDate !== "")
        ) {
            alert("Please select both From Date and To Date.");
            return false;
        }
        var url = "raw_data/export_legcmp_raw_data.php?" +
        "cnic_se=" + encodeURIComponent(document.getElementById("cnic_se").value) +
        "&cmp_num=" + encodeURIComponent(document.getElementById("cmp_num").value) +
        "&comp_type=" + encodeURIComponent(document.getElementById("comp_type").value) +
        "&Agent_Name=" + encodeURIComponent(document.getElementById("Agent_Name").value) +
        "&cmp_status=" + encodeURIComponent(document.getElementById("cmp_status").value) +
        "&txtFromDate=" + encodeURIComponent(document.getElementById("txtFromDate").value) +
        "&txtToDate=" + encodeURIComponent(document.getElementById("txtToDate").value) +
        "&policy_num=" + encodeURIComponent(document.getElementById("policy_num").value);

        window.location.href = url;
    }
    $(document).ready(function () {
    $('.row input, .row select').on('keypress', function (e) {
            if (e.which === 13) {
                e.preventDefault(); // Prevent form submission
                search();
            }
        });
    });
</script>

</body>
</html>