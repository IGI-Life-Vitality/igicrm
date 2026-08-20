<?php
$page_title = "Session History List";
$permission_type = "view";
$module_id = "0";
$menu_id = "interaction_view";

include('includes/header.php');

$objUser = new User();

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
        <li class="active"><a href="javascript:;">Session History List</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Interactions</h1>
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
                    <h4 class="panel-title">Session History List</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Session ID</th>
                            <th>Interaction Date/Time</th>
                            <th>Channel</th>
                            <th>Interaction Officer</th>
                            <th>Interaction Outcome</th>
                            <th>Remarks</th>
                        </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td><a href="#">000005160</a></td>
                                <td>06/11/2017 15:18:00</td>
                                <td>Call Center</td>
                                <td>Admin</td>
                                <td>none</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td><a href="#">000005159</a></td>
                                <td>06/11/2017 15:16:00</td>
                                <td>Call Center</td>
                                <td>Admin</td>
                                <td>none</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td><a href="#">000005158</a></td>
                                <td>06/11/2017 15:12:00</td>
                                <td>Call Center</td>
                                <td>Admin</td>
                                <td>none</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td><a href="#">000005157</a></td>
                                <td>06/11/2017 15:00:00</td>
                                <td>Call Center</td>
                                <td>Admin</td>
                                <td>none</td>
                                <td></td>
                            </tr>

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
