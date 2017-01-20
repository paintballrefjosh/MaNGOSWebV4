<?php
//==============================================================
// class vBulletin-Bridge
// See README, INSTALL for installation/config/usage instructions
// Released under the new BSD license.
// Copyright (c) 2009, Sam Cleaver (Beaver6813) All rights reserved.
//===============================================================

//===============================================================
// Change forum path to the absolute path to your forum, change
// usergroupid's to fit with your forum installation.

define('FORUMPATH', $Config->get('module_vbulletin_path')); // path to your forum
  
define('REGISTERED_USERGROUP', 2); // typical default for registered users
define('BANNED_USERGROUP', 19); // typical default for banned
define('NOACTIVATION_USERGROUP', 3); // typical default for user awaiting activation
define('PERMANENT_COOKIE', false); // false=session cookies (recommended)

// end of configuration stuff
//===============================================================
define('THIS_SCRIPT', __FILE__);
$cwd = getcwd();
chdir(FORUMPATH);
require_once('./global.php');
require_once('./includes/init.php'); // includes class_core.php
require_once('./includes/class_dm.php'); // for class_dm_user.php
require_once('./includes/class_dm_user.php'); // for user functions
require_once('./includes/functions.php'); // vbsetcookie etc.
require_once('./includes/functions_login.php'); // process login/logout
require_once('./includes/functions_user.php'); // enable us to sort out activation

//---------------------------------------------------------------------
// CLASS vBulletin_Bridge
//---------------------------------------------------------------------
class vBulletin_Bridge extends vB_DataManager_User {
   var $userdm;
   var $vbulletin;
   var $db;
   function vBulletin_Bridge() // constructor
   {
      global $vbulletin;
	  $this->vbulletin = $vbulletin;
	  $this->db = $this->vbulletin->db;
      $this->userdm =& datamanager_init('User', $this->vbulletin, ERRTYPE_ARRAY);
   }
//---------------------------------------------------------------------
// This function duplicates the functionality of fetch_userinfo(),
// using the user name instead of numeric ID as the argument.
// See comments in includes/functions.php for documentation.
//---------------------------------------------------------------------
	function fetch_userinfo_from_username($username, $option=0, $languageid=0)
	{
	   $result = $this->db->query("SELECT * FROM "
		  . TABLE_PREFIX . "user WHERE username = '".$username."'");
		$useridq = $this->db->fetch_array($result);  
	   if (!$useridq) return $useridq;
	   $userid = $useridq['userid'];
	   return fetch_userinfo($userid, $option, $languageid);
	}
//---------------------------------------------------------------------
// Internal function used for converting userdata to the right format 
// to vBulletin
//---------------------------------------------------------------------
  private function userdata_convert(&$userdata) 
  {
	 // $userdata is our array that contains user data from our own
	 // user database, which we must convert to the vBulletin values.
	 // Minimally, it must contain the username, email and/or password.
  
	 // required fields
	 $vbuser = array( 'username' => $userdata['username'] );
	 if (isset($userdata['email']))
		$vbuser['email'] = $userdata['email'];
	 if (isset($userdata['password']))
		$vbuser['password'] = $userdata['password'];
	  $vbuser['ipaddress'] = $_SERVER['REMOTE_ADDR'];
	 // extra stuff, expand as desired
	 if ($userdata['usergroupid'])
		$vbuser['usergroupid'] = $userdata['usergroupid'];
	 if ($userdata['usertitle'])
		$vbuser['usertitle'] = $userdata['usertitle'];
	 return $vbuser;
  }

