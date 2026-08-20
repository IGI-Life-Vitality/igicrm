<?php
$page_title = "ISM Views";
$permission_type = "view";
$module_id = "34";
$parent_id ="26";
$menu_id = "ism_types";

include('includes/header.php');
include('classes/taskcat.php');

$objTaskcat = new Taskcat();
$data = $objTaskcat->GetIsamList(0);

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
        <li><a href="javascript:;">ISM</a></li>
        <li class="active">View ISM Types</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">View ISM Types</h1>
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
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ISM</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>TAT</th>
                            <th>User</th>
                            <!--<th>Escalation Time Period</th>-->
                            <!--<th>Level 1</th>
                            <th>Level 2</th>-->
                            <th style="text-align: center;">Is Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach($data as $row){ ?>

                            <tr>
                                <td><? echo $row["id"] ?></td>
                                <td><? echo $row["fullname"] ?></td>
                                <td><? echo $objTaskcat->GetCategoryNameById($row["task_category_id"]); ?></td>
                                <td><? echo $objTaskcat->GetSubCategoryNameById($row["sub_cat_id"]); ?></td>
                                <td><? echo $row["tat"] ?> hours</td>
                                <td><? echo $objUser->GetUserNameById($row["user_id"]); ?></td>
                                <!--<td><?/* echo $row["time_period"] */?>%</td>-->
                                <!--<td><?/* echo $row["level_1"] */?></td>
                                <td><?/* echo $row["level_2"] */?></td>-->

                                <td style="text-align: center;"><input type="checkbox" <?php echo ($row['isactive'] ? "checked='checked'" : ""); ?> disabled="disabled"></td>

                                <td class="center">
                                    <a class="btn btn-primary btn-sm checkUpdate" href="ism_add.php?id=<?php echo $row['id']; ?>">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return show_confirm(<?php echo $row['id']; ?>);">
                                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                    </a>
                                </td>

                            </tr>

                        <?php } ?>

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
