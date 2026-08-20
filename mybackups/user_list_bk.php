<?php
$page_title = "Users";
$group_id = "user_management";
$menu_id = "user_view";

include('includes/header.php');

$objUser = new User();
$data = $objUser->GetUsers(0);

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
        <li><a href="javascript:;">User Management</a></li>
        <li class="active">View Users</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">User Management</h1>
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
                    <h4 class="panel-title">View Users</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off">
                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Id</label>
                                        <input type="text" class="form-control" id="txtName" />
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>User Id</label>
                                        <input type="text" class="form-control" id="txtUserId" />
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" data-parsley-required="true" id="ddlActive" name="ddlActive">
                                            <option value="1">Active</option>
                                            <option value="2">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-info button_margin">Search</button>
                                        <button type="reset" class="btn btn-sm btn-info button_margin">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br><hr>
                        <fieldset>
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User Id</th>
                                    <th>User Name</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Create Date</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>

                                <?php foreach ($data as $row){ ?>

                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td><?php echo $row['user_name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td style="text-align: center;"><input type="checkbox" <?php echo ($row['isactive'] ? "checked='checked'" : ""); ?> disabled="disabled"></td>
                                        <td><?php echo $row['create_datetime']; ?></td>
                                        <td><?php echo $row['last_login']; ?></td>

                                        <td class="center">
                                            <a class="btn btn-info btn-sm" href="user_add.php?id=<?php echo $row['id']; ?>">
                                                Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="#" onclick="javascript:return show_confirm(<?php echo $row['id']; ?>);">
                                                Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php } ?>

                                </tbody>

                            </table>
                        </fieldset>



                    </form>
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

<script type="text/javascript">

    function EditUser() {
        window.location.href = "user_add.php";
    }

</script>

</body>
</html>
