<?php
/****************************************************************************/
/*  						< MangosWeb v4 >  								*/
/*              Copyright (C) <2017> <Mistvale.com>   		                */
/*					  < http://www.mistvale.com >							*/
/*																			*/
/*			Original MangosWeb Enhanced (C) 2010-2011 KeysWow				*/
/*			Original MangosWeb (C) 2007, Sasha, Nafe, TGM, Peec				*/
/****************************************************************************/

?>
<!-- Start #main -->
<div id="main">			
	<div class="content">	
		<div class="content-header">
			<h4><a href="?p=admin">Main Menu</a> / Site Config</h4>
		</div> <!-- .content-header -->				
		<div class="main-content">					
		<?php 
		if(isset($_POST['task'])) 
		{
			if($_POST['task'] == 'saveconfig') 
			{
				saveConfig();
			}
		} ?>
			<div class="mini-nav" style="width: 98%;">
				<table>
					<thead>
						<th  style="background: #FFD;"><center>Sub - Navigation</center></th>
					</thead>
				</table>
				<p>
					<center>
						| <a href="#basic">Basic Settings</a> |
						<a href="#config">Site Configuration</a> |
						<a href="#lang">Language Settings</a> |
						<a href="#acct">Account & Register Settings</a> |
						<a href="#fp">Frontpage Settings</a> |
						<br />
						| <a href="#email">Email Settings</a> |
						<a href="#paypal">Paypal Settings</a> |
						<a href="#module">In-Built Module Settings</a> |
						<a href="#forum">Forum Integration Settings</a> |
					</center>
				</p>
			</div>
			<form method="POST" name="adminform" class="form label-inline">
			<input type="hidden" name="task" value="saveconfig">
	
			<!-- BASIC SITE CONFIG -->
			<table>
				<thead>
					<tr>
						<th><center><a name="basic"></a>Basic Site Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="Title">Site Title: </label>
				<input id="Title" name="site_title" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_title']; ?>" />
				<p class="field_help">Enter your site title here.</p>
			</div>
			
			<div class="field">
				<label for="Email">Site Email: </label>
				<input id="Email" name="site_email" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_email']; ?>" />
				<p class="field_help">Enter your site email here.</p>
			</div>
			
			<div class="field">
				<label for="site_cookie">Site Cookie: </label>
				<input id="site_cookie" name="site_cookie" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_cookie']; ?>" />
				<p class="field_help">Cookie Identifier.</p>
			</div>
			
			<div class="field">
				<label for="site_base_href">Site URL: </label>
				<input id="site_base_href" name="site_base_href" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_base_href']; ?>" />
				<p class="field_help">Full link including "http://" to your website.</p>
			</div>
			
			<div class="field">
				<label for="site_href">Site Directory: </label>
				<input id="site_href" name="site_href" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_href']; ?>" />
				<p class="field_help">Path to your MaNGOS Web install.</p>
			</div>
			
			<div class="field">
				<label for="Armory">Site Armory Link: </label>
				<input id="Armory" name="site_armory" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_armory']; ?>" />
				<p class="field_help">Full link including "http://" to your armory. Set to "0" to disable.</p>
			</div>
			
			<div class="field">
				<label for="Forums">Site Forums Link: </label>
				<input id="Forums" name="site_forums" size="20" type="text" class="medium" value="<?php echo $mwe_config['site_forums']; ?>" />
				<p class="field_help">Full link including "http://" to your forums. Set to "0" to disable.</p>
			</div>
			
			<!-- SITE CONFIG -->
			<table>
				<thead>
					<tr>
						<th><center><a name="config"></a>Site Configuration</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="Emu">Emulator: </label>
				<select id="type" class="small" name="emulator">
					<?php 
						if($mwe_config['emulator'] == 'mangos')
						{ $e_s = 'selected="selected"'; $e_s2 = ''; }else{ $e_s2 = 'selected="selected"'; $e_s = ''; }
					?>
					<option value="mangos" <?php echo $e_s; ?>>Mangos</option>
					<option value="trinity" <?php echo $e_s2; ?>>Trinity</option>
				</select>
			</div>
			
			<div class="field">
				<label for="DR">Default Realm: </label>
				<select id="type" class="medium" name="default_realm_id">
					<?php 
						foreach($realms as $Config_realms)
						{
							if($mwe_config['default_realm_id'] == $Config_realms['id'])
							{ $e_rs = 'selected="selected"'; }else{ $e_rs = ''; }
							echo "<option value=".$Config_realms['id']." ".$e_rs.">".$Config_realms['name']."</option>";
						}
					?>
				</select>
				<p class="field_help">Default selected realm for new users.</p>
			</div>
			
			<div class="field">
				<label for="Templates">Site Templates: </label>
				<input id="Templates" name="templates" size="30" type="text" class="large" value="<?php echo $mwe_config['templates']; ?>" />
				<p class="field_help">Seperate templates with a "," comma. Case sensative on some servers!</p>
			</div>
			
			<div class="field">
				<label for="site_notice_enable">Site Agreement: </label>
				<select id="type" class="small" name="site_notice_enable">
					<?php 
						if($mwe_config['site_notice_enable'] == 1)
						{ $e_sne = 'selected="selected"'; $e_sne2 = ''; }else{ $e_sne2 = 'selected="selected"'; $e_sne = ''; }
					?>
					<option value="1" <?php echo $e_sne; ?>>Enabled</option>
					<option value="0" <?php echo $e_sne2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Require users to accept the agreement before entering site.</p>
			</div>
			<br />
			
			<!-- Realm DB Config -->
			<table>
				<thead>
					<tr>
						<th><center><a name="realm_db"></a>Realm Database Configuration</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="db_logon_host">Database Host: </label>
				<input id="db_logon_host" name="db_logon_host" size="20" type="text" class="medium" value="<?php echo $mwe_config['db_logon_host']; ?>" />
			</div>
			
			<div class="field">
				<label for="db_logon_port">Database Port: </label>
				<input id="db_logon_port" name="db_logon_port" size="20" type="text" class="medium" value="<?php echo $mwe_config['db_logon_port']; ?>" />
			</div>
			
			<div class="field">
				<label for="db_logon_name">Database Name: </label>
				<input id="db_logon_name" name="db_logon_name" size="20" type="text" class="medium" value="<?php echo $mwe_config['db_logon_name']; ?>" />
			</div>
			
			<div class="field">
				<label for="db_logon_user">Database Username: </label>
				<input id="db_logon_user" name="db_logon_user" size="20" type="text" class="medium" value="<?php echo $mwe_config['db_logon_user']; ?>" />
			</div>
			
			<div class="field">
				<label for="db_logon_pass">Database Password: </label>
				<input id="db_logon_pass" name="db_logon_pass" size="20" type="text" class="medium" value="<?php echo $mwe_config['db_logon_pass']; ?>" />
			</div>
			
			<br />
			
			<!-- LANG CONFIG -->
			<table>
				<thead>
					<tr>
						<th><center><a name="lang"></a>Site Language Configuration</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="DL">Default Language: </label>
				<input id="DL" name="default_lang" size="20" type="text" class="medium" value="<?php echo $mwe_config['default_lang']; ?>" />
				<p class="field_help">Website default language</p>
			</div>
			
			<div class="field">
				<label for="AL">Site Languages: </label>
				<input id="AL" name="available_lang" size="20" type="text" class="medium" value="<?php echo $mwe_config['available_lang']; ?>" />
				<p class="field_help">Separate Languages with a "," comma. Case sensitive on some servers!</p>
			</div>
			<br />
			
			<!-- ACCOUNT CONFIG -->
			<table>
				<thead>
					<tr>
						<th><center><a name="acct"></a>Site Registration / Account Configuration</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="reg_allow">Account Registration: </label>
				<select id="type" class="small" name="reg_allow">
					<?php 
						if($mwe_config['reg_allow'] == 1)
						{ $e_ar = 'selected="selected"'; $e_ar2 = ''; }else{ $e_ar2 = 'selected="selected"'; $e_ar = ''; }
					?>
					<option value="1" <?php echo $e_ar; ?>>Enabled</option>
					<option value="0" <?php echo $e_ar2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow guests to register an account on your server.</p>
			</div>
			
			<div class="field">
				<label for="reg_require_activation">Require Account Activation: </label>
				<select id="type" class="small" name="reg_require_activation">
					<?php 
						if($mwe_config['reg_require_activation'] == 1)
						{ $e_arr = 'selected="selected"'; $e_arr2 = ''; }else{ $e_arr2 = 'selected="selected"'; $e_arr = ''; }
					?>
					<option value="1" <?php echo $e_arr; ?>>Enabled</option>
					<option value="0" <?php echo $e_arr2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Requires users to activate there accounts via Email.</p>
			</div>
			
			<div class="field">
				<label for="reg_require_invite">Require Invite: </label>
				<select id="type" class="small" name="reg_require_invite">
					<?php 
						if($mwe_config['reg_require_invite'] == 1)
						{ $e_ari = 'selected="selected"'; $e_ari2 = ''; }else{ $e_ari2 = 'selected="selected"'; $e_ari = ''; }
					?>
					<option value="1" <?php echo $e_ari; ?>>Enabled</option>
					<option value="0" <?php echo $e_ari2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Requires guests to have an invite code before registering an account.</p>
			</div>
			
			<div class="field">
				<label for="reg_require_recaptcha">Registration reCAPTCHA: </label>
				<select id="type" class="small" name="reg_require_recaptcha">
					<?php 
						if($mwe_config['reg_require_recaptcha'] == 1)
						{ $e_ariv = 'selected="selected"'; $e_ariv2 = ''; }else{ $e_ariv2 = 'selected="selected"'; $e_ariv = ''; }
					?>
					<option value="1" <?php echo $e_ariv; ?>>Enabled</option>
					<option value="0" <?php echo $e_ariv2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Enables reCAPTCHA to block bots.</p>
			</div>

			<div class="field">
				<label for="reg_recaptcha_private_key">reCAPTCHA Private Key: </label>
				<input id="reg_recaptcha_private_key" name="reg_recaptcha_private_key" size="25" type="text" class="medium" value="<?php echo $mwe_config['reg_recaptcha_private_key']; ?>" />
				<p class="field_help">Private key obtained from <a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>.</p>
			</div>

			<div class="field">
				<label for="reg_recaptcha_public_key">reCAPTCHA Public Key: </label>
				<input id="reg_recaptcha_public_key" name="reg_recaptcha_public_key" size="25" type="text" class="medium" value="<?php echo $mwe_config['reg_recaptcha_public_key']; ?>" />
				<p class="field_help">Private key obtained from <a href="https://www.google.com/recaptcha/">https://www.google.com/recaptcha/</a>.</p>
			</div>

			<div class="field">
				<label for="reg_require_secret_questions">Require Secret Questions: </label>
				<select id="reg_require_secret_questions" class="small" name="reg_require_secret_questions">
					<?php 
						if($mwe_config['reg_require_secret_questions'] == 1)
						{ $e_arsq = 'selected="selected"'; $e_arsq2 = ''; }else{ $e_arsq2 = 'selected="selected"'; $e_arsq = ''; }
					?>
					<option value="1" <?php echo $e_arsq; ?>>Enabled</option>
					<option value="0" <?php echo $e_arsq2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Requires users to input secret questions / answers when registering account.<br /> 
					Questions are set in the database.
				</p>
			</div>
			
			<div class="field">
				<label for="allow_user_pass_change">Allow Pass Change: </label>
				<select id="allow_user_pass_change" class="small" name="allow_user_pass_change">
					<?php 
						if($mwe_config['allow_user_pass_change'] == 1)
						{ $e_aup = 'selected="selected"'; $e_aup2 = ''; }else{ $e_aup2 = 'selected="selected"'; $e_aup = ''; }
					?>
					<option value="1" <?php echo $e_aup; ?>>Enabled</option>
					<option value="0" <?php echo $e_aup2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to change their passwords</p>
			</div>
			
			<div class="field">
				<label for="allow_user_email_change">Allow Email Change: </label>
				<select id="type" class="small" name="allow_user_email_change">
					<?php 
						if($mwe_config['allow_user_email_change'] == 1)
						{ $e_aec = 'selected="selected"'; $e_aec2 = ''; }else{ $e_aec2 = 'selected="selected"'; $e_aec = ''; }
					?>
					<option value="1" <?php echo $e_aec; ?>>Enabled</option>
					<option value="0" <?php echo $e_aec2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to change their Emails</p>
			</div>
			
			<div class="field">
				<label for="max_account_per_ip">Max Accounts Per IP: </label>
				<input id="max_account_per_ip" name="max_account_per_ip" size="10" type="text" class="tiny" value="<?php echo $mwe_config['max_account_per_ip']; ?>" />
				<p class="field_help">Maximum accounts per IP address. "0" is unlimited.</p>
			</div>
			<br />
			
			<!-- Frontpage Settings -->
			<table>
				<thead>
					<tr>
						<th><center><a name="fp"></a>Frontpage Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			<?php
				output_message('info', 'Some frontpage options will not apply to all templates, especially non-blizzlike templates');
			?>
			<br />
			<div class="field">
				<label for="default_component">Default Component: </label>
				<input id="default_component" name="default_component" size="10" type="text" class="small" value="<?php echo $mwe_config['default_component']; ?>" />
				<p class="field_help">Dont touch this unless you know what you're doing!</p>
			</div>
			
			<div class="field">
				<label for="flash_display_type">Banner Type: </label>
				<select id="type" class="medium" name="flash_display_type">
					<?php 
						if($mwe_config['flash_display_type'] == 0)
							{ $e_fpf = ''; $e_fpf2 = ''; $e_fpf3 = 'selected="selected"'; }
						elseif($mwe_config['flash_display_type'] == 1)
							{ $e_fpf = 'selected="selected"'; $e_fpf2 = ''; $e_fpf3 = ''; }
						elseif($mwe_config['flash_display_type'] == 2)
							{ $e_fpf = ''; $e_fpf2 = 'selected="selected"'; $e_fpf3 = ''; }
					?>
					<option value="2" <?php echo $e_fpf2; ?>>External Flash</option>
					<option value="1" <?php echo $e_fpf; ?>>Internal Flash</option>
					<option value="0" <?php echo $e_fpf3; ?>>Banner</option>
				</select>																											
				<p class="field_help">External Flash is directly played from worldofwarcraft.com. <br />Banner is an image called "banner.jpg in the 
					"templates/< template name >/images/" folder</p>
			</div>
			
			<div class="field">
				<label for="fp_vote_banner">Vote Banner: </label>
				<select id="type" class="small" name="fp_vote_banner">
					<?php 
						if($mwe_config['fp_vote_banner'] == 1)
						{ $e_fpvb = 'selected="selected"'; $e_fpvb2 = ''; }else{ $e_fpvb2 = 'selected="selected"'; $e_fpvb = ''; }
					?>
					<option value="1" <?php echo $e_fpvb; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpvb2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the vote banner on the frontpage.</p>
			</div>
			
			<div class="field">
				<label for="module_fp_ssotd">Screen Of The Day: </label>
				<select id="type" class="small" name="module_fp_ssotd">
					<?php 
						if($mwe_config['module_fp_ssotd'] == 1)
						{ $e_fpsst = 'selected="selected"'; $e_fpsst2 = ''; }else{ $e_fpsst2 = 'selected="selected"'; $e_fpsst = ''; }
					?>
					<option value="1" <?php echo $e_fpsst; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsst2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the screenshot of the moment on the frontpage.</p>
			</div>
			
			<div class="field">
				<label for="fp_newbie_guide">Newbie Guide: </label>
				<select id="type" class="small" name="fp_newbie_guide">
					<?php 
						if($mwe_config['fp_newbie_guide'] == 1)
						{ $e_fpng = 'selected="selected"'; $e_fpng2 = ''; }else{ $e_fpng2 = 'selected="selected"'; $e_fpng = ''; }
					?>
					<option value="1" <?php echo $e_fpng; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpng2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the Newbie Guide on the frontpage.</p>
			</div>
			
			<div class="field">
				<label for="fp_hitcounter">Hit Counter: </label>
				<select id="type" class="small" name="fp_hitcounter">
					<?php 
						if($mwe_config['fp_hitcounter'] == 1)
						{ $e_fphc = 'selected="selected"'; $e_fphc2 = ''; }else{ $e_fphc2 = 'selected="selected"'; $e_fphc = ''; }
					?>
					<option value="1" <?php echo $e_fphc; ?>>Enabled</option>
					<option value="0" <?php echo $e_fphc2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the Hit Counter on the frontpage</p>
			</div>
			
			<div class="field">
				<label for="fp_server_info">Server Info: </label>
				<select id="type" class="small" name="fp_server_info">
					<?php 
						if($mwe_config['fp_server_info'] == 1)
						{ $e_fpsi = 'selected="selected"'; $e_fpsi2 = ''; }else{ $e_fpsi2 = 'selected="selected"'; $e_fpsi = ''; }
					?>
					<option value="1" <?php echo $e_fpsi; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsi2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Info' on the frontpage. Enabling this can/will cause Frontpage to load slower.</p>
			</div>
			
			<div class="field">
				<label for="fp_realm_status">Realm Status: </label>
				<select id="type" class="small" name="fp_realm_status">
					<?php 
						if($mwe_config['fp_realm_status'] == 1)
						{ $e_fpsirs = 'selected="selected"'; $e_fpsirs2 = ''; }else{ $e_fpsirs2 = 'selected="selected"'; $e_fpsirs = ''; }
					?>
					<option value="1" <?php echo $e_fpsirs; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsirs2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Realm Status' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_players_online">Players Online: </label>
				<select id="type" class="small" name="fp_players_online">
					<?php 
						if($mwe_config['fp_players_online'] == 1)
						{ $e_fpsipo = 'selected="selected"'; $e_fpsipo2 = ''; }else{ $e_fpsipo2 = 'selected="selected"'; $e_fpsipo = ''; }
					?>
					<option value="1" <?php echo $e_fpsipo; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsipo2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the '# of Players Online' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_ip">Server IP: </label>
				<select id="type" class="small" name="fp_server_ip">
					<?php 
						if($mwe_config['fp_server_ip'] == 1)
						{ $e_fpsiip = 'selected="selected"'; $e_fpsiip2 = ''; }else{ $e_fpsiip2 = 'selected="selected"'; $e_fpsiip = ''; }
					?>
					<option value="1" <?php echo $e_fpsiip; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsiip2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the '# of Players Online' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_type">Server Type: </label>
				<select id="type" class="small" name="fp_server_type">
					<?php 
						if($mwe_config['fp_server_type'] == 1)
						{ $e_fpsist = 'selected="selected"'; $e_fpsist2 = ''; }else{ $e_fpsist2 = 'selected="selected"'; $e_fpsist = ''; }
					?>
					<option value="1" <?php echo $e_fpsist; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsist2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Type' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_lang">Server Language: </label>
				<select id="type" class="small" name="fp_server_lang">
					<?php 
						if($mwe_config['fp_server_lang'] == 1)
						{ $e_fpsisl = 'selected="selected"'; $e_fpsisl2 = ''; }else{ $e_fpsisl2 = 'selected="selected"'; $e_fpsisl = ''; }
					?>
					<option value="1" <?php echo $e_fpsisl; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsisl2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Language' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_pop">Server Population: </label>
				<select id="type" class="small" name="fp_server_pop">
					<?php 
						if($mwe_config['fp_server_pop'] == 1)
						{ $e_fpsipop = 'selected="selected"'; $e_fpsipop2 = ''; }else{ $e_fpsipop2 = 'selected="selected"'; $e_fpsipop = ''; }
					?>
					<option value="1" <?php echo $e_fpsipop; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsipop2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Population' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_act">Server Accounts: </label>
				<select id="type" class="small" name="fp_server_act">
					<?php 
						if($mwe_config['fp_server_act'] == 1)
						{ $e_fpsiat = 'selected="selected"'; $e_fpsiat2 = ''; }else{ $e_fpsiat2 = 'selected="selected"'; $e_fpsiat = ''; }
					?>
					<option value="1" <?php echo $e_fpsiat; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsiat2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Accounts' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_active_act">Active Accounts: </label>
				<select id="type" class="small" name="fp_server_active_act">
					<?php 
						if($mwe_config['fp_server_active_act'] == 1)
						{ $e_fpsiact = 'selected="selected"'; $e_fpsiact2 = ''; }else{ $e_fpsiact2 = 'selected="selected"'; $e_fpsiact = ''; }
					?>
					<option value="1" <?php echo $e_fpsiact; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsiact2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Active Accounts' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_chars">Server Characters: </label>
				<select id="type" class="small" name="fp_server_chars">
					<?php 
						if($mwe_config['fp_server_chars'] == 1)
						{ $e_fpsic = 'selected="selected"'; $e_fpsic2 = ''; }else{ $e_fpsic2 = 'selected="selected"'; $e_fpsic = ''; }
					?>
					<option value="1" <?php echo $e_fpsic; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsic2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'Server Characters' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			
			<div class="field">
				<label for="fp_server_more_info">Server More Info: </label>
				<select id="type" class="small" name="fp_server_more_info">
					<?php 
						if($mwe_config['fp_server_more_info'] == 1)
						{ $e_fpsimi = 'selected="selected"'; $e_fpsimi2 = ''; }else{ $e_fpsimi2 = 'selected="selected"'; $e_fpsimi = ''; }
					?>
					<option value="1" <?php echo $e_fpsimi; ?>>Enabled</option>
					<option value="0" <?php echo $e_fpsimi2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Displays the 'More Info' under Server Info. FP Server Info must be Enabled!</p>
			</div>
			<br />
			
			<!-- Email Settings -->
			<table>
				<thead>
					<tr>
						<th><center><a name="email"></a>Email Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="email_type">Mail Relay: </label>
				<select id="type" class="small" name="email_type">
					<?php 
						if($mwe_config['email_type'] == 0)
							{ $e_et = ''; $e_et2 = ''; $e_et3 = 'selected="selected"'; }
						elseif($mwe_config['email_type'] == 1)
							{ $e_et = 'selected="selected"'; $e_et2 = ''; $e_et3 = ''; }
						elseif($mwe_config['email_type'] == 2)
							{ $e_et = ''; $e_et2 = 'selected="selected"'; $e_et3 = ''; }
					?>

					<option value="0" <?php echo $e_et3; ?>>SMTP</option>
				</select>																											
				<p class="field_help">&nbps;</p>
			</div>
			
			<div class="field">
				<label for="email_smtp_host">SMTP Host: </label>
				<input id="email_smtp_host" name="email_smtp_host" size="10" type="text" class="medium" value="<?php echo $mwe_config['email_smtp_host']; ?>" />
				<p class="field_help">SMTP host. e.g. "smtp.gmail.com"</p>
			</div>
			
			<div class="field">
				<label for="email_smtp_port">SMTP Port: </label>
				<input id="email_smtp_port" name="email_smtp_port" size="10" type="text" class="xsmall" value="<?php echo $mwe_config['email_smtp_port']; ?>" />
				<p class="field_help">SMTP port.</p>
			</div>
			
			<div class="field">
				<label for="email_use_secure">Enable Encryption: </label>
				<select id="type" class="xsmall" name="email_use_secure">
					<?php 
						if($mwe_config['email_use_secure'] == 1)
						{ $e_eus = 'selected="selected"'; $e_eus2 = ''; }else{ $e_eus2 = 'selected="selected"'; $e_eus = ''; }
					?>
					<option value="1" <?php echo $e_eus; ?>>Yes</option>
					<option value="0" <?php echo $e_eus2; ?>>No</option>
				</select>																											
				<p class="field_help">Enable SNMP encryption.</p>
			</div>
			
			<div class="field">
				<label for="email_smtp_secure">Encryption Method: </label>
				<select id="type" class="xsmall" name="email_smtp_secure">
					<?php 
						if($mwe_config['email_smtp_secure'] == 'ssl')
						{ $e_est = 'selected="selected"'; $e_est2 = ''; }else{ $e_est2 = 'selected="selected"'; $e_est = ''; }
					?>
					<option value="ssl" <?php echo $e_est; ?>>SSL</option>
					<option value="tls" <?php echo $e_est2; ?>>TLS</option>
				</select>																											
				<p class="field_help">SMTP Encryption Method.</p>
			</div>
			
			<div class="field">
				<label for="email_smtp_user">SMTP Username: </label>
				<input id="email_smtp_user" name="email_smtp_user" size="10" type="text" class="medium" value="<?php echo $mwe_config['email_smtp_user']; ?>" />
				<p class="field_help">SMTP Username.</p>
			</div>
			
			<div class="field">
				<label for="email_smtp_pass">SMTP Password: </label>
				<input id="email_smtp_pass" name="email_smtp_pass" size="10" type="password" class="medium" value="<?php echo $mwe_config['email_smtp_pass']; ?>" />
				<p class="field_help">SMTP Password.</p>
			</div>
			<br />
			
			<!-- Paypal Settings -->
			<table>
				<thead>
					<tr>
						<th><center><a name="paypal"></a>Paypal Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="Paypal Email">Site Paypal Email: </label>
				<input id="Paypal Email" name="paypal_email" size="20" type="text" class="medium" value="<?php echo $mwe_config['paypal_email']; ?>" />
				<p class="field_help">Enter your Paypal email here.</p>
			</div>
			
			<br />
			<!-- In Built Module Settings -->
			<table>
				<thead>
					<tr>
						<th><center><a name="module"></a>In Built Module Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="module_news_items"># News Displayed: </label>
				<input id="module_news_items" name="module_news_items" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_news_items']; ?>" />
				<p class="field_help">Number of news entries to display on the front page.</p>
			</div>
			
			<div class="field">
				<label for="module_news_open"># News Open: </label>
				<input id="module_news_open" name="module_news_open" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_news_open']; ?>" />
				<p class="field_help">Number of news entries open on the front page.</p>
			</div>
			
			<div class="field">
				<label for="module_vote_system">Vote System: </label>
				<select id="type" class="small" name="module_vote_system">
					<?php 
						if($mwe_config['module_vote_system'] == 1)
						{ $e_mvs = 'selected="selected"'; $e_mvs2 = ''; }else{ $e_mvs2 = 'selected="selected"'; $e_mvs = ''; }
					?>
					<option value="1" <?php echo $e_mvs; ?>>Enabled</option>
					<option value="0" <?php echo $e_mvs2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Enable the vote system?</p>
			</div>
			
			<div class="field">
				<label for="module_vote_online_check">Vote Online Check: </label>
				<select id="type" class="small" name="module_vote_online_check">
					<?php 
						if($mwe_config['module_vote_online_check'] == 1)
						{ $e_mvsc = 'selected="selected"'; $e_mvsc2 = ''; }else{ $e_mvsc2 = 'selected="selected"'; $e_mvsc = ''; }
					?>
					<option value="1" <?php echo $e_mvsc; ?>>Enabled</option>
					<option value="0" <?php echo $e_mvsc2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Enable Site online check? Prevents users from getting points when the site is offline<br />
				But... can slow the page load time of the Vote page.</p>
			</div>
			
			<div class="field">
				<label for="module_online_list">Users Online List: </label>
				<select id="type" class="small" name="module_online_list">
					<?php 
						if($mwe_config['module_online_list'] == 1)
						{ $e_mol = 'selected="selected"'; $e_mol2 = ''; }else{ $e_mol2 = 'selected="selected"'; $e_mol = ''; }
					?>
					<option value="1" <?php echo $e_mol; ?>>Enabled</option>
					<option value="0" <?php echo $e_mol2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Enable the users online list? (?p=whoisonline)</p>
			</div>
			
			<div class="field">
				<label for="module_char_rename">Character Rename: </label>
				<select id="type" class="small" name="module_char_rename">
					<?php 
						if($mwe_config['module_char_rename'] == 1)
						{ $e_mcr = 'selected="selected"'; $e_mcr2 = ''; }else{ $e_mcr2 = 'selected="selected"'; $e_mcr = ''; }
					?>
					<option value="1" <?php echo $e_mcr; ?>>Enabled</option>
					<option value="0" <?php echo $e_mcr2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to rename their characters?.</p>
			</div>
			
			<div class="field">
				<label for="rename points">Char-Rename Cost: </label>
				<input id="rename points" name="module_char_rename_pts" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_char_rename_pts']; ?>" />
				<p class="field_help">Cost in Web Points for users to rename their Characters</p>
			</div>
			
			<div class="field">
				<label for="module_char_customize">Re-Customize: </label>
				<select id="type" class="small" name="module_char_customize">
					<?php 
						if($mwe_config['module_char_customize'] == 1)
						{ $e_mcrc = 'selected="selected"'; $e_mcrc2 = ''; }else{ $e_mcrc2 = 'selected="selected"'; $e_mcrc = ''; }
					?>
					<option value="1" <?php echo $e_mcrc; ?>>Enabled</option>
					<option value="0" <?php echo $e_mcrc2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to Re-Customize their characters?.</p>
			</div>
			
			<div class="field">
				<label for="rename points">Re-Customize Cost: </label>
				<input id="rename points" name="module_char_customize_pts" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_char_customize_pts']; ?>" />
				<p class="field_help">Cost in Web Points for users to Re-Customize their Characters</p>
			</div>
			
			<div class="field">
				<label for="module_char_faction_change">Char Faction Change: </label>
				<select id="type" class="small" name="module_char_faction_change">
					<?php 
						if($mwe_config['module_char_faction_change'] == 1)
						{ $e_mcf = 'selected="selected"'; $e_mcf2 = ''; }else{ $e_mcf2 = 'selected="selected"'; $e_mcf = ''; }
					?>
					<option value="1" <?php echo $e_mcf; ?>>Enabled</option>
					<option value="0" <?php echo $e_mcf2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to change factions of their characters?.</p>
			</div>
			
			<div class="field">
				<label for="rename points">Faction Change Cost: </label>
				<input id="rename points" name="module_char_faction_change_pts" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_char_faction_change_pts']; ?>" />
				<p class="field_help">Cost in Web Points for users to change factions of their characters</p>
			</div>
			
			<div class="field">
				<label for="module_char_race_change">Char. Race Change: </label>
				<select id="type" class="small" name="module_char_race_change">
					<?php 
						if($mwe_config['module_char_race_change'] == 1)
						{ $e_mrc = 'selected="selected"'; $e_mrc2 = ''; }else{ $e_mrc2 = 'selected="selected"'; $e_mrc = ''; }
					?>
					<option value="1" <?php echo $e_mrc; ?>>Enabled</option>
					<option value="0" <?php echo $e_mrc2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Allow users to change the race of their characters?.</p>
			</div>
			
			<div class="field">
				<label for="rename points">Race Change Cost: </label>
				<input id="rename points" name="module_char_race_change_pts" size="2" type="text" class="xsmall" value="<?php echo $mwe_config['module_char_race_change_pts']; ?>" />
				<p class="field_help">Cost in Web Points for users to change the race of their characters</p>
			</div>
			
			<br />			

			<table>
				<thead>
					<tr>
						<th><center><a name="debug"></a>Debug Settings</center></th>
					</tr>
				</thead>
			</table>
			<br />
			
			<div class="field">
				<label for="enable_debugging">Site Debugging: </label>
				<select id="enable_debugging" class="small" name="enable_debugging">
					<?php 
						if($mwe_config['enable_debugging'] == 1)
						{ $e_mrc = 'selected="selected"'; $e_mrc2 = ''; }else{ $e_mrc2 = 'selected="selected"'; $e_mrc = ''; }
					?>
					<option value="1" <?php echo $e_mrc; ?>>Enabled</option>
					<option value="0" <?php echo $e_mrc2; ?>>Disabled</option>
				</select>																											
				<p class="field_help">Enable debugg messages.</p>
			</div>
			

			<div class="buttonrow-border">								
				<center><button><span>Update Config</span></button></center>			
			</div>
			</form>
		</div> <!-- .main-content -->	
	</div> <!-- .content -->		
</div> <!-- #main -->