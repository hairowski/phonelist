<?php 

require_once ('phonelist.php');
/*
	1) crear entrada en users
	2) guardar ID
	3) crear entrada en pics
	*) todo lo demás por defecto para que lo personalice el usuario
*/
require_once ('utils.php');

$action = isset($_GET['act']) ? $_GET['act'] : NULL;

if ($action == 'insert'){ //Insert user into DB
	
	$p = new phonelist();
	
	isset($_POST['login']) ? $p->set('user_login',$_POST['login']) : header('location:new_user.php?act=err&item=login');
	isset($_POST['mail']) ? $p->set('user_email',$_POST['mail']) : die("ERROR: mail cannot be empty!");
	isset($_POST['name']) ? $p->set('user_name',$_POST['name']) : die("ERROR: name cannot be empty!");
	isset($_POST['surname']) ? $p->set('user_lastname',$_POST['surname']) : die("ERROR: surname cannot be empty!");
	isset($_POST['location']) ? $p->set('user_location',$_POST['location']) : die("ERROR: location cannot be empty!");
	
	if(isset($_POST['department'])) $p->set('user_dep',$_POST['department']);	
	if(isset($_POST['mobile'])) $p->set('user_mobile',$_POST['mobile']);
	if(isset($_POST['ext'])) $p->set('user_ext',$_POST['ext']);
	if(isset($_POST['skype'])) $p->set('user_skype',$_POST['skype']);
	if(isset($_POST['acr'])) $p->set('user_acr',$_POST['acr']);
		
	
	$p->addUser();
	header('location:user.php?uid='.$p->theId());	
	
}else{
	include 'header.php';

	echo'
			<section id="profile">		
				<div id="profile">	
					<h1>New User</h1>					
					<form action="new_user.php?act=insert" method="post"> <!-- /------------------------/FORM/-----------------------/ -->
						<div id="form">						
								<label>Login </label><input name="login" type="text"  required/><br />
								<label>Email </label><input name="mail" type="email"  required/><br />
								<label>Name </label><input name="name" type="text"  required/><br />
								<label>Surname</label><input name="surname"  type="text"  required/><br /><br />
								<label>Location</label>
									<select name="location" style="width:153px;margin-left:2px;" required>
										<option value=""></option>
										<option value="internal">Internal</option>
										<option value="external">External</option>
									</select><br /><br />';							
								loadDepartments();
								echo'	
								<br />
								<label>Mobile</label><input name="mobile" type="tel"  /><br />
								<label>Extension</label><input name="ext" type="text"  /><br />
								<label>Skype</label><input name="skype" type="text"  /><br />
								<label>Acronym</label><input name="acr" type="text"  /><br /><br /><br />															
								<input id="button" class="fleft big" type="submit" value="Save">			
						</div>
					</form> <!-- /------------------------/FORM/-----------------------/ -->				
				</div>';
				if($action == 'err'){
					echo'<div><h2>The '.$_GET['item'].' cannot be empty. Fill it please.</h2></div>';
				}
			echo'	
			</section>';

	include 'footer.php';
}
?>
