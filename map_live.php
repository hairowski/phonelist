<!DOCTYPE html>
<html> 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>SunHotels - Live Bookings</title> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
  <!-- <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script> -->
  <!-- <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel/src/markerwithlabel.js"></script> -->

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJokBrTkZUeAHfqFRBL2vVkapR4OemqfU&callback=initMap" async defer></script>
          
  <style type="text/css">
  body, html {
	height: 100%;
	width: 100%;
	margin: 0px;
	padding: 0px;
  }
  
   .labels {
     color: red;
     background-color: white;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 10px;
     font-weight: bold;
     text-align: center;
     width: 40px;
     border: 2px solid black;
     white-space: nowrap;
   }
   
   #header {
	height: 60px;
	background-color: #df2600;
	padding: 8px;
}



#logo {
	float: left;
	width: 171px;
	background-image: url(logo.png);
	height: 60px;
}

#shade {
	background-image: url(shade.png);
	background-repeat: repeat;
	height: 10px;	
}

#loginlink {
	font-size: 38px;
	color: #FFF;
	margin-left: 600px;
	margin-top: 10px;
	font-family: Verdana, Geneva, sans-serif;
}

  </style>
</head> 
<body>
<div id="rtm_map" style="width:100%;height:100%"></div>

<!-- <?php 
	//include ('get_live.php');	
	//exit;
?> -->
<!-- JAVASCRIPT -->  

<script>	
	
	var map;
	var markers = [];	//array for markers (and their data)
	var locations;		//array to store query results

	function initMap() {			
		
		var myLatLng = {lat: -25.363, lng: 131.044};
		map = new google.maps.Map(document.getElementById('rtm_map'), {
			zoom: 3,
			maxZoom: 8,
			minZoom: 1,
			mapTypeControl: false,
			zoomControl: false,
			panControl: false,
			draggable: false,
			scaleControl: false,
			scrollwheel: false,
			navigationControl: false,
			streetViewControl: false,
			center: new google.maps.LatLng(myLatLng),
			mapTypeId: google.maps.MapTypeId.HYBRID  
		});			
	}

		//Example of locations -->   {"loc0":
		//								{"info":"Husa Paseo del Arte",
		//								 "lat":"40.4099588743458",
		//								 "lng":"-3.69339644908905"}
		//							}

	function loadMarkers(locObj){
		
		$.each(locObj, function (key, loc) {
			var marker = new google.maps.Marker({         		
	    		position: new google.maps.LatLng(loc.lat,loc.lng),
	    		title: loc.info,
	    		animation:google.maps.Animation.DROP
	  		});	  		
  			markers.push(marker);
  		});
	}

	function setMarker(map,marker) {

			if (marker !== undefined){			
			    var infowindow = new google.maps.InfoWindow({content: marker.title});
			    map.setOptions({    
			      center: marker.position,
			      zoom: 5
			    })
			    marker.setMap(map);
			    infowindow.open(map,marker);  
			    setTimeout(function(){
			                marker.setMap(null);              
			                },30000);    
		  	}else{
		  		console.log("no puedo pintar el marcador");
		  	}
	}

	
	var ajaxObj = { 				//Object to save cluttering the namespace.
	    options: {
	        url: "get_live.php", 	//The resource that delivers loc data.
	        dataType: "json" 		//The type of data tp be returned by the server.	        
	    },
	    delay: 300000,				//(milliseconds) the interval between successive gets.
	    //errorCount: 0, 			//running total of ajax errors.
	    //errorThreshold: 5,		//the number of ajax errors beyond which the get cycle should cease.
	    //ticker: null, 			//setTimeout reference - allows the get cycle to be cancelled with clearTimeout(ajaxObj.ticker);

	    done: function (result){
	    	loadMarkers(result);
	    },
	    fail: function (jqXHR, textStatus, errorThrown) {
	        console.log(errorThrown);
	        ajaxObj.errorCount++;
	    },
	    get: function (){setTimeout(getMarkerData, ajaxObj.delay);}    
	};

	//Ajax master routine
	function getMarkerData() {
	    $.ajax(ajaxObj.options)
	        .done(ajaxObj.done) //fires when ajax returns successfully	        
	    	.fail(ajaxObj.fail) //fires when an ajax error occurs	
	    	.always(ajaxObj.get); //fires after ajax success or ajax error
	}

	//setMarker(locs); //Create markers from the initial dataset served with the document.
	//ajaxObj.get(); //Start the get cycle.
	$(document).ready(getMarkerData());
	
	setInterval(function(){
		setMarker(map,markers.shift())
		},30000
	);
	
  </script>
</body>
</html>