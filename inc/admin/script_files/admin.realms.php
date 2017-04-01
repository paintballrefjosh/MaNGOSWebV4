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

if($user['account_level'] != 4)
{
	echo "You Do not have the right privilages to view this page!";
	exit;
}

$getrealms = $RDB->select("SELECT * FROM `realmlist`");

function updateRealm()
{
	global $DB, $RDB, $lang;
	$RDB->query("UPDATE `realmlist` SET 
		`name` = '".$_POST['realm_name']."',
		`address` = '".$_POST['realm_address']."',
		`port` = '".$_POST['realm_port']."',
		`timezone` = '".$_POST['timezone']."'
	WHERE `id`=".$_GET['id']);

	$realm = $DB->count("SELECT realm_id FROM `mw_realm` WHERE `realm_id` = '".$_GET['id']."'");
	
	if(empty($_POST['db_world_port']))
		$_POST['db_world_port'] = 0;
	
	if(empty($_POST['db_char_port']))
		$_POST['db_char_port'] = 0;
	
	if(empty($_POST['ra_port']))
		$_POST['ra_port'] = 0;
	
	if($realm > 0)
	{
		$DB->query("UPDATE `mw_realm` SET 
			`db_world_host` = '".$_POST['db_world_host']."',
			`db_world_name` = '".$_POST['db_world_name']."',
			`db_world_port` = '".$_POST['db_world_port']."',
			`db_world_user` = '".$_POST['db_world_user']."',
			`db_world_pass` = '".$_POST['db_world_pass']."',
			`db_char_host` = '".$_POST['db_char_host']."',
			`db_char_name` = '".$_POST['db_char_name']."',
			`db_char_port` = '".$_POST['db_char_port']."',
			`db_char_user` = '".$_POST['db_char_user']."',
			`db_char_pass` = '".$_POST['db_char_pass']."',
			`ra_type` = '".$_POST['ra_type']."',
			`ra_port` = '".$_POST['ra_port']."',
			`ra_user` = '".$_POST['ra_user']."',
			`ra_pass` = '".$_POST['ra_pass']."',
			`site_enabled` = '".$_POST['site_enabled']."'
		WHERE `realm_id` = ".$_GET['id']."
		");
	}
	else
	{
		$DB->query("INSERT INTO `mw_realm` SET 
			`db_world_host` = '".$_POST['db_world_host']."',
			`db_world_name` = '".$_POST['db_world_name']."',
			`db_world_port` = '".$_POST['db_world_port']."',
			`db_world_user` = '".$_POST['db_world_user']."',
			`db_world_pass` = '".$_POST['db_world_pass']."',
			`db_char_host` = '".$_POST['db_char_host']."',
			`db_char_name` = '".$_POST['db_char_name']."',
			`db_char_port` = '".$_POST['db_char_port']."',
			`db_char_user` = '".$_POST['db_char_user']."',
			`db_char_pass` = '".$_POST['db_char_pass']."',
			`ra_type` = '".$_POST['ra_type']."',
			`ra_port` = '".$_POST['ra_port']."',
			`ra_user` = '".$_POST['ra_user']."',
			`ra_pass` = '".$_POST['ra_pass']."',
			`site_enabled` = '".$_POST['site_enabled']."',
			`realm_id` = ".$_GET['id'].";
		");
	}

	output_message('success', $lang['realm_update_success']);
}
?>