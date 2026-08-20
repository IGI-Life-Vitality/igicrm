<?php
  $objProd = new Product();
  $objComplaint = new Complaint();
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintBB">
        <input type="hidden" id="txtId" name="txtId" value="">
        <input type="hidden" id="actionBB" name="actionBB" value="save_complaint">
        <input type="hidden" name="typeBB" id="typeBB" value="bancaBank" />
        <input type="hidden" name="cmp_userBB" id="cmp_userBB" value="" />
        <input type="hidden" name="cmp_user_groupBB" id="cmp_user_groupBB" value="" />
        <input type="hidden" name="modeBB" id="modeBB" value="" />
        <input type="hidden" name="txtCNIBB" id="txtCNIBB" value="" />
        <input type="hidden" name="txtCounterDisplayBB" id="txtCounterDisplayBB" value="<? echo $counter_display; ?>" />
        <input type="hidden" name="txtCounterBB" id="txtCounterBB" value="<? echo $counter; ?>" />
        <input type="hidden" id="txtComplaintNoBB" name="txtComplaintNoBB" class="form-control" value="<? echo $counter_display; ?>">

        <fieldset>
            <legend>Complaint Bancassurance Bank</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Reported By</label>
                        <select class="form-control" id="ddlReportedByBB" name="ddlReportedByBB">
                            <option value="group_companies" selected="true">Group Companies</option>
                            <option value="hospitals">Hospitals</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Group No<span style="color: red;">*</span></label>
                        <input type="text" id="txtGroupNoBBB" name="txtGroupNoBBB" class="form-control" placeholder="Group No" value="" >
                        <div class="input-error form-control-input" style="color: Red; display: none;">Group No is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Certificate No<span style="color: red;">*</span></label>
                        <input type="text" id="txtCertificateBBB" name="txtCertificateBBB" class="form-control"  placeholder="Certificate No" maxlength="12" onblur="customer_data_group_banca();">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Certificate No is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateBB" id="policy_issuance_dateBB" placeholder="Pick Preferable Date and Time" tabindex="13" />

                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>

                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="status_of_policyB" name="status_of_policyB" data-placeholder="Select Plan Nature" >
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
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Plan Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="plan_natureB" name="plan_natureB" data-placeholder="Select Plan Nature" >
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
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountBB" name="txtPremiumAmountBB" class="form-control" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss</label>
                        <input type="text" id="txtRefundAmountBB" name="txtRefundAmountBB" class="form-control" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)" disabled>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedBB" name="txtAmountClaimedBB" class="form-control" placeholder="Enter Amount" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Region</label>
                        <select class="form-control" id="ddlRegionB" name="ddlRegionB">
                            <option value="" selected="selected" disabled="disabled">Select Region</option>
                            <option value="south" >South</option>
                            <option value="east">East</option>
                            <option value="central">Central</option>
                            <option value="north">North</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Region is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityB" name="cityB">
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
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="reported_dtBB" value="" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
                 <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="received_dateB" value="" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Company Name</label>
                        <input type="text" id="txtCompanyNameBB" name="txtCompanyNameBB" class="form-control" placeholder="Company Name" onkeypress="return validateAlphabets(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Company Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Member Name</label>
                        <input type="text" id="txtMemberNameBB" name="txtMemberNameBB" class="form-control" placeholder="Member Name" onkeypress="return validateAlphabets(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Member Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Source<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlSourceBBB" name="ddlSourceBBB" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select Source</option>
                            <?php $source = $objProd->GetSource(0); ?>
                            <?php foreach($source as $sources){ ?>
                             <option value="<? echo $sources["id"]; ?>"><? echo $sources["fullname"] ?></option>
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
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameBBB" name="ddlDepartmentNameBBB" data-placeholder="Select Complaint"  onchange="getcmp_type_co_banca();">
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
                        <select class="form-control default-select2" id="ddlComplaintTypeBBB" name="ddlComplaintTypeBBB" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_co_banca();">
                            <option value="0" selected="selected" disabled>Select Complaint</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Type is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityBB" name="ddlPriorityBB" class="form-control" placeholder="Priority" disabled="disabled">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATBB" name="txtComplaintTATBB" class="form-control" placeholder="Complaint TAT" disabled="disabled">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Agent / Broker</label>
                        <!-- <select class="form-control default-select2" id="txtAgentBrokerBB" name="txtAgentBrokerBB" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Agent/Broker Name</option>
                            <?php //$broker = $objProd->GetAgency(0); ?>
                            <?php //foreach($broker as $brokers){ ?>
                             <option value="<? //echo $brokers["id"]; ?>"><? //echo $brokers["fullname"] ?></option>
                            <? //} ?>
                        </select> -->
                        <input type="text" id="txtAgentBrokerBB" name="txtAgentBrokerBB" class="form-control" placeholder="Agent or Broker Name" disabled="true">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Hospital Name (Reported By)<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlHospitalNameBB" name="ddlHospitalNameBB">
                            <option value="" selected="selected" disabled="disabled">Hospital Name</option>
                            <?php $hospitals = $objProd->GetHospital(0); ?>
                            <?php foreach($hospitals as $hospital){ ?>
                             <option value="<? echo $hospital["id"]; ?>"><? echo $hospital["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Hospital Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionBB" name="txtDescriptionBB" rows="6" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bank Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="bankNameBB" name="bankNameBB" data-size="10" data-live-search="true" data-style="btn-white">
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
                        <input type="text" id="txtCallBackBB" name="txtCallBackBB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneBB" name="txtHomePhoneBB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileBB" name="txtMobileBB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneBB" name="txtOfficePhoneBB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                            <input type="text" class="form-control" id="txtEmailBB" name="txtEmailBB" placeholder="example@mail.com">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <!-- <span class="input-group-addon">@</span> -->
                        </div>
                    <!-- </div> -->
                </div>
                <div class="col-md-1">
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea rows="6" placeholder="Enter Office Address" id="txtOfficeAddressBB" name="txtOfficeAddressCOfficeAddressBB" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressBB" name="txtCorrespondenceAddressBB" class="form-control"></textarea>
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
                                <input type="radio" name="rdEmailBB" id="radio_inline_css_bb" value="1" >
                                <label for="radio_inline_css_bb">
                                   Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdEmailBB" id="radio_inline_css_bb2" value="0" checked="true">
                                <label for="radio_inline_css_bb2">
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
                            <input type="text" class="form-control" id="txtCustomerEmailBB" name="txtCustomerEmailBB" placeholder="abc@example.com">
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
                                <input type="radio" name="rdSMSBB" id="radio_inline_css_bb3" value="1">
                                <label for="radio_inline_css_bb3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSBB" id="radio_inline_css_bb4" value="0" checked="true">
                                <label for="radio_inline_css_bb4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer Mobile<span style="color: red;">*</span></label>
                            <input type="text" maxlength="12" class="form-control" id="txtcusNumberBB" name="txtcusNumberBB" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX">
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
                                    <input type="radio" name="rdCallBackBB" id="radio_inline_css_bb12" value="1" >
                                    <label for="radio_inline_css_bb12">
                                        Yes
                                    </label>
                                </div>

                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="rdCallBackBB" id="radio_inline_css_bb21" value="0" checked="true">
                                    <label for="radio_inline_css_bb21">
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
                            <input type="text" maxlength="12" class="form-control number" id="txtcusNumberBB" name="txtcusNumberBB" onkeypress="return validateNumbers(event)" placeholder="92-XXXXXXXXXX">
                        </div>
                    </div>

                    <div class="col-md-1">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Call Back</label>
                            <div>
                                <div class="radio radio-css radio-inline radio-success">
                                    <input type="radio" name="rdCallBackBB" id="radio_inline_css_bb12" value="1" >
                                    <label for="radio_inline_css_bb12">
                                        Yes
                                    </label>
                                </div>

                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="rdCallBackBB" id="radio_inline_css_bb21" value="0" checked="true">
                                    <label for="radio_inline_css_bb21">
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
                <button type="button" class="btn btn-sm btn-primary" onclick ="banca_bank_cmp();" id="btnSaveComplaintBB" data-loading-text="<i class='fa fa-spinner fa-spin ' ></i> Process...">Save</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    #complaintBB .select2-container--default .default-select2{
        width: 260px !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '#ddlReportedByBB', function () {
            var selected_val = $(this).val();

            if(selected_val == 'group_companies')
            {
                $('#txtGroupNoBBB').removeAttr("disabled");
                $('#txtCertificateBBB').removeAttr("disabled");
                $('#txtCompanyNameBB').removeAttr("disabled");
                $('#txtMemberNameBB').removeAttr("disabled");
            }

            if(selected_val == 'hospitals')
            {
                $('#txtGroupNoBBB').attr("disabled", "true");
                $('#txtCertificateBBB').attr("disabled", "true");
                $('#txtCompanyNameBB').attr("disabled", "true");
                $('#txtMemberNameBB').attr("disabled", "true");
            }
        });
    });

    function customer_data_group_banca()
    {
        var txtGroupNo = $('#txtGroupNoBBB').val();
        var certificate_no = $('#txtCertificateBBB').val();
        var type = 0;

        if(certificate_no != '')
        { 
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:
                {
                    action: "get_customer_data",
                    certificate_no: certificate_no,
                    type: type
                }
            }).done(function (data) {
                //alert(data);
                //$('#ddlSubCat').html(data);
                var res = data.split('|');
                $('#txtCNIBB').val(res[0]);
                $('#txtCompanyNameBB').val(res[1]);
                $('#txtMemberNameBB').val(res[10]);
                $('#txtcusNumberBB').val(res[2]);
                $('#txtOfficePhoneBB').val(res[3]);
                $('#txtEmailBB').val(res[4]);
                $('#txtCustomerEmailBB').val(res[5]);
                $('#txtMobileBB').val(res[6]);
                $('#txtHomePhoneBB').val(res[7]);
                $('#txtOfficeAddressBB').val(res[8]);
                //$('#txtCorrespondenceAddressBB').val(res[9]);

                if(res[8] != '' || res[9] != '' || res[11] != '')
                {
                    $('#txtCorrespondenceAddressBB').val(res[8] + " " + res[9] + " " + " " + res[11]);
                }
                else
                {
                    res[8] = "NA";
                    res[9] = "NA";
                    res[11] = "NA";

                    $('#txtCorrespondenceAddressBB').val(res[8] + " " + res[9] + " " + res[11]);
                }

                $('#txtAgentBrokerBB').val(res[12]);
            });
        }
    }

    function getcmp_type_co_banca()
    {
        var depart = $('#ddlDepartmentNameBBB').val();
        //alert(depart);
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
            console.log(data);
            $('#ddlComplaintTypeBBB').html(data);
        });
    }

    function get_cmp_type_detail_co_banca()
    {
        var cmptype = $('#ddlComplaintTypeBBB').val();
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
             $('#cmp_userBB').val(res[0]);
             $('#cmp_user_groupBB').val(res[1]);
             $('#ddlPriorityBB').val(res[2]);
             $('#txtComplaintTATBB').val($tat);
             //$('#typeC').val(res[4]);
             $('#modeBB').val(res[5]);
        });
    }

    function banca_bank_cmp()
    {
        var mode = $('#modeBB').val();
        var ddlReportedBy = $('#ddlReportedByBB').val();
        var txtGroupNo = $('#txtGroupNoBBB').val();
        var txtCertificate = $('#txtCertificateBBB').val();
        var txtCNIC = $('#txtCNIBB').val();

        var policy_issuance_date=$('#policy_issuance_dateBB').val();
        var status_of_policy=$('#status_of_policyB').val();
        var plan_nature = $('#plan_natureB').val();
        var txtPremiumAmount = $('#txtPremiumAmountBB').val();
        var txtRefundAmount = $('#txtRefundAmountBB').val();
        var txtAmountClaimed = $('#txtAmountClaimedBB').val();
        var ddlRegion = $('#ddlRegionB').val();
        var cityL = $('#cityB').val();
        var reported_dt = $('#reported_dtBB').val();
        var received_date = $('#received_dateB').val();

        var txtMemberName = $('#txtMemberNameBB').val();
        var ddlProductName = $('#ddlProductNameBB').val();
        var ddlSource = $('#ddlSourceBBB').val(); 
        var ddlDepartmentName = $('#ddlDepartmentNameBBB').val();
        var ddlPriority = $('#ddlPriorityBB').val();
        var ddlComplaintType = $('#ddlComplaintTypeBBB').val();
        var txtComplaintTAT = $('#txtComplaintTATBB').val();
        var txtDescription = $('#txtDescriptionBB').val();
        var txtCallBack = $('#txtCallBackBB').val();
        var txtHomePhone = $('#txtHomePhoneBB').val();
        var txtMobile = $('#txtMobileBB').val();
        var txtOfficePhone = $('#txtOfficePhoneBB').val();
        var txtEmail = $('#txtEmailBB').val();
        var txtOfficeAddress = $('#txtOfficeAddressBB').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddressBB').val();
        var txtCustomerEmail = $('#txtCustomerEmailBB').val();
        var txtResponseNumber = $('#txtcusNumberBB').val();
        var type = $('#typeBB').val();
        var bank =  $('#bankNameBB').val();
        var cmp_user = $('#cmp_userBB').val();
        var cmp_user_group = $('#cmp_user_groupBB').val();
        var rdEmail = $('input[name=rdEmailBB]:checked').val();
        var rdSMS = $('input[name=rdSMSBB]:checked').val();
        var rdCallBack = $('input[name=rdCallBackBB]:checked').val();
        var action = $('#actionBB').val();
        var txtCompanyName = $('#txtCompanyNameBB').val();
        var txtAgentBroker = $('#txtAgentBrokerBB').val();
        var ddlHospitalNameC = $('#ddlHospitalNameBB').val();

        if(ddlReportedBy == 'hospitals'){
            txtGroupNo = "-";
            txtCertificate = "N/A";
        }

        //$("#btnSaveComplaintBB").button('loading');
        
        if(validation_co_banca()){
           $("#btnSaveComplaintBB").button('loading');
            $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint.php",
            data:{
                'action'            : action,
                'mode'              : mode,
                'txtGroupNo'        : txtGroupNo,
                'txtCertificate'    : txtCertificate,
                'policy_issuance_date'           : policy_issuance_date,
                'status_of_policy'           : status_of_policy,
                'plan_nature'           : plan_nature,
                'txtPremiumAmount'      :txtPremiumAmount,
                'txtRefundAmount'      :txtRefundAmount,
                'txtAmountClaimed'      :txtAmountClaimed,
                'ddlRegion'           : ddlRegion,
                'cityL'           : cityL,
                'reported_dt'           : reported_dt,
                'received_date'           : received_date,
                'txtMemberName'     : txtMemberName,
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
                'txtCompanyName'     : txtCompanyName,
                'txtAgentBroker'     : txtAgentBroker,
                'ddlHospitalNameC'   : ddlHospitalNameC,
                'ddlReportedBy'      : ddlReportedBy,
                'bank'               : bank
            },
            success: function(data) 
            {
                //alert(data);
               $("#btnSaveComplaintBB").button('reset');
                //console.log(data);
                var result = data.split("|");
                    getid = result[1];

                    if(result[0] == 'success')
                    {
                        $('#ModalCommentBB').modal({backdrop: 'static', keyboard: false});
                        $('#ModalCommentBB').modal('show');
                        $('#complaint_id_mainBB').val(result[1]);
                        $('#type_mainBB').val(result[2]);
                        $('#counter_displayBB').val(result[3]);
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

    function validation_co_banca()
    {
        var hasFocus = false;
        var errCount = 0;
        var ddlReportedBy = $('#ddlReportedByBB').val();
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        if(ddlReportedBy != "hospitals")
        {
            // Policy Number OK
            if($('#txtGroupNoBBB').val() == '') 
            {
                $('#txtGroupNoBBB').addClass('error-val');
                $('#txtGroupNoBBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtGroupNoBBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtGroupNoBBB').removeClass('error-val');
                //$('#txtTitle').parents('.control-group').addClass('success');
                $('#txtGroupNoBBB').parent().find('.input-error').hide();
            }

            if($('#policy_issuance_dateBB').val() == '') 
            {
                $('#policy_issuance_dateBB').addClass('error-val');
                $('#policy_issuance_dateBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#policy_issuance_dateBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#policy_issuance_dateBB').removeClass('error-val');
                //$('#policy_issuance_dateBB').parents('.control-group').addClass('success');
                $('#policy_issuance_dateBB').parent().find('.input-error').hide();
            }

            if($('#txtPremiumAmountBB').val() == '') 
            {
                $('#txtPremiumAmountBB').addClass('error-val');
                $('#txtPremiumAmountBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtPremiumAmountBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtPremiumAmountBB').removeClass('error-val');
                //$('#txtPremiumAmountBB').parents('.control-group').addClass('success');
                $('#txtPremiumAmountBB').parent().find('.input-error').hide();
            }
            // if($('#txtRefundAmountBB').val() == '') 
            // {
            //     $('#txtRefundAmountBB').addClass('error-val');
            //     $('#txtRefundAmountBB').parent().find('.input-error').show().css('display', 'inline-block');

            //     if (!hasFocus) 
            //     {
            //         $('#txtRefundAmountBB').focus();
            //         hasFocus = true;
            //     }
            //     errCount++;
            // }
            // else 
            // {
            //     $('#txtRefundAmountBB').removeClass('error-val');
            //     $('#txtRefundAmountBB').parent().find('.input-error').hide();
            // }
            if($('#txtAmountClaimedBB').val() == '') 
            {
                $('#txtAmountClaimedBB').addClass('error-val');
                $('#txtAmountClaimedBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtAmountClaimedBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtAmountClaimedBB').removeClass('error-val');
                //$('#txtAmountClaimedBB').parents('.control-group').addClass('success');
                $('#txtAmountClaimedBB').parent().find('.input-error').hide();
            }
            if($('#reported_dtBB').val() == '') 
            {
                $('#reported_dtBB').addClass('error-val');
                $('#reported_dtBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#reported_dtBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#reported_dtBB').removeClass('error-val');
                //$('#reported_dtBB').parents('.control-group').addClass('success');
                $('#reported_dtBB').parent().find('.input-error').hide();
            }
            if($('#received_dateB').val() == '') 
            {
                $('#received_dateB').addClass('error-val');
                $('#received_dateB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#received_dateB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#received_dateB').removeClass('error-val');
                //$('#received_dateB').parents('.control-group').addClass('success');
                $('#received_dateB').parent().find('.input-error').hide();
            }


            if($('#plan_natureB').val() == '0') 
            {
                $('#plan_natureB').addClass('error-val');
                $('#plan_natureB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#plan_natureB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#plan_natureB').removeClass('error-val');
                //$('#plan_natureB').parents('.control-group').addClass('success');
                $('#plan_natureB').parent().find('.input-error').hide();
            }

            // CNIC/NICOP OK
            if($('#txtCertificateBBB').val() == "") 
            {
                $('#txtCertificateBBB').addClass('error-val');
                $('#txtCertificateBBB').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) 
                {
                    $('#txtCertificateBBB').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtCertificateBBB').removeClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#txtCertificateBBB').parent().find('.input-error').hide();
            }
        }

        // Customer Name OK
        if($('#ddlDepartmentNameBBB').val() == null) 
        {
            $('#ddlDepartmentNameBBB').addClass('error-val');
            $('#ddlDepartmentNameBBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameBBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlDepartmentNameBBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlDepartmentNameBBB').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
             $('#ddlDepartmentNameBBB').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlDepartmentNameBBB').parent().find('.input-error').hide();
        }
        if($('#status_of_policyB').val() == null) 
        {
            $('#status_of_policyB').addClass('error-val');
            $('#status_of_policyB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#status_of_policyB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#status_of_policyB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#status_of_policyB').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
             $('#status_of_policyB').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#status_of_policyB').parent().find('.input-error').hide();
        }

        // Source OK
        if($('#ddlSourceBBB').val() == '') 
        {
            $('#ddlSourceBBB').addClass('error-val');
            $('#ddlSourceBBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSourceBBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSourceBBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSourceBBB').removeClass('error-val');
            $('#ddlSourceBBB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSourceBBB').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintTypeBBB').val() == 0 || $('#ddlComplaintTypeBBB').val() == null) 
        {
            $('#ddlComplaintTypeBBB').addClass('error-val');
            $('#ddlComplaintTypeBBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeBBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeBBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintTypeBBB').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeBBB').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintTypeBBB').parent().find('.input-error').hide();
        }

        if($('#txtCorrespondenceAddressBB').val() == "") 
        {
            $('#txtCorrespondenceAddressBB').addClass('error-val');
            $('#txtCorrespondenceAddressBB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddressBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCorrespondenceAddressBB').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddressBB').parent().find('.input-error').hide();
        }

        // if($('#txtEmailBB').val() != '' && email.test($('#txtEmailBB').val()) == false) 
        // {
        //     $('#txtEmailBB').addClass('error-val');
        //     $('#txtEmailBB').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) {
        //         $('#txtEmailBB').focus();
        //         hasFocus = true;
        //     }
        //         alert('txtEmailBB');

        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtEmailBB').removeClass('error-val');
        //     //$('#txtUserId').parents('.control-group').addClass('success');
        //     $('#txtEmailBB').parent().find('.input-error').hide();
        // }

        if($('#ddlHospitalNameBB').val() == null || $('#ddlHospitalNameBB').val() == '' ) 
        {
            $('#ddlHospitalNameBB').addClass('error-val');
            $('#ddlHospitalNameBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlHospitalNameBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlHospitalNameBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlHospitalNameBB').removeClass('error-val');
            $('#ddlHospitalNameBB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlHospitalNameBB').parents('.control-group').addClass('success');
            $('#ddlHospitalNameBB').parent().find('.input-error').hide();
        }

        if($('#bankNameBB').val() == null || $('#bankNameBB').val() == '' ) 
        {
            $('#bankNameBB').addClass('error-val');
            $('#bankNameBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#bankNameBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#bankNameBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#bankNameBB').removeClass('error-val');
            $('#bankNameBB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#bankNameBB').parent().find('.input-error').hide();
        }

        if($('#txtEmailBB').val() == null || $('#txtEmailBB').val() == '' ) 
        {
            $('#txtEmailBB').addClass('error-val');
            $('#txtEmailBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#txtEmailBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#txtEmailBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmailBB').removeClass('error-val');
            $('#txtEmailBB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#txtEmailBB').parent().find('.input-error').hide();
        }

        if($('#txtcusNumberBB').val() == null || $('#txtcusNumberBB').val() == '' ) 
        {
            $('#txtcusNumberBB').addClass('error-val');
            $('#txtcusNumberBB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#txtcusNumberBB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#txtcusNumberBB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtcusNumberBB').removeClass('error-val');
            $('#txtcusNumberBB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#txtcusNumberBB').parent().find('.input-error').hide();
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