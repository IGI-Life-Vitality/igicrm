<?php
    include('../includes/config.php');
    include('../classes/complaint_rpt.php');

    $year = isset($_GET['getYear'])?$_GET['getYear']:'';

    $objComplaintReport = new ComplaintReport();
    $data               = $objComplaintReport->countsLegalComplaintClosureAnalysis($year);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rpt_cmp_legal_complaint_closure_download.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            /* text-align: right !important; */
            height: 44px !important;
        }
        #tblMyTables tr td{
            border:1px solid #CCC !important;
        }
        .tblHead, .tblFoot{
            background: #006BB1 !important;
            color: #FFF !important;
            /* text-align: right !important; */
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
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td colspan="3"></td>
                    <td align="right" valign="top">
                        <h4>Legal Complaint Closure Analysis Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b>Print Date:</b> 
                        <span id="spanPrintDate"><?php echo DATE('Y-m-d h:s'); ?></span>
                    </td>
                    <td colspan="3"></td>
                    <td align="right">
                        <b>Pages:</b> 1
                    </td>
                </tr>

                <tr>
                    <td align="left">
                        <b class="spanYear">Year:</b> 
                        <span id="spanYear"> <?php print_r($year); ?> </span>
                    </td>
                    <td  colspan="3">
                    </td>
                    <td align="right"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <table id="tblMyTables" class="table table-igi table-responsive">
        <thead>
            <tr class="tblHead">
                <th width="350px;" align="left">Month</th>
                <th width="150px;" text-align="center">Premium Collected</th>
                <th width="200px;" text-align="center">Claimed by the Policyholders</th>
                <th width="200px;" text-align="center">Payments to Policyholders</th>
                <th width="100px;" text-align="center">Savings</th>
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
            <tr class="tblFoot">
                <td>Total</td>
                <td><?php echo number_format($PremiumCollected); ?></td>
                <td><?php echo number_format($ClaimedPolicyholders); ?></td>
                <td><?php echo number_format($PaymentsPolicyholders); ?></td>
                <td><?php echo number_format($SumSavings); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>