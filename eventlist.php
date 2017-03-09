<?php 

/* Parsea los calendarios ICS indicados 
 * y muestra el tiempo y la hora de diversas
 * localizaciones. 
 */
	
require_once ('icalReader.php');
require_once ('Event.php');

isset($_GET['sec']) ? $sec = $_GET['sec'] : $sec = "list";
isset($_GET['room'])? $proom = $_GET['room'] : $proom = 1; //se usa solo para editar

$cals[1] = new ical('https://mail.qwerty.com/calendar/689580b34e4d4460acf524030cd53c39@sunhotels.com/6f6eff95568244ba8f96cc1647d33e9a6785828459988279174/calendar.ics');
$cals[2] = new ical('https://mail.qwerty.com/calendar/64a0f6df8c6f4e078f0c66642cfcdd42@sunhotels.com/fb1825c22f2547f48bb108e4388a98b82764660919182050952/calendar.ics');
$cals[3] = new ical('https://mail.qwerty.com/calendar/53a4ed562d424e3085fdc06c109d1a6f@sunhotels.com/45764369117046e79fb69ffde264b04616221432303392068260/calendar.ics');
$cals[4] = new ical('https://mail.qwerty.com/calendar/f830bf09a47e41278ac216ac6c929a66@sunhotels.com/998f9709f6a6474ea0c90ca630d98c844486908510248423319/calendar.ics');

function showRoomName($room = 1){
	switch($room){
		case 1 : return "White Room";break;
		case 2 : return "Black Room";break;
		case 3 : return "Conference Room";break;
		case 4 : return "Executive Room";break;
	}
}

$today = (string)date('Y/m/d 00:00:00');
//$tomorrow = (string)date('Y/m/d 00:00:00', strtotime('+1 day'));
echo'
<!DOCTYPE html>
   <html lang="en">
   <head>
   		  <meta charset="utf-8" >		  
	  	 <!-- <meta http-equiv="refresh" content="3900"> --><!-- refresh general cada 1h5m -->
	  	  <meta http-equiv="refresh" content="1800"> <!-- refresh general cada 30min -->
		  <title>Events - Sunhotels</title>  
		  <link rel="stylesheet" type="text/css" href="css/schedule.css" />
  <!--[if IE]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	<script src="libs/ajax.js"></script>
	<script language="javascript" type="text/javascript">
		window.onload = function(){
			Refresh("schedule.php","schedule");
			setInterval(function(){Refresh("schedule.php","schedule")},1200000); <!-- segundos x 1000-->						
			setInterval(function(){toggle("slider")},90000);
		}
	</script>
  </head>
  <body>	
	<header id="screen"><h1>'.date("l d/m/Y").'</h1></header>;';
	
