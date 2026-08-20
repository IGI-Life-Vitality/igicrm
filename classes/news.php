<?php

class News
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }


    function AddNews($sender,$recipient,$subject,$news,$file){

        $query_news = "INSERT INTO tbl_news (sender, recipient, subject , detail, file, is_read , create_date )
                                  VALUES ('$sender','$recipient','$subject','$news','$file','0', NOW())";

         $result = $this->mysqli_lib->insert($query_news);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetNews($id){

        $query_getnews = "SELECT * from tbl_news where sender = '$id'";

         $result = $this->mysqli_lib->fetch_all($query_getnews);
        
         return $result;
    }
    function GetNewsById($id){

        $query_getnewsbyid = "SELECT * from tbl_news where id ='$id'";

         $result = $this->mysqli_lib->fetch_all($query_getnewsbyid);
        
         return $result;
    }

    function UpdateNews($news_id,$sender,$recipient,$subject,$news,$file){

        if($file == "0"){

            $query_news_update = "UPDATE tbl_news SET recipient = '$recipient' , subject = '$subject' , detail = '$news', update_date =  NOW()  where id = '$news_id'";
        }else{
            $query_news_update = "UPDATE tbl_news SET recipient = '$recipient' , subject = '$subject' , detail = '$news',file = '$file' , update_date =  NOW()  where id = '$news_id'";
        }

         $result = $this->mysqli_lib->update($query_news_update);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetGroupById($id){

        $ids= explode(',',$id);
        $response ="";
        for($a=0;$a<count($ids);$a++){

             $query_getgroup = "SELECT primary_name from tbl_groups where id ='$ids[$a]'";

            $result = $this->mysqli_lib->fetch_all($query_getgroup);

            $response .= $result[0]['primary_name'].",";
        }
         $len = strlen($response);
         $response = substr($response,0,$len-1);
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