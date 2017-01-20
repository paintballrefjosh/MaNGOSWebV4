<?php
/*
tappc ain't a php captcha class

Rewriter: Lorenz Schwittmann Feb 2006
 based on Horst Nogajski's <horst@nogajski.de> hn_captcha (http://www.phpclasses.org/browse/package/1569.html)

License: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)


Required MySql Table:

CREATE TABLE `acc_creation_captcha` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(200) NOT NULL default '',
  `key` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

*/
class Captcha
{
	var $tmpfolder="core/cache/randimg/"; //writeable by php
	var $ttf_folder="core/cache/font/";

	var $chars_image_activate = 6;
	var $lx = 230;
	var $ly = 70;
	var $minsize = 23;
	var $maxsize = 30;
	var $noise = 0;  //number of chars in background
	var $maxrotation = 20;
	var $ttf_range = array();
	var $privkey;
	var $filename;
	var $maxold = 1800;  // 0.5 h = 1800 s

	function delold()
	{	
		global $DB;
		$handle = opendir($this->tmpfolder);
		while($file = readdir($handle))
		{
			if($file != "." && $file != ".." && $file != ".svn" && $file != "_svn")
			{
				if( filemtime($this->tmpfolder.$file) <= time() - $this->maxold )
				{
					@unlink($this->tmpfolder.$file);
					$qry = "DELETE FROM `mw_acc_creation_captcha` WHERE filename='".$this->tmpfolder.$file."'";
					$DB->query($qry);
				}
			}
		}
		closedir($handle);
	}

	function load_ttf()
	{
		$handle = opendir($this->ttf_folder);
		while($file = readdir ($handle))
		{
			if ($file != "." && $file != ".." && $file != "" && $file != ".svn" && $file != "_svn")
			{
				$this->ttf_range[] = $file;
			}
		}
		closedir($handle);
	}

	function random_color($min,$max)
	{
		srand((double)microtime() * 1000000);
		$randcol['r'] = intval(0);
		srand((double)microtime() * 1000000);
		$randcol['g'] = intval(0);
		srand((double)microtime() * 1000000);
		$randcol['b'] = intval(0);

		return $randcol;
	}

	function random_char()
	{

		$chars_image_activate=array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '2', '3', '4', '5', '6', '7', '8', '9'); // 0 o l 1 look too similar
		$randcharindex = rand(0, count($chars_image_activate)-1);
		
		return $chars_image_activate[$randcharindex];
	}

	function generate_private()
	{
		$this->privkey = "";
		for($i=0; $i < $this->chars_image_activate; $i++)
		{

			$this->privkey .= $this->random_char();
		}

	}

	function random_ttf()
	{
		$filename = $this->ttf_folder;
		$filename .= $this->ttf_range[rand(0,count($this->ttf_range)-1)];
		return $filename;
	}

	function make_captcha()
	{	
		$this->generate_private();
		$image = imagecreatetruecolor($this->lx, $this->ly);
		
		// Set Backgroundcolor
		$randcol['r'] = "255";
		$randcol['b'] = "255";
		$randcol['g'] = "255";
		$back =  imagecolorallocate($image, $randcol['r'], $randcol['g'], $randcol['b']);
		ImageFilledRectangle($image, 0, 0, $this->lx, $this->ly, $back);
		// fill with noise or grid
		if($this->noise > 0)
		{
			// random characters in background with random position, angle, color
			for($i=0; $i < $this->noise; $i++)
			{
				srand((double)microtime()*1000000);
				$size	= intval(rand((int)($this->minsize / 2.3), (int)($this->maxsize / 1.7)));
				srand((double)microtime()*1000000);
				$angle	= intval(rand(0, 360));
				srand((double)microtime()*1000000);
				$x = intval(rand(0, $this->lx));
				srand((double)microtime()*1000000);
				$y = intval(rand(0, (int)($this->ly - ($size / 5))));
				
				$randcol['r'] = "0";
				$randcol['b'] = "0";
				$randcol['g'] = "0";
				
				$color	= imagecolorallocate($image, $randcol['r'], $randcol['g'], $randcol['b']);
				srand((double)microtime()*1000000);
				$text	= $this->random_char();
				ImageTTFText($image, $size, $angle, $x, $y, $color, $this->random_ttf(), $text);
			}
		}
		else
		{
			// generate grid
			for($i=0; $i < $this->lx; $i += (int)($this->minsize / 1.5))
			{
				$randcol=$this->random_color(160, 224);
				$color	= imagecolorallocate($image, $randcol['r'], $randcol['g'], $randcol['b']);
				@imageline($image, $i, 0, $i, $this->ly, $color);
			}
			for($i=0 ; $i < $this->ly; $i += (int)($this->minsize / 1.8))
			{
				$randcol=$this->random_color(160, 224);
				$color	= imagecolorallocate($image, $randcol['r'], $randcol['g'], $randcol['b']);
				@imageline($image, 0, $i, $this->lx, $i, $color);
			}
		}

		for($i=0, $x = intval(rand($this->minsize,$this->maxsize)); $i < $this->chars_image_activate; $i++)
		{
			$text	= strtolower(substr($this->privkey, $i, 1));
			srand((double)microtime()*1000000);
			$angle	= intval(rand(($this->maxrotation * -1), $this->maxrotation));
			srand((double)microtime()*1000000);
			$size	= intval(rand($this->minsize, $this->maxsize));
			srand((double)microtime()*1000000);
			$y		= intval(rand((int)($size * 1.5), (int)($this->ly - ($size / 7))));
			$randcol=$this->random_color(0, 127);
			$color	=  imagecolorallocate($image, $randcol['r'], $randcol['g'], $randcol['b']);
			$randcol=$this->random_color(0, 127);
			$shadow = imagecolorallocate($image, $randcol['r'] + 127, $randcol['g'] + 127, $randcol['b'] + 127);
			$TTF_file=$this->random_ttf();
			ImageTTFText($image, $size, $angle, $x + (int)($size / 15), $y, $shadow, $TTF_file, $text);
			ImageTTFText($image, $size, $angle, $x, $y - (int)($size / 15), $color, $TTF_file, $text);
			$x += (int)($size + ($this->minsize / 5));
		}
	
		$filename="captcha_".sha1(uniqid (rand())).".png";
		ImagePNG($image, $this->tmpfolder.$filename);

		ImageDestroy($image);
		$this->filename = $this->tmpfolder.$filename;
	}
}
?>