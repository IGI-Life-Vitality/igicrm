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
            $data                   = $objComplaint->GetComplaintByIdVatality($complaint_id,$cmode);
            $activity_data          = $objComplaint->GetComplaintStatusById($complaint_id,$cmode);

            $dis_button             = ($data[0]['status_id'] == 3  || $data[0]['status_id'] == 6 || $data[0]['user_id'] != $login_id && $data[0]['user_id'] != 0 ) ? "disabled='true'" : "";

            $disable_complaint_progress  = ($data[0]["progress"] == 100 ||  $data[0]['user_id'] == 0)? "disabled='true'" : "";

            $comments_progress   = ($data[0]['status_id'] == 3  || $data[0]['status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments   = ($data[0]['status_id'] == 3  || $data[0]['status_id']== 6 /*||  $data[0]['user_id'] == 0*/) ? "disabled='true'" : "";

            $email_checked       = $data[0]['is_email'] == 0 ? "checked='checked'" : "";
            $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='checked'" : "";
            $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='checked'" : "";

            $us = explode(',', $group_id);
            if(in_array($data[0]['group_id'], $us) && $user_type == 2 && ($data[0]['status_id']== 5 || $data[0]['status_id'] == 4)){

                 $dis_button = "";
            }
        }
        else
        {
            $heading = "";
        }
    }
?>

<div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
</div>

<div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
    <strong>Error!</strong>
    Error while saving record, Please try again!
    <span class="close" data-dismiss="alert">&times;</span>
