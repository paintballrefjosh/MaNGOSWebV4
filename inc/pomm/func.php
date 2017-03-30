<?php

function error($message)
{
	$s = 'Error: <strong>'.$message.'.</strong>';
	echo $s;
}

function sort_players($a, $b)
{
	if($a['leaderGuid'] == $b['leaderGuid'])
		return strcmp($a['name'],$b['name']);
	return ($a['leaderGuid'] < $b['leaderGuid']) ? -1 : 1;
}

function get_zone_name($zone_id)
{
	global $zones;
	$zname = 'Unknown zone';
	if(isset($zones[$zone_id])) {
		$zname = $zones[$zone_id];
    		}
	return $zname;
} 

function test_realm(){
	//return true; //always run
	global $server, $port;
	$s = @fsockopen("$server", $port, $ERROR_NO, $ERROR_STR,(float)0.5);
	if($s){@fclose($s);return true;} else return false;
}
?>