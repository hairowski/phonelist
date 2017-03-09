<?php

	include 'header.php';
	include 'utils.php';
		
		echo'<nav>
				<ul>
					<li><a href="index.php?sec=phone" class="tab">Phonelist</a></li>					
					<li><a href="index.php?sec=tutorials" class="tab">Help Desk</a></li>				
					<li><a href="user_request.php" class="tab">New User</a></li>
					<li><a href="user_unsuscribe.php" class="tab">Remove User</a></li>
				</ul>
			</nav> ';
		echo'
		<div class="forms">
		<h1>New user Request</h1>
		';
		isset($_GET['opt'])? $opt = $_GET['opt'] : $opt = "form";
		
		if ($opt == 'form'){ //show form
			echo'<p>Please fill the information below and select the options needed for the new user.</p>
				<form name="req_form" action="user_request.php?opt=send" method="post" id="req_form">					
					<!--<label for="req">Applicant</label><input type="text" name="req" id="req" placeholder="who makes the petition" required>-->';
					loadUsers("Applicant","req");					
					echo'
					<label for="name">Name</label><input type="text" name="name" id="name" placeholder="who joins SunHotels?" required>
					<label for="surname">Surname</label><input type="text" name="surname" id="surname" required>					
					';
					loadDepartments();
					echo'					
						<label for="location" class="">Location</label>
						<input type="radio" name="location" value="internal" checked/>Office
						<input type="radio" name="location" value="external" />External<br /><br />
						<label for="day">Start Date</label>
						<select name="day" class="smallsel" />
							<option></option>';
							for($i=1;$i<32;$i++){
								echo'<option>'.$i.'</option>';
							}						
						echo'
						</select> / 	
						<select name="month" class="smallsel" />
							<option></option>';
							for($i=1;$i<13;$i++){
								echo'<option>'.$i.'</option>';
							}						
						echo'
						</select><br />											
					<!--<label for="account" class="mini">Account</label><input type="checkbox" name="account" id="account" value="Create Sunhotels account" />-->
					
					<label for="correo" class="mini">Email</label><input type="checkbox" name="correo" id="correo" value="Create Email account"/>				
					<div id="opt">
						<input type="radio" name="mail" value="sunhotels" checked/>Sunhotels<br />
						<input type="radio" name="mail" value="eventholiday"/>Eventholiday<br />						
						<input type="radio" name="mail" value="other" id="activate"/>Other
						<input type="email" name="cmail" id="email" placeholder="please write an email account"/>
					</div>					
					<label for="skype" class="mini">Skype</label><input type="checkbox" name="skype" id="skype" value="Create Skype account" />											
					<label for="macc" class="mini">Maker</label><input type="checkbox" name="macc" id="macc" value="Create Maker Account"/>
					<label for="hmacc" class="mini">Hotel Maker</label><input type="checkbox" name="hmacc" id="hmacc" value="Create Hotel Maker Account"/>
					<label for="cmacc" class="mini">Contract Maker</label><input type="checkbox" name="cmacc" id="hmacc" value="Create Cotract Maker Account"/>					
					<label for="plist" class="mini">Phonelist</label><input type="checkbox" name="plist" id="plist" value="Create Phonelist profile"/>								
					<label for="ext" class="mini">Phone Ext.</label><input type="checkbox" name="extension" id="ext" value="Create Phone Extension" />	
					<label for="fing" class="mini">Fingerprints Reg.</label><input type="checkbox" name="fing" id="fing" value="Register Fingerprints"/>
					<label for="computer" class="mini">Computer</label><input type="checkbox" name="computer" id="computer" value="Order a computer"/>				
					<div id="opt">
						<input type="radio" name="comp" value="Desktop" checked/>Desktop Computer<br />
						<input type="radio" name="comp" value="Laptop"/>Laptop Computer<br />
						<input type="radio" name="comp" value="Desktop + Laptop"/>Both<br />						
					</div>							
					<label for="mob" class="mini">Phone</label><input type="checkbox" name="mob" id="mob" value="Phone"/>				
					<div id="opt">		
						<h2>Smartphone</h2>
						<input type="radio" name="terminal" value="Order a Smartphone" checked/>Order a Phone<br />	
						<input type="radio" name="terminal" value="Smartphone not needed" />Not needed<br />												
						<h2>Phone Line</h2>					
						<input type="radio" name="line" value="do nothing with user\'s line." checked/>Not applicable<br />
						<input type="radio" name="line" value="register a new line" checked/>Request new line<br />	
						<input type="radio" name="line" value="keep number" id="activate"/>Keep user\'s number						
						<input type="tel" name="number" id="pnum" placeholder="please write a valid phone number"/><br />					
					</div>
					<label for="notes" class="mini">Comments:</label><textarea class="reqs" name="notes" placeholder="Please add any additional info if relevant."></textarea>
					
					<input type="submit" value="Send"/>
				</form>
				';
		}elseif($opt == 'send'){ //process info		
			//mail(to,subject,message,headers,parameters)	
			
			$msg = "--------------------------- DATA ------------------------------- \n";			
			if (isset($_POST['req']) && $_POST['req']!='') $msg = $msg . "\nApplicant: ".$_POST['req']."\n";
			if (isset($_POST['name']) && $_POST['name']!=''){
				if (isset($_POST['surname']) && $_POST['surname']!='') 
					$user = $_POST['name']." ".$_POST['surname'];
					$msg = $msg . "\nUser: ".$_POST['name']." ".$_POST['surname']."\n";					
			}			
			if (isset($_POST['location'])) $msg = $msg . "\nLocation: ".$_POST['location']."\n";
			if (isset($_POST['department']) && $_POST['department']!='') $msg = $msg . "\nDepartment: ".printDepartment($_POST['department'])."\n";
			if ((isset($_POST['day']) && $_POST['day']!='') && (isset($_POST['month']) && $_POST['month']!='')) 
				$msg = $msg . "\nStarts on: ".$_POST['day']." / ".$_POST['month']."\n";	
			
			$msg = $msg."\n\n -------------------------- REQUEST --------------------------- \n";
			//if (isset($_POST['account']) && $_POST['account']!='') $msg = $msg . "\n".$_POST['account']."\n";
			if (isset($_POST['extension']) && $_POST['extension']!='') $msg = $msg . "\n".$_POST['extension']."\n";
			if (isset($_POST['correo']) && $_POST['correo']!='') {
				$msg = $msg . "\n".$_POST['correo'].": ".$_POST['mail'];
				if(isset($_POST['cmail']) && $_POST['cmail']!='') $msg = $msg ." --> ".$_POST['cmail']."\n";				
				$msg = $msg ."\n";
			}
			if (isset($_POST['skype']) && $_POST['skype']!='') $msg = $msg . "\n".$_POST['skype']."\n";
			if (isset($_POST['plist']) && $_POST['plist']!='') $msg = $msg . "\n".$_POST['plist']."\n";	
			if (isset($_POST['macc']) && $_POST['macc']!='') $msg = $msg . "\n".$_POST['macc']."\n";	
			if (isset($_POST['hmacc']) && $_POST['hmacc']!='') $msg = $msg . "\n".$_POST['hmacc']."\n";	
			if (isset($_POST['cmacc']) && $_POST['cmacc']!='') $msg = $msg . "\n".$_POST['cmacc']."\n";	
			if (isset($_POST['computer']) && $_POST['computer']!='') $msg = $msg . "\n".$_POST['computer'].": ".$_POST['comp']."\n";						
			if (isset($_POST['num']) && $_POST['num']!='') $msg = $msg . "\n".$_POST['num']."\n";
			if (isset($_POST['fing']) && $_POST['fing']!='') $msg = $msg . "\n".$_POST['fing']."\n";
			if (isset($_POST['mob']) && $_POST['mob']!=''){
				$msg = $msg . "\n".$_POST['mob'].": ";
				if (isset($_POST['terminal']) && $_POST['terminal']!='') $msg = $msg . $_POST['terminal'];
				if (isset($_POST['line']) && $_POST['line']!='') {
					$msg = $msg . " and ".$_POST['line'];
					if (isset($_POST['number']) && $_POST['number']!='') $msg = $msg . " : ".$_POST['number'];										
				}
				$msg = $msg."\n";
			}
			if (isset($_POST['notes']) && $_POST['notes']!='') $msg = $msg . "\n Comments: ".$_POST['notes']."\n";	
			$msg = $msg."\n [ Hostname: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])." ]\n";
			$msg = $msg."\n [ User: ".getenv('userdomain')."\\".getenv('username')." ] \n";
			
			//echo $msg;
	
			if (isset($_POST['req']) && $_POST['req']!='')
				mail("support@sunhotels.com","Sunhotels User Request / ".$user,$msg,"From:".$_POST['req']."");		
			else
				mail("sunhotelstest@gmail.com","Sunhotels User Request / ".$user,$msg,"From:noreply@sunhotels.com");
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
