<?php

    session_start();
    $_SESSION['is_login'] = 0;
    session_unset();

    // This will destroy the session variables
    session_destroy();
    header( "Location: http://".$_SERVER['HTTP_HOST']."/igicrm/",false ) ;

?>