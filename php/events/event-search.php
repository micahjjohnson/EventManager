<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire');

require_once __DIR__ . '/../db_connect.php';
include_once '../master/header.php';

if (!isAuthorized(EMP))
{
	include_once '../unauthorized.php';
}
else // authorized
{
?>	
<h5 class="card-header bg-primary text-white"><i class="fas fa-search"></i>&nbsp;&nbsp;Search</h5>

	<div class="card-body">
		<form method="POST" action="">	
			<div class="form-row">
				<div class="form-group col-md-7">
					<input type="text" name="search_text" class="form-control" id="searchText" placeholder="Search" required>
				</div>
				<div class="form-group col-md-2">
					<input type="hidden" name="search" >
					<button type='submit' class='btn btn-success' name=''>
						<i class='fa fa-search'></i> Search
					</button>
				</div>			
				<div class="form-group col-md-3">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="chapter-filter" value="YES" id="defaultCheck2" >
						<label class="form-check-label" for="defaultCheck2" style="font-size: 13px;">
						Include Chapters
						</label>
					</div>	
				</div>
			</div>
		</form>
		<br /><hr>
	</div>	
	<?php
	if (isset($_POST['search']))
	{
		$query = $_POST['search_text'];
		$filter_chapters = $_POST['chapter-filter'];
		$chapterSearch = false;
		
		$query = trim($query);
		
		if ($filter_chapters == 'YES')
		{
			$chapterSearch = true;
			$sql = "SELECT * FROM chapters WHERE name LIKE '%{$query}%' OR description LIKE '%{$query}%' ";	
		}
		else
		{
			$sql = "SELECT * FROM events WHERE status_id='2' AND name LIKE '%{$query}%' OR description LIKE '%{$query}%' ";
		}

		$result = $mysqli->query($sql);		
		
		print '<div class="table1">
				<div class="card">
				<div class="card-body">
				';

		if ($result->num_rows == 0) 
		{
			echo "No results found.";
		}
		else
		{
			print '<table class="table table-striped table-hover">';
			
			if ($chapterSearch)
			{
				while ($chapters = $result->fetch_assoc())
				{
					$id = $chapters['id'];
					$name = $chapters['name'];
					$description = $chapters['description'];
					$short_name = $chapters['short_name'];
					
					print '	  			
						<tr>
							<td>
								<a href="../chapters/chapter-overview.php?chapter=' . $id . '">' . $name . '</a>
							</td>
							<td>
							'. $description .'
							</td>
						</tr>';	  	
				}
			}
			else 
			{
				while ($events = $result->fetch_assoc())
				{
					$id = $events['id'];
					$name = $events['name'];
					$date = $events['date'];
					$start_time = $events['start_time'];
					$end_time = $events['end_time'];
					$description = $events['description'];

					$converted_date = convertDate($date);
					$converted_stime = convertTime($start_time);
					$converted_etime = convertTime($end_time);

					print '	  			
						<tr>
							<td>
								<a href="event-detail-map.php?event=' . $id . '">' . $name . '</a>

							</td>
							<td>
								'.$converted_date.',
								'. $converted_stime .'				
								-
								'. $converted_etime .'	
							</td>
							<td>
								'. $description .'
							</td>
						</tr>';	  			
				}	
			}
			print '</table>';
		}
					
		print '
				</div>
				</div>
				</div>';
	}

} // authorized

include '../master/footer.php'; ?>
