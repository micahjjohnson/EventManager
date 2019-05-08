<?php
include_once 'session.php'; 
include_once 'functions.php'; 

		// TODO: probably need a better solution to get the domain name, 
		// to enable child pages to always have right links
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$hostnametmp = getenv('HTTP_HOST');
		$hostname = $protocol.$hostnametmp;
?> 
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../favicon.ico">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo($hostname);?>/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo($hostname);?>/assets/css/site.css">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script src="<?php echo($hostname);?>/assets/js/site.js"></script>
   


</head>

<body>
	<nav class="navbar navbar-expand-md navbar-dark bg-secondary text-white fixed-top">

		<div id="logo" style="">
			<a class="navbar-brand" href="/home.php">
				<img id="svg-logo" src="<?php echo($hostname);?>/assets/images/logo.png" alt="">
			</a>
		</div>
		<!--<a class="navbar-brand font-weight-bold" href="/">EBNPortal.com</a>-->
		<?php
		if (!$isLoggedIn)
		{
		?>
		<form class="text-center" action="<?php echo($hostname);?>/login.php" method="post">
			<button class="btn btn-danger font-weight-bold" type="submit">Log In</button>
			<input type="hidden" name="log-in">
		</form>
		<?php
		}
		else
		{
		?>								
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" 
					    aria-haspopup="true" aria-expanded="false">Employee Hub</a>
					<div class="dropdown-menu bg-light" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="<?php echo($hostname);?>/employee/home.php">Home</a>
						<a class="dropdown-item" href="<?php echo($hostname);?>/volunteer_tracking/vto_home.php">My Volunteer Time-Off (VTO)</a>
						<?php
						if (isAuthorized(PRMG))
						{
						?>								
						<hr>
						<a class="dropdown-item" href="<?php echo($hostname);?>/volunteer_tracking/vto_approvals.php">Pending VTO Approvals</a>
						<?php
						}
						?>
					</div>
				</li>
			<?php
			}
			if ($isLoggedIn)
			{
			?>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="dropdown01" data-toggle="dropdown" 
					    aria-haspopup="true" aria-expanded="false">BRG Hub</a>
					<div class="dropdown-menu bg-light" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="<?php echo($hostname);?>/chapters/all.php">All BRG Chapters</a>
						<a class="dropdown-item" href="<?php echo($hostname);?>/events/event-search.php">Search BRG Events & Chapters</a>
					</div>
				</li>
			<?php
			}
			if (isAuthorized(CHL))
			{
			?>								
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="dropdown02" data-toggle="dropdown" 
					    aria-haspopup="true" aria-expanded="false">Chapter Leader</a>
					<div class="dropdown-menu  bg-light" aria-labelledby="dropdown02">
						<a class="dropdown-item" href="<?php echo($hostname);?>/chapters/chapter-list.php">My Chapters</a>
						<hr/>
						<a class="dropdown-item" href="<?php echo($hostname);?>/events/attendance-upload.php">Upload Attendance CSV</a>
					</div>
				</li>
			<?php
			}
			if (isAuthorized(PRMG))
			{
			?>								
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white " href="#" id="dropdown03" data-toggle="dropdown" 
					    aria-haspopup="true" aria-expanded="false">Program Manager</a>
					<div class="dropdown-menu  bg-light" aria-labelledby="dropdown03">
						<a class="dropdown-item" href="<?php echo($hostname);?>/progmgr/home.php">Home</a>
						<hr/>
						<a class="dropdown-item" href="<?php echo($hostname);?>/events/main.php">Event Master List</a>
						<hr />
						<a class="dropdown-item" href="<?php echo($hostname);?>/chapters/main.php">Manage Chapters</a>
						<a class="dropdown-item" href="<?php echo($hostname);?>/chapters/leaders/main.php">Manage Chapter Leaders</a>
						<a class="dropdown-item" href="<?php echo($hostname);?>/progmgr/manage_pm.php">Manage Program Managers</a>
						<a class="dropdown-item" href="<?php echo($hostname);?>/employee/empupload.php">Upload Employees CSV</a>
					</div>
				</li>
			<?php
			}
			if (isAuthorized(PRMG))
			{
			?>								
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white " href="#" id="dropdown03" data-toggle="dropdown" 
					    aria-haspopup="true" aria-expanded="false">Reporting</a>
					<div class="dropdown-menu  bg-light" aria-labelledby="dropdown03">
						<a class="dropdown-item" href="/reporting/reportsexec1.php">Executive Dashboard</a>
					</div>
				</li>
			<?php
			}
			if ($isLoggedIn) // is logged in
			{				
			?>
			</ul>
			<ul class="navbar-nav mr-auto navbar-right">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $user_name ?>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
						<a class="dropdown-item alignctr" href="<?php echo($hostname);?>/admin/account_settings.php">Change Password</a>
						<!--<a class="dropdown-item alignctr" href="#">Help</a>-->
						<div class="dropdown-divider"></div>
						<form class="text-center" action="<?php echo($hostname);?>/logout.php" method="post">
							<button class="btn btn-danger font-weight-bold" type="submit">Log Out</button>
							<input type="hidden" name="log-out">
						</form>
					</div>
				</li>
			</ul>
		</div>
		<?php
		}
		?>

	</nav>

	<main role="main" class="container">