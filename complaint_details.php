<?php
$page_title = "Complaint Details";
$permission_type = "view";
$module_id = "3";
$parent_id ="19";
$menu_id = "complaint_views";

include('includes/header.php');
include('classes/complaint.php');
include('classes/product.php');

$objProd = new Product();
$objComplaint = new Complaint();

if(isset($_GET))
{
    $id     = isset($_GET['id'])?$_GET['id']:0;
    $cmode  = isset($_GET['cmode'])?$_GET['cmode']:0;

    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $Activity_data       = $objComplaint->GetComplaintStatus($id,$cmode);
        $heading    = "Complaint Details";
    }
    else
    {
        $heading    = "Complaint Management";
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
    <h1 class="page-header"><?php echo $heading; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-4">
                <div class="panel-heading p-0">
                    <!-- <div class="panel-heading-btn-igi panel-heading-btn m-r-10 m-t-10">
                        <label for="file-upload" class="custom-file-upload">
                            <a class="btn btn-icon btn-circle btn-info btnAdd" title="Click Here To Add" id=""><i class="fa fa fa-plus-square"></i></a>
                        </label>
                    </div> -->

                    <!-- begin nav-tabs -->
                    <div class="tab-overflow overflow-right">
                        <ul class="nav nav-pills nav-tabs-inverse">
                            <li class="prev-button">
                                <a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a>
                            </li>
                            <?php if($cmode == 'individual') { ?>
                            <li class="active">
                                <a href="#nav-tab-1" id="tabIndividualLife" data-toggle="tab">Individual Life</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-1" id="tabIndividualLife" data-toggle="tab">Individual Life</a>
                            </li>
                            <?php } ?>

                            <?php if($cmode == 'legal') { ?>
                            <li class="active">
                                <a href="#nav-tab-3" id="tabLegalComplaints" data-toggle="tab">Legal/Fraudalent Complaints</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-3" id="tabLegalComplaints" data-toggle="tab">Legal/Fraudalent Complaints</a>
                            </li>
                            <?php } ?>

                            <?php if($cmode == 'bancaIndividual' || $cmode == 'bancaBank' ) { ?>
                            <li class="active">
                                <a href="#nav-tab-5" id="tabBanca" data-toggle="tab">Bancassurance  Complaints</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-5" id="tabBanca" data-toggle="tab">Bancassurance Complaints</a>
                            </li>
                            <?php } ?>

                            <?php if($cmode == 'vatality') { ?>
                            <li class="active">
                                <a href="#nav-tab-6" id="tabVatality" data-toggle="tab">Vitality  Complaints</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-6" id="tabVatality" data-toggle="tab">Vitality Complaints</a>
                            </li>
                            <?php } ?>

                            <?php if($cmode == 'corporate') { ?>
                            <li class="active">
                                <a href="#nav-tab-2" id="tabCorporatePolicyholders" data-toggle="tab">Corporate Policyholders</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-2" id="tabCorporatePolicyholders" data-toggle="tab">Corporate Policyholders</a>
                            </li>
                            <?php } ?>

                            
                            
                            <?php if($cmode == 'internal') { ?>
                            <li class="active">
                                <a href="#nav-tab-4" id="tabInternal" data-toggle="tab">Internal Complaints</a>
                            </li>
                            <?php } else { ?>
                            <li class="disabled">
                                <a href="#nav-tab-4" id="tabInternal" data-toggle="tab">Internal Complaints</a>
                            </li>
                            <?php } ?>

                            <li class="next-button" style="">
                                <a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-tab-1">
                        <!-- begin Individual Life -->
                        <?php if($cmode=="individual") {include('complaint_individual_details.php');} ?>
                        <!-- end Individual Life -->    
                    </div>
                    <div class="tab-pane fade active in" id="nav-tab-2">
                        <!-- begin Corporate Policyholders -->
                        <?php if($cmode =="corporate") {include('complaint_corporate_details.php');} ?>
                        <!-- end Corporate Policyholders -->
                    </div>
                    <div class="tab-pane fade active in" id="nav-tab-3">
                        <!-- begin Legal/Fraudalent Complaints -->
                        <?php if($cmode=="legal") {include('complaint_legal_details.php');} ?>
                        <!-- end Legal/Fraudalent Complaints -->
                    </div>
                    <div class="tab-pane fade active in" id="nav-tab-4">
                        <!-- begin internal Complaints -->
                        <?php if($cmode=="internal") {include('complaint_internal_details.php');} ?>
                        <!-- end internal Complaints -->
                    </div>

                    <div class="tab-pane fade active in" id="nav-tab-5">
                        <!-- begin internal Complaints -->
                        <?php if($cmode=="bancaIndividual") {include('complaint_banca_indvidual_details.php');}elseif($cmode=="bancaBank"){include('complaint_banca_bank_details.php'); } ?>
                        <!-- end internal Complaints -->
                    </div>
                     <div class="tab-pane fade active in" id="nav-tab-6">
                        <!-- begin internal Complaints -->
                        <?php if($cmode=="vatality") {include('complaint_vatality_details.php');} ?>
                        <!-- end internal Complaints -->
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
                                <!-- <th>Assigned To</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $users = $objUser->GetUsers(0);
                                $counter = 0;
                                $users_ids =  explode(",",$Activity_data[0]['assign_to']);
                            ?>
                            <?php foreach($Activity_data as $row){ ?>
                                <?php
                                    $status = "";
                                    
                                    if($row["current_state"] == 2)
                                    {
                                        $curr_status = "In Progress";
                                        $pre_status  = "Initiated";
                                    }
                                    elseif($row["current_state"] == 3)
                                    {
                                        $curr_status = "Resolved";
                                        $pre_status  = "In Progress";
                                    }
                                    elseif($row["current_state"] == 4)
                                    {
                                        $curr_status = "UnResolved";
                                        $pre_status  = "In Progress";
                                    }
                                    elseif($row["current_state"] == 5) 
                                    {
                                        $curr_status = "Invalid";
                                        $pre_status = "Initiated";
                                    }
                                    elseif($row["current_state"] == 1) 
                                    {
                                        $curr_status = "Forwarded";
                                        $pre_status = "Invalid";
                                    }
                                ?>
                                <tr>
                                    <td><? echo $row["update_datetime"] ?></td>
                                    <td><? echo $pre_status ?></td>
                                    <td><? echo $curr_status ?></td>
                                    <td><? echo $row["activity_performer"] ?></td>
                                    <td><? echo $row["comments"] ?></td>
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

<!-- Begin Verification Modal -->
<div class="modal fade" id="ModalVerify" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseComments" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Complaint Details</h4>
                    </div>
                </div>
                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">
                    <div class="panel-body">
                        <form role="form" autocomplete="off" method="post" class="form-horizontal" id="modalComplaint" enctype="multipart/form-data" style="clear:both">
                            <fieldset>
                                <input type="hidden" class="form-control" id="txtId" value="<?php echo($data[0]['compl_id']); ?>">
                                <input type="hidden" id="txtEForm" name="txtEForm" class="form-control"  value="<? echo $data[0]['complaint_num'] ?>">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text"  id="comments" class="form-control" id="txtComments1" row="5" placeholder="Final Comments"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" id="btnVerified" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Verify</button>
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
<!-- End Verification Modal -->

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

<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>

<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<style type="text/css">
    legend {
        margin: 0px 0px 10px 14px;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        Notification.init();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
       $(".nav li.disabled a").click(function() {
         return false;
       });
    });

    $("#btnSubmitComplaint").click(function () {
        var id = $('#txtId').val();
        var action = "";

        var user_type = <? echo $user_type ?>;
        var progress = $('#ddlProgress').val();
        
        if (progress == '101') 
        {
            action = "update_progress";
        }
        else 
        {
            // user_type == 2 ? "edit_complaint" :
            action =  "update_progress";
        }

        var channel = $('#ddlChannel').val();
        var notes = $('#txtActivity').val();
        var group = $('#ddlGroup').val();
        var user = $('#ddlUsers').val();

        $("#btnSubmitComplaint").button('loading');

        if (validation(user_type)) 
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: 
                {
                    'complaint_id': id,
                    'action': action,
                    'channel': channel,
                    'progress': progress,
                    'notes': notes,
                    'group': group,
                    'user': user
                },
                success: function (data) {
                    $("#btnSubmitComplaint").button('reset');

                    data = data.trim();
                    //alert(data);
                    //console.log(data);

                    if (data == 'success') 
                    {
                        $.notifyBar({
                            cssClass: "success",
                            html: "Data Saved Successfully",
                            delay: 2000,
                            animationSpeed: "normal"
                        });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php"
                        }, 3000);
                    }
                    else if (data == 'fail') 
                    {
                        $.notifyBar({
                            cssClass: "error",
                            html: "Error Occured",
                            delay: 2000,
                            animationSpeed: "normal"
                        });
                    }
                }
            });
        }
    });

    $(document).on('change', '#ddlGroup', function () {
        $('#ddlUsers').empty();
        var group_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_user.php",
            data: {
                action: "select_users",
                id: group_id
            }
        }).done(function (data) {
            //console.log(data);
            $('#ddlUsers').html(data);
        });
    });

    /* Begin Modal Verified */
    $(document).on('click', '#btnVerify', function () {
        $('#ModalVerify').modal({backdrop: 'static', keyboard: false});
        $('#ModalVerify').modal('show');
        return false;
    });

    $(document).on('click', '#btnCloseComments', function () {
        $('#ModalVerify').modal('hide');
    });


    $(document).on('click', '#btnVerified', function () {
        var id = $("#txtId").val();

        var comments = $("#comments").val();

        $("#btnVerified").button('loading');

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint.php",
            data:{
                'complaint_id'         :id,
                'action'               :"verification_comment",
                'comments'             :comments
            },
            success: function (data) {

                $("#btnVerified").button('reset');

                data = data.trim();
                //alert(data);
                console.log(data);

                if(data == 'success'){
                    $('#ModalVerify').modal('hide');
                    $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                    setTimeout(function () { window.location.href = "complaint_views.php" }, 3000);
                }else if(data == 'fail'){
                    $('#ModalVerify').modal('hide');
                    $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                }
            }
        });
    });
    /* End Modal Verified */
</script>

</body>
</html>