<?php

class Docs
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }


    function AddDocs($subject,$detail,$url,$cat,$creator,$owner,$share,$share_user,$file,$exp_dt,$rm_dt,$reminder_msg,$isexternal,$isrenewal,$isreminder){

         $exp_dt = date("Y-m-d H:i:s", strtotime($exp_dt));
         $rm_dt = date("Y-m-d H:i:s", strtotime($rm_dt));

           $query_docs = "INSERT INTO tbl_docs (subject, detail, url , cat , creator, owner, share , share_user ,file , exp_dt , rm_dt ,reminder_msg , isexternal , isrenewal , isreminder , is_active , create_date) VALUES ('$subject','$detail','$url','$cat','$creator','$owner','$share','$share_user', '$file' , '$exp_dt' ,'$rm_dt' ,'reminder_msg' ,'$isexternal' , '$isrenewal' , '$isreminder' ,'1', NOW())";

         $result = $this->mysqli_lib->insert($query_docs);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetDocs($id){

        $query_getdoc = "SELECT * from tbl_docs where creator = '$id'";

        $result = $this->mysqli_lib->fetch_all($query_getdoc);
        
        return $result;
    }
    function GetDocById($id){

        $query_getnewsbyid = "SELECT * from tbl_docs where id ='$id'";

         $result = $this->mysqli_lib->fetch_all($query_getnewsbyid);
        
         return $result;
    }

    function UpdateDocs($docs_id,$subject,$detail,$url,$cat,$creator,$owner,$share,$share_user,$file,$exp_dt,$rm_dt,$reminder_msg,$isexternal,$isrenewal,$isreminder,$comments){

         $exp_dt = date("Y-m-d H:i:s", strtotime($exp_dt));
         $rm_dt = date("Y-m-d H:i:s", strtotime($rm_dt));

        if($file == "0"){

            $query_docs_update = "UPDATE tbl_docs SET subject = '$subject' , detail = '$detail' , url = '$url', owner = '$owner', share = '$share' , share_user = '$share_user', exp_dt = '$exp_dt', rm_dt = '$rm_dt', reminder_msg = '$reminder_msg' , isexternal = '$isexternal' ,isrenewal = '$isrenewal' , isreminder = '$isreminder' , comments = '$comments' ,update_date =  NOW()  where id = '$docs_id'";
        }else{
            $query_docs_update = "UPDATE tbl_docs SET subject = '$subject' , detail = '$detail' , url = '$url', owner = '$owner', share = '$share' , share_user = '$share_user', exp_dt = '$exp_dt', rm_dt = '$rm_dt', reminder_msg = '$reminder_msg' , isexternal = '$isexternal' ,isrenewal = '$isrenewal' , isreminder = '$isreminder' , file = '$file' , comments = '$comments' ,update_date =  NOW()  where id = '$docs_id'";
        }

         $result = $this->mysqli_lib->update($query_docs_update);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetCatById($id){

        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++){

             $query_getcategory = "SELECT cat_name from tbl_docs_category where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getcategory);

            $response .= $result[0]['cat_name'].",";
        }
         $len = strlen($response);
         $response = substr($response,0,$len-1);
         return $response;
    }
    
   function GetCats(){

        $query_getcat = "SELECT id,cat_name,is_active from tbl_docs_category";

         $result = $this->mysqli_lib->fetch_all($query_getcat);
        
         return $result;
    }

    function GetDocsCategory($id){

        $query_getcatbyid = "SELECT id,cat_name,is_active from tbl_docs_category where id = '$id'";

         $result = $this->mysqli_lib->fetch_all($query_getcatbyid);
        
         return $result;
    }

    function AddDocCategory($cat_name,$is_active){
        $query = "INSERT INTO tbl_docs_category (cat_name,is_active) VALUES ('$cat_name','$is_active')";
        $result = $this->mysqli_lib->insert($query);
        if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
        return $response;
    }
    function UpdateDocCategory($cat_name,$is_active,$id){
        $query  = "UPDATE tbl_docs_category SET cat_name = '$cat_name' , is_active = '$is_active' WHERE id = '$id'";
        $result = $this->mysqli_lib->update($query);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }
    
/*
    function UpdateGroupsPermission($permissions, $group_id){

        // Decode the JSON array
        $permissions = json_decode($permissions,TRUE);

        foreach($permissions as $data){

            $moduleid = $data['moduleid']; $create = $data['create']; $update = $data['update']; $delete = $data['delete']; $view = $data['view'];
            $query_permission = "UPDATE tbl_groups_permissions SET `create` = '$create', `update` = '$update', `delete` = '$delete', `view` = '$view'";
            $query_permission .= "WHERE group_id = '$group_id' AND module_id = '$moduleid'";
            $this->mysqli_lib->insert($query_permission);
        }
        return 1;
    }
*/
  
   

    /*function GetUsersByGroupId($id,$group_id)
    {
        if($id == 0)
            $query = "SELECT GROUP_CONCAT(user_id) user_id FROM tbl_users_group WHERE group_id NOT IN ($group_id)";
        else if($id == 1)
            $query = "SELECT GROUP_CONCAT(user_id) user_id FROM tbl_users_group WHERE group_id IN ($group_id)";

        return $this->mysqli_lib->fetch_all($query);
    }*/
}