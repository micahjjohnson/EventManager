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
	if (isset($_POST['rsvp']))
	{		
		$today = date("Y-m-d H:i:s");
		$event_id = $_POST['event-id'];
		$guests = $_POST['guests'];
		$email_reminder = $_POST['email-reminder'];
				
		if ($guests == 0)
		{
			$guests = 1;
		}
		if($email_reminder != 'YES')
		{
			$email_reminder = 'NO';
		}

		$sql = 'INSERT INTO event_rsvps (company_emp_id, event_id, guests, time, email_reminder) 
		VALUES ("'.$username.'",  "'.$event_id.'", "'.$guests.'", "'.$today.'", "'.$email_reminder.'"); ';				

		$result = $mysqli->query($sql);

		if ($result === TRUE) 
		{
			$isRSVP = true;
			print '<div id="snackbar">Your space is secured.</div>';
		} 
		else 
		{
			//echo "Error: " . $sql . "<br>" . $conn->error;
			print '<div id="snackbarFail">Something Went Wrong! Please try again.</div>';
		}
	}	
	
	if (isset($_GET['remove-rsvp'])) 
	{
		$rsvp_id = $_GET['remove-rsvp'];

		$sql = "DELETE FROM event_rsvps WHERE event_id='$rsvp_id' AND company_emp_id='$username'";
		$result = $mysqli->query($sql);
		
		$id = $rsvp_id;

		print '<div id="snackbar">You successfully removed your RSVP.</div>';
	} 
	else if (isset($_GET['follow-event'])) 
	{
		$follow_id = $_GET['follow-event'];

		$sql = 'INSERT INTO employee_event_follow (company_emp_id, event_id) VALUES ("'.$username.'",  "'.$follow_id.'")';
		$result = $mysqli->query($sql);

		$id = $follow_id;

		print '<div id="snackbar">You are now following this event.</div>';
	} 
	else if (isset($_GET['unfollow-event'])) 
	{
		$unfollow_id = $_GET['unfollow-event'];

		$sql = "DELETE FROM employee_event_follow WHERE event_id='$unfollow_id' AND company_emp_id='$username'";
		$result = $mysqli->query($sql);
		
		$id = $unfollow_id;

		print '<div id="snackbar">You have unfollowed this event.</div>';
	} 
	else // if just removed, followed, or unfollowed we already have ID
	{
		$id = $_GET['event'];
	}
	
	// if RSVP for event
	$rsvp_sql = "SELECT * FROM event_rsvps WHERE event_id='$id' AND company_emp_id='$username'";
	$rsvp_result = $mysqli->query($rsvp_sql);

	if ($rsvp_result->num_rows !== 0) 
	{
		$isRSVP = true;
	}
	
	// if follow event
	$follow_sql = "SELECT * FROM employee_event_follow WHERE event_id='$id' AND company_emp_id='$username'";
	$follow_result = $mysqli->query($follow_sql);

	if ($follow_result->num_rows !== 0) 
	{
		$follow = true;
	}
	
	$sql = "SELECT * FROM events WHERE ID='$id'";
	$result = $mysqli->query($sql);

	if (!$result) 
	{
		echo "Sorry, the website is experiencing problems.";
		exit;
	}

	while ($event = $result->fetch_assoc())
	{
		$name = $event['name'];
		$chapter_id = $event['chapter_id'];
		$description = $event['description'];
		$line1 = $event['line1'];
		$line2 = $event['line2'];
		$city = $event['city'];
		$state_abbr = $event['state_abbr'];
		$postal = $event['postal'];			
		$start_time = $event['start_time'];
		$end_time = $event['end_time'];

		$converted_date = convertDate($event['date']);
		$converted_stime = convertTime($start_time);
		$converted_etime = convertTime($end_time);

		$chap_sql = "SELECT name FROM chapters WHERE ID='$chapter_id'";
		$chap_result = $mysqli->query($chap_sql);
		$chapter = $chap_result->fetch_assoc();
		$chapter_name = $chapter['name'];
	}	
