<?php	//PHONELIST PAGE
	
	$p = new phonelist();	
	switch($scope){
		case 'int' :
			$p->readUserList($order);  //leemos info de los usuarios internos
			break;
		case 'ext' :
			$p->readExtUserList($order);  //leemos info de los usuarios externos
			//echo count($p->theUserList()); exit();
			break;
		default : 
			$scope = 'err';
	}	
		
	echo'					
	<div id="menu_top">
		<a href="index.php?sec=phone&view=list&ord='.$order.'&scp='.$scope.'"><img src="images/list.png" class="viewer" title="List view"/></a>
		<a href="index.php?sec=phone&view=tab&ord='.$order.'&scp='.$scope.'"><img src="images/tab.png" class="viewer" title="Tab view"/></a>
		<a href="index.php?sec=phone&view='.$view.'&ord=name&scp='.$scope.'" class="sort first';if($order == 'name')echo' actual';echo'" title="Order by Name">Name</a>
		<a href="index.php?sec=phone&view='.$view.'&ord=surname&scp='.$scope.'" class="sort';if($order == 'surname')echo' actual';echo'" title="Order by Surname">Surname</a>
		<a href="index.php?sec=phone&view='.$view.'&ord=ext&scp='.$scope.'" class="sort';if($order == 'ext')echo' actual';echo'" title="Order by Extension">Extension</a>
		<a href="index.php?sec=phone&view='.$view.'&ord=acronym&scp='.$scope.'" class="sort';if($order == 'acronym')echo' actual';echo'" title="Order by Acronym">Acronym</a>
		<a href="index.php?sec=phone&view='.$view.'&ord=department&scp='.$scope.'" class="sort';if($order == 'department')echo' actual';echo'" title="Order by Department">Department</a>
		<a href="index.php?sec=phone&view='.$view.'&ord=status&scp='.$scope.'" class="sort last';if($order == 'status')echo' actual';echo'" title="Order by Status">Status</a>						
	</div>
	<br />
	<div id="users_list" border="1">';
	switch($view){
		case 'list' : 
				$total = count($p->theUserList());
				$half = ceil($total/2);
				echo'<table class="list">';						
				
				foreach ($p->theUserList() as $ind => $user){					
					if ($ind == $half){
						echo'</table>';						
						echo'<table class="list">';
					}
					$p->loadUser($user); //cargamos info
					$p->loadUserFlags();//cargamos flags
					/*print_r($p->theFlags());
					foreach ($p->theFlags() as $flag){							
										echo'<img src="images/flags/'.$flag.'" />';
									}exit;*/
					echo'	<tr>
								<td class="name"><p><a href="user.php?uid='.$p->theId().'" >'.$p->theName().' '.$p->theLastName().' ('.$p->theAcronym().')</a></p></td>
								<td class="ext"><p>Ext: '.$p->theExt().' ('.$p->theDepartment().')</p></td>
								<td class="mob"><p>Mob: '.$p->theMobile().'</p></td>
								<td class="flags"><div class="user_flags_list">';									
									foreach ($p->theFlags() as $flag){							
										echo'<img src="images/flags/'.$flag.'" />';
									}
									echo'
								</td>		
								<td><img id="little_status" src="images/'.$p->theStatImg().'" /></td>
							</tr>';
				}
				echo'</table>';
				break;
		case 'tab' :
				foreach ($p->theUserList() as $user){
					$p->loadUser($user); //cargamos info
					$p->loadUserFlags();//cargamos flags					
					echo'
					<!-- USER PROFILE -->
						<div class="user_profile">				
							<div id="user_face">
								<img class="portrait" src="images/profiles/'.$p->theUserImg().'" /> <!-- src="show_image.php?id='.$p->theId().'" -->
							</div>
							<div class="user_info">
								<p><a href="user.php?uid='.$p->theId().'" >'.$p->theName().' '.$p->theLastName().' ('.$p->theAcronym().')</a></p>					
								<p>Ext: '.$p->theExt().' ('.$p->theDepartment().')</p>
								<p>Mobile: '.$p->theMobile().'</p>										
								<div class="user_flags">';
									//print_r($p->theFlags());exit;
									foreach ($p->theFlags() as $flag){							
										echo'<img src="images/flags/'.$flag.'" />';
									}
									if($p->theComment()!= NULL){
										echo'
										<div id="com_but">
											<img id="info" src="images/info.png" />
											<div id="comments">
												'.str_replace("\n","<br />",$p->theComment()).'						
											</div>
										</div>';
									}
								echo'
								</div>
							</div>
							<div id="user_status">';					
								echo'
								<img id="status" src="images/'.$p->theStatImg().'" />	
								<!--<div id="comments">
									<p>'.$p->theComment().'<p>						
								</div>-->
							</div>
						</div>';
				}
				break;
	}	
	echo'		
	</div>';
	
	
?>