switch($sec){
	case "list" : 	
	echo '
	<div id="cont">
		<div id="schedule"></div> <!--en esta capa se carga el contenido de schedule.php mediante AJAX.-->
		<div id="map">
			<article id="map">
				<h1 class="fixed-tl">REAL TIME BOOKINGS</h1>		
				<object class="bookmap" type="text/html" data="map_live.php" seamless></object>				
			</article>
		</div>
	</div>';	
	echo'<div id="weather">
		<div id="slider">	
			<div class="panel">
					
					<!-- Palma --> 
						<div class="clock"> <div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Spain/Madrid/Madrid/"><img src="http://localtimes.info/images/countries/es.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Palma</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Europe&country=Spain&province=Madrid&city=Madrid&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->		
				
					<!-- Gothenburg --> 
						<div class="clock"> <div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Sweden/Gothenburg/"><img src="http://localtimes.info/images/countries/se.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Gothenburg</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=europe&country=Sweden&city=Gothenburg&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<!-- London -->
						<div class="clock"> <div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/United_Kingdom/London/"><img src="http://localtimes.info/images/countries/gb.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;London</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Europe&country=United Kingdom&city=London&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<!-- New York --> 
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/North_America/United_States/New_York/New_York/"><img src="http://localtimes.info/images/countries/us.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;New York</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=north america&country=United States&province=New York&city=New York&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<!-- Los Angeles -->
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/North_America/United_States/California/Los_Angeles/"><img src="http://localtimes.info/images/countries/us.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Los Angeles</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=north america&country=United States&province=California&city=Los Angeles&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->	
					
					<!-- Beijing -->
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Asia/China/Beijing/Beijing/"><img src="http://localtimes.info/images/countries/cn.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Beijing</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=asia&country=China&province=Beijing&city=Beijing&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<div class="weather_info"><div id="cont_142770459aa108d0a13ceb06b1ba04f7">
						<span id="h_142770459aa108d0a13ceb06b1ba04f7"><h3>Palma de Mallorca</h3></span>
						<script type="text/javascript" src="http://www.tiempo.com/wid_loader/142770459aa108d0a13ceb06b1ba04f7"></script>
					</div></div>

					<div class="weather_info"><div id="cont_fd04035ffe0021b6ac871db752c323e2">
					  <span id="h_fd04035ffe0021b6ac871db752c323e2"><h3>Gothenburg</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/fd04035ffe0021b6ac871db752c323e2"></script>
					</div></div>

					<div class="weather_info"><div id="cont_ead81d147640fd73e1ab6065f4ec88a5">
					  <span id="h_ead81d147640fd73e1ab6065f4ec88a5"><h3>London</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/ead81d147640fd73e1ab6065f4ec88a5"></script>
					</div></div>

					<div class="weather_info"><div id="cont_de3552d8d3c93a2fdc92782f626e6dea">
					  <span id="h_de3552d8d3c93a2fdc92782f626e6dea"><h3>New York</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/de3552d8d3c93a2fdc92782f626e6dea"></script>
					</div></div>

					<div class="weather_info"><div id="cont_77c9bcd85f460656e35cbb92683fc7f6">
					  <span id="h_77c9bcd85f460656e35cbb92683fc7f6"><h3>Los Angeles</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/77c9bcd85f460656e35cbb92683fc7f6"></script>
					</div></div>

					<div class="weather_info"><div id="cont_1270d223bc056f853e6ab046b54c74bc">
					  <span id="h_1270d223bc056f853e6ab046b54c74bc"><h3>Beijing</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/1270d223bc056f853e6ab046b54c74bc"></script>
					</div></div>

				echo'
				</div>
				<div class="panel">					
					<!-- Mexico -->
						<div class="clock"> <div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/North_America/Mexico/Distrito_Federal/Mexico_City/"><img src="http://localtimes.info/images/countries/mx.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Mexico DF</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=north america&country=Mexico&province=Distrito Federal&city=Mexico City&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<!-- Berlin -->
						<div class="clock"><div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Germany/Berlin/"><img src="http://localtimes.info/images/countries/de.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Berlin</a></div> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Europe&country=Germany&city=Berlin&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->
					
					<!-- Oslo --> 
						<div class="clock"> <div class="clock_title"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Norway/Oslo/"><img src="http://localtimes.info/images/countries/no.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Oslo</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=europe&country=Norway&city=Oslo&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->	
					
					<!-- Madrid --> 
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Spain/Madrid/Madrid/"><img src="http://localtimes.info/images/countries/es.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Madrid</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Europe&country=Spain&province=Madrid&city=Madrid&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->	
					
					<!-- Canberra --> 
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Oceania/Australia/New_South_Wales/Sydney/"><img src="http://localtimes.info/images/countries/au.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Canberra</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=oceania&country=Australia&province=New South Wales&city=Canberra&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->	
					
					<!-- Bangkok --> 
						<div class="clock"> <div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Asia/Thailand/Bangkok/"><img src="http://localtimes.info/images/countries/th.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Bangkok</a></div> </noscript> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Asia&country=Thailand&city=Bangkok&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->

					<div class="weather_info"><div id="cont_628bca4fff4e46657d1c3cea785fe29c">
					  <span id="h_628bca4fff4e46657d1c3cea785fe29c"><h3>Mexico</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/628bca4fff4e46657d1c3cea785fe29c"></script>
					</div></div>
				
					<div class="weather_info"><div id="cont_60f4c845b3cdb43030d535d7f8d123c8">
					  <span id="h_60f4c845b3cdb43030d535d7f8d123c8"><h3>Berlin</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/60f4c845b3cdb43030d535d7f8d123c8"></script>
					</div></div>
					
					<div class="weather_info"><div id="cont_9f153154ec44cc9926d7d6abdece4a84">
					  <span id="h_9f153154ec44cc9926d7d6abdece4a84"><h3>Oslo</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/9f153154ec44cc9926d7d6abdece4a84"></script>
					</div></div>
					
					<div class="weather_info"><div id="cont_7123518f880aeeaa6ccceaa33e4ff5ee">
						<span id="h_7123518f880aeeaa6ccceaa33e4ff5ee"><h3>Madrid</h3></span>
						<script type="text/javascript" src="http://www.tiempo.com/wid_loader/7123518f880aeeaa6ccceaa33e4ff5ee"></script>
					</div></div>
					
					<div class="weather_info"><div id="cont_c32f24e072a2eed2249aa660a99a4ae8">
					  <span id="h_c32f24e072a2eed2249aa660a99a4ae8"><h3>Canberra</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/c32f24e072a2eed2249aa660a99a4ae8"></script>
					</div></div>
							
					<div class="weather_info"><div id="cont_6c98331140ccf4cbdb706d485c6b263d">
					  <span id="h_6c98331140ccf4cbdb706d485c6b263d"><h3>Bangkok</h3></span>
					  <script type="text/javascript" src="http://www.tiempo.com/wid_loader/6c98331140ccf4cbdb706d485c6b263d"></script>
					</div></div>						
				
				</div>';
				
		/*		
		<!-- Stockholm -->
						<div class="clock"><div class="clock_title negative_margin"> <a style="font-size:13px; line-height:16px; padding:2px 0px; font-family:arial; text-decoration: none; color: #EEEEEE;" href="http://localtimes.info/Europe/Sweden/Stockholm/"><img src="http://localtimes.info/images/countries/se.png" border=0 style="border:0;margin:0;padding:0">&nbsp;&nbsp;Stockholm</a></div> <script type="text/javascript" src="http://localtimes.info/clock.php?cp3_Hex=000000&cp2_Hex=FCFCFC&cp1_Hex=191919&fwdt=128&ham=0&hbg=0&hfg=0&sid=&mon=&wek=&wkf=&sep=&continent=Europe&country=Sweden&city=Stockholm&widget_number=125"></script></div>
					<!-- End of localTimes.info script -->			
		echo'
		<!--<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="143" height="176"><param name=movie value="http://www.websmultimedia.com/flash/wm_reloj.swf?_id1=4&_id2=7&_id3=1&_id4=2&_id5=8&_id6=2&_id7=1&_id8=2&_id9=0&_id10=256&_id11=15992070&_id12=256&_id13=9870976&_id14=3421231&_id15=16515068&_id17=1&_id19=1" /><param name=quality value=high /><param name=wmode value=transparent /><embed src="http://www.websmultimedia.com/flash/wm_reloj.swf?_id1=4&_id2=7&_id3=1&_id4=2&_id5=8&_id6=2&_id7=1&_id8=2&_id9=0&_id10=256&_id11=15992070&_id12=256&_id13=9870976&_id14=3421231&_id15=16515068&_id17=1&_id19=1" quality=high wmode=transparent pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="143" height="176" /></embed></object>-->
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=LEPA&city_name=Palma de Mallorca (Islas Baleares)&language=en&use_celsius=Yes&skinName=Gray&PID=152468&ts=201305080720&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Palma_de_Mallorca_Islas_Baleares.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=EGLC&city_name=London&language=en&use_celsius=Yes&skinName=Gray&PID=152469&ts=201305080720&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/London.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=KNYC&city_name=New York&language=en&use_celsius=Yes&skinName=Gray&PID=152470&ts=201305080721&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/New_York.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=ESGP&city_name=Gothenburg (Sweden)&language=en&use_celsius=Yes&skinName=Gray&PID=152471&ts=201305080722&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Gothenburg_Sweden.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=000054&city_name=Oslo&language=en&use_celsius=Yes&skinName=Gray&PID=152472&ts=201305080723&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Oslo.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=LEGT&city_name=Madrid&language=en&use_celsius=Yes&skinName=Gray&PID=152467&ts=201305080712&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Madrid.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=EDDI&city_name=Berlin&language=en&use_celsius=Yes&skinName=Gray&PID=152474&ts=201305080724&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Berlin.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=KCQT&city_name=Los Angeles&language=en&use_celsius=Yes&skinName=Gray&PID=152475&ts=201305080724&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Los_Angeles.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=MMMX&city_name=Mexico City&language=en&use_celsius=Yes&skinName=Gray&PID=152476&ts=201305080725&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Mexico_City.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=000001&city_name=Beijing&language=en&use_celsius=Yes&skinName=Gray&PID=152477&ts=201305080726&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Beijing.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=YSCB&city_name=Canberra&language=en&use_celsius=Yes&skinName=Gray&PID=152478&ts=201305080726&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Canberra.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=VTBD&city_name=Bangkok&language=en&use_celsius=Yes&skinName=Gray&PID=152479&ts=201305080728&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Bangkok.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_gray_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>
		<!-- PARIS	<div style="line-height: 10px;background:#FFF; float:left;margin:15px 0px 0px 10px; height:115px; overflow:hidden; border:#FFF 3px solid; border-radius:8px;box-shadow: 0px 0px 10px #EEE;"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=LFPO&city_name=Paris&language=en&use_celsius=Yes&skinName=LightGreen&PID=151718&ts=201304230508&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Paris.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_light_green_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>	-->
			
		<!-- Stockholm <div class="weather_info"><div style="max-width: 160px; width: 160px; background:none;"><object style="margin:0;padding:0;" type="application/x-shockwave-flash" data="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" 	id="w4aaa9c4e6c122b4c4af9ecec7aeeb33a" height="272" width="160">	<param value="http://static.hotelscombined.com.s3.amazonaws.com/swf/weather_widget.swf" name="movie"/>	<param value="transparent" name="wmode">	<param value="station_id=ESSB&city_name=Stockholm&language=en&use_celsius=Yes&skinName=LightGreen&PID=151710&ts=201304230348&hideChangeSkin=No" name="flashvars">	<param value="all" name="allowNetworking">	<param value="always" name="allowScriptAccess"></object><a alt="Hotels Combined" title="Hotels Combined" style="margin:0; padding:0; text-decoration: none; background: none;" target="_blank" href="http://widgets.hotelscombined.com/City/Weather/Stockholm.htm?use_celsius=Yes"><div style="background: none; color: white; text-align: center; width: 160px; height: 17px; margin: 0px 0 0 0; padding: 5px 0 0 0; cursor:pointer; background: transparent url(http://static.hotelscombined.com.s3.amazonaws.com/Pages/WeatherWidget/Images/weather_light_green_bottom.png) no-repeat; font-size: 12px; font-family: Arial,sans-serif; line-height: 12px; font-weight: bold;">See 10-Day Forecast</div></a><div style="text-align: center; width: 160px;"><a alt="Hotels Combined" title="Hotels Combined" style="background:none;font-family:Arial,sans-serif; font-size: 9px; color: #777777;" rel="nofollow" href="http://www.hotelscombined.com">&copy; HotelsCombined.com</a></div></div></div>-->
		';
		*/

		/*<iframe src="http://www.weather365.net/foreign/city.php?cityid=12832&language=31" width="170" height="183" align="left" allowtransparency="true" name="Weather365" seamless>
			<p>Your Browser is not able to handle IFRAME: Check here for more weather: <a href="http://www.weather365.net"> WEATHER365.net </a></p> 
		</iframe>
		
		<iframe src="http://www.weather365.net/foreign/city.php?cityid=33908&language=31" width="170" height="183" align="left" allowtransparency="true" name="Weather365" seamless>
			<p>Your Browser is not able to handle IFRAME: Check here for more weather: <a href="http://www.weather365.net"> WEATHER365.net </a></p> 
		</iframe>
		
		<iframe src="http://www.weather365.net/foreign/city.php?cityid=7577&language=31" width="170" height="183" align="left" allowtransparency="true" name="Weather365" seamless>
			<p>Your Browser is not able to handle IFRAME: Check here for more weather: <a href="http://www.weather365.net"> WEATHER365.net </a></p> 
		</iframe>
		
		<iframe src="http://www.weather365.net/foreign/city.php?cityid=1468&language=31" width="170" height="183" align="left" allowtransparency="true" name="Weather365" seamless>
			<p>Your Browser is not able to handle IFRAME: Check here for more weather: <a href="http://www.weather365.net"> WEATHER365.net </a></p> 
		</iframe>*/
	echo'
		</div>
			</div>';	//en esta capa se carga el contenido de weather.php mediante AJAX.
		
		break;
		
	case "edit" :
		// Listado editable:
		echo '
		<div id="edit">
		<h2 class="center">Edit Events</h2>
		<nav>
			<ul>
				<li><a href="eventlist.php?sec=edit&room=1">White Room</a></li>
				<li><a href="eventlist.php?sec=edit&room=2">Black Room</a></li>
				<li><a href="eventlist.php?sec=edit&room=3">Conference Room</a></li>
				<li><a href="eventlist.php?sec=edit&room=4">Executive Room</a></li>
			</ul>
		</nav>
		<form action="save_events.php?room='.$proom.'" method="post">
		<br/><br/><hr>
		<h2>'.showRoomName($proom).'</h2>';
		if ($cals[$proom]->hasEvents()){
			$events = $cals[$proom]->eventsFromRange($today);
			$ev = new event($proom);
			$dbevents = array();
			$dbevents = $ev->getEventList($proom);
			echo'
			<table>
			<tr class="caption"><td>Title</td><td>Date</td><td>Start</td><td>End</td><td>Visit</td></tr>';
			foreach($events as $e){
				$datetime = str_replace('T','',$e['DTSTART']);			
				$datetime = str_replace('T','',$e['DTEND']);
				//$ev = new event($e['UID'],$room,$datetime);
				echo'
				<tr>
					<td>'.$e['SUMMARY'].'</td>
					<td>'.$cals[$proom]->formatIcalDate($e['DTSTART']).'</td>
					<td>'.$cals[$proom]->formatIcalTime($e['DTSTART']). 'h</td>	
					<td>'.$cals[$proom]->formatIcalTime($e['DTEND']). 'h</td>	
					<td><input type="checkbox" id="uid" name="checks[]" value="'.$e['UID'].'"';if ($dbevents && in_array($e['UID'],$dbevents)) echo ' checked';echo' />
						<input type="hidden" name="timestamp[]" value="'.$datetime.'" />
					</td>
				</tr>
				';				
			}
			echo'</table>';
			echo '<input type="submit" value="Save Changes">';
		}else{
			echo'<p>This room has no events by now.</p>'; //DO SOMETHING HERE
		}
		echo'</form>
		</div>';
		break;
}
echo'
</body>
</html>';


?>
