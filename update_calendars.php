<?php 

/*
 * Descarga cada uno de los calendarios remotos indicados 
 * y los almacena en el directorio /webdav del servidor web.
 * 
 * Este script se ejecuta periodicamente mediante Crontab.
 *
 */
//require_once ('config.php');
require_once ('/var/www/intranet/phonelist.php');
require_once ('/var/www/intranet/utils.php');

	getCalendar('https://mail.sunhotels.com/OWA/calendar/53a4ed562d424e3085fdc06c109d1a6f@sunhotels.net/45764369117046e79fb69ffde264b04616221432303392068260/calendar.ics', 'Conference_Room');
	getCalendar('https://mail.sunhotels.com/OWA/calendar/689580b34e4d4460acf524030cd53c39@sunhotels.net/6f6eff95568244ba8f96cc1647d33e9a6785828459988279174/calendar.ics', 'White_Room');
	getCalendar('https://mail.sunhotels.com/owa/calendar/64a0f6df8c6f4e078f0c66642cfcdd42@sunhotels.net/fb1825c22f2547f48bb108e4388a98b82764660919182050952/calendar.ics', 'Black_Room');
	getCalendar('https://mail.sunhotels.com/OWA/calendar/f830bf09a47e41278ac216ac6c929a66@sunhotels.net/998f9709f6a6474ea0c90ca630d98c844486908510248423319/calendar.ics', 'Executive_Room');
	
?>
