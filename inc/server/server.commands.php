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

if($mwe_config['emulator'] == 'mangos') 
{
	$userlevel = $DB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id` = ".$user['id']);
	$alltopics  = $WDB->select("SELECT * FROM `command` WHERE `security` <= $userlevel ORDER BY `name` ASC");
}
elseif($mwe_config['emulator'] == 'trinity') 
{
	$userlevel = $RDB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id` = ".$user['id']);
	if($userlevel == FALSE)
	{
		$userlevel = 0;
	}
	
	$permissions = $RDB->select("SELECT `rbac_linked_permissions`.`linkedId` FROM `rbac_linked_permissions` 
		LEFT JOIN `rbac_default_permissions` ON (`rbac_linked_permissions`.`id` = `rbac_default_permissions`.`permissionId`)
		WHERE `rbac_default_permissions`.`secId` =  <= $userlevel"
	);
	$permissions = join(",", $permissions);
	$alltopics  = $WDB->select("SELECT * FROM `command` WHERE `permission` IN ($permissions) ORDER BY `name` ASC");
}
?>