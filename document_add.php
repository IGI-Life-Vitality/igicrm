<?php
$page_title = "Add Documents";
$permission_type = "create";
$module_id = "16";
$parent_id = '24';
$menu_id = "document_add";

include('includes/header.php');
include('classes/document.php');
include('classes/group.php');

$objDoc = new Docs();
$objGroup = new Group();
$categories = $objDoc->GetCats();

$groups = $objGroup->GetGroups();

 if(isset($_GET)){

     $id  = isset($_GET['id'])?$_GET['id']:0;
     $users = $objUser->GetUsers('0');
     $heading = "";
     $isactive = "";

     if($id > 0){
          $data = $objDoc->GetDocById($id);
         //print_r($ids);

          $isexternal  = $data[0]['is_active'] == 1 ? "checked" : "";
          $isrenewal   = $data[0]['is_active'] == 1 ? "checked" : "";
          $isreminder  = $data[0]['is_active'] == 1 ? "checked" : "";

          $heading = "Edit Documents";
      }
     else{
         $heading = "Add Documents";
     }
 }

?>



<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
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
        <li><a href="javascript:;">Document Uploader</a></li>
        <li class="active">Add Documents </li>
    </ol>
    <!-- end breadcrumb -->
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

    <!-- begin page-header -->
    <h1 class="page-header"> Add Documents</h1>
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
                  
                    <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
                          <div class="form-group">
                            <label class="col-md-2 control-label-my">Subject/Title</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtSubject" id="txtSubject" value="<?php echo  $data[0]['subject'];?>" placeholder="Subject/Title" data-parsley-required="true"/>
                                <div class="input-error form-control-input" id ="err_sub" style="color: Red; display: none;">Document Subject/Title is required</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Detail</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtDocs" id="txtDocs" rows="8" style="    margin: 0px -333.344px 0px 0px;width: 559px;height: 101px"><?php echo $data[0]['detail'];?></textarea>
                                <div class="input-error form-control-input" id ="err_detail" style="color: Red; display: none;">Please Enter Detail </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label-my">External Document URL</label>
                            <div class="col-md-4">
                                <input type="checkbox" onclick='ck_url();' id="chkurl" name="chkurl" <?php echo ($isexternal); ?>/>
                            </div>
                        </div>
                        <div class="form-group" id="shw_url" style="display: none;">
                            <label class="col-md-2 control-label-my">URL</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="url" id="url" value="<?php echo  $data[0]['url'];?>" placeholder="URL" data-parsley-required="true"/>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Category</label>
                            <div class="col-md-4">
                                <select class="form-control multiple-select2" id="category" name="category"  multiple="multiple" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0" disabled>Select Category</option>
                                    <?php 
                                          $counter = 0;
                                          $cat_ids =  explode(",",$data[0]['cat']);?>
                                     <?php foreach($categories as $doccat){?>
                                    <option value="<?php echo $doccat['id']; ?>" <?php echo ($cat_ids[$counter] == $doccat['id'] ? "selected='selected'" : $counter--);?>><?php echo $doccat['cat_name'] ;?></option>
                                       <?php $counter++;}?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select Category </div>
                                  <a href="document_category_add.php">
                                            Add Category <i></i>
                                        </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Owner</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker" id="owner" name="owner" data-size="10" data-live-search="true" data-style="btn-white"  >
                                    <option value="0" selected="selected" disabled>Select Owner</option>
                                     <?php foreach($users as $user){?>
                                    <option value="<?php echo $user['id']; ?>" <?php echo ($data[0]['owner'] == $user['id'] ? "selected='selected'" : '');?>><?php echo $user['user_name'] ;?></option>
                                       <?php } ?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select Owner </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-2 control-label-my">Share</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker" id="share" name="share" data-size="10" data-live-search="true" data-style="btn-white" onchange="chceck_user();" >
                                  <option value="0" selected="selected" disabled>Select Share Type</option>
                                    <option value="1" <?php echo ($data[0]['share'] == "1" ? "selected='selected'" : '');?>>Name</option>
                                    <option value="2" <?php echo ($data[0]['share'] == "2" ? "selected='selected'" : '');?>>Group</option>
                                </select>
                                <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select Share Type</div>
                              </div>
                        </div>

                        <div class="form-group" id="chk_users" style="display: none;">
                            <label class="col-md-2 control-label-my">User</label>
                            <div class="col-md-4">
                                <select class="form-control multiple-select2" id="users" name="users" multiple="multiple">
                                    <option value="0" disabled>Select User</option>
                                    <?php 
                                          if($data[0]['share'] == "1"){
                                          $counter = 0;
                                          $users_ids =  explode(",",$data[0]['share_user']);}?>
                                     <?php foreach($users as $user){?>
                                    <option value="<?php echo $user['id']; ?>" <?php echo ($users_ids[$counter] == $user['id'] ? "selected='selected'" : $counter--);?>><?php echo $user['user_name'] ;?></option>
                                       <?php $counter++;}?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select User </div>
                            </div>
                        </div>

                         <div class="form-group" id="chk_group" style="display: none;">
                            <label class="col-md-2 control-label-my">Group</label>
                            <div class="col-md-4">
                                <select class="form-control multiple-select2" id="group" name="group"  multiple="multiple">
                                    <option value="0">Select Group</option>
                                    <?php  
                                          if($data[0]['share'] == "2"){
                                          $counter = 0;
                                          $groups_ids =  explode(",",$data[0]['share_user']);}?>
                                     <?php foreach($groups as $group){?>
                                    <option value="<?php echo $group['id']; ?>" <?php echo ($groups_ids[$counter] == $group['id'] ? "selected='selected'" : $counter--);?>><?php echo $group['primary_name'] ;?></option>
                                       <?php $counter++;}?>
                                </select>
                                 <div class="input-error form-control-input" id ="err_group" style="color: Red; display: none;">Please Select Group </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Attach File</label>
                            <div class="col-md-4">
                                <input type="File" name="doc_file" id="doc_file">
                        </div>
                      </div>
                            <div class="form-group">
                            <label class="col-md-2 control-label-my">This document require renewal</label>
                            <div class="col-md-4">
                                <input type="checkbox" onclick='ck_renew();' id="chkrenew" name="chkrenew" <?php echo ($isrenewal); ?>/>
                            </div>
                        </div>
                       <div class="form-group" id="shw_exp_dt" style="display: none;">
                            <label class="col-md-2 control-label-my">Expiry Date</label>
                            <div class="col-md-4">
                                 <input type="text" class="form-control" id="datepicker-autoClose" value="<?php echo $objUser->DateTimeToString($data[0]['exp_dt']);?>" placeholder="Expiry Date" />
                                    <!--<div class="input-error form-control-input" style="color: Red; display: none;">From Date Required</div>-->
                        </div>
                      </div>
                             <div class="form-group" id="shw_remind_ck" style="display: none;">
                            <label class="col-md-2 control-label-my">Reminder</label>
                            <div class="col-md-4">
                                <input type="checkbox" onclick='ck_remind();' id="chkremind" name="chkremind" <?php echo ($isreminder); ?>/>
                            </div>
                        </div>
                      <div class="form-group" id="shw_rm_dt" style="display: none;">
                            <label class="col-md-2 control-label-my">Reminder Date</label>
                            <div class="col-md-4">
                                 <input type="text" class="form-control" id="datepicker-autoClose2" value="<?php echo $objUser->DateTimeToString($data[0]['rm_dt']);?>" placeholder="Reminder Date" />
                                    <!--<div class="input-error form-control-input" style="color: Red; display: none;">From Date Required</div>-->
                        </div>
                      </div>
                      <div class="form-group" id="shw_remid_msg" style="display: none;">
                            <label class="col-md-2 control-label-my">Reminder Message</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtreminder" id="txtreminder" rows="8" style="    margin: 0px -525.344px 0px 0px;width: 559px;height: 101px"><?php echo $data[0]['detail'];?></textarea>
                                <div class="input-error form-control-input" id ="err_detail" style="color: Red; display: none;">Please Enter Detail </div>
                            </div>
                        </div>

                        <div class="form-group" id="shw_comments" style="display: none;">
                            <label class="col-md-2 control-label-my">Comments</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtcomments" id="txtcomments" rows="8" style="    margin: 0px -525.344px 0px 0px;width: 559px;height: 101px"><?php echo $data[0]['comments'];?></textarea>
                            </div>
                        </div>



                            <input type="hidden" value="<?php echo $_SESSION['login_id'] ?>" id="creator" name="creator" />
                            <input type="hidden" value="<?php echo $id ;?>" id="id_doc" name="id_doc" />
                        
                        <br />

                        <div class="form-group">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-sm btn-primary" onclick="save();">Save</button>
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
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->

