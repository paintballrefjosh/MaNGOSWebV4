<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

if(INCLUDED !== TRUE) {
	echo "Not Included!"; 
	exit;
}

// Check to see if the changerealm_to variable is set in the URI.  If so we need to set the selected 
// realm cookie and reload the page in order to pull the players online from the correct realm
if(isset($_GET['changerealm_to']))
{
	setcookie("cur_selected_realm", $_GET['changerealm_to'], time() + (3600 * 24 * 365));
	redirect("?p=server&sub=playersonline",1);
}

// build top of page navigation breadcrumbs
$realm = get_realm_byid($user['cur_selected_realm']);
$pathway_info[] = array('title' => $lang['online_players'], 'link' => '?p=server&sub=playersonline');
$pathway_info[] = array('title' => $realm['name'], 'link' => '');

include('core/SDL/class.zone.php');
include('core/SDL/class.character.php');
$Zone = new Zone;
$Character = new Character;

if(isset($_GET["page"]))
{
	$pid = $_GET["page"];
} 
else 
{
	$pid = 1;
}
$limit = 100;
$limitstart = ($pid - 1) * $limit;
 
$res_info = array();
$query = array();
$realm_info = get_realm_byid($_COOKIE['cur_selected_realm']);
$cc = 0;
$Online_Check = check_port_status($realm_info['address'], $realm_info['port']);
if($Online_Check == TRUE)
{
	$Count = $Character->getOnlineCount();
	$numofpgs = ($Count / $limit);
	if(gettype($Count / $limit) != "integer") 
	{
		settype($numofpgs, "integer");
		$numofpgs++;
	}
	$query = $Character->getOnlineList(0, $limitstart, $limit);
}
else
{
	$numofpgs = 0;
}

foreach($query as $result) 
{
	if($res_color==1)
	{
		$res_color=2;
	}
	else
	{
		$res_color=1;
	}
	
	$cc++;     
	$res_race = $Character->charInfo['race'][$result['race']];
	$res_class = $Character->charInfo['class'][$result['class']];
	$res_pos = $Zone->getZoneName($result['zone']);

	$res_info[$cc]["number"] = $cc;
	$res_info[$cc]["res_color"] = $res_color;
	$res_info[$cc]["name"] = $result['name'];
	$res_info[$cc]["race"] = $result['race'];
	$res_info[$cc]["class"] = $result['class'];
	$res_info[$cc]["gender"] = $result['gender'];
	$res_info[$cc]["level"] = $result['level'];
	$res_info[$cc]["pos"] = $res_pos;
	$res_info[$cc]["guid"] = $result['guid'];
}
unset($query); // Free up memory.

//===== Calc pages =====//
$pnum = ceil($Count / $limit);
$pages_str = paginate($pnum, $pid, "index.php?p=server&sub=playersonline");
?>