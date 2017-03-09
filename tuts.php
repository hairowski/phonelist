
<?php 

$tut_list = ListDirectory("tutorials");

echo'

<div id="tuts">
	<h1> Tutorials </h1>
	<p>Here you will find some tutorials, in case you need guidance on common tasks: </p>
	<ol>';
	foreach($tut_list as $tut_name ){
		echo'<li><a href="tutorials/'.$tut_name.'">'.$tut_name.'</a></li>';
	}

	echo'
	</ol>
	<h1> Skype Contacts </h1>
	<ul>
		<li><a href="skype_contacts.php">Download SunHotels Skype contacts</a></li>
	</ul>
	<h1> IT Department Requests </h1> 
	<!--<ul>
		<li><a href="it_request.php">General Requests</a></li>
	</ul>-->	
	<ul>
		<li><a href="user_request.php">Staff Requests</a> ( must be used ONLY by Department Managers )</li>
	</ul>
	<br />
</div>';

?>
