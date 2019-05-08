<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php';
include_once '../master/session.php'; 

$requiredRole = 1;
if (! isAuthorized($requiredRole))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['new-user-role'])) 
	{
		$employee_id = $_POST['employee_id'];
		$role_id = $_POST['role'];

		$sql = "INSERT INTO user_roles (company_emp_id, role_id) VALUES ('$employee_id', '$role_id')";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Role created</div>';

		//$_POST = 'refresh-chapter';
	}
?>
	<a href="./main.php">Back to Roles</a>
	<div class="card">
		<h5 class="card-header"><?= $title ?> User Role</h5>
		<div class="card-body">
			<div>
				<form action="" method="post">
					<div class="form-row">		
						<div class="form-group col-md-3">
							<input type="text" class="form-control" name="employee_id" placeholder="Employee Company ID" required>
						</div>
					</div>
					<div class="form-check">
						<label class="form-check-label" for="admin"><input class="form-check-input" type="radio" name="role" id="admin" value="1" required>Administrator</label>
					</div>
					<div class="form-check">
						<label class="form-check-label" for="manager"><input class="form-check-input" type="radio" name="role" id="manager" value="2" required>Project Manager</label>
					</div>
					<div class="form-check">
						<label class="form-check-label" for="leader"><input class="form-check-input" type="radio" name="role" id="leader" value="3" required>Chapter Leader</label>
					</div>
					<div class="form-check">
						<label class="form-check-label" for="employee"><input class="form-check-input" type="radio" name="role" id="employee" value="4" required>Employee</label>
					</div>
					<div class="form-check">
						<label class="form-check-label" for="guest"><input class="form-check-input" type="radio" name="role" id="guest" value="5" required>Guest</label>
					</div>
					<div class="form-row">							
						<div class="form-group col-md-2">
							<input type="hidden" name="new-user-role" value="">
							<input class="btn btn-primary" type="submit" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
} // authorized

include '../master/footer.php'; ?>