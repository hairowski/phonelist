<?php

	include 'header_forms.php';
	include 'utils.php';
	
		echo'
		<div class="forms">
		<h1>IT Department Requests</h1>
		';
		isset($_GET['opt'])? $opt = $_GET['opt'] : $opt = "form";
		
		if ($opt == 'form'){ //show form
			echo'<p>If you want to notify any incident related to IT, please fill the information below.</p>
				<form name="req_form" action="it_request.php?opt=send" method="post" id="req_form">					
					<!--<label for="name">Name</label><input type="text" name="name" id="name" class="longinput" placeholder="who\'s making the petition?" required>-->';
					loadUsers("Applicant","name");
					echo'
					<label for="subject">Subject</label><input type="text" name="subject" id="sub" class="longinput" placeholder="what\'s the problem?" required>					
					<label for="pri">Priority</label>
						<select name="pri" id="pri" required>
							<option></option>
							<option>1 - High</option>
							<option>2 - Medium</option>
							<option>3 - Low</option>							
						</select>	
						<label for="desc">Description</label>
						<textarea name="desc" rows="10" cols="40" required>
						</textarea>			
						<br />											
					<input type="submit" value="Send"/>					
				</form>
				';
		}elseif($opt == 'send'){ //process info		
			//mail(to,subject,message,headers,parameters)	
			$error_string = "Some Error occurred. Check the information provided in the form. ";
			$msg = "--------------------------- DATA ------------------------------- \n";
			if (isset($_POST['subject']) && $_POST['subject']!=''){
				if (isset($_POST['name']) && $_POST['name']!='') $msg = $msg . "\n Applicant: ".$_POST['name']."\n";									
				else echo $error_string;
				if (isset($_POST['pri']) && $_POST['pri']!='') $msg = $msg . "\n Priority: ".$_POST['pri']."\n";
				else echo $error_string;
				$msg = $msg."\n [ Date: ".date("D. d/m/Y")." ]";
				$msg = $msg."\n [ Hostname: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])." ]";
				$msg = $msg."\n\n -------------------------- DESCRIPTION --------------------------- \n";			
				if (isset($_POST['desc']) && $_POST['desc']!=''){
					$msg = $msg . "\n".$_POST['desc']."\n";
					echo $msg;
					//mail();		
					echo'<p>Your request has been sent. We will notify you when it\'s done. Thanks!</p>';
				}else{
					echo $error_string;				
				}				
			}else{
				echo $error_string;
			}
		}
	echo'
		</div>
	</body>
	</html>';
	
?>
