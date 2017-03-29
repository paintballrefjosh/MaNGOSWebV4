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

//====== Pagination Code ======/
$limit = 20; // Sets how many results shown per page	
if(!isset($_GET['page']) || (!is_numeric($_GET['page'])))
{
    $page = 1;
} 
else 
{
	$page = htmlspecialchars($_GET['page']);
}
$limitvalue = $page * $limit - ($limit);	// Ex: (2 * 25) - 25 = 25 <- data starts at 25

// Get all items
$getitems = $DB->select("SELECT * FROM mw_shop_items ORDER BY `id` ASC LIMIT $limitvalue, $limit;");
$getcnt = $DB->select("SELECT item_number FROM mw_shop_items");
$totalrows = count($getcnt);

// Get alist of all the realms
$realms = getRealmlist(0);
foreach($realms as $aaa) 
{
	$realmzlist .= "<option value='".$aaa['id']."'>".$aaa['name']."</option>";
}

function editItem()
{
	global $DB;
	$DB->query("UPDATE `mw_shop_items` SET
		`item_number`=".(int)$_POST['item_number'].",
		`itemset`=".(int)$_POST['itemset'].",
		`gold`=".(int)$_POST['gold'].",
		`quanity`=".(int)$_POST['quanity'].",
		`desc`='".$_POST['desc']."',
		`wp_cost`=".(int)$_POST['wp_cost'].",
		`realms`='".$_POST['realms']."'
	  WHERE `id`='".$_GET['id']."'
	");
	output_message('success', 'Shop Item successfully updated!');
}

function deleteItem()
{
	global $DB;
	$DB->query("DELETE FROM `mw_shop_items` WHERE `id`='".$_GET['id']."'");
	output_message('success', 'Deleted Shop Item!');
}

function addItem()
{
	global $DB;
	$DB->query("INSERT INTO mw_shop_items(
		`item_number`,
		`itemset`,
		`gold`,
		`quanity`,
		`desc`,
		`wp_cost`,
		`realms`)
	  VALUES(
		".(int)$_POST['item_number'].",
		".(int)$_POST['itemset'].",
		".(int)$_POST['gold'].",		
		".(int)$_POST['quanity'].",
		'".$_POST['desc']."',
		".(int)$_POST['wp_cost'].",
		'".$_POST['realms']."'
		)
	");
	output_message('success', 'Shop Item successfully added to Database!');
}
?>