<?php
$page_title = "View News & Announcement";
$permission_type = "view";
$module_id = "15";
$parent_id = '23';
$menu_id = "news_view";

include('includes/header.php');
include('classes/news.php');
include('classes/group.php');

$objNews = new News();
$objGroup = new Group();

$data = $objNews->GetNews($_SESSION['login_id'],$user_type);
$groups = $objGroup->GetGroups();
$dis_login = ($data[0]['sender'] != $login_id)? "disabled='true'" : "";
//print_r($data);
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">News & Announcement</a></li>
        <li class="active">View News & Announcement</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">News & Announcement</h1>
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
                    <h4 class="panel-title">News & Announcement</h4>
                </div>

                <div class="panel-body">
                    <fieldset>
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject/Title</th>
                                    <th>Send To</th>
                                    <th>Detail</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($data as $news) {
                                    $recipientName = $objNews->GetGroupById($news['recipient']);
                                ?>
                                <tr>
                                    <td><?php echo $news['subject'];?></td>
                                    <td><?php echo $recipientName;?></td>
                                    <td style="width: 40%;"><?php echo $news['detail'];?></td>
                                    <td>
                                        <?php if($news['file'] != 0 ){?>
                                         <a class="btn btn-primary btn-sm"  target="blank" href="uploads_announcement/<?php echo $news['file']?>" download>
                                            Attachment <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <?php } ?>
                                        </td>

                                    <td class="center">
                                        <a class="btn btn-primary btn-sm" href="news_add.php?id=<?php echo $news['id']?>" <?php echo $dis_login?>>
                                            Edit <i class="glyphicon glyphicon-edit icon-white" ></i>
                                        </a>
                                        <!-- <a class="btn btn-danger btn-sm" href="#">
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
<script src="assets/js/table-manage-buttons.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        //TableManageDefault.init();
        TableManageButtons.init();

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