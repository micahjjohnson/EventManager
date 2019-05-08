<?php
//ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php';

if (!isAuthorized(PRMG))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if(isset($_POST['accept-vto']))
	{	
		$vto_id = $_POST['accept-vto'];

		$sql = 'UPDATE volunteer_submissions SET status="accepted", approved_by="'.$username.'" WHERE id="'.$vto_id.'"';		
		$result = $mysqli->query($sql);

		print '<div id="snackbar">VTO was successfully accepted</div>';
	}

	if(isset($_POST['cancel-vto']))
	{	
		$vto_id = $_POST['cancel-vto'];

		//$sql = 'UPDATE volunteer_submissions SET status="accepted" WHERE id="'.$vto_id.'"';		
		//$result = $mysqli->query($sql);

		//print '<div id="snackbar">VTO was successfully cancelled</div>';
	}

	if(isset($_POST['reject-vto']))
	{
		$vto_id = $_POST['reject-vto'];
		
		$sql = 'UPDATE volunteer_submissions SET status="rejected",  approved_by="'.$username.'" WHERE id="'.$vto_id.'"';		
		$result = $mysqli->query($sql);

		print '<div id="snackbar">VTO was successfully rejected</div>';
	}	
?>

<div class="card" style="max-width:none; min-width:55%;">
	<h5 class="card-header bg-primary text-white"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;VTO Employee Submissions</h5>
	<div class="card-body">
		<table style="cursor: default; display: block;" class="table table-striped table-sm table-responsive table-hover">
			<thead>
				<tr>
					<th scope="col" style="width: 150px;">Employee Id</th>
					<th scope="col">Date</th>
					<th scope="col" style="width: 250px;">Volunteer Organization</th>
					<th scope="col" style="width: 60px;">Total Hours</th>
					<th scope="col" style="width: 250px;">Details</th>
					<th scope="col" colspan="2" style="width: 113px;">Status</th>
					<th scope="col">Manager</th>
					<th scope="col"></th>
				</tr>
			</thead>

			<?php
			$rowCounter = 1;
			$description_is_short = false;

			$sql = "SELECT * FROM volunteer_submissions WHERE company_emp_id != '$username' AND status <> 'accepted' and status <> 'rejected'";
			$result = $mysqli->query($sql);

			if ($result->num_rows == 0) 
			{
				echo "<tr><td colspan='8'>No submissions found.</td></tr>";
			}		
			else
			{
				while ($submissions = $result->fetch_assoc()) 
				{		
					$id = $submissions['id'];
					$employee_id = $submissions['company_emp_id'];
					$name = $submissions['name'];
					$hours = $submissions['hours'];		
					$status = $submissions['status'];
					$description = $submissions['description'];
					$approved_by = $submissions['approved_by'];
					$supervisor = $submissions['supervisor'];
					$phone = $submissions['phone'];

					$converted_date = date('m/d/Y', strtotime($submissions['date']));

					print "
					<tr id='$id'>
								<td>$employee_id</td>
								<td>$converted_date</td>
								<td>$name</td>
								<td>$hours</td>
								<td>
									$description <br>
									<button style='margin: 5px; float: right;' type='submit' class='btn btn-success' name='submit-btn' data-toggle='collapse' data-target='.demo$rowCounter'>More Details
									</button>
								</td>";

					if (strcmp($status, 'accepted') == 0)
					{
						echo "<td colspan='2'>Approved</td>";
					}
					else if (strcmp($status, 'rejected') == 0)
					{
						echo "<td colspan='2'>Rejected</td>";
					}
					else 
					{
						print "
						<td>
							<form action='' method='POST'>
								<input type='hidden' name='accept-vto' value='$id'/>
								<button type='submit' data-toggle='tooltip' title='Accept' class='btn btn-success' name='submit-btn' ><i class='fa fa-check-circle'></i>
								</button>
							</form>
						</td>
						<td>
							<form action='' method='POST'>
								<input type='hidden' name='reject-vto' value='$id'/>
								<button type='submit' data-toggle='tooltip' title='Reject' class='btn btn-danger' name='submit-btn' onclick='javascript: return confirm('Confirm delete');' ><i class='fa fa-times-circle'></i>

								</button>
							</form>
						</td>";		
					}

					print "
						<td>$approved_by</td>
						<td>
							<form action='' method='POST'>
								<input type='hidden' name='cancel-vto' value='$id'/>
								<button type='submit' class='btn btn-danger' name='submit-btn' disabled ><i class='fa fa-ban'></i>
								</button>
							</form>
						</td>	
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td colspan='5' class='hiddenRow'>
								<div class='collapse demo$rowCounter'>
									<strong>Supervisor Name: </strong>$supervisor <br>
									<strong>Phone Number: </strong>$phone <br>						<strong>Details: </strong>$description
								</div>
							</td>
						</tr>
						";

					++$rowCounter;
				}
			}
				//$mysqli->close();
				?>
		</table>
		</div>
</div>
<?php
} // authorized

include '../master/footer.php';?>