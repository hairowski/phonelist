<?php

require_once ('db.php');

class phonelist {

	var $db;
	var $user_list = array(); 	//resultado de la consulta de usuarios a la BD
	var $user_info; 			//resultado de la consulta de perfil individual
	var $user_id;
	var $user_login;
	var $user_name;
	var $user_lastname;
	var $user_email;
	var $user_acr;
	var $user_ext;
	var $user_dep; 
	var $user_location;
	var $user_mobile;
	var $user_skype;
	var $user_comment;
	var $user_img;
	var $user_status;	
	var $user_statimg; 			//la foto del estado	
	var $user_flags = array();
	
		
	function __construct($id="",$status="",$com="",$login="",$name="",$lastname="",$email="",$acr="",$ext="",$dep="",$mobile="",$skype="",$stimg="",$flags= array()){				
		$this->db = db_connect();			
		$this->user_id = $id;
		$this->user_login = $login;
		$this->user_name = $name;
		$this->user_lastname = $lastname;	
		$this->user_email = $email;			
		$this->user_acr = $acr;			
		$this->user_ext = $ext;
		$this->user_dep = $dep;
		$this->user_mobile = $mobile;
		$this->user_skype = $skype;
		$this->user_comment = $com;		
		//$user->user_img = ;
		$this->user_status = $status;
		$this->user_statimg = $stimg;			
		$this->user_flags = $flags;		
	}
	
	//--- METODOS ---//	
	function readUserList($order){ 		
		//if ($result = $db->get_results("SELECT users.*,pics.image_id FROM users,pics WHERE users.id = pics.user_id AND users.level !='disabled'")){
		//if ($result = $db->get_results("SELECT users.*,pics.image_id,events.img_event,departments.shortname FROM users,pics,events,departments WHERE users.id = pics.user_id AND users.level !='disabled' AND users.status = events.id_event AND users.department = departments.id ORDER BY users.id ASC")){
		if ($result = $this->db->get_results("SELECT users.*,pics.image_name,events.img_event,departments.shortname FROM users,pics,events,departments WHERE (users.id = pics.user_id OR pics.user_id IS NULL)AND users.level !='disabled' AND users.status = events.id_event AND users.department = departments.id AND users.location = 'internal' ORDER BY users.$order ASC")){
			$this->user_list = $result;	
					// DO SOMETHING HERE!
		}else{
			//no existe entrada en imagenes --> crear entrada en 'pics' cuando alta usuario
			//status no es correcto --> controlar en alta usuario
			//department no es correcto --> controlar en alta usuario
			die ('ERROR: Cannot collect users list info [phonelist.php]');
		}
		
	}
	
	function readExtUserList($order){ 		
		if ($result = $this->db->get_results("SELECT users.*,pics.image_name,events.img_event,departments.shortname FROM users,pics,events,departments WHERE (users.id = pics.user_id OR pics.user_id IS NULL)AND users.level !='disabled' AND users.status = events.id_event AND users.department = departments.id AND users.location = 'external' ORDER BY users.$order ASC")){
			$this->user_list = $result;	
		}else{			
			die ('ERROR: Cannot collect external users list info [phonelist.php]');
		}
		
	}
	
	function readUser($uid){ 
		if ($result = $this->db->get_results("SELECT users.*,pics.image_name,events.img_event,departments.shortname FROM users,pics,events,departments WHERE users.id = pics.user_id AND users.status = events.id_event AND users.department = departments.id AND users.id = $uid")){
			$this->user_info = $result[0];		
		}elseif ($result = $this->db->get_results("SELECT users.*,events.img_event,departments.shortname FROM users,events,departments WHERE users.status = events.id_event AND users.department = departments.id AND users.id = $uid")){
			$this->user_info = $result[0];				
			//print_r($this->user_info);exit;
		}else{
			die ('ERROR: Cannot collect user info [phonelist.php]');
		}
		
	}
	
	function loadUser($user){	
		$this->user_id = $user->id;
		$this->user_login = $user->login;
		$this->user_name = $user->name;
		$this->user_lastname = $user->surname;	
		$this->user_email = $user->email;			
		$this->user_acr = $user->acronym;			
		$this->user_ext = $user->ext;
		$this->user_dep = $user->shortname;
		$this->user_mobile = $user->mobile;
		$this->user_skype = $user->skype_login;
		$this->user_comment = $user->comment;	
		if(isset($user->image_name)){ // && ($user->image_name != NULL)
			$this->user_img = $user->image_name;
		}else{
			$this->user_img = "head.png";
		}
		$this->user_status = $user->status;
		$this->user_statimg = $user->img_event;			
	}
	
