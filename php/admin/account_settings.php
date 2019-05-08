<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 

	if (isset($_POST['change-password'])) 
	{
		$email = $_POST['email'];
		$current_password = $_POST['curr-password'];
		$new_password = $_POST['new-password'];
		$new_password_confirm = $_POST['new-password-confirm'];
		
		$email = stripslashes($email);
		$current_password = stripslashes($current_password);	
		$new_password = stripslashes($new_password);	
		$new_password_confirm = stripslashes($new_password_confirm);	
			
		$sql = "SELECT company_emp_id, pword, email FROM employees WHERE company_emp_id='$username'";
			
		$result = $mysqli->query($sql);
		
		if ($result->num_rows !== 0) 
		{
			$user = $result->fetch_assoc();
			$db_password = $user['pword'];
			$first_name = $user['first_name'];
			$last_name = $user['last_name'];
					
			if(password_verify($current_password, $db_password))  
			{
				if ($new_password === $new_password_confirm)
				{
					$hash_password = password_hash($new_password, PASSWORD_DEFAULT);
					
					$sql = 'UPDATE employees SET pword="'.$hash_password.'" WHERE company_emp_id="'.$username.'"';
					$result = $mysqli->query($sql);

					echo "<script language='javascript' type='text/javascript'> location.href='../employee/home.php' </script>";
				}
				else
				{
					print '<div id="snackbar">New passwords do not match!</div>';					
				}
			}
			else // wrong password
			{
				print '<div id="snackbar">password was incorrect!  Try again.</div>';
			}
		}
		else // wrong email
		{
			print '<div id="snackbar">Email was incorrect. Try again.</div>';
		}

		$mysqli->close();
	} 
?>

<div class="container">

<h5 class="card-header bg-primary text-white"><i class='fas fa-sign-in-alt'></i>&nbsp;&nbsp;Change Password</h5>
<div class="card-body">
		<div class="row justify-content-md-center">
			<div class="col col-md-4">
				<form action='' method='POST'>
					<div class="form-group">
						<label for="email"><strong>Company E-mail Address</strong></label><span class="required">&nbsp;*</span>
						<input class="form-control" id="email" aria-describedby="emailHelp" type="email" name="email" placeholder="Enter company ID" required>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1"><strong>Current Password</strong></label><span class="required">&nbsp;*</span>
						<input type="password"  name="curr-password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1"><strong>New Password</strong></label><span class="required">&nbsp;*</span>
						<input id='new-password' type="password"  name="new-password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1"><strong>Re-enter New Password</strong></label><span class="required">&nbsp;*</span>
						<input id='new-password-confirm' type="password"  name="new-password-confirm" class="form-control"  placeholder="Password" onKeyUp="checkSimilarity()" required>
						<div id='password-help' style="font-size:10px; color: red;"></div>
					</div>
					<div class="form-group">
						<input type="hidden" name="change-password">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include '../master/footer.php';?>
<script>
function checkSimilarity()
{
	var fistInput = document.getElementById("new-password").value;
	var secondInput = document.getElementById("new-password-confirm").value;

	if (fistInput !== secondInput) 
	{
		document.getElementById("password-help").innerHTML = 'Passwords do not match.';
	}
	else
	{
		document.getElementById("password-help").innerHTML = '';
	}

}
</script>