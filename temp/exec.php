<?php
/*
date_default_timezone_set('UTC');
$creation_day = explode(" ", "2012-10-29 13:25:41");
$splitted_creation = explode("-", $creation_day[0]);
$creation_year = $splitted_creation[0];
$creation_month = $splitted_creation[1];
$creation_day = $splitted_creation[2];
echo $creation_year.", ".$creation_month.", ".$creation_day."<br>";

$today = explode(" ", date("Y-m-d H:i:s"));
$splitted_today = explode("-", $today[0]);
$today_year = $splitted_today[0];
$today_month = $splitted_today[1];
$today_day = $splitted_today[2];
echo $today_year.", ".$today_month.", ".$today_day."<br>";
*/

//$home = "C:/Users/boh/Downloads/";
$filename = "Consortium_Development_06-25-2014_04-50-10.csv";

header('Pragma: anytextexeptno-cache', true);
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=$filename");

//$csv_file = fopen($filename, 'w');

print "Project ID, Project Name, PI Name, PI Email, Create Date\n";

//fclose($csv_file); 

						<?php
						if ($err_flag == "1") { ?>
							<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Close</button><span><strong>ERROR: </strong> You entered an invalid user name or password!</span></div>
						<?php
						} else if ($err_flag == "2") { ?>
							<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Close</button><span><strong>ERROR: </strong> Your are not a user admin!</span></div>
						<?php
						} else if ($err_flag == "3") { ?>
							<br><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>Close</button><span><strong>ERROR: </strong> Please check your inputs!</span></div>
						<?php
						} ?>
?>