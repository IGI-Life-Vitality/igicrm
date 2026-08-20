<?php
    $objProd = new Product();
    $objComplaint = new Complaint();

    $users = $objUser->GetUsers(0);   

    $disa               = "";
    $dis_button         = "";
    $disabled           = "";
    $disable_info       = "";
    $email_checked      = "";
    $sms_checked        = "";
    $call_back_checked  = "";
    $disable_complaint_progress     = "";
    $comments_progress              = "";
    $disabled_comments              = "";
    $heading                        = "Complaint Management";

    if(isset($_GET))
    {
        $complaint_id   = isset($_GET['id']) ? $_GET['id'] : 0;
        $cmode          = isset($_GET['cmode']) ? $_GET['cmode'] : 0;

        $heading = "";
        $isactive = "";

        if($complaint_id > 0)
        {
            $data                   = $objComplaint->GetComplaintByIdBancaBank($complaint_id,$cmode);
            $activity_data          = $objComplaint->GetComplaintStatusById($complaint_id,$cmode);

            $dis_button             = ($data[0]['status_id'] == 3  || $data[0]['status_id'] == 6 || $data[0]['user_id'] != $login_id && $data[0]['user_id'] != 0 ) ? "disabled='true'" : "";

            $dis_button_invalid     = ($data[0]['status_id'] == 5 && $data[0]['group_id'] == 0 && $data[0]['user_id'] == 0 && $data[0]['user_id'] != $login_id && $data[0]['agent_id'] != $login_id) ? "disabled='true'" : "";
            $dis_btn_once_invalid   = ($data[0]['status_id'] == 5 && $data[0]['user_id'] == $login_id && $data[0]['progress'] == 0) ? "disabled='true'" : "";

            $disable_complaint_progress  = ($data[0]["progress"] == 100 ||  $data[0]['user_id'] == 0)? "disabled='true'" : "";

            $comments_progress   = ($data[0]['status_id'] == 3  || $data[0]['status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments   = ($data[0]['status_id'] == 3  || $data[0]['status_id']== 6 /*||  $data[0]['user_id'] == 0*/) ? "disabled='true'" : "";

            $email_checked       = $data[0]['is_email'] == 0 ? "checked='true'" : "";
            $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='true'" : "";
            $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='true'" : "";
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

                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsBB" class="form-control" id="txtCommentsBB" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div> -->

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

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintBancaBank">
        <input type="hidden" id="txtIdBB" name="txtIdBB" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actionBB" name="actionBB" value="update_progress">
        <input type="hidden" name="cmodeBB" id="cmodeBB" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_idBB" id="user_idBB" value="<?php echo($data[0]['user_id']); ?>" />
        <input type="hidden" name="cmp_invalidBB" id="cmp_invalidBB" value="<?php if($data[0]['status_id'] == 5 ){ echo '1';}else{echo '0';} ?>" />

        <input type="hidden" name="user_id_ressignbb" id="user_id_ressignbb" value="0" />
        <input type="hidden" name="is_manualbb" id="is_manualbb" value="1" />
        <input type="hidden" name="statusbb" id="statusbb" value="<?php echo $data[0]['status_id'];?>" />
        <input type="hidden" name="complaint_num" id="complaint_num" value="<?php echo $data[0]['complaint_num'];?>" />

        <fieldset>
            <legend>Complaint Banca Bank</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Reported By</label>
                        <input type="text" id="ddlReportedByBB" name="ddlReportedByBB" class="form-control" value="<?php if($data[0]['reported_by'] == "group_companies"){ echo "Group Companies";}else{echo "Hospitals";} ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Group No<span style="color: red;">*</span></label>
                        <input type="text" id="txtGroupNoBB" name="txtGroupNoBB" class="form-control" value="<?php echo $data[0]['group_no']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Certificate No<span style="color: red;">*</span></label>
                        <input type="text" id="txtCertificateBB" name="txtCertificateBB" class="form-control" value="<?php echo $data[0]['certificate_no']; ?>"  disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date <span style="color: red;">*</span></label>
                        <input type="text" class="form-control date" name="policy_issuance_date" id="policy_issuance_date" value="<?php echo Date("d-M-Y",strtotime($data[0]['policy_issuance_date'])); ?>" placeholder="Pick Preferable Date and Time" tabindex="13" disabled />

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
                            <option value="Matured" <?php echo $data[0]['status_policy'] == 'Matured' ? 'selected' : ''; ?>>Matured</option>
                            <option value="Enforce" <?php echo $data[0]['status_policy'] == 'Enforce' ? 'selected' : ''; ?>>Enforce</option>
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
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountB" name="txtPremiumAmountB" class="form-control" value="<?php echo $data[0]['premium_amount']; ?>" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)" <? echo $disable_complaint_progress; ?>>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <input type="text" id="txtRefundAmountB" name="txtRefundAmountB" class="form-control" value="<?php echo $data[0]['refund_amount']; ?>" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)" <? echo $disable_complaint_progress; ?>>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedB" name="txtAmountClaimedB" class="form-control" value="<?php echo $data[0]['claim_amount']; ?>" placeholder="Enter Amount" onkeypress="return validateNumbers(event)" <? echo $disable_complaint_progress; ?>>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
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
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="reported_dt" value="<?php echo Date("d-M-Y",strtotime($data[0]['reported_dt'])) ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="received_date" value="<?php echo Date("d-M-Y",strtotime($data[0]['received_date'])) ?>" placeholder="Complaint Received Date" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" id="txtCompanyNameBB" name="txtCompanyNameBB" class="form-control" value="<?php echo $data[0]['company_name']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" id="txtMemberNameBB" name="txtMemberNameBB" class="form-control" value="<?php echo $data[0]['customer_name']; ?>"  disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Source<span style="color: red;">*</span></label>
                        <input type="text" id="ddlSourceBB" name="ddlSourceBB" class="form-control" value="<?php echo $data[0]['source']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <input type="text" id="ddlDepartmentNameBB2" name="ddlDepartmentNameBB2" class="form-control" value="<?php echo $data[0]['department_name']; ?>" disabled="true">
                        <input type="hidden" name="ddlDepartmentNameBB" id="ddlDepartmentNameBB" value="<?php echo $data[0]['complaint_depart']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <input type="text" id="ddlComplaintTypeBB2" name="ddlComplaintTypeBB2" class="form-control" value="<?php echo $data[0]['complaint_type']; ?>" disabled="true">
                        <input type="hidden" name="ddlComplaintTypeBB" id="ddlComplaintTypeBB" value="<?php echo $data[0]['complaint_type_id']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityBB" name="ddlPriorityBB" class="form-control" value="<?php echo $data[0]['priority_id']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATBB" name="txtComplaintTATBB" class="form-control" value="<?php echo $data[0]['tat']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agent / Broker</label>
                        <input type="text" id="txtAgentBrokerBB" name="txtAgentBrokerBB" class="form-control" value="<?php echo $data[0]['agent']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <!-- <div class="col-md-12">
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] == 5) { ?>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameBB" name="ddlDepartmentNameBB" data-placeholder="Select Complaint"  onchange="getcmp_type_co_banca_dtl();">
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
                        <select class="form-control default-select2" id="ddlComplaintTypeBB" name="ddlComplaintTypeBB" data-placeholder="Select Complaint Type" onchange="get_cmp_type_co_banca_dtl();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <?php } else { ?>
               
                <?php } ?>
                
            </div> -->

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hospital Name (Reported By)<span style="color: red;">*</span></label>
                        <input type="text" id="ddlHospitalNameBB" name="ddlHospitalNameBB" class="form-control" value="<?php echo $data[0]['hospital']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name</label>
                         <input type="text" id="txtAgentBrokerBB" name="txtAgentBrokerBB" class="form-control" placeholder="Bank Name" value="<?php echo $data[0]['bank']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionBB" name="txtDescriptionBB" rows="6" class="form-control" disabled="true"><?php echo $data[0]['description']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

               

                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] != 5) {?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Assign To<span style="color: red;">*</span></label>
                            <select class="form-control default-select2" id="cmp_user_nameBB" name="cmp_user_nameBB" data-size="10" data-live-search="true" data-style="btn-white">
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
            </div>
        </fieldset>

        <fieldset>
            <legend>Call Back Information</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Home</label>
                        <input type="text" id="txtHomePhoneBB" name="txtHomePhoneBB" class="form-control" value="<?php echo $data[0]['residence_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtCallBackBB" name="txtCallBackBB" class="form-control" value="<?php echo $data[0]['callback_num']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileBB" name="txtMobileBB" class="form-control" value="<?php echo $data[0]['mobile_number']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneBB" name="txtOfficePhoneBB" class="form-control" value="<?php echo $data[0]['office_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail</label>
                        
                            <input type="text" id="txtEmailBB" name="txtEmailBB" class="form-control" value="<?php echo $data[0]['email']; ?>" disabled="true">
                        
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea rows="6" placeholder="Enter Office Address" id="txtOfficeAddressBB" name="txtOfficeAddressCOfficeAddressBB" class="form-control" disabled="true"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressBB" name="txtCorrespondenceAddressBB" class="form-control" disabled="true"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMSBB" id="radio_inline_css_3" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSBB" id="radio_inline_css_4" value="0" <?php echo $sms_checked; ?> disabled="true">
                                <label for="radio_inline_css_4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Mobile</label>
                        <input type="text" maxlength="12" class="form-control number" id="txtcusNumberBB" name="txtcusNumberBB" value="<?php echo $data[0]['response_number']; ?>" disabled="true">
                    </div>
                </div>

                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackBB" id="radio_inline_css_12" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackBB" id="radio_inline_css_21" value="0" <?php echo $call_back_checked; ?> disabled="true">
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
                        <textarea type="text" class="form-control" rows="6" disabled="true"><?php echo $data[0]['comments'] ?></textarea>
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
                        <select class="form-control default-select2" id="ddlProgressBB" name="ddlProgressBB" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_complaint_progress; ?>>
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
                        <textarea type="text" class="form-control" id="txtActivityBB" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['status_id'] == 3 /*|| $data[0]['status_id'] == 4*/) ? $comments_progress : ''; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" <? echo $dis_button; ?> <? echo $dis_button_invalid; ?> <? echo $dis_btn_once_invalid; ?> onclick ="banca_bank_cmp();" id="btnSaveComplaintBancaBank" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    #complaintCorporate .select2-container--default{
        width: 230px !important;
    }
