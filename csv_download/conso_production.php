<?php
//error_reporting(0);
require_once '../../../redcap_connect.php';
include_once "sql_list.php";

$sql = db_query("SELECT project_id, app_title, creation_time, project_pi_firstname, project_pi_lastname, project_pi_email FROM redcap_projects WHERE status='1' AND app_title NOT LIKE '%test%' AND app_title NOT LIKE '%copy%' AND app_title NOT LIKE '%example%' AND app_title NOT LIKE '%longitudinal%' ORDER BY creation_time DESC");
$filename = "Consortium_Projects_Production_".$report_name.date("Y-m-d_H-m-s").".csv";

header('Pragma: anytextexeptno-cache', true);
header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$filename");

print "Project ID,Project Name,PI Name,PI Email,Create Date\n";
while ( $result = db_fetch_array($sql) ) { 
	print $result['project_id'].",".$result['app_title'].",".$result['project_pi_firstname']." ".$result['project_pi_lastname'].",".$result['project_pi_email'].",".$result['creation_time']."\n";
}
?>
