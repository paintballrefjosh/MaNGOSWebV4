<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/****************************************************************************/

//  This PHP file is the script to update your MWE database to version 4.0.5
//  It will be executed from the web interface.

// First check to see if the database is already at version 4.0.5 but the mw_db_version simply wasn't added.

$row = $DB->selectRow("SHOW FIELDS FROM mw_gallery");

if(substr($row['Type'], 0, 3) === "int")
{
    // database was updated, but mw_db_version was not
    $DB->query("INSERT INTO `mw_db_version` VALUES ('4.0.5', UNIX_TIMESTAMP(), 2)");
}
else
{
    $DB->query("ALTER TABLE `mw_gallery` ADD COLUMN `date_2` INT(11) unsigned NOT NULL");
    $DB->query("UPDATE `mw_gallery` SET `date_2` = UNIX_TIMESTAMP(`date`)");
    $DB->query("ALTER TABLE `mw_gallery` DROP COLUMN `date`");
    $DB->query("ALTER TABLE `mw_gallery` CHANGE `date_2` `date` INT(11) unsigned NOT NULL");
    $DB->query("INSERT INTO `mw_db_version` VALUES ('4.0.5', UNIX_TIMESTAMP(), '2')");
}

?>

Database successfully updated!!<br /><br />
<a href="index.php">Go back</a> to check for additional updates.<br />