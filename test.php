<?php
require_once("includes/config.php");



$query = "SELECT group_id FROM  tbl_eform_type WHERE product_category_id = '4' AND product_id = '10' AND id = '4' AND operation_mode = '1'";

$data = $obj_mysql->fetch_all($query);
if(!empty($data)){
    $group_id = $data[0]['group_id'];
    $group_id;
    $query = "SELECT GROUP_CONCAT(user_id) AS user_id FROM tbl_users_group WHERE group_id = '1'";
    $users_id = $obj_mysql->fetch_all($query);
    $users_id = $users_id[0]['user_id'];
    if($users_id != ''){
        $query = "UPDATE tbl_eform_add SET group_id = '1', user_id = '4', status_id = '2', forward_datetime = NOW() WHERE id = '2'";
        $obj_mysql->update($query);
        echo 'success';
    }
}else
echo 'fail';


?>