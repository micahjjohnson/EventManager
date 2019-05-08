<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);
require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php'; 

if (!isAuthorized(CHL))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
?>
<div class="table1">
<div class="card">
  <h5 class="card-header bg-primary text-white">Chapters I am Chapter Leader for</h5>
  <div class="card-body">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th scope="col">Chapter Name</th>
        </tr>
    </thead>
    <tbody>    
    <?php
	$sql = "SELECT chapter_id FROM chapter_leaders WHERE company_emp_id='$username' ";
	$result = $mysqli->query($sql);

	if ($result->num_rows == 0) 
	{
		echo "<tr><td colspan='1'>No chapters found.</td></tr>";
	}
	else
	{		
		while ($chapter_leader = $result->fetch_assoc())
		{
			$chapter_id = $chapter_leader['chapter_id'];
			
			$sql2 = "SELECT id, name FROM chapters WHERE id='$chapter_id' ";
			
			$result2 = $mysqli->query($sql2);
						
			if ($result2->num_rows != 0) 
			{
				$found_chapter = $result2->fetch_assoc();
				
				$id = $found_chapter['id'];
				$name = $found_chapter['name'];

				echo "<tr scope='row'>";
				echo '<td><a href="chapter-home.php?chapter='. $id .'">' . $name . '</a></td>';
				echo "</tr>";
			}
		}

		// New page- My Chaps List - new sql to get chaps by emp id
		// Make chapter names into Links to My Chap page, with query string
	}
	?>
</tbody>
</table>
</div>
</div>
</div>
<br/>

<?php
} // authorized
include '../master/footer.php'; 
?>