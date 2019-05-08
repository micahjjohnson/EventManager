<?php

    session_start();

    session_destroy();

	$user_role = 5;
	$isLoggedIn = false;

    echo "<script language='javascript' type='text/javascript'> location.href='../home.php' </script>";

?>