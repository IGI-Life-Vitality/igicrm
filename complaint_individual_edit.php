<?php
    $objProd = new Product();
    $objComplaint = new Complaint();
    $data                   = $objComplaint->GetComplaintById($id,$cmode); 
    // print_r($data);
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintIndividual">
        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>" />
        <input type="hidden" id="action" name="action" value="edit_complaint" />
        <input type="hidden" name="cmode" id="cmode" value="<?php echo($data[0]['type']); ?>" />
        <input type="hidden" name="user_id" id="user_id" value="<?php echo($data[0]['user_id']); ?>" />
        <input type="hidden" name="cmp_invalid" id="cmp_invalid" value="<?php if($data[0]['status_id'] == 5){echo '1';}else{echo '0';} ?>" />
        <input type="hidden" name="user_id_ressign" id="user_id_ressign" value="0" />
        <input type="hidden" name="is_manual" id="is_manual" value="1" />
        <input type="hidden" name="status" id="status" value="<?php echo $data[0]['status_id'];?>" />
        <input type="hidden" name="mode" id="mode" value="" />
        <input type="hidden" name="cmp_user_group" id="cmp_user_group" value="" />
        <input type="hidden" name="complaint_num" id="complaint_num" value="<?php echo $data[0]['complaint_num'];?>" />

        <fieldset>
            <legend>Complaint Individual</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumber" name="txtPolicyNumber" class="form-control" placeholder="Policy Number" value="<?php echo $data[0]['policy_num']; ?>" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policyholder Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtCustomerName" name="txtCustomerName" class="form-control" placeholder="Policyholder Name" value="<?php echo $data[0]['customer_name']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNIC" name="txtCNIC" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['cnic']; ?>" placeholder="42201XXXXXXXX" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control date my-datepicker" name="policy_issuance_date" id="policy_issuance_date" value="<?php echo Date('d/m/Y',strtotime($data[0]['policy_issuance_date'])); ?>" placeholder="Pick Preferable Date and Time" tabindex="13" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy</label>
                        <select class="form-control default-select2" id="status_of_policy" name="status_of_policy" data-placeholder="Select Plan Nature" >
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
				
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Plan Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="plan_nature" name="plan_nature" data-placeholder="Select Plan Nature" >
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
                        <select class="form-control default-select2" id="ddlProductName" name="ddlProductName" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Select Product</option>
                            <?php $product = $objProd->GetProduct(0); ?>
                            <?php foreach($product as $products){ 
                                if($products["fullname"] != "Vitality"){?>
                                <option value="<? echo $products["id"]; ?>" <?php echo $products["id"] == $data[0]['product_id']  ? 'selected' : ''; ?>><? echo $products["fullname"] ?></option>
                            <? } }?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <select class="form-control default-select2" id="bankName" name="bankName" data-size="10" data-live-search="true" data-style="btn-white">
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
						<select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName" data-placeholder="Select Complaint" onchange="getcmp_type_ind();">
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
                        <select class="form-control default-select2" id="ddlComplaintType" name="ddlComplaintType" data-placeholder="Select Complaint Type" onchange="get_cmp_type_indvl_dtl();">
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
                        <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Select Source</option>
                            <?php $source = $objProd->GetSource(0); ?>
                            <?php foreach($source as $sources){ ?>
                             <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["fullname"] ? 'Selected' : ''; ?> ><? echo $sources["fullname"] ?></option>
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
                        <input type="text" id="txtPremiumAmount" name="txtPremiumAmount" class="form-control" placeholder="Enter Premium Amount" value="<?php echo $data[0]['premium_amount']; ?>" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- <div class="col-md-3" style="display: none;">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss<span style="color: red;">*</span></label>
                        <input type="text" id="txtRefundAmount" name="txtRefundAmount" class="form-control" placeholder="Enter Refund Amount" value="<?php echo $data[0]['refund_amount']; ?>" onkeypress="return validateNumbers(event)" >
                    </div>
                </div>
				<div class="col-md-1">
                </div> -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimed" name="txtAmountClaimed" class="form-control" placeholder="Enter Amount" value="<?php echo $data[0]['claim_amount']; ?>" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
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
			</div>
            <div class="col-md-12">
					<div class="col-md-3">
						<div class="form-group">
							<label>Region</label>
							<select class="form-control" id="ddlRegion" name="ddlRegion">
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
                            <input type="text" class="form-control my-datepicker" id="reported_dt" value="<?php echo Date('d/m/Y',strtotime($data[0]['reported_dt'])); ?> " placeholder="Complaint Received Date">
                            <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                            <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Complaint Received Date<span style="color: red;">*</span></label>
                            <input type="text" class="form-control my-datepicker" id="received_date" value="<?php echo Date('d/m/Y',strtotime($data[0]['received_date'])); ?> " placeholder="Complaint Received Date">
                            <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                            <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                        </div>
                    </div>
            </div>

            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriority" name="ddlPriority" class="form-control" placeholder="Priority" disabled="disabled">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTAT" name="txtComplaintTAT" class="form-control" placeholder="Complaint TAT" disabled="disabled">
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescription" name="txtDescription" rows="6" class="form-control"><?php echo $data[0]['description']; ?></textarea>
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
                        <input type="text" id="txtCallBack" name="txtCallBack" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['residence_phone']; ?>" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhone" name="txtHomePhone" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['callback_num']; ?>" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobile" name="txtMobile" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12" value="<?php echo $data[0]['mobile_number']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhone" name="txtOfficePhone" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12" value="<?php echo $data[0]['office_phone']; ?>">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="example@mail.com" value="<?php echo $data[0]['email']; ?>">
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
                        <textarea rows="6" placeholder="Office Address" id="txtOfficeAddress" name="txtOfficeAddress" class="form-control"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddress" name="txtCorrespondenceAddress" class="form-control"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMS" id="radio_inline_css_3" value="1" <?php echo $data[0]['is_sms'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMS" id="radio_inline_css_4" value="0" <?php echo $data[0]['is_sms'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1">
                </div> -->

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Mobile<span style="color: red;">*</span></label>
                        <input type="text" maxlength="12" class="form-control" id="txtResponseNumber" name="txtResponseNumber" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" value="<?php echo $data[0]['response_number']; ?>" >
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
                                <input type="radio" name="rdCallBack" id="radio_inline_css_12" value="1" <?php echo $data[0]['is_call_back'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBack" id="radio_inline_css_21" value="0" <?php echo $data[0]['is_call_back'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_21">
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
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintIndividual"  onclick ="individual_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." >Update</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    
   
    function customer_data()
    {
        var PolicyNumber = $('#txtPolicyNumber').val();
        var type = 1;

        if(PolicyNumber != '')
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:
                {
                    action : "get_customer_data",
                    PolicyNumber: PolicyNumber,
                    type : type
                }
            }).done(function (data) {
                    //alert(data);
                    var res = data.split('|');
                    //$('#ddlSubCat').html(data);
                    $('#txtCNIC').val(res[0]);
                    $('#txtCustomerName').val(res[1]);
                    $('#txtResponseNumber').val(res[2]);
                    $('#txtOfficePhone').val(res[3]);
                    $('#txtEmail').val(res[4]);
                    $('#txtCustomerEmail').val(res[5]);
                    $('#txtMobile').val(res[6]);
                    $('#txtHomePhone').val(res[7]);
                    $('#txtOfficeAddress').val(res[8]);
                    
                    if(res[8] != '' || res[9] != '' || res[11] != '')
                    {
                        $('#txtCorrespondenceAddress').val(res[8] + " " + res[9] + " " + " " + res[11]);
                    }
                    else
                    {
                        res[8] = "NA";
                        res[9] = "NA";
                        res[11] = "NA";

                        $('#txtCorrespondenceAddress').val(res[8] + " " + res[9] + " " + res[11]);
                    }
            });
        }
    }
    getcmp_type_ind();
    function getcmp_type_ind()
    {
        var depart = $('#ddlDepartmentName').val();
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
            $('#ddlComplaintType').html(data);
            $('#ddlComplaintType').val('<?php echo $data[0]['complaint_type_id']; ?>').trigger('change');
        });
    }
    get_cmp_type_indvl_dtl();
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
             $('#mode').val(res[5]);
        });
    }

    function individual_cmp()
    {
        
        var complaintId = $('#txtId').val();
        var complaintNum = $('#complaint_num').val();
        var mode = $('#mode').val();
        var txtCNIC = $('#txtCNIC').val();
        var txtPolicyNumber = $('#txtPolicyNumber').val();
        var txtCustomerName = $('#txtCustomerName').val();
        var policy_issuance_date=$('#policy_issuance_date').val();
        var status_of_policy=$('#status_of_policy').val();
        var plan_nature = $('#plan_nature').val();
        var bank =  $('#bankName').val();
        var txtPremiumAmount = $('#txtPremiumAmount').val();
        // var txtRefundAmount = $('#txtRefundAmount').val();
        var txtRefundAmount = 0;
        var txtAmountClaimed = $('#txtAmountClaimed').val();
        var ddlRegion = $('#ddlRegion').val();
        var cityL = $('#cityL').val();
        var reported_dt = $('#reported_dt').val();
        var received_date = $('#received_date').val();
        var ddlProductName = $('#ddlProductName').val();
        var ddlSource = $('#ddlSource').val(); 
        var ddlDepartmentName = $('#ddlDepartmentName').val();
        var ddlPriority = $('#ddlPriority').val();
        var ddlComplaintType = $('#ddlComplaintType').val();
        var txtComplaintTAT = $('#txtComplaintTAT').val();
        var txtDescription = $('#txtDescription').val();
        var txtCallBack = $('#txtCallBack').val();
        var txtHomePhone = $('#txtHomePhone').val();
        var txtMobile = $('#txtMobile').val();
        var txtOfficePhone = $('#txtOfficePhone').val();
        var txtEmail = $('#txtEmail').val();
        var txtOfficeAddress = $('#txtOfficeAddress').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddress').val();
        var txtCustomerEmail = $('#txtCustomerEmail').val();
        var txtResponseNumber = $('#txtResponseNumber').val();
        var type =  $('#cmode').val();
        var cmp_user = $('#cmp_user').val();
        var cmp_user_group = $('#cmp_user_group').val();
        var rdEmail = $('input[name=rdEmail]:checked').val();
        var rdSMS = $('input[name=rdSMS]:checked').val();
        var rdCallBack = $('input[name=rdCallBack]:checked').val();
        var action = $('#action').val();

        if(validation_ind())
        {
            $("#btnSaveComplaintIndividual").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:
                {
                    'complaintId'            : complaintId,
                    'complaintNum'            : complaintNum,
                    'action'            : action,
                    'mode'              : mode,
                    'txtCNIC'           : txtCNIC,
                    'txtPolicyNumber'   : txtPolicyNumber,
                    'txtCustomerName'   : txtCustomerName,
                    'policy_issuance_date'   : policy_issuance_date,
                    'status_of_policy'    : status_of_policy,
                    'plan_nature'       : plan_nature,
                    'bank'              : bank,
                    'txtPremiumAmount'  : txtPremiumAmount,
                    'txtRefundAmount'  : txtRefundAmount,
                    'txtAmountClaimed'  : txtAmountClaimed,
                    'ddlRegion'  : ddlRegion,
                    'cityL'  : cityL,
                    'reported_dt'  : reported_dt,
                    'received_date'  : received_date,
                    'ddlProductName'    : ddlProductName,
                    'ddlSource'         : ddlSource,
                    'ddlDepartmentName' : ddlDepartmentName,
                    'priority'          : ddlPriority,
                    'ddlComplaintType'  : ddlComplaintType,
                    'txtComplaintTAT'   : txtComplaintTAT,
                    'txtDescription'    : txtDescription,
                    'txtCallBack'       : txtCallBack,
                    'txtHomePhone'      : txtHomePhone,
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
                    var result  = data.split("|");
                    getid       = result[1];
                    var message = "Complaint updated successfully with Complaint Id <strong>";
                    var tempdata = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "success", html: message +  tempdata[3] + "</strong>", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () {
                            window.location.href = "complaint_views.php";
                        }, 3000);
                        // $('#ModalComment').modal({backdrop: 'static', keyboard: false});
                        // $('#ModalComment').modal('show');
                        // $('#complaint_id_main').val(result[1]);
                        // $('#type_main').val(result[2]);
                        // $('#counter_display').val(result[3]);

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

    function validation_ind()
    {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        // Policy Number OK
        if($('#txtPolicyNumber').val() == '') 
        {
            $('#txtPolicyNumber').addClass('error-val');
            $('#txtPolicyNumber').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPolicyNumber').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtPolicyNumber').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#txtPolicyNumber').parent().find('.input-error').hide();
        }

        // CNIC/NICOP OK
        if($('#txtCNIC').val() == "") 
        {
            $('#txtCNIC').addClass('error-val');
            $('#txtCNIC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNIC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtCNIC').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNIC').parent().find('.input-error').hide();
        }

        // Customer Name OK
        if($('#txtCustomerName').val() == '') 
        {
            $('#txtCustomerName').addClass('error-val');
            $('#txtCustomerName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCustomerName').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtCustomerName').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
            $('#txtCustomerName').parent().find('.input-error').hide();
        }

        if($('#policy_issuance_date').val() == '') 
        {
            $('#policy_issuance_date').addClass('error-val');
            $('#policy_issuance_date').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#policy_issuance_date').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#policy_issuance_date').removeClass('error-val');
            //$('#policy_issuance_date').parents('.control-group').addClass('success');
            $('#policy_issuance_date').parent().find('.input-error').hide();
        }
        if($('#txtPremiumAmount').val() == '') 
        {
            $('#txtPremiumAmount').addClass('error-val');
            $('#txtPremiumAmount').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPremiumAmount').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtPremiumAmount').removeClass('error-val');
            //$('#txtPremiumAmount').parents('.control-group').addClass('success');
            $('#txtPremiumAmount').parent().find('.input-error').hide();
        }
        // if($('#txtRefundAmount').val() == '') 
        // {
        //     $('#txtRefundAmount').addClass('error-val');
        //     $('#txtRefundAmount').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) 
        //     {
        //         $('#txtRefundAmount').focus();
        //         hasFocus = true;
        //     }

        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtRefundAmount').removeClass('error-val');
        //     //$('#txtRefundAmount').parents('.control-group').addClass('success');
        //     $('#txtRefundAmount').parent().find('.input-error').hide();
        // }
        if($('#txtAmountClaimed').val() == '') 
        {
            $('#txtAmountClaimed').addClass('error-val');
            $('#txtAmountClaimed').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtAmountClaimed').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtAmountClaimed').removeClass('error-val');
            //$('#txtAmountClaimed').parents('.control-group').addClass('success');
            $('#txtAmountClaimed').parent().find('.input-error').hide();
        }
        if($('#reported_dt').val() == '') 
        {
            $('#reported_dt').addClass('error-val');
            $('#reported_dt').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#reported_dt').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#reported_dt').removeClass('error-val');
            //$('#reported_dt').parents('.control-group').addClass('success');
            $('#reported_dt').parent().find('.input-error').hide();
        }
        if($('#received_date').val() == '') 
        {
            $('#received_date').addClass('error-val');
            $('#received_date').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_date').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#received_date').removeClass('error-val');
            //$('#received_date').parents('.control-group').addClass('success');
            $('#received_date').parent().find('.input-error').hide();
        }


        if($('#plan_nature').val() == '0') 
        {
            $('#plan_nature').addClass('error-val');
            $('#plan_nature').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#plan_nature').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#plan_nature').removeClass('error-val');
            //$('#plan_nature').parents('.control-group').addClass('success');
            $('#plan_nature').parent().find('.input-error').hide();
        }


        if($('#ddlProductName').val() == null) 
        {
            $('#ddlProductName').addClass('error-val');
            $('#ddlProductName').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductName').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlProductName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlProductName').removeClass('error-val');
            $('#ddlProductName').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlProductName').parents('.control-group').addClass('success');
            $('#ddlProductName').parent().find('.input-error').hide();
        }

        // Source OK
        if($('#ddlSource').val() == null) 
        {
            $('#ddlSource').addClass('error-val');
            $('#ddlSource').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSource').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSource').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSource').removeClass('error-val');
            $('#ddlSource').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSource').parent().find('.input-error').hide();
        }
        
        if($('#ddlDepartmentName').val() == null) 
        {
            $('#ddlDepartmentName').addClass('error-val');
            $('#ddlDepartmentName').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentName').parent().find('.select2-container--default').show().addClass('error-val');

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
            $('#ddlDepartmentName').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlDepartmentName').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintType').val() == 0 || $('#ddlComplaintType').val() == null) 
        {
            $('#ddlComplaintType').addClass('error-val');
            $('#ddlComplaintType').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintType').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintType').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintType').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintType').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintType').parent().find('.input-error').hide();
        }

        if($('#txtResidenceAddress').val() == "") 
        {
            $('#txtResidenceAddress').addClass('error-val');
            $('#txtResidenceAddress').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResidenceAddress').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResidenceAddress').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtResidenceAddress').parent().find('.input-error').hide();
        }

        if($('#txtEmail').val() != '' && email.test($('#txtEmail').val()) == false) 
        {
            $('#txtEmail').addClass('error-val');
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmail').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
        }
        
        if($('#txtCorrespondenceAddress').val() == "") 
        {
            $('#txtCorrespondenceAddress').addClass('error-val');
            $('#txtCorrespondenceAddress').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddress').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCorrespondenceAddress').removeClass('error-val');
            //$('#txtCorrespondenceAddress').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddress').parent().find('.input-error').hide();
        }

        if($('#txtEmail').val() == "") 
        {
            $('#txtEmail').addClass('error-val');
            $('#txtEmail').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmail').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmail').removeClass('error-val');
            //$('#txtEmail').parents('.control-group').addClass('success');
            $('#txtEmail').parent().find('.input-error').hide();
        }

        if($('#txtResponseNumber').val() == "") 
        {
            $('#txtResponseNumber').addClass('error-val');
            $('#txtResponseNumber').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResponseNumber').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResponseNumber').removeClass('error-val');
            //$('#txtResponseNumber').parents('.control-group').addClass('success');
            $('#txtResponseNumber').parent().find('.input-error').hide();
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