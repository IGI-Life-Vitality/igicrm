<?php
    $objProd        = new Product();
    $objComplaint   = new Complaint();
    $users          = $objUser->GetUsers(0);

    $disa           = "";
    $dis_button     = "";
    $disabled       = "";
    $disable_info   = "";
    $email_checked  = "";
    $sms_checked    = "";
    $call_back_checked            = "";
    $disable_complaint_progress   = "";
    $comments_progress = "";
    $disabled_comments = "";
    $heading           = "Complaint Management";

    if(isset($_GET))
    {
        $complaint_id   = isset($_GET['id']) ? $_GET['id'] : 0;
        $cmode          = isset($_GET['cmode']) ? $_GET['cmode'] : 0;

        $heading = "";
        $isactive = "";

        if($complaint_id > 0)
        {
            $data                   = $objComplaint->GetComplaintById($complaint_id,$cmode); 
            $activity_data          = $objComplaint->GetComplaintStatusById($complaint_id,$cmode);
            $dis_button             = ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 6 || $data[0]['user_id'] != $login_id && $data[0]['user_id'] != 0 ) ? "disabled='true'" : "";

            $dis_button_invalid     = ($data[0]['status_id'] == 5 && $data[0]['group_id'] == 0 && $data[0]['user_id'] == 0 && $data[0]['user_id'] != $login_id && $data[0]['agent_id'] != $login_id) ? "disabled='true'" : "";
            $dis_btn_once_invalid   = ($data[0]['status_id'] == 5 && $data[0]['user_id'] == $login_id && $data[0]['progress'] == 0) ? "disabled='true'" : "";

            $disable_complaint_progress  = ($data[0]["progress"] == 100 || $data[0]['user_id'] == 0)? "disabled='true'" : "";

            $comments_progress   = ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments   = ($data[0]['status_id'] == 3 || $data[0]['status_id']== 6 || $data[0]['user_id'] == 0) ? "disabled='true'" : "";

            $email_checked       = $data[0]['is_email'] == 0 ? "checked='checked'" : "";
            $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='checked'" : "";
            $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='checked'" : "";

            $us = explode(',', $group_id);
            if(in_array($data[0]['group_id'], $us) && $user_type == 2 && $data[0]['status_id']== 5)
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

                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="comments" class="form-control" id="txtComments1" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div> -->

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
<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintIndividual">
        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>" />
        <input type="hidden" id="action" name="action" value="update_progress" />
        <input type="hidden" name="cmode" id="cmode" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_id" id="user_id" value="<?php echo($data[0]['user_id']); ?>" />
         <input type="hidden" name="cmp_invalid" id="cmp_invalid" value="<?php if($data[0]['status_id'] == 5){echo '1';}else{echo '0';} ?>" />
        <input type="hidden" name="user_id_ressign" id="user_id_ressign" value="0" />
        <input type="hidden" name="is_manual" id="is_manual" value="1" />
        <input type="hidden" name="status" id="status" value="<?php echo $data[0]['status_id'];?>" />
        <input type="hidden" name="complaint_num" id="complaint_num" value="<?php echo $data[0]['complaint_num'];?>" />

        <fieldset>
            <legend>Complaint Individual</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumber" name="txtPolicyNumber" class="form-control" placeholder="Policy Number" value="<?php echo $data[0]['policy_num']; ?>"  disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policyholder Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtCustomerName" name="txtCustomerName" class="form-control" value="<?php echo $data[0]['customer_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNIC" name="txtCNIC" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15" value="<?php echo $data[0]['cnic']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" name="policy_issuance_date" id="policy_issuance_date" value="<?php echo Date("d-M-Y",strtotime($data[0]['policy_issuance_date'])); ?>" placeholder="Pick Preferable Date and Time" tabindex="13" disabled />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy </label>
                        <select class="form-control default-select2" id="status_of_policy" name="status_of_policy" data-placeholder="Select Plan Nature" disabled >
                            <option value="0" selected="selected" disabled>Select Status of Policy</option>
                            <option value="Enforce" <?php echo $data[0]['status_policy'] == 'Enforce' ? 'selected' : ''; ?>>Enforce</option>
                            <option value="Matured" <?php echo $data[0]['status_policy'] == 'Matured' ? 'selected' : ''; ?>>Matured</option>
                            <option value="Active" <?php echo $data[0]['status_policy'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Lapsed" <?php echo $data[0]['status_policy'] == 'Lapsed' ? 'selected' : ''; ?>>Lapsed</option>
                            <option value="Auto Surrender" <?php echo $data[0]['status_policy'] == 'Auto Surrender' ? 'selected' : ''; ?>>Auto Surrender</option>
                            <option value="Reduce Paid Up" <?php echo $data[0]['status_policy'] == 'Reduce Paid Up' ? 'selected' : ''; ?>>Reduce Paid Up</option>
                            <option value="Extended Term Assurance" <?php echo $data[0]['status_policy'] == 'Extended Term Assurance' ? 'selected' : ''; ?>>Extended Term Assurance</option>
                            <option value="Surrendered" <?php echo $data[0]['status_policy'] == 'Surrendered' ? 'selected' : ''; ?>>Surrendered</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Status of Policy is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Plan Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="plan_nature" name="plan_nature" data-placeholder="Select Plan Nature" disabled >
                            <option value="0" selected="selected" disabled>Select Plan Nature</option>
                            <option value="Unit Linked" <?php echo $data[0]['plan_nature'] == 'Unit Linked' ? 'selected' : ''; ?>>Unit Linked</option>
                            <option value="Term Life" <?php echo $data[0]['plan_nature'] == 'Term Life' ? 'selected' : ''; ?>> Term Life</option>
                            <option value="Saving" <?php echo $data[0]['plan_nature'] == 'Saving' ? 'selected' : ''; ?>>Saving</option>
                            <option value="Group" <?php echo $data[0]['plan_nature'] == 'Group' ? 'selected' : ''; ?>>Group</option>
                            <option value="Accidential" <?php echo $data[0]['plan_nature'] == 'Accidential' ? 'selected' : ''; ?>>Accidential</option>
                            <option value="Others" <?php echo $data[0]['plan_nature'] == 'Others' ? 'selected' : ''; ?>>Others</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Plan Nature is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Nature<span style="color: red;">*</span></label>
                        <input type="text" id="ddlProductName" name="ddlProductName" class="form-control" value="<?php echo $data[0]['product_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <select class="form-control default-select2" id="bankName" name="bankName" data-size="10" data-live-search="true" data-style="btn-white" disabled>
                            <option value="" selected="selected">Select Bank</option>
                                <option value="Al Baraka" <?php echo $data[0]['bank'] == 'Al Baraka' ? 'selected' : ''; ?> >Al Baraka</option>
                                <option value="Bank Alfalah" <?php echo $data[0]['bank'] == 'Bank Alfalah' ? 'selected' : ''; ?> >Bank Alfalah</option>
                                <option value="Dubai Islamic Bank" <?php echo $data[0]['bank'] == 'Dubai Islamic Bank' ? 'selected' : ''; ?> >Dubai Islamic Bank</option>
                                <option value="MCB" <?php echo $data[0]['bank'] == 'MCB' ? 'selected' : ''; ?> >MCB</option>
                                <option value="Samba" <?php echo $data[0]['bank'] == 'Samba' ? 'selected' : ''; ?> >Samba</option>
                                <option value="SCB" <?php echo $data[0]['bank'] == 'SCB' ? 'selected' : ''; ?> >SCB</option>
                                <option value="Soneri Bank" <?php echo $data[0]['bank'] == 'Soneri Bank' ? 'selected' : ''; ?> >Soneri Bank</option>
                                <option value="Summit Bank" <?php echo $data[0]['bank'] == 'Summit Bank' ? 'selected' : ''; ?> >SamSummit Bankba</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Bank Name is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <!-- <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] == 5) { ?>
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName" data-placeholder="Select Complaint" onchange="getcmp_type_indvl_dtl();">
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
                        <select class="form-control default-select2" id="ddlComplaintType" name="ddlComplaintType" data-placeholder="Select Complaint Type" onchange="get_cmp_type_indvl_dtl();">
                            <option value="0" selected="selected" disabled >Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>

                <?php }else{ ?>
                <?php } ?> -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <input type="text" id="ddlDepartmentName2" name="ddlDepartmentName2" class="form-control" value="<?php echo $data[0]['department_name']; ?>" disabled="true">
                        <input type="hidden" name="ddlDepartmentName" id="ddlDepartmentName" value="<?php echo $data[0]['complaint_depart']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <input type="text" id="ddlComplaintType2" name="ddlComplaintType2" class="form-control" value="<?php echo $data[0]['complaint_type']; ?>" disabled="true">
                        <input type="hidden" name="ddlComplaintType" id="ddlComplaintType" value="<?php echo $data[0]['complaint_type_id']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Source<span style="color: red;">*</span></label>
                        <input type="text" id="ddlSource" name="ddlSource" class="form-control" value="<?php echo $data[0]['source']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmount" name="txtPremiumAmount" class="form-control" value="<?php echo $data[0]['premium_amount']; ?>" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)" <?php echo $disable_complaint_progress ?>>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                
                 
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <input type="text" id="txtRefundAmount" name="txtRefundAmount" class="form-control" value="<?php echo $data[0]['refund_amount']; ?>" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)" <?php echo $disable_complaint_progress ?>>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimed" name="txtAmountClaimed" class="form-control" value="<?php echo $data[0]['claim_amount']; ?>" placeholder="Enter Amount" onkeypress="return validateNumbers(event)" <?php echo $disable_complaint_progress ?>>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityL" name="cityL" disabled>
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>" <?php echo $data[0]['city'] == $city["id"] ? 'selected' : ''; ?> ><? echo $city["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Region</label>
                        <select class="form-control" id="ddlRegion" name="ddlRegion" disabled>
                            <option value="" selected="selected" disabled="disabled">Select Region</option>
                            <option value="south" <?php echo $data[0]['region'] == 'south' ? 'selected' : ''; ?>  >South</option>
                            <option value="east" <?php echo $data[0]['region'] == 'east' ? 'selected' : ''; ?> >East</option>
                            <option value="central" <?php echo $data[0]['region'] == 'central' ? 'selected' : ''; ?> >Central</option>
                            <option value="north" <?php echo $data[0]['region'] == 'north' ? 'selected' : ''; ?> >North</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Region is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="reported_dt" value="<?php echo Date("d-M-Y",strtotime($data[0]['reported_dt'])) ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="received_date" value="<?php echo Date("d-M-Y",strtotime($data[0]['received_date'])) ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriority" name="ddlPriority" class="form-control" placeholder="Priority" value="<?php echo $data[0]['priority_id']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>TAT</label>
                        <input type="text" id="txtComplaintTAT" name="txtComplaintTAT" class="form-control" placeholder="Complaint TAT" value="<?php echo $data[0]['tat']; ?>" disabled="true">
                    </div>
                </div>
                 
            </div>

            <div class="col-md-12">
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Nature<span style="color: red;">*</span></label>
                        <input type="text" id="ddlProductName" name="ddlProductName" class="form-control" value="<?php echo $data[0]['product_name']; ?>" disabled="true">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
                    </div>
                </div> -->
                

               
            </div>

            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescription" name="txtDescription" rows="6" class="form-control" disabled="true"><?php echo $data[0]['description']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] != 5 /*&& ($user_type == 2 || $user_type == 1)*/) { ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Assign To<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="cmp_user_name" name="cmp_user_name" data-size="10" data-live-search="true" data-style="btn-white">
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
            <legend>Call Back Information</legend>
            <div class="col-md-12">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Home</label>
                        <input type="text" id="txtHomePhone" name="txtHomePhone" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['residence_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtCallBack" name="txtCallBack" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11" value="<?php echo $data[0]['callback_num']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobile" name="txtMobile" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['mobile_number']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhone" name="txtOfficePhone" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12" value="<?php echo $data[0]['office_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail</label>
                        
                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="example@mail.com" value="<?php echo $data[0]['email']; ?>" disabled="true">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            
                        
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea rows="6" placeholder="Office Address" id="txtOfficeAddress" name="txtOfficeAddress" class="form-control" disabled="true"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Correspondence Address" id="txtCorrespondenceAddress" name="txtCorrespondenceAddress" class="form-control" disabled="true"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                        <label>SMS</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdSMS" id="radio_inline_css_3" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMS" id="radio_inline_css_4" value="0" <?php echo $sms_checked; ?> disabled="true">
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
                        <label>Customer Mobile</label>
                        <input type="text" maxlength="12" class="form-control number" id="txtResponseNumber" name="txtResponseNumber" value="<?php echo $data[0]['response_number']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBack" id="radio_inline_css_12" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBack" id="radio_inline_css_21" value="0" <?php echo $call_back_checked; ?> disabled="true">
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
            <legend>Last Comment</legend>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea type="text" class="form-control" rows="6" disabled="true"><?php echo $data[0]['description'] ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-md-11">
                <label>Attachments</label>
                <table class="table table-bordered">
                    <?php
                        $filepath  = SITE_ROOT."/uploads_eform_complaint/complaint_attachment/".$data[0]['complaint_num']."/";

                        $filepath7 = SITE_IP."/uploads_eform_complaint/complaint_attachment/".$data[0]['complaint_num']."/";

                        $files = scandir($filepath);
                        
                        $datas = "";
                    ?>
                    
                    <?php if($files != '') { ?>
                        <tr>
                            <?php
                                for($a=2; $a<count($files); $a++)
                                {
                                    $datas .='<td class="text-center">';
                                        $datas .='<div><i class="fa fa-arrow-circle-o-right fa-3x text-inverse fa-rotate-90"></i></div>';
                                        $datas .='<div><a title="'.$files[$a].'" class="btn btn-primary btn-sm" href="'.$filepath7.$files[$a].'" download>'.$data[0]['complaint_num'].'<a/></div>';
                                    $datas .='</td>';
                                }
                                echo $datas;
                            ?>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td align="center"><b> No Attachment Found </b></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </fieldset>

        <fieldset>
            <legend>Activity</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Progress</label>
                        <select class="form-control default-select2" id="ddlProgress" name="ddlProgress" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_complaint_progress; ?>>
                           <?php if($user_type == 2 && $data[0]['status_id'] == 5 ){?>
                                <option value="101" <?php if($data[0]['progress'] =="101") echo "selected=selected"?>>Invalid</option>
                                <option value="99" <?php if($data[0]['progress'] =="99") echo "selected=selected"?>>Valid</option>
                            <?php }else{ ?>
                            <option value="0" <?php if($data[0]['progress'] =="0") echo "selected=selected"?> disabled="disabled">Select Progress</option>
                            <option value="100" <?php if($data[0]['progress'] =="100") echo "selected=selected"?>>Resolved</option>
                            <option value="50" <?php if($data[0]['progress'] =="50") echo "selected=selected"?>>In Progress</option>
                            <option value="101" <?php if($data[0]['progress'] =="101") echo "selected=selected"?>>Invalid</option>
                            <option value="11" <?php if($data[0]['progress'] =="11") echo "selected=selected"?>>UnResolved</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-7">
                    <div class="form-group">
                        <label>Comments<span style="color: red;">*</span></label>
                        <textarea type="text" class="form-control" id="txtActivity" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['status_id'] == 3 /*|| $data[0]['status_id'] == 4*/) ? $comments_progress : ''; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintIndividual" <? echo $dis_button; ?> <? echo $dis_button_invalid; ?> <? echo $dis_btn_once_invalid; ?> onclick ="individual_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    // Working in details view START
    function individual_cmp()
    {
        var manual        = 0;
        var new_user      = "";
        var id            = $('#txtId').val();
        var complaint_num = $('#complaint_num').val();
        var action        = 'update_progress';
        var txtPremiumAmount      = $('#txtPremiumAmount').val();
        var txtRefundAmount      = $('#txtRefundAmount').val();
        var txtAmountClaimed      = $('#txtAmountClaimed').val();
        var user_type     = <? echo $user_type ?>;
        var progress      = $('#ddlProgress').val();
        var user_id       = $('#user_id').val();
        var notes         = $('#txtActivity').val();
        var cmode         = $('#cmode').val();
        var cmp_user_name = $('#cmp_user_name').val();
        var invalid       = $('#cmp_invalid').val();
        var tat           = $('#txtComplaintTAT').val();
        var priority      = $('#ddlPriority').val();
        var user          = $('#user_id_ressign').val();        //Set 0 in hidden field
        var is_manual     = $('#is_manual').val();

        var departmentName = $('#ddlDepartmentName').val();
        var cmp_type       = $('#ddlComplaintType').val();
        var Assign_to      = "";
        var new_user       = user_id;

        //alert(user_id);

        /* 
            When AssignedTo HoD (Manager) Confirm Invaild.
            Status ID will be marked as 0 in DB.
        */
        if(invalid == 1 && is_manual == 1)
        {
            manual = 2;
            //alert("When AssignedTo HoD Confirm Invaild");
            //return false;
        }

        /*  
            When AssignedBy User Reassigned to any department.
            GROUPID, USERID is being marked as 0 in DB but should be marked with department and its type ID.
            NOTE: This block execute when reassignment has been made with auto user assignment 
        */
        if(user_id == 0 && is_manual == 0 && user != 0 && invalid == 1)
        {
            manual      = 1;
            is_manual   = 0;
            new_user    = user;
            //alert("When AssignedBy User Reassigned to any department with auto user assignment");
            //return false;
        }

        /*
            When AssignedBy User Reassigned to any department.
            GROUPID, USERID is being marked as 0 in DB but should be marked with department and its type ID.
            NOTE: This block execute when reassignment has been made with manual user assignment 
        */
        if(user_id == 0 && is_manual == 1 && invalid == 0)
        {
            manual      = 1;
            is_manual   = 1;
            new_user    = cmp_user_name;
            //alert("When AssignedBy User Reassigned to any department with manual user assignment");
            //return false;
        }

        if(new_user == 'undefined' || new_user == '' || new_user == 'null' || new_user == null)
        {
            new_user = 0;
        }

        if(validation(user_type))
        {
            $("#btnSaveComplaintIndividual").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: 
                {
                    'id'            :id,
                    'action'        :action,
                    'progress'      :progress,
                    'premium_amount'    :txtPremiumAmount,
                    'refund_ammount'    :txtRefundAmount,
                    'amount_claimed'    :txtAmountClaimed,
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
                    'departmentName':departmentName,
                    'cmp_type'      :cmp_type
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                    //$("#btnSaveComplaintIndividual").button('reset');

                    data = data.trim();
                    //alert(data);
                    //console.log(data);

                    if(data == 'success')
                    {
                        $('#ModalComment').modal({backdrop: 'static', keyboard: false});
                        $('#ModalComment').modal('show');
                        $('#complaint_id_main').val(id);
                        $('#type_main').val('individual');
                        $('#counter_display').val(complaint_num);

                        // $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        // setTimeout(function () { window.location.href = "complaint_views.php" }, 3000);
                    }
                    else if(data == 'fail')
                    {
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    } 

    function validation(user_type)
    {
        var hasFocus = false;
        var errCount = 0;
        var user_id   = $('#user_id').val();
        var invalid   = $('#cmp_invalid').val();
        var status    = $('#status').val();

        if(user_id == 0 && invalid == 1)
        {
           if($('#ddlDepartmentName').val() == null || $('#ddlDepartmentName').val()  == "") 
            {
                $('#ddlDepartmentName').addClass('error-val');
                $('#ddlDepartmentName').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlDepartmentName').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlDepartmentName').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlDepartmentName').parent().find('.input-error').hide();
            }


            if($('#ddlComplaintType').val() == null || $('#ddlComplaintType').val()  == "") 
            {
                $('#ddlComplaintType').addClass('error-val');
                $('#ddlComplaintType').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlComplaintType').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlComplaintType').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlComplaintType').parent().find('.input-error').hide();
            }
        }
        else if(user_id == 0 && invalid == 0 && status != 5)
        {
            if($('#cmp_user_name').val() == null || $('#cmp_user_name').val() == "")
            {
                $('#cmp_user_name').addClass('error-val');
                $('#cmp_user_name').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#cmp_user_name').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#cmp_user_name').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#cmp_user_name').parent().find('.input-error').hide();
            }
        }

        // if(user_type == 4 && status != 5 && user_id != 0)
        // {
            if($('#txtActivity').val() == "") 
            {
                $('#txtActivity').addClass('error-val');
                $('#txtActivity').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivity').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivity').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivity').parent().find('.input-error').hide();
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

    function getcmp_type_indvl_dtl()
    {
        var depart = $('#ddlDepartmentName').val();
        //alert(depart);
        $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_complaint_type.php",
                    data:{
                        action : "get_cmp_type",
                        id: depart
                    }
        }).done(function (data) {
            //alert(data);
            console.log(data);
            $('#ddlComplaintType').html(data);
        });
    }

    function get_cmp_type_indvl_dtl()
    {
        var cmptype = $('#ddlComplaintType').val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:{
                action : "get_cmp_detail",
                id: cmptype
            }
        }).done(function (data) {
           //alert(data);
             var res = data.split('|');
             if(res[0] == 0){
                  $('#is_manual').val('1');
                  $('#cmp_invalid').val('0');
             }else{
                $('#is_manual').val('0');
             } 

             var $tat = res[3] + " Working Days";
             $('#user_id_ressign').val(res[0]);
             $('#cmp_user_group').val(res[1]);
             $('#ddlPriority').val(res[2]);
             $('#txtComplaintTAT').val($tat);
             //$('#typeC').val(res[4]);
             //$('#modeC').val(res[5]);
        });
    }
    
    var counter = 1;
    var getid = 0;


    $(document).on('click', '#btnFileUpload', function () {
        var formdata = new FormData($('#modalform')[0]);
        formdata.append('complaint_id',getid);

        $("#btnFileUpload").button('loading');
        var id            = $('#txtId').val();
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
                        window.location.href = `complaint_views.php`;
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
</script>