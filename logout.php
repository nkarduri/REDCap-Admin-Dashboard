<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username'];
} else {
	header("Location: dashboard.php");
}

require_once '../../redcap_connect.php';
$_SESSION = array();
session_unset();
session_destroy();
echo "<script>location.reload();</script>";
exit;

?>