<?php 
include_once '../master/header.php'; 
include_once '../master/session.php'; 

if (!isAuthorized(EMP))
{
	include_once '../unauthorized.php';
}
else // authorized
{
?>


<p> Volunteer/ Non-BRG Group Event</p>



<?php 
}

include '../master/footer.php'; ?>