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
    $data = $objLeadReport->countsLeadsBySourceInfo($FromDate,$ToDate,$RgCity);
    $city_name = $objLeadReport->countsLeadsByCityOne($RgCity);

    $email_leads_pval           = ($data[0]['email']/$data[0]['counts'])*100;
    $calls_leads_pval           = ($data[0]['calls']/$data[0]['counts'])*100;
    $letter_leads_pval          = ($data[0]['letter']/$data[0]['counts'])*100;
    $walkin_customer_leads_pval = ($data[0]['walkin_customer']/$data[0]['counts'])*100;
    $website_leads_pval              = ($data[0]['website']/$data[0]['counts'])*100;
    $corporate_partners_leads_pval   = ($data[0]['corporate_partners']/$data[0]['counts'])*100;
    $vec_leads_pval                  = ($data[0]['vec']/$data[0]['counts'])*100;
    $billboard_leads_pval            = ($data[0]['billboard']/$data[0]['counts'])*100;

    $t_pval = $email_leads_pval + $calls_leads_pval + $letter_leads_pval + $walkin_customer_leads_pval + $website_leads_pval + $corporate_partners_leads_pval + $vec_leads_pval + $billboard_leads_pval;

    $all_leads = $data[0]['email'] + $data[0]['calls'] + $data[0]['letter'] + $data[0]['walkin_customer'] + $data[0]['website'] + $data[0]['corporate_partners'] + $data[0]['vec'] + $data[0]['billboard'];

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
        $getCity = 'All';
    }
    else
    {
        $city_name  = $objLeadReport->GetCityName($RgCity);
        $city_name  = $city_name[0]['fullname'];
    }

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_lead_source_info_report_download.xls"');
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
                    <h3>Source Of Info Wise Lead Analysis</h3>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>From Date:</b> 
                    <span id="spanFromDate"><?php echo $FromDate; ?></span>
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
                    <span id="spanToDate"><?php echo $ToDate; ?></span>
                </td>
                <td colspan="5"></td>
                <td align="right" colspan="2">
                    <b>Pages:</b> 1
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>City:</b> 
                    <span id="spanCity"><?php echo $city_name; ?></span>
                </td>
                <td colspan="5"></td>
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
                <td rowspan="8" valign="top">
                    <?php echo $city_name; ?>
                </td>
                <td rowspan="8" valign="top">
                    <?php 
                        $lead_counts = $data[0]['email'] + $data[0]['calls'] + $data[0]['letter'] + $data[0]['walkin_customer'] + $data[0]['website'] + $data[0]['corporate_partners'] + $data[0]['vec'] + $data[0]['billboard'];
                        echo $lead_counts;
                    ?>
                </td>
                <td rowspan="8" valign="top">
                    <?php 
                        echo number_format(($lead_counts/$data[0]['counts']*100),2); 
                    ?>%
                </td>

                <td>Email</td>
                <td><?php echo $data[0]['email_male_leads']; ?></td>
                <td><?php echo $data[0]['email_female_leads']; ?></td>
                <td><?php echo $data[0]['email']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['email']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Calls</td>
                <td><?php echo $data[0]['calls_male_leads']; ?></td>
                <td><?php echo $data[0]['calls_female_leads']; ?></td>
                <td><?php echo $data[0]['calls']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['calls']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Letter</td>
                <td><?php echo $data[0]['letter_male_leads']; ?></td>
                <td><?php echo $data[0]['letter_female_leads']; ?></td>
                <td><?php echo $data[0]['letter']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['letter']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Walk in Customer</td>
                <td><?php echo $data[0]['walkin_customer_male_leads']; ?></td>
                <td><?php echo $data[0]['walkin_customer_female_leads']; ?></td>
                <td><?php echo $data[0]['walkin_customer']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['walkin_customer']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Website</td>
                <td><?php echo $data[0]['website_male_leads']; ?></td>
                <td><?php echo $data[0]['website_female_leads']; ?></td>
                <td><?php echo $data[0]['website']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['website']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Corporate Partners</td>
                <td><?php echo $data[0]['corporate_partners_male_leads']; ?></td>
                <td><?php echo $data[0]['corporate_partners_female_leads']; ?></td>
                <td><?php echo $data[0]['corporate_partners']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['corporate_partners']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>Vitality Experience Center</td>
                <td><?php echo $data[0]['vec_male_leads']; ?></td>
                <td><?php echo $data[0]['vec_female_leads']; ?></td>
                <td><?php echo $data[0]['vec']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['vec']/$data[0]['counts']*100, 2); 
                    ?>%
                </td>
            </tr>
            <tr>
                <td>BillBoard / Others</td>
                <td><?php echo $data[0]['billboard_male_leads']; ?></td>
                <td><?php echo $data[0]['billboard_female_leads']; ?></td>
                <td><?php echo $data[0]['billboard']; ?></td>
                <td>
                    <?php 
                        echo number_format($data[0]['billboard']/$data[0]['counts']*100, 2); 
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