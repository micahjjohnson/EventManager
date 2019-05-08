<?php 

	require_once __DIR__ . '/../db_connect.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-type: text/csv');
	header('Content-Disposition: attachment; filename="MasterEventList.csv"');
	 
	// do not cache the file
	header('Pragma: no-cache');
	header('Expires: 0');
	 
	// create a file pointer connected to the output stream
	$file = fopen('php://output', 'w');
	 
	// send the column headers
	fputcsv($file, array('Event Name', 'Chapter', 'Event Date'));
	 
	 //query the database
	$query = 'SELECT events.name AS "event name", chapters.name AS "Chapter", events.date AS "Date"
					FROM events
					INNER JOIN chapters
					ON events.chapter_id = chapters.id;';
						 
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