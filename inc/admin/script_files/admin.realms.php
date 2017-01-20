<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

if($user['account_level'] != 4)
{
	echo "You Do not have the right privilages to view this page!";
	exit;
}

$getrealms = $DB->select("SELECT * FROM `realmlist`");

function updateRealm()
{
	global $DB, $lang;
	$DB->query("UPDATE `realmlist` SET 
		`name`= '".$_POST['realm_name']."',
		`address`= '".$_POST['realm_address']."',
		`port`= '".$_POST['realm_port']."',
		`icon`= '".$_POST['icon']."',
		`timezone`= '".$_POST['timezone']."',
		`dbinfo`= '".$_POST['char_db_host'].";".$_POST['char_db_port'].";".$_POST['char_db_user'].";".$_POST['char_db_pass'].";".$_POST['char_db_name'].";".$_POST['w_db_host'].";".$_POST['w_db_port'].";".$_POST['w_db_user'].";".$_POST['w_db_pass'].";".$_POST['w_db_name']."',
		`ra_info`= '".$_POST['ra_type'].";".$_POST['ra_port'].";".$_POST['ra_user'].";".$_POST['ra_pass']."',
		`site_enabled`= '".$_POST['site_enabled']."'
	   WHERE `id`=".$_GET['id']."
	");
	output_message('success', $lang['realm_update_success']);
}
?>