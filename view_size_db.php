<?php
error_reporting(0);
require_once '../../redcap_connect.php';
include_once "sql_list.php";

$mysql = new MySQL();

$conso_db_size_sql = db_query($mysql->conso_db_size());
$conso_db_size = db_fetch_assoc($conso_db_size_sql);

$crsu_db_size = $mysql->crsu_db_size();
?>
<tr>
	<td>Total size of database</td>
	<td><?php echo round($conso_db_size['db_size']); ?> (MB)</td>
	<td><?php echo round($crsu_db_size); ?> (MB)</td>
	<td><?php echo (int) round($conso_db_size['db_size']) + (int) round($crsu_db_size); ?> (MB)</td>
</tr>