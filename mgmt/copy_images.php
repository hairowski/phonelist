<?php

/*	Vuelca las imagenes de la BD hacia el directorio images/profiles/	*/

require "db.php";


$db = db_connect();
if($results = $db->get_results("SELECT pics.image_name,pics.image_type,users.login,users.id FROM pics,users WHERE pics.user_id = users.id")){
	foreach($results as $u){
		$ext = strtolower(substr($u->image_type, -4));
		switch ($ext){
			case 'jpeg': $ext = '.jpg';break;
			case '/gif': $ext = '.gif';break;
			case '/png': $ext = '.png';break;
		}			
		if ($ext == '.jpg' || $ext == '.gif' || $ext == '.png') {			
			$iname = $u->login.$ext;
			$db->query("UPDATE pics SET pics.image_name = '$iname' WHERE pics.user_id = '$u->id'");
		}
	}	
}

//$db = db_connect();
if($results = $db->get_results("SELECT *,users.login FROM pics,users WHERE pics.user_id = users.id")){
	foreach($results as $pic){
		$ext = strtolower(substr($pic->image_name, -4));	
		if ($ext == '.jpg' || $ext == '.gif' || $ext == '.png') {
			echo "creando fichero"; 			
			$f = fopen('images/profiles/'.$pic->login.$ext,'w+');
			fwrite($f,$pic->image);
			fclose($f);
		}
	}
}

?>
