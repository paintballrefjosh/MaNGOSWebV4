<br />
<style media="screen" title="currentStyle" type="text/css">
p.nm, p.wm { 
		margin: 0.5em 0 0.5em 0; 
		padding: 3px; }
		
	p.nm { 
		background-color: #FEF5DA; 
		border-right: 1px solid #D0CBAF;
		border-bottom: 1px solid #D0CBAF; 
		color: #605033; }
	
	p.wm { 
		background-color: #FBD8D7; 
		border-right: 1px solid #DCBFB4;
		border-bottom: 1px solid #DCBFB4; 
		color: #6A0D0B; }
#regform label {
	display: block;
	margin-top: 1em;
	font-weight: bold;
}
p.nm, p.wm { 
	margin: 0px;
	margin-top: 3px;
}
</style>
<?php
builddiv_start(0, $lang['registration']);
if ((int)$Config->get('allow_registration') == 0)
{
    output_message('error', 'Registration: Locked');
}
else
{
	if(isset($_POST['step']) && $_POST['step'] == 3 && $allow_reg == TRUE)
	{
		Register();
	}
	elseif(isset($_POST['step']) && $_POST['step'] == 2 && $allow_reg == TRUE)
	{
		build_CommBox_Header();
?>
		<div style="padding-left:8px; padding-right: 14px">
			<form method="post" action="?p=account&amp;sub=register" name="regform" id="regform">
				<input type="hidden" name="r_key" value="<?php echo $_POST['r_key'];?>"/>
				<input type="hidden" name="step" value="3"/>
				
				<label for="r_login"><?php echo $lang['username'];?>:</label>
				<input type="text" id="r_login" name="r_login" size="40" maxlength="16"/>
				<p id="t_login" style="display:none;" class="wm"></p>

				<label for="r_pass"><?php echo $lang['password'];?>:</label>
				<input type="password" id="r_pass" name="r_pass" size="40" maxlength="16"/>
				<p id="t_pass" style="display:none;" class="wm"></p>

				<label for="r_cpass"><?php echo $lang['confirm_password'];?>:</label>
				<input type="password" id="r_cpass" name="r_cpass" size="40" maxlength="16"/>
				<p id="t_cpass" style="display:none;" class="wm"></p>

				<label for="r_email"><?php echo $lang['email'];?>:</label>
				<input type="text" id="r_email" name="r_email" size="40" maxlength="50"/>
				<p id="t_email" style="display:none;" class="wm"></p>

			<?php 
				if ((int)$Config->get('reg_secret_questions') == 0)
				{ ?>

					<label for="secretq1"><?php echo $lang['secretq']; ?> 1:</label>
					Q: <select id="secretq1" name="secretq1">
					<option value="Disabled">Disabled</option>
			<?php 
					foreach ($secret_questions as $question)
					{?>
						<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
			<?php 	} ?>
					</select><br />
					A: <input type="hidden" id="secreta1" name="secreta1" size="40" maxlength="50"/>

					<label for="secretq2"><?php echo $lang['secretq']; ?> 2:</label>
					Q: <select id="secretq2" name="secretq2">
						<option value="Disabled">Disable</option>
			<?php 
					foreach ($secret_questions as $question)
					{ ?>
						<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
			<?php 	} ?>
					</select><br />
					A: <input type="hidden" id="secreta2" name="secreta2" size="40" maxlength="50"/>
	
			<?php 	
				} ?>

			<?php 
				if ($Config->get('reg_secret_questions') == 1)
				{ ?>
					<label for="secretq1"><?php echo $lang['secretq']; ?> 1:</label>
					Q: <select id="secretq1" name="secretq1">
						<option value="0">None</option>
			<?php 
					foreach ($secret_questions as $question)
					{ ?>
						<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
			<?php   } ?>
					</select><br />
					A: <input type="text" id="secreta1" name="secreta1" size="40" maxlength="50"/>

					<label for="secretq2"><?php echo $lang['secretq']; ?> 2:</label>
					Q: <select id="secretq2" name="secretq2">
						<option value="0">None</option>
			<?php 
					foreach ($secret_questions as $question)
					{ ?>
						<option value="<?php echo htmlspecialchars($question['question']); ?>"><?php echo $question['question']; ?></option>
			<?php 	} ?>
					</select><br />
					A: <input type="text" id="secreta2" name="secreta2" size="40" maxlength="50"/>
			<?php 
				} ?>

				<label for="r_account_type"><?php echo $lang['select_expansion']; ?>:</label>
				<select id="r_account_type" name="r_account_type">
					<option selected="selected" value="2"><?php echo $lang['wrath'];?></option>
					<option value="1"><?php echo $lang['burning_crusade'];?></option>
					<option value="0"><?php echo $lang['classic'];?></option>
				</select><br /><br />

			<?php
				if ((int)$Config->get('reg_act_imgvar') == 1)
				{        
					// Initialize random image:
					$captcha = new Captcha;
					$captcha->load_ttf();
					$captcha->make_captcha();
					$captcha->delold();
					$filename = $captcha->filename;
					$privkey = $captcha->privkey;
					$DB->query("INSERT INTO `mw_acc_creation_captcha`(`filename`, `key`) VALUES('$filename','$privkey')");
			?>
					<img src="<?php echo $filename; ?>" alt=""/><br />
					<input type="hidden" name="filename_image" value="<?php echo $filename; ?>"/>
					<b>Type letters above (6 characters)</b>
					<br />
					<input type="text" name="image_key"/><br />
			<?php 	
				} ?>
	
				<br />
				<center>
					<input type='image' class="button" src='<?php echo $Template['path']; ?>/images/buttons/createaccount-button2.gif' />
				</center>
			</form>
		</div>
	<?php	
		build_CommBox_Footer();
	}
	
	// Else if step is empty (1), and require invite is disabled
	elseif(empty($_POST['step']) && $Config->get('reg_invite') == 0 && $allow_reg == TRUE)
	{
		build_CommBox_Header();
?>
		<form method="post" action="?p=account&amp;sub=register">
			<input type="hidden" name="step" value="2"/>
			<input type="hidden" name="r_key" value="0"/>
			<div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
				<h2 style="margin:2px;"> <?php echo $lang['rules_agreement'] ?> </h2>
				<div style="color: red"><?php echo $lang['warn_email'] ?></div>
				<br/>
				<?php include("lang/".$GLOBALS['user_cur_lang']."/rules.html"); ?>
			</div>
			<div style="margin:4px;padding:6px 9px 0px 9px;text-align:center;">
				<input type='image' class="button" src="<?php echo $Template['path']; ?>/images/buttons/disagree-button.gif" name="disagree" value="1" />
				<input type='image' class="button" src='<?php echo $Template['path']; ?>/images/buttons/agree-button.gif' />
			</div>
		</form>
<?php
		build_CommBox_Footer();
	}
	
	// Else if step is 1, and require invite is enabled
	elseif(isset($_POST['step']) && $_POST['step'] == 1 && $Config->get('reg_invite') == 1)
	{
		if($Account->isValidRegkey($_POST['r_key']) !== TRUE)
		{
			output_message('validation', $lang['bad_register_key']);
			$allow_reg = FALSE;
		}
		else
		{
			build_CommBox_Header();
?>
			<form method="post" action="?p=account&amp;sub=register">
				<input type="hidden" name="step" value="2"/>
				<input type="hidden" name="r_key" value="<?php echo $_POST['r_key'];?>"/>
				<div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
					<h2 style="margin:2px;"> <?php echo $lang['rules_agreement'] ?> </h2>
					<div style="color: red"><?php echo $lang['warn_email'] ?></div>
					<br/>
					<?php include("lang/".$GLOBALS['user_cur_lang']."/rules.html"); ?>
				</div>
				<div style="margin:4px;padding:6px 9px 0px 9px;text-align:center;">
					<input type='image' class="button" src="<?php echo $Template['path']; ?>/images/buttons/disagree-button.gif" name="disagree" value="1" />
					<input type='image' class="button" src='<?php echo $Template['path']; ?>/images/buttons/agree-button.gif' />
				</div>
			</form>
			
<?php		build_CommBox_Footer();
		}
	}
	
	// Else if step is empty, and require invite is enabled, user must enter the Invite Key
	elseif(empty($_POST['step']) && $Config->get('reg_invite') == 1 && $allow_reg === TRUE)
	{
		build_CommBox_Header();
?>
		<form method="post" action="\?p=account&amp;sub=register">
			<input type="hidden" name="step" value="1"/>
			<div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
				<b><?php echo $lang['register_key'];?>:</b> 
				<input type="text" name="r_key" size="45" maxlength="50"/>
			</div>
			<div style="background:none;margin:4px;padding:6px 9px 0px 9px;text-align:left;">
				<input type="submit" class="button" value="Next"/>
			</div>
		</form>
<?php
		build_CommBox_Footer();
	}
}
builddiv_end();
?>