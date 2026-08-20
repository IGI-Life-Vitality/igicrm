<?php
$page_title = "News & Announcement Details";
$permission_type = "view";
$module_id = "15";
$parent_id = '23';
$menu_id = "news_detail";

include('includes/header.php');
include('classes/news.php');
include('classes/group.php');

$objNews = new News();
$objGroup = new Group();

$groups = $objGroup->GetGroups();
//print_r($users); 

 if(isset($_GET)){

    $id  = isset($_GET['id'])?$_GET['id']:0;
     $heading = "";
     $isactive = "";

     if($id > 0){
         $data = $objNews->GetNewsById($id);
         
         //print_r($ids);
          $heading = "News & Announcement";
      }
     else{
         $heading = "News & Announcement";
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
        <li><a href="javascript:;">News & Announcement</a></li>
        <li class="active"> News & Announcement</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"> News & Announcement</h1>
    <!-- end page-header -->
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
                        <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                    </div>
                    <h4 class="panel-title"><?php echo $heading ; ?></h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off" enctype="multipart/form-data">
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
                            <label class="col-md-2 control-label-my">Detail</label>
                            <div class="col-md-4">
                                <textarea disabled = "disabled" class="form-control" name="txtNews" id="txtNews" rows="8" style="    margin: 0px -525.344px 0px 0px;width: 859px;height: 301px"><?php echo $data[0]['detail'];?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label-my">Attach File</label>
                            <div class="col-md-4">
                                 <?php if($data[0]['file'] != '' && $data[0]['file'] != "0"){?> 
                                       <a class="btn btn-info btn-sm"  target="blank" href="uploads/<?php echo $data[0]['file']?>">
                                            Attachment <i class="glyphicon glyphicon-edit icon-white"></i>
                                        </a>
                                        <?php } ?>
                        </div>
                      </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <!--<button type="button" class="btn btn-sm btn-info" onclick="save();">Save</button>-->
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
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        FormWysihtml5.init();
    });


</script>
