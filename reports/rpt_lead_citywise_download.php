<?php
    include('../includes/config.php');
    include('../classes/lead_rpt.php');

    $FromDate = $_GET['fDate'];
    $ToDate   = $_GET['tDate'];
    $RgCity   = $_GET['RgCity'];

    //print_r($RgCity);die;

    /*$FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
    $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';*/

    $objLeadReport = new LeadReport();
    $data = $objLeadReport->exportLeadsByCity($FromDate,$ToDate,$RgCity);
    $city_name = $objLeadReport->countsLeadsByCityOne($RgCity);

    $initiated_leads_pval       = ($data[0]['initiated_leads']/$data[0]['counts'])*100;
    $inprogress_leads_pval      = ($data[0]['inprogress_leads']/$data[0]['counts'])*100;
    $followup_leads_pval        = ($data[0]['followup_leads']/$data[0]['counts'])*100;
    $bought_leads_pval          = ($data[0]['bought_leads']/$data[0]['counts'])*100;
    $not_interested_leads_pval  = ($data[0]['not_interested_leads']/$data[0]['counts'])*100;
    $general_inquiry_leads_pval = ($data[0]['general_inquiry_leads']/$data[0]['counts'])*100;

    $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;

    $all_leads = $data[0]['initiated_leads'] + $data[0]['inprogress_leads'] + $data[0]['followup_leads'] + $data[0]['bought_leads'] + $data[0]['not_interested_leads'] + $data[0]['general_inquiry_leads'];

    //print_r($city_name);die;

    /*echo "<pre>";
        print_r($RgCity);
        echo "<br>";
        print_r($data);
    echo "</pre>";
    die;*/

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

    if($RgCity == '')
    {
        $city_name = 'All';
    }
    else
    {
        $city_name  = $objLeadReport->GetCityName($RgCity);
        $city_name  = $city_name[0]['fullname'];
    }

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_lead_citywise_report_download.xls"');
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
                <td colspan="6"></td>
                <td align="right" valign="top">
                    <h3>Lead Citywise Report</h3>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>From Date:</b> 
                    <span id="spanFromDate"><?php echo $FromDate; ?></span>
                </td>
                <td colspan="6"></td>
                <td align="right">
                    <b>Print Date:</b> 
                    <span id="spanPrintDate"><?php echo Date('Y-m-d H:i'); ?></span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>To Date:</b> 
                    <span id="spanToDate"><?php echo $ToDate; ?></span>
                </td>
                <td colspan="6"></td>
                <td align="right">
                    <b>Pages:</b> 1
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>City:</b> 
                    <span id="spanCity"><?php echo $city_name; ?></span>
                </td>
                <td colspan="6"></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <br>

    <table id="tblMyTable" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="400px;" align="left">City</th>
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
            <tr>
                <td rowspan="6" valign="top">
                    <?php echo $city_name; ?>
                </td>
                <td rowspan="6" valign="top">
                    <?php 
                        $lead_counts = $data[0]['initiated_leads'] + $data[0]['inprogress_leads'] + $data[0]['followup_leads'] + $data[0]['bought_leads'] + $data[0]['not_interested_leads'] + $data[0]['general_inquiry_leads'];
                        echo $lead_counts;
                    ?>
                </td>
                <td rowspan="6" valign="top">
                    <?php 
                        echo number_format(($lead_counts/$data[0]['counts']*100),2); 
                    ?>%
                </td>
                <td>Initiated</td>
                <td><?php echo $data[0]['initiated_male_leads']; ?></td>
                <td><?php echo $data[0]['initiated_female_leads']; ?></td>
                <td><?php echo $data[0]['initiated_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['initiated_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>In Progress</td>
                <td><?php echo $data[0]['inprogress_male_leads']; ?></td>
                <td><?php echo $data[0]['inprogress_female_leads']; ?></td>
                <td><?php echo $data[0]['inprogress_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['inprogress_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Follow Up</td>
                <td><?php echo $data[0]['followup_male_leads']; ?></td>
                <td><?php echo $data[0]['followup_female_leads']; ?></td>
                <td><?php echo $data[0]['followup_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['followup_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Bought</td>
                <td><?php echo $data[0]['bought_male_leads']; ?></td>
                <td><?php echo $data[0]['bought_female_leads']; ?></td>
                <td><?php echo $data[0]['bought_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['bought_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Not Interested</td>
                <td><?php echo $data[0]['not_interested_male_leads']; ?></td>
                <td><?php echo $data[0]['not_interested_female_leads']; ?></td>
                <td><?php echo $data[0]['not_interested_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['not_interested_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>General Inquiry</td>
                <td><?php echo $data[0]['general_inquiry_male_leads']; ?></td>
                <td><?php echo $data[0]['general_inquiry_female_leads']; ?></td>
                <td><?php echo $data[0]['general_inquiry_leads']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['general_inquiry_leads']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="4"><b>Total</b></td>
                <td><b><?php echo number_format($data[0]['all_male_leads']); ?></b></td>
                <td><b><?php echo number_format($data[0]['all_female_leads']); ?></b></td>
                <td><b><?php echo number_format($all_leads); ?></b></td>
                <td><b><?php echo number_format($t_pval,2); ?>%</b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>