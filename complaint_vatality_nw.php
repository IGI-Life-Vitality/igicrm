<?php
     $objProd = new Product();
     $objComplaint = new Complaint();

?>

<div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
</div>

<div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
    <strong>Error!</strong>
    Error while saving record, Please try again!
    <span class="close" data-dismiss="alert">&times;</span>
</div>

<div class="row">
        <form class="form-horizontal" action="#" method="POST" id="complaintVatality">
        <input type="hidden" id="txtId" name="txtId" value="">
        <input type="hidden" id="actionV" name="actionV" value="save_complaint">
        <input type="hidden" name="txtCounterDisplayV" id="txtCounterDisplayV" value="<? //echo $counter_display; ?>" />
        <input type="hidden" name="txtCounterV" id="txtCounterV" value="<? //echo $counter; ?>" />
        <input type="hidden" name="typeV" id="typeV" value="vatality" />
        <input type="hidden" name="cmp_userV" id="cmp_userV" value="" />
        <input type="hidden" name="cmp_user_groupV" id="cmp_user_groupV" value="" />
        <input type="hidden" name="modeV" id="modeV" value="" />
        <input type="hidden" id="txtComplaintNoV" name="txtComplaintNoV" class="form-control" value="<? //echo $counter_display; ?>">

        <fieldset>
            <legend>Complaint Individual</legend>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policy Number<span style="color: red;">*</span></label>
                        <input type="text" id="txtPolicyNumberV" name="txtPolicyNumberV" class="form-control" placeholder="Policy Number" value="" onblur="customer_data_vatality();">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policy Number is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CNIC/NICOP<span style="color: red;">*</span></label>
                        <input type="text" id="txtCNICV" name="txtCNICV" class="form-control" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15">
                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Policyholder Name<span style="color: red;">*</span></label>
                        <input type="text" id="txtCustomerNameV" name="txtCustomerNameV" class="form-control" placeholder="Policyholder Name">
                        <div class="input-error form-control-input" style="color: Red; display: none;">Policyholder Name is required</div>
                    </div>
                </div>
                <div class="col-md-1">
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
                                <option value="<? echo $products["id"]; ?>"<? if($products['fullname'] == 'Vitality'){ echo "selected";} ?> ><?echo $products["fullname"] ?></option>
                            <? } ?>
                        </select>
                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Nature is required</div>
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
                <div class="col-md-1">
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
            </div>

            <div class="col-md-12">
                <div class="col-md-11">
                    <div class="form-group">
                        <label>Additional Note</label>
                        <textarea placeholder="Additional Information" id="txtDescriptionV" name="txtDescriptionV" rows="4" class="form-control"></textarea>
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
                        <label>Call Back Phone</label>
                        <input type="text" id="txtCallBackV" name="txtCallBackV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="11">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Home</label>
                        <input type="text" id="txtHomePhoneV" name="txtHomePhoneV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Cellular</label>
                        <input type="text" id="txtMobileV" name="txtMobileV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="92XXXXXXXXXX" maxlength="12">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Phone Office</label>
                        <input type="text" id="txtOfficePhoneV" name="txtOfficePhoneV" class="form-control number" onkeypress="return validateNumbers(event)" placeholder="021XXXXXXXX" maxlength="12">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>E-Mail</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtEmailV" name="txtEmailV" placeholder="example@mail.com">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <span class="input-group-addon">@</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Office Address</label>
                        <textarea placeholder="Office Address" id="txtOfficeAddressV" name="txtOfficeAddressV" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-1">
                </div> 
            </div>

            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Address Correspondence<span style="color: red;">*</span></label>
                        <textarea placeholder="Correspondence Address" id="txtCorrespondenceAddressV" name="txtCorrespondenceAddressV" class="form-control"></textarea>
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
                        <label>E-Mail</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdEmailV" id="radio_inline_css_v1" value="1" >
                                <label for="radio_inline_css_v1">
                                   Yes
                                </label>
                            </div>

                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdEmailV" id="radio_inline_css_v2" value="0" checked="true">
                                <label for="radio_inline_css_v2">
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
                        <label>Customer Email</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="txtCustomerEmailV" name="txtCustomerEmailV" placeholder="abc@example.com">
                            <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                            <span class="input-group-addon">@</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>SMS</label>
                        <div>
                            <div class="radio radio-css radio-inline radio-success">
                                <input type="radio" name="rdSMSV" id="radio_inline_css_v3" value="1" >
                                <label for="radio_inline_css_v3">
                                    Yes
                                </label>
                            </div>
                            <div class="radio radio-css radio-inline radio-danger">
                                <input type="radio" name="rdSMSV" id="radio_inline_css_v4" value="0" checked="true">
                                <label for="radio_inline_css_v4">
                                    No
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
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
            </div>
        </fieldset>

        <hr>

        <div class="col-md-12">
            <div class="col-md-2 form-group">
                <button type="button" class="btn btn-sm btn-primary" id="btnSaveComplaintIndividual"  onclick ="vatality_cmp();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." >Save</button>
            </div>
        </div>
    </form>
</div>

<!-- Begin Modal Individial -->
<div class="modal fade" id="ModalDailyHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnCloseDailyHours" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">Daily Hours</h4>
                    </div>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Individial -->

<script type="text/javascript">
    /*function customer_data_vatality()
    {
        var PolicyNumber = $('#txtPolicyNumberV').val();
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

        $('#txtCNICV').val('42501-9346322-7');
        $('#txtCustomerNameV').val('Haroon Saeed');
        $('#txtResponseNumberV').val('923333985446');
        $('#txtOfficePhoneV').val('021340228888');
        $('#txtEmailV').val('haroon.ssuet@gmail.com');
        $('#txtCustomerEmailV').val('haroon.ssuet@gmail.com');
        $('#txtMobileV').val('923333985446');
        $('#txtHomePhoneV').val('021340228888');
        $('#txtOfficeAddressV').val('Room # 123, xyz Building ABC Road Karachi');
        $('#txtCorrespondenceAddressV').val('Room # 123, xyz Building ABC Road Karachi');
        //$('#txtCustomerName').html(PolicyNumber);
        //$('#ddlSubCat').html(PolicyNumber);
        //alert(PolicyNumber);
    }*/

    function customer_data_vatality()
    {
        var PolicyNumber = $('#txtPolicyNumberV').val();
        var type = 1;
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
        });
    }

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
        var mode = $('#modeV').val();
        var txtCNIC = $('#txtCNICV').val();
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

        //alert(ddlPriority);
        if(validation_vatality()){
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint.php",
                data:{
                    'action'            : action,
                    'mode'              : mode,
                    'txtCNIC'           : txtCNIC,
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
                    var result = data.split("|");
                    getid = result[1];

                    if(result[0] == 'success')
                    {
                        $('#ModalCommentV').modal({backdrop: 'static', keyboard: false});
                        $('#ModalCommentV').modal('show');
                        $('#complaint_id_mainV').val(result[1]);
                        $('#type_mainV').val(result[2]);
                        $('#counter_displayV').val(result[3]);

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

        if($('#txtEmailV').val() != '' && email.test($('#txtEmailV').val()) == false) 
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

        if($('#txtCustomerEmailV').val() != '' && email.test($('#txtCustomerEmailV').val()) == false) 
        {
            $('#txtCustomerEmailV').addClass('error-val');
            $('#txtCustomerEmailV').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtCustomerEmailV').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtCustomerEmailV').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtCustomerEmailV').parent().find('.input-error').hide();
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