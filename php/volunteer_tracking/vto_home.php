<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php';

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['delete-vto-submission']))
	{
		$delete_id = $_POST['delete-vto-submission'];

		$sql = "DELETE FROM volunteer_submissions WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Volunteer submission successfully deleted</div>';
	}
	if (isset($_POST['submit-vto']))
	{
		$hours = $_POST['hours'];
		$date = $_POST['date'];
		$hours = $_POST['hours'];
		$name = $_POST['name'];
		$supervisor = $_POST['supervisor'];
		$phone = $_POST['phone'];
		$description = $_POST['description'];

		$sql = 'INSERT INTO volunteer_submissions (company_emp_id, date, hours, name, supervisor, phone, description) VALUES ( "'.$username.'", "'.$date.'", "'.$hours.'", "'.$name.'", "'.$supervisor.'", "'.$phone.'", "'.$description.'" ); ';
		
		$result = $mysqli->query($sql);

		if ($result)  
		{
			print '<div id="snackbar">Volunteer hours are submitted and waiting for manager approval.</div>';
		}
	}
?>
<div class="col-md-12">
	<div class="card">
	<h5 class="card-header bg-primary text-white"><i class="far fa-clock"></i>&nbsp;&nbsp;My 2019 Volunteer Summary</h5>
		  <div class="card-body" style="max-height: 250px;">
				<div class="tight-verticalScroll">
					<table class="table table-sm table-striped table-hover">
						<?php
						$sql = "SELECT * FROM volunteer_submissions WHERE company_emp_id='$username' AND YEAR(date) = 2019 ";
						$result = $mysqli->query($sql);

						if ($result->num_rows == 0) 
						{
							echo "No submissions found.";
						}
						else
						{
							echo '<thead>
									<tr>
										<th scope="col">Date</th>
										<th scope="col">Volunteer Organization</th>
										<th scope="col">Supervisor Name</th>
										<th scope="col">Hours</th>
										<th scope="col">Status</th>
										<th scope="col">Manager</th>
										<th scope="col"></th>
									</tr>
								</thead>';

							while ($submission = $result->fetch_assoc())
							{
								$id = $submission['id'];
								$hours = $submission['hours'];
								$name = $submission['name'];
								$supervisor = $submission['supervisor'];
								$status = $submission['status'];
								$approved_by = $submission['approved_by'];			

								$converted_date = date('m/d/Y', strtotime($submission['date']));

								echo "<tr>";
								echo "<td>". $converted_date . "</td>";
								echo "<td>". $name . "</td>";
								echo "<td>". $supervisor . "</td>";
								echo "<td>". $hours . "</td>";
								echo "<td>". $status . "</td>";

								if ($status == 'submitted')
								{
									echo "<td> n/a </td>";
									echo "<td>";
									echo "<form action='' method='POST'>
											<input type='hidden' name='delete-vto-submission' value='$id'/>
											<button type='submit' class='btn btn-danger' employeeid='submit-btn' onclick=\"javascript: return confirm('Are you sure you want to delete? Your hours will not be counted and you would need to resubmit.');\" >
												<i class='fas fa-trash'></i>
											</button>
										</form>";
								}
								else
								{
									echo "<td>". $approved_by . "</td>";
									echo "<td>";	
								}
								echo "</td>";
								echo "</tr>";
							}
						}	
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<br/>
	<div class="col-md-12">
		<div class="card">
			<h5 class="card-header bg-primary text-white">Volunteer Time-Off Details</h5>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<form action='' method="post">
							<div class="form-row">
								<div class="form-group col-md-2">
									<label for="hours">Hours</label><span class="required">&nbsp;*</span>
									<input type="text" class="form-control" name="hours" id="hours" required>
								</div>
								<div class="form-group col-md-4">
									<label for="date">Date</label><span class="required">&nbsp;*</span>
									<input type="date" class="form-control" name="date" id="date" required>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label for="name">Volunteer Organization</label><span class="required">&nbsp;*</span>
									<input type="text" class="form-control" name="name" id="name" required>
								</div>
								<div class="form-group col-md-4">
									<label for="supervisor">Supervisor Name</label><span class="required">&nbsp;*</span>
									<input type="text" class="form-control" name="supervisor" id="supervisor" required>
								</div>
								<div class="form-group col-md-4">
									<label for="phone">Phone Number</label><span class="required">&nbsp;*</span>
									<input type="text" class="form-control" name="phone" id="phone" maxlength="10" required>
								</div>
							</div>
							<div class="form-group">
								<label for="description">Details</label><span class="required">&nbsp;*</span>
								<textarea class="form-control" name="description" id="details" rows="3" placeholder="max 150 characters" required maxlength="150"></textarea>            
							</div>
							<div class="float-right col-sm-22">
								<input type="hidden" name="submit-vto" >
								<button type='submit' class='btn btn-primary' title='Save'>
									Submit
								</button>
							</div>
							</form>
						</div>
				  </div>
			</div>
		</div>
	</div>


<?php 
	}

	include '../master/footer.php'; 

?>