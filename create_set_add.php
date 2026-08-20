<?php

$page_title = "Create Set";
$group_id = "question";
$menu_id = "create_set_add";

include('includes/header.php');
include('classes/question.php');
$objQuestion = new Question();

if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;

    $heading = "";
    $isactive = "";

    if($id > 0){
        $data = $objQuestion->GetCreateSet($id);
        $isactive = $data[0]['isactive'] == 1 ? "checked='checked'" : "";
        $heading = "Edit Create Set";
    }
    else{
        $heading = "Create Set";
        $isactive = "checked='checked'";
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
        <li><a href="javascript:;">Question Manager</a></li>
        <li class="active">Create Set</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $heading; ?></h1>
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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Create Set</h4>
                </div>
                <div class="panel-body">

                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                        <strong>Success!</strong>
                        Record Saved Successfully!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                        <strong>Error!</strong>
                        Error while saving record, Please try again!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <form class="form-horizontal" autocomplete="off">

                        <div class="form-group">
                            <label class="col-md-2">Set Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo($data[0]['id']); ?>" placeholder="Id" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2">Set Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo($data[0]['fullname']); ?>" placeholder="Set Name"/>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Set Name is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2">Hierarchy<span style="color: red;">*</span></label>
                            <div class="col-md-4">
                                <select required="true" class="form-control selectpicker" name="txthrr" id="txthrr" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <div class="input-error form-control-input" style="color: Red; display: none;">Select Hierarchy is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <div class="checkbox checkbox-css checkbox-success">
                                    <input class="checkbox checkbox-css checkbox-success" type="checkbox" id="chkIsActive" name="chkIsActive" <?php echo ($isactive); ?> />
                                    <label for="chkIsActive">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-success" onclick="save();">Add</button>
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
<!-- end #content -->

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

    function save() {

        var id = $('#txtId').val() !=0 ? $('#txtId').val() : 0;
        var action = id == 0 ? "save" : "edit";
        var name = $('#txtName').val();
        var hierarchy = $('#txthrr').val();
        var is_active = $('#chkIsActive').is(":checked") ? 1 : 0;

        if(validation()){

            $.ajax({
                data: {
                    'action':action,
                    'id':id,
                    'fullname':name,
                    'hierarchy':hierarchy,
                    'isactive':is_active
                },
                type: 'POST',
                url: "includes/ajax/action_question_set.php",
                success: function(data) {

                    data = data.trim();
                    //alert(data);
                    console.log(data);

                    if(data == 'success'){
                        $('html, body').animate({scrollTop : 0}, 600);
                        $('#divSuccess').show();
                        clear_values();
                    }else if(data == 'fail'){
                        $('#divError').show();
                    }

                    setTimeout(function () { window.location.href = "create_set_list.php" }, 3000);
                }
            });

        }

    }

    function clear_values(){
        $('#txtId').val('');
        $('#txtName').val('');
        $('#txthrr').val('');
    }

    function validation(){

        var hasFocus = false;
        var errCount = 0;


        if($('#txtName').val() == '') {

            $('#txtName').parents('.control-group').addClass('error');
            $('#txtName').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtName').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtName').parents('.control-group').removeClass('error');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#txtName').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }

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

</script>

</body>
</html>