</div>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintVatality">
        <input type="hidden" id="txtIdV" name="txtIdV" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actionV" name="actionV" value="update_progress">
        <input type="hidden" name="cmodeV" id="cmodeV" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_idV" id="user_idV" value="<?php echo($data[0]['user_id']); ?>" />
         <input type="hidden" name="cmp_invalidV" id="cmp_invalidV" value="<?php if($data[0]['status_id'] == 5 ){ echo '1';}else{echo '0';} ?>" />

         <input type="hidden" name="user_id_ressignv" id="user_id_ressignv" value="0" />
        <input type="hidden" name="is_manualv" id="is_manualv" value="1" />
        <input type="hidden" name="statusv" id="statusv" value="<?php echo $data[0]['status_id'];?>" />


        <fieldset>
            <legend>Complaint Individual</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberV" name="txtPolicyNumberV" class="form-control" placeholder="Policy Number" value="<?php echo $data[0]['policy_num']; ?>"  disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICV" name="txtCNICV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15" value="<?php echo $data[0]['cnic']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policyholder Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtCustomerNameV" name="txtCustomerNameV" class="form-control" value="<?php echo $data[0]['customer_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Nature<span style="color: red;">*</span></label>
                        <input type="text" id="ddlProductNameV" name="ddlProductNameV" class="form-control" value="<?php echo $data[0]['product_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Source<span style="color: red;">*</span></label>
                        <input type="text" id="ddlSourceV" name="ddlSourceV" class="form-control" value="<?php echo $data[0]['source']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] == 5) {?>

                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameV" name="ddlDepartmentNameV" data-placeholder="Select Complaint" onchange="getcmp_type_vatality_dtl();">
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
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlComplaintTypeV" name="ddlComplaintTypeV" data-placeholder="Select Complaint Type" onchange="get_cmp_type_vatality_dtl();">
                            <option value="0" selected="selected" disabled >Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>

                <?php }else{?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <input type="text" id="ddlDepartmentNameV" name="ddlDepartmentNameV" class="form-control" value="<?php echo $data[0]['department_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Department is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <input type="text" id="ddlComplaintTypeV" name="ddlComplaintTypeV" class="form-control" value="<?php echo $data[0]['complaint_type']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-2">
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityV" name="ddlPriorityV" class="form-control" placeholder="Priority" value="<?php echo $data[0]['priority_id']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label>TAT</label>
                        <input type="text" id="txtComplaintTATV" name="txtComplaintTATV" class="form-control" placeholder="Complaint TAT" value="<?php echo $data[0]['tat']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionV" name="txtDescriptionV" rows="4" class="form-control" disabled="true"><?php echo $data[0]['description']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] != 5) {?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Assign To<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="cmp_user_nameV" name="cmp_user_nameV" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select User</option>
                             <?php $users = $objUser->GetUsers(); ?>
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
            <legend>Call Back Information</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtCallBackV" name="txtCallBackV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11" value="<?php echo $data[0]['callback_num']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Home</label>
                        <input type="text" id="txtHomePhoneV" name="txtHomePhoneV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['residence_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileV" name="txtMobileV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['mobile_number']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneV" name="txtOfficePhoneV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12" value="<?php echo $data[0]['office_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtEmailV" name="txtEmailV" placeholder="example@mail.com" value="<?php echo $data[0]['customer_email']; ?>" disabled="true">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <span class="input-group-addon">@</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea placeholder="Office Address" id="txtOfficeAddressV" name="txtOfficeAddressV" class="form-control" disabled="true"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea placeholder="Correspondence Address" id="txtCorrespondenceAddressV" name="txtCorrespondenceAddressV" class="form-control" disabled="true"><?php echo $data[0]['delivery_address']; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Correspondence Address is required</div>
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
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdEmailV" id="radio_inline_css_1" checked="true" value="1" disabled="true">
                                <label for="radio_inline_css_1">
                                   Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdEmailV" id="radio_inline_css_2" value="0" <?php echo $email_checked; ?> disabled="true">
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
                            <input type="text" class="form-control" id="txtCustomerEmailV" name="txtCustomerEmailV" value="<?php echo $data[0]['customer_email']; ?>" disabled="true">
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
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdSMSV" id="radio_inline_css_3" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSV" id="radio_inline_css_4" value="0" <?php echo $sms_checked; ?> disabled="true">
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
                        <input type="text" maxlength="12" class="form-control number" id="txtResponseNumberV" name="txtResponseNumberV" value="<?php echo $data[0]['mobile_number']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_12" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_21" value="0" <?php echo $call_back_checked; ?> disabled="true">
                                <label for="radio_inline_css_21">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Activity</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Progress</label>
                        <select class="form-control default-select2" id="ddlProgressV" name="ddlProgressV" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_complaint_progress; ?>>
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
                            <?php if($data[0]['user_id'] == $login_id && $data[0]['reassign'] != '2' ){?>
                            <option value="1000" <?php if($data[0]['progress'] =="1000") echo "selected=selected"?> >Reassign</option>
                             
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>Comments<span style="color: red;">*</span></label>
                        <textarea type="text" class="form-control" id="txtActivityV" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['status_id'] == 3 /*|| $data[0]['status_id'] == 4*/) ? $comments_progress : ''; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                    </div>
                    <input type="hidden" name="reassign" id="reassign" value="<?php echo $data[0]['reassign'] ?>">
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintVatality" <? echo $dis_button; ?> onclick ="vatality_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<!-- Begin Modal Individial -->
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
<!-- End Modal Individial -->

<script type="text/javascript">
    // Working in details view START
    function vatality_cmp()
    {
        /*alert("sfsfsfsfs");return false;*/
        var manual = 0;
        var new_user ="";
        var id            = $('#txtIdV').val();
        var action        = 'update_progress';
        var user_type     = <? echo $user_type ?>;
        var progress      = $('#ddlProgressV').val();
        var user_id       = $('#user_idV').val();
        var notes         = $('#txtActivityV').val();
        var cmode         = $('#cmodeV').val();
        var cmp_user_name = $('#cmp_user_nameV').val();
        var invalid       = $('#cmp_invalidV').val();
        var reassign      = $('#reassign').val();

        var tat           = $('#txtComplaintTATV').val();
        var priority      = $('#ddlPriorityV').val(); 
        var user          = $('#user_id_ressignv').val();
        var is_manual     = $('#is_manualv').val();
        //var is_manual     = $('#is_manual').val();
        var departmentName = $('#ddlDepartmentNameV').val();
        var cmp_type       = $('#ddlComplaintTypeV').val();
        var Assign_to = "";

        /*if(invalid == 1){
             manual = 2;
        }
        
        if(user_id == 0){
            manual = 1;
        }*/
        var new_user = user_id;

        if(invalid == 1 && is_manual == 1){
             manual = 2;
             //alert("Invalid");
        }
        
        if(user_id == 0 && is_manual == 0 && user != 0 && invalid == 1){
            manual = 1;
            is_manual = 0;
            new_user = user;
            //alert("reassign Assign");
        }

         if(user_id == 0 && is_manual == 1 && invalid == 0){
             //alert("reassign");
              manual = 1;
              new_user = cmp_user_name;
              is_manual = 1;
        }
     
       if(new_user == 'undefined' || new_user == '' || new_user == 'null' || new_user == null){
           new_user = 0;
       }

        if(validation_vatality(user_type))
        {
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
                    'reassign'      :reassign,
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
                    $("#btnSaveComplaintVatality").button('reset');

                    data = data.trim();
                    //alert(data);
                    console.log(data);

                    if(data == 'success')
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () { window.location.href = "complaint_details.php?id=<? echo $complaint_id; ?>&cmode=<? echo $cmode; ?>" }, 3000);
                    }
                    else if(data == 'fail')
                    {
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    } 

    function validation_vatality(user_type)
    {

        var hasFocus = false;
        var errCount = 0;
        var user_id   = $('#user_idV').val();
        var invalid       = $('#cmp_invalidv').val();
        var status       = $('#statusv').val();


         if(user_id == 0 && invalid == 1)
          { 

            if($('#ddlDepartmentNameV').val() == null || $('#ddlDepartmentNameV').val()  == "") 
            {
                $('#ddlDepartmentNameV').addClass('error-val');
                $('#ddlDepartmentNameV').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlDepartmentNameV').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlDepartmentNameV').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlDepartmentNameV').parent().find('.input-error').hide();
            }


            if($('#ddlComplaintTypeV').val() == null || $('#ddlComplaintTypeV').val()  == "") 
            {
                $('#ddlComplaintTypeV').addClass('error-val');
                $('#ddlComplaintTypeV').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlComplaintType').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlComplaintTypeV').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlComplaintTypeV').parent().find('.input-error').hide();
            }


         }else if(user_id == 0 && invalid == 0 && status != 5)
        {
            if($('#cmp_user_nameV').val() == null || $('#cmp_user_nameV').val()  == "") 
            {
                $('#cmp_user_nameV').addClass('error-val');
                $('#cmp_user_nameV').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#cmp_user_nameV').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#cmp_user_nameV').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#cmp_user_nameV').parent().find('.input-error').hide();
            }
        }

        if(user_type == 4)
        {
            if($('#txtActivityV').val() == "") 
            {
                $('#txtActivityV').addClass('error-val');
                $('#txtActivityV').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivityV').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivityV').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivityV').parent().find('.input-error').hide();
            }
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    } 
    // Working in details view END


     function getcmp_type_vatality_dtl()
    {
        var depart = $('#ddlDepartmentNameV').val();
        // alert(depart);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:
            {
                action : "get_cmp_type",
                id: depart
            }
            }).done(function (data) {
            //alert(data);
            $('#ddlComplaintTypeV').html(data);
        });
    }

    function get_cmp_type_vatality_dtl()
    {
        var cmptype = $('#ddlComplaintTypeV').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:
            {
                action : "get_cmp_detail",
                id: cmptype
            }
        }).done(function (data) {
           //alert(data);
             var res = data.split('|');
             if(res[0] == 0){
                  $('#is_manualv').val('1');
                  $('#cmp_invalidv').val('0');
             }else{
                $('#is_manualv').val('0');
             } 
             var $tat = res[3] + " Working Days";

             $('#user_id_ressignv').val(res[0]);
             //$('#cmp_user_groupV').val(res[1]);
             $('#ddlPriorityV').val(res[2]);
             $('#txtComplaintTATV').val($tat);
             //$('#type').val(res[4]);
             //$('#modeV').val(res[5]);
        });
    }
</script>