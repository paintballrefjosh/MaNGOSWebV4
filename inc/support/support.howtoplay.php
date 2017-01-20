<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
$pathway_info[] = array('title' => $lang['support'], 'link' => '');
$pathway_info[] = array('title' => $lang['howtoplay'], 'link' => '');
//=======================//

$content = file_get_contents("lang/".$GLOBALS['user_cur_lang']."/howtoplay.html");

?>

