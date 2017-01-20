<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => 'Shop', 'link' => '');
// ==================== //

define("CACHE_FILE", FALSE);

// Lets check to see the user is logged in
if($Account->isLoggedIn() == FALSE)
{
    redirect('?p=account&sub=login',1);
}

$shop_items = $DB->select("SELECT * FROM `mw_shop_items` WHERE `realms`=".$GLOBALS['cur_selected_realm']." OR `realms`='0'");
?>