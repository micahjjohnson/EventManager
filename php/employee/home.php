<?php
//ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['remove-rsvp'])) 
	{
		$rsvp_id = $_POST['remove-rsvp'];

		$sql = "DELETE FROM event_rsvps WHERE event_id='$rsvp_id' AND company_emp_id='$username'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">You successfully removed your RSVP.</div>';
	} 
?>
<h5 class="card-header bg-primary text-white"><i class="fas fa-home"></i>&nbsp;&nbsp;Employee Home</h5>
<div class="card-body">

<div class="row">
	<div class="col-md-3">
		<div class="card" style="max-width: 245px;">
			<div class="card-body">
				<img src="../assets/images/avatar.png" alt="Avatar" class="img-fluid img-thumbnail">
			</div>
			<div class="card-body">
				<table>
					<tr>
						<td><?php print $user_name . ' ' . $user_last_name; ?></td>
					</tr>
					<tr>
						<td style="color: #5f80b7; font-size: 13px;"><b><i><?php print $user_role; ?></i></b></td>
					</tr>
				</table>
			</div>
		</div>
		<br/>
		<div class="card" style="max-width: 245px;">
			<h6 class="card-header"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;My RSVPs</h6>
			<div class="card-body">
				<div class="tight-verticalScroll">
					<table class="table table-striped table-sm table-responsive" style="display: table; font-size: .5rem;">
					<?php
						$sql = "SELECT * FROM event_rsvps JOIN events ON event_rsvps.event_id = events.id WHERE company_emp_id='$username'";

						if (!$result = $mysqli->query($sql)) {
							//echo "Sorry, the website is experiencing problems.";
						}

						if ($result->num_rows == 0) 
						{
							echo '<tr>
									<td>No events found.</td>
								<tr>';
						}
						else
						{
							echo "<thead>
										<tr>
											<th>Date</th>
											<th>Name</th>
											<th></th>
										</tr>
								</thead>";

							while ($event = $result->fetch_assoc()) 
							{
								$id = $event['id'];
								$date = $event['date'];
								$name = $event['name'];

								$converted_date = convertDate($date);
								$converted_stime = convertTime($start_time);
								$converted_etime = convertTime($end_time);

								echo '<tr id=' . $id . '>';
									echo '<td>' . $converted_date . '</td>';
									echo '<td><a href="../events/event-detail-map.php?event='. $id .'">' . $name . '</a></td>';
									echo '<td>
											<form action="" method="POST">
												<input type="hidden" name="remove-rsvp" value="' . $id . '"/>
												<button type="submit" data-toggle="tooltip" title="Delete" class="sm-delete-btn"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to remove this RSVP??");\" >
													<i class="fas fa-trash fa-xs"></i>
												</button>
											</form>
										  </td>';
								echo '</tr>';
							}
						}

						//$mysqli->close();
					?>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-6" >
	<div class="card" style="max-height: 200px;">
			<h6 class="card-header"><i class='fas fa-clock'></i>&nbsp;&nbsp;VTO Hours</h6>
			<div class="card-body">
				<div class="tight-verticalScroll">
				<table class="table table-striped table-sm table-responsive" style="display: table;">
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
								<th scope="col">Organization</th>
								<th scope="col">Hours</th>
								<th scope="col">Status</th>
							</tr>
						</thead>';

						while ($submission = $result->fetch_assoc())
						{
							$id = $submission['id'];
							$hours = $submission['hours'];
							$name = $submission['name'];
							$status = $submission['status'];

							$converted_date = date('m/d/Y', strtotime($submission['date']));

							echo "<tr>";
							echo "<td>". $converted_date . "</td>";
							echo "<td>". $name . "</td>";
							echo "<td>". $hours . "</td>";
							echo "<td>". $status . "</td>";
							echo "</tr>";
						}
					}
					?>
					</table>
				</div>
			</div>	
		</div>	
		
		<br />
		<div class="card" style="max-height: 331px;">
			<h6 class="card-header"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Following Chapter Events</h6>
			<div class="card-body">
				<div class="tight-verticalScroll" style="height: 238px;">
					<table class="table table-striped table-sm table-responsive" style="display: table;">
					<?php
					$sql = "SELECT * FROM employee_chapter_follow JOIN events ON employee_chapter_follow.chapter_id = events.chapter_id WHERE company_emp_id='$username' ORDER BY date";

					$result = $mysqli->query($sql);

					if ($result->num_rows == 0) 
					{
						echo "<tr><td colspan='4'>You are not following any chapters or no events are available.</td></tr>";
					}
					else
					{
						echo "<thead>
								<tr>
									<th>Date</th>
									<th>Event Name</th>
									<th>Chapter Name</th>
								</tr>
						</thead>";

						while ($follow = $result->fetch_assoc())
						{
							$id = $follow['id'];
							$chapter_id = $follow['chapter_id'];
							$event_name = $follow['name'];
							$converted_date = convertDate($follow['date']);

							// chapter SQL -- can later edit JOIN statement above
							$chapsql = "SELECT name FROM chapters WHERE id='$chapter_id'";
							$chapresult = $mysqli->query($chapsql);
							$chapter = $chapresult->fetch_assoc();

							echo "<tr>";
							echo '<td>' . $converted_date . '</td>';
							echo '<td><a href="../events/event-detail-map.php?event='. $id .'">' . $event_name . '</a></td>';
							echo '<td><a href="../chapters/chapter-overview.php?chapter='. $chapter_id .'">' . $chapter['name'] . '</a></td>';
							echo "</tr>";
						}
					}
					?>
					</table>
				</div>
			</div>
		</div>			
	</div>	
	
	<div class="col-md-3">
		<div class="card">
			<h6 class="card-header" style="font-size:15px;"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Events Followed</h6>
			<div class="card-body">
				<div class="tight-verticalScroll">
					<table class="table table-sm table-responsive" style="display: table;">
					<?php
					$sql = "SELECT * FROM employee_event_follow JOIN events ON employee_event_follow.event_id = events.id WHERE company_emp_id='$username'";

					$result = $mysqli->query($sql);

					if ($result->num_rows == 0) 
					{
						echo "<tr><td>You are not following any events.</td></tr>";
					}
					else
					{
						while ($follow = $result->fetch_assoc())
						{
							$id = $follow['id'];
							$chapter_id = $follow['chapter_id'];
							$event_name = $follow['name'];
							$converted_date = convertDate($follow['date']);

							echo "<tr>";
							echo '<td><a href="../events/event-detail-map.php?event='. $id .'">' . $event_name . '</a></td>';
							echo "</tr>";
						}
					}
					?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<?php
} // authorized

include '../master/footer.php';?>