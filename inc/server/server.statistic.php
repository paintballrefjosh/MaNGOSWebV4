<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}

// build top of page navigation breadcrumbs
$realm = $RDB->selectRow("SELECT * FROM realmlist WHERE `id`='".$user['cur_selected_realm']."' LIMIT 1");
$pathway_info[] = array('title' => 'Server Statistics', 'link' => '?p=server&sub=statistic');
$pathway_info[] = array('title' => $realm['name'], 'link' => '');

//initialize $num_chars variable
$num_chars = 0;
$rc = $CDB->select("SELECT race, count(race) AS `num` FROM `characters` GROUP BY race");

foreach($rc as $row)
{
    $data[$row['race']] = $row['num'];
}

// Loop thru classes, add 0 if its not defined in array.
for($i = 1; $i <= 26; $i++)
{
    if(!isset($data[$i]))
    {
        $data[$i] = 0;
    }

    $num_chars += $data[$i];
}

//Check if 0 entries to avoid PHP warnings if 0 chars in database.
if ($num_chars > 0)
{
    $num_ally = $data[1]+$data[3]+$data[4]+$data[7]+$data[11]+$data[22]+$data[25];
    $num_horde = $data[2]+$data[5]+$data[6]+$data[8]+$data[10]+$data[9]+$data[26];
    $pc_ally =  round($num_ally/$num_chars*100,2);
    $pc_horde =  round($num_horde/$num_chars*100,2);
    $pc_human = round($data[1]/$num_chars*100,2);
    $pc_orc = round($data[2]/$num_chars*100,2);
    $pc_dwarf = round($data[3]/$num_chars*100,2);
    $pc_ne = round($data[4]/$num_chars*100,2);
    $pc_undead = round($data[5]/$num_chars*100,2);
    $pc_tauren = round($data[6]/$num_chars*100,2);
    $pc_gnome = round($data[7]/$num_chars*100,2);
    $pc_troll = round($data[8]/$num_chars*100,2);
    $pc_be = round($data[10]/$num_chars*100,2);
    $pc_dranei = round($data[11]/$num_chars*100,2);
    $pc_goblin = round($data[9]/$num_chars*100,2);
    $pc_worgen = round($data[22]/$num_chars*100,2);
    $pc_pandaren_ally = round($data[25]/$num_chars*100,2);
    $pc_pandaren_horde = round($data[26]/$num_chars*100,2);
}
?>

