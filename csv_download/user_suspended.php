<?php
//error_reporting(0);
require_once '../../../redcap_connect.php';
include_once "sql_list.php";

$sql = db_query("select username,user_firstname,user_lastname,user_email from redcap_user_information where user_suspended_time != 'NULL'");
$filename = "Consortium_User_suspended_".$report_name.date("Y-m-d_H-m-s").".csv";

header('Pragma: anytextexeptno-cache', true);
header('Content-type: text/csv');
header("Content-disposition: attachment;filename=$filename");

print "Username,First Name,Last Name,E-mail\n";
while ( $result = db_fetch_array($sql) ) { 
	print $result['username'].",".$result['user_firstname'].",".$result['user_lastname'].",".$result['user_email']."\n";
}

?>