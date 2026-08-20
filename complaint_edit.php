<?php
$page_title = "Edit Complain";
$permission_type = "update";
$module_id = "3";
$parent_id ="19";
$menu_id = "complaint_views";

include('includes/header.php');
include('classes/complaint.php');
include('classes/product.php');

$objProd = new Product();
$objComplaint = new Complaint();
$id     = isset($_GET['id'])?$_GET['id']:0;
$cmode  = isset($_GET['cmode'])?$_GET['cmode']:0;
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
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
        <li><a href="complaint_views.php">Complaint Management</a></li>
        <li class="javascript:;"><?php echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Complaint Management</h1>
    <!-- end page-header -->

    <!-- begin Tab panel -->
    <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1" data-init="true">
        <div class="panel-heading p-0">
            <!-- begin nav-tabs -->
            <div class="tab-overflow overflow-right">
                <ul class="nav nav-pills nav-tabs-inverse">
                    <li class="prev-button">
                        <a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a>
                    </li>
                    <li class="<?php echo ($cmode == 'individual') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-1" id="tabIndividualLife" data-toggle="tab">Individual Life</a>
                    </li>
					 <li class="<?php echo ($cmode == 'legal') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-3" id="tabLegalComplaints" data-toggle="tab">Legal/Fraudalent Complaints</a>
                    </li>
					<li class="<?php echo ($cmode == 'bancaIndividual' || $cmode == 'bancaBank') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-5" id="tabBanca" data-toggle="tab">Bancassurance Complaints</a>
                    </li>
					
                    <li class="<?php echo ($cmode == 'internal') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-6" id="tabVatality" data-toggle="tab">Vitality Complaints</a>
                    </li>
                    <li class="<?php echo ($cmode == 'corporate') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-2" id="tabCorporatePolicyholders" data-toggle="tab">Corporate Policyholders</a>
                    </li>
                   
                    <li class="<?php echo ($cmode == 'vatality') ? 'active': 'disabled hide' ?>">
                        <a href="#nav-tab-4" id="tabInternal" data-toggle="tab">Internal Complaints</a>
                    </li>
                    
                    <li class="next-button">
                        <a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade <?php echo $cmode=="individual" ? 'active in' : ''?>" id="nav-tab-1">
                <!-- begin Individual Life -->
                <?php if($cmode=="individual") {include('complaint_individual_edit.php');} ?>
                <!-- end Individual Life -->
            </div>
            <div class="tab-pane fade <?php echo $cmode=="corporate" ? 'active in' : ''?>" id="nav-tab-2">
                <!-- begin Corporate Policyholders -->
                 <?php if($cmode=="corporate") {include('complaint_corporate_edit.php');} ?>
                <!-- end Corporate Policyholders -->
            </div>
            <div class="tab-pane fade <?php echo $cmode=="legal" ? 'active in' : ''?>" id="nav-tab-3">
                <!-- begin Legal/Fraudalent Complaints -->
                 <?php if($cmode=="legal") {include('complaint_legal_edit.php');} ?>
                <!-- end Legal/Fraudalent Complaints -->
            </div>
            <div class="tab-pane fade <?php echo $cmode=="internal" ? 'active in' : ''?>" id="nav-tab-4">
                <!-- begin internal Complaints -->
                 <?php if($cmode=="internal") {include('complaint_internal_edit.php');} ?>
                <!-- end internal Complaints -->
            </div>
            <div class="tab-pane fade <?php echo ($cmode=="bancaIndividual" || $cmode=="bancaBank") ? 'active in' : ''?>" id="nav-tab-5">
                <!-- begin internal Complaints -->
                <?php if($cmode=="bancaIndividual") {include('complaint_banca_indvidual_edit.php');}elseif($cmode=="bancaBank"){include('complaint_banca_bank_edit.php'); } ?>
                <!-- end internal Complaints -->
            </div>
            <div class="tab-pane fade <?php echo $cmode=="vatality" ? 'active in' : ''?>" id="nav-tab-6">
                <!-- begin internal Complaints -->
                 <?php if($cmode=="vatality") {include('complaint_vatality_edit.php');} ?>
                <!-- end internal Complaints -->
            </div>
        </div>
    </div>
    <!-- end Tab panel -->
</div>


<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
        //masking();
    });
</script>

<script type="text/javascript">
     $('.my-datepicker').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoclose: true
    });
 

    // $(document).on('change', '#ddlProduct', function () {
    //     var id = $(this).val();
    //     $.ajax({
    //         type: "POST",
    //         url: "includes/ajax/action_complaint.php",
    //         data: { 'action': 'select_type', id: id }
    //     }).done(function (data) {
    //         $('#ddlComplaintType').html(data);
    //         $("#ddlComplaintType").select2();
    //     });
    // });

    // $(document).on('change', '#ddlProductCategory', function () {
    //     $("#ddlComplaintType").empty();
    //     var product_category = $(this).val();
    //     $.ajax({
    //         type: "POST",
    //         url: "includes/ajax/action_complaint_type.php",
    //         data:{
    //             action : "select_product",
    //             id: product_category
    //         }

    //     }).done(function (data) {
    //         $('#ddlProduct').html(data);
    //     });
    // });
    
    // function masking()
    // {
    //     $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

    //     $.mask.definitions["9"] = null;
    //     $.mask.definitions["^"] = "[0-9]";
    //     $(".number").mask("92^^^^^^^^^^");
    // }
</script>

</body>
</html>