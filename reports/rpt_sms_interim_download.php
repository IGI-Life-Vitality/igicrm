<?php
    include('../includes/config.php');
    include('../classes/complaint.php');

    $fromDate = isset($_GET['fDate']) ? $_GET['fDate'] : '';
    $toDate   = isset($_GET['tDate']) ? $_GET['tDate'] : '';


    $objComplaint = new Complaint();
    $smsDetails       = $objComplaint->getSmsInterimResultDetails($fromDate, $toDate);

    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="sms_interim.xls"');
?>

    <style>
        #tblMyTables tr th{
            border:1px solid #CCC !important;
            /* text-align: left !important; */
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
            margin: 0px 0px 0px 100px !important;
        }
        .border{
            border: 1px solid #CCC !important;
        }
        .bgColor{
            background: #006BB1 !important; 
            color: #FFF !important; 
        }
    </style>

    <div class="col-md-12">
        <table id="tblMyTable" class="table table-igi table-responsive">
            <tbody>
                <tr>
                    <td align="left" valign="top" colspan="10">
                        <img src="<?php echo SITE_IP; ?>/assets/img/IGI-32x32.png">
                    </td>
                    <td align="right" valign="top" colspan="4">
                        <h4>SMS Interim Report</h4>
                    </td>
                </tr>

                <tr>
                    <td align="left" colspan="8">
                        <b>From:</b> <?php echo $FromDate; ?> 
                        <b>To:</b> <?php echo $ToDate; ?>
                    </td>
                    <td align="right" colspan="4">
                        <b>Print Date:</b> <?php echo date('Y-m-d H:i'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

   
<br>

<table id="tblMyTables" class="table table-igi table-responsive">
    <thead>
        <tr class="tblHead">
            <th align="center">#</th>
            <th align="center">Source</th>
            <th align="center">Complaint Num</th>
            <th align="center">Customer Name</th>
            <th align="center">Customer Email</th>
            <th align="center">Response Number</th>
            <th align="center">Current Date</th>
            <th align="center">Days Since Complaint</th>
            <th align="center">Type</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $i = 1;
        foreach ($smsDetails as $row):
        ?>
        <tr>
            <td align="center"><?php echo $i++; ?></td>
            <td align="center"><?php echo $row['source']; ?></td>
            <td align="center"><?php echo $row['complaint_num']; ?></td>
            <td align="center"><?php echo $row['customer_name']; ?></td>
            <td align="center"><?php echo $row['customer_email']; ?></td>
            <td align="center"><?php echo $row['response_number']; ?></td>
            <td align="center"><?php echo $row['current_date']; ?></td>
            <td align="center"><?php echo $row['days_since_complaint']; ?></td>
            <td align="center"><?php echo $row['type']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <!-- <tfoot>
        <tr class="tblFoot">
            <td colspan="8" align="center">
                <b>Total Records:</b> <?php echo count($smsDetails); ?>
            </td>
        </tr>
    </tfoot> -->
</table>
</body>
</html>