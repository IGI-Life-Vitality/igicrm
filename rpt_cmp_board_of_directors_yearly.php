<?php
    $page_title         = "Board Of Directors Yearly Report";
    $permission_type    = "view";
    $module_id          = "71";
    $parent_id          = "25";
    $parent_id2         = "61";
    $menu_id            = "rpt_cmp_board_of_directors_yearly";

    include('includes/header.php');
    include('classes/complaint_rpt.php');

    $login_id = $_SESSION['login_id'];

    $year_last  = DATE("Y", strtotime("-1 year"));    //Last Year
    $year       = DATE("Y");                          //Current Year
    $status     = "1,2,5,6";

    $objComplaintReport = new ComplaintReport();
    $forum_names        = $objComplaintReport->getForumFromDBById('');
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Year</label>
                                    <select class="form-control default-select2" id="getYear" name="getYear" data-size="10" data-live-search="true" data-style="btn-white">
                                        <option value="">-- Select Year --</option>
                                        <?php $Years = $objComplaintReport->getYearFromDB(); ?>
                                        <?php foreach($Years as $Year){ ?>
                                        <option value="<? echo $Year["value"]; ?>" ><? echo $Year["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                    <div class="input-error form-control-input" style="color: Red; display: none;">Year is required</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Forum</label>
                                    <select class="form-control default-select2" id="getForum" name="getForum" data-size="10" data-live-search="true" data-style="btn-white">
                                        <?php $Forums = $objComplaintReport->getForumFromDB(); ?>
                                        <option value="">-- Select Forum --</option>
                                        <?php foreach($Forums as $Forum){ ?>
                                        <option value="<? echo $Forum["id"]; ?>" ><? echo $Forum["fullname"]; ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" name="search" class="btn btn-sm btn-primary" onclick="search();">Filter Complaint</button>
                                    
                                    <a href="" onclick="exportAllReport(); return false;" class="btn btn-sm btn-success">Export All</a>
                                    
                                    <a href="" onclick="exportFilterReport(); return false;" class="btn btn-sm btn-success">Export Filter</a>

                                    <a href="javascript: window.location.href = 'rpt_cmp_board_of_directors_yearly.php'" class="btn btn-sm btn-inverse">Reset</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <table id="tblMyTable" class="table table-igi table-responsive">
                                <tbody>
                                    <tr>
                                        <td align="left">
                                            <h4>Board Of Directors Yearly Report</h4>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <img src="assets/img/logo.png" width="100px" height="35px">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b class="spanPrintDate">Print Date:</b> 
                                            <span id="spanPrintDate"></span>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <b>Total Pages:</b> 1
                                        </td>
                                    </tr>

                                    <tr>
                                        <td align="left">
                                            <b class="spanYear">Year: </b>
                                            <span id="spanYear"> - </span>
                                        </td>
                                        <td></td>
                                        <td align="right">
                                            <b class="spanForum">Forum: </b> 
                                            <span id="spanForum"> - </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <table id="tblTable" class="table table-igi table-bordered table-responsive">
                        <?php
                            $sum_cf = 0;
                            $sum_open = 0;
                            $sum_closed = 0;
                            $sum_pendding = 0;
                        ?>

                        <thead>
                            <tr>
                                <th rowspan="2" class="line-hight">Forum</th>
                                <th width="250px" rowspan="2" class="text-center line-hight">Complaint Type</th>
                                <th colspan="4" class="text-center">Grand Total</th>
                            </tr>
                            <tr>
                                <th class="text-center line-hight">CF</th>
                                <th class="text-center line-hight">Received</th>
                                <th class="text-center line-hight">Closed</th>
                                <th class="text-center line-hight">Pending</th>
                            </tr>
                        </thead>
                        
                        <tbody class="table table-bordered">
                            <?php foreach($forum_names as $forum_name): ?>
                            <?php
                                $forum_name_id = $forum_name['id'];
                                $data2 =  $objComplaintReport->getComplaintTypeByForumId($forum_name_id);
                                $rowspan = count($data2);
                                $rowspan = $rowspan + 1;
                            ?>
                            <tr>
                                <td rowspan="<?php echo $rowspan; ?>"><?php echo $forum_name['fullname']; ?></td>
                                <?php for($i=0; $i<count($data2); $i++) { ?>
                                    <tr>
                                        <?php if($data2 != 0) {  ?>
                                            <td><?php echo $data2[$i]['dept_type']; ?></td>

                                            <?php $complaint_type_id = $data2[$i]['complaint_type_id']; ?>
                                            
                                            <?php
                                                $cmp_cf = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year_last,$status);
                                                $cmp_cf = $cmp_cf[0]['CMP_COUNTS'];
                                                $sum_cf = $sum_cf + $cmp_cf;
                                            ?>
                                            <td class="bgColor text-center"><?php echo $cmp_cf; ?></td>

                                            <?php
                                                $cmp_open = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,$status);
                                                $cmp_open = $cmp_open[0]['CMP_COUNTS'];
                                                $sum_open = $sum_open + $cmp_open;
                                            ?>
                                            <td class="text-center"><?php echo $cmp_open; ?>
                                            </td>

                                            <?php
                                                $cmp_closed = $objComplaintReport->countsQuarterlyComplaintsByForum($forum_name_id,$complaint_type_id,'',$year,'3');
                                                $cmp_closed = $cmp_closed[0]['CMP_COUNTS'];
                                                $sum_closed = $sum_closed + $cmp_closed;
                                            ?>
                                            <td class="text-center"><?php echo $cmp_closed; ?></td>

                                            <?php
                                                $cmp_pendding = $cmp_cf + $cmp_open;
                                                $sum_pendding = $sum_pendding + $cmp_pendding;
                                            ?>
                                            <td class="bgColor text-center"><?php echo $cmp_pendding; ?></td>
                                            <!-- Quarter-4 End -->
                                        <?php } else { ?>
                                            <td class="text-center line-hight"><?php echo "NA"; ?></td>
                                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                                            <td class="text-center line-hight"><?php echo "0"; ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td class="text-center line-hight" colspan="2"><b>Total</b></td>

                                <td class="text-center line-hight"><b><?php echo $sum_cf; ?></b></td>
                                <td class="text-center line-hight"><b><?php echo $sum_open; ?></b></td>
                                <td class="text-center line-hight"><b><?php echo $sum_closed; ?></b></td>
                                <td class="text-center line-hight"><b><?php echo $sum_pendding; ?></b></td>
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
    #tblTable .line-hight{
        vertical-align: middle;
    }

    .myTble tbody{
        padding: 0px 0px 0px 15px;
        float: left;
        font-size: 18px;
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
        var getYear     = $('#getYear').val();
        var getForum    = $('#getForum').val();

        var ForumText  = $('#getForum option:selected').text();

        $('#spanYear').html(getYear);
        $('#spanForum').html(ForumText);
        $('#spanPrintDate').html(PrintDate);
  
        if(validation())
        {
            $.ajax({
                type: 'POST',
                url: "includes/ajax/action_complaint_rpt.php",
                data: 
                {
                    'action'     :'search_cmp_board_of_directors_yearly_rpt',
                    'getYear'    :getYear,
                    'getForum'   :getForum
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

                        /*$('#data-table').dataTable({ 
                            destroy: true,            
                            responsive: true,            
                            searching: true,            
                            pageLength: 10,            
                            order: false       
                        }); */  
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
                'action': 'export_all_cmp_board_of_directors_yearly'
            },
            success: function(data)
            {
                window.open(SITE_IP + "/reports/rpt_cmp_board_of_directors_yearly_download_all.php");
            }
        }).done(function (data) {
            console.log(data);
        });
    }

    function exportFilterReport()
    {
        var getYear     = $('#getYear').val();
        var getForum    = $('#getForum').val();

        $.ajax({
            type: "POST",
            url: "includes/ajax/action_complaint_rpt.php",
            data:
            {
                'action': 'export_cmp_board_of_directors_yearly_rpt',
                'getYear': getYear,
                'getForum': getForum
            },
            success: function(data)
            {
                data = data.trim();
                var result = data.split("|");

                getYear   = result[1];
                getForum  = result[2];

                window.open(SITE_IP + "/reports/rpt_cmp_board_of_directors_yearly_download.php?getYear="+getYear+"&getForum="+getForum);
            }
        }).done(function (data) {
            console.log(data);
        });
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