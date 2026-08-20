<?php
    $page_title = "Lead Details";
    $permission_type = "view";
    $module_id = "36";
    $parent_id = "35";
    $menu_id = "leads_view";

    include('includes/header.php');
    include('classes/lead.php');
    include('classes/product.php');

    $login_id   = $_SESSION['login_id'];

    $objLead    = new Lead();
    $objProd    = new Product();

    $users = $objUser->GetUsers(0);

    $disa               = "";
    $dis_button         = "";
    $disabled           = "";
    $disable_info       = "";
    $call_back_checked  = "";
    $up_status          = "";

    //print_r($data);die;

    if(isset($_GET))
    {
        $lead_id     = isset($_GET['id'])?$_GET['id']:0;

        $heading = "";
        $isactive = "";

        if($lead_id > 0)
        {
            $data                   = $objLead->GetLeadsById($lead_id);
            $activity_data          = $objLead->GetLeadsStatusById($lead_id);
            $test_data              = $objLead->GetLeadsTestById($lead_id);

            //$disable_info         = $data[0]['group_id'] != 0 ? "disabled='true'" : "";
            if($data[0]['source'] == 5)
            {
                $channel = "Website";
            }
            else
            {
                $channel = $data[0]['assignee'];
            }

            $disable_assigned_to    = ($data[0]['lead_assigned_to'] != 0 || $data[0]['agent_id'] == $login_id) ? "disabled='true'" : "";

            $dis_button             = ($data[0]['lead_status_id'] == 2) ? "disabled='true'" : "";
            $comments_progress      = ($data[0]['lead_status_id'] == 2 || $data[0]['lead_status_id'] == 3 || $data[0]['lead_status_id'] == 4) ? $data[0]['lead_note'] : '';
            $disabled_comments      = ($data[0]['lead_status_id'] == 2 || $data[0]['lead_status_id'] == 3 || $data[0]['lead_status_id'] == 4 || $data[0]['lead_assigned_to'] != 0 || $data[0]['agent_id'] == $login_id) ? "disabled='true'" : "";
            $display_button         = ($data[0]['lead_status_id'] == 2 && $user_type == 1 || $user_type == 2) ? "" : "display: none";

            $dis_login = ($data[0]['lead_assigned_to'] != $login_id)? "disabled='true'":"";

            //Leads Activity Disable Features
            $disabled_remarks               = ($data[0]['lead_status_id'] == 4 || $data[0]['lead_status_id'] == 5 || $data[0]['lead_status_id'] == 6) ? "disabled='true'" : "";
            $comments_remarks               = ($activity_data[0]['lead_status_id'] == 2 || $activity_data[0]['lead_status_id'] == 3 || $activity_data[0]['lead_status_id'] == 4) ? $activity_data[0]['remarks'] : '';
            $disabled_lead_activity_button  = ($data[0]['lead_status_id'] == 4 || $data[0]['lead_status_id'] == 5 || $data[0]['lead_status_id'] == 6) ? "disabled='true'" : "";

            // Vitality Experience Center Activity
            $vitality_activity = ($data[0]['source_name'] == 'Vitality Experience Center' AND $user_type == '4') ? "display:show" : "display:none";

            // Need Leads Meturity By Call Center Agent
           /*if want to disabled agent and enable only at APi */
             /* if($data[0]['assignee']== 0 && $data[0]['lead_assigned_to'] && $channel = "Website" ){
                 $disabled_cc            = ($user_type == 3) ? "disabled='true'" : "disabled='true'";

             }else{*/
                $disabled_cc            = ($user_type == 3) ? "" : "disabled='true'";
             //}
                if($data[0]['source'] == 7){
                    $up_status = "disabled='disabled'";
                }
            
        }
        else
        {
            $heading = "Lead Management";
        }
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
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Leads Management</a></li>
        <li class="javascript:;"><?php echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <?php 
        /*echo "<pre>";
        print_r($data[0]);
        echo "</pre>";*/
    ?>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-4">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><?php echo $page_title; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="#" method="POST" id="lead">
                        <input type="hidden" id="txtId" name="txtId" value="<?php echo($data[0]['lead_id']); ?>">
                        <input type="hidden" id="txtLeadNum" name="txtLeadNum" class="form-control" value="<? echo $data[0]['lead_num']; ?>">
                        <input type="hidden" id="res" name="res" value="<?php echo $activity_data[0]['current_state'];?>">
                        
                        <fieldset>
                            <legend>Leads</legend>

                            <div class="col-md-12">
                                <div class="col-md-3" style="display: none">
                                    <div class="form-group">
                                        <label>Department</label>
                                        <?php $groups = $objUser->GetGroups(); ?>
                                        <select class="form-control default-select2" id="ddlDepartmentName" name="ddlDepartmentName">
                                            <?php foreach($groups as $group){ ?>
                                            <option value="<? echo $group["id"]; ?>" <?php if($group["primary_name"] == "AGENCY OPERATIONS/SALES") {echo "selected='selected'"; } ?>><? echo $group["primary_name"];?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1" style="display: none">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Current Date Time</label>
                                        <input class="form-control" type="text" name="current_date_time" id="current_date_time" disabled="disabled" value="<?php echo date('Y-m-d h:i:s');?>">
                                        
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Agent Name/Website</label>
                                        <input class="form-control" type="text" name="current_date_time" id="current_date_time" disabled="disabled" value="<?php echo $channel; ?>">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Salutation is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Salutation</label>                                       
                                        <?php if(isset($data[0]['lead_id'])) { ?>
                                            <input class="form-control" type="text" name="current_date_time" id="current_date_time" disabled="disabled" value="<?php echo $data[0]['salutation'];?>">
                                        <?php } else { ?>
                                            <select class="form-control default-select2" id="ddlSalutation" name="ddlSalutation" <?php echo $disabled_cc; ?>>
                                                <option value="" selected="selected">Select Salutation</option>
                                                <option value="Mr">Mr.</option>
                                                <option value="Mrs">Mrs.</option>
                                                <option value="Ms">Ms.</option>
                                            </select>   
                                        <?php } ?>

                                        <div class="input-error form-control-input" style="color: Red; display: none;">Salutation is required</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="txtFName" name="txtFName" value="<?php print_r($data[0]['fname']); ?>" <?php echo $disabled_cc; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">First Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" id="txtMName" name="txtMName" value="<?php print_r($data[0]['mname']); ?>" <?php echo $disabled_cc; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Middle Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="txtLName" name="txtLName" value="<?php print_r($data[0]['lname']); ?>" <?php echo $disabled_cc; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Last Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>CNIC/NICOP<!-- <span style="color: red;">*</span> --></label>
                                        <input type="text" class="form-control" id="txtCNIC" name="txtCNIC" onkeypress="return validateNumbers(event)" placeholder="42201-XXXXXXX-X" maxlength="15" value="<?php print_r($data[0]['cnic']); ?>" <?php echo $disabled_cc; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">CNIC/NICOP is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlGender" name="ddlGender" data-size="10" data-live-search="true" data-style="btn-white" <?php echo $disabled_cc; ?>>
                                            <option value="" <?php echo $data[0]['gender'] == " " ? "selected='true'" : ''; ?> selected="selected">Select Gender</option>
                                            <option value="Male" <?php echo $data[0]['gender'] == "Male" ? "selected='true'" : ''; ?>>Male</option>
                                            <option value="Female" <?php echo $data[0]['gender'] == "Female" ? "selected='true'" : ''; ?>>Female</option>
                                            <option value="Others" <?php echo $data[0]['gender'] == "Others" ? "selected='true'" : ''; ?>>Others</option>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Gender is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Call Back Number<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="txtMobile" name="txtMobile" value="<?php print_r($data[0]['mobile_no']); ?>" <?php echo $disabled_cc; ?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Call Back Number is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Back Up Number</label>
                                        <input type="text" class="form-control" id="txtBackNumber" name="txtBackNumber" value="<?php print_r($data[0]['backup_no']); ?>" <?php echo $disabled_cc; ?>>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>E-Mail</label>
                                        <!-- <div class="input-group"> -->
                                            <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="<?php print_r($data[0]['email']); ?>" <?php echo $disabled_cc; ?>>
                                            <!-- <span class="input-group-addon">@</span> -->
                                       <!--  </div> -->
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlCity" name="ddlCity" <?php echo $disabled_cc; ?>>
                                            <option value="" <?php echo $data[0]['gender'] == " " ? "selected='true'" : ''; ?> selected="selected">Select City</option>
                                           <?php $cities = $objProd->GetCity(0); ?>
                                            <?php foreach($cities as $city){ ?>
                                             <option value="<? echo $city["id"]; ?>" <?php echo $data[0]['city'] == $city["fullname"] ? "selected='true'" : ''; ?>><? echo $city["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">City is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Area<span style="color: red;">*</span></label>
                                            <?php if(isset($data[0]['lead_id'])) { ?>
                                            <select class="form-control default-select2" id="ddlArea" name="ddlArea" <?php echo $disabled_cc; ?>>
                                                <option value="" selected="selected">Select Area</option>
                                                <option selected='true'><?php echo $data[0]['area']; ?></option>
                                            </select>
                                            <?php } else { ?>
                                            <select class="form-control default-select2" id="ddlArea" name="ddlArea" <?php echo $disabled_cc; ?> >
                                                <option value="" selected="selected">Select Area</option>
                                            </select>    
                                            <?php } ?>
                                            <div class="input-error form-control-input" style="color: Red; display: none;">Area is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Complete Address<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtAddress" name="txtAddress" rows="6" <?php echo $disabled_cc; ?>><?php print_r($data[0]['address']); ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Address is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product Name<span style="color: red;">*</span></label>
                                        <?php if(isset($data[0]['lead_id'])) { ?>
                                        <select class="form-control default-select2" id="ddlProductName" name="ddlProductName[]" data-size="10" data-live-search="true" data-style="btn-white" <?php echo $disabled_cc; ?>>
                                            <option value="" selected="selected">Select Product</option>
                                            <?php $product_categories = $objProd->GetProduct(); ?>
                                            <?php foreach($product_categories as $product_names){ ?>
                                                <option value="<? echo $product_names["id"]; ?>" <?php echo $data[0]['product'] == $product_names["id"] ? "selected='true'" : ''; ?>><? echo $product_names["fullname"] ?></option>
                                            <? } ?> 
                                        </select>
                                        <?php } else { ?>
                                        <select class="form-control default-select2" id="ddlProductName" name="ddlProductName[]" data-size="10" data-live-search="true" data-style="btn-white">
                                            <option value="" selected="selected" <?php echo $disabled_cc; ?>>Select Product</option>
                                            <?php $product_categories = $objProd->GetProduct(); ?>
                                            <?php foreach($product_categories as $product_names){ ?>
                                                <option value="<? echo $product_names["id"]; ?>" <?php echo $data[0]['product'] == $product_names["id"] ? "selected='true'" : ''; ?>><? echo $product_names["fullname"] ?></option>
                                            <? } ?> 
                                        </select>
                                        <?php } ?>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Product Name is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Preferable Call Time<span style="color: red;">*</span></label>
                                        <!--  <?php //if(isset($data[0]['lead_id']) && $data[0]['lead_assignee'] == 0) { ?> -->
                                         <!-- <div class="input-group date" id="datetimepicker2">
                                                <input type="text" class="form-control" name="txtPreferableCallTime" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                                 </div> -->
                                        <?php /*} else*/ if(isset($data[0]['lead_id']) && $data[0]['lead_assignee'] != 0) { ?>
                                         <input class="form-control" type="text" name="txtPreferableCallTime" value=" <?php echo $data[0]['call_time']?>" id="txtPreferableCallTime" <?php echo $disabled_cc; ?>>

                                        <?php } else { ?>

                                            <div class="input-group date" id="datetimepicker2">
                                                <input type="text" class="form-control" name="txtPreferableCallTime" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                                 </div>
                                        <!-- <select class="form-control default-select2" id="txtPreferableCallTime" name="txtPreferableCallTime" <?php //echo $disabled_cc; ?>>
                                            <option value="" <?php //echo $data[0]['call_time'] == ' ' ? "selected='true'" : '' ?>> -- Select -- </option>
                                            <option value="09-11 AM" <?php //echo $data[0]['call_time'] == '09-11 AM' ? "selected='true'" : '' ?>>09 - 11 AM</option>
                                            <option value="12-02 PM" <?php //echo $data[0]['call_time'] == '12-02 PM' ? "selected='true'" : '' ?>>12 - 02 PM</option>
                                            <option value="02-05 PM" <?php //echo $data[0]['call_time'] == '02-05 PM' ? "selected='true'" : '' ?>>02 - 05 PM</option>
                                            <option value="05-08 PM" <?php //echo $data[0]['call_time'] == '05-08 PM' ? "selected='true'" : '' ?>>05 - 08 PM</option>
                                        </select> -->
                                        <?php } ?>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Preferable Call Time is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Source of Information<span style="color: red;">*</span></label>
                                        <?php if(isset($data[0]['lead_id'])) { ?>
                                        <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white" <?php echo $disabled_cc; ?>>
                                            <option value="" selected="selected">Select Source</option>
                                            <?php $source = $objProd->GetSource(0); ?>
                                            <?php foreach($source as $sources){ ?>
                                             <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["id"] ? "selected='true'" : ''; ?>><? echo $sources["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                        <?php } else { ?>
                                        <select class="form-control default-select2" id="ddlSource" name="ddlSource" data-size="10" data-live-search="true" data-style="btn-white" <?php echo $disabled_cc; ?>>
                                            <option value="" selected="selected">Select Source</option>
                                            <?php $source = $objProd->GetSource(0); ?>
                                            <?php foreach($source as $sources){ ?>
                                             <option value="<? echo $sources["id"]; ?>" <?php echo $data[0]['source'] == $sources["id"] ? "selected='true'" : ''; ?>><? echo $sources["fullname"] ?></option> 
                                            <? } ?>
                                        </select>
                                        <?php } ?>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Source is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label>Description<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtLaedsDesc" name="txtLaedsDesc" rows="6" placeholder="Enter Details about inquiry" <?php echo $disabled_cc; ?>><?php echo $data[0]['lead_desc']; ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Description is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>
                            
                            <!-- Test Result - Start -->
                            <div class="col-md-12" <?php if($data[0]['source'] != 7){ echo "style='display: none;'"; } ?>>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <legend>Test Results</legend>
                                        <table id="myTable" class="table table-striped table-bordered order-list" style="">
                                            <thead>
                                                <tr>
                                                    <th>Test Type</th>
                                                    <th>Status</th>
                                                    <th>Results</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach($test_data as $rows) { ?>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control">
                                                            <option  selected="selected" value="<? echo $rows["test_type_name"];?>" disabled="disabled"><? echo $rows["test_type_name"]; ?></option></select></td>
                                                        <!-- <td><? //echo $rows["test_type_name"]; ?></td> -->
                                                        <!-- <td><? //echo $rows["test_type_status"]; ?></td> -->
                                                        <td><select class="form-control">
                                                            <option  selected="selected" value="<? echo $rows["test_type_status"];?>" disabled="disabled"><? echo $rows["test_type_status"]; ?></option></select></td>
                                                        <td><? echo $rows["results"]; ?></td>
                                                        <td><? echo $rows["remarks"]; ?></td>
                                                    </tr>
                                                <? } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Test Result - End -->

                            <br>

                            <?php if($user_type == 3 AND $data[0]['lead_status_id'] == 1 AND  $data[0]['source'] == 7) { ?>
                            <div class="col-md-12">
                                <div class="col-md-2 form-group">
                                    <button type="button"  class="btn btn-sm btn-primary" id="btnUpdateLeads" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process..." >Update Lead</button>
                                </div>
                            </div>
                            <?php } ?>
                        </fieldset>
                        
                        <!-- Assign Lead (Assign Lead Area Working Only) -->
                        <fieldset <?php if($user_type != '1' AND $user_type != '2' AND $data[0]['lead_assigned_to'] != $login_id AND $data[0]['agent_id'] != $login_id){ echo "style='display: none;'"; } ?>>
                            <legend>Assign Lead</legend>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label-my">Assigned To</label>
                                        <select class="default-select2 form-control" id="assignedTo" name="assignedTo" <? echo $disable_assigned_to; ?>>
                                            <option value="" selected="selected" disabled="true">Select Assignee</option>
                                            <?php $users = $objUser->GetSalesUsers($data[0]['group_id']); ?>
                                            <?php foreach($users as $user){ ?>
                                                <option value="<? echo $user["id"]; ?>" <?php echo $data[0]['lead_assigned_to'] == $user["id"] ? "selected='selected'" : "" ?>><? echo ucfirst($user["first_name"]) ." ". ucfirst($user["last_name"]); ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">User is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label-my">Assigned By</label>
                                        <input type="text" class="form-control" id="assignedBy" name="assignedBy" value="<?php print_r($data[0]['assignee']); ?>" disabled="true">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label-my">Assigned Date/Time</label>
                                        <?php if($data[0]['source'] == 7) { ?>
                                        <input type="text" class="form-control" id="assignedDateTime" name="assignedDateTime" value="<?php echo $data[0]['lead_update_date']; ?>" disabled="true">
                                        <?php } else { ?>
                                        <input type="text" class="form-control" id="assignedDateTime" name="assignedDateTime" value="<?php echo $data[0]['lead_create_date']; ?>" disabled="true">
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                                
                                <!-- For Manual Leads Assgnment - Not working now  -->
                                <div class="col-md-3" style="display: none;">
                                    <div class="form-group">
                                        <label>Activity Note<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtActivity" rows="6" placeholder="Additional Comments" <? echo $disabled_comments; ?>><? echo ($data[0]['lead_status_id'] == 2 || $data[0]['lead_status_id'] == 3 || $data[0]['lead_status_id'] == 4) ? $comments_progress : ''; ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Comments is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <hr>
                                
                            <!-- For Manual Leads Assgnment - Not working now  -->
                            <div class="col-md-12" style="display: none;">
                                <div class="col-md-2 form-group">
                                    <button type="button" class="btn btn-sm btn-primary" id="btnSaveUserLeads" <? echo $disable_assigned_to; ?> data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process...">Assign User</button>
                                </div>
                            </div>
                        </fieldset>
                        
                        <!-- Lead Activity and Test Type For Vatilaty -->
                        <fieldset>
                            <legend>Lead Activity</legend>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Call Result<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlCallResult" name="ddlCallResult" onchange="call_res();" <?php echo $dis_login?>>
                                            <option value="" selected="selected" disabled="disabled">Select Any</option>
                                           <?php $CallResult = $objLead->GetCallResult(); ?>
                                            <?php foreach($CallResult as $CallResults){ ?>
                                             <option value="<? echo $CallResults["id"]; ?>" <?php if($activity_data[0]["lead_call_result"] == $CallResults["id"]){ echo "selected='true'"; } ?>><? echo $CallResults["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Call Result is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lead Status<span style="color: red;">*</span></label>
                                        <select class="form-control default-select2" id="ddlLeadStatus" name="ddlLeadStatus" <?php echo $dis_login?> >
                                            <option value="" selected="selected" disabled="disabled">Select Status</option>
                                           <?php $LeadStatus = $objLead->GetLeadStatus(); ?>
                                            <?php foreach($LeadStatus as $LeadsStatus){ ?>
                                             <option value="<? echo $LeadsStatus["id"]; ?>" <?php if($activity_data[0]["current_state"] == $LeadsStatus["fullname"]){ echo "selected='selected'"; } ?>><? echo $LeadsStatus["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Lead Status is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group" id="meeting_dt" style="display: none;">                        
                                        <label>Meeting Date & Time<span style="color: red;">*</span></label>
                                        <input type="text" class="form-control" id="datetimepicker1" value="<?php echo $activity_data[0]["meeting_time"]?>" placeholder="Meeting Date & Time" name="ddlMeetingTime" <?php echo $dis_login?>>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Meeting Date & Time</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label>Remarks<span style="color: red;">*</span></label>
                                        <textarea type="text" class="form-control" id="txtLeadRemarks" name="txtLeadRemarks" rows="6" placeholder="Enter Remarks" <? echo $disabled_remarks; ?> <?php echo $dis_login?> ><? echo ($data[0]['lead_status_id'] == 3 || $data[0]['lead_status_id'] == 4 || $data[0]['lead_status_id'] == 5 || $data[0]['lead_status_id'] == 6) ? $comments_remarks : ''; ?></textarea>
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Remarks is required</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                <div class="col-md-4 form-group">
                                    <?php if(($user_type == 2 || $user_type == 1) && $data[0]['lead_assigned_to'] == 0){ ?>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnSaveAssignee" onclick="save_lead_user();" <? echo $disabled_lead_activity_button; ?> data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process..." <?php //echo $dis_login?>>Update Assignee</button>
                                    <?php }else{ ?>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnSaveActivityLeads" <? echo $disabled_lead_activity_button; ?> data-loading-text="<i class='fa fa-spinner fa-spin'></i> Process..." <?php echo $dis_login?>>Save Activity</button>
                                    <?php } ?>
                                    
                                    <?php if(($user_type == 1 && ($data[0]['lead_status_id'] == 1 || $data[0]['lead_status_id'] == 3)) || ($user_type == 2 && ($data[0]['lead_status_id'] == 1 || $data[0]['lead_status_id'] == 3))){ ?>
                                            <button type="button" class="btn btn-sm btn-primary" id="btnReasignTask" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process..." onclick="reasign();">Reassign</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            
            <!-- Begin Activities Table -->
            <div class="panel panel-inverse" data-sortable-id="table-stuff-5">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Lead Activities</h4>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date/Time</th>
                                    <!-- <th>Previous State</th> -->
                                    <th>Lead Status</th>
                                    <th>Activity Performed By</th>
                                    <th>Meeting Time</th>
                                    <th>Call Result</th>
                                    <th width="300px">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($activity_data as $row) { ?>
                                    <?php
                                        if($row["current_state"] == 2){
                                            $curr_status = "In Progress";
                                            $pre_status  = "Initiated";
                                        }
                                        elseif($row["current_state"] == 3){
                                            $curr_status = "closed";
                                            $pre_status  = "In Progress";
                                        }
                                        elseif($row["current_state"] == 4){
                                            $curr_status = "verified";
                                            $pre_status  = "closed";
                                        }
                                        elseif($row["current_state"] == 5) {
                                            $curr_status = "Invalid";
                                            $pre_status = "Forwarded";
                                        }elseif($row["current_state"] == 6) {
                                            $curr_status = "ONHOLD/Forwarded";
                                            $pre_status = "In Progress";
                                        }
                                    ?>
                                    <tr>
                                        <td><? echo $row["update_datetime"]; ?></td>
                                        <!-- <td><? //echo $row["previous_state"]; ?></td> -->
                                        <td><? echo $row["current_state"]; ?></td>
                                        <td>
                                            <? 
                                                $user_id = $row["login_id"];
                                                $user = $objUser->GetUsers($user_id);
                                                echo $user[0]['first_name'] . " " . $user[0]['last_name'];
                                            ?>
                                        </td>
                                        <td><? echo $row["meeting_time"]; ?></td>
                                        <td><? echo $row["call_result"]; ?></td>
                                        <td><? echo $row["remarks"]; ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end #content -->

<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
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

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }

   /* .select2-container--default{
        width: 256px !important;
    }

    #txtCNIC{
        width: 256px !important;
    }*/
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        masking();
        call_res();
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Save Leads Assignee //Not working now
        $("#btnSaveUserLeads").click(function () 
        {
            var id          = $('#txtId').val();
            var action      = $('#action').val();
            var assignedTo  = $('#assignedTo').val();
            var assignee    = <?php echo $login_id ?>;   
            var user_type   = <?php echo $user_type ?>;
            var notes       = $('#txtActivity').val();
                        
            if (validation(user_type)) 
            {
                $("#btnSaveUserLeads").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_lead.php",
                    data: 
                    {
                        'id'        :id,
                        'action'    :action,
                        'assignedTo':assignedTo,
                        'assignee'  :assignee,
                        'notes'     :notes
                    },
                    success: function (data) 
                    {
                        //alert(data); return false;
                        //$("#btnSaveUserLeads").button('reset');
                        data = data.trim();
                        //console.log(data);

                        if(data == 'success')
                        {
                            $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "leads_details.php?id=<? echo $lead_id ?>" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });
    });

    // Update Leads By Agent only
    $(document).ready(function() {
        // Update Lead by Agent
        $('#btnUpdateLeads').on('click', function(event){            
            var Form_data = new FormData($('#lead')[0]);
            Form_data.append('action', 'update_lead');
            Form_data.append('id', <?php echo($data[0]['lead_id']); ?>);
            Form_data.append('login_id', <?php echo $login_id ?>);

            /*for (var pair of Form_data.entries())           
            {               
                console.log(pair[0]+ ', '+ pair[1]); 
            }*/
            
            if (validation_update_lead(user_type)) 
            {
                $("#btnUpdateLeads").button('loading');

                $.ajax({
                    type:        "POST",
                    url:         "includes/ajax/action_lead.php",
                    data:        Form_data,
                    traditional: true,
                    contentType: false,
                    cache:       false,
                    processData: false,
                    success: function (data) 
                    {
                        //$("#btnUpdateLeads").button('reset');
                        //alert(data);
                        data = data.trim();
                        //console.log(data);

                        if(data == 'success' || data == 'successsuccess' || data == 'successsuccesssuccess' || data == 'successsuccesssuccesssuccess' || data == 'successsuccesssuccesssuccesssuccess')
                        {
                            $.notifyBar({ cssClass: "success", html: "Lead updated successfully!", delay: 2000, animationSpeed: "normal" });

                            setTimeout(function () { window.location.href = "leads_view.php" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $.notifyBar({ cssClass: "error", html: "Lead not updated!", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });
    });

    /* Load Lead Areas */
    $(document).on('change', '#ddlCity', function () {
        var city = $(this).val();
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:{
                action : "select_lead_city_area",
                city: city
            }

        }).done(function (data) {
            /*alert(data);*/
            $('#ddlArea').html(data);
        });
    });

    // To save sigle or multi tr value as a Jquery jSON.
    function storeTblValues()
    {
        var TableData = new Array();

        $('.tblPermissions tr').each(function(row, tr){

            TableData[row] = {
                "moduleid"  : $(tr).find('td:eq(0)').text()
                ,"create"   : $(tr).find('.chkCreate').is(":checked") ? 1 : 0
                ,"update"   : $(tr).find('.chkUpdate').is(":checked") ? 1 : 0
                ,"delete"   : $(tr).find('.chkDelete').is(":checked") ? 1 : 0
                ,"view"     : $(tr).find('.chkView').is(":checked") ? 1 : 0
            }
        });

        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    
    // Adding Rows Dynamiclly
    $(document).ready(function () {
        var counter = 1;

        $("#addrow").on("click", function () {
            var newRow = $("<tr>");
            var cols = "";

            cols += '<td><select class="form-control" id="ddlTestType' + counter + '" name="ddlTestType' + counter + '">';
                cols += '<option value="" selected="selected" disabled="disabled">Select Status</option>';
                <?php $test_type = $objLead->GetLeadsTestType(); ?>
                <?php foreach($test_type as $test_types) { ?>
                cols += '<option value="<? echo $test_types["id"]; ?>"><? echo $test_types["fullname"] ?></option>';
                <? } ?>
            cols += '</select></td>';

            cols += '<td><select class="form-control" id="ddlLeadTestStatus' + counter + '" name="ddlLeadTestStatus' + counter + '">';
                cols += '<option value="" selected="selected" disabled="disabled">Select Status</option>';
                <?php $LeadTestTypeStatus = $objLead->GetLeadTestTypeStatus(); ?>
                <?php foreach($LeadTestTypeStatus as $LeadsTestTypeStatus) { ?>
                cols += '<option value="<? echo $LeadsTestTypeStatus["id"]; ?>"><? echo $LeadsTestTypeStatus["fullname"] ?></option>';
                <? } ?>
            cols += '</select></td>';

            cols += '<td><input type="text" class="form-control" id="txtLeadsResults' + counter + '" name="txtLeadsResults' + counter + '"></td>';
            cols += '<td><input type="text" class="form-control" id="txtLeadsRmrk' + counter + '" name="txtLeadsRmrk' + counter + '"></td>';

            cols += '<td><input type="button" class="ibtnDel btn btn-sm btn-danger"  value="Delete"></td>';
            newRow.append(cols);
            $("table.order-list").append(newRow);
            counter++;
        });

        $("table.order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();       
            counter -= 1
        });

        // Save Leads Activit
        $('#btnSaveActivityLeads').on('click', function(event){
            event.preventDefault();
            
            var Form_data = new FormData($('#lead')[0]);
            Form_data.append('counter', counter-1);
            Form_data.append('action', 'update_lead_activty');
            Form_data.append('id', <?php echo($data[0]['lead_id']); ?>);
            Form_data.append('login_id', <?php echo $login_id ?>);
            Form_data.append('previous_state', <? echo $data[0]['lead_status_id']; ?>);

            /*for (var pair of Form_data.entries())           
            {               
                console.log(pair[0]+ ', '+ pair[1]); 
            }*/
            
            if (validation(user_type)) 
            {
                $("#btnSaveActivityLeads").button('loading');

                $.ajax({
                    type:        "POST",
                    url:         "includes/ajax/action_lead.php",
                    data:        Form_data,
                    traditional: true,
                    contentType: false,
                    cache:       false,
                    processData: false,
                    success: function (data) 
                    {
                        $("#btnSaveActivityLeads").button('reset');
                        //alert(data);
                        data = data.trim();
                        //console.log(data);

                        if(data == 'success' || data == 'successsuccess')
                        {
                            $.notifyBar({ cssClass: "success", html: "Activity saved successfully!", delay: 2000, animationSpeed: "normal" });

                            setTimeout(function () { window.location.href = "leads_details.php?id=<?php echo $lead_id; ?>" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $.notifyBar({ cssClass: "error", html: "Activity not saved!", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
        });
    });

    function validation(user_type)
    {
        var hasFocus = false;
        var errCount = 0;

        if(user_type == 4)
        {
            if($('#ddlCallResult').val() == null) 
            {
                $('#ddlCallResult').addClass('error-val');
                $('#ddlCallResult').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlCallResult').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlCallResult').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlCallResult').removeClass('error-val');
                $('#ddlCallResult').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#ddlCallResult').parent().find('.input-error').hide();
            }

            if($('#ddlMeetingTime').val() == '') 
            {
                $('#ddlMeetingTime').addClass('error-val');
                $('#ddlMeetingTime').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlMeetingTime').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlMeetingTime').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlMeetingTime').removeClass('error-val');
                $('#ddlMeetingTime').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#ddlMeetingTime').parent().find('.input-error').hide();
            }

            if($('#ddlLeadStatus').val() == null) 
            {
                $('#ddlLeadStatus').addClass('error-val');
                $('#ddlLeadStatus').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlLeadStatus').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlLeadStatus').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlLeadStatus').removeClass('error-val');
                $('#ddlLeadStatus').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#ddlLeadStatus').parent().find('.input-error').hide();
            }

            if($('#txtLeadRemarks').val() == '') 
            {
                $('#txtLeadRemarks').addClass('error-val');
                $('#txtLeadRemarks').parent().find('.input-error').show().css('display', 'inline-block');
                $('#txtLeadRemarks').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#txtLeadRemarks').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtLeadRemarks').removeClass('error-val');
                $('#txtLeadRemarks').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#txtLeadRemarks').parent().find('.input-error').hide();
            }
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function validation_update_lead(user_type)
    {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        if(user_type == 3)
        {
           /* if($('#ddlSalutation').val() == '') 
            {
                $('#ddlSalutation').addClass('error-val');
                $('#ddlSalutation').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlSalutation').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlSalutation').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlSalutation').removeClass('error-val');
                $('#ddlSalutation').parent().find('.select2-container--default').show().removeClass('error-val');
                //$('#txtTitle').parents('.control-group').addClass('success');
                $('#ddlSalutation').parent().find('.input-error').hide();
            }*/

            if($('#txtFName').val() == 0 || $('#txtFName').val() == null) 
            {

                $('#txtFName').addClass('error-val');
                $('#txtFName').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) {
                    $('#txtFName').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtFName').removeClass('error-val');
                //$('#txtFName').parents('.control-group').addClass('success');
                $('#txtFName').parent().find('.input-error').hide();
            }

            if($('#txtLName').val() == 0 || $('#txtLName').val() == null) 
            {

                $('#txtLName').addClass('error-val');
                $('#txtLName').parent().find('.input-error').show().css('display', 'inline-block');

                if (!hasFocus) {
                    $('#txtLName').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtLName').removeClass('error-val');
                $('#txtLName').parent().find('.input-error').hide();
            }

            if($('#txtCNIC').val() == 0 || $('#txtCNIC').val() == null) 
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
                $('#txtCNIC').parent().find('.input-error').hide();
            }

            if($('#ddlGender').val() == '') 
            {
                $('#ddlGender').addClass('error-val');
                $('#ddlGender').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlGender').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlGender').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlGender').removeClass('error-val');
                $('#ddlGender').parent().find('.select2-container--default').show().removeClass('error-val');
                //$('#ddlGender').parents('.control-group').addClass('success');
                $('#ddlGender').parent().find('.input-error').hide();
            }

            if($('#txtMobile').val() == 0 || $('#txtMobile').val() == null) 
            {
                $('#txtMobile').addClass('error-val');
                $('#txtMobile').parent().find('.input-error').show().css('display','inline-block');

                if (!hasFocus) 
                {
                    $('#txtMobile').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtMobile').removeClass('error-val');
                $('#txtMobile').parent().find('.input-error').hide();
            }

            if($('#ddlCity').val() == '') 
            {
                $('#ddlCity').addClass('error-val');
                $('#ddlCity').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlCity').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlCity').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlCity').removeClass('error-val');
                $('#ddlCity').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#ddlCity').parent().find('.input-error').hide();
            }

            if($('#ddlArea').val() == '') 
            {
                $('#ddlArea').addClass('error-val');
                $('#ddlArea').parent().find('.input-error').show().css('display', 'inline-block');
                $('#ddlArea').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#ddlArea').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#ddlArea').removeClass('error-val');
                $('#ddlArea').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#ddlArea').parent().find('.input-error').hide();
            }

            if($('#txtAddress').val() == 0 || $('#txtAddress').val() == null) 
            {
                $('#txtAddress').addClass('error-val');
                $('#txtAddress').parent().find('.input-error').show().css('display','inline-block');

                if (!hasFocus) 
                {
                    $('#txtAddress').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtAddress').removeClass('error-val');
                $('#txtAddress').parent().find('.input-error').hide();
            }

            if($('#ddlProductName').val() == '') 
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
                $('#ddlProductName').parent().find('.input-error').hide();
            }

            if($('#txtPreferableCallTime').val() == '') 
            {
                $('#txtPreferableCallTime').addClass('error-val');
                $('#txtPreferableCallTime').parent().find('.input-error').show().css('display', 'inline-block');
                $('#txtPreferableCallTime').parent().find('.select2-container--default').show().addClass('error-val');

                if (!hasFocus) 
                {
                    $('#txtPreferableCallTime').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtPreferableCallTime').removeClass('error-val');
                $('#txtPreferableCallTime').parent().find('.select2-container--default').show().removeClass('error-val');
                $('#txtPreferableCallTime').parent().find('.input-error').hide();
            }

            if($('#ddlSource').val() == '') 
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
                $('#ddlSource').parent().find('.input-error').hide();
            }

            if($('#txtLaedsDesc').val() == 0 || $('#txtLaedsDesc').val() == null) 
            {
                $('#txtLaedsDesc').addClass('error-val');
                $('#txtLaedsDesc').parent().find('.input-error').show().css('display','inline-block');

                if (!hasFocus) 
                {
                    $('#txtLaedsDesc').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else 
            {
                $('#txtLaedsDesc').removeClass('error-val');
                $('#txtLaedsDesc').parent().find('.input-error').hide();
            }
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function masking()
    {
        $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});

        $.mask.definitions["9"] = null;
        $.mask.definitions["^"] = "[0-9]";
        $(".number").mask("92^^^^^^^^^^");
    } 

    function call_res()
    {
        var callresult = $('#ddlCallResult').val();
        //alert(callresult);
        check_status();

        if(callresult == 1)
        {
            $('#meeting_dt').show();
        }
        else
        {
            $('#meeting_dt').hide();
        } 
    }

    function save_lead_user()
    {
        if($('#assignedTo').val() == 0 || $('#assignedTo').val() == null) 
        {
                $('#assignedTo').addClass('error-val');
                $('#assignedTo').parent().find('.input-error').show().css('display','inline-block');

                if (!hasFocus) 
                {
                    $('#assignedTo').focus();
                    hasFocus = true;
                }
                return false
        }
        else 
        {
            $('#assignedTo').removeClass('error-val');
            $('#assignedTo').parent().find('.input-error').hide();  
        }

        var user        = $('#assignedTo').val();
        var id          = $('#txtId').val();
        var action      = 'update_asignee';
        $.ajax({
            type:        "POST",
            url:         "includes/ajax/action_lead.php",
            data:        { 'action' : action ,'user' : user,'id' : id },
            success: function (data) 
            {
                if(data == "success")
                {
                    $.notifyBar({ cssClass: "success", html: "Activity saved successfully!", delay: 2000, animationSpeed: "normal" });

                    setTimeout(function () { window.location.href = "leads_details.php?id=<?php echo $lead_id; ?>" }, 3000);
                }
                else if(data == 'fail')
                {
                    $.notifyBar({ cssClass: "error", html: "Activity not saved!", delay: 2000, animationSpeed: "normal" });
                }
            }
        });
    }

    function check_status()
    {
        var cal_result = $('#ddlCallResult').val();
        var res = $('#res').val();
        //alert(res);
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:
            {
                'action' : "select_status",
                'cal_result': cal_result,
                'res' : res
            }
        }).done(function (data) {
            //alert(data);
            $('#ddlLeadStatus').html(data);
        });
    }

    function reasign()
    {
        var lead = $('#txtId').val();
        var action = 'reassign_lead'

        $.ajax({
            data: 
            {
                'action':action,
                'id':lead
            },
            type: 'POST',
            url: "includes/ajax/action_lead.php",
            success: function(data) 
            {
                if(data == 'success')
                {
                    //$('html, body').animate({scrollTop: 0}, 600);
                    $.notifyBar({ cssClass: "success", html: "Lead Reassigned Successfully", delay: 2000, animationSpeed: "normal" });
                    setTimeout(function () { window.location.href = "leads_view.php" }, 3000);
                }
                else if(data == 'fail')
                {
                    $.notifyBar({ cssClass: "warning", html: "This lead can't be reasign! Kindly update mapping first.", delay: 2000, animationSpeed: "normal" });
                }
            }
        });
    }
</script>

</body>
</html>