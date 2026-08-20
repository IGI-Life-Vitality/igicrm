<?php
$page_title = "Add Complain";
$permission_type = "create";
$module_id = "3";
$parent_id ="19";
$menu_id = "complaint_add";

include('includes/header.php');
include('classes/complaint.php');
include('classes/product.php');

$objProd = new Product();
$objComplaint = new Complaint();
// $data_counter = explode('|',$objComplaint->GenComplaintCounter());

// $counter_display = $data_counter[0];
// $counter = $data_counter[1];
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
                    <li class="active">
                        <a href="#nav-tab-1" id="tabIndividualLife" data-toggle="tab">Individual Life</a>
                    </li>
					 <li class="">
                        <a href="#nav-tab-3" id="tabLegalComplaints" data-toggle="tab">Legal/Fraudalent Complaints</a>
                    </li>
					<li class="">
                        <a href="#nav-tab-5" id="tabBanca" data-toggle="tab">Bancassurance Complaints</a>
                    </li>
					
                    <li class="">
                        <a href="#nav-tab-6" id="tabVatality" data-toggle="tab">Vitality Complaints</a>
                    </li>
                    <li class="">
                        <a href="#nav-tab-2" id="tabCorporatePolicyholders" data-toggle="tab">Corporate Policyholders</a>
                    </li>
                   
                    <li class="">
                        <a href="#nav-tab-4" id="tabInternal" data-toggle="tab">Internal Complaints</a>
                    </li>
                    
                    <li class="next-button" style="">
                        <a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade active in" id="nav-tab-1">
                <!-- begin Individual Life -->
                <?php include('complaint_individual.php'); ?>
                <!-- end Individual Life -->
            </div>
            <div class="tab-pane fade" id="nav-tab-2">
                <!-- begin Corporate Policyholders -->
                <?php include('complaint_corporate.php'); ?>
                <!-- end Corporate Policyholders -->
            </div>
            <div class="tab-pane fade" id="nav-tab-3">
                <!-- begin Legal/Fraudalent Complaints -->
                <?php include('complaint_legal.php'); ?>
                <!-- end Legal/Fraudalent Complaints -->
            </div>
            <div class="tab-pane fade" id="nav-tab-4">
                <!-- begin internal Complaints -->
                <?php include('complaint_internal.php'); ?>
                <!-- end internal Complaints -->
            </div>
            <div class="tab-pane fade" id="nav-tab-5">
                <!-- begin internal Complaints -->
                <?php include('complaint_banca.php'); ?>
                <!-- end internal Complaints -->
            </div>
            <div class="tab-pane fade" id="nav-tab-6">
                <!-- begin internal Complaints -->
                <?php include('complaint_vatality.php'); ?>
                <!-- end internal Complaints -->
            </div>
        </div>
    </div>
    <!-- end Tab panel -->
</div>
<!-- end #content -->

<div class="modal fade" id="ModalComment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseComments" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalform" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_main" name="complaint_id_main" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_main" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_display" name="counter_display" value="">

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

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDiv">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUpload" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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

<div class="modal fade" id="ModalCommentC" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseCommentsC" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalformC" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_mainC" name="complaint_id_mainC" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_mainC" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_displayC" name="counter_displayC" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsC" class="form-control" id="txtComments1C" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadC1" id="fileuploadC1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileC1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadC2" id="fileuploadC2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileC2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadC3" id="fileuploadC3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileC3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadC4" id="fileuploadC4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileC4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadC5" id="fileuploadC5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDivC">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUploadC" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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

<div class="modal fade" id="ModalCommentL" tabindex="-1" role="dialog" aria-labelledby="myModalLabeL" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseCommentsL" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalformL" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_mainL" name="complaint_id_mainL" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_mainL" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_displayL" name="counter_displayL" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsL" class="form-control" id="txtCommentsL" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadL1" id="fileuploadL1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileL1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadL2" id="fileuploadL2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileL2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadL3" id="fileuploadL3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileL3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadL4" id="fileuploadL4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileL4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadL5" id="fileuploadL5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDivL">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUploadL" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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

<div class="modal fade" id="ModalCommentB" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseCommentsB" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalformB" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_mainB" name="complaint_id_mainB" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_mainB" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_displayB" name="counter_displayB" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsB" class="form-control" id="txtCommentsB" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadB1" id="fileuploadB1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileB1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadB2" id="fileuploadB2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileB2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadB3" id="fileuploadB3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileB3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadB4" id="fileuploadB4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileB4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadB5" id="fileuploadB5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDivB">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUploadB" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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

<div class="modal fade" id="ModalCommentBB" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseCommentsBB" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalformBB" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_mainBB" name="complaint_id_mainBB" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_mainBB" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_displayBB" name="counter_displayBB" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsBB" class="form-control" id="txtCommentsBB" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadBB1" id="fileuploadBB1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileBB1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadBB2" id="fileuploadBB2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileBB2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadBB3" id="fileuploadBB3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileBB3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadBB4" id="fileuploadBB4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileBB4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadBB5" id="fileuploadBB5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDivBB">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUploadBB" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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

