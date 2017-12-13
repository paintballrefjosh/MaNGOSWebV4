<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

class Core
{
	public $version = '4.1.4';
	public $version_date = '2017-12-13, 11:22';
	public $db_version = '4.1.0';
	private $conf;

	public function __construct(array $conf)
	{
		$this->conf = $conf;
		$this->Initialize();
	}

//**************************************************************
//	
//	Main initialize function. Sets the path in the config for 
//	the site.
//
//**************************************************************	
	private function Initialize()
	{
		$this->copyright = 'Powered by MaNGOS Web Enhanced version ' . $this->version . ' &copy; 2017, <a href="http://www.mistvale.com">Mistvale Dev Team</a>. All Rights Reserved.';
	
		// Fill in the config with the proper directory info if the directory info is wrong
		define('SITE_DIR', dirname( $_SERVER['PHP_SELF'] ).'/');
		define('PRE_SITE_HREF', str_replace('//', '/', SITE_DIR));
		define('SITE_HREF', stripslashes(PRE_SITE_HREF));
		if(isset($_SERVER['HTTP_HOST']))
		{
			define('SITE_BASE_HREF', 'http://'.$_SERVER['HTTP_HOST'] . SITE_HREF);
		}
		else
		{
			define('SITE_BASE_HREF', $this->conf['site_base_href'] . SITE_HREF);
		}

		return TRUE;
	}
	
//**************************************************************
//	
//	Set the site globals and determine what language and realm
//	the user has selected. If no cookie set, then set one
//
//**************************************************************	
	public function setGlobals()
	{
		// Setup the site globals
		$GLOBALS['users_online'] = array();
		$GLOBALS['guests_online'] = 0;
		$GLOBALS['user_cur_lang'] = '';
		$GLOBALS['messages'] = '';		// For server messages
		$GLOBALS['redirect'] = '';		// For the redirect function, uses <meta> tags
		$GLOBALS['debug_messages'] = array();
		$GLOBALS['cur_selected_realm'] = '';
		
		
		// Check if a language cookie is set
		if(isset($_COOKIE['Language'])) 
		{
			// If the cookie is set, we need to make sure the language file still exists
			if(file_exists('lang/' . $_COOKIE['Language'] . '/common.php'))
			{
				$GLOBALS['user_cur_lang'] = (string)$_COOKIE['Language'];
			}
			else
			{
				$GLOBALS['user_cur_lang'] = (string)$this->conf->get('default_lang');
				setcookie("Language", $GLOBALS['user_cur_lang'], time() + (3600 * 24 * 365));
			}
		}
		else
		{
			$GLOBALS['user_cur_lang'] = $this->conf['default_lang'];
			setcookie("Language", $GLOBALS['user_cur_lang'], time() + (3600 * 24 * 365));
		}
		
		// === Finds out what realm we are viewing. Sets cookie if need be. === //
		if(isset($_COOKIE['cur_selected_realm'])) 
		{
			$GLOBALS['cur_selected_realm'] = (int)$_COOKIE['cur_selected_realm'];
		}
		else
		{
			$GLOBALS['cur_selected_realm'] = (int)$this->conf['default_realm_id'];
			setcookie("cur_selected_realm", (int)$this->conf['default_realm_id'], time() + (3600 * 24 * 365));
		}
	}

//**************************************************************
//	
//	Loads the server permissions such as allowing fopen
//	to open a url. Als checks to see of the function exists
//	fsockopen.
//
//**************************************************************	
	public function load_permissions()
	{
		$allow_url_fopen = ini_get('allow_url_fopen');
		if(function_exists("fsockopen")) 
		{
			$fsock = 1;
		}
		else
		{
			$fsock = 0;
		}
		$ret = array('allow_url_fopen' => $allow_url_fopen, 'allow_fsockopen' => $fsock);
		return $ret;
	}
}
?>
