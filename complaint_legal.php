<?php
$objProd = new Product();
$objComplaint = new Complaint();
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintLegal">
        <input type="hidden" id="txtId" name="txtId" value="">
        <input type="hidden" id="actionL" name="actionL" value="save_complaint">
        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<? //echo $counter_display; 
                                                                                    ?>" />
        <input type="hidden" name="typeL" id="typeL" value="legal" />
        <input type="hidden" name="cmp_userL" id="cmp_userL" value="" />
        <input type="hidden" name="cmp_user_groupL" id="cmp_user_groupL" value="" />
        <input type="hidden" name="modeL" id="modeL" value="" />
        <!-- <input type="hidden" name="txtCNICL" id="txtCNICL" value="" /> -->
        <input type="hidden" name="txtComplaintTATL" id="txtComplaintTATL" value="" />
        <input type="hidden" name="txtCounter" id="txtCounter" value="<? //echo $counter; 
                                                                        ?>" />
        <input type="hidden" id="txtComplaintNo" name="txtComplaintNo" class="form-control" value="<? //echo $counter_display; 
                                                                                                    ?>">

        <fieldset>
            <legend>Complaint Legal</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <!-- <input type="text" id="txtPolicyNumberL" name="txtPolicyNumberL" class="form-control" placeholder="Policy Number" value="" onblur="customer_data_legal();"> -->
                        <input type="text" id="txtPolicyNumberL" name="txtPolicyNumberL" class="form-control" placeholder="Policy Number" value="" onblur="customer_data_legal();">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Name</label>
                        <input type="text" id="txtComplaintNameL" name="txtComplaintNameL" class="form-control" placeholder="Complaint Name" onchange="get_cmp_type_detail_legal();">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Name is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICL" name="txtCNICL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Letter/Complaint No.<span style="color: red;">*</span></label>
                        <input type="text" id="txtLetterComplNumber" name="txtLetterComplNumber" class="form-control" placeholder="Enter Letter/Complaint Number" value="">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Letter/Complaint Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateLL" id="policy_issuance_dateLL" placeholder="Pick Preferable Date and Time" tabindex="13" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="status_of_policyLL" name="status_of_policyLL" data-placeholder="Select Plan Nature" >
                            <option value="0" selected="selected" disabled>Select Status of Policy</option>
                            <option value="Cancelled" >Cancelled</option>
							<option value="Matured" >Matured</option>
							<option value="Active" >Active</option>
							<option value="Lapsed" >Lapsed</option>
							<option value="Auto Surrender" >Auto Surrender</option>
							<option value="Reduce Paid Up" >Reduce Paid Up</option>
							<option value="Extended Term Assurance" >Extended Term Assurance</option>
							<option value="Surrendered" >Surrendered</option>
							<option value="Claim Case" >Claim Case</option>
							<option value="Not Inforce" >Not Inforce</option>
							<option value="Terminated" >Terminated</option>
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
                            <option value="Unit Linked" >Unit Linked</option>
                            <option value="Term Life" > Term Life</option>
                            <option value="Saving" >Saving</option>
                            <option value="Group" >Group</option>
                            <option value="Accidential" >Accidential</option>
                            <option value="Others" >Others</option>
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
                                <option value="<? echo $products["id"]; ?>"><? echo $products["fullname"] ?></option>
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
                                <option value="Al Baraka">Al Baraka</option>
                                <option value="Bank Alfalah">Bank Alfalah</option>
								<option value="Dubai Islamic Bank">Dubai Islamic Bank</option>
								<option value="MCB">MCB</option>
								<option value="Samba">Samba</option>
								<option value="SCB">SCB</option>
								<option value="Soneri Bank">Soneri Bank</option>
								<option value="Silk Bank">Silk Bank</option>
								<option value="UBL">UBL</option>
								<option value="HBL">HBL</option>
								<option value="Summit Bank">Summit Bank</option>
								<option value="Makramah Bank">Makramah Bank</option>
								<option value="Faysal Bank">Faysal Bank</option>
								<option value="BOP">BOP</option>
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
                                <option value="<? echo $sources["id"]; ?>"><? echo $sources["fullname"] ?></option>
                            <? } ?>

                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
            </div>

            
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountLL" name="txtPremiumAmountLL" class="form-control" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss</label>
                        <input type="text" id="txtRefundAmount" name="txtRefundAmount" class="form-control" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)" disabled>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedLL" name="txtAmountClaimedLL" class="form-control" placeholder="Enter Amount" onkeypress="return validateNumbers(event)">
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
                        <input type="text" id="txtAgentNameL" name="txtAgentNameL" class="form-control" placeholder="Nominated Agent Name" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Nominated Agent Name is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Agent Code</label>
                        <input type="text" id="txtAgentCode" name="txtAgentCode" class="form-control" placeholder="Enter Agent Code" value="" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Agent Code is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Unit Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtUnitName" name="txtUnitName" class="form-control" placeholder="Enter Unit Name" value="" onkeypress="return validateAlphabets(event)">
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
                        <input type="text" id="txtAMName" name="txtAMName" class="form-control" placeholder="Enter AM Name" value="" onkeypress="return validateAlphabets(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">AM Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityLL" name="cityLL">
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>"><? echo $city["fullname"] ?></option>
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
                        <select class="form-control" id="ddlRegionL" name="ddlRegionL">
                            <option value="south" selected="true">South</option>
                            <option value="east">East</option>
                            <option value="central">Central</option>
                            <option value="north">North</option>
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
                            <option value="high" selected="true">High</option>
                            <option value="medium" selected="true">Medium</option>
                            <option value="low">Low</option>
                        </select>

                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control  my-datepicker" id="datetimepicker12222" value="" placeholder="Complaint Report/Log Date">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Report/Log Date is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Complaint Received Date<span style="color: red;">*</span></label>
						<input type="text" class="form-control my-datepicker" id="received_dateLL" value="" placeholder="Complaint Received Date">
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
                        <input type="text" id="ddlPriorityL" name="ddlPriorityL" class="form-control" placeholder="Priority" disabled="disabled">
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
                        <input type="text" class="form-control" name="ddlPolicyStatusL" id="ddlPolicyStatusL" value="" placeholder="Policy Status" disabled="true">
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

            <!-- <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Problem Occured<span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="datepicker-autoClose1" value="" placeholder="Problem Occured">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Problem Occured Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div> -->

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Detail Description</label>
                        <textarea placeholder="Enter Description" id="txtDescriptionL" name="txtDescriptionL" rows="6" class="form-control"></textarea>
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
                        <input type="text" id="txtCallBackL" name="txtCallBackL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneL" name="txtHomePhoneL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileL" name="txtMobileL" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneL" name="txtOfficePhoneL" class="form-control " onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                        <input type="text" class="form-control" id="txtEmailL" name="txtEmailL" placeholder="example@mail.com">
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
                        <textarea rows="6" placeholder="Enter Address" id="txtOfficeAddressL" name="txtOfficeAddressL" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressL" name="txtCorrespondenceAddressL" class="form-control"></textarea>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Correspondence Address is required</div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Acknowledge Response</legend>
            <div class="col-md-12">
                <div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdEmailL" id="radio_inline_css_l1" value="1">
                                <label for="radio_inline_css_l1">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdEmailL" id="radio_inline_css_l2" value="0" checked="true">
                                <label for="radio_inline_css_l2">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1">
                </div> -->
                <div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>Customer Email</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtCustomerEmailL" name="txtCustomerEmailL" placeholder="abc@example.com">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <span class="input-group-addon">@</span>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1">
                </div> -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SMS</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdSMSL" id="radio_inline_css_l3" value="1">
                                <label for="radio_inline_css_l3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSL" id="radio_inline_css_l4" value="0" checked="true">
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
                        <input type="text" maxlength="12" class="form-control" id="txtResponseNumberL" name="txtResponseNumberL" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX">
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
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_l12" value="1">
                                <label for="radio_inline_css_l12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackL" id="radio_inline_css_l21" value="0" checked="true">
                                <label for="radio_inline_css_l21">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="col-md-12">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer Mobile</label>
                            <input type="text" maxlength="12" class="form-control number" id="txtResponseNumberL" name="txtResponseNumberL" onkeypress="return validateNumbers(event)" placeholder="92-XXXXXXXXXX">
                        </div>
                    </div>

                    <div class="col-md-1">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Call Back</label>
                            <div>
                                <div class="radio radio-css radio-inline radio-success">
                                    <input type="radio" name="rdCallBackL" id="radio_inline_css_l12" value="1" >
                                    <label for="radio_inline_css_l12">
                                        Yes
                                    </label>
                                </div>

                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="rdCallBackL" id="radio_inline_css_l21" value="0" checked="true">
                                    <label for="radio_inline_css_l21">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> 
            </div>-->
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" onclick="legal_cmp();" id="btnSaveComplaintLegal" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    .select2-container--default {
        width: 260px !important;
    }
