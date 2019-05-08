<?php
require_once __DIR__ . '/../db_connect.php';
include '../master/header.php'; 

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
            $activeemployeesadded = 0;
            $file = fopen($filename, "r");

            $sql1 = "                       
            UPDATE employee 
            SET active = 0;";

            $result1 = $mysqli->query($sql1);

            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                if($incr != 0) // need to skip the header row
                {
                    $compempID = $getData[0];
                    $first = $getData[1];
                    $last  = $getData[2];
                    $title = $getData[3];
                    
                    // TODO: better error handling here
                    // TODO: need to track which records had issues saving and show that to the user
                    $sql = 'UPDATE employee SET first_name =  "'.$first.'", last_name = "'.$last.'", title = "'.$title.'", active=1 WHERE company_emp_id = "'.$compempID.'";';
                    $result = $mysqli->query($sql);

                    $sql = 'INSERT INTO employee (company_emp_id, first_name, last_name, title) SELECT * FROM (SELECT "'.$compempID.'",  "'.$first.'",  "'.$last.'", "'.$title.'") AS tmp WHERE NOT EXISTS ( SELECT company_emp_id FROM employee WHERE company_emp_id = "'.$compempID.'") LIMIT 1; ';
                    $result = $mysqli->query($sql);

                    
                    if(isset($result))
                    {
                        // echo "<script type=\"text/javascript\">
                        // 		alert(\"Invalid File:Please Upload CSV File.\");
                        // 		window.location = \"index.php\"
                        // 	  </script>";	
                        $activeemployeesadded = $activeemployeesadded + 1;
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
            print '<div id="snackbar">' .$activeemployeesadded . ' records processed</div>';
        }
	}	 
 ?>

	<form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
		<div class="row">
			<div class="col-6">
				<div class="card" style="width: 36rem;">
					<h5 class="card-header bg-primary text-white">Import Bulk List of Active Employees</h5>
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
									<li>Template file: <a href="EmployeeTemplate.csv">click to download</a></li>
									<li>Sample file: <a href="EmployeeSample.csv">click to download</a></li>
									<li>To save as CSV in Excel, go to File -> Save As -> click on "Save As Type" and choose CSV.  See picture.
								</ul>
							</div>
						</div>
					</div>
				</div>  
			</div>
			<div class="col-1"> 
			</div>  
			<div class="col-5">
				<img src="../assets/images/excel.png" width="500" height="407" alt="excel screenshot">  
			</div>  
		</div>
	</form>
<?php
} // authorized

include '../master/footer.php'; ?>