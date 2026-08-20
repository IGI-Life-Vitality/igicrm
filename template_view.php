<?php

$page_title = "View Template";
$permission_type = "view";
$module_id = "9";
$parent_id ="20";
$menu_id = "template_view";


include('includes/header.php');
include('classes/templates.php');

$objTemplate = new Templates();

$data = $objTemplate->GetTemplates();
//print_r($data);

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
        <li><a href="javascript:;">Template Manager</a></li>
        <li class="active">View Template</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Template Manager</h1>
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
                    <h4 class="panel-title">View Template</h4>
                </div>
                <div class="panel-body">

                    <fieldset>
                        <legend>Template Search</legend>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <div class="input-group" id="default-daterange">
                                            <input type="text" name="default-daterange" class="form-control" value="" placeholder="Click To Select Date Range">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <div class="input-group" id="default-daterange">
                                            <input type="text" name="default-daterange" class="form-control" value="" placeholder="Click To Select Date Range">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="">Template Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Template Type</label>
                                        <select class="form-control" id="ddlTemplateType" name="ddlTemplateType">
                                            <option value="0">Select Template Type</option>
                                            <option value="1">Attachement</option>
                                            <option value="2">Email</option>
                                            <option value="3">SMS</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary">Search</button>
                                        <button type="reset" class="btn btn-sm btn-primary">Reset</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Template Name</th>
                                <th>Template Type</th>
                                <th>Modified Date</th>
                                <th>Action</th>
                            </tr>

                            </thead>

                            <tbody>
                                <?php foreach($data as $temp){?>
                                <tr>
                                    <td><?php echo $temp['id'];?></td>
                                    <td><?php echo $temp['template_name'];?></td>
                                    <td><?php echo $temp['template_type'];?></td>
                                    <td><?php echo $temp['update_date'];?></td>

                                    <td class="center">
                                        <a class="btn btn-primary btn-sm checkUpdate" href="template_add.php?id=<?php echo $temp['id']?>">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm checkDelete" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>
                               <?php } ?>
<!--
                                <tr>
                                    <td>2</td>
                                    <td>Balance Inquiry By Email (Collection Acct)</td>
                                    <td>Attachment</td>
                                    <td>02/11/2017 15:20:00</td>

                                    <td class="center">
                                        <a class="btn btn-info btn-sm" href="template_add.php">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Balance Inquiry By Email (Current Acct)</td>
                                    <td>Attachment</td>
                                    <td>02/11/2017 15:18:00</td>

                                    <td class="center">
                                        <a class="btn btn-info btn-sm" href="template_add.php">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>Balance Inquiry By Email (Deposit Acct)</td>
                                    <td>Attachment</td>
                                    <td>02/11/2017 15:18:00</td>

                                    <td class="center">
                                        <a class="btn btn-info btn-sm" href="template_add.php">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>

                                <tr>
                                    <td>5</td>
                                    <td>Balance Inquiry By Email (Saving Acct)</td>
                                    <td>Attachment</td>
                                    <td>02/11/2017 15:18:00</td>

                                    <td class="center">
                                        <a class="btn btn-info btn-sm" href="template_add.php">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>

                                <tr>
                                    <td>6</td>
                                    <td>Credit Card Inquiry By Email</td>
                                    <td>Attachment</td>
                                    <td>02/11/2017 15:18:00</td>

                                    <td class="center">
                                        <a class="btn btn-info btn-sm" href="template_add.php">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
                                    </td>

                                </tr>-->

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

        /*if ($.fn.DataTable.isDataTable("#data-table1")) {
         $('#data-table1').DataTable().clear().destroy();
         }

         var oTable = $('#data-table1').dataTable( {
         "aaSorting": [[ 7, "desc" ]]
         });*/
    });
</script>

</body>
</html>


