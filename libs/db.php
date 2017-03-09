<?php //Database queries

include "config.php";

include "libs/ez_sql_core.php";
include "libs/ez_sql_mysql.php";

function db_connect(){
	$db = new ezSQL_mysql($GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name'],$GLOBALS['db_server']); 
	$db->query("SET NAMES 'utf8'");
	// For production servers
	//$db->hide_errors();
	return $db;
}

?>
