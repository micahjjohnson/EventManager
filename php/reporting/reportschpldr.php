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

<p>ChapLrd/Reports</p>


<?php
} // authorized

include '../master/footer.php'; ?>