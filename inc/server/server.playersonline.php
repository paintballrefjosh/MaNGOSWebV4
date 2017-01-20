<?php
//========================//
if(INCLUDED !== TRUE) {
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title'=>$lang['online_players'],'link'=>'');
// ==================== //

// Tell the cache not to cache the file because we want live feeds
define("CACHE_FILE", FALSE);

include('core/SDL/class.zone.php');
include('core/SDL/class.character.php');
$Zone = new Zone;
$Character = new Character;

if(isset($_GET["page"]))
{
	$pid = $_GET["page"];
} 
else 
{
	$pid = 1;
}
$limit = 100;
$limitstart = ($pid - 1) * $limit;
 
$res_info = array();
$query = array();
$realm_info = get_realm_byid($_COOKIE['cur_selected_realm']);
$cc = 0;
$Online_Check = check_port_status($realm_info['address'], $realm_info['port']);
if($Online_Check == TRUE)
{
	$Count = $Character->getOnlineCount();
	$numofpgs = ($Count / $limit);
	if(gettype($Count / $limit) != "integer") 
	{
		settype($numofpgs, "integer");
		$numofpgs++;
	}
	$query = $Character->getOnlineList(0, $limitstart, $limit);
}
else
{
	$numofpgs = 0;
}

foreach($query as $result) 
{
	if($res_color==1)
	{
		$res_color=2;
	}
	else
	{
		$res_color=1;
	}
	
	$cc++;     
	$res_race = $Character->charInfo['race'][$result['race']];
	$res_class = $Character->charInfo['class'][$result['class']];
	$res_pos = $Zone->getZoneName($result['zone']);

	$res_info[$cc]["number"] = $cc;
	$res_info[$cc]["res_color"] = $res_color;
	$res_info[$cc]["name"] = $result['name'];
	$res_info[$cc]["race"] = $result['race'];
	$res_info[$cc]["class"] = $result['class'];
	$res_info[$cc]["gender"] = $result['gender'];
	$res_info[$cc]["level"] = $result['level'];
	$res_info[$cc]["pos"] = $res_pos;
	$res_info[$cc]["guid"] = $result['guid'];
}
unset($query); // Free up memory.

//===== Calc pages =====//
$pnum = ceil($Count / $limit);
$pages_str = paginate($pnum, $pid, "index.php?p=server&sub=playersonline");
?>