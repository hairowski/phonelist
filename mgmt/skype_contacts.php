<?php 

require_once ('db.php');

$db = db_connect();			

if($result = $db->get_results("SELECT skype_login FROM users WHERE level='normal' and skype_login != '' and skype_login is not null")){
	/*
	1) create a text file
	2) Loop and add all users
	3) close file
	*/
	$f = fopen('shcontacts.vcf','w');
	foreach ($result as $username){
		$contact = 'BEGIN:VCARD'.chr(13).chr(10).'VERSION:3.0'.chr(13).chr(10).'N:'.$username->skype_login.''.chr(13).chr(10).'X-SKYPE-USERNAME:'.$username->skype_login.''.chr(13).chr(10).'END:VCARD'.chr(13).chr(10);
		fwrite($f,$contact);				
	}
	fclose($f);
	header('location:shcontacts.vcf');
}else{
	die ('ERROR: Cannot collect Skype users list [export_skype_contacts.php]');
}
?>