<?php
    $page_title = "Customer Info";
    $permission_type = "view";
    $module_id = "0";
    $menu_id = "customer_info";

    include('includes/header.php');
    include('classes/complaint.php');
    $objComplaint = new Complaint();
    $msisdn = isset($_REQUEST['msisdn'])?$_REQUEST['msisdn']:0;
    $policy = isset($_REQUEST['pno'])?$_REQUEST['pno']:0;//$_REQUEST['pno'];
    $detail = isset($_REQUEST['detail'])?$_REQUEST['detail']:0;
 //echo  $msisdn.$policy.$detail;
    if($msisdn == 0){
        $data ='';
        //unset($data);
        if($policy != 0 ){

         $data = $objComplaint->GetCustomersDataPolicy($policy);
       }
    }else{
        $data ='';
        //if($msisdn != ''){
         //unset($data);
         $data = $objComplaint->GetCustomersData($msisdn);
        // print_r($data);
        //}else{
         //$data = '';
       //}
    }
    
    //print_r($data);
    //echo $msisdn;
    if(empty($data)){

        header('Location: search.php');
    }
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
<link href="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
<link href='assets/plugins/jquery-noty/noty_theme_default.css' rel='stylesheet'>
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="customer_info.php">Customer Info</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Customer Info</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">
                <div class="panel-heading p-0">
                    <div class="panel-heading-btn m-r-10 m-t-10">
                    </div>
                    <!-- begin nav-tabs -->
                    <div class="tab-overflow">
                        <ul class="nav nav-tabs nav-tabs-igi nav-tabs-inverse nav-tabs-inverse-igi">
                            <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                            <li class="active"><a id="tabCustomerInfo" href="#nav-tab-customer" data-toggle="tab">Customer Info</a></li>
                            <!-- <li class=""><a id="tabAccount" href="#nav-tab-accounts" data-toggle="tab">Policies</a></li>
                            <li class=""><a id="tabDebitCard" href="#nav-tab-atm_card" data-toggle="tab">Customer Call History</a></li>
                            <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li> -->
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane fade active in" id="nav-tab-customer">
                        <div class="panel-body">
                            <form class="form-horizontal" action="/" method="POST">
                                <fieldset>
                                    <legend>Owner Details</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Owner Name</label>
                                                <input type="text" class="form-control" placeholder="Owner Name" disabled="true" value="<?php echo $data['Owner_Name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Insured Name</label>
                                                <input type="text" class="form-control" placeholder="Insured Name" disabled="true" value="<?php echo $data['Insure_Name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Owner CNIC/NICOP</label>
                                                <input type="text" class="form-control" placeholder="Insured CNIC/NICOP" disabled="true" value="<?php echo $data['CNIC'];?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Contact</label>
                                                <input type="text" class="form-control" placeholder="Contact" disabled="true" value="<?php echo $data['Mobile_Number'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Owner Address</label>
                                                <textarea name="txtAddress" id="txtAddress" class="form-control" rows="4" placeholder="Owner Addres" disabled="true"><?php echo $data['Address1'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Policy Details</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Policy Number</label>
                                                <input type="text"  class="form-control" placeholder="Policy Number" name="txtpolicy" id="txtpolicy" disabled="true" value="<?php echo $data['Policy_Number'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Plan of Insurance</label>
                                                <input type="text" class="form-control" placeholder="Plan Of Insurance" disabled="true" value="<?php echo $data['Plan_Name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Face Amount</label>
                                                <input type="text" class="form-control" placeholder="Agent Branch Code/Name" disabled="true" value="<?php echo $data['Face_Amount'];?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Initial Amount Premium</label>
                                                <input type="text" class="form-control" placeholder="Initial Amount Premium" disabled="true" value="<?php echo $data['CNIC'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mode Of Premium Amount</label>
                                                <input type="text" class="form-control" placeholder="Mode Of Premium Amount" disabled="true" value="<?php echo $data['Policy_Premium_Mode'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Amount Of Modal Premium Payable</label>
                                                <input type="text" class="form-control" placeholder="Amount Of Modal Premium Payable" disabled="true" value="<?php echo $data['Modal_Premium'];?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Issue Date</label>
                                                <input type="text" class="form-control" placeholder="Initial Amount Premium" disabled="true" value="<?php echo $data['Issue_Date'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Total Premium Paid</label>
                                                <input type="text" class="form-control" placeholder="Mode Of Premium Amount" disabled="true" value="<?php echo $data['Total_Premium_Paid'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3" style="display: none;">
                                            <div class="form-group">
                                                <label>Policy Status</label>
                                                <input type="text" class="form-control" placeholder="Amount Of Modal Premium Payable" disabled="true" value="<?php echo $data['Status_Policy_Description'];?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Next Premium <br>Due Date</label>
                                                <input type="text" class="form-control" placeholder="Next Premium Due Date" disabled="true" value="<?php echo $data['Next_Premium_Due_Date'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Total Accumulated Amount of <br>Automatic Premium Loan (If any)</label>
                                                <input type="text" class="form-control" placeholder="Enter Amount" disabled="true" value="<?php echo $data['CNIC'];?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Total Accumulated Amount of <br>Policy Loan (If any)</label>
                                                <input type="text" class="form-control" placeholder="Enter Amount" disabled="true" value="<?php echo $data['CNIC'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!--<hr>-->

                                <fieldset style="display: none;" id="save_btn">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-sm btn-primary" name="save" id="save" />Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    

                    <!-- Not Using -->
                    <div class="tab-pane fade" id="nav-tab-accounts">
                        <h3 id="AccountList">Policy List</h3>

                        <div id="AccountTable" class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Policy Num</th>
                                    <th>Policy Title</th>
                                    <th>Policy Type</th>
                                    <th>Branch Name</th>
                                    <th>Branch Code</th>
                                    <th>Status</th>
                                    <th>Currency</th>
                                    <th>Available Balance</th>
                                    <th>Customer Type</th>
                                </tr>
                                </thead>

                                <tbody>

                                <tr>
                                    <td>
                                        <a id="account_no" href=""><? echo "0118006000004896"; ?></a>
                                    </td>
                                    <td><?php echo "" ?></td>
                                    <td><?php echo "CA"; ?></td>
                                    <td><?php echo "Karachi"; ?></td>
                                    <td><?php echo "0526"; ?></td>
                                    <td><?php echo "Active"; ?></td>
                                    <td><?php echo "PKR"; ?></td>
                                    <td><?php echo "100,000"; ?></td>
                                    <td><?php echo "Individual Customer"; ?></td>
                                </tr>
                                </tbody>

                            </table>
                        </div>

                        <div id="AccountInfo" style="display: none;" class="panel-body">

                            <!-- begin panel -->
                            <div class="panel panel-default panel-with-tabs" >
                                <div class="panel-heading">
                                    <ul id="myTab" class="nav nav-tabs pull-right">
                                        <li><a id="SubtabChequeBook" href="#nav-tab-ChequeBook" data-toggle="tab"><span class="hidden-xs">Cheque book Request</span></a></li>
                                        <li><a id="SubtabBalanceInquiry" href="#nav-tab-BalanceInquiry" data-toggle="tab"><span class="hidden-xs">Balance Inquiry</span></a></li>
                                        <li><a id="SubtabChequeInquiry" href="#nav-tab-ChequeInquiry" data-toggle="tab"><span class="hidden-xs">Cheque Inquiry</span></a></li>
                                        <li><a id="SubtabTransactions" href="#nav-tab-Transactions" data-toggle="tab"><span class="hidden-xs">Last 10 Transactions</span></a></li>
                                        <li><a id="SubtabStopPayment" href="#nav-tab-StopPayment" data-toggle="tab"><span class="hidden-xs">Stop Payment</span></a></li>
                                    </ul>
                                    <a id="SubtabAccountDetails" style="text-decoration: none;" href="#nav-tab-AccountDetails" data-toggle="tab"><span class="hidden-xs"><h4>Policy Details</h4></span></a>
                                </div>

                                <!--Begin Account Details-->
                                <?php include('services/account_details.php') ?>
                                <!--End Account Details-->



                                <!--Begin Cheque book Request-->
                                <?php include('services/cheque_book.php') ?>
                                <!--End Cheque book Request-->



                                <!--Begin Balance Inquiry-->
                                <?php include('services/balance_inquiry.php') ?>
                                <!--End Balance Inquiry-->



                                <!--Begin Cheque Inquiry-->
                                <?php include('services/cheque_inquiry.php') ?>
                                <!--End Cheque Inquiry-->



                                <!--Begin Transactions-->
                                <?php include('services/last_transactions.php') ?>
                                <!--End Transactions-->



                                <!--Begin Stop Payment-->
                                <?php include('services/stop_payment.php') ?>
                                <!--End Stop Payment-->

                            </div>
                            <!-- end panel -->

                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-atm_card">
                        <h3 id="DebitCardList">Customer Call History</h3>

                        <div id="DebitCardTable" class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Card Num</th>
                                    <th>Card Type</th>
                                    <th>Embossed</th>
                                    <th>Expiry Date</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                </tr>
                                </thead>

                                <tbody>

                                <tr>
                                    <td>
                                        <a id="card_no" href=""><? echo "0123456789012345"; ?></a>
                                    </td>
                                    <td><?php echo "Test" ?></td>
                                    <td><?php echo "Test"; ?></td>
                                    <td><?php echo "18-May-12 01:00:00"; ?></td>
                                    <td><?php echo "Card"; ?></td>
                                    <td><?php echo "Active"; ?></td>
                                </tbody>

                            </table>
                        </div>
                        <div id="DebitCardInfo" style="display: none;" class="panel-body">
                            <!-- begin panel -->
                            <div class="panel panel-default panel-with-tabs" >
                                <div class="panel-heading">
                                    <ul id="myTab1" class="nav nav-tabs pull-right">
                                        <li class=""><a id="SubtabDefaultAccountMarketing" href="#nav-tab-DefaultAccountMarketing" data-toggle="tab"><span class="hidden-xs">Default Account Marketing</span></a></li>
                                        <li><a id="SubtabLinkingDelinking" href="#nav-tab-LinkingDelinking" data-toggle="tab"><span class="hidden-xs">Account Linking/Delinking</span></a></li>
                                        <li class=""><a id="SubtabStatusChange" href="#nav-tab-StatusChange" data-toggle="tab"><span class="hidden-xs">Debit Card Status Change</span></a></li>
                                    </ul>
                                    <a id="SubtabDebitCardDetails" style="text-decoration: none;" href="#nav-tab-DebitCardDetails" data-toggle="tab"><span class="hidden-xs"><h4>Customer History Details</h4></span></a>
                                </div>

                                <!--Begin Debit Card Detail Form-->
                                <?php include('services/debit_card_details.php') ?>
                                <!--End Debit Card Detail Form-->


                                <!--Begin Default Account Marketing-->
                                <?php include('services/account_marketing.php') ?>
                                <!--End Default Account Marketing-->

                                <!--Begin Account Linking/Delinking-->
                                <?php include('services/account_linking_delinking.php') ?>
                                <!--End Account Linking/Delinking-->


                                <!--Begin Debit Card Status Change-->
                                <?php include('services/debit_card_status_change.php') ?>
                                <!--End Debit Card Status Change-->

                            </div>
                            <!-- end panel -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<!--begin modals-->
<div class="modal fade" id="ModalTPin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnChange" data-click="swal-info" class="btn btn-xs btn-primary">Change TPIN</a>
                            <a id="btnGenerate" data-click="swal-info" class="btn btn-xs btn-primary">Generate TPIN</a>
                            <a id="btnCloseTpin" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>

                        </div>
                        <h4 class="panel-title">T-Pin</h4>
                    </div>
                </div>
                <div class="alert alert-info fade in m-b-15" id="labelTpin" style="display: none;">
                    Call Fowarded To Customer
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>
                <div class="alert alert-info fade in m-b-15" id="labelNewTpin" style="display: none;">
                    Call Fowarded To Customer
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;" id="">

                    <div class="panel-body">
                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Key Validation Counts</label>
                                        <input type="text" class="form-control" id="txtTPINCounts">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" id="txtTPINStatus">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalATMPin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="panel panel-inverse">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a id="btnChangeATM" data-click="swal-info" class="btn btn-xs btn-primary">Change ATMPIN</a>
                            <a id="btnGenerateATM" data-click="swal-info" class="btn btn-xs btn-primary">Generate ATMPIN</a>
                            <a id="btnCloseATM" class="btn btn-xs btn-icon btn-circle btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                        <h4 class="panel-title">ATM Pin</h4>
                    </div>
                </div>
                <div class="alert alert-info fade in m-b-15" id="labelATMpin" style="display: none;">
                    Call Fowarded To Customer
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>
                <div class="alert alert-info fade in m-b-15" id="labelNewATMpin" style="display: none;">
                    Call Fowarded To Customer
                    <span class="close" data-dismiss="alert">&times;</span>
                </div>

                <div class="modal-body" style="max-height: 480px; overflow-y:auto; overflow-x:hidden;">

                    <div class="panel-body">
                        <fieldset>
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Key Validation Counts</label>
                                        <input type="text" class="form-control" id="txtATMPINCounts">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" id="txtATMPINStatus">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
<!--end modals-->

<!-- begin #footer -->
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/masked-input/masked-input.min.js"></script>
<script src="assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script src="assets/plugins/password-indicator/js/password-indicator.js"></script>
<script src="assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
<script src="assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
<script src="assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
<script src="assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
<script src="assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
<script src="assets/plugins/clipboard/clipboard.min.js"></script>
<script src="assets/js/form-plugins.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        masking();

        $('input[type=radio][name=radioInlineCss]').change(function() {
            if (this.value == '1') {
                $("#save_btn").hide();
            }
            else if (this.value == '2') {
                $("#div_misc").hide();
                $("#save_btn").show();
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        /*<Begin TPIN Modal>*/

        $(document).on('click', '.btnTPin', function () {


            $('#ModalTPin').modal({backdrop: 'static', keyboard: false});
            $('#ModalTPin').modal('show');
            return false;
        });

        $(document).on('click', '#btnChange', function () {
            clear();
            $('#labelTpin').show();
        });

        $(document).on('click', '#btnGenerate', function () {
            clear();
            $('#labelNewTpin').show();
        });


        $(document).on('click', '#btnCloseTpin', function () {
            $('#ModalTPin').modal('hide');
        });

        function clear(){
            $('#labelTpin').hide();
            $('#labelNewTpin').hide();
        }

        /*<End TPIN Modal>*/



        /*<Begin ATM Modal>*/

        $(document).on('click', '.btnATMPin', function () {

            $('#ModalATMPin').modal({backdrop: 'static', keyboard: false});
            $('#ModalATMPin').modal('show');
            return false;
        });

        $(document).on('click', '#btnChangeATM', function () {
            clearATM();
            $('#labelATMpin').show();
        });

        $(document).on('click', '#btnGenerateATM', function () {
            clearATM();
            $('#labelNewATMpin').show();
        });


        $(document).on('click', '#btnCloseATM', function () {
            $('#ModalATMPin').modal('hide');
        });

        function clearATM(){
            $('#labelATMpin').hide();
            $('#labelNewATMpin').hide();
        }

        /*<End ATM Modal>*/


        /*Begin Account Tab*/

        $(document).on('click', '#tabAccount', function () {
            //alert("Abdullah");
        });

        $(document).on('click', '#account_no', function () {
            AccountListHide();
            AccountDetailsShow();
            return false;
        });

        function AccountDetailsShow(){
            //$('#AccountDetails').show();
            $('#AccountInfo').show();
        }
        function AccountListHide(){
            $('#AccountList').hide();
            $('#AccountTable').hide();
        }
        function AccountDetailsHide(){
            //$('#AccountDetails').hide();
            $('#AccountInfo').hide();
        }

        function AccountListShow(){
            $('#AccountList').show();
            $('#AccountTable').show();
        }

        $(document).on('click', '#btnBackAccounts', function () {
            AccountDetailsHide();
            AccountListShow();
        });

        $(document).on('click', '#SubtabBalanceInquiry', function () {
            HideAll();
            $('#tabBalanceInquiry').css('display','block');
        });

        $(document).on('click', '#SubtabChequeBook', function () {
            HideAll();
            $('#tabChequeBook').css('display','block');
        });

        $(document).on('click', '#SubtabChequeInquiry', function () {
            HideAll();
            $('#tabChequeInquiry').css('display','block');
        });

        $(document).on('click', '#SubtabStopPayment', function () {
            HideAll();
            $('#tabStopPayment').css('display','block');
        });

        $(document).on('click', '#SubtabTransactions', function () {
            HideAll();
            $('#tabTransactions').css('display','block');
        });

        $(document).on('click', '#SubtabAccountDetails', function () {
            HideAll();
            $('#AccountForm').show();
        });

        function HideAll(){
            $('#AccountForm').hide();
            $('#tabChequeBook').hide();
            $('#tabBalanceInquiry').hide();
            $('#tabChequeInquiry').hide();
            $('#tabTransactions').hide();
            $('#tabStopPayment').hide();
        }


        /*End Account Tab*/


        /*Begin ATM/DebitCard Tab*/



        $(document).on('click', '#card_no', function () {
            DebitCardListHide();
            DebitCardDetailsShow();
            return false;
        });

        function DebitCardDetailsShow(){
            $('#DebitCardDetails').show();
            $('#DebitCardInfo').show();
        }
        function DebitCardListHide(){
            $('#DebitCardList').hide();
            $('#DebitCardTable').hide();
        }
        function DebitCardDetailsHide(){
            $('#DebitCardDetails').hide();
            $('#DebitCardInfo').hide();
        }

        function DebitCardListShow(){
            $('#DebitCardList').show();
            $('#DebitCardTable').show();
        }

        $(document).on('click', '#btnBackDebit', function () {
            DebitCardDetailsHide();
            DebitCardListShow();
        });


        $(document).on('click', '#SubtabDebitCardDetails', function () {
            DebitCardHideAll();
            $('#tabDebitCardDetailsForm').show();
        });

        $(document).on('click', '#SubtabDefaultAccountMarketing', function () {
            DebitCardHideAll();
            $('#tabDefaultAccountMarketing').show();
        });

        $(document).on('click', '#SubtabLinkingDelinking', function () {
            DebitCardHideAll();
            $('#tabLinkingDelinking').show();
        });

        $(document).on('click', '#SubtabStatusChange', function () {
            DebitCardHideAll();
            $('#tabStatusChange').show();
        });

        function DebitCardHideAll(){
            $('#tabDebitCardDetailsForm').hide();
            $('#tabDefaultAccountMarketing').hide();
            $('#tabLinkingDelinking').hide();
            $('#tabStatusChange').hide();
        }

        /*End ATM/DebitCard Tab*/
    });

    function masking(){

        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    }
</script>

</body>
</html>
