<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'lead.php');
include(CLASSES_PATH.DS.'lead_rpt.php');
//include(CLASSES_PATH.DS.'user.php');
//include(CLASSES_PATH.DS.'product.php');
//require_once(MAILER_PATH.DS.'PHPMailer/PHPMailerAutoload.php');
//require_once('/var/www/html/igicrm/third_party/PHPMailer/PHPMailerAutoload.php');

$objLead        = new Lead();
$objLeadReport  = new LeadReport();
//$objUser        = new User();
//$objProd        = new Product();

$login_id = $_SESSION['login_id'];

if(isset($_POST)) 
{
    $id                  = isset($_POST['id'])?$_POST['id']: 0;
    $city                = isset($_POST['city'])?$_POST['city']: '';
    
    if(isset($_POST['action'])) 
    {
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == 'search_lead_status_rpt')
        {
            $FromDate      = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate        = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            
            $data          = $objLeadReport->countsLeadsByStatus($FromDate,$ToDate);

            //print_r($row['initiated_leads']/$row['all_leads']*100);die;
            
            $output = '';
            $output .='<table id="data-table" class="table table-igi table-responsive">
                            <thead>
                                <tr>
                                    <th width="600px;">Lead Status</th>
                                    <th width="200px;">Lead Count</th>
                                    <th width="200px;">Overall Percentage</th>
                                </tr>
                            </thead>
                            <tbody>';

                            foreach($data as $row)
                            {
                                $initiated_leads_pval       = ($row['initiated_leads']/$row['all_leads'])*100;
                                $inprogress_leads_pval      = ($row['inprogress_leads']/$row['all_leads'])*100;
                                $followup_leads_pval        = ($row['followup_leads']/$row['all_leads'])*100;
                                $bought_leads_pval          = ($row['bought_leads']/$row['all_leads'])*100;
                                $not_interested_leads_pval  = ($row['not_interested_leads']/$row['all_leads'])*100;
                                $general_inquiry_leads_pval = ($row['general_inquiry_leads']/$row['all_leads'])*100;

                                $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;
                                
                                $output .='<tr>';
                                    $output .='<td>Initiated</td>';
                                    $output .='<td>'.$row['initiated_leads'].'</td>';
                                    $output .='<td>'.number_format($initiated_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>In Progress</td>';
                                    $output .='<td>'.$row['inprogress_leads'].'</td>';
                                    $output .='<td>'.number_format($inprogress_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Follow Up</td>';
                                    $output .='<td>'.$row['followup_leads'].'</td>';
                                    $output .='<td>'.number_format($followup_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Bought</td>';
                                    $output .='<td>'.$row['bought_leads'].'</td>';
                                    $output .='<td>'.number_format($bought_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Not Interested</td>';
                                    $output .='<td>'.$row['not_interested_leads'].'</td>';
                                    $output .='<td>'.number_format($not_interested_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>General Inquiry</td>';
                                    $output .='<td>'.$row['general_inquiry_leads'].'</td>';
                                    $output .='<td>'.number_format($general_inquiry_leads_pval,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td><b>Total</b></td>';
                                    $output .='<td><b>'.number_format($row['all_leads']).'</b></td>';
                                    $output .='<td><b>'.number_format($t_pval)."%".'</b></td>';
                                $output .='</tr>';
                            }

            $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_lead_status_report')
        {
            $FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
            $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';

            echo "success|".$FromDate."|".$ToDate;
        }
        elseif($action == 'search_lead_citywise_rpt')
        {
            //echo "sadasdsa";die;

            $FromDate      = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate        = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            $RgCity        = isset($_POST['RgCity'])?$_POST['RgCity']: '';

            if($RgCity != '')
            {
                $city_name     = $objLeadReport->countsLeadsByCityOne($RgCity);
                $get_city_name = $objLeadReport->GetCityName($RgCity);
                $get_city_name = $get_city_name[0]['fullname'];
            }
            else
            {
                $get_city_name = "All";
            }
            
            $data          = $objLeadReport->countsLeadsByCity($FromDate,$ToDate,$RgCity);
            
            $output = '';
            $output .='<table id="data-table" class="table table-igi table-responsive">
                            <thead>
                                <tr>
                                    <th width="400px;">City</th>
                                    <th width="100px;">Count</th>
                                    <th width="100px;">Percent</th>
                                    <th width="200px;">Lead Status</th>
                                    <th width="100px;">Male</th>
                                    <th width="100px;">Female</th>
                                    <th width="150px;">Lead Count</th>
                                    <th width="200px;">Overall Percentage</th>
                                </tr>
                            </thead>';

                            foreach($data as $row)
                            {
                                /*echo "<pre>";
                                    print_r($row);
                                echo "</pre>";
                                die;*/

                                $output .='<tbody>';
                                    $initiated_leads_pval       = ($row['initiated_leads']/$row['counts'])*100;
                                    $inprogress_leads_pval      = ($row['inprogress_leads']/$row['counts'])*100;
                                    $followup_leads_pval        = ($row['followup_leads']/$row['counts'])*100;
                                    $bought_leads_pval          = ($row['bought_leads']/$row['counts'])*100;
                                    $not_interested_leads_pval  = ($row['not_interested_leads']/$row['counts'])*100;
                                    $general_inquiry_leads_pval = ($row['general_inquiry_leads']/$row['counts'])*100;

                                    $t_pval = $initiated_leads_pval + $inprogress_leads_pval + $followup_leads_pval + $bought_leads_pval + $not_interested_leads_pval + $general_inquiry_leads_pval;

                                    $all_leads = $row['initiated_leads'] + $row['inprogress_leads'] + $row['followup_leads'] + $row['bought_leads'] + $row['not_interested_leads'] + $row['general_inquiry_leads'];

                                    $output .='<tr>';
                                        if($city_name != '')
                                        {
                                            $output .='<td rowspan="6">'.$get_city_name.'</td>';
                                        }
                                        else 
                                        {
                                            $output .='<td rowspan="6">'.$get_city_name.'</td>';
                                        }
                                        $output .='<td rowspan="6">'.$all_leads.'</td>';
                                        $output .='<td rowspan="6">'.number_format($all_leads/$row['counts']*100,2)."%".'</td>';
                                        $output .='<td>Initiated</td>';
                                        $output .='<td>'.$row['initiated_male_leads'].'</td>';
                                        $output .='<td>'.$row['initiated_female_leads'].'</td>';
                                        $output .='<td>'.$row['initiated_leads'].'</td>';
                                        $output .='<td>'.number_format($row['initiated_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';

                                    $output .='<tr>';
                                        $output .='<td>Inprogress</td>';
                                        $output .='<td>'.$row['inprogress_male_leads'].'</td>';
                                        $output .='<td>'.$row['inprogress_female_leads'].'</td>';
                                        $output .='<td>'.$row['inprogress_leads'].'</td>';
                                        $output .='<td>'.number_format($row['inprogress_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';

                                    $output .='<tr>';
                                        $output .='<td>Follow Up</td>';
                                        $output .='<td>'.$row['followup_male_leads'].'</td>';
                                        $output .='<td>'.$row['followup_female_leads'].'</td>';
                                        $output .='<td>'.$row['followup_leads'].'</td>';
                                        $output .='<td>'.number_format($row['followup_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';

                                    $output .='<tr>';
                                        $output .='<td>Bought</td>';
                                        $output .='<td>'.$row['bought_male_leads'].'</td>';
                                        $output .='<td>'.$row['bought_female_leads'].'</td>';
                                        $output .='<td>'.$row['bought_leads'].'</td>';
                                        $output .='<td>'.number_format($row['bought_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';

                                    $output .='<tr>';
                                        $output .='<td>Not Interested</td>';
                                        $output .='<td>'.$row['not_interested_male_leads'].'</td>';
                                        $output .='<td>'.$row['not_interested_female_leads'].'</td>';
                                        $output .='<td>'.$row['not_interested_leads'].'</td>';
                                        $output .='<td>'.number_format($row['not_interested_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';

                                    $output .='<tr>';
                                        $output .='<td>General Inquiry</td>';
                                        $output .='<td>'.$row['general_inquiry_male_leads'].'</td>';
                                        $output .='<td>'.$row['general_inquiry_female_leads'].'</td>';
                                        $output .='<td>'.$row['general_inquiry_leads'].'</td>';
                                        $output .='<td>'.number_format($row['general_inquiry_leads']/$data[0]['counts']*100,2)."%".'</td>';
                                    $output .='</tr>';
                                $output .='</tbody>';

                                $output .='</tfoot>';
                                    $output .='<tr class="tblFoot">';
                                        $output .='<td colspan="4"><b>Total</b></td>';
                                        $output .='<td><b>'.number_format($row['all_male_leads']).'</b></td>';
                                        $output .='<td><b>'.number_format($row['all_female_leads']).'</b></td>';
                                        $output .='<td><b>'.number_format($row['all_leads']).'</b></td>';
                                        $output .='<td><b>'.number_format($t_pval,2)."%".'</b></td>';
                                    $output .='</tr>';
                                $output .='</tfoot>';
                            }
                    $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_all_lead_citywise_report')
        {
            echo "success";
        }
        elseif($action == 'export_lead_citywise_report')
        {
            $FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
            $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';
            $RgCity    = isset( $_POST['RgCity'] )   ? $_POST['RgCity']   : '';

            echo "success|".$FromDate."|".$ToDate."|".$RgCity;
        }
        elseif($action == 'search_lead_source_info_rpt')
        {
            $FromDate      = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate        = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            $RgCity        = isset($_POST['RgCity'])?$_POST['RgCity']: '';
            
            $data          = $objLeadReport->countsLeadsBySourceInfo($FromDate,$ToDate,$RgCity);

            if($RgCity != '')
            {
                $city_name     = $objLeadReport->countsLeadsByCityOne($RgCity);
                $get_city_name = $objLeadReport->GetCityName($RgCity);
                $get_city_name = $get_city_name[0]['fullname'];
            }
            else
            {
                $get_city_name = "All";
            }

            $output = '';
            $output .='<table id="data-table" class="table table-igi table-responsive">
                            <thead>
                                <tr>
                                    <th width="400px;">City</th>
                                    <th width="100px;">Count</th>
                                    <th width="100px;">Percent</th>
                                    <th width="300px;">Source Of Information</th>
                                    <th width="100px;">Male</th>
                                    <th width="150px;">Female</th>
                                    <th width="150px;">Lead Count</th>
                                    <th width="200px;">Overall Percentage</th>
                                </tr>
                            </thead>

                            <tbody>';
                            foreach($data as $row)
                            {
                                $email_leads_pval      = ($row['email']/$row['counts'])*100;
                                $calls_leads_pval      = ($row['calls']/$row['counts'])*100;
                                $letter_leads_pval     = ($row['letter']/$row['counts'])*100;
                                $walkin_customer_leads_pval    = ($row['walkin_customer']/$row['counts'])*100;
                                $website_leads_pval    = ($row['website']/$row['counts'])*100;
                                $corporate_partners_leads_pval      = ($row['corporate_partners']/$row['counts'])*100;
                                $vec_leads_pval      = ($row['vec']/$row['counts'])*100;
                                $billboard_leads_pval  = ($row['billboard']/$row['counts'])*100;

                                $t_pval = $email_leads_pval + $calls_leads_pval + $letter_leads_pval + $walkin_customer_leads_pval + $website_leads_pval + $corporate_partners_leads_pval + $vec_leads_pval + $billboard_leads_pval;

                                $all_leads = $row['email'] + $row['calls'] + $row['letter'] + $row['walkin_customer'] + $row['website'] + $row['corporate_partners'] + $row['vec'] + $row['billboard'];

                                $output .='<tr>';
                                    if($city_name != '')
                                    {
                                        $output .='<td rowspan="8">'.$city_name[0]['city_name'].'</td>';
                                    }
                                    else 
                                    {
                                        $output .='<td rowspan="8">'.$get_city_name.'</td>';
                                    }
                                    $output .='<td rowspan="8">'.$all_leads.'</td>';
                                    $output .='<td rowspan="8">'.number_format($all_leads/$row['counts']*100,2)."%".'</td>';

                                    $output .='<td>Email</td>';
                                    $output .='<td>'.$row['email_male_leads'].'</td>';
                                    $output .='<td>'.$row['email_female_leads'].'</td>';
                                    $output .='<td>'.$row['email'].'</td>';
                                    $output .='<td>'.number_format($row['email']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Calls</td>';
                                    $output .='<td>'.$row['calls_male_leads'].'</td>';
                                    $output .='<td>'.$row['calls_female_leads'].'</td>';
                                    $output .='<td>'.$row['calls'].'</td>';
                                    $output .='<td>'.number_format($row['calls']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Letter</td>';
                                    $output .='<td>'.$row['letter_male_leads'].'</td>';
                                    $output .='<td>'.$row['letter_female_leads'].'</td>';
                                    $output .='<td>'.$row['letter'].'</td>';
                                    $output .='<td>'.number_format($row['letter']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Walk in Customer</td>';
                                    $output .='<td>'.$row['walkin_customer_male_leads'].'</td>';
                                    $output .='<td>'.$row['walkin_customer_female_leads'].'</td>';
                                    $output .='<td>'.$row['walkin_customer'].'</td>';
                                    $output .='<td>'.number_format($row['walkin_customer']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Website</td>';
                                    $output .='<td>'.$row['website_male_leads'].'</td>';
                                    $output .='<td>'.$row['website_female_leads'].'</td>';
                                    $output .='<td>'.$row['website'].'</td>';
                                    $output .='<td>'.number_format($row['website']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Corporate Partners</td>';
                                    $output .='<td>'.$row['corporate_partners_male_leads'].'</td>';
                                    $output .='<td>'.$row['corporate_partners_female_leads'].'</td>';
                                    $output .='<td>'.$row['corporate_partners'].'</td>';
                                    $output .='<td>'.number_format($row['corporate_partners']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Vitality Experience Center</td>';
                                    $output .='<td>'.$row['vec_male_leads'].'</td>';
                                    $output .='<td>'.$row['vec_female_leads'].'</td>';
                                    $output .='<td>'.$row['vec'].'</td>';
                                    $output .='<td>'.number_format($row['vec']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>BillBoard / Others</td>';
                                    $output .='<td>'.$row['billboard_male_leads'].'</td>';
                                    $output .='<td>'.$row['billboard_female_leads'].'</td>';
                                    $output .='<td>'.$row['billboard'].'</td>';
                                    $output .='<td>'.number_format($row['billboard']/$data[0]['counts']*100,2)."%".'</td>';
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td colspan="4"><b>Total</b></td>';
                                    $output .='<td><b>'.number_format($row['all_male_leads']).'</b></td>';
                                    $output .='<td><b>'.number_format($row['all_female_leads']).'</b></td>';
                                    $output .='<td><b>'.number_format($all_leads).'</b></td>';
                                    $output .='<td><b>'.number_format($t_pval,2)."%".'</b></td>';
                                $output .='</tr>';
                            }

            $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_all_lead_source_report')
        {
            echo "success";
        }
        elseif($action == 'export_lead_source_report')
        {
            $FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
            $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';
            $RgCity    = isset( $_POST['RgCity'] )   ? $_POST['RgCity']   : '';

            echo "success|".$FromDate."|".$ToDate."|".$RgCity;
        }
        elseif($action == 'search_lead_regional_rpt')
        {
            $FromDate         = isset($_POST['FromDate'])?$_POST['FromDate']: '';
            $ToDate           = isset($_POST['ToDate'])?$_POST['ToDate']: '';
            $RegionalManagers = isset($_POST['RegionalManagers'])?$_POST['RegionalManagers']: '';

            $regionalManager  = $objLeadReport->getRegionalManagersById($RegionalManagers);
           
            $sum_male_leads         = 0;
            $sum_female_leads       = 0;
            $sum_count_leads        = 0;
            $sum_percentage_leads   = 0;

            $output = '';
            $output .='<table id="data-table" class="table table-igi table-responsive">
                            <thead>
                                <tr>
                                    <th width="300px;">Regional Manager</th>
                                    <th width="100px;">Count</th>
                                    <th width="100px;">Percent</th>
                                    <th width="300px;">Lead Status</th>
                                    <th width="100px;">Male</th>
                                    <th width="100px;">Female</th>
                                    <th width="150px;">Lead Count</th>
                                    <th width="200px;">Overall Percentage</th>
                                </tr>
                            </thead>

                            <tbody>';
                            foreach($regionalManager as $regionalManagers)
                            {
                                $regional_manager_id = $regionalManagers['regional_manager_id'];
                                $data1 = $objLeadReport->countsLeadsByRegional($FromDate,$ToDate,$regional_manager_id);

                                $lead_counts = $data1[0]['initiated_leads'] + $data1[0]['inprogress_leads'] + $data1[0]['followup_leads'] + $data1[0]['bought_leads'] + $data1[0]['not_interested_leads'] + $data1[0]['general_inquiry_leads'];

                                $output .='<tr>';
                                    $output .='<td rowspan="6">'.$regionalManagers['regional_manager_name'].'</td>';
                                    $output .='<td rowspan="6">'.$lead_counts.'</td>';
                                    $output .='<td rowspan="6">'.number_format(($lead_counts/$data1[0]['counts']*100),2)."%".'</td>';

                                    $output .='<td>Initiated</td>';
                                    $output .='<td>'.$data1[0]['initiated_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['initiated_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['initiated_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['initiated_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['initiated_male_leads'];
                                    $sum_female_leads += $data1[0]['initiated_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['initiated_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Inprogress</td>';
                                    $output .='<td>'.$data1[0]['inprogress_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['inprogress_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['inprogress_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['inprogress_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['inprogress_male_leads'];
                                    $sum_female_leads += $data1[0]['inprogress_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['inprogress_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Follow Up</td>';
                                    $output .='<td>'.$data1[0]['followup_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['followup_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['followup_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['followup_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['followup_male_leads'];
                                    $sum_female_leads += $data1[0]['followup_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['followup_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Bought</td>';
                                    $output .='<td>'.$data1[0]['bought_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['bought_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['bought_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['bought_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['bought_male_leads'];
                                    $sum_female_leads += $data1[0]['bought_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['bought_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>Not Interested</td>';
                                    $output .='<td>'.$data1[0]['not_interested_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['not_interested_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['not_interested_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['not_interested_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['not_interested_male_leads'];
                                    $sum_female_leads += $data1[0]['not_interested_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['not_interested_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';

                                $output .='<tr>';
                                    $output .='<td>General Inquiry</td>';
                                    $output .='<td>'.$data1[0]['general_inquiry_male_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['general_inquiry_female_leads'].'</td>';
                                    $output .='<td>'.$data1[0]['general_inquiry_leads'].'</td>';
                                    $output .='<td>'.number_format($data1[0]['general_inquiry_leads']/$data1[0]['counts']*100,2)."%".'</td>';

                                    $sum_male_leads += $data1[0]['general_inquiry_male_leads'];
                                    $sum_female_leads += $data1[0]['general_inquiry_female_leads'];
                                    $sum_count_leads = $sum_male_leads + $sum_female_leads;
                                    $sum_percentage_leads += number_format($data1[0]['general_inquiry_leads']/$data1[0]['counts']*100,2);
                                $output .='</tr>';
                            }

                            $output .='</tfoot>';
                                $output .='<tr>';
                                    $output .='<td colspan="4"><b>Total</b></td>';
                                    $output .='<td><b>'.$sum_male_leads.'</b></td>';
                                    $output .='<td><b>'.$sum_female_leads.'</b></td>';
                                    $output .='<td><b>'.$sum_count_leads.'</b></td>';
                                    $output .='<td><b>'.number_format($sum_percentage_leads,2)."%".'</b></td>';
                                $output .='</tr>';
                            $output .='</tfoot>';
                        $output .='</tbody>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_all_lead_regional_report')
        {
            echo "success";
        }
        elseif($action == 'export_lead_regional_report')
        {
            $FromDate  = isset( $_POST['FromDate'] ) ? $_POST['FromDate'] : '';
            $ToDate    = isset( $_POST['ToDate'] )   ? $_POST['ToDate']   : '';
            $RegionalManagers    = isset( $_POST['RegionalManagers'] )   ? $_POST['RegionalManagers']   : '';

            echo "success|".$FromDate."|".$ToDate."|".$RegionalManagers;
        }
    }
}
?>