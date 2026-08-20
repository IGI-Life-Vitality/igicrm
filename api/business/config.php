<?php

$live_run = 'false';

if(!isset($_SESSION)) 
{
    ob_start();
    session_start();
}

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ERROR | E_PARSE);

if( !ini_get('safe_mode') )
{
    ini_set("memory_limit","128M");
    set_time_limit(250);
    ini_set('max_execution_time', 3000);
}
/* Local DB */

//echo "$live_run";
if($live_run=='true')
{
    //echo "$live_run";
    if(isset($_GET)) {array_walk_recursive($_GET, function(&$val){$val = trim($val);});}
    if(isset($_POST)) {array_walk_recursive($_POST, function(&$val){$val = trim($val);});}
    if(isset($_REQUEST)) {array_walk_recursive($_REQUEST, function(&$val){$val = trim($val);});}
}

$current_session_id = session_id();
date_default_timezone_set("Asia/Karachi");

$api_dir  = "/api/";
$api_path = $_SERVER['DOCUMENT_ROOT'].$api_dir;

if($live_run=='true')
{
    $api_url  = "http://sns.m3techservice.com/".$api_dir;
}
else
{
    $api_url  = "http://localhost/".$api_dir;
}

$key_value = "123";

define ("API_PATH", $api_path);
define ("API_URL", $api_url);
define ("IMG_URL", $api_url."images/");
define ("VDO_URL", $vod_url."videos/");
define ("AUD_URL", $vod_url."audios/");

define ("KEY", $key_value);

include_once($api_path."business/db.php" );
include_once($api_path."business/api_lib.php" );

?>