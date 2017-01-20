<?php
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