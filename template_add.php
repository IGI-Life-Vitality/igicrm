<?php
$page_title = "Add Template";
$permission_type = "create";
$module_id = "9";
$parent_id ="20";
$menu_id = "template_add";

include('includes/header.php');
include('classes/templates.php');

$objTemplate = new Templates();

 if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;
     $heading = "";
     $isactive = "";

     if($id > 0){
         $data = $objTemplate->GetTemplateById($id);
         $isactive = $data[0]['is_active'] == 1 ? "checked" : "";
          $heading = "Edit Template";
      }
     else{
         $heading = "Add Template";
         $isactive = "checked";
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

<style>
    .shd-mh {
        display: inline-block;
        color: #ccc;
    }

    #sc-box .well a {
        margin-right: 3px;
        margin-bottom: 3px;
        display: inline-block;
        text-decoration: none;
    }

    .label{
        display: inline;
        padding: .2em .6em .3em;
        font-size: 85%;
        font-weight: bold;
        line-height: 1;
        color: #ffffff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }

    .well {
        margin: 0px 16px 0px 16px !important;
        padding: 20px 20px !important;
        min-height: 20px;
        padding: 19px;
        /* margin-bottom: 20px; */
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        /* border-radius: 4px; */
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
    }

    .my-lab{
        margin:10px 0px 0px 16px;
    }
</style>

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Template Manager</a></li>
        <li class="active">Add Template</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Template Manager</h1>
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
                            <label class="col-md-2 control-label-my">Id</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="txtId" value="<?php echo $id; ?>" placeholder="Id" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Template Type</label>
                            <div class="col-md-4">
                                <select class="form-control selectpicker" id="ddlTemplateType" name="ddlTemplateType" data-size="10" data-live-search="true" data-style="btn-white">
                                    <option value="0">Select Template Type</option>
                                    <option value="Attachement" <?php if($data[0]['template_type'] == 'Attachement'){ echo 'selected';}?>>Attachement</option>
                                    <option value="Email" <?php if($data[0]['template_type'] == 'Email'){ echo 'selected';}?>>Email</option>
                                    <option value="SMS" <?php if($data[0]['template_type'] == 'SMS'){ echo 'selected';}?>>SMS</option>
                                </select>
                                 <div class="input-error form-control-input" id ="err_type" style="color: Red; display: none;">Please Select Template Type </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Template Name</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtName" id="txtName" value="<?php echo  $data[0]['template_name'];?>" placeholder="Template Name" data-parsley-required="true"/>
                                <div class="input-error form-control-input" id ="err_name" style="color: Red; display: none;">Template Name is required</div>
                            </div>
                        </div>




                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Description</label>
                            <div class="col-md-4">
                                <textarea class="form-control" name="txtDescription" id="txtDescription" rows="2" placeholder="Description"><?php echo $data[0]['template_desc'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Subject</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="txtSubject" id="txtSubject" value="<?php echo  $data[0]['template_subject'];?>" placeholder="Subject" data-parsley-required="true"/>
                                <div class="input-error form-control-input" id ="err_sub" style="color: Red; display: none;">Subject is required</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Is Active</label>
                            <div class="col-md-4">
                                <input type="checkbox" id="chkIsActive" name="chkIsActive" <?php echo ($isactive); ?> />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sc-lists" class="my-lab">
                                <a href="javascript:;" class="shd-mh" data-shd-key="44ql7ZGaYA" tabindex="-1">
                                    <i class="glyphicon glyphicon-question-sign"></i></a> Short Codes <a href="javascript:;" class="sc-opener"><span class="glyphicon glyphicon-chevron-up"></span></a></label>
                            <div id="sc-box" class="sHide" style="display: block;">
                                <div class="well">
                                    <a href="javascript:;" class="tooltips lethe-sc" data-lethe-scf="details" title="" data-original-title="Name Prefix">
                                        <span class="label label-danger">{NAME_PREFIX}</span>
                                    </a>
                                    <a href="javascript:;" class="tooltips lethe-sc" data-lethe-scf="details" title="" data-original-title="Address Prefix">
                                        <span class="label label-danger">{ADDRESS_PREFIX}</span>
                                    </a>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body panel-form">
                             <textarea class="ckeditor animated" id="editor1" name="editor1"><?php echo $data[0]['template_detail'];?></textarea>
                        </div>

                        <br />

                        <div class="form-group">
                            <div class="col-md-4">
                                <!--<button type="button" class="btn btn-sm btn-success" id="btnSaveTemplate" >Submit</button>-->
                                <button type="button" class="btn btn-primary btn-sm" id="btnSaveTemplate" onclick="save();" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Process...">Save</button>
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
<script src="assets/plugins/ckeditor/ckeditor.js"></script>
<script src="assets/plugins/bootstrap-wysihtml5/dist/bootstrap3-wysihtml5.all.min.js"></script>
<script src="assets/js/form-wysiwyg.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script src="assets/js/autosize.js"></script>

<script>
    $(document).ready(function() {

        App.init();
        FormPlugins.init();
        FormWysihtml5.init();

        /* Short Code Opener */
        $(".sc-opener").click(function(){
            if($(this).find('span,i').hasClass("glyphicon-chevron-down")){
                $(this).find('span,i').removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
            }else{$(this).find('span,i').removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");}
            $("#sc-box").slideToggle();
        });


        //tinyMCE.get($(this).data('lethe-scf'));
        /* Short Code Insert */
        $(".lethe-sc").click(function(){
            var myField = CKEDITOR.instances['editor1'].getData($(this).data('lethe-scf'));
            //alert(myField);
            if (document.selection) {
                myField.focus();
                sel = document.selection.createRange();
                sel.text = $(this).find('span').html();
            }
            else if (document.getSelection) {
                //tinyMCE.activeEditor.selection.setContent($(this).find('span').html());
                CKEDITOR.instances['editor1'].insertHtml($(this).find('span').html());
                myField.focus();
            }
        });

    });

</script>
<script type="text/javascript">

     function save(){
         
          $('#err_type').hide();
          $('#err_name').hide();
          $('#err_sub').hide();
          $('#divSuccess').hide();
          $('#divError').hide();

          var isActive =  "";
          var template_id = $('#txtId').val();
          var template_type = $('#ddlTemplateType').val();
          var template_name = $('#txtName').val();
          var template_desc = $('#txtDescription').val();
          var template_subject = $('#txtSubject').val();
          var checkbox_isactive =  $('input[type=checkbox]').prop('checked');
          var template_detail = CKEDITOR.instances['editor1'].getData();

         //alert(template_detail);
         //return false;

          var action = "save_update";

          if (checkbox_isactive == true ){
               isActive = 1;
          }else{
              isActive = 0;
          }
          
          if(template_type == 0){
            $('#err_type').show();
            return false;
          }else if(template_name == ""){
             $('#err_name').show();
             return false;
          }else if(template_subject == ""){
             $('#err_sub').show();
             return false;
          }

         $("#btnSaveTemplate").button('loading');

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_template.php",
            data: {'action': action , 'template_id' : template_id,'template_type' : template_type , 'template_name':template_name , 'template_desc' :template_desc , 'template_subject' : template_subject , 'isActive' : isActive , 'template_detail' : template_detail },

            success: function (data) {
                //alert(data);
                $("#btnSaveTemplate").button('reset');
                console.log(data);

                 if(data == 1){
                     clear_values();
                     $.notifyBar({ cssClass: "success", html: "Data Saved Successfully", delay: 2000, animationSpeed: "normal" });
                     setTimeout(function () { window.location.href = "template_view.php" }, 3000);
                 }else{
                     $.notifyBar({ cssClass: "error", html: "Error Occured", delay: 2000, animationSpeed: "normal" });
                 }
            }

        });
         

}

     function clear_values(){
         $('#txtId').val('');
         $('#txtName').val('');
         $('#txtDescription').val('');
         $('#txtSubject').val('');
         $('#ddlTemplateType').val(0);
     }

</script>