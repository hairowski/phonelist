<?php


include('config.php');
include('header.php');
echo '<div style="position:absolute;top:20%;left:40%; width:35%; height:80%;">';

$user_id=$_POST["user_id"];
$month=$_POST["month"];
$year=$_POST["year"];
$print=$_POST["print"];
$row="";
$a=0;






if(!isset($user_id))
{
   
   echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post">'."\n";
   echo '<h3>SELECT USER NAME</h3>';
   echo '<select name="user_id">'."\n";
   $query_user_list="SELECT concat(us.name,' ',us.surname) as name, us.id as id FROM users as us WHERE level!='disabled' ORDER BY us.name;";
   $user_list = $db->get_results($query_user_list);
   foreach ($user_list as $user)
   {
   echo '<option value="'.$user->id.'">'.$user->name.'</option>'."\n";
   }
   echo '</select><br><br>';
   
	echo '<h3>SELECT MONTH</h3>
	<select name="month">'.'\n'.'
	<option value="01">JANUARY</option>
	<option value="02">FEBRUARY</option>
	<option value="03">MARCH</option>
	<option value="04">APRIL</option>
	<option value="05">MAY</option>
	<option value="06">JUNE</option>
	<option value="07">JULY</option>
	<option value="08">AUGUST</option>
	<option value="09">SEPTEMBER</option>
	<option value="10">OCTOBER</option>
	<option value="11">NOVEMBER</option>
	<option value="12">DECEMBER</option>
	</select><br><br>
	<h3>SELECT YEAR</h3>
	<select name="year">'.'\n'.'
	<option value="2017">2017</option>
	<option value="2016">2016</option>
	</select>&nbsp;&nbsp;&nbsp;<br><br>
	<p><strong>PRINT FORMAT</strong>
	<input type="checkbox" name="print" value="1"></input><br><br></p>
    <input type="submit" name="Submit" value="Submit" /></form>';
}
else
{
 
	
 
   $query_by_user="SELECT concat(us.name,' ',us.surname) as name, tc.timestamp as timestamp, ev.name_event as event FROM users us, time_control tc, events ev WHERE tc.user_id=us.id AND tc.id_event=ev.id_event AND us.id='$user_id' ORDER BY timestamp ASC;";
   echo '<table border="1" style=text-align:center>'."\n";
   $user_events=$db->get_results($query_by_user);
  
   if($print) //formato de impresion 
   {
		
   	   echo '<tr><td>DATE</td><td>START TIME</td><td>FINISH TIME</td><td>TOTAL TIME/DAY</td><!--<td>LUNCH</td>--><td>EATING TIME</td><td>COMMENTS</td><tr>'."\n";
	   
	   foreach ($user_events as $event)
	   {
		   $readmonth = substr($event->timestamp,5,2);
		   $readyear = substr($event->timestamp,0,4);
		   $date = substr($event->timestamp,0, 10);
		   $hour = substr($event->timestamp, 11, 8);
		   $day = substr($event-timestamp,8, 2);
		    
		   
		   if (($month == $readmonth) && ($year == $readyear))
			{ 
				
				
				if ($user_id != $event->name){echo '<h1>'.$event->name.'</h1>'; echo '<strong><p>FORMATO IMPRESIÓN</p></strong>'; $user_id=$event->name;}
				if ($row != $date) //Cuando cambia de dia, primer estado del dia...
				{ 
					$starttime="";
					$finishtime="";
					$lunchtime="";
					$totaltime = 0;
					$b=0; //flag
					$eating=0;
					$eatingtime=0;
			
								
					switch ($event->event) 
					{
						case 'Working':
						$starttime = $hour;
						$lunchtime="";
						break;
						
						case 'Away':
						$starttime = $hour."Away";
						break;
						
						case 'Business travel':
						$starttime = "08:30:00 BT";	
						$totaltime = strtotime('08:00:00'); $totaltime = date('H:i:s', $totaltime); $printst=1;						
						break;
						
						case 'Vacations':
						$starttime = "08:30:00 VA";
						break;
						
						case 'Sick':
						$starttime = $hour."Sick";
						//$totaltime = strtotime('08:00:00'); $totaltime = date('H:i:s', $totaltime); $printst=1;
						
						break;
						
						case 'Out of office':
						$starttime = "Status error";
						echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
						break;
					}
					
					
					if ($totaltime !=0){echo '<tr><td ><strong>'.$date.'</strong></td><td>'.$starttime.'</td><td>&nbsp;</td><td>'.$totaltime.'</td><td>No lunch time</td><td>&nbsp;</td><td>&nbsp;</td>';}
					else{echo '<tr><td><strong>'.$date.'</strong></td><td contenteditable>'.$starttime.'</td>'; }
					$row = $date;
				}
				else  //Durante el mismo dia...
				{
						
						$b=$hour;
						
						
						switch ($event->event) 
						{
							case 'Lunch':
							if ($lunchtime != ""){$printst=0;}
							else {$lunchtime = $hour;$printst=1;}
							break;						
							
							case 'Out of office':
							$a = $hour;
							if ($finishtime < $a){$finishtime = $a;}
							if (strtotime($finishtime) > strtotime ('15:00:00')) {$printst=1;}
							else {$printst =0;}
							if ($lunchtime == "") {$lunchtime ="No lunch time"; $printst=1;}
							if (((strtotime($b))>= (strtotime($lunchtime))) && $lunchtime!="No lunch time" && $eating == 0){$eating=$b;}
							
							//else {$printst=0;}
							break;		
																					
							case 'Business travel':
							if ($finishtime == ""){$totaltime = strtotime('08:00:00'); $totaltime = date('H:i:s', $totaltime); $printst=1;}
							else {$printst=0;}
							if ($lunchtime == "") {$lunchtime ="No lunch time"; $printst=1;}
							else {$printst=0;}
							
							break;
							
							case 'Vacations':
							if ($finishtime == ""){$totaltime = strtotime('08:00:00'); $totaltime = date('H:i:s', $totaltime); $printst=1;}
							else {$printst=0;}
							if ($lunchtime == "") {$lunchtime ="No lunch time"; $printst=1;}
							else {$printst=0;}
							break;
							
							case 'Sick':
							//$finishtime=0;
							//$totaltime = strtotime('08:00:00'); $totaltime = date('H:i:s', $totaltime); $printst=1;
							break;
							
							case 'Working':
							$printst=0;
							
							if (((strtotime($b))>= (strtotime($lunchtime))) && $lunchtime!="No lunch time"){$eating=$b;$printst=1;}
							break;
							
							case 'Away':
							// if (($lunchtime == "") && ($lunch != 1)) {$lunchtime ="No lunch time"; $printst=1;}
							// else {$printst=0;}
							break;
						
						}
					
						
						if ($finishtime ==""){$finishtime=0; $printst=0;}
						
					
						if ($printst==1)
						{
							
							if ($totaltime == 0)
							{
								if ($lunchtime=="No lunch time"){$eatingtime="00:00:00";
									$totaltime = strtotime($finishtime) - strtotime($starttime);
									$totaltime = strtotime('-1 hour', $totaltime);
									$totaltime = date('H:i:s', $totaltime);	
								
								
								}
								else
								{
									$eatingtime = strtotime($eating) - strtotime($lunchtime);
									$totaltime = strtotime($finishtime) - strtotime($starttime);
									$totaltime = date('H:i:s', $totaltime);	
									$eatingtime = date('H:i:s', $eatingtime);	
									$eatingtime = strtotime ('-1 hour', strtotime($eatingtime)); //solo en live
									$eatingtime = date('H:i:s', $eatingtime);
									$totaltime = strtotime($totaltime) - strtotime($eatingtime);
									$totaltime = date('H:i:s', $totaltime);	
									$totaltime = strtotime ('-2 hour', strtotime($totaltime)); //solo en live
									$totaltime = date('H:i:s', $totaltime);	
								}
														
								
							}
														
														
							echo '<td contenteditable>'.$finishtime.'</td><td>'.$totaltime.'</td><!--<td contenteditable>'.$lunchtime.'</td>--><td contenteditable>'.$eatingtime.'</td><td contenteditable>&nbsp;</td></tr>'."\n";
						
						}
						
						
					
					
					
				}
				
				
			
			
				 if ($totaltime!=0)
				{	
					// echo $totaltime;
					$secs= $secs + substr($totaltime,6,2);
					$mins= $mins + substr($totaltime,3,2);
					 if ($hors>99) {$hors=$hors + substr($totaltime,0,3);}
					 else{$hors=$hors + substr($totaltime,0,2);}
					 if ($secs>=60){$mins=$mins+1; $secs=$secs-60;}
					 if ($mins>=60){$hors=$hors+1; $mins=$mins-60;}
					
				}
				
			}	
						
		} //foreach
		
			if($hors<10){$hors="0".$hors;}
			if($mins<10){$mins="0".$mins;}
			if($secs<10){$secs="0".$secs;}
			$totalhours = $hors.":".$mins.":".$secs;
			
			
			switch($month)
			{
				case '01': $monthname="JANUARY";break;
				case '02': $monthname="FEBRUARY";break;
				case '03': $monthname="MARCH";break;
				case '04': $monthname="APRIL";break;
				case '05': $monthname="MAY";break;
				case '06': $monthname="JUNE";break;
				case '07': $monthname="JULY";break;
				case '08': $monthname="AUGUST";break;
				case '09': $monthname="SEPTEMBER";break;
				case '10': $monthname="OCTOBER";break;
				case '11': $monthname="NOVEMBER";break;
				case '12': $monthname="DECEMBER";break;
				
				
			}
			
						
			echo "<h3>".$monthname." ".$year."</h3>";
			echo "<p>Total month hours: ".$totalhours."</p>";
			
   } else //formato detallado
   {
	    foreach ($user_events as $event)
	   {
		   $readmonth = substr($event->timestamp,5,2);
		   $readyear = substr($event->timestamp,0,4);
		   $date = substr($event->timestamp,0, 10);
		   $hour = substr($event->timestamp, 11, 8);
		   $day = substr($event->timestamp,8, 2);
		   
		   
		  if (($month == $readmonth) && ($year == $readyear))
			{ 
			  if ($user_id != $event->name){echo '<h1>'.$event->name.'</h1>'; echo '<strong><p>FORMATO DETALLADO</p></strong>'; $user_id=$event->name;}
			  
			  if ($row != $date) //Cuando cambia de dia...
			  {
				echo '<tr><td><strong>'.$date.'</strong></td><td>'.$hour.'</td><td>'.$event->event.'</td><tr>'."\n";
				
				$row = $date;
			  }
			  else //si es el mismo dia...
			  {
				 echo '<tr><td>&nbsp;&nbsp;&nbsp;</td><td>'.$hour.'</td><td>'.$event->event.'</td><tr>'."\n";
				 
			  }
				
			  
			}
	   
		}
	   
	   
   }
}
echo '</table>'."\n";

echo '<br><a href="users_reports.php">Back</a>'."\n";
echo '</div>';

?>
