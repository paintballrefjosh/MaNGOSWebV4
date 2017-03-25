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
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => 'Shop', 'link' => '');
// ==================== //

// Lets check to see the user is logged in
if($Account->isLoggedIn() == FALSE)
{
    redirect('?p=account&sub=login',1);
}

$shop_items = $DB->select("SELECT * FROM `mw_shop_items` WHERE `realms`=".$GLOBALS['cur_selected_realm']." OR `realms`='0'");
?>