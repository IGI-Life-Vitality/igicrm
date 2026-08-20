<?php
    $page_title         = "Add Leads Mapping";
    $permission_type    = "create";
    $module_id          = "38";
    $parent_id          = "35";
    $menu_id            = "leads_mapping_add";

    include('includes/header.php');

    include('classes/product.php');
    include('classes/lead.php');

    $objProd = new Product();
    $objLead = new Lead();

    if(isset($_GET))
    {
        $id  = isset($_GET['id'])?$_GET['id']:0;

        $heading = "";
        $isactive = "";

        if($id > 0)
        {
            $data       = $objLead->GetLeadsMappingById($id);
            $isactive   = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
            $heading    = "Edit Leads Mapping";
            $title      .= "<li><a href='hospital_view.php'>View Leads Mapping</a></li>";
            $title      .= "<li class='active'>Edit Leads Mapping</li>";
        }
        else
        {
            $heading    = "Add Leads Mapping";
            $isactive   = "checked='checked'";
            $title      .= "<li class='active'>Add Leads Mapping</li>";
        }
        $disabled = 'disabled=disabled';
    }
?>

<!-- ================= BEGIN PAGE LEVEL STYLE ================== -->
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
        <li><a href="javascript:;">Leads Management</a></li>
        <li class='active'><a href="javascript:;"><?php echo $heading; ?></a></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <?php 
      // echo "<pre>";
      //   print_r($data[0]);
      // echo "</pre>";
    ?>

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
                    <form class="form-horizontal" action="" method="POST" id="LeadsMapping">
                        <input type="hidden" value="<?php echo($data[0]['id']); ?>" name="leads_mapping_id" id="leads_mapping_id">
                        <input type="hidden" value="<?php echo($data[0]['lead_regional_manager']); ?>" name="leads_mapping_manager_id" id="leads_mapping_manager_id">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Region</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="region" name="region">
                                    <option value="" selected="selected" disabled="disabled"> -- Select Region -- </option>
                                    <?php $regions = $objProd->GetRegion(); ?>


                                    <?php foreach($regions as $region) { ?>
                                     <option value="<? echo $region["id"]; ?>" <?php if($data[0]['lead_region'] == $region["id"]){ echo "selected='selected'"; } ?>><? echo $region["fullname"] ?></option>
                                    <? } ?>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">City</label>
                            <div class="col-md-4">
                                 <?php if($data[0]['lead_city'] > 0){ ?>
                                <select class="form-control default-select2" id="ddlCity" name="ddlCity">
                                    <option value="" selected="selected"> -- Select -- </option>
                                    <?php $cities = $objProd->GetCity(0); ?>
                                    <?php foreach($cities as $city) { ?>
                                     <option value="<? echo $city["id"]; ?>" <?php if($data[0]['lead_city'] == $city["id"]){ echo "selected='selected'"; } ?>><? echo $city["fullname"] ?></option>
                                    <? } ?>
                                </select>
                                <?php } else { ?>
                                <select class="form-control default-select2" id="ddlCity" name="ddlCity" data-placeholder=" --- Select City --- ">
                                    </select> 
                                <?php } ?>

                                <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Regional Area</label>

                            <div class="input-group">
                                <div class="col-md-4">
                                    <? if($data[0]["id"] != "") { ?>
                                    <select class="form-control default-select2" id="ddlArea" name="ddlArea[]" data-size="10" data-live-search="true" data-style="btn-white" multiple="multiple">
                                    <?php
                                        $areas = $objLead->GetCityAreas($data[0]["lead_city"]); 
                                        //print_r($areas);
                                        $counter      = 0;
                                        $region_areas = explode(",", $data[0]["lead_region_area"]);
                                    ?>
                                    <?php foreach($areas as $area) { ?>
                                        <option value="<? echo $area["id"]; ?>" <?php echo ($region_areas[$counter] == $area["id"] ? "selected='selected'" : $counter--); ?>><? echo $area["area"] ?></option>
                                    <? $counter++; } ?>
                                    </select>
                                    <span class="add-on input-group-addon">
                                        <input type="checkbox" id="Userscheckbox" <?php //echo $disabled; ?> />
                                        <label for="Userscheckbox"> Select All </label>
                                    </span>
                                    <? } else { ?>
                                        <select class="form-control default-select2" id="ddlArea" name="ddlArea[]" data-size="10" data-live-search="true" data-style="btn-white" multiple="multiple"></select>
                                        <span class="add-on input-group-addon">
                                            <input type="checkbox" id="Userscheckbox" <?php echo $disabled; ?> />
                                            <label for="Userscheckbox"> Select All </label>
                                        </span>
                                    <? } ?>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Area is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Product Type</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="ddlProductType" name="ddlProductType" onchange="get_region_user_by_product();">
                                    <option value="" selected="selected" disabled="disabled"> -- Select Product Type -- </option>
                                    <?php $product_categories = $objProd->GetProduct(); ?>
                                    <?php foreach($product_categories as $product_names){ ?>
                                        <option value="<? echo $product_names["id"]; ?>" <?php echo $data[0]['lead_product'] == $product_names["id"] ? "selected='true'" : ''; ?>><? echo $product_names["fullname"] ?></option>
                                    <? } ?> 
                                    <!-- <option value="1" <?php //if($data[0]['lead_product'] == 1){ echo "selected='selected'"; } ?>>None-Vitality</option>
                                    <option value="3" <?php //if($data[0]['lead_product'] == 3){ echo "selected='selected'"; } ?>>Vitality</option> -->
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product type is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Regional Manager</label>
                            <div class="col-md-4">
                                <?php if($data[0]['lead_regional_manager'] > 0){ ?>
                                <select class="form-control default-select2" id="ddlRegionManager" name="ddlRegionManager">
                                    <option value="" selected="selected" disabled="disabled">Select Regional Manager</option>
                                    <?php $regional_managers = $objLead->GetRegionalManager(); ?>
                                    <?php foreach($regional_managers as $regional_manager){ ?>
                                     <option value="<? echo $regional_manager["id"]; ?>" <?php if($data[0]['lead_regional_manager'] == $regional_manager["id"]){ echo "selected='selected'"; } ?>><? echo $regional_manager["first_name"] . " " . $regional_manager["last_name"]; ?></option>
                                    <? } ?>
                                </select>
                                <?php }else{ ?>
                                <select class="form-control default-select2" id="ddlRegionManager" name="ddlRegionManager">
                                </select>
                                 <?php } ?>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Regional Manager is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveLeadsMapping">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
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

    .select2-container--default{
        width: 420px !important;
    }

    .input-group-addon{
        cursor: pointer !important;
        width: 100px !important;
        padding: 8px 10px 5px 10px !important;
        margin: -35px 0px 0px 430px !important;
        position: absolute !important;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        get_region_user_by_product()
    });
