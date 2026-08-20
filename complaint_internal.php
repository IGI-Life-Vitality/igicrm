<?php
   

     $objProd = new Product();
     $objComplaint = new Complaint();
?>

<div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
</div>

<div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
    <strong>Error!</strong>
    Error while saving record, Please try again!
    <span class="close" data-dismiss="alert">&times;</span>
</div>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintInternal">
        <input type="hidden" id="txtId" name="txtId" value="">
        <input type="hidden" id="actionI" name="actionI" value="save_complaint">
        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? echo $counter_display; ?>" />
        <input type="hidden" name="cmp_userI" id="cmp_userI" value="" />
        <input type="hidden" name="cmp_user_groupI" id="cmp_user_groupI" value="" />
        <input type="hidden" name="typeI" id="typeI" value="internal" />
        <input type="hidden" name="modeI" id="modeI" value="" />
        <input type="hidden" name="txtCounter" id="txtCounter" value="<? //echo $counter; ?>" />
        <input type="hidden" id="txtComplaintNo" name="txtComplaintNo" class="form-control" value="<? //echo $counter_display; ?>">

        <fieldset>
            <legend>Internal Complaint</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group" id="ComplaintTitle">
                        <label>Complainer Name</label>
                        <select class="form-control default-select2" id="ddlComplainerName" name="ddlComplainerName" data-placeholder="Select Complaint">
                            <option value="0" selected="selected" disabled>Select Complainer</option>
                            <?php $users = $objUser->GetUsers(0); ?>
                            <?php foreach($users as $user){ ?>
                                <option value="<? echo $user["id"]; ?>" <?php echo $data[0]['user_id'] == $user["id"] ? "selected='selected'" : ""?>><? echo $user["first_name"] ." ".$user["last_name"]?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complainer Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICI" name="txtCNICI" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group" id="ComplaintTitle">
                        <label>Department Name</label>
                        <select class="form-control default-select2" id="ddlDepartmentNameI" name="ddlDepartmentNameI" data-placeholder="Select Complaint" onchange="getcmp_type_int();">
                            <option value="0" selected="selected" disabled>Select Department</option>
                            <?php $groups = $objUser->GetGroups(); ?>
                            <?php foreach($groups as $group){ ?>
                                <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['group_id'] == $group["id"] ? "selected='selected'" : ""?>><? echo $group["primary_name"];?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Department is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="txtPriorityI" name="txtPriorityI" class="form-control" placeholder="Priority" readonly="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="reported_dtI" value="" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="received_dateI" value="" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlComplaintTypeI" name="ddlComplaintTypeI" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_int();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATI" name="txtComplaintTATI" class="form-control" placeholder="Complaint TAT" readonly="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionI" name="txtDescriptionI" rows="6" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintInternal" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." onclick ="internal_cmp();">Save</button>
            </div>
        </div>
    </form>
</div>

<!-- begin Modal Internal -->
<div class="modal fade" id="ModalDailyHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseDailyHours" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Daily Hours</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Internal -->

<style type="text/css">
    legend{
        margin: 0px 0px 10px 14px;
    }

    .select2-container--default{
        width: 100% !important;
    }
</style>

<script type="text/javascript">
    function getcmp_type_int()
    {
        var depart = $('#ddlDepartmentNameI').val();
        //alert(depart);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:{
                action : "get_cmp_type",
                id: depart
            }
        }).done(function (data) 
        {
           // alert(data);
            $('#ddlComplaintTypeI').html(data);
        });
    }
      
    function get_cmp_type_detail_int()
    {
        var cmptype = $('#ddlComplaintTypeI').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:
            {
                action : "get_cmp_detail",
                id: cmptype
            }
        }).done(function (data) 
        {
            //alert(data);
            var res = data.split('|');
            var $tat = res[3] + " Working Days";
            $('#cmp_userI').val(res[0]);
            $('#cmp_user_groupI').val(res[1]);
            $('#txtPriorityI').val(res[2]);
            $('#txtComplaintTATI').val($tat);
            //$('#typeI').val(res[4]);
            $('#modeI').val(res[5]);
        });
    }

    function internal_cmp()
    {
        var mode              = $('#modeI').val();
        var txtComplainerName = $('#ddlComplainerName').val(); 
        var txtCNIC = $('#txtCNICI').val(); 
        var reported_dt = $('#reported_dtI').val();
        var received_date = $('#received_dateI').val();
        var ddlDepartmentName = $('#ddlDepartmentNameI').val();
        var priority          = $('#txtPriorityI').val();
        var ddlComplaintType  = $('#ddlComplaintTypeI').val();
        var txtComplaintTAT   = $('#txtComplaintTATI').val();
        var txtDescription    = $('#txtDescriptionI').val();
        var type              = $('#typeI').val();
        var cmp_user          = $('#cmp_userI').val();
        var cmp_user_group    = $('#cmp_user_groupI').val();
        var action            = $('#actionI').val();
         
        if(validation_int())
        {
            $("#btnSaveComplaintInternal").button('loading');
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:
                {
                    'action'             : action,
                    'mode'               : mode,
                    'txtCNIC'               : txtCNIC,
                    'reported_dt'  : reported_dt,
                    'received_date'  : received_date,
                    'txtComplainerName'  : txtComplainerName,
                    'ddlDepartmentName'  : ddlDepartmentName,
                    'priority'           : priority,
                    'ddlComplaintType'   : ddlComplaintType,
                    'txtComplaintTAT'    : txtComplaintTAT,
                    'txtDescription'     : txtDescription,
                    'type'               : type,
                    'cmp_user'           : cmp_user,
                    'cmp_user_group'     : cmp_user_group,
                    'action'             : action
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                   $("#btnSaveComplaintInternal").button('reset');
                    var result = data.split("|");
                        getid = result[1];
                    var message = "Complaint created successfully with Complaint Id <strong>";

                    if(result[0] == 'success')
                    {
                        //$('#ModalCommentC').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  result[3] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                    }
                    else if(data == 'fail')
                    {
                        //$('#ModalCommentC').modal('hide');
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    }

    function validation_int()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#ddlDepartmentNameI').val() == null) 
        {
            $('#ddlDepartmentNameI').addClass('error-val');
            $('#ddlDepartmentNameI').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameI').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlDepartmentNameI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlDepartmentNameI').removeClass('error-val');
            //$('#ddlDepartmentNameI').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlDepartmentNameI').parent().find('.input-error').hide();
        }

        if($('#reported_dtI').val() == '') 
        {
            $('#reported_dtI').addClass('error-val');
            $('#reported_dtI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#reported_dtI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#reported_dtI').removeClass('error-val');
            //$('#reported_dtI').parents('.control-group').addClass('success');
            $('#reported_dtI').parent().find('.input-error').hide();
        }
        if($('#received_dateI').val() == '') 
        {
            $('#received_dateI').addClass('error-val');
            $('#received_dateI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_dateI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#received_dateI').removeClass('error-val');
            //$('#received_dateI').parents('.control-group').addClass('success');
            $('#received_dateI').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintTypeI').val() == 0 || $('#ddlComplaintTypeI').val() == null) 
        {
            $('#ddlComplaintTypeI').addClass('error-val');
            $('#ddlComplaintTypeI').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeI').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintTypeI').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeI').parent().find('.input-error').hide();
        }

        if($('#txtCNICI').val() == 0 || $('#txtCNICI').val() == null) 
        {
            $('#txtCNICI').addClass('error-val');
            $('#txtCNICI').parent().find('.input-error').show().css('display', 'inline-block');
            $('#txtCNICI').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#txtCNICI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCNICI').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNICI').parent().find('.input-error').hide();
        }

        if($('#ddlComplainerName').val() == null) 
        {
            $('#ddlComplainerName').addClass('error-val');
            $('#ddlComplainerName').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplainerName').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlComplainerName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplainerName').removeClass('error-val');
            $('#ddlComplainerName').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlComplainerName').parent().find('.input-error').hide();
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