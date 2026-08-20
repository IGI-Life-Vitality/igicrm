<?php

$page_title = "Complaint Details";
$permission_type = "view";
$module_id = "0";
$menu_id = "complaint_agent";

include('includes/header.php');
include('classes/complaint.php');
include('classes/product.php');

$objProd = new Product();
$objComplaint = new Complaint();
$data_counter = explode('|',$objComplaint->GenComplaintCounter());


$heading       = "Complaint Management";
$disabled      = "";
$email_checked = "";
$sms_checked = "";
$call_back_checked = "";

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data                = $objComplaint->GetComplaint($login_id,$id);
        $Activity_data       = $objComplaint->GetComplaintStatus($id);
        $heading             = "Complaint Management";
        $disabled            = $data[0]['id'] != 0 ? "disabled='disabled'" : "";
        $button              = $data[0]['group_id'] == 0 ? "Forward" : "Submit";
        $email_checked       = $data[0]['is_email'] == 0 ? "checked='checked'" : "";
        $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='checked'" : "";
        $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='checked'" : "";
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
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" />

<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />

<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li><a href="javascript:;">Home</a></li>
    <li><a href="complaint_views.php">Complaint</a></li>
    <li class="javascript:;">Complaint Details</li>
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
    <h4 class="panel-title">Complaint Details</h4>
</div>
<div class="panel-body">

<form class="form-horizontal" action="#" method="POST">

<input type="hidden" class="form-control" id="txtId" value="<?php echo($data[0]['compl_id']); ?>">
<input type="hidden" class="form-control" value="<? echo $data[0]['complaint_num'] ?>">
<input type="hidden" name="txtCounter" id="txtCounter" value="<? echo $data[0]['daily_counter']; ?>" />

