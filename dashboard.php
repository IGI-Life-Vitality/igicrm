<?php
$page_title = "Dashboard";
$module_id = "99";
$menu_id = "dashboard";

include('includes/header.php');
include('classes/dashboard.php');
include('classes/complaint_rpt.php');
include('classes/lead_rpt.php');

$today      = date("Y-m-d");
$last_date  = date("Y-m-d", strtotime("-1 week"));

$objDash                = new Dashboard();
$objComplaintReport     = new ComplaintReport();
$objLeadReport          = new LeadReport();

$login_id = $_SESSION['login_id'];
$product_id = $_SESSION['product_id'];

$news = $objDash->GetNews($group_id,$user_type);
$msgs = $objDash->GetMessage($_SESSION['login_id']);

$data       = $objDash->dashbord_complains($login_id,$user_type,$group_id);
$data_leads = $objDash->dashbord_leads($login_id,$user_type,$group_id,$product_id);
$lead_rate  = ($data_leads[0]["leads_matured"]/$data_leads[0]["total_leads"]) * 100;
$lead_rate  = sprintf('%2d',$lead_rate);

//echo $data = $objComplaintReport->countsAllComplaintGraph($login_id); die;
?>

<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin #content -->
<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
        <li><a href="javascript:;">Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">Dashboard</h1>

    <div class="row">
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-green-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                <div class="stats-title">Total Complaints</div>
                <div class="stats-number"><? echo number_format($data[0]["total_complaints"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="complaint_views.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-blue-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
                <div class="stats-title">Closed Complaints</div>
                <div class="stats-number"><? echo number_format($data[0]["closed_complaints"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="complaint_views.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-purple-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-clock-o fa-fw"></i></div>
                <div class="stats-title">Total Task</div>
                <div class="stats-number"><? echo number_format($data[0]["total_task"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="task_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-black-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
                <div class="stats-title">Assigned Task</div>
                <div class="stats-number"><? echo number_format($data[0]["assigned_task"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="task_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>

    <!--haroon work starts-->
    <div class="row">
        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-red-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-globe fa-fw"></i></div>
                <div class="stats-title">Total Leads</div>
                <div class="stats-number"><? echo number_format($data_leads[0]["total_leads"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="leads_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-yellow-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-users fa-fw"></i></div>
                <div class="stats-title">Leads Matured </div>
                <div class="stats-number"><? echo number_format($data_leads[0]["leads_matured"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="leads_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-or-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-clock-o fa-fw"></i></div>
                <div class="stats-title">Leads Pending</div>
                <div class="stats-number"><? echo number_format($data_leads[0]["leads_pending"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="leads_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->

        <!-- begin col-3 -->
        <div class="col-md-3 col-sm-6">
            <div class="widget widget-stats bg-pi-igi">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-comments fa-fw"></i></div>
                <div class="stats-title">Leads General Inquery</div>
                <div class="stats-number"><? echo number_format($data_leads[0]["leads_inquery"]); ?></div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: 100%;"></div>
                </div>
                <div class="stats-desc"><a href="leads_view.php">View Details <i class="fa fa-arrow-circle-o-right"></i></a></div>
            </div>
        </div>
        <!-- end col-3 -->
    </div>
    <!--haroon works end-->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-6 -->
        <div class="col-md-6">
            <div class="panel panel-inverse" data-sortable-id="index-1">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Message</h4>
                </div>

                <div class="panel-body">
                    <div class="height-sm" data-scrollbar="true">
                        <ul class="media-list media-messaging">
                            <?php if(!empty($msgs)) {
                                  foreach($msgs as $msg) { ?>
                                    <li class="media media-sm">
                                        <div class="media-body media-body-igi">
                                            <a href="message_detail.php?id=<?php echo $msg['id']?>">
                                                <h5 class="media-heading"><?php echo $msg ['subject']; ?></h5>
                                            </a>
                                            <span class="date-time">Sent by : <b><?php echo $objUser->GetMsgUser($msg['sender']); ?></b> | <?php  echo $objDash->GetDateFormate($msg['create_date']); ?></span>
                                            <?php if(strlen($msg['message']) > 100) {
                                                $txt = substr($msg['message'], 0,100) . ".  .  .  .";}else{$txt = $msg['message']; } ?>
                                            <p><?php echo $txt; ?></p>
                                        </div>
                                    </li>
                            <?php } } else { ?>
                                <li class="media media-sm">
                                    <div class="media-body">
                                        <h5 class="media-heading">No Record Found</h5>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-inverse" data-sortable-id="index-2">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Total Complaints (Last 7 Days)</h4>
                </div>
                <div class="panel-body">
                    <div id="chart_div" style="height: 480px;"></div>
                </div>
            </div>
        </div>
        <!-- end col-6 -->

        <!-- begin col-6 -->
        <div class="col-md-6">
            <div class="panel panel-inverse" data-sortable-id="index-6">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">News & Announcement</h4>
                </div>

                <div class="panel-body">
                    <div class="height-sm" data-scrollbar="true">
                        <ul class="media-list media-list-with-divider media-messaging">
                            <?php if(!empty($news)) {
                                    foreach($news as $nws){?>    
                            <li class="media media-sm">
                                <div class="media-body media-body-igi">
                                        <a href="news_detail.php?id=<?php echo $nws['id']?>">
                                    <h5 class="media-heading"><?php echo $nws['subject'];?></h5> </a>
                                    <span>Published by : <b><?php echo $objUser->GetMsgUser($nws['sender']);?></b> | <?php echo $objDash->GetDateFormate($nws['create_date']);?></span>
                                       <?php if(strlen($nws['detail']) > 100){
                                                $newstxt = substr($nws['detail'], 0,100).".  .  .  .";}else{$newstxt = $nws['detail'];}?>
                                    <p><?php  echo $newstxt;?></p> 
                                </div>
                            </li>
                             <?php }}else{?>
                                    <li class="media media-sm">
                                    <div class="media-body">
                                    <h5 class="media-heading">No Record Found</h5>
                                </div>
                            </li>
                             <?php } ?>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class="panel panel-inverse" data-sortable-id="index-7">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Total Leads (Last 7 Days)</h4>
                </div>

                <div class="panel-body">
                    <div id="chart_div2" style="height: 480px;"></div>
                </div>
            </div>
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
<!--<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>-->
<script src="assets/plugins/flot/jquery.flot.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.time.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="assets/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="assets/plugins/sparkline/jquery.sparkline.js"></script>
<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
<script src="assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="assets/js/dashboard.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
        Dashboard.init();//for map
    });
</script>

<!-- First Chart -->
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawComplaintsChart);

    function drawComplaintsChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Complaints', 'Total', { role: 'style' }],

            <?php $data = $objComplaintReport->countsAllComplaintGraph($login_id); ?>
            <?php for($c=0; $c<count($data); $c++) { ?>
            ['Individual Life', <?php echo $data[$c]['L']; ?>, '#b87333'],
            ['Corporate', <?php echo $data[$c]['C']; ?>, 'silver'],
            ['Legal', <?php echo $data[$c]['LG']; ?>, 'red'],
            ['Bancassurance Individual', <?php echo $data[$c]['B']; ?>, 'gold'],
            ['Bancassurance Bank', <?php echo $data[$c]['BB']; ?>, 'colors: #006BB1'],
            ['Vitality', <?php echo $data[$c]['V']; ?>, 'green']
            <?php } ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
        { 
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation" },
        2]);

        var options = {
            title: "Complaints Statistics (<?php echo $last_date . " - " . $today; ?>)",
            height: 450,
            bar: {groupWidth: "100%"},
            legend: { position: "none" }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
        chart.draw(view, options);
    }

    //setInterval(drawComplaintsChart, 10000);
</script>

<!-- Second Chart -->
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawLeadsChart);

    function drawLeadsChart()
    {
        var data = google.visualization.arrayToDataTable([
            ['Leads with Category', 'Total Leads', { role: 'style' }],
            <?php $data = $objLeadReport->countsLeadsByStatusGraphs($last_date,$today,$login_id); ?>
            <?php for($c=0; $c<count($data); $c++) { ?>
            ['Initiated', <?php echo $data[$c]['initiated_leads']; ?>, '#b87333'],
            ['In Progress', <?php echo $data[$c]['inprogress_leads']; ?>, 'silver'],
            ['Follow-up', <?php echo $data[$c]['followup_leads']; ?>, 'red'],
            ['Bought', <?php echo $data[$c]['bought_leads']; ?>, 'color: gold' ],
            ['Not Interested', <?php echo $data[$c]['not_interested_leads']; ?>, 'color: #006BB1' ],
            ['General Inquiry', <?php echo $data[$c]['general_inquiry_leads']; ?>, 'green' ],
            <?php } ?>
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
        { 
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation" },
        2]);

        var options = {
            title: "Leads Statistics (<?php echo $last_date . " - " . $today; ?>)",
            height: 450,
            bar: {groupWidth: "75%"},
            chartArea: {width: '55%'},
            legend: { position: "none" },
            hAxis: {
              title: 'Total Leads',
              minValue: 0
            },
            vAxis: {
              title: 'Lead with Status'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById("chart_div2"));
        chart.draw(view, options);
    }

    //setInterval(drawLeadsChart, 10000);
</script>

</body>
</html>