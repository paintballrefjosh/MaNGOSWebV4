<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

/***************************************************************
 * SET ERROR REPORTING
 ***************************************************************/
error_reporting(E_ALL);
ini_set('log_errors', TRUE);
ini_set('html_errors', FALSE);
ini_set('display_errors', TRUE);

/***************************************************************
 * Define INCLUDED so we can see if pages are included by this one
 ***************************************************************/
define('INCLUDED', TRUE);

/***************************************************************
 * Define page loading time start
 ***************************************************************/
define('TIME_START', microtime(1));
$_SERVER['REQUEST_TIME'] = time();

/***************************************************************
 * Load the Config
 ***************************************************************/
include('config/config-protected.php');

/***************************************************************
 * Setup the Database class and Database connections
 ***************************************************************/
require ('core/class.database.php');
$DB = new Database(
	$dbconf['db_host'], 
	$dbconf['db_port'], 
	$dbconf['db_username'], 
	$dbconf['db_password'], 
	$dbconf['db_name']
	);

// Check the database status. 0 = cannot connect, 1 = success, 2 = DB doesnt exist
if($DB->status() != 1)
{
	echo "Cannot connect to the MaNGOS Web database. Please make sure you have run the installer to properly set the DB info in the database.<br>";
	die();
}

$mwe_config = array();
$mwe_config = $DB->selectRow("SELECT * FROM mw_config LIMIT 1");

/***************************************************************
 * Load the Core class
 ***************************************************************/
include('core/core.php');
$Core = new Core($mwe_config);

/***************************************************************
 * Show Site Notice if enabled in config, and user cookie not set
 ***************************************************************/
if($mwe_config['site_notice_enable'] == 1 && !isset($_COOKIE['agreement_accepted']))
{
	include('modules/notice/notice.php');
	exit();
}

/***************************************************************
 * See if the site is installed by checking config defualts
 ***************************************************************/
if($dbconf['db_username'] == 'default')
{
	header('location: install/');
}

/***************************************************************
 * Include the site functions and classes
 ***************************************************************/
include('core/common.php'); 				// Holds most of the sites common functions
include('core/class.template.php');			// Sets up the template system
include('core/SDL/class.account.php'); 		// contains account related scripts and functions

/***************************************************************
 * Set the site globals, selected realm, language etc etc
 ***************************************************************/
$Core->setGlobals();

// Load language file
include('lang/' . $GLOBALS["user_cur_lang"] . '/common.php');
	
// Make an array from `dbinfo` column for the selected realm..
$realm_db = $DB->selectRow("SELECT * FROM mw_realm WHERE realm_id='".$GLOBALS['cur_selected_realm']."'");

// === Establish the Realm DB connection === //
$RDB = new Database(
	$mwe_config['db_logon_host'],
	$mwe_config['db_logon_port'],
	$mwe_config['db_logon_user'],
	$mwe_config['db_logon_pass'],
	$mwe_config['db_logon_name']
	);

// Check the CDB status. 0 = cannot connect, 1 = success, 2 = DB doesnt exist
if($RDB->status() != 1)
{
	echo "Cannot connect to the Realm database. Please make sure you have this realm setup successfully in the Admin Panel.  Delete your cookies to reset realm selection back to default.<br>";
	//die();
}

// === Establish the Character DB connection === //
$CDB = new Database(
	$realm_db['db_char_host'],
	$realm_db['db_char_port'],
	$realm_db['db_char_user'],
	$realm_db['db_char_pass'],
	$realm_db['db_char_name']
	);

// Check the CDB status. 0 = cannot connect, 1 = success, 2 = DB doesnt exist
if($CDB->status() != 1)
{
	echo "Cannot connect to the Character database. Please make sure you have this realm setup successfully in the Admin Panel.  Delete your cookies to reset realm selection back to default.<br>";
	//die();
}

