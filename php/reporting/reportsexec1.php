<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);

require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

if (!isAuthorized(PRMG))
{
	include_once '../unauthorized.php';
}
else // authorized
{
	$sqlEmployeeCount = "SELECT COUNT(*) FROM employees";

	$sqlUniqueAttendeeCount = "SELECT count(DISTINCT event_attendance.company_emp_id)
	FROM event_attendance
	INNER JOIN employees 
	ON event_attendance.company_emp_id = employees.company_emp_id COLLATE utf8_unicode_ci";

	$sqlNumberOfEvents = "SELECT COUNT(*) FROM events";

	$sqlEventExpenses = "SELECT SUM(total) FROM event_expenses";

	$sqlTotalApprovedVTOHours = "SELECT SUM(hours) FROM volunteer_submissions WHERE status='accepted'";

	if  ((!$result1 = $mysqli->query($sqlEmployeeCount)) ||
		 (!$result2 = $mysqli->query($sqlUniqueAttendeeCount)) ||
		 (!$result3 = $mysqli->query($sqlNumberOfEvents)) ||
		 (!$result4 = $mysqli->query($sqlEventExpenses)) ||
		 (!$result5 = $mysqli->query($sqlTotalApprovedVTOHours)))
	 {
		//echo "Error: " . $sql . "<br>" . $conn->error;
		echo "Sorry, the website is experiencing problems.";
		//exit;
	 }
?>

<h5 class="card-header bg-primary text-white">
	<i class="fas fa-table"></i>&nbsp;&nbsp; Executive Dashboard
</h5>

<br/>

<div class="row">
	<div class="col-md-6">
		<div class="card text-white  text-center bg-primary mb-4" >
			<div class="card-body">
			<h3 class="card-title text-center"><b>

			<?php
				if ($result1->num_rows === 0){
					echo "Sorry, the website is experiencing problems.";
					exit;
				} 
				else{
					$row1 = mysqli_fetch_array($result1);
					echo $row1[0];
				}

			?>

			</b>
			</h3>
			<p class="card-text"># of Employees</p>
			</div>
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="card text-white text-center bg-primary mb-5">
			<div class="card-body">
				<h3 class="card-title"><b>

				<?php
					if ($result5->num_rows === 0){
						echo "Sorry, the website is experiencing problems.";
						exit;
					} 
					else{
						$row5 = mysqli_fetch_array($result5);
						echo $row5[0];
					}

				?>

				</b>
				</h3>
				<p class="card-text"># Approved VTO Hours</p>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-4">
		<div class="card text-white text-center bg-primary mb-4">
			<div class="card-body">
			<h3 class="card-title"><b>

			<?php
				if ($result3->num_rows === 0){
					echo "Sorry, the website is experiencing problems.";
					exit;
				} 
				else{
					$row3 = mysqli_fetch_array($result3);
					echo $row3[0];
				}

			?>

			</b>
			</h3>
			<p class="card-text"># of BRG Events</p>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="card text-white text-center bg-primary mb-4">
			<div class="card-body">
			<h3 class="card-title"><b>

			<?php
				if ($result2->num_rows === 0){
					echo "Sorry, the website is experiencing problems.";
					exit;
				} 
				else{
					$row2 = mysqli_fetch_array($result2);
					echo $row2[0];
				}

			?>

			</b>
			</h3>
			<p class="card-text"># of Unique Event Attendees</p>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="card text-white text-center bg-success mb-5" >
			<div class="card-body">
				<h3 class="card-title"><b>

				<?php
					if ($result4->num_rows === 0){
						echo "Sorry, the website is experiencing problems.";
						exit;
					} 
					else{
						$row4 = mysqli_fetch_array($result4);
						setlocale(LC_MONETARY, 'en_US');
						echo money_format('%(#10n', $row4[0]);
					}

				?>

				</b>
				</h3>
				<p class="card-text">Event Expenses Total</p>
			</div>
		</div>

	</div>
</div>

<hr style="margin:2em;">

<h5 class="card-header bg-primary text-white">
	<i class="fas fa-table"></i>&nbsp;&nbsp; Downloadable Reports
</h5>
<div class="row">
	<div class="col-sm-12">
		<table class="table">
		  <thead>
			<tr>
			  <th scope="col">Report Name</th>
			  <th scope="col">Description</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row"><a href="/reporting/report1.php" target="_blank">BRG Chapter Event Report</a></th>
			  <td>Listing of all chapters, their event count, and total expenses.</td>
			</tr>
			<tr>
			  <th scope="row"><a href="/reporting/report2.php" target="_blank">BRG Event Coordinator Contact Report</a></th>
			  <td>Listing of all events and their coordinators with contact info.</td>
			</tr>
			<tr>
			  <th scope="row"><a href="/reporting/report3.php" target="_blank">BRG Master Event List</a></th>
			  <td>Listing of all events.</td>
			</tr>
		  </tbody>
		</table>
	</div>
</div>



<?php

} // authorized 

include '../master/footer.php'; ?>