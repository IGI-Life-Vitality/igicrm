<?php
require __DIR__ . '/business/config.php';
$api_lib = new api_lib();

if(isset($_REQUEST['menu']))
{
    $menu    = isset( $_REQUEST['menu'] )?$_REQUEST['menu']:'';

    switch( $menu ) 
    {
        case "save_lead":

            //echo "API HIT"; die;

            $name               = isset( $_REQUEST['name'] )?$_REQUEST['name']:'';
            $email              = isset( $_REQUEST['email'] )?$_REQUEST['email']:'';
            $contact_no         = isset( $_REQUEST['mobile'] )?$_REQUEST['mobile']:'';
            $intersted_product  = isset( $_REQUEST['product'] )?$_REQUEST['product']:'';
            $created_date       = date('Y-m-d');
            $lead_source        = "7";

            //print_r($name . "," . $email . "," . $contact_no . "," . $intersted_product . "," . $created_date . "," . $lead_source); die;

            if( isset($name) && isset($email) && isset($contact_no) && isset($intersted_product) && isset($created_date) && isset($lead_source) )
            {
                `echo "$name|$email|$contact_no|$intersted_product|$created_date|$lead_source" >> /tmp/igicrm/api_hit.log`;

                $return_value = $api_lib->save_lead($name, $email, $contact_no, $intersted_product, $created_date, $lead_source);
                echo($return_value);
            }
            else
            {
                echo($api_lib->missing_params());
                die();
            }

        case "complaint_feedback":
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);
            //echo "API HIT"; die;
            $complaintId                        = isset( $input['complaint_id'] )?$input['complaint_id']:null;
            $complaintType                      = isset( $input['complaint_type'] )?$input['complaint_type']:null;
            $overAllSatisfaction                = isset( $input['over_all_satisfaction'] )?$input['over_all_satisfaction']:null;
            $resolutionTimeSatisfaction         = isset( $input['resolution_time_satisfaction'] )?$input['resolution_time_satisfaction']:null;
            $staffBehavior                      = isset( $input['staff_behavior'] )?$input['staff_behavior']:null;
            $feedbackComments                   = isset( $input['feedback_comments'] )?$input['feedback_comments']:null;
            $feedbackDate                       = date('Y-m-d');

            $dataToUpdate = [
                'over_all_satisfaction'       => $input['over_all_satisfaction'],
                'resolution_time_satisfaction'=> $input['resolution_time_satisfaction'],
                'staff_behavior'              => $input['staff_behavior'],
                'feedback_comments'           => $input['feedback_comments'],
                'feedback_date'               => $feedbackDate
            ];
            
            $where = [
                'complaint_num' => $input['complaint_id']
            ];
            // echo 'ss';
            if( isset($complaintId) && isset($complaintType) && isset($overAllSatisfaction) && isset($resolutionTimeSatisfaction) && isset($staffBehavior) && isset($feedbackComments) )
            {
                `echo "$data" >> /tmp/igicrm/api_hit.log`;
                $returnValue = $api_lib->complaintFeedback($complaintType,$dataToUpdate,$where);
                echo $returnValue;
            }
            else
            {
                header('Content-Type: application/json');
                echo json_encode(
                    array(
                        'status'  => 'fail',
                        'message' => 'Missing required parameters',
                    )
                );
                exit;
            }

        break;

        default:

        echo($api_lib->invalidRequest());

        break;
    }
}
else 
{
    echo("<h1><center>You are not authorized person to view this page.</center></h1>");
}

//URL for Localhost with Parameters
//http://localhost/igicrm/api/index.php?menu=save_lead&name=adnan&email=adnan@gmail.com&mobile=92342270345&product=3
?>