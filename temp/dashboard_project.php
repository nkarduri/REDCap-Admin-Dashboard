<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username'];
} else {
	header("Location: dashboard.php");
}
require_once '../../../redcap_connect.php';
include_once "../sql_list.php";
include_once "dashboard_project_conso.php";

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

// CRSU
$crsu_prod_num = $mysql->crsu_num_production();
$crsu_dev_num = $mysql->crsu_num_development();
$crsu_inact_num = $mysql->crsu_num_inactive();
$crsu_arch_num = $mysql->crsu_num_archive();

// IHDI
$ihdi_prod_num = $mysql->ihdi_num_production();
$ihdi_dev_num = $mysql->ihdi_num_development();
$ihdi_inact_num = $mysql->ihdi_num_inactive();
$ihdi_arch_num = $mysql->ihdi_num_archive();

// CTU
$ctu_prod_num = $mysql->ctu_num_production();
$ctu_dev_num = $mysql->ctu_num_development();
$ctu_inact_num = $mysql->ctu_num_inactive();
$ctu_arch_num = $mysql->ctu_num_archive();

// VEC
$vec_prod_num = $mysql->vec_num_production();
$vec_dev_num = $mysql->vec_num_development();
$vec_inact_num = $mysql->vec_num_inactive();
$vec_arch_num = $mysql->vec_num_archive();

?>

