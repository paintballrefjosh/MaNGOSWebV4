<?php
/**
 * show_image.php
 * 
 * Example utility file for dynamically displaying images
 * 
 * @author      Ian Selby
 * @version     1.0 (php 5 version)
 */

//reference thumbnail class
include_once('thumbnail.inc.php');

// Bind gallery pathing so we wont get any hacks.
if ($_GET['gallery'] == 'screen'){
	$path = "../../images/screenshots/";
	$thum_p = "../../modules/ssotd/cache/screenshots/";
}
if ($_GET['gallery'] == 'wallp'){
	$path = "../../images/wallpapers/";
	$thum_p = "../../modules/ssotd/cache/wallpapers/";
}

// Prevent stupid hackers. So they cant do:
// show_picture.php?filename=../../../index.php
if(strstr($_GET['filename'], '/.')){
	die(" \"/.\" is not allowed in a file name.");
}

// Die if the script cannot find the image.
if (file_exists($path.$_GET['filename']) == false){
	die('Picture doesnt exsist!');
}

// Check if the required paths is not included.
if (empty($path) || empty($_GET['filename'])){

}else{

// Does this thumbnail exists, we dont want to overload the CPU with our gallery.
if (file_exists($thum_p.$_GET['filename'])){
	
	// Well if the image that we have.. is newer and same name we must create a new tempalte.
	if(file_exists($path.$_GET['filename']) && filemtime($thum_p.$_GET['filename']) < filemtime($path.$_GET['filename'])){
		unlink($thum_p.$_GET['filename']);
		$thumb = new Thumbnail($path.$_GET['filename']);
		$thumb->resize($_GET['width'],$_GET['height']);
		$thumb->save($thum_p.$_GET['filename']);
		$thumb->show();
	// Ok we just show our thumbnail.
	}else{
		$thumb = new Thumbnail($thum_p.$_GET['filename']);
		$thumb->show();
	}
// We gotta create a thumbnail because our thumbnail does not exist.
}else{
	$thumb = new Thumbnail($path.$_GET['filename']);
	$thumb->resize($_GET['width'],$_GET['height']);
	$thumb->save($thum_p.$_GET['filename']);
	$thumb->show();
}

}
exit;
?>