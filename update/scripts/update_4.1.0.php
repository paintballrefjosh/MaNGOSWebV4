<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/****************************************************************************/

//  This PHP file is the script to update your MWE database to version 4.1.0
//  It will be executed from the web interface.

if(isset($_POST['db_admin_user']))
{
	executeDBScript();
}
else
{

?>

	<font color="red"><b>WARNING! Before proceeding with the database upgrade you should take a backup of your database (structure + data).</b></font><br /><br />
	This will upgrade your database to version 4.1.0.  You must supply database admin credentials in order to create the new MWE database.<br /><br />

	<form method="POST">
	DB Admin Username: <input type="text" name="db_admin_user" /><br />
	DB Admin Password: <input type="text" name="db_admin_pass" /><br />
	DB Host: <input type="text" name="db_admin_host" value="127.0.0.1" /><br />
	Port: <input type="text" name="db_admin_port" value="3306" /><br /><br />
	New MaNGOS Web DB Name: <input type="text" name="mw_db_name" /><br />
	New MaNGOS Web DB Username: <input type="text" name="mw_db_user" /><br />
	New MaNGOS Web DB Password: <input type="text" name="mw_db_pass" /><br /><br />
	<input type="submit" value="Update DB" />
	</form>

<?php

}

function migrateConfig(Database $dbAdmin)
{
	global $dbconf;
	
	// migrate config.php data to new DB & structure
	include("../config/config.php");
	$config = get_defined_vars();
	$sql = "UPDATE `".$_POST['mw_db_name']."`.`mw_config` SET 
		site_title = '".$config['site_title']."',
		site_email = '".$config['site_email']."',
		site_cookie = '".$config['site_cookie']."',
		site_href = '".$config['site_href']."',
		site_base_href = '".$config['site_base_href']."',
		site_armory = '".$config['site_armory']."',
		site_forums = '".$config['site_forums']."',
		emulator = '".$config['emulator']."',
		templates = '".$config['templates']."',
		default_lang = '".$config['default_lang']."',
		available_lang = '".$config['available_lang']."',
		reg_allow = '".$config['allow_registration']."',
		reg_require_activation = '".$config['require_act_activation']."',
		reg_require_invite = '".$config['reg_invite']."',
		reg_require_recaptcha = '".$config['reg_use_recaptcha']."',
		reg_recaptcha_private_key = '".$config['reg_recaptcha_private_key']."',
		reg_recaptcha_public_key = '".$config['reg_recaptcha_public_key']."',
		reg_require_secret_questions = '".$config['reg_secret_questions']."',
		allow_user_pass_change = '".$config['allow_user_passchange']."',
		allow_user_email_change = '".$config['allow_user_emailchange']."',
		max_account_per_ip = '".$config['max_act_per_ip']."',
		default_component = '".$config['default_component']."',
		flash_display_type = '".$config['flash_display_type']."',
		fp_vote_banner = '".$config['fp_vote_banner']."',
		fp_newbie_guide = '".$config['fp_newbie_guide']."',
		fp_hitcounter = '".$config['fp_hitcounter']."',
		fp_server_info = '".$config['fp_serverinfo']."',
		fp_realm_status = '".$config['fp_realmstatus']."',
		fp_players_online = '".$config['fp_playersonline']."',
		fp_server_ip = '".$config['fp_serverip']."',
		fp_server_type = '".$config['fp_servertype']."',
		fp_server_pop = '".$config['fp_serverpop']."',
		fp_server_lang = '".$config['fp_serverlang']."',
		fp_server_act = '".$config['fp_serveract']."',
		fp_server_active_act = '".$config['fp_serveractive_act']."',
		fp_server_chars = '".$config['fp_serverchars']."',
		fp_server_more_info = '".$config['fp_server_moreinfo']."',
		email_type = '".$config['email_type']."',
		email_smtp_host = '".$config['email_smtp_host']."',
		email_smtp_port = '".$config['email_smtp_port']."',
		email_use_secure = '".$config['email_use_secure']."',
		email_smtp_secure = '".$config['email_smtp_secure']."',
		email_smtp_user = '".$config['email_smtp_user']."',
		email_smtp_pass = '".$config['email_smtp_pass']."',
		paypal_email = '".$config['paypal_email']."',
		site_notice_enable = '".$config['site_notice_enable']."',
		module_online_list = '".$config['module_onlinelist']."',
		module_fp_ssotd = '".$config['module_fp_ssotd']."',
		module_vote_system = '".$config['module_vote_system']."',
		module_vote_online_check = '".$config['module_vote_onlinecheck']."',
		module_news_items = '".$config['module_news_items']."',
		module_news_open = '".$config['module_news_open']."',
		module_char_rename = '".$config['module_charrename']."',
		module_char_rename_pts = '".$config['module_charrename_pts']."',
		module_char_customize = '".$config['module_charcustomize']."',
		module_char_customize_pts = '".$config['module_charcustomize_pts']."',
		module_char_faction_change = '".$config['module_charfactionchange']."',
		module_char_faction_change_pts = '".$config['module_charfactionchange_pts']."',
		module_char_race_change = '".$config['module_charracechange']."',
		module_char_race_change_pts = '".$config['module_charracechange_pts']."',
		enable_debugging = '".$config['enable_debugging']."',
		default_realm_id = '1',
		db_logon_host = '".$dbconf['db_host']."',
		db_logon_port = '".$dbconf['db_port']."',
		db_logon_name = '".$dbconf['db_name']."',
		db_logon_user = '".$dbconf['db_username']."',
		db_logon_pass = '".$dbconf['db_password']."'
	";
	
	$dbAdmin->query($sql);
}

