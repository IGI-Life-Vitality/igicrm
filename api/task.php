<?php
include('../includes/config.php');
include('../classes/task.php');
include('../classes/user.php');
include('../classes/taskcat.php');
include('../classes/api_auth.php');

header('Content-Type: application/json');
$objTask = new Task();
$objTaskCat = new Taskcat();
$apiAuth = new ApiAuth();
// die('aaaa');
if (isset($_REQUEST['menu'])) {
    $menu    = isset($_REQUEST['menu']) ? $_REQUEST['menu'] : '';
    $token    = isset($_SERVER['HTTP_AUTH_TOKEN']) ? $_SERVER['HTTP_AUTH_TOKEN'] : '';

    // Handling unauthorize user for all menu except login   
    if ($menu !== "login") {
        if (!empty($token)) {
            $tokenIsValid  = $apiAuth->validateToken($token);
            if (!$tokenIsValid) {
                $response = ['status_code'   => '401', 'response' => 'Unauthorized Request'];
                echo json_encode($response);
                die;
            }
        } else {
            echo (api_params_missing('Auth-Token is required in header'));
            die();
        }
    }

    // If user is Authorize than move to api
    switch ($menu) {
        case "login":
            $username = $_REQUEST['user_name'];
            $password = $_REQUEST['password'];

            if (isset($username)) {
                $response = $apiAuth->authLogin($username, $password);
                if ($response['status']) {
                    $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
                    echo json_encode($response);
                } else {
                    $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
                    echo json_encode($response);
                }
            } else {
                echo (api_params_missing('user _name field is required'));
                die();
            }
            break;

        case "get_task_cat":
            $response = $objTask->GetTaskCat();
            $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
            echo json_encode($response);
            break;

        case "get_task_sub_cat":

            $id = $_REQUEST['cat_id'];

            if (isset($id)) {
                $response = $objTask->GetSubCategoryByCategoryID($id);
                $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
                echo json_encode($response);
            } else {
                echo (api_params_missing('cat_id field is required'));
                die();
            }
            break;

        case "get_ism":

            $cat_id = $_REQUEST['cat_id'];
            $sub_cat_id = $_REQUEST['sub_cat_id'];

            if (isset($cat_id) && isset($sub_cat_id)) {
                $response = $objTaskCat->GetTskIsmss($sub_cat_id, $cat_id, $is_main = 1);
                $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
                echo json_encode($response);
            } else {
                echo (api_params_missing('cat_id and sub_cat_id fields is required'));
                die();
            }
            break;

        case "task_add":

            if (empty($_REQUEST['ism_id']) || empty($_REQUEST['policy_number']) || empty($_REQUEST['task_description'])) {
                echo (api_params_missing('ism_id, policy_number and task_description field are required'));
                die;
            }

            $ismId         = isset($_REQUEST['ism_id']) ? $_REQUEST['ism_id'] : ' ';
            $assignedToUserId         = isset($_REQUEST['assigned_to_user_id']) ? $_REQUEST['assigned_to_user_id'] : ' ';
            $policyNumber         = isset($_REQUEST['policy_number']) ? $_REQUEST['policy_number'] : ' ';
            $taskDescription         = isset($_REQUEST['task_description']) ? $_REQUEST['task_description'] : ' ';

            $objTask = new Task();
            $objUser = new User();
            $objTaskcat = new Taskcat();

            $data        = $objTask->GetISMByCategoryANDSubCategory($ismId);
            if (empty($data)) {
                $response = ['status_code'   => '200', 'response' => 'No ISM Found'];
                echo json_encode($response);
                die;
            }

            $userdetails = $objUser->GetUserDetail($data[0]["user_id"]);

            $title = $objTaskcat->GetCategoryNameById($data[0]['task_category_id']) . "-" . $objTaskcat->GetSubCategoryNameById($data[0]['sub_cat_id']);
            $isManual = $data[0]['operation_mode'] == 0 ? '1' : '0';
            if ($isManual == '1' && empty($assignedToUserId)) {
                echo (api_params_missing('assigned_to_user_id field is required'));
                die;
            } elseif ($isManual == '1' && !empty($assignedToUserId)) {
                $userdetails = $objUser->GetUserDetail($assignedToUserId);
            }

            //check remove on request of IGI dated 2024-04-25
            /*if (empty($userdetails)) {
                echo (api_params_missing('assigned_to_user_id not match in database'));
                die();
            }*/
            
            $api_group_id = 0;
            if (!empty($userdetails)) {
                $api_group_id = $userdetails["group_id"];
            }

            $usergroup        =  $api_group_id; //$userdetails["group_id"];
            $id               = 0;
            $opmode           = $isManual;
            $counter          = '';
            $task_num         = '';
            $task_cat         = $data[0]['task_category_id'];
            $task_subcat      = $data[0]['sub_cat_id'];
            $task_ism         = $data[0]['id'];
            $task_ism_desc    = $data[0]["desc"];
            $priority         = $data[0]["pri"];
            $group_id         = $usergroup;
            $assigned_to      = '';
            $verified_by      = '';
            $cc_users         = '';
            $task_title       = $title;
            $start_time       = isset($_POST['datetimepicker_start']) ? $_POST['datetimepicker_start'] : '';
            $end_time         = isset($_POST['datetimepicker_end']) ? $_POST['datetimepicker_end'] : '';
            $task_desc        = $taskDescription;
            $task_ism_id      = $data[0]["id"];
            $policy_number    = $policyNumber;
            $tid              = '0';

            if ($priority == 'High') {
                $priority = '1';
            } elseif ($priority == 'Low') {
                $priority = '2';
            } elseif ($priority == 'Medium') {
                $priority = '3';
            }

            if ($opmode == "1") {
                $assigned_to = $assignedToUserId;
            } else {
                $assigned_to = $data[0]["user_id"];
            }
            //ISM department will be set in "tbl_task_new" table inplace of "group_id"
            $GetISMGroupId = $objTask->GetISMGroupId($task_cat, $task_subcat, $task_ism);
            $group_id      = $GetISMGroupId[0]['department_id'];
            $channel      = 'APP';

            //validate file if exist
            if (!empty($_FILES['files'])) {
                if (!empty($_FILES['files']['name'][0])) {
                    $validateFile = validateFile();
                    if ($validateFile['status'] == 1) {
                        $response['attachment']['msg'] = $validateFile['description'];
                        $response['attachment']['status'] = "200";
                    } else {
                        $response['attachment']['msg'] = $validateFile['description'];
                        $response['attachment']['status'] = $validateFile['status'];
                        echo json_encode($response);
                        die;
                    }
                } else {
                    $response['attachment']['msg'] = 'No attachment found';
                    $response['attachment']['status'] = '0';
                    echo json_encode($response);
                    die;
                }
            }
            $login_id=382;
            $response = $objTask->SaveTaskNew($counter, $task_num, $task_cat, $task_subcat, $task_ism, $task_ism_desc, $task_title, $task_desc, $login_id, $group_id, $assigned_to, $verified_by, $cc_users, $start_time, $end_time, $priority, $task_ism_id, $policy_number, $tid, $channel);


            if ($response['status']) {
                $taskId = $response['task_id'];
                $taskNum = $response['task_num'];
                $response = array("status_code" => "200", "response" => "Task created successfully", "task_id" => $taskId, "task_status" => 'Initiated');

                // Check if the files key is present in the request
                if (!empty($_FILES['files']['name'][0])) {
                    $uploadResponse = uploadFiles($taskNum);
                    if ($uploadResponse['status'] == 1) {
                        $response['attachment']['msg'] = $uploadResponse['description'];
                        $response['attachment']['status'] = "200";
                    } else {
                        $response['attachment']['msg'] = $uploadResponse['description'];
                        $response['attachment']['status'] = $uploadResponse['status'];
                    }
                }
                echo json_encode($response);
            } else {
                $response = array("status_code" => "500", "response" => "Some error occured");
                echo json_encode($response);
            }

            break;

        case "get_tasks_list":

            $response = $objTask->GetAppTask($login_id, $user_type, $group_id);
            $response = ['status_code'   => '200', 'response' => !empty($response) ? $response : 'Record Not Found'];
            echo json_encode($response);
            break;

        case "task_details":
            $taskId = $_REQUEST['task_id'];
            if (isset($taskId)) {
                $data                   = $objTask->GetTaskById($taskId);
                $activity_data          = $objTask->GetTaskStatusById($taskId);

                $acticityArr = array();
                $filesArr = array();
                $dataArray = array();
                foreach ($activity_data as $row) {
                    if ($row["current_state"] == 2) {
                        $row["current_state"] = "In Progress";
                        $row["previous_state"]  = "Initiated";
                    } elseif ($row["current_state"] == 3) {
                        $row["current_state"] = "closed";
                        $row["previous_state"]  = "In Progress";
                    } elseif ($row["current_state"] == 4) {
                        $row["current_state"] = "verified";
                        $row["previous_state"]  = "closed";
                    } elseif ($row["current_state"] == 5) {
                        $row["current_state"] = "Invalid";
                        $row["previous_state"] = "Forwarded";
                    } elseif ($row["current_state"] == 6) {
                        $row["current_state"] = "ONHOLD/Forwarded";
                        $row["previous_state"] = "In Progress";
                    } elseif ($row["current_state"] == 8) {
                        $row["current_state"] = "Paused by requirement";
                        $row["previous_state"] = "In Progress";
                    } elseif ($row["current_state"] == 10) {
                        $row["current_state"] = "Pause by surrender";
                        $row["previous_state"] = "In Progress";
                    } elseif ($row["current_state"] == 9) {
                        $row["current_state"] = "Resumed";
                        $row["previous_state"] = "Paused";
                    }

                    array_push($acticityArr, $row);
                }
                $filepath  = SITE_ROOT . "/uploads_eform_complaint/task_attachment/" . $data[0]['task_num'] . "/";
                $filepath7 = SITE_IP . "/uploads_eform_complaint/task_attachment/" . $data[0]['task_num'] . "/";
                $files = scandir($filepath);
                for ($a = 2; $a < count($files); $a++) {
                    $fileDa = $filepath7 . $files[$a];
                    array_push($filesArr, $fileDa);
                }
                $dataArray['data'] = $data;
                $dataArray['activity_data'] = $acticityArr;
                $dataArray['files'] = $filesArr;
                $response = array(
                    "status_Code" => "200",
                    'response' => !empty($dataArray) ? $dataArray : 'Record Not Found'
                );
                echo json_encode($response);
            } else {
                echo (api_params_missing('Task id is required'));
            }
            break;

        default:
            echo (invalidRequest());
            break;
    }
} else {
    echo ("<h1><center>You are not authorized person to view this page.</center></h1>");
}

