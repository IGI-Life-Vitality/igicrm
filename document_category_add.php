<?php

$page_title = "Document Category";
$permission_type = "create";
$module_id = "16";
$parent_id = '24';
$menu_id = "document_category_add";
include('includes/header.php');
include('classes/document.php');

$objDocs = new Docs();
$all_doc_cat = $objDocs->GetCats();
if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data     = $objDocs->GetDocsCategory($id);
        $isactive = $data[0]['is_active'] == 1 ? "checked='checked'" : "";
        $heading  = "Edit Document Category";
        $title    =  "Edit Document Category";
    }
    else{
        $heading  = "Add Document Category";
        $isactive = "checked='checked'";
        $title   = "Add Document Category";
    }
}

?>



<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />

<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>

<!-- ================== END PAGE LEVEL STYLE ================== -->




<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class='active'><a href="javascript:;">Document Category</a></li>
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->
      <div class="noty_bar noty_theme_default noty_layout_top noty_success NotificationDiv" id="notify_success_insert" style="cursor: pointer; display: none;">
    <div class="noty_message">
        <span class="noty_text">Record Saved Successfully</span>
    </div>
</div>

<div class="noty_bar noty_theme_default noty_layout_top noty_error NotificationDiv" id="notify_error_insert" style="cursor: pointer; display: none;">
    <div class="noty_message">
        <span class="noty_text">Error while saving record, Please try again!</span>
    </div>
</div>
   

    <!-- begin page-header -->
    <h1 class="page-header">Document Category</h1>
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



                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" action="" method="POST">
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtcategoryId" value="<?php echo($data[0]['id']); ?>" placeholder="Category Id" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Document Category</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtdocCategoryName" id="txtdocCategoryName" value="<?php echo($data[0]['cat_name']); ?>" placeholder="Document Category"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Document Category is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <input type="checkbox" id="chkCategoryActive" name="chkCategoryActive" <?php echo ($isactive); ?> />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnCategorySave" onclick="save();">Save</button>
                            </div>
                        </div>

                    </form>
                    <table id="data-table" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Document Category</th>
            <th>Is Active</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach ($all_doc_cat as $row){ ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['cat_name']; ?></td>
                <td><input type="checkbox" <?php echo ($row['is_active'] ? "checked='checked'" : ""); ?> disabled="disabled"></td>
                <td class="center">
                    <a class="btn btn-primary btn-sm checkUpdate" href="document_category_add.php?id=<?php echo $row['id']; ?>">
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
        <!-- end col-6 -->
    </div>
    <!-- end row -->

</div>




<!-- begin #footer -->
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="assets/plugins/clipboard/clipboard.min.js"></script>
<script src="assets/js/form-plugins.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->


<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
    });
</script>


<script type="text/javascript">
   
    $(document).ready(function() {
    });


 function save(){
            var id = $('#txtcategoryId').val() !=0 ? $('#txtcategoryId').val() : 0;
            var action = id == 0 ? "category_save" : "category_edit";
            var document_category_name = $('#txtdocCategoryName').val();
            var is_active = $('#chkCategoryActive').is(":checked") ? 1 : 0;


            if(validation()){

                $.ajax({
                    data: {
                        'action':action,
                        'id':id,
                        'category_name': document_category_name,
                        'isactive':is_active
                    },
                    type: 'POST',
                    url: "includes/ajax/action_document.php",
                    success: function(data) {
                        //alert(data);
                        console.log(data);
                        if(data == 1){
                            $('#notify_success_insert').show();
                            setTimeout(function () { window.location.href = "" }, 3000);
                        }else{
                            $('#notify_error_insert').show();
                        }
                    }
                });

            }

    }

    function validation() {

        var hasFocus = false;
        var errCount = 0;

        if ($('#txtdocCategoryName').val() == '') {

            $('#txtdocCategoryName').parents('.control-group').addClass('error');
            $('#txtdocCategoryName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtdocCategoryName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtdocCategoryName').parents('.control-group').removeClass('error');
            $('#txtdocCategoryName').parent().find('.input-error').hide();
        }

    if (errCount > 0)
        return false;
    else
        return true;
    }


</script>

</body>
</html>