</style>

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

    /*function customer_data_legal(){

        var PolicyNumber = $('#txtPolicyNumberL').val();
           /* $.ajax({
                type: "POST",
                url: "includes/ajax/action_customer_data.php",
                data:{
                    action : "get_customer_data",
                    id: PolicyNumber
                }

            }).done(function (data) {
                //alert(data);
                $('#ddlSubCat').html(data);
            });
            //$('#txtCNIC').html(PolicyNumber);
            $('#txtCNICL').val('42501-9346322-7');
            $('#txtLetterComplNumber').val(PolicyNumber);
            $('#txtComplaintNameL').val('Haroon Saeed');
            $('#txtResponseNumberL').val('923333985446');
            $('#txtOfficePhoneL').val('02130000000');
            $('#txtEmailL').val('haroon.ssuet@gmail.com');
            $('#txtCustomerEmailL').val('haroon.ssuet@gmail.com');
            $('#txtMobileL').val('923333985446');
            $('#txtHomePhoneL').val('02130000000');
            $('#txtOfficeAddressL').val('Room # 123, xyz Building ABC Road Karachi');
            $('#txtCorrespondenceAddressL').val('Room # 123, xyz Building ABC Road Karachi');
            //$('#txtCustomerName').html(PolicyNumber);
        //  $('#ddlSubCat').html(PolicyNumber);
    //alert(PolicyNumber);
    }*/

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

    function getcmp_type_legal() {
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
        });
    }

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
        var mode = $('#modeL').val();
        var txtCNIC = $('#txtCNICL').val();

        var policy_issuance_date=$('#policy_issuance_dateLL').val();
        var status_of_policy=$('#status_of_policyLL').val();
        var plan_nature = $('#plan_natureLL').val();
        var bank =  $('#bankNameLL').val();
        var received_date = $('#received_dateLL').val();


        var txtPremiumAmount = $('#txtPremiumAmountLL').val();
        var txtRefundAmount = $('#txtRefundAmount').val();
        var txtAmountClaimed = $('#txtAmountClaimedLL').val();
        var txtAgentNameL = $('#txtAgentNameL').val();
        var txtAgentCode = $('#txtAgentCode').val();
        var txtUnitName = $('#txtUnitName').val();
        var txtAMName = $('#txtAMName').val();
        var ddlRegion = $('#ddlRegionL').val();
        var reported_dt = $('#datetimepicker12222').val();
        // var poccured = $('#datepicker-autoClose1').val();
        var ddlPolicyStatusL = $('#ddlPolicyStatusL').val();
        var ddlComplaintNature = $('#ddlComplaintNature').val();
        var cityL = $('#cityLL').val();
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
                    // 'poccured': poccured,
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

                    if (result[0] == 'success') {
                        $('#ModalCommentL').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#ModalCommentL').modal('show');
                        $('#complaint_id_mainL').val(result[1]);
                        $('#type_mainL').val(result[2]);
                        $('#counter_displayL').val(result[3]);
                        return false;
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
        if ($('#status_of_policyLL').val() == null) {
            $('#status_of_policyLL').addClass('error-val');
            $('#status_of_policyLL').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#status_of_policyLL').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#status_of_policyLL').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#status_of_policyLL').parent().find('.input-error').hide();
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

        if ($('#datetimepicker1').val() == "") {
            $('#datetimepicker1').addClass('error-val');
            $('#datetimepicker1').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#datetimepicker1').focus();
                hasFocus = true;
            }

            errCount++;
        } else {
            $('#datetimepicker1').removeClass('error-val');
            //$('#datetimepicker1').parents('.control-group').addClass('success');
            $('#datetimepicker1').parent().find('.input-error').hide();
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