<?php
/****************************************************************************/
/*  					< MangosWeb Enhanced v3 >  							*/
/*              Copyright (C) <2009 - 2011>  <Wilson212>                    */
/*						  < http://keyswow.com >							*/
/*																			*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/
/*																			*/
/*  Update class for MangosWeb Enhanced. You the user are NOT allowed to	*/ 
/*	copy any of this code, and/or use it for any purpose other than to 		*/
/*	update MangosWeb Enhanced.        										*/
/****************************************************************************/

class Update
{
	var $current_version;
	var $server_version;
	var $update_version;
	var $updated_files_list = array();
	var $update_delete = array();
	var $update_make_dir = array();
	var $update_remove_dir = array();
	var $writable_files;
	var $charlen_file;
	var $updates;
	
	function Update()
	{
		global $Core;
		$this->server_address = 'http://update.keyswow.com/mangoswebv3/';
		$this->current_version = $Core->version;
		$this->handle = FALSE;
	}
	
//	************************************************************	
// Standard check to see if the server is online function

	function connect()
	{
		$this->handle = @fsockopen('www.keyswow.com', 80, $errno, $errstr, 5);
		if($this->handle)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

//	************************************************************		
// This function should always be used FIRST! checks to  see if server is online, 
// and if there's updates

	function check_for_updates() 
	{
		$connection = $this->connect();
		if($connection == TRUE)
		{
			$this->updates = file_get_contents("". $this->server_address ."updates.txt");
			$ups = explode(",", $this->updates );
			$this->newest = $ups['0'];
			if($this->current_version != $this->newest)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 0;
		}
	}

//	************************************************************		
// If there is updates, then this function returns the next update version number.

	function get_next_update()
	{
		$ups = explode(",", $this->updates );
		
		// Ok, so we need the next update, but first we need to find, where in the array is out current version
		foreach($ups as $key => $value)
		{
			if($value == $this->current_version)
			{
				$tmp_version = $key;
				// Now that we have our postion, we subtract 1, to get the next update version
				$newkey = $tmp_version - 1;
			}
		}
		$this->update_version = $ups[$newkey];
		$this->get_server_variables();
		return $this->update_version;
	}

//	************************************************************	
// This function get the list of all update variables such as
// make dir, remove file, update file etc etc.

	function get_server_variables() 
	{
		$variables_file_address = $this->server_address."update_". (string)$this->update_version ."/update_vars.php";
		$file = file($variables_file_address);
		foreach ($file as $line) 
		{
			if(strstr($line,"[update_version]") !== false)
			{
				$this->server_version = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[update_info]") !== false)
			{
				$this->update_info[] = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[update_make_dir]") !== false)
			{
				$this->update_make_dir[] = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[update_remove_dir]") !== false)
			{
				$this->update_remove_dir[] = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[update_delete]") !== false)
			{
				$this->update_delete[] = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[update_file_list]") !== false)
			{
				$this->updated_files_list[] = trim(substr($line,strpos($line,"=")+1));
			}
			elseif(strstr($line,"[charlen_file]") !== false)
			{
				$this->charlen_file[] = trim(substr($line,strpos($line,"=")+1));
			}
		}
	}

//	************************************************************	
// Prints updated file list

	function print_updated_files_list() 
	{
		$filelist = "";
		foreach ($this->updated_files_list as $filename) 
		{
			$filelist .= $filename."<br />";
		}
		return $filelist;
	}
	
//	************************************************************	
// Prints Delete File list

	function print_delete_files_list() 
	{
		$filelist = "";
		if(count($this->update_delete) > 0)
		{
			foreach($this->update_delete as $filename) 
			{
				$filelist .= $filename."<br />";
			}
		}
		else
		{
			echo "None";
		}
		return $filelist;
	}

//	************************************************************
// Prints the Update information info
	
	function print_update_info()
		{
		$infolist = "";
		foreach ($this->update_info as $desc) 
		{
			$infolist .= $desc."<br />";
		}
		return $infolist;
	}

//	************************************************************	
// This function checks to see if a file is writable

	private function is__writable($path) 
	{
		//Make sure to use a "/" after trailing folders
	    if ($path{strlen($path)-1} == '/') // recursively return a temporary file path
		{
	        return is__writable($path.uniqid(mt_rand()).'.tmp');
		}
	    else if (is_dir($path))
		{
	        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
		}
	    // check tmp file for read/write capabilities
	    $rm = file_exists($path);
	    $f = @fopen($path, 'a');
	    if ($f == false)
		{
	        return FALSE;
		}
	    fclose($f);
	    if (!$rm)
		{
	        unlink($path);
		}
	    return TRUE;
	}

//	************************************************************		
// Checks if the all the files in the update are writable

	function check_if_are_writable() 
	{
		$err = 0;
		foreach ($this->updated_files_list as $filename) 
		{
			if($this->is__writable($filename) == TRUE) 
			{
				$this->writable_files[$filename] = "yes";
			} 
			else 
			{
				$this->writable_files[$filename] = "no";
				$err++;
			}
		}
		if($err == 0)
		{
			$return = TRUE;
		}
		else
		{
			$return = FALSE;
		}
		return $return;
	}

//	************************************************************	
// Gets the total character length of all updated files
// Can be used for like a progress bar

	function get_total_charlen() 
	{
		$total_len = 0;
		foreach($this->charlen_file as $len) 
		{
			$total_len += $len;
		}
		return $total_len;
	}
	
//	************************************************************	
// Makes all the directories from the update list

	function makeDirs() 
	{
		$mkerr = 0;
		$count = count($this->update_make_dir);
		if($count > 0)
		{
			foreach($this->update_make_dir as $mkdir) 
			{
				// First check to see if the directory already exists
				$check = @opendir($mkdir);
				if($check)
				{
					@closedir($check);
				}
				else
				{
					// We need to make the directory
					$make = @mkdir($mkdir, 0775);
					if(!$make)
					{
						$mkerr++;
					}
				}
			}
			if($mkerr == 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}
	}
	
//	************************************************************	
// Removes all the directories from the update list

	function removeDirs() 
	{
		$rmerr = 0;
		$count = count($this->update_remove_dir);
		if($count > 0)
		{
			foreach($this->update_remove_dir as $remove) 
			{
				// First check to see if the directory already exists
				$check = @opendir($remove);
				if($check)
				{
					@closedir($check);
				}
				else
				{
					return FALSE;
				}

				// We need to revmove the directory
				$rm = @rmdir($remove);
				if(!$rm)
				{
					$rmerr++;
				}
			}
			if($rmerr == 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}
	}

//	************************************************************		
// Main update function

	function update_files()
	{
		$err = "";

		// Delete files			
		if(count($this->update_delete) > 0)
		{
			foreach($this->update_delete as $unlinkf)
			{
				$unlink = @unlink($unlinkf);
				if(!$unlink)
				{
					echo $filename." <font color='red'>Problem Removing File!</font><br />";
				}
				else
				{
					echo $filename." <font color='green'>Removed Successfully!</font><br />";
				}
			}
		}
			
		if($this->check_if_are_writable() == TRUE) 
		{
			$i = 0;
			$len_till_now = 0;
			
			// Update Files Loop
			foreach($this->updated_files_list as $filename) 
			{
				// Start by replacing .php to .upd, and using file_get_contents
				$updated_file_url = $this->server_address."/update_".$this->update_version."/".str_replace(".php",".upd",$filename);
				$updated_file_contents = file_get_contents($updated_file_url);

				// As long as the file isnt empty, lets use fopen, and fwrite to put the contents in the file.
				if($updated_file_contents != "") 
				{
					$file = fopen($filename,"w");
					fwrite($file, $updated_file_contents);
					fclose($file);
				}
				
				// next 2 lines can be used for a future progress bar. Calculates the total
				// character length of all update files, and turns that into a percentage
				$len_till_now += $this->charlen_file[$i];
				$perc = $len_till_now * 100 / $this->get_total_charlen();
				
				echo $filename." <font color='green'>Updated Successfully!</font><br />";
				ob_flush();
				flush();
				$i++;
			}
			
			// These next few lines are for the server to get statistics. The update server will log your servers
			// Address so we can get a good count on how many users are using mangosweb, and how many are updating
			$open_add = $this->server_address ."index.php?server=".$_SERVER['HTTP_HOST']."&update=".$this->update_version;
			$calc = @fopen($open_add, 'r');
			if($calc)
			{
				@fclose($calc);
			}
			return TRUE;
		} 
		else 
		{
			$err .= "<font color='red'>An error occured while updating. Some files where not writable by the server!</font>";
			foreach ($this->writable_files as $id => $value) 
			{
				if($value == "no") 
				{
					echo $id." file is <font color='red'><i>not writable!</i></font><br>";
				}
			}
			$err .= "<font color='red'>No file(s) were updated.<br></font>";
			return $err;
		}
	}
}
?>