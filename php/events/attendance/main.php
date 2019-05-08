<?php
//TODO need to make this page and csv upload page both upload to correct table

require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
include '../../master/header.php';
include_once '../../master/session.php'; 

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	$event_id = $_GET['event'];

	if (isset($_POST['delete-attendant'])) 
	{
		$delete_id = $_POST['delete-attendant'];

		$sql = "DELETE FROM event_attendance WHERE id='$delete_id'";
		$result = $mysqli->query($sql);
		
		print '<div id="snackbar">Attendant deleted</div>';
	} 
	else if (isset($_POST['save-attendant'])) 
	{
		$event_id = $_POST['save-attendant'];
		$company_emp_id = $_POST['company_emp_id'];
		
		$sql = "SELECT * FROM employees WHERE company_emp_id='$company_emp_id'";

		$result = $mysqli->query($sql);

		//echo $mysqli->error ;
		if ($result->num_rows === 0) 
		{
		print '<div id="snackbar">Employee not found.</div>';
		} 
		else 
		{
			$employee = $result->fetch_assoc();
			$first_name = $employee['first_name'];
			$last_name = $employee['last_name'];
			$name = $first_name . ' ' . $last_name;

			$sql2 = 'INSERT INTO event_attendance (company_emp_id, event_id) SELECT * FROM (SELECT "'.$company_emp_id.'",  "'.$event_id.'") AS tmp WHERE NOT EXISTS ( SELECT company_emp_id FROM event_attendance WHERE company_emp_id = "'.$company_emp_id.'" AND event_id = "'.$event_id.'" ) LIMIT 1; ';

			$result2 = $mysqli->query($sql2);

			print '<div id="snackbar">Attendee added</div>';
		}
	} 
?>

<h5 class="card-header bg-primary text-white"><i class="fas fa-home"></i>&nbsp;&nbsp;Event Attendance</h5><br/>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/>

<div class="container">
	<div class="card-body">	
		<div class="row">		
			<div class="col-md-7">
				<div class="card">
					<div class="card-body">
						<form action="" method="POST">
							<div class="form-group">
								<label for="inputId">Add New Attendant</label>
								<input type="text" name="company_emp_id" class="form-control" id="inputId" placeholder="Employee Company ID" required>
							</div>
							<button type='submit' class='btn btn-success' name=''>
								<i class='fas fa-save'></i>&nbsp;Save
							</button>
							<input type="hidden" name="save-attendant" value="<?= $_GET['event'] ?>">
						</form>
					</div>
				</div>	
			</div>	
			<div class="col-md-5">
				<div class="card">
					<h5 class="card-header">Employee Attendance</h5>
						<div class="card-body">
							<div class="float-right" style="font-size:11px;">
								<b>Attendance Total:</b> 
								<?php
								$count = 0;

								$sql = "SELECT * FROM event_attendance WHERE event_id='$event_id'";
								$result = $mysqli->query($sql);

								while ($attendant = $result->fetch_assoc())
								{
									$count++;
								}
								?>
								<?= $count ?><br/><br/>
							</div>		
							<form action="" method="POST">
								<table  class="table table-striped table-responsive">
									<?php
									if(isset($_GET['event']))
									{
										$event_id = $_GET['event'];	
										$sql = "SELECT * FROM event_attendance WHERE event_id='$event_id'";

										$result = $mysqli->query($sql);

										if ($result->num_rows === 0) 
										{
											echo '<br/>No results found.';
										} 
										else
										{
											echo '<th scope="col">Employee ID</th>
												<th scope="col">Name</th>
												<th scope="col"></th>';
										}

										while ($attendant = $result->fetch_assoc())
										{
											$id = $attendant['id'];
											$company_emp_id = $attendant['company_emp_id'];

											$sql2 = "SELECT * FROM employees WHERE company_emp_id='$company_emp_id'";
											$result2 = $mysqli->query($sql2);

											$employee = $result2->fetch_assoc();
											$first_name = $employee['first_name'];
											$last_name = $employee['last_name'];
											$name = $first_name . ' ' . $last_name;


											echo '<tr id=' . $company_emp_id . '>';
											echo '<td>' . $company_emp_id . '</td>';
											echo '<td>' . $name . '</td>';
											echo '<td>
												<form action="" method="POST">
												<input type="hidden" name="delete-attendant" value="' . $id . '"/>
												<button type="submit"  data-toggle="tooltip" title="Delete" class="btn btn-danger"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to delete?");\" >
												<i class="fas fa-trash"></i>
												</button>
												</form>
											</td>';
											echo '</tr>';
										}
									}
									?>
							</table>
						</form>	
					</div>
				</div>	
			</div>	

		</div>
	</div>
</div>

<?php 
} // authorized

include '../../master/footer.php';?>