<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
          isedit();
    });


</script>
<script type="text/javascript">

     function save(){
          var subject            = $('#txtSubject').val();
          var detail             = $('#txtDocs').val();
          var url                = $('#url').val();
          var category           = $('#category').val();
          var owner              = $('#owner').val();
          var share              = $('#share').val();
          var users              = $('#users').val();
          var group              = $('#group').val();
          var exp_dt             = $('#datepicker-autoClose').val();
          var rm_dt              = $('#datepicker-autoClose2').val();
          var docs_id            = $('#id_doc').val();
          var reminder_msg       = $('#txtreminder').val();
          var comments           = $('#txtcomments').val();
          var isexternal         ="";
          var isrenewal          ="";
          var isreminder         ="";
          var share_user         ="";
          var checkbox_chkurl    =  $('input[name=chkurl]').prop('checked');
          var checkbox_renew     =  $('input[name=chkrenew]').prop('checked');
          var checkbox_chkremind =  $('input[name=chkremind]').prop('checked');
          var path               = $('#doc_file').val();
          var file               = path.replace(/^.*\\/, "");
          var creator            = $('#creator').val();
          var action = "save_update";

          if(checkbox_chkurl == true){
              isexternal =1;
          }if(checkbox_renew == true){
              isrenewal =1;
          }if(checkbox_chkremind == true){
              isreminder =1;
          }
          if(share ==1){
              share_user = users;
          }else{
              share_user = group;
          }
            upload();
            if(validation()){
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_document.php",
                data: {'action': action, 'subject' : subject, 'detail' : detail, 'url': url, 'category':category, 'owner': owner, 'share': share, 'share_user' : share_user, 'exp_dt' : exp_dt, 'rm_dt' : rm_dt, 'docs_id' : docs_id, 'reminder_msg' : reminder_msg, 'file' : file, 'creator' : creator, 'isexternal' : isexternal, 'isrenewal' : isrenewal, 'isreminder' : isreminder, 'comments' : comments },

                  success: function (data) {
                      console.log(data);
                      //alert(data);
                       if(data == 1){
                           $('#notify_success_insert').show();
                       }else{
                          $('#notify_error_insert').show();
                       }
                   setTimeout(function () { window.location.reload(); }, 8000); 
                }
            });
          }

        return false;
   }


 function upload(){
        var file      = $('#doc_file').val();
        var file_data = $('#doc_file').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);                             
       $.ajax({
                url: 'includes/ajax/action_upload_docs.php', 
                dataType: 'text',  
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    
                }
     });

 }
 function ck_url() {
    var ck_url =  $('input[type=checkbox]').prop('checked');
    if(ck_url == true){
      $('#shw_url').show();
    }else{
      $('#shw_url').hide();
    }
    
}

 function ck_renew() {
    var checkbox_renew =  $('input[name=chkrenew]').prop('checked');
    if(checkbox_renew == true){
      $('#shw_exp_dt').show();
      $('#shw_remind_ck').show();
    }else{
      $('#shw_exp_dt').hide();
      $('#shw_remind_ck').hide();
      $('#shw_rm_dt').hide();
    }   
}
   
  function ck_remind() {
    var checkbox_remind =  $('input[name=chkremind]').prop('checked');
    if(checkbox_remind == true){
      $('#shw_remid_msg').show();
      $('#shw_rm_dt').show();
    }else{
      $('#shw_remid_msg').hide();
      $('#shw_rm_dt').hide();
    }  
} 

 function chceck_user() {
    var is_share =  $('#share').val();
       if(is_share == "1"){
            $('#chk_users').show();
           $('#users').select2();
            $('#chk_group').hide();
     }
       if(is_share == "2"){
            $('#chk_group').show();
            $('#group').select2();
            $('#chk_users').hide();
    }
}
function isedit(){
     var docs_id         = $('#id_doc').val();
     if(docs_id > 0){
         $('#shw_comments').show();
         ck_remind();
         ck_renew();
         ck_url();
         chceck_user();
      }
}

