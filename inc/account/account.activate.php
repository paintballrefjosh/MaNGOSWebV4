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
$pathway_info[] = array('title' => $lang['activation'], 'link' => '');
// ==================== //

if(isset($_POST['key']) && isset($_POST['user']))
{
	$sub_id = $RDB->selectCell("SELECT `id` FROM `account` WHERE `username` LIKE '".$_POST['user']."'");
	if($sub_id != FALSE)
	{
		redirect("?p=account&sub=activate&id=".$sub_id."&key=".$_POST['key']."", 1);
	}
	else
	{
		output_message('error', 'Invalid username');
	}
}

function CheckKey()
{
	global $user, $DB, $RDB, $Account;
	if(isset($_GET['key']))
	{
		if(isset($_GET['id']))
		{
			$lock = $RDB->selectCell("SELECT `locked` FROM account WHERE id='".$_GET['id']."'");
			if($user['id'] > 0 && $lock == 0)
			{
				output_message('info', 'Your account is already active!');
			}
			else
			{
				$check_key = $Account->isValidActivationKey($_GET['key']);
				if($check_key != FALSE)
				{
					if($_GET['id'] == $check_key)
					{
						$RDB->query("UPDATE account SET locked=0 WHERE id='".$_GET['id']."' LIMIT 1");
						$DB->query("UPDATE mw_account_extend SET activation_code=NULL WHERE account_id='".$_GET['id']."' LIMIT 1");
						output_message('success', '<b>Account successfully activated! You may now log into the server and play.</b>');
						redirect("?p=account&sub=login", 0, 2);
					}
					else
					{
						output_message('error', 'This Activation Key does not belong to this account id!');
					}
				}
				else
				{
					output_message('error', 'Not a valid activation key.');
				}
			}
		}
	}
}

?>
