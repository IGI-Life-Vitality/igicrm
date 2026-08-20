<?php

$page_title = "Add Complaint";
$permission_type = "create";
$module_id = "0";
$menu_id = "complaint_agent";

include('includes/header.php');
include('classes/complaint.php');
include('classes/product.php');

$objProd = new Product();
$objComplaint = new Complaint();
$data_counter = explode('|',$objComplaint->GenComplaintCounter());

$counter_display = $data_counter[0];
$counter = $data_counter[1];

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
    <li><a href="complaint_views.php">Complaint</a></li>
    <li class="javascript:;">Add Complaint</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Complaint Management</h1>
<!-- end page-header -->

<!-- begin row -->
<div class="row">
<!-- begin col-12 -->
<div class="col-md-12">
<!-- begin panel -->
<div class="panel panel-inverse">
<div class="panel panel-inverse" data-sortable-id="form-stuff-4">
<div class="panel-heading">
    <div class="panel-heading-btn">
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
    </div>
    <h4 class="panel-title">Add Complaint</h4>
</div>
<div class="panel-body">

<form class="form-horizontal" action="#" method="POST" id="complaint">

<input type="hidden" id="txtId" name="txtId" value="">
<input type="hidden" id="txtAction" name="txtAction" value="save_complaint">
<input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? echo $counter_display; ?>" />
<input type="hidden" name="txtCounter" id="txtCounter" value="<? echo $counter; ?>" />
<input type="hidden" id="txtComplaintNo" name="txtComplaintNo" class="form-control" value="<? echo $counter_display; ?>">

