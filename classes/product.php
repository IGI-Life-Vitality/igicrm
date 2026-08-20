<?php
class Product
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function AddProduct($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_product (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateProduct($id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_product SET fullname = '$fullname', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        //return $response > 0 ? "success" : "fail";
        return "success";
    }

    function AddProductCategory($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_product_category (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateProductCategory($fullname,$is_active,$id)
    {
        $query = "UPDATE `tbl_product_category` SET fullname = '$fullname' , isactive = '$is_active' WHERE id = '$id'";
        $this->mysqli_lib->update($query);
        return "success";
    }

    function GetProduct($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_product` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_product`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_product` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetProductsAll()
    {
        $query = "SELECT p.*, pc.fullname `product_category_name` FROM tbl_product p INNER JOIN tbl_product_category pc ON pc.id = p.product_category";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetProductsActive($id)
    {
        if($id == 0)
            $query = "SELECT * FROM tbl_product WHERE isactive = 1;";
        else
            $query = "SELECT * FROM tbl_product WHERE id = '$id'";

        return $this->mysqli_lib->fetch_all($query);
    }

    function GetProductByProductCategoryID($id)
    {
        $query = "SELECT * FROM `tbl_product` WHERE product_category = '$id'";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetHospital($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_hospitals` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_hospitals`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_hospitals` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);

    }

    function AddHospital($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_hospitals (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateHospital($id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_hospitals SET fullname = '$fullname', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }

    function GetAgency($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_agency` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_agency`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_agency` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function AddAgency($fullname,$code,$is_active)
    {
        $query = "INSERT INTO tbl_agency (fullname,code,isactive) VALUES ('$fullname','$code','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateAgency($id,$fullname,$code,$isactive)
    {
        $query = "UPDATE tbl_agency SET fullname = '$fullname', isactive = '$isactive' , code = '$code' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }

    function GetBusinessLine($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_business_line` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_business_line`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_business_line` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function AddBusinesLine($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_business_line (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateBusinesLine($id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_business_line SET fullname = '$fullname', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }

    function GetSource($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_source` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_source`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_source` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function AddSource($fullname,$is_active)
    {
        $query = "INSERT INTO tbl_source (fullname,isactive) VALUES ('$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateSource($id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_source SET fullname = '$fullname', isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }

    function GetCity($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_region_city` WHERE isactive = '$isactive' AND  region_id != '0'";
            else
                $query = "SELECT * FROM `tbl_region_city` WHERE region_id != '0' ORDER By fullname ASC";
        }
        else
        {
            $query = "SELECT * FROM `tbl_region_city` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function AddCity($region_id,$fullname,$is_active)
    {
          $query = "INSERT INTO tbl_region_city (region_id,fullname,isactive) VALUES ('$region_id','$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateCity($region_id,$id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_region_city SET fullname = '$fullname', region_id = '$region_id' , isactive = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }
    function DeleteData($id,$login_id,$table)
    {
        $cmp_prd_query = "SELECT * FROM vw_get_complaint WHERE product_id = '$id'";
        $pro_count = $this->mysqli_lib->count_results($cmp_prd_query);
        $l_prd_query = "SELECT * FROM tbl_leads WHERE product = '$id'";
        $pro_count_l = $this->mysqli_lib->count_results($l_prd_query);
        if($pro_count == 0 && $pro_count_l ==0 ){
            $query = "DELETE FROM $table WHERE id = '$id';";
            $res = $this->mysqli_lib->delete($query);
         return "success";
        }else{
            return "fail";
        }
        
    }

    function getsearchresult($search_detail)
    {
        $query = "SELECT * FROM tbl_policy_master_data $search_detail";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetRegion()
    {
        $query = "SELECT * FROM tbl_region";
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetRegionName($id){
        $query = "SELECT * FROM tbl_region where id ='$id'";
        $res = $this->mysqli_lib->query_execute($query);
        return $res['fullname'];
    }

    function GetCityArea($id = 0, $isactive = 0)
    {
        if($id == 0) 
        {
            if($isactive != 0)
                $query = "SELECT * FROM `tbl_city_areas` WHERE isactive = '$isactive'";
            else
                $query = "SELECT * FROM `tbl_city_areas`";
        }
        else
        {
            $query = "SELECT * FROM `tbl_city_areas` WHERE id = '$id'";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetCityName($id){
        $query = "SELECT * FROM tbl_region_city where id ='$id'";
        $res = $this->mysqli_lib->query_execute($query);
        return $res['fullname'];
    }
    
    function AddCityArea($region_id,$city_id,$fullname,$is_active)
    {
          $query = "INSERT INTO tbl_city_areas (region_id,city_id,area,is_active) VALUES ('$region_id','$city_id','$fullname','$is_active')";
        $response = $this->mysqli_lib->insert($query);
        return $response > 0 ? "success" : "fail";
    }

    function UpdateCityArea($region_id,$city_id,$id,$fullname,$isactive)
    {
        $query = "UPDATE tbl_city_areas SET area = '$fullname', region_id = '$region_id' , city_id = '$city_id' ,is_active = '$isactive' WHERE id = '$id'";
        $response = $this->mysqli_lib->update($query);
        return "success";
    }

    function GetCityBySubRegionId($id){

        $query = "SELECT * FROM `tbl_region_city` WHERE region_id = '$id'";
        return $this->mysqli_lib->fetch_all($query);


    }
    function GetArea($id){
        $query = "SELECT * FROM tbl_city_areas where id ='$id'";
        return  $this->mysqli_lib->fetch_all($query);
    }

    function GetRegionalManagerByProId($id){
        $query = "SELECT * FROM tbl_users WHERE  FIND_IN_SET($id, product_id) and user_type = '4'";
        return  $this->mysqli_lib->fetch_all($query);
    }



}