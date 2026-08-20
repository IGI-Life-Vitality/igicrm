<?php
    include('../includes/config.php');
    include('../classes/lead_rpt.php');    

    $FromDate = $_GET['fDate'];
    $ToDate   = $_GET['tDate'];

    //print_r($ToDate);die;

    /*$FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
    $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';*/

    $objLeadReport = new LeadReport();
    $data = $objLeadReport->exportLeadsByStatus($FromDate, $ToDate);

    //print_r($data);die;

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_lead_status_report.xls"');
?>

    <style>
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
        }
        .logoArea img{
            margin: 0px 0px 0px 100px!important;
        }
    </style>

    <table id="tblMyTable" class="table table-igi table-responsive">
        <tbody>
            <tr>
                <td align="left" valign="top">
                    <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                </td>
                <td></td>
                <td align="right" valign="top">
                    <h3>Lead Status Report</h3>
                </td>
            </tr>
            <tr class="spanFromDate">
                <td align="left">
                    <b class="FromDate">From Date:</b> 
                    <span id="spanFromDate"><?php echo $FromDate; ?></span>
                </td>
                <td></td>
                <td align="right">
                    <b>Print Date:</b> 
                    <span id="spanPrintDate"><?php echo Date('Y-m-d H:i'); ?></span>
                </td>
            </tr>
            <tr class="spanToDate">
                <td align="left">
                    <b class="ToDate">To Date:</b> 
                    <span id="spanToDate"><?php echo $ToDate; ?></span>
                </td>
                <td></td>
                <td align="right">
                    <b>Pages:</b> 1
                </td>
            </tr>
        </tbody>
    </table>

    <br>

    <table id="tblMyTable" class="table table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="600px" align="left">Lead Status</th>
                <th width="200px" align="right">Lead Count</th>
                <th width="200px" align="right">Overall Percentage</th>
            </tr>
        </thead>

        <?php 
            $initiated_leads_pval       = ($data[0]['initiated_leads']/$data[0]['all_leads'])*100;
            $inprogress_leads_pval      = ($data[0]['inprogress_leads']/$data[0]['all_leads'])*100;
            $followup_leads_pval        = ($data[0]['followup_leads']/$data[0]['all_leads'])*100;
            $bought_leads_pval          = ($data[0]['bought_leads']/$data[0]['all_leads'])*100;
            $not_interested_leads_pval  = ($data[0]['not_interested_leads']/$data[0]['all_leads'])*100;
            $general_inquiry_leads_pval = ($data[0]['general_inquiry_leads']/$data[0]['all_leads'])*100;

            $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;
        ?>

        <tbody>
            <tr>
                <td width="600px">Initiated</td>
                <td><?php echo $data[0]['initiated_leads']; ?></td>
                <td><?php echo number_format($initiated_leads_pval); ?>%</td>
            </tr>
            <tr>
                <td width="600px">In Progress</td>
                <td><?php echo $data[0]['inprogress_leads']; ?></td>
                <td><?php echo number_format($inprogress_leads_pval); ?>%</td>
            </tr>
            <tr>
                <td width="600px">Follow Up</td>
                <td><?php echo $data[0]['followup_leads']; ?></td>
                <td><?php echo number_format($followup_leads_pval); ?>%</td>
            </tr>
            <tr>
                <td width="600px">Bought</td>
                <td><?php echo $data[0]['bought_leads']; ?></td>
                <td><?php echo number_format($bought_leads_pval); ?>%</td>
            </tr>
            <tr>
                <td width="600px">Not Interested</td>
                <td><?php echo $data[0]['not_interested_leads']; ?></td>
                <td><?php echo number_format($not_interested_leads_pval); ?>%</td>
            </tr>
            <tr>
                <td width="600px">General Inquiry</td>
                <td><?php echo $data[0]['general_inquiry_leads']; ?></td>
                <td><?php echo number_format($general_inquiry_leads_pval); ?>%</td>
            </tr>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td width="600px"><b>Total</b></td>
                <td><b><?php echo number_format($data[0]['all_leads']); ?></b></td>
                <td><b><?php echo number_format($t_pval); ?>%</b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>