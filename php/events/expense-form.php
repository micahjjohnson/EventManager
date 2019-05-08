<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php';


if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if(isset($_GET['eid']))
	{
		$id = $_GET['eid'];
	}

	$expense_name="";
	$expense_date="";
	$expense_total="";
	$expense_date="";
	$expense_description="";
?>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/><br/>
	<form action="event-overview.php" method="POST">
		<div class="card">
			<h5 class="card-header">Add Event Expense</h5>
			<div class="card-body">
				<form>
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="inputId">Event ID</label>
							<input type="text" class="form-control" id="inputId" name="event_id" value="<?= $id ?>" readonly>
						</div>
						<div class="form-group col-md-4">
							<label for="inputAmount">Amount</label>
							<input type="text" class="form-control" id="inputAmount" maxlength="10" name="expense_total" value="<?= $expense_total ?>" required >
						</div>
						<div class="form-group col-md-3">
							<label for="inputAmount">Date</label>
							<input type="date" class="form-control" id="inputDate" maxlength="10" name="expense_date" value="<?= $expense_date ?>" required >
						</div>
					</div>
					<div class="form-group">
							<label for="inputExpName">Expense Name</label>
							<input type="text" id="inputExpName" class="form-control" name="expense_name" value="<?= $expense_name ?>" required >
					</div>
					<div class="form-group">
							<label for="inputDesc">Description</label>
							<textarea id="inputDesc" class="form-control" name="expense_description" placeholder=><?= $expense_description ?></textarea>
					</div>
					<a href="main.php" class="btn btn-secondary">Cancel</a>
					<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</button>
					<input type="hidden" name="save-expense">
				</form>
			</div>
		</div>
	</form>
<?php
} // authorized

include '../master/footer.php';?>