</script>

<script type="text/javascript">
    $("#Userscheckbox").click(function(){
        if($("#Userscheckbox").is(':checked') )
        {
            $("#ddlArea > option").prop("selected","selected");
            $("#ddlArea").trigger("change");
        }
        else
        {
            $("#ddlArea > option").removeAttr("selected");
            $("#ddlArea").trigger("change");
        }
    });

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
                $("#Userscheckbox").attr("disabled", false); 
                $('#ddlCity').html(data);
            });
    });

    function get_region_user_by_product()
    {
        var product = $('#ddlProductType').val();
        var pr_id   = $('#leads_mapping_manager_id').val();
        //alert(pr_id);

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_product.php",
            data:
            {
                action : "select_regional_manager",
                id     : product,
                pr_id  : pr_id
            }
        }).done(function (data) {
            //alert(data);
            //console.log(data);
            $('#ddlRegionManager').html(data);

        });
    }

    /* Lead Areas */
    $(document).on('change', '#ddlCity', function () {
        var city = $(this).val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:{
                action : "select_lead_city_area_multiselect",
                city: city
            }

        }).done(function (data) {
            /*alert(data);*/
            $('#ddlArea').html(data);
        });
    });

    $(document).ready(function() {
        $(document).on('click', '#btnSaveLeadsMapping', function () {
            var id                  = $('#leads_mapping_id').val() !=0 ? $('#leads_mapping_id').val() : 0;
            var action              = id == 0 ? "leads_mapping_save" : "leads_mapping_update";
            var region              = $('#region').val();
            var city                = $('#ddlCity').val();
            var regional_area       = $('#ddlArea').val();
            var regional_manager    = $('#ddlRegionManager').val();
            var product_type        = $('#ddlProductType').val();

 



            if(validation())
            {
                $("#btnSaveLeadsMapping").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_lead.php",
                    data: 
                    {
                        'action':action,
                        'id':id,
                        'region':region,
                        'city' : city,
                        'regional_area':regional_area,
                        'regional_manager': regional_manager,
                        'product_type': product_type
                    },
                    success: function(data) 
                    {
                        //alert(data);
                        $("#btnSaveLeadsMapping").button('reset');

                        data = data.trim();
                        //alert(data);
                        //console.log(data);

                        if(data == 'success')
                        {
                            $.notifyBar({ cssClass: "success", html: "Lead mapping saved successfully!", delay: 2000, animationSpeed: "normal" });
                            //clear_values();
                            setTimeout(function (){ window.location.href = "leads_mapping_view.php" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Lead mapping not saved!", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });
    });

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#region').val() == null) 
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

        if($('#ddlCity').val() == null) 
        {
            $('#ddlCity').addClass('error-val');
            $('#ddlCity').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlCity').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlCity').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlCity').removeClass('error-val');
            $('#ddlCity').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlCity').parent().find('.input-error').hide();
        }

        if($('#ddlRegionManager').val() == null) 
        {
            $('#ddlRegionManager').addClass('error-val');
            $('#ddlRegionManager').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlRegionManager').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlRegionManager').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlRegionManager').removeClass('error-val');
            $('#ddlRegionManager').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlRegionManager').parent().find('.input-error').hide();
        }

        if($('#ddlProductType').val() == null) 
        {
            $('#ddlProductType').addClass('error-val');
            $('#ddlProductType').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductType').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlProductType').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlProductType').removeClass('error-val');
            $('#ddlProductType').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlProductType').parent().find('.input-error').hide();
        }

        if($('#ddlArea').val() == null) 
        {
            $('#ddlArea').addClass('error-val');
            $('#ddlArea').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlArea').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlArea').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlArea').removeClass('error-val');
            $('#ddlArea').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlArea').parent().find('.input-error').hide();
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }
</script>

</body>
</html>