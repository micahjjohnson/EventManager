<?php 
ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 

if (!isAuthorized(EMP))
{
	include_once '../unauthorized.php';
}
else // authorized
{
	$id = $_GET['chapter'];
	
	$sql = "SELECT * FROM chapters WHERE id='$id' ";
	$result = $mysqli->query($sql);
	
	while ($chapter = $result->fetch_assoc())
	{
		$name = $chapter['name'];
		$description = $chapter['description'];
	}
?>
<h5 class="card-header bg-primary text-white"><i class="fas fa-home"></i>&nbsp;&nbsp;<?=$name?> Chapter Home</h5><br/>


<div class="row">
	<div class="col">
		<div class="float-left">
			<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a>
		</div>
	</div>
	<div class="col">
		<div class="float-right">
			<a href="../events/event-form.php?chapter=<?= $id ?>" class = "btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Create New Event</a><br/><br/>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="card">
				<h6 class="card-header"><i class="far fa-clock"></i>&nbsp;&nbsp;New Events</h6>
				<div class="card-body">
					<table class="table table-sm table-striped" style='font-size:12px; overflow-'>
					<?php
					echo "<thead>
								<tr>
									<th>Event Date</th>
									<th>Event Name</th>
									<th></th>
								</tr>
						</thead>";

					$sql = "SELECT * FROM events WHERE status_id='0' AND chapter_id='$id' " ;
					$result = $mysqli->query($sql);

					if (!$result) 
					{
						echo "Sorry, the website is experiencing problems.";
						exit;
					}

					if ($result->num_rows === 0) 
					{
						echo '<tr>
								<td colspan="5">No new events.</td>
								</tr>';
					} 

					while ($event = $result->fetch_assoc()) 
					{
						///*
						$event_id = $event['id'];
						$name = $event['name'];

						$converted_date = date('m/d/Y', strtotime($event['date']));

						echo '<tr id=' . $event_id . '>';
						echo '<td>' . $converted_date . '</td>';
						echo '<td><a href="../events/event-overview.php?event='. $event_id .'">' . $name . '</a></td>';
						echo '<td><a href="../events/event-form.php?event=' . $event_id . '" data-toggle="tooltip" title="Edit" class="btn btn-success"><i class="fas fa-edit"></i></a></td>';
						echo '</tr>';
						//*/
					}

					?>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<h6 class="card-header"><i class="far fa-clock"></i>&nbsp;&nbsp;Pending Approval</h6>
				<div class="card-body">
					<table class="table table-sm table-striped " style='font-size:12px; overflow-x:auto;'>
					<?php
					echo "<thead>
								<tr>
									<th>Event Date</th>
									<th>Event Name</th>
									<th></th>
								</tr>
						</thead>";

					$sql = "SELECT * FROM events WHERE status_id='1' AND chapter_id='$id' " ;
					$result = $mysqli->query($sql);

					if (!$result) 
					{
						echo "Sorry, the website is experiencing problems.";
						exit;
					}

					if ($result->num_rows === 0) 
					{
						echo '<tr>
								<td colspan="5">No pending events.</td>
								</tr>';
					} 

					while ($event = $result->fetch_assoc()) 
					{
						///*
						$event_id = $event['id'];
						$name = $event['name'];

						$converted_date = date('m/d/Y', strtotime($event['date']));

						echo '<tr id=' . $event_id . '>';
						echo '<td>' . $converted_date . '</td>';
						echo '<td><a href="../events/event-overview.php?event='. $event_id .'">' . $name . '</a></td>';
						echo '<td><a href="../events/event-form.php?event=' . $event_id . '" data-toggle="tooltip" title="Edit" class="btn btn-success" title="Edit" ><i class="fas fa-edit fa-xs"></i></a></td>';
						echo '</tr>';
						//*/
					}

					?>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<h6 class="card-header"><i class='fa fa-check-circle'></i>&nbsp;&nbsp;Approved Events</h6>
				<div class="card-body">
					<table class="table table-sm table-striped table-responsive">				
					<?php
					echo "<thead>
							<tr>
								<th>Event Date</th>
								<th>Event Name</th>
								<th></th>
							</tr>
					</thead>";

					$sql = "SELECT * FROM events WHERE chapter_id='$id' AND status_id='2'";
					$result = $mysqli->query($sql);

					if (!$result) 
					{
						echo '<tr>
								<td colspan="5">No accepted events.</td>
								</tr>';
					}

					if ($result->num_rows === 0) 
					{
						echo '<tr>
								<td colspan="5">No approved events.</td>
								</tr>';
					} 
					else
					{
						while ($event = $result->fetch_assoc()) 
						{
							///*
							$id = $event['id'];
							$name = $event['name'];

							$converted_date = date('m/d/Y', strtotime($event['date']));

							echo '<tr id=' . $id . '>';
							echo '<td>' . $converted_date . '</td>';
							echo '<td><a href="/../events/event-overview.php?event='. $id .'">' . $name . '</a></td>';
							echo '<td><a href="../events/attendance/main.php?event=' . $id . '" data-toggle="tooltip" title="Attendance"  class="btn btn-success"><i class="fas fa-users fa-xs"></i>  </a></td>';
							echo '</tr>';
							//*/
						}
					}

					?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
} // authorized

include_once '../master/footer.php'; ?>