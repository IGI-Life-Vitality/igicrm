<?php
require_once("../config.php");
include(CLASSES_PATH.DS.'product.php');

$objProduct = new Product();

if(isset($_POST)) {

    $action             = isset($_POST['action']) ? $_POST['action'] : '';
    $id                 = isset($_POST['id'])?$_POST['id']:0;
    $name               = isset($_POST['fullname'])?$_POST['fullname']:'';
    $is_active          = isset($_POST['isactive'])?$_POST['isactive']:'';
    $code               = isset($_POST['agency_code'])?$_POST['agency_code']:'';
    $region_id          = isset($_POST['region_id'])?$_POST['region_id']:'';
    $city_id            = isset($_POST['city'])?$_POST['city']:'';
    //$city_id            = isset($_POST['city'])?$_POST['city']:'';

    if (isset($_POST['action'])) {

        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action == "hospital_save"){
            echo $objProduct->AddHospital($name,$is_active);
        }elseif($action == "hospital_edit"){
            echo $objProduct->UpdateHospital($id,$name,$is_active);
        }elseif($action == 'product_save'){
             echo $objProduct->AddProduct($name,$is_active);
        }elseif($action == "product_edit"){
            echo $objProduct->UpdateProduct($id,$name,$is_active);
        }elseif($action == 'agency_save'){
             echo $objProduct->AddAgency($name,$code,$is_active);
        }elseif($action == "agency_edit"){
            echo $objProduct->UpdateAgency($id,$name,$code,$is_active);
        }elseif($action == 'business_line_save'){
             echo $objProduct->AddBusinesLine($name,$is_active);
        }elseif($action == "business_line_edit"){
            echo $objProduct->UpdateBusinesLine($id,$name,$is_active);
        }elseif($action == "get_agency_code"){
            $agency_detail =  $objProduct->GetAgency($code);
            echo $agency_name = $agency_detail[0]['code'];
        }elseif($action == 'save_city'){
             echo $objProduct->AddCity($region_id,$name,'1');
        }elseif($action == "edit_city"){
            echo $objProduct->UpdateCity($region_id,$id,$name,'1');
        }
        elseif($action == 'save_area'){
             echo $objProduct->AddCityArea($region_id,$city_id,$name,'1');
        }elseif($action == "edit_area"){
            echo $objProduct->UpdateCityArea($region_id,$city_id,$id,$name,'1');
        }elseif($action == 'select_city'){
                $data = $objProduct->GetCityBySubRegionId($id);
                $Option = "<option disabled selected='selected' disabled='disabled'>Select City</option>";
                foreach ($data as $row){
                    $Option .= "<option value ='".$row['id']."'>".$row["fullname"]."</option>";
                }
            echo $Option;
        }elseif($action == 'select_regional_manager'){
                echo $data = $objProduct->GetRegionalManagerByProId($id);
                $pr_id = isset($_POST['pr_id'])?$_POST['pr_id']: '';
                // $Option = "<option disabled selected='selected' disabled='disabled'>Select Regional Manager</option>";
                foreach ($data as $row){
                    $Option .= "<option value ='".$row['id']."'". ($user['id'] == $pr_id ? 'selected = selected': '').">".$row["first_name"]." " .$row["last_name"]."</option>";
                }
            echo $Option;
        } elseif($action == "delete_product"){
              $result = $objProduct->DeleteData($id,$login_id,'tbl_product');
            
            if($result == "success"){
                 $data = $objProduct->GetProduct();
                 $output = '';
                 $output .= '<table id="data-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>';

                foreach ($data as $row){ 
                $isactive ="";
                $isactive .= "(".$row['isactive'] ."== '1' ? checked = 'checked' : '') ";
                $output   .= '<tr>';
                $output   .= '<td>'.$row['id'].'</td>';
                $output   .= '<td>'.$row['fullname'].'</td>';
                $output   .= '<td><input type="checkbox"'.$isactive.'disabled="disabled"></td>';
                $output   .= '<td class="center"> 
                       <a class="btn btn-primary btn-sm checkUpdate" href="complaint_product_add.php?id='.$row['id'].'">
                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                    </a>';
                $output .= '<a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL('.$row['id'].');">
                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                    </a>
                </td>

            </tr>';

                  } 
         $output .= '</tbody>';
         $output .= '</table>';
              echo "success"."|".$output;
            }else{
                echo "error";
            }
            
        }elseif($action == "delete_hospital"){
             $result = $objProduct->DeleteData($id,$login_id,'tbl_hospitals');
             if($result == "success"){
                $data = $objProduct->GetHospital();
                $output = '';
                 $output = '<table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hospital</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>';

                        foreach ($data as $row){
                            $isactive ="";
                            $isactive .= "(".$row['isactive'] ."== '1' ? checked = 'checked' : '') ";
                        $output .= '<tr>';
                        $output .= '<td>'.$row['id'].'</td>';
                        $output .= '<td>'.$row['fullname'].'</td>';
                        $output .= '<td><input type="checkbox"'.$isactive.' disabled="disabled"></td>';
                        $output .= '<td class="center">
                                    <a class="btn btn-primary btn-sm checkUpdate" href="hospital_add.php?id='.$row['id'].'">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                         <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL('.$row['id'].');">
                                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                    </a>
                                </td>

                            </tr>';

                               }

                    $output .= '</tbody>';

                    $output .= '</table>';
                 echo "success"."|".$output;
             }else{
                echo "error";
             }
        }elseif($action == "delete_agency"){
              $result = $objProduct->DeleteData($id,$login_id,'tbl_agency');
              if($result == "success"){
                 $data = $objProduct->GetAgency();
                 $output ='';
                 $output .='<table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Agency</th>
                            <th>Code</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>';

                        foreach ($data as $row){
                            $isactive ="";
                            $isactive .= "(".$row['isactive'] ."== '1' ? checked = 'checked' : '') ";
                         $output .='<tr>';
                         $output .='<td>'.$row['id'].'</td>';
                         $output .='<td>'.$row['fullname'].'</td>';
                         $output .='<td>'.$row['code'].'</td>';
                         $output .='<td><input type="checkbox" ' .$isactive. ' disabled="disabled"></td>';
                         $output .='<td class="center">
                                    <a class="btn btn-primary btn-sm checkUpdate" href="agency_add.php?id='.$row['id'].'">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL('.$row['id'].');">
                                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                    </a>
                                </td>

                            </tr>';

                         } 

                      $output .='</tbody>';

                    $output .='</table>';
                echo "success"."|".$output;
              }else{
                echo "error";
              }
        }elseif($action == "delete_business_line"){
             $result = $objProduct->DeleteData($id,$login_id,'tbl_business_line');
             if($result == "success"){
                 $data = $objProduct->GetBusinessLine();
                 $output = '';
                 $output .= '<table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Line Of Business</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>';

                        foreach ($data as $row){
                            $isactive ="";
                            $isactive .= "(".$row['isactive'] ."== '1' ? checked = 'checked' : '') ";
                         $output .= '<tr>';
                         $output .= '<td>'.$row['id'].'</td>';
                         $output .= '<td>'.$row['fullname'].'</td>';
                         $output .= '<td><input type="checkbox" '.$isactive. 'disabled="disabled"></td>';
                         $output .= '<td class="center">
                                    <a class="btn btn-primary btn-sm checkUpdate" href="business_line_add.php?id='.$row['id'].'">
                                        Edit <i class="glyphicon glyphicon-edit icon-white"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm checkDelete" href="#" onclick="javascript:return DEL('.$row['id'].');">
                                        Delete <i class="glyphicon glyphicon-trash icon-white"></i>
                                    </a>
                                </td>

                            </tr>';

                        }

                        $output .= '</tbody>';

                       $output .= '</table>';
                echo "success"."|".$output;
             }else{
                echo "error";
             }
        }else if($action == "search"){

            $name             = isset($_POST['name']) ? $_POST['name'] : '';
            $CNIC             = isset($_POST['CNIC'])?$_POST['CNIC']:'';
            $policy           = isset($_POST['policy'])?$_POST['policy']:'';
            $mobile           = isset($_POST['mobile'])?$_POST['mobile']:'';
            $email            = isset($_POST['email'])?$_POST['email']:'';
            $nicop            = isset($_POST['nicop'])?$_POST['nicop']:'';


            $search_detail = "where 1=1 ";

            if($name != ""){
               $search_detail.= "AND  (Owner_Name = '$name' OR Insure_Name = '$name') ";
            }
            if($CNIC != ""){
               $search_detail.= "AND  CNIC = '$CNIC' ";
            }
            if($policy != ""){
               $search_detail.= "AND  Policy_Number  like '%$policy%' ";
            }
            if($mobile != ""){
               $search_detail.= "AND  Mobile_Number = '$mobile' ";
            }
            if($email != ""){
               $search_detail.= "AND  Email_Address = '$email' ";
            }
            if($nicop != ""){
               $search_detail.= "AND  CNIC = '$nicop' ";
            }

            $data = $objProduct->getsearchresult($search_detail);
            $output ="";
               $output .='<table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Owner Name</th>
                            <th>Insured Name</th>
                            <th>Mobile Phone</th>
                            <th>CNIC</th>
                            <th>Policy Number</th>
                            <th>Plan of Insurance</th>
                            <th>Detail</th>
                        </tr>

                        </thead>

                        <tbody>';
                     foreach ($data as $value) {
                        
                     $output  .='<tr>';
                     $output  .='<td>'.$value['Owner_Name'].'</td>';
                     $output  .='<td>'.$value['Insure_Name'].'</td>';
                     $output  .='<td>'.$value['Mobile_Number'].'</td>';
                     $output  .='<td>'.$value['CNIC'].'</td>';
                     $output  .='<td>'.$value['Policy_Number'].'</td>';
                     $output  .='<td>'.$value['Plan_Name'].'</td>';
                     $output  .='<td><a class="btn-sm btn-primary" href="customer_info.php?pno='.$value['Policy_Number'].'&detail=1">Detail</a></td>';
                        }
                     $output .='</tr>

                        </tbody>

                    </table>';
                    echo $output;
        }

    }

}

?>