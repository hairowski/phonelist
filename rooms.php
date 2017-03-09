<?php 

	echo'
	<nav>
		<ul>
			<li><a class="tab-right cals ';if($room == 'conf') echo'selected'; echo'" href="index.php?sec=rooms&r=conf">Conference Room</a></li>
			<li><a class="tab-right cals ';if($room == 'white') echo'selected'; echo'" href="index.php?sec=rooms&r=white">White Room</a></li>
			<li><a class="tab-right cals ';if($room == 'black') echo'selected'; echo'" href="index.php?sec=rooms&r=black">Black Room</a></li>
			<li><a class="tab-right cals ';if($room == 'exec') echo'selected'; echo'" href="index.php?sec=rooms&r=exec">Executive Room</a></li>
		</ul>
	</nav>			
	<div id="conf_room" class="cal-cont ';if($room == 'conf') echo'active'; echo'">
		<object class="roomcal" type="text/html" data="calendarios/week.php?cal=Conference_Room" seamless></object>		
	</div>
	<div id="white_room" class="cal-cont ';if($room == 'white') echo'active'; echo'">
		<object class="roomcal" type="text/html" data="calendarios/week.php?cal=White_Room" seamless></object>		
	</div>
	<div id="black_room" class="cal-cont ';if($room == 'black') echo'active'; echo'">
		<object class="roomcal" type="text/html" data="calendarios/week.php?cal=Black_Room" seamless></object>
	</div>
	<div id="exec_room" class="cal-cont ';if($room == 'exec') echo'active'; echo'">
		<object class="roomcal" type="text/html" data="calendarios/week.php?cal=Executive_Room" seamless></object>
	</div>';

?>