<?php
    $page_title = "Search";
    $permission_type = "view";
    $module_id = "0";
    $menu_id = "search";

    include('includes/header.php');
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
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" />


<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">

    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Search</a></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Search</h1>
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
                    </div>
                    <h4 class="panel-title">Search</h4>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" autocomplete="off">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>CNIC <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="txtCNIC" value="" placeholder="42201-xxxxxxx-x">
                            </div>

                            <div class="col-md-4">
                                <label>Policy Number</label>
                                <input type="text" class="form-control" value="" id="policy" name="policy">
                            </div>

                            <div class="col-md-4">
                                <label>Mobile No</label>
                                <input type="text" class="form-control" value="" onkeypress="return validateNumbers(event)" id="mobile" name="mobile">
                            </div>
                        </div>

                        <div style="display:none;" id="divAdvanced">
                            <hr />
                            <div class="col-md-12">
                                <!-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div> -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="" id="email" name="email">
                                        <div class="input-error form-control-input" style="color: Red; display: none;">Email Format is incorrect</div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" value="" id="name" name="name">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <!--< div class="col-md-3">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Is Customer</label>
                                        <div>
                                            <div class="radio radio-css radio-inline radio-inverse">
                                                <input type="radio" name="radioInlineCss" id="radio_inline_css_1" value="1" checked="">
                                                <label for="radio_inline_css_1">
                                                    True
                                                </label>
                                            </div>
                                            <div class="radio radio-css radio-inline radio-danger">
                                                <input type="radio" name="radioInlineCss" id="radio_inline_css_2" value="2">
                                                <label for="radio_inline_css_2">
                                                    False
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>NICOP</label>
                                        <input type="text" class="form-control" id="txtNICOP" value="" onkeypress="return validateNumbers(event)" >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-primary" id="btnSearch" onclick="search();">Search</button>
                                <button type="reset" class="btn btn-sm btn-primary" id="btnClear">Clear Search</button>
                            </div>
                        </div>
                    </form>
                    
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Insured Name</th>
                                <th>Mobile Phone</th>
                                <th>CNIC</th>
                                <th>Policy Number</th>
                                <th>Plan of Insurance</th>
                                <th>Detail</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>
                    </table>
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

<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
<script src="assets/js/ui-modal-notification.demo.min.js"></script>

<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        Notification.init();
        TableManageDefault.init();
        masking();
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#btnAdvancedSearch").click(function(){
            $("#divAdvanced").toggle();
        });

        // $("#btnSearch").click(function(){
        //     window.location.href = "customer_kyc.php";
        // });
    });

    // $(document).on('click', '#btnModal', function () {
    //     //id = $(this).data('id');
    //     $('#ModalWorkcode').modal({ backdrop: 'static', keyboard: false });
    //     $('#ModalWorkcode').modal('show');
    //     return false;
    // });

    function search()
    {
        var CNIC   = $('#txtCNIC').val();
        var policy = $('#policy').val();
        var mobile = $('#mobile').val();
        var email  = $('#email').val();
        var name   = $('#name').val();
        var nicop   = $('#txtNICOP').val();

        //alert(policy);

        if(CNIC != '' || policy != ''  || mobile != '' || email != '' || name != '')
        {
            if(validation())
            {
                $.ajax({
                        data: 
                        {
                            'action'  :'search',
                            'CNIC'    :CNIC,
                            'policy'  :policy,
                            'mobile'  :mobile,
                            'email'   :email,
                            'name'    :name,
                            'nicop'   :nicop

                        },
                        type: 'POST',
                        url: "includes/ajax/action_product.php",
                        success: function(data) 
                        {
                            //data = data.trim();
                            // alert(data);
                            $('#data-table').html(data);
                            $('#data-table').dataTable({ 
                               destroy: true,            
                               responsive: true,            
                               searching: true,            
                               pageLength: 10,            
                               order: [[ 0, "asc" ]]       
                            });
                            //console.log(data);
                        }
                    });
            }
        }
    }

    // function masking()
    // {
    //     $("#txtCNIC").inputmask({"mask": "99999-9999999-9"});
    // }

    function validation()
    {
        var hasFocus = false;
        var errCount = 0;
        var email = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i;

        if($('#email').val() != '' && email.test($('#email').val()) == false) 
        {
             //alert("khan");
            $('#email').addClass('error-val');
            $('#email').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#email').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#email').removeClass('error-val');
            //$('#txtUserId').parents('.control-group').addClass('success');
            $('#email').parent().find('.input-error').hide();
        }
        if (errCount > 0) 
        {
            $('html, body').animate({scrollTop: 0}, 600);
            return false;
        }
        else
            return true;
    }
</script>

</body>
</html>