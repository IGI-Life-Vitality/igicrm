<?php
    include('../includes/config.php');
    include('../classes/lead_rpt.php');
    
    $objLeadReport = new LeadReport();
    $regionalManager    = $objLeadReport->getRegionalManagers();
    $data               = $objLeadReport->countsLeadsByRegional('','','');
    $get_regional_manager   = $objLeadReport->getRegionalManagersById($RegionalManagers);

    $initiated_leads_pval       = ($data[0]['initiated_leads']/$data[0]['counts'])*100;
    $inprogress_leads_pval      = ($data[0]['inprogress_leads']/$data[0]['counts'])*100;
    $followup_leads_pval        = ($data[0]['followup_leads']/$data[0]['counts'])*100;
    $bought_leads_pval          = ($data[0]['bought_leads']/$data[0]['counts'])*100;
    $not_interested_leads_pval  = ($data[0]['not_interested_leads']/$data[0]['counts'])*100;
    $general_inquiry_leads_pval = ($data[0]['general_inquiry_leads']/$data[0]['counts'])*100;

    $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;

    $all_leads = $data[0]['initiated_leads'] + $data[0]['inprogress_leads'] + $data[0]['followup_leads'] + $data[0]['bought_leads'] + $data[0]['not_interested_leads'] + $data[0]['general_inquiry_leads'];

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_lead_regional_report_download_all.xls"');
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
                <td colspan="5"></td>
                <td align="right" valign="top" colspan="2">
                    <h3>All Leads Regional Manager Report</h3>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>From Date:</b> 
                    <span id="spanFromDate"> All </span>
                </td>
                <td colspan="5"></td>
                <td align="right" colspan="2">
                    <b>Print Date:</b> 
                    <span id="spanPrintDate"><?php echo Date('Y-m-d H:i'); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>To Date:</b> 
                    <span id="spanToDate"> All </span>
                </td>
                <td colspan="5"></td>
                <td align="right" colspan="2">
                    <b>Pages:</b> 1
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>Regional Manager:</b> 
                    <span id="spanRegionalManager">All</span>
                </td>
                <td colspan="5"></td>
                <td align="right"></td>
            </tr>
        </tbody>
    </table>

    <br>

    <table id="tblMyTable" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="400px;" align="left">Regional Manager</th>
                <th width="100px;" align="right">Count</th>
                <th width="100px;" align="right">Percent</th>
                <th width="200px;" align="right">Lead Status</th>
                <th width="100px;" align="right">Male</th>
                <th width="100px;" align="right">Female</th>
                <th width="150px;" align="right">Lead Count</th>
                <th width="200px;" align="right">Overall Percentage</th>
            </tr>
        </thead>

        <tbody class="table table-bordered">
            <?php foreach($regionalManager as $regionalManagers): ?>
                <?php
                    $regional_manager_id = $regionalManagers['regional_manager_id'];
                    $data1 = $objLeadReport->countsLeadsByRegionalOnPageLoad($regional_manager_id);
                ?>
                <tr>
                    <td rowspan="6" valign="top"><?php echo $regionalManagers['regional_manager_name']; ?></td>
                    <td rowspan="6" valign="top">
                        <?php
                            $lead_counts = $data1[0]['initiated_leads'] + $data1[0]['inprogress_leads'] + $data1[0]['followup_leads'] + $data1[0]['bought_leads'] + $data1[0]['not_interested_leads'] + $data1[0]['general_inquiry_leads'];
                            echo $lead_counts;
                        ?>
                    </td>
                    <td rowspan="6" valign="top"><?php echo number_format(($lead_counts/$data1[0]['counts']*100),2); ?>%</td>
                    <td>Initiated</td>
                    <td><?php echo $data1[0]['initiated_male_leads']; ?></td>
                    <td><?php echo $data1[0]['initiated_female_leads']; ?></td>
                    <td><?php echo $data1[0]['initiated_leads']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['initiated_leads']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>In Progress</td>
                    <td><?php echo $data1[0]['inprogress_male_leads']; ?></td>
                    <td><?php echo $data1[0]['inprogress_female_leads']; ?></td>
                    <td><?php echo $data1[0]['inprogress_leads']; ?></td>
                    <td><?php echo number_format($data1[0]['inprogress_leads']/$data[0]['counts']*100, 2); ?>%</td>
                </tr>
                <tr>
                    <td>Follow Up</td>
                    <td><?php echo $data1[0]['followup_male_leads']; ?></td>
                    <td><?php echo $data1[0]['followup_female_leads']; ?></td>
                    <td><?php echo $data1[0]['followup_leads']; ?></td>
                    <td><?php echo number_format($data1[0]['followup_leads']/$data[0]['counts']*100, 2); ?>%</td>
                </tr>
                <tr>
                    <td>Bought</td>
                    <td><?php echo $data1[0]['bought_male_leads']; ?></td>
                    <td><?php echo $data1[0]['bought_female_leads']; ?></td>
                    <td><?php echo $data1[0]['bought_leads']; ?></td>
                    <td><?php echo number_format($data1[0]['bought_leads']/$data[0]['counts']*100, 2); ?>%</td>
                </tr>
                <tr>
                    <td>Not Interested</td>
                    <td><?php echo $data1[0]['not_interested_male_leads']; ?></td>
                    <td><?php echo $data1[0]['not_interested_female_leads']; ?></td>
                    <td><?php echo $data1[0]['not_interested_leads']; ?></td>
                    <td><?php echo number_format($data1[0]['not_interested_leads']/$data[0]['counts']*100, 2); ?>%</td>
                </tr>
                <tr>
                    <td>General Inquiry</td>
                    <td><?php echo $data1[0]['general_inquiry_male_leads']; ?></td>
                    <td><?php echo $data1[0]['general_inquiry_female_leads']; ?></td>
                    <td><?php echo $data1[0]['general_inquiry_leads']; ?></td>
                    <td><?php echo number_format($data1[0]['general_inquiry_leads']/$data[0]['counts']*100, 2); ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="4"><b>Total</b></td>
                <td><b><?php echo number_format($data[0]['all_male_leads']); ?></b></td>
                <td><b><?php echo number_format($data[0]['all_female_leads']); ?></b></td>
                <td><b><?php echo number_format($data[0]['all_leads']); ?></b></td>
                <td><b><?php echo number_format(100); ?>%</b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>