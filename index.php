
<?php 
ob_start();
//require_once ('config.php');
require_once ('phonelist.php');
require_once ('utils.php');

isset($_GET['sec'])? $section = $_GET['sec'] : $section = "phone";

//--------------------------------------//

//include 'main_header.php';
include 'header.php';

switch ($section){
	case "phone":
		isset($_GET['scp'])? $scope = $_GET['scp'] : $scope = "int";
		isset($_GET['ord'])? $order = $_GET['ord'] : $order = 'name'; 
		isset($_GET['view'])? $view = $_GET['view'] : $view = 'tab';		
		echo'		
		<section id="phonelist">';
			include ("list.php");
			echo'
		</section>';
		break;	
	case "rooms":
		isset($_GET['r'])? $room = $_GET['r'] : $room = "conf";
		echo'		
		<section id="rooms">';
			include ("rooms.php");			
			echo'
		</section>';
		break;
	case "bookings":
		echo'
		<section id="bookings">';
			include ("booking.php");
			echo'	
		</section>';
		break;
	case "tutorials":
		echo'
		<section id="tutorials">';
			include ("tuts.php");
			echo'	
		</section>';
		break;
	default:
		echo'ERROR: No section available.';
}

include 'footer.php';
?>
