<?php
// This include makes use of the EZ SQL connection to different DBs, MySQL in this case.
// API is divided into ez_sql_core.php, containing non db specific functions
// and ez_sql_mysql.php, containing MySQL related stuff.
// Info at http://www.jvmultimedia.com/portal/node/6

include_once(shinclude.'ez_sql_core.php');
include_once(shinclude.'ez_sql_mysql.php');

// Make use of db related from config.php.

global $globals;
$db = new ezSQL_mysql($globals['db_user'], $globals['db_password'], $globals['db_name'], $globals['db_server']);
// we now do "lazy connection.
//$db->persistent = $globals['mysql_persistent'];


$db->query("SET NAMES 'utf8'");

?>
