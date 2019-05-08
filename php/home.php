<?php 
//ini_set('display_errors',1); error_reporting(E_ALL);

include_once './master/header.php'; 
include_once './master/session.php'; 
?>

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="assets/images/carousel/stock_2.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/carousel/stock_1.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="assets/images/carousel/stock_3.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  
</div>

<hr style="margin:2em;">
<div class="" style="width: 90%; margin: auto;">
	<div class="row text-center">
		<div class="col-md-4">
			<h5><b>BRG Event Management</b></h5>
			<p style="font-size: 13px;">EBNPortal is your one-stop-shop for creating and managing your BRG chapters and events.</p>
		</div>
		<div class="col-md-4">
			<h5><b>Employee Volunteer Time Tracking</b></h5>
			<p style="font-size: 13px;">EBNPortal gives your employees one simple place to log their volutneer hours, and their managers to review.</p>
		</div>
		<div class="col-md-4">
			<h5><b>Volunteer Hours & Expense Reporting</b></h5>
			<p style="font-size: 13px;">EBNPortal is your single source of truth for volunteer time and expense reporting.</p>
		</div>
	</div>
</div>

<hr style="margin:3em;">

<div class="row featurette">
  <div class="col-md-7">
	<h4 class="featurette-heading">Enterprise Social Responsiblity One-Stop Shop </h4>
	<p class="lead" style="font-size:18px;">The days of tracking volunteer hours and expenses in multiple systems and spreadsheets are gone.  EBNPortal is one system that handles all of your Social Responsiblity goals.</p>
  </div>
  <div class="col-md-5">
	<img class="featurette-image img-fluid mx-auto"  alt="300x300" style="width: 250px; height: 250px;" src="assets/images/carousel/pic1.jpg">
  </div>
</div>

<hr style="margin:3em;">

<div class="row featurette">
  <div class="col-md-7 order-md-2">
	<h4 class="featurette-heading">Enterprise-Grade SaaS Offering</h4>
	<p class="lead" style="font-size:18px;">Our product is an enterprise-grade cloud offering that you can count on.</p>
  </div>
  <div class="col-md-5 order-md-1">
	<img class="featurette-image img-fluid mx-auto"  alt="300x300" style="width: 250px; height: 250px;" src="assets/images/carousel/pic2.jpg">
  </div>
</div>



<?php include './master/footer.php'; ?>