<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username'];
} else {
	header("Location: dashboard.php");
}
require_once '../../../redcap_connect.php';
include_once "../sql_list.php";
include_once "dashboard_project_helper.php";

$mysql = new MySQL();

$total_sql = db_query($mysql->conso_total_project());
$total_result = db_fetch_assoc($total_sql);

// production=1, development=0, inactive=2, and archive=3
// Consortium
$production_sql = db_query($mysql->conso_num_production());
$production_num = mysqli_num_rows($production_sql);

$development_sql = db_query($mysql->conso_num_development());
$development_num = mysqli_num_rows($development_sql);

$inactive_sql = db_query($mysql->conso_num_inactive());
$inactive_num = mysqli_num_rows($inactive_sql);

$archive_sql = db_query($mysql->conso_num_archive());
$archive_num = mysqli_num_rows($archive_sql);

$prod_info_sql = db_query($mysql->conso_prod_info());
$dev_info_sql = db_query($mysql->conso_dev_info());
$inact_info_sql = db_query($mysql->conso_inact_info());
$arch_info_sql = db_query($mysql->conso_arch_info());

$last_10days_sql = db_query($mysql->conso_last_10days());
$last_10days_num = mysqli_num_rows($last_10days_sql);

$last_30days_sql = db_query($mysql->conso_last_30days());
$last_30days_num = mysqli_num_rows($last_30days_sql);

$last_90days_sql = db_query($mysql->conso_last_90days());
$last_90days_num = mysqli_num_rows($last_90days_sql);


$template = new Project_Dashboard_Template();
$template1 = new Project_Dashboard_Template1();

$det_project_sql     = db_query($mysql->det_project());
$det_project_sql_num  = mysqli_num_rows($det_project_sql);  


?>

