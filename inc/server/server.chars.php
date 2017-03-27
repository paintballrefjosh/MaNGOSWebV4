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

// build top of page navigation breadcrumbs
$realm_info = get_realm_byid($user['cur_selected_realm']);
$pathway_info[] = array('title' => $lang['Characters'], 'link' => '?p=server&sub=chars');
$pathway_info[] = array('title' => $realm_info['name'], 'link' => '');


if(isset($_GET['page']))
{
	$p = $_GET['page'];
}
else
{
	$p = 1;
}

//===== Calc pages1 =====//
$items_per_pages = 100;
$limit_start = ($p-1) * $items_per_pages;
// ==================== //

include('core/SDL/class.zone.php');
include('core/SDL/class.character.php');
$Zone = new Zone;
$Character = new Character;

$query = array();
 
$cc = 0;

// arrays
$query1 = array();

//Find total number of characters in database -- used to calculate total number of pages
$cc2 = (int)$CDB->count("SELECT guid FROM `characters`");

$query1 = $CDB->select("SELECT * FROM `characters` ORDER BY `name` LIMIT $limit_start, $items_per_pages");

$cc1 = 0;
$item_res = array();

if($cc2 > 0)
{
	foreach ($query1 as $result1) 
	{
		if($res_color==1) 
		{
		  $res_color=2;
		}
		else
		{
		  $res_color=1;
		}
		$cc1++;
		$res_pos = $Zone->getZoneName($result1['zone']);

		$char_gender = dechex($result1['gender']);
		
		$item_res[$cc1]["number"] = $cc1;
		$item_res[$cc1]["name"] = $result1['name'];
		$item_res[$cc1]["res_color"] = $res_color;
		$item_res[$cc1]["race"] = $result1['race'];
		$item_res[$cc1]["class"] = $result1['class'];
		$item_res[$cc1]["gender"] = $char_gender;
		$item_res[$cc1]["level"] = $result1['level'];
		$item_res[$cc1]["pos"] = $res_pos;
		$item_res[$cc1]["guid"] = $result1['guid'];
    }
}
unset($query1, $result1);

//===== Calc pages2 =====//
$pnum = ceil($cc2 / $items_per_pages);
$pages_str = paginate($pnum, $p, "index.php?p=server&sub=chars");
?>
