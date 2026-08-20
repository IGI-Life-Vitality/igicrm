<?php
    $objProd = new Product();
    $objComplaint = new Complaint();
    $users = $objUser->GetUsers(0);
    $data  = $objComplaint->GetComplaintByIdCorporate($id,$cmode);   
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintCorporate">
        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['complaint_id']); ?>">
        <input type="hidden" id="action" name="action" value="edit_complaint">
        <input type="hidden" name="typeC" id="typeC" value="corporate" />
        <input type="hidden" name="cmp_userC" id="cmp_userC" value="" />
        <input type="hidden" name="cmp_user_groupC" id="cmp_user_groupC" value="" />
        <input type="hidden" name="modeC" id="modeC" value="" />
        <!-- <input type="hidden" name="txtCNICC" id="txtCNICC" value="" /> -->
        <input type="hidden" name="txtCounterDisplay" id="txtCounterDisplay" value="<?php echo $data[0]['complaint_num'];?>" />
        <input type="hidden" name="txtCounter" id="txtCounter" value="<? echo $counter; ?>" />
        <input type="hidden" id="complaint_num" name="complaint_num" class="form-control" value="<?php echo $data[0]['complaint_num'];?>">

        <fieldset>
            <legend>Complaint Corporate</legend>
			<div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Group No<span style="color: red;">*</span></label>
                        <input type="text" id="txtGroupNo" name="txtGroupNo" class="form-control" placeholder="Group No" value="<?php echo $data[0]['group_no']; ?>">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Group No is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Certificate No<span style="color: red;">*</span></label>
                        <input type="text" id="txtCertificate" name="txtCertificate" class="form-control" placeholder="Certificate No" value="<?php echo $data[0]['certificate_no']; ?>" maxlength="12" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Certificate No is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" id="txtMemberName" name="txtMemberName" class="form-control" placeholder="Member Name" value="<?php echo $data[0]['customer_name']; ?>" onkeypress="return validateAlphabets(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Member Name is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICC" name="txtCNICC" class="form-control" value="<?php echo $data[0]['cnic']; ?>" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" id="txtCompanyName" name="txtCompanyName" value="<?php echo $data[0]['company_name']; ?>" class="form-control" placeholder="Company Name" onkeypress="return validateAlphabets(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Company Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Reported By</label>
                        <select class="form-control" id="ddlReportedBy" name="ddlReportedBy">
                            <option value="group_companies" <?php echo $data[0]['reported_by'] == "group_companies" ? 'selected': ''?>>Group Companies</option>
                            <option value="hospitals" <?php echo $data[0]['reported_by'] == "hospitals" ? 'selected': ''?>>Hospitals</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateCC" id="policy_issuance_dateCC" placeholder="Pick Preferable Date and Time" tabindex="13" value="<?php echo Date('d/m/Y',strtotime($data[0]['policy_issuance_date'])); ?>" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy</label>
                        <select class="form-control default-select2" id="status_of_policyCC" name="status_of_policyCC" data-placeholder="Select Status of Policy" >
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
                        <select class="form-control default-select2" id="plan_natureCC" name="plan_natureCC" data-placeholder="Select Plan Nature" >
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
                        <select class="form-control default-select2" id="ddlProductNameCC" name="ddlProductNameCC" data-size="10" data-live-search="true" data-style="btn-white">
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
                        <select class="form-control default-select2" id="bankNameCC" name="bankNameCC" data-size="10" data-live-search="true" data-style="btn-white">
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
                        <label>Source<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlSourceC" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select Source</option>
                            <?php $source = $objProd->GetSource(0); ?>
                            <?php foreach($source as $sources){ ?>
                             <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["fullname"] ? 'Selected' : ''; ?>><? echo $sources["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameC" name="ddlDepartmentNameC" data-placeholder="Select Complaint"  onchange="getcmp_type_co();">
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
                        <select class="form-control default-select2" id="ddlComplaintTypeC" name="ddlComplaintTypeC" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_co();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hospital Name (Reported By)<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlHospitalNameC" name="ddlHospitalNameC">
                            <option value="" selected="selected" disabled="disabled">Hospital Name</option>
                            <?php $hospitals = $objProd->GetHospital(0); ?>
                            <?php foreach($hospitals as $hospital){ ?>
                             <option value="<? echo $hospital["id"]; ?>" <?php echo $data[0]['hospital']== $hospital["fullname"] ? 'selected' : ''; ?>><? echo $hospital["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Hospital Name is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="reported_dtCC" value="<?php echo Date('d/m/Y',strtotime($data[0]['reported_dt'])); ?>" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="received_dateCC" value="<?php echo Date('d/m/Y',strtotime($data[0]['received_date'])); ?>" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Agent / Broker</label>
                        <!-- <select class="form-control default-select2" id="txtAgentBroker" name="txtAgentBroker" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Agent/Broker Name</option>
                            <?php //$broker = $objProd->GetAgency(0); ?>
                            <?php //foreach($broker as $brokers){ ?>
                             <option value="<? //echo $brokers["id"]; ?>"><? //echo $brokers["fullname"] ?></option>
                            <? //} ?>
                        </select> -->
                        <input type="text" id="txtAgentBroker" name="txtAgentBroker" class="form-control" placeholder="Agent Or Broker Name" value="<?php echo $data[0]['agency']; ?>" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityC" name="ddlPriorityC" class="form-control" placeholder="Priority" disabled="disabled">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATC" name="txtComplaintTATC" class="form-control" placeholder="Complaint TAT" disabled="disabled">
                    </div>
                </div>
                <div class="col-md-1">
                </div>
			</div>
            

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea placeholder="Enter Description" id="txtDescriptionC" name="txtDescriptionC" rows="6" class="form-control"><?php echo $data[0]['description']; ?></textarea>
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
                        <input type="text" id="txtCallBackC" name="txtCallBackC" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['residence_phone']; ?>" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneC" name="txtHomePhoneC" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['callback_num']; ?>" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileC" name="txtMobileC" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['mobile_number']; ?>" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneC" name="txtOfficePhoneC" class="form-control" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['office_phone']; ?>" placeholder="021XXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                            <input type="text" class="form-control" id="txtEmailC" name="txtEmailC" placeholder="example@mail.com" value="<?php echo $data[0]['email']; ?>">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <!-- <span class="input-group-addon">@</span>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea rows="6" placeholder="Office Address" id="txtOfficeAddressC" name="txtOfficeAddressCOfficeAddressC" class="form-control"><?php echo $data[0]['office_address']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressC" name="txtCorrespondenceAddressC" class="form-control"><?php echo $data[0]['delivery_address']; ?></textarea>
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
                                <input type="radio" name="rdSMSC" id="radio_inline_css_c3" value="1" <?php echo $data[0]['is_sms'] == '1' ? 'checked': '' ?>>
                                <label for="radio_inline_css_c3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSC" id="radio_inline_css_c4" value="0" <?php echo $data[0]['is_sms'] == '0' ? 'checked': '' ?>>
                                <label for="radio_inline_css_c4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer Mobile<span style="color: red;">*</span></label>
                            <input type="text" maxlength="12" class="form-control" id="txtcusNumberC" name="txtcusNumberC" onkeypress="return validateNumbers(event)" value="<?php echo $data[0]['response_number']; ?>"  placeholder="92XXXXXXXXXX">
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
                                    <input type="radio" name="rdCallBackC" id="radio_inline_css_144" value="1" <?php echo $data[0]['is_call_back'] == '1' ? 'checked': '' ?>>
                                    <label for="radio_inline_css_144">
                                        Yes
                                    </label>
                                </div>

                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="rdCallBackC" id="radio_inline_css_1444" value="0" <?php echo $data[0]['is_call_back'] == '0' ? 'checked': '' ?>>
                                    <label for="radio_inline_css_1444">
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
                <button type="button" class="btn btn-sm btn-primary" onclick ="cooperate_cmp();" id="btnSaveComplaintCorporate" data-loading-text="<i class='fa fa-spinner fa-spin ' ></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    #complaintCorporate .select2-container--default .default-select2{
        width: 280px !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '#ddlReportedBy', function () {
            var selected_val = $(this).val();

            if(selected_val == 'group_companies')
            {
                $('#txtGroupNo').removeAttr("disabled");
                $('#txtCertificate').removeAttr("disabled");
                $('#txtCompanyName').removeAttr("disabled");
                $('#txtMemberName').removeAttr("disabled");
            }

            if(selected_val == 'hospitals')
            {
                $('#txtGroupNo').attr("disabled", "true");
                $('#txtCertificate').attr("disabled", "true");
                $('#txtCompanyName').attr("disabled", "true");
                $('#txtMemberName').attr("disabled", "true");
            }
        });
    });

    function customer_data_group()
    {
        var txtGroupNo = $('#txtGroupNo').val();
        var certificate_no = $('#txtCertificate').val();
        var type = 0;

        if(certificate_no != '')
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:{
                    action : "get_customer_data",
                    certificate_no: certificate_no,
                    PolicyNumber : txtGroupNo,
                    type    : type
                }
            }).done(function (data) 
            {
                var res = data.split('|');

                $('#txtCNICC').val(res[0]);
                $('#txtCompanyName').val(res[1]);
                $('#txtMemberName').val(res[10]);
                $('#txtcusNumber').val(res[2]);
                $('#txtOfficePhoneC').val(res[3]);
                $('#txtEmailC').val(res[4]);
                $('#txtCustomerEmailC').val(res[5]);
                $('#txtMobileC').val(res[6]);
                $('#txtHomePhoneC').val(res[7]);
                $('#txtOfficeAddressC').val(res[8]);

                if(res[8] != '' || res[9] != '' || res[11] != '')
                {
                    $('#txtCorrespondenceAddressC').val(res[8] + " " + res[9] + " " + " " + res[11]);
                }
                else
                {
                    res[8] = "NA";
                    res[9] = "NA";
                    res[11] = "NA";

                    $('#txtCorrespondenceAddressC').val(res[8] + " " + res[9] + " " + res[11]);
                }

                $('#txtAgentBroker').val(res[12]);
            });
        }
    }
    getcmp_type_co();
    function getcmp_type_co()
    {
        var depart = $('#ddlDepartmentNameC').val();
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
            $('#ddlComplaintTypeC').html(data);
            $('#ddlComplaintTypeC').val('<?php echo $data[0]['complaint_type_id']; ?>').trigger('change');
        });
    }
    get_cmp_type_detail_co();
    function get_cmp_type_detail_co()
    {
        var cmptype = $('#ddlComplaintTypeC').val();
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
             var $tat = res[3] + " Working Days";
             $('#cmp_userC').val(res[0]);
             $('#cmp_user_groupC').val(res[1]);
             $('#ddlPriorityC').val(res[2]);
             $('#txtComplaintTATC').val($tat);
             //$('#typeC').val(res[4]);
             $('#modeC').val(res[5]);
        });
    }

    function cooperate_cmp()
    {
        var complaintId = $('#txtId').val();
        var complaintNum = $('#complaint_num').val();
        var mode = $('#modeC').val();
        var ddlReportedBy = $('#ddlReportedBy').val();
        var txtGroupNo = $('#txtGroupNo').val();
        var txtCertificate = $('#txtCertificate').val();
        var txtCNIC = $('#txtCNICC').val();

        var policy_issuance_date=$('#policy_issuance_dateCC').val();
        var status_of_policy=$('#status_of_policyCC').val();
        var ddlProductName = $('#ddlProductNameCC').val();
        var plan_nature = $('#plan_natureCC').val();
        var bank =  $('#bankNameCC').val();
        var reported_dt = $('#reported_dtCC').val();
        var received_date = $('#received_dateCC').val();

        var txtMemberName = $('#txtMemberName').val();
        // var ddlProductName = $('#ddlProductNameC').val();
        var ddlSource = $('#ddlSourceC').val(); 
        var ddlDepartmentName = $('#ddlDepartmentNameC').val();
        var ddlPriority = $('#ddlPriorityC').val();
        var ddlComplaintType = $('#ddlComplaintTypeC').val();
        var txtComplaintTAT = $('#txtComplaintTATC').val();
        var txtDescription = $('#txtDescriptionC').val();
        var txtCallBack = $('#txtCallBackC').val();
        var txtHomePhone = $('#txtHomePhoneC').val();
        var txtMobile = $('#txtMobileC').val();
        var txtOfficePhone = $('#txtOfficePhoneC').val();
        var txtEmail = $('#txtEmailC').val();
        var txtOfficeAddress = $('#txtOfficeAddressC').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddressC').val();
        var txtCustomerEmail = $('#txtCustomerEmailC').val();
        var txtResponseNumber = $('#txtcusNumberC').val();
        var type = $('#typeC').val();
        var cmp_user = $('#cmp_userC').val();
        var cmp_user_group = $('#cmp_user_groupC').val();
        var rdEmail = $('input[name=rdEmailC]:checked').val();
        var rdSMS = $('input[name=rdSMSC]:checked').val();
        var rdCallBack = $('input[name=rdCallBackC]:checked').val();
        var action = $('#action').val();
        var txtCompanyName = $('#txtCompanyName').val();
        var txtAgentBroker = $('#txtAgentBroker').val();
        var ddlHospitalNameC = $('#ddlHospitalNameC').val();

        if(ddlReportedBy == 'hospitals')
        {
            txtGroupNo = "-";
            txtCertificate = "N/A";
        }

        //$("#btnSaveComplaintCorporate").button('loading');
        
        if(validation_co())
        {
            $("#btnSaveComplaintCorporate").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:
                {
                    'action'            : action,
                    'complaintId'       : complaintId,
                    'complaintNum'      : complaintNum,
                    'mode'              : mode,
                    'txtGroupNo'        : txtGroupNo,
                    'txtCertificate'    : txtCertificate,
                    'txtCNIC'           : txtCNIC,
                    'policy_issuance_date': policy_issuance_date,
                    'status_of_policy'  :status_of_policy,
                    'ddlProductName'    : ddlProductName,
                    'plan_nature'       : plan_nature,
                    'bank'              :  bank,
                    'reported_dt'       : reported_dt,
                    'received_date'     : received_date,
                    'txtMemberName'     : txtMemberName,
                    'ddlSource'         : ddlSource,
                    'ddlDepartmentName' : ddlDepartmentName,
                    'priority'       : ddlPriority,
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
                    'txtCompanyName'     : txtCompanyName,
                    'txtAgentBroker'     : txtAgentBroker,
                    'ddlHospitalNameC'   : ddlHospitalNameC,
                    'ddlReportedBy'      : ddlReportedBy,
                    'action'             : action
                },
                success: function(data) 
                {
                    //alert(data);
                   $("#btnSaveComplaintCorporate").button('reset');
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
                            // $('#ModalCommentC').modal({backdrop: 'static', keyboard: false});
                            // $('#ModalCommentC').modal('show');
                            // $('#complaint_id_mainC').val(result[1]);
                            // $('#type_mainC').val(result[2]);
                            // $('#counter_displayC').val(result[3]);
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

    function validation_co()
    {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        var ddlReportedBy = $('#ddlReportedBy').val();
        //alert(ddlReportedBy);
        // Policy Number OK

        if(ddlReportedBy != "hospitals")
        {

            if($('#txtGroupNo').val() == '') 
            {
                $('#txtGroupNo').addClass('error-val');
                $('#txtGroupNo').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtGroupNo').focus();
                    hasFocus = true;
                }

                errCount++;
            }
            else 
            {
                $('#txtGroupNo').removeClass('error-val');
                //$('#txtTitle').parents('.control-group').addClass('success');
                $('#txtGroupNo').parent().find('.input-error').hide();
            }

            // CNIC/NICOP OK
            if($('#txtCertificate').val() == "") 
            {
                $('#txtCertificate').addClass('error-val');
                $('#txtCertificate').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtCertificate').focus();
                    hasFocus = true;
                }

                errCount++;
            }
            else 
            {
                $('#txtCertificate').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtCertificate').parent().find('.input-error').hide();
            }
        }

        // Customer Name OK
        if($('#ddlDepartmentNameC').val() == null) 
        {
            $('#ddlDepartmentNameC').addClass('error-val');
            $('#ddlDepartmentNameC').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameC').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlDepartmentNameC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#ddlDepartmentNameC').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
            $('#ddlDepartmentNameC').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlDepartmentNameC').parent().find('.input-error').hide();
        }

        if($('#txtCNICC').val() == '') 
        {
            $('#txtCNICC').addClass('error-val');
            $('#txtCNICC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNICC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#txtCNICC').removeClass('error-val');
            //$('#txtCNICC').parents('.control-group').addClass('success');
            $('#txtCNICC').parent().find('.input-error').hide();
        }

        if($('#policy_issuance_dateCC').val() == '') 
        {
            $('#policy_issuance_dateCC').addClass('error-val');
            $('#policy_issuance_dateCC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#policy_issuance_dateCC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#policy_issuance_dateCC').removeClass('error-val');
            //$('#policy_issuance_dateCC').parents('.control-group').addClass('success');
            $('#policy_issuance_dateCC').parent().find('.input-error').hide();
        }

        if($('#ddlProductNameCC').val() == '') 
        {
            $('#ddlProductNameCC').addClass('error-val');
            $('#ddlProductNameCC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#ddlProductNameCC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#ddlProductNameCC').removeClass('error-val');
            //$('#ddlProductNameCC').parents('.control-group').addClass('success');
            $('#ddlProductNameCC').parent().find('.input-error').hide();
        }

        if($('#plan_natureCC').val() == '0') 
        {
            $('#plan_natureCC').addClass('error-val');
            $('#plan_natureCC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#plan_natureCC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#plan_natureCC').removeClass('error-val');
            //$('#plan_natureCC').parents('.control-group').addClass('success');
            $('#plan_natureCC').parent().find('.input-error').hide();
        }
        if($('#reported_dtCC').val() == '') 
        {
            $('#reported_dtCC').addClass('error-val');
            $('#reported_dtCC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#reported_dtCC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#reported_dtCC').removeClass('error-val');
            //$('#reported_dtCC').parents('.control-group').addClass('success');
            $('#reported_dtCC').parent().find('.input-error').hide();
        }
        if($('#received_dateCC').val() == '') 
        {
            $('#received_dateCC').addClass('error-val');
            $('#received_dateCC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_dateCC').focus();
                hasFocus = true;
            }

            errCount++;
        }
        else 
        {
            $('#received_dateCC').removeClass('error-val');
            //$('#received_dateCC').parents('.control-group').addClass('success');
            $('#received_dateCC').parent().find('.input-error').hide();
        }

        // Source OK
        if($('#ddlSourceC').val() == '') 
        {
            $('#ddlSourceC').addClass('error-val');
            $('#ddlSourceC').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSourceC').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSourceC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSourceC').removeClass('error-val');
            $('#ddlSourceC').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSourceC').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintTypeC').val() == 0 || $('#ddlComplaintTypeC').val() == null) 
        {
            $('#ddlComplaintTypeC').addClass('error-val');
            $('#ddlComplaintTypeC').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeC').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintTypeC').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeC').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintTypeC').parent().find('.input-error').hide();
        }

        if($('#txtCorrespondenceAddressC').val() == "") 
        {
            $('#txtCorrespondenceAddressC').addClass('error-val');
            $('#txtCorrespondenceAddressC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddressC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCorrespondenceAddressC').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddressC').parent().find('.input-error').hide();
        }

        // if($('#txtEmailC').val() != '' && email.test($('#txtEmailC').val()) == false) 
        // {
        //     $('#txtEmailC').addClass('error-val');
        //     $('#txtEmailC').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) {
        //         $('#txtEmailC').focus();
        //         hasFocus = true;
        //     }
        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtEmailC').removeClass('error-val');
        //     //$('#txtUserId').parents('.control-group').addClass('success');
        //     $('#txtEmailC').parent().find('.input-error').hide();
        // }

        if($('#ddlHospitalNameC').val() == 0 || $('#ddlHospitalNameC').val() == null) 
        {
            $('#ddlHospitalNameC').addClass('error-val');
            $('#ddlHospitalNameC').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlHospitalNameC').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlHospitalNameC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlHospitalNameC').removeClass('error-val');
            //$('#ddlHospitalNameC').parents('.control-group').addClass('success');
            $('#ddlHospitalNameC').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlHospitalNameC').parent().find('.input-error').hide();
        }

        if($('#txtEmailC').val() == "") 
        {
            $('#txtEmailC').addClass('error-val');
            $('#txtEmailC').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmailC').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmailC').removeClass('error-val');
            //$('#txtEmailC').parents('.control-group').addClass('success');
            $('#txtEmailC').parent().find('.input-error').hide();
        }

        if($('#txtcusNumber').val() == "") 
        {
            $('#txtcusNumber').addClass('error-val');
            $('#txtcusNumber').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtcusNumber').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtcusNumber').removeClass('error-val');
            //$('#txtcusNumber').parents('.control-group').addClass('success');
            $('#txtcusNumber').parent().find('.input-error').hide();
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