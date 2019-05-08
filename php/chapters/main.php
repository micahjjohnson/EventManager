<?php
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php';

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	if (isset($_POST['delete-chapter'])) {
		$delete_id = $_POST['delete-chapter'];

		$sql = "DELETE FROM chapters WHERE id='$delete_id'";
		$result = $mysqli->query($sql);

		print '<div id="snackbar">Chapter deleted</div>';
	} 
	?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="" method="POST">
				<div class="card">
					<h5 class="card-header bg-primary text-white"><i class="fas fa-users"></i>&nbsp;&nbsp;Manage Chapters</h5>
					<div class="card-body">
						<a href="chapter-form.php" class = "btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add New Chapter</a><br/><br/>
						<table class="table table-striped table-sm table-responsive" style="display: table;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Name</th>
								<th>Short Name</td>
								<th>Description</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<?php
						$sql = "SELECT * FROM chapters";

						if (!$result = $mysqli->query($sql))
						{
							echo "Sorry, the website is experiencing problems.";
							exit;
						}

						if ($result->num_rows === 0) 
						{
							echo "<tr>
									<td colspan='3'>No results found.</td>
									</tr>";
							exit;
						} 
						else 
						{
							while ($chapter = $result->fetch_assoc()) 
							{
								$id = $chapter['id'];
								$name = $chapter['name'];
								$short_name = $chapter['short_name'];
								$description = $chapter['description'];

								echo "<tr id='$id'>
										<td>$id</td>
										<td><a href='chapter-home.php?chapter=". $id ."'>$name</a></td>
										<td>$short_name</td>
										<td>$description</td>
										<td>
											<a style='padding:2px 8px 4px 8px;' href='chapter-form.php?chapter=" . $id . "' data-toggle='tooltip' title='Edit' class='btn btn-success'><i class='fas fa-edit fa-xs'></i></a>
										</td>
										<td>
											<form action='' method='POST'>
												<input type='hidden' name='delete-chapter' value='$id'/>
												<button style='padding:2px 8px 4px 8px;' type='submit' data-toggle='tooltip' title='Delete' class='btn btn-danger' name='submit-btn' onclick=\"javascript: return confirm('Are you sure you want to delete?');\" >
													<i class='fas fa-trash fa-xs'></i>
												</button>
											</form>
										</td>
									</tr>";
							}
						}
						?>
						</table>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php 
} // authorized

include '../master/footer.php';?>
