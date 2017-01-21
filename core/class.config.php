<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

class Config 
{
	
	var $data = array();
	var $configFile = 'config/config.php';	//Default Config File
	var $path_protectedconf = "config/config-protected.php";
	
	function __construct()
	{
		$this->Load();
	}
	
//	************************************************************
//	Loads the config files.

	function Load() 
	{
		if(file_exists($this->configFile )) 
		{
			include($this->configFile);
			$vars = get_defined_vars();
			foreach($vars as $key => $val) 
			{
				if ($key != 'this' && $key != 'data') 
				{
					$this->data[$key] = $val;
				}
			}
			return TRUE;
		} 
		else 
		{
			return FALSE;
		}
	}
	
//	************************************************************
// Returns the config variable requested

	function get($key) 
	{
		if(isset($this->data[$key])) 
		{
			return $this->data[$key];
		}
	}
	
//	************************************************************
// Returns the requested DB key from the DB config file

	function getDbInfo($key) 
	{
		include($this->path_protectedconf);
		return $db[$key];
	}
	
//	************************************************************
// Sets a variable

	function set($key, $val) 
	{
		$this->data[$key] = $val;
	}

//	************************************************************
// Saves all set config variables to the config file, and makes a backup of the current config file

	function Save() 
	{
		$cfg  = "<?php\n";
		$cfg .= "/*********************************************\n";
		$cfg .= "*  MangosWeb Enhanced Auto Generated Config  *\n";
		$cfg .= "**********************************************\n";
		$cfg .= "* Generated from the MangosWeb Config Class  *\n";
		$cfg .= "* Use the Admin Panel to set Config Values   *\n";
		$cfg .= "**********************************************/\n";
		$cfg .= "\n";
		foreach($this->data as $key => $val) 
		{
			// If the value is numeric, dont add quotes
			if (is_numeric($val)) 
			{
				$cfg .= "\$$key = " . $val . ";\n";
			} 
			else # ins't numeric
			{
				$cfg .= "\$$key = '" . addslashes( $val ) . "';\n";
			}
		}
		$cfg .= "?>";
		
		// Copy the current config file, and make a new config file for backup.
		// Put the current config contents in the backup config file
		@copy( $this->configFile, $this->configFile.'.bak' );
		
		if (@file_put_contents( $this->configFile, $cfg )) 
		{
			return TRUE;
		} 
		else 
		{
			return FALSE;
		}
	}
}
?>
