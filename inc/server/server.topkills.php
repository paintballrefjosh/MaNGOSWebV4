<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

$realm = $DB->selectRow("SELECT * FROM realmlist WHERE `id`='".$user['cur_selected_realm']."' LIMIT 1");

// ==================== //
$pathway_info[] = array('title' => 'Top Kills', 'link' => '?p=server&sub=topkills');
$pathway_info[] = array('title' => $realm['name'], 'link' => '');
// ==================== //


// Define not to cache because of there being multi realms
define("CACHE_FILE", FALSE);

// some config //
$limit = 50; // Only top 50 in stats

include('core/SDL/class.character.php');
$Character = new Character;

// Calculates the rank of the character based on the number of
// Kills. Param $honor_points = Total Kills
function calc_character_rank($honor_points)
{
    $rank = 0;
    if($honor_points <= 0)
	{
        $rank = 0;
    }
	else
	{
        if($honor_points < 100)
		{
			$rank = 1;
		}
        else
		{
			$rank = ceil($honor_points / 1000) + 1;
		}
    }
    if($rank > 14)
	{
		$rank = 14;
	}
    return $rank;
}

// Get the top so many kills for each faction using the Character SDL
$ally_kills = $Character->getFactionTopKills(1, $limit);
$horde_kills = $Character->getFactionTopKills(0, $limit);

if($ally_kills != FALSE)
{
	foreach($ally_kills as $charinfo_item)
	{
		$char_rank_id = calc_character_rank($charinfo_item['totalKills']);
		$character = array(
			'name'   => $charinfo_item['name'],
			'race'   => $Character->charInfo['race'][$charinfo_item['race']],
			'class'  => $Character->charInfo['class'][$charinfo_item['class']],
			'gender' => $Character->charInfo['gender'][$charinfo_item['gender']],
			'rank'   => '',
			'level'  => $charinfo_item['level'],
			'honorable_kills'    =>  $charinfo_item['totalKills'],
			'race_icon'   => $Template['path'] .'/images/icons/race/'.$charinfo_item['race'].'-'.$charinfo_item['gender'].'.gif',
			'class_icon'   => $Template['path'] .'/images/icons/class/'.$charinfo_item['class'].'.gif',
			'rank_icon'   => $Template['path'] .'/images/icons/pvpranks/rank'.$char_rank_id.'.gif',
		);
		$allhonor[1][] = $character;
	}
}		

if($horde_kills != FALSE)
{
	foreach($horde_kills as $charinfo_item)
	{
		$char_rank_id = calc_character_rank($charinfo_item['totalKills']);
		$character = array(
			'name'   => $charinfo_item['name'],
			'race'   => $Character->charInfo['race'][$charinfo_item['race']],
			'class'  => $Character->charInfo['class'][$charinfo_item['class']],
			'gender' => $Character->charInfo['gender'][$charinfo_item['gender']],
			'rank'   => '',
			'level'  => $charinfo_item['level'],
			'honorable_kills'    =>  $charinfo_item['totalKills'],
			'race_icon'   => $Template['path'] .'/images/icons/race/'.$charinfo_item['race'].'-'.$charinfo_item['gender'].'.gif',
			'class_icon'   => $Template['path'] .'/images/icons/class/'.$charinfo_item['class'].'.gif',
			'rank_icon'   => $Template['path'] .'/images/icons/pvpranks/rank'.$char_rank_id.'.gif',
		);
		$allhonor[0][] = $character;
	}
}
?>
