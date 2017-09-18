<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}

$pathway_info[] = array('title' => $lang['wallpaper_gallery'], 'link' => '');

if(isset($_POST['doadd']))
{
    $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);

	if($fn)
	{

		// AJAX call
		file_put_contents(
			'modules/ssotd/wallpapers/' . $fn,
			file_get_contents('php://input')
		);
		die("$fn uploaded");
	}
	else
	{
		// form submit
		$files = $_FILES['fileselect'];

		foreach ($files['error'] as $id => $err) {
			if ($err == UPLOAD_ERR_OK) {
				$fn = $files['name'][$id];
				move_uploaded_file(
					$files['tmp_name'][$id],
					'uploads/' . $fn
				);
				echo "<p>File $fn uploaded.</p>";
			}
		}

	}
	
	/*$img=isset($_FILES["filename"]["name"]) ? $_FILES["filename"]["name"] : '';
    $comment=isset($_POST['message']) ? $_POST['message'] : '';
    $autor=$user['character_name'];

    if($_FILES["filename"]["size"] > (1024*$screensize*1024) )
    {
        echo $lang['Filesizes'];
        echo " ";
        echo $screensize;
        echo Mb;
        exit;
    }

    if(!in_array($_FILES["filename"]["type"], array("image/jpeg", "image/pjpeg", "image/jpg")))
    {
        echo $lang['Filetype'];
        echo ("<br/>");
        exit;
    }

    if($DB->count("SELECT `id` FROM `mw_gallery` WHERE `img` = ? AND `cat` = 'wallpaper'", $img) > 0)
    {
        echo $lang['ErrorFilename'];
        exit;
    }

    if(copy($_FILES["filename"]["tmp_name"], "modules/ssotd/wallpapers/".$_FILES["filename"]["name"]))
    {
        $comment = "wallpaper";
        $DB->query("INSERT INTO `mw_gallery` (`img`,`comment`,`autor`,`date`,`cat`) VALUES(?,?,".$user['id'].",".time().",'wallpaper')",$img,$comment);
    }
    else
    {
        echo $lang['Uploaderror'];
    }*/
}

?>