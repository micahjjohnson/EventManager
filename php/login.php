<?php
require_once 'db_connect.php';
include_once 'master/header.php';

if (isset($_POST['login-user'])) 
{
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = stripslashes($username);
	$password = stripslashes($password);	

	$sql = "SELECT company_emp_id, first_name, last_name, pword FROM employees WHERE company_emp_id='$username'";

	$result = $mysqli->query($sql);

	if ($result->num_rows !== 0) 
	{
		$user = $result->fetch_assoc();
		$db_password = $user['pword'];
		$first_name = $user['first_name'];
		$last_name = $user['last_name'];
		//$chapter_ud = $user['chapter_id'];  // for when we add chapters

		if(password_verify($password, $db_password))  
		{
			$role = checkPermission($username);

			$_SESSION['login'] = true;
			$_SESSION['role'] = $role; // Initializing Session
			$_SESSION['logged_user'] = $username; // Initializing Session
			$_SESSION['first_name'] = $first_name; // Initializing Session		
			$_SESSION['last_name'] = $last_name; // Initializing Session		

			//$_SESSION['chap_id'] = $chapter_id; // for when we add chapters

			echo "<script language='javascript' type='text/javascript'> location.href='/employee/home.php' </script>";
			exit;
		}
		else // wrong password
		{
			print '<div id="snackbar">Username and/or password was incorrect!  Try again.</div>';
		}
	}
	else // wrong user name
	{
		print '<div id="snackbar">Username and/or password was incorrect!  Try again.</div>';
	}

	$mysqli->close();
} 
?>

<div class="card">
	<h5 class="card-header bg-primary text-white"><i class='fas fa-sign-in-alt'></i>&nbsp;&nbsp;Sign In</h5>
	<div class="card-body">

		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col col-lg-4">
					<form action='' method='POST'>
						<div class="form-group">
							<label for="exampleInputEmail1"><strong>Company Employee ID</strong></label>
							<input class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username" placeholder="Enter company ID">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1"><strong>Password</strong></label>
							<input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div>
						<div class="form-group">
							<input type="hidden" name="login-user">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'master/footer.php';?>