<?php
	
   echo'
   <!DOCTYPE html>
   <html lang="en">
   <head>
   		<meta charset="utf-8" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  		<link rel="stylesheet" href="css/common.css">
  		<link rel="stylesheet" href="css/circle-menu.css">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		
		<!--[if IE]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script language="javascript" type="text/javascript"></script>
		<title>Phonelist - Sunhotels</title>

		<style type="text/css">
		div.forms {margin:150px 0px 50px 25%;width:550px;min-height:600px;padding:20px 85px 0px 85px;font-family:verdana;background:#DDD;border:1px solid #FFF;border-radius:10px;box-shadow:0px 0px 15px #666;}
		h1 {xmargin-left:70px;font-family:Georgia,Sans;font-size:2em;color:#27F;text-shadow:1px 1px 1px #888;border-bottom:groove 2px #FFF;text-align:center;}
		h2 {font-size:1em;color:#27F;text-shadow:1px 1px 1px #AAA;xborder-bottom:groove 2px #FFF;}
		p {margin:40px 0px 40px 100px;width:450px;text-align:left; color:#666;font-size:11pt;}			
		
		input,select,textarea {border:1px solid #AAA;border-radius:4px;-webkit-border-radius:4px;-moz-border-radius:4px;}
		input[type="text"],input[type="email"],input[type="submit"],input[type="tel"]{		
			height:25px;
			width:220px;
			font-size:0.9em;
			color:#555;
			margin-bottom:8px;
			padding-left:5px;			
		}		
		input[type="checkbox"]{display:block;width:20px;height:24px;margin:7px 0px 5px 170px;border:1px solid red;}
		input[type="checkbox"]:checked + div#opt{display:block;}
		
		input[type="radio"]{display:inline;width:15px;height:15px;}			
		input[type="radio"]#activate:checked + input {display:block;background:#FFF;}		
		
		input[type="submit"]{width:150px;height:40px;margin:30px 0px 40px 170px;background:#333;color:#EEE;border-radius:5px;font-size:14pt;border:1px solid #DDD;}			
		input[type="submit"]:focus, input[type="submit"]:hover {background:#444;}
		select{display:block;width:200px;height:25px;padding-left:5px;margin:3px 0px 10px 0px;}		
		
		label{
			display:block;
			width:160px;
			padding-top:4px;				
			margin:0px 10px 0px 0px;
			text-align:right;
			float:left;
			line-height:20px;
			font-family:Verdana;
			font-size:0.9em;
			font-weight:bold;
			color:#666;
			xborder:1px solid black;
		}
		div#opt {width:310px;xheight:45px;display:none;margin-left:190px;xmargin:10px 20px 10px 190px;padding:15px;border-radius:5px;background:#EEE;border:1px solid #FFF;box-shadow:0px 0px 4px #AAA;}
		input#email{display:none;margin-top:10px;width:300px;}
		input#pnum{display:none;margin-top:10px;width:300px;}
		select.smallsel {width:60px;display:inline;}
		select.smallsel2 {width:90px;display:inline;}
		
		textarea.reqs {						
			margin:10px 0px 10px 70px;
			width:450px;
			height:120px;					
			padding:10px;	
			font-family:Sans-Serif;
			font-size: 1em;
			color:#555;
		}
	</style>
  </head>
  <body>
  	<header>
  			<img id="logo" src="images/logo_black_bg_rgb2.svg" />
			<!-- <form action="#">
				<!--<fieldset id="search"> 
					<span><i class="fa fa-search" style="display: inline-block;margin: 10px 10px 0px 0px; font-size: 2.5em !important;"></i></span>
					<input type="text" id="searchbox" tabindex="1" onkeyup="showResult(this.value)" palaceholder="Search!">
				<!-- </fieldset> 
			</form>	-->
			<nav id="mainmenu">
				<ul>
					<li><a class="menu-item" href="#">Home</a></li>
				    <li><a class="menu-item" href="#">Staff</a></li>
				    <li><a class="menu-item" href="#lemon">Meetings</a></li>
				    <li><a class="menu-item" href="#">Support</a></li>
				</ul>
				<menu class="c-circle-menu js-menu">
					<button class="c-circle-menu__toggle js-menu-toggle">
				    	<span>Toggle</span>
				  	</button>
				  	<ul class="c-circle-menu__items">
				    	<li class="c-circle-menu__item">
				      		<a href="#" class="c-circle-menu__link">
				        		<!-- <img src="images/pin.svg" alt="Locations" title="Locations"> -->
				        		<i class="fa fa-home" aria-hidden="true" title="..."></i>
				      		</a>
				    	</li>
				    	<li class="c-circle-menu__item">
				      		<a href="index.php?sec=phone" class="c-circle-menu__link">
				        		<!-- <img src="images/house.svg" alt="Home" title="Home"> -->
				        		<i class="fa fa-users" aria-hidden="true" title="Staff"></i>
				      		</a>
				    	</li>
				    	<li class="c-circle-menu__item">
				      		<a href="index.php?sec=rooms" class="c-circle-menu__link">
				      	  		<!-- <img src="images/group2.svg" alt="Staff" title="Staff"> -->
				      	  		<i class="fa fa-calendar" aria-hidden="true" title="Meetings"></i>
				      		</a>
				    	</li>
				    	<li class="c-circle-menu__item">
				      		<a href="#" class="c-circle-menu__link">
				        		<!-- <img src="images/search.svg" alt="Search" title="Search"> -->
				        		<i class="fa fa-wrench" title="Support"></i>
				      		</a>
				    	</li>
				    	<li class="c-circle-menu__item">
				      		<a href="#" class="c-circle-menu__link">
				        		<!-- <img src="images/support.svg" alt="Support" title="Support"> -->
				        		<i class="fa fa-envelope" aria-hidden="true" title="Web Mail"></i>
				      		</a>
				    	</li>
				  	</ul>
			  		<div class="c-circle-menu__mask js-menu-mask"></div>	
			  	</menu>		  
			</nav>		

			<!--<nav>
				<ul>
					<li><a href="index.php?sec=phone" class="tab">Phonelist</a></li>
					<li><a href="index.php?sec=phone&scp=ext" class="tab">Ext. Staff</a></li>
					<li><a href="index.php?sec=rooms" class="tab">Rooms</a></li>
					--><!-- <li><a href="index.php?sec=bookings" class="tab">Bookings</a></li> 
					<li><a href="index.php?sec=tutorials" class="tab">Help Desk</a></li>	
					<a href="https://sunhotels.ladesk.com/" class="jiraButton">Support Portal</a>
				</ul>
			</nav> -->

			<script src="js/circleMenu.js"></script>
			<script>
			  var el = \'.js-menu\';
			  var myMenu = cssCircleMenu(el);
			</script>

	</header>
	<div id="menu_top">
		<form action="#">				
			<span><i class="fa fa-search" style="display: inline-block;margin: 10px 10px 0px 0px; font-size: 1.5em !important;"></i></span>
			<input type="text" id="searchbox" tabindex="1" onkeyup="showResult(this.value)" placeholder="Sök">			
		</form>
	</div>		
 ';
?>
