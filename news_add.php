<?php
$page_title = "Create News & Announcement";
$permission_type = "create";
$module_id = "15";
$parent_id = '23';
$menu_id = "news_add";

include('includes/header.php');
include('classes/news.php');
include('classes/group.php');

$objNews = new News();
$objGroup = new Group();
$groups = $objGroup->GetGroups();
//print_r($users); 

if(isset($_GET))
{
    $id = isset($_GET['id'])?$_GET['id']:0;
    $heading = "";
    $isactive = "";

    if($id > 0)
    {
        $data = $objNews->GetNewsById($id);
        //print_r($ids);
        $heading = "Edit News & Announcement";
    }
    else
    {
        $heading = "Add News & Announcement";
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

<div id="content" class="content">
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">News & Announcement</a></li>
        <li class="active"><?php echo $heading; ?></li>
    </ol>

    <h1 class="page-header">News & Announcement</h1>

    <div class="noty_bar noty_theme_default noty_layout_top noty_success NotificationDiv" id="notify_success_insert" style="cursor: pointer; display: none;">
        <div class="noty_message">
            <span class="noty_text">Record Saved Successfully</span>
        </div>
    </div>

    <div class="noty_bar noty_theme_default noty_layout_top noty_error NotificationDiv" id="notify_error_insert" style="cursor: pointer; display: none;">
        <div class="noty_message">
            <span class="noty_text">Error while saving record, Please try again!</span>
        </div>
    </div>

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
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                    <h4 class="panel-title"><?php echo $heading ; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Send To</label>
                            <div class="col-md-4">
                                <select class="form-control multiple-select2" id="group" name="group"  multiple="multiple" data-size="10" data-live-search="true" data-style="btn-white"  >
                                    <option value="0" disabled="disabled">Select Group</option>
                                    <?php 
                                          $counter = 0;
                                          $groups_ids =  explode(",",$data[0]['recipient']);?>
                                     <?php foreach($groups as $group){?>
                                    <option value="<?php echo $group['id']; ?>" <?php echo ($groups_ids[$counter] == $group['id'] ? "selected='selected'" : $counter--);?>><?php echo $group['primary_name'] ;?></option>
                                       <?php $counter++;}?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select Group </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Subject/Title</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtSubject" id="txtSubject" value="<?php echo  $data[0]['subject'];?>" placeholder="Subject/Title" data-parsley-required="true"/>
                                <div class="input-error form-control-input" id ="err_sub" style="color: Red; display: none;">News Subject/Title is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Detail</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtNews" id="txtNews" rows="16"><?php echo $data[0]['detail'];?></textarea>
                                <div class="input-error form-control-input" id ="err_detail" style="color: Red; display: none;">Please Enter Detail </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Attach File</label>
                            <div class="col-md-4">
                                <input type="File" name="news_file" id="news_file">
                            </div>
                        </div>

                        <input type="hidden" value="<?php echo $_SESSION['login_id'] ?>" id="sender" name="sender" />
                        <input type="hidden" value="<?php echo $id ;?>" id="id_news" name="id_news" />
                        
                        <br />

                        <div class="form-group">
                            <label class="col-md-2 control-label-my"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" onclick="save();">Save</button>
                                <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

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
        var group     = $('#group').val();
        var news      = $('#txtNews').val();
        var sender    = $('#sender').val();
        var news_id   = $('#id_news').val();
        var path = $('#news_file').val();
        var file = path.replace(/^.*\\/, "");
        var action = "save_update";
         
        upload();

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_news.php",
                data: {'action': action , 'sender' : sender,'subject' : subject , 'group':group , 'news' :news ,'news_id' :news_id , 'file' :file },
                success: function (data) 
                {
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    if(data == 1)
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () { window.location.href = "news_view.php" }, 3000);
                    }
                    else
                    {
                        $('html, body').animate({scrollTop: 0}, 600);
                        $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }

                   setTimeout(function () { window.location.reload(); }, 8000); 
                }
            });
        }
    }

    function upload()
    {
        var file      = $('#news_file').val();
        var file_data = $('#news_file').prop('files')[0];

        var form_data = new FormData();                  
        form_data.append('file', file_data);

        $.ajax({
            url: 'includes/ajax/action_upload.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(script_response){}
        });
    }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;

        if($('#group').val() == '0'|| $('#group').val() == null) {

            $('#group').addClass('error-val');
            $('#group').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#group').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#group').removeClass('error-val');
            $('#group').parent().find('.input-error').hide();
        }

         if($('#txtSubject').val() == '') {

            $('#txtSubject').addClass('error-val');
            $('#txtSubject').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtSubject').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtSubject').removeClass('error-val');
            $('#txtSubject').parent().find('.input-error').hide();
        }

        if($('#txtNews').val() == '') {

            $('#txtNews').addClass('error-val');
            $('#txtNews').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtNews').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtNews').removeClass('error-val');
            $('#txtNews').parent().find('.input-error').hide();
        }

        if (errCount > 0)
            return false;
        else
            return true;
    }
</script>