function migrateRealmlist(Database $dbAdmin)
{
	// migrate realmlist data to new DB & structure
	global $DB;
	$getrealms = $DB->select("SELECT * FROM `realmlist` WHERE site_enabled = 1");
	foreach($getrealms as $row)
	{
		$connectInfo = explode(";", $row['dbinfo']);
		$raInfo = explode(";", $row['ra_info']);
		if($raInfo[1] == "port")
		{
			$raInfo[1] = 0;
		}
		$dbAdmin->query("INSERT INTO `".$_POST['mw_db_name']."`.`mw_realm` SET
			realm_id = '".$row['id']."',
			db_world_host = '".$connectInfo[5]."',
			db_world_port = '".$connectInfo[6]."',
			db_world_name = '".$connectInfo[9]."',
			db_world_user = '".$connectInfo[7]."',
			db_world_pass = '".$connectInfo[8]."',
			db_char_host = '".$connectInfo[0]."',
			db_char_port = '".$connectInfo[1]."',
			db_char_name = '".$connectInfo[4]."',
			db_char_user = '".$connectInfo[2]."',
			db_char_pass = '".$connectInfo[3]."',
			ra_type = '".$raInfo[0]."',
			ra_port = '".$raInfo[1]."',
			ra_user = '".$raInfo[2]."',
			ra_pass = '".$raInfo[3]."',
			site_enabled = 1
		");
	}
}

function executeDBScript()
{
	global $Update, $DB, $dbconf;

	// run the SQL script as the provided DB admin
	$dbAdmin = New Database(
		$_POST['db_admin_host'],
		$_POST['db_admin_port'],
		$_POST['db_admin_user'],
		$_POST['db_admin_pass'],
		"" // db name
	);

	$dbAdmin->query("CREATE DATABASE `".$_POST['mw_db_name']."`");

	$dbAdmin->query("CREATE TABLE `".$_POST['mw_db_name']."`.`mw_config`(  
		`site_title` VARCHAR(64) DEFAULT 'MaNGOS Web V4',
		`site_email` VARCHAR(64) DEFAULT 'admin@mistvale.com',
		`site_cookie` VARCHAR(255) DEFAULT 'MaNGOSWebV4',
		`site_href` VARCHAR(255) DEFAULT '/',
		`site_base_href` VARCHAR(255) DEFAULT 'http://www.mistvale.com',
		`site_armory` VARCHAR(32) DEFAULT 'http://realmplayers.com',
		`site_forums` VARCHAR(32) DEFAULT '/forum/',
		`emulator` VARCHAR(32) DEFAULT 'mangos',
		`templates` VARCHAR(255) DEFAULT 'WotLK,Cataclysm_1,illidan,sunwell,Mists_of_Pandaria_v1.0,Burning_Crusade',
		`default_lang` VARCHAR(32) DEFAULT 'English',
		`available_lang` VARCHAR(255) DEFAULT 'English',
		`reg_allow` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`reg_require_activation` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`reg_require_invite` TINYINT UNSIGNED NOT NULL DEFAULT 0,
		`reg_require_recaptcha` TINYINT UNSIGNED NOT NULL DEFAULT 0,
		`reg_recaptcha_private_key` VARCHAR(64),
		`reg_recaptcha_public_key` VARCHAR(64),
		`reg_require_secret_questions` TINYINT UNSIGNED NOT NULL DEFAULT 0,
		`allow_user_pass_change` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`allow_user_email_change` TINYINT UNSIGNED NOT NULL DEFAULT 0,
		`max_account_per_ip` TINYINT UNSIGNED NOT NULL DEFAULT 10,
		`default_component` VARCHAR(64) DEFAULT 'frontpage',
		`flash_display_type` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_vote_banner` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_newbie_guide` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_hitcounter` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_info` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_realm_status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_players_online` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_ip` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_type` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_pop` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_lang` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_act` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_active_act` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_chars` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`fp_server_more_info` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`email_type` TINYINT UNSIGNED NOT NULL DEFAULT 2,
		`email_smtp_host` VARCHAR(64) DEFAULT 'smtp.gmail.com',
		`email_smtp_port` SMALLINT UNSIGNED NOT NULL DEFAULT 465,
		`email_use_secure` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`email_smtp_secure` VARCHAR(32) NOT NULL DEFAULT 'SSL',
		`email_smtp_user` VARCHAR(64),
		`email_smtp_pass` VARCHAR(64),
		`paypal_email` VARCHAR(64) DEFAULT 'admin@mistvale.com',
		`site_notice_enable` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_online_list` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_fp_ssotd` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_vote_system` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_vote_online_check` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_news_items` TINYINT UNSIGNED NOT NULL DEFAULT 10,
		`module_news_open` TINYINT UNSIGNED NOT NULL DEFAULT 3,
		`module_char_rename` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_char_rename_pts` TINYINT UNSIGNED NOT NULL DEFAULT 2,
		`module_char_customize` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_char_customize_pts` TINYINT UNSIGNED NOT NULL DEFAULT 5,
		`module_char_faction_change` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_char_faction_change_pts` TINYINT UNSIGNED NOT NULL DEFAULT 15,
		`module_char_race_change` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`module_char_race_change_pts` TINYINT UNSIGNED NOT NULL DEFAULT 10,
		`enable_debugging` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`default_realm_id` TINYINT UNSIGNED NOT NULL DEFAULT 1,
		`db_logon_host` VARCHAR(32) NOT NULL DEFAULT '127.0.0.1',
		`db_logon_port` SMALLINT UNSIGNED NOT NULL DEFAULT 3306,
		`db_logon_name` VARCHAR(32) NOT NULL DEFAULT '',
		`db_logon_user` VARCHAR(64) NOT NULL DEFAULT '',
		`db_logon_pass` VARCHAR(64) NOT NULL DEFAULT ''
		) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci
		");

	$dbAdmin->query("INSERT INTO `".$_POST['mw_db_name']."`.`mw_config` () VALUES ()");

	$dbAdmin->query("CREATE TABLE `".$_POST['mw_db_name']."`.`mw_realm` (
		`realm_id` INT UNSIGNED NOT NULL,
		`site_enabled` TINYINT UNSIGNED NOT NULL DEFAULT 0,
		`db_world_host` VARCHAR(32) DEFAULT '127.0.0.1',
		`db_world_port` SMALLINT UNSIGNED DEFAULT 3306,
		`db_world_name` VARCHAR(32) DEFAULT '',
		`db_world_user` VARCHAR(64) DEFAULT '',
		`db_world_pass` VARCHAR(64) DEFAULT '',
		`db_char_host` VARCHAR(32) DEFAULT '127.0.0.1',
		`db_char_port` SMALLINT UNSIGNED DEFAULT 3306,
		`db_char_name` VARCHAR(32) DEFAULT '',
		`db_char_user` VARCHAR(64) DEFAULT '',
		`db_char_pass` VARCHAR(64) DEFAULT '',
		`ra_type` TINYINT UNSIGNED DEFAULT 0,
		`ra_port` SMALLINT UNSIGNED DEFAULT 3443,
		`ra_user` VARCHAR(64) DEFAULT '',
		`ra_pass` VARCHAR(64) DEFAULT '',
		PRIMARY KEY (`realm_id`)
		) ENGINE=MYISAM CHARSET=utf8 COLLATE=utf8_unicode_ci
		");
	
	// setup permissions for realm user to access new mangosweb database
	$dbAdmin->query("GRANT ALL PRIVILEGES ON `" . $_POST['mw_db_name'] . "` . * to '".$_POST['mw_db_user']."'@'".$_POST['mw_admin_host']."' 
	IDENTIFIED BY '" . $_POST['mw_db_pass'] . "'");

	// migrate the mw_ tables over to new mangosweb database
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_account_extend` RENAME `".$_POST['mw_db_name']."`.`mw_account_extend`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_account_groups` RENAME `".$_POST['mw_db_name']."`.`mw_account_groups`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_account_keys` RENAME `".$_POST['mw_db_name']."`.`mw_account_keys`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_db_version` RENAME `".$_POST['mw_db_name']."`.`mw_db_version`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_donate_packages` RENAME `".$_POST['mw_db_name']."`.`mw_donate_packages`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_donate_transactions` RENAME `".$_POST['mw_db_name']."`.`mw_donate_transactions`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_faq` RENAME `".$_POST['mw_db_name']."`.`mw_faq`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_gallery` RENAME `".$_POST['mw_db_name']."`.`mw_gallery`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_menu_items` RENAME `".$_POST['mw_db_name']."`.`mw_menu_items`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_news` RENAME `".$_POST['mw_db_name']."`.`mw_news`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_online` RENAME `".$_POST['mw_db_name']."`.`mw_online`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_pms` RENAME `".$_POST['mw_db_name']."`.`mw_pms`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_regkeys` RENAME `".$_POST['mw_db_name']."`.`mw_regkeys`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_secret_questions` RENAME `".$_POST['mw_db_name']."`.`mw_secret_questions`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_shop_items` RENAME `".$_POST['mw_db_name']."`.`mw_shop_items`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_vote_sites` RENAME `".$_POST['mw_db_name']."`.`mw_vote_sites`");
	$dbAdmin->query("ALTER TABLE `".$dbconf['db_name']."`.`mw_voting` RENAME `".$_POST['mw_db_name']."`.`mw_voting`");
	
	migrateConfig($dbAdmin);
	migrateRealmlist($dbAdmin);
	$dbAdmin->query("ALTER TABLE `".$_POST['mw_db_name']."`.`mw_db_version` DROP COLUMN `entry`, DROP PRIMARY KEY");
	$dbAdmin->query("INSERT INTO `".$_POST['mw_db_name']."`.`mw_db_version` VALUES ('4.1.0', UNIX_TIMESTAMP())");

?>

	Database successfully updated!!<br /><br />
	Please update your config/config-protected.php.  Change the database name &amp; credentials to the new database.<br /><br />
	<a href="index.php">Go back</a> to check for additional updates.<br />
	
<?php

}