<?php
//error_reporting(0);
//define("NOAUTH", False);
//require_once "../../redcap_connect.php";

$username = ( isset($_POST["username"]) ? $_POST["username"] : null );
$password = ( isset($_POST["password"]) ? $_POST["password"] : null );

$user_info = db_query("SELECT username FROM redcap_user_information WHERE username='".$username."' AND super_user='1'");
$user_info_num = mysqli_num_rows($user_info);

if ($username != '' && $password != '') {
	if ($user_info_num == 1) {
		if (checkUserPassword($username, $password)) {
			//echo "<script>$(document).ready(function() { $('#index').hide(); $('#dashboard').load('dashboard.php?username=$username'); });</script>";
			header('Location: dashboard.php?username='.$username);
			//echo "<script>$(document).ready(function() { $('#dashboard').load('dashboard2.php?username=$usernmae'); });</script>";
		} else {
			echo "<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>ERROR: </strong> You entered an invalid user name or password!</span></div>";
		}
		
	} else {
		echo "<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>ERROR: </strong> Your are not a user admin!</span></div>";
	}
	
} else {
	echo "<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>ERROR: </strong> Please check your inputs!</span></div>";
}

?>