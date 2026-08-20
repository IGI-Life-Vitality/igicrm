<?php

$page_title = "Organization Unit";
$permission_type = "create";
$module_id = "8";
$menu_id = "unit_add";

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
        <li class="active">Add Organization Unit</li>
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
                    <h4 class="panel-title">Organization Unit</h4>
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
                            <label class="col-md-3 control-label-my">Parent Organization<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-5">
                                <select class="form-control" data-parsley-required="true" id="ddlParent" name="ddlParent">
                                    <option value="">--Select--</option>
                                    <option value="">ABC</option>
                                    <option value="">XYZ</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Organization Type<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-5">
                                <select class="form-control" data-parsley-required="true" id="ddlOrganization" name="ddlOrganization">
                                    <option value="">Branch</option>
                                    <option value="">MNO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Unit Name</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="txtUnitName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Full Name<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtFullName" id="txtFullName">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Hierarchy Level<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtHierarchy" id="txtHierarchy">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Other Code 1</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtCode1" id="txtCode1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Other Code 2</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtCode2" id="txtCode2">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Other Code 3</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtCode3" id="txtCode3">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Address</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="txtAddress" id="txtAddress">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Phone Number</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="txtPhone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">E-Mail Address</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="txtEmail">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label-my">Short Name</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="txtShortName">
                            </div>
                        </div>


                        <br>
                        <div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-5">
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
