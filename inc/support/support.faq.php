<?php
//========================//
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

// ==================== //
$pathway_info[] = array('title' => $lang['support'], 'link' => '');
$pathway_info[] = array('title' => 'FAQ', 'link' => '');
// ==================== //

// Define we want this page to be cached
define("CACHE_FILE", TRUE);

// Lets check to see if this file is cahced or not. If it is, no need to run the mysql query
if($Core->isCached($_COOKIE['cur_selected_theme']."_server.faq") != TRUE)
{
	$alltopics = $DB->select("SELECT * FROM `mw_faq` ORDER BY `id`");
	$cc1 = 0;
}
?>