	function loadUserFlags(){
		unset($this->user_flags);
		if ($result =  $this->db->get_results("SELECT flagname FROM user_language,language WHERE user_id = $this->user_id AND language_id = lang_id ORDER BY language_id ASC")){			
			foreach($result as $flag){
				$this->user_flags[] = $flag->flagname;				
			}
		}else{
			//el usuario no tiene ningun idioma asignado
			//die ('ERROR: Cannot collect user languages [phonelist.php]');
			$this->user_flags[] = NULL;
		}
	}
	
	function updateUserInfo(){ 		
		$this->db->query("UPDATE users SET login = '$this->user_login', email = '$this->user_email', name = '$this->user_name', surname = '$this->user_lastname', department = '$this->user_dep', ext = '$this->user_ext', mobile = '$this->user_mobile', skype_login = '$this->user_skype', acronym = '$this->user_acr' WHERE id = '$this->user_id'");
			//or die ('ERROR: Cannot update user information [phonelist.php]'.$this->db->debug());
		$this->db->query("DELETE FROM user_language WHERE user_id='$this->user_id'");
			//or die ('ERROR: Cannot update user languages(1) [phonelist.php]');
		foreach($this->user_flags as $f){
			$this->db->query("REPLACE INTO user_language SET user_id='$this->user_id', language_id='$f'") or 
			die ('ERROR: Cannot update user languages(2) [phonelist.php]');
		}
		//$this->db->debug();		
	}
	
	function updateUserStatus(){
		$this->db->query("UPDATE users 
						  SET users.status =(SELECT events.id_event FROM events WHERE events.name_event = '$this->user_status') 
						  WHERE users.id = '$this->user_id'");
						//or die ('ERROR: Cannot update user status [phonelist.php]'.$this->db->debug());
		$this->db->query("INSERT INTO time_control
						  SET id_event =(SELECT events.id_event FROM events WHERE events.name_event = '$this->user_status'), user_id = '$this->user_id'");
	}
	
	function updateUserComments(){		
		$this->db->query("UPDATE users 
						  SET users.comment = '$this->user_comment' 
						  WHERE users.id = '$this->user_id'");
	}
	
	function addUser(){
		$this->db->query("INSERT INTO users (login,email,name,surname,location,department,mobile,ext,skype_login,acronym) 
		VALUES ('$this->user_login','$this->user_email','$this->user_name','$this->user_lastname','$this->user_location','$this->user_dep','$this->user_mobile','$this->user_ext','$this->user_skype','$this->user_acr')");
		$this->user_id = mysql_insert_id();
		$this->db->query("INSERT INTO pics (image_type,image_size,image_name,user_id) VALUES ('image/png','width=\"188\" height=\"250\"','head.png','$this->user_id')");		
	}
	
	//--- GETTERS ---//	

	/*function get($field){
		return $this->$field;
	}*/

	
	function theUserList(){
		return $this->user_list;
	}
	
	function theUserInfo(){
		return $this->user_info;
	}
	
	function theId(){
		return $this->user_id;
	}
	
	function theLogin(){
		return $this->user_login;
	}
	
	function theName(){
		return $this->user_name;
	}
	
	function theLastName(){
		return $this->user_lastname;
	}
	
	function theMail(){
		return $this->user_email;
	}
	
	function theAcronym(){
		return $this->user_acr;
	}
	
	function theExt(){
		return $this->user_ext;
	}
	
	function theDepartment(){
		return $this->user_dep;
	}
	
	function theMobile(){
		return $this->user_mobile;
	}
	
	function theSkype(){
		return $this->user_skype;
	}
	
	function theComment(){
		return $this->user_comment;
	}
	
	function theUserImg(){
		return $this->user_img;
	}
	
	function theStatus(){
		return $this->user_status;
	}
	
	function theStatImg(){
		return $this->user_statimg;
	}
	
	function theFlags(){
		return $this->user_flags;
	}
	
	/*function theIdPic(){
		return $this->user_idpic;
	}*/
	
	//--- SETTERS ---//
	
	function set($field,$value){
		$this->$field = $value;
	}
		
}


?>
