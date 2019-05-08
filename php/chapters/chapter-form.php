<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 
//include '../master/session.php'; 

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
	$id = "";
	$name = "";
	$description = "";
	$short_name="";

	if (isset($_POST['insert-chapter']) || isset($_POST['update-chapter']))
	{
		if(isset($_POST['update-chapter']))
		{
			$name = $_POST['chapter_name'];
			$description = $_POST['description'];
			$id = $_POST['chapterid'];
			$short_name = $_POST['short_name'];

			$sql = 'UPDATE chapters SET name="'.$name.'", short_name="'.$short_name.'", description="'.$description.'" WHERE id="'.$id.'"';
			$result = $mysqli->query($sql);

			if (!$result)  
			{
				echo "Sorry, the website is experiencing problems.";
				print '<div id="snackbarFail">Something Went Wrong!</div>';
				exit;
			}
			else
			{
				print '<div id="snackbar">Chapter updated</div>';
			}
		}
		else
		{
			$name = $_POST['chapter_name'];
			$description = $_POST['description'];
			$id = "0";
			$short_name = $_POST['short_name'];

			$sql = 'INSERT INTO chapters (name, short_name, description) VALUES ("'.$name.'", "'.$short_name.'", "'.$description.'"); ';

			$result = $mysqli->query($sql);

			if ($result === TRUE) {
				$last_id = $mysqli->insert_id;
				print '<div id="snackbar">Chapter ID ' . $last_id . ' added</div>';
			} 
			else {
				echo "Error: " . $sql . "<br>" . $conn->error;
				print '<div id="snackbarFail">Something Went Wrong!</div>';
			}
		}
	}
?>

<a class="btn btn-secondary" href="javascript:history.go(-1)"><i class='fas fa-chevron-left'></i>&nbsp;&nbsp;Back</a><br/><br/>

<?php
	if(isset($_GET['chapter']))
	{
		$id = $_GET['chapter'];	
		$sql = "SELECT * FROM chapters WHERE ID='$id'";
		$result = $mysqli->query($sql);

		if (!$result) 
		{
			echo "Sorry, the website is experiencing problems.";
			exit;
		}

		while ($chapter = $result->fetch_assoc())
		{
			$name = $chapter['name'];
			$description = $chapter['description'];
			$short_name = $chapter['short_name'];
		}

		print '<h5>Editing Chapter ID:' . $id . '</h5>';
	} 
	else
	{
		$id = "";
		$name = "";
		$description = "";
		$short_name = "";
	}
?>
<?php
$mysqli->close();
?>
	<div class="card">
	<h6 class="card-header"><i class='fas fa-th-list'></i>&nbsp;&nbsp;Enter Chapter details</h6>
	<div class="card-body">
		<form method="POST" action="">
			<div class="form-group">
				<label for="inputName">Chapter Name</label><span class="required">&nbsp;*</span>
				<input type="text" name="chapter_name" class="form-control" id="inputName" value="<?= $name ?>" required>
			</div>
			<div class="form-group">
				<label for="inputShortName">Short Name</label><span class="required">&nbsp;*</span>
				<input type="text" name="short_name" class="form-control" id="inputShortName" value="<?= $short_name ?>" required>
			</div>
			<div class="form-group">
				<label for="inputDescrip">Description</label>
				<textarea rows="4" cols="50" class="form-control" id="description" name="description"><?= $description ?></textarea>
			</div>

			<div class="float-right col-md-3">
				<button type='submit' class='btn btn-primary' title='Save'>
					Submit
				</button>
				<a href="main.php" class="btn btn-secondary">Cancel</a>
			</div>

			<?php
				if(isset($_GET['chapter']))
				{
					echo '<input type="hidden" name="update-chapter" >';
					echo '<input type="hidden" name="chapterid" value=' . $id . ' >';
				}
				else{
					echo '<input type="hidden" name="insert-chapter" >';
				}
			?>
		</form>
	</div>
	</div>
<?php
} // authorized

include '../master/footer.php';?>