   //======== USER REGISTRATION / UPDATE / DELETE ========
//---------------------------------------------------------------------
// Register new user, requires userdata username, password and email,
// details on how to wrap up userdata outlined above. 
// Optional, set $noactivate to true and automatically activate user,
// useful if validation system already in place.
//---------------------------------------------------------------------
public function register_newuser(&$userdata,$noactivate=false)
   {
      $vbuser = $this->userdata_convert($userdata);
      foreach($vbuser as $key => $value)
         $this->userdm->set($key, $value);
      $this->userdm->set('usergroupid', NOACTIVATION_USERGROUP);

      // Bitfields; set to desired defaults.
      // Comment out those you have set as defaults
      // in the vBuleltin admin control panel
      $this->userdm->set_bitfield('options', 'adminemail', 1);
      $this->userdm->set_bitfield('options', 'showsignatures', 1);
      $this->userdm->set_bitfield('options', 'showavatars', 1);
      $this->userdm->set_bitfield('options', 'showimages', 1);
      $this->userdm->set_bitfield('options', 'showemail', 0);

      //$this->userdm->errors contains error messages
      if (empty($this->userdm->errors))
         $this->vbulletin->userinfo['userid'] = $this->userdm->save();
      else
         return implode(" ",$this->userdm->errors);
	//Assign VB Script variables
	  $email = $vbuser['email'];
	  $userid = $this->vbulletin->userinfo['userid'];
	  $username = $vbuser['username'];
	  $vbsiteurl = SITE_URL;
	//Build activation id (uses vb's built-in function)
		$activateid = build_user_activation_id($userid, 2, 0);
	//If $noactivate is set to true then we skip sending activation email and just activate user
	if($noactivate)
		{
		$activatestatus = $this->activate_user($userid,$activateid);
		//It will only be true if an error has occured, in which case return it
		if($activatestatus)
			return $activatestatus;
		}
	else
		{
		//Parse variables for email messsage, also subsitutes in activateid, userid, username and email
			eval(fetch_email_phrases('activateaccount'));
		//Send activation email
			vbmail($email, $subject, $message, true);	
		}

	//Reset userid to 0 as to not confuse script
		$this->vbulletin->userinfo['userid'] = 0;
      return false;
   }
//---------------------------------------------------------------------
// Activates user when provided with userid ($u) and activation key ($i)
// Unlike most functions it returns FALSE if it activates successfully
// and returns a string with the error message if it is unsuccessful.
//---------------------------------------------------------------------
public function activate_user($u,$i)
   	{
	//Retrieve userinfo from userid supplied
	$userinfo = verify_id('user', $u, 1, 1);	
	//If they are awaiting activation
	if ($userinfo['usergroupid'] == NOACTIVATION_USERGROUP)
	{
		// check valid activation id
		$user = $this->db->query_first("
			SELECT activationid, usergroupid, emailchange
			FROM ".TABLE_PREFIX."useractivation
			WHERE activationid = '" . $this->db->escape_string($i) . "'
				AND userid = $userinfo[userid]
				AND type = 0
		");
		if (!$user OR $i != $user['activationid'])
		{
		// give link to resend activation email
		return "Invalid activation ID or user ID. Click <a href='register.php?do=requestemail&u=$u'>here</a> to request a new activation email.";
		}
		// delete activationid
		$this->db->query_write("DELETE FROM ".TABLE_PREFIX."useractivation WHERE userid=$userinfo[userid] AND type=0");
		//If we dont have a usergroup for the user, assign to the whatever has been set in config as registered usergroup
		if (empty($user['usergroupid']))
		{
			$user['usergroupid'] = REGISTERED_USERGROUP; // sanity check
		}
		//Get the username for user
		$getusername = $this->db->query_first("
			SELECT username
			FROM ".TABLE_PREFIX."user
			WHERE userid = '" . $this->db->escape_string($u) . "'");
		//Wrap up new userdata
		$userdata = array('username'=>$getusername['username'],'usergroupid'=>REGISTERED_USERGROUP,'usertitle'=>'Junior Member');
		//Update user with new usergroup/title, if unsuccessful, return the error message
		if($updateug = $this->update_user($userdata))
			return $updateug;
		//If update was successful send welcome email (note we use a custom phrase for the "main" site)
		if ($this->vbulletin->options['welcomemail'])
			{
				eval(fetch_email_phrases('welcomemail'));
				vbmail($userinfo['email'], $subject, $message);
			}
		//Reset userid so we dont confuse the script
		$this->vbulletin->userinfo['userid'] = 0;	
		//Return false which indicates success
		return false;
		
	}
	else
		return "This account has already been activated. Click <a href='login.php'>here</a> to login.";
		
	}
//---------------------------------------------------------------------
// Used before a user is activated, link given in initial activation
// email, removes activation key and deletes user. Only used for un-
// activated users, requires userid ($u) and activation key ($i)
//---------------------------------------------------------------------
   public function deactivate_user($u,$i)
   	{
	//Retrieve userinfo from userid supplied
	$userinfo = verify_id('user', $u, 1, 1);	
	//If they are awaiting activation
	if ($userinfo['usergroupid'] == NOACTIVATION_USERGROUP)
	{
		// check valid activation id
		$user = $this->db->query_first("
			SELECT activationid, usergroupid, emailchange
			FROM ".TABLE_PREFIX."useractivation
			WHERE activationid = '" . $this->db->escape_string($i) . "'
				AND userid = $userinfo[userid]
				AND type = 0
		");
		if (!$user OR $i != $user['activationid'])
		{
		// give link to resend activation email
		return "Invalid activation ID or user ID. Click <a href='register.php?do=requestemail&u=$u'>here</a> to request a new activation email.";
		}
		// delete activationid
		$this->db->query_write("DELETE FROM ".TABLE_PREFIX."useractivation WHERE userid=$userinfo[userid] AND type=0");
		//If we dont have a usergroup for the user, assign to whatever has been set in config as registered usergroup
		if (empty($user['usergroupid']))
		{
			$user['usergroupid'] = REGISTERED_USERGROUP; // sanity check
		}
		//Get the username for user
		$getusername = $this->db->query_first("
			SELECT username
			FROM ".TABLE_PREFIX."user
			WHERE userid = '" . $this->db->escape_string($u) . "'");
		//Remove totally!
		$this->delete_user($getusername['username']);
		//Reset userid so we dont confuse the script
		$this->vbulletin->userinfo['userid'] = 0;	
		//Return false which means success!
		return false;
		
	}
	else
		return "This account has already been activated. Click <a href='login.php'>here</a> to login.";
		
	}
//---------------------------------------------------------------------
// Used to request a new activation email incase they didnt recieve the
// first one. Only requires the email address the original one was sent
// to ($email).
//---------------------------------------------------------------------
   public function requestact_user($email)
   	{
	//Get user info from email given/check they actually exist
	$users = $this->db->query_read_slave("
		SELECT user.userid, user.usergroupid, username, email, activationid, languageid
		FROM ".TABLE_PREFIX."user AS user
		LEFT JOIN useractivation AS useractivation ON(user.userid = useractivation.userid AND type = 0)
		WHERE email = '" . $this->db->escape_string($email) . "'"
	);
	//If they exist then carry on
	if ($this->db->num_rows($users))
	{
		//Loop through everyone with the same email address
		while ($user = $this->db->fetch_array($users))
		{
			//Only work on those who are still not activated
			if ($user['usergroupid'] == NOACTIVATION_USERGROUP)
			{ 
				//If they for some crazy reason do not have an activation ID then...
				if (empty($user['activationid']))
				{ 
					//Create a new activation ID for the user
					$user['activationid'] = build_user_activation_id($user['userid'], 2, 0);
				}
				else
				{
					//If they already have an activation ID we'll update the current entry with a new ID
					$user['activationid'] = fetch_random_string(40);
					$this->db->query_write("
						UPDATE ".TABLE_PREFIX."useractivation SET
							dateline = " . TIMENOW . ",
							activationid = '$user[activationid]'
						WHERE userid = $user[userid]
							AND type = 0
					");
				}
				//Set some required VB variables (for the email)
				$userid = $user['userid'];
				$username = $user['username'];
				$activateid = $user['activationid'];
				//Send out activation email, note the custom vbulletin phrase for the "main" site!
				eval(fetch_email_phrases('activateaccount', $user['languageid']));
				//Actually send the email
				vbmail($user['email'], $subject, $message, true);
			}
		}
		//Return as a success
		return false;
	}
	else
	{
		return "No account with that email address exists, please try again.";
	}
	}
//---------------------------------------------------------------------
// Used to request a new request a new password incase they forgot their
// old one! Only requires user accounts email ($email). Returns false on success
//---------------------------------------------------------------------
   public function request_password($email)
   	{
	//Get the userid from their email address
	$getuserid = $this->db->query_first("
			SELECT userid
			FROM ".TABLE_PREFIX."user
			WHERE email = '" . $this->db->escape_string($email) . "'");
	//Gets list of users with the email address
	$users = $this->db->query_read_slave("
		SELECT userid, username, email, languageid
		FROM " . TABLE_PREFIX . "user
		WHERE email = '" . $this->db->escape_string($email) . "'
	");
	if ($this->db->num_rows($users))
	{
		//Loops through users
		while ($user = $this->db->fetch_array($users))
		{
			//If the userid's do not match up with whats in the database
			if ($getuserid['userid'] AND $getuserid['userid'] != $user['userid'])
			{
				//Exit the loop
				continue;
			}
			//Set vb username
			$user['username'] = unhtmlspecialchars($user['username']);
			//Generate new activation id
			$user['activationid'] = build_user_activation_id($user['userid'], 2, 1);
			//Use custom phrase and send out lost password email
			eval(fetch_email_phrases('lostpw', $user['languageid']));
			vbmail($user['email'], $subject, $message, true);
		}
		//Return as a success
		return false;
	}
	else
	{
		return "No account with that email address exists, please try again.";
	}
		
	}
//---------------------------------------------------------------------
// Accessed only from change_password(), you shouldn't need this.
// Requires userid ($u) and activation key ($i), returns false on success
//---------------------------------------------------------------------
  private function check_password_request($u,$i)
   	{
	//Retrieve userinfo from userid supplied
	$userinfo = verify_id('user', $u, 1, 1);	
	//Get user with matching userid and with a request for new password
	$user = $this->db->query_first("
		SELECT activationid, dateline
		FROM " . TABLE_PREFIX . "useractivation
		WHERE type = 1
			AND userid = $u
	");
	//Check if doesnt exist
	if (!$user)
		{
		return "New password request for this user not placed.";
		}
	//If its been longer than 24 hours than the password request was placed
	if ($user['dateline'] < (TIMENOW - 24 * 60 * 60))
		{  // is it older than 24 hours?
		return "Lost password key expired. It has been longer than 24 hours since you requested it. You can request a new one <a href='login.php?do=lostpw'>here</a>.";
		}
	//If activation ID doesnt match that of the user
	if ($user['activationid'] != $i)
	{ //wrong act id
			return "Invalid lost password key. Click <a href='login.php?do=lostpw'>here</a> to request a new one.";
	}
	//If we haven't already returned it must be fine, return false!
	return false;
	}
//---------------------------------------------------------------------
// Public function to change the password.
// Requires userid ($u) and activation key ($i), returns false on success
// Optional, defaults to logging in user after password change, can be 
// changed to false.
//---------------------------------------------------------------------
   public function change_password($u,$i,$password,$login=true)
   	{
	//Check if password request is correct
	if($check_codes = $this->check_password_request($u,$i))
		return $check_codes;
		
	// delete old activation id
	$this->db->query_write("DELETE FROM " . TABLE_PREFIX . "useractivation WHERE userid = $u AND type = 1");
	//Get the username from the userid
	$getusername = $this->db->query_first("
			SELECT username
			FROM ".TABLE_PREFIX."user
			WHERE userid = '" . $this->db->escape_string($u) . "'");
	//Create array for password change
	$build_update = array("username"=>$getusername['username'],"password"=>$password);
	//Commit password change
	$user_changed = $this->update_user($build_update);
	//If login is set to true then log the user in
	if($login&&!$user_changed)
		$this->login($buildupdate);
	//If all is correct $user_changed should be false and so should return false
	return $user_changed;
		
	}
//---------------------------------------------------------------------
// Update user details. Very important function requires $userdata,
// configuration details for this can be found above.
//---------------------------------------------------------------------
   public function update_user(&$userdata)
   {
	  //Validate userdata by passing through our userdata_convert function
      $vbuser = $this->userdata_convert($userdata);
	  //Check for userinfo from the username provided
      	if (!($existing_user = $this->fetch_userinfo_from_username($vbuser['username'])))
		{
         	return 'Username does not exist.';
		}
	  //Set existing user data
      $this->userdm->set_existing($existing_user);
	  
	  //Loop through new user data and set it
      foreach($vbuser as $key => $value)
	  {
         $this->userdm->set($key, $value);
	  }
	  
      // reset password cookie in case password changed
      if (isset($vbuser['password']))
	  {
		  vbsetcookie('password', md5($this->vbulletin->userinfo['password'].COOKIE_SALT), PERMANENT_COOKIE, true, true);
	  }
	  
	  //If there are any errors return them
      if (count($this->userdm->errors))
	  {
         return $this->userdm->errors;
	  }
	  
	  //If there are no errors then SAVE the set data and return false.
      $this->vbulletin->userinfo['userid'] = $this->userdm->save();
      return false;
   }
//---------------------------------------------------------------------
// Completely deletes user, experimental and is not reccomended for normal
// use due to the irregularities it can create with post counts. We only 
// use it delete non-activated users.
// Requires only the username ($username)
//---------------------------------------------------------------------
   public function delete_user(&$username)
   {
   // The vBulletin documentation suggests using userdm->delete()
   // to delete a user, but upon examining the code, this doesn't
   // delete everything associated with the user.  The following
   // is adapted from admincp/user.php instead.
   // NOTE: THIS MAY REQUIRE MAINTENANCE WITH NEW VBULLETIN UPDATES.

      $userdata = $this->db->query_first_slave("SELECT userid FROM "
         . TABLE_PREFIX . "user WHERE username='{$username}'");
      $userid = $userdata['userid'];
      if ($userid) {

      // from admincp/user.php 'do prune users (step 1)'

         // delete subscribed forums
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "subscribeforum WHERE userid={$userid}");
         // delete subscribed threads
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "subscribethread WHERE userid={$userid}");
         // delete events
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "event WHERE userid={$userid}");
         // delete event reminders
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "subscribeevent WHERE userid={$userid}");
         // delete custom avatars
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "customavatar WHERE userid={$userid}");
         $customavatars = $this->db->query_read("SELECT userid, avatarrevision FROM "
          . TABLE_PREFIX . "user WHERE userid={$userid}");
         while ($customavatar = $this->db->fetch_array($customavatars)) {
            @unlink($this->vbulletin->options['avatarpath'] . "/avatar{$customavatar['userid']}_{$customavatar['avatarrevision']}.gif");
         }
         // delete custom profile pics
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "customprofilepic WHERE userid={$userid}");
         $customprofilepics = $this->db->query_read(
            "SELECT userid, profilepicrevision FROM "
            . TABLE_PREFIX . "user WHERE userid={$userid}");
         while ($customprofilepic = $this->db->fetch_array($customprofilepics)) {
            @unlink($this->vbulletin->options['profilepicpath'] . "/profilepic$customprofilepic[userid]_$customprofilepic[profilepicrevision].gif");
         }
         // delete user forum access
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "access WHERE userid={$userid}");
         // delete moderator
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "moderator WHERE userid={$userid}");
         // delete private messages
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "pm WHERE userid={$userid}");
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "pmreceipt WHERE userid={$userid}");
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "session WHERE userid={$userid}");
         // delete user group join requests
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "usergrouprequest WHERE userid={$userid}");
         // delete bans
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "userban WHERE userid={$userid}");
         // delete user notes
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "usernote WHERE userid={$userid}");

      // from admincp/users.php 'do prune users (step 2)'

         // update deleted user's posts with userid=0
         $this->db->query_write("UPDATE " . TABLE_PREFIX
            . "thread SET postuserid = 0, postusername = '"
            . $this->db->escape_string($username)
            . "' WHERE postuserid = $userid");
         $this->db->query_write("UPDATE " . TABLE_PREFIX
            . "post SET userid = 0, username = '"
            . $this->db->escape_string($username)
            . "' WHERE userid = $userid");

         // finally, delete the user
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "usertextfield WHERE userid={$userid}");
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "userfield WHERE userid={$userid}");
         $this->db->query_write("DELETE FROM " . TABLE_PREFIX
            . "user WHERE userid={$userid}");
      }
   /*
      the following is suggested in the documentation but doesn't work:

      $existing_user = fetch_userinfo_from_username($username);
      $this->userdm->set_existing($existing_user);
      return $this->userdm->delete();
   */
   }


   // ======== USER LOGIN / LOGOUT ========
