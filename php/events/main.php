<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 

if (!isAuthorized(CHL))
{
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['delete-event'])) {
		$delete_id = $_POST['delete-event'];

		$sql = "DELETE FROM events WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Event ' . $delete_id . ' deleted</div>';
	} 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="" method="POST">
				<div class="card">
					<h5 class="card-header bg-primary text-white"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Master Event List</h5>
					<div class="card-body">
						<a href="event-form.php" class = "btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Event</a><br/><br/>
						<table class="table table-striped table-sm table-responsive" style="display: table;">
						<thead>
							<tr>
								<th></th>
								<th>Id</th>
								<th>Event Date</th>
								<th>Event Name</th>
								<th>Street Address</th>
								<th>City</th>
								<th>State</th>
								<th>ZIP</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<?php
						$sql = "SELECT * FROM events";
						$result = $mysqli->query($sql);

						if ($result->num_rows === 0) 
						{
							echo "<tr>
									<td colspan='10'>No results found.</td>
									</tr>";
							//exit;
						} 
						else 
						{
							while ($event = $result->fetch_assoc()) 
							{
								$id = $event['id'];
								$name = $event['name'];
								$address = $event['line1'];
								$city = $event['city'];
								$state_abbr = $event['state_abbr'];
								$postal = $event['postal'];
								$status = $event['status_id'];
							
								$converted_date = date('m/d/Y', strtotime($event['date']));

								echo '<tr id=' . $id . '>';
								if ($status == 0 || isAuthorized(PRM))
								{
									echo '<td><a data-toggle="tooltip" title="Edit" href="event-form.php?event=' . $id . '" class="btn btn-success"><i class="fas fa-edit fa-xs"></i></a></td>';
								}
								else
								{
									echo '<td></td>';
								}				
								echo '<td>' . $id . '</td>';
								echo '<td>' . $converted_date . '</td>';
								echo '<td><a href="event-overview.php?event='. $id .'">' . $name . '</a></td>';
								echo '<td>' . $address . '</td>';
								echo '<td>' . $city . '</td>';
								echo '<td>' . $state_abbr . '</td>';
								echo '<td>' . $postal . '</td>';
							
								if (isAuthorized(PRM))
								{				
									echo '<td>
										<form action="" method="POST">
											<input type="hidden" name="delete-event" value="' . $id . '"/>
											<button type="submit" data-toggle="tooltip" title="Delete" class="btn btn-danger"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to delete?");\" >
												<i class="fas fa-trash fa-xs"></i>
											</button>
										</form>
									</td>';
								}					
								echo '<td><a href="attendance/main.php?event=' . $id . '" data-toggle="tooltip" title="Attendance"  class="btn btn-success"><i class="fas fa-users fa-xs"></i>  </a></td>';				
								echo '</tr>';
							}
						}
						?>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
} // authorized

include '../master/footer.php';?>
