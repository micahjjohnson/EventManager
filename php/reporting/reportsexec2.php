<?php 
include_once '../master/header.php'; 
include_once '../master/session.php'; 

if (!isAuthorized(PRMG))
{
	include_once '../unauthorized.php';
}
else // authorized
{

?>

<p> ProgMgr/Reports</p>



<?php
}

include '../master/footer.php'; ?>