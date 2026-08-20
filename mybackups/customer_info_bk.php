<?php

$page_title = "Customer Info";
$permission_type = "view";
$module_id = "0";
$menu_id = "customer_info";

include('includes/header.php');

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
        <li class="customer_info.php">Services</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Services</h1>
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
                        <ul class="nav nav-tabs nav-tabs-inverse">
                            <li class="prev-button"><a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a></li>
                            <li class="active"><a id="tabCustomerInfo" href="#nav-tab-customer" data-toggle="tab">Customer Info</a></li>
                            <li class=""><a id="tabAccount" href="#nav-tab-accounts" data-toggle="tab">Accounts</a></li>
                            <li class=""><a id="tabCreditCard" href="#nav-tab-credit_cards" data-toggle="tab">Credit Cards</a></li>
                            <li class=""><a id="tabDebitCard" href="#nav-tab-atm_card" data-toggle="tab">ATM/Debit Cards</a></li>
                            <li class="next-button"><a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">

                    <div class="tab-pane fade active in" id="nav-tab-customer">
                        <div class="panel-body">
                            <form class="form-horizontal" action="/" method="POST">
                                <fieldset>
                                    <legend>Basic Info</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Default Account</label>
                                                <input type="text" class="form-control" placeholder="Default Account" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Is Customer</label>
                                                <div>
                                                    <div class="radio radio-css radio-inline radio-inverse">
                                                        <input type="radio" name="radioInlineCss" id="radio_inline_css_1" value="1" checked="">
                                                        <label for="radio_inline_css_1">
                                                            True
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline radio-danger">
                                                        <input type="radio" name="radioInlineCss" id="radio_inline_css_2" value="2">
                                                        <label for="radio_inline_css_2">
                                                            False
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="First Name">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>CNIC</label>
                                                <input type="text" onkeypress="return validateNumbers(event);" class="form-control" maxlength="15" placeholder="42201-XXXXXXX-X">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Details</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date Of Birth</label>
                                                <div class="input-group date" id="datetimepicker1">
                                                    <input type="text" class="form-control" value="" placeholder="DOB">
                                                    <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Birth Place</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="City Name">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Marital Status</label>
                                                <select class="form-control">
                                                    <option>-- Marital Status --</option>
                                                    <option value="0">• Single</option>
                                                    <option value="1">• Married</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Mother Name</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Mother Name">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Nationality</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Nationality">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Occupation</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Occupation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Father Name</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Father Name">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Language</label>
                                                <input type="text" onkeypress="return validateAlphabets(event);" class="form-control" placeholder="Language">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div>
                                                    <div class="radio radio-css radio-inline radio-inverse">
                                                        <input type="radio" name="radioInlineCss1" id="radio_inline_css_3" value="option3" checked="">
                                                        <label for="radio_inline_css_3">
                                                            Male
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline radio-danger">
                                                        <input type="radio" name="radioInlineCss1" id="radio_inline_css_4" value="option4">
                                                        <label for="radio_inline_css_4">
                                                            Female
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline radio-danger">
                                                        <input type="radio" name="radioInlineCss1" id="radio_inline_css_5" value="option5">
                                                        <label for="radio_inline_css_5">
                                                            Other
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <fieldset id="div_misc">
                                    <legend>Misc</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>T Pin Status</label>
                                                <input type="text" class="form-control" placeholder="T Pin Status">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control" id="ddlPriority" name="ddlPriority">
                                                        <option value="1">Normal</option>
                                                        <option value="1">Low</option>
                                                        <option value="1">High</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>T Pin Count Tries</label>
                                                <input type="text" onkeypress="return validateNumbers(event);" maxlength="4" class="form-control" placeholder="XXXX">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>ATM Pin Count Tries</label>
                                                <input type="text" onkeypress="return validateNumbers(event);" maxlength="4" class="form-control" placeholder="XXXX">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>IB Subscription</label>
                                                <div>
                                                    <div class="radio radio-css radio-inline radio-inverse">
                                                        <input type="radio" name="radInlineCss2" id="radio_inline_css_6" value="option6" checked="">
                                                        <label for="radio_inline_css_6">
                                                            Activated
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline radio-danger">
                                                        <input type="radio" name="radInlineCss2" id="radio_inline_css_7" value="option7">
                                                        <input type="radio" name="radInlineCss2" id="radio_inline_css_7" value="option7">
                                                        <label for="radio_inline_css_7">
                                                            Deactivated
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>SMS Subscription</label>
                                                <div>
                                                    <div class="radio radio-css radio-inline radio-inverse">
                                                        <input type="radio" name="radioInlineCss2" id="radio_inline_css_6" value="option6" checked="">
                                                        <label for="radio_inline_css_6">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-css radio-inline radio-danger">
                                                        <input type="radio" name="radioInlineCss2" id="radio_inline_css_7" value="option7">
                                                        <label for="radio_inline_css_7">
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <a class="btn btn-inverse btn-sm btnTPin" href="">
                                                    T PIN <i class="glyphicon glyphicon-edit icon-white"></i>
                                                </a>
                                                <a class="btn btn-info btn-sm btnATMPin" href="">
                                                    ATM PIN <i class="glyphicon glyphicon-edit icon-white"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <legend>Contact</legend>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Residence Phone</label>
                                                <input type="text" placeholder="Residence Phone" onkeypress="return validateNumbers(event);" name="txtAddress" id="txtAddress" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Residence Address</label>
                                                <textarea placeholder="Residence Address" name="txtAddress" id="txtAddress" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Alternate E-Mail</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="example@mail.com">
                                                    <span class="input-group-addon">@</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Fax Number</label>
                                                <input type="text" onkeypress="return validateNumbers(event);" class="form-control" placeholder="Fax Number">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Office Phone</label>
                                                <input type="text" onkeypress="return validateNumbers(event);" class="form-control" placeholder="021XXXXXXXX">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Office Address</label>
                                                <textarea placeholder="Office Address" name="txtAddress" id="txtAddress" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>E-Mail</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="example@mail.com">
                                                    <span class="input-group-addon">@</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <!--<hr>-->
                                <fieldset style="display: none;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-sm btn-info" />Submit</button>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>
                            </form>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="nav-tab-accounts">
                        <h3 id="AccountList">Account List</h3>

                        <div id="AccountTable" class="panel-body">
                            <table id="data-table" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Account Num</th>
                                    <th>Account Title</th>
                                    <th>Account Type</th>
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
                                    <a id="SubtabAccountDetails" style="text-decoration: none;" href="#nav-tab-AccountDetails" data-toggle="tab"><span class="hidden-xs"><h4>Account Details</h4></span></a>
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



                    <div class="tab-pane fade" id="nav-tab-credit_cards">
                        <h3 id="CreditCardList">Credit Card List</h3>

                        <div id="CreditCardTable" class="panel-body">
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
                                        <a id="creditcard_no" href=""><? echo "0123456789112"; ?></a>
                                    </td>
                                    <td><?php echo "Cold" ?></td>
                                    <td><?php echo "Test"; ?></td>
                                    <td><?php echo "18-May-12 01:00:00"; ?></td>
                                    <td><?php echo "Card"; ?></td>
                                    <td><?php echo "Active"; ?></td>
                                </tbody>

                            </table>
                        </div>

                        <div id="CreditCardInfo" style="display: none;" class="panel-body">
                            <div class="panel panel-default panel-with-tabs" >
                                <div class="panel-heading">
                                    <a id="SubtabCreditCardDetails" style="text-decoration: none;" href="#nav-tab-CreditCardDetails" data-toggle="tab"><span class="hidden-xs"><h4>Credit Card Details</h4></span></a>
                                </div>

                                <!--Begin Credit Card Details Form-->
                                <?php include('services/credit_card_details.php') ?>
                                <!--End Credit Card Details Form-->

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-atm_card">
                        <h3 id="DebitCardList">ATM/Debit Card List</h3>

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
                                    <a id="SubtabDebitCardDetails" style="text-decoration: none;" href="#nav-tab-DebitCardDetails" data-toggle="tab"><span class="hidden-xs"><h4>ATM/Debit Card Details</h4></span></a>
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
                            <a id="btnChange" data-click="swal-info" class="btn btn-xs btn-info">Change TPIN</a>
                            <a id="btnGenerate" data-click="swal-info" class="btn btn-xs btn-info">Generate TPIN</a>
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
                            <a id="btnChangeATM" data-click="swal-info" class="btn btn-xs btn-info">Change ATMPIN</a>
                            <a id="btnGenerateATM" data-click="swal-info" class="btn btn-xs btn-info">Generate ATMPIN</a>
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

        $('input[type=radio][name=radioInlineCss]').change(function() {
            if (this.value == '1') {
                $("#div_misc").show();
            }
            else if (this.value == '2') {
                $("#div_misc").hide();
            }
        });
    });
