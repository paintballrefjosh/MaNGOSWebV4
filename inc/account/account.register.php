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
if(INCLUDED !== TRUE) 
{
	echo "Not Included!"; 
	exit;
}
$pathway_info[] = array('title' => $lang['register'], 'link' => '');
// ==================== //

// Include the captcha class
include('core/lib/class.captcha.php');

//	************************************************************
// Define minimum and max lengths for password and login

$regparams = array(
	'MIN_LOGIN_L' => 3,
	'MAX_LOGIN_L' => 16,
	'MIN_PASS_L'  => 4,
	'MAX_PASS_L'  => 16
	);
	
//	************************************************************
// Logged in users cannot access this page ;)

if($Account->isLoggedIn() == TRUE)
{
	redirect('?p=account&sub=manage',1);
}

// If ther user disagrees with the terms of service, redirect him
if(isset($_POST['disagree']))
{
	redirect('index.php',1);
}	

// Load Secret Questions
$secret_questions = $DB->select("SELECT * FROM mw_secret_questions");

// Define that users can register (for error reporting)
$allow_reg = TRUE;

// Init the error array
$err_array = array();

//	************************************************************
// If users are limited to how many accounts per IP, we find out how many this IP has.

if($mwe_config['max_act_per_ip') > 0)
{
	$count_ip = $DB->count("SELECT account_id FROM mw_account_extend WHERE registration_ip='".$_SERVER['REMOTE_ADDR']."'");
	if($count_ip >= (int)$mwe_config['max_act_per_ip'))
	{
		$allow_reg = FALSE;
		$err_array[] = $lang['register_acct_limit'];
	}
}

//	************************************************************
// When finished registering, this is the function

function Register()
{
	global $DB, $mwe_config, $allow_reg, $err_array, $Account, $lang;
	
	// Check to see if we still are allowed to register
	if($allow_reg == TRUE)
	{
		// Inizialize variable, we use this after. Use this to add extensions.
		$notreturn = FALSE;

		// Extensions
		// Each extention you see down-under will check for specific user input,
		// In this step we set "requirements" for what user may input.

		// Ext 1 - Image verification
		// We need to see if its enabled, and if the user put in the right code
		if($mwe_config['reg_use_recpatcha'] == 1)
		{
			$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$mwe_config['reg_recaptcha_private_key']."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			
			if($response['success'] != true)
			{
				$notreturn = TRUE;
				$err_array[] = $lang['image_var_incorrect'];
			}
		}

		// Ext 2 - secret questions
		// Check if user questions are required, if so we need to check for symbols, and character lenght
		if ($mwe_config['reg_secret_questions'] == 1)
		{
			if ($_POST['secretq1'] && $_POST['secretq2'] && $_POST['secreta1'] && $_POST['secreta2']) 
			{
				if(check_for_symbols($_POST['secreta1']) || check_for_symbols($_POST['secreta2']))
				{
					$notreturn = TRUE;
					$err_array[] = $lang['secretq_error_symbols'];
				}
				if($_POST['secretq1'] == $_POST['secretq2']) 
				{
					$notreturn = TRUE;
					$err_array[] = $lang['secretq_error_same'];
				}
				if($_POST['secreta1'] == $_POST['secreta2']) 
				{
					$notreturn = TRUE;
					$err_array[] = $lang['secretq_error_same'];
				}
				if(strlen($_POST['secreta1']) < 4 || strlen($_POST['secreta2']) < 4) 
				{
					$notreturn = TRUE;
					$err_array[] = $lang['secretq_error_short'];
				}
			}
			else 
			{
				$notreturn = TRUE;
				$err_array[] = $lang['secretq_error_empty'];
			}
		}
		
		// Ext 3 - make sure the username isnt already in use
		if($Account->isAvailableUsername($_POST['r_login']) == FALSE)
		{
			$notreturn = TRUE;
			$err_array[] = $lang['username_taken'];
		}

		// Ext 4 - make sure password is not username
		if($_POST['r_login'] == $_POST['r_pass']) 
		{
			$notreturn = TRUE;
			$err_array[] = $lang['user_pass_same'];
		}

		// Main add into the database
		if ($notreturn == FALSE)
		{
			// @$Enter is the main input arrays into the SDL
			$Enter = $Account->register(
				array(
					'username' => strtoupper($_POST['r_login']),
					'sha_pass_hash' => $Account->sha_password($_POST['r_login'],$_POST['r_pass']),
					'sha_pass_hash2' => $Account->sha_password($_POST['r_login'],$_POST['r_cpass']),
					'email' => $_POST['r_email'],
					'expansion' => $_POST['r_account_type'],
					'password' => $_POST['r_pass']
				), 
				array(
					'secretq1'=> strip_if_magic_quotes($_POST['secretq1']),
					'secreta1' => strip_if_magic_quotes($_POST['secreta1']),
					'secretq2' => strip_if_magic_quotes($_POST['secretq2']), 
					'secreta2' => strip_if_magic_quotes($_POST['secreta2'])
				)
			);
			
			// lets catch the return on the register function
			if($Enter == 1) # 1 = success
			{
				if($mwe_config['reg_invite'] == 1)
				{
					$Account->delete_key($_POST['r_key']);
				}
				$reg_succ = TRUE;
			}
			elseif($Enter == 0) # All params are emtpy
			{
				$reg_succ = FALSE;
				$err_array[] = $lang['some_params_empty'];
			}
			elseif($Enter == 2) # empty username
			{
				$reg_succ = FALSE;
				$err_array[] = $lang['empty_param_username'];
			}
			elseif($Enter == 3) # passwords dont match
			{
				$reg_succ = FALSE;
				$err_array[] = $lang['passwords_dont_match'];
			}
			elseif($Enter == 4) # empty email
			{
				$reg_succ = FALSE;
				$err_array[] = $lang['empty_param_email'];
			}
			elseif($Enter == 5) # IP Banned
			{
				$reg_succ = FALSE;
				$err_array[] = $lang['your_ip_is_banned'];
			}
			else # Fetal Error
			{
				$reg_succ = FALSE;
				$err_array[] = "Account Creation [FATAL ERROR]: User cannot be created, likely due to incorrect database configuration.  Contact the administrator.";
			}
		}
		else
		{
			$reg_succ = FALSE;
		}
		  
		// If there were any errors, then they are outputed here
		if($reg_succ == FALSE) 
		{
			if(!$err_array[0]) 
			{
				$err_array[0] = "Unknown Reason";
			}
			$output_error = $lang['register_failed'];
			$output_error .= "<ul><li>";
			$output_error .= implode("</li><li>", $err_array);
			$output_error .= "</li></ul>";
			output_message('error', $output_error.'Redirecting...<meta http-equiv=refresh content="8;url=?p=account&sub=register">');
		}
		else # Registration was successful
		{
			if((int)$mwe_config['require_act_activation'] == 1)
			{
				output_message('success', $lang['activation_email_sent']);
			}
			else
			{
				output_message('success', $lang['register_success'].'<meta http-equiv=refresh content="5;url=?p=account&sub=login">');
			}
		}
	}
	else
	{
		return FALSE;
	}
}
?>
