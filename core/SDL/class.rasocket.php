<?php
/****************************************************************************/
/*  					< MangosWeb Enhanced SDL > 							*/
/*              Copyright (C) <2009 - 2011>  <Wilson212>                    */
/*						  < http://keyswow.com >							*/
/*																			*/
/****************************************************************************/
/*																			*/
/*  Character Class for MangosWeb v3. Some functions used from TrinMangSDK 	*/
/*				   http://code.google.com/p/trinmangsdk/					*/
/****************************************************************************/

class RA
{
	private $handle;
    private $errorstr, $errorno;
    private $auth;
    public $com;
	
	var $logFile = 'core/logs/ra.log';
	var $debugLogFile = 'core/logs/RA_Debug.log';
	var $debugLog = array();
	var $consoleReturn = array();
	var $authReturn = '';

//	************************************************************
    /**
      Class constructer.
    */
    public function __construct()
    {
		global $Config;
        $this->handle = FALSE;
		if($Config->get('enable_debugging') == 1)
		{
			$this->debug = TRUE;
		}
		else
		{
			$this->debug = FALSE;
		}
    }

//	************************************************************
    /**
      Class destructor. Closes the connection.
      Called with unset($parent).
    */
    public function __destruct()
    {
        if($this->handle)
        {
            fclose($this->handle);
            $this->auth = FALSE;
        }
    }

//	************************************************************
    /**
      Once connected to the server, this allows you to login
      Returns TRUE if it was successful.
      Returns FALSE if it was unable to authenticate.
    */
    public function auth($user, $pass)
    {
		global $Config;
		
        $user = strtoupper($user);
        fwrite($this->handle, $user."\n");
        usleep(100);
        fwrite($this->handle, $pass."\n");
        usleep(300);
		
		$return = trim(fgets($this->handle));
		
		// Check for error logging
		if($this->debug == TRUE)
		{
			$this->debugLog[] = 'Loging in with account: '.$user;
			$this->debugLog[] = 'Authorization return: '.$return;
		}

		if($Config->get('emulator') == 'mangos')
		{
			if(strpos($return, "+") === FALSE)
			{
				$this->authReturn = $return;
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Authorization Failed.';
					$this->writeDebugLog();
				}
				return FALSE;
			}
			else
			{
				// Check for error logging
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Authorization Success!';
				}
				$this->auth = TRUE;
				return TRUE;
			}
		}
		else
		{
			if(strpos($return, "failed") != FALSE)
			{
				$this->authReturn = $return;
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Authorization Failed.';
					$this->writeDebugLog();
				}
				return FALSE;
			}
			else
			{
				// Check for error logging
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Authorization Success!';
				}
				$this->auth = TRUE;
				return TRUE;
			}
		}
    }

//	************************************************************
    /**
      Attempts to connect to console. Returns false if it was unable to connect.
      Returns true if it is successfully connected.
      @param $host the IP or the DNS name of the server
      @param $port the port on which try to connect (default 3443)
    */
    public function connect($host, $port = 3443)
    {
        if($this->handle)
		{
			fclose($this->handle);
		}
        $this->handle = @fsockopen($host, $port, $errno, $errstr, 3);
        if(!$this->handle)
		{
			// Check for error logging
			if($this->debug == TRUE)
			{
				$this->debugLog[] = 'Connection to '.$host.' @ '.$port.' Failed!';
				$this->writeDebugLog();
			}
			return FALSE;
		}
        else 
		{
			// get the message of the day
			$motd = fgets($this->handle);
			
			// Check for error logging
			if($this->debug == TRUE)
			{
				$this->debugLog[] = 'Connection to '.$host.' @ '.$port.' success!';
			}
            return TRUE;
        }
    }
	
//	************************************************************	
// Writes into the log file, a message

	private function writeLog($msg)
	{
		$outmsg = date('Y-m-d H:i:s')." : ".$msg."\n";
		
		$file = fopen($this->logFile,'a');
		fwrite($file, $outmsg);
		fclose($file);
	}
	
//	************************************************************	
// Writes into the debug log file, all the debugging messages

	private function writeDebugLog()
	{
		$date = date('Y-m-d H:i:s');
		$outmsg = array();
		$outmsg[] = "******************************************************************";
		$outmsg[] = "Ra Debugging Log for date: ".$date."\n";
		
		foreach($this->debugLog as $log)
		{
			$outmsg[] = $log;
		}
		
		$outmsg[] = "****************************************************************** \n";
		$file = fopen($this->debugLogFile,'a');
		foreach($outmsg as $msg)
		{
			fwrite($file, " ".$msg."\n");
		}
		fclose($file);
	}

