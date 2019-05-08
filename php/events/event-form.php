<?php
//ini_set('display_errors',1); error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 
$am = 'AM';
$pm = 'PM';
//include '../master/session.php'; 
	
if (!isAuthorized(EMP))
{
		$mysqli->close();
		include_once '../unauthorized.php';
	}
	else // authorized
	{
		$canCreateEvent = false;
		$id = "";
		$date = "";
		$name = "";
		$description = "";
		$line1 = "";
		$line2 = "";
		$city = "";
		$state_abbr = "";
		$postal = "";
		$start_time = "";
		$end_time = "";
		
		if (isset($_POST['insert-event']) || isset($_POST['update-event']))
		{
			$date = $_POST['event_date'];
			$name = $_POST['event_name'];
			$description = $_POST['description'];
			$line1 = $_POST['line1'];
			$line2 = $_POST['line2'];
			$city = $_POST['city'];
			$state_abbr = $_POST['state_abbr'];
			$postal = $_POST['postal'];
			$start_time = $_POST['event_start_time'];
			$end_time = $_POST['event_end_time'];

			$chapter_id = $_POST['chapter'];
			// $rsvp = $_POST['rsvp'];
			// $rsvp_date = $_POST['rsvp_date'];
			
			if(isset($_POST['update-event']))
			{
				$id = $_POST['eventid'];
				
				$sql = 'UPDATE events SET name="'.$name.'", date="'.$date.'", start_time="'.$start_time.'", end_time="'.$end_time.'", description="'.$description.'", line1="'.$line1.'", line2="'.$line2.'", city="'.$city.'", state_abbr="'.$state_abbr.'", postal="'.$postal.'", chapter_id="'.$chapter_id.'" WHERE id="'.$id.'"';
				$result = $mysqli->query($sql);

				if (!$result) 
				{
					echo "Sorry, the website is experiencing problems.";
					print '<div id="snackbarFail">Something Went Wrong!</div>';
					exit;
				}
				else
				{
					print '<div id="snackbar">Event ' . $id . ' updated</div>';
				}
			}
			else
			{
				$id = "0";
				
				$sql = 'INSERT INTO events (name, date, start_time, end_time, description, line1, line2, city, state_abbr, postal, coordinator_employee_id, chapter_id) 
				VALUES ("'.$name.'",  "'.$date.'", "'.$start_time.'", "'.$end_time.'", "'.$description.'", "'.$line1.'", "'.$line2.'", "'.$city.'", "'.$state_abbr.'", "'.$postal.'", "'.$username.'", "'.$chapter_id.'"); ';

				$result = $mysqli->query($sql);

				if ($result === TRUE) 
				{
					$last_id = $mysqli->insert_id;
					print '<div id="snackbar">Event ID ' . $last_id . ' added</div>';
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $conn->error;
					print '<div id="snackbarFail">Something Went Wrong!</div>';
				}
			}
		}

?>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/><br/>

<?php
	if(isset($_GET['event']))
	{
		$id = $_GET['event'];	
		$sql = "SELECT * FROM events WHERE ID='$id'";
		$result = $mysqli->query($sql);

		if (!$result) 
		{
			echo "Sorry, the website is experiencing problems.";
			exit;
		}

		while ($event = $result->fetch_assoc())
		{
			$date = $event['date'];
			$name = $event['name'];
			$description = $event['description'];
			$line1 = $event['line1'];
			$line2 = $event['line2'];
			$city = $event['city'];
			$state_abbr = $event['state_abbr'];
			$postal = $event['postal'];
			$start_time = $event['start_time'];
			$end_time = $event['end_time'];
			
			// $rsvp = $event['rsvp'];
			// $rsvp_date = $event['rsvp_date'];
			
			$converted_date = date('m/d/Y', strtotime($date));
		}

		print '<h5>Editing Event ID:' . $id . '</h5>';
	} 
	else if ($_GET["chapter"])
	{
		$chapter_id = $_GET["chapter"];
	}
	else
	{
		$id = "";
		$date = "";
		$name = "";
		$description = "";
		$line1 = "";
		$line2 = "";
		$city = "";
		$state_abbr = "";
		$postal = "";
	}
?>

<div class="card">
  <h6 class="card-header"><i class='fas fa-th-list'></i>&nbsp;&nbsp;Enter event details</h6>
  <div class="card-body">
        <form method="POST" action="" onsubmit="return checkDate()">
			<div class="form-group">
				<?php
				if (isAuthorized(PRM))
				{
					$sql = "SELECT * FROM chapters";
				}
				else
				{
					$sql = "SELECT * FROM chapter_leaders JOIN chapters ON chapter_leaders.chapter_id = chapters.id WHERE company_emp_id='$username'";
				}


				$result = $mysqli->query($sql);

				if ($result->num_rows == 0) 
				{
					echo "<b>You cannot create an event because you are not a chapter leader.</b>";
					$canCreateEvent = false;
				}
				else
				{
					$canCreateEvent = true;
					echo '<label for="inputName">Select Chapter  </label><span class="required">&nbsp;*</span>';
					echo '<select name="chapter" class="form-control" >';

					while ($chapter = $result->fetch_assoc())
					{						
						$chap_id = $chapter['id'];
						$chap_name = $chapter['name'];


						if ($chap_id == $chapter_id)
						{
							echo '<option value='. $chap_id .' selected >'. $chap_name .'</option>';
						}
						else
						{
							echo '<option value='. $chap_id .' >'. $chap_name .'</option>';		
						}						
					}
					echo '</select>';
				}
				?>
			</div>
			<div class="form-group">
				<label for="inputName">Event Title</label><span class="required">&nbsp;*</span>
				<input type="text" name="event_name" class="form-control" id="inputName" value="<?= $name ?>" required maxlength="75">
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputDate">Event Date</label><span class="required">&nbsp;*</span>
					<input type="date" name="event_date" class="form-control" id="inputDate" value="<?= $date ?>" required>
				</div>
				<div class="form-group col-md-3">
					<label for="inputStartTime">Event Start Time</label><span class="required">&nbsp;*</span>
					<input type="time" name="event_start_time" class="form-control" id="inputStartTime"value="<?= $start_time ?>" required>
				</div>
				<div class="form-group col-md-3">
					<label for="inputEndTime">Event End Time</label><span class="required">&nbsp;*</span>
					<input type="time" name="event_end_time" class="form-control" id="inputEndTime"value="<?= $end_time ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputDescrip">Description</label>
				<textarea rows="4" cols="50" class="form-control" id="description" name="description"><?= $description ?></textarea>
			</div>
			<div class="form-group">
				<label for="inputAddress1">Address 1</label>
				<input type="text" maxlength="100" class="form-control" id="inputAddress1" name="line1" value="<?= $line1 ?>" >
			</div>
			<div class="form-group">
				<label for="inputAddress2">Address 2</label>
				<input type="text" maxlength="100" class="form-control"id="inputAddress2"  name="line2" value="<?= $line2 ?>" >
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="inputCity">City</label>
					<input type="text" maxlength="50" class="form-control" id="inputCity" name="city" value="<?= $city ?>" >
				</div>
				<div class="form-group col-md-4">
					<label for="state_abbr">State</label>
					<select id="state_abbr" name="state_abbr" class="form-control">
						<option name="select-state" value="N/A">Select...</option>
						<?php		
							$sql = "SELECT abbreviation FROM us_states";
							$result = $mysqli->query($sql);
							while ($states = $result->fetch_assoc()) 
							{
								$state = $states['abbreviation'];

								if ($state_abbr == $state)
									print "<option name='select-state' value='$state' selected>$state</option>";
								else 
									print "<option name='select-state' value='$state'>$state</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group col-md-2">
					<label for="inputZip">Zip</label>
					<input type="text" class="form-control" id="inputZip" maxlength="5" name="postal" value="<?= $postal ?>" >
				</div>
			</div>		

			<?php
			if(isset($_GET['event']))
			{
				echo '<input type="hidden" name="update-event" >';
				echo '<input type="hidden" name="eventid" value=' . $id . ' >';
			}
			else
			{
				echo '<input type="hidden" name="insert-event" >';
			}
			?>
			<div class="float-right col-md-4">
				<button type='submit' class='btn btn-primary' title='Save' <?php if(!$canCreateEvent) print 'disabled'; ?>>
					Submit
				</button>
				<a href="javascript:history.go(-1)" class="btn btn-secondary">Cancel</a>
			</div>
		
        </form>
  </div>
</div>

<script>
function checkDate() 
{
	var selectedText = document.getElementById('inputDate').value;
	var selectedDate = new Date(selectedText);
	var now = new Date();
	
	if (selectedDate < now) 
	{
		alert("Date must be in the future");
		return false;
	}
	else return true;
}
</script>

<?php
} // authorized

include '../master/footer.php';?>