<?php
$page_title = "View Documents";
$permission_type = "view";
$module_id = "16";
$parent_id = '24';
$menu_id = "documents_view";


include('includes/header.php');
include('classes/document.php');
include('classes/group.php');

$objDocs = new Docs();
$objGroup = new Group();

$data = $objDocs->GetDocs($_SESSION['login_id']);
$groups = $objGroup->GetGroups();

//print_r($data);die;
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
        <li><a href="javascript:;">View Documents</a></li>
        <li class="active">View Documents</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Document</h1>
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
                    <h4 class="panel-title">View Documents</h4>
                </div>
                <div class="panel-body">

                    <fieldset>
                        <legend> Documents Search</legend>
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
                                        <label class="">Subject/Title</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Send To</label>
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
                                <th>Subject/Title</th>
                                <th>Detail</th>
                                <th>Category</th>
                                <th>Owner</th>
                                <th>Share</th>
                                <th>Attachment</th>
                                <th>Action</th>
                            </tr>

                            </thead>

                            <tbody>
                                <?php foreach($data as $doc){
                                    if($doc['share'] == "1"){
                                        $shareName = $objUser->GetUserById($doc['share_user']);
                                    }else if($doc['share'] == "2"){
                                        $shareName = $objGroup->GetGroupById($doc['share_user']);
                                    }
                                    $catName = $objDocs->GetCatById($doc['cat']);
                                    $owner = $objUser->GetUsers($doc['owner']);

                                    ?>
                                <tr>
                                    <td><?php echo $doc['subject'];?></td>
                                    <td><?php echo $doc['detail'];?></td>
                                    <td><?php echo $catName;?></td>
                                    <td><?php echo $owner[0]['user_name'];?></td>
                                    <td><?php echo $shareName;?></td>
                                    <td>
                                        <?php if($doc['file'] != ''){?>
                                         <a class="btn btn-primary btn-sm"  target="blank" href="documents/<?php echo $doc['file']?>">
                                            Attachment <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <?php } ?>
                                    </td>

                                    <td class="center">
                                        <a class="btn btn-primary btn-sm" href="document_add.php?id=<?php echo $doc['id']?>">
                                            Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                        </a>
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


