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

$get_pack = $DB->select("SELECT * FROM `mw_donate_packages`");

function editPkg()
{
	global $DB, $lang;
	$DB->query("UPDATE `mw_donate_packages` SET
		`desc`='".$DB->real_escape_string($_POST['desc'])."',
		`cost`='".$_POST['cost']."',
		`points`='".$_POST['points']."'
	  WHERE `id`='".$_GET['id']."'
	");
	output_message('success', $lang['donate_update_success']);
}

function deletePkg()
{
	global $DB;
	$DB->query("DELETE FROM `mw_donate_packages` WHERE `id`='".$_GET['id']."'");
	output_message('success', 'Deleted Package');
}

function addPkg()
{
	global $DB, $lang;
	$DB->query("INSERT INTO mw_donate_packages(
		`desc`,
		`cost`,
		`points`)
	  VALUES(
		'".$DB->real_escape_string($_POST['desc'])."', 
		'".$_POST['cost']."', 
		'".$_POST['points']."'
		)
	");
	output_message('success', $lang['donate_add_success']);
}
?>