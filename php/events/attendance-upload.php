<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 
include_once '../master/session.php'; 

if (!isAuthorized(EMP))
{
	$mysqli->close();
	include_once '../unauthorized.php';
}
else // authorized
{
    //https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/

    if(isset($_POST["Import"])){
		
        $filename=$_FILES["file"]["tmp_name"];		

        if($_FILES["file"]["size"] > 0)
        {
            $incr = 0;
            $attendeesadded = 0;

            $file = fopen($filename, "r");
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                $idToAdd = '';

                if($incr != 0) // need to skip the header row
                {
                    $empID = $getData[0];
                    $eventID = $getData[1];
                    
                    // TODO need to track which records had issues saving and show that to the user

                    $sql1 = 'SELECT * FROM employee WHERE company_emp_id ="'. $empID .'"; ';
                    $result = $mysqli->query($sql1);

                    while ($event = $result->fetch_assoc()) {
                        $idToAdd = $event['id'];
                    }

                    $sql = 'INSERT INTO event_attendance (employeeid, eventid) SELECT * FROM (SELECT "'.$idToAdd.'",  "'.$eventID.'") AS tmp WHERE NOT EXISTS ( SELECT employeeid FROM event_attendance WHERE employeeid = "'.$idToAdd.'" AND eventid = "'.$eventID.'" ) LIMIT 1; ';
                    $result = $mysqli->query($sql);
                    
                    if(isset($result))
                    {
                        // echo "<script type=\"text/javascript\">
                        // 		alert(\"Invalid File:Please Upload CSV File.\");
                        // 		window.location = \"index.php\"
                        // 	  </script>";	
                        $attendeesadded = $attendeesadded + 1;
                    }
                    else {
                        //   echo "<script type=\"text/javascript\">
                        //             alert(\"CSV File has been successfully Imported.\");
                        //             window.location = \"..\main.php\"
                        //        </script>";
                    }
                }
                $incr = $incr + 1;
            }
        
            fclose($file);	
            print '<div id="snackbar">' .$attendeesadded . ' records processed</div>';
        }
	}	 
 ?>

	<form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				<div class="card" style="width: 36rem;">
					<h5 class="card-header bg-primary text-white">Import Attendees</h5>
					<div class="card-body">
						<div class="row">
							<!-- File Button -->
							<div class="form-group col">
								<label class="control-label" for="filebox" ><strong>Select File</strong></label>
								<input type="file" name="file" id="filebox" class="input-large">
							</div>

							<!-- Button -->
							<div class="form-group col">
								<label class="control-label"></label>
								<div>
									<button type="submit" id="submit" name="Import" 
										class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
								</div>
							</div>
						</div>
						<br/>
						<div class="row">
							<div class="form-group col">
								<ul>
									<li>CSV format only.</li>
									<li>CSV file must include the header row.</li>
									<li>Template file: <a href="AttendanceTemplate.csv">click to download</a></li>
									<li>Sample file: <a href="AttendanceSample.csv">click to download</a></li>
									<li>To save as CSV in Excel, go to File -> Save As -> click on "Save As Type" and choose CSV.  See picture.
								</ul>
							</div>
						</div>
					</div>
				</div>  
			</div>
			<div class="col-1"> 
			</div>  
			<div class="col-md-5">
				<img src="../assets/images/excel.png" width="500" height="407" alt="excel screenshot">  
			</div>  
		</div>
	</form>
<?php
} // authorized

include '../master/footer.php'; ?>
