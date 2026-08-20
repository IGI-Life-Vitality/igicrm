<?php
$page_title = "Create Message";
$permission_type = "create";
$module_id = "14";
$parent_id = '22';
$menu_id = "message_create";

include('includes/header.php');
include('classes/messages.php');

$objMessage = new Message();
$users = $objUser->GetUsers(0);
//print_r($users); 

if(isset($_GET))
{
    $id  = isset($_GET['id'])?$_GET['id']:0;
     $heading = "";
     $isactive = "";

     if($id > 0)
     {
        $data = $objMessage->GetMessageById($id);
        //print_r($ids);
        $heading = "Edit Message";
    }
    else
    {
        $heading = "Add Message";
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
        <li class="active"><?php echo $heading; ?></li>
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
                    </div>
                    <h4 class="panel-title"><?php echo $heading ; ?></h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off">
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Subject/Title</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtSubject" id="txtSubject" value="<?php echo  $data[0]['subject'];?>" placeholder="Subject/Title" data-parsley-required="true"/>
                                <div class="input-error form-control-input" id ="err_sub" style="color: Red; display: none;">Message Subject/Title is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Recipient</label>
                            <div class="col-md-4">
                                <select class="form-control multiple-select2" id="recipient" name="recipient"  multiple="multiple" data-size="10" data-live-search="true" data-style="btn-white"  >
                                    <option value="0" disabled="disabled">Select Recipient</option>
                                    <?php 
                                          $counter = 0;
                                          $users_ids =  explode(",",$data[0]['recipient']);?>
                                     <?php foreach($users as $user){?>
                                    <option value="<?php echo $user['id']; ?>" <?php echo ($users_ids[$counter] == $user['id'] ? "selected='selected'" : $counter--);?>><?php echo $user['user_name'] ;?></option>
                                       <?php $counter++;}?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_recipient" style="color: Red; display: none;">Please Select Recipient </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Message</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtMessage" id="txtMessage" rows="8"><?php echo $data[0]['message'];?></textarea>
                                <div class="input-error form-control-input" id ="err_msg" style="color: Red; display: none;">Please Enter Message </div>
                            </div>
                        </div>

                        <input type="hidden" value="<?php echo $_SESSION['login_id'] ?>" id="sender" name="sender" />
                        <input type="hidden" value="<?php echo $id ;?>" id="id_msg" name="id_msg" />

                        <div class="form-group">
                            <label class="col-md-2"></label>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSaveMessage" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Send Message</button>
                                <button type="reset" class="btn btn-sm btn-danger">Reset</button>
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
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#btnSaveMessage', function () {
            $('#err_sub').hide();
            $('#err_recipient').hide();
            $('#err_msg').hide();
            $('#divSuccess').hide();
            $('#divError').hide();

            var subject   = $('#txtSubject').val();
            var recipient = $('#recipient').val();
            var msg       = $('#txtMessage').val();
            var sender    = $('#sender').val();
            var msg_id    = $('#id_msg').val();
            var action = "save_update";

            if(subject == ""){
                $('#err_sub').show();
                return false;
            }else if(recipient == 0){
                $('#err_recipient').show();
                return false;
            }else if(msg == ""){
                $('#err_msg').show();
                return false;
            }

            /*alert("hi");
            alert(sender);
            alert(subject);
            alert(recipient);
            alert(msg);
            return false;*/
            //alert(recipient);

            $("#btnSaveMessage").button('loading');

            $.ajax({
                type: "POST",
                url: "includes/ajax/action_message.php",
                data: {'action': action , 'sender' : sender,'subject' : subject , 'recipient':recipient , 'msg' :msg ,'msg_id' :msg_id},

                success: function (data) 
                {
                    //$("#btnSaveMessage").button('reset');
                    //data = data.trim();
                    console.log(data);
                    //alert(data);

                    if(data == 1)
                    {
                        $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                        setTimeout(function () { window.location.href = "message_view.php" }, 3000);
                    }
                    else
                    {
                        $('html, body').animate({scrollTop: 0}, 600);
                            $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                    }

                    setTimeout(function () { window.location.reload(); }, 8000);
                }
            });
        });
    });
</script>