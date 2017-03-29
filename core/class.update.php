<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

class Update
{
	private $local_version;
	public $latest_version;
	public $next_db_version;
	private $server_address;
	private $update_list;
	
	function __construct(Core $Core)
	{
		$this->server_address = 'https://raw.githubusercontent.com/paintballrefjosh/MaNGOSWebV4/master/';
		$this->local_version = $Core->version;
		$this->handle = FALSE;
	}
	
//	************************************************************	
// Standard check to see if the server is online function

	function connect()
	{
		$this->handle = @fsockopen('raw.githubusercontent.com', 443, $errno, $errstr, 5);
		if(is_resource($this->handle))
		{
			fclose($this->handle);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

//	************************************************************		
// This function should always be used FIRST! checks to see if server is online, 
// and if there's updates

	function check_for_updates() 
	{
		$connection = $this->connect();
		if($connection)
		{
			//$this->server_version = file_get_contents($this->server_address . "core/core.php");
			//preg_match('/\$version = \'(.*)\';/i', $this->server_version, $ups);

			// update file should be in the following format:
			// code_ver,db_ver
			if(file_exists("update_list.txt"))
			{
				// check if local list file exists, this is only used when the update/ directory exists
				$this->update_list = file("update_list.txt");
			}
			else
			{
				// check if GitHub list file exists
				$this->update_list = file("https://raw.githubusercontent.com/paintballrefjosh/MaNGOSWebV4/master/update/update_list.txt");
			}

			$this->latest_version = preg_replace("~[\r\n]+~", "", explode(",", $this->update_list[0])[0]);
			$this->get_next_db_update();

			if((string)$this->local_version != (string)$this->latest_version)
			{
				// there is an update available
				return 1;
			}
			else
			{
				// no updates are available
				return 2;
			}
		}
		else
		{
			// could not connect to update server
			return 0;
		}
	}

//	************************************************************		
// If there is updates, then this function returns the next update version number.

	function get_next_db_update()
	{
		global $DB;

		$newkey = -1;
		$db_act_ver = $DB->selectCell("SELECT `dbver` FROM `mw_db_version` ORDER BY `dbdate` DESC LIMIT 0,1");

		// update_list.txt lists the updates in descending order (latest, or greatest, code version first)
		foreach($this->update_list as $key => $value)
		{
			if(preg_replace("~[\r\n]+~", "", explode(",", $value)[1]) == $db_act_ver)
			{
				// Now that we have our postion, we subtract 1, to get the next update version
				$newkey = $key - 1;
				break;
			}
		}

		if($newkey == -1)
		{
			return null;
		}
		else
		{
			$this->next_db_version = preg_replace("~[\r\n]+~", "", explode(",", $this->update_list[$newkey])[1]);
			return $this->next_db_version;
		}
	}
}
?>