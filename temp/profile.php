<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username']; echo "here11: ".$userid;
} else {
	header("Location: dashboard.php");
}

//require_once '/home/redcap/public_html/consortium/redcap/redcap_v5.9.10/Config/init_functions.php';
require_once '../../redcap_connect.php';

include_once "sql_list.php";
$mysql = new MySQL();
//$userid = ( isset($_POST["username"]) ? $_POST["username"] : null );
//$user_query = db_query("SELECT username, user_email, user_lastname, user_firstname, super_user, user_lastlogin FROM redcap_user_information WHERE username='$userid'");
echo $userid;
$user_query = db_query($mysql->get_user_profile($userid));
$user_result = db_fetch_assoc($user_query);
?>
<h3>User Profile</h3>
<br>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">User Information</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3 col-lg-3" align="center">
				<img class="pic img-circle" src="img/default_img.jpg" alt="profile pic" />
			</div>
					
			<div class="col-md-9 col-lg-9"> 
				<table class="table table-user-information">
					<tbody>
						<tr>
							<td>Username</td>
							<td><?php echo $user_result['username']; ?></td>
						</tr>
						<tr>
							<td>E-mail</td>
							<td><?php echo $user_result['user_email']; ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $user_result['user_lastname']; ?></td>
						</tr>
						<tr>
							<td>First Name</td>
							<td><?php echo $user_result['user_firstname']; ?></td>
						</tr>
						<tr>
							<td>Super User</td>
							<td>
								<?php 
								if ($user_result['super_user'] == "1") {
									echo "Yes";
								} else {
									echo "No";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Last Login</td>
							<td><?php echo $user_result['user_lastlogin']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="panel-footer"></div>
</div>