<?php
$page_title = "City Area Add";
$permission_type = "create";
$module_id = "44";
$parent_id ="20";
$menu_id = "area_add";

include('includes/header.php');
include('classes/product.php');


$objProd = new Product();

$users = $objUser->GetUsers(0);
$regions = $objProd->GetRegion();


if(isset($_GET))
{
    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $data = $objProd->GetArea($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked" : "";
        $heading = "Edit Area";
        $display_none = "display: block";
    }
    else
    {
        $heading = "Add Area";
        $isactive = "checked";
        $display_none = "display: none";
        $isdisable = "";
    }


    //print_r($data);
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
        <li><a href="javascript:;">Administration</a></li>
        <li class="active"><? echo $heading; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Administration</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>

                <div class="panel-body">
                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                    </div>

                    <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                        <strong>Error!</strong>
                        Error while saving record, Please try again!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <form class="form-horizontal" autocomplete="off">
                        <div class="form-group" style="display: none">
                            <label class="col-md-2 control-label-my">ID</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="ID" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Region<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="region" name="region" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option selected="selected" value="" disabled="disabled">Select Region</option>
                                    <?php //$task_categories = $objTaskcat->GetTaskCategory();  ?>
                                    <?php foreach($regions as $region){ ?>
                                        <option value="<? echo $region["id"]; ?>"<?php echo ($data[0]["region_id"] == $region["id"] ? "selected='selected'" : ""); ?>><? echo $region["fullname"] ?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Region is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">City<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <?php if($data[0]['city_id'] > 0){ ?>
                                    <select class="form-control default-select2" id="city" name="city" data-placeholder="Select Product">
                                        <option selected="selected" value="" disabled="disabled">Select City</option>
                                        <?php $cities = $objProd->GetCity(0); ?>
                                        <?php foreach($cities as $city){ ?>
                                            <option value="<? echo $city["id"]; ?>"<?php echo ($data[0]["city_id"] == $city["id"] ? "selected='selected'" : ""); ?>><? echo $city["fullname"] ?></option>
                                        <? } ?>
                                    </select>
                                <?php }else{ ?>
                                     <select class="form-control default-select2" id="city" name="city" data-placeholder="Select City">
                                    </select> 
                                <?php } ?>
                                <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Area Name<span style="color: red; font-size: 16px;">*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($data[0]['area']); ?>" placeholder="Enter Area"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Area Name is required</div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="col-md-2 control-label-my"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveArea" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
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

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var counter = 1;

        $("#region").change(function () {
            var region = $(this).val();
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_product.php",
                data:
                {
                    action : "select_city",
                    id: region
                }
            }).done(function (data) {
                //alert(data);
                $('#city').html(data);
            });
        });

        $(document).on('click', '#btnSaveArea', function () {
            var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
            var action = id == 0 ? "save_area" : "edit_area";
            var fullname = $('#txtName').val();
            var region_id = $('#region').val();
            var city = $('#city').val();
            
            //alert(isactive);
            if(validation())
            {
                $("#btnSaveArea").button('loading');

                $.ajax({
                    data: 
                    {
                        'action'            : action,
                        'id'                : id,
                        'fullname'          : fullname,
                        'region_id'         : region_id,
                        'city'              : city
                    },
                    type: 'POST',
                    url: "includes/ajax/action_product.php",
                    success: function(data) 
                    {
                        $("#btnSaveArea").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);
                        $('html, body').animate({scrollTop: 0}, 600);

                        if(data == 'success')
                        {

                            $.notifyBar({ cssClass: "success", html: "Area Saved Successfully", delay: 2000, animationSpeed: "normal" });

                            setTimeout(function () {
                                window.location.href = "area_view.php"
                            }, 2000);
                        }
                        else
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });

            }
        });

    });

   

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

    
        if($('#region').val() == null ) 
        {
            $('#region').addClass('error-val');
            $('#region').parent().find('.input-error').show().css('display', 'inline-block');
            $('#region').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#region').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#region').removeClass('error-val');
            $('#region').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#region').parent().find('.input-error').hide();
        }

        // For ISM OK
        if($('#txtName').val() == '') 
        {
            $('#txtName').addClass('error-val');
            $('#txtName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtName').parent().find('.input-error').hide();
        }

       

        // For TAT OK
        if($('#city').val() == null) 
        {
            $('#city').addClass('error-val');
            $('#city').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#city').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#city').removeClass('error-val');
            $('#city').parent().find('.input-error').hide();
        }

        

        if (errCount > 0)
            return false;
        else
            return true;
    }

    
</script>

</body>
</html>