//	************************************************************	
	 /**
      Inputs a command into an active connection to MaNGOS/Trinity
      Adds the output of the console into ralog.
      Returns 0 if it's not connected
      Returns 1 if it the command was sent successfully
      Returns 2 if it's not authenticated
      @param $command the command to enter on console
    */
    public function executeCommand($type, $shost, $remote, $command)
    {
		global $Config;
		if($type == 0)
		{
			if(!$this->connect($shost, $remote[1]))
			{
				return 0;
			}
			
			if(!$this->auth($remote[2], $remote[3]))
			{
				return 2;
			}
			
			if(is_array($command))
			{
				foreach($command as $cmd)
				{
					// Check for error logging
					if($this->debug == TRUE)
					{
						$this->debugLog[] = 'Got Command: '.$cmd;					
					}
					
					fwrite($this->handle, $cmd."\n");
					sleep(1);
					$return = fgets($this->handle, 5000);
					$this->consoleReturn[] = $return;
					
					// Check for error logging
					if($this->debug == TRUE)
					{
						$this->debugLog[] = 'Server Response: '.$return;					
					}
				}
			}
			else
			{
				// Check for error logging
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Got Command: '.$cmd;					
				}
					
				fwrite($this->handle, $command."\n");
				$return = fgets($this->handle, 5000);
				$this->consoleReturn[] = $return;
				
				// Check for error logging
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Server Response: '.$return;					
				}
			}
			// Check for error logging
			if($this->debug == TRUE)
			{
				$this->writeDebugLog();
			}
			return 1;
		}
		else # type is SOAP
		{
			$client = $this->soapHandle($shost, $remote);
			// If multiple commands
			if(is_array($command))
			{
				foreach($command as $cmd)
				{
					// Check for error logging
					if($this->debug == TRUE)
					{
						$this->debugLog[] = 'Got Command: '.$cmd;					
					}
					
					try
					{
						$result = $client->executeCommand(new SoapParam($cmd, "command"));
						$this->consoleReturn[] = $result;
					}
					catch(Exception $e)
					{
						$return = $e->getMessage();
						$this->consoleReturn[] = $return;
						
						// Check for error logging
						if($this->debug == TRUE)
						{
							$this->debugLog[] = 'Server Error Response: '.$return;					
						}
					}
				}
			}
			else # A single Command
			{
				// Check for error logging
				if($this->debug == TRUE)
				{
					$this->debugLog[] = 'Got Command: '.$cmd;					
				}
				
				try
				{		
					$result = $client->executeCommand(new SoapParam($command, "command"));
					$this->consoleReturn[] = $result;
				}
				catch(Exception $e)
				{
					$return = $e->getMessage();
					$this->consoleReturn[] = $return;
					
					// Check for error logging
					if($this->debug == TRUE)
					{
						$this->debugLog[] = 'Server Error Response: '.$return;					
					}
				}
			}
			// Check for error logging
			if($this->debug == TRUE)
			{
				$this->writeDebugLog();
			}
			return 1;
		}
    }

//	************************************************************
// Setups the Soap Handle	
	private function soapHandle($shost, $remote)
	{
		global $Config;
		if($Config->get('emulator') == 'mangos')
		{
			$client = new SoapClient(NULL,
			array(
			"location" => "http://".$shost.":".$remote[1]."/",
			"uri" => "urn:MaNGOS",
			"style" => SOAP_RPC,
			"login" => $remote[2],
			"password" => $remote[3]
			));
		}
		else
		{
			$client = new SoapClient(NULL,
			array(
			"location" => "http://".$shost.":".$remote[1]."/",
			"uri" => "urn:TC",
			"style" => SOAP_RPC,
			"login" => $remote[2],
			"password" => $remote[3]
			));
		}
		return $client;
	}

//	************************************************************	
	/*
		Main sending function for the site
		This function gets the RA info for the realm.
		and executes the command.
		send( Command, realm ID )
		returns 1 if unable to connect
		return 2 if unauthorized
		returns console return upon success
	*/
	function send($command, $realm)
	{
		global $user, $Config, $DB;
		
		// Get the remote access information from the realm database
		$get_remote = $DB->selectRow("SELECT * FROM `realmlist` WHERE id='".$realm."'");
		$remote = explode(';', $get_remote['ra_info']);
		$shost = $get_remote['address'];
		
		// Make sure the remote access type is either 1 or 0
		if($remote[0] == 0 || $remote[0] == 1)
		{
			$result = $this->executeCommand($remote[0], $shost, $remote, $command);
			if($result != 1)
			{
				if($result == 0)
				{
					return 1;
				}
				elseif($result == 2)
				{
					return 2;
				}
			}
			else
			{
				return $this->consoleReturn;
			}
		}
	}
}
?>