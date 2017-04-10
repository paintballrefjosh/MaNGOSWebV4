<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

class Account
{
	var $DB, $RDB;
    var $user = array(
		'id'    => -1,
		'username'  => 'Guest',
		'account_level' => 1,
		'theme' => 0
    );

//	************************************************************	
// Initialize with checking for user cookies, and getting their IP

    function __construct()
    {
        global $mwe_config, $DB, $RDB;
        $this->DB = $DB;
		$this->RDB = $RDB;
        $this->check();
        $this->user['ip'] = $_SERVER['REMOTE_ADDR'];
		
		// If the admin has the onlinelist module enabled
		if($mwe_config['module_online_list'] == 1)
		{
			if($this->user['id'] < 1)
			{
				$this->onlinelist_addguest();
			}
			else 
			{
				$this->onlinelist_add();
			}
			$this->onlinelist_update();
		}
		
		// Update the users last visit
        $this->lastvisit_update($this->user);
    }

//	************************************************************	
// Checks if user is logged in already by reading the cookie

    function check()
    {
        global $mwe_config;
		
		// Check if a cookie is set
        if(isset($_COOKIE[((string)$mwe_config['site_cookie'])]))
		{
            list($cookie['user_id'], $cookie['account_key']) = @unserialize(stripslashes($_COOKIE[((string)$mwe_config['site_cookie'])]));
            if($cookie['user_id'] < 1)
			{
				return false;
			}
			
			// Get the user info from the DB
            $res = $this->RDB->selectRow("
                SELECT * FROM account
                WHERE id ='".$cookie['user_id']."'");
//	                LEFT JOIN mw_account_extend ON account.id = mw_account_extend.account_id
  //              LEFT JOIN mw_account_groups ON mw_account_extend.account_level = mw_account_groups.account_level
  			$res_extend = $this->DB->selectRow("SELECT * FROM mw_account_extend WHERE account_id = '".$cookie['user_id']."'");
			$res_group = $this->DB->selectRow("SELECT title FROM mw_account_groups WHERE account_level = '".$res_extend['account_level']."'");

			$res = array_merge($res, $res_extend, $res_group);

			// Check to see if account is banned
            if($this->isBannedAccount($res['id']) == TRUE)
			{
                $this->setgroup();
                $this->logout();
                return false;
            }
			
			// Make sure the activation code is NULL in the DB
            if($res['locked'] == 1)
			{
                $this->setgroup();
                return false;
            }
			
			// Match the cookie account key with the DB account key
            if($this->matchAccountKey($cookie['user_id'], $cookie['account_key']))
			{
                unset($res['sha_pass_hash']);
                $this->user = $res;
                return true;
            }
			else
			{
				// If ther return is false on the account key matching, then
				// we must logout to delete the key, and set group to guest
				$this->logout($cookie['user_id']);
                $this->setgroup();
                return false;
            }
        }
		else # Cookie is not set
		{
            $this->setgroup();
            return false;
        }
    }

/*	************************************************************
* Main login script. 
* @$params = array('username' => username, 'sha_pass_hash' => encrypted password
* returns 0 if the username doesnt exist
* returns 1 on success
* returns 2 if some params are empty
* returns 3 if the password is wrong
* returns 4 if the account is banned
* returns 5 if the account is not activated
// **************************************************************/

    function login($params)
    {
        global $mwe_config;
        $success = 1;
		
		// If the params are emtpy, return 2
        if(empty($params)) 
		{
			return 2;
		}
		
		// if the username is empty, return 2
        if(empty($params['username']))
		{
            return 2;
            $success = 0;
        }
		
		// If the sha_pass_hash is empty, return 2
        if(empty($params['sha_pass_hash']))
		{
            return 2;
            $success = 0;
        }
		
		// Load the users info from the DB
        $res = $this->RDB->selectRow("SELECT * FROM `account` WHERE `username`='".$params['username']."'");
			
		// If the result was false, then username is no good, return 0.
        if($res == FALSE)
		{
			$success = 0;
			return 0;
		}
		else
		{
			$res2 = $this->DB->selectRow("SELECT * FROM `mw_account_extend` WHERE `account_id`='".$res['id']."'");
		}
		
		// Check to see if the account is banned, if so return 4
        if($this->isBannedAccount($res['id']) == TRUE)
		{
            $success = 0;
			return 4;
        }
		
		// If the account is locked or "inactive" then return 5, do not allow login
        if($res['locked'] == 1)
		{
            $success = 0;
			return 5;
        }
		
		// If any of the above checks returnes $success = 0; then login fails
        if($success != 1) 
		{
			return FALSE;
		}
		else
		{
			// Lets check to see if the posted password matches the DB password
			if(strtoupper($res['sha_pass_hash']) == strtoupper($params['sha_pass_hash']))
			{
				$this->user['id'] = $res['id'];
				$this->user['name'] = $res['username'];
				
				// generate an account key, and set the account key in the DB for login cookie checks
				$generated_key = $this->generate_key();
				$this->addOrUpdateAccountKeys($res['id'],$generated_key);
				$uservars_hash = serialize(array($res['id'], $generated_key));
				
				// Prepare for cookie setting
				$cookie_expire_time = intval($mwe_config['account_key_retain_length']);
				if(!$cookie_expire_time) 
				{
					$cookie_expire_time = (60*60*24*365);   //default is 1 year
				}
				(string)$cookie_name = $mwe_config['site_cookie'];
				(string)$cookie_href = $mwe_config['site_href'];
				(int)$cookie_delay = (time() + $cookie_expire_time);
				
				// Set cookie and return 1
				setcookie($cookie_name, $uservars_hash, $cookie_delay, $cookie_href);
				return 1;
			}
			else # Passwords didnt match in the DB, return 3
			{
				return 3;
			}
		}
    }

//	************************************************************
// Main logout function, Sets an expired cookie over the current
// cookie and removes the DB account key

    function logout()
    {
        global $mwe_config;
        setcookie((string)$mwe_config['site_cookie'], '', time()-3600,(string)$mwe_config['site_href']);
        $this->removeAccountKeyForUser($this->user['id']);
    }
	
/*	************************************************************
* Main register script
* @$params = array('username' => 'username', 'sha_pass_hash' => 'encrypted_pass', 'sha_pass_hash2' => 'encrypted_pass2', 
*		'email' => 'email', 'expansion' => 'expansion', 'password' => 'clean password');
* @$account_extend = array('secretq1' => '', 'secreta1' => '', 'secretq2' => '', 'secreta2 => '');
* returns 0 if the params are emtpy
* returns 1 on success
* returns 2 if the username is empty
* returns 3 if the passwords didnt match or are empty
* returns 4 if the email is empty
* returns 5 if the IP is banned
* returns 6 upon fatal error
// **************************************************************/

    function register($params, $account_extend = NULL)
    {
        global $mwe_config;
        $success = 1;
		
		// Check to see if the params is empty, if so return 0
        if(empty($params)) 
		{
			return 0;
		}
		
		// If the param username is empty
        if(empty($params['username']))
		{
			return 2;
            $success = 0;
        }
		
		// If the password hash is emtpy, OR the 2 posted passwords dont match
        if(empty($params['sha_pass_hash']) || $params['sha_pass_hash'] != $params['sha_pass_hash2'])
		{
			return 3;
            $success = 0;
        }
		
		// Is email is empty
        if(empty($params['email']))
		{
			return 4;
            $success = 0;
        }
		
		// check to see if the users IP is banned
		if($this->isBannedIp($_SERVER['REMOTE_ADDR']) == TRUE)
		{
			return 5;
            $success = 0;
        }
		
		// If any of the above checks are flase, then reigster failed
        if($success != 1) 
		{
			return FALSE;
		}
        unset($params['sha_pass_hash2']);
        $password = $params['password'];
        unset($params['password']);
		
		// If email activation is set in the config
        if((int)$mwe_config['reg_require_activation'] == 1)
		{
			// Setup an activation key, Set locked to 1 so the user cant login, insert into DB
            $tmp_act_key = $this->generate_key();
            $params['locked'] = 1;
			$acc_id = $this->RDB->query("INSERT INTO account(
				`username`,
				`sha_pass_hash`,
				`email`,
				`locked`,
				`expansion`)
			   VALUES(
				'".$params['username']."',
				'".$params['sha_pass_hash']."',
				'".$params['email']."',
				'".$params['locked']."',
				'".$params['expansion']."')
			   ");
			   
			// If the insert into account query was successful
            if($acc_id == TRUE)
			{
				$u_id = $this->RDB->selectCell("SELECT `id` FROM `account` WHERE `username` LIKE '".$params['username']."'");
				
                // If we dont want to insert special stuff in account_extend...
                if ($account_extend == NULL)
				{
                    $this->DB->query("INSERT INTO mw_account_extend(
						`account_id`,
						`account_level`,
						`registration_ip`,
						`activation_code`)
					   VALUES(
						'".$u_id."',
						'2',
						'".$_SERVER['REMOTE_ADDR']."',
						'".$tmp_act_key."')
					");
                } 
                else # We do want to insert into account extend
				{
                    $this->DB->query("INSERT INTO mw_account_extend(
						`account_id`,
						`account_level`,
						`registration_ip`, 
						`activation_code`, 
						`secret_q1`, 
						`secret_a1`, 
						`secret_q2`, 
						`secret_a2`)
					   VALUES(
						'".$u_id."',
						'2',
						'".$_SERVER['REMOTE_ADDR']."',
						'".$tmp_act_key."',
						'".$account_extend['secretq1']."', 
						'".$account_extend['secreta1']."', 
						'".$account_extend['secretq2']."', 
						'".$account_extend['secreta2']."')
					");
                }
				
				// Send the activation email
                $act_link = (string)$mwe_config['site_base_href'] . $mwe_config['site_href'] . "?p=account&amp;sub=activate&amp;id=$u_id&amp;key=$tmp_act_key";
                $email_text  = $mwe_config['site_title'] . " Account activation<br /><br />";
                $email_text .= 'Username: '.$params['username']."<br />";
                $email_text .= 'Password: '.$password."<br />";
                $email_text .= 'This is your activation key: '.$tmp_act_key."<br />";
                $email_text .= 'CLICK HERE : '.$act_link."<br />";
                send_email($params['email'], $mwe_config['site_title'].' - Account Activation', $email_text, false);
                return 1;
            }
			
			// Insert into account table failed
			else
			{
                return 6;
            }
        }
		
		// Email activation disabled
		else
		{
			$acc_id = $this->RDB->query("INSERT INTO account(
				`username`,
				`sha_pass_hash`,
				`email`,
				`expansion`)
			   VALUES(
				'".$params['username']."',
				'".$params['sha_pass_hash']."',
				'".$params['email']."',
				'".$params['expansion']."')
			");
			
			// If insert into account table was successfull
            if($acc_id == TRUE)
			{
				$u_id = $this->RDB->selectCell("SELECT `id` FROM `account` WHERE `username` LIKE '".$params['username']."'");
                if ($account_extend == NULL)
				{
                    $this->DB->query("INSERT INTO mw_account_extend(
						`account_id`,
						`account_level`,
						`registration_ip`)
					   VALUES(
						'".$u_id."',
						'2',
						'".$_SERVER['REMOTE_ADDR']."'
					   )
					");
                }
				else
				{
                    $this->DB->query("INSERT INTO mw_account_extend(
						`account_id`,
						`account_level`,
						`registration_ip`, 
						`secret_q1`, 
						`secret_a1`, 
						`secret_q2`, 
						`secret_a2`)
					   VALUES(
						'".$u_id."',
						'2',
						'".$_SERVER['REMOTE_ADDR']."',
						'".$account_extend['secretq1']."', 
						'".$account_extend['secreta1']."', 
						'".$account_extend['secretq2']."', 
						'".$account_extend['secreta2']."')
					");
                }
                return 1;
            }
            else
			{
                return 6;
            }
        }
    }
	
/*************************************************************
* Last update set the current time under the account_extend database to get
* an approximate time when the user was last online.
* @userparams all $user params ($user)
**************************************************************/


	function lastvisit_update($uservars)
    {
        if($uservars['id'] > 0)
		{
            if(time() - $uservars['last_visit'] > 60*10)
			{
                $this->DB->query("UPDATE `mw_account_extend` SET last_visit='".time()."' WHERE account_id='".$uservars['id']."' LIMIT 1");
            }
        }
    }

//	************************************************************
// Get the account level information for a group level
// @$group_id = the account level
	
	function getgroup($group_id = FALSE)
	{
        $res = $this->DB->selectRow("SELECT * FROM `mw_account_groups` WHERE `account_level`='".$group_id."'");
        return $res;
    }

//	************************************************************
// Sets the group of the user
// @$gid = the account level
	
	function setgroup($gid = 1) // 1 = guest
    {
        $guest_g = $this->getgroup($gid);
        $this->user = array_merge($this->user, $guest_g);
    }

//	************************************************************	
// Converts the username:password into a SHA1 encryption

	function sha_password($user, $pass)
	{
		$user = strtoupper($user);
		$pass = strtoupper($pass);
		return SHA1($user.':'.$pass);
	}

	
//	************************************************************	
// Checks if the user is logged in. Returns FALSE if user is guest

	function isLoggedIn()
	{
		if($this->user['id'] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

//	************************************************************	
// Check if the username is available. Post the username here.
// returns returns TRUE if the name is available.

    function isAvailableUsername($username)
	{
        $res = $this->RDB->count("SELECT id FROM `account` WHERE `username`='".$username."'");
        if($res == 0) 
		{
			return TRUE; // username is available
		}
		else
		{
			return FALSE; // username is not available
		}
    }

//	************************************************************
// Check if the email is available. Post an email address here.
// returns returns TRUE if the email is available.

    function isAvailableEmail($email)
	{
        $res = $this->RDB->count("SELECT id FROM `account` WHERE `email`='".$email."'");
        if($res == 0) 
		{
			return TRUE; // email is available
		}
		else
		{
			return FALSE; // email is not available
		}
    }

//	************************************************************	
// Checks if the email is in valid format.
// returns returns TRUE if the email is a valid email

    function isValidEmail($email)
	{
        if(preg_match('#^.{1,}@.{2,}\..{2,}$#', $email) == 1)
		{
            return TRUE; // email is valid
        }
		else
		{
            return FALSE; // email is not valid
        }
    }

//	************************************************************	
// Checks if the register key is valid
// @$key is the Register key

    function isValidRegkey($key)
	{
        $res = $this->DB->selectCell("SELECT `id` FROM `mw_regkeys` WHERE `key`='".$key."'");
        if($res != FALSE) 
		{
			return TRUE; // key is valid
		}
        else
		{
			return FALSE; // key is not valid
		}
    }

//	************************************************************
// Checks is the account activation key is valid
// @$key is the activiation key

    function isValidActivationKey($key)
	{
        $res = $this->DB->selectCell("SELECT `account_id` FROM `mw_account_extend` WHERE `activation_code`='".$key."'");
        if($res != FALSE) 
		{
			return $res; // key is valid
		}
		else
		{
			return FALSE; // key is not valid
		}
    }

//	************************************************************
// Checks to see if the account is banned
// Returns TRUE is the account id is banned
// @$account_id is the account id

	function isBannedAccount($account_id)
	{
		$check = $this->RDB->count("SELECT id FROM `account_banned` WHERE `id`='".$account_id."' AND `active`=1");
		if ($check > 0)
		{
			return TRUE; // Account is banned
		}
		else
		{
			return FALSE; // Account is not banned
		}
	}

//	************************************************************
// Checks to see of an IP address is banned
// Returns TRUE if the IP is banned
	
	function isBannedIp()
	{
		$check = $this->RDB->count("SELECT ip FROM `ip_banned` WHERE `ip`='".$_SERVER['REMOTE_ADDR']."'");
		if ($check > 0)
		{
			return TRUE; // IP is banned
		}
		else
		{
			return FALSE; // IP is not banned
		}
	}
	
//	************************************************************
// For mangos and trinity. Used to determine if the account is locked or not
// Returns TRUE of the account is locked, else FALSE

	function isLockedAccount($id)
	{
		$check = $this->RDB->selectCell("SELECT `locked` FROM `account` WHERE `id`='".$id."'");
		if($check == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

//	************************************************************	
// Generate a unique key

    function generate_key()
    {
        $str = microtime(1);
        return sha1(base64_encode(pack("H*", md5(utf8_encode($str)))));
    }
	
//	************************************************************
// Generate multiple keys. Post amount of keys needed

    function generate_keys($n)
    {
        set_time_limit(600);
        for($i=1;$i<=$n;$i++)
        {
            if($i > 1000)
			{
				exit;
			}
            $keys[] = $this->generate_key();
            $slt = 15000;
            usleep($slt);
        }
        return $keys;
    }

//	************************************************************	
// Deletes a register key

    function delete_key($key)
	{
        $this->DB->query("DELETE FROM `mw_regkeys` WHERE `key`='".$key."'");
		return TRUE;
    }

//	************************************************************
// This function bans an account, 
// POST account id, reason, and banned by.
// @$banip: 1 = yes, ban the IP as well, 0 = Dont ban IP
	
	function banAccount($bannid, $banreason, $banduration, $bannedby, $banip = 0)
	{
		$starttime = time();
		if($banduration > 0)
			$endtime = $starttime + $banduration;
		else
			$endtime = 0;
		
		$this->RDB->query("INSERT INTO `account_banned`(
			`id`, 
			`bandate`, 
			`unbandate`, 
			`bannedby`, 
			`banreason`, 
			`active`) 
		   VALUES(
			'".$bannid."', 
			'".$starttime."', 
			'".$endtime."',
			'".$bannedby."',
			'".$banreason."',
			'1')
		");
		
		// If banip is set to 1, then we need to ban the IP
		if($banip == 1)
		{
			$getip = $this->RDB->selectCell("SELECT `last_ip` FROM `account` WHERE `id`='".$bannid."'");
			$this->RDB->query("INSERT INTO `ip_banned`(
				`ip`, 
				`bandate`, 
				`unbandate`, 
				`bannedby`, 
				`banreason`) 
			   VALUES(
				'". $getip ."', 
				'". $starttime ."', 
				'". $endtime ."',
				'". $bannedby ."', 
				'". $banreason. "')
			");
		}
		
		//$this->DB->query("UPDATE `mw_account_extend` SET `account_level`=5 WHERE account_id='".$bannid."'");
		return TRUE;
	}
	
//	************************************************************
// Un Bans an account. Just need to post the account ID

	function unbanAccount($id)
	{
		$this->RDB->query("UPDATE account_banned SET active='0' WHERE `id`='".$id."'");
		$ipd = $this->RDB->selectCell("SELECT `last_ip` FROM `account` WHERE `id`='".$id."'");
		$this->RDB->query("DELETE FROM ip_banned WHERE ip='".$ipd."'");
        $this->DB->query("UPDATE `mw_account_extend` SET `account_level`='2' WHERE `account_id`='".$id."'");
		return TRUE;
	}

//	************************************************************	
// Gets all the users info from the database including username, email
// account level, id, and all sorts. post an account id here

	function getProfile($acct_id=FALSE)
	{
		$res = $this->RDB->selectRow("
			SELECT * FROM account
			WHERE id='".$acct_id."'");
//			LEFT JOIN mw_account_extend ON account.id = mw_account_extend.account_id
//			LEFT JOIN mw_account_groups ON mw_account_extend.account_level = mw_account_groups.account_level
		$res_ext = $this->DB->selectRow("SELECT * FROM mw_account_extend 
			LEFT JOIN mw_account_groups ON mw_account_extend.account_level = mw_account_groups.account_level 
			WHERE mw_account_extend.account_id = '".$acct_id."'");
        return array_merge($res, $res_ext);
    }
	
//	************************************************************
// Returns an account username. Post an account ID here.

    function getLogin($acct_id=FALSE)
	{
        $res = $this->RDB->selectCell("SELECT `username` FROM `account` WHERE `id`='".$acct_id."'");
        if($res == FALSE)
		{
			return FALSE;  // no such account
		}
		else
		{
			return $res;
		}
    }

//	************************************************************	
// Gets an account id. Post username here
    function getAccountId($acct_name=FALSE)
	{
        $res = $this->RDB->selectCell("SELECT id FROM account WHERE username='".$acct_name."'");
        if($res == FALSE)
		{
			return FALSE;  // no such account
		}
		else
		{
			return $res;
		}
    }

//	************************************************************	
// Loads characters list for a specific account

	function getCharacterList($id)
	{
		global $CDB;
		$list = $CDB->select("SELECT * FROM `characters` WHERE `account`='".$id."'");
		if($list == FALSE)
		{
			return FALSE;
		}
		return $list;
	}
	
//	************************************************************
// Loads secret questions from the Database and returns them in an array.

	function getSecretQuestions()
	{
		$getsc = $this->DB->select("SELECT * FROM `mw_secret_questions`");
		return $getsc;
	}
	
//	************************************************************
// For mangos and trinity. Set locked to the $lock value

	function setLock($id, $lock)
	{
		$this->RDB->query("UPDATE `account` SET `locked`='".$lock."' WHERE `id`='".$id."'");
		return TRUE;
	}
	
//	************************************************************
// Sets an accounts email. Post an account id and new email address.

	function setEmail($id, $newemail)
	{
		$id = $this->RDB->real_escape_string($id);
        $newemail = $this->RDB->real_escape_string($newemail);
		$this->RDB->query("UPDATE `account` SET `email`='".$newemail."' WHERE `id`='$id' LIMIT 1");
		return TRUE;
	}

//	************************************************************	
// Sets the expansion for an account. Post an account id and Expansion number here.
// 2 = WotLK, 1 = TBC, 0 = Base

	function setExpansion($id, $nexp)
    {
        $id = $this->RDB->real_escape_string($id);
        $nexp = $this->RDB->real_escape_string($nexp);
        $this->RDB->query("UPDATE `account` SET `expansion`='$nexp' WHERE `id`=$id");
        return TRUE;
    }

//	************************************************************	
// Sets a password for an account. Post an account id and New password here.

	function setPassword($id, $newpass)
    {
        $id = $this->RDB->real_escape_string($id);
        $newpass = $this->RDB->real_escape_string($newpass);
        $username = $this->RDB->selectCell("SELECT `username` FROM `account` WHERE `id`='$id' LIMIT 1");
		if($username != FALSE)
		{
			$pass_hash = $this->sha_password($username, $newpass);
			$this->RDB->query("UPDATE `account` SET `sha_pass_hash`='$pass_hash', `sessionkey`= NULL, `v`= '0', `s`= '0' WHERE `id`='$id' LIMIT 1");
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }

//	************************************************************	
// Sets the secret questions and answers for an account.
// Post in order, account id, question 1 ,  answer 1, question 2, answer 2.

	function setSecretQuestions($id, $sq1, $sa1, $sq2, $sa2)
	{
		$sq1 = strip_if_magic_quotes($sq1);
		$sa1 = strip_if_magic_quotes($sa1);
		$sq2 = strip_if_magic_quotes($sq2);
		$sa2 = strip_if_magic_quotes($sa2);
		
		// Check for symbols
		if(check_for_symbols($sa1) == FALSE && check_for_symbols($sa2) == FALSE && $sq1 != '0' && $sq2!= '0')
		{
			if(strlen($sa1) >= 4 && strlen($sa2) >= 4)
			{
				if($sa1 != $sa2 && $sq1 != $sq2)
				{
					$this->DB->query("UPDATE `mw_account_extend` SET `secret_q1`='$sq1', `secret_q2`='$sq2', `secret_a1`='$sa1', `secret_a2`='$sa2' WHERE `account_id`='$id'");
					return 1; // 1 = Set
				}
				else
				{
					return 2; // 2 = Answers or questions where the same
				}
			}
			else
			{
				return 3; // Answers where less then 4 characters long
			}
		}
		else
		{
			return 4; // Answers contained symbols
		}
	}

//	************************************************************
// Resets users secret questions
	
	function resetSecretQuestions($id)
	{
		$this->DB->query("UPDATE mw_account_extend SET secret_q1=NULL, secret_q2=NULL, secret_a1=NULL, secret_a2=NULL WHERE account_id='".$id."'");
		return TRUE;
	}
	
	
// === ONLINE FUNCTIONS === //

//	************************************************************
// Updates the online list based off of whos been online in the last 5 minutes
// Deletes the old

    function onlinelist_update()
    {
        $GLOBALS['guests_online'] = 0;
        $rows  = $this->DB->select("SELECT * FROM `mw_online`");
        foreach($rows as $result_row)
        {
            if(time()-$result_row['logged'] <= 60*5)
            {
                if($result_row['user_id'] > 0)
				{
					$GLOBALS['users_online'][] = $result_row['user_name'];
                }
				else
				{
					$GLOBALS['guests_online']++;
                }
            }
            else
            {
                $this->DB->query("DELETE FROM `mw_online` WHERE `id`='".$result_row['id']."' LIMIT 1");
            }
        }
    }

//	************************************************************
// Adds the user to the update list

    function onlinelist_add()
    {
        global $user;

        $result = $this->DB->count("SELECT id FROM `mw_online` WHERE `user_id`='".$this->user['id']."'");
        if($result > 0)
        {
            $this->DB->query("UPDATE `mw_online` SET 
				`user_ip`='".$this->user['ip']."',
				`logged`='".time()."',
				`currenturl`='".$_SERVER['REQUEST_URI']."' 
			  WHERE `user_id`='".$this->user['id']."' LIMIT 1
			");
        }
        else
        {
            $this->DB->query("INSERT INTO `mw_online`(
				`user_id`,
				`user_name`,
				`user_ip`,
				`logged`,
				`currenturl`) 
			  VALUES(
				'".$this->user['id']."',
				'".$this->user['username']."',
				'".$this->user['ip']."',
				'".time()."',
				'".$_SERVER['REQUEST_URI']."')
			");
        }
    }

//	************************************************************
// Adds a guest to the online list

    function onlinelist_addguest()
    {
        global $user;

        $result = $this->DB->count("SELECT id FROM `mw_online` WHERE `user_id`='0' AND `user_ip`='".$this->user['ip']."'");
        if($result > 0)
        {
            $this->DB->query("UPDATE `mw_online` SET 
				`user_ip`='".$this->user['ip']."',
				`logged`='".time()."',
				`currenturl`='".$_SERVER['REQUEST_URI']."' 
			  WHERE `user_id`='0' AND `user_ip`='".$this->user['ip']."' LIMIT 1");
        }
        else
        {
            $this->DB->query("INSERT INTO `mw_online`(
				`user_ip`,
				`logged`,
				`currenturl`) 
			  VALUES(
				'".$this->user['ip']."',
				'".time()."',
				'".$_SERVER['REQUEST_URI']."')
			");
        }
    }

	
// === ACCOUNT KEY FUNCTIONS === //

//	************************************************************
// Checks to see if the posted account key matches the DB account key

	function matchAccountKey($id, $key) 
	{
		$count = $this->DB->selectRow("SELECT * FROM mw_account_keys WHERE id='$id'");
		if($count == FALSE) 
		{
			return FALSE;
		}
		else
		{
			$account_key = $this->DB->selectRow("SELECT * FROM mw_account_keys WHERE id='$id'");
			if($key == $account_key['key']) 
			{
				return TRUE;
			}
			else 
			{
				return FALSE;
			}
		}
	}

//	************************************************************
// Adds or updates the account keys in the DB for a user

	function addOrUpdateAccountKeys($id, $key) 
	{
		$current_time = time();
		$go = $this->DB->selectRow("SELECT * FROM mw_account_keys WHERE id = '".$id."'");
		if($go == FALSE) //need to INSERT
		{
			$this->DB->query("INSERT INTO mw_account_keys (`id`, `key`, `assign_time`) VALUES ('$id', '$key', '$current_time')");
		}
		else //need to UPDATE
		{              
			$this->DB->query("UPDATE `mw_account_keys` SET `key`='$key', `assign_time`='$current_time' WHERE `id`='$id'");
		}
	}

//	************************************************************
// Removes the account key for a user ( basically logout )

	function removeAccountKeyForUser($id) 
	{
		$count = $this->DB->count("SELECT `id` FROM `mw_account_keys` where `id` ='$id'");
		if($count == 1) 
		{
			$this->DB->query("DELETE FROM `mw_account_keys` WHERE `id` ='$id'");
		}
	}
}
?>
