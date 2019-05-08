<?php
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

$requiredRole = 4;
if (!isAuthorized(CHL))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_GET['follow-chapter'])) 
	{
		$follow_id = $_GET['follow-chapter'];

		$sql = 'INSERT INTO employee_chapter_follow (company_emp_id, chapter_id) VALUES ("'.$username.'",  "'.$follow_id.'")';
		$result = $mysqli->query($sql);
		
		$id = $follow_id;

		print '<div id="snackbar">You are now following this chapter.</div>';
	} 
	else if (isset($_GET['unfollow-chapter'])) 
	{
		$unfollow_id = $_GET['unfollow-chapter'];

		$sql = "DELETE FROM employee_chapter_follow WHERE chapter_id='$unfollow_id' AND company_emp_id='$username'";
		$result = $mysqli->query($sql);

		$id = $unfollow_id;

		print '<div id="snackbar">You have unfollowed this chapter.</div>';
	} 
	else 
	{
		$id = $_GET['chapter'];	
	}
	
	$sql = "SELECT * FROM chapters WHERE id='$id'";
	$result = $mysqli->query($sql);

	while ($chapter = $result->fetch_assoc()) 
	{
		$id = $chapter['id'];
		$name = $chapter['name'];
		$description = $chapter['description'];			
	}

	// if follow chapter
	$follow_sql = "SELECT * FROM employee_chapter_follow WHERE chapter_id='$id' AND company_emp_id='$username'";
	$follow_result = $mysqli->query($follow_sql);

	if ($follow_result->num_rows !== 0) 
	{
		$follow = true;
	}
?>
<h5 class="card-header bg-primary text-white"><i class="fas fa-home"></i>&nbsp;&nbsp;<?=$name?> Chapter Overview</h5><br/>
<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a>

<div class="container">
	<div class="card-body">	
		<div class="row">
			<div class="col-md-5">
				<form action="" method="POST">
					<div class="card">
						<div class="card-body">
							<div class="col">
								<div class="float-left">
									<div style="font-size: 13px; font-weight: bold;"><?=$name?></div>
								</div>
								<div class="float-right">
								<table>
									<tr>
										<?php	
										if ($follow == true)
										{
										?>
										<td>
											<a class="btn btn-secondary" href="chapter-overview.php?unfollow-chapter=<?= $id ?>"  data-toggle="tooltip" title="Unfollow"><i class="fas fa-eye-slash fa-sm"></i></a>
										</td>
										<?php
										}
										else
										{
										?>
										<td>
											<a class="btn btn-secondary" href="chapter-overview.php?follow-chapter=<?= $id ?>" data-toggle="tooltip" title="Follow"><i class="fas fa-eye fa-sm"></i></a>
										</td>					
										<?php	
										}
										?>
									</tr>	
								</table>
								</div>	
							<br />
							<br />

							<div style="font-size: 12px;"><i>Chapter Leaders</i></div>
							<div style="font-size: 10px;">
								<?php
								$sql = "SELECT first_name, last_name FROM employees JOIN chapter_leaders ON employees.company_emp_id = chapter_leaders.company_emp_id WHERE chapter_id='$id'";	
								$result = $mysqli->query($sql);

								if ($result->num_rows == 0) 
								{
									echo "<tr><td colspan='5'>No chapter leaders.</td></tr>";
								}
								else
								{
									while ($employee = $result->fetch_assoc()) 
									{		
										print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $employee['first_name'] . ' ' . $employee['last_name'] . '<br />';
									}
								}


								?>
							</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-7">
				<div class="card">
					<h5 class="card-header bg-primary text-white"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;Upcoming Events</h5>
					<div class="card-body" style="max-height: 450px;">
						<div class="verticalScroll">
							<table class="table table-striped table-sm table-responsive" style="display: table;">
							<?php
								$sql = "SELECT * FROM events WHERE chapter_id='$id' ORDER BY date";
								$result = $mysqli->query($sql);

								echo "<tr>					
										<td><strong>Name</strong></td>
										<td><strong>Date</strong></td>
										<td><strong>Time</strong></td>
										<td><strong>Address</strong></td>
									</tr>";	

								if ($result->num_rows == 0) 
								{
									echo "<tr><td colspan='5'>No upcoming events.</td></tr>";
								}
								else
								{
									while ($event = $result->fetch_assoc()) 
									{		
										$id = $event['chapter_id'];
										$event_id = $event['id'];
										$name = $event['name'];
										$line1 = $event['line1'];
										$line2 = $event['line2'];
										$city = $event['city'];
										$st = $event['state_abbr'];
										$postal = $event['postal'];

										$converted_date = convertDate($event['date']);
										$converted_stime = convertTime($event['start_time']);
										$converted_etime = convertTime($event['end_time']);

										print "<tr id='$id'>

													<td><a href='../events/event-detail-map.php?event=$event_id'>$name </a></td>
													<td>$converted_date</td>
													<td>$converted_stime - $converted_etime</td>
													<td>$line1<br/>$line2<br/>$city, $st $postal</td>
												</tr>";
									}
								}

									//$mysqli->close();
							?>
							</table>
						</div>
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