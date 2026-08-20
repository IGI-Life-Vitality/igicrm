<?php

require_once("../config.php");

// storing  request (ie, get/post) global array to a variable
$requestData = $_REQUEST;

//echo $requestData['start'];

$columns = array(
// datatable column index  => database column name
    0 =>'id',
    1 => 'product_code',
    2=> 'product_category_name',
    3=> 'fullname',
    4=> 'isactive',
    5=> 'Action'
);

// getting total number records without any search
$sql = "SELECT p.*, pc.fullname `product_category_name` ";
$sql.="FROM tbl_product p ";
$sql.="INNER JOIN tbl_product_category pc ON pc.id = p.product_category";

$counts = count($obj_mysql->fetch_all($sql));
$totalData = $counts;
$totalFiltered = $counts;  // when there is no search parameter then total number rows = total number filtered rows.die;

$sql = "SELECT p.*, pc.fullname `product_category_name` ";
$sql.="FROM tbl_product p ";
$sql.="INNER JOIN tbl_product_category pc ON pc.id = p.product_category WHERE 1=1";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( p.product_code LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR pc.fullname LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR p.fullname LIKE '".$requestData['search']['value']."%' )";
}

$totalFiltered = count($obj_mysql->fetch_all($sql));

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

$data = array();

$get_data = $obj_mysql->fetch_all($sql);

foreach($get_data as $row){

    $nestedData=array();
    $id = $row['id'];
    $action = "<a class='btn btn-info btn-sm checkUpdate' href='product_add.php?id=$id'>
                Edit <i class='glyphicon glyphicon-edit icon-white'></i>
               </a>
               <a class='btn btn-danger btn-sm checkDelete' href='#' onclick='javascript:return show_confirm($id);'>
                Delete <i class='glyphicon glyphicon-trash icon-white'></i>
               </a>";

    $isactive = $row["isactive"] == 1 ? "checked='checked'" : "";

    $isactive = "<input type='checkbox' $isactive disabled />";

    $nestedData[] = $row["id"];
    $nestedData[] = $row["product_code"];
    $nestedData[] = $row["product_category_name"];
    $nestedData[] = $row["fullname"];
    $nestedData[] = $isactive;
    $nestedData[] = $action;

    $data[] = $nestedData;
}


$json_data = array(
    "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval( $totalData ),  // total number of records
    "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data   // total data array
);

echo json_encode($json_data);  // send data as json format



?>