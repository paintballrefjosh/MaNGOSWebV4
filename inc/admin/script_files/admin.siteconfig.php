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

$realms = $RDB->select("SELECT * FROM realmlist ORDER BY `id` ASC");

function saveConfig() 
{
	global $DB, $lang;

	$DB->query("UPDATE `mw_config` SET
		`site_title` = '".$_POST['site_title']."',
		`site_email` = '".$_POST['site_email']."',
		`site_cookie` = '".$_POST['site_cookie']."',
		`site_href` = '".$_POST['site_href']."',
		`site_base_href` = '".$_POST['site_base_href']."',
		`site_armory` = '".$_POST['site_armory']."',
		`site_forums` = '".$_POST['site_forums']."',
		`emulator` = '".$_POST['emulator']."',
		`templates` = '".$_POST['templates']."',
		`default_lang` = '".$_POST['default_lang']."',
		`available_lang` = '".$_POST['available_lang']."',
		`reg_allow` = '".$_POST['reg_allow']."',
		`reg_require_activation` = '".$_POST['reg_require_activation']."',
		`reg_require_invite` = '".$_POST['reg_require_invite']."',
		`reg_require_recaptcha` = '".$_POST['reg_require_recaptcha']."',
		`reg_recaptcha_private_key` = '".$_POST['reg_recaptcha_private_key']."',
		`reg_recaptcha_public_key` = '".$_POST['reg_recaptcha_public_key']."',
		`reg_require_secret_questions` = '".$_POST['reg_require_secret_questions']."',
		`allow_user_pass_change` = '".$_POST['allow_user_pass_change']."',
		`allow_user_email_change` = '".$_POST['allow_user_email_change']."',
		`max_account_per_ip` = '".$_POST['max_account_per_ip']."',
		`default_component` = '".$_POST['default_component']."',
		`flash_display_type` = '".$_POST['flash_display_type']."',
		`fp_vote_banner` = '".$_POST['fp_vote_banner']."',
		`fp_newbie_guide` = '".$_POST['fp_newbie_guide']."',
		`fp_hitcounter` = '".$_POST['fp_hitcounter']."',
		`fp_server_info` = '".$_POST['fp_server_info']."',
		`fp_realm_status` = '".$_POST['fp_realm_status']."',
		`fp_players_online` = '".$_POST['fp_players_online']."',
		`fp_server_ip` = '".$_POST['fp_server_ip']."',
		`fp_server_type` = '".$_POST['fp_server_type']."',
		`fp_server_pop` = '".$_POST['fp_server_pop']."',
		`fp_server_lang` = '".$_POST['fp_server_lang']."',
		`fp_server_act` = '".$_POST['fp_server_act']."',
		`fp_server_active_act` = '".$_POST['fp_server_active_act']."',
		`fp_server_chars` = '".$_POST['fp_server_chars']."',
		`fp_server_more_info` = '".$_POST['fp_server_more_info']."',
		`email_type` = '".$_POST['email_type']."',
		`email_smtp_host` = '".$_POST['email_smtp_host']."',
		`email_smtp_port` = '".$_POST['email_smtp_port']."',
		`email_use_secure` = '".$_POST['email_use_secure']."',
		`email_smtp_secure` = '".$_POST['email_smtp_secure']."',
		`email_smtp_user` = '".$_POST['email_smtp_user']."',
		`email_smtp_pass` = '".$_POST['email_smtp_pass']."',
		`paypal_email` = '".$_POST['paypal_email']."',
		`site_notice_enable` = '".$_POST['site_notice_enable']."',
		`module_online_list` = '".$_POST['module_online_list']."',
		`module_fp_ssotd` = '".$_POST['module_fp_ssotd']."',
		`module_vote_system` = '".$_POST['module_vote_system']."',
		`module_vote_online_check` = '".$_POST['module_vote_online_check']."',
		`module_news_items` = '".$_POST['module_news_items']."',
		`module_news_open` = '".$_POST['module_news_open']."',
		`module_char_rename` = '".$_POST['module_char_rename']."',
		`module_char_rename_pts` = '".$_POST['module_char_rename_pts']."',
		`module_char_customize` = '".$_POST['module_char_customize']."',
		`module_char_customize_pts` = '".$_POST['module_char_customize_pts']."',
		`module_char_faction_change` = '".$_POST['module_char_faction_change']."',
		`module_char_faction_change_pts` = '".$_POST['module_char_faction_change_pts']."',
		`module_char_race_change` = '".$_POST['module_char_race_change']."',
		`module_char_race_change_pts` = '".$_POST['module_char_race_change_pts']."',
		`enable_debugging` = '".$_POST['enable_debugging']."',
		`default_realm_id` = '".$_POST['default_realm_id']."',
		`db_logon_host` = '".$_POST['db_logon_host']."',
		`db_logon_port` = '".$_POST['db_logon_port']."',
		`db_logon_name` = '".$_POST['db_logon_name']."',
		`db_logon_user` = '".$_POST['db_logon_user']."',
		`db_logon_pass` = '".$_POST['db_logon_pass']."'
	");
	
	output_message('success', $lang['config_updated_successfully'].'<meta http-equiv=refresh content="3;url=?p=admin&sub=siteconfig">');
}
?>
