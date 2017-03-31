<?php
error_reporting(E_ALL);
ini_set('log_errors', TRUE);
ini_set('html_errors', FALSE);
ini_set('display_errors', TRUE);

// check if MWE is already up to date, if so then do not proceed
include("../config/config-protected.php");
include("../core/core.php");
include("../core/class.database.php");
include("../core/class.update.php");
$DB = new Database(
	$dbconf['db_host'], 
	$dbconf['db_port'], 
	$dbconf['db_username'], 
	$dbconf['db_password'], 
	$dbconf['db_name']
	);

$Core = New Core(array());
$Update = New Update($Core);

// Check if the MaNGOS Web DB is up to date, if so we stop the script
if($DB->selectRow("SHOW DATABASES LIKE '" . $dbconf['db_name'] . "'"))
{
	if($DB->count("SHOW TABLES LIKE 'mw_db_version'") > 0)
	{
		$db_act_ver = $DB->selectCell("SELECT `dbver` FROM `mw_db_version` ORDER BY `dbdate` DESC LIMIT 0,1");
		if($db_act_ver == $Core->db_version)
		{
			die("Your MaNGOS Web install is up to date.  Please delete the <b>update/</b> directory from your webserver to continue.
			<br /><br /><a href=\"../index.php\">Click Here</a> To go to your MaNGOS Web home page.</a>");
		}
	}
}

$Update->check_for_updates();

$sql_file = "https://raw.githubusercontent.com/paintballrefjosh/MaNGOSWebV4/master/update/scripts/update_" . $Update->next_db_version . ".sql";
$php_file = "https://raw.githubusercontent.com/paintballrefjosh/MaNGOSWebV4/master/update/scripts/update_" . $Update->next_db_version . ".php";
$sql_headers = @get_headers($sql_file);
$php_headers = @get_headers($php_file);

//die($db_act_ver . "---".$Core->db_version."---".$Update->next_db_version);
if(file_exists("scripts/update_" . $Update->next_db_version . ".php"))
{
	// check to see if there is a local PHP script to handle the SQL update
	include("scripts/update_" . $Update->next_db_version . ".php");
}
/*elseif(stripos($php_headers[0], "200 OK") >= 0) // disabling this feature due to default php settings not allowing remote files to be included
{
	// check for online copy if no local copy exists of the PHP script
	include($php_file);
}*/
else
{
	// no script required for this DB update, proceed
	if(file_exists("scripts/update_" . $Update->next_db_version . ".sql"))
	{
		// check to see if there is a local SQL script and run
		$DB->runSQL("scripts/update_" . $Update->next_db_version . ".sql");
?>

		Database successfully updated using file: "scripts/update_<?= $Update->next_db_version; ?>.sql !!<br /><br />
		<a href="index.php">Go back</a> to check for additional updates.<br />
	
<?php

	}
/*	elseif(stripos($sql_headers[0], "200 OK") >= 0)
	{
		// check for online copy if no local copy exists of the SQL script
		$DB->runSQL($sql_file);
?>

		Database successfully updated using file: <?= $sql_file; ?> !!<br /><br />
		<a href="index.php">Go back</a> to check for additional updates.<br />
	
<?php

	}*/
	else
	{
		die("SQL update file not found!<br /><br />Current DB Version: $db_act_ver <br />Expected DB Version: $Core->db_version <br />Next DB Version: $Update->next_db_version");
	}
}
