<?php
    $page_title         = "Add User Mapping";
    $permission_type    = "create";
    $module_id          = "40";
    $parent_id          = "35";
    $menu_id            = "add_user_mapping";

    include('includes/header.php');
    include('classes/product.php');
    include('classes/lead.php');

    $objProd = new Product();
    $objLead = new Lead();

    if(isset($_GET))
    {
        $id  = isset($_GET['id'])?$_GET['id']:0;

        $heading = "";
        $isactive = "";

        if($id > 0)
        {
            $data       = $objLead->GetLeadsUserById($id);
            $isactive   = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
            $heading    = "Edit Leads User";
            $title      .= "<li><a href='hospital_view.php'>View Leads User</a></li>";
            $title      .= "<li class='active'>Edit Leads User</li>";
            $disabled = "disabled=disabled";
        }
        else
        {
            $heading    = "Add User Mapping";
            $isactive   = "checked='checked'";
            $title      .= "<li class='active'>Add User Mapping</li>";
        }
    }
    //print_r($data);
?>

<!-- ================= BEGIN PAGE LEVEL STYLE ================== -->
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
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Leads Management</a></li>
        <li class='active'><a href="javascript:;"><?php echo $heading; ?></a></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <?php 
      // echo "<pre>";
      //   print_r($data[0]);
      // echo "</pre>";
    ?>

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="" method="POST" id="LeadsMapping">
                        <input type="hidden" value="<?php echo($data[0]['id']); ?>" name="leads_user_id" id="leads_user_id">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $data[0]['id'] ?>">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">User Type</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="user_type" name="user_type" onchange="getsalesuser();" <?php echo $disabled ?>>
                                    <option value="" selected="selected"> -- Select Type  -- </option>
                                     <option value="2" <?php if($data[0]['user_type'] == 2){ echo "selected='selected'"; } ?>>Head Of Sale</option>
                                     <option value="4" <?php if($data[0]['user_type'] == 4){ echo "selected='selected'"; } ?>>Regional Manager</option>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">User Type is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Product(s) Name</label>
                            <div class="col-md-4">
                                <!-- <? //if($data[0]["product_id"] != "") { ?> -->
                                <select class="form-control default-select2" id="prod" name="prod[]" data-size="10" data-live-search="true" data-style="btn-white" multiple="multiple">
                                    <option value="" disabled="">Select Product(s)</option>
                                <?php
                                    $prod =  $objProd->GetProduct(); 
                                    //print_r($prod); die;
                                    $counter      = 0;
                                    $user_prod = explode(",", $data[0]["product_id"]);
                                ?>
                                <?php foreach($prod as $prods) { ?>
                                    <option value="<? echo $prods["id"]; ?>" <?php echo ($user_prod[$counter] == $prods["id"] ? "selected='selected'" : $counter--); ?>><? echo $prods["fullname"] ?></option>
                                <? $counter++; } ?>
                                </select>
                                <!-- <? //} else { ?>
                                    <select class="form-control default-select2" id="prod" name="prod[]" data-size="10" data-live-search="true" data-style="btn-white" multiple="multiple"></select>
                                <? //} ?> -->
                                <div class="input-error form-control-input" style="color: Red; display: none;">Product(s) is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Map User</label>
                            <div class="col-md-4">
                                <select class="form-control default-select2" id="users" name="users" <?php echo $disabled ?>></select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Regional Manager is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveLeadsMapping" onclick="save();">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-6 -->
    </div>
    <!-- end row -->

</div>

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
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }

    .select2-container--default{
        width: 400px !important;
    }
</style>

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
    });
</script>

<script type="text/javascript"> 
    $(document).ready(function() {
        getsalesuser();
    });

    function save()
    {
            var id        = $('#leads_user_id').val() !=0 ? $('#leads_user_id').val() : 0;
            var action    = id == 0 ? "leads_user_save" : "leads_user_update";
            var user_type = $('#user_type').val();
            var prod      = $('#prod').val();
            var users     = $('#users').val();

            if(validation())
            {
                $("#btnSaveLeadsMapping").button('loading');

                $.ajax({
                    type: "POST",
                    url: "includes/ajax/action_lead.php",
                    data: 
                    {
                        'action':action,
                        'id':id,
                        'user_type':user_type,
                        'prod':prod,
                        'users': users
                    },
                    success: function(data) 
                    {
                        //alert(data);
                        //$("#btnSaveLeadsMapping").button('reset');

                        data = data.trim();
                        //alert(data);
                        console.log(data);

                        if(data == 'success')
                        {
                            $.notifyBar({ cssClass: "success", html: "Lead User saved successfully!", delay: 2000, animationSpeed: "normal" });
                            //clear_values();
                            setTimeout(function (){ window.location.href = "lead_users_view.php" }, 3000);
                        }
                        else if(data == 'fail')
                        {
                            $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Lead User not saved!", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });
            }
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#user_type').val() == '') 
        {
            $('#user_type').addClass('error-val');
            $('#user_type').parent().find('.input-error').show().css('display', 'inline-block');
            $('#user_type').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#user_type').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#user_type').removeClass('error-val');
            $('#user_type').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#user_type').parent().find('.input-error').hide();
        }

        if($('#prod').val() == null) 
        {
            $('#prod').addClass('error-val');
            $('#prod').parent().find('.input-error').show().css('display', 'inline-block');
            $('#prod').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#prod').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#prod').removeClass('error-val');
            $('#prod').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#prod').parent().find('.input-error').hide();
        }

        if($('#users').val() == null) 
        {
            $('#users').addClass('error-val');
            $('#users').parent().find('.input-error').show().css('display', 'inline-block');
            $('#users').parent().find('.select2-container--default').show().addClass('error-val');

            if (!hasFocus) 
            {
                $('#users').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#users').removeClass('error-val');
            $('#users').parent().find('.select2-container--default').show().removeClass('error-val');
            $('#users').parent().find('.input-error').hide();
        }

        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }

    function getsalesuser()
    {
        var type = $('#user_type').val();
        var user_id = $('#user_id').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_lead.php",
            data:
            {
                'action' : "get_lead_user",
                'type': type,
                'user_id':user_id
            }
        }).done(function (data) {
            //alert(data);
            $('#users').html(data);
        });
    }
</script>

</body>
</html>