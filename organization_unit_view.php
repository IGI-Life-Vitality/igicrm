<?php

$page_title = "Organization Unit";
$permission_type = "view";
$module_id = "8";
$menu_id = "unit_view";

include('includes/header.php');

$heading = "User Management";

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
        <li class="active">View Organization Unit</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><?php echo $heading?></h1>
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
                    <h4 class="panel-title">Organization Unit</h4>
                </div>
                <div class="panel-body">
                    <fieldset>
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Unit Name</th>
                                    <th>Created Date</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">1</a>
                                    </td>
                                    <td>Abu Dhabi Branch</td>
                                    <td>1-Nov-2016</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">2</a>
                                    </td>
                                    <td>Ajman</td>
                                    <td>2-Nov-2016</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">3</a>
                                    </td>
                                    <td>Al Ain Branch</td>
                                    <td>3-Nov-2016</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">4</a>
                                    </td>
                                    <td>Al Awir Branch</td>
                                    <td>3-Nov-2016</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">5</a>
                                    </td>
                                    <td>Al Maktoum Branch</td>
                                    <td>4-Nov-2016</td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">6</a>
                                    </td>
                                    <td>Al Qusais Branch</td>
                                    <td>4-Nov-2016</td>
                                </tr>


                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">7</a>
                                    </td>
                                    <td>Baniyas Branch</td>
                                    <td>5-Nov-2016</td>
                                </tr>


                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">8</a>
                                    </td>
                                    <td>Call Center</td>
                                    <td>5-Nov-2016</td>
                                </tr>


                                <tr>
                                    <td>
                                        <a href="" title="Click here to see Details">9</a>
                                    </td>
                                    <td>Diera Branch</td>
                                    <td>1-Dec-2016</td>
                                </tr>
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