<fieldset>
    <legend>Complaint</legend>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Number</label>
                <input type="text" class="form-control" placeholder="Complaint Number" disabled value="<? echo $counter_display; ?>">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Title<span style="color: red;">*</span></label>
                <input type="text" id="txtTitle" name="txtTitle" class="form-control" placeholder="Complaint Title" value="">
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Title is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Relationship No<span style="color: red;">*</span></label>
                <input type="text" id="txtCNIC" name="txtCNIC" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15">
                <div class="input-error form-control-input" style="color: Red; display: none;">Relationship No is required</div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Customer Name<span style="color: red;">*</span></label>
                <input type="text" id="txtCustomerName" name="txtCustomerName" class="form-control" placeholder="Customer Name">
                <div class="input-error form-control-input" style="color: Red; display: none;">Customer Name is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Product Category<span style="color: red;">*</span></label>
                <select class="form-control default-select2" id="ddlProductCategory" name="ddlProductCategory" data-size="10" data-live-search="true" data-style="btn-white">
                    <option disabled="disabled" selected="selected">Select Product Category</option>
                    <?php $product_categories = $objProd->GetProductCategory(0); ?>
                    <?php foreach($product_categories as $product_category){ ?>
                        <option value="<? echo $product_category["id"]; ?>"><? echo $product_category["fullname"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Product Category is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Product<span style="color: red;">*</span></label>
                <select class="form-control default-select2" id="ddlProduct" name="ddlProduct" data-size="10" data-live-search="true" data-style="btn-white">
                    <option value="0" selected="selected" disabled>Select Product</option>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Product is required</div>
            </div>
        </div>

    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Type<span style="color: red;">*</span></label>
                <select class="form-control default-select2" id="ddlComplaintType" name="ddlComplaintType" data-placeholder="Select Complaint Type">
                    <option value="0" selected="selected" disabled>Select Complaint Type</option>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <label>Priority</label>
                <select class="form-control default-select2" id="ddlPriority" name="ddlPriority">
                    <?php $priorities = $objComplaint->GetPriority(); ?>
                    <?php foreach($priorities as $priority){ ?>
                        <option value="<? echo $priority["id"]; ?>"><? echo $priority["priority"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
            </div>
        </div>


        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Policy Number</label>
                <select class="form-control default-select2" id="ddlCardNumber" name="ddlCardNumber" data-size="10" data-live-search="true" data-style="btn-white">
                    <option value="0" selected="selected" disabled>Select Policy</option>
                    <option value="110011">110011</option>
                    <option value="112211">112211</option>
                </select>
            </div>
        </div>


        <div class="col-md-1">
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Nature</label>
                <select class="form-control default-select2" id="ddlComplaintNature" name="ddlComplaintNature">
                    <option value="Complaint" selected="selected">Complaint</option>
                    <option value="Lead">Lead</option>
                    <option value="Suggestion">Suggestion</option>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Nature is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Source</label>
                <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white">
                    <option value="Call Center" selected="selected">Call Center</option>
                    <option value="Branch Office">Branch Office</option>
                    <option value="Back Office">Back Office</option>
                </select>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Measures</label>
                <input type="text" id="txtMeasures" name="txtMeasures" class="form-control" placeholder="Complaint Measures">
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>Note</label>
                <textarea placeholder="Additional Information" id="txtDescription" name="txtDescription" rows="3" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-1">
        </div>

    </div>

</fieldset>
<fieldset>
    <legend>Call Back Information</legend>
    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Call Back Phone</label>
                <input type="text" id="txtCallBack" name="txtCallBack" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Delivery Address</label>
                <textarea placeholder="Delivery Address" id="txtDeliveryAddress" name="txtDeliveryAddress" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Address Residence<span style="color: red;">*</span></label>
                <textarea placeholder="Residence Address" id="txtResidenceAddress" name="txtResidenceAddress" class="form-control"></textarea>
                <div class="input-error form-control-input" style="color: Red; display: none;">Residence Address is required</div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Address Office</label>
                <textarea placeholder="Office Address" id="txtOfficeAddress" name="txtOfficeAddress" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Address Correspondence</label>
                <textarea placeholder="Alternate Address" id="txtAlternateAddress" name="txtAlternateAddress" class="form-control"></textarea>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>E-Mail</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="example@mail.com">
                    <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                    <span class="input-group-addon">@</span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>Phone Office</label>
                <input type="text" id="txtOfficePhone" name="txtOfficePhone" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Phone Home</label>
                <input type="text" id="txtHomePhone" name="txtHomePhone" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Phone Cellular</label>
                <input type="text" id="txtMobile" name="txtMobile" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
            </div>
        </div>

    </div>


</fieldset>
<fieldset>
    <legend>Acknowledge Response</legend>
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>E-Mail</label>
                <div>
                    <div class="radio radio-css radio-inline radio-inverse">
                        <input type="radio" name="rdEmail" id="radio_inline_css_1" value="1" checked="">
                        <label for="radio_inline_css_1">
                            Yes
                        </label>
                    </div>

                    <div class="radio radio-css radio-inline radio-danger">
                        <input type="radio" name="rdEmail" id="radio_inline_css_2" value="0">
                        <label for="radio_inline_css_2">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Customer Email</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="txtCustomerEmail" name="txtCustomerEmail" placeholder="abc@example.com">
                    <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                    <span class="input-group-addon">@</span>
                </div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>SMS</label>
                <div>
                    <div class="radio radio-css radio-inline radio-inverse">
                        <input type="radio" name="rdSMS" id="radio_inline_css_3" value="1" checked="">
                        <label for="radio_inline_css_3">
                            Yes
                        </label>
                    </div>
                    <div class="radio radio-css radio-inline radio-danger">
                        <input type="radio" name="rdSMS" id="radio_inline_css_4" value="0">
                        <label for="radio_inline_css_4">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Customer Mobile</label>
                <input type="text" class="form-control number" id="txtResponseNumber" name="txtResponseNumber" onkeypress="return validateNumbers(event)" maxlength="12" placeholder="92-XXXXXXXXXX">
            </div>
        </div>

        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Call Back</label>
                <div>
                    <div class="radio radio-css radio-inline radio-inverse">
                        <input type="radio" name="rdCallBack" id="radio_inline_css_12" value="1" checked="">
                        <label for="radio_inline_css_12">
                            Yes
                        </label>
                    </div>

                    <div class="radio radio-css radio-inline radio-danger">
                        <input type="radio" name="rdCallBack" id="radio_inline_css_21" value="0">
                        <label for="radio_inline_css_21">
                            No
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>

</fieldset>

<hr>

<div class="col-md-12">
    <div class="col-md-2 form-group">
        <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaint" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
    </div>
</div>
</form>


</div>
</div>
</div>
<!-- end panel -->
</div>
<!-- end col-12 -->
</div>
<!-- end row -->
</div>
<!-- end #content -->

<div class="modal fade" id="ModalComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseComments" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalform" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="$complaint_id" name="$complaint_id" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" name="counter_display" value="<? echo $counter_display; ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="comments" class="form-control" id="txtComments1" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload1" id="fileupload1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload2" id="fileupload2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload3" id="fileupload3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload4" id="fileupload4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFile4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileupload5" id="fileupload5">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label>
                                        <a class="btn btn-icon btn-circle btn-success" id="btnFileUplaodDiv">
                                            <i class="fa fa fa-plus-square"></i></a>
                                    </label>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUpload" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Upload</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
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
        masking();
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        var counter = 1;
        var getid = 0;

        $(document).on('click', '#btnSaveComplaint', function () {

            var Form_data = new FormData($('#complaint')[0]);

            if(validation()){

                $("#btnSaveComplaint").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_complaint.php",
                    async: true,
                    contentType: false,
                    processData: false,
                    cache: false,
                    data: Form_data,
                    success: function(data) {

                        $("#btnSaveComplaint").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);
                        var result = data.split("|");
                        getid = result[1];

                        if(result[0] == 'success'){
                            $('#ModalComment').modal({backdrop: 'static', keyboard: false});
                            $('#ModalComment').modal('show');
                            return false;
                        }else if(data == 'fail'){
                            $('html, body').animate({scrollTop: 0}, 600);
                            $('#divError').show();
                        }
                    }
                });

            }
        });

        $(document).on('click', '#btnFileUplaodDiv', function () {
            if(counter > 4){
                alert("Can not add more.");
            }
            else if(counter == 1){
                $('#SelectFile1').css('display','block');
                counter++;
            }
            else if(counter == 2){
                $('#SelectFile2').css('display','block');
                counter++;
            }
            else if(counter == 3){
                $('#SelectFile3').css('display','block');
                counter++;
            }
            else if(counter == 4){
                $('#SelectFile4').css('display','block');
                counter++;
            }
        });

        $(document).on('click', '#btnFileUpload', function () {

            var formdata = new FormData($('#modalform')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUpload").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,

                success: function (data) {

                    $("#btnFileUpload").button('reset');

                    data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";

                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success'){
                        $('#ModalComment').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_view_agent.php";
                        }, 3000);
                    }else{
                        $('#ModalComment').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }

            });
        });

        $(document).on('click', '#btnCloseComments', function () {
            $('#ModalComment').modal('hide');
        });

        $('#fileupload1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload1').val('');
            }
        });

        $('#fileupload2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload2').val('');
                return false;
            }
        });

        $('#fileupload3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload3').val('');
                return false;
            }
        });

        $('#fileupload4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload4').val('');
                return false;
            }
        });

        $('#fileupload5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileupload5').val('');
                return false;
            }
        });




    });

    $(document).on('change', '#ddlProduct', function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint.php",
            data: { 'action': 'select_type', id: id }
        }).done(function (data) {
            $('#ddlComplaintType').html(data);
            $("#ddlComplaintType").select2();
        });
    });

    $(document).on('change', '#ddlProductCategory', function () {
        $("#ddlComplaintType").empty();
        var product_category = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:{
                action : "select_product",
                id: product_category
            }

        }).done(function (data) {
            $('#ddlProduct').html(data);
        });
    });



    function validation(){

        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;



        if($('#txtTitle').val() == '') {

            $('#txtTitle').addClass('error-val');
            $('#txtTitle').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtTitle').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtTitle').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#txtTitle').parent().find('.input-error').hide();
        }

        if($('#txtCNIC').val() == "") {

            $('#txtCNIC').addClass('error-val');
            $('#txtCNIC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCNIC').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#txtCNIC').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNIC').parent().find('.input-error').hide();
        }

        if($('#txtCustomerName').val() == "") {

            $('#txtCustomerName').addClass('error-val');
            $('#txtCustomerName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCustomerName').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#txtCustomerName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCustomerName').parent().find('.input-error').hide();
        }

        if($('#ddlProductCategory').val() == null) {

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
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlProductCategory').parent().find('.input-error').hide();
        }


        if($('#ddlProduct').val() == 0 || $('#ddlProduct').val() == null) {

            $('#ddlProduct').addClass('error-val');
            $('#ddlProduct').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlProduct').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#ddlProduct').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlProduct').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintType').val() == 0 || $('#ddlComplaintType').val() == null) {

            $('#ddlComplaintType').addClass('error-val');
            $('#ddlComplaintType').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#ddlComplaintType').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#ddlComplaintType').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintType').parent().find('.input-error').hide();
        }


        /*if($('#txtDescription').val() == '') {

         $('#txtDescription').addClass('error-val');
         $('#txtDescription').parent().find('.input-error').show().css('display', 'inline-block');

         if (!hasFocus) {
         $('#txtDescription').focus();
         hasFocus = true;
         }
         errCount++;
         }
         else {
         $('#txtDescription').removeClass('error-val');
         //$('#txtDescription').parents('.control-group').addClass('success');
         $('#txtDescription').parent().find('.input-error').hide();
         }*/


        if($('#txtResidenceAddress').val() == "") {

            $('#txtResidenceAddress').addClass('error-val');
            $('#txtResidenceAddress').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResidenceAddress').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#txtResidenceAddress').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtResidenceAddress').parent().find('.input-error').hide();
        }

        if($('#txtEmail').val() != '' && email.test($('#txtEmail').val()) == false) {

            $('#txtEmail').addClass('error-val');
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#txtEmail').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
        }


        if($('#txtCustomerEmail').val() != '' && email.test($('#txtCustomerEmail').val()) == false) {

            $('#txtCustomerEmail').addClass('error-val');
            $('#txtCustomerEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCustomerEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }

        else {
            $('#txtCustomerEmail').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCustomerEmail').parent().find('.input-error').hide();
        }


        if (errCount > 0) {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking(){

        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }




</script>

</body>
</html>
