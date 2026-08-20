<?php
    $objProd = new Product();
    $objComplaint = new Complaint();
?>

<div class="row">
    <form class="form-horizontal" action="#" method="POST" id="complaintBanca">
        <input type="hidden" id="txtIdB" name="txtIdB" value="">
        <input type="hidden" id="actionB" name="actionB" value="save_complaint">
        <input type="hidden" name="txtCounterDisplayB" id="txtCounterDisplayB" value="<? //echo $counter_display; ?>" />
        <input type="hidden" name="txtCounterB" id="txtCounterB" value="<? //echo $counter; ?>" />
        <input type="hidden" name="typeB" id="typeB" value="bancaIndividual" />
        <input type="hidden" name="cmp_userB" id="cmp_userB" value="" />
        <input type="hidden" name="cmp_user_groupB" id="cmp_user_groupB" value="" />
        <input type="hidden" name="modeB" id="modeB" value="" />
        <input type="hidden" id="txtComplaintNoB" name="txtComplaintNoB" class="form-control" value="<? //echo $counter_display; ?>">

        <fieldset>
            <legend>Complaint Bancassurance Individual</legend>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberB" name="txtPolicyNumberB" class="form-control" placeholder="Policy Number" value="" onblur="customer_data_bnk();">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
					<div class="form-group">
						<label>Policyholder Name<span style="color: red;">*</span></label>
						<input type="text" id="txtCustomerNameB" name="txtCustomerNameB" class="form-control" placeholder="Policyholder Name">
						<div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
					</div>
				</div>
				<div class="col-md-1">
				</div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICB" name="txtCNICB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201XXXXXXXX" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Issuance Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" name="policy_issuance_dateBI" id="policy_issuance_dateBI" placeholder="Pick Preferable Date and Time" tabindex="13" />
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Issuance Date is required</div>
                    </div>
                </div>
                
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Status of Policy<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="status_of_policyBI" name="status_of_policyBI" data-placeholder="Select Plan Nature" >
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
                        <select class="form-control default-select2" id="plan_natureBI" name="plan_natureBI" data-placeholder="Select Plan Nature" >
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
                        <label>Product Nature<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlProductNameB" name="ddlProductNameB" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected">Select Product</option>
                            <?php $product = $objProd->GetProduct(0); ?>
                            <?php foreach($product as $products){ ?>
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
                        <label>Bank Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="bankNameB" name="bankNameB" data-size="10" data-live-search="true" data-style="btn-white">
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
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Department Name<span style="color: red;">*</span></label>
                        <select class="form-control default-select2" id="ddlDepartmentNameB" name="ddlDepartmentNameB" data-placeholder="Select Complaint" onchange="getcmp_type_bnk();">
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
                        <select class="form-control default-select2" id="ddlComplaintTypeB" name="ddlComplaintTypeB" data-placeholder="Select Complaint Type" onchange="get_cmp_type_detail_bnk();">
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
                        <select class="form-control default-select2" id="ddlSourceB" name="ddlSourceB" data-size="10" data-live-search="true" data-style="btn-white">
                            <option value="" selected="selected" disabled="disabled">Select Source</option>
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Premium<span style="color: red;">*</span></label>
                        <input type="text" id="txtPremiumAmountBI" name="txtPremiumAmountBI" class="form-control" placeholder="Enter Premium Amount" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Premium Amount is required</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Of Refund/Loss</label>
                        <input type="text" id="txtRefundAmountBI" name="txtRefundAmountBI" class="form-control" placeholder="Enter Refund Amount" onkeypress="return validateNumbers(event)" disabled>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Amount Claimed/Fraud Prevent<span style="color: red;">*</span></label>
                        <input type="text" id="txtAmountClaimedBI" name="txtAmountClaimedBI" class="form-control" placeholder="Enter Amount" onkeypress="return validateNumbers(event)">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Amount Claimed/Fraud Prevent is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control default-select2" id="cityBI" name="cityBI">
                            <option value="" selected="selected" disabled="disabled">Select City</option>
                            <?php $cities = $objProd->GetCity(0); ?>
                            <?php foreach ($cities as $city) { ?>
                                <option value="<? echo $city["id"]; ?>"><? echo $city["fullname"] ?></option>
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
                        <select class="form-control" id="ddlRegionBI" name="ddlRegionBI">
                            <option value="" selected="selected" disabled="disabled">Select Region</option>
                            <option value="south" >South</option>
                            <option value="east">East</option>
                            <option value="central">Central</option>
                            <option value="north">North</option>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Region is required</div>
                    </div>
				</div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint Report/Log Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="reported_dtBI" value="" placeholder="Complaint Received Date">
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
                        <label>Complaint Received Date<span style="color: red;">*</span></label>
                        <input type="text" class="form-control my-datepicker" id="received_dateBI" value="" placeholder="Complaint Received Date">
                        <span style="float: right; margin: -25px 15px 0px 0px;" class="input-group-input"><i class="fa fa-calendar"></i></span>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Complaint Received Date is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Priority</label>
                        <input type="text" id="ddlPriorityB" name="ddlPriorityB" class="form-control" placeholder="Priority" disabled="disabled">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Priority is required</div>
                    </div>
                </div>
				<div class="col-md-1">
                </div>
				<div class="col-md-3">
                    <div class="form-group">
                        <label>Complaint TAT</label>
                        <input type="text" id="txtComplaintTATB" name="txtComplaintTATB" class="form-control" placeholder="Complaint TAT" disabled="disabled">
                    </div>
                </div>
				<div class="col-md-1">
                </div>
			</div>
			

            <div class="col-md-12">
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionB" name="txtDescriptionB" rows="4" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
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
                        <input type="text" id="txtCallBackB" name="txtCallBackB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back Phone</label>
                        <input type="text" id="txtHomePhoneB" name="txtHomePhoneB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileB" name="txtMobileB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneB" name="txtOfficePhoneB" class="form-control" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail<span style="color: red;">*</span></label>
                        <!-- <div class="input-group"> -->
                            <input type="text" class="form-control" id="txtEmailB" name="txtEmailB" placeholder="example@mail.com">
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
                        <textarea rows="6" placeholder="Enter Office Address" id="txtOfficeAddressB" name="txtOfficeAddressB" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea rows="6" placeholder="Enter Address" id="txtCorrespondenceAddressB" name="txtCorrespondenceAddressB" class="form-control"></textarea>
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
                                <input type="radio" name="rdEmailB" id="radio_inline_css_bi1" value="1" >
                                <label for="radio_inline_css_bi1">
                                   Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdEmailB" id="radio_inline_css_bi2" value="0" checked="true">
                                <label for="radio_inline_css_bi2">
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
                            <input type="text" class="form-control" id="txtCustomerEmailB" name="txtCustomerEmailB" placeholder="abc@example.com">
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
                                <input type="radio" name="rdSMSB" id="radio_inline_css_bi3" value="1" >
                                <label for="radio_inline_css_bi3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSB" id="radio_inline_css_bi4" value="0" checked="true">
                                <label for="radio_inline_css_bi4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer Mobile<span style="color: red;">*</span></label>
                        <input type="text" maxlength="12" class="form-control" id="txtResponseNumberB" name="txtResponseNumberB" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX">
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
                                <input type="radio" name="rdCallBackB" id="radio_inline_css_bi12" value="1" >
                                <label for="radio_inline_css_bi12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackB" id="radio_inline_css_bi21" value="0" checked="true">
                                <label for="radio_inline_css_bi21">
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
                        <input type="text" maxlength="12" class="form-control number" id="txtResponseNumberB" name="txtResponseNumberB" onkeypress="return validateNumbers(event)" placeholder="92-XXXXXXXXXX">
                    </div>
                </div>

                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Call Back</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdCallBackB" id="radio_inline_css_bi12" value="1" >
                                <label for="radio_inline_css_bi12">
                                    Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdCallBackB" id="radio_inline_css_bi21" value="0" checked="true">
                                <label for="radio_inline_css_bi21">
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
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintBanca"  onclick ="banca_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." >Save</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    });

    function customer_data_bnk()
    {
        var PolicyNumber = $('#txtPolicyNumberB').val();
        var type = 1;

        if(PolicyNumber != '')
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:{
                    action : "get_customer_data",
                    PolicyNumber: PolicyNumber,
                    type : type
                }
            }).done(function (data) 
            {
                //alert(data);
                //$('#ddlSubCat').html(data);
                var res = data.split('|');
                $('#txtCNICB').val(res[0]);
                $('#txtCustomerNameB').val(res[1]);
                $('#txtResponseNumberB').val(res[2]);
                $('#txtOfficePhoneB').val(res[3]);
                $('#txtEmailB').val(res[4]);
                $('#txtCustomerEmailB').val(res[5]);
                $('#txtMobileB').val(res[6]);
                $('#txtHomePhoneB').val(res[7]);
                $('#txtOfficeAddressB').val(res[8]);
                $('#txtCorrespondenceAddressB').val(res[9]);
            });
        }
    }

    function getcmp_type_bnk()
    {
        var depart = $('#ddlDepartmentNameB').val();
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
            $('#ddlComplaintTypeB').html(data);
        });
    }

    function get_cmp_type_detail_bnk()
    {
        var cmptype = $('#ddlComplaintTypeB').val();

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
             $('#cmp_userB').val(res[0]);
             $('#cmp_user_groupB').val(res[1]);
             $('#ddlPriorityB').val(res[2]);
             $('#txtComplaintTATB').val($tat);
             //$('#type').val(res[4]);
             $('#modeB').val(res[5]);
        });
    }

    function banca_cmp()
    {
        var mode = $('#modeB').val();
        var txtCNIC = $('#txtCNICB').val();

        var policy_issuance_date=$('#policy_issuance_dateBI').val();
        var status_of_policy=$('#status_of_policyBI').val();
        var plan_nature = $('#plan_natureBI').val();
        var txtPremiumAmount = $('#txtPremiumAmountBI').val();
        var txtRefundAmount = $('#txtRefundAmountBI').val();
        var txtAmountClaimed = $('#txtAmountClaimedBI').val();
        var ddlRegion = $('#ddlRegionBI').val();
        var cityL = $('#cityBI').val();
        var reported_dt = $('#reported_dtBI').val();
        var received_date = $('#received_dateBI').val();

        var txtPolicyNumber = $('#txtPolicyNumberB').val();
        var txtCustomerName = $('#txtCustomerNameB').val();
        var ddlProductName = $('#ddlProductNameB').val();
        var ddlSource = $('#ddlSourceB').val(); 
        var ddlDepartmentName = $('#ddlDepartmentNameB').val();
        var ddlPriority = $('#ddlPriorityB').val();
        var ddlComplaintType = $('#ddlComplaintTypeB').val();
        var txtComplaintTAT = $('#txtComplaintTATB').val();
        var txtDescription = $('#txtDescriptionB').val();
        var bank =  $('#bankNameB').val();
        var txtCallBack = $('#txtCallBackB').val();
        var txtHomePhone = $('#txtHomePhoneB').val();
        var txtMobile = $('#txtMobileB').val();
        var txtOfficePhone = $('#txtOfficePhoneB').val();
        var txtEmail = $('#txtEmailB').val();
        var txtOfficeAddress = $('#txtOfficeAddressB').val();
        var txtCorrespondenceAddress = $('#txtCorrespondenceAddressB').val();
        var txtCustomerEmail = $('#txtCustomerEmailB').val();
        var txtResponseNumber = $('#txtResponseNumberB').val();
        var type = $('#typeB').val();
        var cmp_user = $('#cmp_userB').val();
        var cmp_user_group = $('#cmp_user_groupB').val();
        var rdEmail = $('input[name=rdEmailB]:checked').val();
        var rdSMS = $('input[name=rdSMSB]:checked').val();
        var rdCallBack = $('input[name=rdCallBackB]:checked').val();
        var action = $('#actionB').val();

         //$("#btnSaveComplaintBanca").button('loading');

        //alert(ddlPriority);
        if(validation_bnk()){
          $("#btnSaveComplaintBanca").button('loading');
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:{
                    'action'            : action,
                    'mode'              : mode,
                    'txtCNIC'           : txtCNIC,
                    'txtPolicyNumber'    :txtPolicyNumber,
                    'policy_issuance_date'    :policy_issuance_date,
                    'status_of_policy'    :status_of_policy,
                    'plan_nature'    :plan_nature,
                    'txtPremiumAmount'    :txtPremiumAmount,
                    'txtRefundAmount'    :txtRefundAmount,
                    'txtAmountClaimed'    :txtAmountClaimed,
                    'ddlRegion'    :ddlRegion,
                    'cityL'    :cityL,
                    'reported_dt'    :reported_dt,
                    'received_date'    :received_date,
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
                    'bank'               : bank
                },
                success: function(data) 
                {
                    //alert(data); 
                    //console.log(data);
                   $("#btnSaveComplaintBanca").button('reset');
                    var result = data.split("|");
                    getid = result[1];

                    if(result[0] == 'success')
                    {
                        $('#ModalCommentB').modal({backdrop: 'static', keyboard: false});
                        $('#ModalCommentB').modal('show');
                        $('#complaint_id_mainB').val(result[1]);
                        $('#type_mainB').val(result[2]);
                        $('#counter_displayB').val(result[3]);

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

    function validation_bnk()
    {
        //alert($('#bankName').val());
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        // Policy Number OK
        if($('#txtPolicyNumberB').val() == '') 
        {
            $('#txtPolicyNumberB').addClass('error-val');
            $('#txtPolicyNumberB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPolicyNumberB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtPolicyNumberB').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#txtPolicyNumberB').parent().find('.input-error').hide();
        }
        if($('#status_of_policyBI').val() == null) 
        {
            $('#status_of_policyBI').addClass('error-val');
            $('#status_of_policyBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#status_of_policyBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#status_of_policyBI').removeClass('error-val');
            //$('#txtTitle').parents('.control-group').addClass('success');
            $('#status_of_policyBI').parent().find('.input-error').hide();
        }

        // CNIC/NICOP OK
        if($('#txtCNICB').val() == "") 
        {
            $('#txtCNICB').addClass('error-val');
            $('#txtCNICB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCNICB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCNICB').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCNICB').parent().find('.input-error').hide();
        }

        // Customer Name OK
        if($('#txtCustomerNameB').val() == '') 
        {
            $('#txtCustomerNameB').addClass('error-val');
            $('#txtCustomerNameB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtCustomerNameB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCustomerNameB').removeClass('error-val');
            //$('#txtCustomerName').parents('.control-group').addClass('success');
            $('#txtCustomerNameB').parent().find('.input-error').hide();
        }

        if($('#policy_issuance_dateBI').val() == '') 
        {
            $('#policy_issuance_dateBI').addClass('error-val');
            $('#policy_issuance_dateBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#policy_issuance_dateBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#policy_issuance_dateBI').removeClass('error-val');
            //$('#policy_issuance_dateBI').parents('.control-group').addClass('success');
            $('#policy_issuance_dateBI').parent().find('.input-error').hide();
        }

        if($('#txtPremiumAmountBI').val() == '') 
        {
            $('#txtPremiumAmountBI').addClass('error-val');
            $('#txtPremiumAmountBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtPremiumAmountBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtPremiumAmountBI').removeClass('error-val');
            //$('#txtPremiumAmountBI').parents('.control-group').addClass('success');
            $('#txtPremiumAmountBI').parent().find('.input-error').hide();
        }
        // if($('#txtRefundAmountBI').val() == '') 
        // {
        //     $('#txtRefundAmountBI').addClass('error-val');
        //     $('#txtRefundAmountBI').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) 
        //     {
        //         $('#txtRefundAmountBI').focus();
        //         hasFocus = true;
        //     }
        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtRefundAmountBI').removeClass('error-val');
        //     $('#txtRefundAmountBI').parent().find('.input-error').hide();
        // }
        if($('#txtAmountClaimedBI').val() == '') 
        {
            $('#txtAmountClaimedBI').addClass('error-val');
            $('#txtAmountClaimedBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#txtAmountClaimedBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtAmountClaimedBI').removeClass('error-val');
            //$('#txtAmountClaimedBI').parents('.control-group').addClass('success');
            $('#txtAmountClaimedBI').parent().find('.input-error').hide();
        }
        if($('#reported_dtBI').val() == '') 
        {
            $('#reported_dtBI').addClass('error-val');
            $('#reported_dtBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#reported_dtBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#reported_dtBI').removeClass('error-val');
            //$('#reported_dtBI').parents('.control-group').addClass('success');
            $('#reported_dtBI').parent().find('.input-error').hide();
        }
        if($('#received_dateBI').val() == '') 
        {
            $('#received_dateBI').addClass('error-val');
            $('#received_dateBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#received_dateBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#received_dateBI').removeClass('error-val');
            //$('#received_dateBI').parents('.control-group').addClass('success');
            $('#received_dateBI').parent().find('.input-error').hide();
        }


        if($('#plan_natureBI').val() == '0') 
        {
            $('#plan_natureBI').addClass('error-val');
            $('#plan_natureBI').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) 
            {
                $('#plan_natureBI').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#plan_natureBI').removeClass('error-val');
            //$('#plan_natureBI').parents('.control-group').addClass('success');
            $('#plan_natureBI').parent().find('.input-error').hide();
        }

        if($('#ddlProductNameB').val() == '') 
        {
            $('#ddlProductNameB').addClass('error-val');
            $('#ddlProductNameB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlProductNameB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlProductNameB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlProductNameB').removeClass('error-val');
            $('#ddlProductNameB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlProductName').parents('.control-group').addClass('success');
            $('#ddlProductName').parent().find('.input-error').hide();
        }

        // Source OK
        if($('#ddlSourceB').val() == null) 
        {
            $('#ddlSourceB').addClass('error-val');
            $('#ddlSourceB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlSourceB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlSource').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlSourceB').removeClass('error-val');
            $('#ddlSourceB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlSource').parent().find('.input-error').hide();
        }
        if($('#ddlDepartmentNameB').val() == null) 
        {
            $('#ddlDepartmentNameB').addClass('error-val');
            $('#ddlDepartmentNameB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlDepartmentNameB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#ddlDepartmentNameB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlDepartmentNameB').removeClass('error-val');
            $('#ddlDepartmentNameB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#ddlDepartmentNameB').parent().find('.input-error').hide();
        }

        if($('#ddlComplaintTypeB').val() == 0 || $('#ddlComplaintTypeB').val() == null) 
        {
            $('#ddlComplaintTypeB').addClass('error-val');
            $('#ddlComplaintTypeB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#ddlComplaintTypeB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) {
                $('#ddlComplaintTypeB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#ddlComplaintTypeB').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#ddlComplaintTypeB').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#ddlComplaintTypeB').parent().find('.input-error').hide();
        }

        if($('#txtResidenceAddressB').val() == "") 
        {
            $('#txtResidenceAddressB').addClass('error-val');
            $('#txtResidenceAddressB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResidenceAddressB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResidenceAddressB').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtResidenceAddressB').parent().find('.input-error').hide();
        }

        // if($('#txtEmailB').val() != '' && email.test($('#txtEmailB').val()) == false) 
        // {
        //     $('#txtEmailB').addClass('error-val');
        //     $('#txtEmailB').parent().find('.input-error').show().css('display', 'inline-block');

        //     if (!hasFocus) {
        //         $('#txtEmailB').focus();
        //         hasFocus = true;
        //     }
        //     errCount++;
        // }
        // else 
        // {
        //     $('#txtEmailB').removeClass('error-val');
        //     //$('#txtUserId').parents('.control-group').addClass('success');
        //     $('#txtEmailB').parent().find('.input-error').hide();
        // }

        if($('#bankNameB').val() == null || $('#bankNameB').val() == '' ) 
        {
            $('#bankNameB').addClass('error-val');
            $('#bankNameB').parent().find('.input-error').show().css('display', 'inline-block');
            $('#bankNameB').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#bankNameB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#bankNameB').removeClass('error-val');
            $('#bankNameB').parent().find('.select2-container--default').show().removeClass('error-val');
            //$('#ddlSource').parents('.control-group').addClass('success');
            $('#bankNameB').parent().find('.input-error').hide();
        }

        if($('#txtCorrespondenceAddressB').val() == '') 
        {
            $('#txtCorrespondenceAddressB').addClass('error-val');
            $('#txtCorrespondenceAddressB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCorrespondenceAddressB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCorrespondenceAddressB').removeClass('error-val');
            //$('#txtCorrespondenceAddressB').parents('.control-group').addClass('success');
            $('#txtCorrespondenceAddressB').parent().find('.input-error').hide();
        }

        if($('#txtEmailB').val() == '') 
        {
            $('#txtEmailB').addClass('error-val');
            $('#txtEmailB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtEmailB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtEmailB').removeClass('error-val');
            //$('#txtEmailB').parents('.control-group').addClass('success');
            $('#txtEmailB').parent().find('.input-error').hide();
        }

        if($('#txtResponseNumberB').val() == '') 
        {
            $('#txtResponseNumberB').addClass('error-val');
            $('#txtResponseNumberB').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtResponseNumberB').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtResponseNumberB').removeClass('error-val');
            //$('#txtResponseNumberB').parents('.control-group').addClass('success');
            $('#txtResponseNumberB').parent().find('.input-error').hide();
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking_bi()
    {
        $("#txtCNICB").inputmask({"mask": "99999-9999999-9"});
        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }
</script>