// Helper Functions
function api_params_missing($param = '')
{
    $data = array('status_code'   => '422', 'response' => $param);
    return json_encode($data);
}

function invalidRequest($opt = '', $msg = '')
{
    $opt = !empty($opt) ? " with [$opt] option." : '';

    $data[0] = array(
        'status' => 'invalid request' . $opt,
        'msg' => $msg
    );

    return json_encode($data);
}

/// file validation
function validateFile()
{
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'pdf'];  // Specify allowed file extensions
    $maxFileSize = 10 * 1024 * 1024;  // 10 MB in bytes
    // Loop through each file
    foreach ($_FILES['files']['name'] as $key => $fileName) {
        $fileSize = $_FILES['files']['size'][$key];

        // Extract file extension using explode and end
        $fileParts = explode('.', $fileName);
        $fileExtension = strtolower(end($fileParts));

        // Check file size
        if ($fileSize > $maxFileSize) {
            $response = array("status" => 0, "description" => 'File size exceeds the allowed limit (10 MB)');
            return $response;
        }

        // Check if the file type is allowed
        if (!in_array($fileExtension, $allowedExtensions)) {
            $response = array("status" => 0, "description" => 'Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions));
            return $response;
        }
    }
    $response = array("status" => 1, "description" => 'All attachments are fine');
    return $response;
}

// Define a function to handle file upload
function uploadFiles($taskNum)
{
    $uploadDir = '../uploads_eform_complaint/task_attachment/';  // Specify the directory where you want to save the uploaded files
    $response = ['success' => true, 'files' => []];

    // Loop through each file
    foreach ($_FILES['files']['name'] as $key => $fileName) {
        $fileTmpName = $_FILES['files']['tmp_name'][$key];

        $filename = stripslashes($fileName);
        $filename = preg_replace("/[^a-z0-9\_\-\.]/i", '', $filename);

        if (is_dir($uploadDir . $taskNum) == false) {
            mkdir($uploadDir . $taskNum);
        }

        $uploaddir = $uploadDir . $taskNum . "/" . $taskNum . "_" . $filename;

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($fileTmpName, $uploaddir)) {
            $response = array("status" => 1, "description" => 'Attachment successfully uploaded');
        } else {
            $response = array("status" => 0, "description" => 'Error moving the uploaded Attachment');
        }
    }

    return $response;
}
