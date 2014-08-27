<?php
//error_reporting(0);
//define("NOAUTH",False);
//require_once "../../redcap_connect.php";
//echo $userid;
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
	<meta name="author" content="hoseok brandon" />
	<meta name="keywords" content="redcap" />
	<meta name="description" content="resume builder" />
	<title>CFRI Data Management</title>
	<link rel="shortcut icon" href="https://redcap-dev.cfri.ca/consortium/redcap/redcap_v5.9.10/Resources/images/favicon.ico" /> 
		
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.3.1.1.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<link rel="stylesheet" type="text/css" href="css/dashboard.css" />

	<script type="text/javascript" src="js/jquery.min.1.11.0.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.3.1.1.js"></script>
	<script type="text/javascript" src="js/login_form.js"></script>
	<script type="text/javascript" src="js/auth.js"></script>
	<script type="text/javascript" src="js/dashboard.js"></script>
	
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/exporting.js"></script>
</head>
<body>

	<div id="index" class="container">
		<br>
		<div class="row">
			
			<img src="https://rc.cfri.ca/cfri-redcap.png" />
			<h2>CFRI Data Management</h2>
			<div class="alert alert-success">
				<h4>Description</h4>
				This .............
			</div>

			<div class="row">
				<div class="col-sm-5">

					<h4 class="page-header"><i class="glyphicon glyphicon-dashboard"></i> User Login</h4>
					<form class="registerForm" id="myForm" role="form">
						<div class="form-group float-label-control">
							<label for="">Username</label>
							<input id="username" name="username" type="text" class="form-control" placeholder="Username">
						</div>
						<div class="form-group float-label-control">
							<label for="">Password</label>
							<input id="password" name="password" type="password" class="form-control" placeholder="Password">
						</div>
						
						<button id="btn-login" type="submit" class="btn btn-lg btn-primary">
							<i class="glyphicon glyphicon-ok pull-left"></i><span>Log in<br><small>for super admin only</small></span>
						</button>
					</form>
					<div id="error_msg" style="display: none;"></div>
				</div>
				<div class="col-sm-7">
					<img src="img/TRB_large.jpg" class="img-thumbnail" />
				</div>		
			</div>
		</div>
		
	</div>
	<div id="dashboard"></div>

</body>
</html>