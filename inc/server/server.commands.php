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

//	************************************************************
// Redirect users who arent logged in ;)
if($Account->isLoggedIn() == FALSE)
{
	redirect('?p=account&sub=login',1);
}

if($mwe_config['emulator'] == 'mangos') 
{
	$userlevel = $RDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id` = ".$user['id']);
	$alltopics  = $WDB->select("SELECT * FROM `command` WHERE `security` <= $userlevel ORDER BY `name` ASC");
}
elseif($mwe_config['emulator'] == 'trinity') 
{
	$userlevel = $RDB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id` = ".$user['id']);
	if($userlevel == FALSE)
	{
		$userlevel = 0;
	}
	$sql = "SELECT `rbac_linked_permissions`.`linkedId` FROM `rbac_linked_permissions` 
		LEFT JOIN `rbac_default_permissions` ON (`rbac_linked_permissions`.`id` BETWEEN `rbac_default_permissions`.`permissionId` + 4 AND 199)
		WHERE `rbac_default_permissions`.`secId` <= $userlevel";
	$permissions = $RDB->select($sql);

	$permission_id = "";
	foreach($permissions as $row)
	{
		$permission_id .= $row['linkedId'].",";
	}
	$permission_id = substr($permission_id, 0, -1);

	$sql = "SELECT * FROM `command` WHERE `permission` IN ($permission_id) ORDER BY `name` ASC";
	$alltopics  = $WDB->select($sql);
}
?>