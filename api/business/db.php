<?php

	/* Local DB */
	$host	= '';
	$un 	= '';
	$pass = '';
	$db 	= '';

	/* Local DB */
	if($live_run == 'false')
	{
		$host	= 'localhost';
		$un 	= 'root';
		$pass = '';
		$db 	= 'db_igicrm_live';
	}
	else
	{
	  $host	= 'localhost';
	  $un 	= 'root';
	  $pass = '';
	  $db 	= 'db_igicrm_live';
	}

?>