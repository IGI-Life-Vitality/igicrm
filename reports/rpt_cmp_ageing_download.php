<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $FromDate   = isset($_GET['FromDate'])?$_GET['FromDate']:'';
    $ToDate     = isset($_GET['ToDate'])?$_GET['ToDate']:'';
    $Department = isset($_GET['Department'])?$_GET['Department']:'';
    $Type       = isset($_GET['Type'])?$_GET['Type']:'';
    $Source     = isset($_GET['Source'])?$_GET['Source']:'';
    $Status     = isset($_GET['Status'])?$_GET['Status']:'';

    $objComplaintReport = new ComplaintReport();
    $data               = $objComplaintReport->countsComplaintAgeing($FromDate,$ToDate,$Department,$Type,$Source,$Status);

    if($FromDate == '')
    {
        $FromDate = 'All';
    }
    else
    {
        $FromDate = $FromDate;
    }

    if($ToDate == '')
    {
        $ToDate = 'All';
    }
    else
    {
        $ToDate = $ToDate;
    }

    if($Department == '')
    {
        $getDepartment = 'All';
    }
    else
    {
        $getDepartment = $objComplaintReport->getDepartmentById($Department);
        $getDepartment = $getDepartment[0]['primary_name'];
    }

    if($Type == '')
    {
        $getType = 'All';
    }
    else
    {
        $getType = $objComplaintReport->getComplaintTypeById($Type);
        $getType = $getType[0]['fullname'];
    }

    if($Source == '')
    {
        $getSource = 'All';
    }
    else
    {
        $getSource = $objComplaintReport->getSourceById($Source);
        $getSource = $getSource[0]['fullname'];
    }

    if($Status == '')
    {
        $getStatus = 'All';
    }
    else
    {
        $getStatus = $objComplaintReport->getStatusById($Status);
        $getStatus = $getStatus[0]['fullname'];
    }

    /*echo "<pre>";
        print_r($data[0]);
    echo "</pre>";die;*/

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_ageing_downlod.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            text-align: left !important;
            height: 44px !important;
        }
        #tblMyTables tr td{
            border:1px solid #CCC !important;
        }
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            text-align: left !important;
        }
        .tabHeadLine{
            background: #CFCFCF !important;
            color: #000 !important;
        }
        .logoArea img{
            margin: 0px 0px 0px 100px!important;
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-bordered table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="5"></td>
                    <td align="right" valign="top">
                        <h4>Ageing Analysis Report</h4>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="5"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="FromDate">From Date:</b> 
                        <span id="spanFromDate"> <?php echo $FromDate; ?> </span>
                    </td>
                    <td colspan="2"></td>
                    <td align="left">
                        <b class="ToDate">To Date:</b> 
                        <span id="spanToDate"> <?php echo $ToDate; ?> </span>
                    </td>
                    <td colspan="2"></td>
                    <td align="right">
                        <b class="Department">Department:</b> 
                        <span id="spangetDepartment"> <?php echo $getDepartment; ?> </span>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <b class="Type">Complaint Type:</b> 
                        <span id="spangetType"> <?php echo $getType; ?>  </span>
                    </td>
                    <td colspan="2"></td>
                    <td align="left">
                        <b class="Source">Source:</b> 
                        <span id="spangetSource"> <?php echo $getSource; ?>  </span>
                    </td>
                    <td colspan="2"></td>
                    <td align="right">
                        <b class="Status">Status:</b> 
                        <span id="spangetStatus"> <?php echo $getStatus; ?>  </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="100px;">Ticket #</th>
                <th width="100px;">Registration Date</th>
                <th width="100px;">Camplaint Received Date</th>
                <th width="100px;">Policy#</th>
                <th width="100px;">Customer Name</th>
                <th width="100px;">Contact No</th>
                <th width="100px;">Source</th>
                <th width="100px;">Logged By</th>
                <th width="100px;">Complaint Type</th>
                <th width="100px;">Department</th>
                <th width="100px;">Assign To</th>
                <th width="100px;">Priority/TAT</th>
                <th width="100px;">Status</th>
                <th width="100px;">Resolution Date</th>
                <th width="100px;">End Date</th>
                <th width="100px;">Aging (Overdue)</th>
                <th width="100px;">Over All Satisfaction</th>
                <th width="100px;">Resolution Time Satisfaction</th>
                <th width="100px;">Staff Behavior</th>
                <th width="100px;">Feedback Comments</th>
                <th width="100px;">Feedback Date</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php foreach($data as $row): ?>
                <tr>
                    <td valign="top"><?php echo $row['complaint_num'] ?></td>
                    <td valign="top"><?php echo substr($row['create_date'],0,10); ?></td>
                    <td valign="top"><?php echo !empty($row['received_date']) && strtotime($row['received_date']) ? date('d/m/Y', strtotime($row['received_date'])) : '' ?></td>
                    <td valign="top"><?php echo $row['policy_num'] ?></td>
                    <td valign="top"><?php echo $row['customer_name'] ?></td>
                    <td valign="top"><?php echo $row['response_number'] ?></td>
                    <td valign="top"><?php echo $row['Source'] ?></td>
                    <td valign="top"><?php echo $row['ReleasedBy'] ?></td>
                    <td valign="top"><?php echo $row['ComplaintType'] ?></td>
                    <td valign="top"><?php echo $row['depart'] ?></td>
                    <td valign="top"><?php echo $row['AssignedTo'] ?></td>
                    <td valign="top"><?php echo $row['tat'] ?></td>
                    <td valign="top"><?php echo $row['cmpStatus'] ?></td>
                    <!-- <td><?php echo substr($row['close_date'],0,10); ?></td> -->
                     <td>
                        <?php
                            if ($row['cmpStatus'] == 'closed' || $row['cmpStatus'] == 3) {
                                echo !empty($row['close_date']) ? date('d/m/Y', strtotime($row['close_date'])) : '';
                            } else {
                                echo !empty($row['forward_date']) ? date('d/m/Y', strtotime($row['forward_date'])) : '';
                            }
                        ?>
                    </td>
                    <td valign="top"><?php echo date('d/m/y',strtotime($row['end_date'])) ?></td>
                    <td valign="top">
                        <?php
                            // 1st date
                            $resolution_date = substr($row['close_date'],0,10);

                            // 2nd date
                            $createdDate=($row['received_date'] == null || $row['received_date'] == '' || $row['received_date'] == '0000-00-00') ? substr($row['create_date'],0,10) : substr($row['received_date'],0,10);
                            $cdate  = $createdDate;
                            $date   = strtotime($cdate);
                            $tat    = substr($row['tat'],0,1);
                            $create_date = strtotime("+$tat day", $date);
                            $close_date = date('Y-m-d', $create_date);

                            if($resolution_date == '0000-00-00')
                            {
                                $today  = DATE('Y-m-d');
                                $start  = date_create($close_date);
                                $end    = date_create($today);
                                $diff   = date_diff($start,$end);
                                echo $diff->format('%R%a Days');
                            }
                            else
                            {
                                $re = $objComplaintReport->cmpOverdue($resolution_date, $close_date);
                                echo $re;
                            }
                        ?>
                    </td>
                    
                    <td valign="top"><?php echo $row['over_all_satisfaction'] ?></td>
                    <td valign="top"><?php echo $row['resolution_time_satisfaction'] ?></td>
                    <td valign="top"><?php echo $row['staff_behavior'] ?></td>
                    <td valign="top"><?php echo $row['feedback_comments'] ?></td>
                    <td valign="top"><?php echo $row['feedback_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>