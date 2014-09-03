<?php
require_once '../../redcap_connect.php';
include_once "sql_list.php";

$userid = $_SESSION['username'];

$user_info = db_query("SELECT username FROM redcap_user_information WHERE username='".$userid."' AND super_user='1'");
$user_info_num = mysqli_num_rows($user_info);	

$user = array('cfriadmin','admin_dm','amckerrow_sa','nkarduri','eportales','nkarduri_test');

if(in_array($userid,$user))
{
//echo "session: ".$_SESSION['myusername'];

$mysql = new MySQL();
$user_name = db_query($mysql->get_username($userid));
$name_result = db_fetch_assoc($user_name);


// Consortium
$conso_prod_sql = db_query($mysql->conso_num_production());
$conso_prod_num = mysqli_num_rows($conso_prod_sql);

$conso_dev_sql = db_query($mysql->conso_num_development());
$conso_dev_num = mysqli_num_rows($conso_dev_sql);

$conso_total_user_sql = db_query($mysql->conso_total_user());
$conso_total_user = mysqli_num_rows($conso_total_user_sql);

$conso_total_centre_sql = db_query($mysql->conso_total_centre());
$conso_total_centre = db_fetch_assoc($conso_total_centre_sql);

$conso_total_record_sql = db_query($mysql->conso_total_record());
$conso_total_record = db_fetch_assoc($conso_total_record_sql);

$conso_version_sql = db_query($mysql->conso_redcap_version());
$conso_version_result = db_fetch_assoc($conso_version_sql);


// CRSU
$crsu_prod_num = $mysql->crsu_num_production();
$crsu_dev_num = $mysql->crsu_num_development();
$crsu_total_user = $mysql->crsu_total_user();
$crsu_total_centre = $mysql->crsu_total_centre();
$crsu_total_record = $mysql->crsu_total_record();
$crsu_db_size = $mysql->crsu_db_size();
$crsu_version = $mysql->crsu_version();

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

<div class="container">

	<div class="header panel">
		<div class="row">
			<div class="col-md-3 col-md-offset-3"></div>
			<div class="col-md-3 col-md-offset-3">
				<img class="pic img-circle" src="img/default_img.jpg" alt="profile pic" />
			</div>
		</div>		
		<div class="name"><small><?php echo $name_result['user_firstname']; ?> <?php echo $name_result['user_lastname']; ?></small></div>
	</div>
	<br></br>
    <hr>
    <div class="row">
	
        <div class="col-sm-3">
            <nav class="nav-sidebar">
                <ul class="nav">
                    <li class="active">
						<a id="home" href="#"><i class="glyphicon glyphicon-home"></i> Home</a>
					</li>
					<li>
						<a id="profile" href="#"><i class="glyphicon glyphicon-user"></i> User Profile</a>
						<input type="hidden" id="userid" value="<?php echo $userid; ?>" />
					</li>
                    <li>
						<a id="project_dashboard" href="#"><i class="glyphicon glyphicon-stats"></i> Project Dashboard</a>
					</li>
                    <li>
						<a id="user_dashboard" href="#"><i class="glyphicon glyphicon-stats"></i> User Dashboard</a>
					</li>
                    <li>
						<a id="group_dashboard" href="#"><i class="glyphicon glyphicon-stats"></i> Group Dashboard</a>
					</li>
					<!-- <li>
						<a id="ticket_dashboard" href="#"><i class="glyphicon glyphicon-stats"></i> Ticket System</a>
					</li> -->
                    <li class="nav-divider"></li>
                    <li>
						<a id="logout" href="#"><i class="glyphicon glyphicon-log-out"></i> Log out</a>
					</li>
                </ul>
            </nav>
			<br>
			<img class="img-thumbnail" src="img/redcaplogo.gif" />
        </div>
		
		<div id="logout_load"></div>
		
        <div class="col-sm-9">
			<div id="home_load">
				<h3>Welcome to CFRI - CSRU Data Management</h3>
				<br>
				
				<div class="alert alert-info">
					
					<p>REDCap (Research Electronic Data Capture) is a web-based, metadata-driven EDC software solution and workflow methodology for designing and capturing data for research studies. REDCap allows users to build and manage online surveys and research databases quickly and securely. REDCap at CFRI is managed by the CRSU data management team in collaboration with CFRI's Research IT services office.</p>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Statistics</h3>
					</div>
					<div class="panel-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th><b>Type</b></th>
									<th><b>CFRI Consortium</b> <span class="label label-success">ver <?php echo $conso_version_result['value']; ?></span></th>
									<th><b>CRSU</b> <span class="label label-success">ver <?php echo $crsu_version; ?></span></th>
									<th><b>Total</b></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Projects in Production</td>
									<td><?php echo $conso_prod_num; ?></td>
									<td><?php echo $crsu_prod_num; ?></td>
									<td><?php echo (int) $conso_prod_num + (int) $crsu_prod_num; ?></td>
								</tr>
								<tr>
									<td>Projects in Development</td>
									<td><?php echo $conso_dev_num; ?></td>
									<td><?php echo $crsu_dev_num; ?></td>
									<td><?php echo (int) $conso_dev_num + (int) $crsu_dev_num; ?></td>
								</tr>
								<tr>
									<td>Number of total users</td>
									<td><?php echo $conso_total_user; ?></td>
									<td><?php echo $crsu_total_user; ?></td>
									<td><?php echo (int) $conso_total_user + (int) $crsu_total_user; ?></td>
								</tr>
								<tr>
									<td>Number of centres</td>
									<td><?php echo $conso_total_centre['total_count']; ?></td>
									<td><?php echo $crsu_total_centre; ?></td>
									<td><?php echo (int) $conso_total_centre['total_count'] + (int) $crsu_total_centre; ?></td>
								</tr>
								<tr>
									<td>Number of records</td>
									<td><?php echo $conso_total_record['total_count']; ?></td>
									<td><?php echo $crsu_total_record; ?></td>
									<td><?php echo (int) $conso_total_record['total_count'] + (int) $crsu_total_record; ?></td>
								</tr>
							</tbody>
							<tbody id="db_size_load"></tbody>
							<tbody id="db_size_load_empty">
								<tr>
									<td>Total size of database</td>
									<td>
										<div class="row">
											<div class="col-sm-5">n/a</div>
											<div class="col-sm-5"><button id="db_size" class="btn btn-warning btn-xs" type="button">Click to view</button></div>
										</div>
									</td>
									<td><?php echo round($crsu_db_size); ?> (MB)</td>
									<td>n/a</td>									
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Clients</h3>
					</div>
					<div class="panel-body">
						<a href="http://hipdysplasia.org/" target="_blank">
						International Hip Dysplasia Institute <br>
							<img id="ihdi-tooltip" class="img-thumbnail" src="img/logo.png" alt="ihdi-logo" data-toggle="tooltip" data-placement="right" title="Go to IHDI" />
						</a>
						<br></br>
						<a href="http://vec.med.ubc.ca/" target="_blank">
						Vaccine Evaluation Center <br>
							<img id="vec-tooltip" class="img-rounded" src="img/vec_logo.png" alt="vec-logo" data-toggle="tooltip" data-placement="right" title="Go to VEC" />
						</a>
						<br></br>
						<a href="#" target="_blank">CTU</a>
					</div>
				</div> -->
				<script>
					$('#ihdi-tooltip').tooltip('hide');
					$('#vec-tooltip').tooltip('hide');
				</script>
				
			</div>
			<div id="profile_load" style="display: none;"></div>
			<div id="project_dashboard_load" style="display: none;"></div>
			<div id="user_dashboard_load" style="display: none;"></div>
			<div id="group_dashboard_load" style="display: none;"></div>
			<div id="ticket_dashboard_load" style="display: none;"></div>
			
        </div>
		
    </div>
</div>
<script>
$(document).ready(function() {
	var userid = $("#userid").val();
	$(".nav-sidebar").on('click', 'li', function() {
		$(".nav-sidebar .active").removeClass("active");
		$(this).addClass("active");
  
		return false;  
	});  

	$("#home").click(function() {
		$("#profile_load").hide();
		$("#project_dashboard_load").hide();
		$("#user_dashboard_load").hide();
		$("#group_dashboard_load").hide();
		$("ticket_dashboard_load").hide();
		$("#home_load").show();
	});
	
	$("#profile").on("click", function() {
		$("#home_load").hide();
		$("#project_dashboard_load").hide();
		$("#user_dashboard_load").hide();
		$("#group_dashboard_load").hide();
		$("ticket_dashboard_load").hide();
		$("#profile_load").show();
		$("#profile_load").html('<img src="img/loading.gif" style="margin-left: 30px;" /> <span style="color: #777"> Loading...</span>');
		$("#profile_load").load("view/dashboard_profile.php?username=" + userid);
	});
	
	$("#project_dashboard").click(function() {
		$("#home_load").hide();
		$("#profile_load").hide();
		$("#user_dashboard_load").hide();
		$("#group_dashboard_load").hide();
		$("ticket_dashboard_load").hide();
		$("#project_dashboard_load").show();
		$("#project_dashboard_load").html('<img src="img/loading.gif" style="margin-left: 30px;" /> <span style="color: #777"> Loading...</span>');
		$("#project_dashboard_load").load("view/dashboard_project.php?username=" + userid);
	});
	
	$("#user_dashboard").click(function() {
		$("#home_load").hide();
		$("#profile_load").hide();
		$("#project_dashboard_load").hide();
		$("#group_dashboard_load").hide();
		$("ticket_dashboard_load").hide();
		$("#user_dashboard_load").show();
		$("#user_dashboard_load").html('<img src="img/loading.gif" style="margin-left: 30px;" /> <span style="color: #777"> Loading...</span>');
		$("#user_dashboard_load").load("view/dashboard_user.php?username=" + userid);
	});
	
		$("#group_dashboard").click(function() {
		$("#home_load").hide();
		$("#profile_load").hide();
		$("#project_dashboard_load").hide();
		$("#user_dashboard_load").hide();
		$("ticket_dashboard_load").hide();
		$("#group_dashboard_load").show();
		$("#group_dashboard_load").html('<img src="img/loading.gif" style="margin-left: 30px;" /> <span style="color: #777"> Loading...</span>');
		$("#group_dashboard_load").load("view/dashboard_group.php?username=" + userid);
	});
	
		$("#ticket_dashboard").click(function() {
		$("#home_load").hide();
		$("#profile_load").hide();
		$("#project_dashboard_load").hide();
		$("#user_dashboard_load").hide();
		$("#group_dashboard_load").hide();
		$("#ticket_dashboard_load").show();
		$("#ticket_dashboard_load").html('<img src="img/loading.gif" style="margin-left: 30px;" /> <span style="color: #777"> Loading...</span>');
		$("#ticket_dashboard_load").load("view/ticket_system.php?username="+ userid);
	});
	
	$("#logout").click(function() {
		$("#logout_load").load("logout.php?username=" + userid);
	});
	
	$("#db_size").click(function() {
		$("#db_size_load_empty").hide();
		$("#db_size_load").html('<img src="img/loading_sm.gif" style="margin-left: 30px;" /> <span style="color: #777"> Estmating...</span>');
		$("#db_size_load").load("view_size_db.php?username=" + userid);
	});
	
});
</script>
</body>
</html>
<?php 
}
else{

$_SESSION = array();
session_unset();
session_destroy();

echo "
		<script type='text/javascript'>

        alert('Only Super Administrators has access to this application. ');
        
		window.location = 'dashboard.php';
		
		</script> ";
		
exit;
}
?>