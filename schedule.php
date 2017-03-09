<?php

require_once ('icalReader.php');	
require_once ('Event.php');

function showRoomName($room = 1){
	switch($room){
		case 1 : return "White Room";break;
		case 2 : return "Black Room";break;
		case 3 : return "Conference Room";break;
		case 4 : return "Executive Room";break;
	}
}

$cals[1] = new ical('https://mail.sunhotels.com/OWA/calendar/689580b34e4d4460acf524030cd53c39@sunhotels.com/6f6eff95568244ba8f96cc1647d33e9a6785828459988279174/calendar.ics');
$cals[2] = new ical('https://mail.sunhotels.com/OWA/calendar/64a0f6df8c6f4e078f0c66642cfcdd42@sunhotels.com/fb1825c22f2547f48bb108e4388a98b82764660919182050952/calendar.ics');
$cals[3] = new ical('https://mail.sunhotels.com/OWA/calendar/53a4ed562d424e3085fdc06c109d1a6f@sunhotels.com/45764369117046e79fb69ffde264b04616221432303392068260/calendar.ics');
$cals[4] = new ical('https://mail.sunhotels.com/OWA/calendar/f830bf09a47e41278ac216ac6c929a66@sunhotels.com/998f9709f6a6474ea0c90ca630d98c844486908510248423319/calendar.ics');

$now = date('Y/m/d H:i:s');

if($now > date('Y/m/d 16:00:00')){ 
	$today = (string)date('Y/m/d 16:00:00');
}elseif($now > date('Y/m/d 12:00:00')){
	$today = (string)date('Y/m/d 12:00:00');
}else{
	$today = (string)date('Y/m/d 00:00:00');
}

$tomorrow = (string)date('Y/m/d 00:00:00', strtotime('+1 day'));
 // echo $now.'<br />';
 // echo $today.'<br />';
 // echo $tomorrow.'<br /><br />';
 // exit;
echo'<article id="rooms">';

for($room=1;$room<=4;$room++){
	//$room = 4;
	//$events = $cals[$room]->events();				
	//$dbevents = array();
	//$visits = array();
	//$internals = array();
	//echo $room;
	echo'<section class="small_col">
			<h1 class="center">'.showRoomName($room).'</h1>';
	if ($cals[$room]->hasEvents()){
		$events = $cals[$room]->eventsFromRange($today,$tomorrow);		
		if (count($events) !== 0){															
			foreach($events as $e){
				$Start_time = str_replace('T','',$e['DTSTART']);
				$End_time = str_replace('T','',$e['DTSTART']);				
				echo'
					<div class="eventtab room_'.$room.'">
						<p class="title">'.$e['SUMMARY'].'</p>							
						<p class="date">Date : '.$cals[$room]->formatIcalDate($e['DTSTART']).'</p>
						<p class="date">Time : '.$cals[$room]->formatIcalTime($e['DTSTART']). 'h / '.$cals[$room]->formatIcalTime($e['DTEND']). 'h </p>								
					</div>
					<br />';
			}		
		}			
	}		
	echo'</section>';
}
echo'</article>';
	
?>
