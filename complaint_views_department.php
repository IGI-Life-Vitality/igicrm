<?php
$page_title = "Complaint View";
$group_id = "complaint";
$menu_id = "complaint_views_department";

include('includes/header.php');
include('classes/complaint.php');

$objComplaint = new Complaint();
$data = $objComplaint->GetComplaintByDepartment($department_id);

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
        <li class="active">View Complaints</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">View Complaints</h1>
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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">View Complaints</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Complaint ID</th>
                            <th>Product</th>
                            <th>Complaint Type</th>
                            <th>Complaint Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Complaint Date</th>
                            <th>Forward Date</th>
                            <!--<th>Test</th>-->
                            <th>Action</th>
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
                            $check_over = $objComplaint->CheckOverDue($row["forward_date"], $row["complaint_type_id"]);
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
                                    $status = strtoupper($row["status"]);
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
                                <td><? echo $row["complaint_counter"] ?></td>
                                <td><? echo $row["product_name"] ?></td>
                                <td><? echo $row["type"] ?></td>
                                <td><? echo $row["complaint_title"] ?></td>
                                <td><? echo $row["complaint_desc"] ?></td>
                                <td><span class='label label-<? echo $label ?>'><? echo $status ?></span> </td>
                                <td><? echo $row["comments"] ?></td>
                                <td><? echo $row["create_date"] ?></td>
                                <td><? echo $row["forward_date"] ?></td>
                                <!--<td><?/* echo $check_over */?></td>-->

                                <td class="center">
                                    <a class="btn btn-info btn-sm" href="complaint_details_department.php?id=<?php echo $row['complaint_id']; ?>&action=c">
                                        Details <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                                </td>

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

