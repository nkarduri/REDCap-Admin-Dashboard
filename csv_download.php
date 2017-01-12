<?php
error_reporting(0);
require_once '../../redcap_connect.php';
include_once "sql_list.php";

$mysql = new MySQL();

$name = ( isset($_POST["name"]) ? $_POST["name"] : null );
$type = ( isset($_POST["type"]) ? $_POST["type"] : null );

$report_name = '';
$sql = '';
if ($name == "conso" && $type == "production") {
	$report_name = "Consortium_Projects_Production_";
	$sql = db_query($mysql->conso_prod_info());

} else if ($name == "conso" && $type == "development") {
	$report_name = "Consortium_Projects_Development_";
	$sql = db_query($mysql->conso_dev_info());

} else if ($name == "conso" && $type == "inactive") {
	$report_name = "Consortium_Projects_Inactive_";
	$sql = db_query($mysql->conso_inact_info());

} else if ($name == "conso" && $type == "archive") {
	$report_name = "Consortium_Projects_Archive_";
	$sql = db_query($mysql->conso_arch_info());
}

$filename = $report_name.date("Y-m-d_H_m_s").".csv";

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=$filename");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

/*
header('Pragma: anytextexeptno-cache', true);
header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$filename");
*/

//$csv_file = fopen('php://output', 'w');
$csv_file = fopen($filename, 'w');
fputcsv($csv_file, array("Project ID", "Project Name", "PI Name", "PI Email", "Creation Date","production Date","Last Activity Date"));
while ( $result = db_fetch_array($sql) ) { 
	fputcsv($csv_file, array($result['project_id'], $result['app_title'], $result['project_pi_firstname']." ".$result['project_pi_lastname'], $result['project_pi_email'], $result['creation_time'],$result['production_time'],$result['last_logged_event']));
} 

fclose($csv_file);  

?>