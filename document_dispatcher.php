<?php

$page_title = "Document Dispatcher";
$permission_type = "view";
$module_id = "0";
$menu_id = "document_dispatcher";
$sub_module_id = "0";

include('includes/header.php');

$heading = "Document Dispatcher";

$dir="uploads_document_dispatcher/";

$sub_dir = scandir($dir);

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
        <li><a href="javascript:;">Agent Productivity Tools</a></li>
        <li class="active">Document Dispatcher</li>
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
                    <h4 class="panel-title">Channel Selection</h4>
                </div>
                <div class="panel-body">

                    <div class="alert alert-success fade in m-b-15" id="divSuccess" style="display: none;">
                        <strong>Success!</strong>
                        Email Send Successfully!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <div class="alert alert-danger fade in m-b-15" id="divError" style="display: none;">
                        <strong>Error!</strong>
                        Error while dispatching document, Please try again!
                        <span class="close" data-dismiss="alert">&times;</span>
                    </div>

                    <form class="form-horizontal" autocomplete="off">

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Channel Type</label>
                            <div class="col-md-6">
                                <div class="radio radio-css radio-inline radio-inverse">
                                    <input type="radio" name="radioInlineCss" id="radio_inline_css_1" value="1" checked="">
                                    <label for="radio_inline_css_1">
                                        Email
                                    </label>
                                </div>
                                <div class="radio radio-css radio-inline radio-danger">
                                    <input type="radio" name="radioInlineCss" id="radio_inline_css_2" value="2">
                                    <label for="radio_inline_css_2">
                                        Courier
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Email Address<span style="color: red;">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txtEmail" name="txtEmail" value="" placeholder="abc@example.com" />
                                <div class="input-error form-control-input" id ="err_email" style="color: Red; display: none;">Email is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Home Address</label>
                            <div class="col-md-6">
                                <textarea placeholder="Residential Address" rows="5" id="txtAddress" name="txtAddress" class="form-control"><?php ?></textarea>
                                <div class="input-error form-control-input" id ="err_home_address" style="color: Red; display: none;">Home Address is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Attachment</label>
                            <div class="col-md-6">
                                <select class="form-control default-select2" id="directories" name="directories" onchange="dir_files();">
                                    <option disabled="disabled" selected="selected" value="0">Select Directory</option>
                                     <?php for($a=2;$a<count($sub_dir);$a++){?>

                                       <option value="<?php echo $sub_dir[$a]; ?>"><?php echo $sub_dir[$a]; ?></option>
                                    <?php }?>

                                </select>
                                <div class="input-error form-control-input" id ="err_dir" style="color: Red; display: none;">Please Select Attachment</div>

                                <br>
                                <br>
                                <select class="form-control default-select2" id ="files" name="files">
                                    <option disabled="disabled" selected="selected" value="0">Select File(s)</option>
                                </select>
                                <div class="input-error form-control-input" id ="err_file" style="color: Red; display: none;">Please Select Attachment File</div>
                            </div>
                        </div>
                        <input type="hidden" name="d_path" id="d_path" value="<?php echo $dir;?>">

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-info" onclick="save();">Submit & Send</button>
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

    function dir_files(){
        var dir = $('#directories').val();
        var dpath = $('#d_path').val();
        var filepath =  dpath + dir + '/';
        //alert(filepath);
        var action = "scandir";

        $.ajax({
            type: "POST",
            //url: "scandir.php",
            url: "includes/ajax/action_document_dispatcher.php",
            data: {'action': action , 'filepath' : filepath},
            success: function (data) {
                //data = data.trim();
                console.log(data);
                $('#files').html(data);
            }

        });

    }

    function save(){

         //alert("hi");
         $('#err_email').hide();
         $('#err_home_address').hide();
         $('#err_dir').hide();
         $('#err_file').hide();

         var channel = $("input[name='radioInlineCss']:checked").val()
         var email = $('#txtEmail').val();
         var home_address = $('#txtAddress').val();

         var dir = $('#directories').val();
         var dpath = $('#d_path').val();
         var file = $('#files').val();
         var filepath =  dpath + dir +"/"+file;
         var action = "sendmail";
         var folder = dpath + dir;

          if(email == ""){
             $('#err_email').show();
             return false;
          }else if(home_address == ""){
            $('#err_home_address').show();
            return false;
          }else if(dir == "0" || dir == null || dir == "" ){
             $('#err_dir').show();
             return false;
          }else if(file == "0" || file == null || file == ""){
             $('#err_file').show();
             return false;
          }

        if(channel == 1){

         $.ajax({
                type: "POST",
                url: "includes/ajax/action_document_dispatcher.php",
                data: {
                    'action'        : action ,
                    'dir'           : dir ,
                    'file'          : file ,
                    'filepath'      : filepath,
                    'email'         : email ,
                    'folder'        : folder ,
                    'home_address'  : home_address
                },

                success: function (data) {
                    //data = data.trim();
                    console.log(data);
                    //alert(data);
                    if(data == "success"){
                         $('#divSuccess').show();
                     }else{
                        $('#divError').show();
                     }

                   setTimeout(function () { window.location.reload(); }, 3000); 
                    
                }

            });
        }
        
    }

</script>

</body>
</html>

