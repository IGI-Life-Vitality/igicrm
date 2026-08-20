<?php
    $objProd        = new Product();
    $objComplaint   = new Complaint();

    $users      = $objUser->GetUsers(0);

    $disa       = "";
    $dis_button = "";
    $disabled   = "";
    $disable_info   = "";
    $email_checked  = "";
    $sms_checked    = "";
    $call_back_checked              = "";
    $disable_complaint_progress     = "";
    $comments_progress              = "";
    $disabled_comments              = "";
    $heading = "Complaint Management";

    if(isset($_GET))
    {
        $complaint_id   = isset($_GET['id']) ? $_GET['id'] : 0;
        $cmode          = isset($_GET['cmode']) ? $_GET['cmode'] : 0;

        $heading = "";
        $isactive = "";

        if($complaint_id > 0)
        {
            $data = $objComplaint->GetComplaintByIdLegal($complaint_id,$cmode);
            $activity_data = $objComplaint->GetComplaintStatusById($complaint_id,$cmode);

            $dis_button = ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 6 || $data[0]['user_id'] != $login_id && $data[0]['user_id'] != 0 ) ? "disabled='true'" : "";

            $dis_button_invalid     = ($data[0]['status_id'] == 5 && $data[0]['group_id'] == 0 && $data[0]['user_id'] == 0 && $data[0]['user_id'] != $login_id && $data[0]['agent_id'] != $login_id) ? "disabled='true'" : "";
            $dis_btn_once_invalid   = ($data[0]['status_id'] == 5 && $data[0]['user_id'] == $login_id && $data[0]['progress'] == 0) ? "disabled='true'" : "";

            $disable_complaint_progress = ($data[0]["progress"] == 100 ||  $data[0]['user_id'] == 0)? "disabled='true'" : "";

            $comments_progress = ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 6) ? $data[0]['comments'] : '';
            $disabled_comments   = ($data[0]['status_id'] == 3  || $data[0]['status_id']== 6 /*||  $data[0]['user_id'] == 0*/) ? "disabled='true'" : "";

            $disabled = ($data[0]['status_id'] == 3) ? "disabled='true'" : "";

            $email_checked       = $data[0]['is_email'] == 0 ? "checked='true'" : "";
            $sms_checked         = $data[0]['is_sms'] == 0 ? "checked='true'" : "";
            $call_back_checked   = $data[0]['is_call_back'] == 0 ? "checked='true'" : "";

            $us = explode(',', $group_id);
            
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

                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Comments</label>
                                        <textarea type="text" name="commentsL" class="form-control" id="txtCommentsL" row="5" placeholder="Comments Section"></textarea>
                                    </div>
                                </div> -->

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

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintLegal">
        <input type="hidden" id="txtIdl" name="txtIdl" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actionl" name="actionl" value="update_progress">
        <input type="hidden" name="cmodel" id="cmodel" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_idl" id="user_idl" value="<?php echo($data[0]['user_id']); ?>" />
        <input type="hidden" name="cmp_invalidl" id="cmp_invalidl" value="<?php if($data[0]['status_id'] == 5 ){ echo '1';}else{echo '0';} ?>" />

        <input type="hidden" name="user_id_ressignl" id="user_id_ressignl" value="0" />
        <input type="hidden" name="is_manuall" id="is_manuall" value="1" />
        <input type="hidden" name="statusl" id="statusl" value="<?php echo $data[0]['status_id'];?>" />
        <input type="hidden" name="complaint_num" id="complaint_num" value="<?php echo $data[0]['complaint_num'];?>" />

        <fieldset>
            <legend>Complaint Legal</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberL" name="txtPolicyNumberL" class="form-control" value="<?php echo $data[0]['policy_num']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Name</label>
                        <input type="text" id="txtComplaintNameL" name="txtComplaintNameL" class="form-control" value="<?php echo $data[0]['customer_name']; ?>" disabled="true">
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
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Letter/Complaint No.<span style="color: red;">*</span></label>
                        <input type="text" id="txtLetterComplNumber" name="txtLetterComplNumber" class="form-control" value="<?php echo $data[0]['letter_no']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control date" name="policy_issuance_dateLL" id="policy_issuance_dateLL" value="<?php echo Date("d-M-Y",strtotime($data[0]['policy_issuance_date'])); ?>" placeholder="Pick Preferable Date and Time" disabled tabindex="13" />

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
                            <option value="Cancelled" <?php echo $data[0]['status_policy'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Status of Policy is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
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
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product Nature<span style="color: red;">*</span></label>
                        <input type="text" id="ddlProductNameL" name="ddlProductNameL" class="form-control" value="<?php echo $data[0]['product_name']; ?>" disabled="true">
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
            </div>
            <div class="col-md-12">
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] == 5) { ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Department Name<span style="color: red;">*</span></label>
                            <select class="form-control default-select2" id="ddlDepartmentNameL" name="ddlDepartmentNameL" data-placeholder="Select Complaint" onchange="getcmp_type_legal_dtl();">
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
                            <select class="form-control default-select2" id="ddlComplaintTypeL" name="ddlComplaintTypeL" data-placeholder="Select Complaint Type" onchange="get_cmp_type_legal_dtl();">
                                <option value="0" selected="selected" disabled >Select Complaint</option>
                            </select>
                            <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Department Name<span style="color: red;">*</span></label>
                            <input type="text" id="ddlDepartmentNameL2" name="ddlDepartmentNameL2" class="form-control" value="<?php echo $data[0]['department_name']; ?>" disabled="true">
                            <input type="hidden" name="ddlDepartmentNameL" id="ddlDepartmentNameL" value="<?php echo $data[0]['complaint_depart']; ?>">
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Complaint Type<span style="color: red;">*</span></label>
                            <input type="text" id="ddlComplaintTypeL2" name="ddlComplaintTypeL2" class="form-control" value="<?php echo $data[0]['complaint_type']; ?>" disabled="true">
                            <input type="hidden" name="ddlComplaintTypeL" id="ddlComplaintTypeL" value="<?php echo $data[0]['complaint_type_id']; ?>">
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Compalint Reported Through<span style="color: red;">*</span></label>
                        <input type="text" id="ddlSourceL" name="ddlSourceL" class="form-control" value="<?php echo $data[0]['source']; ?>" disabled="true">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountL" name="txtPremiumAmountL" class="form-control" value="<?php echo $data[0]['premium_amount']; ?>" <? echo $disable_complaint_progress; ?>>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <?php if($data[0]['status_id'] == 3) { ?>
                        <input type="text" id="txtRefundAmountL" name="txtRefundAmountL" value="<?php echo $data[0]['refun_amount']; ?>" class="form-control"  <? echo $disable_complaint_progress; ?>>
                        <?php } else { ?>
                            <input type="text" id="txtRefundAmountL" name="txtRefundAmountL" value="<?php echo $data[0]['refun_amount']; ?>" class="form-control"<? echo $disable_complaint_progress; ?>>
                        <?php } ?>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Refund Amount is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedL" name="txtAmountClaimedL" class="form-control" value="<?php echo $data[0]['claim_amount']; ?>" <? echo $disable_complaint_progress; ?>>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nominated Agent Name</label>
                        <input type="text" id="txtAgentNameL" name="txtAgentNameL" class="form-control" placeholder="Nominated Agent Name" value="<?php echo $data[0]['agent']; ?>" disabled>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Nominated Agent Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agent Code</label>
                        <input type="text" id="txtAgentCode" name="txtAgentCode" class="form-control" value="<?php echo $data[0]['agent_code']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Unit Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtUnitName" name="txtUnitName" class="form-control" value="<?php echo $data[0]['unit_name']; ?>" disabled="true">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>AM Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtAMName" name="txtAMName" class="form-control" value="<?php echo $data[0]['am_name']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <!-- <input type="text" id="cityL" name="cityL" class="form-control" value="<?php echo $objComplaint->GetCityName($data[0]['city']); ?>" disabled="true"> -->
                        <select class="form-control default-select2" id="cityL" name="cityL" disabled>
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>" <?php echo $data[0]['city'] == $city["id"] ? 'selected' : ''; ?> ><? echo $city["fullname"] ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" id="ddlRegion" name="ddlRegion" class="form-control" value="<?php echo $data[0]['region']; ?>" disabled="true">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Nature Of Complaint</label>
                        <input type="text" id="ddlComplaintNature" name="ddlComplaintNature" class="form-control" value="<?php echo $data[0]['complaint_nature']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Reported Date & Time<span style="color: red;">*</span></label>
                        <input type="text" id="datepicker-autoClose" name="datepicker-autoClose" class="form-control" value="<?php echo Date("d-M-Y",strtotime($data[0]['reported_date'])); ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="received_dateLL" value="<?php echo Date("d-M-Y",strtotime($data[0]['received_date'])) ?>" disabled placeholder="Complaint Received Date">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Activity Priority</label>
                        <input type="text" id="ddlPriorityL" name="ddlPriorityL" class="form-control" value="<?php echo $data[0]['priority_id']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Forums<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlForum" name="ddlForum" disabled="true">
                            <option value="">Select Forum</option>
                            <?php $forums = $objComplaint->GetForums(); ?>
                            <?php foreach($forums as $forum){ ?>
                                <option value="<? echo $forum["id"]; ?>" <?php echo $data[0]['forum_id'] == $forum["id"] ? "selected='selected'" : ""?>><? echo $forum["fullname"]; ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Forums is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>Policy Status<span style="color: red;">*</span></label>
                        <input type="text" id="ddlPolicyStatusL" name="ddlPolicyStatusL" class="form-control" value="<?php echo $data[0]['policy_status']; ?>" disabled="true">
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <?php if($data[0]['user_id'] == 0 && $data[0]['agent_id'] == $login_id && $data[0]['status_id'] != 5) {?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Assign To<span style="color: red;">*</span></label>
                            <select class="form-control default-select2" id="cmp_user_namel" name="cmp_user_namel" data-size="10" data-live-search="true" data-style="btn-white">
                                <option value="" selected="selected">Select User</option>
                                 <?php $users = $objUser->GetUsers(); ?>
                                <?php foreach($users as $user){ ?>
                                <option value="<? echo $user["id"]; ?>" <?php echo $data[0]['user_id'] == $user["id"] ? "selected='selected'" : ""?>><? echo $user["first_name"] ." ".$user["last_name"]?></option>
                                <? } ?>
                            </select>
                            <div class="input-error form-control-input" style="color: Red; display: none;">User is required</div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                <?php } ?>
            </div>
            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Detail Description</label>
                        <textarea placeholder="Enter Description" id="txtDescriptionL" name="txtDescriptionL" rows="6" class="form-control" disabled='true'><?php echo $data[0]['description']; ?></textarea>
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
                        <label>Phone Home</label>
                        <input type="text" id="txtHomePhoneL" name="txtHomePhoneL" class="form-control" value="<?php echo $data[0]['residence_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtCallBackL" name="txtCallBackL" class="form-control" value="<?php echo $data[0]['callback_num']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileL" name="txtMobileL" class="form-control" value="<?php echo $data[0]['mobile_number']; ?>" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneL" name="txtOfficePhoneL" class="form-control" value="<?php echo $data[0]['office_phone']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <input type="text" class="form-control" id="txtEmailL" name="txtEmailL" value="<?php echo $data[0]['email']; ?>" disabled="true">
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
                        <textarea rows="6" placeholder="Enter Office Address" id="txtOfficeAddressL" name="txtOfficeAddressL" class="form-control" disabled="true"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressL" name="txtCorrespondenceAddressL" class="form-control" disabled="true"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMSL" id="radio_inline_css_3" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSL" id="radio_inline_css_4" value="0" <?php echo $sms_checked; ?> disabled="true">
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
                        <input type="text" maxlength="12" class="form-control number" id="txtResponseNumberL" name="txtResponseNumberL" value="<?php echo $data[0]['response_number']; ?>" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_12" value="1" checked="true" disabled="true">
                                <label for="radio_inline_css_12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_21" value="0" <?php echo $call_back_checked; ?> disabled="true">
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
                        <label>Progress<span style="color: red;">*</span></label><br>
                        <select class="form-control default-select2" id="ddlProgressL" name="ddlProgressL" data-size="10" data-live-search="true" data-style="btn-white" <? echo $disable_complaint_progress; ?>>
                            <?php if($user_type == 2 && $data[0]['status_id'] == 5) { ?>
                                    <option value="101" <?php if($data[0]['progress'] =="101") echo "selected=selected"?> >Invalid</option>
                                    <option value="99" <?php if($data[0]['progress'] =="99") echo "selected=selected"?>>Valid</option>
                            <?php } elseif($user_type == 2 && $data[0]['status_id'] == 4 ) { ?>
                                    <option value="11" <?php if($data[0]['progress'] =="11") echo "selected=selected"?> >UnResolved</option>
                                    <option value="50" <?php if($data[0]['progress'] =="50") echo "selected=selected"?> >In Progress</option>
                            <?php } else { ?>
                                <option value="" <?php if($data[0]['progress'] =="0") echo "selected=selected"?>  disabled="disabled">Select Progress</option>
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
                        <textarea type="text" class="form-control" id="txtActivityL" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['status_id'] == 3 || $data[0]['status_id'] == 4) ? $comments_progress : ''; ?></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" <? echo $dis_button; ?> <? echo $dis_button_invalid; ?> <? echo $dis_btn_once_invalid; ?> onclick ="legal_cmp();" id="btnSaveComplaintLegal" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }
</style>

<script type="text/javascript">
    //Working in details view START
    function legal_cmp()
    {
        var manual = 0;
        var new_user ="";
        var id            = $('#txtIdl').val();
        var action        = 'update_progress';
        var user_type     = <? echo $user_type ?>;
        var complaint_num = $('#complaint_num').val();
        var progress      = $('#ddlProgressL').val();
        var user_id       = $('#user_idl').val();
        var notes         = $('#txtActivityL').val();
        var cmode         = $('#cmodel').val();
        var cmp_user_name = $('#cmp_user_namel').val();
        var invalid       = $('#cmp_invalidl').val();
        var tat           = $('#txtComplaintTATL').val();
        var priority      = $('#ddlPriorityL').val();
        var user          = $('#user_id_ressignl').val();
        var is_manual     = $('#is_manuall').val();
        var refund_ammount = $('#txtRefundAmountL').val();
        var premium_amount = $('#txtPremiumAmountL').val();
        var amount_claimed = $('#txtAmountClaimedL').val();
        var departmentName = $('#ddlDepartmentNameL').val();
        var cmp_type       = $('#ddlComplaintTypeL').val();
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

        if(validationL(user_type))
        {
            $("#btnSaveComplaintLegal").button('loading');

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
                    'cmp_type'       :cmp_type,
                    'refund_ammount' :refund_ammount,
                    'premium_amount' :premium_amount,
                    'amount_claimed' :amount_claimed
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                    //$("#btnSaveComplaintLegal").button('reset');

                    data = data.trim();
                    //alert(data);
                    //console.log(data);

                    if(data == 'success')
                    {
                        $('#ModalCommentL').modal('show');
                        $('#complaint_id_mainL').val(id);
                        $('#type_mainL').val('legal');
                        $('#counter_displayL').val(complaint_num);
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

    function validationL(user_type)
    {
        var hasFocus  = false;
        var errCount  = 0;
        var user_id   = $('#user_idl').val();
        var invalid   = $('#cmp_invalidl').val();
        var status    = $('#statusl').val();
        var progress  = $('#ddlProgressL').val();

        if(progress == 100)
        {
            if($('#txtRefundAmountL').val() == "" || $('#txtRefundAmountL').val() == null) 
            {
                $('#txtRefundAmountL').addClass('error-val');
                $('#txtRefundAmountL').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) {
                    $('#txtRefundAmountL').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtRefundAmountL').removeClass('error-val');
                //$('#txtRefundAmountL').parents('.control-group').addClass('success');
                $('#txtRefundAmountL').parent().find('.input-error').hide();
            }
        }

        //For Reassignemt
        if(user_id == 0 && invalid == 1)
        {
            if($('#ddlDepartmentNameL').val() == null || $('#ddlDepartmentNameL').val()  == "") 
            {
                $('#ddlDepartmentNameL').addClass('error-val');
                $('#ddlDepartmentNameL').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlDepartmentNameL').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlDepartmentNameL').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlDepartmentNameL').parent().find('.input-error').hide();
            }

            if($('#ddlComplaintTypeL').val() == null || $('#ddlComplaintTypeL').val()  == "") 
            {
                $('#ddlComplaintTypeL').addClass('error-val');
                $('#ddlComplaintTypeL').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#ddlComplaintTypeL').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlComplaintTypeL').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#ddlComplaintTypeL').parent().find('.input-error').hide();
            }
        }
        else if(user_id == 0 && invalid == 0 && status != 5) // For Reassignemt with menual user
        {
            if($('#cmp_user_namel').val() == null || $('#cmp_user_namel').val()  == "") 
            {
                $('#cmp_user_namel').addClass('error-val');
                $('#cmp_user_namel').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#cmp_user_namel').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#cmp_user_namel').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#cmp_user_namel').parent().find('.input-error').hide();
            }
        }

        // if(user_type == 4)
        // {
            if($('#txtActivityL').val() == "" || $('#txtActivityL').val() == null) 
            {
                $('#txtActivityL').addClass('error-val');
                $('#txtActivityL').parent().find('.input-error').show().css('display', 'inline-block');
                if (!hasFocus) 
                {
                    $('#txtActivityC').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtActivityL').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtActivityL').parent().find('.input-error').hide();
            }

            if($('#ddlProgressL').val() == null || $('#ddlProgressL').val() == '') 
            {
                $('#ddlProgressL').addClass('error-val');
                $('#ddlProgressL').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlProgressL').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlProgressL').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlProgressL').removeClass('error-val');
                $('#ddlProgressL').parent().find('.select2-container--default').show().removeClass('error-val');
                //$('#ddlProgressL').parents('.control-group').addClass('success');
                $('#ddlProgressL').parent().find('.input-error').hide();
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

    function getcmp_type_legal_dtl()
    {
        var depart = $('#ddlDepartmentNameL').val();

        // alert(depart);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data:{
                action : "get_cmp_type",
                id: depart
            }
        }).done(function (data) {
            //alert(data);
            $('#ddlComplaintTypeL').html(data);
        });
    }

    function get_cmp_type_legal_dtl()
    {
        var cmptype = $('#ddlComplaintTypeL').val();
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

            if(res[0] == 0)
            {
                $('#is_manuall').val('1');
                $('#cmp_invalidl').val('0');
            }
            else
            {
                $('#is_manuall').val('0');
            }

            var $tat = res[3] + " Working Days";
            $('#user_id_ressignl').val(res[0]);
            //$('#cmp_user_groupL').val(res[1]);
            $('#ddlPriorityL').val(res[2]);
            $('#txtComplaintTATL').val($tat);
            //$('#type').val(res[4]);
            //$('#modeL').val(res[5]);
        });
    }
    var counterL = 1;
    var getid = 0;

    $(document).on('click', '#btnFileUploadL', function () {

            var formdata = new FormData($('#modalformL')[0]);
            formdata.append('complaint_id',getid);
            var id            = $('#txtIdl').val();
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
                            window.location.href = `complaint_views.php`;
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
</script>