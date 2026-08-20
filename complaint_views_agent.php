<?php

$page_title = "Complaint Views";
$permission_type = "";
$module_id = "0";
$menu_id = "complaint_agent";


include('includes/header.php');
include('classes/complaint.php');

$objComplaint = new Complaint();
$data = $objComplaint->GetComplaint($login_id,0);

$heading = "Complaint Management";
?>


<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Complaint</a></li>
        <!--<li class="active">View Complaints</li>-->
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
                        <div class="col-md-2">
                            <a href="complaint_add_agent.php" class="btn btn-xs btn-primary">Add Complaint</a>
                        </div>
                    </div>
                    <h4 class="panel-title">View Complaints</h4>
                </div>
                <div class="panel-body">

                    <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Complaint ID</th>
                                <th>Released By</th>
                                <th>Role ID</th>
                                <th>Location</th>
                                <th>Product</th>
                                <th>Complaint Type</th>
                                <th>Progress</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Assignee</th>
                                <th>Due Date</th>
                                <!--<th>Forward Date</th>-->
                                <th>Closed Date</th>
                                <!--<th>Last UpDate</th>-->
                                <th>Created Date</th>
                                <th>Lead Time</th>
                                <!--<th>Check</th>-->
                                <!--<th>Action</th>-->
                            </tr>
                            </thead>

                            <tbody>

                            <?php

                            foreach($data as $row){

                                /*open 	= info
                                inprogress	= info
                                closed		= warning
                                verified	= success
                                overdue		= important*/

                                $status = "";
                                $check_over = $objComplaint->CheckOverDue($row["end_date"]);
                                $lead_time = $objComplaint->LeadTime($row["create_date"], $row["close_date"]) . " Day(s)";

                                if($row["status_id"] == '1'){

                                    $status = strtoupper($row["status"]);
                                    $label = "info";

                                }
                                else if($row["status_id"] == '2'){
                                    //only in progress status check for overdue
                                    if($check_over == 1){
                                        $status = "OVERDUE";
                                        $label = "danger";
                                    }else{
                                        if($user_type == 4)
                                            $status = "IN PROGRESS";
                                        else
                                            $status = "FORWARD";

                                        $label = "info";
                                    }

                                }else if($row["status_id"] == '4'){

                                    $status = strtoupper($row["status"]);
                                    $label = "success";

                                }
                                else if($row["status_id"] == '3'){

                                    $status = strtoupper($row["status"]);
                                    $label = "warning";

                                }else if($row["status_id"] == '5'){

                                    $status = strtoupper($row["status"]);
                                    $label = "inverse";

                                }
                                ?>

                                <tr>
                                    <td>
                                        <a href="complaint_details_agent.php?id=<?php echo $row['complaint_id']; ?>" title="Click here to see Details"><? echo $row["complaint_num"] ?></a>
                                    </td>
                                    <td><? echo $row["agent_name"] ?></td>
                                    <td>Role</td>
                                    <td>KHI</td>
                                    <td><? echo $row["product_name"] ?></td>
                                    <td><? echo $row["type"] ?></td>
                                    <td><? echo $row["progress"] == 0 ? 'N/A' : $row["progress"] . '%' ?></td>
                                    <td><? echo $row["priority"] ?></td>
                                    <td> <span class='label label-<? echo $label ?>'><? echo $status ?></span> </td>
                                    <td><? echo $row["group_fullname"] == "" ? "Not Assign" : $row["group_fullname"] ?></td>
                                    <td><? echo $row["end_date"] ?></td>
                                    <!--<td style="text-align: center;"><?/* echo $row["forward_date"] */?></td>-->
                                    <td><? echo $row["close_date"] != '0000-00-00 00:00:00' ? $row["close_date"] : '-' ?></td>
                                    <!--<td><?/* echo $row["create_date"] */?></td>-->
                                    <td><? echo $row["create_date"] ?></td>
                                    <td><? echo $row["close_date"] != '0000-00-00 00:00:00' ? $lead_time : '-' ?></td>
                                    <!--<td><?/* echo $check_over */?></td>-->

                                    <!--<td class="center">
                                                    <a class="btn btn-info btn-sm" href="complaint_details.php?id=<?php /*echo $row['complaint_id']; */?>">
                                                        Details <i class="glyphicon glyphicon-edit icon-white"></i>
                                                    </a>
                                                </td>-->

                                </tr>


                            <?php }

                            ?>

                            </tbody>
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
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        TableManageDefault.init();
    });
</script>

</body>
</html>