</style>

<script type="text/javascript">
    // Working in details view START
    function banca_bank_cmp()
    {
        var manual        = 0;
        var new_user      = "";
        var id            = $('#txtIdBB').val();
        var action        = 'update_progress';
        var user_type     = <? echo $user_type ?>;
        var txtPremiumAmount = $('#txtPremiumAmountB').val();
        var txtRefundAmount = $('#txtRefundAmountB').val();
        var txtAmountClaimed = $('#txtAmountClaimedB').val();
        var complaint_num = $('#complaint_num').val();
        var progress      = $('#ddlProgressBB').val();
        var user_id       = $('#user_idBB').val();
        var notes         = $('#txtActivityBB').val();
        var cmode         = $('#cmodeBB').val();
        var cmp_user_name = $('#cmp_user_nameBB').val();
        var invalid       = $('#cmp_invalidBB').val();
        var tat           = $('#txtComplaintTATBB').val();
        var priority      = $('#ddlPriorityBB').val();
        var user          = $('#user_id_ressignbb').val();
        var is_manual     = $('#is_manualbb').val();
        var departmentName = $('#ddlDepartmentNameBB').val();
        var cmp_type       = $('#ddlComplaintTypeBB').val();
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

        if(validationBB(user_type))
        {
            $("#btnSaveComplaintBancaBank").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: 
                {
                    'id'            :id,
                    'action'        :action,
                    'progress'      :progress,
                    'premium_amount'      :txtPremiumAmount,
                    'refund_ammount'      :txtRefundAmount,
                    'amount_claimed'      :txtAmountClaimed,
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
                    //$("#btnSaveComplaintBancaBank").button('reset');

                    data = data.trim();
                    //alert(data);
                    //console.log(data);

                    if(data == 'success')
                    {
                        $('#ModalCommentBB').modal({backdrop: 'static', keyboard: false});
                        $('#ModalCommentBB').modal('show');
                        $('#complaint_id_mainBB').val(id);
                        $('#type_mainBB').val('bancaBank');
                        $('#counter_displayBB').val(complaint_num);
                        return false;
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

    function validationBB(user_type)
    {
        var hasFocus = false;
        var errCount = 0;
        var user_id  = $('#user_idBB').val();
        var invalid  = $('#cmp_invalidBB').val();
        var status   = $('#statusbb').val();

        if(user_id == 0 && invalid == 1)
        {
            if($('#ddlDepartmentNameBB').val() == null || $('#ddlDepartmentNameBB').val()  == "") 
            {
                $('#ddlDepartmentNameBB').addClass('error-val');
                $('#ddlDepartmentNameBB').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlDepartmentNameBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlDepartmentNameBB').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlDepartmentNameBB').parent().find('.input-error').hide();
            }


            if($('#ddlComplaintTypeBB').val() == null || $('#ddlComplaintTypeBB').val()  == "") 
            {
                $('#ddlComplaintTypeBB').addClass('error-val');
                $('#ddlComplaintTypeBB').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlComplaintTypeBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlComplaintTypeBB').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlComplaintTypeBB').parent().find('.input-error').hide();
            }
        }
        else if(user_id == 0 && invalid == 0 && status != 5)
        {
            if($('#cmp_user_nameBB').val() == null || $('#cmp_user_nameBB').val()  == "") 
            {
                $('#cmp_user_nameBB').addClass('error-val');
                $('#cmp_user_nameBB').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#cmp_user_nameBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#cmp_user_nameBB').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#cmp_user_nameBB').parent().find('.input-error').hide();
            }
        }

        //if(user_type == 4 && status != 5)
        //{
            if($('#txtActivityBB').val() == "") 
            {
                $('#txtActivityBB').addClass('error-val');
                $('#txtActivityBB').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivityBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivityBB').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivityBB').parent().find('.input-error').hide();
            }
        //}

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    } 
    // Working in details view END

    function getcmp_type_co_banca_dtl()
    {
        var depart = $('#ddlDepartmentNameBB').val();
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
            $('#ddlComplaintTypeBB').html(data);
        });
    }

    function get_cmp_type_co_banca_dtl()
    {
        var cmptype = $('#ddlComplaintTypeBB').val();
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
                  $('#is_manualbb').val('1');
                  $('#cmp_invalidBB').val('0');
             }else{
                $('#is_manualbb').val('0');
             } 
             var $tat = res[3] + " Working Days";
             $('#user_id_ressignbb').val(res[0]);
             //$('#cmp_user_groupBB').val(res[1]);
             $('#ddlPriorityBB').val(res[2]);
             $('#txtComplaintTATBB').val($tat);
             //$('#typeC').val(res[4]);
             //$('#modeBB').val(res[5]);
        });
    }
    var counterBB = 1;
    var getid = 0;

     $(document).on('click', '#btnFileUploadBB', function () {
            var formdata = new FormData($('#modalformBB')[0]);
            formdata.append('complaint_id',getid);
            var id            = $('#txtIdBB').val();
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
                            window.location.href = `complaint_views.php`;
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
</script>