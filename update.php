<?php /* UPDATE.PHP */

require_once ('phonelist.php');

if (isset($_GET['uid'])) {
	$uid = $_GET['uid'];
	
	if (isset($_GET['sec'])) $sec = $_GET['sec'];
	else $sec = 'main';	
	switch($sec){
		case 'main':
			$flags = $_POST['langs'];
			$login = $_POST['login'];
			$mail = $_POST['mail'];
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$dep = $_POST['department']; //id del departamento			
			$mobile = $_POST['mobile'];
			$ext = $_POST['ext'];
			$skype = $_POST['skype'];
			$acr = $_POST['acr'];
			$p = new phonelist($uid,"","",$login,$name,$surname,$mail,$acr,$ext,$dep,$mobile,$skype,"",$flags);
			$p->updateUserInfo();			
			break;
		case 'status':	
			if (isset($_POST['status'])) $status = $_POST['status'];
			else die ("ERROR: no status selected [update.php]");			
			$p = new phonelist($uid,$status);
			$p->updateUserStatus();
			break;
		case 'comments':	
			if (isset($_POST['coms'])) $coms = $_POST['coms'];			
			else die ("ERROR: no comments info selected [update.php]");						
			$coms = addslashes (htmlspecialchars($coms));		//escapamos simbolos HTML			
			$p = new phonelist($uid,"",$coms);
			$p->updateUserComments();
			break;	
		default:
			header('location:user.php?uid='.$uid);
	}		 
	header('location:user.php?uid='.$uid.'&state=updated');//cambiar esto por un AJAX que modifique solo el stat_img
}else{
	die("ERROR: no user selected for update [update.php]");
}
?>