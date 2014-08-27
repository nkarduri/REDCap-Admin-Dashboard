<?php
require_once "../../redcap_connect.php";
//error_reporting(0);
if (!isset($_SESSION)) {
    session_start();
}
header("Location: dashboard.php?username=$username");
/*
$username = $password = "";
$err_flag = "0";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if ($_POST["username"] != '' && $_POST["password"] != '') { 
		
		require_once "../../redcap_connect.php";	
		
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$user_info = db_query("SELECT username FROM redcap_user_information WHERE username='".$username."' AND super_user='1'");
		$user_info_num = mysqli_num_rows($user_info);	
		
		if ($user_info_num == 1 && checkUserPassword($username, $password)) {
			$_SESSION['myusername'] = $username;
			header("Location: dashboard.php?username=$username");
			
		} else {
			redirect("/consortium/redcap/plugins/Stats/index.php");
			exit;

			//echo "<script>$(document).ready(function() { return true; });</script>";
			//header('Location: /consortium/redcap/plugins/Stats/index.php?logout=1');
		}
		
	} else {
		$err_flag = "3";
	}
}
*/
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
		
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.3.1.1.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<link rel="stylesheet" type="text/css" href="css/dashboard.css" />

	<script type="text/javascript" src="js/jquery.min.1.11.0.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.3.1.1.js"></script>
	<script type="text/javascript" src="js/login_form.js"></script>
	<script type="text/javascript" src="js/dashboard.js"></script>
	
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/exporting.js"></script>
</head>
<body>

	<div id="index" class="container">
		<br>
		<div class="row">
			
			<img src="https://rc.cfri.ca/cfri-redcap.png" />
			<h2>THE CLINICAL RESEARCH SUPPORT UNIT CRSU AT CFRI</h2>
			<div class="alert alert-success">
				REDCap (Research Electronic Data Capture) is a web-based, metadata-driven EDC software solution and workflow methodology for designing and capturing data for research studies. REDCap allows users to build and manage online surveys and research databases quickly and securely. REDCap at CFRI is managed by the CRSU data management team in collaboration with CFRI's Research IT services office.
			</div>

			<div class="row">
				<div class="col-sm-5">

					<h4 class="page-header"><i class="glyphicon glyphicon-dashboard"></i> User Login</h4>
					<form class="registerForm" id="myForm" role="form"  method="post" action="index.php">
					
						<div class="form-group float-label-control">
							<label for="">Username</label>
							<input id="username" name="username" type="text" class="form-control" placeholder="Username">
						</div>
						<div class="form-group float-label-control">
							<label for="">Password</label>
							<input id="password" name="password" type="password" class="form-control" placeholder="Password">
						</div>
						
						 <input class="btn btn-lg btn-primary" type="submit" name="submit" value="Log in" />

					</form>
					<div id="error_msg">
						<?php
						if ($err_flag == "3") { ?>
							<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button><span><strong>ERROR: </strong> Please check your inputs!</span></div>
						<?php
						} ?>
					</div>
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