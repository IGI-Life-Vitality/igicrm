<?php
	include('/var/www/html/igicrm/includes/config.php');
	include('/var/www/html/igicrm/classes/user.php');

	$date = date('Y-m-d H:i:s');

	$objUser = new User();
	$InactiveUsres = $objUser->GetBlockedUsers();

	if(!empty($InactiveUsres))
	{
		foreach($InactiveUsres as $user)
		{
			$currentTime        = strtotime($date);
			$loginTime          = strtotime($user['last_login']);
			echo $diff          = round(($currentTime - $loginTime)/60);

			if($diff > 14 )
			{
				$activeUsre = $objUser->UpdateInactiveUser($user['id'], 1);
			}
		}
	}
?>
