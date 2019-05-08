<?php 

	require_once __DIR__ . '/../db_connect.php';

	// output headers so that the file is downloaded rather than displayed
	header('Content-type: text/csv');
	header('Content-Disposition: attachment; filename="EventCoordinatorList.csv"');
	 
	// do not cache the file
	header('Pragma: no-cache');
	header('Expires: 0');
	 
	// create a file pointer connected to the output stream
	$file = fopen('php://output', 'w');
	 
	// send the column headers
	fputcsv($file, array('Event Name', 'Coordinator Last Name', 'First Name',  'Email', 'Company ID'));
	 
	 //query the database
	$query = 'SELECT events.name AS "event name", employees.last_name AS "Last", employees.first_name AS "First", employees.email AS "Email", employees.company_emp_id AS "Company ID"
					FROM events
					INNER JOIN employees
					ON events.coordinator_employee_id = employees.id';
						 
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