function validation(){

        var hasFocus = false;
        var errCount = 0;


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


        if($('#txtDocs').val() == '') {

            $('#txtDocs').addClass('error-val');
            $('#txtDocs').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#txtDocs').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#txtDocs').removeClass('error-val');
            $('#txtDocs').parent().find('.input-error').hide();
        }

         if($('#category').val() == "0" || $('#category').val() == null ) {

            $('#category').addClass('error-val');
            $('#category').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#category').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#category').removeClass('error-val');
            $('#category').parent().find('.input-error').hide();
        }

         if($('#owner').val() == "0" || $('#owner').val() == null ) {

            $('#owner').addClass('error-val');
            $('#owner').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#owner').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#owner').removeClass('error-val');
            $('#owner').parent().find('.input-error').hide();
        }

         if($('#share').val() == "0" || $('#share').val() == null ) {

            $('#share').addClass('error-val');
            $('#share').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#share').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#share').removeClass('error-val');
            $('#share').parent().find('.input-error').hide();
        }
        if($('#share').val() == "1" && $('#users').val() == null ) {

            $('#users').addClass('error-val');
            $('#users').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#users').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else {
            $('#users').removeClass('error-val');
            $('#users').parent().find('.input-error').hide();
        }
         if($('#share').val() == "2" && $('#group').val() == null ) {

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
        if (errCount > 0)
            return false;
        else
            return true;
    }   

</script>