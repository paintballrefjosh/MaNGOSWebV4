<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//
$gettopics = $DB->select("SELECT `title`,`id`,`posted_by`,`post_time` FROM `mw_news`");

// If posting a new News post
function addNews($subj,$message,$un) 
{
	global $DB, $Core, $lang;
    if(!$subj | !$message)
	{
		output_message('validation', $lang['field_left_blank']);
	}
	else
	{
		$post_time = time();
		$sql =  "INSERT INTO mw_news(title, message, posted_by, post_time) VALUES('".$subj."','".$message."','".$un."','".$post_time."')";
        $tabs = $DB->query($sql);
		$Core->clearCache();
		output_message('success', $lang['news_add_success']);
    }
}
function editNews($idz,$mess) 
{
	global $DB, $Core, $lang;
	if(!$mess)
	{
		output_message('validation', $lang['field_left_blank']);
	}
	else
	{
		$DB->query("UPDATE `mw_news` SET `message`='$mess' WHERE `id`='$idz'");
		$Core->clearCache();
		output_message('success', $lang['news_edit_success']);
	}
}
function delNews($idzz) 
{
	global $DB, $Core;
	$DB->query("DELETE FROM `mw_news` WHERE `id`='$idzz'");
	$Core->clearCache();
	output_message('success', 'Deleted News Item.');
}
?>