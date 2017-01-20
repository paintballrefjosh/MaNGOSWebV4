<?php
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
if($Config->get('emulator') == 'mangos') 
{
	$userlevel = $DB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id`='$userid'");
}
elseif($Config->get('emulator') == 'trinity') 
{
	$userlevel = $DB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id`='$userid'");
	if($userlevel == FALSE)
	{
		$userlevel = 1;
	}
}
$maxtopics  = $WDB->count("SELECT COUNT(*) FROM `command` WHERE `security` <= $userlevel");

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
