<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username'];
} else {
	header("Location: dashboard.php");
}
require_once '../../../redcap_connect.php';
include_once "../sql_list.php";
$mysql = new MySQL();

$conso_total_centre_sql = db_query($mysql->conso_total_centre());
$conso_total_centre = db_fetch_assoc($conso_total_centre_sql);

//$conso_total_record_sql = db_query($mysql->conso_total_record());
//$conso_total_record = db_fetch_assoc($conso_total_record_sql);

// CRSU
$crsu_total_centre = $mysql->crsu_total_centre();
//$crsu_total_record = $mysql->crsu_total_record();

// IHDI
$ihdi_total_centre = $mysql->ihdi_total_centre();
//$ihdi_total_record = $mysql->ihdi_total_record();

// CTU
$ctu_total_centre = $mysql->ctu_total_centre();
//$ctu_total_record = $mysql->ctu_total_record();

// VEC
$vec_total_centre = $mysql->vec_total_centre();
//$vec_total_record = $mysql->vec_total_record();

?>
<h3>Group Dashboard</h3>
<br>
<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title">Centres</h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Type</th>
					<th>CFRI Redcap Consortium</th>
					<th>CRSU</th>
					<th>IHDI</th>
					<th>CTU</th>
					<th>VEC</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Number of centres</td>
					<td><?php echo $conso_total_centre['total_count']; ?></td>
					<td><?php echo $crsu_total_centre; ?></td>
					<td><?php echo $ihdi_total_centre; ?></td>
					<td><?php echo $ctu_total_centre; ?></td>
					<td><?php echo $vec_total_centre; ?></td>
				</tr>
				
                 <!--
                <tr>
					<td>Number of records</td>
					<td><?php /*echo $conso_total_record['total_count'];*/ ?></td>
					<td><?php /* echo $crsu_total_record; */ ?></td>
					<td><?php /* echo $ihdi_total_record; */?></td>
					<td><?php /* echo $ctu_total_record; */ ?></td>
					<td><?php /* echo $vec_total_record; */ ?></td>
				</tr> -->
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
					$('#num-centre').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Number of centres'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: ['Centre']
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Number'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
								'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
							footerFormat: '</table>',
							shared: true,
							useHTML: true
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0
							}
						},
						series: [{
							name: 'CFRI Consortium',
							data: [<?php echo $conso_total_centre['total_count']; ?>],
							color: '#428bca'				
						}, {
							name: 'CRSU',
							data: [<?php echo $crsu_total_centre; ?>],
							color: '#5cb85c'
						}, {
							name: 'IHDI',
							data: [<?php echo $ihdi_total_centre; ?>],
							color: '#f0ad4e'
						}, {
							name: 'CTU',
							data: [<?php echo $ctu_total_centre; ?>],
							color: '#d9534f'
						}, {
							name: 'vec',
							data: [<?php echo $vec_total_centre; ?>],
							color: '#777'
						}]
					});
				});
				</script>
				<div id="num-centre"></div>
				
               <!-- 
				<script type="text/javascript">
				$(function () {
					$('#num-record').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Number of records'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							categories: ['Record']
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Number'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
								'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
							footerFormat: '</table>',
							shared: true,
							useHTML: true
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0
							}
						},
						series: [{
							name: 'CFRI Consortium',
							data: [<?php //echo $conso_total_record['total_count']; ?>],
							color: '#428bca'				
						}, {
							name: 'CRSU',
							data: [<?php //echo $crsu_total_record; ?>],
							color: '#5cb85c'
						}, {
							name: 'IHDI',
							data: [<?php //echo $ihdi_total_record; ?>],
							color: '#f0ad4e'
						}, {
							name: 'CTU',
							data: [<?php //echo $ctu_total_record; ?>],
							color: '#d9534f'
						}, {
							name: 'VEC',
							data: [<?php //echo $vec_total_record; ?>],
							color: '#777'
						}]
					});
				});
				</script>    
				<div id="num-record"></div> -->
			</div>
		</div>