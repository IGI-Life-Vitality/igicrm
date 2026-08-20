<?php
    $page_title         = "Legal Complaint Closure Report";
    $permission_type    = "view";
    $module_id          = "63";
    $parent_id          = "25";
    $parent_id2         = "61";
    $menu_id            = "rpt_cmp_legal_complaint_closure";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $year = DATE("Y");                          //Current Year

    $objComplaintReport = new ComplaintReport();
    $data               = $objComplaintReport->countsLegalComplaintClosureAnalysis($year);
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li><a href="javascript:;">Reports Management</a></li>
        <li><a href="javascript:;">Complaint CS & Ops</a></li>
        <li class="active"><? echo $page_title; ?></li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header"><? echo $page_title; ?></h1>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- <div class="col-md-12">
            <? 
                /*echo "<pre>";
                    print_r($data[0]); 
                echo "<pre>";*/
            ?>
        </div> -->

        <div class="col-md-12">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">&nbsp;</h4>
                </div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select class="form-control default-select2" id="getYear" name="getYear" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
                                        <option value="">-- Select Year --</option>
                                        <?php foreach($Years as $Year) { ?>
                                        <option value="<? echo $Year["value"]; ?>" ><? echo $Year["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                    
                                    <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a>
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_legal_complaint_closure.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Legal Complaint Closure Analysis Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b>Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                        <td align="left"></td>
                                        <td align="right">
                                            <b>Total Pages:</b> 1
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b class="spanYear">Year: </b>
                                            <span id="spanYear"> All </span>
                                        </td>
                                        <td align="left"></td>
                                        <td align="right"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <table id="tblTable" class="table table-igi table-bordered table-responsive">
                        <thead>
                            <tr valign="middle">
                                <th width="350px;">Month</th>
                                <th width="150px;">Premium Collected</th>
                                <th width="200px;">Claimed by the Policyholders</th>
                                <th width="200px;">Payments to Policyholders</th>
                                <th width="100px;">Savings</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
                            <?php $PremiumCollected = 0; ?>
                            <?php $ClaimedPolicyholders = 0; ?>
                            <?php $PaymentsPolicyholders = 0; ?>
                            <?php $SumSavings = 0; ?>

                            <?php foreach($data AS $row): ?>
                                <?php 
                                    $Savings = ($row['PremiumCollected']-$row['PaymentToPolicyholder']);
                                ?>
                                <tr>
                                    <td><?php echo $row['MonthName']; ?></td>
                                    <td><?php echo number_format($row['PremiumCollected']); ?></td>
                                    <td><?php echo number_format($row['ClaimedByPolicyholder']); ?></td>
                                    <td><?php echo number_format($row['PaymentToPolicyholder']); ?></td>
                                    <td><?php echo number_format($Savings); ?></td>
                                    <?php  
                                        $PremiumCollected = $PremiumCollected + $row['PremiumCollected'];
                                        $ClaimedPolicyholders = $ClaimedPolicyholders + $row['ClaimedByPolicyholder'];
                                        $PaymentsPolicyholders = $PaymentsPolicyholders + $row['PaymentToPolicyholder'];
                                        $SumSavings = $SumSavings + $Savings;
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td><?php echo number_format($PremiumCollected); ?></td>
                                <td><?php echo number_format($ClaimedPolicyholders); ?></td>
                                <td><?php echo number_format($PaymentsPolicyholders); ?></td>
                                <td><?php echo number_format($SumSavings); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- end panel -->
        </div>
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

<style type="text/css">
    .error-val{
        border: 1px solid red !important;
        border-radius: 4px !important;
    }
</style>

<script>
    var PrintDate;
    var SITE_IP = '<?php echo SITE_IP; ?>';

    $(document).ready(function() {
        App.init();
        FormPlugins.init();
        TableManageDefault.init();

        PrintDate = moment().format('YYYY-MM-DD HH:mm');
        $('#spanPrintDate').html(PrintDate);
    });
</script>

<script type="text/javascript">
    function search()
    {
        var getYear = $('#getYear').val();

        $('#spanYear').html(getYear);
        $('#spanPrintDate').html(PrintDate);

        var YearText  = $('#getYear option:selected').text();

        $('#spanYear').html(YearText);
  
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'     :'search_cmp_legal_complaint_closure_rpt',
                    'getYear'    :getYear
                },
                success: function(data) 
                {
                    //alert(data);
                    console.log(data);
                    var result = data.split("|");

                    if(result[0] == 'success')
                    {
                        $('#tblTable tr').remove();
                        $('#tblTable').html(result[1]); 
                    }
                }
            });
        }
    }

    function exportAllReport()
    {
        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_cmp_legal_complaint_closure_rpt'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_legal_complaint_closure_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function exportFilterReport()
    {
        var getYear = $('#getYear').val();

        if(validation())
        {
            $.ajax({
                type: "POST",
                url: "includes/ajax/action_complaint_rpt.php",
                data:
                {
                    'action': 'export_cmp_legal_complaint_closure_rpt',
                    'getYear': getYear
                },
                success: function(data)
                {
                    data = data.trim();
                    var result = data.split("|");

                    getYear   = result[1];

                    window.open(SITE_IP + "/reports/rpt_cmp_legal_complaint_closure_download.php?getYear="+getYear);
                }
            }).done(function (data) {
                console.log(data);
            });
        }
    }

    function validation()
    {
        //return true;
        var hasFocus = false;
        var errCount = 0;

        if($('#getYear').val() == 0 || $('#getYear').val() == '') 
        {
            $('#getYear').addClass('error-val');
            $('#getYear').parent().find('.input-error').show().css('display', 'inline-block');

            if (!hasFocus) {
                $('#getYear').focus();
                hasFocus = true;
            }
            errCount++;
        }
        else 
        {
            $('#getYear').removeClass('error-val');
            //$('#getYear').parents('.control-group').addClass('success');
            $('#getYear').parent().find('.input-error').hide();
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