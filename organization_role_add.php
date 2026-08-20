<?php
$page_title = "Organization Role";
$permission_type = "create";
$module_id = "7";
$menu_id = "role_add";

include('includes/header.php');

$heading = "User Management";

?>

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<link href="assets/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL JS ================== -->



<!-- begin #content -->
<div id="content" class="content">

    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">User Management</a></li>
        <li class="active">Add Organization Role</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><?php echo $heading ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Organization Role</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" action="#" method="post">

                        <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                        </div>
                        <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                            <strong>Error!</strong>
                            Error while saving record, Please try again!
                            <span class="close" data-dismiss="alert">&times;</span>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Primary Role Name<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtPrimaryRoleName" id="txtPrimaryRoleName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Secodary Role Name<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtSecodaryRoleName" id="txtSecodaryRoleName">
                            </div>
                        </div>

                        <br>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Parent Role<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <div id="jstree-default">
                                    <ul>
                                        <li data-jstree='{"opened":true, "selected":true }'>ATM Service Officer</li>
                                        <li>Call Agent</li>
                                        <li data-jstree='{"opened":false}' >
                                            Complaint Manager
                                            <ul>
                                                <li data-jstree='{"disabled":true}' >Disabled node</li>
                                                <li>Another node</li>
                                            </ul>
                                        </li>

                                        <li data-jstree='{"opened":false}' >
                                            E-Form Controller
                                            <ul>
                                                <li>Node 1</li>
                                                <li>Node 2</li>
                                            </ul>
                                        </li>
                                        <li>E-Form Handler Role</li>
                                        <li>General</li>
                                        <li>Manager</li>
                                        <!--<li data-jstree='{ "icon" : "fa fa-warning fa-lg text-danger" }'>custom icon class (fontawesome)</li>-->
                                        <li data-jstree='{"opened":false}'>
                                            RM Sales Manager
                                            <ul>
                                                <li>Node 3</li>
                                                <li>Node 4</li>
                                            </ul>
                                        </li>
                                        <li data-jstree='{"opened":false}'>
                                            Sales Manager
                                            <ul>
                                                <li>Gulshan Branch</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary">Save</button>
                                <button type="button" class="btn btn-sm btn-primary">Cancel</button>
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
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>
<script src="assets/plugins/jstree/dist/jstree.min.js"></script>
<script src="assets/js/ui-tree.demo.min.js"></script>

<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        TreeView.init();
        Notification.init();
    });
</script>


<script type="text/javascript">
</script>

</body>
</html>
