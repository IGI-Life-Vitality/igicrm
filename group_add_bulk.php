<?php
ob_start();
require_once("includes/config.php");

$obj_mysql->fetch_all("TRUNCATE TABLE tbl_groups_permissions;");
$data = $obj_mysql->fetch_all("SELECT *FROM tbl_groups WHERE isactive = 1;");
if (!empty($data)) {
    foreach ($data as $row) {
        $id = $row['id'];
        $query = "INSERT INTO tbl_groups_permissions (group_id,module_id,`create`,`update`,`delete`,`view`) SELECT $id,id,0,0,0,0 FROM tbl_modules";
        $obj_mysql->query_execute($query);
    }
}

?>
