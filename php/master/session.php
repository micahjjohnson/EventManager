<?php
//ini_set('display_errors',1); error_reporting(E_ALL);
session_start();
define("PRMG", "Program Manager");
define("CHL", "Chapter Leader");
define("EMP", "Employee");
define("GUEST", "Guest");


if(!isset($_SESSION['logged_user']) || $_SESSION['logged_user'] == '')
{
	$user_role = GUEST;
	$isLoggedIn = FALSE;
}	

if (isset( $_SESSION['login'] ) ) // user is logged in
{	
	$username = $_SESSION['logged_user'];
	$user_name = $_SESSION['first_name'];
	$user_last_name = $_SESSION['last_name'];
	$user_role = $_SESSION['role'];
	$isLoggedIn = TRUE;
	// do user stuff
	
	//unset($_SESSION['login']);
}

function checkPermission($employee_id)
{
	global $mysqli;
	
	$id = $employee_id;
	
	// check in program manager table

	$pm_sql = "SELECT * FROM program_managers WHERE company_emp_id='$id'";
	$result = $mysqli->query($pm_sql);

	if ($result->num_rows == 0) // not program manager
	{
		$cl_sql = "SELECT * FROM chapter_leaders WHERE company_emp_id='$id'";
		$result2 = $mysqli->query($cl_sql);
		
		if ($result2->num_rows == 0) // not chapter leader
		{
			return EMP; // employee
		}
		else
		{
			return CHL; // chapter leader
		}
	}
	else
	{
		return PRMG; // program manager
	}
}

function isAuthorized($requiredRole)
{
	global $isLoggedIn, $user_role;
	
	if (! $isLoggedIn)
	{
		return FALSE;
	}
	
	if ($requiredRole == GUEST) // just checking for logged user
	{
		if ($isLoggedIn)
			return TRUE;
		else
			return FALSE;
	}
	else
	{
		if ($user_role == PRMG)
		{
			return TRUE; 
		}
		else if ($requiredRole == $user_role)
		{
			return TRUE;
		}
		else if ($requiredRole == EMP && $user_role == CHL)
		{
			return TRUE;
		}
	}
	
	return FALSE;
}
?>