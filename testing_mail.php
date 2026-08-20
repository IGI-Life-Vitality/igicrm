<?php
ini_set('display_errors', 1);

ini_set('SMTP','email.igi.com.pk');
ini_set('smtp_port',25);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_error_handler("var_dump");

echo mail("haroon.ssuet@gmail.com","My subject","hello h r u");

echo mail("haroon.saeed@m3tech.com.pk","My subject","hello h r u");


?>

