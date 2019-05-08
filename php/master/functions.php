<?php
/* BACK BUTTON */
//<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/><br/>

function convertTime($time)
{
	return date('h:i a', strtotime($time));
}

function convertDate($date)
{
	return date('m/d/Y', strtotime($date));
}


?>