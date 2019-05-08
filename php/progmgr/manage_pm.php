<?php 
include '../master/header.php'; 
include_once __DIR__ . '/../db_connect.php';

if (!isAuthorized(PRMG))
{
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['new-program-manager'])) 
	{
		$company_emp_id = $_POST['new-program-manager'];
		
		$sql = "SELECT id FROM employees WHERE company_emp_id='$company_emp_id'";

		$result = $mysqli->query($sql);

		if ($result->num_rows === 0) 
		{
			print '<div id="snackbar">Employee not found</div>';
		} 
		else 
		{
			$sql = "INSERT INTO program_managers (company_emp_id) VALUES ('$company_emp_id')";
			$result = $mysqli->query($sql);

			print '<div id="snackbar">Program Manager created</div>';
		}
	} 
	if (isset($_POST['delete-program-manager'])) 
	{
		$delete_id = $_POST['delete-program-manager'];

		$sql = "DELETE FROM program_managers WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Program Manager deleted</div>';
	} 
?>		
<h5 class="card-header bg-primary text-white"><i class="fas fa-users"></i>&nbsp;&nbsp;Manage Program Managers</h5>
<div class="container">
	<div class="card-body">
		<div class="row">	
			<div class="col-md-7">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="">
							<div class="form-row">
								<div class="form-group col-md-9">
									<label for="inputId">Add Manager ID</label>
									<input type="text" name="new-program-manager" class="form-control" id="inputId" placeholder="Employee ID" value="<?= $id ?>" required>
								</div>
								<div class="form-group col-md-3">
									<label for="inputId">&nbsp;</label>
									<button type='submit' class="btn btn-primary form-control" name=''>Submit</button>
								</div>		
							</div>		
						</form>
					</div>
				</div>
			</div>

		<div class="col-md-5">
				<div class="card">
					<h6 class="card-header"><i class="fas fa-users"></i>&nbsp;&nbsp;Program Managers</h6>
					<div class="card-body">
						<table class="table table-striped table-sm table-responsive" style="display: table;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Employee Id</th>	
								<th></th>	
							</tr>
						</thead>
						<?php
						$sql = "SELECT * FROM program_managers";

						if (!$result = $mysqli->query($sql))
						{
							echo "Sorry, the website is experiencing problems.";
							exit;
						}

						if ($result->num_rows === 0) 
						{
							echo "<tr>
									<td colspan='3'>No results found.</td>
									</tr>";
							exit;
						} 
						else 
						{
							while ($programmanagers = $result->fetch_assoc()) 
							{
								$id = $programmanagers['id'];
								$employee_id = $programmanagers['company_emp_id'];


								echo "<tr id='$id'>
										<td>$id</td>
										<td>$employee_id</td>						
										<td>
											<form action='' method='POST'>
												<input type='hidden' name='delete-program-manager' value='$id'/>
												<button type='submit' data-toggle='tooltip' title='Delete' class='btn btn-danger' employeeid='submit-btn' onclick=\"javascript: return confirm('Are you sure you want to delete?');\" >
													<i class='fas fa-trash fa-xs'></i>
												</button>
											</form>
										</td>
									</tr>";
							}
						}
						$mysqli->close();
						?>
					</table>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?
} // authorized

include '../master/footer.php'; 
?>