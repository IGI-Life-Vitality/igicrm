<?php
    $objProd = new Product();
    $objComplaint = new Complaint();

    $users = $objUser->GetUsers(0);   

    $disa       = "";
    $dis_button = "";
    $disabled = "";
    $disable_info = "";
    $email_checked = "";
    $sms_checked = "";
    $call_back_checked = "";
    $disable_complaint_progress   = "";
    $comments_progress       = "";
    $disabled_comments       = "";
    $heading = "Complaint Management";

    if(isset($_GET))
    {
        $complaint_id   = isset($_GET['id']) ? $_GET['id'] : 0;
        $cmode          = isset($_GET['cmode']) ? $_GET['cmode'] : 0;

        $heading = "";
        $isactive = "";

        if($complaint_id > 0)
        {
            $data                   = $objComplaint->GetComplaintByIdInternal($complaint_id,$cmode);
            $activity_data          = $objComplaint->GetComplaintStatusById($complaint_id,$cmode);
            $complanierNam          = $objUser->GetUsersById($data[0]['complanier']);

            $dis_button             = ($data[0]['status_id'] == 3  || $data[0]['status_id'] == 6 || $data[0]['user_id'] != $login_id && $data[0]['user_id'] != 0 ) ? "disabled='true'" : "";

            $dis_button_invalid     = ($data[0]['status_id'] == 5 && $data[0]['group_id'] == 0 && $data[0]['user_id'] == 0 && $data[0]['user_id'] != $login_id && $data[0]['agent_id'] != $login_id) ? "disabled='true'" : "";
            $dis_btn_once_invalid   = ($data[0]['status_id'] == 5 && $data[0]['user_id'] == $login_id && $data[0]['progress'] == 0) ? "disabled='true'" : "";

            $disable_complaint_progress  = ($data[0]["progress"] == 100 ||  $data[0]['user_id'] == 0)? "disabled='true'" : "";

            $comments_progress   = ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments   = ($data[0]['status_id'] == 3 || $data[0]['status_id']== 6 ||  $data[0]['user_id'] == 0) ? "disabled='true'" : "";

            $email_checked       = $data[0]['is_email'] == 0 ? "checked='true'" : "";
            $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='true'" : "";
            $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='true'" : "";
            $us                  = explode(',', $group_id);

            if(in_array($data[0]['group_id'], $us) && $user_type == 2 && ($data[0]['status_id']== 5 || $data[0]['status_id'] == 4))
            {
                $dis_button = "";
            }
        }
        else
        {
            $heading = "";
        }
    }
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintInternal">
        <input type="hidden" id="txtIdi" name="txtIdi" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actioni" name="actioni" value="update_progress">
        <input type="hidden" name="cmodei" id="cmodei" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_idi" id="user_idi" value="<?php echo($data[0]['user_id']); ?>" />
        <input type="hidden" name="cmp_invalidi" id="cmp_invalidi" value="<?php if($data[0]['status_id'] == 5 ){ echo '1';}else{echo '0';} ?>" />
        <input type="hidden" name="user_id_ressigni" id="user_id_ressigni" value="0" />
        <input type="hidden" name="is_manuali" id="is_manuali" value="1" />
        <input type="hidden" name="statusi" id="statusi" value="<?php echo $data[0]['status_id'];?>" />

        <fieldset>
            <legend>Internal Complaint</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group" id="ComplaintTitle">
                        <label>Complainer Name</label>
                        <input type="text" id="ddlComplainerName" name="ddlComplainerName" class="form-control" value="<?php echo $complanierNam[0]['first_name']." ".$complanierNam[0]['last_name']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICI" name="txtCNICI" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15" value="<?php echo $data[0]['cnic']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group" id="ComplaintTitle">
                        <label>Department Name</label>
                        <input type="text" id="ddlDepartmentNameI2" name="ddlDepartmentNameI2" class="form-control" value="<?php echo $data[0]['department_name']; ?>" disabled="true">
                        <input type="hidden" name="ddlDepartmentNameI" id="ddlDepartmentNameI" value="<?php echo $data[0]['complaint_depart']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <input type="text" id="ddlComplaintTypeI2" name="ddlComplaintTypeI2" class="form-control" value="<?php echo $data[0]['complaint_type']; ?>" disabled="true">
                        <input type="hidden" name="ddlComplaintTypeI" id="ddlComplaintTypeI" value="<?php echo $data[0]['complaint_type_id']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="txtPriorityI" name="txtPriorityI" class="form-control" value="<?php echo $data[0]['priority_id']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="reported_dtI" value="<?php echo Date("d-M-Y",strtotime($data[0]['reported_dt'])) ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <!-- <div class="col-md-12">
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] == 5) { ?>
                <div class="col-md-3">
                    <div class="form-group" id="ComplaintTitle">
                        <label>Department Name</label>
                        <select class="form-control default-select2" id="ddlDepartmentNameI" name="ddlDepartmentNameI" data-placeholder="Select Complaint" onchange="getcmp_type_int_dtl();">
                            <option value="0" selected="selected" disabled>Select Department</option>
                            <?php $groups = $objUser->GetGroups(); ?>
                            <?php foreach($groups as $group){ ?>
                                <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['group_id'] == $group["id"] ? "selected='selected'" : ""?>><? echo $group["primary_name"];?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Department is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlComplaintTypeI" name="ddlComplaintTypeI" data-placeholder="Select Complaint Type" onchange="get_cmp_type_int_dtl();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <?php }else{ ?>
                
                
                <div class="col-md-1">
                </div>
               <?php } ?>
            </div> -->
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="received_dateI" value="<?php echo Date("d-M-Y",strtotime($data[0]['received_date'])); ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATI" name="txtComplaintTATI" class="form-control" value="<?php echo $data[0]['tat']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionI" name="txtDescriptionI" rows="6" class="form-control" disabled="true"><?php echo $data[0]['comments']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] != 5) {?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Assign To<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="cmp_user_namei" name="cmp_user_namei" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select User</option>
                             <?php $users = $objUser->GetUsers(0); ?>
                            <?php foreach($users as $user){ ?>
                            <option value="<? echo $user["id"]; ?>" <?php echo $data[0]['user_id'] == $user["id"] ? "selected='selected'" : ""?>><? echo $user["first_name"] ." ".$user["last_name"]?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">User is required</div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-1">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Activity</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Progress</label>
                        <select class="form-control default-select2" id="ddlProgressI" name="ddlProgressL" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_complaint_progress; ?>>
                           <?php if($user_type == 2 && $data[0]['status_id'] == 5 ){?>
                                 <option value="101" <?php if($data[0]['progress'] =="101") echo "selected=selected"?> >Invalid</option>
                                 <option value="99" <?php if($data[0]['progress'] =="99") echo "selected=selected"?>>Valid</option>
                           <?php }elseif($user_type == 2 && $data[0]['status_id'] == 4 ){?>

                                  <option value="11" <?php if($data[0]['progress'] =="11") echo "selected=selected"?> >UnResolved</option>
                                  <option value="50" <?php if($data[0]['progress'] =="50") echo "selected=selected"?> >In Progress</option>
                            <?php }else{?>
                            <option value="0"  <?php if($data[0]['progress'] =="0") echo "selected=selected"?>  disabled="disabled">Select Progress</option>
                            <option value="100" <?php if($data[0]['progress'] =="100") echo "selected=selected"?> >Resolved</option>
                            <option value="50" <?php if($data[0]['progress'] =="50") echo "selected=selected"?> >In Progress</option>
                            <option value="101" <?php if($data[0]['progress'] =="101") echo "selected=selected"?> >Invalid</option>
                            <option value="11" <?php if($data[0]['progress'] =="11") echo "selected=selected"?> >UnResolved</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>Comments<span style="color: red;">*</span></label>
                        <textarea type="text" class="form-control" id="txtActivityI" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 4) ? $comments_progress : ''; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintInternal" <? echo $dis_button; ?> <? echo $dis_button_invalid; ?> <? echo $dis_btn_once_invalid; ?> data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." onclick ="internal_cmp();">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    legend{
        margin: 0px 0px 10px 14px;
    }

    .select2-container--default{
        width: 100% !important;
    }
</style>

<script type="text/javascript">
    // Working in details view START
    function internal_cmp()
    {
        var manual = 0;
        var new_user ="";
        var id            = $('#txtIdi').val();
        var action        = 'update_progress';
        var user_type     = <? echo $user_type ?>;
        var progress      = $('#ddlProgressI').val();
        var user_id       = $('#user_idi').val();
        var notes         = $('#txtActivityI').val();
        var cmode         = $('#cmodei').val();
        var cmp_user_name = $('#cmp_user_namei').val();
        var invalid       = $('#cmp_invalidi').val();
        var tat           = $('#txtComplaintTATI').val();
        var priority      = $('#txtPriorityI').val();
        var user          = $('#user_id_ressigni').val();
        var is_manual     = $('#is_manuali').val();
        var departmentName = $('#ddlDepartmentNameI').val();
        var cmp_type       = $('#ddlComplaintTypeI').val();
        var Assign_to      = "";
        var new_user       = user_id;

        if(invalid == 1 && is_manual == 1)
        {
            manual = 2;
        }
        
        if(user_id == 0 && is_manual == 0 && user != 0 && invalid == 1)
        {
            manual = 1;
            is_manual = 0;
            new_user = user;
        }

        if(user_id == 0 && is_manual == 1 && invalid == 0)
        {
            manual = 1;
            new_user = cmp_user_name;
            is_manual = 1;
        }
     
        if(new_user == 'undefined' || new_user == '' || new_user == 'null' || new_user == null)
        {
            new_user = 0;
        }

        if(validationI(user_type))
        {
            $("#btnSaveComplaintInternal").button('loading');
            
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: 
                {
                    'id'            :id,
                    'action'        :action,
                    'progress'      :progress,
                    'notes'         :notes,
                    'cmode'         :cmode,
                    'manual'        :manual,
                    'invalid'       :invalid,
                    'cmp_user_name' :cmp_user_name,
                    'tat'           :tat,
                    'priority'      :priority,
                    'user_id'       :user_id,
                    'new_user'      :new_user,
                    'is_manual'     :is_manual,
                    'departmentName' :departmentName,
                    'cmp_type'       :cmp_type
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                    //$("#btnSaveComplaintInternal").button('reset');

                    data = data.trim();
                    //alert(data);
                    //console.log(data);

                    if(data == 'success')
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () { window.location.href = "complaint_views.php" }, 3000);
                    }
                    else if(data == 'fail')
                    {
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    } 

    function validationI(user_type)
    {
        var hasFocus = false;
        var errCount = 0;
        var user_id  = $('#user_idi').val();
        var invalid  = $('#cmp_invalidi').val();
        var status   = $('#statusi').val();

        if(user_id == 0 && invalid == 1)
        {
           if($('#ddlDepartmentNameI').val() == null || $('#ddlDepartmentNameI').val()  == "") 
            {
                $('#ddlDepartmentNameI').addClass('error-val');
                $('#ddlDepartmentNameI').parent().find('.input-error').show().css('display', 'inline-block');
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
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlDepartmentNameI').parent().find('.input-error').hide();
            }


            if($('#ddlComplaintTypeI').val() == null || $('#ddlComplaintTypeI').val()  == "") 
            {
                $('#ddlComplaintTypeI').addClass('error-val');
                $('#ddlComplaintTypeI').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
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
        }
        else if(user_id == 0 && invalid == 0 && status != 5)
        {
            if($('#cmp_user_namei').val() == null || $('#cmp_user_namei').val()  == "") 
            {
                $('#cmp_user_namei').addClass('error-val');
                $('#cmp_user_namei').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#cmp_user_namei').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#cmp_user_namei').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#cmp_user_namei').parent().find('.input-error').hide();
            }
        }

        // if(user_type == 4)
        // {
            if($('#txtActivityI').val() == "") 
            {
                $('#txtActivityI').addClass('error-val');
                $('#txtActivityI').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivityI').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivityI').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivityI').parent().find('.input-error').hide();
            }
        // }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    } 
    // Working in details view END

    function getcmp_type_int_dtl()
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
  
    function get_cmp_type_int_dtl()
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

            if(res[0] == 0)
            {
                $('#is_manuali').val('1');
                $('#cmp_invalidi').val('0');
            }
            else
            {
                $('#is_manuali').val('0');
            } 

            var $tat = res[3] + " Working Days";

            $('#user_id_ressigni').val(res[0]);
            // $('#cmp_user_groupI').val(res[1]);
            $('#txtPriorityI').val(res[2]);
            $('#txtComplaintTATI').val($tat);
            //$('#typeI').val(res[4]);
            //$('#modeI').val(res[5]);
        });
    }
</script>