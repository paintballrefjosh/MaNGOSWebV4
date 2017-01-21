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

include('core/SDL/class.lib.php');
$Lib = new Lib;

$get_db_date = $DB->selectCell("SELECT `dbdate`	FROM `mw_db_version`");
$db_date = date("Y-m-d, g:i a", $get_db_date);
?>