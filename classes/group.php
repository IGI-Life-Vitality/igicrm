<?php
class Group
{
    private $mysqli_lib;

    function __construct()
    {
        global $obj_mysql;
        $this->mysqli_lib = $obj_mysql;
    }

    function GetGroups($id=0,$isall=1)
    {
        if($id==0)
        {
            if($isall == 1)
                $query = "SELECT *FROM tbl_groups";
            else
                $query = "SELECT *FROM tbl_groups WHERE isactive = '1'";
        }
        else
        {
            $query = "SELECT *FROM tbl_groups WHERE id = '$id'";
        }

        return $this->mysqli_lib->fetch_all($query);
    }

    function AddGroup($primary_name, $secondary_name, $email, $expiry_date, $is_active)
    {
        $datetime = date('Y-m-d g:i:s');

        $query = "INSERT INTO tbl_groups (primary_name, secondary_name, email, expiry_date, isactive, created_on, updated_on) VALUES ('$primary_name', '$secondary_name', '$email', '$expiry_date', '$is_active', '$datetime', '$datetime')";
        return $response = $this->mysqli_lib->insert($query);
    }

    function UpdateGroup($id, $primary_name, $secondary_name, $email, $expiry_date, $is_active)
    {
        $datetime = date('Y-m-d g:i:s');
        $query = "UPDATE tbl_groups SET primary_name = '$primary_name', secondary_name = '$secondary_name', email = '$email', expiry_date = '$expiry_date',
                  isactive = '$is_active', updated_on = '$datetime' WHERE id = '$id'";
        return $response = $this->mysqli_lib->insert($query);
    }

    function AddUsersToGroup($users,$group_id)
    {
        $query = "INSERT INTO tbl_users_group (user_id, group_id) VALUES";

        foreach($users as $user)
        {
            $query .= "('$user', '$group_id'),";
        }

        $query = rtrim($query,',');
        return $result = $this->mysqli_lib->insert($query);
    }

    function UpdateUsersToGroup($users,$group_id)
    {
        $query = "DELETE FROM tbl_users_group WHERE group_id = '$group_id';";
        $this->mysqli_lib->delete($query);

        $query = "INSERT INTO tbl_users_group (user_id, group_id) VALUES";
        foreach($users as $user)
        {
            $query .= "('$user', '$group_id'),";
        }
        $query = rtrim($query,',');
        return $result = $this->mysqli_lib->insert($query);
    }

    function InheritGroupsPermission($groups,$new_group_id)
    {
        $groups = implode($groups,',');

        $query_module = "SELECT *FROM tbl_modules WHERE isactive = 1";
        $data_modules = $this->mysqli_lib->fetch_all($query_module);

        foreach($data_modules as $row_module)
        {
            $create = 0; $update = 0; $delete = 0; $view = 0;

            $query = "SELECT *FROM tbl_groups_permissions WHERE group_id IN ($groups) AND module_id = '".$row_module['id']."'";
            $data = $this->mysqli_lib->fetch_all($query);

            foreach($data as $row)
            {
                if($create == 0){
                    $create = $row['create'] == 1 ? 1 : 0;
                }

                if($update == 0){
                    $update = $row['update'] == 1 ? 1 : 0;
                }

                if($delete == 0){
                    $delete = $row['delete'] == 1 ? 1 : 0;
                }

                if($view == 0){
                    $view = $row['view'] == 1 ? 1 : 0;
                }
            }

            $query_permission = "INSERT INTO tbl_groups_permissions (group_id, module_id, `create`, `update`, `delete`, `view`) VALUES";
            $query_permission .= "('$new_group_id', '".$row_module['id']."', '".$create."', '".$update."', '".$delete."', '".$view."'),";
            $query_permission = rtrim($query_permission,',');
            $this->mysqli_lib->insert($query_permission);
        }
    }

    function UpdateInheritGroupsPermission($groups,$group_id)
    {
        $groups = implode($groups,',');

        $query_module = "SELECT *FROM tbl_modules WHERE isactive = 1";
        $data_modules = $this->mysqli_lib->fetch_all($query_module);

        foreach($data_modules as $row_module)
        {
            $create = 0; $update = 0; $delete = 0; $view = 0;

            $query = "SELECT *FROM tbl_groups_permissions WHERE group_id IN ($groups) AND module_id = '".$row_module['id']."'";
            $data = $this->mysqli_lib->fetch_all($query);

            foreach($data as $row)
            {
                if($create == 0){
                    $create = $row['create'] == 1 ? 1 : 0;
                }

                if($update == 0){
                    $update = $row['update'] == 1 ? 1 : 0;
                }

                if($delete == 0){
                    $delete = $row['delete'] == 1 ? 1 : 0;
                }

                if($view == 0){
                    $view = $row['view'] == 1 ? 1 : 0;
                }

                $moduleid = $row_module['id'];
                $query_permission = "UPDATE tbl_groups_permissions SET `create` = '$create', `update` = '$update', `delete` = '$delete', `view` = '$view'";
                $query_permission .= "WHERE group_id = '$group_id' AND module_id = '$moduleid'";
                $this->mysqli_lib->insert($query_permission);
            }
        }
    }

