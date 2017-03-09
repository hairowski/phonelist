<?php
	
   echo'  
   <!DOCTYPE html>
   <html lang="en">
   <head>
   		  <meta charset="utf-8" >		 
		  <title>Phonelist - Sunhotels</title>  		 
		  <link rel="stylesheet" type="text/css" href="css/estilos.css" />
  <!--[if IE]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
	<script language="javascript" type="text/javascript"></script>
	<style type="text/css">
		xhtml{background:#FFF;}
		xbody {margin:150px 0px 50px 25%;width:720px;min-height:600px;padding:20px 0px 0px 80px;font-family:verdana;background:#DDD;border:1px solid #FFF;border-radius:10px;box-shadow:0px 0px 15px #666;}		
		div.forms {margin:150px 0px 50px 25%;width:550px;min-height:600px;padding:20px 85px 0px 85px;font-family:verdana;background:#DDD;border:1px solid #FFF;border-radius:10px;box-shadow:0px 0px 15px #666;}
		xdiv {width:550px;xborder:1px solid green;}
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
			<img id="laptop" src="images/phone2.png" />
			<nav>
				<ul>
					<li><a href="index.php?sec=phone" class="tab">Phonelist</a></li>					
					<li><a href="index.php?sec=tutorials" class="tab">Help Desk</a></li>				
					<li><a href="user_request.php" class="tab">New User</a></li>
					<li><a href="user_unsuscribe.php" class="tab">Remove User</a></li>
				</ul>
			</nav> 
		</header>
		
 ';
?>
