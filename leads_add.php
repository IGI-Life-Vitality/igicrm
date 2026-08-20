<?php
    $page_title = "Add Leads";
    $permission_type = "create";
    $module_id = "36";
    $parent_id = "35";
    $menu_id = "leads_add";

    include('includes/header.php');
    include('classes/product.php');
    include('classes/lead.php');

    $objProd = new Product();
    $objLead = new Lead();
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
        <li><a href="javascript:;">Leads Management</a></li>
        <li class="javascript:;"><?php echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-4">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><?php echo $page_title; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="#" method="POST" id="lead">
                        <input type="hidden" id="txtId" name="txtId" value="">
                        <input type="hidden" id="action" name="action" value="save_lead">
                        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? //echo $counter_display; ?>" />
                        <input type="hidden" id="pro_num" name="pro_num" class="form-control" value="">
                        <input type="hidden" name="txtCounter" id="txtCounter" value="<? //echo $counter; ?>" />
                        <input type="hidden" id="txtLeadNo" name="txtLeadNo" class="form-control" value="<? //echo $counter_display; ?>">

                        <fieldset>
                            <legend>Leads</legend>

                            <div class="col-md-12">
                                <div class="col-md-3" style="display: none">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <?php $groups = $objUser->GetGroups(); ?>
                                        <select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName">
                                            <?php foreach($groups as $group){ ?>
                                            <option value="<? echo $group["id"]; ?>" <?php if($group["primary_name"] == "AGENCY OPERATIONS/SALES") {echo "selected='selected'"; } ?>><? echo $group["primary_name"];?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: none">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Salutation</label>
                                        <select class="form-control default-select2" id="ddlSalutation" name="ddlSalutation">
                                            <option value="" selected="selected">Select Salutation</option>
                                            <option value="Mr">Mr.</option>
                                            <option value="Mrs">Mrs.</option>
                                            <option value="Ms">Ms.</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Salutation is required</div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name<span style="color: red;">*</span></label>
                                        <input type="text" id="txtFName" name="txtFName" class="form-control" placeholder="Enter First Name" onkeypress="return validateAlphabets(event)" tabindex="1">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">First Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" id="txtMName" name="txtMName" class="form-control" placeholder="Enter Middle Name" onkeypress="return validateAlphabets(event)" tabindex="2">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Middle Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name<span style="color: red;">*</span></label>
                                        <input type="text" id="txtLName" name="txtLName" class="form-control" placeholder="Enter Last Name" onkeypress="return validateAlphabets(event)" tabindex="3">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Last Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>CNIC/NICOP<!-- <span style="color: red;">*</span> --></label>
                                        <input type="text" id="txtCNIC" name="txtCNIC" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="13" tabindex="4">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlGender" name="ddlGender" data-size="10" data-live-search="true" data-style="btn-white" tabindex="5">
                                            <option value="" selected="selected" disabled = "disabled">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Gender is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Call Back Number<span style="color: red;">*</span></label>
                                        <input type="text" id="txtMobile" name="txtMobile" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" tabindex="6">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Call Back Number is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Back Up Number</label>
                                        <input type="text" id="txtBackNumber" name="txtBackNumber" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" tabindex="7">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <!--<div class="input-group">-->
                                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="example@mail.com" tabindex="8">
                                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                                            <!--<span class="input-group-addon">@</span>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlCity" name="ddlCity" tabindex="9">
                                            <option value="" selected="selected" disabled="disabled">Select City</option>
                                           <?php $cities = $objProd->GetCity(0); ?>
                                            <?php foreach($cities as $city){ ?>
                                             <option value="<? echo $city["id"]; ?>"><? echo $city["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Area<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlArea" name="ddlArea" tabindex="10">
                                            <option value="" selected="selected" disabled="disabled">Select Area</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Area is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Complete Address<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtAddress" name="txtAddress" rows="6" placeholder="Enter Address" tabindex="11"></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Address is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Name<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlProductName" name="ddlProductName" data-size="10" data-live-search="true" data-style="btn-white" onchange="vitality_test(0);" tabindex="12">
                                            <option value="" selected="selected" disabled >Select Product</option>
                                            <?php $product_categories = $objProd->GetProduct(); ?>
                                            <?php foreach($product_categories as $product_names){ ?>
                                                <option value="<? echo $product_names["id"]; ?>"><? echo $product_names["fullname"] ?></option>
                                            <? } ?> 
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Preferable Call Time<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control date" name="txtPreferableCallTime" id="datetimepicker2" placeholder="Pick Preferable Date and Time" tabindex="13" />

                                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                                        <div class="input-error form-control-input" style="color: Red; display: none;">Preferable Call Time is required</div>
                                    </div>
                                </div>

                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Preferable Call Time<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="txtPreferableCallTime" name="txtPreferableCallTime">
                                            <option value="" selected="selected" disabled>Select Preferable Call Time</option>
                                            <option value="09-11 AM">09 - 11 AM</option>
                                            <option value="12-02 PM">12 - 02 PM</option>
                                            <option value="02-05 PM">02 - 05 PM</option>
                                            <option value="05-08 PM">05 - 08 PM</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Preferable Call Time is required</div>
                                    </div>
                                </div>-->
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Source of Information<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white" onchange="vitality_test(1);" tabindex="14">
                                            <option value="" selected="selected" disabled>Select Source</option>
                                            <?php $source = $objProd->GetSource(0); ?>
                                            <?php foreach($source as $sources){ ?>
                                             <option value="<? echo $sources["id"]; ?>"><? echo $sources["fullname"] ?></option> -->
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <!--haroon work start-->
                            <div class="col-md-12" id="vitality_div" style="display: none;">
                                <div class="col-md-11">
                                    <div class="form-group" style="<?php echo $vitality_activity; ?>">
                                        <table id="myTable" class="table table-striped table-bordered order-list">
                                            <thead>
                                                <tr>
                                                    <th>Test Type</th>
                                                    <th>Status</th>
                                                    <th>Results</th>
                                                    <th>Remarks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" style="text-align: left;">
                                                        <input type="button" class="btn btn-sm pull-right" id="addrow" value="Add More"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- haroon work ends-->    

                            <div class="col-md-12">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label>Description<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtLaedsDesc" name="txtLaedsDesc" rows="6" placeholder="Enter Details about inquiry" tabindex="15"></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Description is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                        </fieldset>

                        <hr>

                        <div class="col-md-12">
                            <div class="col-md-2 form-group">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveLeads" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Create Lead</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

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

    /*.select2-container--default{
        width: 256px !important;
    }

    #txtCNIC{
        width: 256px !important;
    }*/
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        //masking();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var counter = 1;
        var cc = 0;
        var getid = 0;
        var types = [];
        var a = -1;

        $(document).on('click', '#btnSaveLeads', function () {
            var Form_data = new FormData($('#lead')[0]);
            Form_data.append('counter', counter-1);

            /*for (var pair of Form_data.entries())           
            {               
                console.log(pair[0]+ ', '+ pair[1]);            
            }
            return false;*/

            if(validation())
            {
                $("#btnSaveLeads").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_lead.php",
                    async: true,
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: Form_data,
                    success: function(data) 
                    {
                        //$("#btnSaveLeads").button('reset');
                        data = data.trim();
                        //alert(data);
                        //console.log(data);

                        if(data == 'success')
                        {
                            $.notifyBar({ cssClass: "success", html: "Yes! Lead Created Successfully", delay: 2000, animationSpeed: "normal" });
                            //clear_values();
                            setTimeout(function (){ window.location.href = "leads_view.php" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Oops! Lead Not Created, Try Again", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });

        /*haroon*/
        $("#addrow").on("click", function () {
                //alert("haroon");
                var id = '#ddlTestType'+cc;
                var value = $(id).val();
                //alert(value);
                <?php $testcount = $objLead->GetLeadsTestType(); 
                $tcount = count($testcount);?>
                var ttcount = <?php echo $tcount;?>;
                //alert(ttcount);
                if(counter <= ttcount && value != 'Select Status'){
                var newRow = $("<tr>");
                var cols = "";
                
                //alert(value);

                if(value != undefined)
                {
                    types.push(value);
                }

                //fruits.insert(value);
                types = types.unique();
                console.log(types);
                cols += '<td><select class="form-control" id="ddlTestType' + counter +'" name="ddlTestType' + counter + '">';
                    cols += '<option  selected="selected" >Select Status</option>';
                    <?php $test_type = $objLead->GetLeadsTestType(); ?>
                    <?php foreach($test_type as $test_types) {?>
                        if(types.length != 0){
                        a = types.indexOf("<?php echo $test_types["id"] ;?>");
                            }
                        //console.log('types.indexOf("<?php //echo $test_types["id"] ;?>")');
                        console.log(a);
                        //if(value != <?php //echo $test_types["id"] ;?>){
                            if(a == '-1'){

                    cols += '<option value="<? echo $test_types["id"]; ?>"><? echo $test_types["fullname"]?></option>';
                        }
                    <? }?>
                
                cols += '</select></td>';

                cols += '<td><select class="form-control" id="ddlLeadTestStatus' + counter + '" name="ddlLeadTestStatus' + counter + '">';
                    /*cols += '<option value="" selected="selected" disabled="disabled">Select Status</option>';*/
                    <?php $LeadTestTypeStatus = $objLead->GetLeadTestTypeStatus(); ?>
                    <?php foreach($LeadTestTypeStatus as $LeadsTestTypeStatus) { ?>
                    cols += '<option value="<? echo $LeadsTestTypeStatus["id"]; ?>"><? echo $LeadsTestTypeStatus["fullname"] ?></option>';
                    <? } ?>
                cols += '</select></td>';

                cols += '<td><input type="text" class="form-control" id="txtLeadsResults' + counter + '" name="txtLeadsResults' + counter + '"></td>';
                cols += '<td><input type="text" class="form-control" id="txtLeadsRmrk' + counter + '" name="txtLeadsRmrk' + counter + '"></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-sm btn-danger"  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);

                counter++;
                cc++;
             }
        });

        $("table.order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();       
            counter -= 1
        });
        /*end haroon */
    });

    /* Lead Areas */
    $(document).on('change', '#ddlCity', function () {
        var city = $(this).val();
        //alert(city);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:{
                action : "select_lead_city_area",
                city: city
            }

        }).done(function (data) {
            //alert(data);
            $('#ddlArea').html(data);
        });
    });

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        if(email.test($('#txtEmail').val()) == false && $('#txtEmail').val() != "") 
        {
            $('#txtEmail').addClass('error-val');
            //$('#txtEmail').parents('.control-group').addClass('error');
            //$('#txtEmail').parent().find('.input-error').hide();
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmail').removeClass('error-val');
            //$('#txtPassword').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
            $('#txtEmail').parent().find('.input-error1').hide();
        }

        if($('#txtFName').val() == 0 || $('#txtFName').val() == null) 
        {
            $('#txtFName').addClass('error-val');
            $('#txtFName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtFName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtFName').removeClass('error-val');
            //$('#txtFName').parents('.control-group').addClass('success');
            $('#txtFName').parent().find('.input-error').hide();
        }

        if($('#txtLName').val() == 0 || $('#txtLName').val() == null) 
        {

            $('#txtLName').addClass('error-val');
            $('#txtLName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtLName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtLName').removeClass('error-val');
            $('#txtLName').parent().find('.input-error').hide();
        }

        /*if($('#txtCNIC').val() == 0 || $('#txtCNIC').val() == null) 
        {

            $('#txtCNIC').addClass('error-val');
            $('#txtCNIC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNIC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCNIC').removeClass('error-val');
            $('#txtCNIC').parent().find('.input-error').hide();
        }*/

        if($('#ddlGender').val() == '') 
        {
            $('#ddlGender').addClass('error-val');
            $('#ddlGender').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlGender').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlGender').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlGender').removeClass('error-val');
            $('#ddlGender').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlGender').parents('.control-group').addClass('success');
            $('#ddlGender').parent().find('.input-error').hide();
        }

        if($('#txtMobile').val() == 0 || $('#txtMobile').val() == null) 
        {
            $('#txtMobile').addClass('error-val');
            $('#txtMobile').parent().find('.input-error').show().css('display','inline-block');

            if (!hasFocus) 
            {
                $('#txtMobile').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtMobile').removeClass('error-val');
            $('#txtMobile').parent().find('.input-error').hide();
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

        if($('#txtAddress').val() == 0 || $('#txtAddress').val() == null) 
        {
            $('#txtAddress').addClass('error-val');
            $('#txtAddress').parent().find('.input-error').show().css('display','inline-block');

            if (!hasFocus) 
            {
                $('#txtAddress').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtAddress').removeClass('error-val');
            $('#txtAddress').parent().find('.input-error').hide();
        }

        if($('#ddlProductName').val() == null) 
        {
            $('#ddlProductName').addClass('error-val');
            $('#ddlProductName').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductName').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlProductName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlProductName').removeClass('error-val');
            $('#ddlProductName').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlProductName').parent().find('.input-error').hide();
        }

        if($('#datetimepicker2').val() == null || $('#datetimepicker2').val() == '') 
        {
            $('#datetimepicker2').addClass('error-val');
            $('#datetimepicker2').parent().find('.input-error').show().css('display','inline-block');

            if (!hasFocus)
            {
                $('#datetimepicker2').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#datetimepicker2').removeClass('error-val');
            $('#datetimepicker2').parent().find('.input-error').hide();
        }

        if($('#ddlSource').val() == null)
        {
            $('#ddlSource').addClass('error-val');
            $('#ddlSource').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSource').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSource').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSource').removeClass('error-val');
            $('#ddlSource').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlSource').parent().find('.input-error').hide();
        }

        if($('#txtLaedsDesc').val() == 0 || $('#txtLaedsDesc').val() == null) 
        {
            $('#txtLaedsDesc').addClass('error-val');
            $('#txtLaedsDesc').parent().find('.input-error').show().css('display','inline-block');

            if (!hasFocus) 
            {
                $('#txtLaedsDesc').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtLaedsDesc').removeClass('error-val');
            $('#txtLaedsDesc').parent().find('.input-error').hide();
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking()
    {
        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }

    function vitality_test(val)
    {
        if(val == 0)
        {
            check_source();
        }

        var pro = $('#ddlProductName').val();
        var cat = $('#ddlSource').val();

        //alert(pro);
        //alert(cat);
        
        // pro = product name = Vitality = id (3)
        // cat = source = Vitality Experience Center = id (7)
        if(pro == 3 && cat == 7)
        {
            $('#vitality_div').show();
        }
        else
        {
            $('#vitality_div').hide();
        }
    }

    function check_source()
    {
      var pro = $('#ddlProductName').val();

      $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:{
                'action' : "select_source",
                'pro': pro
            }

        }).done(function (data) {
            //alert(data);
            $('#ddlSource').html(data);
        });
    } 

    Array.prototype.unique = function() {
      return this.filter(function (value, index, self) { 
        return self.indexOf(value) === index;
      });
    }
</script>

</body>
</html>