<?php
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

if (!isAuthorized(PRMG))
{
	include_once '../unauthorized.php';
}
else
{
	if(isset($_POST['submit-event']))
	{	
		$id = $_POST['submit-event'];
		
		$sql = 'UPDATE events SET status_id="1" WHERE id="'.$id.'"';		
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Event was successfully submitted.</div>';
	}

	if(isset($_POST['accept-event']))
	{	
		$id = $_POST['accept-event'];
		
		$sql = 'UPDATE events SET status_id="2" WHERE id="'.$id.'"';		
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Event was successfully accepted.</div>';
	}

	if(isset($_POST['reject-event']))
	{	
		$id = $_POST['reject-event'];
		
		$sql = 'UPDATE events SET status_id="3" WHERE id="'.$id.'"';		
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Event was successfully rejected.</div>';
	}
	
?>
<h5 class="card-header bg-primary text-white"><i class="fas fa-home"></i>&nbsp;&nbsp;<?=$name?> Program Manager Home</h5><br/>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a>

<div class="container">
	<div class="card-body">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<h5 class="card-header"><i class="far fa-clock"></i>&nbsp;&nbsp;All Unapproved Events</h5>
					<div class="card-body">
						<div class="verticalScroll">
							<table class="table table-striped table-sm table-responsive" style="display: table;">
							<?php
								$sql = "SELECT * FROM events WHERE status_id='1'";

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
												<th>Date</th>
												<th>Name</th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
									</thead>";


								while ($event = $result->fetch_assoc()) 
								{
									$id = $event['id'];
									$name = $event['name'];
									$address = $event['line1'];
									$address2 = $event['line2'];
									$city = $event['city'];
									$state_abbr = $event['state_abbr'];
									$postal = $event['postal'];
									$status = $event['status_id'];

									$converted_date = date('m/d/Y', strtotime($event['date']));

									echo '<tr><td>' . $converted_date . '</td>';
									echo '<td><a href="../events/event-overview.php?event='. $id .'">' . $name . '</a></td>';

									echo '<td><a href="../events/event-form.php?event=' . $id . '" data-toggle="tooltip" title="Edit" class="btn btn-success"><i class="fas fa-edit"></i></a></td>';
									echo '<td>
										<form action="" method="POST">
											<input type="hidden" name="delete-event" value="' . $id . '"/>
											<button type="submit" data-toggle="tooltip" title="Delete" class="btn btn-danger"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to delete?");\" >
												<i class="fas fa-trash fa-sm"></i>
											</button>
										</form>
									  </td>';

									if ($status == 1)
									{
									?>
									<td>
										<form action='' method='POST'>
											<input type='hidden' name='accept-event' value='<?= $id ?>'/>
											<button type='submit'  data-toggle="tooltip" title="Accept" class='btn btn-success' name='submit-btn' ><i class='fa fa-check-circle fa-sm'></i>
											</button>
										</form>
									</td>
									<td>
										<form action='' method='POST'>
											<input type='hidden' name='reject-event' value='<?= $id ?>'/>
											<button type='submit' data-toggle="tooltip" title="Reject" class='btn btn-danger' name='submit-btn' onclick='javascript: return confirm('Confirm delete');' ><i class='fa fa-times-circle fa-sm'></i>
											</button>
										</form>
									</td>
									<?php
									}
									else if ($status == 2)
									{
									?>
									<td colspan="2">							
										<form action='' method='POST'>
											<button type='submit' class='btn btn-success' name='submit-btn' disabled>Accepted
											</button>
										</form>	
									</td>												
									<?php
									}
									else if ($status == 3)
									{
									?>
									<td colspan="2">								
										<form action='' method='POST'>
											<button type='submit' class='btn btn-danger' name='submit-btn' disabled>Rejected
											</button>
										</form>	
									<td>													
									<?php
									}

									echo '</tr>';
								}
								?>
							</table>
						</div>						
					</div>						
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<h6 class="card-header"><i class="far fa-clock"></i>&nbsp;&nbsp;Upcoming Week</h6>
					<div class="card-body">
						<table class="table table-striped table-sm table-responsive" style="display: table;">
						<?php
							$sql = "SELECT id, date, name FROM events WHERE `date` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)";

							if (!$result = $mysqli->query($sql)) {
								echo "Sorry, the website is experiencing problems.";
								//exit;
							}

							if ($result->num_rows === 0) 
							{
								echo "No upcoming events.";
							} 
							else
							{
								echo "<thead>
											<tr>
												<th>Date</th>
												<th>Name</th>
											</tr>
									</thead>";


								while ($event = $result->fetch_assoc()) 
								{
									$id = $event['id'];
									$name = $event['name'];
									$converted_date = convertDate($event['date']);

									echo '<tr><td>' . $converted_date . '</td>';
									echo '<td><a href="../events/event-overview.php?event='. $id .'">' . $name . '</a></td>';
									echo '</tr>';
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
}

include '../master/footer.php'; ?>