//---------------------------------------------------------------------
// Main login function, requires userdata formatted correctly. Can also
// filter user groups, $acceptgroups should be an array passed as 
// array(1,2,3,45) etc, this is useful for creating admin only pages etc
// if not set then all activated members will be allowed in.
//---------------------------------------------------------------------
   public function login($vbuser,$acceptgroups=false)
   {
	  //Get user info from username passed
      $this->vbulletin->userinfo = $this->fetch_userinfo_from_username($vbuser['username']);
	  //Verify login via VB
	  if(!verify_authentication($vbuser['username'], $vbuser['password'], '', '', 1, true))
	  	{
		$this->vbulletin->userinfo['userid'] = 0;
	  	return "Invalid Username or Password.";
		}
	//Check that user is not awaiting activation
	if($this->vbulletin->userinfo['usergroupid']==NOACTIVATION_USERGROUP)
		{
		$this->vbulletin->userinfo['userid'] = 0;
	  	return "Un-Activated Account. To activate please request a new activation email <a href='register.php?do=requestemail&username={$vbuser['username']}'>here</a>.";
		}
	//Check user does not belong to the "banned" user group - TODO: Use VB variables incase usergroupid is different
	if($this->vbulletin->userinfo['usergroupid']==BANNED_USERGROUP)
		{
		$this->vbulletin->userinfo['userid'] = 0;
	  	return "You're Barred! If you think there has been a mistake or wish to appeal please visit the contact page <a href='contact.php'>here</a>.";
		}
	//If acceptgroups is set then check that user is part of the usergroups specified
	if($acceptgroups)
		{
		//Check main usergroup as well as additional usergroups
		$getadditional = explode(',',$this->vbulletin->userinfo['membergroupids']);
		//Loop through specified usergroups
		foreach($acceptgroups as $value)
			{
			//If user is part of the usergroup then allowlogin
			if($value == $this->vbulletin->userinfo['usergroupid'])
				$allowlogin = true;
			//Check additional usergroups
			foreach($getadditional as $additionalvalue)
				{
				//If user is part of the usergroup then allowlogin
				if($value == $additionalvalue)
					$allowlogin = true;	
				}
			}
		//If user is not part of any specified usergroups then return error.
		if(!$allowlogin)
			{
			$this->vbulletin->userinfo['userid'] = 0;
	  		return "This is a restricted area. Please contact the site administrator for further details.";	
			}
		}
		//Unstrike the user (resets vbulletin brute-force protection)
		exec_unstrike_user($vbuser['username']);
	  //Create vbulletin cookies for user
      process_new_login('', 1, '');
	  //Saves cookies & session variables for user
	  $this->vbulletin->session->save();
	  //Return false for success!
	  return false;
   }
//---------------------------------------------------------------------
// Very simple function used to LOGOUT, requires no variables, logs out
// currently logged in user.
//---------------------------------------------------------------------
   public function logout()
   {
	  // unsets all cookies and session data
      process_logout(); 
   }

} // end class vBulletin_Bridge
chdir($cwd);
?> 