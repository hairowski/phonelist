<?php
 
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/
 
class SimpleImage {
 
   var $image;
   var $image_type;
 
   function load($filename) {
 
      $image_info = getimagesize($filename);
      $this->image_type = $image_info['mime'];
      if( $this->image_type == 'image/jpeg' ) {
 
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == 'image/gif' ) {
 
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == 'image/png' ) {
 
         $this->image = imagecreatefrompng($filename);
      } //else{
		//echo "IMAGE: ".$filename." is giving problems";
	  //}
   }
   function save($filename, $compression=75, $permissions=null) {
		
      if( $this->image_type == 'image/jpeg' ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $this->image_type == 'image/gif' ) {
 
         imagegif($this->image,$filename);
      } elseif( $this->image_type == 'image/png' ) {
 
         imagepng($this->image,$filename);
      }
      if( $permissions != null) {
 
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
 
      if( $image_type == 'image/jpeg' ) {
         imagejpeg($this->image);
      } elseif( $image_type == 'image/gif' ) {
 
         imagegif($this->image);
      } elseif( $image_type == 'image/png' ) {
 
         imagepng($this->image);
      }
   }
   
   function getWidth() {
 
      return imagesx($this->image);
   }
   function getHeight() {
 
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
 
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
 
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
 
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }
 
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      
 
	function crop($from_x=0, $from_y=0, $crop_width=200, $crop_height=200){		
	 
		// Get dimensions of the original image
		$current_width  = $this->getWidth();
		$current_height = $this->getHeight();
		 
		// The x and y coordinates on the original image where we
		// will begin cropping the image
		//$left = 50;
		//$top = 50;
		 
		// This will be the final size of the image (e.g. how many pixels
		// left and down we will be going)
		//$crop_width = 200;
		//$crop_height = 200;
		 
		// Resample the image
		$canvas = imagecreatetruecolor($crop_width,$crop_height);			
		imagecopy($canvas, $this->image, 0, 0, $from_x, $from_y, $current_width, $current_height);
		$this->image = $canvas;
		//imagejpeg($this->image, $filename, 100);		
	}
 
}
?>