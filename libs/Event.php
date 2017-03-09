<?php 

require_once ('db.php');
	
/* Clase para organizar/ver eventos  
 * (Decidir si se guardan todos los eventos en BD o si
 * se guardan unicamente los IDs de eventos con visitas).
 */
	
class Event{
	
	var $db;
	var $id;
	var $uid;				//UID del evento
//	var $subject;			//WHAT
	var $datetime;			//WHEN
	var $room;				//WHERE	
	
	public function __construct($uid = 0, $room = 0, $datetime = 0){
	/*constructor de la clase*/
		$this->db = db_connect();
		$this->uid = $uid;
		//$this->subject = $subject;
		$this->datetime = $datetime;
		$this->room = $room;
	}
	
	/*public function printEvent(){
	//muestra el evento por pantalla (HTML)
		echo'
		<div class="eventtab">
			<p class="title">'.$subject.'</p> 
			<p class="date">Date: '.$this->formatDate().' at '.$this->formatTime(). 'h
		</div>';
	}*/
	
	public function getEventList($room = 0){
	/* Descarga la lista de eventos y deuelve un array
	 * Puede especificarse una room concreta para filtrar
	 */
		//if ($field !== 'uid' && $field !== '*')	$field = '*';

		if ($room == 0) $query = "SELECT uid FROM meetings;";
		else $query = "SELECT uid FROM meetings WHERE room_id = '$room';";
		
		$num = $this->db->get_var("SELECT COUNT(*)FROM meetings;"); //verificamos si hay algo					
		if($num > 0 && $results = $this->db->get_results($query)){ 
			foreach ($results as $r){
				$list[] = $r->uid; 				
			}
			return $list;	
		}else{
			return false; //lista vacia
		}
	}

	
	public function addEvent(){
		//inserta el evento en la base de datos
		if ($this->uid !== 0 && $this->room !== 0 && $this->datetime !== 0){			
			//$query = $this->db->query("INSERT INTO meetings (uid,room_id,datetime) VALUES ('$this->uid','$this->room','$this->datetime')
			//ON DUPLICATE KEY UPDATE uid = uid;");  
			$query = $this->db->query("INSERT INTO meetings (uid,room_id,datetime) VALUES ('$this->uid','$this->room','$this->datetime');");
		}else{
			die ("ERROR: Cannot add the event. Some event data is missing. [Event.php]");
		}
	}
	
	public function eraseEventRoom(){
		//borra todos los eventos de una sala antes de insertar los nuevos
		if ($this->room !== 0)
			$this->db->query("DELETE FROM meetings WHERE room_id='$this->room'");
		else
			die ("ERROR: Cannot erase room. Maybe a bad room_id ?. [Event.php]");
	}
	
	/*public function formatDate(){
	//Returns ical date string in dd/mm/yyyy format
		$year = substr($this->datetime,0,4);
		$month = substr($this->datetime,4,2);
		$day = substr($this->datetime,6,2);
		$date = $day.'/'.$month.'/'.$year;
		
		return $date;	   
	  
    } 
	
	public function formatTime(){
	//Returns ical time string in hh:mm format 
		$hours = substr($this->datetime,-6,2);		
		$minutes = substr($this->datetime,-4,2);
		$time = $hours.':'.$minutes;
		
		return $time;	   
	  
    } */

//	public function checkAsVisit(){}

/*	GETTERS	*/

public function theUid(){		return $this->uid;}
//public function theSubject(){	return $this->subject;}
public function theDatetime(){	return $this->datetime;}
public function theRoom(){		return $this->room;}

	
}

?>