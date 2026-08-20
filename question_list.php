<?php

$page_title = "KYC Manager";
$permission_type = "view";
$module_id = "3";
$menu_id = "question_list";

include('includes/header.php');
include('classes/question.php');
$objQuestion = new Question();

$data = $objQuestion->GetQuestion(0);

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
        <li><a href="javascript:;">Question Manager</a></li>
        <li class="active">View KYC</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header"><? echo $page_title; ?></h1>
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
                    <h4 class="panel-title">View KYC</h4>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>GDCI ID</th>
                            <th>Question</th>
                            <th style="text-align: center;">Set ID</th>
                            <th style="text-align: center;">Is Active</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($data as $row){ ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['gdci_id']; ?></td>
                                <td><?php echo $row['question']; ?></td>
                                <td style="text-align: center;"><?php echo $row['set_id']; ?></td>
                                <td style="text-align: center;"><input type="checkbox" <?php echo ($row['isactive'] ? "checked='checked'" : ""); ?> disabled="disabled"></td>
                                <td class="center">
                                    <a class="btn btn-info btn-sm checkUpdate" href="question_add.php?id=<?php echo $row['id']; ?>">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="">
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