    function SaveGroupsPermission($permissions, $new_group_id)
    {
        // Decode the JSON array
        $permissions = json_decode($permissions,TRUE);
        $query_permission = "INSERT INTO tbl_groups_permissions (group_id, module_id, `create`, `update`, `delete`, `view`) VALUES";

        foreach($permissions as $data)
        {
            if($data['moduleid'] != "")
            {
               $query_permission .= "('$new_group_id', '".$data['moduleid']."', '".$data['create']."', '".$data['update']."', '".$data['delete']."', '".$data['view']."'),";
            }
        }

        $query_permission = rtrim($query_permission,',');
        return $result = $this->mysqli_lib->insert($query_permission);
    }

    function UpdateGroupsPermission($permissions, $group_id)
    {
        $sql = "SELECT group_id FROM tbl_groups_permissions WHERE group_id = '$group_id'";
        $result = $this->mysqli_lib->fetch_all($sql);

        if(!empty($result))
        {
            // Decode the JSON array
            $permissions = json_decode($permissions,TRUE);

            foreach($permissions as $data)
            {
                $moduleid = $data['moduleid']; $create = $data['create']; $update = $data['update']; $delete = $data['delete']; $view = $data['view'];
                $query_permission = "UPDATE tbl_groups_permissions SET `create` = '$create', `update` = '$update', `delete` = '$delete', `view` = '$view'";
                $query_permission .= "WHERE group_id = '$group_id' AND module_id = '$moduleid'";
                $this->mysqli_lib->insert($query_permission);
            }
        }
        else
        {
            $this->SaveGroupsPermission($permissions,$group_id);
        }
        return 1;
    }

    function GetModules($group_id,$par_id)
    {
        if($group_id > 0)
        {
            $query = "SELECT tbl_modules.id, tbl_modules.name,
                  IFNULL((SELECT tbl_groups_permissions.`create` FROM tbl_groups_permissions
                  WHERE tbl_groups_permissions.group_id = $group_id AND tbl_groups_permissions.module_id = tbl_modules.id),0) AS `create`,
                  IFNULL((SELECT tbl_groups_permissions.`update` FROM tbl_groups_permissions
                  WHERE tbl_groups_permissions.group_id = $group_id AND tbl_groups_permissions.module_id = tbl_modules.id),0) AS `update`,
                  IFNULL((SELECT tbl_groups_permissions.`delete` FROM tbl_groups_permissions
                  WHERE tbl_groups_permissions.group_id = $group_id AND tbl_groups_permissions.module_id = tbl_modules.id),0) AS `delete`,
                  IFNULL((SELECT tbl_groups_permissions.`view` FROM tbl_groups_permissions
                  WHERE tbl_groups_permissions.group_id = $group_id AND tbl_groups_permissions.module_id = tbl_modules.id),0) AS `view`
                  FROM tbl_modules
                  LEFT JOIN tbl_groups_permissions ON tbl_groups_permissions.module_id = tbl_modules.id
                  WHERE tbl_modules.isactive = '1' AND tbl_modules.parent_id = '$par_id' AND tbl_groups_permissions.group_id = '$group_id'";
        }
        else
        {
            $query = "SELECT tbl_modules.id, tbl_modules.name FROM tbl_modules WHERE parent_id = '$par_id' and isactive = 1";
        }
        return $this->mysqli_lib->fetch_all($query);
    }

    function GetUsersByGroupId($group_id)
    {
        $query = "SELECT GROUP_CONCAT(user_id) user_id FROM tbl_users_group WHERE group_id = '$group_id'";
        $data = $this->mysqli_lib->fetch_all($query);
        $user_id = $data[0]['user_id'] > 0 ? $data[0]['user_id'] : 0;
        return $user_id;
    }

    function GetGroupById($id)
    {
        $ids= explode(',',$id);
        $response ="";

        for($a=0;$a<count($ids);$a++)
        {
            $query_getgroup = "SELECT primary_name from tbl_groups where id ='$ids[$a]'";
            $result = $this->mysqli_lib->fetch_all($query_getgroup);
            $response .= $result[0]['primary_name'].",";
        }

        $len = strlen($response);
        $response = substr($response,0,$len-1);
        return $response;
    }

    function GetParentModules()
    {
        $query = "SELECT tbl_modules.id, tbl_modules.name FROM tbl_modules WHERE isactive = 1 and parent_id = '0' ";
        return $this->mysqli_lib->fetch_all($query);
    }
}