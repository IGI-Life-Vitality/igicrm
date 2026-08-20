<?php
    $page_title         = "View Leads";
    $permission_type    = "view";
    $module_id          = "37";
    $parent_id          = "35";
    $menu_id            = "leads_view";

    include('includes/header.php');
    include('classes/lead.php');
    include('classes/product.php');

    $login_id   = $_SESSION['login_id'];
    $group_id   = $_SESSION['group_id'];
    $user_type  = $_SESSION['user_type'];
    $prod_id    = $_SESSION['product_id'];

    $objLead    = new Lead();
    $objProd    = new Product();
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/parsley/src/parsley.css" rel="stylesheet" />
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

<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Leads Management</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Leads Management</h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title"><? echo $page_title; ?></h4>
                </div>

                <div class="panel-body">
                    <fieldset>
                        <legend>Lead Search</legend>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Lead ID</label>
                                        <input type="text" class="form-control" name="txtLeadNum" id="txtLeadNum" value="<? echo isset($_POST['txtLeadNum']) ? $_POST['txtLeadNum'] : ""; ?>" placeholder="LMXXXXXXXXX" maxlength="11">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="">CNIC/NICOP</label>
                                        <input type="text" class="form-control" name="txtCNIC" id="txtCNIC" value="<? echo isset($_POST['txtCNIC']) ? $_POST['txtCNIC'] : ""; ?>" placeholder="42201XXXXXXXX" onkeypress="return validateNumbers(event)" maxlength="13">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select class="form-control default-select2" id="ddlProductName" name="ddlProductName[]" data-size="10" data-live-search="true" data-style="btn-white">
                                            <option value="" selected="selected" disabled >Select Product</option>
                                            <?php $product_categories = $objProd->GetProduct(); ?>
                                            <?php foreach($product_categories as $product_names){ ?>
                                                <option value="<? echo $product_names["id"]; ?>" <? echo $product_names["id"] == $search_product ? "selected='selected'" : "" ?>><? echo $product_names["fullname"] ?></option>
                                            <? } ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Call Back</label>
                                        <input type="text" name="txtCallBack" id="txtCallBack" class="form-control" value="<? echo isset($_POST['txtCallBack']) ? $_POST['txtCallBack'] : ""; ?>" placeholder="Mobile Number" maxlength="12">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="" selected="selected" disabled>Lead Status</label>
                                        <select class="form-control default-select2" id="ddlLeadStatus" name="ddlLeadStatus">
                                            <option selected="selected" disabled>Select Lead Status</option>
                                            <option value="1">Initiated</option>
                                            <option value="2">In Progress</option>
                                            <?php $LeadStatus = $objLead->GetLeadStatus(); ?>
                                            <?php foreach($LeadStatus as $LeadsStatus){ ?>
                                             <option value="<? echo $LeadsStatus["id"]; ?>" <?php if($activity_data[0]["current_state"] == $LeadsStatus["fullname"]){ echo "selected='true'"; } ?>><? echo $LeadsStatus["fullname"] ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select class="form-control default-select2" id="ddlCity" name="ddlCity">
                                            <option value="" selected="selected" disabled="disabled">Select City</option>
                                           <?php $cities = $objProd->GetCity(0); ?>
                                            <?php foreach($cities as $city){ ?>
                                             <option value="<? echo $city["id"]; ?>" <? echo $city["id"] == $search_city ? "selected='selected'" : "" ?>><? echo $city["fullname"]; ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" id="txtFromDate" value="<? echo trim($_POST['txtFromDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtFromDate']))) : ''; ?>" placeholder="Start Date/Time">
                                            <span class="input-group-addon">
                                                <span id="txtFromDateClear" class="glyphicon glyphicon-refresh"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <div class="input-group date" id="datetimepicker2">
                                            <input type="text" class="form-control" id="txtToDate" value="<? echo trim($_POST['txtToDate']) != '' ? date('m/d/Y' ,strtotime(trim($_POST['txtToDate']))) : ''; ?>" placeholder="End Date/Time">
                                            <span class="input-group-addon">
                                                <span id="txtToDateClear" class="glyphicon glyphicon-refresh"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="search();">Search</button>

                                        <button type="reset" class="btn btn-sm btn-primary" onclick="reset();">Reset</button>
                                        
                                        <?php if($user_type == 1 || $user_type == 2){ ?>
                                            <a href="raw_data/export_lead_raw_data.php" class="btn btn-sm btn-success">Export Lead Raw Data</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <table id="lead_grid" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Leads <br>ID</th>
                                    <th>Leads <br>Status</th>
                                    <th>Leads <br>Name</th>
                                    <th>Intersted <br>Products</th>
                                    <th>Call Back</th>
                                    <th>Call Time</th>
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Assigned <br>By</th>
                                    <th>Assigned <br>To</th>
                                    <th>Created <br>Date/Time</th>
                                    <th>Exceed <br>Date/Time</th>
                                </tr>
                            </thead>

                            <tbody>
                                
                            </tbody>
                        </table>
                    </fieldset>
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

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script type="text/javascript">
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();
        //masking();

        $('#tblTable').dataTable({
            destroy: true,
            responsive: true,
            searching: false,
            pageLength: 25,
            order: [[ 0, "desc" ]]
        });

        $(document).on('click', '#txtFromDateClear', function () {
            $("#txtFromDate").val('');
        });

        $(document).on('click', '#txtToDateClear', function () {
            $("#txtToDate").val('');
        });
    });

    function reset()
    {
        $('#txtLeadNum').val('');
        $('#txtCNIC').val('');
        $('#ddlProductName').val('');
        $('#txtCallBack').val('');
        $('#ddlLeadStatus').prop('selectedIndex',0);
        $('#select2-ddlLeadStatus-container').html('Select Lead Status');
        $('#ddlProductName').prop('ddlProductName',0);
        $('#select2-ddlProductName-container').html('Select Product');
        $('#ddlCity').prop('selectedIndex',0);
        $('#select2-ddlCity-container').html('Select City');
        $('#txtFromDate').val('');
        $('#txtToDate').val('');
    }

    function search()
    {
        var lead_num    = $('#txtLeadNum').val();
        var cnic        = $('#txtCNIC').val();
        var product     = $('#ddlProductName').val();
        var call_back   = $('#txtCallBack').val();
        var lead_status = $('#ddlLeadStatus').val();
        var city        = $('#ddlCity').val();
        var FromDate    = $('#txtFromDate').val();
        var ToDate      = $('#txtToDate').val();
  
        if(lead_num != '' || cnic != ''  || product != null || city != null || call_back != '' || lead_status != null  || FromDate != '' || ToDate != '')
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_lead.php",
                data: 
                {
                    'action'     :'search_lead',
                    'lead_num'   :lead_num,
                    'cnic'       :cnic,
                    'product'    :product,
                    'call_back'  :call_back,
                    'lead_status':lead_status,
                    'city'       :city,
                    'FromDate'   :FromDate,
                    'ToDate'     :ToDate
                },
                success: function(data) 
                {
                    //alert(data);
                    //console.log(data);
                    var result = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('#lead_grid').html(result[1]);
                        $('#lead_grid').dataTable({ 
                            destroy: true,            
                            responsive: true,            
                            searching: true,            
                            pageLength: 10,            
                            order: [[ 9, "DESC" ]]       
                        });   
                    }
                 }
            });
        }
    }
</script>

<!-- Datatable with ajax request -->
<script type="text/javascript" language="javascript">
    $( document ).ready(function() {
        var dt = $('#lead_grid').DataTable({
            "bProcessing": true,
            "serverSide": true,
            "searching": false,
            /*"language": 
            {
                searchPlaceholder: "Enter Lead ID / Lead Name / Product Name"
            },*/
            "order": [[ 0, "desc" ]],
            "ajax":
            {
                url : "data-table-query/response_lead.php", //JSON Data Source
                type: "post",                               //Type of Method, GET/POST/DELETE
                error: function(){
                    $("#lead_grid_processing").css("display","none");
                }/*,
                success: function(data){
                    console.log(data);
                }*/
            }
        });

        /*$('.dataTables_filter input[type="search"]').css(
            {
                'width':'295px',
                'display':'inline-block'
            }
        );*/

        /*$(window).load(function(){
            var iets = $('.dataTables_filter input');

            iets.unbind().bind("keyup", function (e) {
                if(iets.val().length >= 3)
                {
                    dt.search(iets.val()).draw();
                }

                if(iets.val() === "")
                {
                    dt.search(iets.val()).draw();
                }
            });
        });*/
    });
</script>

</body>
</html>