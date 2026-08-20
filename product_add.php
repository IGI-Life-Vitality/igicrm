<?php

$page_title = "Product";
$permission_type = "create";
$module_id = "13";
$parent_id = '21';
$menu_id = "product_add";
$title= '';
include('includes/header.php');
include('classes/product.php');

$objProduct = new Product();

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data = $objProduct->GetProductsActive($id);
        $heading = "Edit Product";
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $title .= "<li><a href='product_view.php'> View Products </a></li>";
        $title .= "<li> Edit Product </li>";

    }
    else{
        $heading = "Add Product";
        $isactive = "checked='checked'";
        $title .= "<li class='active'> Add Product </li>";
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
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="">Product Manager</a></li>
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Product Manager</h1>
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
                    </div>
                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" id="ProductTypeForm">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="Id" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Product Code</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtProductCode" value="<?php echo($data[0]['product_code']); ?>" placeholder="Product Code"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product Code is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Product Category</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlProductCategory" name="ddlProductCategory" title="Please select something!">
                                    <option value="0">Select Product Category</option>
                                    <?php $product_categories = $objProduct->GetProductCategory(0); ?>
                                    <?php foreach($product_categories as $product_category){ ?>
                                        <option value="<? echo $product_category["id"]; ?>"<?php echo ($data[0]["product_category"] == $product_category["id"] ? "selected='selected'" : ""); ?>><? echo $product_category["fullname"] ?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product Category is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Product</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($data[0]['fullname']); ?>" placeholder="Product Name" onkeypress="return validateAlphabets(event)" />
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product Name is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <input type="checkbox" id="chkIsActive" name="chkIsActive" <?php echo ($isactive); ?> />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <!--<button type="button" class="btn btn-sm btn-info" id="btnProductSave">Save</button>-->
                                <button type="button" class="btn btn-primary btn-sm" id="btnProductSave" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
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

        /*$.notifyBar({ cssClass: "success", html: "Data Saved Successfully..!", close: true, waitingForClose: true, closeOnClick: false });

        $.notifyBar({
            html: "Thank you, your settings were updated!",
            delay: 2000,
            animationSpeed: "normal"
        });*/

        $(document).on('click', '#btnProductSave', function () {

            var id = $('#txtId').val() != 0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save" : "edit";
            var name = $('#txtName').val();
            var product_code = $('#txtProductCode').val();
            var product_category = $('#ddlProductCategory').val();
            var is_active = $('#chkIsActive').is(":checked") ? 1 : 0;

            if (validation()) {

                $("#btnProductSave").button('loading');

                $.ajax({
                    data: {
                        'action': action,
                        'id': id,
                        'fullname': name,
                        'product_category': product_category,
                        'product_code': product_code,
                        'isactive': is_active
                    },
                    type: 'POST',
                    url: "includes/ajax/action_product.php",
                    success: function (data) {

                        $("#btnProductSave").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);

                        if (data == 'success') {
                            clear_values();
                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "product_list.php" }, 3000);
                        } else if (data == 'fail') {
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });

            }
        });
    });

    function clear_values(){
        $('#txtId').val('');
        $('#txtName').val('');
        $('#txtProductCode').val('');
        $('#ddlProductCategory').empty();
    }

    function validation(){

        var hasFocus = false;
        var errCount = 0;

        if ($('#txtProductCode').val() == '') {

            $('#txtProductCode').addClass('error-val');
            $('#txtProductCode').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtProductCode').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtProductCode').removeClass('error-val');
            $('#txtProductCode').parent().find('.input-error').hide();
        }

        if ($('#ddlProductCategory').val() == 0) {

            $('#ddlProductCategory').addClass('error-val');
            $('#ddlProductCategory').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlProductCategory').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#ddlProductCategory').removeClass('error-val');
            $('#ddlProductCategory').parent().find('.input-error').hide();
        }

        if ($('#txtName').val() == '') {

            $('#txtName').addClass('error-val');
            $('#txtName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtName').removeClass('error-val');
            $('#txtName').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }



</script>


</body>
</html>

