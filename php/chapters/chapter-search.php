<?php 
ini_set('display_errors',1); error_reporting(E_ALL);

include_once '../master/header.php'; 
include_once '../master/session.php'; 

if (!isAuthorized(EMP))
{
	include_once '../unauthorized.php';
}
else // authorized
{
?>
	<p> Chapter Search (Employee Folder)</p>

<?php

} // authorized

include '../master/footer.php'; ?>