<fieldset <? echo $disabled?>>
    <legend>Entry Information</legend>
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>Groups<span style="color: red; font-size: 16px;">*</span></label>
                <select class="default-select2 form-control" data-parsley-required="true" id="ddlGroup" name="ddlGroup" <?php echo $disabled ?>>
                    <option value="" selected="selected" disabled>Select Group</option>
                    <?php $groups = $objUser->GetGroups(); ?>
                    <?php foreach($groups as $group){ ?>
                        <option value="<? echo $group["id"]; ?>" <?php echo ($data[0]['group_id'] == $group["id"] ? "selected='selected'" : ''); ?>><? echo $group["primary_name"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Department required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>User(s)<span style="color: red; font-size: 16px;">*</span></label>
                <? if($data[0]["user_id"] != ""){ ?>

                    <select class="multiple-select2 form-control" multiple="multiple" id="ddlUsers" name="ddlUsers" <?php echo $disabled ?>>

                        <?php

                        $users = $objUser->GetUsersByGroupID($data[0]["group_id"]);
                        $counter = 0;
                        $users_ids =  explode(",",$data[0]["user_id"]);
                        ?>

                        <?php foreach($users as $user){ ?>
                            <option value="<? echo $user["id"]; ?>"<?php echo ($users_ids[$counter] == $user["id"] ? "selected='selected'" : $counter--); ?>><? echo $user["user_name"] ?></option>
                            <? $counter++; } ?>

                    </select>
                    <div class="input-error form-control-input" style="color: Red; display: none;">User required</div>
                <? }
                else{ ?>
                    <select class="multiple-select2 form-control" multiple="multiple" id="ddlUsers" name="ddlUsers" <?php echo $disabled ?>>
                    </select>
                    <div class="input-error form-control-input" style="color: Red; display: none;">User required</div>
                <? }?>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Entry Date/Time</label>
                <input type="text" class="form-control" id="txtDateTime" value="<?php echo $data[0]["id"] != 0 ? $data[0]["create_date"] : date("Y-m-d h:i:s")?>" disabled="true">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="col-md-3">
            <div class="form-group">
                <label>Channel</label>
                <select class="form-control default-select2" id="ddlChannel" name="ddlChannel"  <?php echo $disabled ?>>
                    <option value="<?php echo $data[0]['channel'] ?>"><?php echo $data[0]['channel'] ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Progress</label>
                <select class="form-control default-select2" id="ddlProgress" name="ddlProgress"  <?php echo $disabled ?> data-size="10" data-live-search="true" data-style="btn-white">
                    <option value="0">Select Progress</option>
                    <?php for($i = 0; $i <= 100; $i += 10) { ?>
                        <option value="<? echo $i ?>"<?php echo ($data[0]["progress"] == $i ? "selected='selected'" : ""); ?>><? echo $i ?>%</option>
                    <? } ?>
                    <option value="101">Invalid</option>
                </select>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Activity Notes</label>
                <textarea type="text" class="form-control" id="txtActivity" row="2" placeholder="Additional Comments"  <?php echo $disabled ?>><? echo $data[0]['comments_progress'] ?></textarea>
                <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
            </div>
        </div>
    </div>
</fieldset>


<fieldset <?php echo $disabled ?>>
    <legend>Complaint</legend>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Number</label>
                <input type="text" class="form-control" placeholder="Complaint Number" disabled value="<? echo $data[0]['complaint_num'] ?>">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Title<span style="color: red;">*</span></label>
                <input type="text" id="txtTitle" name="txtTitle" class="form-control" placeholder="Complaint Title" value="<? echo $data[0]['compl_title'] ?>">
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Title is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Relationship No<span style="color: red;">*</span></label>
                <input type="text" id="txtCNIC" name="txtCNIC" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15" value="<? echo $data[0]['cnic'] ?>">
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Customer Name<span style="color: red;">*</span></label>
                <input type="text" id="txtCustomerName" name="txtCustomerName" class="form-control" placeholder="Customer Name" value="<? echo $data[0]['customer_name'] ?>">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Product Category<span style="color: red;">*</span></label>
                <select class="form-control default-select2" id="ddlProductCategory" name="ddlProductCategory" <?php echo $disabled ?>>
                    <option disabled="disabled" selected="selected">Select Product Category</option>
                    <?php $product_categories = $objProd->GetProductCategory(0); ?>
                    <?php foreach($product_categories as $product_category){ ?>
                        <option value="<? echo $product_category["id"]; ?>" <?php echo ($data[0]["product_category"] == $product_category["id"] ? "selected='selected'" : ""); ?>><? echo $product_category["fullname"] ?></option>
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
                <select class="form-control default-select2" id="ddlProduct" name="ddlProduct" <?php echo $disabled ?>>
                    <option value="0">Select Product</option>
                    <?php $products = $objComplaint->GetProducts(0); ?>
                    <?php foreach($products as $product){ ?>
                        <option value="<? echo $product["id"]; ?>"<?php echo ($data[0]["product_id"] == $product["id"] ? "selected='selected'" : ""); ?>><? echo $product["fullname"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Product is required</div>
            </div>
        </div>

    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Type<span style="color: red;">*</span></label>
                <select class="form-control default-select2" id="ddlType" name="ddlType" <?php echo $disabled ?>>
                    <?php
                    $complaint_types = $objComplaint->GetComplaintType(0);
                    ?>
                    <?php foreach($complaint_types as $complaint_type){ ?>
                        <option value="<? echo $complaint_type["id"]; ?>"<?php echo ($data[0]["complaint_type_id"] == $complaint_type["id"] ? "selected='selected'" : ""); ?>><? echo $complaint_type["fullname"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Priority</label>
                <select class="form-control default-select2" id="ddlPriority" name="ddlPriority" <?php echo $disabled ?>>
                    <?php $priorities = $objComplaint->GetPriority(); ?>
                    <?php foreach($priorities as $priority){ ?>
                        <option value="<? echo $priority["id"]; ?>" <?php echo ($data[0]["priority_id"] == $priority["id"] ? "selected='selected'" : ""); ?>><? echo $priority["priority"] ?></option>
                    <? } ?>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
            </div>
        </div>


        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Acct/Card Number</label>
                <select class="form-control default-select2" id="ddlCardNumber" name="ddlCardNumber" <?php echo $disabled ?>>
                    <option value="<? echo $data[0]['card_number'] ?>"><? echo $data[0]['card_number'] ?></option>
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
                <label>Source</label>
                <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white" <?php echo $disabled ?>>
                    <option value="<?php echo $data[0]['source'] ?>" selected="selected"><? echo $data[0]['source'] ?></option>
                </select>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Nature</label>
                <select class="form-control default-select2" id="ddlNature" name="ddlNature" <?php echo $disabled ?>>
                    <option value="Complaint" selected="selected">Complaint</option>
                    <option value="Lead">Lead</option>
                    <option value="Suggestion" selected="selected"><? echo $data[0]['complaint_nature'] ?></option>
                </select>
                <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Nature is required</div>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Reference No</label>
                <input type="text" id="txtReferenceNo" name="txtReferenceNo" class="form-control" placeholder="Complaint Reference No" disabled>
            </div>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Complaint Measures</label>
                <input type="text" id="txtMeasures" name="txtMeasures" class="form-control" placeholder="Complaint Measures"  value="<? echo $data[0]['complaint_measures'] ?>">
            </div>
        </div>

        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Note</label>
                <textarea placeholder="Additional Information" id="txtDescription" name="txtDescription" rows="3" class="form-control"><? echo $data[0]['description'] ?></textarea>
            </div>
        </div>
    </div>

</fieldset>


<fieldset <?php echo $disabled ?>>
    <legend>Call Back Information</legend>
    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Call Back Phone</label>
                <input type="text" id="txtCallBack" name="txtCallBack" class="form-control" onkeypress="return validateNumbers(event)" value="<? echo $data[0]['callback_num'] ?>" placeholder="021XXXXXXXX" maxlength="11">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Delivery Address</label>
                <textarea placeholder="Delivery Address" id="txtDeliveryAddress" name="txtDeliveryAddress" class="form-control"><? echo $data[0]['delivery_address'] ?></textarea>
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Response Date/Time</label>
                <div class="input-group date" id="datetimepicker1">
                    <input type="text" class="form-control" value="" placeholder="Date/Time" <? echo $disabled ?>>
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                </div>
            </div>
        </div>


    </div>

    <div class="col-md-12">

        <div class="col-md-3">
            <div class="form-group">
                <label>Follow Up Date/Time</label>
                <div class="input-group date" id="datetimepicker2">
                    <input type="text" class="form-control" value="" placeholder="Date/Time" <? echo $disabled ?>>
                                                <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>


    </div>

</fieldset>

<fieldset <?php echo $disabled ?>>
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
                        <input type="radio" name="rdEmail" id="radio_inline_css_2" value="0" <?php echo $email_checked; ?>>
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
                <label>SMS</label>
                <div>
                    <div class="radio radio-css radio-inline radio-inverse">
                        <input type="radio" name="rdSMS" id="radio_inline_css_3" value="1" checked="">
                        <label for="radio_inline_css_3">
                            Yes
                        </label>
                    </div>
                    <div class="radio radio-css radio-inline radio-danger">
                        <input type="radio" name="rdSMS" id="radio_inline_css_4" value="0" <?php echo $sms_checked; ?>>
                        <label for="radio_inline_css_4">
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
                <label>Customer Mobile Number</label>
                <input type="text" class="form-control" onkeypress="return validateNumbers(event)" id="txtResNumber" name="txtResNumber" placeholder="92XXXXXXXXXX" maxlength="12" value="<? echo $data[0]['mobile_number'] ?>">
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Customer Email</label>
                <input type="text" class="form-control" id="txtCustomerEmail" name="txtCustomerEmail" placeholder="example@mail.com" value="<? echo $data[0]['customer_email'] ?>">
            </div>
        </div>
        <div class="col-md-1">
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Call Back</label>
                <div>
                    <div class="radio radio-css radio-inline radio-inverse">
                        <input type="radio" name="rdEmail1" id="radio_inline_css_12" value="1" checked="">
                        <label for="radio_inline_css_12">
                            Yes
                        </label>
                    </div>

                    <div class="radio radio-css radio-inline radio-danger">
                        <input type="radio" name="rdEmail1" id="radio_inline_css_21" value="0" <?php echo $call_back_checked; ?>>
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
        <button type="button" class="btn btn-sm btn-primary" id="btnSubmitComplaint" <? echo $disabled ?> data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..."><? echo $button?></button>
    </div>
</div>
</form>

</div>
</div>
</div>

<div class="panel panel-inverse" data-sortable-id="table-basic-5">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
        </div>
        <h4 class="panel-title">Complaint Activities</h4>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Previous State</th>
                    <th>Current State</th>
                    <th>Activity Performer (User)</th>
                    <th>Comments</th>
                    <th>Assigned To</th>

                </tr>
                </thead>
                <tbody>

                <?  $users = $objUser->GetUsers(0);
                $counter = 0;
                $users_ids =  explode(",",$Activity_data[0]['assign_to']);
                ?>

                <?php foreach($Activity_data as $row){ ?>

                    <?php
                    $status = "";

                    if($row["current_state"] == 2){
                        $curr_status = "In Progress";
                        $pre_status  = "Initiated";
                    }
                    elseif($row["current_state"] == 3){
                        $curr_status = "Resolved";
                        $pre_status  = "In Progress";
                    }
                    elseif($row["current_state"] == 4){
                        $curr_status = "verified";
                        $pre_status  = "Resolved";
                    }
                    elseif($row["current_state"] == 5) {
                        $curr_status = "Invalid";
                        $pre_status = "Forwarded";
                    }

                    ?>

                    <tr>
                        <td><? echo $row["update_datetime"] ?></td>
                        <td><? echo $pre_status ?></td>
                        <td><? echo $curr_status ?></td>
                        <td><? echo $row["activity_performer"] ?></td>
                        <td><? echo $row["comments"] ?></td>
                        <td>
                            <? foreach ($users as $user) { ?>
                                <? if($users_ids[$counter] == $user["id"]) {
                                    $users_name .= $user["user_name"].",";

                                }
                                else
                                    $counter--;
                                $counter++; } ?>
                            <? echo rtrim($users_name , ',')?>
                        </td>

                    </tr>
                <? } ?>

                </tbody>
            </table>
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

<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>

<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        Notification.init();
    });
</script>

<script type="text/javascript">
</script>

</body>
</html>
