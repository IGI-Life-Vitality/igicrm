<?php
    include('../includes/config.php');
    include('../classes/lead_rpt.php');   

    $objLeadReport = new LeadReport();
    $citylop       = $objLeadReport->countsLeadsByCityLoop();
    $data          = $objLeadReport->countsLeadsBySourceInfo('','','');

    $email_leads_pval           = ($data[0]['email']/$data[0]['counts'])*100;
    $calls_leads_pval           = ($data[0]['calls']/$data[0]['counts'])*100;
    $letter_leads_pval          = ($data[0]['letter']/$data[0]['counts'])*100;
    $walkin_customer_leads_pval = ($data[0]['walkin_customer']/$data[0]['counts'])*100;
    $website_leads_pval              = ($data[0]['website']/$data[0]['counts'])*100;
    $corporate_partners_leads_pval   = ($data[0]['corporate_partners']/$data[0]['counts'])*100;
    $vec_leads_pval                  = ($data[0]['vec']/$data[0]['counts'])*100;
    $billboard_leads_pval            = ($data[0]['billboard']/$data[0]['counts'])*100;

    //$t_pval = $email_leads_pval + $website_leads_pval + $calls_leads_pval + $billboard_leads_pval;

    $all_leads = $data[0]['email'] + $data[0]['calls'] + $data[0]['letter'] + $data[0]['walkin_customer'] + $data[0]['website'] + $data[0]['corporate_partners'] + $data[0]['vec'] + $data[0]['billboard'];

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_lead_source_info_report_download_all.xls"');
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
                    <b>City:</b> 
                    <span id="spanCity">All</span>
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
            <?php foreach($citylop as $cityloop): ?>
                <?php
                    $city_id = $cityloop['id'];
                    $data1 = $objLeadReport->countsLeadsBySourceInfoOnPageLoad($city_id);
                ?>
                <tr>
                    <td rowspan="8" valign="top"><?php echo $cityloop['city_name']; ?></td>
                    <td rowspan="8" valign="top">
                        <?php 
                            $lead_counts = $data1[0]['email'] + $data1[0]['calls'] + $data1[0]['letter'] + $data1[0]['walkin_customer'] + $data1[0]['website'] + $data1[0]['corporate_partners'] + $data1[0]['vec'] + $data1[0]['billboard'];
                            echo $lead_counts;
                        ?>
                    </td>
                    <td rowspan="8" valign="top">
                        <?php 
                            echo number_format(($lead_counts/$data1[0]['counts']*100),2); 
                        ?>%
                    </td>

                    <td>Email</td>
                    <td><?php echo $data1[0]['email_male_leads']; ?></td>
                    <td><?php echo $data1[0]['email_female_leads']; ?></td>
                    <td><?php echo $data1[0]['email']; ?></td>
                    <td>
                        <?php 
                            echo number_format(($data1[0]['email']/$data[0]['counts']*100),2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Calls</td>
                    <td><?php echo $data1[0]['calls_male_leads']; ?></td>
                    <td><?php echo $data1[0]['calls_female_leads']; ?></td>
                    <td><?php echo $data1[0]['calls']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['calls']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Letter</td>
                    <td><?php echo $data1[0]['letter_male_leads']; ?></td>
                    <td><?php echo $data1[0]['letter_female_leads']; ?></td>
                    <td><?php echo $data1[0]['letter']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['letter']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Walk in Customer</td>
                    <td><?php echo $data1[0]['walkin_customer_male_leads']; ?></td>
                    <td><?php echo $data1[0]['walkin_customer_female_leads']; ?></td>
                    <td><?php echo $data1[0]['walkin_customer']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['walkin_customer']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td><?php echo $data1[0]['website_male_leads']; ?></td>
                    <td><?php echo $data1[0]['website_female_leads']; ?></td>
                    <td><?php echo $data1[0]['website']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['website']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Corporate Partners</td>
                    <td><?php echo $data1[0]['corporate_partners_male_leads']; ?></td>
                    <td><?php echo $data1[0]['corporate_partners_female_leads']; ?></td>
                    <td><?php echo $data1[0]['corporate_partners']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['corporate_partners']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>Vitality Experience Center</td>
                    <td><?php echo $data1[0]['vec_male_leads']; ?></td>
                    <td><?php echo $data1[0]['vec_female_leads']; ?></td>
                    <td><?php echo $data1[0]['vec']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['vec']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
                <tr>
                    <td>BillBoard / Others</td>
                    <td><?php echo $data1[0]['billboard_male_leads']; ?></td>
                    <td><?php echo $data1[0]['billboard_female_leads']; ?></td>
                    <td><?php echo $data1[0]['billboard']; ?></td>
                    <td>
                        <?php 
                            echo number_format($data1[0]['billboard']/$data[0]['counts']*100, 2); 
                        ?>%
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr class="tblFoot">
                <td colspan="4"><b>Total</b></td>
                <td><b><?php echo number_format($data[0]['all_male_leads']); ?></b></td>
                <td><b><?php echo number_format($data[0]['all_female_leads']); ?></b></td>
                <td><b><?php echo number_format($data[0]['counts']); ?></b></td>
                <td><b><?php echo number_format(100); ?>%</b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>