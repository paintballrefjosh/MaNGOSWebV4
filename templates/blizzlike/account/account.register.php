<br />
<style media="screen" title="currentStyle" type="text/css">
p.nm, p.wm { 
	margin: 0.5em 0 0.5em 0; 
	padding: 3px;
}
		
p.nm { 
	background-color: #FEF5DA; 
	border-right: 1px solid #D0CBAF;
	border-bottom: 1px solid #D0CBAF; 
	color: #605033;
}

p.wm { 
	background-color: #FBD8D7; 
	border-right: 1px solid #DCBFB4;
	border-bottom: 1px solid #DCBFB4; 
	color: #6A0D0B;
}

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
if ((int)$mwe_config['reg_allow'] == 0)
{
    output_message('error', 'Registration: Locked');
}
else
{
	if($mwe_config['reg_require_invite'] == 1 && (!isset($_GET['r_key']) || !$Account->isValidRegkey($_GET['r_key'])))
	{
		// require invite / registration code to create an account
		if(isset($_GET['r_key']) && !$Account->isValidRegkey($_GET['r_key']))
		{
			output_message('validation', $lang['bad_register_key']);
		}

		build_CommBox_Header();
?>
		<div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
			<b><?php echo $lang['register_key'];?>:</b> 
			<input type="text" id="r_key" <?php if(isset($_GET['r_key'])) echo 'value="'.htmlspecialchars($_GET['r_key']).'"';?> size="45" maxlength="50" />
		</div>
		<div style="background:none;margin:4px;padding:6px 9px 0px 9px;text-align:center;">
			<a href="" onclick="this.href='?p=account&amp;sub=register&amp;r_key='+document.getElementById('r_key').value">
				<img src='<?php echo $Template['path']; ?>/images/buttons/continue-button.gif' />
			</a>
		</div>
<?php
		build_CommBox_Footer();
	}
	elseif(!isset($_GET['accept']) && !isset($_POST['r_login']))
	{
		// display the terms / conditions accept page
		build_CommBox_Header();
?>
		<div style="margin:4px;padding:6px 9px 6px 9px;text-align:left;">
			<h2 style="margin:2px;"> <?php echo $lang['rules_agreement'] ?> </h2>
			<div style="color: red"><?php echo $lang['warn_email'] ?></div>
			<br/>
			<?php include("lang/".$GLOBALS['user_cur_lang']."/rules.html"); ?>
		</div>
		<div style="margin:4px;padding:6px 9px 0px 9px;text-align:center;">
			<a href="<?= $_SERVER['REQUEST_URI'];?>&amp;accept=true"><img src="<?php echo $Template['path']; ?>/images/buttons/agree-button.gif" /></a>
		</div>
<?php
		build_CommBox_Footer();
	}

	if(isset($_GET['accept']))
	{
		if(isset($_POST['r_login']))
		{
			$reg_result = Register();
		}

		if(isset($reg_result) && $reg_result)
		{
			if((int)$mwe_config['reg_require_activation'] == 1)
			{
				output_message('success', $lang['activation_email_sent']);
			}
			else
			{
				output_message('success', $lang['register_success'].'<meta http-equiv=refresh content="5;url=?p=account&sub=login">');
			}
		}
		else
		{
			if(isset($_POST['r_login']))
			{
				if(!$err_array[0])
				{
					$err_array[0] = "Unknown Reason";
				}
				$output_error = $lang['register_failed'];
				$output_error .= "<ul><li>";
				$output_error .= implode("</li><li>", $err_array);
				$output_error .= "</li></ul>";
				output_message('error', $output_error);
			}

			build_CommBox_Header();
?>
	<div style="padding-left:8px; padding-right: 14px">
		<form method="post" name="regform" id="regform">
			<label for="r_login"><?php echo $lang['username'];?>:</label>
			<input type="text" id="r_login" name="r_login" size="40" maxlength="16" <?php if(isset($_POST['r_login'])) echo 'value="'.htmlspecialchars($_POST['r_login']).'"';?> />
			<p id="t_login" style="display:none;" class="wm"></p>

			<label for="r_pass"><?php echo $lang['password'];?>:</label>
			<input type="password" id="r_pass" name="r_pass" size="40" maxlength="16" />
			<p id="t_pass" style="display:none;" class="wm"></p>

			<label for="r_cpass"><?php echo $lang['confirm_password'];?>:</label>
			<input type="password" id="r_cpass" name="r_cpass" size="40" maxlength="16" />
			<p id="t_cpass" style="display:none;" class="wm"></p>

			<label for="r_email"><?php echo $lang['email'];?>:</label>
			<input type="text" id="r_email" name="r_email" size="40" maxlength="50" <?php if(isset($_POST['r_email'])) echo 'value="'.htmlspecialchars($_POST['r_email']).'"';?> />
			<p id="t_email" style="display:none;" class="wm"></p>
<?php 
			if ($mwe_config['reg_require_secret_questions'] == 1)
			{
?>
				<label for="secretq1"><?= $lang['secretq']; ?> 1:</label>
				Q: <select id="secretq1" name="secretq1">
					<option value="0">None</option>
<?php 
				foreach ($secret_questions as $question)
				{
?>
					<option value="<?= htmlspecialchars($question['question']); ?>"><?= $question['question']; ?></option>
<?php
				}
?>
				</select><br />
				A: <input type="text" id="secreta1" name="secreta1" size="40" maxlength="50" <?php if(isset($_POST['secreta1'])) echo 'value="'.htmlspecialchars($_POST['secreta1']).'"';?> />

				<label for="secretq2"><?php echo $lang['secretq']; ?> 2:</label>
				Q: <select id="secretq2" name="secretq2">
					<option value="0">None</option>
<?php 
				foreach ($secret_questions as $question)
				{
?>
					<option value="<?= htmlspecialchars($question['question']); ?>"><?= $question['question']; ?></option>
<?php
				}
?>
				</select><br />
				A: <input type="text" id="secreta2" name="secreta2" size="40" maxlength="50" <?php if(isset($_POST['secreta2'])) echo 'value="'.htmlspecialchars($_POST['secreta2']).'"';?> />
<?php 
			}
?>
			<label for="r_account_type"><?php echo $lang['select_expansion']; ?>:</label>
			<select id="r_account_type" name="r_account_type">
				<option selected="selected" value="2"><?php echo $lang['wrath'];?></option>
				<option value="1"><?php echo $lang['burning_crusade'];?></option>
				<option value="0"><?php echo $lang['classic'];?></option>
			</select><br /><br />
<?php
			if ((int)$mwe_config['reg_require_recaptcha'] == 1)
			{
?>
			<div class="g-recaptcha" data-sitekey="<?php echo $mwe_config['reg_recaptcha_public_key'];?>"></div>
<?php 	
			}
?>
			<br />
			<center>
				<input type='image' class="button" src='<?php echo $Template['path']; ?>/images/buttons/createaccount-button2.gif' />
			</center>
		</form>
	</div>
<?php	
			build_CommBox_Footer();
		}
	}
}

builddiv_end();

?>