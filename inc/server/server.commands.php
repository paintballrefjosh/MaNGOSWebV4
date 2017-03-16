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

$pathway_info[] = array('title' => $lang['commands'], 'link' => '');
$items_per_page = 20;	// Output items limit
$defaultOpen =  0;	// First N items that are "opened" by default.
$hl = '';   // High lighted item
if(isset($_GET['sp'])) 
{  
	$startpage = $_GET['sp'];
}
else
{
	$startpage = 1;
}
$userid = $user['id'];
if($mwe_config['emulator'] == 'mangos') 
{
	$userlevel = $RDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id`='$userid'");
}
elseif($mwe_config['emulator'] == 'trinity') 
{
	$userlevel = $RDB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id`='$userid'");
	if($userlevel == FALSE)
	{
		$userlevel = 1;
	}
}
$maxtopics  = $WDB->count("SELECT name FROM `command` WHERE `security` <= $userlevel");

$maxpages = round($maxtopics / $items_per_page);
if(($maxpages * $items_per_page) < $maxtopics) 
{
	$maxpages += 1;
}
if ($startpage < 1) 
{
	$startpage = 1;
}
if ($startpage > $maxpages) 
{
	$startpage = $maxpages;
}
$sp = ($startpage * $items_per_page ) - $items_per_page;
$alltopics = $WDB->select("SELECT * FROM command WHERE security <= $userlevel ORDER BY `security` ASC, `name` ASC LIMIT $sp , $items_per_page");
?>
