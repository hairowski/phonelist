<?php /* utils.PHP */

require_once ('db.php');
require ('libs/simpleimage.php');

function loadDepartments ($selected=""){
	$db = db_connect();
	if($deps = $db->get_results("SELECT * FROM departments")){
		echo '<div class="custom_select">
				<label>Department </label>						
				<select name="department" style="width:153px;margin-left:2px;" required>
					<option value=""></option>';
		foreach($deps as $dep){
			echo '<option value="'.$dep->id.'"';if($selected == $dep->shortname) echo ' selected';
			echo'>'.$dep->name.'</option>';
		}
		echo '</select></div>';		
	}else{
		die ("ERROR: cannot load Departments [utils.php]");
	}
}

function printDepartment ($id=0,$short=""){
	$db = db_connect();
	if ($id!=0){
		if($dep = $db->get_row("SELECT name FROM departments WHERE id = $id"))
			return $dep->name;
		else
			die ("ERROR: cannot print Department (wrong id) [utils.php]");
	}elseif ($short != ""){
		if($dep = $db->get_row("SELECT name FROM departments WHERE shortname = $short"))
			return $dep->name;
		else
			die ("ERROR: cannot print Department (wrong shortname) [utils.php]");
	}else{
		die ("ERROR: missing parameter for printDepartment [utils.php]");
	}
}

function loadUsers ($label="",$field=""){
	$db = db_connect();
	if($users = $db->get_results("SELECT * FROM users WHERE Level='normal' ORDER BY name,surname")){
		echo '<div class="custom_select">
				<label>'.$label.' </label>						
				<select name="'.$field.'" style="width:153px;margin-left:2px;" required>
					<option value=""></option>';
		foreach($users as $u){
			echo '<option value="'.$u->email.'">'.$u->name.' '.$u->surname.'</option>';
		}
		echo '</select></div>';		
	}else{
		die ("ERROR: cannot load Users [utils.php]");
	}
}

function loadFlags ($selected){
	$db = db_connect();
	if($flags = $db->get_results("SELECT * FROM language")){
		foreach ($flags as $f){						
			echo 
			'<img title="'.$f->fullname.'" src="images/flags/'.$f->flagname.'" />						
			<input type="checkbox" name="langs[]" value="'.$f->lang_id.'"';
			if (in_array($f->flagname,$selected)) echo' checked';
			echo'/>';					
		}
	}else{
		die ("ERROR: cannot load Flags [utils.php]");
	}						
}

function loadStatus ($selected){
	$db = db_connect();
	if($status = $db->get_results("SELECT * FROM events")){
	echo'<select name="status" id="statselect" onchange="this.form.submit()">';
		foreach ($status as $stat){	
			echo'			
				<option value="'.$stat->name_event.'"';
				if($selected == $stat->id_event) echo'selected';
				echo'>'.$stat->name_event.'</option>';
		}
		echo'</select>';
	}
	/*if(!empty($selected)){
		echo'
		<select name="status" id="statselect" onchange="document.getElementById(\'imgloader\').className=\'showloader\';this.form.submit()">			
			<option value="Working" ';if($selected == 1)echo'selected';echo'>Working</option>			
			<option value="Out of office" ';if($selected == 2)echo'selected';echo'>Out of office</option>			
			<option value="Lunch" ';if($selected == 3)echo'selected';echo'>Lunch</option>			
			<option value="Sick" ';if($selected == 7)echo'selected';echo'>Sick</option>			
			<option value="Vacations" ';if($selected == 8)echo'selected';echo'>Vacations</option>
		</select>';		
	}else{
		die ("ERROR: NO status given to loadStatus[utils.php]");
	}*/
}


function copyImage($user_id){ //lee una imagen de usuario y la copia al directorio de profile images
	//FALTA QUE BORRE CUALQUIER FOTO ANTERIOR DEL USUARIO EN EL DIRECTORIO DE PROFILES
	$db = db_connect();
	if($results = $db->get_row("SELECT image_name,image FROM pics WHERE pics.user_id ='$user_id' ")){
		$f = fopen('images/profiles/'.$results->image_name,'w+');
		fwrite($f,$results->image);
		fclose($f);
	}
}

function prepareImage($user_id,$img_mime){ //prepara el nombre de la imagen a subir para que sea el correcto.
	$db = db_connect();	
	if($user = $db->get_var("SELECT login FROM users WHERE id = '$user_id'")){
		$ext = strtolower(substr($img_mime, -4));		
		switch ($ext){
			case 'jpeg': $ext = '.jpg';break;
			case '/gif': $ext = '.gif';break;
			case '/png': $ext = '.png';break;
		}			
		if ($ext == '.jpg' || $ext == '.gif' || $ext == '.png') {			
			//echo $user.$ext;exit;
			return $user.$ext;
			//$db->query("UPDATE pics SET pics.image_name = '$iname' WHERE pics.user_id = '$user_id'");
		}else{
			die ("ERROR: you selected an image with invalid filetype. Must be jpg, png or gif [utils.php]");
		}		
	}else{
		die ("ERROR: the user id is not in the database [utils.php]");
	}
}

function resizeProfilePicture($filename){	//redimensiona una imagen de perfil al tamanyo adecuado
	$img = new SimpleImage();
	$img->load($filename);	
	$img->resizeToHeight(250);
	if($img->getWidth() > 188){
		$x_ini = ($img->getWidth()-188)/2;
		$img->crop($x_ini,0,188,250);
	}
	$img->save($filename);	
	
}

function resizeProfileDirectory(){	//redimensiona todas las imagenes del directorio 'profiles'	
	$src_dir  = "images/import/";	
	$images = dir("images/import/");

	while($i = $images->read()){
		//echo '<p>'.$i.'</p>';
		if($i != '.' && $i !='..'){		
			resizeProfilePicture($src_dir.$i);	
		}
	}
	$images->close();
}

/* GetCalendar:
 * 1)Accede a un calendario remoto
 * 2)Copia el contenido del calendario
 * 3)Almacena el contenido en un nuevo fichero en el servidor webdav
 * 
 */
function getCalendar($cal_source,$newcal_name){
	if (!$cal_source) return false;	
	$data = file_get_contents($cal_source);
	$name = str_replace('_',' ',$newcal_name);
	$data = str_replace('X-WR-CALNAME:Calendar','X-WR-CALNAME:'.$name,$data);
	//LOCK_EX = flag para bloquear el fichero mientras escribe
	//file_put_contents('C:\wamp\www\intranet\\'.$newcal_name.'.ics',$data,LOCK_EX); 
	file_put_contents('/var/www/webdav/'.$newcal_name.'.ics',$data,LOCK_EX); 
	
}

function ListDirectory ($directory) 
  {
    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
        $results[] = $file;
      }
    }
    // tidy up: close the handler
    closedir($handler);
    // done!
    return $results;
  }

?>
