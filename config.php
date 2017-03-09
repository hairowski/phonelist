<?php
define("root_dir", dirname(__FILE__));
define("css", dirname(__FILE__).'\css\\');
define("doc", dirname(__FILE__).'\docs\\');
define("img", dirname(__FILE__).'\images\\');
define("lib", dirname(__FILE__).'\libs\\');
define("mgmt", dirname(__FILE__).'\mgmt\\');

// Better to do local modification in hostname-local.php
$server_name	= $_SERVER['SERVER_NAME'];
$dblang			= 'es';

$GLOBALS['db_server'] = 'localhost';
$GLOBALS['db_name'] = 'intranet';
$GLOBALS['db_user'] = 'root';
$GLOBALS['db_password'] = '';
$GLOBALS['mysql_persistent'] = true;

$GLOBALS['base_url'] = '/';
$GLOBALS['favicon']= 'images/favicon/favicon.ico';

//ob_start();
//include_once constant("lib").'utils.php';

?>
