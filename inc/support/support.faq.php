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
if(INCLUDED!==true) {
	echo "Not Included!"; exit;
}
//=======================//

// ==================== //
$pathway_info[] = array('title' => $lang['support'], 'link' => '');
$pathway_info[] = array('title' => 'FAQ', 'link' => '');
// ==================== //

$alltopics = $DB->select("SELECT * FROM `mw_faq` ORDER BY `id`");
$cc1 = 0;

?>