// === Establish the World DB connection === //	
$WDB = new Database(
	$realm_db['db_world_host'],
	$realm_db['db_world_port'],
	$realm_db['db_world_user'],
	$realm_db['db_world_pass'],
	$realm_db['db_world_name']
	);

// Check the CDB status. 0 = cannot connect, 1 = success, 2 = DB doesnt exist
if($WDB->status() != 1)
{
	echo "Cannot connect to the World database. Please make sure you have this realm setup successfully in the Admin Panel.  Delete your cookies to reset realm selection back to default.<br>";
	//die();
}
	
// Free up memory
unset($Realm_DB_Info);

/***************************************************************
 * Load the Account / Auth Class
 ***************************************************************/
$Account = new Account();
$user = $Account->user;
$user['cur_selected_realm'] = $GLOBALS['cur_selected_realm'];

/***************************************************************
 * Load the Template class and setup the template system
 ***************************************************************/
$Template = new MangosTemplate;

// Lets get the template information
$Template = $Template->loadTemplateXML();
if($Template == FALSE)
{
	echo "Fetal Error: Template XML Not Found!";
	die();
}

/***************************************************************
 * Start of page loading
 ***************************************************************/

	// Start off by checking if the requested page is a module or not
	if(!isset($_GET['p']) && isset($_GET['module']))
	{
		// Scan the directory for installed modules to prevent XSS
		$Modulelist = scandir("modules/");
		if(in_array($_GET['module'], $Modulelist))
		{
			include("modules/".$_GET['module']."/module.php");
		}
		else
		{
			echo "No Module of that name found!";
		}
	}

	// If page is not a module, then lets load our template pages.
	else
	{
		// if empty page, then load default component(frontpage)
		$ext = (isset($_GET['p']) ? $_GET['p'] : (string)$mwe_config['default_component']);
		
		// If url looks like so: ?p=account/login (This is a avalid url)
		if(strpos($ext, '/') !== FALSE) 
		{
			list($ext, $sub) = explode('/', $ext);
		}
		else
		{
			// If empty sub page, load page.index.php
			$sub = (isset($_GET['sub']) ? $_GET['sub'] : 'index');
		}
		$script_file = 'inc/' . $ext . '/' . $ext . '.' . $sub . '.php';
		$template_file = $Template['script_path'] . '/' . $ext . '/' . $ext . '.' . $sub . '.php';

		// === Start Loading of the Page files === //

		// If the requested page is the admin Panel, then we load the admin template
		if($ext == 'admin') 
		{
			if(file_exists('inc/admin/body_functions.php')) 
			{
				include('inc/admin/body_functions.php');
			}
			@include('inc/admin/script_files/admin.' . $sub .'.php');
			ob_start();
				include('inc/admin/body_header.php');
			ob_end_flush();
			ob_start();
				include('inc/admin/template_files/admin.' . $sub .'.php');
			ob_end_flush();
			
			// Set our time end, so we can see how fast the page loaded.
			define('TIME_END', microtime(1));
			define('PAGE_LOAD_TIME', TIME_END - TIME_START);
			include('inc/admin/body_footer.php');
		}

		// Else, if requested page isnt the admin panel, then load the template
		else
		{
			
			// Start Loading Of Script Files
			@include($script_file);

			// If a body functions file exists, include it.
			if(file_exists($Template['functions'])) 
			{
				include($Template['functions']);
			}
			ob_start();
				include($Template['header']);
			ob_end_flush();
			
			ob_start();
			include($template_file);
			ob_end_flush();

			// Set our time end, so we can see how fast the page loaded.
			define('TIME_END', microtime(1));
			define('PAGE_LOAD_TIME', TIME_END - TIME_START);
			include($Template['footer']);
		}
	}
/***************************************************************
 * End Page Loading
 ***************************************************************/

// Close all DB Connections
$DB->__destruct();
$CDB->__destruct();
$WDB->__destruct();
?>
