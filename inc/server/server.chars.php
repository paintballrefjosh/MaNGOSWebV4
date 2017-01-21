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
if(INCLUDED !== TRUE) {
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title'=>$lang['Characters'],'link'=>'');
//========================//

// Tell the cache not to cache the file because theres more then 1 page
define("CACHE_FILE", FALSE);

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
$realm_info_new = get_realm_byid($_COOKIE['cur_selected_realm']);
 
$cc = 0;

// array´s
$query1 = array();

//===== Filter ==========//
if($_GET['char'] && preg_match("/[a-z]/",$_GET['char']))
{
   $filter = "WHERE `name` LIKE '".$_GET['char']."%'";
}
elseif($_GET['char'] == 1)
{
   $filter = "WHERE `name` REGEXP '^[^A-Za-z]'";
}
else
{
   $filter = '';
}

//Find total number of characters in database -- used to calculate total number of pages
$cc2 =  $CDB->count("SELECT count(*) FROM `characters` $filter");
// again count() was returning an array, hacked it to work below
$cc2 = $cc2['count(*)'];

$query1 = $CDB->select("SELECT * FROM `characters` $filter ORDER BY `name` LIMIT $limit_start, $items_per_pages");

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
