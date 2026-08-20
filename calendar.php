<?php

$page_title = "Calender";
$permission_type = "view";
$module_id = "10";
$parent_id ="20";
$menu_id = "calender_info";

include('includes/header.php');
include('classes/complaint.php');

/*$objComplaint = new Complaint();
$data = $objComplaint->GetComplaint($login_id,0);*/

?>

<style>
    input[type="file"] {
    display: none;
}
.custom-file-upload {
    /* display: inline-block; */
    /* padding: 6px 12px; */
    margin-top: -4px;
    cursor: pointer;
}
</style>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Calender</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Calender</h1>

    <div class="panel panel-inverse" data-sortable-id="table-basic-2">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a> -->
                <!-- <a href="javascript:;" class="btn btn-icon btn-circle btn-success"><i class="fa fa-plus-square"></i></a> -->
                <!-- <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a> -->
                <label for="file-upload" class="custom-file-upload">
                    <a class="btn btn-icon btn-circle btn-success">
                    <i class="fa fa fa-plus-square"></i></a>
                </label>
                <input id="file-upload" type="file"/>
            </div>
            <h4 class="panel-title">Calender</h4>
        </div>
        <div class="panel panel-body">
            <!-- begin row -->
            <div class="row">
                <!-- begin col-12 -->
                <div class="col-md-12 ui-sortable">
                    <!-- begin Tab panel -->
                    <div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1" data-init="true">
                        <div class="panel-heading p-0">
                            <div class="panel-heading-btn m-r-10 m-t-10">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            </div>
                            <!-- begin nav-tabs -->
                            <div class="tab-overflow overflow-right">
                                <ul class="nav nav-pills nav-tabs-inverse">
                                    <li class="prev-button" style="">
                                        <a href="javascript:;" data-click="prev-tab" class="text-success"><i class="fa fa-arrow-left"></i></a>
                                    </li>
                                    <li class="active">
                                        <a href="#nav-tab-1" data-toggle="tab">Daily Hours</a>
                                    </li>
                                    <li class="">
                                        <a href="#nav-tab-2" data-toggle="tab">Week Ends</a>
                                    </li>
                                    <li class="">
                                        <a href="#nav-tab-3" data-toggle="tab">Holidays</a>
                                    </li>
                                    <li class="next-button" style="">
                                        <a href="javascript:;" data-click="next-tab" class="text-success"><i class="fa fa-arrow-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="nav-tab-1">
                                <!-- begin panel -->
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info"><!-- 4396BB -->
                                        <thead>
                                            <tr role="row">
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Effective From
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Browser: activate to sort column ascending">Effective To
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Platform(s): activate to sort column ascending">Timings
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Engine version: activate to sort column ascending">Options
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                            <tr role="row">
                                                <td>Jan 01, 2009
                                                </td>
                                                <td>Dec 31, 2009</td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table table_margin_bottom table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Seq #</th>
                                                                    <th class="text-center">Start Time</th>
                                                                    <th class="text-center">End Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>09:00:00</td>
                                                                    <td>20:00:00</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm btn-warning m-r-5">Edit</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- end panel -->
                            </div>
                            <div class="tab-pane fade" id="nav-tab-2">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Effective From
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Browser: activate to sort column ascending">Effective To
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Platform(s): activate to sort column ascending">Day Of Week
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Engine version: activate to sort column ascending">Options
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                            <tr role="row">
                                                <td>Jan 01, 2009
                                                </td>
                                                <td>Dec 31, 2009</td>
                                                <td>
                                                    Saturday</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm btn-warning m-r-5">Edit</a>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                                <td>Jan 01, 2009
                                                </td>
                                                <td>Dec 31, 2009</td>
                                                <td>
                                                    Sunday</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm btn-warning m-r-5">Edit</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-tab-3">
                                <div class="table-responsive">
                                    <table id="data-table" class="table table-striped text-center table-bordered dataTable no-footer dtr-inline" role="grid" aria-describedby="data-table_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">From
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Browser: activate to sort column ascending">To
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Platform(s): activate to sort column ascending">Repeat Every Year
                                                </th>
                                                <th class="text-center" tabindex="0" aria-controls="data-table" aria-label="Engine version: activate to sort column ascending">Options
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>    
                                            <tr role="row">
                                                <td>Jan 25, 2010
                                                </td>
                                                <td>Jan 25, 2010</td>
                                                <td>
                                                    True</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm btn-warning m-r-5">Edit</a>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                                <td>Jan 25, 2010
                                                </td>
                                                <td>Jan 25, 2010</td>
                                                <td>
                                                    False</td>
                                                <td>
                                                    <a href="javascript:;" class="btn btn-sm btn-warning m-r-5">Edit</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end Tab panel -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
        </div>
    </div>

    <!-- end page-header -->

    
</div>
<!-- end #content -->

<!-- begin #footer -->
<?php include('includes/footer.php') ?>
<!-- end #footer -->

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();

        $('input[type=radio][name=radioInlineCss]').change(function() {
            if (this.value == '1') {
                $("#div_misc").show();
            }
            else if (this.value == '2') {
                $("#div_misc").hide();
            }
        });
    });
</script>

<script type="text/javascript">

    $('input[name=rdEmail]:checked').val()

</script>

</body>
</html>
