<?php
    $objProd = new Product();
    $objComplaint = new Complaint();
    $users = $objUser->GetUsers(0); 
    $data                   = $objComplaint->GetComplaintByIdVatality($id,$cmode);
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintVatality">
        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actionV" name="actionV" value="edit_complaint">
        <input type="hidden" name="txtCounterDisplayV" id="txtCounterDisplayV" value="<? //echo $counter_display; ?>" />
        <input type="hidden" name="txtCounterV" id="txtCounterV" value="<? //echo $counter; ?>" />
        <input type="hidden" name="typeV" id="typeV" value="vatality" />
        <input type="hidden" name="cmp_userV" id="cmp_userV" value="" />
        <input type="hidden" name="cmp_user_groupV" id="cmp_user_groupV" value="" />
        <input type="hidden" name="modeV" id="modeV" value="" />
        <input type="hidden" id="complaint_num" name="complaint_num" class="form-control" value="<?php echo $data[0]['complaint_num'];?>">

        <fieldset>
            <legend>Complaint Vitality</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberV" name="txtPolicyNumberV" class="form-control" placeholder="Policy Number" value="<?php echo $data[0]['policy_num']; ?>" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Policyholder Name<span style="color: red;">*</span></label>
						<input type="text" id="txtCustomerNameV" name="txtCustomerNameV" class="form-control" placeholder="Policyholder Name" value="<?php echo $data[0]['customer_name']; ?>">
						<div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
					</div>
				</div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICV" name="txtCNICV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15" value="<?php echo $data[0]['cnic']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateV" id="policy_issuance_dateV" placeholder="Pick Preferable Date and Time" tabindex="13" value="<?php echo Date('d/m/Y',strtotime($data[0]['policy_issuance_date'])) ?>" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy</label>
                        <select class="form-control default-select2" id="status_of_policyV" name="status_of_policyV" data-placeholder="Select Plan Nature" >
                            <option value="0" selected="selected" disabled>Select Status of Policy</option>
                            <option value="Cancelled" <?php echo $data[0]['status_policy'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
							<option value="Matured" <?php echo $data[0]['status_policy'] == 'Matured' ? 'selected' : ''; ?>>Matured</option>
							<option value="Active" <?php echo $data[0]['status_policy'] == 'Active' ? 'selected' : ''; ?>>Active</option>
							<option value="Lapsed" <?php echo $data[0]['status_policy'] == 'Lapsed' ? 'selected' : ''; ?>>Lapsed</option>
							<option value="Auto Surrender" <?php echo $data[0]['status_policy'] == 'Auto Surrender' ? 'selected' : ''; ?>>Auto Surrender</option>
							<option value="Reduce Paid Up" <?php echo $data[0]['status_policy'] == 'Reduce Paid Up' ? 'selected' : ''; ?>>Reduce Paid Up</option>
							<option value="Extended Term Assurance" <?php echo $data[0]['status_policy'] == 'Extended Term Assuranc' ? 'selected' : ''; ?>>Extended Term Assurance</option>
							<option value="Surrendered" <?php echo $data[0]['status_policy'] == 'Surrendered' ? 'selected' : ''; ?>>Surrendered</option>
							<option value="Claim Case" <?php echo $data[0]['status_policy'] == 'Claim Case' ? 'selected' : ''; ?>>Claim Case</option>
							<option value="Not Inforce" <?php echo $data[0]['status_policy'] == 'Not Inforce' ? 'selected' : ''; ?>>Not Inforce</option>
							<option value="Terminated" <?php echo $data[0]['status_policy'] == 'Terminated' ? 'selected' : ''; ?>>Terminated</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Status of Policy is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Plan Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="plan_natureV" name="plan_natureV" data-placeholder="Select Plan Nature" >
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
                        <select class="form-control default-select2" id="ddlProductNameV" name="ddlProductNameV" data-size="10" data-live-search="true" data-style="btn-white">
                            <!-- <option value="">Select Product</option> -->
                            <?php $product = $objProd->GetProduct(0); ?>
                            <?php foreach($product as $products){ ?>
                                <option value="<? echo $products["id"]; ?>"<? if($products['fullname'] == $data[0]['product_name']){ echo "selected";} ?> ><?echo $products["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <select class="form-control default-select2" id="bankNameV" name="bankNameV" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select Bank</option>
                                <option value="Al Baraka" <?php echo $data[0]['bank'] == 'Al Baraka' ? 'selected' : ''; ?>>Al Baraka</option>
								<option value="Bank Alfalah" <?php echo $data[0]['bank'] == 'Bank Alfalah' ? 'selected' : ''; ?>>Bank Alfalah</option>
								<option value="Dubai Islamic Bank" <?php echo $data[0]['bank'] == 'Dubai Islamic Bank' ? 'selected' : ''; ?>>Dubai Islamic Bank</option>
								<option value="MCB" <?php echo $data[0]['bank'] == 'MCB' ? 'selected' : ''; ?>>MCB</option>
								<option value="Samba" <?php echo $data[0]['bank'] == 'Samba' ? 'selected' : ''; ?>>Samba</option>
								<option value="SCB" <?php echo $data[0]['bank'] == 'SCB' ? 'selected' : ''; ?>>SCB</option>
								<option value="Soneri Bank" <?php echo $data[0]['bank'] == 'Soneri Bank' ? 'selected' : ''; ?>>Soneri Bank</option>
								<option value="Silk Bank" <?php echo $data[0]['bank'] == 'Silk Bank' ? 'selected' : ''; ?>>Silk Bank</option>
								<option value="UBL" <?php echo $data[0]['bank'] == 'UBL' ? 'selected' : ''; ?>>UBL</option>
								<option value="HBL" <?php echo $data[0]['bank'] == 'HBL' ? 'selected' : ''; ?>>HBL</option>
								<option value="Summit Bank" <?php echo $data[0]['bank'] == 'Summit Bank' ? 'selected' : ''; ?>>Summit Bank</option>
								<option value="Makramah Bank" <?php echo $data[0]['bank'] == 'Makramah Bank' ? 'selected' : ''; ?>>Makramah Bank</option>
								<option value="Faysal Bank" <?php echo $data[0]['bank'] == 'Faysal Bank' ? 'selected' : ''; ?>>Faysal Bank</option>
								<option value="BOP" <?php echo $data[0]['bank'] == 'BOP' ? 'selected' : ''; ?>>BOP</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Bank Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameV" name="ddlDepartmentNameV" data-placeholder="Select Complaint" onchange="getcmp_type_vatality();">
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
                        <label>Complaint Type<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlComplaintTypeV" name="ddlComplaintTypeV" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_vatality();">
                            <option value="0" selected="selected" disabled >Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Source<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlSourceV" name="ddlSourceV" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Select Source</option>
                            <?php $source = $objProd->GetSource(0); ?>
                            <?php foreach($source as $sources){ ?>
                             <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["fullname"] ? 'selected' : ''?>><? echo $sources["fullname"] ?></option>
                            <? } ?>
                         
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountV" name="txtPremiumAmountV" class="form-control" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['premium_amount']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- <div class="col-md-3">
                    <div class="form-group" style="display: none;"> 
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <input type="text" id="txtRefundAmountV" name="txtRefundAmountV" class="form-control" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)"  value="<?php echo $data[0]['refund_amount']; ?>">
                    </div>
                </div>
				<div class="col-md-1">
                </div> -->
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedV" name="txtAmountClaimedV" class="form-control" placeholder="Enter Amount" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['claim_amount']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityLV" name="cityLV">
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>" <?php echo $data[0]['city'] == $city["id"] ? 'selected' : ''; ?> ><? echo $city["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                    </div>
                </div>
			</div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Region</label>
                        <select class="form-control" id="ddlRegionV" name="ddlRegionV">
                            <option value="" selected="selected" disabled="disabled">Select Region</option>
                            <option value="south" <?php echo $data[0]['region'] == 'south' ? 'selected' : ''; ?>>South</option>
                            <option value="east" <?php echo $data[0]['region'] == 'east' ? 'selected' : ''; ?>>East</option>
                            <option value="central" <?php echo $data[0]['region'] == 'central' ? 'selected' : ''; ?>>Central</option>
                            <option value="north" <?php echo $data[0]['region'] == 'north' ? 'selected' : ''; ?>>North</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Region is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="reported_dtV" value="<?php echo Date("d/m/Y",strtotime($data[0]['reported_dt'])) ?>" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="received_dateV" value="<?php echo Date("d/m/Y",strtotime($data[0]['received_date'])) ?>" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
			</div>
            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityV" name="ddlPriorityV" class="form-control" placeholder="Priority" disabled="disabled">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATV" name="txtComplaintTATV" class="form-control" placeholder="Complaint TAT" disabled="disabled">
                    </div>
                </div>
				
				<div class="col-md-1">
                </div>
            </div>
			
            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionV" name="txtDescriptionV" rows="4" class="form-control"><?php echo $data[0]['description']; ?></textarea>
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
                        <input type="text" id="txtCallBackV" name="txtCallBackV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11" value="<?php echo $data[0]['callback_num']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneV" name="txtHomePhoneV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['residence_phone']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileV" name="txtMobileV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['mobile_number']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneV" name="txtOfficePhoneV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12" value="<?php echo $data[0]['office_phone']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                            <input type="text" class="form-control" id="txtEmailV" name="txtEmailV" placeholder="example@mail.com" value="<?php echo $data[0]['email']; ?>">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <!-- <span class="input-group-addon">@</span> -->
                        <!-- </div> -->
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea rows="6" placeholder="Enter Office Address" id="txtOfficeAddressV" name="txtOfficeAddressV" class="form-control"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressV" name="txtCorrespondenceAddressV" class="form-control"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMSV" id="radio_inline_css_v3" value="1" <?php echo $data[0]['is_sms'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_v3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSV" id="radio_inline_css_v4" value="0" <?php echo $data[0]['is_sms'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_v4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Mobile<span style="color: red;">*</span></label>
                        <input type="text" maxlength="12" class="form-control" id="txtResponseNumberV" name="txtResponseNumberV" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" value="<?php echo $data[0]['response_number']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Customer Mobile is required</div>
                    </div>
                </div>

                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_v12" value="1" <?php echo $data[0]['is_call_back'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_v12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_v21" value="0" <?php echo $data[0]['is_call_back'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_v21">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Mobile</label>
                        <input type="text" maxlength="12" class="form-control number" id="txtResponseNumberV" name="txtResponseNumberV" onkeypress="return validateNumbers(event)" placeholder="92-XXXXXXXXXX">
                    </div>
                </div>

                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_v12" value="1" >
                                <label for="radio_inline_css_v12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackV" id="radio_inline_css_v21" value="0" checked="true">
                                <label for="radio_inline_css_v21">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintVitality"  onclick ="vatality_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." >Save</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        masking_v();
    });

    function customer_data_vatality()
    {
        var PolicyNumber = $('#txtPolicyNumberV').val();
        var type = 1;
        if(PolicyNumber != ''){
         $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint.php",
            data:{
                action : "get_customer_data",
                PolicyNumber: PolicyNumber,
                type : type

            }

        }).done(function (data) {
              //alert(data);
             var res = data.split('|');
                $('#txtCNICV').val(res[0]);
                $('#txtCustomerNameV').val(res[1]);
                $('#txtResponseNumberV').val(res[2]);
                $('#txtOfficePhoneV').val(res[3]);
                $('#txtEmailV').val(res[4]);
                $('#txtCustomerEmailV').val(res[5]);
                $('#txtMobileV').val(res[6]);
                $('#txtHomePhoneV').val(res[7]);
                $('#txtOfficeAddressV').val(res[8]);
                $('#txtCorrespondenceAddressV').val(res[9]);
        }); 
      } 
    }
    getcmp_type_vatality();
    function getcmp_type_vatality()
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
            $('#ddlComplaintTypeV').val('<?php echo $data[0]['complaint_type_id']; ?>').trigger('change');
        });
    }
    get_cmp_type_detail_vatality();
    function get_cmp_type_detail_vatality()
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
             var $tat = res[3] + " Working Days";
             $('#cmp_userV').val(res[0]);
             $('#cmp_user_groupV').val(res[1]);
             $('#ddlPriorityV').val(res[2]);
             $('#txtComplaintTATV').val($tat);
             //$('#type').val(res[4]);
             $('#modeV').val(res[5]);
        });
    }

    function vatality_cmp()
    {
        var complaintId = $('#txtId').val();
        var complaintNum = $('#complaint_num').val();
        var mode = $('#modeV').val();
        var txtCNIC = $('#txtCNICV').val();

        var policy_issuance_date=$('#policy_issuance_dateV').val();
        var status_of_policy=$('#status_of_policyV').val();
        var plan_nature = $('#plan_natureV').val();
        var bank =  $('#bankNameV').val();
        var txtPremiumAmount = $('#txtPremiumAmountV').val();
        var txtRefundAmount = 0;
        // var txtRefundAmount = $('#txtRefundAmountV').val();
        var txtAmountClaimed = $('#txtAmountClaimedV').val();
        var ddlRegion = $('#ddlRegionV').val();
        var cityL = $('#cityLV').val();
        var reported_dt = $('#reported_dtV').val();
        var received_date = $('#received_dateV').val();

        var txtPolicyNumber = $('#txtPolicyNumberV').val();
        var txtCustomerName = $('#txtCustomerNameV').val();
        var ddlProductName = $('#ddlProductNameV').val();
        var ddlSource = $('#ddlSourceV').val(); 
        var ddlDepartmentName = $('#ddlDepartmentNameV').val();
        var ddlPriority = $('#ddlPriorityV').val();
        var ddlComplaintType = $('#ddlComplaintTypeV').val();
        var txtComplaintTAT = $('#txtComplaintTATV').val();
        var txtDescription = $('#txtDescriptionV').val();
        var txtCallBack = $('#txtCallBackV').val();
        var txtHomePhone = $('#txtHomePhoneV').val();
        var txtMobile = $('#txtMobileV').val();
        var txtOfficePhone = $('#txtOfficePhoneV').val();
        var txtEmail = $('#txtEmailV').val();
        var txtOfficeAddress = $('#txtOfficeAddressV').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddressV').val();
        var txtCustomerEmail = $('#txtCustomerEmailV').val();
        var txtResponseNumber = $('#txtResponseNumberV').val();
        var type = $('#typeV').val();
        var cmp_user = $('#cmp_userV').val();
        var cmp_user_group = $('#cmp_user_groupV').val();
        var rdEmail = $('input[name=rdEmailV]:checked').val();
        var rdSMS = $('input[name=rdSMSV]:checked').val();
        var rdCallBack = $('input[name=rdCallBackV]:checked').val();
        var action = $('#actionV').val();

        //$("#btnSaveComplaintVitality").button('loading');
        //alert(ddlPriority);
        if(validation_vatality()){
          $("#btnSaveComplaintVitality").button('loading');
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:{
                    'action'            : action,
                    'complaintId'       : complaintId,
                    'complaintNum'      : complaintNum,
                    'mode'              : mode,
                    'txtCNIC'           : txtCNIC,
                    'policy_issuance_date'           : policy_issuance_date,
                    'status_of_policy'           : status_of_policy,
                    'plan_nature'           : plan_nature,
                    'bank'           : bank,
                    'txtPremiumAmount'           : txtPremiumAmount,
                    'txtRefundAmount'           : txtRefundAmount,
                    'txtAmountClaimed'           : txtAmountClaimed,
                    'ddlRegion'           : ddlRegion,
                    'cityL'           : cityL,
                    'reported_dt'           : reported_dt,
                    'received_date'           : received_date,
                    'txtPolicyNumber'    :txtPolicyNumber,
                    'txtCustomerName'   : txtCustomerName,
                    'ddlProductName'    : ddlProductName,
                    'ddlSource'         : ddlSource,
                    'ddlDepartmentName' : ddlDepartmentName,
                    'priority'          : ddlPriority,
                    'ddlComplaintType'  : ddlComplaintType,
                    'txtComplaintTAT'   : txtComplaintTAT,
                    'txtDescription'    : txtDescription,
                    'txtCallBack'       : txtCallBack,
                    'txtHomePhone'      :   txtHomePhone,
                    'txtMobile'         : txtMobile,
                    'txtOfficePhone'    : txtOfficePhone,
                    'txtEmail'          : txtEmail,
                    'txtOfficeAddress'  : txtOfficeAddress,
                    'txtCorrespondenceAddress' : txtCorrespondenceAddress,
                    'txtCustomerEmail'   : txtCustomerEmail,
                    'txtResponseNumber'  : txtResponseNumber,
                    'type'               : type,
                    'cmp_user'           : cmp_user,
                    'cmp_user_group'     : cmp_user_group,
                    'rdEmail'            : rdEmail,
                    'rdSMS'              : rdSMS,
                    'rdCallBack'         : rdCallBack,
                    'action'             : action
                },
                success: function(data) 
                {
                    //alert(data); 
                    //console.log(data);
                    $("#btnSaveComplaintVitality").button('reset');
                    var result = data.split("|");
                    getid = result[1];
                    var message = "Complaint updated successfully with Complaint Id <strong>";
                    var tempdata = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "success", html: message +  tempdata[3] + "</strong>", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () {
                                window.location.href = "complaint_views.php";
                            }, 3000);
                        // $('#ModalCommentV').modal({backdrop: 'static', keyboard: false});
                        // $('#ModalCommentV').modal('show');
                        // $('#complaint_id_mainV').val(result[1]);
                        // $('#type_mainV').val(result[2]);
                        // $('#counter_displayV').val(result[3]);

                        return false;
                    }
                    else if(data == 'fail')
                    {
                         $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }
                }
            });
        }
    }  

    function validation_vatality()
    {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        // Policy Number OK
        if($('#txtPolicyNumberV').val() == '') 
        {
            $('#txtPolicyNumberV').addClass('error-val');
            $('#txtPolicyNumberV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPolicyNumberV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtPolicyNumberV').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#txtPolicyNumberV').parent().find('.input-error').hide();
        }

        // CNIC/NICOP OK
        if($('#txtCNICV').val() == "") 
        {
            $('#txtCNICV').addClass('error-val');
            $('#txtCNICV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNICV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtCNICV').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNICV').parent().find('.input-error').hide();
        }

        if($('#policy_issuance_dateV').val() == '') 
        {
            $('#policy_issuance_dateV').addClass('error-val');
            $('#policy_issuance_dateV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#policy_issuance_dateV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#policy_issuance_dateV').removeClass('error-val');
            //$('#policy_issuance_dateV').parents('.control-group').addClass('success');
            $('#policy_issuance_dateV').parent().find('.input-error').hide();
        }
        if($('#txtPremiumAmountV').val() == '') 
        {
            $('#txtPremiumAmountV').addClass('error-val');
            $('#txtPremiumAmountV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPremiumAmountV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtPremiumAmountV').removeClass('error-val');
            //$('#txtPremiumAmountV').parents('.control-group').addClass('success');
            $('#txtPremiumAmountV').parent().find('.input-error').hide();
        }
        // if($('#txtRefundAmountV').val() == '') 
        // {
        //     $('#txtRefundAmountV').addClass('error-val');
        //     $('#txtRefundAmountV').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) 
        //     {
        //         $('#txtRefundAmountV').focus();
        //         hasFocus = true;
        //     }

        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtRefundAmountV').removeClass('error-val');
        //     //$('#txtRefundAmountV').parents('.control-group').addClass('success');
        //     $('#txtRefundAmountV').parent().find('.input-error').hide();
        // }
        if($('#txtAmountClaimedV').val() == '') 
        {
            $('#txtAmountClaimedV').addClass('error-val');
            $('#txtAmountClaimedV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtAmountClaimedV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtAmountClaimedV').removeClass('error-val');
            //$('#txtAmountClaimedV').parents('.control-group').addClass('success');
            $('#txtAmountClaimedV').parent().find('.input-error').hide();
        }
        if($('#reported_dtV').val() == '') 
        {
            $('#reported_dtV').addClass('error-val');
            $('#reported_dtV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#reported_dtV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#reported_dtV').removeClass('error-val');
            //$('#reported_dtV').parents('.control-group').addClass('success');
            $('#reported_dtV').parent().find('.input-error').hide();
        }
        if($('#received_dateV').val() == '') 
        {
            $('#received_dateV').addClass('error-val');
            $('#received_dateV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_dateV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#received_dateV').removeClass('error-val');
            //$('#received_dateV').parents('.control-group').addClass('success');
            $('#received_dateV').parent().find('.input-error').hide();
        }


        if($('#plan_natureV').val() == '0') 
        {
            $('#plan_natureV').addClass('error-val');
            $('#plan_natureV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#plan_natureV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#plan_natureV').removeClass('error-val');
            //$('#plan_natureV').parents('.control-group').addClass('success');
            $('#plan_natureV').parent().find('.input-error').hide();
        }

        // Customer Name OK
        if($('#txtCustomerNameV').val() == '') 
        {
            $('#txtCustomerNameV').addClass('error-val');
            $('#txtCustomerNameV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCustomerNameV').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtCustomerNameV').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
            $('#txtCustomerNameV').parent().find('.input-error').hide();
        }


        if($('#ddlProductNameV').val() == '') 
        {
            $('#ddlProductNameV').addClass('error-val');
            $('#ddlProductNameV').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductNameV').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlProductNameV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlProductNameV').removeClass('error-val');
            $('#ddlProductNameV').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlProductName').parents('.control-group').addClass('success');
            $('#ddlProductNameV').parent().find('.input-error').hide();
        }

        // Source OK
        if($('#ddlSourceV').val() == null) 
        {
            $('#ddlSourceV').addClass('error-val');
            $('#ddlSourceV').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSourceV').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSourceV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSourceV').removeClass('error-val');
            $('#ddlSourceV').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSourceV').parent().find('.input-error').hide();
        }
        if($('#ddlDepartmentNameV').val() == null) 
        {
            $('#ddlDepartmentNameV').addClass('error-val');
            $('#ddlDepartmentNameV').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameV').parent().find('.select2-container--default').show().addClass('error-val');

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
            $('#ddlDepartmentNameV').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlDepartmentNameV').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintTypeV').val() == 0 || $('#ddlComplaintTypeV').val() == null) 
        {
            $('#ddlComplaintTypeV').addClass('error-val');
            $('#ddlComplaintTypeV').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeV').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintTypeV').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeV').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintTypeV').parent().find('.input-error').hide();
        }

        if($('#txtResidenceAddressV').val() == "") 
        {
            $('#txtResidenceAddressV').addClass('error-val');
            $('#txtResidenceAddressV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResidenceAddressV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResidenceAddressV').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtResidenceAddressV').parent().find('.input-error').hide();
        }

        if($('#txtCorrespondenceAddressV').val() == "") 
        {
            $('#txtCorrespondenceAddressV').addClass('error-val');
            $('#txtCorrespondenceAddressV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddressV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCorrespondenceAddressV').removeClass('error-val');
            //$('#txtCorrespondenceAddressV').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddressV').parent().find('.input-error').hide();
        }

        if($('#txtEmailV').val() == '' ) 
        {
            $('#txtEmailV').addClass('error-val');
            $('#txtEmailV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmailV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmailV').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtEmailV').parent().find('.input-error').hide();
        }

        if($('#txtResponseNumberV').val() == "") 
        {
            $('#txtResponseNumberV').addClass('error-val');
            $('#txtResponseNumberV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResponseNumberV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResponseNumberV').removeClass('error-val');
            //$('#txtResponseNumberV').parents('.control-group').addClass('success');
            $('#txtResponseNumberV').parent().find('.input-error').hide();
        }
        

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking_v()
    {
        //$("#txtCNICV").inputmask({"mask": "99999-9999999-9"});
        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }
</script>