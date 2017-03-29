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
$pathway_info[] = array('title' => $lang['activation'], 'link' => '');
// ==================== //

$postnum = 0;
$hl = '';

// If the hit counter is enabled, then add a hit when this page is accessed
if($mwe_config['fp_hitcounter'] == 1)
{
    $count_my_page = "inc/frontpage/hitcounter.txt";
    $hits = (int)file_get_contents($count_my_page);
    $hits++;
    file_put_contents($count_my_page, $hits);
}

$alltopics = $DB->select("SELECT * FROM mw_news ORDER BY `id` DESC");
$servers = array();
$multirealms = getRealmlist();
foreach($multirealms as $realmnow_arr)
{
	if($mwe_config['fp_server_info'] == 1)
	{
		$data = $RDB->selectRow("SELECT * FROM realmlist WHERE id ='".$realmnow_arr['realm_id']."' LIMIT 1");

		$CHDB_EXTRA = new Database(
			$realmnow_arr['db_char_host'],
			$realmnow_arr['db_char_port'],
			$realmnow_arr['db_char_user'],
			$realmnow_arr['db_char_pass'],
			$realmnow_arr['db_char_name']
		);

		$server = array();
		$server['name'] = $data['name'];
		if((int)$mwe_config['fp_realm_status'] == 1)
		{
			$checkaddress = $data['address'];
			$server['realm_status'] = (check_port_status($checkaddress, $data['port'], 0.5) === true) ? true : false;
		}
		$changerealmtoparam = array("changerealm_to" => $realmnow_arr['realm_id']);
		if($mwe_config['fp_players_online'] == 1)
		{
			$server['playersonline'] = $CHDB_EXTRA->count("SELECT `guid` FROM `characters` WHERE online=1");
			$server['onlineurl'] = mw_url('server', 'playersonline', $changerealmtoparam);
		}
		if($mwe_config['fp_server_ip'] == 1)
		{
			$server['server_ip'] = $data['address'];
		}
		if($mwe_config['fp_server_type'] == 1)
		{
			$server['type'] = $realm_type_def[$data['icon']];
		}
		if($mwe_config['fp_server_lang'] == 1)
		{
			$server['language'] = $realm_timezone_def[$data['timezone']];
		}
		if($mwe_config['fp_server_pop'] == 1)
		{
			$server['population'] = $CHDB_EXTRA->count("SELECT `guid` FROM `characters` WHERE online=1");
		}
		if($mwe_config['fp_server_act'] == 1)
		{
			$server['accounts'] = $RDB->count("SELECT `id` FROM `account`");
		}
		if($mwe_config['fp_server_active_act'] == 1)
		{
			$server['active_accounts'] = $RDB->count("SELECT `id` FROM `account` WHERE `last_login` > ". date("Y-m-d", strtotime("-2 week")));
		}
		if($mwe_config['fp_server_chars'] == 1)
		{
			$server['characters'] = $CHDB_EXTRA->count("SELECT `guid` FROM `characters`");
		}
		unset($CHDB_EXTRA, $data); // Free up memory.

		$server['moreinfo'] = $mwe_config['fp_server_more_info'];
		$servers[] = $server;
	}
}

unset($multirealms);
if($mwe_config['module_online_list'] == 1)
{
	$usersonhomepage = $DB->count("SELECT `id` FROM `mw_online`");
}

