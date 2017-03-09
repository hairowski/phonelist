<?php

	include 'header.php';
	include 'utils.php';
	
		echo'
		<nav>
			<ul>
				<li><a href="index.php?sec=phone" class="tab">Phonelist</a></li>					
				<li><a href="index.php?sec=tutorials" class="tab">Help Desk</a></li>				
				<li><a href="user_request.php" class="tab">New User</a></li>
				<li><a href="user_unsuscribe.php" class="tab">Remove User</a></li>
			</ul>
		</nav> ';

		echo'
		<div class="forms">
		<h1>Remove user Request</h1>
		';
		isset($_GET['opt'])? $opt = $_GET['opt'] : $opt = "form";
		
		if ($opt == 'form'){ //show form
			echo'<p>Please fill the information below and select what user accounts should be disabled.</p>
				<form name="req_form" action="user_unsuscribe.php?opt=send" method="post" id="uns_form">';			
					loadUsers("Applicant","req");
					loadUsers("User","user");
					echo'
					<label for="dep">Finish Date</label>
						<select name="day" class="smallsel" />
							<option></option>';
							for($i=1;$i<32;$i++){
								echo'<option>'.$i.'</option>';
							}						
						echo'
						</select>	
						<select name="month" class="smallsel" />
							<option></option>';
							for($i=1;$i<13;$i++){
								echo'<option>'.$i.'</option>';
							}						
						echo'
						</select><br />									
					<label for="ext" class="mini">Phone Ext.</label><input type="checkbox" name="extension" id="ext" value="Disable Phone Extension" />					
					<label for="correo" class="mini">Email</label><input type="checkbox" name="correo" id="correo" value="Email account"/>				
					<div id="opt">		
						<h2>Account</h2>
						<input type="radio" name="maccount" value="disable"/>Disable<br />	
						<input type="radio" name="maccount" value="mantain" checked/>Don\'t disable<br />						
						<input type="radio" name="maccount" value="forward" id="activate"/>Don\'t disable + Forward to
						<input type="email" name="cmail" id="email" placeholder="please write an email account"/>
						<h2>Messages</h2>						
						<input type="radio" name="mmsg" value="Keep" checked />Keep for
						<select name="num" class="smallsel" />
							<option></option>';
							for($i=1;$i<7;$i++){
								echo'<option>'.$i.'</option>';
							}						
						echo'
						</select>	
						<select name="period" class="smallsel2" />
							<option></option>
							<option>day(s)</option>
							<option>week(s)</option>
							<option>month(s)</option>
							<option>year(s)</option>		
						</select><br />	
						<input type="radio" name="mmsg" value="store" />Store until further notice<br />						
						<input type="radio" name="mmsg" value="delete" />Delete <br />								
					</div>
					<label for="skype" class="mini">Skype</label><input type="checkbox" name="skype" id="skype" value="Disable Skype account" />						
					<label for="plist" class="mini">Phonelist</label><input type="checkbox" name="plist" id="plist" value="Disable Phonelist profile"/>	
					<label for="macc" class="mini">Maker</label><input type="checkbox" name="macc" id="macc" value="Disable Maker Account"/>
					<label for="hmacc" class="mini">Hotel Maker</label><input type="checkbox" name="hmacc" id="hmacc" value="Disable Hotel Maker Account"/>
					<label for="computer" class="mini">Computer</label><input type="checkbox" name="computer" id="computer" value="Collect"/>				
					<div id="opt">
						<input type="radio" name="comp" value="Desktop computer" checked/>Collect Desktop Computer<br />
						<input type="radio" name="comp" value="Laptop computer "/>Collect Laptop Computer<br />
						<input type="radio" name="comp" value="Desktop + Laptop"/>Collect Both<br />						
					</div>					
					<label for="mob" class="mini">Mobile Phone</label><input type="checkbox" name="mob" id="mob" value="Collect: Mobile Phone"/>										
					<label for="number" class="mini">Mobile Line</label><input type="checkbox" name="number" id="number" value="Line"/>				
					<div id="opt">
						<input type="radio" name="line" value="User will keep the number" checked/>User will keep the number<br />
						<input type="radio" name="line" value="Disable the number"/>Disable the number<br />						
					</div>					
					<label for="fing" class="mini">Fingerprints</label><input type="checkbox" name="fing" id="fing" value="Delete Fingerprints"/>
					<label for="notes" class="mini">Comments:</label><textarea class="reqs" name="notes" placeholder="Please add any additional info if relevant."></textarea>
					
					<input type="submit" value="Send"/>					
				</form>
				';
		}elseif($opt == 'send'){ //process info 		
			//mail(to,subject,message,headers,parameters)	
			
			$msg = $msg."\n\n --------------------------- DATA ------------------------------- \n";
			
			$msg = "{panel:title=DATA}";
			if (isset($_POST['req']) && $_POST['req']!='') $msg = $msg . "\nApplicant: ".$_POST['req']."\n";
			if (isset($_POST['user']) && $_POST['user']!=''){
				$at_pos = strpos ($_POST['user'], "@");								
				$user = substr($_POST['user'], 0, $at_pos);	
				$user = str_replace('.',' ',$user);
				$msg = $msg . "\nUser: ".$user."\n";
				//if (isset($_POST['surname']) && $_POST['surname']!='') 
					//$msg = $msg . "\nUser: ".$_POST['name']." ".$_POST['surname']."\n";
					//$msg = $msg . "\nSurname: ".$_POST['surname']."\n";
			}			
			if (isset($_POST['dep']) && $_POST['dep']!='') $msg = $msg . "\nDepartment: ".$_POST['dep']."\n";
			if ((isset($_POST['day']) && $_POST['day']!='') && (isset($_POST['month']) && $_POST['month']!='')) 
				$msg = $msg . "\nFinishes on: ".$_POST['day']." / ".$_POST['month']."\n";			
			
			$msg = $msg."\n\n -------------------------- REQUEST --------------------------- \n";
				
			if (isset($_POST['account']) && $_POST['account']!='') $msg = $msg . "\n".$_POST['account']."\n";
			if (isset($_POST['extension']) && $_POST['extension']!='') $msg = $msg . "\n".$_POST['extension']."\n";
			if (isset($_POST['correo']) && $_POST['correo']!='') {
				$msg = $msg . "\n".$_POST['correo'].": ".$_POST['maccount'];if ((isset($_POST['cmail']) && $_POST['cmail']!='')) $msg = $msg ." to ".$_POST['cmail'];
				$msg = $msg . " and ".$_POST['mmsg']." messages ";
				if (isset($_POST['num']) && $_POST['num']!='' & isset($_POST['period']) && $_POST['period']!=''){
					$msg = $msg ."for ".$_POST['num']." ".$_POST['period'];
				}
				$msg = $msg ."\n";
			}
			if (isset($_POST['skype']) && $_POST['skype']!='') $msg = $msg . "\n".$_POST['skype']."\n";
			if (isset($_POST['plist']) && $_POST['plist']!='') $msg = $msg . "\n".$_POST['plist']."\n";			
			if (isset($_POST['macc']) && $_POST['macc']!='') $msg = $msg . "\n".$_POST['macc']."\n";	
			if (isset($_POST['hmacc']) && $_POST['hmacc']!='') $msg = $msg . "\n".$_POST['hmacc']."\n";	
			if (isset($_POST['computer']) && $_POST['computer']!='') $msg = $msg . "\n".$_POST['computer'].": ".$_POST['comp']."\n";
			if (isset($_POST['mob']) && $_POST['mob']!='') $msg = $msg . "\n".$_POST['mob']."\n";			
			if (isset($_POST['number']) && $_POST['number']!='') $msg = $msg . "\n".$_POST['number'].": ".$_POST['line']."\n";
			if (isset($_POST['fing']) && $_POST['fing']!='') $msg = $msg . "\n".$_POST['fing']."\n";			
			if (isset($_POST['notes']) && $_POST['notes']!='') $msg = $msg . "\n Comments: ".$_POST['notes']."\n";
			$msg = $msg."\n [ Hostname: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])." ] \n";
			
			echo $msg; exit;

			if (isset($_POST['req']) && $_POST['req']!='')
				mail("support@qwerty.com","User Disable / ".$user,$msg,"From:".$_POST['req']."");		
			else
				mail("ese@qwerty.com","User Disable / ".$user,$msg,"From:noreply@qwerty.com");
			echo'<p>Your request has been sent.<br />
				 We will notify you when it\'s done.<br />
				 Thanks!</p>
			';
		}
	echo'
		</div>
	</body>
	</html>';
	
?>
