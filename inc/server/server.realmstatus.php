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
if(INCLUDED !== true) {
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['realmstatus'], 'link' => '');
// ==================== //

// Start a page desc
$PAGE_DESC = $lang['realm_status_desc'];

$Realm = array();
$Realm = getRealmlist();
$i = 0;

// ********************************************************
/*
	This function converts a unix time into an
	days / hours / minutes time
*/

function parse_time($number) 
{
	$time = array();
    $time['d'] = intval($number/3600/24);
	$time['h'] = intval(($number % (3600*24))/3600);
	$time['m'] = intval(($number % 3600)/60);
	$time['s'] = (($number % 3600) % 60);

	return $time;
}

// ********************************************************
/*
	This function echos the days, minutes, seconds time
*/

function print_time($time_array) 
{
	global $lang;
	
	$count = 0;
	$return = '';
	
	if($time_array['d'] > 0) 
	{
		$return .= $time_array['d'];
		$return .= " Days";
		$count++;
	}
	if($time_array['h'] > 0) 
	{
        if ($count > 0) 
		{
			$return .= ', ';
		}
		$return .= $time_array['h'];
		$return .= "h";
		$count++;
	}
	if($time_array['m'] > 0) 
	{
		if ($count > 0)
		{
			$return .= ', ';
		}
		$return .= $time_array['m'];
		$return .= "m";
		$count++;
	}
	if($time_array['s'] > 0) 
	{
		if ($count < 2)
		{
			$return .= ', ';
			$return .= $time_array['s'];
			$return .= "s";
		}
	}
	return $return;
}

// ************************************************************
/*
	Main array of realms. Foreach realm, we connect
	to the databases, check the port status, and
	get the server uptime, population, and time.
*/
$realm_list = array();

foreach($Realm as $row)
{
	$realm_data = $RDB->selectRow("SELECT * FROM `realmlist` WHERE `id` = '".$row['realm_id']."'");

	$row = array_merge($row, $realm_data);
	
	// Establish the Character DB connection
	$CDB_EXTRA = new Database(
		$row['db_char_host'],
		$row['db_char_port'],
		$row['db_char_user'],
		$row['db_char_pass'],
		$row['db_char_name']
	);

	// Establish the World DB connection	
	$WDB_EXTRA = new Database(
		$row['db_world_host'],
		$row['db_world_port'],
		$row['db_world_user'],
		$row['db_world_pass'],
		$row['db_world_name']
	);

	// $res_color is a template thing for blizzlike templates,
	// makes each row an offset color from the previous
    if($res_color == 1)
	{
		$res_color = 2;
	}
	else
	{
		$res_color=1;
	}
	
	// Define the realm type, and realm number
    $realm_type = $realm_type_def[$row['icon']];
	$realm_num = $row['realm_id'];
	
	// Check the realm status using the check_port_status function
    if(check_port_status($row['address'], $row['port'], 2) == TRUE)
    {
		// res image is the up arrow pretty much
        $res_img = 'Online';
		
		// Get the server population
        $population = (int)$CDB_EXTRA->count("SELECT guid FROM `characters` WHERE online=1");
		
		// Get the server uptime
		$start_time = $RDB->selectCell("SELECT `starttime` FROM `uptime` WHERE `realmid`='".$realm_num."' ORDER BY `starttime` DESC LIMIT 1");
        $uptime = (time() - $start_time);
    }
    else
    {
		// Get the result image arrow
        $res_img = 'Offline';
        $population = 0;
        $uptime = 0;
    }
	
	// Convert uptime into a days / hours / minutes format
	if($uptime != 0) 
	{ 
		$uptime = print_time(parse_time($uptime)); 
	}
	else
	{
		$uptime = "N/A";
	}
	
	// Setup this realm in the array
    $realm_list[$i]['res_color'] = $res_color;
    $realm_list[$i]['status'] = $res_img;
    $realm_list[$i]['name'] = $row['name'];
    $realm_list[$i]['type'] = $realm_type;
    $realm_list[$i]['population'] = $population;
    $realm_list[$i]['uptime'] = $uptime;
	
	// Unset the realms DB Connections
    unset($WDB_EXTRA);
    unset($CDB_EXTRA);
	$i++;
}
?>
