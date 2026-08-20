<?php

class Message
{

    private $mysqli_lib;

    function __construct()
    {

        global $obj_mysql;

        $this->mysqli_lib = $obj_mysql;

    }

    function AddMessage($sender,$recipient,$subject,$msg){

        $query_message = "INSERT INTO tbl_messages (sender, recipient, subject , message, is_read , create_date )
                                  VALUES ('$sender','$recipient','$subject','$msg','0', NOW())";

         $result = $this->mysqli_lib->insert($query_message);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetMessages($id){

        $query_getmessages = "SELECT * from tbl_messages where sender = '$id'";

         $result = $this->mysqli_lib->fetch_all($query_getmessages);
        
         return $result;
    }

    function GetMessageById($id){

        $query_getmessagebyid = "SELECT * from tbl_messages where id ='$id'";

         $result = $this->mysqli_lib->fetch_all($query_getmessagebyid);
        
         return $result;
    }

    function UpdateMessage($msg_id,$sender,$recipient,$subject,$msg){

        $query_message_update = "UPDATE tbl_messages SET recipient = '$recipient' , subject = '$subject' , message = '$msg', update_date =  NOW()  where id = '$msg_id'";

         $result = $this->mysqli_lib->update($query_message_update);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }


}