<h3>Project Dashboard</h3>
<br>
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#consortium" data-toggle="tab">CFRI Redcap Consortium</a></li>
	<li><a href="#crsu" data-toggle="tab">CRSU</a></li>
	<li><a href="#ihdi" data-toggle="tab">IHDI</a></li>
	<li><a href="#ctu" data-toggle="tab">CTU</a></li>
	<li><a href="#vec" data-toggle="tab">VEC</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
	<div class="tab-pane in active" id="consortium">
		<br>
		<div id="download_msg"></div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">CFRI Redcap Consortium Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
							<td><b>View</b></td>
							<td><b>Download</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Production</td>
							<td><?php echo $production_num; ?></td>
							<td>
								<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#production">
									<span class="glyphicon glyphicon-list"></span> View
								</button>
								<div id="production" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">List of projects in Production</h4>
											</div>
											<div class="modal-body filterable">
												
												<table class="table table-striped table-hover">
													<thead>
														<tr class="filters">
															<td><input type="text" class="form-control" placeholder="PID" /></td>
															<td><input type="text" class="form-control" placeholder="Project Name" /></td>
															<td><input type="text" class="form-control" placeholder="PI Name" /></td>
															<td><b>PI Email</b></td>
															<td><b>Creation Date</b></td>
														</tr>
													</thead>
													<tbody>
														<?php
														while ( $prod_info_result = db_fetch_array($prod_info_sql) ) { ?>
														<tr>
															<td><?php echo $prod_info_result['project_id']; ?></td>
															<td><?php echo $prod_info_result['app_title']; ?></td>
															<td><?php echo $prod_info_result['project_pi_firstname']." ".$prod_info_result['project_pi_lastname']; ?></td>
															<td><a href="mailto: <?php echo $prod_info_result['project_pi_email']; ?>"><?php echo $prod_info_result['project_pi_email']; ?></a></td>
															<td><?php echo $prod_info_result['creation_time']; ?></td>
														</tr>
														<?php
														} ?>
													</tbody>
												</table>
												
											 </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>

										</div>
									</div>
								</div>
							</td>
							<td><a href="csv_download/conso_production.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
							<!-- td><button id="btn-conso-prod" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
						</tr>
						<tr>
							<td>Development</td>
							<td><?php echo $development_num; ?></td>
							<td>
								<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#development">
									<span class="glyphicon glyphicon-list"></span> View
								</button>
								<div id="development" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">List of projects in Development</h4>
											</div>
											<div class="modal-body">
												<table class="table table-striped table-hover">
													<thead>
														<tr>
															<td><b>Project ID</b></td>
															<td><b>Project Name</b></td>
															<td><b>PI Name</b></td>
															<td><b>PI Email</b></td>
															<td><b>Creation Date</b></td>
														</tr>
													</thead>
													<tbody>
														<?php
														while ( $dev_info_result = db_fetch_array($dev_info_sql) ) { ?>
														<tr>
															<td><?php echo $dev_info_result['project_id']; ?></td>
															<td><?php echo $dev_info_result['app_title']; ?></td>
															<td><?php echo $dev_info_result['project_pi_firstname']." ".$dev_info_result['project_pi_lastname']; ?></td>
															<td><a href="mailto: <?php echo $dev_info_result['project_pi_email']; ?>"><?php echo $dev_info_result['project_pi_email']; ?></a></td>
															<td><?php echo $dev_info_result['creation_time']; ?></td>
														</tr>
														<?php
														} ?>
													</tbody>
												</table>
											 </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>

										</div>
									</div>
								</div>
							</td>
							<td><a href="csv_download/conso_development.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
							<!-- td><button id="btn-conso-dev" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
						</tr>
						<tr>
							<td>Inactive</td>
							<td><?php echo $inactive_num; ?></td>
							<td>
								<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#inactive">
									<span class="glyphicon glyphicon-list"></span> View
								</button>
								<div id="inactive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">List of projects in Inactive</h4>
											</div>
											<div class="modal-body">
												<table class="table table-striped table-hover">
													<thead>
														<tr>
															<td><b>Project ID</b></td>
															<td><b>Project Name</b></td>
															<td><b>PI Name</b></td>
															<td><b>PI Email</b></td>
															<td><b>Creation Date</b></td>
														</tr>
													</thead>
													<tbody>
														<?php
														while ( $inact_info_result = db_fetch_array($inact_info_sql) ) { ?>
														<tr>
															<td><?php echo $inact_info_result['project_id']; ?></td>
															<td><?php echo $inact_info_result['app_title']; ?></td>
															<td><?php echo $inact_info_result['project_pi_firstname']." ".$inact_info_result['project_pi_lastname']; ?></td>
															<td><a href="mailto: <?php echo $inact_info_result['project_pi_email']; ?>"><?php echo $inact_info_result['project_pi_email']; ?></a></td>
															<td><?php echo $inact_info_result['creation_time']; ?></td>
														</tr>
														<?php
														} ?>
													</tbody>
												</table>
											 </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>

										</div>
									</div>
								</div>
							</td>
							<td><a href="csv_download/conso_inactive.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
							<!-- td><button id="btn-conso-inact" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
						</tr>
						<tr>
							<td>Archive</td>
							<td><?php echo $archive_num; ?></td>
							<td>					
								<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#archive">
									<span class="glyphicon glyphicon-list"></span> View						
								</button>
								<div id="archive" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h4 class="modal-title" id="myModalLabel">List of projects in Archive</h4>
											</div>
											<div class="modal-body">
												<table class="table table-striped table-hover">
													<thead>
														<tr>
															<td><b>Project ID</b></td>
															<td><b>Project Name</b></td>
															<td><b>PI Name</b></td>
															<td><b>PI Email</b></td>
															<td><b>Creation Date</b></td>
														</tr>
													</thead>
													<tbody>
														<?php
														while ( $arch_info_result = db_fetch_array($arch_info_sql) ) { ?>
														<tr>
															<td><?php echo $arch_info_result['project_id']; ?></td>
															<td><?php echo $arch_info_result['app_title']; ?></td>
															<td><?php echo $arch_info_result['project_pi_firstname']." ".$arch_info_result['project_pi_lastname']; ?></td>
															<td><a href="mailto: <?php echo $arch_info_result['project_pi_email']; ?>"><?php echo $arch_info_result['project_pi_email']; ?></a></td>
															<td><?php echo $arch_info_result['creation_time']; ?></td>
														</tr>
														<?php
														} ?>
													</tbody>
												</table>
											 </div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>

										</div>
									</div>
								</div>
							</td>
							<td><a href="csv_download/conso_archive.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
							<!-- td><button id="btn-conso-arch" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
						</tr>
						<tr>
							<td><b>Total</b></td>
							<td><b><?php echo $total_result['total_count']; ?><b></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
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
							text: 'Project Status in CFRI Redcap Consortium'
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
							text: 'Users Created in Database'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: ['Users'],
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
	
	<div class="tab-pane" id="crsu">
		<br>	
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">CRSU Redcap Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Production</td>
							<td><?php echo $crsu_prod_num; ?></td>
						</tr>
						<tr>
							<td>Development</td>
							<td><?php echo $crsu_dev_num; ?></td>
						</tr>
						<tr>
							<td>Inactive</td>
							<td><?php echo $crsu_inact_num; ?></td>
						</tr>
						<tr>
							<td>Archive</td>
							<td><?php echo $crsu_arch_num; ?></td>
						</tr>
					</tbody>
				</table>
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
					$('#crsu-project-bar-chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Project Status in CRSU'
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
								{ name: 'Production',  y: <?php echo $crsu_prod_num; ?>,  color: '#428bca' },
								{ name: 'Development', y: <?php echo $crsu_dev_num; ?>, color: '#5cb85c' },
								{ name: 'Inactive',    y: <?php echo $crsu_inact_num; ?>,    color: '#f0ad4e' },
								{ name: 'Archive',     y: <?php echo $crsu_arch_num; ?>,     color: '#d9534f' }
							]
						}]
					});
				});
				</script>
				<div id="crsu-project-bar-chart"></div>
			</div>
		</div>
		
	</div>
	
	<div class="tab-pane" id="ihdi">
		<br>	
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">IHDI Redcap Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Production</td>
							<td><?php echo $ihdi_prod_num; ?></td>
						</tr>
						<tr>
							<td>Development</td>
							<td><?php echo $ihdi_dev_num; ?></td>
						</tr>
						<tr>
							<td>Inactive</td>
							<td><?php echo $ihdi_inact_num; ?></td>
						</tr>
						<tr>
							<td>Archive</td>
							<td><?php echo $ihdi_arch_num; ?></td>
						</tr>
					</tbody>
				</table>
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
					$('#ihdi-project-bar-chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Project Status in IHDI'
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
								{ name: 'Production',  y: <?php echo $ihdi_prod_num; ?>,  color: '#428bca' },
								{ name: 'Development', y: <?php echo $ihdi_dev_num; ?>, color: '#5cb85c' },
								{ name: 'Inactive',    y: <?php echo $ihdi_inact_num; ?>,    color: '#f0ad4e' },
								{ name: 'Archive',     y: <?php echo $ihdi_arch_num; ?>,     color: '#d9534f' }
							]
						}]
					});
				});
				</script>
				<div id="ihdi-project-bar-chart"></div>
			</div>
		</div>
		
	</div>
	
	<div class="tab-pane" id="ctu">
		<br>	
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">CTU Redcap Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Production</td>
							<td><?php echo $ctu_prod_num; ?></td>
						</tr>
						<tr>
							<td>Development</td>
							<td><?php echo $ctu_dev_num; ?></td>
						</tr>
						<tr>
							<td>Inactive</td>
							<td><?php echo $ctu_inact_num; ?></td>
						</tr>
						<tr>
							<td>Archive</td>
							<td><?php echo $ctu_arch_num; ?></td>
						</tr>
					</tbody>
				</table>
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
					$('#ctu-project-bar-chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Project Status in CTU'
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
								{ name: 'Production',  y: <?php echo $ctu_prod_num; ?>,  color: '#428bca' },
								{ name: 'Development', y: <?php echo $ctu_dev_num; ?>, color: '#5cb85c' },
								{ name: 'Inactive',    y: <?php echo $ctu_inact_num; ?>,    color: '#f0ad4e' },
								{ name: 'Archive',     y: <?php echo $ctu_arch_num; ?>,     color: '#d9534f' }
							]
						}]
					});
				});
				</script>
				<div id="ctu-project-bar-chart"></div>
			</div>
		</div>
	</div>
	
	<div class="tab-pane" id="vec">
		<br>	
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h3 class="panel-title">VEC Redcap Dashboard</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<td><b>Project Status</b></td>
							<td><b>Number of projects</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Production</td>
							<td><?php echo $vec_prod_num; ?></td>
						</tr>
						<tr>
							<td>Development</td>
							<td><?php echo $vec_dev_num; ?></td>
						</tr>
						<tr>
							<td>Inactive</td>
							<td><?php echo $vec_inact_num; ?></td>
						</tr>
						<tr>
							<td>Archive</td>
							<td><?php echo $vec_arch_num; ?></td>
						</tr>
					</tbody>
				</table>
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
					$('#vec-project-bar-chart').highcharts({
						chart: {
							plotBackgroundColor: null,
							plotBorderWidth: null,
							plotShadow: false
						},
						title: {
							text: 'Project Status in vec'
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
								{ name: 'Production',  y: <?php echo $vec_prod_num; ?>,  color: '#428bca' },
								{ name: 'Development', y: <?php echo $vec_dev_num; ?>, color: '#5cb85c' },
								{ name: 'Inactive',    y: <?php echo $vec_inact_num; ?>,    color: '#f0ad4e' },
								{ name: 'Archive',     y: <?php echo $vec_arch_num; ?>,     color: '#d9534f' }
							]
						}]
					});
				});
				</script>
				<div id="vec-project-bar-chart"></div>
			</div>
		</div>
	</div>
	
	<div id="download_load"></div>
</div>

<script>
$(document).ready(function() {
	$('#production').modal('hide');
	$('#development').modal('hide');
	$('#inactive').modal('hide');
	$('#archive').modal('hide');
	
	$("#btn-conso-prod").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "production"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>¡Á</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-dev").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "development"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>¡Á</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-inact").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "inactive"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>¡Á</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
	$("#btn-conso-arch").click(function() {
		$("#download_load").load("csv_download.php", {name: "conso", type: "archive"});
		$("#download_msg").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>¡Á</button><span><strong>SUCCESS: </strong> Download successfully!</span></div>");
	});
	
});
</script>