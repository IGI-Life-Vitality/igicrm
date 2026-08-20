<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'taskcat_rpt.php');
include(CLASSES_PATH.DS.'user.php');

$objUser            = new User();
$objTaskcatReport   = new TaskcatReport();
$login_id           = $_SESSION['login_id'];
$current_datetime   = date('Y-m-d H:i:s');

if(isset($_POST)) 
{    
    if(isset($_POST['action'])) 
    {
        $action    = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == 'search_task_department_wise_ism_rpt')
        {
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            //print_r($durationType); die;

            /*$task_rating = $objTaskcatReport->getTaskRating(85,$durationType,$month,$quarter,$year);
            print_r($task_rating); die;*/
            
            $deprtments    = $objTaskcatReport->getDepartmentById($departmentName);

            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                        $output .='<thead>';
                            $output .='<tr>';
                                $output .='<th width="400px;">Department Name</th>';
                                $output .='<th width="100px;">Score Current Month</th>';
                                $output .='<th width="100px;">Grade Current Month</th>';
                                $output .='<th width="250px;">ISM Codes</th>';
                                $output .='<th width="150px;">ISM Description</th>';
                                $output .='<th width="100px;">TAT</th>';
                                $output .='<th width="300px;">Ownership</th>';
                                $output .='<th width="100px;">Weightage</th>';
                                $output .='<th width="100px;">Rating</th>';
                                $output .='<th width="100px;">Grade</th>';
                                $output .='<th width="100px;">Count of Closed Service Tickets</th>';
                            $output .='</tr>';
                        $output .='</thead>';

                        $cmpTotalLogged = 0;

                        foreach($deprtments as $deprtment)
                        {
                            $deprtment_id = $deprtment['id'];
                            $data2    = $objTaskcatReport->getIsmByDepartmentId($deprtment_id,$durationType,$month,$quarter,$year);
                            $colspan1 = count($data2);
                            $colspan1 = $colspan1 + 1;
                            //print_r($data2); die;

                            $output .='<tbody>';
                                $output .='<tr>';
                                    $output .="<td rowspan=".$colspan1.">".$deprtment['primary_name']."</td>";

                                    for($x=0; $x<count($data2); $x++)
                                    {
                                        // For Grade Current Month - Start
                                        $ism_id1 = $data2[$x]['id'];
                                        $task_rating1 = $objTaskcatReport->getTaskRating($ism_id1,$durationType,$month,$quarter,$year,$deprtment_id);
                                        $task_rating_percetage1 = ($task_rating1[0]['task_within_tat'] / $task_rating1[0]['total_service_request']) * 100;

                                        $getScoreCurrentMonth = $objTaskcatReport->getScoreCurrentMonth($deprtment_id);
                                        $count_ism_where_task_closed = count($getScoreCurrentMonth);

                                        $GradeCurrentMonth += $task_rating_percetage1;
                                        // For Grade Current Month - End
                                    }

                                    $total_ism = count($data2);
                                    $GradeCurrentMonth1 = number_format($GradeCurrentMonth / $count_ism_where_task_closed);
                                    if($total_ism > 1)
                                    {
                                        $output .="<td rowspan=".$colspan1.">".$GradeCurrentMonth1."%</td>";
                                    }
                                    else
                                    {
                                        $output .="<td rowspan=".$colspan1.">0%</td>";
                                    }

                                    if($GradeCurrentMonth1 >= "95")
                                    {
                                        $output .="<td rowspan=".$colspan1.">Outstanding</td>";
                                    }
                                    else if($GradeCurrentMonth1 >= "80" AND $GradeCurrentMonth1 <= "94")
                                    {
                                        $output .="<td rowspan=".$colspan1.">Very Good</td>";
                                    }
                                    else if($GradeCurrentMonth1 >= "71" AND $GradeCurrentMonth1 <= "79")
                                    {
                                        $output .="<td rowspan=".$colspan1.">Average</td>";
                                    }
                                    else if($GradeCurrentMonth1 <= "70")
                                    {
                                        $output .="<td rowspan=".$colspan1.">Below Average</td>";
                                    }
                                $output .='</tr>';

                                for($i=0; $i<count($data2); $i++)
                                {
                                    $output .='<tr>';
                                        if($data2 != 0) 
                                        {
                                            $output .='<td>'.$data2[$i]['fullname'].'</td>';
                                            $output .='<td>'.$data2[$i]['subcat_name'].'</td>';
                                            $output .='<td>'.$data2[$i]['tat']. " Days" . '</td>';
                                            $output .='<td>'.$data2[$i]['ownership'].'</td>';
                                            $output .='<td>'.$data2[$i]['weightage'].'</td>';

                                            // Rating
                                            $ism_id = $data2[$i]['id'];
                                            $task_rating = $objTaskcatReport->getTaskRating($ism_id,$durationType,$month,$quarter,$year,$deprtment_id); 
                                            //print_r($task_rating); die;
                                            $task_rating_percetage = ($task_rating[0]['task_within_tat'] / $task_rating[0]['total_service_request']) * 100;
                                            $rating = number_format($task_rating_percetage,2);
                                            $output .='<td>'.$rating."%". '</td>';

                                            if($task_rating_percetage >= "95")
                                            {
                                                $grade = "Outstanding";
                                            }
                                            else if($task_rating_percetage >= "80" AND $task_rating_percetage <= "94")
                                            {
                                                $grade = "Very Good";
                                            }
                                            else if($task_rating_percetage >= "71" AND $task_rating_percetage <= "79")
                                            {
                                                $grade = "Average";
                                            }
                                            else if($task_rating_percetage <= "70")
                                            {
                                                $grade = "Below Average";
                                            }
                                            $output .='<td>'.$grade.'</td>';

                                            $output .='<td>'.$task_rating[0]['total_closed_service'].'</td>';
                                        }
                                        else
                                        {
                                            $output .='<td class="na" colspan="8">NA</td>';
                                        }
                                    $output .='</tr>';
                                }
                            $output .='</tbody>';
                        }
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_task_department_wise_ism_rpt')
        {
            $departmentName= isset($_POST['getDepartment'])?$_POST['getDepartment']:'';
            $durationType  = isset($_POST['getDurationType'])?$_POST['getDurationType']:'';
            $month         = isset($_POST['getMonth'])?$_POST['getMonth']:'';
            $quarter       = isset($_POST['getQuarter'])?$_POST['getQuarter']:'';
            $year          = isset($_POST['getYear'])?$_POST['getYear']:'';

            echo "success|".$departmentName."|".$durationType."|".$month."|".$quarter."|".$year;
        }
        elseif($action == 'search_task_ism_wise_rpt')
        {
            $FromDate = isset($_POST['FromDate'])?$_POST['FromDate']:'';
            $log_datetime = $FromDate;          

            /*$SUM_AvgMinutesPerActivity = 0;*/
            $SUM_BF = 0;
            $SUM_Incoming = 0;
            $SUM_Total = 0;
            $SUM_Today_Completed = 0;
            $SUM_CF = 0;
            $SUM_Main_Hours = 0;
            $SUM_Day1 = 0;
            $SUM_Day2 = 0;
            $SUM_Day3 = 0;
            $SUM_Day4 = 0;

            $ismDetails = $objTaskcatReport->getIsmWiseResultDetails($log_datetime);

            $output = '';
            $output .='<table id="tblTable" class="table table-igi table-responsive table-bordered">';
                        $output .='<thead>';
                            $output .='<tr>';
                                $output .='<th class="text-center line-hight">INTERNAL <br>SERVICE MEASURE</th>';
                                $output .='<th class="text-center line-hight">ISM\'s</th>';
                                $output .='<th class="text-center line-hight">TAT <br> SLA Days</th>';
                                $output .='<th class="text-center line-hight">Avg. Minutes<br> Per Activity</th>';
                                $output .='<th class="text-center line-hight">B/F</th>';
                                $output .='<th class="text-center line-hight">Incoming</th>';
                                $output .='<th class="text-center line-hight">Total</th>';
                                $output .='<th class="text-center line-hight">Today<br>Completed</th>';
                                $output .='<th class="text-center line-hight">C/F</th>';
                                $output .='<th class="text-center line-hight">Man-Hours</th>';
                                $output .='<th class="text-center line-hight">1<br> Day</th>';
                                $output .='<th class="text-center line-hight">2<br> Days</th>';
                                $output .='<th class="text-center line-hight">3<br> Days</th>';
                                $output .='<th class="text-center line-hight">4<br> Days or Above</th>';
                            $output .='</tr>';
                        $output .='</thead>';

                        foreach($ismDetails as $ismDetail)
                        {
                            if(count($ismDetails) > 0)
                            {
                                $ism_sub_cat_id   = $ismDetail['ism_sub_cat_id'];
                                $ism_id           = $ismDetail['ism_id'];
                                $last_date        = DATE('Y-m-d', strtotime("-1 day"));
                                $present_date     = DATE('Y-m-d');
                                $incomming_status = "1,2,4,5,6";
                                $completed_status = "3";

                                $getSubCatName    = $objTaskcatReport->getSubCatName($ism_sub_cat_id,$ism_id);

                                $output .='<tbody>';
                                    $output .='<tr>';
                                        $output .='<td class="line-hight">'.$getSubCatName[0]['subcat_name'].'</td>';
                                        $output .='<td class="line-hight">'.$getSubCatName[0]['fullname'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['tat']. " Days" . '</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['avg_mint_activity'].'</td>';
                                        $output .='<td class="text-center line-hight bgColor">'.$ismDetail['bf'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['incomming'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['total'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['today_completed'].'</td>';
                                        $output .='<td class="text-center line-hight bgColor">'.$ismDetail['cf'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['main_hours'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['day_1'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['day_2'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['day_3'].'</td>';
                                        $output .='<td class="text-center line-hight">'.$ismDetail['day_4_above'].'</td>';
                                    $output .='</tr>';                            
                                $output .='</tbody>';

                                $SUM_BF              += $ismDetail['bf'];
                                $SUM_Incoming        += $ismDetail['incomming'];
                                $SUM_Total           += $ismDetail['total'];
                                $SUM_Today_Completed += $ismDetail['today_completed'];
                                $SUM_CF              += $ismDetail['cf'];
                                $SUM_Main_Hours      += $ismDetail['main_hours'];
                                $SUM_Day1 += $ismDetail['day_1'];
                                $SUM_Day2 += $ismDetail['day_2'];
                                $SUM_Day3 += $ismDetail['day_3'];
                                $SUM_Day4 += $ismDetail['day_4_above'];
                            }
                            else
                            {
                                echo "NA";
                            }
                        }

                        $output .='<tfoot>';
                            $output .='<tr>';
                                $output .='<td colspan="4">Grand Total</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_BF.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Incoming.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Total.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Today_Completed.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_CF.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Main_Hours.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Day1.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Day2.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Day3.'</td>';
                                $output .='<td class="text-center line-hight">'.$SUM_Day4.'</td>';
                            $output .='</tr>';
                            $output .='<tr>';
                                $output .='<td colspan="4"><b>Manpower in working hours includes, given extra time </b></td>';
                                $output .='<td colspan="11" class="text-center line-hight">'.number_format($SUM_Main_Hours/7,2).'</td>';
                            $output .='</tr>';
                        $output .='</tfoot>';
            $output .='</table>';

            echo "success|".$output;
        }
        elseif($action == 'export_task_ism_wise_rpt')
        {
            $FromDate = isset($_POST['FromDate'])?$_POST['FromDate']:'';

            echo "success|".$FromDate;
        }
    }
}

?>