<div class="modal fade" id="ModalCommentV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <!-- <a id="btnCloseCommentsV" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a> -->
                        </div>
                        <h4 class="panel-title">Add Complaint</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalformV" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="complaint_id_mainV" name="complaint_id_mainV" value="<?php echo($data[0]['complaint_id']); ?>">
                                <input type="hidden" class="form-control" name="action" value="upload">
                                <input type="hidden" class="form-control" id ="type_mainV" name="type" value="">
                                <input type="hidden" class="form-control" id="counter_displayV" name="counter_displayV" value="">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsV" class="form-control" id="txtCommentsV" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadV1" id="fileuploadV1">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileB1" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadV2" id="fileuploadV2">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileV2" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadV3" id="fileuploadV3">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileV3" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadV4" id="fileuploadV4">
                                    </div>
                                </div>

                                <div class="col-md-12" id="SelectFileV4" style="display: none;">
                                    <div class="form-group">
                                        <label>Select File</label>
                                        <input type="file" class="form-control" name="fileuploadV5" id="fileuploadV5">
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin: 0px 0px 10px -15px;">
                                    <a class="btn btn-icon btn-success" id="btnFileUplaodDivV">
                                    <i class="fa fa fa-plus-square"></i></a>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnFileUploadV" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Finish</button>
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
    $(document).ready(function() {
        var counter = 1;
        var counterC = 1;
        var counterL = 1;
        var counterB = 1;
        var counterBB = 1;
        var counterV = 1;
        var getid = 0;

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
                success: function (data) 
                {
                    $("#btnFileUpload").button('reset');
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";
                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success')
                    {
                        $('#ModalComment').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }
                    else
                    {
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

        /*haroon work*/
        $(document).on('click', '#btnFileUplaodDivC', function () {
            if(counterC > 4){
                alert("Can not add more.");
            }
            else if(counterC == 1){
                $('#SelectFileC1').css('display','block');
                counterC++;
            }
            else if(counterC == 2){
                $('#SelectFileC2').css('display','block');
                counterC++;
            }
            else if(counterC == 3){
                $('#SelectFileC3').css('display','block');
                counterC++;
            }
            else if(counterC == 4){
                $('#SelectFileC4').css('display','block');
                counterC++;
            }
        });

        $(document).on('click', '#btnFileUploadC', function () {
            var formdata = new FormData($('#modalformC')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUploadC").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,
                success: function (data) 
                {
                    $("#btnFileUploadC").button('reset');
                     ///alert(data);
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";

                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success'){
                        $('#ModalCommentC').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }else{
                        $('#ModalCommentC').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }

            });
        });

        $(document).on('click', '#btnCloseCommentsC', function () {
            $('#ModalCommentC').modal('hide');
        });

        $('#fileuploadC1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadC1').val('');
            }
        });

        $('#fileuploadC2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadC2').val('');
                return false;
            }
        });

        $('#fileuploadC3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadC3').val('');
                return false;
            }
        });

        $('#fileuploadC4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadC4').val('');
                return false;
            }
        });

        $('#fileuploadC5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadC5').val('');
                return false;
            }
        });
        /*haroon co-operate work end*/

        /*haroon legal work */
        $(document).on('click', '#btnFileUplaodDivL', function () {
            if(counterL > 4){
                alert("Can not add more.");
            }
            else if(counterL == 1){
                $('#SelectFileL1').css('display','block');
                counterL++;
            }
            else if(counterL == 2){
                $('#SelectFileL2').css('display','block');
                counterL++;
            }
            else if(counterL == 3){
                $('#SelectFileL3').css('display','block');
                counterL++;
            }
            else if(counterL == 4){
                $('#SelectFileL4').css('display','block');
                counterL++;
            }
        });

        $(document).on('click', '#btnFileUploadL', function () {

            var formdata = new FormData($('#modalformL')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUploadL").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,
                success: function (data) 
                {
                    $("#btnFileUploadL").button('reset');
                     ///alert(data);
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";

                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success')
                    {
                        $('#ModalCommentL').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }
                    else
                    {
                        $('#ModalCommentL').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }

            });
        });

        $(document).on('click', '#btnCloseCommentsL', function () {
            $('#ModalCommentL').modal('hide');
        });

        $('#fileuploadL1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadL1').val('');
            }
        });

        $('#fileuploadL2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadL2').val('');
                return false;
            }
        });

        $('#fileuploadL3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadL3').val('');
                return false;
            }
        });

        $('#fileuploadL4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadL4').val('');
                return false;
            }
        });

        $('#fileuploadL5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadL5').val('');
                return false;
            }
        });
        /*haroon work end */

        /*haroon banca work */
        $(document).on('click', '#btnFileUplaodDivB', function () {
            if(counterB > 4){
                alert("Can not add more.");
            }
            else if(counterB == 1){
                $('#SelectFileB1').css('display','block');
                counterB++;
            }
            else if(counterB == 2){
                $('#SelectFileB2').css('display','block');
                counterB++;
            }
            else if(counterB == 3){
                $('#SelectFileB3').css('display','block');
                counterB++;
            }
            else if(counterB == 4){
                $('#SelectFileB4').css('display','block');
                counterB++;
            }
        });

        $(document).on('click', '#btnFileUploadB', function () {
            var formdata = new FormData($('#modalformB')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUploadB").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,
                success: function (data) 
                {
                    $("#btnFileUploadB").button('reset');
                     //alert(data);
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";

                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success'){
                        $('#ModalCommentB').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }else{
                        $('#ModalCommentB').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        });

        $(document).on('click', '#btnCloseCommentsB', function () {
            $('#ModalCommentB').modal('hide');
        });

        $('#fileuploadB1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadB1').val('');
            }
        });

        $('#fileuploadB2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadB2').val('');
                return false;
            }
        });

        $('#fileuploadB3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadB3').val('');
                return false;
            }
        });

        $('#fileuploadB4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadB4').val('');
                return false;
            }
        });

        $('#fileuploadB5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadB5').val('');
                return false;
            }
        });
        /*work end */

        /*banca bank*/
        $(document).on('click', '#btnFileUplaodDivBB', function () {
            if(counterBB > 4){
                alert("Can not add more.");
            }
            else if(counterBB == 1){
                $('#SelectFileBB1').css('display','block');
                counterBB++;
            }
            else if(counterBB == 2){
                $('#SelectFileBB2').css('display','block');
                counterBB++;
            }
            else if(counterBB == 3){
                $('#SelectFileBB3').css('display','block');
                counterBB++;
            }
            else if(counterBB == 4){
                $('#SelectFileBB4').css('display','block');
                counterBB++;
            }
        });

        $(document).on('click', '#btnFileUploadBB', function () {
            var formdata = new FormData($('#modalformBB')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUploadBB").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,
                success: function (data) 
                {
                    $("#btnFileUploadBB").button('reset');
                    //alert(data);
                    //data = data.trim();
                    console.log(data);
                    //alert(data);
                    var message = "Complaint created successfully with Complaint Id <strong>";
                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success')
                    {
                        $('#ModalCommentBB').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }
                    else
                    {
                        $('#ModalCommentBB').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }

            });
        });

        $(document).on('click', '#btnCloseCommentsBB', function () {
            $('#ModalCommentBB').modal('hide');
        });

        $('#fileuploadBB1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadBB1').val('');
            }
        });

        $('#fileuploadBB2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadBB2').val('');
                return false;
            }
        });

        $('#fileuploadBB3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadBB3').val('');
                return false;
            }
        });

        $('#fileuploadBB4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadBB4').val('');
                return false;
            }
        });

        $('#fileuploadBB5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadBB5').val('');
                return false;
            }
        });
        /*work end banca bank*/

        /*vatality start*/
        $(document).on('click', '#btnFileUplaodDivV', function () {
            if(counterV > 4){
                alert("Can not add more.");
            }
            else if(counterV == 1){
                $('#SelectFileV1').css('display','block');
                counterV++;
            }
            else if(counterV == 2){
                $('#SelectFileV2').css('display','block');
                counterV++;
            }
            else if(counterV == 3){
                $('#SelectFileV3').css('display','block');
                counterV++;
            }
            else if(counterV == 4){
                $('#SelectFileV4').css('display','block');
                counterV++;
            }
        });

        $(document).on('click', '#btnFileUploadV', function () {

            var formdata = new FormData($('#modalformV')[0]);
            formdata.append('complaint_id',getid);

            $("#btnFileUploadV").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                async: true,
                contentType: false,
                processData: false,
                cache: false,
                data: formdata,

                success: function (data) 
                {
                    $("#btnFileUploadV").button('reset');
                     //alert(data);
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    var message = "Complaint created successfully with Complaint Id <strong>";

                    var tempdata = data.split("|");

                    if(tempdata[0] == 'success'){
                        $('#ModalCommentV').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[1] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }else{
                        $('#ModalCommentV').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        });

        $(document).on('click', '#btnCloseCommentsV', function () {
            $('#ModalCommentV').modal('hide');
        });

        $('#fileuploadV1').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadV1').val('');
            }
        });

        $('#fileuploadV2').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadV2').val('');
                return false;
            }
        });

        $('#fileuploadV3').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadV3').val('');
                return false;
            }
        });

        $('#fileuploadV4').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadV4').val('');
                return false;
            }
        });

        $('#fileuploadV5').bind('change', function() {
            var size = (this.files[0].size/1024/1024);
            if(Math.trunc(size) > 2) {
                alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
                $('#fileuploadV5').val('');
                return false;
            }
        });
        /*end vatality*/
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
    
    function masking()
    {
        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }
</script>

</body>
</html>