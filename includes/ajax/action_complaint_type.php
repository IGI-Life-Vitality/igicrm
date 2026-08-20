<?php

require_once("../config.php");
include(CLASSES_PATH.DS.'complaint.php');
include(CLASSES_PATH.DS.'product.php');
include(CLASSES_PATH.DS.'user.php');

$objUser = new User();
$objprod = new Product();
$objComplaint = new Complaint();
$login_id = $_SESSION['login_id'];


if(isset($_POST)) {

    $id                  = isset($_POST['id'])?$_POST['id']: 0;
    $product_id          = isset($_POST['product_id'])?$_POST['product_id']:'';
    $product_category_id = isset($_POST['product_category']) ? $_POST['product_category'] : 0;
    $name                = isset($_POST['name'])?$_POST['name']:'';
    $tat                 = isset($_POST['tat'])?$_POST['tat']:'';
    $is_active           = isset($_POST['is_active'])?$_POST['is_active']:'';
    $mode                = isset($_POST['mode'])?$_POST['mode']: 0;
    $group_id            = isset($_POST['group_id']) != "" ? $_POST['group_id'] : 0;
    $user_id             = isset($_POST['user_id']) != "" ? $_POST['user_id'] : 0;
    $priority            = isset($_POST['priority']) != "" ? $_POST['priority'] : 0;

    $escalation_id       = isset($_POST['escalation_id'])?$_POST['escalation_id']: 0;
    $time_period1        = isset($_POST['time_period1'])?$_POST['time_period1']: 0;
    $time_period2        = isset($_POST['time_period2'])?$_POST['time_period2']: 0;
    $time_period3        = isset($_POST['time_period3'])?$_POST['time_period3']: 0;
    $time_period4        = isset($_POST['time_period4'])?$_POST['time_period4']: 0;
    $time_period5        = isset($_POST['time_period5'])?$_POST['time_period5']: 0;
    $level1              = isset($_POST['level1'])?$_POST['level1']:'';
    $level2              = isset($_POST['level2'])?$_POST['level2']:'';
    $level3              = isset($_POST['level3'])?$_POST['level3']:'';
    $level4              = isset($_POST['level4'])?$_POST['level4']:'';
    $level5              = isset($_POST['level5'])?$_POST['level5']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "save_type"){

            if($level1 != ''){
                $level1 = implode(",", $level1);
            }
            if($level2 != ''){
                $level2 = implode(",", $level2);
            }
            if($level3 != ''){
                $level3 = implode(",", $level3);
            }
            if($level4 != ''){
                $level4 = implode(",", $level4);
            }
            if($level5 != ''){
                $level5 = implode(",", $level5);
            }


            $response = $objComplaint->SaveComplaintType($group_id,$user_id,$name,$tat,$mode,$priority,$is_active);

            if($response > 0){
                $data = $objComplaint->SaveComplaintTypeEscalation($response,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5);
                echo $data;
            }

        }
        elseif($action == "edit_type"){

            if($level1 != ''){
                $level1 = implode(",", $level1);
            }
            if($level2 != ''){
                $level2 = implode(",", $level2);
            }
            if($level3 != ''){
                $level3 = implode(",", $level3);
            }
            if($level4 != ''){
                $level4 = implode(",", $level4);
            }
            if($level5 != ''){
                $level5 = implode(",", $level5);
            }


            $objComplaint->UpdateComplaintType($id,$group_id,$user_id,$name,$tat,$mode,$priority,$is_active);

            echo $objComplaint->UpdateComplaintTypeEscalation($escalation_id,$time_period1,$level1,$time_period2,$level2,$time_period3,$level3,$time_period4,$level4,$time_period5,$level5);

        }
        elseif($action == 'select_product'){

            $data = $objprod->GetProductByProductCategoryID($id);
            $Option = "<option disabled selected='selected'>Select Product</option>";
            foreach ($data as $row){
                $Option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
            }
            echo $Option;
        }elseif($action == 'select_assign_to'){
                //echo $group_id;
                $cmp_id = isset($_POST['cmp_id'])?$_POST['cmp_id']: 0;
                $Option = "<option value='' selected='selected' disabled>Select Assignee</option>";
                if($group_id != ""){
                 $users = $objUser->GetUserByGrpID($group_id);
                
                foreach($users as $user){
                 $Option .= "<option value ='".$user['id']."'". ($user['id'] == $cmp_id ? 'selected = selected': '').">".$user['first_name']." ".$user['last_name']."</option>"; 
                   //$Option .= "<option value ="$user['id']."".$data[0]['user_id'] == $user['id'] . "? 'selected='selected' : ''>" . $user['first_name'] ." ".$user['last_name']. "</option>";
                 }
               }
                 echo $Option;

            }elseif($action == 'get_cmp_type'){
                $data = $objComplaint->GetComplaintTypeByGroup($id);
               
                 $Option = "<option selected='selected' value='' disabled >Select Complaint Type</option>";
            foreach ($data as $row)
            {
                $Option .= "<option value ='".$row['id']."'>" . $row["fullname"] . "</option>";
            }

            echo $Option;

            }elseif($action == 'get_cmp_detail'){
                 $data             =  $objComplaint->GetComplaintTypeDetails($id);
                 $asign_user       = $data[0]['user_id'];
                 $asign_user_group = $data[0]['group_id'];
                 $pri              = $data[0]['priority'];
                 $weightage        = $objComplaint->GetPriorityLabel($pri);
                 $priority         = $weightage[0]['priority'];
                 $tat              = $data[0]['tat'];
                 $type             = "individual";
                 $mode             = $data[0]['operation_mode'];

                 $output           = $asign_user."|".$asign_user_group."|".$priority."|".$tat."|".$type."|".$mode;
                 echo $output;

            }
            elseif($action == 'delete'){
                  //echo $result = $objComplaint->delcomplainttype($id);
                   $result = $objComplaint->DeleteComplaintType($id);
                   if($result == "success"){
                      $data = $objComplaint->GetComplaintTypeList(0);
                      $output = '';
                      $output .= '<table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Complaint Type</th>
                            <th>TAT</th>
                            <th style="text-align: center;">Is Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>';

                         foreach($data as $row){ 
                            $isactive ="";
                            $isactive .= "(".$row['isactive'] ."== '1' ? checked = 'checked' : '') ";
                            $output .= '<tr>';
                            $output .=   '<td>'.$row["id"].'</td>';
                            $output .=   '<td>'.$row["fullname"].'</td>';
                            $output .=   '<td>'.$row["tat"].'Days</td>';
                            $output .= '<td style="text-align: center;"><input type="checkbox"'.$isactive.' disabled="disabled"></td>';
                                 /*$output .= '<td style="text-align: center;"><input type="checkbox" checked = "checked" ); disabled="disabled"></td>';*/
                            $output .= '<td class="center">
                                    <a class="btn btn-primary btn-sm checkUpdate" href="complaint_types_add.php?id='.$row['id'].'">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>';
                                     $output .= '<a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL('.$row['id'].');">
                                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                    </a>
                                </td>

                            </tr>';

                              }

                         $output .= '</tbody>';

                    $output .='</table>';
                    echo "success"."|".$output;
                   }else{
                    echo "error";
                   }
            }
    }


}










?>