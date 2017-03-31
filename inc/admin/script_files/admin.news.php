<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
$gettopics = $DB->select("SELECT `title`,`id`,`posted_by`,`post_time` FROM `mw_news`");

// If posting a new News post
function addNews($subj,$message,$un) 
{
	global $DB, $lang;
    if(!$subj | !$message)
	{
		output_message('validation', $lang['field_left_blank']);
	}
	else
	{
		$post_time = time();
		$sql =  "INSERT INTO mw_news(title, message, posted_by, post_time) VALUES('".$DB->real_escape_string($subj)."','".$DB->real_escape_string($message)."','".$un."','".$post_time."')";
        $tabs = $DB->query($sql);

		output_message('success', $lang['news_add_success']);
    }
}
function editNews($idz,$mess) 
{
	global $DB, $lang;
	if(!$mess)
	{
		output_message('validation', $lang['field_left_blank']);
	}
	else
	{
		$DB->query("UPDATE `mw_news` SET `message`='".$DB->real_escape_string($mess)."' WHERE `id`='$idz'");

		output_message('success', $lang['news_edit_success']);
	}
}
function delNews($idzz) 
{
	global $DB;
	$DB->query("DELETE FROM `mw_news` WHERE `id`='$idzz'");

	output_message('success', 'Deleted News Item.');
}
?>