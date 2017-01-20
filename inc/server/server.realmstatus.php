<?php
//========================//
if(INCLUDED !== true) {
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['realmstatus'], 'link' => '');
// ==================== //

// Define we want this page to be cached
define("CACHE_FILE", FALSE);

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

foreach($Realm as $i => $result)
{
	// turn the dbinfo column into an array
	$dbinfo = explode(';', $result['dbinfo']);

	// DBinfo column: char_host;char_port;char_username;char_password;charDBname;world_host;world_port;world_username;world_pass;worldDBname
	$Realm_DB_Info = array(
		'char_db_host' => $dbinfo['0'], // char host
		'char_db_port' => $dbinfo['1'], // char port
		'char_db_username' => $dbinfo['2'], // char user
		'char_db_password' => $dbinfo['3'], // char password
		'char_db_name' => $dbinfo['4'], //char db name
		'w_db_host' => $dbinfo['5'], // world host
		'w_db_port' => $dbinfo['6'], // world port
		'w_db_username' => $dbinfo['7'], // world user
		'w_db_password' => $dbinfo['8'], // world password
		'w_db_name' => $dbinfo['9'], // world db name
		);

	// Free up memory.
	unset($dbinfo, $DB_info); 

	// Establish the Character DB connection
	$CDB_EXTRA = new Database(
		$Realm_DB_Info['char_db_host'],
		$Realm_DB_Info['char_db_port'],
		$Realm_DB_Info['char_db_username'],
		$Realm_DB_Info['char_db_password'],
		$Realm_DB_Info['char_db_name']
	);

	// Establish the World DB connection	
	$WDB_EXTRA = new Database(
		$Realm_DB_Info['w_db_host'],
		$Realm_DB_Info['w_db_port'],
		$Realm_DB_Info['w_db_username'],
		$Realm_DB_Info['w_db_password'],
		$Realm_DB_Info['w_db_name']
	);
	
	// Free up memory
	unset($Realm_DB_Info);
	
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
    $realm_type = $realm_type_def[$result['icon']];
	$realm_num = $result['id'];
	
	// Check the realm status using the check_port_status function
    if(check_port_status($result['address'], $result['port'], 2) == TRUE)
    {
		// res image is the up arrow pretty much
        $res_img = 'Online';
		
		// Get the server population
        $population = $CDB_EXTRA->count("SELECT COUNT(*) FROM `characters` WHERE online=1");
		
		// Get the server uptime
		$start_time = $DB->selectCell("SELECT `starttime` FROM `uptime` WHERE `realmid`='".$realm_num."' ORDER BY `starttime` DESC LIMIT 1");
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
    $Realm[$i]['res_color'] = $res_color;
    $Realm[$i]['status'] = $res_img;
    $Realm[$i]['name'] = $result['name'];
    $Realm[$i]['type'] = $realm_type;
//    $Realm[$i]['population'] = $population; // This was returning an array, resolved with below fix using COUNT(*) as the array key
    $Realm[$i]['population'] = $population['COUNT(*)'];
    $Realm[$i]['uptime'] = $uptime;
	
	// Unset the realms DB Connections
    unset($WDB_EXTRA);
    unset($CDB_EXTRA);
}
?>
