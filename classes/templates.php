<?php

class Templates
{

    private $mysqli_lib;
    //private $templates;

    function __construct()
    {

        global $obj_mysql;
        //global $dir_templates;
        $this->mysqli_lib = $obj_mysql;
        //$this->templates = $dir_templates;
    }

    function AddTemplates($template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail){

        //return $this->templates;
        //global $dir_templates;
        //$template_name = strtolower(str_replace(" ","_",$template_name));
        //file_put_contents($dir_templates.$template_name.".html", $template_detail);

        $template_detail = addslashes($template_detail);

        $query_template = "INSERT INTO tbl_templates (template_type, template_name, template_desc , template_subject, is_active , template_detail, create_date )
                           VALUES ('$template_type','$template_name','$template_desc','$template_subject','$is_active','".$template_detail."', NOW())";

         $result = $this->mysqli_lib->insert($query_template);

         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

    function GetTemplates(){

        $query_gettemplate = "SELECT * from tbl_templates";

         $result = $this->mysqli_lib->fetch_all($query_gettemplate);
        
         return $result;
    }

    public function GetTemplateById($id){

        $query_gettemplatebyid = "SELECT * from tbl_templates where id ='$id'";

         $result = $this->mysqli_lib->fetch_all($query_gettemplatebyid);
        
         return $result;
    }

    function UpdateTemplates($id,$template_type,$template_name,$template_desc,$template_subject,$is_active,$template_detail){

        $template_detail = addslashes($template_detail);

        $query_template_update = "UPDATE tbl_templates SET template_type = '$template_type', template_name = '$template_name' , template_desc = '$template_desc' ,
                                   template_subject = '$template_subject', is_active = '$is_active' , template_detail = '".$template_detail."' , update_date =  NOW()
                                   where id = '$id'";

         $result = $this->mysqli_lib->update($query_template_update);
         if(!$result){
            $response = 0;
         }else{
            $response = 1;
         }
         return $response;
    }

}