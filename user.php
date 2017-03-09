<?php //PROFILE PAGE

//* we read $uid and $state retrieved from GET in Index.php
//ob_start();
require_once ('phonelist.php');
require_once ('utils.php');

if (isset($_GET['uid'])){
			$uid = $_GET['uid'];
		}else{
			$uid = "0"; 
		} 
		if (isset($_GET['state'])){
			$state = $_GET['state'];
		}else{
			$state = "none"; 
		}

$p = new phonelist();
$p->readUser($uid);
$p->loadUser($p->theUserInfo());
$p->loadUserFlags();

include 'header.php';

echo'
		<section id="profile">		
			<div id="profile">	
				<h1>'.$p->theName().' '.$p->theLastName().' ('.$p->theAcronym().')</h1>
				<form action="update.php?uid='.$uid.'&sec=status" method="post">
					<div class="status_select" style="background: url(images/big_'.$p->theStatImg().') no-repeat top;">';
						//echo $p->theStatus();exit;
						loadStatus($p->theStatus());
					echo'
					</div>
				</form>
				<form action="update.php?uid='.$uid.'" method="post"> <!-- /------------------------/FORM/-----------------------/ -->
					<div id="leftcol">
						<a href="upload.php?user_id='.$uid.'"><img id="big_face" src="images/profiles/'.$p->theUserImg().'" /></a>							
						<div id="flags">';													
							loadFlags($p->theFlags());					
						echo '
						</div>
					</div>										
					<div id="form">						
							<label>Login </label><input name="login" type="text" value="'.$p->theLogin().'" required/><br />
							<label>Email </label><input name="mail" type="email" value="'.$p->theMail().'" required/><br />
							<label>Name </label><input name="name" type="text" value="'.$p->theName().'" required/><br />
							<label>Surname</label><input name="surname"  type="text" value="'.$p->theLastName().'" required/><br /><br />';							
							loadDepartments($p->theDepartment());
							echo'
							<label>Mobile</label><input name="mobile" type="tel" value="'.$p->theMobile().'" /><br />
							<label>Extension</label><input name="ext" type="text" value="'.$p->theExt().'" /><br />
							<label>Skype Login</label><input name="skype" type="text" value="'.$p->theSkype().'" /><br />
							<label>Acronym</label><input name="acr" type="text" value="'.$p->theAcronym().'" /><br /><br /><br />
														
							<input id="button" class="fleft big" type="submit" value="Save" onclick="document.getElementById(\'imgloader\').className=\'showloader\'">							
							';
							if($state == 'updated')echo'<img id="updated" src="images/3redtick.png" />';
							
							echo'<img id="imgloader" class="hideloader" src="images/loader.gif" />
												
					</div>
				</form> <!-- /------------------------/FORM/-----------------------/ -->
				<div id="coms">					
					<form action="update.php?uid='.$uid.'&sec=comments" method="post" id="coms_form">
						<label id="lab_coms">Comments:</label>						
						<textarea id="usercoms" name="coms" cols="1" rows="1" placeholder="Write here your comments (200 chars max.)">'.$p->theComment().'</textarea>	
						<input id="button" class="fright small" type="button" value="Clear" onclick="document.getElementById(\'usercoms\').value=\'\'">
						<input id="button" class="fright small" type="submit" value="Modify" onclick="document.getElementById(\'imgloader\').className=\'showloader\'"> <!--formtarget="_blank"-->
					</form>
				</div>
			</div>
		</section>';

include 'footer.php';

?>
