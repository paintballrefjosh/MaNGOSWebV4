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

$get_faq = $DB->select("SELECT * FROM `mw_faq`");

function editFaq()
{
	global $DB, $Core, $lang;
	$DB->query("UPDATE `mw_faq` SET
		`question`='".$DB->real_escape_string($_POST['question'])."',
		`answer`='".$DB->real_escape_string($_POST['answer'])."'
	  WHERE `id`='".$_GET['id']."'
	");

	output_message('success', $lang['faq_updated_success']);
	redirect("?p=admin&amp;sub=faq", 0, 2);
}

function deleteFaq()
{
	global $DB, $Core;
	$DB->query("DELETE FROM `mw_faq` WHERE `id`='".$_GET['id']."'");

	output_message('success', 'Deleted Faq');
	redirect("?p=admin&amp;sub=faq", 0, 2);
}

function addFaq()
{
	global $DB, $Core, $lang;
	$DB->query("INSERT INTO mw_faq(
		`question`,
		`answer`)
	  VALUES(
		'".$DB->real_escape_string($_POST['question'])."',  
		'".$DB->real_escape_string($_POST['answer'])."'
		)
	");

	output_message('success', $lang['faq_add_success']);
	redirect("?p=admin&amp;sub=faq", 0, 2);
}
?>