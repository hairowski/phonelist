<?php

//include('config.php');
//include(shinclude.'html1.php');
require_once ('phonelist.php');
require_once ('utils.php');

function upload($user_id)
{
	//print_r($_FILES['userfile']);exit;

	//global $db;
	$p = new phonelist($user_id); //instanciamos usuario
   //$p->readUser($p->theId()); //leemos datos del usuario   
   //$p->loadUser($p->theUserInfo());
   
   $result=0;
   if(is_uploaded_file($_FILES['userfile']['tmp_name'])){      	  	  
      $ext = strtolower(substr($_FILES['userfile']['name'], -4));//gets the file extension
	  $file = $_FILES['userfile']['tmp_name'];
	  // check file size and extension
		if(($_FILES['userfile']['size'] < $_POST['MAX_FILE_SIZE']) && ($ext == '.jpg' or $ext =='.png')){
			// prepare the image for insertion		  
			resizeProfilePicture($file);
			$imgData = addslashes (file_get_contents($file));
			//print_r($_FILES['userfile']);exit;
			// get the image info..
			$size = getimagesize($file);			 
			$haspicsql="SELECT count(*) FROM pics WHERE user_id='$user_id'";
			$haspic = $p->db->get_var($haspicsql);	 		 
			$filename = prepareImage($user_id,$size['mime']); //preparamos el nombre de la imagen	 
			if($haspic){
				/////////////////////////-->><>>////////$image_id = $p->db->get_var('SELECT image_id FROM pics WHERE user_id='.$user_id.";");
				// $sql_update="UPDATE pics SET image_type='{$size['mime']}', image='{$imgData}', image_size='{$size[3]}', image_name='{$_FILES['userfile']['name']}' WHERE image_id={$image_id};";
				$sql_update="UPDATE pics SET image_type='{$size['mime']}', image='{$imgData}', image_size='{$size[3]}', image_name='$filename' WHERE user_id='$user_id';";
				$p->db->query($sql_update);				
			}else{			 
				$sql = "INSERT INTO pics
				   ( image_id , image_type ,image, image_size, image_name, user_id)
				   VALUES
				   ('', '{$size['mime']}', '{$imgData}', '{$size[3]}', '$filename','$user_id')";
				$p->db->query($sql);
			}		 
			$result = 1;		 
		}else{			
			$result = -1;	
		}		
	}else $result = -1;
	
	if($result == -1){
		// if the file is bigger than the maximum allowed or incorrect file format:
		echo'
		<div>
		<h1>There was an <span class="bold">Error</span> due to:</h1>
		<ul>
			<li>The file exceeds the maximum file limit (or no file was selected)
				Maximum file limit is 1.5 MB aprox.</li>
			<li>You selected a wrong filetype. Remember that it must be a <span class="bold">JPG</span> or <span class="bold">PNG</span> image file.</li>
		</ul>
		<br /><br /><br /><br /><br /><br /><br /><hr /><br />
		<p>You can go back to <a href="user.php?uid='.$_POST['user_id'].'">your profile</a> and try again</p>
		</div>';		
   }
   return $result;
}

$show_news = false;
include 'header.php';

echo '<section id="upload">
		<div id="img_upload">';
if(!isset($_FILES['userfile']))
{
   if (isset($_GET['user_id'])) {
		$uid = $_GET['user_id'];
		$p = new phonelist();
		$sql_picexist="SELECT count(*) FROM pics WHERE user_id='$uid';";		
		if ($pic_exist = $p->db->get_var($sql_picexist))
		{
			$sqlpic = "SELECT image_name FROM pics WHERE user_id='$uid';";
			$image_name = $p->db->get_var($sqlpic);
			echo '<img src="images/profiles/'.$image_name.'" id="big_face">';
		}else{
			echo '<img src="images/head.png" id="big_face">';			
		}
		echo '<br />'; //este bloque puede no ir aqui...
		echo '
		<h1>Please choose a file and click submit</h1>
		<p>Note that the file has to be in <span class="bold">PNG</span> or <span class="bold">JPG</span> format and the maximum file size is around 1.5MB
		(if you need advice contact the IT department)</p>		
		<form enctype="multipart/form-data" action="'.$_SERVER['PHP_SELF'].'" method="post">
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
			<input type="hidden" name="user_id" value="'.$uid.'" />
			<div id="upl">
				<input type="file" name="userfile" value="Slect..." />
				<input type="submit" value="Submit" id="submit"/>
			</div>
		</form>'."\n";
   }
}
else
{
   $uploadedok = upload($_POST['user_id']);
   if ($uploadedok == 1){
	  copyImage($_POST['user_id']); //copiamos la imagen en el directorio de profiles
      echo '
	  <div id="response">
		<p>Thank you for submitting</p>
		<p>You can wait 5 seconds or go to <a href="user.php?uid='.$_POST['user_id'].'">your profile</a></p>
	  </div>';	  
	  header("refresh: 5; url=index.php");
   }
}
echo '</div></section>';
include 'footer.php';
?>
