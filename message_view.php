<?php
$page_title = "View Message";
$permission_type = "view";
$module_id = "14";
$parent_id = '22';
$menu_id = "message_view";

include('includes/header.php');
include('classes/messages.php');

$objMessage = new Message();
$data = $objMessage->GetMessages($login_id);
$users = $objUser->GetUsers(0);
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
        <li><a href="javascript:;">Messages</a></li>
        <li class="active">View Messages</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Message</h1>
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
                    <h4 class="panel-title">View Messages</h4>
                </div>

                <div class="panel-body">
                    <fieldset>
                        <table id="myTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject/Title</th>
                                    <th>Recipient</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($data as $msg) {
                                    $recipientName = $objUser->GetUserNameById($msg['recipient']);
                                ?>
                                <tr>
                                    <td style="width: 20%;"><?php echo $msg['subject'];?></td>
                                    <td style="width: 20%;"><?php echo $recipientName;?></td>
                                    <td style="width: 55%;"><?php echo $msg['message'];?></td>
                                    <td  style="width: 05%;" class="center">
                                        <a class="btn btn-primary btn-sm checkUpdate" href="message_create.php?id=<?php echo $msg['id']?>">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <!-- <a class="btn btn-danger btn-sm checkDelete" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a> -->
                                    </td>
                                </tr>
                               <?php } ?>
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
<?php include('includes/footer.php'); ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/buttons.colVis.min.js"></script>
<script src="assets/js/table-manage-buttons.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        TableManageButtons.init();
    });

    $(document).ready(function() {
        $('#myTable').DataTable( {
            dom: 'Bfrtip',
            columnDefs: [
                {
                    targets: 1,
                    className: 'noVis'
                }
            ],
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
                    }
                },
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                }
            ]
        } );
    } );
</script>

</body>
</html>