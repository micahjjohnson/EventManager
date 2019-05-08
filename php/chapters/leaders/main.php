<?php
$chapter_select_text = 'Select chapter...';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db_connect.php';
include_once '../../master/header.php';

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['delete-chapter-leader'])) 
	{
		$delete_id = $_POST['delete-chapter-leader'];
		$chapter_id = $_POST['chapter_id'];

		$sql = "DELETE FROM chapter_leaders WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Chapter leader deleted</div>';

		//$_POST = 'refresh-chapter';
	} 

	if (isset($_POST['new-chapter-leader'])) 
	{
		$chapter_id = $_POST['new-chapter-leader'];
		$company_emp_id = $_POST['employee_id'];

		$sql = "SELECT id FROM employees WHERE company_emp_id='$company_emp_id'";

		$result = $mysqli->query($sql);

		//echo $mysqli->error ;
		if ($result->num_rows === 0) 
		{
			print '<div id="snackbar">Employee not found</div>';
		} 
		else 
		{
			//check for duplicates

			// employee is verified so the leader can be created
			$sql2 = "INSERT into chapter_leaders (company_emp_id, chapter_id) VALUES ('$company_emp_id', '$chapter_id') ";

			$result2 = $mysqli->query($sql2);	
			
			/* SET UP ROLE FOR NEW PERSON */

			print '<div id="snackbar">Chapter leader created</div>';
		}
	} 

	if (isset($_POST['refresh-chapter'])) 
	{
		$chapter_id = $_POST['chapter'];
		//echo $chapter_id;
	} 

	if ($_SERVER['REQUEST_METHOD'] === 'GET')
	{
		$chapter_id = -9999;
	}
?>
<h5 class="card-header bg-primary text-white"><i class="fas fa-users"></i>&nbsp;&nbsp;Manage Chapter Leaders</h5>
<div class="container">
	<div class="card-body">
		<div class="row">
			<div class="col-md-7">
				<div class="card">
					<div class="card-body">
						<form action="" method="POST">
							<div class="form-row">
								<div class="form-group col-md-4">
									Chapter
								</div>
								<div class="form-group col-md-7">
									<select name='chapter' class="form-control" onchange="this.form.submit()">
										<option><?= $chapter_select_text ?></option>	
										<?php
										$sql = "SELECT * FROM chapters";

										$result = $mysqli->query($sql);

										if ($result->num_rows === 0) 
										{
											echo '<option>No results found.</option>';
											//exit;
										} 

										while ($chapter = $result->fetch_assoc())
										{
											$id = $chapter['id'];
											$chapter_name = $chapter['name'];

											if ($id == $chapter_id)
												echo '<option value='. $id .' selected>'. $chapter_name .'</option>';
											else
												echo '<option value='. $id .'>'. $chapter_name .'</option>';
										}
										?>
									</select>
									<input type="hidden" name="refresh-chapter" value=""/>
								</div>	
							</div>	
						</form>	
					</div>
				</div>
			</div>
			<br />
			<br />
			
		<?php
	// TODO Fix table styling issue
	// BEGIN BLOCK
		{
		if($chapter_id != -9999)
		{
		?>
		<div class="col-md-5">
			<div class="card">
				<h6 class="card-header"><i class="fas fa-users"></i>&nbsp;&nbsp;Chapter Leaders</h6>
					<div class="card-body">
						<form action="" method="POST">
							<div class="form-row">
								<div class="form-group col-md-8">
									<input type="text" class="form-control" name="employee_id" placeholder="Employee ID">
									<input type="hidden" name="new-chapter-leader" value="<?= $chapter_id ?>">
								</div>
								<div class="form-group col-md-2">
									<input class="btn btn-primary" type="submit" >
								</div>
							</div>
						</form>	
						<form action="" method="POST">
							<table  class="table table-striped table-responsive">
								<th scope="col">ID</th>
								<th scope="col">Name</th>
								<th scope="col"></th>
								<?php
								$sql = "SELECT * FROM chapter_leaders WHERE chapter_id='$chapter_id'";

								$result = $mysqli->query($sql);

								if ($result->num_rows === 0) 
								{
									echo '<tr><td colspan="3">No current chapter leaders.</td></tr>';
									//exit;
								} 

								while ($leader = $result->fetch_assoc())
								{
									$id = $leader['id'];
									$company_emp_id = $leader['company_emp_id'];
									$active = $leader['active'];

									if ($active == 1) // yes
									{
										$sql2 = "SELECT id, first_name, last_name FROM employees WHERE company_emp_id='$company_emp_id'";

										$result2 = $mysqli->query($sql2);

										while ($employee = $result2->fetch_assoc())
										{				
											$first_name = $employee['first_name'];
											$last_name = $employee['last_name'];

											$name = $first_name . ' ' . $last_name;

											echo '<tr>
													<td>' . $company_emp_id . '</td>';
											echo '	<td>' . $name . '</td>';
											echo '	<td>
													<form action="" method="POST">
														<input type="hidden" name="chapter_id" value="' . $chapter_id . '"/>
														<input type="hidden" name="delete-chapter-leader" value="' . $id . '"/>
														<button type="submit" data-toggle="tooltip" title="Delete" class="btn btn-danger"name="submit-btn" onclick=\"javascript: return confirm("Are you sure you want to delete?");\" >
															<i class="fas fa-trash fa-xs"></i>
														</button>
													</form>
													</td>
												</tr>';
										}

									}
								}
								//$mysqli->close();
								?>
							</table>
						</form>	
					</div>
				</div>
			</div>	

		</div>
	</div>
</div>
	<?php
			}
		// END BLOCK
		}
} // authorized

include '../../master/footer.php';?>