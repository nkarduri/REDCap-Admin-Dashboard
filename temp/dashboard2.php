<?php
require_once "sql_list.php";

$userid = $_GET['username'];
echo $userid."<br>";

$mysql = new MySQL();
$user_name = db_query($mysql->get_username($userid));
?>
<p>a</p>