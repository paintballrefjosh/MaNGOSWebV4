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
	$path = "screenshots/";
	$thum_p = "screenshots/thumbs/";
}
if ($_GET['gallery'] == 'wallp'){
	$path = "wallpapers/";
	$thum_p = "wallpapers/thumbs/";
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
if (!empty($path) && !empty($_GET['filename']))
{
	// if width variable is set, create thumb, otherwise just display the full size image
	if(isset($_GET['width']))
	{
		// Does this thumbnail exists, we dont want to overload the CPU with our gallery.
		if (file_exists($thum_p.$_GET['filename']))
		{
			$thumb = new Thumbnail($thum_p.$_GET['filename']);
			$thumb->show();
		}
		else
		{
			// thumbnail doesn't exist, create one
			$thumb = new Thumbnail($path.$_GET['filename']);
			$thumb->resize($_GET['width'],$_GET['height']);
			$thumb->save($thum_p.$_GET['filename']);
			$thumb->show();
		}
	}
	else
	{
		// display full sized image
		$thumb = new Thumbnail($path.$_GET['filename']);
		$thumb->show();
	}
}
exit;
?>