?>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/><br/>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<form action="" method="POST">
				<div class="card">
					<h5 class="card-header bg-primary text-white"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Event Details</h5>
					<div class="card-body">
						<table class="table table-striped table-sm table-responsive">
							<?php
							if ($isRSVP != true)
							{
							?>
							<tr>
								<td>
								<a class="btn btn-secondary" href="#ex1" rel="modal:open"><i class='far fa-calendar-check'></i>&nbsp;&nbsp;RSVP</a><br/>
								</td>
							<?php
							}
							else
							{
							?>
							<tr>
								<td>
								<a class="btn btn-secondary" href="event-detail-map.php?remove-rsvp=<?= $id ?>"><i class='far fa-calendar-times'></i>&nbsp;&nbsp;REMOVE RSVP</a><br/>
								</td>
							<?php	
							}
							if ($follow == true)
							{
							?>
								<td style="float:right;">
								<a class="btn btn-secondary" href="event-detail-map.php?unfollow-event=<?= $id ?>" title="Unfollow"><i class="fas fa-eye-slash"></i>&nbsp;&nbsp; Unfollow</a>
								</td>
								<div class="clear"></div>
							<?php
							}
							else
							{
							?>
								<td style="float:right;">														
								<a class="btn btn-secondary" href="event-detail-map.php?follow-event=<?= $id ?>" title="Follow"><i class="fas fa-eye"></i>&nbsp;&nbsp; Follow</a>
								</td>	
								<div class="clear"></div>					
							<?php
							}
							?>
							</tr>	
							<tr>
								<td><strong>Chapter</strong></td>
								<td><a href='../chapters/chapter-overview.php?chapter=<?= $chapter_id ?>'><?= $chapter_name ?></td>
							</tr>
							<tr>
								<td><strong>Date</strong></td>
								<td><?= $converted_date ?></td>
							</tr>
							<tr>
								<td><strong>Start Time</strong></td>
								<td><?= $converted_stime ?></td>
							</tr>
							<tr>
								<td><strong>End Time</strong></td>
								<td><?= $converted_etime ?></td>
							</tr>
							<tr>
								<td><strong>Event Name</strong></td>
								<td><?= $name ?></td>
							</tr>
							<tr>
								<td><strong>Event Description</strong></td>
								<td><?= $description ?></td>
							</tr>
							<tr>
								<td><strong>Address</strong></td>
								<td><?= $line1 ?></br>
									<?= $line2 ?></br>
									<?= $city ?>, <?= $state_abbr ?> <?= $postal ?>				
								</td>
							</tr>
						</table>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<div class="card">
				<h5 class="card-header bg-primary text-white"><i class='fas fa-file-invoice-dollar'></i>&nbsp;&nbsp;Event Map</h5>
				<div class="card-body">
					<img src="../assets/images/map-placeholder.jpg"  class="img-fluid" alt="map">
				</div>
			</div>
		</div>
	</div>
</div>

<div id="ex1" class="modal">
	<form method="POST" action="">	
		<div class="form-group row">
			<label for="guests" class="col-sm-8 col-form-label">Guests (not including yourself)</label>
			<select name="guests">
				<?php
				for($i = 0; $i < 8; $i++)
				{
					print '<option value='.$i.'>'.$i.'</option>';
				}
				?>
			</select>
		</div>
		<div class="form-group row">
			<label class="col-sm-10 col-form-label"><input type="checkbox" name='email-reminder' value="YES"> I would like an event reminder sent to my email.</label>
		</div>
		<div class="form-group row">
			<input type="hidden" name="event-id" value="<?= $id ?>" >
			<input type="hidden" name="rsvp" >
			<div class="col">
				<button type='submit' class='btn btn-success col-sm-6' name=''>
				Submit
				</button>
			</div>
			<div class="col">
				<a href="#" rel="modal:close" class="btn btn-secondary">Cancel</a>
			</div>
		</div>
	</form>
</div>

<?php
} // authorized

include '../master/footer.php';?>