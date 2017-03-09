<?php 

	/*	save_events.php	*/
	
	require_once ('Event.php');
	
	if (isset($_POST['timestamp']) && isset($_GET['room'])){
		if(isset($_POST['checks'])) $checks = $_POST['checks'];
		$datetime = $_POST['timestamp'];
		$room = $_GET['room'];
	}else{
		die ("ERROR: missing parameters [save_events.php]");
	}
	
	$e = new event("",$room);
	$e->eraseEventRoom(); //preparamos la sala para insertar/actualizar info
		
	foreach ($checks as $key => $euid){
		//echo ("voy a guardar un evento! <br/>");
		//print_r($checks);
		//print_r($datetime[$key]);
		$e = new event($euid,$room,$datetime[$key]);		
		//print_r($e);exit;
		$e->addEvent();
	}
	
	//header("location:eventlist.php");
	header("Location:eventlist.php?sec=edit&status=updated");

?>