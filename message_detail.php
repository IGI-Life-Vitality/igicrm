<?php
    $page_title = "Messages";
    $permission_type = "view";
    $module_id = "14";
    $parent_id = '22';
    $menu_id = "message_detail";

    include('includes/header.php');
    include('classes/messages.php');

    $objMessage = new Message();

    if(isset($_GET))
    {
        $id  = isset($_GET['id'])?$_GET['id']:0;
        $heading = "";
        $isactive = "";

        if($id > 0)
        {
            $data = $objMessage->GetMessageById($id);
            //print_r($ids);
            $heading = "Messages";
        }
        else
        {
            $heading = "Messages";
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

<link href="assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.min.css" rel="stylesheet" />

<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Message</a></li>
        <li class="active">Edit Message</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Message</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
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
                    <h4 class="panel-title"><?php echo $heading ; ?></h4>
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
                            <label class="col-md-2 control-label-my">Subject/Title</label>
                            <div class="col-md-4">
                                <input type="text" disabled = "disabled" class="form-control" name="txtSubject" id="txtSubject" value="<?php echo  $data[0]['subject'];?>" placeholder="Subject/Title" data-parsley-required="true"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Date</label>
                            <div class="col-md-4">
                                <input type="text" disabled = "disabled" class="form-control" name="txtdate" id="txtdate" value="<?php echo  $data[0]['create_date'];?>"  data-parsley-required="true"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Message</label>
                            <div class="col-md-4">
                                <textarea class="form-control" disabled = "disabled" name="txtMessage" id="txtMessage" rows="8"><?php echo $data[0]['message'];?></textarea>
                            </div>
                        </div>
                           
                        
                        <br />

                        <div class="form-group">
                            <div class="col-md-4">
                               <!-- <button type="button" class="btn btn-sm btn-info" onclick="save();">Send</button>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-12 -->
    </div>
    <!-- end row -->
</div>
<!-- end #content -->

<!-- begin #footer -->
<?php include('includes/footer.php'); ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
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
        FormWysihtml5.init();
    });
</script>

<script type="text/javascript">
    function save()
    {
        var subject   = $('#txtSubject').val();
        var recipient = $('#recipient').val();
        var msg       = $('#txtMessage').val();
        var sender    = $('#sender').val();
        var msg_id    = $('#id_msg').val();
        var action = "save_update";

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_message.php",
                data: {'action': action , 'sender' : sender,'subject' : subject , 'recipient':recipient , 'msg' :msg ,'msg_id' :msg_id},

                success: function (data) 
                {
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    if(data == 1)
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                    }
                    else
                    {
                        $.notifyBar({ cssClass: "error", html: "Error while saving record, Please try again!", delay: 2000, animationSpeed: "normal" });
                    }

                    setTimeout(function () { window.location.reload(); }, 8000); 
                }
            });
        }
    }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#txtSubject').val() == '') 
        {
            $('#txtSubject').addClass('error-val');
            $('#txtSubject').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtSubject').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtSubject').removeClass('error-val');
            $('#txtSubject').parent().find('.input-error').hide();
        }

        if($('#recipient').val() == '0'|| $('#recipient').val() == null ) 
        {
            $('#recipient').addClass('error-val');
            $('#recipient').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#recipient').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#recipient').removeClass('error-val');
            $('#recipient').parent().find('.input-error').hide();
        }

        if($('#txtMessage').val() == '') 
        {
            $('#txtMessage').addClass('error-val');
            $('#txtMessage').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtMessage').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#txtMessage').removeClass('error-val');
            $('#txtMessage').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }
</script>