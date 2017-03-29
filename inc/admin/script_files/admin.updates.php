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

include('core/class.update.php');
$Update = new Update($Core);
$Check = $Update->check_for_updates();

// Here we check for updates, and get the list of files for that update.
function checkCoreUpdates() 
{
	global $Update, $Core, $Check;

	if($Check == 1)
	{
?>
		<b>There are updates available!</b><br /><br />
		<b>Local Version: </b><?= $Core->version; ?><br /><br />
		<b>Latest Version: </b><?= $Update->latest_version; ?><br />
		<ul>
			<li>Download this version on <a target="_blank" href="https://github.com/paintballrefjosh/MaNGOSWebV4/releases/tag/<?= $Update->latest_version; ?>">GitHub</a>!</li>
		</ul>
<?php
	}
	elseif($Check == 2)
	{
?>
		There are no core updates. Your version <font color="green" weight="bold"><?= $Core->version; ?></font> is up to date.
<?php
	}
	else
	{
?>
		<div class='warning'>Cant Connect to update server. The server may be too busy, Try and refresh your page. If the problem persists,
		please check <a href='https://github.com/paintballrefjosh/MaNGOSWebV4/'>here</a> for any news related to this error.</div>
<?php
	}
}

function checkDatabaseUpdates()
{
	global $DB, $Core;
	$db_act_ver = $DB->selectCell("SELECT `dbver` FROM `mw_db_version` ORDER BY `dbdate` DESC LIMIT 0,1");

	if((string)$db_act_ver != (string)$Core->db_version) 
	{ 
?>
		There is a database update required!<br /><br />
		Local Version: <font color="red"><b><?= $db_act_ver; ?></b></font><br /><br />
		Expected Version: <b><?= $Core->db_version; ?></b><br /><br />
		<a href="?p=admin&amp;sub=updates&amp;update=db"><center><button><span>Update Database</span></button></center></a>
		<br /><br />
<?php
	}
	else
	{
?>
		There are no database updates. Your version <font color="green" weight="bold"><?= $Core->db_version; ?></font> is up to date.
<?php
	}
}

// This function runs the update sql on the DB
function updateDatabase()
{
	global $Core, $DB, $Update;

	$update_file = "https://raw.githubusercontent.com/paintballrefjosh/MaNGOSWebV4/master/update/scripts/update_" . $Update->next_db_version . ".sql";
	$update_file_headers = @get_headers($update_file);
	
	if(stripos($update_file_headers[0], "200 OK") >= 0)
	{
		// check for online copy if no local copy exists of the SQL script
		$DB->runSQL($update_file);
		output_message("success", "Database Successfully Updated");
		redirect("?p=admin&amp;sub=updates");
	}
	else
	{
		output_message("error" , "SQL update file not found!");
	}
}
?>