</script>

<script type="text/javascript">

    function validateNumbers(key) {
        //getting key code of pressed key
        var keycode = (key.which) ? key.which : key.keyCode;
        //comparing pressed keycodes
        if (!(keycode == 8 || keycode == 46) && (keycode < 48 || keycode > 57)) {
            return false;
        }
        else {
            return true;
        }
    }

    function validateAlphabets(evt) {

        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(!(charCode >= 65 && charCode <= 123) && (charCode != 32 && charCode != 0)) {
            return false;
        }

        /*if (charCode > 31 && charCode != 0&& (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
            return false;
        }*/

        else {
            return true;
        }
    }



    $().ready(function() {
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


        /*Begin Credit Card Tab*/

        $(document).on('click', '#creditcard_no', function () {
            CreditCardListHide();
            CreditCardDetailsShow();
            return false;
        });

        function CreditCardDetailsShow(){
            $('#CreditCardDetails').show();
            $('#CreditCardInfo').show();
        }
        function CreditCardListHide(){
            $('#CreditCardList').hide();
            $('#CreditCardTable').hide();
        }
        function CreditCardDetailsHide(){
            $('#CreditCardDetails').hide();
            $('#CreditCardInfo').hide();
        }

        function CreditCardListShow(){
            $('#CreditCardList').show();
            $('#CreditCardTable').show();
        }

        $(document).on('click', '#btnBackCredit', function () {
            CreditCardDetailsHide();
            CreditCardListShow();
        });

        $(document).on('click', '#SubtabCreditCardDetails', function () {
            CreditCardHideAll();
            $('#tabCreditCardDetailsForm').show();
        });

        function CreditCardHideAll(){
            $('#tabCreditCardDetailsForm').hide();
        }

        /*End Credit Card Tab*/

});
</script>

</body>
</html>
