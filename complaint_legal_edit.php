<?php
    $objProd        = new Product();
    $objComplaint   = new Complaint();

    $users      = $objUser->GetUsers(0);
    $data = $objComplaint->GetComplaintByIdLegal($id,$cmode);
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintLegal">
        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="actionL" name="actionL" value="edit_complaint">
        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? //echo $counter_display; ?>" />
        <input type="hidden" name="typeL" id="typeL" value="legal" />
        <input type="hidden" name="cmp_userL" id="cmp_userL" value="" />
        <input type="hidden" name="cmp_user_groupL" id="cmp_user_groupL" value="" />
        <input type="hidden" name="modeL" id="modeL" value="" />
        <input type="hidden" name="txtComplaintTATL" id="txtComplaintTATL" value="" />
        <input type="hidden" name="txtCounter" id="txtCounter" value="" />
        <input type="hidden" id="complaint_num" name="complaint_num" class="form-control" value="<?php echo $data[0]['complaint_num'];?>">

        <fieldset>
            <legend>Complaint Legal</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberL" name="txtPolicyNumberL" class="form-control" placeholder="Policy Number" value="<?php echo $data[0]['policy_num']; ?>" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Name</label>
                        <input type="text" id="txtComplaintNameL" name="txtComplaintNameL" class="form-control" placeholder="Complaint Name" onchange="get_cmp_type_detail_legal();" value="<?php echo $data[0]['customer_name']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Name is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICL" name="txtCNICL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15" value="<?php echo $data[0]['cnic']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Letter/Complaint No.<span style="color: red;">*</span></label>
                        <input type="text" id="txtLetterComplNumber" name="txtLetterComplNumber" class="form-control" placeholder="Enter Letter/Complaint Number" value="<?php echo $data[0]['letter_no']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Letter/Complaint Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateLL" id="policy_issuance_dateLL" placeholder="Pick Preferable Date and Time" tabindex="13" value="<?php echo date('d/m/Y',strtotime($data[0]['policy_issuance_date'])) ?>" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy</label>
                        <select class="form-control default-select2" id="status_of_policyLL" name="status_of_policyLL" data-placeholder="Select Plan Nature" >
                            <option value="0" selected="selected" disabled>Select Status of Policy</option>
                            <option value="Cancelled" <?php echo $data[0]['status_policy'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
							<option value="Matured" <?php echo $data[0]['status_policy'] == 'Matured' ? 'selected' : ''; ?>>Matured</option>
							<option value="Active" <?php echo $data[0]['status_policy'] == 'Active' ? 'selected' : ''; ?>>Active</option>
							<option value="Lapsed" <?php echo $data[0]['status_policy'] == 'Lapsed' ? 'selected' : ''; ?>>Lapsed</option>
							<option value="Auto Surrender" <?php echo $data[0]['status_policy'] == 'Auto Surrender' ? 'selected' : ''; ?>>Auto Surrender</option>
							<option value="Reduce Paid Up" <?php echo $data[0]['status_policy'] == 'Reduce Paid Up' ? 'selected' : ''; ?>>Reduce Paid Up</option>
							<option value="Extended Term Assurance" <?php echo $data[0]['status_policy'] == 'Extended Term Assurance' ? 'selected' : ''; ?>>Extended Term Assurance</option>
							<option value="Surrendered" <?php echo $data[0]['status_policy'] == 'Surrendered' ? 'selected' : ''; ?>>Surrendered</option>
							<option value="Claim Case" <?php echo $data[0]['status_policy'] == 'Claim Case' ? 'selected' : ''; ?>>Claim Case</option>
							<option value="Not Inforce" <?php echo $data[0]['status_policy'] == 'Not Inforce' ? 'selected' : ''; ?>>Not Inforce</option>
							<option value="Terminated" <?php echo $data[0]['status_policy'] == 'Terminated' ? 'selected' : ''; ?>>Terminated</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Status of Policy is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Plan Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="plan_natureLL" name="plan_natureLL" data-placeholder="Select Plan Nature" >
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
                        <select class="form-control default-select2" id="ddlProductNameL" name="ddlProductNameL" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select Product</option>
                            <?php $product = $objProd->GetProduct(0); ?>
                            <?php foreach ($product as $products) { ?>
                                <option value="<? echo $products["id"]; ?>" <?php echo $products["id"] == $data[0]['product_id']  ? 'selected' : ''; ?>><? echo $products["fullname"] ?></option>
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
                        <select class="form-control default-select2" id="bankNameLL" name="bankNameLL" data-size="10" data-live-search="true" data-style="btn-white">
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
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameL" name="ddlDepartmentNameL" data-placeholder="Select Complaint" onchange="getcmp_type_legal();">
                            <option value="0" selected="selected" disabled>Select Department</option>
                            <?php $groups = $objUser->GetGroups(); ?>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<? echo $group["id"]; ?>" <?php echo $data[0]['group_id'] == $group["id"] ? "selected='selected'" : "" ?>><? echo $group["primary_name"]; ?></option>
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
                        <select class="form-control default-select2" id="ddlComplaintTypeL" name="ddlComplaintTypeL" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_legal();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Compalint Reported Through<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlSourceL" name="ddlSourceL" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Select Source</option>
                            <?php $source = $objProd->GetSource(0); ?>
                            <?php foreach ($source as $sources) { ?>
                                <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["fullname"] ? 'Selected' : ''; ?>><? echo $sources["fullname"] ?></option>
                            <? } ?>

                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountLL" name="txtPremiumAmountLL" class="form-control" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['premium_amount']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <!-- <div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <input type="text" id="txtRefundAmount" name="txtRefundAmount" class="form-control" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)"  value="<?php echo $data[0]['refund_amount']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div> -->
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedLL" name="txtAmountClaimedLL" class="form-control" placeholder="Enter Amount" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['claim_amount']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
			</div>
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Nominated Agent Name</label>
                        <input type="text" id="txtAgentNameL" name="txtAgentNameL" class="form-control" placeholder="Nominated Agent Name" value="<?php echo $data[0]['agent']; ?>" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Nominated Agent Name is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Agent Code</label>
                        <input type="text" id="txtAgentCode" name="txtAgentCode" class="form-control" placeholder="Enter Agent Code" value="<?php echo $data[0]['agent_code']; ?>" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Agent Code is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Unit Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtUnitName" name="txtUnitName" class="form-control" placeholder="Enter Unit Name"  onkeypress="return validateAlphabets(event)" value="<?php echo $data[0]['unit_name']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Unit Name is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
			</div>
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>AM Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtAMName" name="txtAMName" class="form-control" placeholder="Enter AM Name"  onkeypress="return validateAlphabets(event)" value="<?php echo $data[0]['am_name']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">AM Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityL" name="cityL">
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>" <?php echo $data[0]['city'] == $city["id"] ? 'selected' : ''; ?>><? echo $city["fullname"] ?></option>
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
                        <select class="form-control" id="ddlRegion" name="ddlRegion">
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
			</div>
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Nature Of Complaint</label>
                        <select class="form-control" id="ddlComplaintNature" name="ddlComplaintNature">
                            <option value="high" <?php echo $data[0]['complaint_nature'] == 'high' ? 'selected' : ''; ?>>High</option>
                            <option value="medium" <?php echo $data[0]['complaint_nature'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="low"<?php echo $data[0]['complaint_nature'] == 'low' ? 'selected' : ''; ?>>Low</option>
                        </select>

                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="complaint_log_date" value="<?php echo Date('d/m/Y',strtotime($data[0]['reported_dt'])); ?>" placeholder="Complaint Report/Log Date">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Report/Log Date is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Complaint Received Date<span style="color: red;">*</span></label>
						<input type="text" class="form-control my-datepicker" id="received_dateLL" value="<?php echo Date('d/m/Y',strtotime($data[0]['received_date'])); ?>" placeholder="Complaint Received Date">
						<span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
						<div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
					</div>
				</div>
				<div class="col-md-1">
                </div>
			</div>
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Activity Priority</label>
                        <input type="text" id="ddlPriorityL" name="ddlPriorityL" class="form-control" placeholder="Priority" disabled="disabled" value="<?php echo $data[0]['priority_id']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                <div class="col-md-3">
				<div class="form-group">
					<label>Forums<span style="color: red;">*</span></label>
					<select class="form-control default-select2" id="ddlForum" name="ddlForum">
						<option value="">Select Forum</option>
						<?php $forums = $objComplaint->GetForums(); ?>
						<?php foreach ($forums as $forum) { ?>
							<option value="<? echo $forum["id"]; ?>" <?php echo $data[0]['forum_id'] == $forum["id"] ? "selected='selected'" : "" ?>><? echo $forum["fullname"]; ?></option>
						<? } ?>
					</select>
					<div class="input-error form-control-input" style="color: Red; display: none;">Forums is required</div>
				</div>
				</div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>Policy Status<!-- <span style="color: red;">*</span> --></label>
                        <input type="text" class="form-control" name="ddlPolicyStatusL" id="ddlPolicyStatusL" value="" placeholder="Policy Status" disabled="true" value="<?php echo $data[0]['policy_status']; ?>">
                        <!-- <select class="form-control default-select2" id="ddlPolicyStatusL" name="ddlPolicyStatusL" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" disabled="disabled">Select Status</option>
                            <option value="1" selected="selected">Active</option>
                            <option value="0" >InActive</option>
                        </select> -->
                        <!-- <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div> -->
                    </div>
                </div>
				<div class="col-md-1">
                </div>
			</div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Detail Description</label>
                        <textarea placeholder="Enter Description" id="txtDescriptionL" name="txtDescriptionL" rows="6" class="form-control"><?php echo $data[0]['description']; ?></textarea>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Call Back Information</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Home</label>
                        <input type="text" id="txtCallBackL" name="txtCallBackL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11" value="<?php echo $data[0]['callback_num']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneL" name="txtHomePhoneL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['residence_phone']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileL" name="txtMobileL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['mobile_number']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneL" name="txtOfficePhoneL" class="form-control " onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12" value="<?php echo $data[0]['office_phone']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                        <input type="text" class="form-control" id="txtEmailL" name="txtEmailL" placeholder="example@mail.com" value="<?php echo $data[0]['email']; ?>">
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
                        <textarea rows="6" placeholder="Enter Address" id="txtOfficeAddressL" name="txtOfficeAddressL" class="form-control"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressL" name="txtCorrespondenceAddressL" class="form-control"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMSL" id="radio_inline_css_l3" value="1" <?php echo $data[0]['is_sms'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_l3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSL" id="radio_inline_css_l4" value="0" <?php echo $data[0]['is_sms'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_l4">
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
                        <label>Customer Mobile<span style="color: red;">*</span></label>
                        <input type="text" maxlength="12" class="form-control" id="txtResponseNumberL" name="txtResponseNumberL" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" value="<?php echo $data[0]['response_number']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Customer Mobile is empty</div>

                    </div>
                </div>

                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_l12" value="1" <?php echo $data[0]['is_call_back'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_l12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_l21" value="0" <?php echo $data[0]['is_call_back'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_l21">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" onclick="legal_cmp();" id="btnSaveComplaintLegal" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {

    });

    function get_agency_code() {
        var agency_code = $('#txtAgentNameL').val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_product.php",
            data: {
                action: "get_agency_code",
                agency_code: agency_code
            }

        }).done(function(data) {
            //alert(data);
            $('#txtAgentCode').val(data);
        });
    }


    function customer_data_legal() {
        var PolicyNumber = $('#txtPolicyNumberL').val();
        var type = 1;
        if (PolicyNumber != '') {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: {
                    action: "get_customer_data",
                    PolicyNumber: PolicyNumber,
                    type: type
                }

            }).done(function(data) {
                //alert(data);
                var res = data.split('|');
                //$('#ddlSubCat').html(data);
                $('#txtCNICL').val(res[0]);
                //$('#txtLetterComplNumber').val(PolicyNumber);
                $('#txtComplaintNameL').val(res[1]);
                $('#txtResponseNumberL').val(res[2]);
                $('#txtOfficePhoneL').val(res[3]);
                $('#txtEmailL').val(res[4]);
                $('#txtCustomerEmailL').val(res[5]);
                $('#txtMobileL').val(res[6]);
                $('#txtHomePhoneL').val(res[7]);
                $('#txtOfficeAddressL').val(res[8]);

                if (res[8] != '' || res[9] != '' || res[11] != '') {
                    $('#txtCorrespondenceAddressL').val(res[8] + " " + res[9] + " " + " " + res[11]);
                } else {
                    res[8] = "NA";
                    res[9] = "NA";
                    res[11] = "NA";

                    $('#txtCorrespondenceAddressL').val(res[8] + " " + res[9] + " " + res[11]);
                }

                $('#txtAgentNameL').val(res[12]);
                $('#txtAgentCode').val(res[13]);
                $('#ddlPolicyStatusL').val(res[14]);
            });
        }
    }
    getcmp_type_legal();
    function getcmp_type_legal() {
        debugger;
        var depart = $('#ddlDepartmentNameL').val();
        // alert(depart);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data: {
                action: "get_cmp_type",
                id: depart
            }
        }).done(function(data) {
            //alert(data);
            $('#ddlComplaintTypeL').html(data);
            $('#ddlComplaintTypeL').val('<?php echo $data[0]['complaint_type_id']; ?>').trigger('change');
        });
    }
    get_cmp_type_detail_legal();
    function get_cmp_type_detail_legal() {
        var cmptype = $('#ddlComplaintTypeL').val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_type.php",
            data: {
                action: "get_cmp_detail",
                id: cmptype
            }
        }).done(function(data) {
            //alert(data);
            var res = data.split('|');
            var $tat = res[3] + " Working Days";
            $('#cmp_userL').val(res[0]);
            $('#cmp_user_groupL').val(res[1]);
            $('#ddlPriorityL').val(res[2]);
            $('#txtComplaintTATL').val($tat);
            //$('#type').val(res[4]);
            $('#modeL').val(res[5]);
        });
    }

    function legal_cmp() {
        var complaintId = $('#txtId').val();
        var complaintNum = $('#complaint_num').val();
        var mode = $('#modeL').val();
        var txtCNIC = $('#txtCNICL').val();

        var policy_issuance_date=$('#policy_issuance_dateLL').val();
        var status_of_policy=$('#status_of_policyLL').val();
        var plan_nature = $('#plan_natureLL').val();
        var bank =  $('#bankNameLL').val();
        var received_date = $('#received_dateLL').val();


        var txtPremiumAmount = $('#txtPremiumAmountLL').val();
        // var txtRefundAmount = $('#txtRefundAmount').val();
        var txtRefundAmount =0;
        var txtAmountClaimed = $('#txtAmountClaimedLL').val();
        var txtAgentNameL = $('#txtAgentNameL').val();
        var txtAgentCode = $('#txtAgentCode').val();
        var txtUnitName = $('#txtUnitName').val();
        var txtAMName = $('#txtAMName').val();
        var ddlRegion = $('#ddlRegion').val();
        var reported_dt = $('#complaint_log_date').val();
        // var poccured = $('#datepicker-autoClose1').val();
        var ddlPolicyStatusL = $('#ddlPolicyStatusL').val();
        var ddlComplaintNature = $('#ddlComplaintNature').val();
        var cityL = $('#cityL').val();
        var ddlReportedByL = $('#ddlReportedByL').val();

        var txtPolicyNumber = $('#txtPolicyNumberL').val();
        var txtLetterComplNumber = $('#txtLetterComplNumber').val();
        var txtComplaintName = $('#txtComplaintNameL').val();
        var ddlProductName = $('#ddlProductNameL').val();
        var ddlSource = $('#ddlSourceL').val();
        var ddlDepartmentName = $('#ddlDepartmentNameL').val();
        var ddlPriority = $('#ddlPriorityL').val();
        var ddlComplaintType = $('#ddlComplaintTypeL').val();
        var txtComplaintTAT = $('#txtComplaintTATL').val();
        var txtDescription = $('#txtDescriptionL').val();

        var ddlForum = $('#ddlForum').val();

        var txtCallBack = $('#txtCallBackL').val();
        var txtHomePhone = $('#txtHomePhoneL').val();
        var txtMobile = $('#txtMobileL').val();
        var txtOfficePhone = $('#txtOfficePhoneL').val();
        var txtEmail = $('#txtEmailL').val();
        var txtOfficeAddress = $('#txtOfficeAddressL').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddressL').val();
        var txtCustomerEmail = $('#txtCustomerEmailL').val();
        var txtResponseNumber = $('#txtResponseNumberL').val();
        var type = $('#typeL').val();
        var cmp_user = $('#cmp_userL').val();
        var cmp_user_group = $('#cmp_user_groupL').val();
        var rdEmail = $('input[name=rdEmailL]:checked').val();
        var rdSMS = $('input[name=rdSMSL]:checked').val();
        var rdCallBack = $('input[name=rdCallBackL]:checked').val();
        var action = $('#actionL').val();

        //alert(ddlForum); return false;
        // $("#btnSaveComplaintLegal").button('loading');

        if (validation_legal()) {
            $("#btnSaveComplaintLegal").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data: {
                    'action': action,
                    'complaintId'       : complaintId,
                    'complaintNum'      : complaintNum,
                    'mode': mode,
                    'txtCNIC': txtCNIC,
                    'policy_issuance_date': policy_issuance_date,
                    'status_of_policy': status_of_policy,
                    'plan_nature': plan_nature,
                    'bank': bank,
                    'received_date': received_date,
                    'txtLetterComplNumber': txtLetterComplNumber,
                    'txtPolicyNumber': txtPolicyNumber,
                    'txtComplainerName': txtComplaintName,
                    'ddlProductName': ddlProductName,
                    'ddlSource': ddlSource,
                    'ddlDepartmentName': ddlDepartmentName,
                    'priority': ddlPriority,
                    'ddlComplaintType': ddlComplaintType,
                    'txtComplaintTAT': txtComplaintTAT,
                    'txtDescription': txtDescription,
                    'ddlForum': ddlForum,
                    'txtCallBack': txtCallBack,
                    'txtHomePhone': txtHomePhone,
                    'txtMobile': txtMobile,
                    'txtOfficePhone': txtOfficePhone,
                    'txtEmail': txtEmail,
                    'txtOfficeAddress': txtOfficeAddress,
                    'txtCorrespondenceAddress': txtCorrespondenceAddress,
                    'txtCustomerEmail': txtCustomerEmail,
                    'txtResponseNumber': txtResponseNumber,
                    'type': type,
                    'cmp_user': cmp_user,
                    'cmp_user_group': cmp_user_group,
                    'rdEmail': rdEmail,
                    'rdSMS': rdSMS,
                    'rdCallBack': rdCallBack,
                    'txtPremiumAmount': txtPremiumAmount,
                    'txtRefundAmount': txtRefundAmount,
                    'txtAmountClaimed': txtAmountClaimed,
                    'txtAgentNameL': txtAgentNameL,
                    'txtAgentCode': txtAgentCode,
                    'txtUnitName': txtUnitName,
                    'txtAMName': txtAMName,
                    'ddlRegion': ddlRegion,
                    'reported_dt': reported_dt,
                    'ddlPolicyStatusL': ddlPolicyStatusL,
                    'ddlComplaintNature': ddlComplaintNature,
                    'cityL': cityL,
                    'ddlReportedByL': ddlReportedByL
                },
                success: function(data) {
                    //alert(data);
                    console.log(data);
                    $("#btnSaveComplaintLegal").button('reset');

                    var result = data.split("|");
                    getid = result[1];
                    var message = "Complaint updated successfully with Complaint Id <strong>";
                    var tempdata = data.split("|");

                    if (result[0] == 'success') {
                        $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "success", html: message +  tempdata[3] + "</strong>", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () {
                                window.location.href = "complaint_views.php";
                            }, 3000);
                        // $('#ModalCommentL').modal({
                        //     backdrop: 'static',
                        //     keyboard: false
                        // });
                        // $('#ModalCommentL').modal('show');
                        // $('#complaint_id_mainL').val(result[1]);
                        // $('#type_mainL').val(result[2]);
                        // $('#counter_displayL').val(result[3]);
                        // return false;
                    } else if (data == 'fail') {
                        $('html, body').animate({
                            scrollTop: 0
                        }, 600);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 600);
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
    }

    function validation_legal() {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        // Policy Number OK
        if ($('#txtPolicyNumberL').val() == '') {
            $('#txtPolicyNumberL').addClass('error-val');
            $('#txtPolicyNumberL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPolicyNumberL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtPolicyNumberL').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#txtPolicyNumberL').parent().find('.input-error').hide();
        }

        // CNIC/NICOP OK
        if($('#txtCNICL').val() == "") 
        {
            $('#txtCNICL').addClass('error-val');
            $('#txtCNICL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNICL').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCNICL').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNICL').parent().find('.input-error').hide();
        }
        if($('#policy_issuance_dateLL').val() == '') 
        {
            $('#policy_issuance_dateLL').addClass('error-val');
            $('#policy_issuance_dateLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#policy_issuance_dateLL').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#policy_issuance_dateLL').removeClass('error-val');
            //$('#policy_issuance_dateLL').parents('.control-group').addClass('success');
            $('#policy_issuance_dateLL').parent().find('.input-error').hide();
        }

        if($('#plan_natureLL').val() == '0') 
        {
            $('#plan_natureLL').addClass('error-val');
            $('#plan_natureLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#plan_natureLL').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#plan_natureLL').removeClass('error-val');
            //$('#plan_natureLL').parents('.control-group').addClass('success');
            $('#plan_natureLL').parent().find('.input-error').hide();
        }

        if($('#received_dateLL').val() == '') 
        {
            $('#received_dateLL').addClass('error-val');
            $('#received_dateLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_dateLL').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#received_dateLL').removeClass('error-val');
            //$('#received_dateLL').parents('.control-group').addClass('success');
            $('#received_dateLL').parent().find('.input-error').hide();
        }

        if ($('#txtLetterComplNumber').val() == "") {
            $('#txtLetterComplNumber').addClass('error-val');
            $('#txtLetterComplNumber').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtLetterComplNumber').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtLetterComplNumber').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtLetterComplNumber').parent().find('.input-error').hide();
        }

        // Customer Name OK
        if ($('#ddlDepartmentNameL').val() == null) {
            $('#ddlDepartmentNameL').addClass('error-val');
            $('#ddlDepartmentNameL').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameL').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlDepartmentNameL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlDepartmentNameL').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
            $('#ddlDepartmentNameL').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlDepartmentNameL').parent().find('.input-error').hide();
        }

        // Source OK
        if ($('#ddlSourceL').val() == null) {
            $('#ddlSourceL').addClass('error-val');
            $('#ddlSourceL').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSourceL').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlSourceL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlSourceL').removeClass('error-val');
            $('#ddlSourceL').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSourceL').parent().find('.input-error').hide();
        }

        if ($('#ddlProductNameL').val() == '') {
            $('#ddlProductNameL').addClass('error-val');
            $('#ddlProductNameL').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductNameL').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlProductNameL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlProductNameL').removeClass('error-val');
            $('#ddlProductNameL').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlProductNameL').parent().find('.input-error').hide();
        }

        if ($('#ddlComplaintTypeL').val() == 0 || $('#ddlComplaintTypeL').val() == null) {
            $('#ddlComplaintTypeL').addClass('error-val');
            $('#ddlComplaintTypeL').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeL').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlComplaintTypeL').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeL').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintTypeL').parent().find('.input-error').hide();
        }

        if ($('#ddlProductNameL').val() == '') {
            $('#ddlProductNameL').addClass('error-val');
            $('#ddlProductNameL').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductNameL').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlProductNameL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlProductNameL').removeClass('error-val');
            $('#ddlProductNameL').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlProductNameL').parent().find('.input-error').hide();
        }

        if ($('#txtAMName').val() == "") {
            $('#txtAMName').addClass('error-val');
            $('#txtAMName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtAMName').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtAMName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtAMName').parent().find('.input-error').hide();
        }

        if ($('#complaint_log_date').val() == "") {
            $('#complaint_log_date').addClass('error-val');
            $('#complaint_log_date').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#complaint_log_date').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#complaint_log_date').removeClass('error-val');
            //$('#complaint_log_date').parents('.control-group').addClass('success');
            $('#complaint_log_date').parent().find('.input-error').hide();
        }

        // if ($('#datepicker-autoClose1').val() == "") {
        //     $('#datepicker-autoClose1').addClass('error-val');
        //     $('#datepicker-autoClose1').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) {
        //         $('#datepicker-autoClose1').focus();
        //         hasFocus = true;
        //     }

        //     errCount++;
        // } else {
        //     $('#datepicker-autoClose1').removeClass('error-val');
        //     //$('#datepicker-autoClose1').parents('.control-group').addClass('success');
        //     $('#datepicker-autoClose1').parent().find('.input-error').hide();
        // }

        // if ($('#txtEmailL').val() != '' && email.test($('#txtEmailL').val()) == false) {
        //     $('#txtEmailL').addClass('error-val');
        //     $('#txtEmailL').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) {
        //         $('#txtEmailL').focus();
        //         hasFocus = true;
        //     }

        //     errCount++;
        // } else {
        //     $('#txtEmailL').removeClass('error-val');
        //     //$('#txtUserId').parents('.control-group').addClass('success');
        //     $('#txtEmailL').parent().find('.input-error').hide();
        // }

        if ($('#txtAmountClaimedLL').val() == "") {
            $('#txtAmountClaimedLL').addClass('error-val');
            $('#txtAmountClaimedLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtAmountClaimedLL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtAmountClaimedLL').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtAmountClaimedLL').parent().find('.input-error').hide();
        }

        if ($('#txtPremiumAmountLL').val() == "") {
            $('#txtPremiumAmountLL').addClass('error-val');
            $('#txtPremiumAmountLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtPremiumAmountLL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtPremiumAmountLL').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtPremiumAmountLL').parent().find('.input-error').hide();
        }

        /*if($('#txtRefundAmount').val() == "") 
        {
            $('#txtRefundAmount').addClass('error-val');
            $('#txtRefundAmount').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtRefundAmount').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtRefundAmount').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtRefundAmount').parent().find('.input-error').hide();
        }*/

        if ($('#txtUnitName').val() == "") {
            $('#txtUnitName').addClass('error-val');
            $('#txtUnitName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtUnitName').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtUnitName').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtUnitName').parent().find('.input-error').hide();
        }

        // Forum Name
        if ($('#ddlForum').val() == '') {
            $('#ddlForum').addClass('error-val');
            $('#ddlForum').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlForum').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlForum').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#ddlForum').removeClass('error-val');
            $('#ddlForum').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlForum').parent().find('.input-error').hide();
        }

        if ($('#txtCorrespondenceAddressL').val() == '') {
            $('#txtCorrespondenceAddressL').addClass('error-val');
            $('#txtCorrespondenceAddressL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddressL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#txtCorrespondenceAddressL').removeClass('error-val');
            //$('#txtCorrespondenceAddressL').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddressL').parent().find('.input-error').hide();
        }

        if($('#txtEmailL').val() == "") 
        {
            $('#txtEmailL').addClass('error-val');
            $('#txtEmailL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmailL').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmailL').removeClass('error-val');
            //$('#txtEmailL').parents('.control-group').addClass('success');
            $('#txtEmailL').parent().find('.input-error').hide();
        }

        if($('#txtResponseNumberL').val() == "") 
        {
            $('#txtResponseNumberL').addClass('error-val');
            $('#txtResponseNumberL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResponseNumberL').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResponseNumberL').removeClass('error-val');
            //$('#txtResponseNumberL').parents('.control-group').addClass('success');
            $('#txtResponseNumberL').parent().find('.input-error').hide();
        }

        if (errCount > 0) {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
            return false;
        } else
            return true;
    }
</script>