<h3>Project Dashboard</h3>
<br>
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#consortium" data-toggle="tab">REDCap Database</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane in active" id="consortium">
		<br>
		<div id="download_msg"></div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Redcap Admin Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="dashboard_table table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
							<td><b>View</b></td>
							<td><b>Download</b></td>
						</tr>
					</thead>
					<tbody>
					
						<!-- Production -->
						<?php $template->dashboard_template_body("production", $production_num, "prod_pid", "prod_pname", "prod_piname"); ?>
							<tbody>
							<?php
							while ( $prod_info_result = db_fetch_array($prod_info_sql) ) { ?>
								<tr>
									<td><?php echo $prod_info_result['project_id']; ?></td>
									<td><?php echo $prod_info_result['app_title']; ?></td>
									<td><?php echo $prod_info_result['project_pi_firstname']." ".$prod_info_result['project_pi_lastname']; ?></td>
									<td><a href="mailto: <?php echo $prod_info_result['project_pi_email']; ?>"><?php echo $prod_info_result['project_pi_email']; ?></a></td>
									<td><?php echo $prod_info_result['creation_time']; ?></td>
									<td><?php 
                            		// Number of Records - Production
								    
                                    if(isset($prod_info_result['project_id']))
                                    {
                                    $sql = db_query("select distinct record from redcap_data where project_id =". $prod_info_result['project_id'] );	
									$result = mysqli_num_rows($sql);
									echo $result;						
									}
                                    ?> </td>
									<td>
									<?php
									// Number of forms - production		
									$sql = db_query("select distinct form_name from redcap_metadata where project_id = ". $prod_info_result['project_id'] );	
									$result1 = mysqli_num_rows($sql);
									echo $result1;
									?>
									</td>
									<td>
									<?php 
									//Number of questions - production 
								    $sql = db_query("select distinct field_name from redcap_metadata where project_id = ". $prod_info_result['project_id'] );	
									$result2 = mysqli_num_rows($sql);
									echo $result2;
									?>
									</td>
									<td>
									<?php
									//Project production date 		
								    
									echo $prod_info_result['production_time'];
									
									/*$sql = db_query("select production_time from redcap_projects where project_id =". $prod_info_result['project_id']);
								
									while($row = mysqli_fetch_array($sql))
									{
									echo $row['production_time'];
									}*/
									
									?>
									</td>
									 <td>
									 <?php echo $prod_info_result['last_logged_event']; ?>
									</td>
								
								</tr>
							<?php
							} ?>
							</tbody>
						<?php $template->dashboard_template_footer("conso_production"); ?>
						
						
						<!-- Development -->
						<?php $template->dashboard_template_body("Development", $development_num, "dev_pid", "dev_pname", "dev_piname"); ?>
							<tbody>
							<?php
							while ( $dev_info_result = db_fetch_array($dev_info_sql) ) { ?>
								<tr>
									<td><?php echo $dev_info_result['project_id']; ?></td>
									<td><?php echo $dev_info_result['app_title']; ?></td>
									<td><?php echo $dev_info_result['project_pi_firstname']." ".$dev_info_result['project_pi_lastname']; ?></td>
									<td><a href="mailto: <?php echo $dev_info_result['project_pi_email']; ?>"><?php echo $dev_info_result['project_pi_email']; ?></a></td>
									<td><?php echo $dev_info_result['creation_time']; ?></td>
									
									<td><?php 
									// Number of Records - Developement
									$sql = db_query("select distinct record from redcap_data where project_id = ". $dev_info_result['project_id'] );	
									$result = mysqli_num_rows($sql);
									echo $result;
									?> </td>
									<td>
									 <?php
									 // Number of forms - Development 
									$sql = db_query("select distinct form_name from redcap_metadata where project_id = ". $dev_info_result['project_id'] );	
									$result1 = mysqli_num_rows($sql);
									echo $result1;
						  		    ?>
									</td>
									<td>
									<?php
									//Number of Questions - development 
									$sql = db_query("select distinct field_name from redcap_metadata where project_id = ". $dev_info_result['project_id'] );	
									$result2 = mysqli_num_rows($sql);
									echo $result2;
								
									?>
									</td>
									<td>
									<?php echo '--'; ?>
									</td>
									<td>
									 <?php echo $dev_info_result['last_logged_event']; ?>
								    </td>
									
								</tr>
							<?php
							} ?>
							</tbody>
						<?php $template->dashboard_template_footer("conso_development"); ?>

						<!-- Inactive -->
						<?php $template->dashboard_template_body("Inactive", $inactive_num, "", "", ""); ?>
							<tbody>
							<?php
							while ( $inact_info_result = db_fetch_array($inact_info_sql) ) { ?>
								<tr>
									<td><?php echo $inact_info_result['project_id']; ?></td>
									<td><?php echo $inact_info_result['app_title']; ?></td>
									<td><?php echo $inact_info_result['project_pi_firstname']." ".$inact_info_result['project_pi_lastname']; ?></td>
									<td><a href="mailto: <?php echo $inact_info_result['project_pi_email']; ?>"><?php echo $inact_info_result['project_pi_email']; ?></a></td>
									<td><?php echo $inact_info_result['creation_time']; ?></td>
									
								    <td><?php 
                                    
									// Number of Records - Inactive
									
									$sql = db_query("select distinct record from redcap_data where project_id = ".$inact_info_result['project_id'] );	
									$result = mysqli_num_rows($sql);
									echo $result;
									
									?> </td>
									<td>
									 <?php
									 // Number of forms - Inactive 
									$sql = db_query("select distinct form_name from redcap_metadata where project_id = ".$inact_info_result['project_id'] );	
									$result1 = mysqli_num_rows($sql);
									echo $result1;
						  		    ?>
									</td>
									<td>
									<?php
									//Number of Questions - Inactive 
									$sql = db_query("select distinct field_name from redcap_metadata where project_id = ".$inact_info_result['project_id'] );	
									
									$result2 = mysqli_num_rows($sql);
									echo $result2;
								
									?>
									</td>
									<td>
									<?php
									//Project production date 		
								  	echo $inact_info_result['production_time'];
									
									?>
									</td>	
									
								    <td>
									 <?php echo $inact_info_result['last_logged_event']; ?>
									</td>
								
								</tr>
							<?php
							} ?>
							</tbody>
						<?php $template->dashboard_template_footer("conso_inactive"); ?>

						<!-- Archive -->
						<?php $template->dashboard_template_body("Archive", $archive_num, "", "", ""); ?>
							<tbody>
							<?php
							while ( $arch_info_result = db_fetch_array($arch_info_sql) ) { ?>
								<tr>
									<td><?php echo $arch_info_result['project_id']; ?></td>
									<td><?php echo $arch_info_result['app_title']; ?></td>
									<td><?php echo $arch_info_result['project_pi_firstname']." ".$arch_info_result['project_pi_lastname']; ?></td>
									<td><a href="mailto: <?php echo $arch_info_result['project_pi_email']; ?>"><?php echo $arch_info_result['project_pi_email']; ?></a></td>
									<td><?php echo $arch_info_result['creation_time']; ?></td>
									
								  <td><?php 
                                    
									// Number of Records - Archive
									
									$sql = db_query("select distinct record from redcap_data where project_id = ".$arch_info_result['project_id'] );	
									$result = mysqli_num_rows($sql);
							
									echo $result;
									
									?> </td>	
									
								<td>
									 <?php
									 // Number of forms - Inactive 
									$sql = db_query("select distinct form_name from redcap_metadata where project_id = ".$arch_info_result['project_id'] );	
									$result1 = mysqli_num_rows($sql);
									echo $result1;
						  		    ?>
									</td>
									<td>
									<?php
									//Number of Questions - Inactive 
									$sql = db_query("select distinct field_name from redcap_metadata where project_id = ".$arch_info_result['project_id'] );	
									
									$result2 = mysqli_num_rows($sql);
									echo $result2;
								
									?>
									</td>	
									<td>
									<?php
									//Project production date 		
								    $sql = db_query("select production_time from redcap_projects where project_id =". $arch_info_result['project_id'] );
								
									while($row1 = mysqli_fetch_array($sql))
									{
									echo $row1['production_time'];
									}
									?>
									</td>	
									
								    <td>
									 <?php echo $prod_info_result['last_logged_event']; ?>
									</td>
								
								</tr>
							<?php
							} ?>
							</tbody>
                       
						<?php $template->dashboard_template_footer("conso_archive"); ?>
					
                      <tbody>   	
						<tr>
							<td><b>Total</b></td>
							<td><b><?php echo $total_result['total_count']; ?><b></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
                    
                    <?php $template1->dashboard_template_body1("DET-API", $det_project_sql_num, "prod_pid", "prod_pname","prod_piname","","status",""); ?> 
                    <tbody>  
                    <?php 
                    while ($det_api_info_result = db_fetch_array($det_project_sql)) {                    
                    ?> 
                       <tr>
                       <td><?php echo $det_api_info_result['project_id']; ?></td>
                       <td><?php echo $det_api_info_result['app_title']; ?></td>
                       <td><?php echo $det_api_info_result['project_pi_firstname']." ".$det_api_info_result['project_pi_lastname']; ?></td>
                       <td><a href="mailto: <?php echo $det_api_info_result['project_pi_email']; ?>"><?php echo $det_api_info_result['project_pi_email']; ?></a></td>
                       <td><?php 
                       if ($det_api_info_result['status'] == '0' )
                       echo "<font color='red'>Development</font>";
                       else if ($det_api_info_result['status'] == '1' )
                       echo "<font color=blue>Production</font>"; 
                       
                       
                       
                        ?></td>
                       <td><?php echo $det_api_info_result['data_entry_trigger_url'];?> </td>
                       </tr>
                  
                  <?php
                  } ?>
                
                   </tbody>         
                    
                      <?php $template1->dashboard_template_footer1("det_api"); ?>
                    
                          
				</table>

				<hr>

				<h4><b>Projects Created in Database</b></h4>
				<div class="row">
					<div class="col-sm-4">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<td>Last 10 days</td>
									<td><?php echo $last_10days_num; ?></td>
								</tr>
								<tr>
									<td>Last 30 days</td>
									<td><?php echo $last_30days_num; ?></td>
								</tr>
								<tr>
									<td>Last 90 days</td>
									<td><?php echo $last_90days_num; ?></td>
								</tr>
							</tbody>
						</table>					
					</div>
					<div class="col-sm-8"></div>
				</div>
			</div>
		</div>
		<br>
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Graph</h3>
			</div>
			<div class="panel-body">
				
				<script type="text/javascript">
				$(function () {
					$('#conso-project-bar-chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Project Status in REDCap database'
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
						},
						plotOptions: {
							pie: {
								allowPointSelect: true,
								cursor: 'pointer',
								dataLabels: {
									enabled: true,
									format: '<b>{point.name}</b>: {point.percentage:.1f} %',
									style: {
										color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
									}
								}
							}
						},
						series: [{
							type: 'pie',
							name: 'Browser share',
							data: [
								{ name: 'Production',  y: <?php echo $production_num; ?>,  color: '#428bca' },
								{ name: 'Development', y: <?php echo $development_num; ?>, color: '#5cb85c' },
								{ name: 'Inactive',    y: <?php echo $inactive_num; ?>,    color: '#f0ad4e' },
								{ name: 'Archive',     y: <?php echo $archive_num; ?>,     color: '#d9534f' }
							]
						}]
					});
				});
				</script>
				<div id="conso-project-bar-chart"></div>
				
				<script type="text/javascript">
				$(function () {
					$('#conso-project-creation-bar-chart').highcharts({
						chart: {
							type: 'bar'
						},
						title: {
							text: 'Projects created'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: ['Projects'],
							title: {
								text: null
							}
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Number',
								align: 'high'
							},
							labels: {
								overflow: 'justify'
							}
						},
						tooltip: {
							valueSuffix: ''
						},
						plotOptions: {
							bar: {
								dataLabels: {
									enabled: true
								}
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: -40,
							y: 100,
							floating: true,
							borderWidth: 1,
							backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
							shadow: true
						},
						credits: {
							enabled: false
						},
						series: [{
							name: 'Last 90 days',
							data: [<?php echo $last_90days_num; ?>],
							color: '#f0ad4e'
						}, {
							name: 'Last 30 days',
							data: [<?php echo $last_30days_num; ?>],
							color: '#5cb85c'
						}, {
							name: 'Last 10 days',
							data: [<?php echo $last_10days_num; ?>],
							color: '#428bca'
						}]
					});
				});
				</script>
				<div id="conso-project-creation-bar-chart"></div>
				
			</div>
		</div>
		
	</div>
	
	
	
	<div id="download_load"></div>
</div>
<script type="text/javascript" src="js/filter_project_conso.js"></script>
<script>
$(document).ready(function() {
	$('#production').modal('hide');
	$('#development').modal('hide');
	$('#inactive').modal('hide');
	$('#archive').modal('hide');
    $('#DET-API').modal('hide');
	
	$("#btn-conso-prod").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "production"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-dev").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "development"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-inact").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "inactive"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-arch").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "archive"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
});
</script>