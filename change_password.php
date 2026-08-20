<?php
$page_title = "change_password";
$permission_type = "create";
$module_id = "53";
$parent_id = '20';
$menu_id = "change_password";

include('includes/header.php');
$heading = "Change Password";
$title .= "<li class='active'> Change Password </li>";
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
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class='active'><a href="javascript:;">User Management</a></li>
        <?php echo $title; ?>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Change Password</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $heading; ?></h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="" method="POST">
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Old Password</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" id="oldpassword"  name="oldpassword" value="" placeholder="Old Password"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Old Password is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">New Password</label>
                            <div class="col-md-4">
                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="New Password"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">New Password is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnupdatepassword">Update Password</button>
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
    });
</script>


<script type="text/javascript">

    $(document).ready(function() {

        $(document).on('click', '#btnupdatepassword', function () {

            var action      ="ChangePassword";
            var password    = $('#password').val();
            var oldpassword = $('#oldpassword').val();
            
            if(validation()){

                $("#btnupdatepassword").button('loading');

                $.ajax({
                    data: {
                        'action':action,
                        'password':password,
                        'oldpassword':oldpassword
                    },
                    type: 'POST',
                    url: "includes/ajax/action_login.php",
                    success: function(data) {

                        $("#btnupdatepassword").button('reset');

                        data = data.trim();
                        //alert(data);
                        //console.log(data);

                        if(data == 'success'){
                            clear_values();
                            $.notifyBar({ cssClass: "success", html: "Password Changed  Successfully", delay: 2000, animationSpeed: "normal" });
                            setTimeout(function () { window.location.href = "dashboard.php" }, 3000);
                        }else if(data == 'fail'){
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                        }else if(data == 'wrong_old_password'){
                            $.notifyBar({ cssClass: "error", html: "Error Wrong Old Password", delay: 2000, animationSpeed: "normal" });
                        }
                    }
                });

            }
        });
    });


    function validation() {

        var hasFocus = false;
        var errCount = 0;

        if ($('#password').val() == '') {

            $('#password').addClass('error-val');
            $('#password').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#password').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#password').removeClass('error-val');
            $('#password').parent().find('.input-error').hide();
        }

        if ($('#oldpassword').val() == '') {

            $('#oldpassword').addClass('error-val');
            $('#oldpassword').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#oldpassword').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#oldpassword').removeClass('error-val');
            $('#oldpassword').parent().find('.input-error').hide();
        }
     /*if($('#txtPassword').val() != '' && $('#txtConfirmPassword').val() != ''){
            var password = $('#oldpassword').val();
            var confirmpass = $('#password').val();
        if(password != confirmpass) {

                $('#password').addClass('error-val');
                //$('#txtUserId').parents('.control-group').addClass('success');
                $('#password').parent().find('.input-error').hide();
                $('#password').parent().find('.input-error1').show();

                if (!hasFocus) {
                    $('#password').focus();
                    hasFocus = true;
                }
                errCount++;
            }
            else {
                $('#password').removeClass('error-val');
                //$('#txtConfirmPassword').parents('.control-group').addClass('error');
                $('#password').parent().find('.input-error1').hide();
                $('#password').parent().find('.input-error').hide();
                //$('#txtConfirmPassword').parent().find('.input-error1').show().css('display', 'inline-block');


            }
    }*/
        if (errCount > 0)
            return false;
        else
            return true;

    }

    function clear_values(){
        
        $('#password').val('');
        $('#oldpassword').val('');
    }

</script>

</body>
</html>