<?php
if (!isset($_SESSION)) {
  ob_start();
  session_start();
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(0);

// error_reporting(E_ALL);
// ini_set('display_errors', -1);

if (!ini_get('safe_mode')) {
  ini_set("memory_limit", "256M");
  set_time_limit(250);
  ini_set('max_execution_time', 2500);
}

$current_session_id = session_id();

date_default_timezone_set("Asia/Karachi");
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', 'D:\laragon\www' . DS . 'igicrm');
// defined('SITE_ROOT') ? null : define('SITE_ROOT', '/var/www/html'.DS.'igicrm');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . DS . 'includes');
defined('MAILER_PATH') ? null : define('MAILER_PATH', SITE_ROOT . DS . 'third_party');
defined('CLASSES_PATH') ? null : define('CLASSES_PATH', SITE_ROOT . DS . 'classes');
define("SITE_TITLE", "IGI Life");
define("FEEDBACK_URL", "https://complainants-feedback.igilife.com.pk/feedback?");

// defined('SITE_IP') ? null : define('SITE_IP', 'http://10.40.64.15' . DS . 'igicrm');
//defined('SITE_IP') ? null : define('SITE_IP', 'https://sns.m3tech.com.pk'.DS.'igicrm');
//defined('SITE_IP') ? null : define('SITE_IP', 'http://localhost/igicrm');
defined('SITE_IP') ? null : define('SITE_IP', 'http://igicrm.test:8080');

//echo SITE_IP; die;
/*for testing */
//$email_host = "202.61.45.13";
//$email_username = "risk.department@i-trade.com.pk";
//$email_password = "abc123*+";
//$port = '25';
//$cname = "IGI Life - services";
/*End Testing*/

//$email_host = "smtp.gmail.com";
//$email_username = "kamranajabbar@gmail.com";
//$email_password = "";

/* Email Credential - Start*/
$email_host = "10.9.0.4";
$email_username = "services.life@igi.com.pk";
$email_password = "Customer@123";
$port = '26';
$cname = "IGI Life - services";
/* Email Credential - End*/
/*
$email_host = "smtp.gmail.com";
$email_username = "gtalk.ivr@gmail.com";
$email_password = "admin786!";
$port = 587;
$cname = "IGI LIFE";
*/

/* Database connection - Start*/
include(LIB_PATH . DS . 'db_info.php');
include(LIB_PATH . DS . 'mysqli_lib.php');
include(LIB_PATH . DS . 'functions.php');
$obj_mysql = new Mysqli_Lib($db_server, $db_user, $db_pass, $db_name);
/* Database connection - End*/

//$ip = $_SERVER['REMOTE_ADDR'];
//$page_name = basename($_SERVER['PHP_SELF']);
//$referer = @$_SERVER['HTTP_REFERER'];
