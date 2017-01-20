<?php
//========================//
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['account'], 'link' => '?p=account');
$pathway_info[] = array('title' => $lang['my_donate_transactions'], 'link' => '');
// ==================== //

$transactions = $DB->select("SELECT * FROM `mw_donate_transactions` WHERE `account`='".$user['id']."'");
?>