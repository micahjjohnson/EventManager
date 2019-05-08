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

	if(isset($_POST['save-expense']))
	{	
		$expense_name = $_POST['expense_name'];
		$expense_date = $_POST['expense_date'];
		$expense_description = $_POST['expense_description'];
		$event_id = $_POST['event_id'];
		$expense_total = $_POST['expense_total'];
		
		$sql = "INSERT INTO event_expenses (expense_name, expense_date, description, event_id, total) 
		        VALUES ('$expense_name', '$expense_date', '$expense_description', '$event_id', '$expense_total' )";
		
		$result = $mysqli->query($sql);
		
		print '<div id="snackbar">Expense Saved</div>';
	}

	if(isset($_POST['delete-expense']))
	{
		$delete_id = $_POST['delete-expense'];
		$sql = "DELETE FROM event_expenses WHERE id='$delete_id'";
		$result = $mysqli->query($sql);
		print '<div id="snackbar">Expense Deleted</div>';
	}	

	if(isset($_POST['save-expense'])) // If user came from New Expense page
	{	
		$id = $event_id;
	}
	else if(isset($_POST['delete-expense'])) // If user came delete POST back
	{	
		$id = $_GET['event'];	
	}
	else // Fresh event loaded from overview
	{
		$id = $_GET['event'];	
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
		$status = $event['status_id'];
			
		$converted_date = convertDate($event['date']);
		$converted_stime = convertTime($start_time);
		$converted_etime = convertTime($end_time);

		$chap_sql = "SELECT name FROM chapters WHERE ID='$chapter_id'";
		$chap_result = $mysqli->query($chap_sql);
		$chapter = $chap_result->fetch_assoc();
		$chapter_name = $chapter['name'];
	}
?>


<div class="row">
	<div class="col">
		<div class="float-left">
			<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a>
		</div>
	</div>
	<div class="col">
		<div class="float-right">
			<table>
				<tr>
					<?php
					if ($status == 0)
					{
					?>
					<td>
						<form action='' method='POST'>
							<input type='hidden' name='submit-event' value='<?= $id ?>'/>
							<button type='submit' class='btn btn-success' name='submit-btn' ><i class="fas fa-share-square"></i>&nbsp;Submit for Approval
							</button>
						</form>
					</td>
					<?php
					}
					else if ($status == 1)
					{
					?>
					<td>
						<form action='' method='POST'>
							<button type='submit' class='btn btn-success' name='submit-btn' disabled>Submitted
							</button>
						</form>
					</td>					
					<?php	
					}
					if ($user_role == PRMG && $status == 1) // only show if is submitted
					{
					?>
					<td>
						<form action='' method='POST'>
							<input type='hidden' name='accept-event' value='<?= $id ?>'/>
							<button type='submit' class='btn btn-success' name='submit-btn' ><i class='fa fa-check-circle'></i>
							</button>
						</form>
					</td>
					<td>
						<form action='' method='POST'>
							<input type='hidden' name='reject-event' value='<?= $id ?>'/>
							<button type='submit' class='btn btn-danger' name='submit-btn' onclick='javascript: return confirm('Confirm delete');' ><i class='fa fa-times-circle'></i>
							</button>
						</form>
					</td>
					<?php
					}
					else if ($status == 2)
					{
					?>
						<form action='' method='POST'>
							<button type='submit' class='btn btn-success' name='submit-btn' disabled>Accepted
							</button>
						</form>					
					<?php
					}
					else if ($status == 3)
					{
					?>
						<form action='' method='POST'>
							<button type='submit' class='btn btn-danger' name='submit-btn' disabled>Rejected
							</button>
						</form>						
					<?php
					}
					?>
				</tr>		
			</table>
		</div>
	</div>
</div>
</br>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<form action="" method="POST">
					<div class="card">
						<h5 class="card-header bg-primary text-white"><i class='fas fa-clipboard-list'></i>&nbsp;&nbsp;Event Details</h5>
						<div class="card-body">
							<table class="table table-striped table-sm table-responsive" style="display: table;">
								<tr>
										<td><strong>Chapter</strong></td>
										<td><a href='../chapters/chapter-home.php?chapter=<?= $chapter_id ?>'><?= $chapter_name ?></td>
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
										<td><strong>Name</strong></td>
										<td><?= $name ?></td>
								</tr>
								<tr>
										<td><strong>Description</strong></td>
										<td><?= $description ?></td>
								</tr>
								<tr>
										<td><strong>Address 1</strong></td>
										<td><?= $line1 ?></td>
								</tr>
								<tr>
										<td><strong>Address 2</strong></td>
										<td><?= $line2 ?></td>
								</tr>
								<tr>
										<td><strong>City</strong></td>
										<td><?= $city ?></td>
								</tr>
								<tr>
										<td><strong>State</strong></td>
										<td><?= $state_abbr ?></td>
								</tr>
								<tr>
										<td><strong>ZIP</strong></td>
										<td><?=  $postal ?></td>
								</tr>
							</table>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<div class="card">
					<h5 class="card-header bg-primary text-white"><i class='fas fa-file-invoice-dollar'></i>&nbsp;&nbsp;Event Expenses</h5>
					<div class="card-body">
						<div class="tight-verticalScroll" style="height:250px;">			
							<a class="btn btn-success" href="expense-form.php?eid=<?=$id?>"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Event Expense</a><br/><br/>
							<table class="table table-striped table-responsive smallFont">
							<?php
								$expense_sum = 0;
								$sql = "SELECT * FROM event_expenses WHERE event_id='$id'";
								$result = $mysqli->query($sql);

								if ($result->num_rows == 0) 
								{
									echo "No expenses found.";
								}
								else
								{
									echo "<tr>					
											<td><strong>Date</strong></td>
											<td><strong>Name</strong></td>
											<td><strong>Description</strong></td>
											<td><strong>Amount</strong></td>
											<td></td>
										</tr>";	

									while ($expenses = $result->fetch_assoc()) 
									{		
										$expense_id = $expenses['id'];
										$event_id = $expenses['event_id'];
										$name = $expenses['expense_name'];
										$expense_total = $expenses['total'];
										$expense_description = $expenses['description'];

										$converted_date = date('m/d/Y', strtotime($expenses['expense_date']));

										print "<tr id='$id'>

													<td>$converted_date</td>
													<td>$name</td>
													<td>$expense_description</td>
													<td>$expense_total</td>
													<td>
														<form action='event-overview.php?event=$id' method='POST'>
															<input type='hidden' name='delete-expense' value='$expense_id'/>
															<button type='submit' data-toggle='tooltip' title='Delete' class='btn btn-danger' name='submit-btn' onclick='javascript: return confirm('Confirm delete');' >
																<i class='fas fa-trash'></i>
															</button>
														</form>
													</td>
												</tr>";

										$expense_sum += $expense_total;
									}
							?>
								<tfoot>
									<td colspan="3"><b>Total</b></td>
									<td>$&nbsp;<?= $expense_sum ?></td>
									<td></td>
								</tfoot>
							<?php

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

<?php
} // authorized

include '../master/footer.php';?>