<?php

error_reporting(0);
if (ISSET($_GET['username'])) {
	$userid = $_GET['username'];
} else {
	header("Location: dashboard.php");
}

?>