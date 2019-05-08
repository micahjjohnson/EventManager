<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
?>
<div class="table1">
<div class="card">
  <h5 class="card-header bg-primary text-white">All BRG Chapters</h5>
  <div class="card-body">
    <table class="table table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">Chapter Name</th>
							<th scope="col">Chapter Short Name</th>
							<th scope="col">Chapter Description</th>
						</tr>
					</thead>
					<tbody>    
					<?php
					$sql = "SELECT * FROM chapters";
					$result = $mysqli->query($sql);

					if ($result->num_rows == 0) 
					{
						echo "<tr><td colspan='1'>No chapters found.</td></tr>";
					}
					else
					{		
						while ($chapter = $result->fetch_assoc())
						{
							$chapter_id = $chapter['id'];
							$name = $chapter['name'];
							$short_name = $chapter['short_name'];
							$description = $chapter['description'];

							echo "<tr id='.$chapter_id.' scope='row'>";
							echo '<td><a href="chapter-overview.php?chapter='. $chapter_id .'">' . $name . '</a></td>';
							echo '<td>'.$short_name.'</td>';
							echo '<td>'.$description.'</td>';
							echo "</tr>";
							
						}
					}
					?>
					</tbody>
</table>
</div>
</div>
</div>
  
<?php
} // authorized
include '../master/footer.php'; 
?>
