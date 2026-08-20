<?php

    if (isset($_SESSION['user_id'])) {

    	 if ($_SESSION['user_type'] == 3 ){
    	 	  echo "haroon";
    	 	  header('Location: search.php');
    	 }else{
    	 	 header('Location: dashboard.php');
    	 } 
    }else{
        header('Location: login.php');
    }

?>
