<?php
if(INCLUDED!==true)exit;

$pathway_info[] = array('title'=>$lang['statistic'],'link'=>'');

//initialize $num_chars variable
$num_chars = 0;
$realm_param = $user['cur_selected_realmd'];
$rc = $CHDB->selectCol("SELECT race AS ARRAY_KEY, count(race) AS `num` FROM `characters` GROUP BY race");

foreach($rc as $data)
{
    $num_chars+=$data;
}
// Loop thru classes, add 0 if its not defined in array.
for($i = 1; $i <= 11; $i++)if (!isset($rc[$i]))$rc[$i] = 0;

//Check if 0 entries to avoid PHP warnings if 0 chars in database.
if ($num_chars > 0){
    $num_ally = $rc[1]+$rc[3]+$rc[4]+$rc[7]+$rc[11];
    $num_horde = $rc[2]+$rc[5]+$rc[6]+$rc[8]+$rc[10];
    $pc_ally =  round($num_ally/$num_chars*100,2);
    $pc_horde =  round($num_horde/$num_chars*100,2);
    $pc_human = round($rc[1]/$num_chars*100,2);
    $pc_orc = round($rc[2]/$num_chars*100,2);
    $pc_dwarf = round($rc[3]/$num_chars*100,2);
    $pc_ne = round($rc[4]/$num_chars*100,2);
    $pc_undead = round($rc[5]/$num_chars*100,2);
    $pc_tauren = round($rc[6]/$num_chars*100,2);
    $pc_gnome = round($rc[7]/$num_chars*100,2);
    $pc_troll = round($rc[8]/$num_chars*100,2);
    $pc_be = round($rc[10]/$num_chars*100,2);
    $pc_dranei = round($rc[11]/$num_chars*100,2);
}
?>

