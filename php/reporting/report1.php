<?php 

	require_once __DIR__ . '/../db_connect.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-type: text/csv');
	header('Content-Disposition: attachment; filename="BrgChapterEventReport.csv"');
	 
	// do not cache the file
	header('Pragma: no-cache');
	header('Expires: 0');
	 
	// create a file pointer connected to the output stream
	$file = fopen('php://output', 'w');
	 
	// send the column headers
	fputcsv($file, array('Chapter', 'Event Count', 'Total Expenses'));
	 
	 //query the database
	$query = 'SELECT chapters.name AS "Chapter Name", COUNT(*) AS "Event Count", coalesce(SUM(event_expenses.total),0) AS "Total Expenses"
				FROM chapters

				LEFT JOIN events
				ON chapters.id = events.chapter_id

				LEFT JOIN event_expenses
				ON events.id = event_expenses.event_id

				GROUP BY chapters.id

				ORDER BY chapters.name;';
	 
	if ($rows = $mysqli->query($query))
	{
		// loop over the rows, outputting them
		while ($row = mysqli_fetch_assoc($rows))
		{
			fputcsv($file, $row);
		}
	}
	
 
	exit();

?>