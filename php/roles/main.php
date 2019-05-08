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

	if (isset($_POST['delete-role'])) {
		$delete_id = $_POST['delete-role'];

		$sql = "DELETE FROM user_roles WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Role deleted</div>';
	} 
	?>
	<div class="card">
		<h5 class="card-header bg-primary text-white"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Roles</h5>
		<div class="card-body">
			<a href="role-form.php?create-role" class = "btn btn-success"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Role</a>
			<table class="table table-sm table-striped table-responsive">

			<?php
				$sql = "SELECT * FROM user_roles";

				if (!$result = $mysqli->query($sql)) {
					echo "Sorry, the website is experiencing problems.";
					exit;
				}

				if ($result->num_rows === 0) {
					//echo "We could not find a match. Please try again.";
					exit;
				} 

				echo "<thead>
							<tr>
								<th>Company username</th>
								<th>Role</th>
								<th></th>
							</tr>
					</thead>";


				while ($role = $result->fetch_assoc()) {
					$id = $role['id'];
					$employee_id = $role['company_emp_id'];
					$role_id = $role['role_id'];

					echo '<tr id=' . $id . '>';
					echo '<td>' . $employee_id . '</td>';
					echo '<td>' . $role_id . '</td>';
					echo '<td>
							<form action="" method="POST">
								<input type="hidden" name="delete-role" value="' . $id . '"/>
								<button type="submit" class="btn btn-danger"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to delete?");\" >
									<i class="fas fa-trash"></i> Delete
								</button>
							</form>
						  </td>';
					echo '</tr>';
				}

				$mysqli->close();
			?>
			</table>
		</div>
	</div>
<?php
} // authorized

include '../master/footer.php';?>